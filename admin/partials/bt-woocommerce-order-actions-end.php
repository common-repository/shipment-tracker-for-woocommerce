<?php
if(!$post_id){
    global $post_id;
}
        $bt_shipment_tracking = Bt_Sync_Shipment_Tracking_Shipment_Model::get_tracking_by_order_id($post_id);
        $bt_shipping_provider = $bt_shipment_tracking->shipping_provider;
        $all_providers = BT_SHIPPING_PROVIDERS_WITH_NONE;
        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        foreach ($all_providers as $key => $value) {
            if(!is_array($enabled_shipping_providers) || !in_array($key,$enabled_shipping_providers)){
                if($key=='none') continue;
                unset($all_providers[$key]);
            }
        }
        // echo var_dump($enabled_shipping_providers); die;
	?>
<div class="wide" id="bt_sst_actions" style="column-span: all;">
    <label>Shipping Provider</label>
        <input type="hidden" name="wc_order_action" value="update_bt_sst_shipping_provider"></input>
        <select name="wc_order_action_bt_sst_shipping_provider" style="width: 80%;box-sizing: border-box;float: left;">
            <?php
            $shipping_mode_is_manual_or_ship24 = carbon_get_theme_option('bt_sst_enabled_custom_shipping_mode');
            // $shipping_mode_is_manual_or_ship24 = Bt_Sync_Shipment_Tracking::bt_sst_get_order_meta($post_id, '_bt_sst_custom_shipping_mode', true);
            foreach ($all_providers as $key => $title) { 
                if ($key == "manual" && $shipping_mode_is_manual_or_ship24 == "manual") { ?>
                    <option <?php selected($key, $bt_shipping_provider, true); ?> value="<?php echo esc_attr($key); ?>">
                        <?php echo esc_html($title . " (Manual)"); ?>
                    </option>
                <?php } else if ($key == "manual" && $shipping_mode_is_manual_or_ship24 == "ship24") { ?>
                    <option <?php selected($key, $bt_shipping_provider, true); ?> value="<?php echo esc_attr($key); ?>">
                        <?php echo esc_html($title . " (Ship24)"); ?>
                    </option>
                <?php } else { ?>
                    <option <?php selected($key, $bt_shipping_provider, true); ?> value="<?php echo esc_attr($key); ?>">
                        <?php echo esc_html($title); ?>
                    </option>
                <?php }
            } ?>
        </select>
	    <button style="box-sizing: border-box;float: right;" class="button wc-reload"><span><?php esc_html_e( '>', 'woocommerce' ); ?></span></button>
</div>
