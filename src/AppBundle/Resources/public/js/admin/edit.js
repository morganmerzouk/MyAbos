$(document).ready(function()  {
	//Page servicepayant
    if($("form.servicepayant_edit, form.servicepayant_create").length) {
    	var equipierAvitaillement = ["Equipiers supplémentaires", "Additional crew", "Additional provisioning","Service d'avitaillement supplémentaire"];
    	//On récupère la catégorie actuelle pour afficher les bons éléments
    	var categorie = $("select[id$='categorie'] option:selected").text();
    	afficherElementCategorie(categorie);
    	
        $("select[id$='categorie']").on("change", function() {
        	categorie = $("select[id$='categorie'] option:selected").text();
        	afficherElementCategorie(categorie);
        });
    }
    
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
    	
    
    function afficherElementCategorie(categorie) {
    	if($.inArray(categorie, equipierAvitaillement)!==-1) {
    		displayEquipierAvitaillement(true);
    	} else {
    		displayEquipierAvitaillement(false);
        }
    }
            
    function displayEquipierAvitaillement(display) {
    	if(display) {
    		$(".form-group[id$='fraisSupplementaires'],.form-group[id$='devise'],.form-group[id$='tarifApplique']").show();
    	} else {
    		$(".form-group[id$='fraisSupplementaires'], .form-group[id$='devise'], .form-group[id$='tarifApplique']").hide();
    	}
    }
});

