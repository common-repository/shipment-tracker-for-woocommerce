<?php


class Bt_Sync_Shipment_Tracking_Admin_Ajax_Functions{
    private $shiprocket;
    private $shyplite;
    private $crons;
    private $nimbuspost;
    private $manual;
    
    public function __construct( $crons,$shiprocket,$shyplite,$nimbuspost,$manual,$licenser ) {
        $this->crons = $crons;
        $this->shiprocket = $shiprocket;
        $this->shyplite = $shyplite;
        $this->nimbuspost = $nimbuspost;
        $this->manual = $manual;
    }

    public function bt_sync_now_shyplite(){
        $obj = $this->crons->sync_shyplite_shipments();

        $resp = array(
            "status"=>true,
            "orders_count"=>sizeof($obj)
        );
        echo json_encode($resp);
        wp_die();
    }

    public function force_sync_tracking(){
        $resp = array(
            "status" => false,
            "response" => ''
        );

        if(empty($order_id = $_POST['order_id'])){
            $resp = array(
                "status" => false,
                "response" => 'Invalid order id.'
            );
            wp_send_json($resp);
            wp_die();
        }
        
        try {
            $tracking_resp = bt_force_sync_order_tracking($order_id);
            if(!empty($tracking_resp)) {
                $resp['status'] = true;
                $resp['response'] = $tracking_resp;
            }else{
                $resp['status'] = false;
                $resp['response'] = "Unable to get latest shipment data, please check plugin settings or contact plugin support for help.";
            }
        }
        catch(Exception $e) {
            $resp["response"] = $e->getMessage();
            $resp["status"] = false;
        }


        wp_send_json($resp);
        wp_die();
    }

    public function save_order_awb_number(){
        $resp = array(
            "status" => false,
            "response" => ''
        );

        if(empty($order_id = $_POST['order_id'])){
            $resp = array(
                "status" => false,
                "response" => 'Invalid order id.'
            );
            wp_send_json($resp);
            wp_die();
        }

        if(empty($awb_number = $_POST['awb_number'])){
            $resp = array(
                "status" => false,
                "response" => 'Invalid AWB number.'
            );
            wp_send_json($resp);
            wp_die();
        }

        $shipping_mode_is_manual_or_ship24 = carbon_get_theme_option( 'bt_sst_enabled_custom_shipping_mode' );
		// $shipping_mode_is_manual_or_ship24 = Bt_Sync_Shipment_Tracking::bt_sst_get_order_meta($order_id, '_bt_sst_custom_shipping_mode', true);
		$shipping_provider = Bt_Sync_Shipment_Tracking::bt_sst_get_order_meta($order_id, '_bt_shipping_provider', true);

        if($shipping_mode_is_manual_or_ship24=='ship24' && $shipping_provider == "manual"){
            // echo "<pre>"; print_r($_POST['corier_code_and_name']); die;
            if(empty($corier_code = $_POST['corier_code'])){
                $resp = array(
                    "status" => false,
                    "response" => 'Invalid Courier code.'
                );
                wp_send_json($resp);
                wp_die();
            }
            if(empty($corier_name = $_POST['corier_name'])){
                $resp = array(
                    "status" => false,
                    "response" => 'Invalid Courier name.'
                );
                wp_send_json($resp);
                wp_die();
            }
            Bt_Sync_Shipment_Tracking::bt_sst_update_order_meta($order_id, '_bt_shipping_ship24_corier_name', $corier_name );
            Bt_Sync_Shipment_Tracking::bt_sst_update_order_meta($order_id, '_bt_shipping_ship24_corier_code', $corier_code );
        }

        try {
            Bt_Sync_Shipment_Tracking::bt_sst_delete_order_meta($order_id, '_bt_shipment_tracking' );//fix to delete old shipment data so that new awb number can take effect.
            Bt_Sync_Shipment_Tracking::bt_sst_update_order_meta($order_id, '_bt_shipping_awb', $awb_number );
            bt_force_sync_order_tracking($order_id);
            $resp['status'] = true;
            $resp['response'] = 'Success';
        }
        catch(Exception $e) {
            $resp["response"] = $e->getMessage();
            $resp["status"] = false;
        }


        wp_send_json($resp);
        wp_die();
    }

