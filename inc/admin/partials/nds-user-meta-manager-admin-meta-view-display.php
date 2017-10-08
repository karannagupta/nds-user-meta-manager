<?php    
    if(current_user_can('edit_users')) {            
        $nds_user_meta = get_user_meta($user_id);
        echo '<div class="card">';
        foreach($nds_user_meta as $key => $value) {
            $v = (is_array($value)) ? implode(', ', $value) : $value;            
            echo '<p">'. $key . ': ' . $v . '</p>';
        }
        echo '</div>';
?>
		<a href="<?php echo esc_url( add_query_arg( array( 'page' => wp_unslash( $_REQUEST['page'] ) ) , admin_url( 'users.php' ) ) ); ?>"><?php _e( 'Back', $this->plugin_text_domain ) ?></a>		
<?php
	}
    else {  
    ?>
        <p> <?php __("You are not authorized to perform this operation.", $plugin_name) ?> </p>
    <?php   
    }
?>
