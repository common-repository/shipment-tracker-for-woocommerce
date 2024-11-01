<?php
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
class Bt_Sync_Shipment_Tracking_Shipmozo {

    private $public_key;
    private $private_key;

    public function __construct() {
    }

    function init_params() {
        $public_key=carbon_get_theme_option( 'bt_sst_shipmozo_apipublickey' );
		$private_key=carbon_get_theme_option( 'bt_sst_shipmozo_apiprivatekey' );

        $this->public_key=trim($public_key);
        $this->private_key=trim($private_key);
    }

    public function test_shipmozo(){
        $this->init_params();
        if(!empty($this->public_key) && !empty($this->private_key)){
            $body= array(
                'pickup_pincode'=>'311001',
                'delivery_pincode'=>'311001'
            );
            $body = json_encode($body);
            $args = array(
                'body' => $body,
                'headers'     => array(
                    'public-key'=> $this->public_key,
                    'private-key'=> $this->private_key
                ),
            );
            $response = wp_remote_post( 'https://shipping-api.com/app/api/v1/pincode-serviceability', $args );
            $body     = wp_remote_retrieve_body( $response );
            $resp = json_decode($body,true);
            // var_dump(strpos($resp["message"], "unauthorised")); die;
            if (isset($resp["message"]) && strpos($resp["message"], "unauthorised") !== false) {
                return false;
            } else {
                return true;
            }
            
        }else{
            return false;
        }
    }

