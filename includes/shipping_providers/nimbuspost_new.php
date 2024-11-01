<?php
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;

/**
 * The nimbuspost-specific functionality of the plugin.
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/nimbuspost
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
class Bt_Sync_Shipment_Tracking_Nimbuspost_New {

    private const COURIERS_JSON = '{"37":"Amazon Logistics 1 KG", "52":"Amazon Logistics 2 KG", "53":"Amazon Logistics 5 KG", "5":"Bluedart Express", "1":"Delhivery Air", "6":"Delhivery Surface", "13":"Delhivery Surface 10 K.G", "7":"Delhivery Surface 2 K.G", "35":"Delhivery Surface 20 K.G", "11":"Delhivery Surface 5 K.G", "8":"DTDC Air", "9":"DTDC Surface", "30":"DTDC Surface 1 K.G", "31":"DTDC Surface 10 K.G", "29":"DTDC Surface 5 K.G", "10":"Ecom EXP", "26":"Ecom ROS", "15":"Ekart", "25":"Ekart 1 K.G", "27":"Ekart 2 K.G", "28":"Ekart 5 K.G", "55":"Gati 10 K.G", "56":"Gati 20 K.G", "36":"Gati 5 K.G", "4":"Shadowfax", "32":"Shadowfax 1 K.G", "33":"Shadowfax 2 K.G", "34":"Shadowfax 5 K.G", "44":"Udaan", "50":"Udaan 1 KG", "51":"Udaan 2 KG", "42":"Xpressbees 1 K.G", "45":"Xpressbees 2 K.G", "46":"Xpressbees 5 K.G", "3":"Xpressbees Air", "14":"Xpressbees Surface"}';

    private const API_BASE_URL = "https://ship.nimbuspost.com";
    private const API_TRACK_BY_AWB_NO = "/api/shipments/track_awb/";
    private const API_TRACK_BY_ORDER_ID = "/api/orders/";
    private const API_GET_ALL_SHIPMENTS = "/api/shipments";
    private $auth_token;
    private $api_key;

    private $webhook_secretkey;
    private $email;
    private $password;

	public function __construct() {
    }

    function init_params() {
        $email=carbon_get_theme_option( 'bt_sst_nimbuspost_new_webhook_api_user_email' );
		$password=carbon_get_theme_option( 'bt_sst_nimbuspost_new_user_password' );

        $this->email=trim($email);
        $this->password=trim($password);

    }

    public function nimbuspost_webhook_receiver($request){

        update_option( "nimbuspost_new_webhook_called", time() );

        //error_log(print_r($request,true));

        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        if(is_array($enabled_shipping_providers) && (in_array('nimbuspost',$enabled_shipping_providers) || in_array('nimbuspost_new',$enabled_shipping_providers))){

            $order_ids=array();

            if(isset($request["order_number"]) && !empty($request["order_number"])){
                //Nimbuspost order number is same as woo order id
                $order_ids[]=$request["order_number"];
            }else if(isset($request["awb_number"])){
                $awb = $request["awb_number"];
                //get orders matching awb and provider= Nimbuspost from db
                $order_ids = Bt_Sync_Shipment_Tracking_Shipment_Model::get_orders_by_awb_number($awb);
                
            }else{
                return "Thanks Nimbuspost, nothing to do";
            }

            

            
            if(!is_array($order_ids)){
                $order_ids=array();
            }

            $courier_name = 'NA';
            $edd_old = '';
            if(empty($order_ids)) {
                return "Thanks Nimbuspost, but order not found.";
            } else {
                $bt_shipment_tracking_old = Bt_Sync_Shipment_Tracking_Shipment_Model::get_tracking_by_order_id($order_ids[0]);
                //$courier_name = $bt_shipment_tracking_old->courier_name;
                $edd_old = $bt_shipment_tracking_old->etd;
            }
            $results=array();
            foreach ($order_ids as $order_id) {
                if(!empty($order_id)){
                    if(false !== $order = wc_get_order( $order_id )){
    
                        $bt_sst_order_statuses_to_sync = carbon_get_theme_option( 'bt_sst_order_statuses_to_sync' );
                        $bt_sst_sync_orders_date = carbon_get_theme_option( 'bt_sst_sync_orders_date' );
    
                        $order_status = 'wc-' . $order->get_status();
    
                        if(in_array($order_status,$bt_sst_order_statuses_to_sync)|| in_array('any',$bt_sst_order_statuses_to_sync)){
    
                            $date_created_dt = $order->get_date_created(); // Get order date created WC_DateTime Object
                            $timezone        = $date_created_dt->getTimezone(); // Get the timezone
                            $date_created_ts = $date_created_dt->getTimestamp(); // Get the timestamp in seconds
    
                            $now_dt = new WC_DateTime(); // Get current WC_DateTime object instance
                            $now_dt->setTimezone( $timezone ); // Set the same time zone
                            $now_ts = $now_dt->getTimestamp(); // Get the current timestamp in seconds
    
                            $allowed_seconds = $bt_sst_sync_orders_date * 24 * 60 * 60; // bt_sst_sync_orders_date in seconds
    
                            $diff_in_seconds = $now_ts - $date_created_ts; // Get the difference (in seconds)
    
                            //if ( $diff_in_seconds <= $allowed_seconds ) {
                                $data = $request->get_json_params();
                                $data['edd_old'] = $edd_old;
                                $shipment_obj = $this->init_model($data,$order_id);
                                $this->save_order_shipment_data($order_id, $shipment_obj);
                                $results[] = array( $order_id=>"Thanks Nimbuspost! Record updated.");
                            //}else{
                                //$results[] = array( $order_id=>"Thanks Nimbuspost! Order too old.");                                
                            //}
                        }else{
                            $results[] = array( $order_id=>"Thanks Nimbuspost! Order status out of scope.");  
                        }
                    }
                }
            }
            
        }

        return $results;
    }
    public function save_order_shipment_data($order_id, $shipment_obj){
        Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);
    }
    public function init_model($data, $order_id){

        $obj = new Bt_Sync_Shipment_Tracking_Shipment_Model();

        //from webhook receiver
        $obj->shipping_provider = "nimbuspost_new";
        $obj->order_id = $order_id;
        $obj->awb = sanitize_text_field($data["awb_number"]);
        $obj->courier_name = sanitize_text_field($data["courier_name"]);
        $obj->etd =  sanitize_text_field($data["edd"]);

        if(empty($obj->scans)){
            $obj->scans = array();
        }

        if(isset($data['history'])) {
            $obj->scans = $data['history'];
        } else {
            $obj->scans[] = array("status" => sanitize_text_field($data["status"]),
                "location" => sanitize_text_field($data["message"]),
                "message" => sanitize_text_field($data["message"]),
                "rto_awb" => sanitize_text_field($data["rto_awb"]));
        }
        $obj->current_status = sanitize_text_field($data["status"]);
        if (strtolower($obj->current_status) == "delivered" && empty($obj->delivery_date)) {
            $obj->delivery_date = date('Y-m-d');
        }        
        
        return $obj;
    }
    public function test_nimbuspost(){
       $this->init_params();
       
       $token = $this->get_token();

       if(empty($token))
       {
        return false;
       }
       else{
        return true;
       }
       
    

       
        


    }

    function generate_token(){

        if(empty($this->email) || empty($this->password)){
            return null;
        }

        $body = array(
            'email'    => $this->email,
            'password'   => $this->password,
        );
        $body = json_encode($body);
        $args = array(
            'body'        => $body,
            'headers'     => array(
                "Content-Type"=> "application/json"
              ),
        );

        $response = wp_remote_post( "https://api.nimbuspost.com/v1/users/login", $args );

        $body = wp_remote_retrieve_body( $response );

        $body = json_decode($body,true);

        return isset($body ["data"])?$body ["data"]:"";

    }

    function get_token(){

        if(empty($this->auth_token)){
            $this->auth_token = $this->generate_token();
        }

        return $this->auth_token;
    }

    public function push_order_to_nimbuspost($order_id){
        $this->init_params();
        $auth_token = $this->get_token();
        //$auth_token ="akjkjb";
        
        if(!empty($auth_token)){

            if(false == $body = $this->get_nimbuspost_order_object($order_id)){
                
                return;
            }
            //echo json_encode($body );exit;
            $postData = json_encode($body);
             $args = array(
                 'headers'     => array(
                    'Authorization' => 'Bearer '.$auth_token,
                     'Content-Type' => 'application/json' 
                 ),
                  'body' =>$postData
             );
             //echo json_encode($args);exit;
    
            $response = wp_remote_post( 'https://api.nimbuspost.com/v1/shipments', $args );
          // $response = wp_remote_post( "https://eo650r7ymufcxnv.m.pipedream.net", $args );
            //https://eo650r7ymufcxnv.m.pipedream.net
            //echo json_encode($response);exit;
            $body     = wp_remote_retrieve_body( $response );
            //echo $response;exit;
            $resp = json_decode($body,true);
            //echo json_encode($resp);exit;
            return $resp;

        }else{
            return null;
        }
	}

    public function get_nimbuspost_order_object($order_id){
        if(false == $order = wc_get_order( $order_id )){
            return false;
        }
        $warehouse_name=carbon_get_theme_option( 'bt_sst_nimbuspost_warehouse_name' );
        $name=carbon_get_theme_option( 'bt_sst_nimpuspost_name' );
        $address=carbon_get_theme_option( 'bt_sst_nimpuspost_address_line_1' );
        $address_2=carbon_get_theme_option( 'bt_sst_nimpuspost_address_line_2' );
        $city=carbon_get_theme_option( 'bt_sst_nimpuspost_city' );
        $state=carbon_get_theme_option( 'bt_sst_nimpuspost_state' );
        $pincode=carbon_get_theme_option( 'bt_sst_nimpuspost_pincode' );
        $phone=$this->extractPhoneNumber(carbon_get_theme_option( 'bt_sst_nimpuspost_phone' ));

        $destination_postcode = $order->get_shipping_postcode();
        $get_shipping_first_name = $order->get_shipping_first_name();
        $get_shipping_last_name = $order->get_shipping_last_name();
        $get_shipping_address_1 = $order->get_shipping_address_1();
        $get_shipping_address_2 = $order->get_shipping_address_2();
        $get_shipping_city = $order->get_shipping_city();
        $get_shipping_state = $order->get_shipping_state();
        if(!$destination_postcode){
            $destination_postcode = $order->get_billing_postcode();
            $get_shipping_first_name = $order->get_billing_first_name();
            $get_shipping_last_name = $order->get_billing_last_name();
            $get_shipping_address_1 = $order->get_billing_address_1();
            $get_shipping_address_2 = $order->get_billing_address_2();
            $get_shipping_city = $order->get_billing_city();
            $get_shipping_state = $order->get_billing_state();
        }
        $consignee=array(
            "name"=> $get_shipping_first_name . ' ' . $get_shipping_last_name,
            "address"=> $get_shipping_address_1,
            "address_2"=> $get_shipping_address_2,
            "city"=> $get_shipping_city,
            "state"=> $get_shipping_state,
            "pincode"=> $destination_postcode,
            "phone"=>  $this->extractPhoneNumber($order->get_billing_phone()),
        );

        $pickup=array(
            "warehouse_name"=> $warehouse_name,
            "name"=> $name,
            "address"=> $address,
            "address_2"=> $address_2,
            "city"=> $city,
            "state"=> $state,
            "pincode"=> $pincode,
            "phone"=> $phone,


        );
      

        $so = array(
            "order_number"=> $order->get_id(),
            "shipping_charges"=> $order->get_total_shipping(),
            "payment_type"=> $order->get_payment_method()=="cod"?"cod":"prepaid",
            "discount"=> $order->get_total_discount(),
            "cod_charges"=> $order->get_total_fees(),
            "order_amount"=> $order->get_total(),
            "package_length"=> "",
            "package_breadth"=> "",
            "package_height"=> "",
            "package_weight"=> "",
            "consignee"=>$consignee,
            "pickup"=>$pickup, 
            "order_items"=> array(),
            "auto_ship" => "no"
            //"courier_id" => 0
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
                    "qty"=> $a->get_quantity(),
                    "price"=>  $order->get_item_subtotal( $a, true, true ),
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
        $total_weight_g = $total_weight->toUnit('g');
        if($total_weight_g<100){
            $total_weight_g=100;
        }
        
        $total_length = new Length($total_length, $dimension_unit);
        $total_length_cm = $total_length->toUnit('cm');

        $total_width = new Length($total_width, $dimension_unit);
        $total_width_cm = $total_width->toUnit('cm');

        $total_height = new Length($total_height, $dimension_unit);
        $total_height_cm = $total_height->toUnit('cm');
        
        $so["package_length"] = $total_length_cm>0?$total_length_cm:0.5;
        $so["package_breadth"] = $total_width_cm>0?$total_width_cm:0.5;
        $so["package_height"] = $total_height_cm>0?$total_height_cm:0.5;
        $so["package_weight"] = $total_weight_kg>0?$total_weight_g:100;
        

        //echo json_encode($so);exit;

        return $so;
    }
    private function extractPhoneNumber( $billing_phone) {
        // Remove all characters except digits from the input string
        $digitsOnly = preg_replace('/\D/', '', $billing_phone);
        
        // If the resulting string has more than 10 digits, take the last 10 digits
        if (strlen($digitsOnly) > 10) {
            $phoneNumber = substr($digitsOnly, -10);
        } else {
            // If the resulting string has less than 10 digits, pad with zeros to make it 10 digits
            $phoneNumber = str_pad($digitsOnly, 10, '0', STR_PAD_LEFT);
        }
        
        return $phoneNumber;
    }

    public function update_order_shipment_status($order_id){
        $resp=null;
        if(!empty($awb_number = Bt_Sync_Shipment_Tracking_Shipment_Model::get_awb_by_order_id($order_id))){
            $resp= $this->get_order_tracking_by_awb_number($awb_number);
        } 

        if($resp!=null && $resp["status"] == true && $resp["data"] != null){
            $shipment_obj = $this->init_model($resp["data"], $order_id);
            Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);                           
            return $shipment_obj;
        }

        return null;
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

            $response = wp_remote_get( "https://api.nimbuspost.com/v1/shipments/track/". $awb_number,$args );
            $body     = wp_remote_retrieve_body( $response );
            $resp = json_decode($body,true);
            return $resp;

        }else{
            return null;
        }
    }

    public function get_rate_calcultor($pickup_pincode,$delivery_pincode,$payment_type,$order_amount,$weight,$length,$width,$height){
        $this->init_params();
        $auth_token = $this->get_token();
        //$auth_token ="akjkjb";
        
        if(!empty($auth_token)){

            

            $body = array(
                'origin'=>$pickup_pincode,
                'destination'=>$delivery_pincode,
                'payment_type'=>$payment_type,
                'order_amount'=>$order_amount,
                'weight'=>$weight,
                'length'=>$length,
                'breadth'=>$width,
                'height'=>$height
                
           
            );

             $postData = json_encode($body);
             $args = array(
                 'headers'     => array(
                     'Authorization' => 'Bearer '.$auth_token,
                     'Content-Type' => 'application/json'
                 ),
                  'body' =>$postData
             );

             $response = wp_remote_post( 'https://api.nimbuspost.com/v1/courier/serviceability', $args);
           
             $body     = wp_remote_retrieve_body( $response );

             $resp = json_decode($body,true);
             //print_r($args);
             //echo json_encode($response);exit;
             //echo($body);
            // exit;
            return $resp;
        }else{
            return null;
        }
    }

    public function get_order_label_by_order_ids($awbs) {
        $this->init_params();
        $auth_token = $this->get_token();
        
        if (!empty($auth_token)) {
            $body = array(
                'awbs' => $awbs
            );
    
            $postData = json_encode($body);
            $args = array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $auth_token, // Bearer token for authorization
                    'Content-Type' => 'application/json'
                ),
                'body' => $postData
            );
    
            // Make the API call to create shipment manifest
            $response = wp_remote_post('https://api.nimbuspost.com/v1/shipments/manifest', $args);
            $body = wp_remote_retrieve_body($response);
    
            // Decode the JSON response into an associative array
            $resp = json_decode($body, true);
            $resp = array($resp['data']);
            // echo "<pre>"; print_r($resp);
            return $resp;
        } else {
            return null;
        }
    }
}
