<?php
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
/**
 * The shiprocket-specific functionality of the plugin.
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/shiprocket
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
class Bt_Sync_Shipment_Tracking_Shiprocket {

    //used tool: https://csvjson.com/csv2json
    private const COURIERS_JSON = '{"4":"Amazon Shipping 5Kg","6":"DTDC Surface","10":"Delhivery","14":"Ecom Express Surface 500gms","18":"DTDC 5kg","19":"Ecom Express Surface 2kg","23":"Xpressbees 1kg","24":"Xpressbees 2kg","25":"Xpressbees 5kg","29":"Amazon Shipping 1Kg","32":"Amazon Shipping 2Kg","35":"Aramex International","39":"Delhivery Surface 5 Kgs","43":"Delhivery Surface","44":"Delhivery Surface 2 Kgs","45":"Ecom Express Reverse","46":"Shadowfax Reverse","51":"Xpressbees Surface","54":"Ekart Logistics Surface","58":"Shadowfax Surface","60":"Ecom Express Air 500gms","61":"Delhivery Reverse","69":"Kerry Indev Express Surface","82":"DTDC 2kg","95":"Shadowfax Local","97":"Dunzo Local","99":"Ecom Express ROS Reverse","100":"Delhivery Surface 10 Kgs","101":"Delhivery Surface 20 Kgs","106":"Borzo","107":"Borzo 5 Kg","125":"Xpressbees Reverse","137":"Delhivery Reverse 2kg","140":"Shiprocket International","id":"name"}';

    private const API_BASE_URL = "https://apiv2.shiprocket.in";
    private const API_GET_LOCALITY = "/v1/external/open/postcode/details?postcode=";
    private const API_TRACK_BY_ORDER_ID = "/v1/external/orders?search=";
    private const API_TRACK_BY_AWB_NUMBER = "/v1/external/courier/track/awb/";
    private const API_Check_Courier_Serviceability = "/v1/external/courier/serviceability/";
    private const API_Check_Courier_Serviceability_International = "/v1/external/international/courier/serviceability";
    private const API_COURIER_COMPANIES_NAME = "/v1/external/courier/courierListWithCounts?type=active";

    private $auth_token;

    private $username;
    private $password;
    private $channel_id;

	public function __construct() {
    }

    function init_params() {
        $username=get_option( '_bt_sst_shiprocket_apiusername' );
		$password=get_option( '_bt_sst_shiprocket_apipassword' );
		$channel_id=get_option( '_bt_sst_shiprocket_channelid' );

        $this->username=trim($username);
        $this->password=trim($password);
        $this->channel_id=trim($channel_id);
    }

    public function get_locality($postcode){
        $this->init_params();
        $auth_token = $this->get_token();

        if(!empty($auth_token)){

            $args = array(
                'headers'     => array(
                    'Authorization' => 'Bearer ' . $auth_token,
                ),
            );

            $response = wp_remote_get( self::API_BASE_URL . self::API_GET_LOCALITY . $postcode, $args );
           
            $body     = wp_remote_retrieve_body( $response );

            $resp = json_decode($body,true);
            // echo json_encode($resp);
            // exit;
            
            if($resp["success"]){
                $data = array(
                    "postcode"=>$resp["postcode_details"]["postcode"],
                    "city"=>$resp["postcode_details"]["city"],
                    "state"=>$resp["postcode_details"]["state"],
                    "state_code"=>$resp["postcode_details"]["state_code"],
                    "country"=>$resp["postcode_details"]["country"],
                );
                // echo $data;
                // exit;
                return $data;
            }

        }else{
            return null;
        }


    }

    public function get_courier_serviceability($pickup_postcode,$delivery_postcode,$is_cod,$weight_in_kg,$length_in_cms=null,$breadth_in_cms=null,$height_in_cms=null,$declared_value=null){
        $this->init_params();
        $auth_token = $this->get_token();

        if(!empty($auth_token)){

            $args = array(
                'headers'     => array(
                    'Authorization' => 'Bearer ' . $auth_token,
                ),
            );
            if(!$weight_in_kg){
                $weight_in_kg=0.1;
            }

            $params = "?pickup_postcode=" . $pickup_postcode . "&delivery_postcode=".$delivery_postcode;
            $params .= "&cod=" . $is_cod . "&weight=" . $weight_in_kg;
            if($declared_value){
                $params .= '&declared_value='.$declared_value;
            }
            if($length_in_cms){
                $params .= '&length='.$length_in_cms;
            }
            if($breadth_in_cms){
                $params .= '&breadth='.$breadth_in_cms;
            }
            if($height_in_cms){
                $params .= '&height='.$height_in_cms;
            }
            //echo $params;exit;
            $response = wp_remote_get( self::API_BASE_URL . self::API_Check_Courier_Serviceability . $params, $args );

            $body     = wp_remote_retrieve_body( $response );

            $resp = json_decode($body,true);

             //echo json_encode($resp);
             //exit;

            if(isset($resp["status"]) && $resp["status"] == 200){
                // echo json_encode($resp['data']['available_courier_companies']);
                // exit;
                $resp = $resp['data']['available_courier_companies'];
                return $resp;
            }else {
                return [];
            }
        }else{
            return [];
        }
    }

    public function get_courier_serviceability_international($delivery_country,$weight_in_kg,$pickup_pincode){
        $this->init_params();
        $auth_token = $this->get_token();

        $is_cod = 0;//COD is not available for international couriers

        if(!empty($auth_token)){

            $args = array(
                'headers'     => array(
                    'Authorization' => 'Bearer ' . $auth_token,
                ),
            );
            if(!$weight_in_kg){
                $weight_in_kg=1;
            }
            $weight_in_kg = ceil($weight_in_kg);

            $params = "?delivery_country=" . $delivery_country;
            $params .= "&cod=" . $is_cod . "&weight=" . $weight_in_kg . '&pickup_postcode='.$pickup_pincode;
          
            //echo $params;exit;
            $response = wp_remote_get( self::API_BASE_URL . self::API_Check_Courier_Serviceability_International . $params, $args );

            $body     = wp_remote_retrieve_body( $response );

            $resp = json_decode($body,true);

             //echo json_encode($resp);
             //exit;

            if(isset($resp["status"]) && $resp["status"] == 200){
                // echo json_encode($resp['data']['available_courier_companies']);
                // exit;
                $resp = $resp['data']['available_courier_companies'];
                return $resp;
            }else {
                return [];
            }
        }else{
            return [];
        }
    }

    public function get_courier_companies_name(){
        
        if ( false === ( $bt_sst_shiprocket_courier_companies = get_transient( 'bt_sst_shiprocket_courier_companies' ) ) ) {
            $this->init_params();
            $auth_token = $this->get_token();
    
            if(!empty($auth_token)){
    
                $args = array(
                    'headers'     => array(
                        'Authorization' => 'Bearer ' . $auth_token,
                    ),
                );
    
                $params = '?type=active';
                $response = wp_remote_get( self::API_BASE_URL . self::API_COURIER_COMPANIES_NAME . $params, $args );
    
                $body     = wp_remote_retrieve_body( $response );
    
                $resp = json_decode($body,true);
    
                // echo json_encode($resp);
                // exit;
                //error_log("4. ". json_encode($resp));
                if(isset($resp["total_courier_count"]) && $resp["total_courier_count"] > 0){
                    $resp = $resp['courier_data'];
                    set_transient('bt_sst_shiprocket_courier_companies',$resp, 6000);
                    return $resp;
                }else {
                    return [];
                }
            }else{
                return [];
            }
        }else{
            return $bt_sst_shiprocket_courier_companies ;
        }
        
    }

    public function test_connection(){
        $this->init_params();
        if(empty($this->username) || empty($this->password)){
            return null;
        }

        $body = array(
            'email'    => $this->username,
            'password'   => $this->password,
        );
        $body = json_encode($body);
        $args = array(
            'body'        => $body,
            'headers'     => array(
                "Content-Type: application/json"
            ),
        );

        $response = wp_remote_post( "https://apiv2.shiprocket.in/v1/external/auth/login", $args );

        $body = wp_remote_retrieve_body( $response );
        //error_log("4. ". json_encode($body));

        $body = json_decode($body,true);
        return  $body;

    }

    function generate_token(){

        if(empty($this->username) || empty($this->password)){
            return null;
        }

        $body = array(
            'email'    => $this->username,
            'password'   => $this->password,
        );
        $body = json_encode($body);
        $args = array(
            'body'        => $body,
            'headers'     => array(
                "Content-Type: application/json"
              ),
        );

        $response = wp_remote_post( "https://apiv2.shiprocket.in/v1/external/auth/login", $args );

        $body = wp_remote_retrieve_body( $response );
        //error_log("4. ". json_encode($body));

        $body = json_decode($body,true);

        return isset($body ["token"])?$body ["token"]:"";

    }

    function get_token(){
        if(empty($this->auth_token)){
            if ( false === ( $bt_sst_shiprocket_auth_token = get_transient( 'bt_sst_shiprocket_auth_token' ) ) ) {
                $this->auth_token = $this->generate_token();
                if(!empty($this->auth_token )){
                    set_transient('bt_sst_shiprocket_auth_token',$this->auth_token , 600);
                }
               
            }else{
                $this->auth_token = $bt_sst_shiprocket_auth_token ;
            }
            
        }
        //error_log("3. ". json_encode($this->auth_token));
        //$this->print_call_stack();
        return $this->auth_token;
    }

    function print_call_stack() {
        $callStack = debug_backtrace();
        error_log("5. ". json_encode($callStack));
        
    }
    
    

    public function shiprocket_webhook_receiver($request){

        update_option( "shiprocket_webhook_called", time() );
        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        if(is_array($enabled_shipping_providers) && in_array('shiprocket',$enabled_shipping_providers)){
            $order_ids=array();
            if(isset($request["order_id"]) && !empty($request["order_id"])){
                $order_ids[]=$request["order_id"];
            }
            if(isset($request["awb"]) && !empty($request["awb"])){
                $awb_number = $request["awb"];
                if(!empty($awb_order_ids = Bt_Sync_Shipment_Tracking_Shipment_Model::get_orders_by_awb_number($awb_number))){
                    foreach ($awb_order_ids as $awb_order_id) {
                        if(!in_array($awb_order_id,$order_ids)){
                            $order_ids[] = $awb_order_id;
                        }
                    }                    
                }
            }

            if(!empty($order_ids) && is_array($order_ids)){
                foreach ($order_ids as $order_id) {
                    if(!empty($order_id)){
                        if(false !== $order = wc_get_order( $order_id )){
        
                            $bt_sst_order_statuses_to_sync = carbon_get_theme_option( 'bt_sst_order_statuses_to_sync' );
                            $bt_sst_sync_orders_date = carbon_get_theme_option( 'bt_sst_sync_orders_date' );
        
                            $order_status = 'wc-' . $order->get_status();
        
                            if(in_array($order_status,$bt_sst_order_statuses_to_sync) || in_array('any',$bt_sst_order_statuses_to_sync)){
        
                                $date_created_dt = $order->get_date_created(); // Get order date created WC_DateTime Object
                                $timezone        = $date_created_dt->getTimezone(); // Get the timezone
                                $date_created_ts = $date_created_dt->getTimestamp(); // Get the timestamp in seconds
        
                                $now_dt = new WC_DateTime(); // Get current WC_DateTime object instance
                                $now_dt->setTimezone( $timezone ); // Set the same time zone
                                $now_ts = $now_dt->getTimestamp(); // Get the current timestamp in seconds
        
                                $allowed_seconds = $bt_sst_sync_orders_date * 24 * 60 * 60; // bt_sst_sync_orders_date in seconds
        
                                $diff_in_seconds = $now_ts - $date_created_ts; // Get the difference (in seconds)
        
                                if ( $diff_in_seconds <= $allowed_seconds ) {
                                    $shipment_obj = $this->init_model($request, $order_id);
                                    Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);                           
                                    return "Thanks Shiprocket! Record updated.";
                                }else{
                                    return "Thanks Shiprocket! Order too old.";
                                }
                            }else{
                                return "Thanks Shiprocket! Order status out of scope.";
                            }
                        }
                    }
                }                    
            }

            
        }

        // ob_start();
        // var_dump($request);
        // $result = ob_get_clean();

        // error_log($result);

        return "Thanks Shiprocket!";
    }

    public function get_order_tracking($order_id){
        $this->init_params();
        $auth_token = $this->get_token();       
        if(!empty($auth_token)){

            $args = array(
                'headers'     => array(
                    'Authorization' => 'Bearer ' . $auth_token,
                ),
            );

            $response = wp_remote_get( self::API_BASE_URL . self::API_TRACK_BY_ORDER_ID . $order_id,$args );

            $body     = wp_remote_retrieve_body( $response );

            $resp = json_decode($body,true);


            return $resp;

        }else{
            return null;
        }
    }

    public function get_order_tracking_by_awb_number($awb_number){
        $this->init_params();
        $auth_token = $this->get_token();

        if(!empty($auth_token)){

            $args = array(
                'headers'     => array(
                    'Authorization' => 'Bearer ' . $auth_token,
                ),
            );

            $response = wp_remote_get( self::API_BASE_URL . self::API_TRACK_BY_AWB_NUMBER . $awb_number,$args );
            $body     = wp_remote_retrieve_body( $response );
            //error_log("5. ". json_encode($body));
            $resp = json_decode($body,true);
            return $resp;

        }else{
            return null;
        }
    }

    public function get_courier_by_id($id){
        $couriers = json_decode(self::COURIERS_JSON,true);
        return isset($couriers[$id])?$couriers[$id]:"NA";
    }

    public function init_model($data, $order_id){

        $obj = new Bt_Sync_Shipment_Tracking_Shipment_Model();     

        if(isset($data["tracking_data"])){
            //from the api call
            if($data["tracking_data"]["track_status"] !=0){
                $obj->shipping_provider = 'shiprocket';
                $obj->order_id = $order_id;
                $obj->awb = sanitize_text_field($data["tracking_data"]["shipment_track"][0]["awb_code"]);
                $obj->courier_name = $this->get_courier_by_id(sanitize_text_field($data["tracking_data"]["shipment_track"][0]["courier_company_id"]));
                $obj->etd = sanitize_text_field($data["tracking_data"]["shipment_track"][0]["edd"]);
                $obj->etd = !empty($obj->etd)?$obj->etd:sanitize_text_field($data["tracking_data"]["shipment_track"][0]["delivered_date"]);
                $obj->scans = $data["tracking_data"]["shipment_track_activities"];
                $obj->current_status = sanitize_text_field($data["tracking_data"]["shipment_track"][0]["current_status"]);
            }else{
                $bt_shipment_tracking_old = Bt_Sync_Shipment_Tracking_Shipment_Model::get_tracking_by_order_id($order_id);
                $obj->shipping_provider = 'shiprocket';
                $obj->order_id = $order_id;
                $obj->current_status = 'unknown';
                $obj->awb = $bt_shipment_tracking_old->awb;
               }
            
        } else if(isset($data["data"]) && !empty($data["data"][0])){
            //order search data            
            if($data["data"][0]["channel_order_id"]==$order_id){
                $shipment = !empty($data["data"][0]["shipments"][0])?$data["data"][0]["shipments"][0]:null;

                $obj->shipping_provider = 'shiprocket';
                $obj->order_id = $order_id;
                $obj->awb = sanitize_text_field(!empty($shipment)?$shipment["awb"]:"");
                $obj->courier_name = sanitize_text_field(!empty($shipment)?$shipment["courier"]:"");
                $obj->etd = sanitize_text_field(!empty($shipment)?$shipment["etd"]:"");
                $obj->etd = !empty($obj->etd)?$obj->etd:sanitize_text_field(!empty($shipment)?$shipment["delivered_date"]:"");
                $obj->scans = [];
                $obj->current_status = sanitize_text_field(!empty($data["data"][0]["status"])?$data["data"][0]["status"]:"");
            }
        }
        else if(isset($data["awb"])){
            //from webhook receiver
            $obj->shipping_provider = 'shiprocket';
            $obj->awb = sanitize_text_field($data["awb"]);
            $obj->courier_name = sanitize_text_field($data["courier_name"]);
            $obj->etd = sanitize_text_field($data["etd"]);
            $obj->scans = $data["scans"];
            $obj->current_status = sanitize_text_field($data["current_status"]);
        }else{
            $obj=null;
        }

        if (is_array($data) && sizeof($data) > 0 && strtolower($obj->current_status) == "delivered" && empty($obj->delivery_date)) {
            $obj->delivery_date = date('Y-m-d');
        }        
        


        return $obj;
    }

    public function update_order_shipment_status($order_id){
        $resp=null;
        if(!empty($awb_number = Bt_Sync_Shipment_Tracking_Shipment_Model::get_awb_by_order_id($order_id))){
            $resp= $this->get_order_tracking_by_awb_number($awb_number);
            //error_log("1. ". json_encode($resp));
        } 
        
        if($resp==null || !isset($resp["tracking_data"]) || $resp["tracking_data"]["track_status"]==0) {
            $resp = $this->get_order_tracking($order_id);     
            //error_log("2. ". json_encode($resp));       
        }

		if(!empty($resp)){
			$shipment_obj = $this->init_model($resp, $order_id);
            Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);          
			return $shipment_obj;
        }
        return null;
    }

    public function push_order_to_shiprocket($order_id){
        $order = wc_get_order( $order_id );
        if ( $order && $order->get_meta('has_sub_order') != 1 ) {
            $this->init_params();
            $auth_token = $this->get_token();
            //$auth_token ="akjkjb";
            if(!empty($auth_token)){
    
                if(false == $body = $this->get_shiprocket_order_object($order_id)){
                    return;
                }
                // echo "<pre>"; print_r($body); die;
    
                //$body = json_encode($body);
                //echo json_encode($body );exit;
                $args = array(
                    'body'        => $body,
                    'headers'     => array(
                        'Authorization' => 'Bearer ' . $auth_token,
                        "Content-Type: application/json"
                      ),
                );
        
                $response = wp_remote_post( "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc", $args );
              // $response = wp_remote_post( "https://eo650r7ymufcxnv.m.pipedream.net", $args );
                //https://eo650r7ymufcxnv.m.pipedream.net
              
                $body     = wp_remote_retrieve_body( $response );
              //  echo $body;exit;
                $resp = json_decode($body,true);
                return $resp;
    
            }else{
                return null;
            }
        }else{
            return null;
        }
	}
    private function extractPhoneNumber( $billing_phone) {
        $digitsOnly = preg_replace('/\D/', '', $billing_phone);
        
        if (strlen($digitsOnly) > 10) {
            $phoneNumber = substr($digitsOnly, -10);
        } else {
            $phoneNumber = str_pad($digitsOnly, 10, '0', STR_PAD_LEFT);
        }

        return $phoneNumber;
    }
    public function get_shiprocket_order_object($order_id){
        if(false == $order = wc_get_order( $order_id )){
            return false;
        }
        $order = wc_get_order($order_id);
        foreach ($order->get_items() as $item_id => $item) {
            $product_id = $item->get_product_id();
            $vendor_id = get_post_field('post_author', $product_id);
            if ( $vendor_id ) {
                $vendor_pickup_location = get_user_meta( $vendor_id, 'vendor_pickup_location', true );
                if ( !$vendor_pickup_location ) {
                    $vendor_pickup_location = carbon_get_theme_option( 'bt_sst_shiprocket_pickup_location' );
                }
            }
            break;
        }
      
        $phoneNumber = $this->extractPhoneNumber($order->get_billing_phone());
        $warehouseid = carbon_get_theme_option('bt_sst_shipmozo_warehouseid');
        $shipping_postcode = $order->get_shipping_postcode();
        $get_shipping_first_name = $order->get_shipping_first_name();
        $get_shipping_last_name = $order->get_shipping_last_name();
        $get_shipping_address_1 = $order->get_shipping_address_1();
        $get_shipping_address_2 = $order->get_shipping_address_2();
        $get_shipping_city = $order->get_shipping_city();
        $get_shipping_state = $order->get_shipping_state();
        $get_shipping_email = $order->get_billing_email();
        $get_shipping_country = $order->get_shipping_country();
        if(!$shipping_postcode){
            $shipping_postcode = $order->get_billing_postcode();
            $get_shipping_first_name = $order->get_billing_first_name();
            $get_shipping_last_name = $order->get_billing_last_name();
            $get_shipping_address_1 = $order->get_billing_address_1();
            $get_shipping_address_2 = $order->get_billing_address_2();
            $get_shipping_city = $order->get_billing_city();
            $get_shipping_state = $order->get_billing_state();
            $get_shipping_email = $order->get_billing_email();
            $get_shipping_country = $order->get_billing_country();
        }
        $so = array(
            "order_id"=> $order->get_id(),
            "order_date"=> $order->get_date_created()->date("Y-m-d H:i:s"),
            "pickup_location"=> $vendor_pickup_location,
            "channel_id"=> carbon_get_theme_option( 'bt_sst_shiprocket_channelid' ),
            "comment"=> $order->get_customer_note(),
            "billing_customer_name"=> $order->get_billing_first_name(),
            "billing_last_name"=> $order->get_billing_last_name(),
            "billing_address"=> $order->get_billing_address_1(),
            "billing_address_2"=> $order->get_billing_address_2(),
            "billing_city"=> $order->get_billing_city(),
            "billing_pincode"=> $order->get_billing_postcode(),
            "billing_state"=> $order->get_billing_state(),
            "billing_country"=> $order->get_billing_country(),
            "billing_email"=> $order->get_billing_email(),
            "billing_phone"=> $phoneNumber,
            "shipping_is_billing"=> $order->get_billing_address_1() == $get_shipping_address_1 ,//quick fix to check if billing and shipping address are same.
            "shipping_customer_name"=> $get_shipping_first_name,
            "shipping_last_name"=> $get_shipping_last_name,
            "shipping_address"=> $get_shipping_address_1,
            "shipping_address_2"=> $get_shipping_address_2,
            "shipping_city"=> $get_shipping_city,
            "shipping_pincode"=> $shipping_postcode,
            "shipping_country"=> $get_shipping_country,
            "shipping_state"=> $get_shipping_state,
            "shipping_email"=>  $get_shipping_email,
            "shipping_phone"=> $phoneNumber,
            "order_items"=> array(),
            "payment_method"=> $order->get_payment_method()=="cod"?"cod":"prepaid",
            "shipping_charges"=> $order->get_total_shipping(),
            "giftwrap_charges"=> 0,
            "transaction_charges"=> $order->get_total_fees(),
            "total_discount"=> $order->get_total_discount(),
            "sub_total"=> $order->get_subtotal() + $order->get_total_tax(),
            "length"=> 1,
            "breadth"=> 1,
            "height"=> 1,
            "weight"=> 0.1
        );
        $total_weight = 0;
        $total_width = 0;
        $total_length = 0;
        $total_height = 0;
        $sku_count=1;
        $sku_count_map = array();
        foreach ($order->get_items() as $item_id => $a) {
            
            if (is_a($a, 'WC_Order_Item_Product')) {
                $product = $a->get_product();
                $product_sku = $product->get_sku();
                if(empty($product_sku)){
                    $product_sku = urldecode( substr(get_post( $product->get_id() )->post_name,0,40) ) . '_' .  $sku_count;//to make sku unique
                    $sku_count++;
                }
                if(isset($sku_count_map[$product_sku])){
                    $sku_count_map[$product_sku] = $sku_count_map[$product_sku]+1;
                    $product_sku = $product_sku . '_' . $sku_count_map[$product_sku];// to make sku unique when two variations have same sku. reported by Threadly
                }else{
                    $sku_count_map[$product_sku] = 1;
                }
            
                $so["order_items"][] =array(
                    "name"=> $a->get_name(),
                    "sku"=>  $product_sku,
                    "units"=> $a->get_quantity(),
                    "selling_price"=>  $order->get_item_subtotal( $a, true, true ),
                    "discount"=> "",
                    "tax"=> "",
                    "hsn"=> ""
                ); 
                if(!empty($product->get_weight()) && $product->get_weight()>0){
                    $total_weight = $total_weight + ($product->get_weight() * $a->get_quantity());
                }
                if(!empty($product->get_width()) && $product->get_width()>0){
                    $total_width = $total_width + ($product->get_width() * $a->get_quantity());
                    if($product->get_length()>$total_length){
                        $total_length =$product->get_length();
                    }
                    if($product->get_height()>$total_height){
                        $total_height =$product->get_height();
                    }
                }
            }
        }
        $weight_unit = get_option('woocommerce_weight_unit');
        $dimension_unit = get_option('woocommerce_dimension_unit');

        $total_weight = new Mass($total_weight,  $weight_unit );
        $total_weight_kg = $total_weight->toUnit('kg');
        
        $total_length = new Length($total_length, $dimension_unit);
        $total_length_cm = $total_length->toUnit('cm');

        $total_width = new Length($total_width, $dimension_unit);
        $total_width_cm = $total_width->toUnit('cm');

        $total_height = new Length($total_height, $dimension_unit);
        $total_height_cm = $total_height->toUnit('cm');
        
        $so["length"] = $total_length_cm>0?$total_length_cm:0.5;
        $so["breadth"] = $total_width_cm>0?$total_width_cm:0.5;
        $so["height"] = $total_height_cm>0?$total_height_cm:0.5;
        $so["weight"] = $total_weight_kg>0?$total_weight_kg:0.1;

        return $so;
    }

    public function book_shipment_courier($shipment_id,$courier_id){
        $this->init_params();
        $auth_token = $this->get_token();
        //$auth_token ="akjkjb";
        if(!empty($auth_token)){

            $body = array(
                "shipment_id"=>$shipment_id,
                "courier_id"=>$courier_id,
            );
           // $body = json_encode($body);
           // echo $body;exit;
            
            $args = array(
                'body'        => $body,
                'headers'     => array(
                    'Authorization' => 'Bearer ' . $auth_token,
                    "Content-Type: application/json"
                  ),
            );
    
            $response = wp_remote_post( "https://apiv2.shiprocket.in/v1/external/courier/assign/awb", $args );
          // $response = wp_remote_post( "https://eo650r7ymufcxnv.m.pipedream.net", $args );
            //https://eo650r7ymufcxnv.m.pipedream.net
          
            $body     = wp_remote_retrieve_body( $response );
          //  echo $body;exit;
            $resp = json_decode($body,true);
            return $resp;

        }else{
            return null;
        }
	}
    public function get_order_label_by_shipment_id($shipment_ids){
        $this->init_params();
        $auth_token = $this->get_token();
        if(!empty($auth_token)){

            $body = array(
                "shipment_id"=>$shipment_ids,
            );
            
            $args = array(
                'body'        => $body,
                'headers'     => array(
                    'Authorization' => 'Bearer ' . $auth_token,
                    "Content-Type: application/json"
                  ),
            );
    
            $response = wp_remote_post( "https://apiv2.shiprocket.in/v1/external/courier/generate/label", $args );
          
            $body     = wp_remote_retrieve_body( $response );
            $resp = json_decode($body,true);
            // echo "<pre>"; print_r($resp); die;
            $resp_array = [];
            if (isset($resp['label_created']) && $resp['label_created'] > 0) {
                // foreach ($resp['packages'] as $package) {
                    // if (isset($package['label_url'])) {
                        $resp_array[] = $resp['label_url'];
                    // }
                // }
                $resp = $resp_array;
            } else {
                $resp = $resp['response'];
            }            

            return $resp;

        }else{
            return "Please Enter Token";
        }
	}

    public function get_all_pickup_locations(){
        $this->init_params();
        $auth_token = $this->get_token();
    
        if (!empty($auth_token)) {
            $args = array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $auth_token,
                ),
            );
    
            // Making the API request
            $response = wp_remote_get("https://apiv2.shiprocket.in/v1/external/settings/company/pickup", $args);
    
            // Get and decode response body
            $body = wp_remote_retrieve_body($response);
            $resp = json_decode($body, true);
            // echo "<pre>"; print_r($resp); die;
            if(is_array($resp['data']['shipping_address']) && isset($resp['data']['shipping_address'])){
                return $resp['data']['shipping_address'];
            }else{
                return "error";
            }
        } else {
            return "Please Enter Token";
        }
    }
    

}
