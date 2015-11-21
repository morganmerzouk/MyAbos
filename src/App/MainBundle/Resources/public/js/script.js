$(document).ready(function() {
	$("form input.date").datepicker();
	
	//On gère le message d'avertissement pour les cookies
	if(locale == "fr") {
		getConteneurInfoCookie();
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

function getConteneurInfoCookie(){
	if(localStorage['BandeauInfoCookie'] != 1){
		$('#BandeauInfoCookie').css('display', 'block');
	}else{
		$('#BandeauInfoCookie').css('display', 'none');
		$('#ConteneurInfosCookie').css('display', 'none');
	}
}

function getInfosCookie(){
	if($('#ConteneurInfosCookie').css('display') == "none"){
		$('#ConteneurInfosCookie').css('display', "block");
	}else{
		$('#ConteneurInfosCookie').css('display', "none");
	}
}
	
function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}