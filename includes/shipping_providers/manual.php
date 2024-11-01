<?php

/**
 * The manual-specific functionality of the plugin.
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/manual
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
class Bt_Sync_Shipment_Tracking_Manual {

	public function __construct() {
    }

    public function update_data($order_id, $request){
        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        if(is_array($enabled_shipping_providers) && in_array('manual',$enabled_shipping_providers)){

            if(!empty($order_id)){
                $shipment_obj = $this->init_model($request, $order_id);
                Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);                
                return "Shipment details updated successfully.";
            }
            throw new Exception("Invalid order id.");
        }
        throw new Exception("Sorry, This provider is not enabled.");
    }

    public function init_model($data, $order_id){
        $obj = new Bt_Sync_Shipment_Tracking_Shipment_Model();
        $obj->shipping_provider = "manual";
        $obj->order_id = $order_id;
        
        $obj->awb = sanitize_text_field($data["awb_number"]);
        if ($obj->awb == '') {
            $awb_n = carbon_get_theme_option("bt_sst_manual_awb_number");
            $obj->awb = str_replace('#order_id#', $order_id, $awb_n);
        }

        $obj->courier_name = sanitize_text_field($data["courier_name"]);
        if ($obj->courier_name == '') {
            $cour_n = carbon_get_theme_option("bt_sst_manual_courier_name");
            $obj->courier_name = $cour_n;
        }

        $obj->etd = sanitize_text_field($data["etd"]);
        $obj->scans = array();
        $obj->current_status = sanitize_text_field($data["shipping_status"]);
        $obj->tracking_url = sanitize_text_field($data["tracking_link"]);

        $obj->delivery = $data;
        if (strtolower($obj->current_status) == "delivered" && empty($obj->delivery_date)) {
            $obj->delivery_date = date('Y-m-d');
        }        
        
        return $obj;
    }

    public function manual_webhook_receiver($request){
        $resp = array(
            //"code"=>"not_ok",
            "status"=>false,
            "message"=>"This shipping provider is not enabled.",
            "data"=>array()
        );

        if(empty($request["api_key"])){
            $resp = array(
                "status"=>false,
                "message"=>"API key is missing.",
                "data"=>array()
            );
            return $resp;
        }

        $manual_api_key = carbon_get_theme_option( 'bt_sst_manual_webhook_secretkey' );
        if($request["api_key"] !== $manual_api_key){
            $resp = array(
                "status"=>false,
                "message"=>"API key is invalid.",
                "data"=>array()
            );
            return $resp;
        }

        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        if(is_array($enabled_shipping_providers) && in_array('manual',$enabled_shipping_providers)){
            
            if(empty($request["awb_number"]) && empty($request["order_id"])){
                $resp = array(
                    "status"=>false,
                    "message"=>"Sorry, either AWB or Order ID is required.",
                    "data"=>array()
                );
                return $resp;
            }
            
            $order_ids=array();
            if(isset($request["order_id"]) && !empty($request["order_id"])){
                $order_ids[]=$request["order_id"];
            }
            if(isset($request["awb_number"]) && !empty($request["awb_number"])){
                $awb_number = $request["awb_number"];
                if(!empty($awb_order_ids = Bt_Sync_Shipment_Tracking_Shipment_Model::get_orders_by_awb_number($awb_number))){
                    foreach ($awb_order_ids as $awb_order_id) {
                        if(!in_array($awb_order_id,$order_ids)){
                            $order_ids[] = $awb_order_id;
                        }
                    }                    
                }
            }

            if(empty($order_ids)){
                $resp = array(
                    "status"=>false,
                    "message"=>"Sorry, no orders to process.",
                    "data"=>array()
                );
                return $resp;
            }

            if(empty($request["awb_number"])){
                //set awb number from existing order id
                $request["awb_number"] = Bt_Sync_Shipment_Tracking_Shipment_Model::get_awb_by_order_id($order_ids[0]);
                if(empty($request["awb_number"])){
                    $resp = array(
                        "status"=>false,
                        "message"=>"Sorry, awb nummber is required for this order.",
                        "data"=>array()
                    );
                    return $resp;
                }
            }
            $shipping_statuses = apply_filters( 'bt_sst_shipping_statuses', BT_SHIPPING_STATUS );
            $tracking_statuses = array_values($shipping_statuses );
            $shipping_status = $request["shipping_status"];
            if(!in_array($shipping_status,$tracking_statuses)){
                $resp = array(
                    "status"=>false,
                    "message"=>"Shipping status is out of scope, see data for list of possible values.",
                    "data"=>$tracking_statuses
                );
                return $resp;
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
    
                            if ( $diff_in_seconds <= $allowed_seconds ) {
                                $shipment_obj = $this->init_model($request, $order_id);
                                Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);
                                $results[] = array( $order_id=>"Order #".$order_id." tracking updated.");
                            }else{
                                $results[] = array( $order_id=>"Order #".$order_id." too old.");                                
                            }
                        }else{
                            $results[] = array( $order_id=>"Order #".$order_id." Status out of scope.");  
                        }
                    }
                }
            }
            
        }

        $resp = array(
            "status"=>true,
            "message"=>"Thanks, orders updated.",
            "data"=>$results
        );

        return $resp;
    }

}
