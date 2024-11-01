=== Shipment Tracker for Woocommerce ===
Contributors: amitmital
Donate link: https://pmny.in/6JB4CzvwowVL
Tags: shiprocket, shyplite, nimbuspost, xpressbees, shipmozo, delhivery, order tracking, shipment tracking, order tracking page, tracking page, shipment sms, shipment email, tracking link, shipping 
Requires at least: 4.6
Tested up to: 6.6
Stable tag: trunk
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add awb# to orders, create tracking page, send tracking info via sms & email. Works best with Shiprocket, Shipmozo, Delhivery & Nimbuspost. 🇮🇳 Proudly Made in India 🇮🇳

== Description ==

Boost Sales, Improve Customer Satisfaction, and Reduce Support Requests with Shipment Tracker for WooCommerce. 

Add awb# to orders, create tracking page, send tracking info via sms & email. Works best with Shiprocket, Shipmozo, Delhivery & Nimbuspost.

🇮🇳 Proudly Made in India 🇮🇳

Are you tired of juggling multiple plugins to manage your shipment tracking needs? Look no further! **Shipment Tracker for WooCommerce** is your all-in-one solution, eliminating the need for multiple plugins and streamlining your shipment tracking process.

Shipment Tracker for WooCommerce is the ultimate solution for managing all your shipping needs directly from your WooCommerce store. With seamless integration and a user-friendly interface, this plugin eliminates the need for multiple plugins, providing a comprehensive solution to enhance customer satisfaction and streamline your shipping process.


## Why Shipment Tracker for Woocoomerce?

### Increase Sales

By providing a seamless tracking experience, customers are more likely to complete their purchases and return for future orders.

### Improve Customer Satisfaction

Provide timely notifications via email, SMS, or WhatsApp (coming soon), keeping customers informed at every step. Happy customers are repeat customers.

### Reduce Support Requests

With automated tracking updates & self-service options, customers can check their order status anytime, reducing the number of support inquiries.

### All-in-One Solution

Eliminate the need for multiple plugins with our Swiss army knife for shipment tracking. Manage everything in one place.

### Inbuilt SMS and Email Functionality

Send tracking updates directly to your customers via SMS and email.

### Customizable Tracking Page

Personalize the tracking page to match your preferences & your brand's look and feel.
## Key Features

-   **Admin Features:**

    >-   **View shipment status right** from order list.
    
    >-   **Filter orders** based on shipment statuses.
    
    >-   **Add shipment data** like awb, courier, estimated delivery date etc from backend.
    
    >-   Automatically **update order statuses** (completed, canceled, refunded).
    
    >-   Automatically **add order notes** when shipment statuses change.
    
    >-   Customize order note template.
    
    >-   **Receive email notifications** on status changes.
    
    >-   **Multiple Carrier Support:** Supports a wide range of shipping carriers, making it versatile for any business.
    
    >-   **International Shipping Support**.
    

-   **SMS & Email Notifications:**
    

     >-   **Easily integrates with WooCommerce's default email** system to provide real-time tracking updates.
    
    >-   **Send tracking updates** via SMS, Email, or WhatsApp (coming soon).
    
    >-   Global SMS service availability.
    
    >-   Pre-approved DLT templates for India.
    >-   Configure notification settings for different shipment stages (new order, in transit, out for delivery, delivered).
    
    >-   **Customize Email templates** from Woocommerce Settings.
    

-   **Tracking Widget:**
    

    >-   Create a **beautiful tracking page.**
    
    >-   **Direct links** for order tracking, which can be sent to customers via sms or email. For eg: yourwebsite.com/track/?order=1234
    
    >-   **Customers can track orders** from the My Account section.
    
    >-   Display shipment status, estimated delivery date, courier name, AWB number, and tracking link.
    

-   **Product and Checkout Pages:**
    

    >-   **Delivery Estimate Widget:** Display estimated delivery dates for domestic and international orders.
    
    >-   **Dynamic Shipping Methods:** Let customers choose their preferred courier based on rates and delivery estimates.
    
    >-   **Weight & Dimensions Calculator:** Accurately calculate shipping charges.
    
    >-   **Auto-fill City & State:** Automatically fill city and state based on pin code. Simplify checkout by fetching data from pin codes.
    
    >-   **Set Order Processing Time:** Set processing days at global, category, or product levels.
    
    >-   **Fallback Rates:** Set fallback rates when auto shipment rates are not available.
    

-   **Advanced Features:**
    

    >-   Calculate accurate weight and dimensions of shipments.
    
    >-   Developer-friendly with options for consuming shipment data via actions, public functions, and shortcodes.
    

-   **Developer Options:**
    

    >-   Integrate shipment data into custom PHP code.
    
    >-   Use actions, public functions, and shortcodes.


