<?php
class Bt_Sync_Shipment_Tracking_Ship24 {

    public function init_params() {
        $public_key=carbon_get_theme_option( 'bt_sst_ship24_apitoken' );
        $this->public_key=trim($public_key);
    }
    public function ship24_webhook_receiver($request){

        update_option( "ship24_webhook_called", time() );
        $awbs = [];
        foreach($request["trackings"] as $awb){
            $awb_number = $awb["tracker"]["trackingNumber"];
            $awbs[$awb_number] = array(
                "order_ids"=> [],
                "awb"=>$awb_number,
                "tracking"=>$awb["tracker"],
                "events"=>$awb["events"],
                "shipment" => $awb["shipment"]
            );
        }

       
        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        if(is_array($enabled_shipping_providers) && in_array('manual',$enabled_shipping_providers)){
          
            foreach ($awbs as $awb) {     
                if(isset($awb["awb"]) && !empty($awb["awb"])){
                    $awb_number = $awb["awb"];
                    if(!empty($awb_order_ids = Bt_Sync_Shipment_Tracking_Shipment_Model::get_orders_by_awb_number($awb_number))){
                        $awbs[$awb_number]["order_ids"] = $awb_order_ids;         
                    }
                    // return $awb_order_ids;
                }
            }

            if(!empty($awbs) && is_array($awbs)){
                foreach ($awbs as $track_obj) {
                    // return $track_obj;
                    foreach ($track_obj["order_ids"] as $order_id) {
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
                                        $shipment_obj = $this->init_model($track_obj, $order_id);
                                        // return $shipment_obj;
                                        Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);                           
                                        return "Thanks Ship24! Record updated.";
                                    }else{
                                        return "Thanks Ship24! Order too old.";
                                    }
                                }else{
                                    return "Thanks Ship24! Order status out of scope.";
                                }
                            }
                        }
                    }
                }                    
            }

            
        }
        return "Faild";
    }
    public function init_model($data, $order_id){
        $obj = new Bt_Sync_Shipment_Tracking_Shipment_Model();
        //from webhook receiver
        $obj->shipping_provider = "manual";
        $obj->order_id = $order_id;

        if(isset($data["awb"])){
            $obj->awb = sanitize_text_field($data["awb"]);
            if(isset($data['shipment']["delivery"]["service"]) && !empty($data['shipment']["delivery"]["service"])){
                $obj->courier_name = $data['shipment']["delivery"]["service"];
            }else{
                $obj->courier_name = Bt_Sync_Shipment_Tracking::bt_sst_get_order_meta($order_id, '_bt_shipping_ship24_corier_name', true );

            }
            
            $obj->etd =  $data['shipment']["delivery"]["estimatedDeliveryDate"];
    
            if(empty($obj->scans)){
                $obj->scans = array();
            }
    
            if(isset($data['history'])) {
                $obj->scans = $data['history'];
            } else {
                $obj->scans[] = $data["events"];
            }
            $obj->current_status = sanitize_text_field($data["shipment"]["statusMilestone"]);
            
            if (isset($data["statistics"])) {
                $obj->delivery_date = sanitize_text_field($data["statistics"]['timestamps']["deliveredDatetime"]);
            }else{
                $obj->delivery_date = date('Y-m-d');
            }       
            
        }else if(isset($data['tracker'])){
            $obj->awb = sanitize_text_field($data["tracker"]['trackingNumber']);
            if(isset($data['shipment']["delivery"]["service"]) && !empty($data['shipment']["delivery"]["service"])){
                $obj->courier_name = $data['shipment']["delivery"]["service"];
            }else{
                $obj->courier_name = Bt_Sync_Shipment_Tracking::bt_sst_get_order_meta($order_id, '_bt_shipping_ship24_corier_name', true );

            }
            $obj->etd =  $data['shipment']["delivery"]["estimatedDeliveryDate"];
    
            if(empty($obj->scans)){
                $obj->scans = array();
            }
    
            if(isset($data['history'])) {
                $obj->scans = $data['history'];
            } else {
                $obj->scans[] = $data["events"];
            }
            if(!empty($data['events'])){
                $obj->current_status = sanitize_text_field($data["shipment"]["statusMilestone"]);
            }
            
            if (isset($data["statistics"])) {
                $obj->delivery_date = sanitize_text_field($data["statistics"]['timestamps']["deliveredDatetime"]);
            }  
        }
        return $obj;
    }
    public function update_order_shipment_status($order_id){ 
        $order = wc_get_order($order_id);
		$get_awb_no = Bt_Sync_Shipment_Tracking::bt_sst_get_order_meta( $order_id, '_bt_shipping_awb', true );
		$tracking_id = Bt_Sync_Shipment_Tracking::bt_sst_get_order_meta( $order_id, '_bt_sst_ship24_tracker_id_'.$get_awb_no, true );

        $resp=null;
        // $tracking_id=null;
        if(!empty($tracking_id)){
            $resp= $this->get_order_tracking_by_awb_numbers($get_awb_no);
        }else{
            $resp= $this->create_tracker_for_ship24_tracking($get_awb_no, $order);
            if(isset($resp["tracker"]) && isset($resp['tracker']['trackerId']) && !empty($resp['tracker']['trackerId'])){
                Bt_Sync_Shipment_Tracking::bt_sst_update_order_meta($order_id, '_bt_sst_ship24_tracker_id_'.$get_awb_no, $resp['tracker']['trackerId'] );
            }
        }

        if($resp!=null && isset($resp["tracker"])){
            $shipment_obj = $this->init_model($resp, $order_id);
            Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);                           
            return $shipment_obj;
        }
        if(isset($resp['errors'])){
            return $resp;
        }

        return false;
    }
    public function create_tracker_for_ship24_tracking($awb_number, $order) {
        $order_id = $order->get_id();
        $corier_name = Bt_Sync_Shipment_Tracking::bt_sst_get_order_meta( $order_id, '_bt_shipping_ship24_corier_name', true );
		$corier_code = Bt_Sync_Shipment_Tracking::bt_sst_get_order_meta( $order_id, '_bt_shipping_ship24_corier_code', true );
        $ship_refrence = $order_id;
        $shipment_contry_code = $order->get_shipping_country();
        $dst_c_code = $order->get_billing_country();
        $destination_postcode = $order->get_shipping_postcode();
        if(!$destination_postcode){
            $destination_postcode = $order->get_billing_postcode();
        }
        
        $courier_code = $corier_code;
        $courier_name = $corier_name;
        $this->init_params();
        if (!empty($this->public_key)) {
            $args = array(
                'headers' => array(
                    'Authorization' => "Bearer " . $this->public_key,
                    'Content-Type'  => 'application/json; charset=utf-8',
                ),
                'body' => json_encode(array(
                    "trackingNumber" => $awb_number,
                    "shipmentReference" => (string)$order_id,
                    "originCountryCode" => "IN",
                    "destinationCountryCode" => "IN",
                    "destinationPostCode" => "IN",
                    "courierCode" => [$courier_code],
                    "courierName" => $courier_name,
                    "orderNumber" => (string)$order_id
                ))
            );
            
            $url = 'https://api.ship24.com/public/v1/trackers/track';
            $response = wp_remote_post($url, $args);
            $body = wp_remote_retrieve_body($response);
            
            $resp = json_decode($body, true);
        //   echo"testt"; print_r( $args );
           
         //  print_r( $body );
         //  exit;
            if(isset($resp['data'])){
                $resp = $resp['data']['trackings'][0];
            }
            return $resp;
        } else {
            return false;
        }
    }  
    public function get_order_tracking_by_awb_numbers($awb_number){
       
        $this->init_params();
        $auth_token = $this->public_key;
        if(!empty($auth_token)){

            $args = array(
                'headers' => array(
                    'Authorization' => "Bearer " . $this->public_key,
                )
            );
    
            $url = 'https://api.ship24.com/public/v1/trackers/search/'.$awb_number.'/results';

            $response = wp_remote_get($url, $args);
            $body     = wp_remote_retrieve_body( $response );
            $resp = json_decode($body,true);
            // echo "<pre>"; print_r($resp); die;

            if(isset($resp['data'])){
                $resp = $resp['data']['trackings'][0];
                return $resp;
            }else{
                return $resp;
            }

        }else{
            return false;
        }
    }
    public function get_coriers_name_and_test_connectin(){
        
        $this->init_params();
        $auth_token = $this->public_key;
        if(!empty($auth_token)){

            $args = array(
                'headers' => array(
                    'Authorization' => "Bearer " . $this->public_key,
                )
            );
    
            $url = 'https://api.ship24.com/public/v1/couriers';

            $response = wp_remote_get($url, $args);
            $body     = wp_remote_retrieve_body( $response );
            $response = json_decode($body,true);
            // echo "<pre>"; print_r($resp); die;
 
            $resp = $response['data'];
            if(!empty($resp) && !empty($resp['couriers'])){
                update_option('_bt_sst_ship24_active_courier_companies', $resp['couriers']);
                return $resp['couriers'];
            }else{
                return $response['errors'];
            }

        }else{
            return false;
        }
    }
    // public function test_ship24_connection(){
    //     $this->init_params();
    //     $auth_token = $this->public_key;
    //     if(!empty($auth_token)){

    //         $args = array(
    //             'headers' => array(
    //                 'Authorization' => "Bearer " . $this->public_key,
    //             )
    //         );
    
    //         $url = 'https://api.ship24.com/public/v1/couriers';

    //         $response = wp_remote_get($url, $args);
    //         $body     = wp_remote_retrieve_body( $response );
    //         $response = json_decode($body,true);
 
    //         $resp = $response['data'];
    //         if(!empty($resp) && !empty($resp['couriers'])){
    //             return true;
    //         }else{
    //             return false;
    //         }

    //     }else{
    //         return false;
    //     }
    // }
}