$(document).ready(function() {
	$('.btn-send-to-skipper').on('click', function() {            
		$('.skipper-contact-step2-loading').css("display", "block");
		$.ajax
	    ({
	        type: "POST",
	        url: urlContact,
	        cache: false,
	        success: function(html)
	        {
	            $(".devis-content-tarif").show();
	            $(".devis-sejour-tarif").html(html);
	            $('.field_prix').val($html)
	            displayFinalPrice();
	            $('.skipper-contact-step2-loading').css("display", "none");
	        },
	        error: function() {
	            $('.skipper-contact-step2-loading').css("display", "none");
	        }
	    });
	});
	
});