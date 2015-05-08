$(document).ready(function() {
	$(".input-date-depart, .input-date-retour").datepicker({ 
	});
	
	$('.btn-send-to-skipper').on('click', function(){
        $('.loading').css("display", "block");
        
        var ids = new Array();
        $('.selection:checked').each(function() {
        	ids.push($(this).val());
        });
        
		$.ajax
	    ({
	        type: "POST",
	        url: urlBoatContactAjax,
	        data:
            {
                dateDepart : $(".input-date-depart").val(),
                dateRetour : $(".input-date-retour").val(),
                dureeSejour : $(".select-duree-sejour").val(),
                nbPassager : $(".select-nb-passager").val(),
                portDepart: $(".select-portdepart").val(),
            	destination: $(".select-destination").val(),
                nom : $(".input-nom").val(),
                email : $(".input-email").val(),
                message : $('.textarea-message').val(),
                servicePayant: ids
            },
	        cache: false,
	        success: function(html)
	        {
	            $('.loading').css("display", "none");
	            $('.btn-sent').css("display", "block");
	        },
	        error: function() {
	            $('.loading').css("display", "none");
	        }
	    });	
	});
});