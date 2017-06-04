<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://nuancedesignstudio.in
 * @since      1.0.0
 *
 * @package    Nds_User_Meta_Manager
 * @subpackage Nds_User_Meta_Manager/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Nds_User_Meta_Manager
 * @subpackage Nds_User_Meta_Manager/includes
 * @author     Karan NA Gupta
 */
class Nds_User_Meta_Manager_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'nds-user-meta-manager',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
