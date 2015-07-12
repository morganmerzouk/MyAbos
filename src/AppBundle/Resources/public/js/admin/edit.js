$(document).ready(function()  {
    
    //Page croisiere
    if($("form.croisiere_edit, form.croisiere_create").length) {
    	$("select[id$=_bateau]").on("change", function() {
    		//On vide les services payants
    		$(".croisiere-servicepayant .select2-search-choice").remove();
	        var id=$(this).val();
	        $.ajax
	        ({
	            type: "POST",
	            url: croisiere_servicepayant_url + '/' + id,
	            cache: false,
	            success: function(html)
	            {
	                $("select[id$=_servicePayant]").html(html);
	            } 
	        });
    	});
    }
});

