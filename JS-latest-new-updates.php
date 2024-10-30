<?php
/*
Plugin Name: JS Latest New Updates
Description: This plugin is used to display the latest news upload by the admin in the backend. We can use the shortcode to display the news in any page of the website.
Version: 1.0.2
Author: johnsha
Author URI: https://johnsaolli.wixsite.com/resume
License: GPL
*/

/**
 * Register a custom menu page.
 */

if ( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly

function JS_latest_new_update_funcs(){
    add_menu_page( 
        __( 'JS News Update', 'JS_latest_new_updates' ),
        'JS News Update',
        'manage_options',
        'JS_latest_new_updates',
        'JS_latest_new_updates_page',
        'dashicons-list-view',
        6
    ); 
}
add_action( 'admin_menu', 'JS_latest_new_update_funcs' );  

define('WPRP_PATH', plugin_dir_path(__FILE__)); 

function JS_latest_new_updates_page(){
    require_once(WPRP_PATH . 'includes/js_latest_new_updates_list.php');
}


add_action('admin_menu', 'JS_latest_new_updates_new_page');
function JS_latest_new_updates_new_page() {
    add_submenu_page(
        'latestnews',
        'Latest News',
        'Latest News',
        'manage_options',
        'jsnewupdates',
        'jsnewupdates_funcs' );
}
function jsnewupdates_funcs(){
require_once(WPRP_PATH . 'includes/js_latest_new_updates_form.php');
}

add_action('admin_menu', 'JS_latest_new_updates_edit_page');
function JS_latest_new_updates_edit_page() {
    add_submenu_page(
        'editnews',
        'Edit News',
        'Edit News',
        'manage_options',
        'editjsnewupdates',
        'editjsnewupdates_funcs' );
}
function editjsnewupdates_funcs(){
require_once(WPRP_PATH . 'includes/js_latest_new_updates_edit.php');
}


add_action('admin_menu', 'JS_latest_new_updates_delete_page');
function JS_latest_new_updates_delete_page() {
    add_submenu_page(
        'deletenews',
        'Delete News',
        'Delete News',
        'manage_options',
        'deletejsnewupdates',
        'deletejsnewupdates_funcs' );
}
function deletejsnewupdates_funcs(){
require_once(WPRP_PATH . 'includes/js_latest_new_updates_delete.php');
}


// admin css enqueue code
add_action( 'admin_enqueue_scripts', 'JS_load_admin_style' );
function JS_load_admin_style() {
        wp_enqueue_style( 'admin-style', plugin_dir_url( __FILE__ ) . 'assets/css/admin-style.css', false, '1.0.0' );
}

// css enqueue code
add_action( 'wp_enqueue_scripts', 'JS_front_scripts' );

function JS_front_scripts(){
        wp_enqueue_style('style', plugin_dir_url( __FILE__ ).'assets/css/style.css');
}  


// admin js script
add_action( 'admin_enqueue_scripts', 'JS_load_admin_script' );
      function JS_load_admin_script() {
        wp_enqueue_script( 'jquery-paginate', plugin_dir_url( __FILE__ ) . 'assets/js/jquery-paginate.min.js', false, '1.0.0' );
		wp_enqueue_script( 'pagination', plugin_dir_url( __FILE__ ) . 'assets/js/pagination-admin.js', false, '1.0.0' );
       }

require_once(WPRP_PATH . 'includes/js_latest_new_updates_table_creation.php'); 

// create a shortcode for announcement 
function JS_latest_new_updates()  {

    global $wpdb;
    $js_news_updates = $wpdb->prefix . 'js_news_updates';
	$todaydate = date('Y-m-d');
    $newslist = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $js_news_updates WHERE expdate >= '$todaydate' ORDER BY date DESC",''));
    $data = "<div class='jsnewlist'>";
		  foreach ($newslist as $newslistfin)
		  {
		 $data .= "<div class='announ_dis'>";	 
		 $data .="<div class='ann_msg_left'>";
		 $newDate = date("d-m-Y H:i:s", strtotime($newslistfin->date));
		 $data .="<span class='announe_date'><strong>Posted on: </strong>". $newDate ."</span><br/>". $newslistfin->message ."
		 </div><span class='announe_date'><strong>Tags: </strong>". $newslistfin->tags."</span>";
		 $data .= "</div>";

		  }
		  $data .="</div>";

	return $data;
	
	
	
}
add_shortcode( 'JS_News', 'JS_latest_new_updates' );

       
       
       