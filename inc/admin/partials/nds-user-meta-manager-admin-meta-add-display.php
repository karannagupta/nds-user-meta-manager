<?php 

use Nds_User_Meta_Manager\Inc\Libraries;

    if(current_user_can('edit_users')) {?>
        <p> <?php _e('Insert a key and its value in the fields below.', $plugin_name); ?> </p>        
        <div class="nds_add_user_meta_form">
        <form id="nds_add_user_meta_form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">    
            <?php 
                
                //using this to get useful page information for redirecting later
                settings_fields($plugin_name); 
                      
                //use our oop nonce class
                //$nds_add_meta_nonce = wp_create_nonce('nds_add_user_meta_form_nonce'); 
                $nds_add_meta_nonce = Libraries\Nonce::create_nonce('nds_add_user_meta_form_nonce'); 
             ?>
            <input type="hidden" name="action" value="nds_add_user_meta_form_response">
            <input type="hidden" name="nds_add_user_meta_nonce" value="<?php echo $nds_add_meta_nonce ?>" />
            <input type="hidden" name="nds_user" value="<?php echo $user_id; ?>" />
            <div>
                <strong><label for="<?php echo $plugin_name; ?>-user_meta_key"> <?php _e('New User Meta Key', $plugin_name); ?> </label></strong><br />
                <input id="<?php echo $plugin_name; ?>-user_meta_key" type="text" name="<?php echo "nds"; ?>[user_meta_key]" value="" placeholder="<?php _e('Meta Key', $plugin_name);?>" /><br />
            </div>
            <div>
                <strong><label for="<?php echo $plugin_name; ?>-user_meta_value"> <?php _e('Value for User Meta Key', $plugin_name); ?> </label></strong><br />
                <input id="<?php echo $plugin_name; ?>-user_meta_value" type="text" name="<?php echo "nds"; ?>[user_meta_value]" value="" placeholder="<?php _e('Meta Value', $plugin_name);?>"/><br />
            </div>                 
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
    <?php    
    }
    else {  
    ?>
        <p> <?php __("You are not authorized to perform this operation.", $plugin_name) ?> </p>
    <?php   
    }
?>
