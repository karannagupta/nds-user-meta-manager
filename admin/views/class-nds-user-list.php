<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class-nds-user-list
 *
 * @link       http://nuancedesignstudio.in
 * @since      1.0.0
 * 
 * @package    
 * @subpackage 
 * @author     Karan NA Gupta
 */

class Nds_User_List extends Nds_WP_List_Table {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 * @var      Nds_User_Meta_Manager_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

        // unique identifier of this plugin.
	protected $plugin_name;
        
        // current version of the plugin.
	protected $version; 
        
        /**
	 * Nds_User_Meta_Manager_Nonce object
	 *
	 * @since    1.0.0
	 * @access   private	 
	 */
      	
	private $nds_nonce;        
	
        // define the core functionality of the plugin.		 
	public function __construct() {

		$this->plugin_name = 'nds-user-meta-manager';
		$this->version = '1.0.0';
                
                //instantiate the nonce class
                $this->nds_nonce = new Nds_User_Meta_Manager_Nonce();
                
                parent::__construct(array(
                    'singular'  => __('nds-user', $this->plugin_name),
                    'plural'    => __('nds-users', $this->plugin_name),
                    'ajax'      => false
                ));
         }
         
        /**
         * Add extra markup in the toolbars before or after the list
         * 
         * @since    1.0.0
         * 
         * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
         */
        public function extra_tablenav( $which ) {
           if ( $which == "top" ){
              //code that goes before the table is here              
           }
           if ( $which == "bottom" ){
              //code that goes after the table is there              
           }
        }
        
        /**
         * Retrieve customer’s data from the database
         *
         * @since   1.0.0
         * 
         * @param int $per_page
         * @param int $page_number
         *
         * @return mixed
         */
        private static function get_users( $per_page = 15, $page_number = 1 ) {

            global $wpdb;

            $user_sql = "SELECT * FROM {$wpdb->prefix}users";

            if ( ! empty( $_REQUEST['orderby'] ) ) {
                $user_sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
                $user_sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
            }

            $user_sql .= " LIMIT $per_page";
            $user_sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

            
            $query_results = $wpdb->get_results( $user_sql, ARRAY_A  );  
            return $query_results;
        }              
        
        /**
         * Returns the count of records in the database.
         *
         * @since   1.0.0
         * 
         * @return null|string
         */
        private static function record_count() {
          global $wpdb;

          $user_sql = "SELECT COUNT(*) FROM {$wpdb->prefix}users";
          return $wpdb->get_var( $user_sql );
        }               
  
        /**
         * Define the columns that are going to be used in the table
         * 
         * @since 1.0.0
         * 
         * @return array $columns, the array of columns to use with the table
         */
        public function get_columns() {
           return $columns= array(              
              'ID'=>__('User Id'),
              'user_login'=>__('User Login'),              
              'user_nicename'=>__('Full Name'),              
              'user_registered'=>__('Registered On'),              
           );
        } 
        
        /**
         * Method for name column
         *
         * @param array $item an array of DB data
         *
         * @return string
         */
        public function column_user_login( $item ) {
          
          $view_meta_nonce = wp_create_nonce( 'nds_view_user_meta' );
          $add_meta_nonce = wp_create_nonce( 'nds_add_user_meta' );          
          $edit_meta_nonce = wp_create_nonce( 'nds_edit_user_meta' );
          $delete_meta_nonce = wp_create_nonce( 'nds_delete_user_meta' );
          
          $title = '<strong>' . $item['user_login'] . '</strong>';
          $actions = array(
            'view_user_meta' => sprintf( '<a href="?page=%s&action=%s&nds_user=%s&_wpnonce=%s">'. __('View Meta') . '</a>', esc_attr( $_REQUEST['page'] ), 'nds_view_user_meta', absint( $item['ID']), $view_meta_nonce ),
            'add_user_meta' => sprintf( '<a href="?page=%s&action=%s&nds_user=%s&_wpnonce=%s">'. __('Add Meta') . '</a>', esc_attr( $_REQUEST['page'] ), 'nds_add_user_meta', absint( $item['ID']), $add_meta_nonce ),            
            'delete_user_meta' => sprintf( '<a href="?page=%s&action=%s&nds_user=%s&_wpnonce=%s">'. __('Delete Meta') . '</a>', esc_attr( $_REQUEST['page'] ), 'nds_delete_user_meta', absint( $item['ID']), $delete_meta_nonce ),
          );

          return $title . $this->row_actions( $actions );
        }
        
        /**
         * Render a column when no column specific method exists.
         *
         * @param array $item
         * @param string $column_name
         *
         * @return mixed
         */
        public function column_default( $item, $column_name ) {
          switch ( $column_name ) {
            case 'ID':
            case 'user_nicename':            
            case 'user_registered':
              return stripslashes($item[$column_name]);
                break;
            default:
              return _e($item[user_nicename]);
          }
        }        
        
        /**
        * Decide which columns to activate the sorting functionality on
        * 
        * @since    1.0.0
        * 
        * @return array $sortable_columns, the array of columns that can be sorted by the user
        */
       public function get_sortable_columns() {
            $sortable_columns = array(
            'ID' => array( 'ID', true ),
            'user_login' => array( 'user_login', false ),
            'user_registered'=>'user_registered'    
          );
            
          return $sortable_columns;
       }
       
