<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       Author URI
 * @since      1.0.0
 *
 * @package    Nds_User_Meta_Manager
 * @subpackage Nds_User_Meta_Manager/admin/partials
 */
?>

<div class="wrap">    
    <h2><?php _e('NDS User Meta Manager', $this->plugin_name); ?></h2>

        <div id="nds-list-table">
            <div id="nds-post-body">                                                                             
                <?php
                    $this->user_list_obj->prepare_items();
                    $this->user_list_obj->display(); 
                ?>                                         
            </div>                
        </div>
</div>