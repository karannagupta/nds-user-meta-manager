<?php

namespace Nds_User_Meta_Manager\Inc\Admin;
use Nds_User_Meta_Manager\Inc\Libraries;

/**
 * The admin-specific functionality of the plugin.
 * 
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       http://nuancedesignstudio.in
 * @since      1.0.0
 *
 * @author     Karan NA Gupta
 */

/**
 * An instance of this class should be passed to the run() function
 * defined in Nds_User_Meta_Manager_Loader as all of the hooks are defined
 * in that particular class.
 *
 * The Nds_User_Meta_Manager_Loader will then create the relationship
 * between the defined hooks and the functions defined in this
 * class.
 */

class Admin implements Libraries\Assets_Interface{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
        
        /**
	 * WP_List_Table object
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
      	
	private $user_list_obj;
        
        /**
	 * Nds_User_Meta_Manager_Nonce object
	 *
	 * @since    1.0.0
	 * @access   private	 
	 */
      	
	private $nds_nonce;  
        

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;               
                
                //instantiate the nonce class
                $this->nds_nonce = new Libraries\Nonce();                                
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nds-user-meta-manager-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0         
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nds-user-meta-manager-admin.js', array( 'jquery' ), $this->version, false );
	}
        
        
        /**
        * Add settings action link to the plugins page.
        *
        * https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        *  
        * @since    1.0.0
        */

       public function nds_add_action_links( $links ) {
           
                $settings_link = array(
                    '<a href="' . admin_url( 'users.php?page=' . $this->plugin_name ) . '">' . __('Manage', $this->plugin_name) . '</a>',
                    '<a href="http://nuancedesignstudio.in" target="_blank">Author Link</a>',
                );
                return array_merge(  $settings_link, $links );

       }        
        
        /**
         * Register the admin menu for the plugin in the WordPress dashboard
         * 
         * @since    1.0.0
         */
        
        public function nds_add_plugin_admin_menu() {                           
                            
            	// Add a sub-menu under Users and save the returned hook suffix for callbacks when the menu page is loaded.		
                $nds_hook_suffix = add_users_page( __('NDS User Meta Manager', $this->plugin_name ), //page_title
                                                __('NDS User Meta Manager', $this->plugin_name ), //menu_title
                                                'manage_options', //capability
                                                $this->plugin_name, //menu_slug
                                                array($this, 'nds_plugin_admin_page_view') //callback to load page contents
                                                );

                /*
                 * $page_hook_suffix it can be combined with the load-($page_hook_suffix) action hook
                 *
                 * https://codex.wordpress.org/Plugin_API/Action_Reference/load-(page) 
                 * 
                 * The callback below will be called when the plugin page is loaded
                 */                
                add_action( 'load-'.$nds_hook_suffix, [ $this, 'nds_screen_options' ] );
        }
        
        /**
        * Screen options
        *
        * Callback for the load-($page_hook_suffix)
        * Called when the plugin page is loaded
        * 
        * @since    1.0.0
        */
        public function nds_screen_options() {

                $option = 'per_page';
                $args   = [
                        'label'   => __('Users Per Page', $this->plugin_name),
                        'default' => 15,
                        'option'  => 'users_per_page'
                ];

                add_screen_option( $option, $args );
                
                //instantiate the NDS_User_List
                $this->user_list_obj = new User_List_Table($this->plugin_name, $this->version);
        }       
        
        /**
         * Callback for the add_users_page from function nds_add_plugin_admin_menu
         * 
         * @since    1.0.0
         */
        public function nds_plugin_admin_page_view() {
                 include_once( 'partials/nds-user-meta-manager-admin-display.php' );
        }
        
        /**
         * Callback for the admin_post_nds_add_user_meta_form_response from partials/nds-user-meta-manager-admin-meta-add-display
         * 
         * @since    1.0.0
         */
        public function nds_add_user_meta_form_response() {
                $admin_notice = "no_change";
                /*
                 * Test using our oop based nonce 
                 * 
                 * if(isset($_REQUEST['nds_add_user_meta_nonce']) && wp_verify_nonce($_REQUEST['nds_add_user_meta_nonce'], 'nds_add_user_meta_form_nonce'))
                 */
            
                if(isset($_REQUEST['nds_add_user_meta_nonce']) && $this->nds_nonce->wp_verify_nonce_field($_REQUEST['nds_add_user_meta_nonce'], 'nds_add_user_meta_form_nonce')) {
                    if(isset($_REQUEST['nds']['user_meta_key']) && isset($_REQUEST['nds']['user_meta_value'])  ) {                        
                        $nds_user_meta_key = sanitize_key($_REQUEST['nds']['user_meta_key']);
                        $nds_user_meta_value = sanitize_text_field($_REQUEST['nds']['user_meta_value']);
                        $nds_user_id = absint($_REQUEST['nds_user']);
                        add_user_meta($nds_user_id, $nds_user_meta_key, $nds_user_meta_value, false);
                        
                        $admin_notice = "meta_added";                        
                        $this->nds_redirect($admin_notice);
                    }                           
                }
                else {
                    wp_die(__( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
                                'response' 	=> 403,
                                'back_link' => 'admin.php?page=' . $this->plugin_name,

                        ) );
                }
        }
        
        /**
         * Callback for the nds_delete_user_meta_form_response from partials/nds-user-meta-manager-admin-meta-delete-display
         * 
         * @since    1.0.0
         */
        public function nds_delete_user_meta_form_response() {                
                $admin_notice = "no_change";
                
                /*
                 * Test using our oop based nonce 
                 * 
                 * if(isset($_REQUEST['nds_delete_user_meta_nonce']) && wp_verify_nonce($_REQUEST['nds_delete_user_meta_nonce'], 'nds_delete_user_meta_form_nonce'))
                 * 
                 */

                if(isset($_REQUEST['nds_delete_user_meta_nonce']) && $this->nds_nonce->wp_verify_nonce_field($_REQUEST['nds_delete_user_meta_nonce'], 'nds_delete_user_meta_form_nonce')) {
                    if(isset($_REQUEST['nds_delete_user_meta_key']) && !empty($_REQUEST['nds_delete_user_meta_key']) ) {                               
                        
                        $nds_delete_user_meta_key = sanitize_text_field($_REQUEST['nds_delete_user_meta_key']);                       
                        $nds_user_id = absint($_REQUEST['nds_user']);
                        
                        $exists =  get_user_meta($nds_user_id, $nds_delete_user_meta_key, true);
                        if(! empty($exists)) {
                            delete_user_meta($nds_user_id, $nds_delete_user_meta_key);
                            $admin_notice = "meta_deleted";
                        }                                                
                    }
                    
                    $this->nds_redirect($admin_notice);                    
                    
                }
                else {
                    wp_die(__( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
                                'response' 	=> 403,
                                'back_link' => 'admin.php?page=' . $this->plugin_name,

                        ) );
                }
        }       
        
        /**
         * Redirect
         * 
         * @since    1.0.0
         */
        public function nds_redirect($admin_notice) {
            wp_redirect( esc_url_raw( add_query_arg( 'nds_admin_add_notice', $admin_notice, admin_url('admin.php?page='. $this->plugin_name) ) ) );
        }
        
        
        /**
         * Print Admin Notices
         * 
         * @since    1.0.0
         */
        public function nds_print_admin_notice() {              
              if ( isset( $_REQUEST['nds_admin_add_notice'] ) ) {
                if( $_REQUEST['nds_admin_add_notice'] === "meta_added") {                    
                    echo '<div class="notice notice-success is-dismissible"> 
                            <p><strong>User Meta Saved.</strong></p>
                        </div>';
                }
                
                if( $_REQUEST['nds_admin_add_notice'] === "meta_deleted") {                    
                    echo '<div class="notice notice-success is-dismissible"> 
                            <p><strong>User Meta Deleted.</strong></p>
                        </div>';
                }
                
                if( $_REQUEST['nds_admin_add_notice'] === "no_change") {                    
                    echo '<div class="notice notice-success is-dismissible"> 
                            <p><strong>Please try again</strong></p>
                        </div>';
                }                
                
              }
              else {
                  return;
              }
              
        }
        

}
