<?php

/**
 * Class Nds_User_Meta_Manager_Test
 *
 * @package Nds_User_Meta_Manager
 */

class Nds_User_Meta_Manager_Test extends WP_UnitTestCase {    
    public function setUp() {
        parent::setUp();        
    }
        
    public function tearDown() {
        parent::tearDown();
    }
    
    public function test_load_dependencies() {
        fwrite(STDOUT, "\n\t\t Testing Plugin Integrity ..");
        $plugin_directory = plugin_dir_path( dirname( __FILE__ ) );        
                
        //admin
        $this->assertFileExists($plugin_directory.'admin/class-admin.php');
        $this->assertFileExists($plugin_directory.'admin/class-user-list-table.php');
        
        //admin/css
        $this->assertFileExists($plugin_directory.'admin/css/nds-user-meta-manager-admin.css');
        
        //admin/js
        $this->assertFileExists($plugin_directory.'admin/js/nds-user-meta-manager-admin.js');
        
        //admin/partials
        $this->assertFileExists($plugin_directory.'admin/partials/nds-user-meta-manager-admin-display.php');
        $this->assertFileExists($plugin_directory.'admin/partials/nds-user-meta-manager-admin-meta-add-display.php');
        $this->assertFileExists($plugin_directory.'admin/partials/nds-user-meta-manager-admin-meta-delete-display.php');
        $this->assertFileExists($plugin_directory.'admin/partials/nds-user-meta-manager-admin-meta-view-display.php');
        
        //lib        
        $this->assertFileExists($plugin_directory.'lib/class-wp-list-table.php');
        $this->assertFileExists($plugin_directory.'lib/class-nonce.php');
        
        //includes
        $this->assertFileExists($plugin_directory.'includes/class-init.php');
        $this->assertFileExists($plugin_directory.'includes/class-deactivator.php');
        $this->assertFileExists($plugin_directory.'includes/class-activator.php');
        $this->assertFileExists($plugin_directory.'includes/class-loader.php');
        $this->assertFileExists($plugin_directory.'includes/class-internationalization-i18n.php');
                
        $this->assertTrue( is_plugin_active( $plugin_directory . 'nds-user-meta-manager.php'));
               
    }   
    
    public function test_define_admin_hooks() {  
        
        //dummy action
        $this->assertFalse( has_action( 'nds_add_user_meta_form_response' ) );
        
        //actions for form responses
        $this->assertTrue( has_action( 'admin_post_nds_add_user_meta_form_response' ) );
        $this->assertTrue( has_action( 'admin_post_nds_delete_user_meta_form_response' ) );
                
    }
           
        
}