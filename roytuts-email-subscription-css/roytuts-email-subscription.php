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

add_action('wp_enqueue_scripts', 'roytuts_enqueued_assets');

function roytuts_enqueued_assets() {
	wp_register_script('ajaxHandle', plugin_dir_url( __FILE__ ) . '/js/roytuts-email-subscription.js', array('jquery'), false, true);	
	wp_localize_script( 
		'ajaxHandle',
		'ajax_object',
		array( 'ajaxurl' => admin_url('admin-ajax.php') ) 
	);
	wp_enqueue_script('ajaxHandle');
	
	wp_register_style('subscriptionstyle', plugin_dir_url( __FILE__ ) . '/css/roytuts-email-subscription.css');
	wp_enqueue_style('subscriptionstyle');
}

function roytuts_email_subscription_callback() {
	global $wpdb;
	
	if(isset($_POST) && !empty($_POST['email'])) {
		$email = $_POST['email'];
		$table_name = $wpdb->prefix . 'roytuts_subscribers';
		$fetch_sql_query = "select * from " . $table_name . " where email_id='$email'";
		$result = $wpdb->get_results($fetch_sql_query);
		if(count($result) == 0) {
			//Insert new row
			$data = array('email_id' => $email);
			$result_check = $wpdb->insert($table_name, $data);
			if($result_check){
				echo 'success';
			} else {
				echo 'error';
			}
		} else {
			echo 'success';//already subscribed
		}
	}
	wp_die();
}

add_action('wp_ajax_roytuts_email_subscription', 'roytuts_email_subscription_callback');
add_action('wp_ajax_nopriv_roytuts_email_subscription','roytuts_email_subscription_callback');