    public function get_tracking_data_from_db(){

        $resp = array(
            "status" => false,
            "message" => '',
            'data'  => [],
            'has_tracking' => false
        );

        if (empty($_POST) || !wp_verify_nonce($_POST['bt_get_tracking_form_nonce'],'bt_get_tracking_data') )
        {
            $resp['message'] = 'Sorry, you are not allowed.';
            wp_send_json($resp);
            wp_die();
        }


       $the_order = wc_get_order($_POST['order_id']);
        if(empty($the_order)){
            $resp['message'] = 'Order not found!';
            wp_send_json($resp);
            wp_die();
        }

        $resp['status'] = true;
        $resp['data']['order_status'] = $the_order->get_status();

        $bt_shipment_tracking =Bt_Sync_Shipment_Tracking_Shipment_Model::get_tracking_by_order_id($_POST['order_id']);

        if(!empty($bt_shipment_tracking)) {
            $resp['has_tracking'] = isset($bt_shipment_tracking->awb)&&!empty($bt_shipment_tracking->awb);
            $resp['data']['obj'] = $bt_shipment_tracking;
            $resp['data']['tracking_link'] = $bt_shipment_tracking->get_tracking_link();
        } else {
            $resp['message'] = 'Tracking of this order is not available yet.';
        }

        wp_send_json($resp);
        wp_die();
    }

    public function bt_tracking_manual(){
        $resp = array(
            "status" => false,
            "response" => ''
        );

        try {
            $resp["response"] = $this->manual->update_data($_POST['order_id'], $_POST);
            $resp["status"] = true;
        }
        catch(Exception $e) {
            $resp["response"] = $e->getMessage();
            $resp["status"] = false;
        }

        wp_send_json($resp);
        wp_die();
    }

    public function post_customer_feedback_to_sever() {
        $current_user = wp_get_current_user();
        $body = array(
            'your-message'    => esc_html($_POST['feedback']),
            'your-name'    => esc_html( $current_user->display_name ),
            'your-subject'    => "Plugin Feedback from " . get_site_url(),
            'your-email'    => esc_html(get_bloginfo('admin_email')),
        );

        $base_url="https://shipment-tracker-for-woocommerce.bitss.tech";
        $cfid=4;
        $resp = $this->post_cf7_data($body,$cfid,$base_url );

        //echo json_encode($resp);
        return;
    }

    private function post_cf7_data($body,$cfid,$base_url ){
        // Same user agent as in regular wp_remote_post().
        $userAgent = 'WordPress/' . get_bloginfo('version') . '; ' . get_bloginfo('url');
        // Note that Content-Type wrote in a bit different way.
        $header = ['Content-Type: multipart/form-data'];
    
        $apiUrl = "$base_url/wp-json/contact-form-7/v1/contact-forms/$cfid/feedback";

        $curlOpts = [
            // Send as POST
            CURLOPT_POST => 1,
            // Get a response data instead of true
            CURLOPT_RETURNTRANSFER => 1,
            // CF7 will reject your request as spam without it.
            CURLOPT_USERAGENT => $userAgent,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $body,
        ];

        $ch = curl_init($apiUrl);          // Create a new cURL resource.
        curl_setopt_array($ch, $curlOpts); // Set options.
        $response = curl_exec($ch);        // Grab response.

        if (!$response) {
            // Do something if an error occurred.
        } else {
            $response = json_decode($response);
            // Do something with the response data.
        }

        // Close cURL resource, and free up system resources.
        curl_close($ch);

        return  $response ;

    }

}
