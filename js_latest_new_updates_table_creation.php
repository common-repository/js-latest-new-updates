<?php 
if ( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly

  	global $wpdb;
  	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
	global $js_news_updates;
	$js_news_updates = $wpdb->prefix . 'js_news_updates';
    $charset_collate = $wpdb->get_charset_collate();
	
	if($wpdb->get_var("show tables like '". $js_news_updates ."'") != $js_news_updates) 
	{
		
	$sql = "CREATE TABLE ". $js_news_updates ." (
		acc_id int(9) NOT NULL AUTO_INCREMENT,
		message varchar(500) NOT NULL,
		tags varchar(100) NOT NULL,
		date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		expdate datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		UNIQUE KEY id (acc_id)
	) ". $charset_collate .";";

	dbDelta( $sql );
	
	}