## How to Use

**1.  Installation:-** Install the plugin from wordpress plugins repository.
    
**2.  Set Shipping Provider:-** In general settings, select your shipping provider(s). Then setup webhook and api keys of the chosen shipping provider. If you are not using any supported shipping aggregator, “Manual” shipping provider allows you to use any courier company and manually update the tracking data from the backend.bn 
    
**3.  Delivery Estimate Checker:-** Setup estimated delivery date & shipping charges based on your delivery pin code on product page.
    
**4.  Dynamic Shipping Methods:-** Show dynamic shipping methods during checkout page so customers can select desired courier company based on estimated delivery dates and charges.
    
**5.  Tracking Widget:-** Setup tracking widget to display tracking information on customer’s my account section. Also create a beautiful tracking page using the shortcode provided by the plugin.
    
**6.  Pushing Orders to Shipping Provider:-** Plugin can automatically push new orders to your shipping provider’s panel for further processing. This enables current weight and dimension calculation to reduce weight discrepancy issues.
    
**7.  SMS & Email Notifications:-** Setup sms and email to send tracking notifications to customers. Email is free and sent via your own email server, however sms is a chargeable service. You can buy sms credits from plugin settings.
    
**8.  Advance Customizations:-** Plugin supports various developer actions and filters to programmatically access shipment data and customise various aspects of the plugin.

## Supported Shipping Aggregators

### Shiprocket

Shiprocket is a shipping logistics service provider that connects e-commerce businesses with courier services worldwide to help manage and track order shipments and returns. It's one of India's largest tech-enabled logistics and fulfillment platforms.

**Features supported:**

1.  Automatic tracking sync using webhook.
    
2.  Pushing orders to Shiprocket via API.
    
3.  Force sync tracking information from orders backend.
    
4.  Update awb number of an order from orders backend.
    
5.  Supports White Labelled Custom Tracking URL.

6.    Automatically Assign Courier company to pushed orders on Shiprocket.
    
7.  Realtime Delivery Estimate checker on Product pages.
    
8.  Dynamic shipping methods so users can select preferred courier during checkout.
    
9.  Auto fetch city and state from pincode during checkout.
    
10.  International Shipping Integration.
    
11.  Auto sync tracking info periodically using cron job.


### Shipmozo

Businesses can access a network of over 29,000 pin codes across India and international shipping to over 220 countries.

**Features supported:**

1.  Automatic tracking sync using webhook.
    
2.  Shipmozo API integration.
    
3.  Pushing orders to Shipmozo via API.
    
4.  Auto sync tracking info periodically using cron job.
    
5.  Realtime Delivery Estimate checker on Product pages.
    
6.  Dynamic shipping methods so users can select preferred courier during checkout.


### Nimbuspost

NimbusPost is  a logistics platform that connects entrepreneurs and startups with shipping solutions. It's a third-party logistics software and aggregator that offers shipping services, including international shipping, COD, and fulfillment services.

**Features**

1.  Automatic tracking sync using webhook.
    
2.  Nimbuspost API integration.
    
3.  Pushing orders to Nimbuspost via API.
    
4.  Auto sync tracking info periodically using cron job.
    
5.  Realtime Delivery Estimate checker on Product pages.
    
6.  Dynamic shipping methods so users can select preferred courier during checkout.
    
7.  Auto sync tracking info periodically using cron job.


### Xpressbees

Xpressbees is a logistics service provider in India that offers a variety of services, including:

-   B2B Xpress
-   Cross-border logistics
-   B2C Xpress
-   3PL (third-party logistics)

**Features**

1.    Automatic tracking sync using webhook.

2.    Multi-channel Communication

3.    Tracking Orders Widget

4.    Webhooks Configuration

5.    Shipment Status Page

6.    Customization and Settings

7.    Customer Support Integration 


### Delhivery

**Features**

1.    Automatic tracking syncing at periodic invervals.

2.    SMS & Email notifications

3.    Order Tracking Widget

4.    API Configuration

5.    Shipment Status Page

6.    Customization and Settings

7.    Customer Support Integration 

    
### Manual

If you handle your shipping needs yourself and does not rely on any specific shipping company, this plugin got you covered as well. Shipment related data be updated direct from backend or via your own application via webhooks.

**Features**

1.  Update tracking data from admin.
    
2.  Update tracking data via rest api provided by plugin.
    
3.  Set default courier name and awb number format.

4.  Branded Tracking Page.

5. Send tracking updates to customers via sms & email.

6. Estimated delivery checker widget.

7. Dynamic Shipping methods on checkout page.

