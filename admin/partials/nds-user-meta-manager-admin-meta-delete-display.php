<?php    

use Nds_User_Meta_Manager\Admin\Utils;

    if(current_user_can('edit_users')) {
        $dropdown_html = '<select id="nds_delete_user_meta_key" name="nds_delete_user_meta_key">
                            <option value="">'.__('Select A Meta Key', $plugin_name).'</option>';
        $nds_user_meta = get_user_meta($user_id);
            foreach ($nds_user_meta as $key => $value) {
                $dropdown_html .= '<option value="' . $key . '">' . $key . '</option>' . "\n";
            }
         $dropdown_html .= '</select>';         
        ?>

        <p> <?php _e('Select a meta key that you want to be delete.', $plugin_name); ?> </p>   
        
        <div class="nds_delete_user_meta_form">
        <form id="nds_delete_user_meta_form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">    
            <?php 
                
                //using this to get useful page information for redirecting later
                settings_fields($plugin_name); 
                      
                //use our oop nonce class
                //$nds_delete_meta_nonce = wp_create_nonce('nds_delete_user_meta_form_nonce');
                $nds_delete_meta_nonce = Utils\Nonce::create_nonce('nds_delete_user_meta_form_nonce'); 
             ?>            
            <input type="hidden" name="action" value="nds_delete_user_meta_form_response">
            <input type="hidden" name="nds_delete_user_meta_nonce" value="<?php echo $nds_delete_meta_nonce ?>" />
            <input type="hidden" name="nds_user" value="<?php echo $user_id; ?>" />
            <div>
                <?php echo $dropdown_html; ?>
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
