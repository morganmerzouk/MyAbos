$(document).ready(function() {
    $(".col-devis .input-date-depart, .col-devis .input-date-retour").datepicker({
        onSelect: function(dateText) {
            // On remplit les champs dans la colonne devis
            if($(this).hasClass("input-date-depart"))  {
                $('.devis-date-depart').html(dateText);
            } else if($(this).hasClass("input-date-retour")) {
                $('.devis-date-retour').html(dateText);
            }
        }
    });
    $('.select-duree-croisiere').on("change", function () { $('.devis-duree-sejour').html($(this).val()); });
    $('.select-nb-passager').on("change", function () { $('.devis-nb-passager').html($(this).val()); });
    
    // Faut surement faire un appel ajax pour récupérer le tarif
    $('.select-nb-passager').on("change", function () { 
        $('.loading').css("display", "block");
        
        nbPassager = $(this).val();
        dateDepart = encodeURIComponent($(".col-devis .input-date-depart").val().replace(new RegExp("/", "g"), "-"));
        nbDays = $('.select-duree-croisiere').val();
        console.log(dateDepart);
        $.ajax
        ({
            type: "POST",
            url: urlBoatPriceAjax + '/' + nbPassager + '/' + nbDays + '/' + dateDepart,
            cache: false,
            success: function(html)
            {
                $('.loading').css("display", "none");
                $(".devis-sejour-tarif").html(html);
            } 
        });
        $('.input-nb-passager').html($(this).val()); 
    });
    $('.select-portdepart').on("change", function () { $('.devis-port-depart').html($(this).find("option:selected").text()); });
    $('.select-destination').on("change", function () { $('.devis-destination').html($(this).find("option:selected").text()); });
    
    //Les options payantes
    $('.optionspayantes input[type="checkbox"]').click(function() {
        item = $(this).parent().parent().find(".optionpayante-name");
        if($(this).is(":checked")) {
            $('.devis-options-payantes').append('<div data-item-reference="' + item.data("item") + '">' + item.html() + "</div>");
        } else {
            $(".devis-options-payantes").find("[data-item-reference='" + item.data("item") + "']").remove();
        }
    });
    
    
});