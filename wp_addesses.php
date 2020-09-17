<?php
/*
Plugin Name: wp_addresses
Plugin URI: https://seocontenidos.net/
Description: add the billing address as shipping address
Author: carloscode
Author URI:  https://seocontenidos.net/
Version: 0.0.1
*/

defined( 'ABSPATH' ) || exit;

Class DireccionesWoocommersHookTemCode {

    public $version = '0.0.1';
    private $functioncode;
    public $customer_id;
    function __construct()
    {
        $this->init();
    }

    public function init(){
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 11 );
        add_action( 'wp_enqueue_scripts', array( $this, 'admin_enqueue_scripts_loader' ), 11 );
        add_action('woocommerce_init',  array($this, 'on_woocommerce'));
        add_action('wp_ajax_temcode_ajax_submit', array($this, 'copybluddingAs'));
        add_action('wp_ajax_nopriv_temcode_ajax_submit', array($this, 'copybluddingAs'));
        $this->customer_id = get_current_user_id();
    }
    public function admin_enqueue_scripts_loader(){
        wp_enqueue_script( 'directemcode_ajax_js', plugin_dir_url( __FILE__ ) . 'js/js.js', array( 'jquery' ), $this->version, true );
		wp_localize_script('directemcode_ajax_js','ditemcode_vars',['ajaxurl'=>admin_url('admin-ajax.php')]);
    }
    public function on_woocommerce(){
        global $woocommerce;
        $this->functioncode = $woocommerce;
    }
    public function copybluddingAs(){
       


      $woo_customer = wp_get_current_user();
      $metaKeyVals = array(
          'shipping_first_name' => $this->functioncode->customer->get_billing_first_name(),
          'shipping_last_name' => $this->functioncode->customer->get_billing_last_name(),
          'shipping_address_1' => $this->functioncode->customer->get_billing_address_1(),
          'shipping_address_2' => $this->functioncode->customer->get_billing_address_2(),
          'shipping_country' => $this->functioncode->customer->get_billing_country(),
          'shipping_state' => $this->functioncode->customer->get_billing_state(),
          'shipping_postcode' => $this->functioncode->customer->get_billing_postcode(),
          'shipping_city' => $this->functioncode->customer->get_billing_city(),
          'shipping_phone' => $this->functioncode->customer->get_billing_phone(),
          'shipping_email' => $this->functioncode->customer->get_billing_email()
      );
      foreach ($metaKeyVals as $key => $val) {
          update_user_meta($woo_customer->ID, $key, $val);

      }
      $get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'shipping' => __( 'Dirección de Envío', 'woocommerce' ),
		),
		$this->customer_id
    );


foreach ( $get_addresses as $name => $address_title ){
    $address = wc_get_account_formatted_address( $name );
}

        die($address);
    }

}
$init = new DireccionesWoocommersHookTemCode();
