<?php


class Bt_Sync_Shipment_Tracking_Rest {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
    private $version;

    private $rest_route;

    private $rest_route_cart;

    private $rest_functions;

    private $rest_route_shiprocket;

    private $rest_route_shipmozo;
    private $rest_route_nimbuspost;
    private $rest_route_xpressbees;
    private $rest_route_manual;
    private $rest_route_ship24;
    private $rest_route_nimbuspost_new;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $shiprocket, $shyplite, $nimbuspost, $manual, $xpressbees, $shipmozo, $nimbuspost_new, $ship24) {

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bt-sync-shipment-tracking-rest-functions.php';

		$this->plugin_name = $plugin_name;
		$this->version = "v1.0.0";
        $this->rest_route = "bt-sync-shipment-tracking";
        $this->rest_route_shiprocket = "bt-sync-shipment-tracking-shiprocket";
        $this->rest_route_nimbuspost = "bt-sync-shipment-tracking-nimbuspost";
        $this->rest_route_nimbuspost_new = "bt-sync-shipment-tracking-nimbuspost-new";
        $this->rest_route_xpressbees = "bt-sync-shipment-tracking-xpressbees";
        $this->rest_route_shipmozo = "bt-sync-shipment-tracking-shipmozo";
        $this->rest_route_manual = "bt-sync-shipment-tracking-manual";
        $this->rest_route_ship24 = "bt-sync-shipment-tracking-ship24";

        $this->rest_functions = new Bt_Sync_Shipment_Tracking_Rest_Functions($shiprocket,$shyplite,$nimbuspost, $manual, $xpressbees,$shipmozo,$nimbuspost_new, $ship24);
    }

    public function rest_shiprocket_webhook(){
        register_rest_route( $this->rest_route_shiprocket . '/' . $this->version , 'webhook_receiver', array(
            'methods' => 'POST',
            'callback' => array($this->rest_functions,"shiprocket_webhook_receiver"),
            'permission_callback' => '__return_true',
        ));

        $random_rest_route = get_option( 'bt-sync-shipment-tracking-random-route' );
        if(!empty($random_rest_route)){
            register_rest_route( $random_rest_route ,$random_rest_route, array(
                'methods' => 'POST',
                'callback' => array($this->rest_functions,"shiprocket_webhook_receiver"),
                'permission_callback' => '__return_true',
            ));
        }

    }
     
    public function rest_shipmozo_webhook(){
        register_rest_route( $this->rest_route_shipmozo . '/' . $this->version , 'webhook_receiver', array(
            'methods' => 'POST',
            'callback' => array($this->rest_functions,"shipmozo_webhook_receiver"),
            'permission_callback' => '__return_true',
        ));

    }

    function generate_random_webhook_string(){
        $random_rest_route = get_option( 'bt-sync-shipment-tracking-random-route' );
        if($random_rest_route==false){
            $random_rest_route = $this->getRandomBytes();
            update_option('bt-sync-shipment-tracking-random-route',$random_rest_route);
        }
    }

    function generate_random_webhook_secret_key(){
        $random_rest_secret = get_option( 'bt-sync-shipment-tracking-random-secret-key' );
        if($random_rest_secret==false){
            $random_rest_secret = $this->getRandomBytes();
            update_option('bt-sync-shipment-tracking-random-secret-key',$random_rest_secret);
        }

        //generate/set nimbuspost secret key
        carbon_set_theme_option( 'bt_sst_nimbuspost_webhook_secretkey', $random_rest_secret);
        carbon_set_theme_option( 'bt_sst_xpressbees_webhook_secretkey', $random_rest_secret);
    }

    function generate_random_manual_webhook_secret_key(){
        $random_rest_secret = get_option( 'bt-sync-shipment-tracking-random-manual-secret-key' );
        if($random_rest_secret==false){
            $random_rest_secret = $this->getRandomBytes();
            update_option('bt-sync-shipment-tracking-random-manual-secret-key',$random_rest_secret);
        }

        //generate/set manual secret key
        carbon_set_theme_option( 'bt_sst_manual_webhook_secretkey', $random_rest_secret);
    }

    function getRandomBytes($length = 16)
    {
        if (function_exists('random_bytes')) {
            $bytes = random_bytes($length / 2);
        } else {
            $bytes = openssl_random_pseudo_bytes($length / 2);
        }
        return bin2hex($bytes);
    }

    public function rest_shyplite(){
        register_rest_route( $this->rest_route . '/' . $this->version , 'shyplite', array(
            'methods' => 'GET',
            'callback' => array($this->rest_functions,"rest_shyplite"),
            'permission_callback' => '__return_true',
        ));
    }

    public function rest_nimbuspost_webhook(){
        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        if(is_array($enabled_shipping_providers) && in_array('nimbuspost',$enabled_shipping_providers)){
            register_rest_route( $this->rest_route_nimbuspost . '/' . $this->version , 'webhook_receiver', array(
                'methods' => 'POST',
                'callback' => array($this->rest_functions,"nimbuspost_webhook_receiver"),
                'permission_callback' => '__return_true',
            ));
        }

        if(is_array($enabled_shipping_providers) && in_array('nimbuspost_new',$enabled_shipping_providers)){
            register_rest_route( $this->rest_route_nimbuspost_new . '/' . $this->version , 'webhook_receiver', array(
                'methods' => 'POST',
                'callback' => array($this->rest_functions,"nimbuspost_webhook_receiver_new"),
                'permission_callback' => '__return_true',
            ));
        }

    }

    public function rest_xpressbees_webhook(){
        register_rest_route( $this->rest_route_xpressbees . '/' . $this->version , 'webhook_receiver', array(
            'methods' => 'POST',
            'callback' => array($this->rest_functions,"xpressbees_webhook_receiver"),
            'permission_callback' => '__return_true',
        ));
    }
    public function rest_ship24_webhook(){
        register_rest_route( $this->rest_route_ship24 . '/' . $this->version , 'webhook_receiver', array(
            'methods' => 'POST',
            'callback' => array($this->rest_functions,"ship24_webhook_receiver"),
            'permission_callback' => '__return_true',
        ));
    }

    public function rest_manual_webhook(){
        register_rest_route( $this->rest_route_manual . '/' . $this->version , 'webhook_receiver', array(
            'methods' => 'POST',
            'callback' => array($this->rest_functions,"manual_webhook_receiver"),
            'permission_callback' => '__return_true',
        ));
    }





}
