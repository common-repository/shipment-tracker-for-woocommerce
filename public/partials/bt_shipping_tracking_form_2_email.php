<?php
  $public_dir_url = plugin_dir_url(dirname(__FILE__));
?>
<div class="snipcss0-0-0-1 snipcss-GDYrP obscure-kzaezq7Gp" style="position:relative;margin:0px;padding:20px;background-attachment:scroll !important;">
  <div class="fl-node-content snipcss0-1-1-2 obscure-MMkaMW9Lx obscure-JkAnk9l33" style="max-width:800px;margin-left:auto;margin-right:auto;">
    <?php 
      if (isset($the_order) && $the_order instanceof WC_Order)
      {
            
            // echo json_encode($tracking);
            // echo json_encode($the_order);
            $name = $the_order->get_billing_first_name() ." ". $the_order->get_billing_last_name() ;
            $order_status = $the_order->get_status();      
            $order_status_name = wc_get_order_status_name( $order_status);     
            $order_number = $the_order->get_order_number();      
            $ordering_date = $the_order->get_date_created()->date(get_option('date_format'));
            $ordering_time = $the_order->get_date_created()->date(get_option('time_format'));
            $order_payment_method = $the_order->get_payment_method();
            $order_total = $the_order->get_formatted_order_total();
            $order_sjipping_method = $the_order->get_shipping_method();
            $order_delivery_address= $the_order->get_shipping_city();
            $payment_method_name = $order_payment_method; 
            $payment_gateways   = WC_Payment_Gateways::instance()->payment_gateways();
            if(isset($payment_gateways[$order_payment_method])){
                $payment_method_name = $payment_gateways[$order_payment_method]->get_title();
            }

            $estimated_delivery_date = 'NA';
            $courier_name = 'NA';
            $awb_number = 'NA';
            $shipment_status = "NA";
            $shipped_string = "Shipped";
            $shipped_message = "Your package is on its way & will reach you soon.";
            $show_delivery_states = true;
            $current_step = 2; //orderplaced=1, shipped=2, outfordelivery=3, delivered=4

            if(!empty($tracking['tracking_data']['awb']) && $order_status!='cancelled' && $order_status!='on-hold' && $order_status!='pending' && $order_status!='refunded' && $order_status!='failed' && $order_status!='checkout-draft'){
                $awb_number = $tracking['tracking_data']['awb'];
                $estimated_delivery_date = $tracking['tracking_data']['etd'];
                $shipment_status = $tracking['tracking_data']['current_status'];
                $courier_name = $tracking['tracking_data']['courier_name'];


                if(stripos($shipment_status,'delivered')!==false && stripos($shipment_status,'rto')===false){
                    $current_step = 4; 
                } else if(stripos($shipment_status,'out')!==false && stripos($shipment_status,'rto')===false && stripos($shipment_status,'pick')===false){
                    $current_step = 3; 
                } else if(stripos($shipment_status,'rto')!==false || stripos($shipment_status,'cancel')!==false || stripos($shipment_status,'lost')!==false || stripos($shipment_status,'dispose')!==false){
                    $show_delivery_states = false;
                    $shipped_string = $shipment_status;
                    $shipped_message = "Oops, there will be no further movement of your package.";
                } else if(stripos($shipment_status,'transit')!==false){
                    
                    //shipment is either delivered or out for delivery
                    $shipped_string = "Shipped";
                    $shipped_message = "Your package is on its way & will reach you soon.";
                } else{
                    $shipped_string = bt_format_shipment_status($shipment_status);
                    $shipped_message = apply_filters( 'bt_sst_shipping_status_message', "Your order has been " . $shipped_string, $shipment_status );
                }
               

            }else{
                if($order_status =='cancelled' || $order_status=='on-hold' || $order_status=='pending' || $order_status=='refunded' || $order_status=='failed' || $order_status=='checkout-draft'){
                    //order is not yet in processing or any other equivalent state
                    $show_delivery_states = false;
                    $shipped_string = $order_status_name;
                    $shipped_message = "Your order is in " . $order_status_name . ' state.';
                }else{
                    //order is in processing or any other equivalent state, but not yet shipped or tracking data not available yet
                    $shipped_string = "Shipping soon";
                    $shipped_message = "Your package will be shipped soon, check back later.";
                }
                
            }
        
        ?>
        <div class="fl-module-subscribe-form snipcss-oLzae obscure-5eL1eW3kd obscure-1wJ5wR9d8" data-node="krpof3agj2mn">
            <div class="fl-node-s27vp51tbfmw fl-col-group-align-top snipcss0-2-2-3 obscure-P7W378aZg obscure-wgJwgZVGm" data-node="s27vp51tbfmw" style="display:block;-webkit-flex-wrap:wrap;-ms-flex-wrap:wrap;flex-wrap:wrap;width:100%;flex-grow:1;">
                    <div class="fl-col-has-cols snipcss0-3-3-4 obscure-x03Z0E8Ga obscure-VXzbXRgla" data-node="oi8q7g9kbxfm" style="float:none;min-height:1px;width:auto !important;clear:both;margin-left:auto;margin-right:auto;display:flex;-webkit-box-flex:1 1 auto;-moz-box-flex:1 1 auto;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto;">
                        <div class="fl-node-content snipcss0-4-4-5 obscure-ZWy0WPMnz" style="margin:0px;padding:0px; ;min-width:1px;max-width:100%;width:100%;box-shadow:0px 0px 3px 0px #969696;">
                            <div class="fl-node-l93oa6izcf70 fl-col-group-nested snipcss0-5-5-6 obscure-P7W378aZg" data-node="l93oa6izcf70">
                                <div class="snipcss0-6-6-7 obscure-x03Z0E8Ga obscure-BEzVENp13" data-node="lmkze9s734bq" style="float:none;min-height:1px;width:auto !important;clear:both;margin-left:auto;margin-right:auto;display:flex;-webkit-box-flex:1 1 auto;-moz-box-flex:1 1 auto;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto;">
                                    <div class="fl-node-content snipcss0-7-7-8 obscure-ZWy0WPMnz" style="margin:0px;padding:0px;display:flex;-webkit-box-flex:1 1 auto;-moz-box-flex:1 1 auto;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;flex-shrink:1;min-width:1px;max-width:100%;width:100%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                        <div class="fl-module-rich-text snipcss0-8-8-9 obscure-LzqyzR5x7 obscure-ZWy0WPMR0" data-node="512uy9gq7pib">
                                            <div class="fl-node-content snipcss0-9-9-10 obscure-p7an7J3vr" style="margin:20px;margin-top:5px;margin-bottom:5px;">
                                                <div class="snipcss0-10-10-11 obscure-69p19MbZm" style="text-align:center !important;">
                                                  <p class="snipcss0-11-87-88 bt_sst" style="margin:0 0 10px;text-align:center !important;"><strong class="snipcss0-12-88-89" style="font-weight: bold;">Courier:</strong> <?= $courier_name ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fl-node-xb3alogzj8qv fl-col-group-nested snipcss0-5-5-14 obscure-P7W378aZg" data-node="xb3alogzj8qv">
                                <div class="fl-col-small snipcss0-6-14-15 obscure-x03Z0E8Ga obscure-4BxzBaqZN" data-node="zuia8xpo0fg3" style="float:none;min-height:1px;width:auto !important;clear:both;margin-left:auto;margin-right:auto;display:flex;-webkit-box-flex:1 1 auto;-moz-box-flex:1 1 auto;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto;">
                                    <div class="fl-node-content snipcss0-7-15-16 obscure-ZWy0WPMnz" style="margin:0px;padding:0px;display:flex;-webkit-box-flex:1 1 auto;-moz-box-flex:1 1 auto;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;flex-shrink:1;min-width:1px;max-width:100%;width:100%;">
                                        <div class="snipcss0-8-16-17 obscure-LzqyzR5x7 obscure-VXzbXRgBj obscure-n0EW0n7er" data-node="4358g7wtiu2f">
                                            <div class="fl-node-content snipcss0-9-17-18 obscure-p7an7J3vr" style="margin:20px;margin-top:0px;margin-bottom:0px;">
                                                <h2 class="snipcss0-10-18-19 obscure-Wb9zbk749 bt_sst" style='font-family:"Helvetica",Verdana,Arial,sans-serif;font-weight:700;line-height:1.4;color:#333;margin-top:20px;margin-bottom:10px;font-size:14px;text-transform:none;font-style:normal;letter-spacing:0px;text-align:left;padding:0 !important;margin:0 !important;'>
                                                  <p class="snipcss0-11-94-95 bt_sst" style="margin:0 0 10px;text-align:center !important;"><strong class="snipcss0-12-95-96" style="font-weight: bold;">AWB #:</strong> <?= $awb_number ?></p>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="snipcss0-6-14-21 obscure-x03Z0E8Ga obscure-JkAnk9l3R" data-node="o4vpmrgyx9ks" style="float:none;min-height:1px;width:auto !important;clear:both;margin-left:auto;margin-right:auto;display:flex;-webkit-box-flex:1 1 auto;-moz-box-flex:1 1 auto;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto;">
                                    <div class="fl-node-content snipcss0-7-21-22 obscure-ZWy0WPMnz" style="margin:0px;padding:0px;display:flex;-webkit-box-flex:1 1 auto;-moz-box-flex:1 1 auto;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;flex-shrink:1;min-width:1px;max-width:100%;width:100%;">
                                        <div class="snipcss0-8-22-23 obscure-LzqyzR5x7 obscure-8zZkzly8z obscure-n0EW0n7er" data-node="qdhmc7bswel5">
                                            <div class="fl-node-content snipcss0-9-23-24 obscure-p7an7J3vr" style="margin:20px;margin-top:0px;margin-bottom:0px;">
                                                <h2 class="snipcss0-10-24-25 obscure-Wb9zbk749 bt_sst" style='font-family:"Helvetica",Verdana,Arial,sans-serif;font-weight:700;line-height:1.4;color:#333;margin-top:20px;margin-bottom:10px;font-size:14px;text-transform:none;font-style:normal;letter-spacing:0px;text-align:right;padding:0 !important;margin:0 !important;'>
                                                    <span class="snipcss0-11-25-26 obscure-0w5ewyE3G" style="color:#17b200;"><?= $estimated_delivery_date>=""?"":"Estimated delivery by:$estimated_delivery_date" ?></span>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fl-node-j70sgf5izo6c fl-col-group-nested snipcss0-5-5-27 obscure-P7W378aZg" data-node="j70sgf5izo6c">
                                <div class="snipcss0-6-27-28 obscure-x03Z0E8Ga obscure-38P18aqw4" data-node="k3gphtsnqfw2" style="float:none;min-height:1px;width:auto !important;clear:both;margin-left:auto;margin-right:auto;display:flex;-webkit-box-flex:1 1 auto;-moz-box-flex:1 1 auto;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto;">
                                    <div class="fl-node-content snipcss0-7-28-29 obscure-ZWy0WPMnz" style="margin:0px;padding:0px;display:flex;-webkit-box-flex:1 1 auto;-moz-box-flex:1 1 auto;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;flex-shrink:1;min-width:1px;max-width:100%;width:100%;border-style:solid;border-width:0;background-clip:border-box;border-color:#e2e2e2;border-top-width:1px;border-right-width:0px;border-bottom-width:1px;border-left-width:0px;">
                                        <div class="fl-module-info-list snipcss0-8-29-30 obscure-LzqyzR5x7 obscure-E1qj1WVXX" data-node="9au81dr5xjz6">
                                            <div class="fl-node-content snipcss0-9-30-31 obscure-p7an7J3vr" style="margin: 20px;">
                                                <div class="snipcss0-10-31-32 obscure-qJaRJ3PVg obscure-BEzVENpmn">
                                                    <ul class="snipcss0-11-32-33 obscure-jzEBz173V obscure-AdqVd1LWL bt_sst" style="box-sizing:border-box;margin-top:0;margin-bottom:10px;float:none;margin:0;padding:0;">
                                                        <li class="info-list-item-dynamic0 snipcss0-12-33-34 obscure-z0xQ0E4nw" style="list-style:none;margin:0;padding:0;position:relative;padding-bottom:20px;">
                                                            <div class="snipcss0-13-34-35 obscure-jzEBz173V obscure-MMkaMW93B obscure-vMapMwZlb" style="position:relative;z-index:5;float:none;">
                                                                <div class="snipcss0-14-35-36 obscure-38P18aqL4 obscure-P7W378aLr obscure-x03Z0E85r obscure-VXzbXRgej" style="-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both;-webkit-animation-name:pulse;animation-name:pulse;position:relative;z-index:5;display:inline-block;vertical-align:top;margin-right:20px;">
                                                                    <div class="snipcss0-15-36-37 obscure-8zZkzlygz obscure-BEzVENpmn" style="text-align: center;"> 
                                                                    <span class="snipcss0-16-37-38 obscure-5eLBea7qK" style="display:inline-block;vertical-align:middle;">
                                                                            <span class="snipcss0-17-38-39 obscure-Wb9zbk739" style="display:block;">
                                                                                <i class="snipcss0-18-39-40 obscure-geN8ev7qP obscure-avzpv6m4P" style=' <?= $current_step>=1?"color:green;":"color:gray;" ?>;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:block;font-style:normal;font-variant:normal;text-rendering:auto;line-height:75px;font-weight:400;font-family:"bt_sst_tracking_widget_font";margin:0;float:none;font-size:75px;height:75px;width:75px;text-align:center;'>
                                                                                    ✓
                                                                                </i>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="info-list-content-dynamic0 snipcss0-14-35-41 obscure-jzEBz173V obscure-LzqyzR5gW" style="float:none;display:inline-block;width:calc( 100% - 120px );">
                                                                    <h4 class="uabb-info-list-title bt_sst snipcss0-15-41-42" style='font-family:"Helvetica",Verdana,Arial,sans-serif;font-weight:400;line-height:1.4;color:#333;margin-top:10px;margin-bottom:10px;font-size:18px;text-transform:none;font-style:normal;letter-spacing:0px;margin:0;clear:both;padding:0;'>Order Placed</h4>
                                                                    <div class="info-list-description-dynamic0 snipcss0-15-41-43 obscure-9aVkarqgw obscure-n0EW0n7or">
                                                                        <p class="snipcss0-16-43-44 bt_sst" style="margin:0 0 10px;">We've received your order on </strong> <?=  $ordering_date ?> at <?=  $ordering_time ?>.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="snipcss0-13-34-45 obscure-jzEBz173V obscure-kzaezq7PL <?= $current_step>1?"bt_sst_step_completed":"" ?>" style="color:#9c9c9c;height:calc( 100% - 75px );position:absolute;z-index:1;border-width:0 0 0 1px;float:none;border-style:dotted;border-left-width:5px;top:75px;left:37.5px;"></div>
                                                        </li>
                                                        <li class="info-list-item-dynamic1 snipcss0-12-33-46 obscure-z0xQ0E4nw" style="list-style:none;margin:0;padding:0;position:relative;padding-bottom:20px;">
                                                            <div class="snipcss0-13-46-47 obscure-jzEBz173V obscure-MMkaMW93B obscure-vMapMwZlb" style="position:relative;z-index:5;float:none;">
                                                                <div class="snipcss0-14-47-48 obscure-38P18aqL4 obscure-P7W378aLr obscure-x03Z0E85r obscure-4BxzBaq0J" style="-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both;-webkit-animation-name:pulse;animation-name:pulse;position:relative;z-index:5;display:inline-block;vertical-align:top;margin-right:20px;">
                                                                    <div class="snipcss0-15-48-49 obscure-8zZkzlygz obscure-BEzVENpmn" style="text-align: center;"> <span class="snipcss0-16-49-50 obscure-5eLBea7qK" style="display:inline-block;vertical-align:middle;">
                                                                            <span class="snipcss0-17-50-51 obscure-Wb9zbk739" style="display:block;">
                                                                                <i class="snipcss0-18-51-52 obscure-geN8ev7qP obscure-avzpv6m4P " style='<?= $current_step>1?"color:green;":"color:grey;"?>;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:block;font-style:normal;font-variant:normal;text-rendering:auto;line-height:75px;font-weight:400;font-family:"bt_sst_tracking_widget_font";margin:0;float:none;font-size:75px;height:75px;width:75px;text-align:center;'>
                                                                                    <?= $shipped_string == "canceled" ? '<span style="color:red;">⚠</span>' : '<span style="color:green;">✓</span>' ?>
                                                                                </i>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="info-list-content-dynamic1 snipcss0-14-47-53 obscure-jzEBz173V obscure-LzqyzR5gW" style="float:none;display:inline-block;width:calc( 100% - 120px );">
                                                                    <h4 class="uabb-info-list-title bt_sst snipcss0-15-53-54" style='font-family:"Helvetica",Verdana,Arial,sans-serif;font-weight:400;line-height:1.4;color:#333;margin-top:10px;margin-bottom:10px;font-size:18px;text-transform:none;font-style:normal;letter-spacing:0px;margin:0;clear:both;padding:0;'><?= $shipped_string  ?></h4>
                                                                    <div class="info-list-description-dynamic1 snipcss0-15-53-55 obscure-9aVkarqgw obscure-n0EW0n7or">
                                                                        <p class="snipcss0-16-55-56 bt_sst" style="margin:0 0 10px;"><?= $shipped_message ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="snipcss0-13-46-57 obscure-jzEBz173V obscure-kzaezq7PL <?= $current_step>2?"bt_sst_step_completed":"" ?>" style="color:#9c9c9c;height:calc( 100% - 75px );position:absolute;z-index:1;border-width:0 0 0 1px;float:none;border-style:dotted;border-left-width:5px;top:75px;left:37.5px;"></div>
                                                        </li>
                                                        <li style="<?= $show_delivery_states?'':'display:none;' ?>list-style:none;margin:0;padding:0;position:relative;padding-bottom:20px;" class="info-list-item-dynamic2 snipcss0-12-33-58 obscure-z0xQ0E4nw">
                                                            <div class="snipcss0-13-58-59 obscure-jzEBz173V obscure-MMkaMW93B obscure-vMapMwZlb" style="position:relative;z-index:5;float:none;">
                                                                <div class="snipcss0-14-59-60 obscure-38P18aqL4 obscure-P7W378aLr obscure-x03Z0E85r obscure-KEqMElRvl" style="-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both;-webkit-animation-name:pulse;animation-name:pulse;position:relative;z-index:5;display:inline-block;vertical-align:top;margin-right:20px;">
                                                                    <div class="snipcss0-15-60-61 obscure-8zZkzlygz obscure-BEzVENpmn" style="text-align: center;"> <span class="snipcss0-16-61-62 obscure-5eLBea7qK" style="display:inline-block;vertical-align:middle;">
                                                                            <span class="snipcss0-17-62-63 obscure-Wb9zbk739" style="display:block;">
                                                                                <i class="snipcss0-18-63-64 obscure-geN8ev7qP obscure-avzpv6m4P " style='<?= $current_step>=3?"color:green;":"color:grey;" ?>;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:block;font-style:normal;font-variant:normal;text-rendering:auto;line-height:75px;font-weight:400;font-family:"bt_sst_tracking_widget_font";margin:0;float:none;font-size:75px;height:75px;width:75px;text-align:center;'>
                                                                                    ✓
                                                                                </i>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="info-list-content-dynamic2 snipcss0-14-59-65 obscure-jzEBz173V obscure-LzqyzR5gW" style="float:none;display:inline-block;width:calc( 100% - 120px );">
                                                                    <h4 class="uabb-info-list-title bt_sst snipcss0-15-65-66" style='font-family:"Helvetica",Verdana,Arial,sans-serif;font-weight:400;line-height:1.4;color:#333;margin-top:10px;margin-bottom:10px;font-size:18px;text-transform:none;font-style:normal;letter-spacing:0px;margin:0;clear:both;padding:0;'>Out for delivery</h4>
                                                                    <div class="info-list-description-dynamic2 snipcss0-15-65-67 obscure-9aVkarqgw obscure-n0EW0n7or">
                                                                        <p class="snipcss0-16-67-68 bt_sst" style="margin:0 0 10px;">
                                                                        <?php if($current_step>=3){
                                                                          echo "Package is going to arrive anytime now.";
                                                                      }       
                                                                      ?>                                                                    
                                                                      </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="snipcss0-13-58-69 obscure-jzEBz173V obscure-kzaezq7PL " style="height:calc( 100% - 75px );position:absolute;z-index:1;border-width:0 0 0 1px;float:none;color:#9c9c9c;border-style:dotted;border-left-width:5px;top:75px;left:37.5px;"></div>
                                                        </li>
                                                        <li style=" <?= $show_delivery_states?'':'display:none;' ?> list-style:none;margin:0;padding:0;position:relative;padding-bottom:20px;" class="info-list-item-dynamic3 snipcss0-12-33-70 obscure-z0xQ0E4nw">
                                                            <div class="snipcss0-13-70-71 obscure-jzEBz173V obscure-MMkaMW93B obscure-vMapMwZlb" style="position:relative;z-index:5;float:none;">
                                                                <div class="snipcss0-14-71-72 obscure-38P18aqL4 obscure-P7W378aLr obscure-x03Z0E85r obscure-l0E90NdXQ" style="-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both;-webkit-animation-name:pulse;animation-name:pulse;position:relative;z-index:5;display:inline-block;vertical-align:top;margin-right:20px;">
                                                                    <div class="snipcss0-15-72-73 obscure-8zZkzlygz obscure-BEzVENpmn" style="text-align: center;"> <span class="snipcss0-16-73-74 obscure-5eLBea7qK" style="display:inline-block;vertical-align:middle;">
                                                                            <span class="snipcss0-17-74-75 obscure-Wb9zbk739" style="display:block;">
                                                                                <i class="snipcss0-18-75-76 obscure-geN8ev7qP obscure-avzpv6m4P  " style='<?= $current_step>=4?"color:green;":"color:grey;" ?>;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:block;font-style:normal;font-variant:normal;text-rendering:auto;line-height:75px;font-weight:400;font-family:"bt_sst_tracking_widget_font";margin:0;float:none;color:#9c9c9c;font-size:65px;height:75px;width:75px;text-align:center;'>
                                                                                    ✓
                                                                                </i>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="info-list-content-dynamic3 snipcss0-14-71-77 obscure-jzEBz173V obscure-LzqyzR5gW" style="float:none;display:inline-block;width:calc( 100% - 120px );">
                                                                    <h4 class="uabb-info-list-title bt_sst snipcss0-15-77-78" style='font-family:"Helvetica",Verdana,Arial,sans-serif;font-weight:400;line-height:1.4;color:#333;margin-top:10px;margin-bottom:10px;font-size:18px;text-transform:none;font-style:normal;letter-spacing:0px;margin:0;clear:both;padding:0;'>Delivered</h4>
                                                                    <div class="info-list-description-dynamic3 snipcss0-15-77-79 obscure-9aVkarqgw obscure-n0EW0n7or">
                                                                        <p class="snipcss0-16-79-80 bt_sst" style="margin:0 0 10px;">
                                                                          <?php if($current_step>=4){
                                                                                  echo 'Yay! You should have already received your package.';
                                                                                }   
                                                                          ?>
                                                                         </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>   
          </div>
     <?php } ?>
  </div>
</div>
