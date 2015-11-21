$(document).on("ready", function() {
	$(".form-add-contrat").hide();
	
	$(".category").on("click", function() {
		$(".form-category").val($(this).data('id'));
		$(".form-add-contrat").show();
		$(".block-categories").hide();
	});
});