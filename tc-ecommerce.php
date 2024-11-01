<?php
/**
 * Plugin Name: TC Ecommerce
 * Plugin URI: https://themes-coder.com/
 * Description: A wordpress Plugin for mobile app solution for android and iOS platform with WordPress WooCommerce as backend. 
 * Version: 1.3.4
 * Author: ThemesCoder
 * Author URI: https://themes-coder.com
 */

if (!defined('ABSPATH')) {exit;}

global $woocommerce , $wpdb;
define( 'TCVC_ABSPATH', dirname( __FILE__ ) . '/' );
define( 'TCVC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TCVC_APP_BANNERS_SETTINGS',  $wpdb->prefix . 'tc_app_banner_settings' ); 
define( 'TCVC_APP_ORDER_DATA', 		  $wpdb->prefix . 'tc_app_order_data' );
define( 'TCVC_NOTIFICATION_DEVICES',  $wpdb->prefix . 'tc_app_notification_devices' );
define( 'TCVC_ALL_NOTIFICATION', 	  $wpdb->prefix . 'tc_app_all_notification' );

$expire_time =  strtotime(date('M d, Y h:i:s'));

if(get_option('tc_app_purchase_code') != "" && get_option('tc_app_plugin_active') == 'active' && get_option('tc_app_buyer') != 'trial' ){
	if ( ! class_exists( 'ReduxFramework' ) && file_exists( plugin_dir_path(__FILE__) .'/framework/framework.php' ) ) {
	   require_once('framework/framework.php' );
	}
	
	if ( ! isset( $redux_demo ) && file_exists( plugin_dir_path(__FILE__) .'/functions/tc_app_setting_config.php' ) ) {
	   require_once( 'functions/tc_app_setting_config.php' );
	}
	
	add_action( 'admin_menu', 'tc_app_admin_menu' );
		
	
}elseif(get_option('tc_app_purchase_code') != "" && get_option('tc_app_plugin_active') == 'active' && get_option('tc_app_expiry') >= $expire_time && get_option('tc_app_buyer') == 'trial' ){
    
    if ( ! class_exists( 'ReduxFramework' ) && file_exists( plugin_dir_path(__FILE__) .'/framework/framework.php' ) ) {
	   require_once('framework/framework.php' );
	}
	
	if ( ! isset( $redux_demo ) && file_exists( plugin_dir_path(__FILE__) .'/functions/tc_app_setting_config.php' ) ) {
	   require_once( 'functions/tc_app_setting_config.php' );
	}
	
	add_action( 'admin_menu', 'tc_app_admin_menu' );
	add_action( 'admin_menu', 'tc_app_admin_menu_activation' );
}
else{
	add_action( 'admin_menu', 'tc_app_admin_menu_activation' );	
}

require_once( 'functions/tc_create_insert_tabel_functions.php' );
require_once( 'functions/tc_app_banners_setting.php' );
require_once( 'functions/tc_geo_fencing_functions.php' );
require_once( 'functions/tc_app_notifications_function.php' );
require_once( 'functions/tc_miscellaneous_functions.php' );

require_once( 'controller/app_user.php' );
require_once( 'controller/app_settings.php' );
require_once( 'controller/tc_tera_wallet.php' );

function all_app_routes() {
    $controller = new AppUserController();	
    $controller->tc_user_routes();
	
	$controller = new AppSettingsController();
	$controller->tc_app_routes();
	
	$controller = new TcTeraWalletController();
	$controller->tc_tera_wallet_routes();
} 
add_action( 'rest_api_init', 'all_app_routes' );


require_once __DIR__ .'/assets/src/Templater.php';
//use JO\Module\Templater\Templater;

add_action ( 'admin_notices', 'tc_app_admin_notices' );
register_activation_hook(__FILE__,'tc_app_create_order_page');

add_action( 'wp_head', 'tc_app_style_hook');
add_action( 'plugins_loaded', 'tc_app_load_checkout_template');
add_action( 'woocommerce_coupon_options_save', 'save_coupon_notification_tc_app');
add_action( 'rest_api_init' , 'tc_wp_rest_allow_all_cors', 15);

add_action( 'show_user_profile', 'tc_show_extra_profile_fields_for_wcvendor' );
add_action( 'edit_user_profile', 'tc_show_extra_profile_fields_for_wcvendor' );

add_action( 'personal_options_update', 'tc_save_extra_profile_fields_for_wcvendor' );
add_action( 'edit_user_profile_update', 'tc_save_extra_profile_fields_for_wcvendor' );



function tc_app_load_checkout_template()
{	
	$my_templater = new Templater( array('plugin_directory' => plugin_dir_path(__FILE__), 'plugin_prefix' => 'plugin_prefix_', 'plugin_template_directory' => 'templates',));
    $my_templater->add(array('page' => array('template-mobile-checkout.php' => 'Checkout Custom Template',),))->register();
} ?>