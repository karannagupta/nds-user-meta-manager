<?php

namespace Nds_User_Meta_Manager\Inc\Core;
use Nds_User_Meta_Manager as NS;
use Nds_User_Meta_Manager\Inc\Admin as Admin;
use Nds_User_Meta_Manager\Inc\Frontend as Frontend;

/**
 * The core plugin class.
 * Defines internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * @link       http://nuancedesignstudio.in
 * @since      1.0.0
 * 
 * @author     Karan NA Gupta
 */
class Init {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 * @var      Nds_User_Meta_Manager_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
        
	
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The string used to uniquely identify this plugin.
	 */
	protected $plugin_slug;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;      
	
	/**
	 * The text domain of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $plugin_text_domain;	
	
    // define the core functionality of the plugin.		 
	public function __construct() {

		$this->plugin_name = NS\PLUGIN_NAME;
		$this->version = NS\PLUGIN_VERSION;
				$this->plugin_basename = NS\PLUGIN_BASENAME;
				$this->plugin_text_domain = NS\PLUGIN_TEXT_DOMAIN;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the following required dependencies for this plugin.
	 *
	 * - Nds_User_Meta_Manager_Loader. Orchestrates the hooks of the plugin.
	 * - Nds_User_Meta_Manager_i18n. Defines internationalization functionality.
	 * - Nds_User_Meta_Manager_Admin. Defines all hooks for the admin area.
	 * - Nds_User_Meta_Manager_Public. Defines all hooks for the public side of the site.	 
         * 
         * @access    private
	 */
	private function load_dependencies() {
		$this->loader = new Loader();
                
	}

	/**
	 * Define the locale for this plugin for internationalization.	 
         * 
	 * Uses the Nds_User_Meta_Manager_i18n class in order to set the domain and to register the hook
	 * with WordPress.	 
         * 
         * @access    private
	 */
	private function set_locale() {

		$plugin_i18n = new Internationalization_i18n( $this->plugin_text_domain );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
         * 
         * @access    private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin\Admin( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );     
		$this->loader->add_action('admin_menu', $plugin_admin, 'nds_add_plugin_admin_menu');                
                
		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'nds_add_action_links' );               


		// Register admin notices
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'nds_print_admin_notice');

		/*
		 *  Form actions registered using admin-post.php 
		 */               
		//generated by partials/nds-user-meta-manager-add-meta-display
		$this->loader->add_action( 'admin_post_nds_add_user_meta_form_response', $plugin_admin, 'nds_add_user_meta_form_response');

		//generated by partials/nds-user-meta-manager-delete-meta-display
		$this->loader->add_action( 'admin_post_nds_delete_user_meta_form_response', $plugin_admin, 'nds_delete_user_meta_form_response');
                                
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
         * 
         * @access    private
	 */
	private function define_public_hooks() {

		$plugin_public = new Frontend\Frontend( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 * @return    Nds_User_Meta_Manager_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	
	/**
	 * Retrieve the text domain of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The text domain of the plugin.
	 */
	public function get_plugin_text_domain() {
		return $this->plugin_text_domain;
	}		

}
