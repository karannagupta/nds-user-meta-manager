<?php

/**
 * Class Admin_Test
 *
 */

class Admin_Test extends WP_UnitTestCase {    
    
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
        $this->mock = $this->getMockBuilder('Nds_User_Meta_Manager\Admin\Admin')                              
                            ->setConstructorArgs(array('nds-user-meta-manager', '1.0.0'))                                                       
                            ->setMethods(array('nds_redirect'))
                            ->getMock();
        
    }
    
    public function tearDown() {
        //delete the mock
        unset($this->mock);
        
        parent::tearDown();
    }
           
        
    /*
     * Test that without the nonce and $REQUEST params wp_die is invoked
     */         
    public function test_nds_add_user_meta_form_response_with_incomplete_form() {  
        
       fwrite(STDOUT, "\n\t\t Testing exceptions for invalid (Add Meta) form parameters ..");
       
       /*
        * $REQUEST does not have the required params at this point.
        * 
        * This will lead to an exception with wp_die
        */
       
       $this->setExpectedException( 'WPDieException', 'Invalid nonce specified' );        
       $this->mock->nds_add_user_meta_form_response();
       
    }     
    
    /*
     * Test nds_add_user_meta_form_response which is the callback after the add meta form has been submitted
     */
    public function test_nds_add_user_meta_form_response_with_complete_form() {
        fwrite(STDOUT, "\n\t\t Testing callback for form to Add User Meta ..");                
        wp_set_current_user(1);

        /*
         * Test the method with the required nonce and other params set in $_REQUEST
         */
        $factory_user_id = $this->factory->user->create();
        $the_user_meta_before = get_user_meta($factory_user_id);
        
        //create the form post response params
        $_REQUEST['nds_add_user_meta_nonce'] = wp_create_nonce('nds_add_user_meta_form_nonce');  
        $_REQUEST['nds']['user_meta_key'] = 'fav_os';
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
        
        $the_added_user_meta = get_user_meta($factory_user_id, 'fav_os', true );
        $this->assertEquals('linux', $the_added_user_meta);        
            
    }
    
    /*
     * Test that without the nonce and $REQUEST params wp_die is invoked
     */         
    public function test_nds_delete_user_meta_form_response_with_incomplete_form() {  
        
       fwrite(STDOUT, "\n\t\t Testing exceptions for invalid (Delete Meta) form parameters ..");
       
       /*
        * $REQUEST does not have the required params at this point.
        * 
        * This will lead to an exception with wp_die
        */
       $this->setExpectedException( 'WPDieException', 'Invalid nonce specified' );        
       $this->mock->nds_delete_user_meta_form_response();
       
    }       
    
    /*
     * Test nds_delete_user_meta_form_response which is the callback after the delete meta form has been submitted
     */
    public function test_nds_delete_user_meta_form_response_with_complete_form() {
        fwrite(STDOUT, "\n\t\t Testing callback for form to Delete User Meta ..");                
        wp_set_current_user(1);

        /*
         * Test the method with the required nonce and other params set in $_REQUEST
         */        
        $factory_user_id = $this->factory->user->create();
        $the_user_meta_before = get_user_meta($factory_user_id);
        
        //add some meta to the user to delete later
        add_user_meta($factory_user_id, 'fav_cms', 'wordpress', false);
                
        $the_user_meta_after = get_user_meta($factory_user_id);
        $the_added_user_meta = get_user_meta($factory_user_id, 'fav_cms', true );
        
        //verify the addition
        $this->assertEquals('wordpress', $the_added_user_meta);
        
        //create the form post response params
        $_REQUEST['nds_delete_user_meta_nonce'] = wp_create_nonce('nds_delete_user_meta_form_nonce');  
        $_REQUEST['nds_delete_user_meta_key'] = 'fav_cms';        
        $_REQUEST['nds_user'] = $factory_user_id;
                
        //nds_redirect redirects to the admin page. Let's believe it did
        $this->mock->expects($this->any())
                    ->method('nds_redirect')
                    ->will($this->returnValue(true));
                        
        //call the method that deletes the user_meta       
        $this->mock->nds_delete_user_meta_form_response();
        $the_user_meta_after = get_user_meta($factory_user_id);
        
        $the_added_user_meta = get_user_meta($factory_user_id, 'fav_cms', true );
        $this->assertEmpty($the_added_user_meta);
        $this->assertEquals( sizeof($the_user_meta_before), sizeof($the_user_meta_after) );
    }    
    
    
}