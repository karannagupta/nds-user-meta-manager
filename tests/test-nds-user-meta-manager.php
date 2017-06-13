<?php

/**
 * Class Nds_User_Meta_Manager_Test
 *
 * @package Nds_User_Meta_Manager
 */

class Nds_User_Meta_Manager_Test extends WP_UnitTestCase {
    protected $object;
    
    public function setUp() {
        parent::setUp();
        $this->object = new Nds_User_Meta_Manager();

    }
    
    public function tearDown() {
        parent::tearDown();
    }
    
    public function test_load_dependencies() {
        $plugin_directory = plugin_dir_path( dirname( __FILE__ ) );
        fwrite(STDOUT, "Checking Plugin Integrity ... \n");
                
        #admin
        $this->assertFileExists($plugin_directory.'admin/class-nds-user-meta-manager-admin.php');
                
        #admin/css
        $this->assertFileExists($plugin_directory.'admin/css/nds-user-meta-manager-admin.css');
        
        #admin/js
        $this->assertFileExists($plugin_directory.'admin/js/nds-user-meta-manager-admin.js');
        
        #admin/partials
        $this->assertFileExists($plugin_directory.'admin/partials/nds-user-meta-manager-admin-display.php');
        $this->assertFileExists($plugin_directory.'admin/partials/nds-user-meta-manager-admin-meta-add-display.php');
        $this->assertFileExists($plugin_directory.'admin/partials/nds-user-meta-manager-admin-meta-delete-display.php');
        $this->assertFileExists($plugin_directory.'admin/partials/nds-user-meta-manager-admin-meta-view-display.php');
        
        #admin/views
        $this->assertFileExists($plugin_directory.'admin/views/class-nds-user-list.php');
        $this->assertFileExists($plugin_directory.'admin/views/class-nds-wp-list-table.php');
        
        #includes
        $this->assertFileExists($plugin_directory.'includes/class-nds-user-meta-manager.php');
        $this->assertFileExists($plugin_directory.'includes/class-nds-user-meta-manager-deactivator.php');
        $this->assertFileExists($plugin_directory.'includes/class-nds-user-meta-manager-activator.php');
        $this->assertFileExists($plugin_directory.'includes/class-nds-user-meta-manager-loader.php');
        $this->assertFileExists($plugin_directory.'includes/class-nds-user-meta-manager-i18n.php');
        

        
    }
}