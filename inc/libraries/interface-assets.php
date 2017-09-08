<?php

namespace Nds_User_Meta_Manager\Inc\Libraries;

/**
 * The common functionality of the plugin.
 * 
 * Defines a common set of functions that any class responsible for loading
 * stylesheets, JavaScript, or other assets should implement.
 *
 * @link       http://nuancedesignstudio.in
 * @since      1.1.0
 *
 * @author     Karan NA Gupta
 */

interface Assets_Interface {
    
    /**
     * Register stylesheets
     *
     * @since    1.1.0
     */    
    public function enqueue_styles();
    
    /**
     * Register scripts
     *
     * @since    1.1.0
     */       
    public function enqueue_scripts();

}