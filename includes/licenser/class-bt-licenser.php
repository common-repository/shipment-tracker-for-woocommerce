<?php

/**
 * The manual-specific functionality of the plugin.
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/manual
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
class Bt_Licenser {
    private $license_object;

	public function __construct() {

        $this->license_object = $this->get_license();
        
    }

    function get_premium_user_data_by_user_password($user, $password) {

		$r = array(
			"status"=>false,
			"message"=>""
		);
		
		$site_url = get_site_url();
		$url = 'https://webviewguardapis.bitss.tech/api/alicenser/ValidateDomain?email='. $user .'&pass='. $password .'&domain='. $site_url;

		$response = wp_remote_get($url);
		if ( ! is_wp_error( $response ) ) {
			$body     = wp_remote_retrieve_body( $response );
			$resp = json_decode($body,true);
			if($resp["status"]){
				$r["status"] = true;
				$r["message"] = $resp["data"];
			}else{
				
				$r["message"] = $resp["error"]["message"];
			}
		}else{
			$r = null;//probably api error, do nothing.
		}
		

		return $r;
	}

	function save_license($user_email, $password, $is_premium) {
		$d = array(
			'user' => $user_email, 
			'password' => $password, 
			'is_active' => $is_premium
		);
       
		$d = json_encode($d);
		$base64 = base64_encode($d);
		update_option('bt_sst_is_premium', $base64);
        $this->license_object = $d;
	}

	function get_license() {

		if($this->license_object !=null){
            return $this->license_object;
        }

		$obj = array(
			'user' => '', 
			'password' => '', 
			'is_active' => false
		);
		$data = get_option('bt_sst_is_premium');
		
		if ($data != false) {
			try {
				$json = base64_decode($data);
				$obj = json_decode($json,true);

			} catch(Exception $e) {
				
			}		
		}
		return $obj;
	}
	
	function is_license_active() {
		$premium = $this->get_license();
		$premium = isset($premium['is_active'])?$premium['is_active']:false;
		//$premium=true;
		return $premium;
	}

	function should_activate_premium_features() {
		$premium = $this->is_license_active();
		$is_admin = current_user_can( 'manage_options' );

		return $premium || $is_admin;
	}

}
