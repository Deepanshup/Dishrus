<?php
/*
Plugin Name: Autochat Whapp Contact Web Button
Plugin URI: https://autochat.uy/free-whatsapp-plugin-wp/
Description: The Button for WhatsApp chat allows you to embed it natively on your website, so that the user naturally makes his or her questions through this popular messaging platform. 
Version: 1.9.6
Author: Autochat
Author URI: https://autochat.uy
License: GPLv2 or later
Text Domain: autochat-button-for-mobile-chat
Domain Path: /languages/
*/

define('AUYTPW_DIR', plugin_dir_url( __FILE__ ));

include_once dirname( __FILE__ ) . '/includes/options.php';

function auytpw_add_scripts() {
 
	wp_enqueue_script( 'tpw_widget', AUYTPW_DIR . 'assets/js/widget.js', array ( 'jquery' ), 1.1, true);
	
	$tpw_settings = auytpw_get_settings();
	
	wp_localize_script( 'tpw_widget', 'tpw_settings', $tpw_settings );
	
	wp_register_style( 'tpw_widget_css', AUYTPW_DIR . 'assets/css/widget_css.css' );
	
    wp_enqueue_style( 'tpw_widget_css' );
 
}
add_action( 'wp_enqueue_scripts', 'auytpw_add_scripts' );

function auytpw_admin_style($tpw_hook) {
	
	if($tpw_hook == "toplevel_page_auy_whasapp"){
		wp_register_style('tpw_panel_style', AUYTPW_DIR . 'assets/css/admin.css', __FILE__);
		wp_register_style('tpw_bootstrapp_style', AUYTPW_DIR . 'assets/css/bootstrap.min.css', __FILE__);
		
		wp_enqueue_style('tpw_bootstrapp_style');
		wp_enqueue_style('tpw_panel_style');
		
	}
  
}
add_action('admin_enqueue_scripts', 'auytpw_admin_style');


function auytpw_js_scripts(){
	wp_enqueue_media();
	wp_register_script('tpw_upload', AUYTPW_DIR . 'assets/js/upload.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('tpw_upload');
}
add_action('admin_enqueue_scripts', 'auytpw_js_scripts');

/**
 * Register menu page.
 */
function auytpw_register_menu_page(){
    add_menu_page('Autochat Whatsapp', 'Auy Whatsapp', 'manage_options', 'auy_whasapp', 'auytpw_whatsapp_menu_page', AUYTPW_DIR . 'assets/img/autocht_ic.png', 6); 
}
add_action( 'admin_menu', 'auytpw_register_menu_page' );

function auytpw_add_language(){
	load_plugin_textdomain('autochat-button-for-mobile-chat',FALSE, basename( dirname( __FILE__ ) ) . '/languages/');
}
add_action('plugins_loaded', 'auytpw_add_language');