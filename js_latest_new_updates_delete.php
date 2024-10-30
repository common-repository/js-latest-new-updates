<h2>
<?php  
if ( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly

_e( 'Delete News', 'JS_latest_new_updates' ) ?> </h2> 
 <?php 
    global $wpdb;
    $js_news_updates = $wpdb->prefix . 'js_news_updates';
    $accid = sanitize_text_field($_GET['accid']);
    $action = sanitize_text_field($_GET['action']);
    	if($action == 'delete')
    	{
			$retrieved_nonce_del_url = sanitize_text_field($_REQUEST['_wpnonce']);
			if (!wp_verify_nonce($retrieved_nonce_del_url, 'delete_my_new_url' ) )
			{ 
				die( 'Failed security check' );
			}
			else
			{
				$sql = $wpdb->prepare( "Delete FROM $js_news_updates WHERE acc_id = %d" , $accid );
				if($wpdb->query($sql))
				{
					?>
					<span class='msg'><?php  _e( 'Your News is deleted successfully.', 'JS_latest_new_updates' ) ?><a href='admin.php?page=JS_latest_new_updates'> <?php  _e( 'Click here', 'JS_latest_new_updates' ) ?></a> <?php  _e( 'to view News.', 'JS_latest_new_updates' ) ?></span>
				  
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