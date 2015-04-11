$(document).ready(function() {
    $(".col-devis .input-date-depart, .col-devis .input-date-retour").datepicker({
        onSelect: function(dateText) {
            // On remplit les champs dans la colonne devis
            if($(this).hasClass("input-date-depart"))  {
                $('.devis-date-depart').html(dateText);
            } else if($(this).hasClass("input-date-retour")) {
                $('.devis-date-retour').html(dateText);
            }
            searchPrice();
            //On l'affiche si nécessaire
            $('.devis-content-date-sejour').show();
        }
    });
    
    $('.select-duree-sejour').on("change", function () { 
    	if($(this).val() != ""){
        	$('.devis-content-duree-sejour').show();
            $('.devis-duree-sejour').html($(this).val()); 
    	} else {
        	$('.devis-content-duree-sejour').hide();
    	}
    });
    $('.select-nb-passager').on("change", function () { 
    	if($(this).val() != ""){
        	$('.devis-content-nb-passager').show();
        	$('.devis-nb-passager').html($(this).val());  
    	} else {
        	$('.devis-content-nb-passager').hide();
    	}
    });
    
    $('.select-portdepart').on("change", function () { 
        if($(this).val() != ""){
            $('.devis-content-port-depart').show();
            $('.devis-port-depart').html($(this).find("option:selected").text());  
    	} else {
            $('.devis-content-port-depart').hide();
        }
    });
    $('.select-destination').on("change", function () { 
        if($(this).val() != ""){
            $('.devis-content-destination').show();
            $('.devis-destination').html($(this).find("option:selected").text());  
    	} else {
            $('.devis-content-destination').hide();
        }
    });
    
    // Faut surement faire un appel ajax pour récupérer le tarif
    $('.select-nb-passager, .select-duree-sejour, .col-devis .input-date-depart, .col-devis .input-date-retour, .select-portdepart, .select-destination').on("change", function () { 
    	searchPrice();
    });
        
    //Les options payantes
    $('.optionspayantes input[type="checkbox"]').click(function() {
    	if($('.optionspayantes input[type="checkbox"]:checked').length > 0) {
    		$('.devis-content-option-payante').show();
        } else {
        	$('.devis-content-option-payante').hide();	
    	}
    	item = $(this).parent().parent().find(".optionpayante-name");
        if($(this).is(":checked")) {
            $('.devis-options-payantes').append('<div data-item-reference="' + item.data("item") + '">' + item.html() + "</div>");
        } else {
            $(".devis-options-payantes").find("[data-item-reference='" + item.data("item") + "']").remove();
        }
    });
    
    function searchPrice() {
        if($(".select-nb-passager").val() != "" && ($(".col-devis .input-date-depart").val() != "" || $(".col-devis .input-date-retour").val() != "")) {
            $('.loading').css("display", "block");

            nbPassager = $('.select-nb-passager').val() != "" ? $('.select-nb-passager').val() : "0";
            dateDepart = $(".col-devis .input-date-depart").val() != "" ? encodeURIComponent($(".col-devis .input-date-depart").val().replace(new RegExp("/", "g"), "-")) : "0";
            dateFin = $(".col-devis .input-date-retour").val() != "" ? encodeURIComponent($(".col-devis .input-date-retour").val().replace(new RegExp("/", "g"), "-")) : "0";
            nbDays = $('.select-duree-sejour').val() != "" ? $('.select-duree-sejour').val() : "0";

            $.ajax
            ({
                type: "POST",
                url: urlBoatPriceAjax + '/' + nbPassager + '/' + nbDays + '/' + dateDepart + '/' + dateFin,
                cache: false,
                success: function(html)
                {
                    $(".devis-content-tarif").show();
                    $(".devis-sejour-tarif").html(html);
                    $('.field_prix').val(html);
                    displayFinalPrice();
                    $('.loading').css("display", "none");
                },
                error: function() {
                    $('.loading').css("display", "none");
                }
            });
            $('.input-nb-passager').html($(this).val()); 
        }
    }
    function displayFinalPrice() {
        if($(".select-nb-passager").val() != "" &&  $(".select-duree-sejour").val() != "" && ($(".col-devis .input-date-depart").val() != "" || $(".col-devis .input-date-retour").val() != "")) {
            nbDays = $('.select-duree-sejour').val() != "" ? $('.select-duree-sejour').val() : "0";
            price = $(".devis-sejour-tarif").html();
            finalPrice = nbDays * price;
            $('.final-price').html(finalPrice); 
            $(".devis-content-final-price").show();
        } else {
            $(".devis-content-final-price").hide();
        }
    }
});