    public function shipmozo_webhook_receiver($request){

        /*
          Sample Webhook data:
          array(11) {
            ["order_id"]=>
            string(10) "4681GY4954"
            ["refrence_id"]=>
            string(4) "4954"
            ["awb_number"]=>
            string(14) "SPOP1000018714"
            ["carrier"]=>
            string(11) "Ekart 0.5KG"
            ["delhivery_name"]=>
            string(11) "Nidhi Watts"
            ["delhivery_phone"]=>
            string(10) "8432157417"
            ["expected_delivery_date"]=>
            NULL
            ["shipment_type"]=>
            string(7) "Forward"
            ["current_status"]=>
            string(16) "Pickup Completed"
            ["status_time"]=>
            string(19) "2024-03-28 09:30:32"
            ["status_feed"]=>
            array(1) {
                ["scan"]=>
                array(7) {
                [0]=>
                array(3) {
                    ["date"]=>
                    string(19) "2024-03-28 09:30:32"
                    ["status"]=>
                    string(24) "shipment pickup complete"
                    ["location"]=>
                    string(6) "Dwarka"
                }
                [1]=>
                array(3) {
                    ["date"]=>
                    string(19) "2024-03-28 06:21:52"
                    ["status"]=>
                    string(23) "shipment out for pickup"
                    ["location"]=>
                    string(6) "Dwarka"
                }
                [2]=>
                array(3) {
                    ["date"]=>
                    string(19) "2024-03-27 14:38:56"
                    ["status"]=>
                    string(7) "NON EKL"
                    ["location"]=>
                    string(6) "Dwarka"
                }
                [3]=>
                array(3) {
                    ["date"]=>
                    string(19) "2024-03-27 06:52:27"
                    ["status"]=>
                    string(21) "Dispatched to JAI/BTS"
                    ["location"]=>
                    string(6) "Jaipur"
                }
                [4]=>
                array(3) {
                    ["date"]=>
                    string(19) "2024-03-27 06:44:56"
                    ["status"]=>
                    string(23) "shipment out for pickup"
                    ["location"]=>
                    string(6) "Dwarka"
                }
                [5]=>
                array(3) {
                    ["date"]=>
                    string(19) "2024-03-27 06:39:00"
                    ["status"]=>
                    string(34) "Dispached by SPO : Priyanka Mittal"
                    ["location"]=>
                    string(6) "Dwarka"
                }
                [6]=>
                array(3) {
                    ["date"]=>
                    string(19) "2024-03-27 06:39:00"
                    ["status"]=>
                    string(25) "Expected at EKL Bamnoli1 "
                    ["location"]=>
                    string(6) "Dwarka"
                }
                }
            }
            }

        */

        update_option( "shipmozo_webhook_called", time() );
        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        if(is_array($enabled_shipping_providers) && in_array('shipmozo',$enabled_shipping_providers)){
            $order_ids=array();
            $shipmozo_order_id = "";
            if(isset($request["refrence_id"]) && !empty($request["refrence_id"])){
                $order_ids[]=$request["refrence_id"];
            }
            if(isset($request["order_id"]) && !empty($request["order_id"])){
                $shipmozo_order_id = $request["order_id"];
            }
            if(isset($request["awb-number"]) && !empty($request["awb_number"])){
                $awb_number = $request["awb_number"];
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
        
                            if(!empty($shipmozo_order_id)){
                                Bt_Sync_Shipment_Tracking::bt_sst_update_order_meta($order_id, '_bt_shipmozo_order_id', $shipmozo_order_id);
                            }
                         
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
                                    return "Thanks Shipmozo! Record updated.";
                                }else{
                                    return "Thanks Shipmozo! Order too old.";
                                }
                            }else{
                                return "Thanks Shipmozo! Order status out of scope.";
                            }
                        }
                    }
                }                    
            }

        // ob_start();
        // var_dump($request);
        // $result = ob_get_clean();

        // error_log($result);

        return "Thanks Shipmozo, but nothing got updated.";
        }
    }


    public function init_model($data, $order_id){
        $obj = new Bt_Sync_Shipment_Tracking_Shipment_Model();
        //from webhook receiver
        $obj->order_id = $order_id;
        $obj->shipping_provider = 'shipmozo';
        $obj->awb = sanitize_text_field($data["awb_number"]);
        if(isset($data["carrier"])){
            $obj->courier_name = sanitize_text_field($data["carrier"]);
        }
        if(isset($data["courier"])){
            $obj->courier_name = sanitize_text_field($data["courier"]);
        }
        
        $obj->current_status = sanitize_text_field($data["current_status"]);
        if (strtolower($obj->current_status) == "delivered" && empty($obj->delivery_date)) {
            $obj->delivery_date = date('Y-m-d');
        }        
        
        $obj->etd = sanitize_text_field($data["expected_delivery_date"]);
       
        if(isset($data["status_feed"])){
            $obj->scans = sanitize_text_field($data["status_feed"]);
        }
        if(isset($data["scan_detail"])){
            $obj->scans = sanitize_text_field($data["scan_detail"]);
        }
        return $obj;

    }
    

    public function get_order_tracking_by_awb_number($awb_number){
        $this->init_params();
       

        if(!empty($this->public_key) && !empty($this->private_key)){

            $args = array(
                'headers'     => array(
                    'public-key'=> $this->public_key,
                    'private-key'=> $this->private_key
                )
            );

           
            $response = wp_remote_get( 'https://shipping-api.com/app/api/v1/track-order?awb_number='.$awb_number, $args);
           
            $body     = wp_remote_retrieve_body( $response );

            $resp = json_decode($body,true);
            // print_r($resp);
            // echo json_encode($resp);
            // exit;
            return $resp;
        }else{
            return null;
        }
    }

    public function get_rate_calcultor($order_id,$pickup_pincode,$delivery_pincode,$payment_type,$order_amount,$cod_amount,$weight,$no_of_box,$length,$width,$height){
        $this->init_params();
       

        if(!empty($this->public_key) && !empty($this->private_key)){

            $dimension= array(
                'no_of_box'=>'1',
                'length'=>$length,
                'width'=>$width,
                'height'=>$height
            );

            $body = array(
                'order-id'=>$order_id,
                'pickup_pincode'=>$pickup_pincode,
                'delivery_pincode'=>$delivery_pincode,
                'payment_type'=>$payment_type,
                'shipment_type'=>'FORWARD',
                'order_amount'=>$order_amount,
                'type_of_package'=>'SPS',
                'cod_amount'=>$order_amount,
                'weight'=>$weight*1000,
                'dimensions'=> array($dimension)
           
            );

             $postData = json_encode($body);
             $args = array(
                 'headers'     => array(
                     'public-key'=> $this->public_key,
                     'private-key'=> $this->private_key,
                     'Content-Type' => 'application/json'
                 ),
                  'body' =>$postData
             );

             $response = wp_remote_post( 'https://shipping-api.com/app/api/v1/rate-calculator', $args);
           
             $body     = wp_remote_retrieve_body( $response );

             $resp = json_decode($body,true);
             //print_r($args);
           // echo json_encode($weight);
            // echo($body);
             //exit;
            return $resp;
        }else{
            return null;
        }
    }

    public function push_order_to_shipmozo($order_id){
        $this->init_params();
        //$auth_token ="akjkjb";
        if(!empty($this->public_key) && !empty($this->private_key)){

            if(false == $body = $this->get_shipmozo_order_object($order_id)){
                return;
            }
            //echo json_encode($body );exit;
            $postData = json_encode($body);
             $args = array(
                 'headers'     => array(
                    'public-key'=> $this->public_key,
                     'private-key'=> $this->private_key,
                     'Content-Type' => 'application/json' 
                 ),
                  'body' =>$postData
             );
    
            $response = wp_remote_post( 'https://shipping-api.com/app/api/v1/push-order', $args );
          // $response = wp_remote_post( "https://eo650r7ymufcxnv.m.pipedream.net", $args );
            //https://eo650r7ymufcxnv.m.pipedream.net
          
            $body     = wp_remote_retrieve_body( $response );
           // echo $body;exit;
            $resp = json_decode($body,true);
            return $resp;

        }else{
            return null;
        }
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

    private function get_shipmozo_order_object($order_id){
        if(false == $order = wc_get_order( $order_id )){
            return false;
        }
        $phoneNumber = $this->extractPhoneNumber($order->get_billing_phone());
        $warehouseid = carbon_get_theme_option('bt_sst_shipmozo_warehouseid');
        $destination_postcode = $order->get_shipping_postcode();
        $get_shipping_first_name = $order->get_shipping_first_name();
        $get_shipping_last_name = $order->get_shipping_last_name();
        $get_shipping_address_1 = $order->get_shipping_address_1();
        $get_shipping_address_2 = $order->get_shipping_address_2();
        $get_shipping_city = $order->get_shipping_city();
        $get_shipping_state = $order->get_shipping_state();
        $get_shipping_email = $order->get_billing_email();
        if(!$destination_postcode){
            $destination_postcode = $order->get_billing_postcode();
            $get_shipping_first_name = $order->get_billing_first_name();
            $get_shipping_last_name = $order->get_billing_last_name();
            $get_shipping_address_1 = $order->get_billing_address_1();
            $get_shipping_address_2 = $order->get_billing_address_2();
            $get_shipping_city = $order->get_billing_city();
            $get_shipping_state = $order->get_billing_state();
            $get_shipping_email = $order->get_billing_email();
        }
        
        
        $so = array(
            "order_id"=> $order->get_id(),
            "order_date"=> $order->get_date_created()->date("Y-m-d H:i:s"),
            "order_type"=> "NON_ESSENTIALS",
            "consignee_name"=> $get_shipping_first_name . ' ' . $get_shipping_last_name,
            "consignee_phone"=> $phoneNumber,
            "consignee_email"=>  $get_shipping_email,
            "consignee_address_line_one"=> $get_shipping_address_1,
            "consignee_address_line_two"=> $get_shipping_address_2,
            "consignee_pin_code"=> $destination_postcode,
            "consignee_city"=> $get_shipping_city, 
            "consignee_state"=> $get_shipping_state,
            "product_detail"=> array(),
            "payment_type"=> $order->get_payment_method()=="cod"?"COD":"PREPAID",
            "cod_amount"=>$order->get_total(),
            "weight"=>"",
            "length"=>"",
            "width"=>"",
            "height"=>"",
            "warehouse_id"=> $warehouseid,
            "gst_ewaybill_number"=> "",
            "gstin_number"=> "",
            
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
            
                $so["product_detail"][] =array(
                    "name"=> $a->get_name(),
                    "sku_number"=>  $product_sku,
                    "quantity"=> $a->get_quantity(),
                    "discount"=> "",
                    "unit_price"=>  $order->get_item_total( $a, true, true ),
                    "hsn"=> "",
                    "product_category"=> ""
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
        $so["product_detail"][] =array(
            "name"=>"Shipping Charges",
            "sku_number"=>  "shipping_charges",
            "quantity"=> 1,
            "discount"=> "",
            "unit_price"=>  $order->get_total_shipping(),
            "hsn"=> "",
            "product_category"=> ""
        ); 
        $weight_unit = get_option('woocommerce_weight_unit');
        $dimension_unit = get_option('woocommerce_dimension_unit');

        $total_weight = new Mass($total_weight,  $weight_unit );
        $total_weight_kg = $total_weight->toUnit('g');
        
        $total_length = new Length($total_length, $dimension_unit);
        $total_length_cm = $total_length->toUnit('cm');

        $total_width = new Length($total_width, $dimension_unit);
        $total_width_cm = $total_width->toUnit('cm');

        $total_height = new Length($total_height, $dimension_unit);
        $total_height_cm = $total_height->toUnit('cm');
        
        $so["length"] = $total_length_cm>0?$total_length_cm:5;
        $so["width"] = $total_width_cm>0?$total_width_cm:5;
        $so["height"] = $total_height_cm>0?$total_height_cm:5;
        $so["weight"] = $total_weight_kg>0?$total_weight_kg:100;

        return $so;
        

    }

    public function update_order_shipment_status($order_id){
        $resp=null;
        if(!empty($awb_number = Bt_Sync_Shipment_Tracking_Shipment_Model::get_awb_by_order_id($order_id))){
            $resp= $this->get_order_tracking_by_awb_number($awb_number);
        } 

        if($resp!=null && $resp["result"] == "1" && $resp["data"] != null){
            $shipment_obj = $this->init_model($resp["data"], $order_id);
            Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);                           
            return $shipment_obj;
        }

        return null;
    }

    public function get_order_label_by_awb_numbers_shipmozo($awbs) {
        $this->init_params();
    
        if (!empty($this->public_key) && !empty($this->private_key)) {
            $awb_string = implode(',', $awbs);
            $url = 'https://shipping-api.com/app/api/v1/get-order-label/'.$awb_string;
            $args = array(
                'headers' => array(
                    'public-key' => $this->public_key,
                    'private-key' => $this->private_key
                ),
            );
    
            $response = wp_remote_get($url, $args);
            $body = wp_remote_retrieve_body($response);
            
            $resp = json_decode($body, true);
            $resp_array = [];
            if(is_array($resp['data']) && count($resp['data'])>0){
                foreach ($resp['data'] as $package) {
                    if (isset($package['label'])) {
                        $resp_array[] = $package['label'];
                    }
                }
                $resp = $resp_array;
            }else{
                $resp = "Please enter correct awb";
            }
        } else {
            $resp = "enter public and private key";
        }
        return $resp;
    }
    
}