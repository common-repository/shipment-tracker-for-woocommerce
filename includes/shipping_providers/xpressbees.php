<?php

/**
 * The xpressbees-specific functionality of the plugin.
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/xpressbees
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
class Bt_Sync_Shipment_Tracking_Xpressbees {

    private $webhook_secretkey;

	public function __construct() {
    }

    function init_params() {
        $webhook_secretkey=carbon_get_theme_option( 'bt_sst_xpressbees_webhook_secretkey' );
        $this->webhook_secretkey=trim($webhook_secretkey);
    }

    public function xpressbees_webhook_receiver($request){

        update_option( "xpressbees_webhook_called", time() );

        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        if(is_array($enabled_shipping_providers) && in_array('xpressbees',$enabled_shipping_providers)){
            $order_ids=array();

            if(isset($request["order_number"]) && !empty($request["order_number"])){
                //xpressbees order number is same as woo order id
                $order_ids[]=$request["order_number"];
            }else if(isset($request["awb_number"])){
                $awb = $request["awb_number"];
                //get orders matching awb and provider= xpressbees from db
                $order_ids = Bt_Sync_Shipment_Tracking_Shipment_Model::get_orders_by_awb_number($awb);
                
            }else{
                return "Thanks Xpressbees, nothing to do";
            }

            

            
            if(!is_array($order_ids)){
                $order_ids=array();
            }

            $courier_name = 'NA';
            $edd_old = '';
            if(empty($order_ids)) {
                return "Thanks Xpressbees, but order not found.";
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
                                $results[] = array( $order_id=>"Thanks Xpressbees! Record updated.");
                            //}else{
                                //$results[] = array( $order_id=>"Thanks Nimbuspost! Order too old.");                                
                            //}
                        }else{
                            $results[] = array( $order_id=>"Thanks Xpressbees! Order status out of scope.");  
                        }
                    }
                }
            }
            
        }

        return $results;
    }


 

    public function get_order_tracking($order_id){
	    
        return null;
    }

    public function init_model($data, $order_id){

        $obj = new Bt_Sync_Shipment_Tracking_Shipment_Model();

        //from webhook receiver
        $obj->shipping_provider = "xpressbees";
        $obj->order_id = $order_id;
        $obj->awb = sanitize_text_field($data["awb_number"]);
        $obj->courier_name = "Xpressbees";
        $obj->etd =  $data['edd_old'];

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
            //not yet implemented because xpressbees does not povide public apis.
        }
        return null;
    }
}
