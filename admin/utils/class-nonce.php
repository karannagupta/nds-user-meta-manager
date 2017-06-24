<?php

namespace Nds_User_Meta_Manager\Admin\Utils;

/**
 * Adding Nonce functionality using OOP.
 *
 * @link       http://nuancedesignstudio.in
 * @since      1.0.0
 *
 * @author     Karan NA Gupta
 */

class Nonce {

        /**
        *Add nonce to URL actions
        *
        *@param string $action :: this is the name to be assigned to your nonce
        *@param string $URL :: this is the URL you wish to add the nonce to
        *@return string in a form of the nonce token
        */

        public static function get_wp_nonce_url($URL, $action) {
                return wp_nonce_url($URL, $action);
        }


        /**
        *Create a nonce
        *@param $action :: this is a required string indicating the name of the nonce
        *@return this function return's a nonce token string
        */      

        public static function create_nonce($action=-1) {
                return wp_create_nonce($action);
        }

	
        /**
        *Add nonce to a FORM
        *@param $action :: this is an optional string which represents the action name
        *@param $name   :: this is an optional string which represents the name of the nonce.
        *@param $referer:: this is an optional boolean used to determine whether the referer hidden form field should be created
        *@param $echo   :: this is an optional boolean to determine whether Wordpress should echo the nonce hidden field
        *@return string is a nonce hidden form field, optionally followed by the referer hidden form field if the $referer argument is set to true.
        */

        public static function get_wp_nonce_field($action=-1, $name='_wpnonce', $referer=true, $echo=true) {
                return wp_nonce_field($action, $name, $referer, $echo);
        }


        /**
        *Verifying nonces
        *@param $nonce :: this is a required field which indicates the Nonce to verify
        *@param $action:: this is an optional field which indicates the action specified when nonce was created
        *@return       :: this function will return boolean 'false' for an invalid nonce or
        *return '1' if nonce <= 12hours or
        *return '2' if 12hours < nonce < 24hours
        */

        public static function wp_verify_nonce_field($nonce, $action=-1) {
                return wp_verify_nonce($nonce, $action);
        }


        /**
        *An alternative way to verify nonces 
        *@param $action    :: this is a string name.
        *@param $query_arg :: this denotes the nonce name which WordPress will look for in the 
        *$_REQUEST variable. (defaults to _wpnonce if left blank)
        *@return           :: this function will return boolean 'false' for an invalid nonce or
        *return '1' if nonce <= 12hours or
        *return '2' if 12hours < nonce < 24hours
        */

        public static function wp_check_admin_referer($action = -1, $query_arg = '_wpnonce') {
                return check_admin_referer( $action, $query_arg );
        }

       /**
       *Verifying nonces in AJAX requests.
       *@param $action    :: this is a string name.
       *@param $query_arg :: this denotes the nonce name which WordPress will look for in the 
       *$_REQUEST variable. (defaults to _wpnonce if left blank)
       *@param  boolean $die Whether to die if the nonce is invalid.
       *@return           :: this function will return boolean 'false' for an invalid nonce or
       *return '1' if nonce <= 12hours or
       *return '2' if 12hours < nonce < 24hours
       */

        public static function wp_check_ajax_referer( $action = -1, $query_arg = false, $die = true ) {
    	       	return check_ajax_referer( $action, $queryArg, $die );
    	}	
	
        /**
        *Display's 'Are you sure you want to do this?' message to confirm the action being taken.
        *@param $action :: The required string nonce action.
        *@return This function does not return a value. 
        */

        public static function wp_nonce_ays( $action ) {
                 wp_nonce_ays( $action );
        }
}
