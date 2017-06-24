<?php

/**
 * Class Nds_User_Meta_Manager_Nonce_Test
 *
 * @package Nds_User_Meta_Manager
 */

class Nonce_Test extends WP_UnitTestCase {    
    
    /**
    * @var $mock
    */
    private $mock; 
    
    /*
     * @var $plugin_name
     */
    private $nds_nonce;

    public function setUp() {
        parent::setUp();     

        $this->nds_nonce = new Nds_User_Meta_Manager\Admin\Utils\Nonce();        
    }
    
    public function tearDown() {
        //delete the mock
        unset($this->nds_nonce);
        
        parent::tearDown();
    }
           
             
    public function test_create_nonce() {  
        
       fwrite(STDOUT, "\n\t\t Testing Create Nonce ..");
       
       $our_nonce = $this->nds_nonce->create_nonce('nds-test-nonce');
       $wp_verify = wp_verify_nonce($our_nonce, 'nds-test-nonce');
       $this->assertEquals($wp_verify, 1);
    }     
    
    public function test_wp_check_admin_referer() {

        $our_nonce = $this->nds_nonce->create_nonce('nds-test-nonce');
        $_REQUEST['_referer'] = $our_nonce;

        $wp_verify = check_admin_referer( 'nds-test-nonce', '_referer' );
        $this->assertEquals($wp_verify, 1);        
    }   
    
}