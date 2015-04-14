$(document).ready(function() {
	$('.btn-send-to-skipper').on('click', function() {            
		$('.boat-contact-step2-loading').css("display", "block");
		$.ajax
	    ({
	        type: "POST",
	        url: urlContact,
	        cache: false,
	        success: function(html)
	        {
	            $('.boat-contact-step2-loading').css("display", "none");
	        },
	        error: function() {
	            $('.boat-contact-step2-loading').css("display", "none");
	        }
	    });
	});
	
});