Support for More Shipping Aggregators Coming Soon… [Contact us to get yours integrated](https://shipment-tracker-for-woocommerce.bitss.tech/contact-me/)

## Free Features of the plugin

1.  Tracking Notifications via Email.
    
2.  Beautiful Tracking Page using provided shortcode.
    
3.  Set default shipping provider.
    
4.  Automatically Change Status of Delivered Orders to Completed.
    
5.  Shiprocket Integration

    a.  Automatic tracking sync using webhook.
    
    b.  Pushing orders to Shiprocket via API.
    
    c.  Force sync tracking information from orders backend.
    
    d.  Update awb number of an order from orders backend.
    
    e.  Supports White Labelled Custom Tracking URL.
    
6.  Xpressbees Integration
    
    a.  Automatic tracking sync using webhook.

7.  Manual Shipping Integration.
    
     a.  Update tracking data from admin.
    
     b.  Update tracking data via rest api provided by plugin.
    
     c.  Set default courier name and awb number format.

8.  Delhivery Integration
    
    a.  Api integration.
    b.  Sync latest tracking data from delhivery.
    c.  Push orders with correct weight & dimensions to delhivery.
    

9.  Customize tracking updates email format.
    
10.  Update shipment tracking/movement data from any 3rd party platform using this rest api.
    
11.  Supports default shipment provider which will be automatically assigned to new orders.
    
12.  Notification SMS does not need a premium version, but sms credits needs to be bought separately.
    
13.  Automatically add Order Note (private or customer) when shipment status has changed.
    
14.  Developer actions and filters to access and update tracking information programmatically.
    
15.  Free Email Support.

## Additional Paid Features of the plugin

1.  Shiprocket Integration

       a.  Automatically Assign Courier company to pushed orders on Shiprocket.
    
       b.  Realtime Delivery Estimate checker on Product pages.
    
       c.  Dynamic shipping methods so users can select preferred courier during checkout.
    
       d.  Auto fetch city and state from pincode during checkout.
    
       e.  International Shipping Integration.
    
       f.  Auto sync tracking info periodically using cron job.
    

2.  Nimbuspost Integration

      a.  Automatic tracking sync using webhook.
    
      b.  Nimbuspost API integration.
    
      c.  Pushing orders to Nimbuspost via API.
    
      d.  Auto sync tracking info periodically using cron job.
    
      e.  Realtime Delivery Estimate checker on Product pages.
    
     f.  Dynamic shipping methods so users can select preferred courier during checkout.
    
    g.  Auto sync tracking info periodically using cron job.
    
3.  Shipmozo Integration
    
      a.  Automatic tracking sync using webhook.
    
      b.  Shipmozo API integration.
    
      c.  Pushing orders to Shipmozo via API.
    
      d.  Auto sync tracking info periodically using cron job.
    
      e.  Realtime Delivery Estimate checker on Product pages.
    
      f.  Dynamic shipping methods so users can select preferred courier during checkout.

4.  Delhivery Integration
    
      a.  Auto sync tracking info periodically using cron job.
    
      b.  Delhivery API integration.
    
      c.  Automatically Pushing orders to Delhivery via API.
    
      d.  Auto sync tracking info periodically using cron job.
    
      e.  Realtime Delivery Estimate checker on Product pages.
    
      f.  Dynamic shipping methods so users can select preferred courier during checkout.

5.  Show custom order processing time at product pages. This processing time will be added to the estimated delivery date as well.
    
6.  Show shipment weight during checkout.
    
7.  Automatically fetch city & state from pincode using Google Geocode API.
    
8.  Let customers track their order from the My Account section. Shows a beautiful tracking page within My Account section. No shortcode needed.
    
9.  Custom development assistance.

10.  Priority phone and ticket based support.

## Compatibility

Shipment Tracker for Woocommerce is compatible with a wide range of popular themes, website builders (such as Elementor, Visual Composer, Beaver Builder etc) and many other woocommerce plugins to give you a seamless experience.

Found any compatibility issue? Please report it to us, we’d be glad to fix it on priority.

##  Buy with Confidence

Our aim is to solve the challenges faced by website owners to make eCommerce an affordable, yet seamless experience by providing comprehensive tools that simplify order management, enhance customer satisfaction, and streamline shipping processes.

In case you are not satisfied with the plugin, reach out to us and we’ll do everything to make things right. If we’re unable to solve the issues, we’ll refund the entire amount paid by you if your request was raised within 7 days of the purchase.

##  Demo Videos

-[Setting Up Shipment Tracking Page, SMS & Email](https://youtu.be/bh12hRMlNR0)

-[Estimated Delivery Checker Widget](https://youtu.be/zj8YosIov5M)

-[Real Time Courier, Shipping Rates During Checkout](https://youtu.be/Kl3edHpGvV4)

-[Domestic And Interntional Shipping Rates](https://youtu.be/9ct2eT_gj6Q)

-[Shiprocket Integration](https://youtu.be/82EmgNCbZQ4)

-[Shipmozo Integration](https://youtu.be/2_ZMmayGtT0)

-[Nimbuspost Integration](https://youtu.be/3VMy2ZvpKa8)

-[Xpressbees Integration](https://youtu.be/Ej8eVcklyRE)

-[Setting up Direct Shipping](https://youtu.be/5KgUBOzd0I0)

## Need Expert Support?

We have a team of Expert Engineers ready to provide incredible support. Ask your questions in the support forum or create a support ticket at [billing.bitss.tech](https://billing.bitss.tech/)

##  Feature Requests are Welcome!

Got a feature that you’d like to see in the plugin? Just get in touch and our team will review it and will add in the future plugin updates.

##  Other must-have plugin by "Bitss Techniques":

1. **Otpfy for Wordpress**

   - Let your website users login into your website, effortlessly using SMS & Email OTP.
   - [Visit Website](https://otpfy.in)
   - [See Videos](https://www.youtube.com/playlist?list=PLzDSHgek2t1L35EqwSP341Y76SUTe3aQO)
   - [See Otpfy Docs](https://sites.bitss.tech/knowledge-base/docs/otpfy-for-wordpress/)

   <iframe width="560" height="315" src="https://www.youtube.com/embed/khMJzB16gfc?si=X_QTcx4fppr6vkLm" title="Otpfy for Wordpress" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>


## Developer Actions & Hooks

**1. Filter to add/modify Shipment Statuses defined in the plugin.**

    add_filter( 'bt_sst_shipping_statuses', 'bt_sst_shipping_statuses_filter', 10, 1 );
    function bt_sst_shipping_statuses_filter($statuses){
    	$statuses["packed"] = "Order Packed";
    	$statuses["dispatched"] = "Order Dispatched ";
    	return $statuses;
    }

    add_filter( 'bt_sst_shipping_status_message', 'bt_sst_shipping_status_message_filter', 10, 2 );
    function bt_sst_shipping_status_message_filter($status_message,$status){
    	if($status == "packed"){
    		$status_message = "Your order has been packed & will be dispatched soon.";
    	}else if($status == "dispatched"){
    		$status_message = "Our delivery agent is on the way to your location.";
    	}
    	return $status_message;
    }

    add_filter('bt_sst_product_page_delivery_checker_label_text', 'bt_sst_product_page_delivery_checker_label_text');
    function bt_sst_product_page_delivery_checker_label_text($content) {
		$content .= 'Select a delivery location to see product availability and delivery options';
		return $content;
	}
				
	add_filter('bt_sync_shimpent_track_pincode_checker_shipping_to_text', 'bt_sync_shimpent_track_pincode_checker_shipping_to_text');
	function bt_sync_shimpent_track_pincode_checker_shipping_to_text($content) {
		$content = 'Select a delivery location to see product availability and delivery options';
		return $content;
	}

**2. Tracking Widget Shortcode**

    [bt_shipping_tracking_form_2] 
    This shortcode accepts "order_id" parameter to show the tracking widget for a specific order.
    Example: [bt_shipping_tracking_form_2 order_id="1234"] 
    
**3. Shortcodes to Print Shipment Data**

     1. [bt_shipment_tracking_url order_id="1234"] : Prints the tracking url.
     2. [bt_shipment_status order_id="1234"] : Prints current shipment status (In Transit, Delivered etc)
     3. [bt_shipment_courier_name order_id="1234"] : Prints the courier name.
     4. [bt_shipment_edd order_id="1234"] : Prints estimated delivery date.
     5. [bt_shipment_awb order_id="1234"] : Prints awb number.

Note: Attribute "order_id" is optional on all shortcodes. If order_id is not supplied, the plugin will try to fetch it from current post.

**4. Placeholders to Print Shipment Data in Woocommerce Emails**

	 1. {bt_shipment_tracking_url}
	 2. {bt_shipment_status}
	 3. {bt_shipment_courier_name}
	 4. {bt_shipment_edd}
	 5. {bt_shipment_awb}

    
**5. Action for Shipment Updates**

    function bt_shipment_status_changed_callback( $order_id,$shipment_obj,$shipment_obj_old) {
    			//latest shipment tracking:
    			$courier_name = $shipment_obj->courier_name;
    			$current_status = $shipment_obj->current_status;
    			$awb = $shipment_obj->awb;
    			$tracking_url = $shipment_obj->tracking_url;
    
    			//previous shipment tracking:
    			$old_courier_name = $shipment_obj_old->courier_name;
    			$old_current_status = $shipment_obj_old->current_status;
    			$old_awb = $shipment_obj_old->awb;
    			$old_tracking_url = $shipment_obj_old->tracking_url;
    
    			// do stuff
    
    		}
    add_action( 'bt_shipment_status_changed', 'bt_shipment_status_changed_callback', 10, 3 );

**6. Public Functions**

    1. bt_get_shipping_tracking($order_id);
    2. bt_force_sync_order_tracking($order_id);
    3. bt_update_shipment_tracking($order_id,$courier_name,$awb_number,$shipping_status,$edd,$tracking_link);


Disclaimer: Woocommerce, Shiprocket, Shipmozo, Shyplite, Xpressbees & Nimbuspost are registered trademarks and belong to their respective owners. This plugin is not affiliated with them in any way.


== Installation ==

1. In your WordPress admin panel, go to Plugins > New Plugin, search for \'Shipment Tracker\' and click “Install now“
2. Alternatively, download the plugin and upload the contents of shipment-tracker.zip to your plugins directory, which usually is /wp-content/plugins/.
3. Activate the plugin
4. Enable the desired shipment aggregator (Shiprocket, Shyplite, Nimbuspost or Manual), then click Save.
4. Set your API keys of enabled shipping providers in their respective Tab.

== Frequently Asked Questions ==

= What is Shipment Tracker for WooCommerce? =

Shipment Tracker for WooCommerce is a comprehensive plugin designed to manage all aspects of shipment tracking directly from your WooCommerce store. It integrates seamlessly, providing a unified solution without the need for multiple plugins.

= What are the main benefits of using Shipment Tracker for WooCommerce? =

The plugin aims to boost sales by enhancing the tracking experience, improve customer satisfaction through timely notifications, and reduce support requests by offering automated tracking updates and self-service options.

= How does it handle SMS and email notifications? =

The plugin supports sending tracking updates via SMS and email. Email notifications are free and sent via your own email server, while SMS notifications require purchasing SMS credits from the plugin settings.

= Can I customize the tracking page to match my brand's style? =

Yes, the plugin offers customizable tracking pages where you can personalize the look and feel to align with your brand.

= How do I install Shipment Tracker for WooCommerce? =

You can install the plugin directly from the WordPress plugins repository. Detailed installation instructions are provided in the plugin documentation.

= How do I set up shipping providers? =

In the general settings, you can select your shipping provider(s) and set up webhook and API keys as required. The plugin supports integration with various shipping aggregators and also allows manual setup for any courier company.

= Can I configure estimated delivery dates and shipping charges? =

Yes, you can set up estimated delivery dates and shipping charges based on delivery pin codes directly on the product page

= What tracking information can customers see? =

Customers can track orders from the My Account section, viewing details such as shipment status, estimated delivery date, courier name, AWB number, and tracking link.

= Can I customize email templates for notifications? =

Yes, you can customize email templates directly from the WooCommerce Settings to tailor notifications according to your preferences.

= Is Shipment Tracker for WooCommerce compatible with other plugins and themes? =

Yes, the plugin is designed to be compatible with a variety of popular themes, website builders (e.g., Elementor, Visual Composer), and other WooCommerce plugins for a seamless user experience.

= How can I get support if I encounter issues or have questions? =

You can reach out to our support team through the support forum or create a support ticket at billing.bitss.tech. We also offer priority phone and ticket-based support for advanced assistance.

= What if I'm not satisfied with the plugin? =

We strive to ensure your satisfaction with the plugin. If issues cannot be resolved, we offer a full refund if requested within 7 days of purchase.

= Is international shipping supported by Shipment Tracker? =

Yes, it supports international shipping, ensuring businesses can manage both domestic and international orders seamlessly.

= Can customers track their orders directly from their accounts? =

Yes, customers can track their orders conveniently from the My Account section of your WooCommerce store.

= How does Shipment Tracker handle order processing times? =

It allows you to set order processing days at global, category, or product levels, providing flexibility in managing order fulfillment.

= Is there a fallback option for shipping rates if auto rates are not available? =

Yes, you can set fallback rates when automated shipment rates are not accessible, ensuring consistency in shipping cost calculations.

= Does Shipment Tracker support webhook integration? =

Yes, it supports webhook integration for automatic tracking sync with supported shipping aggregators like Shiprocket and NimbusPost.

= How does Shipment Tracker handle dynamic shipping methods during checkout? =

It allows customers to choose their preferred courier company based on estimated delivery dates and charges directly during checkout.

= Can I print shipment data in WooCommerce emails using shortcodes? =

Yes, you can use shortcodes to print shipment tracking URLs, status, courier name, estimated delivery date, and AWB number in emails.

= Can I set default shipping providers for new orders in Shipment Tracker? =

Yes, you can set default shipping providers that will be automatically assigned to new orders unless otherwise specified.

= How does Shipment Tracker integrate with Shiprocket? =

It integrates with Shiprocket for automatic order pushing, real-time delivery estimates, dynamic shipping methods, and more.

= Does Shipment Tracker integrate with NimbusPost? =

Yes, it integrates with NimbusPost for features like automatic tracking sync, API integration, real-time delivery estimates, and dynamic shipping methods.

= Is there support for manual shipping integration in Shipment Tracker? =

Yes, manual shipping integration allows you to update tracking data manually from the admin or via REST API provided by the plugin.

= Can Shipment Tracker fetch city and state details automatically based on pin codes? =

Yes, it can auto-fill city and state details during checkout by fetching data from pin codes using Google Geocode API.

= Does Shipment Tracker offer custom development assistance? =

Yes, it provides custom development assistance to tailor the plugin to specific business needs or integration.

= How can I request new features for Shipment Tracker? =

You can submit feature requests to the support team, who will review and consider them for future plugin updates

= What is Shiprocket's Automatic Tracking Sync? =

Shiprocket offers automatic tracking sync using webhooks, ensuring real-time updates on shipment statuses directly from the courier.

= How does Shiprocket handle order pushing via API? =

Shiprocket allows seamless integration by pushing orders from your WooCommerce store to their platform using APIs for efficient order management.

= Can I update AWB numbers of orders with Shiprocket? =

Yes, Shiprocket enables you to update AWB numbers directly from your orders backend, ensuring accurate tracking information.

= What is a White Labelled Custom Tracking URL on Shiprocket? =

Shiprocket supports White Labelled Custom Tracking URLs, allowing you to customize the tracking page URL with your brand's identity.

= How does Shiprocket handle international shipping? =

Shiprocket integrates international shipping capabilities, enabling businesses to manage and track shipments globally.

= What is Shipmozo's approach to order tracking? =

Shipmozo utilizes webhooks for automatic tracking sync and API integration for pushing orders, complemented by periodic syncs for updated information.

= How can I offer dynamic shipping methods with Shipmozo? =

Shipmozo allows customers to select preferred couriers during checkout with dynamic shipping methods tailored to delivery timelines and options.

= Does Shipmozo support real-time delivery estimates? =

Yes, Shipmozo provides real-time delivery estimates directly on the product pages, helping customers make informed decisions.

= How does Nimbuspost ensure accurate order tracking? =

Nimbuspost utilizes webhooks for automatic tracking updates and API integration for pushing orders, ensuring real-time shipment information.

= How can I customize shipping methods with Nimbuspost? =

Nimbuspost allows users to select preferred couriers during checkout with dynamic shipping methods based on delivery preferences.

= What is the Tracking Orders Widget on Xpressbees? =

Xpressbees offers a Tracking Orders Widget for easy access to shipment statuses and tracking details directly from your WooCommerce store.

= How can I view shipment status directly from the order list? =

You can easily view the shipment status of orders directly from the order list in the WooCommerce admin panel. It provides a quick overview of where each order stands in terms of shipping.

= Is it possible to filter orders based on shipment statuses? =

Yes, you can filter orders based on various shipment statuses such as in transit, out for delivery, delivered, etc. This helps in efficiently managing orders based on their current shipping stages.

= Can I add shipment details like AWB number and courier information from the backend? =

Absolutely, you have the capability to add essential shipment data like AWB numbers, courier names, estimated delivery dates, and more directly from the WooCommerce backend.

= How do customers access the tracking page to monitor their orders? =

Customers can access a beautifully designed tracking page either through their My Account section on your WooCommerce store or via a provided tracking link.

= What information does the tracking widget display to customers? =

The tracking widget displays essential details such as shipment status, estimated delivery date, courier name, AWB number, and a direct link for real-time tracking.

= Is the tracking widget customizable to match my store's branding? =

Yes, the tracking widget is customizable to align with your store's branding guidelines, ensuring a seamless customer experience throughout the tracking process.

= Can customers track both domestic and international orders using the widget? =

Absolutely, customers can track both domestic and international orders through the tracking widget, providing transparency and peace of mind regardless of location.

= How does the system calculate accurate weight and dimensions for shipments? =

The system utilizes advanced algorithms to calculate precise weight and dimensions for shipments, ensuring accurate shipping costs and logistics planning.

= How developer-friendly is the system for integrating shipment data into custom PHP code? =

The system offers various developer options such as actions, public functions, and shortcodes, allowing seamless integration of shipment data into custom PHP code for enhanced functionality.

= How secure is the tracking page in terms of customer data privacy? =

The tracking page adheres to strict privacy standards to ensure the security of customer data. It does not store sensitive information beyond what is necessary for tracking purposes, maintaining customer trust and confidentiality.


== Screenshots ==

1. Order Tracking Form for customers
2. Order Tracking widget on tracking page and myaccount pages
3. Tracking details sent on email
4. Delivery estimate calculator widget
5. Dynamic Shipping methods on cart and checkout pages
6. SMS & Email configuration
7. Shipment Tracking Metabox in Order details page.
8. Updating shipment details for an order (when not using any aggregator).
9. Updating shipment details from order details page (when not using any aggregator).
10. Tracking information in Woocommerce->Orders page in admin.
11. Tracking Widget configuration
12. Shiprocket configuration
13. Delivery Estimate Widget configuration
14. Dynamic Shipping methods configuration
15. Filter orders based on shipping status
16. Shipment updates in Order notes



== Changelog ==
= 1.4.18 - 2024.09.15 =
1. Feature to show "Rate us" widget in tracking page.
2. Feature to show "Map" of pickup and delivery location along with estimated delivery date in tracting page.
3. Feature to share tracking data via WhatsApp.
4. CSS improvements in tracking page.
5. Bug Fixes.
= 1.4.17 - 2024.09.01 =
1. Feature to set timer in estimated delivery checker widget. (eg: If ordered within 16 hrs 59 mins.)
2. Feature to add a CTA to "Rate us" at the footer of tracking widget.
3. Send shipment tracking updates to third party using Woocommerce Webook (Topic: Shipment Updated).
4. CSS improvements in tracking page.
5. Bug Fixes.
= 1.4.16 - 2024.08.19 =
1) Delhivery Integration is now LIVE!
2) Improvement in Fallback Rate Calculation. Now fallback rates are per 500 gram, instead of flat.
3) Integration with woocommerce checkout blocks.
4) Other bug fixes and improvements.
= 1.4.13 - 2024.07.28 =
1) Bug Fixes in SMS purchase.
= 1.4.11 - 2024.07.26 =
1) Bug Fixes.
2) Improvements in readme of plugin.
= 1.4.10 - 2024.07.23 =
1) Added developer filters to customize the text of the delivery estimate checker widget.
2) Improvements in developer shortcode [bt_estimated_delivery_widget] to place delivery estimate checker widget anywhere on the website.
3) Improvements in sms feature.
= 1.4.9 - 2024.07.22 =
1) Bug fix in Nimbuspost dynamic shipping methods.
2) Added shortcode [bt_estimated_delivery_widget] to place "Estimated Delivery Checker Widget" anywhere on your website.
= 1.4.8 - 2024.07.18 =
1) Several bug fixes and performance improvements.
= 1.4.7 - 2024.06.28 =
1) Feature to send shipment tracking updates via email.
2) Bug fixes in "Processing time" feature.
3) Improvements in Order Tracking Shortcode.
4) Fixes in Shipmozo integration.
5) Css fixes.
6) New ux for order tracking widget.
= 1.4.6 - 2024.06.24 =
1) Feature to test shipment tracking sms from plugin settings.
= 1.4.5 - 2024.06.18 =
1) Bug Fixes in SMS registration
= 1.4.4 - 2024.06.17 =
1) Feature to auto sync tracking from respective courier partners.
2) Now send tracking updates via SMS.
3) Improved Woocommerce HPOS compatibility.
4) Few bug fixes and performance improvements
5) cosmetic fixes in pincode checker.
6) Feature to select default courier company for Shiprocket, so all new orders are by default booked by selected courier.
= 1.4.3 - 2024.05.13 =
1) Fixes in Xpressbees webhook.
2) Nimbuspost new API and Websook integration.
3) Proactively Push Orders from your store to Nimbuspost, improved weebhook handling.
4) Few bug fixes and improvements
= 1.4.2 - 2024.04.24 =
1) Implemented cache for shipmozo and shiprocket apis.
2) Shipmozo integration for Delivery Estimate Checker and Shipping Methods integration.
3) Few bug fixes and improvements
= 1.4.1 - 2024.04.18 =
1) Improvements in shipmozo integration
= 1.3.16 - 2024.04.06 =
1) Fix for compatibility with Shiprocket apis
2) Other bug fixes and improvements
= 1.3.15 - 2024.03.15 =
1) Bug fixes.
2) Fix bug in pushing order to shiprocket when two products having same sku results in api error.
3) Added option to show "Processing time" on Product Page.
= 1.3.14 - 2024.02.24 =
1) Bug fixes.
= 1.3.12 - 2024.01.02 =
1) Added shortcodes for getting shipment related data for current order or by passing order_id as attribute.
2) Added woocommerce email placeholders for adding shipment related data to email templates.
3) Ability to set processing time at product variation level. Processing time is used to show estimated delivery date at product/checkout pages.
4) Tracking widget's shortcode now accepts "Order_id" attribute to show tracking widget of a specific order.
5) Few performance improvements.
= 1.3.11 - 2024.01.18 =
1) Define custom processing time (before shipping) at product or product category level. Processing time is used to show estimated delivery date at product/checkout pages.
2) Few Bug fixes.
= 1.3.10 - 2024.01.01 =
1) Show track option in my account order list, without any shortcode.
2) Added developer filters to modify shipment statuses available in the plugin.
3) Performance Improvements & Bug fixes.
= 1.3.9 - 2024.01.01 =
1) Xpressbees integration.
2) Performance Improvements & Bug fixes.
= 1.3.8 - 2023.10.30 =
1) New Order Tracking widget for customers.
2) Performance Improvements & Bug fixes.
3) Caching pincode and courier data from aggregators.
4) Fixes in Estimated delivery checker.
5) Support for International Shipping Rates
= 1.3.6 - 2023.07.14 =
1) "Estimated Delivery Checker" on product pages.
2) Let users pick their prefered courier while placing order.
3) Show courier wise estimated delivery dates on checkout page. 
4) Many more premium features.
= 1.3.5 - 2023.06.01 =
1) Bug Fixes and Security Improvements.
2) Ability to test connection to Shiprocket apis.
3) Let user choose the desired courier company for shipping during checkout.
4) Automatically assign courier to pushed order in shiprocket, based on user's choice during checkout.
5) Estimate Delivery Date Checker on Product Page.
6) Autofill City and State based on Pincode entered by user.
7) Show total shipment weight on Cart and Checkout pages.
8) Many more premium features coming soon.
= 1.3.4 - 2023.01.07 =
1) Feature to push orders to shiprocket.
2) Calculate overall dimension and weight of all products, when pushing to shiprocket.
3) Convert the dimension to cm and weight to kg, when pushing to shiprocket.
4) Automatically assign courier to pushed order in shiprocket (requires Shiprocket official plugin)
5) Minor fixes
= 1.3.3 - 2022.09.22 =
1) Added support for whitelabeled tracking url for shiprocket.
2) Support for Global Tracking URL for manual shipments.
3) Moved "Shipment Tracking" menu from Settings to Woocommerce.
4) Fixed css issue in settings page for mobile.
5) Added option to change Shipment Provider from order actions widget in sidebar.
6) Fixes in tracking data layout in customer's my-account orders page.
7) Added Rest API to update tracking data from any 3rd party service.
8) Fix in Order notes tracking link so it works well on whatsapp.
9) Added new variable for tracking link to render just the link without anchor or any html.
10)Added new public php function to programatically update shipment data of an order.
11) Bug Fixes
12) Improvements in developer doc.
= 1.3.2 - 2022.06.01 =
1) Fix in Shiprocket syncing for orders when its shipment has not been picked up by the courier.
2) Better Developer Docs
3) Wordpress 6.0 support
4) Few bug fixes
= 1.3.1 - 2022.03.10 =
1) Fix empty settings page issue on some wordpress installations.
2) Implemented Feedback/Review system for users.
3) Fix to support custom order statuses. There was a limitation due to which orders with non default status were not synced.
4) Bug fix in php function 'get_tracking_by_order_id'.
5) Fixes in shipment tracking shortcode for front-end.
6) Several other improvements & fixes.
= 1.2.4 - 2022.01.31 =
1) Dedicated metabox for shipment tracking. Now get all your shipment tracking information in one place.
2) Ability to explicitly set awb number to orders, useful in many scenarios.
3) Fixes in nimbuspost syncing and webhook receiver.
4) Fixes in shiprocket syncing and webhook receiver.
5) Added support to track orders via awb.
6) Several code improvements & cleanup.
7) Added hook "bt_shipment_status_changed" which is called whenever order status is changed.
= 1.2.3 - 2021.11.06 =
1) Add nimnubspost shipping provider integration.
2) Feature to force sync shipment tracking information of the order.
3) Support for fallback webhook url for shiprocket.
4) Added shortcode [bt_shipping_tracking_form] of shippment tracking for website.
5) Added a "manual" shipping provider for custom shipment of the order.
6) Added new functions bt_get_shipping_tracking() and bt_force_sync_order_tracking() for developers.
7) Added hook "bt_shipment_status_changed" which is called whenever order status is changed.
= 1.2.0 - 2021.06.11 =
1) Added tracking info in my-account->orders
2) Feature to add tracking updates as order notes.
3) Support for fallback webhook url for shiprocket.
= 1.1.0 - 2021.03.05 =
* Wordpress 5.7 support. 
* Fixes in Shyplite syncing.
= 1.0.0 - 2021.02.03 =
* Initial release!
== Upgrade Notice ==

