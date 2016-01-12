$(document).on("ready", function() {
	$(".provider .img-thumbnail").on("click", function() {
		$(".provider").removeClass("selected");
		$(this).parent().addClass("selected");
		$(".contract-preview").hide();
		$(".contract-preview-"+$(this).data("id")).show();
		
	});
});