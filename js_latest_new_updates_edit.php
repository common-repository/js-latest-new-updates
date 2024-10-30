<?php
if ( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly
?>
<h2><?php  _e( 'Edit News', 'JS_latest_new_updates' ) ?></h2>
<?php  
    $accid = sanitize_text_field($_GET['accid']);
    global $wpdb;
    $js_news_updates = $wpdb->prefix . 'js_news_updates';
    
    if ($_POST['updateannoun']) 
          {
			$retrieved_nonce_edit = sanitize_text_field($_REQUEST['_wpnonce']);
			if (!wp_verify_nonce($retrieved_nonce_edit, 'my_news_updates_edit' ) )
			{ 
				die( 'Failed security check' );
			}
			else
			{
            $acc_msg = $wpdb->escape(trim(sanitize_text_field($_POST['acc_msg']))); 
			$acc_tags = $wpdb->escape(trim(sanitize_text_field($_POST['tags'])));$acc_expdate = $wpdb->escape(trim(sanitize_text_field($_POST['expdate'])));			
            $sql = $wpdb->prepare("UPDATE $js_news_updates SET message='$acc_msg', tags='$acc_tags', date = CURRENT_TIMESTAMP, expdate='$acc_expdate' WHERE acc_id = %d", $accid );
       
            if($wpdb->query($sql))
    			{
					?>
						<span class='msg'><?php  _e( 'Your News is Updated successfully.', 'JS_latest_new_updates' ) ?><a href='admin.php?page=JS_latest_new_updates'> <?php  _e( 'Click here', 'JS_latest_new_updates' ) ?></a> <?php  _e( 'to view News.', 'JS_latest_new_updates' ) ?></span>
					<?php
    			}
    			else
    			{
    				?>
						<span class='msg'><?php  _e( 'ERROR: Sorry please try again', 'JS_latest_new_updates' ) ?></span>
					<?php 
    			}
			}				
          }
        
        if (! $_POST['updateannoun']) 
        {
			$retrieved_nonce_edit_url = sanitize_text_field($_REQUEST['_wpnonce']);
			if (!wp_verify_nonce($retrieved_nonce_edit_url, 'edit_my_new_url' ) )
			{ 
				die( 'Failed security check' );
			}
			else
			{
				$newslist = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $js_news_updates WHERE acc_id=%d", $accid ));
				foreach ( $newslist as $newslistfin )
				{
				?>
				<div id="jsnewsedit">
				 <form method="post" action="" enctype="multipart/form-data" class="newannoun">
							<label><?php _e('Message','JS_latest_new_updates'); ?></label> <br/>
							<textarea name="acc_msg" rows="8" cols="100" required> <?php echo $newslistfin->message ?> </textarea>
							<label><?php _e('Tags','JS_latest_new_updates'); ?></label> <br/>
							<input type="text" name="tags" id="tags" value="<?php echo $newslistfin->tags ?>" required/> 
							<label><?php _e('Expiry date','JS_latest_new_updates'); ?></label> <br/>
							<input type="date" name="expdate" id="expdate" value="<?php echo date("Y-m-d", strtotime($newslistfin->expdate)) ?>" required/> 		
							<?php wp_nonce_field('my_news_updates_edit'); ?>
							<hr/>
							<input type="submit" id="submitbtn" name="updateannoun" value="<?php  _e( 'Update News', 'JS_latest_new_updates' ) ?>" /> 
						</form> 
						<div>
				 <?php
				}
			}
        }
