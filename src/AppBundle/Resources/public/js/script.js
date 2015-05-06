$(document).ready(function() {
	if(locale == "en") {
	    $(".input-date-depart").datepicker({ "dateFormat": "mm/dd/yy"});
	} else {
	    $(".input-date-depart").datepicker({ "dateFormat": "dd/mm/yy"});
	}
	
	// On simule le click sur le tab si on vient d'une autre page (pour les pages flottes, offres et skipper)
    if(window.location.href.indexOf("#") > -1) {
	    	if($("a[href=#" + window.location.href.split("#")[1] + "]").length) {
	    		$("a[href=#" + window.location.href.split("#")[1] + "]").tab("show");
	    	}
    }
	
	$('.btn-newsletter-subscribe').on('click', function() {
		if($('.newsletter-email').val() == "" || $('.newsletter-email').val() == "email" ) {
			return;
		}
		
		if(validateEmail($('.newsletter-email').val())) {
			$('.newsletter-email').css("border-color", "initial");
			$.ajax
		    ({
		        type: "POST",
		        url: urlNewsletterSubscribe,
		        data:
	            {
	                email : $('.newsletter-email').val(),
	            },
		        cache: false,
		        success: function(html)
		        {
		        	if(html) {
			        	$('.newsletter-succes').show();
			        	$('.newsletter-fail').hide();
		        	} else {
			        	$('.newsletter-succes').hide();
			        	$('.newsletter-succes').show();
			        	$('.newsletter-email-invalide').html($('.newsletter-email').val());
		        	}
		        },
		        error: function() {
		        	$('.newsletter-wrong').show();
		        	$('.newsletter-fail').hide();
		        	$('.newsletter-succes').hide();
		        }
		    });	
		} else {
			$('.newsletter-email').css("border-color", "red");
		}
	});
});
	
function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}