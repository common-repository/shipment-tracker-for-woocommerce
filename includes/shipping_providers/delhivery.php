<?php
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
class Bt_Sync_Shipment_Tracking_Delhivery {

    private $public_key;

    public function __construct() {
    }

    public function init_params() {
        $public_key=carbon_get_theme_option( 'bt_sst_delhivery_apitoken' );
        $this->public_key=trim($public_key);
    }
    
    public function test_delhivery(){
        $args ="";
        $this->init_params();
        if(!empty($this->public_key)){
            $body= array(
                'token'=>$this->public_key,
                'filter_codes'=>'311001'
            );
            $url = 'https://track.delhivery.com/c/api/pin-codes/json/?' .  http_build_query($body);
            $response = wp_remote_get($url , $args );
            $body     = wp_remote_retrieve_body( $response );
          
            $resp = json_decode($body,true);
           if(isset($resp["delivery_codes"]) && sizeof($resp["delivery_codes"])>0){
                return true;
            }
            else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function get_rate_calcultor_and_date($md, $ss, $d_pin, $o_pin, $cgm){
        $this->init_params();
        if(!empty($this->public_key)){
            $body = array(
                'md'=>$md,
                'ss'=>$ss,
                'd_pin'=>$d_pin,
                'o_pin'=>$o_pin,
                'cgm'=>$cgm
                
            );
            // echo "<pre>"; print_r($body); die;
            $args = array(
                'headers'     => array(
                    'Authorization'=>'Token '. $this->public_key
                )
            );
    
            $url = 'https://track.delhivery.com/api/kinko/v1/invoice/charges/.json?' .  http_build_query($body);
            $response = wp_remote_get( $url, $args);
            // echo "<pre>"; print_r($response); die;
             $body     = wp_remote_retrieve_body( $response );

             $resp = json_decode($body,true);
            return $resp;
        }else{
            return null;
        }
    }

    public function get_order_tracking_by_awb_number($awb_number){
        $args ="";
        $this->init_params();
        // echo "<pre>"; echo($this->public_key); die;

        if(!empty($this->public_key)){
    
            $body = array(
                'waybill'=> $awb_number,
                'token'=>$this->public_key
            );
            $url = 'https://track.delhivery.com/api/v1/packages/json?' . http_build_query($body);

            $response = wp_remote_get( $url, $args);
            // echo "<pre>"; print_r(json_decode($response['body'])); die;
           
            $body     = wp_remote_retrieve_body( $response );
    
            $resp = json_decode($body,true);
    
            return $resp;
        } else {
            return null;
        }
    }

    public function init_model($data, $order_id){
        $obj = new Bt_Sync_Shipment_Tracking_Shipment_Model();
        $obj->order_id = $order_id;
        $obj->shipping_provider = 'delhivery';
        $obj->courier_name = 'Delhivery';
        
        
        if (sizeof($data) > 0) {
            $shipment = $data[0]['Shipment'];
            $obj->awb = $shipment['AWB'];
            $obj->current_status = $shipment['Status']['Status'];
            $obj->etd = $shipment['ExpectedDeliveryDate'];
            $obj->scans = $shipment['Scans'];

            if (strtolower($obj->current_status) == "delivered" && empty($obj->delivery_date)) {
                $obj->delivery_date = date('Y-m-d');
            }        
            
        }

        

        return $obj;

    }
    public function get_order_tracking($order_id){
        $this->init_params();
        if(!empty($this->public_key)){
        $args = "";
        $body = array(
            'ref_ids'=> $order_id,
            'token'=>$this->public_key,
        );
        $url = 'https://track.delhivery.com/api/v1/packages/json?' . http_build_query($body);

        $response = wp_remote_get( $url, $args);
        
        $body     = wp_remote_retrieve_body( $response );
        // echo "<pre>"; print_r($response); die;

        $resp = json_decode($body,true);
        return $resp;
        }else{
            return null;
        }
    }
    public function update_order_shipment_status($order_id){
        // die("hrtfghf");
        $resp=null;
        if(!empty($awb_number = Bt_Sync_Shipment_Tracking_Shipment_Model::get_awb_by_order_id($order_id))){
            $resp= $this->get_order_tracking_by_awb_number($awb_number);
        }
        if($resp==null) {
            // die("dsfsd");
            $resp = $this->get_order_tracking($order_id);     
        }
        // var_dump($resp);
        //  die;

        if($resp!=null && isset($resp["ShipmentData"])){
            // die("dsfsd");
            //$order = wc_get_order( $order_id );
			//$order->add_order_note('Fetched latest tracking from Delhivery.' . "\n\n- Shipment tracker for woocommerce", false );
            $shipment_obj = $this->init_model($resp["ShipmentData"], $order_id);
            Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);                           
            return $shipment_obj;
        }

        return null;
    }

    public function push_order_to_delhivery($order_id){
        $this->init_params();
        
        if (!empty($this->public_key)) {
            $postData = $this->get_delhivery_order_object($order_id);
            
            if (false === $postData) {
                return;
            }
            // echo "<pre>"; print_r(json_encode($postData)); echo "</pre>";
            $postData = 'format=json&data=' . urlencode(json_encode($postData));
            $args = array(
                'headers' => array(
                    'Content-Type'  => 'application/x-www-form-urlencoded',
                    'Accept'        => 'application/json',
                    'Authorization' => 'Token ' . $this->public_key,
                ),
                'body' => $postData
            );
    
            $url = 'https://track.delhivery.com/api/cmu/create.json';
            
            $response = wp_remote_post($url, $args);
            // echo "<pre>"; print_r($response); die;
            $body = wp_remote_retrieve_body($response);
            $resp = json_decode($body, true);
            
            return $resp;
        } else {
            return null;
        }
    }
    
    private function get_delhivery_order_object($order_id){
        if(false == $order = wc_get_order( $order_id )){
            return false;
        }
        $phoneNumber = $this->extractPhoneNumber($order->get_billing_phone());
        $pickup_location = carbon_get_theme_option( 'bt_sst_delhivery_warehouse_name' );
        $destination_postcode = $order->get_shipping_postcode();
        $get_shipping_first_name = $order->get_shipping_first_name();
        $get_shipping_last_name = $order->get_shipping_last_name();
        $get_shipping_address_1 = $order->get_shipping_address_1();
        $get_shipping_address_2 = $order->get_shipping_address_2();
        $get_shipping_city = $order->get_shipping_city();
        $get_shipping_state = $order->get_shipping_state();
        $get_shipping_country = $order->get_shipping_country();
        if(!$destination_postcode){
            $destination_postcode = $order->get_billing_postcode();
            $get_shipping_first_name = $order->get_billing_first_name();
            $get_shipping_last_name = $order->get_billing_last_name();
            $get_shipping_address_1 = $order->get_billing_address_1();
            $get_shipping_address_2 = $order->get_billing_address_2();
            $get_shipping_city = $order->get_billing_city();
            $get_shipping_state = $order->get_billing_state();
            $get_shipping_country = $order->get_billing_country();
        }
    
        $postData = array(
            "shipments" => array(
                array(
                    "name" => $get_shipping_first_name . ' ' . $get_shipping_last_name,
                    "add" =>   $get_shipping_address_1.' '.$get_shipping_address_2,
                    "pin" =>  $destination_postcode,
                    "city" =>  $get_shipping_city, 
                    "state" => $get_shipping_state,
                    "country" => $get_shipping_country,
                    "phone" => $phoneNumber,
                    "order" => $order->get_id(),
                    "payment_mode" => $order->get_payment_method()=="cod"?"COD":"PREPAID",
                    "return_pin" => "",
                    "return_city" => "",
                    "return_phone" => "",
                    "return_add" => "",
                    "return_state" => "",
                    "return_country" => "",
                    "products_desc" => "",
                    "hsn_code" => "",
                    "cod_amount" =>$order->get_total(),
                    "order_date" => $order->get_date_created()->format("Y-m-d\TH:i:s.000\Z"),
                    "total_amount" => $order->get_total(),
                    "seller_add" => "",
                    "seller_name" => "",
                    "seller_inv" => "",
                    "quantity" => "",
                    "waybill" => "",
                    "shipment_length" => "",
                    "shipment_width" => "",
                    "shipment_height" => "",
                    "weight" => "",
                    "seller_gst_tin" => "",
                    "shipping_mode" => "Express",
                    "address_type" => ""
                )
            ),
            "pickup_location" => array(
                "name" => $pickup_location
            )
        );

        $total_weight = 0;
        $total_width = 0;
        $total_height = 0;
        $total_length = 0;

        foreach ($order->get_items() as $item_id => $a) {
            if (is_a($a, 'WC_Order_Item_Product')) {
                $product = $a->get_product();
                $postData['shipments'][0]['quantity'] = $a->get_quantity();

                if(!empty($product->get_weight()) && $product->get_weight()>0){
                    $total_weight = $total_weight + ($product->get_weight() * $a->get_quantity());
                }

                if(!empty($product->get_width()) && $product->get_width()>0){
                    $total_width = $total_width + ($product->get_width() * $a->get_quantity());
                    if($product->get_height()>$total_height){
                        $total_height =$product->get_height();
                    }
                    if($product->get_length()>$total_length){
                        $total_length =$product->get_length();
                    }
                }


            }
        }
        $weight_unit = get_option('woocommerce_weight_unit');
        $dimension_unit = get_option('woocommerce_dimension_unit');

        $total_weight = new Mass($total_weight,  $weight_unit );
        $total_weight_kg = $total_weight->toUnit('g');

        $total_width = new Length($total_width, $dimension_unit);
        $total_width_cm = $total_width->toUnit('cm');

        $total_height = new Length($total_height, $dimension_unit);
        $total_height_cm = $total_height->toUnit('cm');

        $total_length = new Length($total_length, $dimension_unit);
        $total_height_cm = $total_length->toUnit('cm');
        
        $postData['shipments'][0]['weight'] = $total_weight_kg>0?$total_weight_kg:100;
        $postData['shipments'][0]['shipment_width'] = $total_width_cm>0?$total_width_cm:5;
        $postData['shipments'][0]['shipment_height'] = $total_height_cm>0?$total_height_cm:5;
        $postData['shipments'][0]['shipment_length'] = $total_height_cm>0?$total_height_cm:5;
        // echo "<pre>"; print_r($postData); echo "</pre>";
        return $postData;
        
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

    public function get_rate_calcultor($pickup_pincode, $delivery_pincode, $pm, $declared_value, $cod, $weight_in_kg, $one, $length_in_cms, $breadth_in_cms, $height_in_cms) {
        $this->init_params();
    
        $auth_key = $this->public_key;
        if (!empty($auth_key)) {
    
            // Call for Express
            $body_express = $this->getDataForExpressAndSurface('E', $delivery_pincode, $pickup_pincode, $weight_in_kg, $auth_key);
    
            // Call for Surface
            $body_surface = $this->getDataForExpressAndSurface('S', $delivery_pincode, $pickup_pincode, $weight_in_kg, $auth_key);
           
            if(isset($body_express['error']) || isset($body_surface['error'])){
                return null;
            }else{
            $all_methods = [];
            if($body_express){
                foreach ($body_express as  $value) {
                    $value['mode'] = "express";
                    $all_methods[] = $value;
                }
            }
            if($body_surface){
                foreach ($body_surface as  $value) {
                    $value['mode'] = "surface";
                    $all_methods[] = $value;
            }
            }
            // echo "<pre>"; print_r($all_methods); echo "</pre>";

        }
            
            return $all_methods;
        } else {
            return null;
        }
    }
    

    function getDataForExpressAndSurface($mode, $delivery_pincode, $pickup_pincode, $weight_in_kg, $auth_key) {
        $body = array(
            'md' => $mode,
            'ss' => "Delivered",
            'd_pin' => $delivery_pincode,
            'o_pin' => $pickup_pincode,
            'cgm' => $weight_in_kg
        );
    
        $args = array(
            'headers' => array(
                'Authorization' => 'Token ' . $auth_key
            )
        );
    
        $url = 'https://track.delhivery.com/api/kinko/v1/invoice/charges/.json?' . http_build_query($body);
        $response = wp_remote_get($url, $args);
       
        $body     = wp_remote_retrieve_body( $response );
            
        $resp = json_decode($body,true);

        return  $resp ;
    }

    public function get_locality($postcode){
        // die;
        $this->init_params();
        $auth_token = $this->public_key;

        if(!empty($auth_token)){

            $body= array(
                'token'=>$this->public_key,
                'filter_codes'=>$postcode
            );
            $url = 'https://track.delhivery.com/c/api/pin-codes/json/?' .  http_build_query($body);
            $response = wp_remote_get($url );
            // $body     = wp_remote_retrieve_body( $response );
          
            // $resp = json_decode($body,true);

            // $response = wp_remote_get( self::API_BASE_URL . self::API_GET_LOCALITY . $postcode, $args );
           
            $body     = wp_remote_retrieve_body( $response );
            
            $resp = json_decode($body,true);
            if(!isset($resp['delivery_codes'][0])){
                return null;
            }
            // echo "<pre>"; print_r($resp); die;
            // echo json_encode($resp);
            // exit;
            
            if(isset($resp["delivery_codes"][0])){
                $data = array(
                    "postcode"=>$resp["delivery_codes"][0]['postal_code']['pin'],
                    "city"=>$resp["delivery_codes"][0]['postal_code']['city'],
                    "state_code"=>$resp["delivery_codes"][0]['postal_code']['state_code'],
                    "country"=>$resp["delivery_codes"][0]['postal_code']['country_code'],
                );
                // echo $data;
                // exit;
                return $data;
            }

        }else{
            return null;
        }


    }
    public function get_order_label_by_awb_numbers($awbs) {
        $this->init_params();
    
        if (!empty($this->public_key) && !empty($awbs)) {

            $awbs_string = implode(',', $awbs);

            $query_params = array(
                'wbns' => $awbs_string,
                'pdf' => 'true',
            );
    
            $url = add_query_arg($query_params, 'https://track.delhivery.com/api/p/packing_slip');
    
            $args = array(
                'headers' => array(
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Token ' . $this->public_key,
                ),
            );
    
            $response = wp_remote_get($url, $args);
    
            $body = wp_remote_retrieve_body($response);
            $resp = json_decode($body, true);
            
            $resp_array = [];
            if (isset($resp['packages_found']) && $resp['packages_found'] > 0) {
                foreach ($resp['packages'] as $package) {
                    if (isset($package['pdf_download_link'])) {
                        $resp_array[] = $package['pdf_download_link'];
                    }
                }
                $resp = $resp_array;
            } else {
                $resp = "Please enter a correct AWB number";
            }            

            return $resp;
        } else {
            return 'Please Enter Token';
        }
    }
    
}