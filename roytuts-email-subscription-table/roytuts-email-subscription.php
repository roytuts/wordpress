<?php
/**
 * Plugin Name: Roytuts Email Subscription
 * Description: This plugin allows users subscribe to recent posts
 * Version: 1.0.0
 * Author: Soumitra Roy Sarkar
 * Author URL: https://www.roytuts.com
 */

//add shortcode
add_shortcode('roytuts-email-subscription-display', 'roytuts_email_subscription_display_form');
 
function roytuts_email_subscription_display_form() {
   return '<div id="roytuts-subscription"><h3>Subscribe to Recent Posts:</h3>
		<div id="roytuts-msg"></div>
		<p><input type="text" id="roytuts_contact_email" name="roytuts-email" placeholder="Email Address"></input></p>
		<p><input type="button" id="roytuts_submit" value="Subscribe Now!" /></p>
	</div>';
}

register_activation_hook( __FILE__, 'roytuts_on_activation' );

function roytuts_on_activation(){
	// create the custom table
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'roytuts_email_subscribers';
	$charset_collate = $wpdb->get_charset_collate();
	
	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        email_id varchar(50) NOT NULL default '') $charset_collate;";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
