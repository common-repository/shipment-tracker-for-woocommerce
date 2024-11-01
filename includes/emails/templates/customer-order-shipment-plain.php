<?php
/**
 * Customer on-hold order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-on-hold-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 7.3.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked WC_Emails::email_header() Output the email header
 */

 $order_id = $order->get_id();
 $name = $order->get_billing_first_name() ." ". $order->get_billing_last_name() ;

 $tracking = bt_get_shipping_tracking($order_id);

 if(!empty($tracking['tracking_data']['awb'])){
    $awb_number = $tracking['tracking_data']['awb'];
    $estimated_delivery_date = $tracking['tracking_data']['etd'];
    $shipment_status = $tracking['tracking_data']['current_status'];
    $courier_name = $tracking['tracking_data']['courier_name'];

    $body = "Shipment Tracking Information:\n\n";
    $body .= "Dear " . $name . ", Here's latest update on your order:\n";

    $body .= "Order ID: " . $order_id . "\n";

    $body .= "AWB: " . $awb_number . "\n";
    $body .= "Current Status: " . $shipment_status . "\n";

    $body .= "Courier Name: " . $courier_name . "\n";
    $body .= "Estimated Time of Delivery (ETD): " . $estimated_delivery_date . "\n";

    echo $body; 
}