
<?php
if(!$order_id){
    $order_id=isset($_GET['post']) ? $_GET['post'] : $_GET['id'];
}
$shipping_mode_is_manual_or_ship24 = carbon_get_theme_option( 'bt_sst_enabled_custom_shipping_mode' );
// $shipping_mode_is_manual_or_ship24 = Bt_Sync_Shipment_Tracking::bt_sst_get_order_meta($order_id, '_bt_sst_custom_shipping_mode', true);
$coriure_name = get_option('_bt_sst_ship24_active_courier_companies');
// echo "vishnu<pre>"; print_r($coriure_name); echo "</pre>";

?>
<div id="bt_sst_check_already_exist">

<div id="bt_sst_awbPopup" class="bt_sst_popup">
    <div class="bt_sst_popup-content">
        <span id="bt_sst_closePopup" class="bt_sst_close">&times;</span>
        <h2>Courier Details</h2>
        <div id="">
            <div>
                <div>
                    <label for="">AWB:</label>
                </div>
                <input type="text" id="bt_sst_ship24_awb_field" name="bt_sst_ship24_awb_field" class="bt_sst_ship24_input">
            </div>
            <div id="bt_sst_ship24_corier_data">
                <div>
                    <label for="">Courier:</label>
                </div>
                <select style="width:100%" name="bt_sst_ship24_couriers_list" id="bt_sst_ship24_couriers_name" class="bt_sst_ship24_input">
                    <option value="">Select Courier</option>
                    <?php
                    if(is_array($coriure_name) && count($coriure_name)>1){
$courierCodeName = [];
foreach ($coriure_name as $key => $courier) {
    $courierCodeName = [
        'corier_code' => $courier['courierCode'],
        'corier_name' => $courier['courierName'],
    ];
    $courierCodeAndName = json_encode($courierCodeName);
    ?>
    <option value='<?php echo $courierCodeAndName?>' data-courierName='<?php echo $courier['courierName']?>'><?php echo $courier['courierName']?></option>
<?php } }else{?>
                    <option value="">Loading.........</option>  
                    <?php } ?>                                                                       
                </select>
            </div>
            <br>
            <button type="button" id="save_manual" class="button save_order" href='#'>SAVE</button>
        </div>
    </div>
</div>
</div>

<span class="spinner"></span> 

<div class="inside">

    <?php if(!empty($bt_shipment_tracking->current_status)){ ?>  		
        <div>
            <h3><?php echo bt_format_shipment_status($bt_shipment_tracking->current_status); ?></h3>
            <small>via</small> <?php echo $bt_shipment_tracking->courier_name; ?>
        </div>
    <?php } ?>
    <?php if(!empty($bt_shipment_tracking->etd)){ ?>
  		<br>
        <div>
            ETD: <?php echo $bt_shipment_tracking->etd; ?>
        </div>
    <?php } ?>    

    <?php if(!empty($bt_shipping_awb_number)){ ?>
  		<br>
        <div>
            AWB# <a target="_blank" href="<?php echo $bt_shipment_tracking->get_tracking_link(); ?>"><?php echo $bt_shipping_awb_number; ?></a> 
            <?php if($bt_shipping_provider != "xpressbees"){ ?>
                <a id="add_awb_number" class="awb_number"><span class="dashicons dashicons-edit"></span></a> 
            <?php } ?>  
        </div>
    <?php }else{ ?>
       
        <br>
        <div>
            AWB# -- <a id="add_awb_number" class="awb_number"><span class="dashicons dashicons-edit"></span></a> 
        </div>
    <?php } ?>
    <?php if(!empty($bt_shipping_provider)){ ?>
  		<br>
        <div>
            Logistic Partner: <?php echo $bt_shipping_provider; ?>
        </div>
    <?php } ?>
    <a id="bt_notify_popup" style="display:none;" href="#TB_inline?&width=200&height=150&inlineId=bt_notify_popup_content" class="thickbox"></a>
    <div id="bt_notify_popup_content" style="display:none;">
    <div style="text-align:center">        
        <h2 id="bt_notify_popup_content_title">
            .. 
        </h2>
        <h4>Click OK to refresh the page.</h4>
        <button class="button button-primary align-center" onclick="location.reload()">OK</button>
    </div>
