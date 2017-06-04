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
 * Version:           1.0.0
 * Author:            Karan NA Gupta
 * Author URI:        http://nuancedesignstudio.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nds-user-meta-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nds-user-meta-manager-activator.php
 */
function activate_nds_user_meta_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nds-user-meta-manager-activator.php';
	Nds_User_Meta_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nds-user-meta-manager-deactivator.php
 */
function deactivate_nds_user_meta_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nds-user-meta-manager-deactivator.php';
	Nds_User_Meta_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nds_user_meta_manager' );
register_deactivation_hook( __FILE__, 'deactivate_nds_user_meta_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nds-user-meta-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nds_user_meta_manager() {

	$plugin = new Nds_User_Meta_Manager();
	$plugin->run();

}
run_nds_user_meta_manager();
