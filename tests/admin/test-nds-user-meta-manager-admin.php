<?php

/**
 * Class Nds_User_Meta_Manager_Test
 *
 * @package Nds_User_Meta_Manager
 */

class Nds_User_Meta_Manager_Admin_Test extends WP_UnitTestCase {    
    
    /**
    * @var $mock
    */
    private $mock; 

    public function setUp() {
        parent::setUp();   
                
        //Create the mock        
        $this->mock = $this->getMockBuilder('Nds_User_Meta_Manager_Admin')  
                            ->setConstructorArgs(array('nds-user-meta-manager', '1.0.0'))
                            ->disableOriginalConstructor()
                            ->setMethods(null)
                            ->getMock();
        
    }
    
    public function tearDown() {
        parent::tearDown();
    }
           
    public function test_nds_add_user_meta_form_response() {  
        
       /*
        * Test that without the nonce and $REQUEST params wp_die is invoked
        */        
        $this->setExpectedException( 'WPDieException', 'Invalid nonce specified' );        
        $this->mock->nds_add_user_meta_form_response();        
               
    }     
    
}