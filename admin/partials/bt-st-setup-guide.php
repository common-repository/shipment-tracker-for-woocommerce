
    <!-- Modal -->
    <div class="bt_sst_setup_guide modal" id="form-wizard-modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <div class="modal-card-title">
                    Shipment Tracker for Woocommerce
                </div>
                <div class="delete close-modal-btn" aria-label="close"></div>
            </header>
            <header class="modal-card-head">
                <div class="modal-card-title">
                 <!-- Progress Bar -->
                 <div class="progress-container">
                    <div class="progress-bar">
                        <div class="progress-bar-fill" id="progress-bar-fill"></div>
                    </div>
                    <!-- Updated to 6 steps -->
                    <div class="progress-step">1</div>
                    <div class="progress-step">2</div>
                    <div class="progress-step">3</div>
                    <div class="progress-step">4</div>
                    <div class="progress-step">5</div>
                    <div class="progress-step">6</div>
                </div>

                </div>
                
            </header>
            <section class="modal-card-body">
               

                <!-- Form Wizard Steps -->
                <form id="form-wizard">
                    <!-- Step 1 -->
                    <div class="wizard-step active welcome1">
                        <h6 class="is-size-6">
                                Thank you for choosing Shipment Tracker for WooCommerce to manage and streamline your order shipment tracking. 
                        </h6><br>
                        <h6 class="is-size-7"> This wizard will guide you through the essential steps to get your plugin up and running in just a few minutes.<br>
                         Our goal is to ensure you can easily integrate shipment tracking into your WooCommerce store, providing your customers with real-time updates on their orders.
                        </h6><br>
                        <div class="notification is-info is-light  is-7">
                            What to Expect: <br>
                                <span class="tag">1. Carrier Integration:</span> <span class="is-size-7">Connect your preferred carriers for seamless shipment updates.</span>
                                <br><span class="tag">2. Tracking Configuration:</span> <span class="is-size-7">Customize how tracking information is displayed to your customers.</span>
                                <br><span class="tag">3. Notifications Setup:</span> <span class="is-size-7">Enable email/sms notifications for timely shipment updates.</span>
                                <br><span class="tag">3. Advanced Features:</span> <span class="is-size-7">Explore features like "Estimated Delivery Checker" and "Dynamic Shipping Methods".</span>
                        </div>
                        <div class="is-size-6">
                            Click "Get Started" to begin the simple setup process. If you need help at any step, our support documentation and team are available to assist you.
                        </div>
                    </div>

                    <!-- Step 1 -->
                    <div class="wizard-step">
                        <div class="field">
                            <div class="label">Are you using any of these shipping companies?</div>
                            <div class="control">
                                <div class="radio-group">
								 	<div class="radio-item">
                                        <input type="radio" id="stw_wizard_delhivery" name="shipping_company"
                                            value="delhivery">
                                        <label for="stw_wizard_delhivery">Delhivery</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" id="stw_wizard_shiprocket" name="shipping_company"
                                            value="shiprocket" checked>
                                        <label for="stw_wizard_shiprocket">Shiprocket</label>
                                    </div>
                                
                                    <div class="radio-item">
                                        <input type="radio" id="stw_wizard_nimbuspostnew" name="shipping_company"
                                            value="nimbuspost_new">
                                        <label for="stw_wizard_nimbuspostnew">Nimbuspost</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" id="stw_wizard_xpressbees" name="shipping_company"
                                            value="xpressbees">
                                        <label for="stw_wizard_xpressbees">Xpressbees</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" id="stw_wizard_shipmozo" name="shipping_company"
                                            value="shipmozo">
                                        <label for="stw_wizard_shipmozo">Shipmozo</label>
                                    </div>
                                   
                                    <div class="radio-item">
                                        <input type="radio" id="stw_wizard_other" name="shipping_company" checked value="manual">
                                        <label for="stw_wizard_other">None of these (Custom Shipping)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="wizard-step">
                        <div class='bt_sst_shipping_company_details delhivery'>
                            <div>Nice to know! Here's some of the features supported by this plugin for <strong >Delhivery</strong>:</div>
                                <div class="panel is-size-7">
                                <a class="panel-block is-active">
                                    1. Automatic pull shipment tracking for processing orders periodically using cron job. 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/feature-rich-tracking-page-builder/">
                                    2. Create Beautiful Shipment Tracking Page with location Map & Review widget. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/developer-options/">
                                    3. Send tracking updates to 3rd party webhooks (for whatsapp notification etc). <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/delhivery-integration-in-woocommerce/">
                                    4. Push orders to Delhivery with correct weight & dimensions. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active">
                                    5. Manually Sync tracking information from orders backend. 
                                </a>
                                <a class="panel-block is-active">
                                    6. Add awb number of an order from orders backend.
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/sms-email-notifications/">
                                    7. SMS & Email Notifications. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/delhivery-integration-in-woocommerce/">
                                    8. Realtime Delivery Estimate checker on product page. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    9. Dynamic shipping methods on checkout. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active">
                                    10. Auto fetch city and state from pincode during checkout. 
                                </a>
                                <div class="panel-block"  >
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/delhivery-integration-in-woocommerce/">
                                    See all features <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a>
                                </div>

                                </div>
                            <div class="notification is-info is-light">
                                Keep these handy: <br>
                                <span class="tag is-primary">API Token</span> <span class="tag is-primary">Pickup Pincode</span> <span class="tag is-primary">Pickup Location Name</span>
                                <br>We'll ask these details at the end of this setup guide.
                            </div>
                        </div>
                        <div class='bt_sst_shipping_company_details shiprocket'>
                            <div>Excellent! This plugin works best with <strong >Shiprocket</strong>.<br>Here are few things you'll get only through this plugin:</div>
                                <div class="panel is-size-7">
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/shiprocket-integration-with-woocommerce/">
                                    1. Automatic tracking sync using webhook & cron job.
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/feature-rich-tracking-page-builder/">
                                    2. Create Beautiful Shipment Tracking Page with location Map & Review widget. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/developer-options/">
                                    3. Send tracking updates to 3rd party webhooks (for whatsapp notification etc). <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/shiprocket-integration-with-woocommerce/">
                                    4. Push orders to Shiprocket with correct weight & dimensions. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active">
                                    5. Manually Sync tracking information from orders backend. 
                                </a>
                                <a class="panel-block is-active">
                                    6. Add awb number of shipment from backend.
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/sms-email-notifications/">
                                    7. SMS & Email Notifications. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    8. Realtime Delivery Estimate checker on product page. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    9. Dynamic shipping methods on checkout. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active">
                                    10. Auto fetch city and state from pincode during checkout. 
                                </a>
                                <div class="panel-block"  >
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/shiprocket-integration-with-woocommerce/">
                                    See all features <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a> &nbsp;&nbsp;&nbsp;
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://youtu.be/82EmgNCbZQ4?si=qNZu0lVVKck3yqqR">
                                    See Video Guide <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a>
                                </div>

                                </div>
                            <div class="notification is-info is-light">
                                Keep these handy: <br>
                                <span class="tag is-primary">Api Username & Password</span> 
                                <span class="tag is-primary">Webhook Setup</span> 
                                <br>We'll ask these details at the end of this setup guide.
                            </div>
                        </div>
                        <div class='bt_sst_shipping_company_details nimbuspost_new'>
                            <div>Great! This plugin works seamlessly with <strong >Nimbuspost</strong>.<br>Here are few things you'll get only through this plugin:</div>
                                <div class="panel is-size-7">
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/nimbuspost-integration-with-woocommerce/">
                                    1. Automatic tracking sync using webhook & cron job.
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/feature-rich-tracking-page-builder/">
                                    2. Create Beautiful Shipment Tracking Page with location Map & Review widget. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/developer-options/">
                                    3. Send tracking updates to 3rd party webhooks (for whatsapp notification etc). <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/nimbuspost-integration-with-woocommerce/">
                                    4. Push orders to Nimbuspost with correct weight & dimensions. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active">
                                    5. Manually Sync tracking information from orders backend. 
                                </a>
                                <a class="panel-block is-active">
                                    6. Add awb number of shipment from backend.
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/sms-email-notifications/">
                                    7. SMS & Email Notifications. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    8. Realtime Delivery Estimate checker on product page. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    9. Dynamic shipping methods on checkout. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <div class="panel-block"  >
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/nimbuspost-integration-with-woocommerce/">
                                    See all features <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a> &nbsp;&nbsp;&nbsp;
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://youtu.be/3VMy2ZvpKa8?si=0kEAGdxVGGz1A7pY">
                                    See Video Guide <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a>
                                </div>

                                </div>
                            <div class="notification is-info is-light">
                                Keep these handy: <br>
                                <span class="tag is-primary">Api User Email & Password</span> 
                                <span class="tag is-primary">Webhook Setup</span> 
                                <br>We'll ask these details at the end of this setup guide.
                            </div>
                        </div>
                        <div class='bt_sst_shipping_company_details shipmozo'>
                            <div>Perfect! <strong >Shipmozo</strong> perfectly integrates with this plugin with following features:</div>
                                <div class="panel is-size-7">
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/shipmozo-integration-with-woocommerce/">
                                    1. Automatic tracking sync using webhook & cron job.
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/feature-rich-tracking-page-builder/">
                                    2. Create Beautiful Shipment Tracking Page with location Map & Review widget. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/developer-options/">
                                    3. Send tracking updates to 3rd party webhooks (for whatsapp notification etc). <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/shipmozo-integration-with-woocommerce/">
                                    4. Push orders to Shipmozo with correct weight & dimensions. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active">
                                    5. Manually Sync tracking information from orders backend. 
                                </a>
                                <a class="panel-block is-active">
                                    6. Add awb number of shipment from backend.
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/sms-email-notifications/">
                                    7. SMS & Email Notifications. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    8. Realtime Delivery Estimate checker on product page. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    9. Dynamic shipping methods on checkout. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <div class="panel-block"  >
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/shipmozo-integration-with-woocommerce/">
                                    See all features <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a> &nbsp;&nbsp;&nbsp;
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://youtu.be/2_ZMmayGtT0?si=KOPJ5wy28jrLGxBI">
                                    See Video Guide <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a>
                                </div>

                                </div>
                            <div class="notification is-info is-light">
                                Keep these handy: <br>
                                <span class="tag is-primary">Api Public & Private Key</span> 
                                <span class="tag is-primary">Webhook Setup</span> 
                                <br>We'll ask these details at the end of this setup guide.
                            </div>
                        </div>
                        <div class='bt_sst_shipping_company_details xpressbees'>
                            <div><strong >Xpressbees</strong> perfectly integrates with this plugin with following features:</div>
                                <div class="panel is-size-7">
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/xpressbees-integration-with-woocommerce/">
                                    1. Automatic tracking sync using webhook.
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/feature-rich-tracking-page-builder/">
                                    2. Create Beautiful Shipment Tracking Page with location Map & Review widget. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/developer-options/">
                                    3. Post tracking updates to 3rd party webhooks (for whatsapp notification etc). <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    4. Delivery Estimate checker on product page (via custom configuration). <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    5. Dynamic shipping methods on checkout (via custom configuration). <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/sms-email-notifications/">
                                    6. SMS & Email Notifications. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <div class="panel-block"  >
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/xpressbees-integration-with-woocommerce/">
                                    See all features <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a> &nbsp;&nbsp;&nbsp;
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://youtu.be/Ej8eVcklyRE?si=ckWsZejR-8MEvIrK">
                                    See Video Guide <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a>
                                </div>

                                </div>
                            <div class="notification is-info is-light">
                                Keep these handy: <br>
                                <span class="tag is-primary">Webhook Setup</span> 
                                <br>We'll ask these details at the end of this setup guide.
                            </div>
                        </div>
                        <div class='bt_sst_shipping_company_details manual'>
                            <div>
                                With our bouquet of powerful shipment related features, your website will never like before. You and your customers will fall in love with your online store more than ever!!
                                <br>
                                With custom shipping, you can:
                            </div>
                            <div class="panel is-size-7">
                                <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/manual/">
                                    1. Add awb number of shipment from orders backend. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block is-active" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/manual/">
                                    2. Manually update shipment tracking data from orders backend. <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block ">
                                    3. Automatically update shipment tracking data via plugin's webhook or via Ship24.com integration.
                                </a>
                                <div class="panel-block " >
                                    <div class="field">
                                        <div class="label"> How would you like to update shipment tracking data of your orders?</div>
                                        <div class="control">
                                            <div class="radio-group">
                                                <div class="radio-item">
                                                    <input type="radio" id="custom_shipping_mode_manual" name="custom_shipping_mode"
                                                        value="manual">
                                                    <label for="custom_shipping_mode_manual">I'll manually update tracking (from backend or webhook or php code). </label>
                                                </div>
                                                <div class="radio-item">
                                                    <input type="radio" id="custom_shipping_mode_ship24" name="custom_shipping_mode"
                                                        value="ship24.com" checked>
                                                    <label for="custom_shipping_mode_ship24">Automatic tracking via Ship24.com (Beta)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/feature-rich-tracking-page-builder/">
                                    4. Create Beautiful Shipment Tracking Page with location Map & Review widget. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/developer-options/">
                                    5. Post tracking updates to 3rd party webhooks (for whatsapp notification etc). <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    6. Delivery Estimate checker on product page (via custom configuration). <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    7. Dynamic shipping methods on checkout (via custom configuration). <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/sms-email-notifications/">
                                    8. SMS & Email Notifications. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                    9. Auto fetch city and state from pincode during checkout. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                                <div class="panel-block"  >
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/supported-shipping-companies/manual/">
                                    See all features <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a> &nbsp;&nbsp;&nbsp;
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://youtu.be/5KgUBOzd0I0?si=dIF0kOGTTa8vUShI">
                                    See Video Guide <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a> &nbsp;&nbsp;&nbsp;
                                    <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://www.ship24.com/pricing">
                                    See Ship24.com pricing <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                    </a>
                                </div>

                            </div>
                            <div class="notification is-info is-light">
                                Keep these handy: <br>
                                <span class="tag is-primary">ship24.com api key</span> 
                                <span class="tag is-primary">ship24.com webhook setup</span> 
                                <br>We'll ask these details at the end of this setup guide.
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="wizard-step tracking-page">
                        <div>
                            A clear and attractive shipment tracking makes your store look more professional & keep customers happy. With our feature rich shipment tracking widget, you can:
                        </div>
                        <div class="panel is-size-7">
                            <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/feature-rich-tracking-page-builder/">
                                1. Create customized tracking page & allow customers to track their orders via order id & mobile number. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                            </a>
                            <div class="panel-block " >
                                <div class="field">
                                    <div class="label">Would you like us to create tracking page on your website?</div>
                                    <div class="control">
                                        <div class="radio-group">
                                            <div class="radio-item">
                                                <input type="radio" id="stw_wizard_ctp_yes" name="stw_wizard_create_tracking_page"
                                                    value="yes">
                                                <label for="stw_wizard_ctp_yes">Yes, create a tracking page for me.</label>
                                            </div>
                                            <div class="radio-item">
                                                <input type="radio" id="stw_wizard_ctp_no" name="stw_wizard_create_tracking_page"
                                                    value="no" checked>
                                                <label for="stw_wizard_ctp_no">Not now, I'll do it later.</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/feature-rich-tracking-page-builder/">
                                2. Create direct order tracking link on your website. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                <br>
                                eg: https://yourwebsite.com/track?order=1234
                            </a>
                            <a class="panel-block ">
                                3. Secure tracking page, so that scrapers cannot slow down your website.
                            </a>
                            <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/feature-rich-tracking-page-builder/">
                                4. Show pick up and delivery location map on tracking page with estimated delivery marker. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                            </a>
                            <div  class="panel-block ">
                                <input type="checkbox" name="" id="stw_wizard_enable_location_map">
                                <label for="stw_wizard_enable_location_map">Enable Location Map</label>
                            </div>
                            <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/feature-rich-tracking-page-builder/">
                                5. Show rating widget on tracking page, so you can get more 5 star ratings!! <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                            </a>
                            <div   class="panel-block ">
                                <input type="checkbox" name="" id="stw_wizard_enable_rating_bar">
                                <label for="stw_wizard_enable_rating_bar">Enable Rating Bar</label>
                            </div>
                            <a class="panel-block " target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/sms-email-notifications/">
                                6. Send tracking updates via sms, email or whatsapp. <svg style="float:right" width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                            </a>
                            <div class="panel-block"  >
                                <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/feature-rich-tracking-page-builder/">
                                See all features <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a> &nbsp;&nbsp;&nbsp;
                                <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://youtu.be/bh12hRMlNR0?si=Ar2NDVWwPYA9t3aC">
                                See Video Guide <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a> &nbsp;&nbsp;&nbsp;
                                <a class=" is-link is-outlined is-fullwidth" target="_blank" href="https://pavitra-arts.com/track-your-order/?order=10258">
                                    See live demo <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                </a>
                            </div>
                        </div>
                        <div class="notification is-info is-light">
                                You can use this shortcode anywhere to display tracking widget: <br>
                                <span class="tag is-primary">[bt_shipping_tracking_form_2]</span> or 
                                <span class="tag is-primary">[bt_shipping_tracking_form_2 order_id="1234"] </span> 
                        </div>
                       
                    </div>

                    <!-- Step 5 -->
                    <div class="wizard-step advance-features">
                        <div>
                            Unlock advanced premium features to enhance your customers' shopping experience with real-time delivery estimates, flexible shipping options and many other useful features. 
                            
                        </div>
                        <div class="panel is-size-7">
                            <div class="panel-block " >
                                <div class="field">
                                    <div class="label">Do you want to enable "Estimated delivery checker" on product page? 
                                        <a class="" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                            <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                        </a>
                                    </div>
                                    <div class="control">
                                        <div class="radio-group">
                                            <div class="radio-item">
                                                <input type="radio" id="stw_wizard_etd_yes" name="stw_wizard_etd_checker"
                                                    value="yes">
                                                <label for="stw_wizard_etd_yes">Yes, I'd like to have the delivery estimate checker enabled on my product pages to provide customers with clearer shipping timelines.</label>
                                            </div>
                                            <div class="radio-item">
                                                <input type="radio" id="stw_wizard_etd_no" name="stw_wizard_etd_checker"
                                                    value="no" checked>
                                                <label for="stw_wizard_etd_no">Not now, I'll do it later.</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-block " >
                                <div class="field">
                                    <div class="label">Shall we enable "Dynamic shipping methods" on checkout page?
                                        <a class="" target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/features/product-and-checkout-pages/">
                                            <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17 13.5v6H5v-12h6m3-3h6v6m0-6-9 9" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> 
                                        </a>

                                    </div>
                                    <div class="control">
                                        <div class="radio-group">
                                            <div class="radio-item">
                                                <input type="radio" id="stw_wizard_dsm_yes" name="stw_wizard_dsm_checker"
                                                    value="yes">
                                                <label for="stw_wizard_dsm_yes">Yes, I want to give my customers the option to choose their preferred courier company for shipping.</label>
                                            </div>
                                            <div class="radio-item">
                                                <input type="radio" id="stw_wizard_dsm_no" name="stw_wizard_dsm_checker"
                                                    value="no" checked>
                                                <label for="stw_wizard_dsm_no">Not now, I'll do it later.</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="notification is-info is-light">
                            Good news! As the admin, you can try out all premium features, including the Estimated Delivery Checker and Dynamic Shipping Methods, without any payment or registration.    
                        </div>
                     
                    </div>

                    <!-- Step 6 -->
                    <div class="wizard-step last-step">
                        <div class="pre-complete-page">
                            <div>
                                Thank you for completing the setup of the Shipment Tracker for WooCommerce plugin! You are now equipped to provide your customers with an enhanced shipping experience. 
                            </div>
                            <div class="notification is-info is-light  is-7">
                                Here's what else you can do with the plugin: <br>
                                    <span class="tag">1. Auto Status Update:</span> <span class="is-size-7">Automatically Change Status of Delivered Orders to Completed.</span><br>
                                    <span class="tag">2. Add Order Notes:</span> <span class="is-size-7">Plugin can automatically add tracking updates to order notes for future reference.</span><br>
                                    <span class="tag">3. Estimated Delivery Timer:</span> <span class="is-size-7">Show timer countdown on "Estimated Delivery checker" to add FOMO factor.</span><br>
                                    <span class="tag">4. Custom Processing Days:</span> <span class="is-size-7">Add custom processing days for delivery date estimates.</span><br>
                                    <span class="tag">5. Free Shipping:</span> <span class="is-size-7">Define coupon based or order total based free shipping.</span><br>
                                    <span class="tag">6. Fallback Rates :</span> <span class="is-size-7">Set flat or weight based shipping rates, if realtime rates are unavailable.</span><br>
                                    <span class="tag">7. Custom Shipping Rates:</span> <span class="is-size-7">Define custom domentic & international shipping rates.</span><br>
                                    <span class="tag">8. Shipment Weight:</span> <span class="is-size-7">Show approximate shipment weight on checkout page.</span>
                            </div>
                            <div class="is-size-6">
                                Click "Finish & Save" to save your changes, it will be done in a jiffy!
                            </div>
                        </div>
                        <div class="post-complete-page" style="display:none">
                            <div>
                                Shipment tracking features has been enabled on your website. You and your customers can now enjoy the latest upgrade on your website!!
                            </div>
                            <div id="created-tracking-page" style="display:none">
                                Your brand new tracking page is ready. Click here view your tracking page.
                            </div>

                            <div class="notification is-info is-light  is-7">
                                Next Steps: <br>
                                    <span class="is-size-7">1. Setup webhook, api keys and other settings of the selected shipping aggregator.</span><br>
                                    <span class="is-size-7">2. In case of custom shipping, review manual tab of plugin settings.</span><br>
                                    <span class="is-size-7">3. For ship24.com, setup webhook and api keys.</span><br>
                                    <span class="is-size-7">4. <b>You can add/update AWB number to an order from orders list and edit page.</b></span><br>
                                    <span class="is-size-7">5. Explore & experiment with many other useful features of the plugin.</span><br>
                            </div>
                            <div class="is-size-6">
                                Click below to setup your shipping provider.
                            </div>
                        </div>
                    </div>

                </form>
            </section>
            <footer class="modal-card-foot">
                <div class="button stw_wizard_button is-info" id="prev-step" style="display: none;">Previous</div>
                <div class="button stw_wizard_button is-info" id="next-step">Get Started</div>
                <div class="button stw_wizard_button is-info" id="final_button"></div>
            </footer>
        </div>
    </div>