        /** 
         * Text displayed when no customer data is available 
         * 
         * @since   1.0.0
         * 
         * @return void
         */
        public function no_items() {
            _e( 'No users avaliable.', $this->plugin_name );
        }       
       
       /**
        * Returns an associative array containing the bulk action
        *
        * @since    1.0.0
        * 
        * @return array
        */
       public function get_bulk_actions() {
            $actions = [
              'bulk-print' => 'Print Meta (for future)'
            ];

            return $actions;
       }                                      

        /**
         * Prepare the table with different parameters, pagination, columns and table elements
         * 
         * @since   1.0.0
         */
        public function prepare_items() {
                              
            //process meta actions            
            $this->process_bulk_action();
            
            $per_page     = $this->get_items_per_page( 'users_per_page', 15 );
            $current_page = $this->get_pagenum();
            $total_items  = self::record_count();

            $this->set_pagination_args( [
              'total_items' => $total_items, //calculate the total number of items
              'per_page'    => $per_page //determine how many items to show on a page
            ] );
            
           $this->items = self::get_users( $per_page, $current_page );  
            
        }
        
       /**
        * Processes the actions triggered by the user
        *
        * @since    1.0.0
        * 
        * @return void
        */       
        public function process_bulk_action() {                                              
            if ( 'nds_view_user_meta' === $this->current_action() ) {                
                $nonce = esc_attr( $_REQUEST['_wpnonce'] );                            
                
                //verify the nonce                
                //if ( ! wp_verify_nonce( $nonce, 'nds_view_user_meta' ) ) {
                // using oop below instead of the statement above
                
                if (! $this->nds_nonce->wp_verify_nonce_field($nonce, $this->current_action()) ) {
                    wp_die(__( 'Invalid nonce specified', $this->plugin->name ), __( 'Error', $this->plugin->name ), array(
                        'response' 	=> 403,
                        'back_link' => 'admin.php?page=' . $this->plugin->name,

                        ));
                }
                else {
                    self::nds_view_user_meta( absint( $_GET['nds_user']), $this->plugin_name );
                    exit;
                }
            }   
            
            if ( 'nds_add_user_meta' === $this->current_action() ) { 
                $nonce = esc_attr( $_REQUEST['_wpnonce'] );
                //verify the nonce
                //if ( ! wp_verify_nonce( $nonce, 'nds_add_user_meta' ) ) {
                
                if (! $this->nds_nonce->wp_verify_nonce_field($nonce, $this->current_action()) ) {
                    wp_die(__( 'Invalid nonce specified', $this->plugin->name ), __( 'Error', $this->plugin->name ), array(
                        'response' 	=> 403,
                        'back_link' => 'admin.php?page=' . $this->plugin->name,

                        ));
                }
                else {                    
                    self::nds_add_user_meta( absint( $_GET['nds_user']), $this->plugin_name );                                        
                    exit;
                }                
            }
            
            if ( 'nds_delete_user_meta' === $this->current_action() ) { 
                $nonce = esc_attr( $_REQUEST['_wpnonce'] );
                //verify the nonce
                //if ( ! wp_verify_nonce( $nonce, 'nds_delete_user_meta' ) ) {
                
                if (! $this->nds_nonce->wp_verify_nonce_field($nonce, $this->current_action()) ) {
                    wp_die(__( 'Invalid nonce specified', $this->plugin->name ), __( 'Error', $this->plugin->name ), array(
                        'response' 	=> 403,
                        'back_link' => 'admin.php?page=' . $this->plugin->name,

                        ));
                }
                else {                    
                    self::nds_delete_user_meta( absint( $_GET['nds_user']), $this->plugin_name );                                        
                    exit;
                }                
            }            
        }        
        
        /**
         * View a user's meta information.
         *
         * @since   1.0.0
         * 
         * @param int $id customer ID
         * @param string $plugin_name
         */
        public static function nds_view_user_meta( $user_id, $plugin_name ) {            
            $user = get_user_by( 'id', $user_id );
            echo __('<h2> View Meta for ' . $user->user_login . '</h2>');           
            include_once( plugin_dir_path( dirname( __DIR__ ) ) .'admin/partials/nds-user-meta-manager-admin-meta-view-display.php' );
        }       
        
        /**
         * Add meta information to a user.
         *
         * @since   1.0.0
         * 
         * @param int $id customer ID  
         * @param string $plugin_name
         */
        public static function nds_add_user_meta( $user_id, $plugin_name ) {            
            $user = get_user_by( 'id', $user_id );
            echo __('<h2> Add Meta for ' . $user->user_login . '</h2>');                        
            include_once( plugin_dir_path( dirname( __DIR__ ) ) .'admin/partials/nds-user-meta-manager-admin-meta-add-display.php' );
        }               

        /**
         * Delete a user's meta information.
         *
         * @since   1.0.0
         * 
         * @param int $id customer ID
         * @param string $plugin_name
         */
        public static function nds_delete_user_meta( $user_id, $plugin_name ) {            
            $user = get_user_by( 'id', $user_id );
            echo __('<h2> Delete Meta for ' . $user->user_login . '</h2>');                        
            include_once( plugin_dir_path( dirname( __DIR__ ) ) .'admin/partials/nds-user-meta-manager-admin-meta-delete-display.php' );
        }               
}
