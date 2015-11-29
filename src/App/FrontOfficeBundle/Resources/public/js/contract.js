$(document).on("ready", function() {
	$(".form-add-contrat").hide();
	
	$(".category").on("click", function() {
		$(".form-category").val($(this).data('id'));
		$(".form-add-contrat").show();
		$(".block-categories").hide();
		
		$('.provider').hide();
		$('.provider_'+$(this).data('id')).show();
	});
	
	$(".img").on("mouseenter", function(){
        $(this).addClass("hover");
    })

    $(".img").on("mouseleave", function(){
        $(this).removeClass("hover");
    });
});