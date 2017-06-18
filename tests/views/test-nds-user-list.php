<?php

/**
 * Class Nds_User_List_Test
 *
 * @package Nds_User_Meta_Manager
 */

class Nds_User_List_Test extends WP_UnitTestCase {    
    
    /**
    * @var $mock
    */
    private $mock; 
    
    public function setUp() {
        parent::setUp();           
                
        //Create the mock   
        
        $this->mock = $this->getMockBuilder('Nds_User_List')   
                            ->disableOriginalConstructor()
                            ->setMethods(array('graceful_exit'))
                            ->getMock();
          
    }
    
    public function tearDown() {
        //delete the mock
        unset($this->mock);
        
        parent::tearDown();
    }
              
                   
    public function test_record_count() {  
        fwrite(STDOUT, "\n\t\t Testing User List ..");
        
        //create 10 users
        $this->factory->user->create_many(10);
        $total_users = $this->mock->record_count();
                
        //admin + 10 users
        $this->assertEquals(11, $total_users);
    }     
    
    
    public function test_get_users() {
        fwrite(STDOUT, "\n\t\t Testing User List Pagination ..");
        //create 7 users
        $this->factory->user->create_many(7);
        
        /*
         * default pagination - 15 users/page
         * 
         * admin + 7 users
         */
        $users_on_page = sizeof($this->mock->get_users(), 0);
        $this->assertEquals(8, $users_on_page);
        
        /*
         * set pagination to a max of 5 users/page.         
         */         
        
        //get users on the first page
        $users_on_page = sizeof($this->mock->get_users(5,1), 0);
        $this->assertNotEquals(8, $users_on_page);
        $this->assertEquals(5, $users_on_page);
        
        //get users on the second page  
        $users_on_page = sizeof($this->mock->get_users(5,2), 0);
        $this->assertNotEquals(8, $users_on_page);
        $this->assertNotEquals(5, $users_on_page);
        $this->assertEquals(3, $users_on_page);
        
    }       
}