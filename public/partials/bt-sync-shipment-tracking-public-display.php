<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://amitmittal.tech
 * @since      1.0.0
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/public/partials
 */
?>

<div id="_bt_shipping_tracking_public">
    <form method="post" id="_bt_shipping_tracking_from">
        <input type="text" placeholder="Enter Order ID" name="_bt_track_order_id" id="_bt_track_order_id" value="" style="width: auto" required/>
        <?php wp_nonce_field('bt_get_tracking_data','bt_get_tracking_form_nonce'); ?>
        <input type="submit"  value="Track"/>
    </form>
    <div class="table-responsive">
        <table id="_bt_shipping_tracking_table" style="display: none;">
            <thead>
            <th>Order Id</th>
            <th>Order Status</th>
            <th>AWB Number</th>
            <th>Current Status</th>
            <th>Courier Name</th>
            <th>ETD</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
