<?php
if ( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly
?>
<h2><?php _e( 'News', 'JS_latest_new_updates' )  ?></h2>
<div class="newannouncement"><a href="admin.php?page=jsnewupdates" id="addannouncement"><?php _e('Add News', 'JS_latest_new_updates') ?></a></div>
<table class="announdisplay" id="rpjob">
 <thead>
<th><?php _e( 'ID', 'JS_latest_new_updates' ); ?></th>
<th><?php _e( 'Message', 'JS_latest_new_updates' ); ?></th>
<th><?php _e( 'Date', 'JS_latest_new_updates' ); ?></th>
<th><?php _e( 'Modify', 'JS_latest_new_updates' ); ?></th>
<th><?php _e( 'Delete', 'JS_latest_new_updates' ); ?></th>
</thead>
<tbody>
<?php
global $wpdb;
$js_news_updates = $wpdb->prefix . 'js_news_updates';
    $newslist = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $js_news_updates ORDER BY acc_id ASC",'' ));
		  foreach ($newslist as $newslistfin)
		  {
			  ?>
			  <tr>
			  <td><?php echo $newslistfin->acc_id ?></td>
			  <td><?php echo $newslistfin->message ?></td>
			  <td><?php echo $newslistfin->date ?></td>
			  <?php 
			  $edit_nonced_url = wp_nonce_url('admin.php?page=editjsnewupdates&accid='.$newslistfin->acc_id , 'edit_my_new_url');
			  ?>
			  <td>
			  <a href="<?php echo $edit_nonced_url ?>"><?php _e( 'Edit', 'JS_latest_new_updates' ); ?></a></td>
			  <?php 
			  $del_nonced_url = wp_nonce_url('admin.php?page=deletejsnewupdates&action=delete&accid='.$newslistfin->acc_id , 'delete_my_new_url');
			  ?>
			 <td> <a href="<?php echo $del_nonced_url  ?>"><?php _e( 'Delete', 'JS_latest_new_updates' ); ?></a>
			  </td>
			  </tr>
			  <?php
		  }
 ?>

</tbody>
</table>