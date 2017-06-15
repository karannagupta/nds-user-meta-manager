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
    
    /*
     * @var $plugin_name
     */
    private $plugin_name;

    public function setUp() {
        parent::setUp();   
                
        //Create the mock        
        $this->mock = $this->getMockBuilder('Nds_User_Meta_Manager_Admin')                              
                            ->setConstructorArgs(array('nds-user-meta-manager', '1.0.0'))                                                       
                            ->setMethods(array('nds_redirect'))
                            ->getMock();
        
    }
    
    public function tearDown() {
        unset($this->mock);
        parent::tearDown();
    }
        
    /*
     * Test that without the nonce and $REQUEST params wp_die is invoked
     */         
    public function test_nds_add_user_meta_form_response_with_incomplete_form() {  
        
       fwrite(STDOUT, "\n\t\t Testing exceptions for invalid form parameters ...");
       
       //$REQUEST does not have the required params at this point.
       $this->setExpectedException( 'WPDieException', 'Invalid nonce specified' );        
       $this->mock->nds_add_user_meta_form_response();
       
    }     
    
    /*
     * Test nds_add_user_meta_form_response which is the callback after the add meta form has been submitted
     */
    public function test_nds_add_user_meta_form_response_with_complete_form() {
        fwrite(STDOUT, "\n\t\t Testing callback for form to Add User Meta ...");
        
        $this->plugin_name = 'nds-user-meta-manager';
        wp_set_current_user(1);

        //Test with the nonce and other params set
        $factory_user_id = $this->factory->user->create();
        $the_user_meta_before = get_user_meta($factory_user_id);
        
        //create the form post response params
        $_REQUEST['nds_add_user_meta_nonce'] = wp_create_nonce('nds_add_user_meta_form_nonce');  
        $_REQUEST['nds']['user_meta_key'] = 'os';
        $_REQUEST['nds']['user_meta_value'] = 'linux';
        $_REQUEST['nds_user'] = $factory_user_id;
                
        //nds_redirect redirects to the admin page. Let's believe it did
        $this->mock->expects($this->any())
                    ->method('nds_redirect')
                    ->will($this->returnValue(true));
        
        //call the method that adds the user_meta
        $this->mock->nds_add_user_meta_form_response();
        
        $the_user_meta_after = get_user_meta($factory_user_id);
        $this->assertGreaterThan( sizeof($the_user_meta_before), sizeof($the_user_meta_after) );
        
        $the_added_user_meta = get_user_meta($factory_user_id, 'os', true );
        $this->assertEquals('linux', $the_added_user_meta);        
            
    }
    
}