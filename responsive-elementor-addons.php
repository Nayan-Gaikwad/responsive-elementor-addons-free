<?php
/**
 * Plugin Name: Responsive Elementor Addons
 * Description: Add more power to your Elementor Page Builder with the most comprehensive elements and extensions, such as Testimonial Carousel, Pricing Table, Countdown, Portfolio widget, etc under the one hood.
 * Plugin URI: https://cyberchimps.com/
 * Author: Cyberchimps.com
 * Version: 1.0.0
 * Author URI: https://cyberchimps.com/
 * Elementor tested up to: 3.5.5
 * Text Domain: responsive-elementor-addons
 *
 * @package responsive-elementor-addons
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	exit;
}

define( 'REA_VER', '1.0.0' );
define( 'REA_DIR', plugin_dir_path( __FILE__ ) );
define( 'REA_URL', plugins_url( '/', __FILE__ ) );
define( 'REA_PATH', plugin_basename( __FILE__ ) );
define( 'REA_ASSETS_URL', REA_URL . 'assets/' );
define( 'REA_PLUGIN_SHORT_NAME', 'REA' );

require_once REA_DIR . 'includes/class-responsive-elementor-addons.php';

/**
 * The code that runs during plugin activation.
 */
function activate_responsive_elementor_addons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-responsive-elementor-addons-activator.php';
	Responsive_Elementor_Addons_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_responsive_elementor_addons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-responsive-elementor-addons-deactivator.php';
	Responsive_Elementor_Addons_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_responsive_elementor_addons' );
register_deactivation_hook( __FILE__, 'deactivate_responsive_elementor_addons' );

/**
 * Load WC_AM_Client class if it exists.
 */
if ( ! class_exists( 'WC_AM_Client_2_7' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'wc-am-client.php';
}

/*
 * Instantiate WC_AM_Client class object if the WC_AM_Client class is loaded.
 */
global $wcam_lib_responsive_elementor_addons;
if ( class_exists( 'WC_AM_Client_2_7' ) ) {

	$wcam_lib_responsive_elementor_addons = new WC_AM_Client_2_7( __FILE__, '410822', '1.0.0', 'plugin', 'https://www.cyberchimps.com/', 'Responsive Elementor Addons', 'responsive-elementor-addons' );
}

/**
 * Load the Plugin Class.
 */
function responsive_elementor_addons_init() {
	Responsive_Elementor_Addons::instance();
}

responsive_elementor_addons_init();
