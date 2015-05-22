$(document).ready(function() {
	if(locale == "en") {
	    $(".input-date-depart-devis, .input-date-retour-devis").datepicker({ "dateFormat": "mm/dd/yy"});
	} else {
	    $(".input-date-depart-devis, .input-date-retour-devis").datepicker({ "dateFormat": "dd/mm/yy"});
	}
	
	$('.btn-send-to-skipper').on('click', function(evt){
		evt.preventDefault();
        $('.loading').css("display", "block");
        
        var ids = new Array();
        $('.selection:checked').each(function() {
        	ids.push($(this).val());
        });
        
		$.ajax
	    ({
	        type: "POST",
	        url: urlSkipperContactAjax,
	        data:
            {
                dateDepart : $(".input-date-depart-devis").val(),
                dateRetour : $(".input-date-retour-devis").val(),
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