<?php


class Bt_Sync_Shipment_Tracking_Rest_Functions{

    private $shiprocket;
    private $shipmozo;
    private $shyplite;
    private $nimbuspost;
    private $nimbuspost_new;
    private $xpressbees;
    private $manual;
    private $ship24;

    public function __construct($shiprocket,$shyplite, $nimbuspost, $manual, $xpressbees, $shipmozo, $nimbuspost_new, $ship24 ) {

        $this->shiprocket = $shiprocket;
        $this->shipmozo = $shipmozo;
        $this->shyplite = $shyplite;
        $this->nimbuspost = $nimbuspost;
        $this->nimbuspost_new = $nimbuspost_new;
        $this->xpressbees = $xpressbees;
        $this->manual = $manual;
        $this->ship24 = $ship24;
    }

    public function shiprocket_webhook_receiver($request){
        return $this->shiprocket->shiprocket_webhook_receiver($request);
    }

    public function ship24_webhook_receiver($request){
        return $this->ship24->ship24_webhook_receiver($request);
    }

    public function shipmozo_webhook_receiver($request){
        return $this->shipmozo->shipmozo_webhook_receiver($request);
    }

    public function shiprocket_get_postcode($request){
        $resp = array(
            "status"=>false,
            "message"=>"",
            "data"=>array()
        );

        return $resp;
    }

    public function rest_shyplite($request){
        //$ob = new Bt_Sync_Shipment_Tracking_Crons();

        //return $ob->sync_shyplite_shipments();
        //$resp= $this->shyplite->get_order_tracking("3591");
       // $resp= $this->shiprocket->get_order_tracking("4569");
        // if(sizeof($resp)>0){
        //     $shipment_obj = $this->shiprocket->init_model($resp[0]);
        //     //update_post_meta($order_id, '_bt_shipment_tracking', $shipment_obj);
        //     return $shipment_obj;
        // }

        //$copyright = carbon_get_theme_option( 'crb_text' );

        return "";// $this->get_orders();
    }

    public function nimbuspost_webhook_receiver($request){
        return $this->nimbuspost->nimbuspost_webhook_receiver($request);
    }

    public function nimbuspost_webhook_receiver_new($request){
        return $this->nimbuspost_new->nimbuspost_webhook_receiver($request);
    }

    public function xpressbees_webhook_receiver($request){
        return $this->xpressbees->xpressbees_webhook_receiver($request);
    }

    public function nimbuspost_get_postcode($request){
        $resp = array(
            "status"=>false,
            "message"=>"",
            "data"=>array()
        );

        return $resp;
    }

    public function manual_webhook_receiver($request){
        return $this->manual->manual_webhook_receiver($request);
    }

}
