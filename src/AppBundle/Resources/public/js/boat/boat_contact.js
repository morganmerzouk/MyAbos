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
	        url: urlBoatContactAjax,
	        data:
            {
                dateDepart : $(".input-date-depart-devis").val(),
                dateRetour : $(".input-date-retour-devis").val(),
                nbPassager : $(".select-nb-passager-devis").val(),
                itineraire: $(".select-itineraire-devis").val(),
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