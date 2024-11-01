<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://amitmittal.tech
 * @since      1.0.0
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/includes
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
class Bt_Sync_Shipment_Tracking {

	const BITSSLOGO ='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOYAAAAyCAYAAABIxaeCAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MjlDOERGRkFCN0YxMTFFMzgwMkVFQ0NFOUU5RkNBMDciIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MjlDOERGRkJCN0YxMTFFMzgwMkVFQ0NFOUU5RkNBMDciPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDoyOUM4REZGOEI3RjExMUUzODAyRUVDQ0U5RTlGQ0EwNyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDoyOUM4REZGOUI3RjExMUUzODAyRUVDQ0U5RTlGQ0EwNyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pu0ct6MAADrzSURBVHja7H0HtCRX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';
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Bt_Sync_Shipment_Tracking_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	private $shiprocket;
	private $shipmozo;
	private $delhivery;
	private $shyplite;
	private $crons;
    private $nimbuspost;
	private $nimbuspost_new;
	private $xpressbees;
    private $manual;
    private $ship24;
	private $licenser;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BT_SYNC_SHIPMENT_TRACKING_VERSION' ) ) {
			$this->version = BT_SYNC_SHIPMENT_TRACKING_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'bt-sync-shipment-tracking';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_cron_events();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_rest_apis();
		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
	}

	public static function bt_sst_update_order_meta($order_id, $meta_key, $meta_value) {
		// Get the order object
		$order = wc_get_order($order_id);
	
		if ($order) {
			// Update the meta data
			$order->update_meta_data($meta_key, $meta_value);
	
			// Save the order to persist the changes
			$order->save();
		} else {
			// Handle the case where the order is not found
			//error_log("Order not found: " . $order_id);
		}
	}

	public static function bt_sst_update_product_meta($product_id, $meta_key, $meta_value) {
		
		$product = wc_get_product($product_id);

		if ($product) {

			// Update the product meta data
			$product->update_meta_data($meta_key, $meta_value);

			// Save the product to persist changes
			$product->save();
		}
	}

	public static function bt_sst_get_product_meta($product_id, $meta_key) {
		
	
		$product = wc_get_product($product_id);

		if ($product) {

			return $product->get_meta($meta_key);

		} else {
			return null;
		}
	}

	public static function bt_sst_get_order_meta($order_id, $meta_key) {
		// Get the order object
		$order = wc_get_order($order_id);
	// echo "<pre>"; print_r($order); die;
		if ($order) {
			// Get the meta data
			$meta_value = $order->get_meta($meta_key);
	
			return $meta_value;
		} else {
			// Handle the case where the order is not found
			error_log("Order not found: " . $order_id);
			return null;
		}
	}

	public static function bt_sst_delete_order_meta($order_id, $meta_key) {
		// Get the order object
		$order = wc_get_order($order_id);
	
		if ($order) {
			// Delete the meta data
			$order->delete_meta_data($meta_key);
	
			// Save the order to persist the changes
			$order->save();
		} else {
			// Handle the case where the order is not found
			error_log("Order not found: " . $order_id);
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Bt_Sync_Shipment_Tracking_Loader. Orchestrates the hooks of the plugin.
	 * - Bt_Sync_Shipment_Tracking_i18n. Defines internationalization functionality.
	 * - Bt_Sync_Shipment_Tracking_Admin. Defines all hooks for the admin area.
	 * - Bt_Sync_Shipment_Tracking_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) )  . '/vendor/autoload.php';
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bt-sync-shipment-tracking-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bt-sync-shipment-tracking-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/models/class-bt-sync-shipment-tracking-shipment-model.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-bt-sync-shipment-tracking-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-bt-review.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shipping_providers/shiprocket.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shipping_providers/shipmozo.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shipping_providers/delhivery.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shipping_providers/shyplite.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shipping_providers/nimbuspost.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shipping_providers/nimbuspost_new.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shipping_providers/xpressbees.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shipping_providers/manual.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shipping_providers/ship24.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-bt-sync-shipment-tracking-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bt-sync-shipment-tracking-rest.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bt-sync-shipment-tracking-crons.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bt-sync-shipment-tracking-admin-ajax-functions.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/licenser/class-bt-licenser.php';

		$this->loader = new Bt_Sync_Shipment_Tracking_Loader();
		$this->shiprocket = new Bt_Sync_Shipment_Tracking_Shiprocket();
		$this->shipmozo = new Bt_Sync_Shipment_Tracking_Shipmozo();
		$this->delhivery = new Bt_Sync_Shipment_Tracking_Delhivery();
		$this->shyplite = new Bt_Sync_Shipment_Tracking_Shyplite();
        $this->nimbuspost = new Bt_Sync_Shipment_Tracking_Nimbuspost();
		$this->nimbuspost_new = new Bt_Sync_Shipment_Tracking_Nimbuspost_new();
		$this->xpressbees = new Bt_Sync_Shipment_Tracking_Xpressbees();
        $this->manual = new Bt_Sync_Shipment_Tracking_Manual();
        $this->ship24 = new Bt_Sync_Shipment_Tracking_Ship24();
		$this->licenser = new Bt_Licenser();
        ( new Bt_Sync_Shipment_Tracking_Review() )->hooks();
	}

	/**
	 * Defines cron events
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_cron_events() {

		$this->crons = new Bt_Sync_Shipment_Tracking_Crons($this->shiprocket,$this->shyplite,$this->nimbuspost_new,$this->shipmozo, $this->licenser, $this->delhivery, $this->ship24);

		$this->loader->add_action( Bt_Sync_Shipment_Tracking_Crons::BT_MINUTELY_JOB, $this->crons, 'minutely_job');
		$this->loader->add_action( Bt_Sync_Shipment_Tracking_Crons::BT_15MINS_JOB, $this->crons, 'bt_every_15_minutes_job');
		$this->loader->add_action( Bt_Sync_Shipment_Tracking_Crons::BT_1HOUR_JOB, $this->crons, 'bt_every_1_hour_job');
		$this->loader->add_action( Bt_Sync_Shipment_Tracking_Crons::BT_4HOURS_JOB, $this->crons, 'bt_every_every_4_hours_job');
		$this->loader->add_action( Bt_Sync_Shipment_Tracking_Crons::BT_DAILY_JOB, $this->crons, 'bt_daily_job');
		//$this->loader->add_action( 'admin_init', $this->crons, 'validate_license');

	}

	/**
	 * Defines rest apis generated by the plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_rest_apis() {

		$rest = new Bt_Sync_Shipment_Tracking_Rest( $this->get_plugin_name(), $this->get_version(), $this->shiprocket, $this->shyplite, $this->nimbuspost, $this->manual, $this->xpressbees, $this->shipmozo, $this->nimbuspost_new, $this->ship24);

		//shiprocket webhook & apis
		$this->loader->add_action( 'rest_api_init', $rest, 'rest_shiprocket_webhook');
		$this->loader->add_action( 'init', $rest, 'generate_random_webhook_string');

		//shipmozo webhook & apis
		$this->loader->add_action( 'rest_api_init', $rest, 'rest_shipmozo_webhook');

		//shyplite
		$this->loader->add_action( 'rest_api_init', $rest, 'rest_shyplite');
		//$this->loader->add_action( 'rest_api_init', $rest, 'rest_shiprocket_get_postcode');

        //nimbuspost webhook & apis
        $this->loader->add_action( 'rest_api_init', $rest, 'rest_nimbuspost_webhook');
        $this->loader->add_action( 'init', $rest, 'generate_random_webhook_secret_key');

		//xpressbees webhook & apis
        $this->loader->add_action( 'rest_api_init', $rest, 'rest_xpressbees_webhook');
        $this->loader->add_action( 'init', $rest, 'generate_random_webhook_secret_key');
		//xpressbees webhook & apis

        $this->loader->add_action( 'rest_api_init', $rest, 'rest_ship24_webhook');
        $this->loader->add_action( 'init', $rest, 'generate_random_webhook_secret_key');

		//manual provider webhook & apis
        $this->loader->add_action( 'rest_api_init', $rest, 'rest_manual_webhook');
        $this->loader->add_action( 'init', $rest, 'generate_random_manual_webhook_secret_key');

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Bt_Sync_Shipment_Tracking_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Bt_Sync_Shipment_Tracking_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Bt_Sync_Shipment_Tracking_Admin( $this->get_plugin_name(), $this->get_version(),$this->shiprocket,$this->shyplite, $this->nimbuspost, $this->manual, $this->licenser, $this->shipmozo, $this->nimbuspost_new, $this->delhivery, $this->ship24 );
		$this->loader->add_action( 'dokan_order_detail_after_order_general_details',$plugin_admin, 'custom_dokan_order_details', 10, 1 );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'manage_shop_order_posts_custom_column', $plugin_admin, 'custom_orders_list_column_content', 20, 2);
		$this->loader->add_action( 'manage_woocommerce_page_wc-orders_custom_column', $plugin_admin, 'custom_orders_list_column_content_hpos', 20, 2);
		

		$this->loader->add_filter( 'manage_edit-shop_order_columns', $plugin_admin, 'custom_shop_order_column' );
		$this->loader->add_filter( 'manage_woocommerce_page_wc-orders_columns', $plugin_admin, 'custom_shop_order_column' );


		$this->loader->add_action( 'admin_menu', $plugin_admin, 'plugin_admin_menu' );
		$this->loader->add_action( 'woocommerce_order_actions_end', $plugin_admin, 'woocommerce_order_actions_end' );
		$this->loader->add_action( 'woocommerce_order_action_update_bt_sst_shipping_provider', $plugin_admin, 'woocommerce_order_action_update_bt_sst_shipping_provider' );
		$this->loader->add_action( 'woocommerce_admin_order_data_after_shipping_address', $plugin_admin, 'show_order_shipping_admin' );
        $this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_meta_boxes' );
		$this->loader->add_action( 'woocommerce_process_shop_order_meta', $plugin_admin, 'woocommerce_process_shop_order_meta' );
		$this->loader->add_action( 'after_setup_theme', $this, 'crb_load' );
		$this->loader->add_action( 'carbon_fields_register_fields', $this, 'crb_attach_theme_options' );
		$this->loader->add_action( 'woocommerce_order_status_processing', $plugin_admin, 'woocommerce_order_status_processing',20,1 );
		$this->loader->add_action( 'woocommerce_order_status_on-hold', $plugin_admin, 'woocommerce_order_status_on_hold' );
		$this->loader->add_action( 'init', $this->crons, 'schedule_recurring_events');

		$this->loader->add_action( 'admin_init', $plugin_admin, 'handle_admin_init');
		//$this->loader->add_action( 'init', $plugin_admin, 'register_shipment_arrival_order_status');
		//$this->loader->add_filter( 'wc_order_statuses', $plugin_admin, 'add_awaiting_shipment_to_order_statuses' );

		$this->loader->add_action( 'bt_shipment_status_changed', $plugin_admin, 'bt_shipment_status_changed',10,3);
		$this->loader->add_action( 'bt_push_order_to_shiprocket', $plugin_admin, 'push_order_to_shiprocket',10,3);
		$this->loader->add_action( 'bt_push_order_to_shipmozo', $plugin_admin, 'push_order_to_shipmozo',10,3);
		$this->loader->add_action( 'bt_push_order_to_delhivery', $plugin_admin, 'push_order_to_delhivery',10,3);
		$this->loader->add_action( 'bt_push_order_to_nimbuspost', $plugin_admin, 'push_order_to_nimbuspost',10,3);

		$ajax_functions = new Bt_Sync_Shipment_Tracking_Admin_Ajax_Functions($this->crons, $this->shiprocket, $this->shyplite, $this->nimbuspost, $this->manual, $this->licenser, $this->delhivery, $this->ship24 );
		$this->loader->add_action( 'wp_ajax_sync_now_shyplite', $ajax_functions, 'bt_sync_now_shyplite',10,2);

        $this->loader->add_action('wp_ajax_force_sync_tracking',$ajax_functions, 'force_sync_tracking');
        $this->loader->add_action('wp_ajax_bt_get_tracking_data',$ajax_functions, 'get_tracking_data_from_db');
        $this->loader->add_action('wp_ajax_nopriv_bt_get_tracking_data',$ajax_functions, 'get_tracking_data_from_db');
        $this->loader->add_action('wp_ajax_bt_tracking_manual',$ajax_functions, 'bt_tracking_manual');
        $this->loader->add_action('wp_ajax_save_order_awb_number',$ajax_functions, 'save_order_awb_number');
        $this->loader->add_action('wp_ajax_post_customer_feedback_to_sever',$ajax_functions, 'post_customer_feedback_to_sever');

		$this->loader->add_action('wp_ajax_create_and_add_tracking_page',$ajax_functions, 'create_and_add_tracking_page');
		/**Check user data for premium features of plugin on checkout tab */
		$this->loader->add_action('wp_ajax_get_coriers_name_for_ship24', $plugin_admin,'get_coriers_name_for_ship24');  // For logged-in users
		$this->loader->add_action('wp_ajax_nopriv_get_coriers_name_for_ship24', $plugin_admin, 'get_coriers_name_for_ship24'); 
		// $this->loader->add_action('wp_ajax_stw_wizard_form_data_save', $plugin_admin, 'handle_stw_wizard_form_data_save');
		$this->loader->add_action('wp_ajax_handle_stw_wizard_form_data_save',$plugin_admin,  'handle_stw_wizard_form_data_save'); // For non-logged in users
		
		$this->loader->add_action( 'wp_ajax_download_label_pdf', $plugin_admin, 'download_label_pdf' );
		$this->loader->add_action( 'wp_ajax_check_user_data_for_premium_features', $plugin_admin, 'check_user_data_for_premium_features' );
		$this->loader->add_action( 'wp_ajax_api_call_for_test_connection', $plugin_admin, 'api_call_for_test_connection' );
		$this->loader->add_action( 'wp_ajax_api_call_for_delhivery_test_connection', $plugin_admin, 'api_call_for_delhivery_test_connection' );
		$this->loader->add_action( 'wp_ajax_api_call_for_ship24_test_connection', $plugin_admin, 'api_call_for_ship24_test_connection' );
		$this->loader->add_action( 'wp_ajax_get_sms_trial', $plugin_admin, 'get_sms_trial' );
		$this->loader->add_action( 'wp_ajax_get_bt_sst_email_trial', $plugin_admin, 'get_bt_sst_email_trial' );
		$this->loader->add_action( 'wp_ajax_api_call_for_sync_order_by_order_id', $plugin_admin, 'api_call_for_sync_order_by_order_id' );
		$this->loader->add_action( 'wp_ajax_api_call_hide_bt_sst_premium_notice', $plugin_admin, 'api_call_hide_bt_sst_premium_notice' );
		$this->loader->add_action( 'wp_ajax_api_call_for_shipmozo_test_connection', $plugin_admin, 'api_call_for_shipmozo_test_connection' );
		$this->loader->add_action( 'wp_ajax_api_check_for_nimbuspost_test_connection', $plugin_admin, 'api_check_for_nimbuspost_test_connection' );
		$this->loader->add_action( 'wp_ajax_buy_credit_balance', $plugin_admin, 'buy_credit_balance' );
		$this->loader->add_action( 'wp_ajax_credit_balance_details', $plugin_admin, 'credit_balance_details' );
		$this->loader->add_action( 'wp_ajax_register_for_sms', $plugin_admin, 'register_for_sms' );
		$this->loader->add_action( 'wp_ajax_bt_sst_get_users_list', $plugin_admin, 'bt_sst_get_users_list' );
		$this->loader->add_action( 'wp_ajax_bt_sst_set_users_list', $plugin_admin, 'bt_sst_set_users_list' );
		$this->loader->add_action( 'wp_ajax_bt_sst_check_users_list', $plugin_admin, 'bt_sst_check_users_list' );
		$this->loader->add_filter( 'woocommerce_email_classes', $plugin_admin, 'register_shipment_email' );
	
		// Add a dropdown to filter orders by state
		$this->loader->add_action( 'restrict_manage_posts', $plugin_admin, 'add_shop_order_filter_by_shipment_status' );
		$this->loader->add_filter( 'request', $plugin_admin, 'process_admin_shop_order_filtering_by_shipment_status', 99 );

		// Adding to admin order list bulk dropdown a custom action 'custom_downloads'
		//$this->loader->add_filter( 'bulk_actions-edit-shop_order', $plugin_admin, 'bulk_actions_edit_shop_order_bulk_sync', 20, 1 );
		// Make the action from selected orders
		$this->loader->add_filter( 'handle_bulk_actions-edit-shop_order', $plugin_admin, 'downloads_handle_bulk_action_edit_shop_order', 10, 3 );
		// The results notice from bulk action on orders
		$this->loader->add_filter( 'admin_notices', $plugin_admin, 'downloads_bulk_action_admin_notice', 10, 3 );
		$this->loader->add_filter( 'admin_notices', $plugin_admin, 'admin_notices', 10, 3 );
		// $this->loader->add_filter('woocommerce_webhook_topics', $plugin_admin, 'add_shipment_updated_webhook_topic', 1, 1);
		$this->loader->add_filter( 'woocommerce_webhook_topic_hooks',$plugin_admin,  'add_new_topic_hooks' ,10,2);
		$this->loader->add_filter( 'woocommerce_valid_webhook_events',$plugin_admin,  'add_new_topic_events' ,10,2);
		$this->loader->add_filter( 'woocommerce_webhook_topics',$plugin_admin,  'add_new_webhook_topics',10,2 );
		// $this->loader->add_action( 'admin_footer', $plugin_admin, 'my_admin_footer_function' );		
		$this->loader->add_action( 'wp_ajax_get_st_form_with_data', $plugin_admin, 'get_st_form_with_data' );

		$this->loader->add_action( 'admin_footer', $plugin_admin, 'my_admin_footer_function' );	

		//processing time at product level
		$this->loader->add_action( 'woocommerce_product_options_shipping', $plugin_admin, 'add_product_processing_time_shipping_field' );	
		$this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin, 'save_product_processing_time_shipping_field' );	

		//processing time at variable product level
		$this->loader->add_action( 'woocommerce_product_after_variable_attributes', $plugin_admin, 'add_variable_product_processing_time_shipping_field',10,3 );	
		$this->loader->add_action( 'woocommerce_save_product_variation', $plugin_admin, 'save_variable_product_processing_time_shipping_field', 10, 2  );	

		//processing time at product category level
		$this->loader->add_action( 'product_cat_add_form_fields', $plugin_admin, 'add_product_cat_processing_time_shipping_field',10,1 );	
		$this->loader->add_action( 'product_cat_edit_form_fields', $plugin_admin, 'add_product_cat_processing_time_shipping_field',10,1 );
		$this->loader->add_action( 'edited_product_cat', $plugin_admin, 'save_product_cat_processing_time_shipping_field',10,2  );	
		$this->loader->add_action( 'create_product_cat', $plugin_admin, 'save_product_cat_processing_time_shipping_field',10,2  );	

		$this->loader->add_action( 'cron_schedules', $plugin_admin, 'cron_schedules' );	
		
		$this->loader->add_action( 'bt_shipment_status_changed', $plugin_admin, 'bt_quickengage_messaging_api', 10, 3  );	
		$this->loader->add_action( 'woocommerce_order_status_processing', $plugin_admin, 'bt_quickengage_messaging_order', 10, 1 );	

	
	}

	function crb_load() {
		\Carbon_Fields\Carbon_Fields::boot();
	}

	function crb_attach_theme_options() {
		
		$woocommerce = WC();
		$base_postcode = WC()->countries->get_base_postcode() ;
		$order_statuses = wc_get_order_statuses();
		$order_statuses['any'] = "Any";

		$is_premium = $this->licenser->is_license_active();
		$premium_message = '
			<div class="notification is-danger">
				Your Premium License is Inactive. "Premium Only" features are not enabled on frontend of website.
			</div>
		';
		if($is_premium){
			$premium_message = '
				<div class="notification is-success">
					Your Premium License is Active. "Premium Only" features have been enabled on frontend of website.
				</div>
			';
		}
		$parentDirectory = plugin_dir_url(dirname(__FILE__));

		$shipping_provides_with_premium = array();
		foreach (BT_SHIPPING_PROVIDERS as $key => $value) {
			//  echo $value; 
			$shipping_provides_with_premium[$key] = $value;

			if($key=="shipmozo"){
				//	$shipping_provides_with_premium[$key] = $value . ' (Premium Only)';
			}
			if($key=="nimbuspost_new"){
				//$shipping_provides_with_premium[$key] = $value . ' (Premium Only)';
			}

		
		}

	
		$weight_unit = get_option( 'woocommerce_weight_unit' );
		$dimension_unit = get_option( 'woocommerce_dimension_unit' );	
		$container = Container::make( 'theme_options', __( 'Shipment Tracking' ) )
		->set_page_parent( "woocommerce" )
		->add_tab( __( 'General' ), array(
			Field::make( 'set', 'bt_sst_enabled_shipping_providers', __( 'Enabled Shipping Providers' ) )
				->set_options( $shipping_provides_with_premium )
				->set_help_text('Select the shipping company with which you have an active account and the necessary API keys for integration.
					Otherwise, select "Custom Shipping".
				'),
			Field::make( 'radio', 'bt_sst_enabled_custom_shipping_mode', __( 'For Custom Shipping, How Shipment Tracking Data Will Be Fetched?' ) )
				->set_options( 
					array(
						"manual" => "I'll manually update tracking (from backend or webhook or php code). ",
						"ship24" => "Automatic tracking via Ship24.com (Beta)"
					)
				)
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_enabled_shipping_providers',
						'compare' => 'INCLUDES',
						'value' => 'manual',
					)
				) )
				->set_help_text('Choose "Manual" if you wish to update tracking yourself from backend (Woocommerce->Orders) or via the webhook or via php hooks provided by this plugin.<br>
						Choose "Ship24.com" if you want automatic shipping tracking using <a href="https://ship24.com" target="_blank">ship24.com</a>. An active Ship24 account is required. They offer a free plan with paid options for higher volumes.
				'),
			Field::make( 'select', 'bt_sst_default_shipping_provider', __( 'Default Shipping Provider' ) )
				->add_options( BT_SHIPPING_PROVIDERS_WITH_NONE )
				->set_help_text( 'will be automatically assigned to new orders' ),
			Field::make( 'checkbox', 'bt_sst_complete_delivered_orders', __( 'Automatically Change Status of Delivered Orders to Completed') )
				->set_option_value( 'yes' ),

			Field::make( 'multiselect', 'bt_sst_order_statuses_to_sync', __( 'Orders Statuses' ) )
				->add_options( $order_statuses )->set_default_value( 'any' )
				->set_help_text( 'Tracking will be auto synced for orders with the selected statuses.' ),
			Field::make( 'select', 'bt_sst_sync_orders_date', __( 'Sync Tracking for' ) )
				->set_options( array(
					'10' => '10 Days',
					'15' => '15 Days',
					'20' => '20 Days',
					'30' => '30 Days',
					'45' => '45 Days',
					'60' => '60 Days',
					'90' => '90 Days',
				) )
				->set_default_value( '30' ),

			Field::make( 'checkbox', 'bt_sst_add_order_note', __( 'Add Order Note when shipment status has changed') )
				->set_option_value( 'yes' ),
			Field::make( 'select', 'bt_sst_order_note_type', __( 'Order Note Type' ) )
				->set_help_text( 'Setting this to "Customer Note" will also send an email to customer when shipment status changes (if enabled in woocommerce settings).' )
				->set_options( array(
					'private' => 'Private Note',
					'customer' => 'Customer Note',
				) )
				->set_default_value( 'customer' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_add_order_note',
						'value' => true,
					)
				) ),
			Field::make( 'text', 'bt_sst_order_note_template', __( 'Order Note Template' ) )
				->set_help_text( 'Available variables: #old_status#, #new_status#, #track_link#, #track_url#, #courier_name#, #awb_tracking_number#, #estimated_delivery#. Html not allowed.' )
				->set_attribute( 'placeholder', 'Shipment status has been updated to #new_status#. #track_link#' )
				->set_default_value( 'Shipment status has been updated to #new_status#. #track_link#' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_add_order_note',
						'value' => true,
					)
				) ),
				// Field::make( 'html', 'bt_sst_shipment_tracking_wizard', __( 'Set Wizard' ) )
				// ->set_html(
				// 	'    <!-- Button to Open Modal -->
    			// 		<div class="button stw_wizard_button is-primary" id="open-modal">Setup Wizard</div>
				// 	'
				// ),
		) );

		

		$args = array(
			'sort_order' => 'asc',
			'sort_column' => 'post_title',
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'meta_key' => '',
			'meta_value' => '',
			'authors' => '',
			'child_of' => 0,
			'parent' => -1,
			'exclude_tree' => '',
			'number' => '',
			'offset' => 0,
			'post_type' => 'page',
			'post_status' => 'publish'
		); 
		$arr_of_pages = [''=>'Select the page'];
		$link = "";
		$page_title = "";
		$payment_redirect_url = "";
		$api = "";
		if(is_admin() && isset($_GET["page"]) && $_GET['page']=="crb_carbon_fields_container_shipment_tracking.php"){
			$pages = get_pages($args);
			foreach ($pages as $page) {
				$arr_of_pages[$page->ID] = $page->post_title . ' (ID: ' . $page->ID . ')';
			}

			$tracking_page_id = get_option( '_bt_sst_tracking_page' );
			$link = get_permalink($tracking_page_id);
			$page_title = get_the_title($tracking_page_id);

			$payment_redirect_url = admin_url( "admin.php?page=".sanitize_text_field($_GET["page"] ));
			$api = get_option('register_for_sms_apy_key');
		}
		$register_for_sms_form="";
		if(empty($api)){
			$register_for_sms_form = '
			 <div class="is-overlay" style="background: #202020d4;">
				<div class="container" style="display: flex; flex-direction: column; align-items: center;justify-content: center;height:100%;">
					<div class="field is-horizontal" style="width: 100%; max-width: 600px;">
						<div class="field-body" style="width: 100%;">
							<div class="field" style="width: 100%;">
								<div class="control">
									<label class="checkbox" style="width: 100%; color: white;font-size:12px;">
										<input type="checkbox" id="checkbox1">
										I agree to the terms & conditions and authorize "Bitss Techniques" to send SMS on my behalf.
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="field is-horizontal" style="width: 100%; max-width: 600px;">
						<div class="field-body" style="width: 100%;">
							<div class="field" style="width: 100%;">
								<div class="control">
									<label class="checkbox" style="width: 100%; color: white;font-size:12px;">
										<input type="checkbox" id="checkbox2">
										I understand that misuse of the service will lead to immediate termination of account.
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="field is-horizontal" style="width: 100%; max-width: 600px; text-align: center;">
						<div class="field-body" style="width: 100%;">
							<div class="field" style="width: 100%;">
								<div class="control">
									<button type="button" class=" button is-medium" id="register_get_api_key" style="width: 100%;" >
										Click Here to Register for SMS
									</button>
									<div id="register_get_api_key_test_connection_modal" class="modal">
										<div class="modal-background"></div>
											<div class="modal-card">
												<header class="modal-card-head">
													<p id="register_get_api_key_tc-m-content" class="modal-content"></p>
												
													</header>
											</div>
									</div> 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			';
		}
		$woocommerce_email_settings_url = admin_url('admin.php?page=wc-settings&tab=email&section=bt_sst_wc_shipment_email');
		$container = $container->add_tab( __( 'SMS & Email' ), array(

			Field::make( 'html', 'bt_sst_custom_html_field', __( 'Custom HTML Field' ) )
				->set_html( '
					<div class="container">`
						<div class="tile is-ancestor mt-2 p-3">
							<div class="tile is-parent">
								<article class="tile is-child notification px-1 is-warning">
								    <p id="bt_sms_credit_bal" class="title has-text-centered">NA</p>
								    <p id="bt_sms_buy_credits" class="subtitle has-text-centered px-0">Credits Balance <br>
								    <a class="js-modal-trigger" data-target="bt_sst_buy_credits_modal">Buy Credits</a> </p>
								</article>
							</div>
							<div class="tile is-parent">
								<article class="tile is-child notification px-1 is-danger">
									<p id="bt_sms_credit_consume" class="title has-text-centered">NA</p>
									<p class="subtitle has-text-centered px-0">Credits Consumed <br> (Last 7 Days)</p>
								</article>
							</div>
							<div class="tile is-parent">
								<article class="tile is-child notification px-1 is-success">
									<p id="bt_sms_sent" class="title has-text-centered">NA</p>
									<p class="subtitle has-text-centered px-0">SMS Sent <br> (Last 7 Days)</p>
								</article>
							</div>
							<div class="tile is-parent">
								<article class="tile is-child notification px-1 is-primary">
									<p id="bt_sms_last_sent_time" class="title has-text-centered">NA</p>
									<p class="subtitle has-text-centered px-0">(Last SMS Sent)</p>
								</article>
							</div>
						</div>
						'.$register_for_sms_form.'
					</div>
					
				' ),
			
			Field::make( 'set', 'bt_sst_shipment_when_to_send_messages', __( 'When Do You Want To Send Message?' ) )
				->set_options( array(
					'new_order' => 'New Order',
					//'out_for_pickup' => 'Out For Pickup',
					'in_transit' => 'In Transit',
					'out_for_delivery' => 'Out For Delivery',
					'delivered' => 'Delivered',
					'review_after_delivery' => 'Review After Delivery (Sent 2 hrs after delivery) (Only SMS is supported)',
				) ),
			Field::make( 'text', 'bt_sst_sms_review_url', __( 'Enter Review URL' ) )
				->set_attribute( 'type', 'url' )
				->set_conditional_logic(array(
					array(
						'field' => 'bt_sst_shipment_when_to_send_messages',
						'compare' => 'INCLUDES',
						'value' => 'review_after_delivery',
					)
				))
				//->set_required( true )
				->set_help_text('This link will be send to customer after 2 hours of delivery. It can be your Google Review URL or your website\'s url where customer can leave feedback.')
				,
				
		
			Field::make( 'set', 'bt_sst_shipment_from_what_send_messages', __( 'Send Message Via' ) )
				->set_options( array(
					'sms' => 'SMS',
					'email' => 'Email',
					'whatsapp' => 'WhatsApp (Coming Soon)',
					'push_notification' => 'Push Notification (Coming Soon)',
				) ),
				Field::make( 'html', 'bt_sst_custom_html_field_trial', __( 'Custom HTML Field' ) )
				->set_html( '
					<h5 class="title is-6">Try SMS:</h5>
					<div class="column ">
                                    <div class="field has-addons ">
                                    <p class="control">
                                        <span class="select  is-medium">
                                        <select id="myselect">
                                            <option value="new-order">New Order</option>
											<option value="in-transit"> In Transit</option>
											<option value="out-for-delivery">Out for Delivery</option>
											<option value="delivered">Delivered</option>
											<option value="review-after-delivery">Review after Delivery</option>
                                        </select>
                                        </span>
                                    </p>
                                        <div class="control is-expanded">
                                            <input id="bt_otpfy_test_phone_otp" class="input is-medium" name="bt_otpfy_number" type="number" value="" placeholder="Enter mobile number">
                                        </div>
                                        <div class="field is-horizontal" style="width: 100%; max-width: 150px; text-align: center;">
											<div class="field-body" style="width: 100%;">
												<div class="field" style="width: 100%;">
													<div class="control">
														<button type="button" class=" button is-medium" id="get_sms_trial" style="width: 100%;" >
															Send SMS
														</button>
														<div id="get_sms_trial_test_connection_modal" class="modal">
															<div class="modal-background"></div>
																<div class="modal-card">
																	<header class="modal-card-head">
																		<p id="get_sms_trial_tc-m-content" class="modal-content"></p>
																		<button type="button" id="api_tc_m_close_btn" class="delete" aria-label="close"></button>
																		</header>
																</div>
															</div> 
														</div>
													</div>
												</div>
											</div>
                                   	 </div>
                                    <p class="help is-info">We will send an sms of selected event to your mobile number.<br> Supported Countries: <b>All</b></p>
                     </div>
				' ),
				Field::make( 'html', 'bt_sst_custom_html_field_email_trial', __( 'Custom HTML Field' ) )
				->set_html( '
					<h5 class="title is-6">Email:</h5>
					<div class="column ">
                                    <div class="field has-addons " style="display:none">
										<p class="control">
											<span class="select  is-medium">
											<select id="bt_sst_test_email_event">
												<option value="in-transit">In Transit</option>
												<option value="out-for-delivery">Out for Delivery</option>
												<option value="delivered">Delivered</option>
											</select>
											</span>
										</p>
                                        <div class="control is-expanded">
                                            <input id="bt_sst_test_email" class="input is-medium" name="bt_sst_test_email" type="email" value="" placeholder="Enter email address">
                                        </div>
                                        <div class="field is-horizontal" style="width: 100%; max-width: 150px; text-align: center;">
											<div class="field-body" style="width: 100%;">
												<div class="field" style="width: 100%;">
													<div class="control">
														<button type="button" class=" button is-medium" id="bt_sst_test_email_send_btn" style="width: 100%;" >
															Send Email
														</button>
														<div id="bt_sst_test_email_modal" class="modal">
															<div class="modal-background"></div>
																<div class="modal-card">
																	<header class="modal-card-head">
																		<p id="bt_sst_test_email_m_content" class="modal-content"></p>
																	</header>
																</div>
															</div> 
														</div>
													</div>
												</div>
											</div>
                                   	 </div>
                                    <p class="help is-info">You can customize the email template from <a target="_blank" href="'.$woocommerce_email_settings_url.'">woocommerce settings</a>.</p>
                     </div>
				' ),
				Field::make( 'html', 'bt_sst_custom_html_field2', __( 'Custom HTML Field' ) )
				->set_html( '
						<div class="box">
							<h3 class="title is-5">Note:</h3>
							<h4 class="title is-6">SMS are chargeable and requires registration. You can buy sms credits from within this plugin.</h4>
							<h4 class="title is-6">Sms are sent using pre-approved, co-branded DLT templates. For sending fully branded sms using your sender id, <a target="_blank" href="https://billing.bitss.tech/index.php?fuse=support&controller=ticket&view=submitticket">pls raise a support ticket</a>.</h4>
							<h4 class="title is-6">Need a Full Featured SMS Panel for advanced SMS Messaging? <a target="_blank" href="https://smsapi.bitss.tech">Signup here for fast, reliable & cost effective sms service.</a></h4>
							<h4 class="title is-6">Emails are free and are sent using your own server. Email template can be customized from <a target="_blank"  href="/wp-admin/admin.php?page=wc-settings&tab=email&section=bt_sst_wc_shipment_email">woocommerce email settings</a>.</h4>
						</div>
				' ),
			
		));

		
		
		

		$container = $container->add_tab( __( 'Tracking Widget' ), array(
			Field::make( 'html', 'bt_sst_tracking_demo', __( 'Custom HTML Field' ) )
			->set_html( '
					See Full Featured Demo of Tracking Page: <a href="https://pavitra-arts.com/track-your-order/?order=10258" target="_blank">Click Here</a>
			' ),
			Field::make( 'checkbox', 'bt_sst_show_tracking_now_button_myaccount_order_list', __( 'Show \'Track Now\' button in "My Account -> Orders. (Premium Only)' ) )
				->set_help_text('Allows customer to track their order from order list in My Account section. Shows beautiful tracking page with My Account section. No shortcode needed.')
				->set_option_value( 'yes' ),
			Field::make( 'checkbox', 'bt_sst_show_shipment_info_myaccount_orders', __( 'Show shipment info in "My Account -> Orders.' ) )
				->set_option_value( 'no' ),
			Field::make( 'checkbox', 'bt_sst_shipment_info_myaccount_order_detail', __( 'Show shipment info in "My Account -> Orders -> Order Detail.' ) )
				->set_option_value( 'no' ),
			Field::make( 'set', 'bt_sst_shipment_info_show_fields', __( 'Show these fields:' ) )
				->set_options( array(
					'shipment_status' => 'Shipment Status',
					'edd' => 'Estimated Delivery Date',
					'courier_name' => 'Courier Name',
					'awb_number' => 'AWB Number',
					'tracking_link' => 'Shipping Provider\'s Tracking Link',
					
				) )->set_conditional_logic( array(
					'relation' => 'OR', 
					array(
						'field' => 'bt_sst_show_shipment_info_myaccount_orders',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_shipment_info_myaccount_order_detail',
						'value' => true,
					)
				) ),
			Field::make( 'select', 'bt_sst_tracking_page_template', __( 'Choose Tracking Page template:' ) )
				->set_options( array(
					'classic' => 'Classic Template',
					'trackingmaster' => 'Tracking Master Template (Premium)',
				) )
				->set_default_value('classic')
				->set_help_text('Preview:<div id="tracking_page_template_preview">
					<input type="hidden" value="'.$parentDirectory.'" id="bt_sst_tracking_page_template_preview_img">
                            <a target="blank" id="tracking_page_template_preview_img_href" href=""><img width="100px" id="tracking-template-preview-img" src="" style="display: none;" alt="Tracking Template Preview"></a>
                         </div>'),
			Field::make( 'html', 'bt_sst_tracking_shortcode_html', __( 'Tracking Widget Shortcode' ) )
				->set_html(
					 '
						<p><b>Tracking Form Shortcode:</b> <input style="width:100%" type="text" value="[bt_shipping_tracking_form_2]" readonly/></p>
						<p>Copy this shortcode to place tracking widget on any page.</p> 
					',
				),
		
			Field::make( 'select', 'bt_sst_tracking_page', __( 'Select Tracking Page:' ) )
				//->set_help_text(' Don’t have tracking page? <a id="bt_sst_select_track_page" href="">Create One</a>. Or use this shortcode on any page to add tracking widget: [bt_shipping_tracking_form_2]')
				->set_help_text('Select a page where you\'ve already added the shortcode of tracking widget.')
				->set_options( $arr_of_pages )
				->set_default_value( '' ),

			Field::make( 'html', 'bt_sst_tracking_page_help_html', __( 'Shiprocket Webhook URL' ) )
				->set_html(
					'
						<p><b>Selected tracking page:</b> '. $page_title .' <a target="_blank" href="' .$link .'">View Page</a></p>
						<p><b>Direct link for order tracking:</b> '. $link .'?order=#order_id#</p>
					',
				),
			
			Field::make( 'checkbox', 'bt_sst_valid_phone_no', __( 'Validate last 4 digits of phone number associated with order.' ) )
				->set_option_value( 'no' ),

				Field::make( 'checkbox', 'bt_sst_navigation_map', __( 'Add a Map with markers for pickup and destination locations. (Premium Only)') )
				->set_option_value( 'yes', 'no' ),


				Field::make('checkbox', 'bt_sst_enable_rating', __('Add a rating bar below the tracking widget. (Premium Only)'))
				
				->set_option_value('yes')
				->set_help_text('Shows a "Rate us" section with customizable headling, description and review page url.'),
			
				Field::make('text', 'bt_sst_heading_text', __('Heading Text'))
					->set_conditional_logic(array(
						array(
							'field' => 'bt_sst_enable_rating',
							'value' => true,
						)
					))
					->set_attribute( 'placeholder', 'How was your experience with us' )
					->set_default_value( 'How was your experience with us' ),
				
				Field::make('text', 'bt_sst__subheading_text', __('Sub-Heading text'))
					->set_conditional_logic(array(
						array(
							'field' => 'bt_sst_enable_rating',
							'value' => true,
						)
					))
					->set_attribute( 'placeholder', 'Rate your experience.' )
					->set_default_value( 'WRate your experience.' ),
				
				Field::make('text', 'bt_sst_rating_page_url', __('Nagetive Rating Page URL'))
					->set_conditional_logic(array(
						array(
							'field' => 'bt_sst_enable_rating',
							'value' => true,
						)
					))
					->set_attribute( 'placeholder', 'Enter url of your rating/reviews page.' )
					->set_help_text('Enter full url starting with "https". Can be url of your Google Reviews, Yelp etc.'),
				Field::make('text', 'bt_sst_rating_page_url_pos', __('Positive Rating Page URL'))
					->set_conditional_logic(array(
						array(
							'field' => 'bt_sst_enable_rating',
							'value' => true,
						)
					))
					->set_attribute( 'placeholder', 'Enter url of your rating/reviews page.' )
					->set_help_text('Enter full url starting with "https". Can be url of your Google Reviews, Yelp etc.'),
			

			Field::make( 'html', 'bt_sst_tracking_page_sms_html', __( 'Shiprocket Webhook URL' ) )
			
		) );
		
		$enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
		$shiprocket_webhook_time = get_option( "shiprocket_webhook_called", "never" );
		if($shiprocket_webhook_time!="never"){
			$shiprocket_webhook_time = date('Y-m-d H:i:s', $shiprocket_webhook_time);
		}
		
		$premium_overlay = "";
		if(!$is_premium){
			$premium_overlay = '
				<div style="background: #202020d4;" class="is-overlay level">
                    <p class="has-text-centered has-text-white title" style="margin: auto;">
                        <a href="https://billing.bitss.tech/order.php?step=2&productGroup=5&product=612&paymentterm=12" target="_blank" class="button is-medium">Upgrade now</a>
                        <br>
                        <span style="font-size:16px;">Available only in premium version of the plugin.</span>
                    </p><br>
                
                </div>
			';
		}
		$arr_active_cc = get_option('_bt_sst_shiprocket_active_courier_companies', []);

		if(is_array($enabled_shipping_providers) && in_array('shiprocket',$enabled_shipping_providers)){
				$random_rest_route = get_option( 'bt-sync-shipment-tracking-random-route','' );
				$container = $container->add_tab( __( 'Shiprocket' ), array(
					Field::make( 'html', 'bt_sst_shiprocket_webhook_html', __( 'Shiprocket Webhook URL' ) )
						->set_html(
							sprintf( '
								<p><b>Shiprocket Webhook URL: [<a target="_blank" href="https://app.shiprocket.in/shipment-webhook">Configure Webhook Here</a>] </b></p>
								<p>'.get_site_url(null,'/wp-json/'. $random_rest_route.'/'.$random_rest_route) . '<a href="#" class="bt_sst_copy_link" > Copy Link</a> </p>
								<p>Last Webhook Called On: '.$shiprocket_webhook_time.'</p>
							'),
						),
					Field::make( 'text', 'bt_sst_shiprocket_apiusername', __( 'Api Username' ) ),
					Field::make( 'text', 'bt_sst_shiprocket_apipassword', __( 'Api Password' ) )
						->set_attribute( 'type', 'password' ),							
					Field::make( 'html', 'bt_sst_test_connection', __( 'Help HTML' ) )
						->set_html(
						sprintf('
							<button type="button" class="button" id="api_test_connection_btn">Test Connection & Fetch Couriers</button><br>
							<em class="cf-field__help">Please click "Save Changes" to save api credentials before testing the connection</em>
							<div id="api_test_connection_modal" class="modal">
								<div class="modal-background"></div>
								<div class="modal-card">
									<header class="modal-card-head">
									<p id="api_tc-m-content" class="modal-content"></p>
									<button type="button" id="api_tc_m_close_btn" class="delete" aria-label="close"></button>
									</header>
								</div>
							</div>
						')),
						Field::make( 'select', 'bt_sst_shiprocket_cron_schedule', __( 'Sync Tracking every (Premium Only)' ) )
						->add_options( 
							array(
								'never'=>'never',
								'15mins'=>'15 mins',
								'1hour'=>'1 hour',
								'4hours'=>'4 hours',
								'24hours'=>'24 hours'
								) 
						)
						->set_help_text( 'Tracking information will be periodically synced from Shiprocket at this interval. Use this option if auto sync is not working on your website even after setting up the webhook correctly.' ),
					// Field::make( 'select', 'bt_sst_shiprocket_cron_schedule', __( 'Sync Tracking every' ) )
					// 	->add_options( array('never', '1 hour') )
					// 	->set_help_text( 'Tracking information will be periodically synced at this interval' ),
					Field::make( 'checkbox', 'bt_sst_shiprocket_push_orders', __( 'Push orders to shiprocket') )
						->set_classes( 'title is-6' )
						->set_help_text( 'Plugin will push "processing" orders to shiprocket. Use this if Shiprocket\'s Order Pull is not working correctly. 
						<br>This feature also pushes correct order weight and dimensions of package to shiprocket, it helps in reducing weight discrepancy issues.
						<br>For this option to work, make sure that the weight and dimensions are correctly set for every product. Keep some packaging buffer for better accuracy in calculation. 
						<a target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/shiprocket-woocommerce-integration">See Demo</a>
						' )
						->set_option_value( 'no' ),
						Field::make( 'text', 'bt_sst_shiprocket_pickup_location', __( 'Pickup Location' ) )
						->set_attribute( 'placeholder', 'Primary' )
						->set_default_value( 'Primary' )
						->set_attribute( 'readOnly', 'readOnly' )				
						->set_help_text( '<div><a href="#"id="bt_sst_fetch_pichup_locations">Select Pickup Locations</a></div>Required. Pickup location to set while pushing order to shiprocket.
						<br>Available at: <b>Shiprocket > Settings > Pickup Address > Manage Pickup Addresses</b>
						<div style="margin: 10px 0;">
							Using "Dokan Multi-Vendor Plugin"? Set Vendor wise pickup location :<br>
							<button type="button" id="" class="button bt_sst_button">Set Vendor Pickup Locations</button>
						</div>
						<div id="" class="">
							<div class="bt_sst_overlay"></div>
							<div class="bt_sst_popup">
							  			<span class="bt_sst_close">&times;</span>
								        <div id="bt_sst_select_vendor" class="field">
											<label class="label" for="bt_sst_vendor_select">Vendor Name</label>
											<div class="control">
											<div class="select">
												<select id="bt_sst_vendor_select">
												<option value="option1">Select Vendor</option>
												</select>
											</div>
											</div>
										</div>

										<div class="field bt_sst_vendor_pickup_location_container">
											<label class="label" for="bt_sst_vendor_pickup_location">Pickup Location</label>
											<div class="control">
												<select id="bt_sst_vendor_pickup_location">
													<option value="" >Select Pick-Up Location</option>
												</select>
											</div>
										</div>
										<button id="bt_sst_set_vendor_submit" type="button">Save Vender</button>
							</div>
						</div>
						<div class="modal" id="pickupLocationModal">
							<div class="modal-background"></div>
							<div class="modal-content">
								<div class="box">
									<!-- Small close button positioned in the top-right corner -->
									<button type="button" class="delete is-small" id="closeModal" aria-label="close" style="position: absolute; top: 10px; right: 10px;"></button>
									<div id="pickupLocationContent"></div>
									<button class="button is-primary" id="bt_sst_save_pickuplocation" style="margin-top: 15px;">Save</button>
								</div>
							</div>
						</div>
						' )
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_shiprocket_push_orders',
								'value' => true,
							)
					) ),
					Field::make( 'text', 'bt_sst_shiprocket_channelid', __( 'Channel Id' ) )
						->set_attribute( 'placeholder', '1234567' )
						->set_help_text( 'Required. Channel will be assigned to shipment on shiprocket.
						<br>Available at: <b>Shiprocket > Setup & Manage > Channels > (Channel ID of Woocommerce)</b>
						' )
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_shiprocket_push_orders',
								'value' => true,
							)
					) ),
					Field::make( 'checkbox', 'bt_sst_shiprocket_assign_courier_to_shipment', __( 'Automatically assign courier to booked shipment. (Premium Only)') )
						->set_option_value( 'yes' )
						->set_help_text( 'Plugin will attempt to assign courier if its already selected by customer during checkout. 
						<br>
						For this option to work, make sure "Allow user to select courier company during checkout" is enabled on "Checkout Page" tab. 
						<br>This feature works well with "Shiprocket Official Wordpress Plugin" as well.
						<a target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/shiprocket-woocommerce-integration">See Demo</a>
						'
						
						)
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_shiprocket_push_orders',
								'value' => true,
							)
					) ),

					Field::make( 'multiselect', 'bt_sst_shiprocket_default_courier_companies', __( 'Default courier companies' ) )
					->set_conditional_logic( array(
						array(
							'field' => 'bt_sst_shiprocket_assign_courier_to_shipment',
							'value' => true,
						),
						array(
							'field' => 'bt_sst_shiprocket_push_orders',
							'value' => true,
						)
					) )
					
					->set_help_text('
							The selected courier will be assiged to shipment after pushing the order to shiprocket. 
							You can select multiple couriers here, plugin will attempt to assign other, if first fails, in order of selection.
					')
					->add_options( $arr_active_cc ),


					Field::make( 'text', 'bt_sst_shiprocket_custom_tracking_url', __( 'Custom Tracking URL' ) )
						->set_attribute( 'placeholder', 'https://yourdomain.com/track/#awb#' )
						->set_help_text( 'Available variables #awb#, #order_id#. These variables can be used to add awb number or order id in tracking url. Eg. https://yoursite.com/track?awb=#awb#' ),
					Field::make( 'html', 'bt_sst_shiprocket_generate_api_key_link' )
                        ->set_html(sprintf( "
						<div>Shiprocket Quick Links</div>
						<div class='content'>
							<ol>
								<li>
									<a target='_blank' href='https://app.shiprocket.in/shipment-webhook'>Setup webhook</a>
								</li>
								<li>
									<a target='_blank' href='https://app.shiprocket.in/api-user'>Setup API username/password.</a>
								</li>
								<li>
									<a target='_blank' href='https://app.shiprocket.in/post_order_settings'>Setup custom tracking page</a>
								</li>
							
							</ol>
						</div>
						")
					),
					Field::make( 'html', 'bt_sst_shiprocket_premium_crosssell' )
                        ->set_html(sprintf( "
						
						<div class='card'>
							<header class='card-header'>
								<div class='card-header-title notification'>
									<p class='title is-5'>
										Upgrade to Premium & Do more with advanced Shiprocket features that elevate your shipping efficiency and customer satisfaction. 
									</p>
									<p class='subtitle is-5'> 
										Harness the power of advanced automation, expanded courier options, and superior support to not only meet but exceed customer expectations. 
									</p> 
								</div>
							</header>
							<div class='card-content'>
								<div class=''>
									<ol>
										<li>
											<div class='notification is-primary is-light subtitle is-6'>
											<b>Estimated Delivery Date Checker on Product Page:</b> Fetch realtime delivery dates & prices from Shiprocket & display on each product page, enabling buyers to plan accordingly based on expected arrival times.
											</div>
										</li>
										<li>
											<div class='notification is-primary is-light subtitle is-6'>
												<b>Preferred Courier Selection:</b> Give customers the option to choose their preferred courier service during the order process, enhancing customization.
											</div>
										</li>
										<li>
											<div class='notification is-primary is-light subtitle is-6'>
												<b>Show Courier Wise Estimated Delivery Dates on Checkout Page:</b> Display estimated delivery dates for each available courier service during checkout, helping customers make informed decisions.
											</div>
										</li>
										<li>
											<div class='notification is-primary is-light subtitle is-6'>
												<b>Auto Fetch City & State from PinCode:</b> As soon as a user enters their pin-code on the checkout page, the city and state fields are automatically populated, improving user experience and reducing entry errors.
											</div>
										</li>
										<li>
											<div class='notification is-primary is-light subtitle is-6'>
												<b>Push Order to Shiprocket:</b> Automatically send order details from your WordPress site to Shiprocket upon order placement.
											</div>
										</li>
										<li>
											<div class='notification is-primary is-light subtitle is-6'>
												<b>Automatically assign courier to booked shipment:</b> Automatically assign the customer's prefered courier to booked shipments in shiprocket, reducing manual effort and minimizing the potential for errors.
											</div>
										</li>
										<li>
											<div class='notification is-primary is-light subtitle is-6'>
												<b>Sync Tracking Data from Shiprocket:</b> Fetch and display the latest tracking information on your site, keeping customers informed about their order status.
											</div>
										</li>
										<li>
											<div class='notification is-primary is-light subtitle is-6'>
												<b>Show Approximate Shipment Weight in Cart and Checkout Page:</b> Provide transparency around shipping costs by showing approximate package weights both during cart selection and at checkout.
											</div>
										</li>
									</ol>
								
								</div>
							</div>
							<footer class='card-footer'>
								<a href='https://billing.bitss.tech/order.php?step=2&productGroup=5&product=612&paymentterm=12' target='_blank' class='button is-focused is-primary is-large is-fullwidth card-footer-item'>Upgrade & Unlock Full Features</a>
							</footer>
						</div>
						")
					),
				) );
		}
		if(is_array($enabled_shipping_providers) && in_array('shyplite',$enabled_shipping_providers)){

				$container = $container->add_tab( __( 'Shyplite' ), array(
					Field::make( 'select', 'bt_sst_shyplite_cron_schedule', __( 'Sync Tracking every' ) )
						->add_options( array('never', '1 hour') )
						->set_help_text( 'Tracking information will be periodically synced from Shyplite at this interval. Use this option if auto sync is not working on your website even after setting up the webhook correctly.' ),
					
					Field::make( 'text', 'bt_sst_shyplite_sellerid', __( 'Seller Id' ) ),
					Field::make( 'text', 'bt_sst_shyplite_appid', __( 'App Id' ) ),
					Field::make( 'text', 'bt_sst_shyplite_publickey', __( 'Public Key' ) ),
					Field::make( 'text', 'bt_sst_shyplite_secretkey', __( 'Secret Key' ) )
						->set_attribute( 'type', 'password' ),
					Field::make( 'html', 'bt_sst_shyplite_generate_api_key_link' )
                        ->set_html(sprintf( "<b>[<a target='_blank' href='https://app.shyplite.com/settings/api'>Click here to get these details</a>]</b>")),
					Field::make( 'html', 'bt_sst_sync_now_shyplite' )
    					->set_html( '<b>To sync tracking right now, click</b> <button class="button button-default" type="button" id="btn-bt-sync-now-shyplite">Sync Now</button>' )
				) );
		}

		
        if(is_array($enabled_shipping_providers) && in_array('nimbuspost',$enabled_shipping_providers)){
			$nimbuspost_webhook_time = get_option('nimbuspost_webhook_called', 'never');
			if($nimbuspost_webhook_time!="never"){
				$nimbuspost_webhook_time = date('Y-m-d H:i:s', $nimbuspost_webhook_time);
			}
                $random_rest_secret = get_option( 'bt-sync-shipment-tracking-random-secret-key','' );
                $container = $container->add_tab( __( 'Nimbuspost (OLD)' ), array(
                    Field::make( 'html', 'bt_sst_nimbuspost_webhook_html', __( 'Nimbuspost Webhook URL' ) )
                        ->set_html(
                            sprintf( '
                                    <b>Nimbuspost Webhook URL: [<a target="_blank" href="https://ship.nimbuspost.com/webhook">Configure Webhook Here</a>] </b> 
									<p>'.get_site_url(null, '/wp-json/bt-sync-shipment-tracking-nimbuspost/v1.0.0/webhook_receiver').'<a href="#" class="bt_sst_copy_link" > Copy Link</a> </p>
									<p>Last Webhook Called On: '.$nimbuspost_webhook_time.'</p>
                                ')
                        ),
                    Field::make( 'text', 'bt_sst_nimbuspost_webhook_secretkey', __( 'Your Secret Key' ) )
                        ->set_attribute( 'readOnly', true ),
                    Field::make( 'text', 'bt_sst_nimbuspost_apikey', __( "Nimbuspost Api Key" ) ),
                    Field::make( 'html', 'bt_sst_nimbuspost_generate_api_key_link' )
                        ->set_html(sprintf( "<b>[<a target='_blank' href='https://ship.nimbuspost.com/user_api'>Click here to get these details</a>]</b>"))
                ) );
        }
		if(is_array($enabled_shipping_providers) && in_array('nimbuspost_new',$enabled_shipping_providers)){
			$nimbuspost_new_webhook_time = get_option('nimbuspost_new_webhook_called', 'never');
			if($nimbuspost_new_webhook_time!="never"){
				$nimbuspost_new_webhook_time = date('Y-m-d H:i:s', $nimbuspost_new_webhook_time);
			}
                $random_rest_secret = get_option( 'bt-sync-shipment-tracking-random-secret-key','' );
                $container = $container->add_tab( __( 'Nimbuspost (NEW) (Premium Only)' ), array(
                    Field::make( 'html', 'bt_sst_nimbuspost_new_webhook_html', __( 'Nimbuspost_New Webhook URL' ) )
                        ->set_html(
                            sprintf( '
                                    <b>Nimbuspost Webhook URL: [<a target="_blank" href="https://ship.nimbuspost.com/webhook">Configure Webhook Here</a>] </b> 
									<p>'.get_site_url(null, '/wp-json/bt-sync-shipment-tracking-nimbuspost-new/v1.0.0/webhook_receiver').'<a href="#" class="bt_sst_copy_link" > Copy Link</a> </p>
									<p>Last Webhook Called On: '.$nimbuspost_new_webhook_time.'</p>
                                ')
                        ),
                    Field::make( 'text', 'bt_sst_nimbuspost_new_webhook_api_user_email', __( 'Api User Email' ) ),
                    Field::make( 'text', 'bt_sst_nimbuspost_new_user_password', __( "Api User Password" ) )
					    ->set_attribute( 'type', 'password' ),
                    Field::make( 'html', 'bt_sst_test_nimbuspost_connection_', __( 'Help HTML' ) )
						->set_html(
						sprintf('
							<button type="button" class="button" id="api_nimbuspost_test_connection_btn">Test Connection</button><br>
							<em class="cf-field__help">Please click "Save Changes" to save api credentials before testing the connection</em>
							<div id="api_nimbuspost_test_connection_modal" class="modal">
								<div class="modal-background"></div>
								<div class="modal-card">
									<header class="modal-card-head">
									<p id="api_nimbuspost_tc-m-content" class="modal-content"></p>
									<button type="button" id="api_nimbuspost_tc_m_close_btn" class="delete" aria-label="close"></button>
									</header>
								</div>
							</div> 
						')),
						Field::make( 'select', 'bt_sst_nimbuspost_new_cron_schedule', __( 'Sync Tracking every' ) )
						->add_options( 
							array(
								'never'=>'never',
								'15mins'=>'15 mins',
								'1hour'=>'1 hour',
								'4hours'=>'4 hours',
								'24hours'=>'24 hours'
								) 
						)
						->set_help_text( 'Tracking information will be periodically synced from Nimbuspost at this interval. Use this option if auto sync is not working on your website even after setting up the webhook correctly.' ),
						Field::make( 'checkbox', 'bt_sst_nimbuspost_push_orders', __( 'Push orders to Nimbuspost') )
						->set_classes( 'title is-6' )
						->set_help_text( 'Plugin will push "processing" orders to nimbuspost. Use this if nimbuspost\'s Order Pull is not working correctly. 
						<br>This feature also pushes correct order weight and dimensions of package to nimbuspost, it helps in reducing weight discrepancy issues.
						<br>For this option to work, make sure that the weight and dimensions are correctly set for every product. Keep some packaging buffer for better accuracy in calculation. 
						<a target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/nimbuspost-woocommerce-integration">See Demo</a>
						' )
						->set_option_value( 'no' ),
						Field::make( 'text', 'bt_sst_nimbuspost_warehouse_name', __( 'Warehouse Name ' ) )
						->set_attribute( 'placeholder', 'Primary' )
						->set_default_value( 'Primary
						' )
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_nimbuspost_push_orders',
								'value' => true,
							)
					) ),
					Field::make( 'text', 'bt_sst_nimpuspost_name', __( 'Name' ) )
						->set_attribute( 'placeholder', 'name
						' )
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_nimbuspost_push_orders',
								'value' => true,
							)
					) ),
					Field::make( 'text', 'bt_sst_nimpuspost_address_line_1', __( 'Address Line 1' ) )
						->set_attribute( 'placeholder', 'Address Line 1
						' )
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_nimbuspost_push_orders',
								'value' => true,
							)
					) ),
					Field::make( 'text', 'bt_sst_nimpuspost_address_line_2', __( 'Address line 2' ) )
						->set_attribute( 'placeholder', 'Address Line 2
						' )
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_nimbuspost_push_orders',
								'value' => true,
							)
					) ),
					Field::make( 'text', 'bt_sst_nimpuspost_city', __( 'City' ) )
						->set_attribute( 'placeholder', 'City
						' )
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_nimbuspost_push_orders',
								'value' => true,
							)
					) ),
					Field::make( 'text', 'bt_sst_nimpuspost_state', __( 'state' ) )
						->set_attribute( 'placeholder', 'state
						' )
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_nimbuspost_push_orders',
								'value' => true,
							)
					) ),
					Field::make( 'text', 'bt_sst_nimpuspost_pincode', __( 'PinCode' ) )
						->set_attribute( 'placeholder', '123456
						' )
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_nimbuspost_push_orders',
								'value' => true,
							)
					) ),
					Field::make( 'text', 'bt_sst_nimpuspost_phone', __( 'Phone' ) )
						->set_attribute( 'placeholder', '1234567890
						' )
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_nimbuspost_push_orders',
								'value' => true,
							)
					) ),
					Field::make( 'text', 'bt_sst_nimpuspost_gst', __( 'GSt' ) )
						->set_attribute( 'placeholder', 'GST number
						' )
						->set_conditional_logic( array(
							array(
								'field' => 'bt_sst_nimbuspost_push_orders',
								'value' => true,
							)
					) ),
					Field::make( 'html', 'bt_sst_nimbuspost_new_premium_overlay_1', __( 'Help HTML' ) )
						->set_html(sprintf($premium_overlay)
					),
					  //  Field::make( 'checkbox', 'bt_sst_nimbustpost_insure_shipment', __( 'Insure Shipmeny to nimbuspost') )
                ) );
        }
		if(is_array($enabled_shipping_providers) && in_array('xpressbees',$enabled_shipping_providers)){
			$xpressbees_webhook_time = get_option('xpressbees_webhook_called', 'never');
			if($xpressbees_webhook_time!="never"){
				$xpressbees_webhook_time = date('Y-m-d H:i:s', $xpressbees_webhook_time);
			}
			$random_rest_secret = get_option( 'bt-sync-shipment-tracking-random-secret-key','' );
			$container = $container->add_tab( __( 'Xpressbees' ), array(
				Field::make( 'html', 'bt_sst_xpressbees_webhook_html', __( 'Xpressbees Webhook URL' ) )
					->set_html(
						sprintf( '
								<b>Xpressbees Webhook URL: [<a target="_blank" href="https://shipment.xpressbees.com/webhook">Configure Webhook Here</a>] </b> 
								<p>'.get_site_url(null, '/wp-json/bt-sync-shipment-tracking-xpressbees/v1.0.0/webhook_receiver').'<a href="#" class="bt_sst_copy_link" > Copy Link</a> </p>
								<p>Last Webhook Called On: '.$xpressbees_webhook_time.'</p>
							')
					),
				Field::make( 'text', 'bt_sst_xpressbees_webhook_secretkey', __( 'Your Secret Key' ) )
					->set_attribute( 'readOnly', true )
			) );
		}


		if(is_array($enabled_shipping_providers) && in_array('shipmozo',$enabled_shipping_providers)){
			$shipmozo_webhook_time = get_option('shipmozo_webhook_called', 'never');
			if($shipmozo_webhook_time!="never"){ 
				$shipmozo_webhook_time = date('Y-m-d H:i:s', $shipmozo_webhook_time);
			}
			$random_rest_secret = get_option( 'bt-sync-shipment-tracking-random-secret-key','' );
			$container = $container->add_tab( __( 'Shipmozo (Premium Only)' ), array(
				Field::make( 'html', 'bt_sst_shipmozo_webhook_html', __( 'Shipmozo Webhook URL' ) )
					->set_html(
						sprintf( '
								<b>Shipmozo Webhook URL: [<a target="_blank" href="https://app.shipmozo.com/user/shipping-notification">Configure Webhook Here</a>] </b> 
								<p>'.get_site_url(null, '/wp-json/bt-sync-shipment-tracking-shipmozo/v1.0.0/webhook_receiver').'<a href="#" class="bt_sst_copy_link" > Copy Link</a> </p>
								<p>Last Webhook Called On: '.$shipmozo_webhook_time.'</p>
							')
					),
					Field::make( 'text', 'bt_sst_shipmozo_apipublickey', __( 'Api Public Key' ) ),
					Field::make( 'text', 'bt_sst_shipmozo_apiprivatekey', __( 'Api Private Key' ) )
						->set_attribute( 'type', 'password' ),							
					Field::make( 'html', 'bt_sst_test_shipmozo_connection_1', __( 'Help HTML' ) )
						->set_html(
						sprintf('
							<button type="button" class="button" id="api_test_connection_btn1">Test Connection</button><br>
							<em class="cf-field__help">Please click "Save Changes" to save api credentials before testing the connection</em>
							<div id="api_shipmozo_test_connection_modal" class="modal">
								<div class="modal-background"></div>
								<div class="modal-card">
									<header class="modal-card-head">
									<p id="api_shipmozo_tc-m-content" class="modal-content"></p>
									<button type="button" id="api_shipmozo_tc_m_close_btn" class="delete" aria-label="close"></button>
									</header>
								</div>
							</div> 
						')),
						Field::make( 'text', 'bt_sst_google_key_shipmozo', __( 'Enter your Google API key.') )
							->set_attribute( 'placeholder', 'Enter google geocoding api key.' )
							->set_help_text('
							<a target="_blank" href="https://developers.google.com/maps/documentation/geocoding/get-api-key">Click here to get Google Geocode Api Key</a>
							'),
						Field::make( 'select', 'bt_sst_shipmozo_cron_schedule', __( 'Sync Tracking every' ) )
						->add_options( 
							array(
								'never'=>'never',
								'15mins'=>'15 mins',
								'1hour'=>'1 hour',
								'4hours'=>'4 hours',
								'24hours'=>'24 hours'
								) 
						)
						->set_help_text( 'Tracking information will be periodically synced from Shipmozo at this interval. Use this option if auto sync is not working on your website even after setting up the webhook correctly.' ),
						Field::make( 'checkbox', 'bt_sst_shipmozo_push_orders', __( 'Push orders to Shipmozo') )
						->set_classes( 'title is-6' )
						->set_help_text( 'Plugin will push "processing" orders to shipmozo. Use this if Shipmozo\'s Order Pull is not working correctly. 
						<br>This feature also pushes correct order weight and dimensions of package to shipmozo, it helps in reducing weight discrepancy issues.
						<br>For this option to work, make sure that the weight and dimensions are correctly set for every product. Keep some packaging buffer for better accuracy in calculation. 
						<a target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/shipmozo-woocommerce-integration">See Demo</a>
						' ),
						Field::make( 'text', 'bt_sst_shipmozo_warehouseid', __( 'Warehouse ID' ) )
						->set_help_text('This warehouse will be assigned to the orders pushed by the plugin into Shipmozo. Warehouse ID can be found from this page, then going to edit and see addressbar.
						                link: https://app.shipmozo.com/user/warehouse'),
						Field::make( 'html', 'bt_sst_shipmozo_premium_overlay_1', __( 'Help HTML' ) )
							->set_html(
							sprintf($premium_overlay)),
			) );
		}


		if(is_array($enabled_shipping_providers) && in_array('delhivery',$enabled_shipping_providers)){
			
			$container = $container->add_tab( __( 'Delhivery' ), array(
					Field::make( 'text', 'bt_sst_delhivery_apitoken', __( 'API Token' ) )
						->set_help_text( ' 
							<a target="_blank" href="https://one.delhivery.com/settings/api-setup">[Click here to get API Token]</a>
							' ),
					Field::make( 'html', 'bt_sst_test_connection_delh', __( 'Help HTML' ) )
						->set_html(
						sprintf('
							<button type="button" class="button" id="api_test_connection_btn_delh">Test Connection</button><br>
							<em class="cf-field__help">Please click "Save Changes" to save api credentials before testing the connection</em>
							<div id="api_test_connection_modal_delh" class="modal">
								<div class="modal-background"></div>
								<div class="modal-card">
									<header class="modal-card-head">
									<p id="api_tc-m-content_delh" class="modal-content"></p>
									<button type="button" id="api_tc_m_close_btn_delh" class="delete" aria-label="close"></button>
									</header>
								</div>
							</div>
						')),
						
					// Field::make( 'select', 'bt_sst_shiprocket_cron_schedule', __( 'Sync Tracking every' ) )
					Field::make( 'text', 'bt_sst_delhivery_pincodepickup', __( 'Pickup Pincode' ) )
					->set_default_value( $base_postcode )
					->set_attribute( 'placeholder', 'Enter pincode of pickup location' )	,	
					Field::make( 'text', 'bt_sst_delhivery_warehouse_name', __( 'Pickup Location ' ) )
					->set_attribute( 'placeholder', 'Enter pickup location name' )		
					->set_help_text( '<a target="_blank" href="https://one.delhivery.com/settings/pickup-locations/domestic">[Click here to get Pickup Location]</a>' ),		
					Field::make( 'select', 'bt_sst_delhivery_cron_schedule', __( 'Sync Tracking every (Premium Only)' ) )
						->add_options( 
							array(
								'never'=>'Never',
								'15mins'=>'15 mins',
								'1hour'=>'1 hour',
								'4hours'=>'4 hours',
								'24hours'=>'24 hours'
								) 
					)->set_help_text( 'Never: Tracking info will not be automatically synced. You can manually pull latest tracking for each order.<br>
							15mins - 24 hours: Tracking information will be periodically synced from Delhivery at this interval.' ),
					Field::make( 'checkbox', 'bt_sst_delhivery_push_orders', __( 'Automatically Push Orders to Delhivery (Premium Only)') )
						->set_classes( 'title is-6' )
						->set_help_text( 'Plugin will automatically push "processing" orders to delhivery.<br>
						You can still push orders by clicking "Push Now" link available in individual order.
						<br>This feature also pushes correct order weight and dimensions of package to delhivery, it helps in reducing weight discrepancy issues.
						<br>For this option to work, make sure that the weight and dimensions are correctly set for every product. Keep some packaging buffer for better accuracy in calculation. 
						<a target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/delhivery-woocommerce-integration">See Demo</a>
						' )
						->set_option_value( '1' )
						->set_default_value( '0' )
					

			) );
		}

		if(is_array($enabled_shipping_providers) && in_array('manual',$enabled_shipping_providers)){
                $random_rest_secret = get_option( 'bt-sync-shipment-tracking-random-manual-secret-key','' );
                $container = $container->add_tab( __( 'Custom Shipping' ), array(
					Field::make( 'html', 'bt_sst_manual_webhook_html', __( 'Rest API to Update Tracking' ) )
                        ->set_html(
                            sprintf( '
									<div class="block">
                                    <b>Rest API to update tracking data: <p>POST: '.get_site_url(null, '/wp-json/bt-sync-shipment-tracking-manual/v1.0.0/webhook_receiver').'</p>
									Parameters:
									<div class="content">
									<ol>
										<li>order_id</li>
										<li>awb_number</li>
										<li>courier_name</li>
										<li>etd</li>
										<li>shipping_status ("Pending pickup", "Out for pickup", "In Transit", "Out for delivery", "Delivered", "Canceled", "RTO in Transit", "RTO Delivered")</li>
										<li>tracking_link</li>
										<li>api_key</li>
									</ol>
									</div>
									</div>
									
                                ')
                        )->set_help_text( 'Update tracking data from any 3rd party platform using this rest api.<br>This api works only if Manual shipping provider is enabled. For any help, get in touch with us.' ),
                    Field::make( 'text', 'bt_sst_manual_webhook_secretkey', __( 'API Key' ) )
                        ->set_attribute( 'readOnly', true ),
					Field::make( 'text', 'bt_sst_manual_courier_name', __( 'Default courier name' ) )						
						->set_help_text(''),
					Field::make( 'text', 'bt_sst_manual_awb_number', __( 'Default awb number format' ) )
						->set_attribute( 'placeholder', 'abc-#order_id#' )
					    ->set_default_value( '#order_id#' )
						->set_help_text( 'Available variables- #order_id#.' ),
                    Field::make( 'text', 'bt_sst_manual_tracking_url', __( 'Global Tracking URL' ) )
						->set_attribute( 'placeholder', 'https://yourdomain.com/track/#awb#' )
						->set_help_text( 'Available variables- #awb#, #order_id#. These variables can be used to add awb number or order id in tracking url. Eg. https://yoursite.com/track?awb=#awb# <br> Global Tracking URL will be used only if order specific tracking url is not set.' ),
					// Field::make( 'checkbox', 'bt_sst_manual_ud_shipment_details', __( 'Enable update shipment details on order list page' ) )						
					// 	->set_help_text(''),
					 ) );
        }



	
		$login_html = file_get_contents(plugin_dir_path( dirname( __FILE__ ) )  . 'includes/licenser/partials/premium_conformation_login_form.php');
		// $csrf =  wp_nonce_field( 'check_user_data_for_premium_features','_wpnonce',true,false );
		// $login_html = str_replace("##csrf##", $csrf, $login_html);
		$woocommerce_settings_url = admin_url('admin.php?page=wc-settings');
		
		$container = $container->add_tab( __( 'Product Page  (Premium Only)' ), array(
			Field::make( 'checkbox', 'bt_sst_shiprocket_pincode_checker', __( 'Enable "Estimated Delivery Date Checker" widget.') )
				->set_classes( 'title is-6' )
				->set_help_text('Allows user to check estimated delivery date, shipping charges etc based on delivery pincode.
				<a target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/estimated-delivery-date-checker-for-woocommerce/">See Demo</a>
				')
				->set_option_value( 'no' ),
			Field::make( 'select', 'bt_sst_pincode_box_template', __( 'Choose widget template:' ) )
				->set_options( array(
					'classic' => 'Classic',
					'realistic' => 'Realistic',
				) )
				->set_default_value('classic')
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					)))
				->set_help_text('Preview:<div id="pincode_template_preview">
					<input type="hidden" value="'.$parentDirectory.'" id="bt_sst_template_preview_img">
                            <img id="template-preview-img" src="" style="display: none;" alt="Template Preview">
                         </div>'),
			Field::make('checkbox', 'bt_sst_enable_auto_postcode_fill', __('Automatically get visitor\'s postcode from ip address'))
				->set_classes( 'title is-6' )
				->set_option_value('no')
				->set_help_text('Plugin will try to identify visitor\'s postcode using their ip address. Service used: freeipapi.com 
					<br>
					Accuracy may vary based on user location.
				')
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
				) ),
			
			Field::make( 'select', 'bt_sst_pincode_checker_location', __( 'Location of delivery checker widget on product page' ) )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
				) )->set_help_text('Use shortcode [bt_estimated_delivery_widget] to place the widget anywhere on your website.')
				->set_options( array(
					'' => 'Shortcode Only',
					'woocommerce_before_single_product_summary' => 'Before single product summary',
					'woocommerce_single_product_summary' => 'Single product summary',
					'woocommerce_before_add_to_cart_form' => 'Before add to cart form',
					'woocommerce_before_add_to_cart_button' => 'Before add to cart button',
					'woocommerce_before_add_to_cart_quantity' => 'Before add to cart quantity',
					'woocommerce_after_add_to_cart_button' => 'After add to cart button',
					'woocommerce_after_add_to_cart_form' => 'After add to cart form',
					'woocommerce_product_meta_start' => 'Product meta start',
					'woocommerce_product_meta_end' => 'Product meta end',
					'woocommerce_after_single_product_summary' => 'After single product summary',

				) )
				->set_default_value( 'woocommerce_after_add_to_cart_form' ),
			Field::make( 'time', 'bt_sst_cutoff_time', __( 'Cut Off Time(Default time will be 6:00 PM)' ) )
			->set_default_value(  '18:00:00' )
			->set_conditional_logic( array(
				array(
					'field' => 'bt_sst_shiprocket_pincode_checker',
					'value' => true,
				)))
			->set_help_text('
			Shows cut off time along with estimated delivery date, if #cutoff_time# is added in the template below.<br>
			Eg. "If ordered within 8 hrs 16 mins"

			')
			,
			Field::make( 'select', 'bt_sst_pincode_data_provider', __( 'Select delivery date & rate provider' ) )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					)
				) )
				->set_options( array(
					'generic'	 => 'Custom Shipping',
					'delhivery'	 => 'Delhivery',
					'nimbuspost_new' => 'Nimbuspost',
					'shipmozo'   => 'Shipmozo',
					'shiprocket' => 'Shiprocket',
					
				) )
				->set_help_text('
				<p><b>Shiprocket:</b> Courier names along with estimated delivery date and rates are fetched from Shiprocket on realtime basis. <br>Make sure the Shiprocket\'s API settings are correctly set to use this provider. <a href="https://www.youtube.com/watch?v=8nds10GbsVE" target="_blank">See Video</a></p>
				<p><b>Custom Shipping:</b> Select this provider to define custom rules yourself. Google Api is used to fetch pin code details.</p>
				<p>NOTE: Pin Code data is cached for 12 hours.</p>
				<p>International shipping is supported if more than one "Shipping location(s)" are set in <a target="_blank" href="'.$woocommerce_settings_url.'">woocommerce settings.</a></p>
				')
				->set_default_value( 'shiprocket' ),
			Field::make( 'multiselect', 'bt_sst_courier_companies_product_page', __( 'Allowed courier companies are' ) )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_pincode_data_provider',
						'value' => 'shiprocket',
					)
				) )
				->set_help_text('Only selected couriers will be available for shipping during checkout, other courier companies will be ignored.
				<br> Make sure to set "Delivery date & rate provider" first, then do "Save Changes" before courier list can be populated.<br>
				
				')
				->add_options( $arr_active_cc ),
			Field::make( 'text', 'bt_sst_shiprocket_pickup_pincode', __( 'Pickup Pincode' ) )
				->set_default_value( $base_postcode )
				->set_help_text( 'Required. Enter pincode of your warehouse/pickup point. Should be same as given in shipping aggregator.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_pincode_data_provider',
						'value' => 'shiprocket',
					)
				) ),
				Field::make( 'checkbox', 'bt_sst_product_page_enable_international_shiprocket', __( 'Fetch international estimates from shiprocket.') )
				->set_option_value( 'no' )
				->set_help_text( '
				<p>Enable this option if International Shipping is enabled in your shiprocket account.</p>
				<p>If this option is disabled, an error is displayed to customer seeking for international estimates.<p>
				
				' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_pincode_data_provider',
						'value' => 'shiprocket',
					)
				) ),
				Field::make( 'text', 'bt_sst_shipmozo_pickup_pincode', __( 'Pickup Pincode' ) )
				->set_default_value( $base_postcode )
				->set_help_text( 'Required. Enter pincode of your warehouse/pickup point. Should be same as given in shipping aggregator.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_pincode_data_provider',
						'value' => 'shipmozo',
					)
				) ),


				Field::make( 'text', 'bt_sst_delhivey_min_day_picker', __( 'Minimum Day' ) )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_pincode_data_provider',
						'value' => 'delhivery',
					)
				) ),

				Field::make( 'text', 'bt_sst_delhivey_max_day_picker', __( 'Maximum Day' ) )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_pincode_data_provider',
						'value' => 'delhivery',
					)
				) ),
				Field::make( 'text', 'bt_sst_nimbuspost_pickup_pincode', __( 'Pickup Pincode' ) )
				->set_default_value( $base_postcode )
				->set_help_text( 'Required. Enter pincode of your warehouse/pickup point. Should be same as given in shipping aggregator.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_pincode_data_provider',
						'value' => 'nimbuspost_new',
					)
				) ),

			
			Field::make( 'text', 'bt_sst_generic_google_key', __( 'Enter your Google API key.') )
				->set_attribute( 'placeholder', 'Enter google api key.' )
				->set_help_text('
				<p>Google geocoding api is used to fetch the City name from pin code, used for only for domestic pin codes.</p>
				<a target="_blank" href="https://developers.google.com/maps/documentation/geocoding/get-api-key">Click here to get api key</a>
				')
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_pincode_data_provider',
						'value' => 'generic',
					)
				) ),
			Field::make( 'complex', 'bt_sst_pincode_estimate_generic_provider','Courier Settings' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_pincode_data_provider',
						'value' => 'generic',
					)
				) )
				->add_fields('domestic', array(
					Field::make( 'text', 'bt_sst_product_page_generic_domestic_min_days', __( 'Minimum Days' ) )
						->set_help_text( '<p>Minimum Days required for domestic delivery.</p>' ),	
					Field::make( 'text', 'bt_sst_product_page_generic_domestic_max_days', __( 'Maximum Days' ) )
						->set_help_text( '<p>Maximum days in which order will get delivered.</p>' ),		
					Field::make( 'text', 'bt_sst_product_page_generic_domestic_min_charges', __( 'Minimum Rate' ) )
						->set_help_text( '<p>Minimum rate for domestic delivery</p>' ),		
					Field::make( 'text', 'bt_sst_product_page_generic_domestic_max_charges', __( 'Maximum Rate' ) )
						->set_help_text( '<p>Maximum rate for domestic delivery</p>' ),
				) )
				->add_fields('international', array(
					Field::make( 'text', 'bt_sst_product_page_generic_intl_min_days', __( 'Minimum Days' ) )
						->set_help_text( '<p>Minimum Days required for international delivery.</p>' ),		
						Field::make( 'text', 'bt_sst_product_page_generic_intl_max_days', __( 'Maximum Days' ) )
						->set_help_text( '<p>Minimum rate for international delivery</p>' ),		
					Field::make( 'text', 'bt_sst_product_page_generic_intl_min_charges', __( 'Minimum Rate' ) )
						->set_help_text( '<p>Maximum days in which order will get delivered.</p>' ),			
						
					Field::make( 'text', 'bt_sst_product_page_generic_intl_max_charges', __( 'Maximum Rate' ) )
						->set_help_text( '<p>Maximum rate for internaltional delivery</p>' ),
				) )
				-> set_layout('tabbed-vertical')
				->set_duplicate_groups_allowed( false )
				->set_min( 1 )
				->set_max( 2),
			Field::make( 'text', 'bt_sst_shiprocket_processing_days', __( 'Global Processing Days' ) )
				->set_help_text( 'Required. Processing days to improve the accuracy of estimated delivery date. This will be added to the EDD of couriers.
				<br>You can set this at "Product Category" or "Product" or "Variations" level as well. 
				<br>Precedence: Global < Product Category < Product < Variation
				' )
				->set_default_value( '0' )
				->set_attribute( 'placeholder', '0' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
					
				) ),	
			Field::make( 'select', 'bt_sst_shiprocket_processing_days_location', __( 'Display Processing Days' ) )
				->set_options( array(
					'do_not_show' => 'Do not show',
					'woocommerce_before_single_product_summary' => 'Before single product summary',
					'woocommerce_single_product_summary' => 'Single product summary',
					'woocommerce_before_add_to_cart_form' => 'Before add to cart form',
					'woocommerce_before_add_to_cart_button' => 'Before add to cart button',
					'woocommerce_before_add_to_cart_quantity' => 'Before add to cart quantity',
					'woocommerce_after_add_to_cart_button' => 'After add to cart button',
					'woocommerce_after_add_to_cart_form' => 'After add to cart form',
					'woocommerce_product_meta_start' => 'Product meta start',
					'woocommerce_product_meta_end' => 'Product meta end',
					'woocommerce_after_single_product_summary' => 'After single product summary',

				) )
				//->set_default_value( 'do_not_show' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					),
					
				) ),
				
		
			Field::make( 'text', 'bt_sst_product_page_delivery_checker_label', __( 'Label' ) )
				->set_help_text( 'Label to be shown in product page, above pincode textbox.  <br><br>
				PHP Filters:<br>
				1.  add_filter("bt_sst_product_page_delivery_checker_label_text", "filter_callback"); => To modify the label.<br>
				2.  add_filter("bt_sync_shimpent_track_pincode_checker_shipping_to_text", "filter_callback"); => To modify the <b>Shipping To IN</b> text above the pincode textbox.<br>
				' )
				->set_default_value( 'Check delivery options in your location:' )
				->set_attribute( 'placeholder', 'Check delivery options in your location:' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					)
				) ),
			Field::make( 'text', 'bt_sst_message_text_template', __( 'Message Text Template' ) )
				->set_help_text( 'Available variables: #city#, #pincode#, #min_date#, #max_date#, #min_date_charges#, #max_date_charges#, #cutoff_time#. Html is allowed.
				<br>
				Sample Templates:<br>
				1. Estimated delivery by &lt;b&gt;#min_date#&lt;/b&gt; &lt;br&gt; Delivering to #city# &lt;br&gt; #cutoff_time#<br>
				2. Get it by &lt;b&gt;#min_date#&lt;/b&gt; at #city#. &lt;br&gt;#cutoff_time#<br>
    			3. 🚚 Delivery by &lt;b&gt;#min_date#&lt;/b&gt; to #city# - #pincode# &lt;br&gt; #cutoff_time#.
				<br><br>
				Apply a preset:<br>
				<select id="bt_sst_pin_and_date_preview" name="bt_sst_pin_and_date_preview" style="margin: 10px 0px;">
					<option value="">Select</option>
					<option value="Estimated delivery by &lt;b&gt;#min_date#&lt;/b&gt; &lt;br&gt; Delivering to #city# &lt;br&gt; #cutoff_time#">Message Text Template - 1</option>
					<option value="Get it by &lt;b&gt;#min_date#&lt;/b&gt; at #city#. &lt;br&gt;#cutoff_time#">Message Text Template - 2</option>
					<option value="🚚 Delivery by &lt;b&gt;#min_date#&lt;/b&gt; to #city# - #pincode# &lt;br&gt; #cutoff_time#">Message Text Template -3 </option>
				</select>
				<p>Message Text Template Preview:</p>
				<div id="bt_sst_pin_and_date_show_preiview" style="display: none;border: 1px solid #8c8f94; padding: 7px; border-radius: 5px; margin: 5px 0;">
					
				</div>
				' )
				->set_attribute( 'placeholder', 'Enter text template to use for edtimated delivery text.' )
				->set_default_value( 'Estimated delivery by <b>#min_date#</b> <br> Delivering to #city# <br> #cutoff_time#' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_shiprocket_pincode_checker',
						'value' => true,
					)
				) ),
		
			Field::make( 'html', 'bt_sst_product_premium_message', __( 'Premium Hint' ) )
				->set_html(
					$premium_message
				),
			Field::make( 'html', 'bt_sst_login_on_product_tab', __( 'Login to Activate Premium Features' ) )
				->set_html(
					$login_html
				),
		) );



		$shipping_mode_is_manual_or_ship24 = carbon_get_theme_option( 'bt_sst_enabled_custom_shipping_mode' );
		if(is_array($enabled_shipping_providers) && in_array('manual',$enabled_shipping_providers) && $shipping_mode_is_manual_or_ship24=="ship24"){
		$enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
		$ship24_webhook_time = get_option( "ship24_webhook_called", "never" );
		if($ship24_webhook_time!="never"){
			$ship24_webhook_time = date('Y-m-d H:i:s', $ship24_webhook_time);
		}
			$container = $container->add_tab( __( 'Ship24' ), array(
					Field::make( 'html', 'bt_sst_ship24_webhook_html', __( 'Ship24 Webhook URL' ) )
					->set_html(
						sprintf( '
							<p><b>Ship24 Webhook URL: [<a target="_blank" href="https://dashboard.ship24.com/integrations/webhook">Configure Webhook Here</a>] </b></p>
							<p>'.get_site_url(null, '/wp-json/bt-sync-shipment-tracking-ship24/v1.0.0/webhook_receiver') . '<a href="#" class="bt_sst_copy_link" > Copy Link</a> </p>
							<p>Last Webhook Called On: '.$ship24_webhook_time.'</p>
						'),
					),
					Field::make( 'text', 'bt_sst_ship24_apitoken', __( 'API Token' ) )
						->set_help_text( ' 
							<a target="_blank" href="https://dashboard.ship24.com/integrations/api-keys">[Click here to get API Token]</a>
							'
					),
					Field::make('html', 'api_test_connection_html', __('Test API Connection'))
						->set_html(sprintf('
							<button type="button" class="button" id="api_test_connection_btn_ship24">Test Connection</button><br>
							<em class="cf-field__help">Please click "Save Changes" to save API credentials before testing the connection.</em>
							<div id="api_test_connection_modal_ship24" class="modal" style="display:none;">
								<div class="modal-background"></div>
								<div class="modal-card">
									<header class="modal-card-head">
										<p id="api_tc-m-content_ship24" class="modal-content"></p>
										<button type="button" id="api_tc_m_close_btn_ship24" class="delete" aria-label="close"></button>
									</header>
								</div>
							</div>')
				),
										
			) );
		}

		// $enabled_pincode_ckecker_report = carbon_get_theme_option( 'bt_sst_report_pincode_checker' );

		// if ( $enabled_pincode_ckecker_report != 0 ) {
		// 	ob_start();
		// 	include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/bt-shipment-tracking-pincode-report.php';
		// 	$result = ob_get_clean();
			
		// 	$container = $container->add_tab( __( 'Report' ), array(
		// 		Field::make( 'html', 'crb_phone_number', __( 'Phone Number' ) )
		// 		->set_html(
		// 			sprintf( $result )
		// 		),
		// 	));
		// }

		$woocommerce_shipping_settings_url = admin_url('admin.php?page=wc-settings&tab=shipping');
			
		$container = $container->add_tab( __( 'Checkout Page (Premium Only)' ), array(
			Field::make( 'checkbox', 'bt_sst_auto_fill_city_state', __( 'Automatically fetch city & state from pincode.') )
				->set_option_value( 'no' )
				->set_classes( 'title is-6' )
				->set_help_text('Plugin will automatically fill City and State on checkout page based on the Pin Code entered by the user.
				<a target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/automatically-fetch-city-state-from-pincode-on-woocommerce-checkout/">See Demo</a>
				'),
			Field::make( 'select', 'bt_sst_data_provider', __( 'Pin Code data provider' ) )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_auto_fill_city_state',
						'value' => true,
					)
				) )
				->set_options( array(
					'google' => 'Google Geocode',
					'shiprocket' => 'Shiprocket',
					'delhivery' => 'Delhivery',
				) )
				->set_default_value( 'shiprocket' )
				->set_help_text( '
				<p><b>Shiprocket:</b> Only Indian Pin Codes are supported. Make sure the Shiprocket\'s API settings are correctly set to use this provider. <a href="https://www.youtube.com/watch?v=8nds10GbsVE" target="_blank">See Video</a></p>
				<p><b>Google Geocode:</b> All countries are supported. Select this provider to fetch pin code data from Google Geocode API. This feature requires Google Geocode API Key.</p>
				<p>NOTE: Pin Code data is cached for 12 hours.</p>
				' ),
			Field::make( 'text', 'bt_sst_google_key', __( 'Enter your Google API key.') )
				->set_attribute( 'placeholder', 'Enter google geocoding api key.' )
				->set_help_text('
				<a target="_blank" href="https://developers.google.com/maps/documentation/geocoding/get-api-key">Click here to get Google Geocode Api Key</a>
				')
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_auto_fill_city_state',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_data_provider',
						'value' => 'google',
					)
				) ),
				
			Field::make( 'checkbox', 'bt_sst_select_courier_company', __( 'Let users select courier company for shipping.') )
				->set_help_text('<p>Shows list of courier companies along with estimated delivery date and respective charges during checkout. Users can choose the desired courier company and pay shipping accordingly.</p>
				<p>Plugin populates Prepaid/COD rates correctly from the aggregators considering total weight and size of the package based on the products added into cart.</p>
				<p><b>For this option to work, make sure that the weight and dimensions are correctly set for every product. Keep some packaging buffer for better accuracy in calculation. </b>
				<a target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/let-users-select-courier-company-for-shipping-in-woocommerce/">See Demo</a></p>
				')
				->set_classes( 'title is-6' )
				->set_option_value( 'no' ),
			Field::make( 'select', 'bt_sst_courier_rate_provider', __( 'Courier rates provider' ) )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					)
				) )
				->set_help_text('<p>Courier companies and their respective rates will be fetched from the selected provider.</p>
				<p><b>Shiprocket:</b> Make sure the Shiprocket\'s API settings are correctly set to use this provider. <a href="https://www.youtube.com/watch?v=8nds10GbsVE" target="_blank">See Video</a></p>
				<p><b>Custom Shipping:</b> Select this provider to define the couriers and the costs yourself.</p>
				')
				->set_options( array(
					'generic' => 'Custom Shipping',
					'delhivery'=> 'Delhivery',
					'nimbuspost_new'=> 'Nimbuspost',
					'shipmozo' => 'Shipmozo',
					'shiprocket' => 'Shiprocket',
					
					
					
				) )
				->set_default_value( 'shiprocket' ),

			Field::make( 'complex', 'bt_sst_add_shipping_methods', __( 'Add Shipping Methods:' ) )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'value' => 'generic',
					)
				) )
				->add_fields( array(
					Field::make( 'text', 'bt_sst_shipping_method', __( 'Courier Name: ' ) ),
					Field::make( 'select', 'bt_sst_rate_type', __( 'Rate Type (Flat Rate, Rate per 500gm): ' ) )
					->set_options( array(
						'flat_rate' => 'Flat Rate',
						'rate_per_500gm' => 'Rate per 500gm',
					) ),
					Field::make( 'text', 'bt_sst_prepaid_rate', __( 'Prepaid Rate: ' ) )
					->set_attribute( 'type', 'number' ),
					Field::make( 'text', 'bt_sst_cod_rate', __( 'COD Rate: ' ) )
					->set_attribute( 'type', 'number' ),
					Field::make( 'select', 'bt_sst_courier_type', __( 'Courier Type: ' ) )
					->set_options( array(
						'domestic' => 'Domestic',
						'international' => 'International',
					) ),
				) ),
		

			Field::make( 'multiselect', 'bt_sst_courier_companies', __( 'Allowed courier companies' ) )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'value' => 'shiprocket',
					)
				) )
				->set_help_text('Only selected couriers will be available for shipping during checkout, other courier companies will be ignored.
				<br> Make sure to set "Courier rates provider" first, then do "Save Changes" before courier list can be populated.
				<br>Leave empty to enable all couriers that are available for a pickup/delivery pincode combination.
				')
				->add_options( $arr_active_cc ),
			Field::make( 'text', 'bt_sst_shipmozo_pickup_pincode_courier', __( 'Pickup pincode' ) )
				->set_default_value( $base_postcode )
				->set_attribute( 'type', 'number' )
				->set_help_text( 'Enter pincode of your warehouse/pickup point. Should be same as given in shipping aggregator.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'value' => 'shipmozo',
					)
				) ),
			Field::make( 'text', 'bt_sst_shipmozo_fall_back_rate', __( 'Fall Back Rate (Per 500gm)' ) )
				->set_attribute( 'type', 'number' )
				->set_help_text( 'Fallback rate is used when no courier is available between any pickup/delivery combination. Leave it empty if you do not want to use any fallback rate.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'value' => 'shipmozo',
					)
				) ),
				Field::make( 'text', 'bt_sst_delhivery_fall_back_rate', __( 'Fall Back Rate (Per 500gm)' ) )
				->set_attribute( 'type', 'number' )
				->set_help_text( 'Fallback rate is used when no courier is available between any pickup/delivery combination. Leave it empty if you do not want to use any fallback rate.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'value' => 'delhivery',
					)
				) ),
				Field::make( 'text', 'bt_sst_nimbuspost_new_pickup_pincode_courier', __( 'Pickup pincode' ) )
				->set_default_value( $base_postcode )
				->set_attribute( 'type', 'number' )
				->set_help_text( 'Enter pincode of your warehouse/pickup point. Should be same as given in shipping aggregator.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'value' => 'nimbuspost_new',
					)
				) ),
			Field::make( 'text', 'bt_sst_nimbuspost_new_fall_back_rate', __( 'Fall Back Rate (Per 500gm)' ) )
				->set_attribute( 'type', 'number' )
				->set_help_text( 'Fallback rate is used when no courier is available between any pickup/delivery combination. Leave it empty if you do not want to use any fallback rate.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'value' => 'nimbuspost_new',
					)
				) ),
				Field::make( 'text', 'bt_sst_shiprocket_pickup_pincode_courier', __( 'Pickup pincode' ) )
				->set_default_value( $base_postcode )
				->set_attribute( 'type', 'number' )
				->set_help_text( 'Enter pincode of your warehouse/pickup point. Should be same as given in shipping aggregator.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'value' => 'shiprocket',
					)
				) ),
			Field::make( 'text', 'bt_sst_shiprocket_fall_back_rate', __( 'Fall Back Rate (Per 500gm)' ) )
				->set_attribute( 'type', 'number' )
				->set_help_text( 'Fallback rate is used when no courier is available between any pickup/delivery combination. Leave it empty if you do not want to use any fallback rate.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'value' => 'shiprocket',
					)
				) ),
			
			Field::make( 'text', 'bt_sst_markup_charges', __( 'Rate markup/discount amount:' ) )
				->set_attribute( 'type', 'number' )
				->set_help_text( 'Adds this amount on top of courier rates (packaging cost for example). You can set it to a negative value to give some discount as well. Leave it empty to disable this feature.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					)
				) )
				->set_default_value( '0' ),
			Field::make( 'checkbox', 'bt_sst_show_delivery_date', __( 'Show estimated delivery date along with courier name and rates.') )
				->set_option_value( 'no' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'compare' => 'IN',
						'value' => array('shiprocket','shipmozo'),
					)
				) ),
			Field::make( 'text', 'bt_sst_shipment_processing_days', __( 'Processing Days' ) )
				->set_attribute( 'type', 'number' )
				->set_help_text( 'Processing days to improve the accuracy of estimated delivery date. This will be added to the EDD of couriers. This value cannot be negative.' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_show_delivery_date',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'compare' => 'IN',
						'value' => array('shiprocket','shipmozo'),
					)
				) ),
			Field::make( 'checkbox', 'bt_sst_show_secure_shipment_rates', __( 'Show secure shipment rates for order above 2500/-.') )
				->set_option_value( 'no' )
				->set_help_text( 'Automatically adds coverage charges to insure the shipmnents of above 2500/-' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'value' => 'shiprocket',
					)
				) )
				->set_default_value( '0' ),
			
			
			
			Field::make( 'checkbox', 'bt_sst_enable_international_shiprocket', __( 'Fetch international shipping rates from shiprocket.') )
				->set_option_value( 'no' )
				->set_help_text( '
				<p>Enable this option if International Shipping is enabled in your shiprocket account.</p>
				<p>If this option is disabled, standard woocommerce shipping zones will be used for international orders.<p>
				
				' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					),
					array(
						'field' => 'bt_sst_courier_rate_provider',
						'value' => 'shiprocket',
					)
				) ),
			Field::make( 'html', 'bt_sst_free_shipping_html' )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_select_courier_company',
						'value' => true,
					)
				) )
    			->set_html( '<h3 class="title is-6">Want to configure FREE SHIPPING?</h3>
							<p>Just create Free Shipping method(s) in woocommerce settings and they will be honored by this plugin.</p>
							<p><a href="'.$woocommerce_shipping_settings_url .'" target="_blank">Click here</a> to go to Woocommerce Shipping Settings.</p>
							' 
			),
			Field::make( 'checkbox', 'bt_sst_show_shipment_weight', __( 'Show shipment weight during checkout') )
				->set_classes( 'title is-6' )
				->set_help_text('Shows approximate weight of shipment based on the products added in cart. For this option to work, make sure that the weight and dimensions are correctly set for every product. 
				<a target="_blank" href="https://shipment-tracker-for-woocommerce.bitss.tech/show-shipment-weight-during-checkout-in-woocommerce/">See Demo</a>
				')
				->set_option_value( 'no' ),
			Field::make( 'select', 'bt_sst_list_weight_unit', __( 'Select the unit of weight.' ) )
				->set_conditional_logic( array(
					array(
						'field' => 'bt_sst_show_shipment_weight',
						'value' => true,
					)
				) )

				->set_options( array(
					'kg' => 'kg',
					'g'	=>	'g',
					'lbs' => 'lbs',
					'oz' => 'oz'
				) )
				->set_default_value( 'kg' ),
			Field::make( 'html', 'bt_sst_checkout_premium_message', __( 'Premium Hint' ) )
				->set_html(
					$premium_message
				),
			Field::make( 'html', 'bt_sst_login_on_checkout_tab', __( 'Login to Activate Premium Features' ) )
				->set_html(
					 $login_html
				),
		) );

		if(is_admin() && isset($_GET["page"]) && $_GET['page']=="crb_carbon_fields_container_shipment_tracking.php"){
			$premium_html = file_get_contents(plugin_dir_path( dirname( __FILE__ ) )  . 'admin/partials/bt-st-buy-premium-feature-tab.php');
			$csrf =  wp_nonce_field( 'check_user_data_for_premium_features','_wpnonce',true,false );
			$premium_html = str_replace("##csrf##", $csrf, $premium_html);
			$bulma = plugin_dir_url(dirname(__FILE__)) . 'admin/css/bulma.min.css';
			$premium_html = str_replace("##bulma##",$bulma,$premium_html);
			$premium_html = str_replace("##premiumfeatures##",$login_html,$premium_html);
			$container = $container->add_tab( __( 'Buy Premium' ), array(
				Field::make( 'html', 'bt_sst_premium_html', __( 'Buy Premium Features' ) )
					->set_html(
						$premium_html
					),
			) );

			$developer_html = file_get_contents(plugin_dir_path( dirname( __FILE__ ) )  . 'admin/partials/developer-doc.html');
			$container = $container->add_tab( __( 'Developer' ), array(
				Field::make( 'html', 'bt_sst_developer_html', __( 'Developer Options HTML' ) )
					->set_html(
						sprintf( $developer_html)
					),
			) );

			$container = $container->add_tab( __( 'Help' ), array(
				Field::make( 'html', 'bt_sst_help_html', __( 'Help HTML' ) )
					->set_html(
						sprintf( '
						<div class="content">
							<b>Shiprocket Integration Steps: </b> 
							<p>
								<ol type="1">
									<li>Enable Shiprocket in General Tab.</li>
									<li><a target="_blank" href="https://www.shiprocket.in/">Create & Activate Shiprocket Account</a></li>
									<li><a target="_blank" href="https://app.shiprocket.in/api-user">Create Api User</a></li>
									<li><a target="_blank" href="https://app.shiprocket.in/shipment-webhook">Configure Webhook URL</a></li>
									<li><a target="_blank" href="https://app.shiprocket.in/channels">Get Channel ID</a></li>
									<li>Copy API user, Api password and Channel ID to Shiprocket Tab.</li>
								</ol>
								
							</p>
							<b>Shyplite Integration Steps: </b> 
							<p>
								<ol type="1">
									<li>Enable Shyplite in General Tab.</li>
									<li><a target="_blank" href="https://shyplite.com/">Create & Activate Shyplite Account</a></li>
									<li><a target="_blank" href="https://pitneybowes.shyplite.com/settings/api">Enable API</a></li>
									<li>Copy Seller Id, App ID, Public key and Secret Key to Shyplite Tab.</li>
								</ol>
								
							</p>	
							<b>Nimbuspost Integration Steps: </b> 
							<p>
								<ol type="1">
									<li>Enable Nimbuspost in General Tab.</li>
									<li><a target="_blank" href="https://www.nimbuspost.com/">Create & Activate Nimbuspost Account</a></li>
									<li><a target="_blank" href="https://ship.nimbuspost.com/user_api">Generate Api Key</a></li>
									<li><a target="_blank" href="https://ship.nimbuspost.com/webhook/add">Configure Webhook URL</a></li>
									<li>Copy API key to Nimbuspost Tab.</li>
								</ol>
								
							</p>						
							<b>To force Sync tracking of specific order:</b>
							<p>
									<ol>
										<li>Go to order details page.</li>
										<li>Click edit icon of Shipping info.</li>
										<li>Select for correct Shipping Provider of the order.</li>
										<li>Go to Sync Shipping Tracking meta box in right side.</li>
										<li>Click on "Sync Tracking Now" button.</li>
										<li>The shipment tracking will be synced from respective shipping provider.</li>
									</ol>
									
							</p>
							<b>To manually add shipment tracking information of specific order:</b>
							<p>
									<ol>
										<li>Go to order details page.</li>
										<li>Click edit icon of Shipping info.</li>
										<li>Select "Manual" option from Shipping Provider dropdown.</li>
										<li>Update order and the shipment tracking fields will be visible in right side meta box.</li>
										<li>Fill the all necessary information and update the order.</li>
										<li>Done!</li>
									</ol>
									
							</p>
							</div>
						')
					),
			) );

			$container = $container->add_tab( __( 'About' ), array(
				Field::make( 'html', 'bt_sst_about_html', __( 'About HTML' ) )
					->set_html(
						sprintf( '		
						<div class="content">					
							<img src="'.self::BITSSLOGO.'" alt="Bitss Techniques logo"/><br>
							<b>Developed by: <a target="_blank" href="https://bitss.tech">Bitss Techniques</a></b><br>
							<em>Made in India</em>
							<br><br>
							If you find this plugin useful, please spare a minute to leave a 5 star review on wordpress. 
							<br>
							<a target="_blank" href="https://wordpress.org/support/plugin/shipment-tracker-for-woocommerce/reviews/#new-post">Rate This Plugin (Shipment Tracker)</a>
							<br><br>
							Found an bug/vulnerability please report to <a  target="_blank" href="https://wordpress.org/support/plugin/shipment-tracker-for-woocommerce/">plugin support</a>.
							<br><br>
							For any suggestions/feedback please <a  target="_blank" href="https://bitss.tech/">contact us</a>.
							<br><br>
							Other services we provide:
							<ol>
								<li>
									Developer Friendly enterprise hosting with automatic horizontal & vertical scaling for very busy websites.
									<a target="_blank" href="https://bitss.cloud/">
										See Details
									</a>
								</li>
								<li>
								Effortlessly create website/webstore without doing any dirty work! Fully managed & cost effective, automatic website creator.
									<a target="_blank" href="https://orderpal.in">
									See Details
									</a>
								</li>
								<li>
									Managed low cost hosting for low to medium traffic websites.
									<a target="_blank" href="https://bitss.tech/">
									See Details
									</a>
								</li>
								<li>
									Reliable & Genuine Transactional & OTP SMS APIs
									<a target="_blank" href="https://smsapi.bitss.tech">
									See Details	
									</a>
								</li>
								<li>
									Turn your website into a secure windows/android app
									<a target="_blank" href="https://websitekiosker.com/">
									See Details	
									</a>
								</li>
								<li>
									Custom wordpress development/customization services.
									<a target="_blank" href="https://bitss.tech/">
									See Details	
									</a>
								</li>
							</ol>
							</div>
						')
					),
			) );

			$container = $container->add_tab( __( 'Donate' ), array(
				Field::make( 'html', 'bt_sst_donate_html', __( 'Donate HTML' ) )
					->set_html(
						sprintf( '							
							We hope this plugin have made your life easier as an ecommerce store developer/owner. But at the same time, developing and maintaining plugin like this demand lots of time and efforts. Also, things does not always work as it should so providing support is critical so people dont feel hanging. And all of this at no cost to the plugin users.<br><br>

							There are many more features coming along the way in future updates like support for Custom Order Statuses based on shipment status, Bulk Sync tracking, Adding many more shipping aggregators, SMS, Email and WhatsApp integration to inform shipment status to customers, pincode based shipping rate and estimated delivery checker,  etc. Some of these features may be premium while all basic features will be free forever.

							<br><br>

							Until we release a premium version, if you would like to contribute for the plugin development today, click on the "Donate" link below. You can donate any amount you like, but donating something above Rs. 500 would be really helpful.
							
							<br><br>

							If you choose to donate, as a token of appreciation, we will provide you all future premium versions free of cost (for any 1 of your website(s)), irrespective of the amount you donate.
							<br><br>
							We will send you GST invoice as well for the donations you make. Also, its your choice to donate just once, more than once, or monthly :-)
							<br><br>
							<a href="https://pmny.in/6JB4CzvwowVL" target="_blank">Click here to Donate</a>
						')
					),
			) );
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Bt_Sync_Shipment_Tracking_Public( $this->get_plugin_name(), $this->get_version() ,$this->shiprocket, $this->shipmozo, $this->nimbuspost_new, $this->licenser, $this->delhivery);

		// $pincode_checker_location_hook = carbon_get_theme_option( 'bt_sst_pincode_checker_location' );
		// $this->loader->add_action( 'dokan_order_detail_after_order_general_details',$plugin_public, 'custom_dokan_order_details', 10, 1 );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'woocommerce_account_orders_columns', $plugin_public, 'wc_add_my_account_orders_column' );
		$this->loader->add_action( 'woocommerce_my_account_my_orders_column_order-shipment', $plugin_public, 'wc_my_orders_shipment_column' );
        $this->loader->add_shortcode( 'bt_shipping_tracking_form', $plugin_public,  'bt_shipping_tracking_form' );
		$this->loader->add_shortcode( 'bt_estimated_delivery_widget', $plugin_public,  'bt_estimated_delivery_widget' );

		/**Show Input Box & Button (pincode checker) on product page */
		// $this->loader->add_action( 'woocommerce_before_add_to_cart_form', $plugin_public, 'show_pincode_input_box' );
		$this->loader->add_action( 'init', $plugin_public, 'init_hook_handler' );

		$this->loader->add_action( 'wp_ajax_get_pincode_data_product_page', $plugin_public, 'get_pincode_data_product_page' );
		$this->loader->add_action( 'wp_ajax_nopriv_get_pincode_data_product_page', $plugin_public, 'get_pincode_data_product_page' );
		
		/**To Auto Fill City & State using pincode on checkout page */
		$this->loader->add_action( 'wp_ajax_get_pincode_data_checkout_page', $plugin_public, 'get_pincode_data_checkout_page' );
		$this->loader->add_action( 'wp_ajax_nopriv_get_pincode_data_checkout_page', $plugin_public, 'get_pincode_data_checkout_page' );
		$this->loader->add_action( 'woocommerce_order_details_after_customer_details', $plugin_public, 'woocommerce_order_details_after_customer_details' );

		/**change woocommerce package rate array */
		$this->loader->add_filter( 'woocommerce_package_rates', $plugin_public, 'update_woocommerce_package_rates', 1, 2 );
		$this->loader->add_filter( 'woocommerce_checkout_update_order_review', $plugin_public, 'refresh_shipping_methods');
		$this->loader->add_filter( 'woocommerce_review_order_before_payment', $plugin_public, 'payment_methods_trigger_update_checkout');
		$this->loader->add_filter( 'woocommerce_cart_totals_before_shipping', $plugin_public, 'woocommerce_cart_totals_before_shipping');
		$this->loader->add_filter( 'woocommerce_review_order_before_shipping', $plugin_public, 'woocommerce_cart_totals_before_shipping');
		$this->loader->add_filter( 'woocommerce_default_address_fields', $plugin_public, 'woocommerce_default_address_fields', 1000, 1 );

		$this->loader->add_shortcode( 'bt_shipping_tracking_form_2', $plugin_public,  'bt_shipping_tracking_form_2' );

		//public shortcodes for shipment related data
		$this->loader->add_shortcode( 'bt_shipment_tracking_url', $plugin_public,  'bt_shipment_tracking_url_shortcode_callback' );
	 	$this->loader->add_shortcode( 'bt_shipment_status', $plugin_public,  'bt_shipment_status_shortcode_callback' );
		$this->loader->add_shortcode( 'bt_shipment_courier_name', $plugin_public,  'bt_shipment_courier_name_shortcode_callback' );
		$this->loader->add_shortcode( 'bt_shipment_edd', $plugin_public,  'bt_shipment_edd_shortcode_callback' );
		$this->loader->add_shortcode( 'bt_shipment_awb', $plugin_public,  'bt_shipment_awb_shortcode_callback' );

		$this->loader->add_filter( 'woocommerce_email_format_string', $plugin_public,  'woocommerce_email_format_string_shipment_placeholders_callback', 10, 2  );

		$this->loader->add_filter( 'woocommerce_my_account_my_orders_actions', $plugin_public,  'add_track_button_to_my_orders', 10, 2  );
		$this->loader->add_filter( 'query_vars', $plugin_public,  'add_query_vars' );
		$this->loader->add_action( 'woocommerce_account_bt-track-order_endpoint', $plugin_public,  'woocommerce_account_track_order_endpoint' );


	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Bt_Sync_Shipment_Tracking_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
