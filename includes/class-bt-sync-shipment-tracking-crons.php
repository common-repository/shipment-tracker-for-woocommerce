<?php

class Bt_Sync_Shipment_Tracking_Crons {

    const BT_MINUTELY_JOB="bt_minutely_job";
    const BT_15MINS_JOB="bt_every_15_minutes_job";
    //const BT_30MINS_JOB="bt_every_30_minutes_job";
    const BT_1HOUR_JOB="bt_every_1_hour_job";
    const BT_4HOURS_JOB="bt_every_every_4_hours_job";
    const BT_DAILY_JOB="bt_daily_job";

    private $shiprocket;
    private $shipmozo;
    private $nimbuspost_new;
    private $shyplite;
    private $licenser;
    private $delhivery;
	
	public function __construct($shiprocket,$shyplite,$nimbuspost_new,$shipmozo,$licenser,$delhivery) {
		$this->shiprocket = $shiprocket;
        $this->shipmozo = $shipmozo;
        $this->nimbuspost_new = $nimbuspost_new;
        $this->shyplite = $shyplite;
        $this->licenser = $licenser;
        $this->delhivery = $delhivery;
    }
    
    public function schedule_recurring_events(){

        if (! wp_next_scheduled( self::BT_MINUTELY_JOB ) ) {
            // wp_schedule_event( time(), 'minutely', self::BT_MINUTELY_JOB );
        }

        if (! wp_next_scheduled( self::BT_15MINS_JOB ) ) {
            wp_schedule_event( time(), 'every_15_minutes', self::BT_15MINS_JOB );
        }

        if (! wp_next_scheduled( self::BT_1HOUR_JOB ) ) {
            wp_schedule_event( time(), 'every_1_hour', self::BT_1HOUR_JOB );
        }
        if (! wp_next_scheduled( self::BT_4HOURS_JOB ) ) {
            wp_schedule_event( time(), 'every_4_hours', self::BT_4HOURS_JOB );
        }
        if (! wp_next_scheduled( self::BT_DAILY_JOB ) ) {
            wp_schedule_event( time(), 'daily', self::BT_DAILY_JOB );
        }
    }

    private function sync_shyplite_shipments(){
        $orderids = $this->get_orders('shyplite');
        $objs = $this->shyplite->bulk_update_order_shipment_status($orderids);
        return $objs;
    }
    private function sync_shiprocket_shipments(){
        $orderids = $this->get_orders('shiprocket');
        //error_log("will sync shiprocket: " . json_encode($orderids));
        foreach($orderids as $o){
            $bt_shipment_tracking = Bt_Sync_Shipment_Tracking_Shipment_Model::get_tracking_by_order_id($o);
            //error_log("6. old data: " . json_encode($bt_shipment_tracking));
            //error_log("7. ". stripos($bt_shipment_tracking->current_status, "delivered"));
            if(empty($bt_shipment_tracking) || empty($bt_shipment_tracking->current_status) || stripos($bt_shipment_tracking->current_status, "delivered") === false){
                $objs = $this->shiprocket->update_order_shipment_status($o);
                //error_log("synced shiprocket: " . json_encode($objs));
            }
        }
    }

    private function sync_delhivery_shipments(){
        $orderids = $this->get_orders('delhivery');
        foreach($orderids as $o){
            $bt_shipment_tracking = Bt_Sync_Shipment_Tracking_Shipment_Model::get_tracking_by_order_id($o);
            if(empty($bt_shipment_tracking) || empty($bt_shipment_tracking->current_status) || stripos($bt_shipment_tracking->current_status, "delivered") === false){
                $objs = $this->delhivery->update_order_shipment_status($o);
            }
        }
    }

    private function sync_shipmozo_shipments(){
        $orderids = $this->get_orders('shipmozo');
       
        foreach($orderids as $o){
            $bt_shipment_tracking = Bt_Sync_Shipment_Tracking_Shipment_Model::get_tracking_by_order_id($o);
            if(empty($bt_shipment_tracking) || empty($bt_shipment_tracking->current_status) || stripos($bt_shipment_tracking->current_status, "delivered") === false){
                $objs = $this->shipmozo->update_order_shipment_status($o);
            }
        }
    }
    private function sync_nimbuspost_new_shipments(){
        $orderids = $this->get_orders('nimbuspost_new');
        foreach($orderids as $o){
            $bt_shipment_tracking = Bt_Sync_Shipment_Tracking_Shipment_Model::get_tracking_by_order_id($o);
            if(empty($bt_shipment_tracking) || empty($bt_shipment_tracking->current_status) || stripos($bt_shipment_tracking->current_status, "delivered") === false){
                $objs = $this->nimbuspost_new->update_order_shipment_status($o);
               // error_log(json_encode($objs));
            }
        }
    }

