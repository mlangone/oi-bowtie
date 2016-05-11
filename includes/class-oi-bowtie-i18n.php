<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://onlineimage.com
 * @since      1.0.0
 *
 * @package    Oi_Bowtie
 * @subpackage Oi_Bowtie/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Oi_Bowtie
 * @subpackage Oi_Bowtie/includes
 * @author     Langone-Saul <langone@onlineimage.com>
 */
class Oi_Bowtie_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'oi-bowtie',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
