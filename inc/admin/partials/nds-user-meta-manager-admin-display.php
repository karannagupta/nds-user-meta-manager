<?php

/**
 * The admin area of the plugin to load the User List Table
 */
?>

<div class="wrap">    
    <h2><?php _e( 'NDS User Meta Manager', $this->plugin_text_domain); ?></h2>
        <div id="nds-wp-list-table-demo">			
            <div id="nds-post-body">		
				<form id="nds-user-list-form" method="get">
					<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
					<?php 
						$this->user_list_obj->search_box( __( 'Search User', $this->plugin_text_domain ), 'nds-user-find');
						$this->user_list_obj->display(); 
					?>					
				</form>
            </div>			
        </div>
</div>