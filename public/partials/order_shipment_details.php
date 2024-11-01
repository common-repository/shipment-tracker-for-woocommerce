<div>
    <?php
        $bt_sst_shipment_info_show_fields = carbon_get_theme_option( 'bt_sst_shipment_info_show_fields' );
  
		$shipment_status = in_array('shipment_status',$bt_sst_shipment_info_show_fields);
		$estimate_date =  in_array('edd',$bt_sst_shipment_info_show_fields); 
		$courier_name = in_array('courier_name',$bt_sst_shipment_info_show_fields); 
		$awb_number = in_array('awb_number',$bt_sst_shipment_info_show_fields);  
		$tracking_link =  in_array('tracking_link',$bt_sst_shipment_info_show_fields);  

        if(!empty($bt_shipment_tracking) && $bt_shipment_tracking instanceof Bt_Sync_Shipment_Tracking_Shipment_Model && !empty($bt_shipment_tracking->awb)){
            try{
                if ($shipment_status && $bt_shipment_tracking->current_status) {
                    echo esc_html(bt_format_shipment_status($bt_shipment_tracking->current_status)) . "<br>";
                }
                if ($estimate_date &&  $bt_shipment_tracking->etd) {
                    echo "ETD: " . esc_html($bt_shipment_tracking->etd) . "<br>";
                }
                if ($courier_name &&  $bt_shipment_tracking->courier_name) {
                    echo "Courier: " .esc_html( $bt_shipment_tracking->courier_name ). "<br>";
                }
                if ($awb_number && $bt_shipment_tracking->awb) {
                    echo "Awb: " . esc_html($bt_shipment_tracking->awb) . "<br>" ;
                }
                if ($tracking_link && !empty($bt_shipment_tracking->get_tracking_link())) {
                    echo "<a target='_blank' href='" . esc_url($bt_shipment_tracking->get_tracking_link()) . "'>Track</a>" ;
                }
            }catch(Exception $e){
                echo '<small>NA</small>';
            }
        }					
        else
            echo '<small>NA</small>';
    ?>
</div>