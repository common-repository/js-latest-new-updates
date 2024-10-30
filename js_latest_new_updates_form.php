<?php
if ( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly
?>
<h2><?php  _e( 'Add News', 'JS_latest_new_updates' ) ?> </h2> 
<?php 
global $wpdb;
	$js_news_updates = $wpdb->prefix . 'js_news_updates';
      if ($_POST['saveannounce']) 
      {
		$retrieved_nonce = sanitize_text_field($_REQUEST['_wpnonce']);
		if (!wp_verify_nonce($retrieved_nonce, 'my_news_updates' ) )
		{ 
			die( 'Failed security check' );
		}
		else
		{
        $acc_msg = $wpdb->escape(trim(sanitize_text_field($_POST['acc_msg']))); 
		$acc_tags = $wpdb->escape(sanitize_text_field(trim($_POST['tags']))); 
		$acc_expdate = $wpdb->escape(sanitize_text_field(trim($_POST['expdate'])));
		// nonce verifying code
		
		
	     
        $sql = "INSERT INTO $js_news_updates (message, tags, date, expdate) VALUES ('$acc_msg', '$acc_tags', CURRENT_TIMESTAMP, '$acc_expdate' )";
        
        if($wpdb->query($sql))
			{
				?>
				<span class='msg'><?php  _e( 'Your News is published successfully.', 'JS_latest_new_updates' ) ?><a href='admin.php?page=JS_latest_new_updates'> <?php  _e( 'Click here', 'JS_latest_new_updates' ) ?></a> <?php  _e( 'to view News.', 'JS_latest_new_updates' ) ?></span>
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
      if (!$_POST['saveannounce']) 
      {
        ?>
         <div id="jsnewsedit">
         <form method="post" action="" enctype="multipart/form-data" class="newannoun">
        	<label><?php _e('Message','JS_latest_new_updates'); ?></label> <br/>
        	<textarea name="acc_msg" rows="8" cols="100" required></textarea>
			<label><?php _e('Tags','JS_latest_new_updates'); ?></label> <br/>
			<input type="text" name="tags" id="tags" value="" required/> 
			<label><?php _e('Expiry date','JS_latest_new_updates'); ?></label> <br/>
			<input type="date" name="expdate" id="expdate" value="" required/> 			
			<?php wp_nonce_field('my_news_updates'); ?>
        	<hr/>
            <input type="submit" id="submitbtn" name="saveannounce" value="<?php  _e( 'Add News', 'JS_latest_new_updates' ) ?>" /> 
        </form> 
        </div>
        <?php
        }