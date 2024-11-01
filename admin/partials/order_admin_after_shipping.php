<?php 
if(isset($order_id)){
    $bt_shipment_tracking = Bt_Sync_Shipment_Tracking_Shipment_Model::get_tracking_by_order_id($order_id);
    $bt_shipping_provider = $bt_shipment_tracking->shipping_provider;
}
?>
<br class="clear" />
<div class="address">
    <b>Shipping Provider:</b> <?php echo $bt_shipping_provider; ?>
</div>
<div>
    <?php if($bt_shipping_provider=="shiprocket" && wc_get_order( $order_id )->has_status('processing')) : 
        global $pagenow;
        $current_page = admin_url(sprintf($pagenow . '?%s', http_build_query(array_merge($_GET,array("bt_push_to_shiprocket"=>true)))));    
      //  $current_page .= http_build_query(array("bt_push_to_shiprocket"=>true))
    ?>
        <a href="<?= $current_page ?>">Push Now</a>
    
    <?php elseif($bt_shipping_provider=="shipmozo" && wc_get_order( $order_id )->has_status('processing')) : 
    global $pagenow;
    $current_page = admin_url(sprintf($pagenow . '?%s', http_build_query(array_merge($_GET,array("bt_push_to_shipmozo"=>true)))));    
    //  $current_page .= http_build_query(array("bt_push_to_shiprocket"=>true))
    ?>
     <a href="<?= $current_page ?>">Push Now</a>
    <?php elseif($bt_shipping_provider=="nimbuspost_new" && wc_get_order( $order_id )->has_status('processing')) : 
    global $pagenow;
    $current_page = admin_url(sprintf($pagenow . '?%s', http_build_query(array_merge($_GET,array("bt_push_to_nimbuspost_new"=>true)))));    
    //  $current_page .= http_build_query(array("bt_push_to_shiprocket"=>true))
    ?>
     <a href="<?= $current_page ?>">Push Now</a> 

     <?php elseif($bt_shipping_provider == "delhivery" && wc_get_order($order_id)->has_status('processing')): 
    global $pagenow;
    $current_page = admin_url(sprintf($pagenow . '?%s', http_build_query(array_merge($_GET, array("bt_push_to_delhivery" => true)))));    
?>
    <a href="<?= $current_page ?>">Push Now</a>
     <?php endif ?>

     <!-- http://localhost/minesite/wp-admin/admin.php?page=wc-orders&amp;action=edit&amp;id=141&amp;message=1&amp;bt_push_to_delhivery=1 -->
</div>
<div class="edit_address">
	<?php
        $all_providers = BT_SHIPPING_PROVIDERS_WITH_NONE;
        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        foreach ($all_providers as $key => $value) {
            if(!is_array($enabled_shipping_providers) || !in_array($key,$enabled_shipping_providers)){
                if($key=='none') continue;
                unset($all_providers[$key]);
            }
        }

        woocommerce_wp_select([
            'id'       => '_bt_shipping_provider',
            'label'    => __( 'Shipping Provider: ', 'woocommerce' ),
            'selected' => true,
            'value'    => $bt_shipping_provider,
            'options' => $all_providers
        ]);

	?>
</div>
<br class="clear" />