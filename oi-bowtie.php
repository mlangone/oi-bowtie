<?php
/*
	Plugin Name: OI Bowtie
	Description: This is for updating your Wordpress plugin.
	Version: 1.0.3
	Author: Langone Saul
	Author URI: http://www.onlineimage.com
 	License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	Text Domain:       oi-bowtie
	Domain Path:       /languages	
*/

if( ! class_exists( 'Bowtie_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
}

$updater = new Bowtie_Updater( __FILE__ );
$updater->set_username( 'mlangone' );
$updater->set_repository( 'oi-bowtie' );
/*
	$updater->authorize( 'abcdefghijk1234567890' ); // Your auth code goes here for private repos
*/
$updater->initialize();

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-oi-bowtie-activator.php
 */
function activate_oi_bowtie() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-oi-bowtie-activator.php';
	Oi_Bowtie_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-oi-bowtie-deactivator.php
 */
function deactivate_oi_bowtie() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-oi-bowtie-deactivator.php';
	Oi_Bowtie_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_oi_bowtie' );
register_deactivation_hook( __FILE__, 'deactivate_oi_bowtie' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-oi-bowtie.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_oi_bowtie() {

	$plugin = new Oi_Bowtie();
	$plugin->run();

}
run_oi_bowtie();
