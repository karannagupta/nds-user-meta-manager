<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Nds_User_Meta_Manager
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/nds-user-meta-manager.php';
        
        // Update array with plugins to include ...
        $plugins_to_activate = array(
            dirname( dirname( __FILE__ ) ) . '/nds-user-meta-manager.php'            
        );
        update_option( 'active_plugins', $plugins_to_activate );
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
