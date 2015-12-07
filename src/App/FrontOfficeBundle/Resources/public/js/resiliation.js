$(document).on("ready", function() {
	
	$(".select-cause-resiliation").on("change", function() {
		$("div.cause-resiliation").hide();
		$(".cause-resiliation-" + $(this).val()).show();
	});
	$(".select-cause-resiliation").trigger("change");
});