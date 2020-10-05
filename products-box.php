<?php

/**
 * Plugin Name: CQ Products Box
 * Plugin URI: https://kelassor.blog.ir/wp-plugins
 * Description: ⪜ CQFlooring Products Box :  use [cq-show-card slug=cat1,cat2,cat3] in post or page
 * Version: 1
 * Text Domain: CQ-products-box
 * Author: Masood Vahid
 * Author URI: https://kelassor.blog.ir
 * Requires at least: 5.0
 * Requires PHP:      7.2
 * WC requires at least: 4.5
 * WC tested up to: 5.0
 * GitHub Plugin URI: masoodvahid/cq-products-box
 * GitHub Plugin URI: https://github.com/masoodvahid/cq-products-box
 */

if (!defined('WPINC')) {
	die;
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	define('PRODUCTS_INLINE_DIR', plugin_dir_path(__FILE__));
	define('PRODUCTS_INLINE_VERSION', '0.1');

	require_once(PRODUCTS_INLINE_DIR . 'inc/class-products-box.php');

	function load_styles(){
		wp_enqueue_style( 'style', plugins_url( 'assets/css/style.css' , __FILE__ ) );
	}
	add_action('wp_enqueue_scripts','load_styles');	
}else{
	function general_admin_notice(){
		global $pagenow;
		if ( $pagenow == 'plugins.php' ) {
			 echo '<div class="notice notice-warning is-dismissible">
				 <p>⚠ CQFlooring Products Box is active but not effective. we needs Woocommerce to work like a charm ;). </p>
			 </div>';
		}
	}
	add_action('admin_notices', 'general_admin_notice');	
}
