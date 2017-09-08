<?php

/**
 *
 * @link              http://nuancedesignstudio.in
 * @since             1.0.0
 * @package           Nds_User_Meta_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       NDS User Meta Manager
 * Plugin URI:        
 * Description:       A simple plugin to manager user meta. Typically these would require tinkering with the $table_prefix_usermeta table.
 * Version:           1.1.0
 * Author:            Karan NA Gupta
 * Author URI:        http://nuancedesignstudio.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nds-user-meta-manager
 * Domain Path:       /languages
 */

namespace Nds_User_Meta_Manager;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Constants
 */

define( 'PLUGIN_NAME_DIR', plugin_dir_path( __FILE__ ) );

define( 'PLUGIN_NAME_URL', plugin_dir_url( __FILE__ ) );

define( 'PLUGIN_NAME_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Autoload Classes
 */

require_once( PLUGIN_NAME_DIR . 'inc/libraries/autoload.php');

/**
 * Register Activation and Deactivation Hooks
 *
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */

register_activation_hook( __FILE__, array('Nds_User_Meta_Manager\Inc\Core\Activator', 'activate') );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in lib/class-deactivator.php
 */

register_deactivation_hook( __FILE__, array('Nds_User_Meta_Manager\Inc\Core\Deactivator', 'deactivate') );


/**
 * Plugin Singleton Container
 *
 * Maintains a single copy of the plugin app object
 *
 * @since    1.0.0
 */
class Nds_User_Meta_Manager {

        static $init;
    	/**
	 * Loads the plugin
         * 
         * @access    public
	 */

	public static function init() {

		if ( null == self::$init ) {
			self::$init = new Inc\Core\init();
			self::$init->run();
		}

		return self::$init;
	}    
    
}

/*
 * Begins execution of the plugin
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Also returns copy of the app object so 3rd party developers
 * can interact with the plugin's hooks contained within.
 *
 */

function nds_user_meta_manager() {
        return Nds_User_Meta_Manager::init();
}

$min_php = '5.3.0';

// Check the minimum required PHP version and run the plugin.
if ( version_compare( PHP_VERSION, $min_php, '>=' ) ) {
		nds_user_meta_manager();
}
