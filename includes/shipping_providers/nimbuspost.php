<?php

/**
 * The nimbuspost-specific functionality of the plugin.
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/nimbuspost
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
class Bt_Sync_Shipment_Tracking_Nimbuspost {

    // private const COURIERS_JSON = '{"37":"Amazon Logistics 1 KG", "52":"Amazon Logistics 2 KG", "53":"Amazon Logistics 5 KG", "5":"Bluedart Express", "1":"Delhivery Air", "6":"Delhivery Surface", "13":"Delhivery Surface 10 K.G", "7":"Delhivery Surface 2 K.G", "35":"Delhivery Surface 20 K.G", "11":"Delhivery Surface 5 K.G", "8":"DTDC Air", "9":"DTDC Surface", "30":"DTDC Surface 1 K.G", "31":"DTDC Surface 10 K.G", "29":"DTDC Surface 5 K.G", "10":"Ecom EXP", "26":"Ecom ROS", "15":"Ekart", "25":"Ekart 1 K.G", "27":"Ekart 2 K.G", "28":"Ekart 5 K.G", "55":"Gati 10 K.G", "56":"Gati 20 K.G", "36":"Gati 5 K.G", "4":"Shadowfax", "32":"Shadowfax 1 K.G", "33":"Shadowfax 2 K.G", "34":"Shadowfax 5 K.G", "44":"Udaan", "50":"Udaan 1 KG", "51":"Udaan 2 KG", "42":"Xpressbees 1 K.G", "45":"Xpressbees 2 K.G", "46":"Xpressbees 5 K.G", "3":"Xpressbees Air", "14":"Xpressbees Surface"}';

    // private const API_BASE_URL = "https://ship.nimbuspost.com";
    // private const API_TRACK_BY_AWB_NO = "/api/shipments/track_awb/";
    // private const API_TRACK_BY_ORDER_ID = "/api/orders/";
    // private const API_GET_ALL_SHIPMENTS = "/api/shipments";

    private $api_key;

    private $webhook_secretkey;

	public function __construct() {
    }

    function init_params() {
        $api_key=carbon_get_theme_option( 'bt_sst_nimbuspost_apikey' );
        $webhook_secretkey=carbon_get_theme_option( 'bt_sst_nimbuspost_webhook_secretkey' );

        $this->api_key=trim($api_key);
        $this->webhook_secretkey=trim($webhook_secretkey);
    }

    private function nimbuspost_webhook_receiver_old($request){

        update_option( "nimbuspost_webhook_called", time() );

        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        if(is_array($enabled_shipping_providers) && (in_array('nimbuspost',$enabled_shipping_providers) || in_array('nimbuspost_new',$enabled_shipping_providers))){

            if(!$awb = $request["awb_number"]){
                return "Thanks Nimbuspost, nothing to do";
            }

            //get orders matching awb and provider= numbuspost from db
            $order_ids = Bt_Sync_Shipment_Tracking_Shipment_Model::get_orders_by_awb_number($awb);

            
            if(!is_array($order_ids)){
                $order_ids=array();
            }

            $courier_name = 'NA';
            if(empty($order_ids)) {
                $nimbuspost_shipment_obj = $this->get_order_by_awb_number($awb);
                if ($nimbuspost_shipment_obj['status']) {
                    $order_data = $nimbuspost_shipment_obj['data'];
                    $order_ids[] = $order_data['order_number'];
                    $courier_name = $this->get_courier_by_id($order_data['courier_id']);
                } else {
                    return "Thanks Nimbuspost, but order not found.";
                }
            } else {
                $bt_shipment_tracking_old = Bt_Sync_Shipment_Tracking_Shipment_Model::get_tracking_by_order_id($order_ids[0]);
                $courier_name = $bt_shipment_tracking_old->courier_name;
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
                                $data['courier_name'] = $courier_name;
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

    public function nimbuspost_webhook_receiver($request){

        update_option( "nimbuspost_webhook_called", time() );

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


    public function get_order_by_awb_number($awb){
        $this->init_params();

        if(!empty($this->api_key)){

            $args = array(
                'headers'     => array(
                    'NP-API-KEY' => $this->api_key,
                ),
            );

            $response = wp_remote_get( self::API_BASE_URL . self::API_TRACK_BY_AWB_NO . $awb, $args );

            $body     = wp_remote_retrieve_body( $response );

            $resp = json_decode($body,true);
            return $resp;

        }else{
            return null;
        }
    }

    public function get_order_tracking($order_id){
	    $awb_number = Bt_Sync_Shipment_Tracking_Shipment_Model::get_awb_by_order_id($order_id);
        if(empty($awb_number)) {

            // Get Order Dates
            $order = wc_get_order( $order_id );
            $order_date = $order->get_date_created();
            $from_date = $order_date->date('Y-m-d');

            $all_shipments = $this->get_all_shipments($from_date);
            $shipment_found = null;
            if (!$all_shipments['status']) {
                return null;
            }

            $shipments_data = $all_shipments['data'];
            foreach ($shipments_data as $shipment) {
                if ($shipment['order_number'] == $order_id) {
                    $shipment_found = $shipment;
                    break;
                }
            }

            if(!$shipment_found){
                return null;
            }
            $awb_number = $shipment['awb_number'] ;
        }

        $nimbuspost_shipment_obj = $this->get_order_by_awb_number($awb_number);
        if (!$nimbuspost_shipment_obj['status']) {
            return null;
        }

        $data = $nimbuspost_shipment_obj['data'];
        return $data;
    }

    public function get_all_shipments($from_date = ''){
        $this->init_params();

        if(!empty($this->api_key)){

            $body = array(
                'from'    => $from_date,
            );

            $args = array(
                'body'        => $body,
                'headers'     => array(
                    'NP-API-KEY' => $this->api_key,
                ),
            );

            $response = wp_remote_get( self::API_BASE_URL . self::API_GET_ALL_SHIPMENTS, $args );

            $body     = wp_remote_retrieve_body( $response );

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

        //from webhook receiver
        $obj->shipping_provider = "nimbuspost";
        $obj->order_id = $order_id;
        $obj->awb = sanitize_text_field($data["awb_number"]);
        $obj->courier_name = sanitize_text_field($data["courier_name"]);
        $obj->etd = '';

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

    public function save_order_shipment_data($order_id, $shipment_obj){
        Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);
    }

    public function update_order_shipment_status($order_id){
        $resp= $this->get_order_tracking($order_id);
		if(!empty($resp) && sizeof($resp)>0){
            $resp['courier_name'] = $this->get_courier_by_id($resp['courier_id']);
            $shipment_obj = $this->init_model($resp, $order_id);
            $this->save_order_shipment_data($order_id, $shipment_obj);
			return $shipment_obj;
        }
        return null;
    }
    public function get_order_label_by_order_ids($ids) {
        $this->init_params();
    
        if (!empty($this->api_key)) {
            // Prepare the body with order IDs
            $body = array(
                'ids' => $ids // Pass the order IDs as an array
            );
    
            // Convert body to JSON format
            $postData = json_encode($body);
            $args = array(
                'headers' => array(
                    'NP-API-KEY' => $this->api_key, // Use NP-API-KEY for authorization
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
    
                ),
                'body' => $postData
            );
    
            // Make the API call to retrieve order labels
            $response = wp_remote_post('https://ship.nimbuspost.com/api/shipments/label', $args);
    
            if (is_wp_error($response)) {
                // Handle error response from wp_remote_post
                return array('error' => $response->get_error_message());
            }
    
            $body = wp_remote_retrieve_body($response);
    
            // Decode the JSON response into an associative array
            $resp = json_decode($body, true);
    
            echo "<pre>"; print_r($resp); die; // Debugging output to examine the response
    
            // Check if response contains data
            if (isset($resp['data'])) {
                return $resp['data']; // Return the label data if available
            } else {
                // Handle potential errors
                return array('error' => isset($resp['message']) ? $resp['message'] : 'Unknown error occurred.');
            }
        } else {
            return array('error' => 'API key is missing.');
        }
    }
    
    
}
