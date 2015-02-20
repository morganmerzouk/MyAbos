$(document).ready(function()  {

    if($("form.servicepayant_edit, form.servicepayant_create").length) {
    	var equipierAvitaillement = ["Equipiers supplémentaires","Service d'avitaillement supplémentaire"];
    	//On récupère la catégorie actuelle pour afficher les bons éléments
    	var categorie = $("select[id$='categorie'] option:selected").text();
    	afficherElementCategorie(categorie);
    	
        $("select[id$='categorie']").on("change", function() {
        	categorie = $("select[id$='categorie'] option:selected").text();
        	afficherElementCategorie(categorie);
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

