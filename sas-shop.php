<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://disenialia.com
 * @since             1.0.0
 * @package           Sas_Shop
 *
 * @wordpress-plugin
 * Plugin Name:       SAS Shop
 * Plugin URI:        http://ulisesfreitas.com/sas-shop
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            UlisesFreitas
 * Author URI:        https://disenialia.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sas-shop
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('SAS_SHOP_VERSION', '1.0.0');
define('SAS_SHOP_NAME', 'sas-shop');

ini_set('log_errors',TRUE);
ini_set('error_reporting', E_ALL);
ini_set('error_log', plugin_dir_path( __FILE__ ) . '/error_log.txt');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sas-shop-activator.php
 */
function activate_sas_shop() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sas-shop-activator.php';
	Sas_Shop_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sas-shop-deactivator.php
 */
function deactivate_sas_shop() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sas-shop-deactivator.php';
	Sas_Shop_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sas_shop' );
register_deactivation_hook( __FILE__, 'deactivate_sas_shop' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sas-shop.php';


require plugin_dir_path( __FILE__ ) . 'includes/class-sas-shop-install.php'; // Install plugin

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sas_shop() {

	$plugin_name = SAS_SHOP_NAME;
	$version = SAS_SHOP_VERSION;

	$plugin = new Sas_Shop( $version, $plugin_name);
	$plugin->run();

}
run_sas_shop();
