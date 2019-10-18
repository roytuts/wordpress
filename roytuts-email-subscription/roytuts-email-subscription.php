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