    private function get_orders($provider){
        $order_statuses = carbon_get_theme_option('bt_sst_order_statuses_to_sync');
        $orders_date = carbon_get_theme_option('bt_sst_sync_orders_date');
        $fromTime = date("Y-m-d", strtotime("-$orders_date day"));
    
        
        // Create an array of arguments for the WC_Order_Query
        $args = array(
            'limit'        => 50,
            'date_created' => '> ' .  $fromTime,
            'orderby'      => 'date',
            'order'        => 'DESC',
            'return' => 'ids',
            'meta_query' => array( // Array for meta data query
                array(
                    'key' => '_bt_shipping_provider', // Replace with your actual meta key
                    'value' => $provider, // Replace with the desired meta value
                    'compare' => '=' // Comparison operator (e.g., '=', '!=', 'LIKE', etc.)
                )
            )
        );
        if(!in_array('any', $order_statuses)){
            $args["status"] = $order_statuses;
        }

        $query = new WC_Order_Query($args);
        $order_ids = $query->get_orders();
        return $order_ids;
    }
    
	
    private function validate_license(){
        $license = $this->licenser->get_license();
        if($license!=null && isset($license['is_active']) && $license['is_active']==true){
            //revalidate from api
            $user=$license['user'];
            $password=$license['password'];
            $received_data = $this->licenser->get_premium_user_data_by_user_password($user, $password);
		
            if(isset($received_data['status']) && $received_data['status']==true) {
                $this->licenser->save_license($user, $password, true);
            }else if(isset($received_data['status'])  && $received_data['status']==false){
                //license is not active, save to db
                $this->licenser->save_license($user, $password, false);
            }
		
        }else{
            //do nothing.
        }
    }

    public function minutely_job(){
        //error_log("1min");
        $this->do_sync("1mins");
    }
    public function bt_every_15_minutes_job(){
        //error_log("15mins");
        $this->do_sync("15mins");
    }
    public function bt_every_1_hour_job(){
        //error_log("1hour");
        $this->do_sync("1hour");
    }
    public function bt_every_every_4_hours_job(){
        //error_log("4hours");
        $this->do_sync("4hours");
    }
    public function bt_daily_job(){
        //error_log("24hours");
        $this->do_sync("24hours");
        //$this->validate_license();
    }

    private function do_sync($cron_freq){
        $is_premium = $this->licenser->is_license_active();
        if(!$is_premium){
            return;
        }
        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        if(is_array($enabled_shipping_providers) && in_array('shipmozo',$enabled_shipping_providers)){
            $bt_sst_shipmozo_cron_schedule=carbon_get_theme_option( 'bt_sst_shipmozo_cron_schedule' );
            if( $bt_sst_shipmozo_cron_schedule==$cron_freq){
                $this->sync_shipmozo_shipments();
            }
        }
        if(is_array($enabled_shipping_providers) && in_array('shiprocket',$enabled_shipping_providers)){
            $bt_sst_shiprocket_cron_schedule=carbon_get_theme_option( 'bt_sst_shiprocket_cron_schedule' );
            if( $bt_sst_shiprocket_cron_schedule==$cron_freq){
                $this->sync_shiprocket_shipments();
            }
        }
        if(is_array($enabled_shipping_providers) && in_array('delhivery',$enabled_shipping_providers)){
            $bt_sst_delhivery_cron_schedule=carbon_get_theme_option( 'bt_sst_delhivery_cron_schedule' );
            if( $bt_sst_delhivery_cron_schedule==$cron_freq){
                $this->sync_delhivery_shipments();
            }
        }
        $bt_sst_nimbuspost_new_cron_schedule=carbon_get_theme_option( 'bt_sst_nimbuspost_new_cron_schedule' );
        if( $bt_sst_nimbuspost_new_cron_schedule==$cron_freq){
            $this->sync_nimbuspost_new_shipments();
        }
        $bt_sst_shyplite_cron_schedule=carbon_get_theme_option( 'bt_sst_shyplite_cron_schedule' );
        if( $bt_sst_shyplite_cron_schedule==1){
            $this->sync_shyplite_shipments();
        }
    }

    public function twicedaily_job(){
        $this->validate_license();
    }

}
