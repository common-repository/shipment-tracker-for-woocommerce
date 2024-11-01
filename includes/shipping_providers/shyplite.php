<?php

/**
 * The shiprocket-specific functionality of the plugin.
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/shiprocket
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
class Bt_Sync_Shipment_Tracking_Shyplite {

    private const TRACKING_EVENT_STATUS_CODES = array(
                                                    "SB"=>"Shipment Booked",
                                                    "PU"=>"Picked Up",
                                                    "IT"=>"In Transit",
                                                    "EX"=>"Exception",
                                                    "OD"=>"Out for Delivery",
                                                    "OP"=>"Out for Pickup",
                                                    "RT"=>"Return",
                                                    "DL"=>"Delivered",
                                                );
    private const API_BASE_URL = "https://api.shyplite.com";
    private const API_BULK_TRACK_BY_ORDER_ID = "/track?oid=1";

    private const API_BULK_TRACK_BY_AWB_NUMBERS = "/track";

    private $auth_token;
    private $seller_id;
    private $app_id;
    private $public_key;
    private $secret_key;

	public function __construct() {
    }

    function init_params() {
        $seller_id=carbon_get_theme_option( 'bt_sst_shyplite_sellerid' );
		$app_id=carbon_get_theme_option( 'bt_sst_shyplite_appid' );
		$public_key=carbon_get_theme_option( 'bt_sst_shyplite_publickey' );
        $secret_key=carbon_get_theme_option( 'bt_sst_shyplite_secretkey' );

        $this->seller_id=trim($seller_id);
        $this->app_id=trim($app_id);
        $this->public_key=trim($public_key);
        $this->secret_key=trim($secret_key);
    }


    function generate_token(){
        $timestamp    = time();
        $appID        = $this->app_id;
        $key          = $this->public_key;
        $secret       = $this->secret_key;

        $sign = "key:".$key."id:".$appID.":timestamp:".$timestamp;
        $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
        return array(
            "authtoken"=>$authtoken,
            "timestamp"=>$timestamp,
            "appID"=>$appID,
            "key"=>$key,
            "secret"=>$secret,
        );
        //echo $timestamp;
    }

    public function get_orders_tracking_by_awb($awbs){

        if(!empty($awbs)){
            $this->init_params();
            $authtoken = $this->generate_token();

            $headers = array(
                "x-appid"=> $this->app_id,
                "x-timestamp"=> $authtoken["timestamp"],
                "x-sellerid"=> $this->seller_id,
                "x-version"=> 3, // for auth version 3.0 only
                "Authorization"=>$authtoken["authtoken"],
                "content-type"=>"application/json",
            );
            $body = array(
                "awbs"=>$awbs
            );

            $postData = json_encode($body);

            $args = array(
                'body' => $postData,
                'headers' => $headers
            );

            $url = self::API_BASE_URL . self::API_BULK_TRACK_BY_AWB_NUMBERS;

            $response = wp_remote_post( $url, $args );

            $body = wp_remote_retrieve_body( $response );
            
            $resp = json_decode($body,true);
           // echo json_encode($resp);exit;
            return !isset($resp["error"])?$resp:null;
            //return $resp;
        }
        return null;
    }

    public function get_order_tracking_by_awb($awb){
        $resp = $this->get_orders_tracking_by_awb(array($awb));
        if(isset($resp[$awb])){
            return $resp[$awb];
        }
        return null;
    }

    public function get_orders_tracking($order_ids){

        if(!empty($order_ids)){
            $this->init_params();
            $authtoken = $this->generate_token();

            $headers = array(
                "x-appid"=> $this->app_id,
                "x-timestamp"=> $authtoken["timestamp"],
                "x-sellerid"=> $this->seller_id,
                "x-version"=> 3, // for auth version 3.0 only
                "Authorization"=>$authtoken["authtoken"],
                "content-type"=>"application/json",
            );
            $body = array(
                "orders"=>$order_ids
            );

            $postData = json_encode($body);

            $args = array(
                'body' => $postData,
                'headers' => $headers
            );

            $url = self::API_BASE_URL . self::API_BULK_TRACK_BY_ORDER_ID;

            $response = wp_remote_post( $url, $args );

            $body = wp_remote_retrieve_body( $response );

            $resp = json_decode($body,true);
            return !isset($resp["error"])?$resp:null;
            //return $resp;
        }


        // ob_start();
        // var_dump($request);
        // $result = ob_get_clean();

        // error_log($result);

        return null;
    }

    public function get_order_tracking($order_id){
        $resp = $this->get_orders_tracking(array($order_id));
        if(isset($resp[$order_id])){
            return $resp[$order_id];
        }
        return null;
    }

    public function init_model($data, $order_id){
        
        $obj = new Bt_Sync_Shipment_Tracking_Shipment_Model();  
        $obj->shipping_provider = 'shyplite';
        $obj->order_id = $order_id;    
        if(!isset($data["error"])){
            $obj->awb = sanitize_text_field($data["awbNo"]);
            $obj->courier_name = sanitize_text_field($data["carrierName"]);
            $obj->etd = sanitize_text_field($data["allData"]["expectedDeliveryDate"]);
            $obj->scans = $data["events"];
            $last_status_code = end($data["events"])["status"];
            if(!empty($last_status_code) && isset(self::TRACKING_EVENT_STATUS_CODES[strtoupper($last_status_code)])){
                $obj->current_status = self::TRACKING_EVENT_STATUS_CODES[strtoupper($last_status_code)];
            }else{
                $obj->current_status = $last_status_code;
            }
        }else{
            $bt_shipment_tracking_old = Bt_Sync_Shipment_Tracking_Shipment_Model::get_tracking_by_order_id($order_id);            
            $obj->current_status = 'unknown';
            $obj->awb = $bt_shipment_tracking_old->awb;
        }
        if (strtolower($obj->current_status) == "delivered" && empty($obj->delivery_date)) {
            $obj->delivery_date = date('Y-m-d');
        }        
        
        return $obj;
    }

    public function update_order_shipment_status($order_id){
        if(!empty($awb_number = Bt_Sync_Shipment_Tracking_Shipment_Model::get_awb_by_order_id($order_id))){
            $resp= $this->get_order_tracking_by_awb($awb_number);
        }else{
            $resp= $this->get_order_tracking($order_id);
        }        
        
		if(!empty($resp)){
			$shipment_obj = $this->init_model($resp, $order_id);
            Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);           
			return $shipment_obj;
        }
        return null;
    }

    public function bulk_update_order_shipment_status($orderids){
        //to do... track using awbs for orders having awbs set.
        $objs=array();
        if($orderids && sizeof($orderids)>0){
            $orderids = array_map('strval',$orderids);
            $array_chunks = array_chunk($orderids, 50);

            $tracking=array();

            foreach ($array_chunks as $ck) {
                $tk=$this->get_orders_tracking($ck);
                if($tk!=null){
                    $tracking = $tracking + $tk;
                }
            }

            foreach ($tracking as $order_id => $track) {
                if(!isset($track['awbNo'])) continue;
                $shipment_obj = $this->init_model($track, $order_id);
                Bt_Sync_Shipment_Tracking_Shipment_Model::save_tracking($order_id,$shipment_obj);
                $objs[]=$shipment_obj;
            }
        }

        return $objs;
    }


}
