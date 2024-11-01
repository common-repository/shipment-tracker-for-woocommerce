<?php
    
    $bt_shipping_manual_tracking_url = $bt_shipment_tracking->tracking_url;
    $bt_shipment_tracking = (array)$bt_shipment_tracking;

    $cour_n = carbon_get_theme_option("bt_sst_manual_courier_name");
    $awb_n = carbon_get_theme_option("bt_sst_manual_awb_number");
    if(!isset($order_id)){
        $order_id=isset($_GET['post']) ? $_GET['post'] : $_GET['id'];
    }
    $awb_n = isset($awb_n) ? $awb_n : '';
    $awb_n = str_replace('#order_id#', $order_id, $awb_n);

?>
<input type="hidden" name="order_id" value="<?= $order_id ?>"/>
<p class="form-field ">
    <label for="bt_manual_courier_name">Courier Name *</label>
    <input type="text" class="short" style="" name="bt_manual_courier_name" id="bt_manual_courier_name" value="<?php echo (isset($bt_shipment_tracking['courier_name']) && !empty($bt_shipment_tracking['courier_name'])) ? $bt_shipment_tracking['courier_name'] : ''; ?>" placeholder="<?= $cour_n ?>">
</p>
<p class="form-field ">
    <label for="bt_manual_awb_number">AWB Number</label>
    <input type="text" class="short" style="" name="bt_manual_awb_number" id="bt_manual_awb_number" value="<?php echo (isset($bt_shipment_tracking['awb'])&& !empty($bt_shipment_tracking['awb'])) ? $bt_shipment_tracking['awb'] : ''; ?>" placeholder="<?= $awb_n ?>">
</p>
<p class="form-field ">
    <?php
    if (class_exists('WooCommerce')) {
        require_once ABSPATH . 'wp-content/plugins/woocommerce/includes/admin/wc-meta-box-functions.php';
    }
    
        woocommerce_wp_select([
            'class'             => 'select short',
            'style'             => 'width:100%;',
            'id'       => 'bt_manual_shipping_status',
            'label'    => __( 'Shipping Status ', 'woocommerce' ),
            'selected' => true,
            'value'    => isset($bt_shipment_tracking['current_status'])?$bt_shipment_tracking['current_status']:"",
            'options' => apply_filters( 'bt_sst_shipping_statuses', BT_SHIPPING_STATUS )
        ]);

	?>
    <!-- <input type="text" class="short" style="" name="bt_manual_shipping_status" id="bt_manual_shipping_status" value="<?php //echo $bt_shipment_tracking['current_status'] ? $bt_shipment_tracking['current_status'] : ''; ?>" placeholder="Enter current shipping status"> -->
</p>
<p class="form-field ">
    <label for="bt_manual_etd">Estimated Delivery Date</label>
    <input type="date" class="short" style="" name="bt_manual_etd" id="bt_manual_etd" value="<?php echo isset($bt_shipment_tracking['etd']) ? $bt_shipment_tracking['etd'] : ''; ?>" placeholder="Enter expected delivery date">
</p>
<p class="form-field ">
    <label for="bt_manual_tracking_link">Tracking Link</label>
    <textarea placeholder="Enter order tracking Link"  name="bt_manual_tracking_link" id="bt_manual_tracking_link" ><?php echo !empty($bt_shipping_manual_tracking_url) ? $bt_shipping_manual_tracking_url : ''; ?></textarea>
    <small>Leave empty to use Global Tracking URL.</small>
</p>
<span class="spinner"></span> <button type="button" id="bt_manual_save" class="button" href='#'>Save</button>

<script>
    jQuery('#bt_manual_save').click(function () {
        var bt_manual_courier_name = jQuery('#bt_manual_courier_name').val();
        // if(bt_manual_courier_name == '' ) {
        //     // alert('Courier name is required');
        //     // return false;
        // }
        jQuery('#bt_manual_save').addClass("disabled");
        jQuery('#bt_sync-box .spinner').addClass("is-active");
        jQuery.ajax({
            method: "POST",
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: "json",
            data: {
                'order_id': '<?php echo $order_id; ?>',
                'courier_name': bt_manual_courier_name,
                'awb_number':  jQuery('#bt_manual_awb_number').val(),
                'shipping_status': jQuery('#bt_manual_shipping_status').val(),
                'etd': jQuery('#bt_manual_etd').val(),
                'tracking_link': jQuery('#bt_manual_tracking_link').val(),
                'action': 'bt_tracking_manual'
            }, success: function (response) {
                jQuery('#bt_manual_save').removeClass("disabled");
                jQuery('#bt_sync-box .spinner').removeClass("is-active");
                if (response != null && response.status != false) {
                    location.reload();  //Reload the page if response received
                } else {
                    alert(response.response);
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                jQuery('#bt_manual_save').removeClass("disabled");
                jQuery('#bt_sync-box .spinner').removeClass("is-active");
                alert('Something went wrong! Error: ' + errorThrown);
                return false;
            }
        });
    });
</script>