</div>
  	<br>

    <?php 
    $get_awb_no = Bt_Sync_Shipment_Tracking::bt_sst_get_order_meta( $order_id, '_bt_shipping_awb', true );

    if($bt_shipping_provider != "xpressbees"){ 
        if($bt_shipping_provider == "manual" && $shipping_mode_is_manual_or_ship24 == "ship24" && !$get_awb_no){
        ?>
        <button type="button" id="add_awb_no_in_ship24" class="button save_order" href='#'>Add AWB No.</button>
        <?php }else{ ?>
            <button type="button" id="sync_manual" class="button save_order" href='#'>Sync Tracking Now</button>
            <?php if($get_awb_no && $bt_shipping_provider=='shiprocket' || $bt_shipping_provider=='delhivery' || $bt_shipping_provider=='shipmozo' || $bt_shipping_provider == 'nimbuspost_new' || $bt_shipping_provider == 'nimbuspost'){ ?>
                <button type="button"style="margin:5px 0"; id="dawnload_able_pdf" class="button dawnload_able_document" href='#'>Download Label</button>
    <?php }}} ?>
    <?php add_thickbox(); ?>
    <script>
        // jQuery('#bt_sst_ship24_couriers_name').select2({
        //     placeholder: "Select Courier",
        //     allowClear: true
        // });
        jQuery('#bt_sst_awbPopup').hide();
        jQuery('#sync_manual').click(function () {
            jQuery('#sync_manual').addClass("disabled");
            jQuery('#bt_sync-box .spinner').addClass("is-active");

            jQuery.ajax({
                method: "POST",
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                dataType: "json",
                data: {
                    'order_id': '<?php echo $order_id; ?>',
                    'action': 'force_sync_tracking'
                }, success: function (response) {
                 
                    jQuery('#sync_manual').removeClass("disabled");
                    jQuery('#bt_sync-box .spinner').removeClass("is-active");
                    // var error_length = response.status.error;
                    // console.log(response.response[0]);
                    if (response != null && response.status !=false && response.response[0] != false) {
                        if(jQuery.isArray(response.response.errors)){
                            alert(response.response.errors[0].message);
                        }else{
                            bt_st_show_info("Tracking Synced.");
                        }
                    } else {
                        alert(response.response);
                    }
                }, error: function (jqXHR, textStatus, errorThrown) {
                    jQuery('#sync_manual').removeClass("disabled");
                    jQuery('#bt_sync-box .spinner').removeClass("is-active");
                    alert('Something went wrong! Error: ' + errorThrown);
                    return false;
                }
            });
        });
        jQuery('#dawnload_able_pdf').click(function () {
            jQuery('#dawnload_able_pdf').addClass("disabled");

            jQuery.ajax({
                method: "POST",
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                dataType: "json",
                data: {
                    'awbs': ['<?php echo $get_awb_no; ?>'],
                    'order_id': '<?php echo $order_id; ?>',
                    'action': 'download_label_pdf'
                }, success: function (response) {
                    jQuery('#dawnload_able_pdf').removeClass("disabled");
                    // window.location.href = response[0]['pdf_download_link'];
                    if(response && Array.isArray(response)){
                        response.forEach(function(item) {
                                if (item.startsWith('data:image/')) {
                                    var newWindow = window.open();
                                    newWindow.document.write('<img src="' + item + '" />');
                                }else{
                                    window.open(item, '_blank');
                                }
                        });
                    }else{
                        alert(response);
                    }
                    
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Failed To Dawnload Label');
                }
            });
        });
        jQuery('#bt_sst_closePopup').click(function () {
            jQuery('#bt_sst_awbPopup').fadeOut();
        });
        jQuery('#add_awb_no_in_ship24').click(function () {
            jQuery('#bt_sst_awbPopup').show();
        });
        jQuery('#add_awb_number').click(function () {
            if ("<?php echo $shipping_mode_is_manual_or_ship24; ?>" == "ship24" && "<?php echo $bt_shipping_provider; ?>" == "manual") {
                jQuery('#bt_sst_awbPopup').fadeIn();
            }else{
                var current_awb = '<?php echo $bt_shipping_awb_number; ?>';
                var shipment_provider = '<?php echo $bt_shipping_provider; ?>';
    
                var awb_number = prompt("Enter new awb number of " + shipment_provider,current_awb);
                awb_number = awb_number.trim();
    
                if(awb_number==""){
                    return;
                }            
                if(awb_number===current_awb){               
                    return;
                } 
              
    
                jQuery('#add_awb_number').addClass("disabled");
                jQuery('#bt_sync-box .spinner').addClass("is-active");
    
                jQuery.ajax({
                    method: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    dataType: "json",
                    data: {
                        'order_id': '<?php echo $order_id; ?>',
                        'awb_number': awb_number,
                        'action': 'save_order_awb_number'
                    }, success: function (response) {
                        jQuery('#add_awb_number').removeClass("disabled");
                        jQuery('#bt_sync-box .spinner').removeClass("is-active");
                        if (response != null && response.status !=false) {
                            bt_st_show_info("AWB updated & Tracking Synced.");
                        } else {
                            alert(response.response);
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        jQuery('#add_awb_number').removeClass("disabled");
                        jQuery('#bt_sync-box .spinner').removeClass("is-active");
                        alert('Something went wrong! Error: ' + errorThrown);
                        return false;
                    }
                });
            }
        });
        jQuery('#bt_sst_ship24_couriers_name').click(function () {
            var optionCount = jQuery(this).find('option').length;
            if (optionCount === 2) {
                jQuery.ajax({
                    method: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    dataType: "json",
                    data: {
                        'status': true,
                        'action': 'get_coriers_name_for_ship24'
                    },
                    success: function (response) {
                        if(response.data==false){
                            alert('Please Enter API Key');
                        }

                        if (response.success && response.data && !response.data[0]?.message) {
                            var html = '<div>' +
                                '    <div>Courier:<div><select class="bt_sst_ship24_input" name="bt_sst_ship24_couriers_list" id="bt_sst_ship24_couriers_name_select">' +
                                '        <option value="">Select Courier</option>';
                            var coriercode_coriername;
                            jQuery.each(response.data, function (index, courier) {
                                coriercode_coriername = {
                                    corier_code: courier.courierCode,
                                    corier_name: courier.courierName
                                };
                                var corier_code_and_name = JSON.stringify(coriercode_coriername);
                                html += "<option value='" + corier_code_and_name + "' data-courierName='" + courier.courierName + "'>" + courier.courierName + "</option>";
                                corier_code_and_name = "";
                            });
                            html += '    </select>' +
                                '</div>';
                            jQuery('#bt_sst_ship24_corier_data').html(html);

                            // Initialize Select2 on the new select element
                            jQuery('#bt_sst_ship24_couriers_name_select').select2({
                                placeholder: "Select Courier",
                                allowClear: true
                            });
                        }else{
                            alert(response.data[0].message);
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Something went wrong! Error: ' + errorThrown);
                        return false;
                    }
                });
            }
        });
        jQuery('#save_manual').click(function () {
            jQuery('#save_manual').text('Loading...')
            jQuery('#save_manual').text('Loading...').prop('disabled', true);

            var current_awb = jQuery("#bt_sst_ship24_awb_field").val();
            var corier_code_and_name = jQuery("#bt_sst_ship24_couriers_name_select").val();
            if(!corier_code_and_name){
                var corier_code_and_name = jQuery("#bt_sst_ship24_couriers_name").val();
            }
            var courierObject = JSON.parse(corier_code_and_name);
            var corier_code = courierObject.corier_code;
            var corier_name = courierObject.corier_name;
            console.log(corier_code+" "+corier_name)
                jQuery.ajax({
                    method: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    dataType: "json",
                    data: {
                        'order_id': '<?php echo $order_id; ?>',
                        'awb_number': current_awb,
                        'corier_code': corier_code,
                        'corier_name': corier_name,                       
                        'action': 'save_order_awb_number'
                    }, success: function (response) {
                        jQuery("#bt_sst_awbPopup").hide();
                        bt_st_show_info("Yor tracking data will update soon.");


                        // window.location.reload();
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        alert('Something went wrong! Error: ' + errorThrown);
                        return false;
                    }
                });
        });
        function bt_st_show_info(info_text){
            //jQuery('#bt_notify_popup').attr("href","#TB_inline?&width=200&height=150&inlineId=bt_notify_popup_content");
            jQuery('#bt_notify_popup_content_title').text(info_text);
            jQuery('#bt_notify_popup').trigger("click");
        }

    </script>
</div>

<style>
.bt_sst_popup {
    display: none;
    position: fixed;
    z-index: 1000;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
}

.bt_sst_popup-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    position: relative;
}

.bt_sst_close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 20px;
    cursor: pointer;
}
.bt_sst_ship24_input{
    width: 100%;
}



/* Popup Overlay Background */
#bt_notify_popup_ship24 {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
    display: none; /* Hidden by default */
    justify-content: center;
    align-items: center;
    z-index: 9999; /* Ensures it's above other content */
}

/* Popup Content */
#bt_notify_popup_ship24 > div {
    background: #fff; /* White background for the content */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds some shadow for depth */
    max-width: 400px;
    width: 80%;
    text-align: center;
}

/* Button Styles */
#bt_notify_popup_ship24 .button {
    margin-top: 15px;
    padding: 10px 20px;
    border: none;
    background-color: #0073aa; /* WooCommerce/WordPress Primary Color */
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

/* Button Hover Effect */
#bt_notify_popup_ship24 .button:hover {
    background-color: #005177; /* Darken on hover */
}

</style>


