<?php

/**
 * Fired during plugin activation
 *
 * @link       https://amitmittal.tech
 * @since      1.0.0
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/includes
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
class Bt_Sync_Shipment_Tracking_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	    //store plugin activation time
        add_option( '_bt_sst_activated_time', time(), '', false );
		$enabled_shipping_providers = get_option( '_bt_sst_enabled_shipping_providers' );
		if(!$enabled_shipping_providers){
			update_option('_bt_sst_enabled_shipping_providers|||0|value', 'manual');
			update_option('_bt_sst_enabled_custom_shipping_mode', "manual");
			update_option('_bt_sst_default_shipping_provider', "manual");
		}
	}

}
