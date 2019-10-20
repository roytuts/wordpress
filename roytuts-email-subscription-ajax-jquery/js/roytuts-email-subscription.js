jQuery(document).ready(function($) {
	jQuery('#roytuts_submit').click(function(e) {
		e.preventDefault();
		
		var email = jQuery('#roytuts_contact_email').val();
		
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/i;
		
		if(email !== '' && regex.test(email)) {
		
			var data = {
				'action': 'roytuts_email_subscription',
				'email': email
			};
			
			jQuery.post(ajax_object.ajaxurl, data, function(response) {
				if(response == "success") {
					jQuery('#roytuts-msg').html('<span style="color: green;">Subscription Successful</span>');
				} else if(response == "error") {
					jQuery('#roytuts-msg').html('<span style="color: red;">Subscription Failed</span>');
				}
			});
		} else {
			jQuery('#roytuts-msg').html('<span style="color: red;">Invalid Email</span>');
		}
	});
});