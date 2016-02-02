$(document).on("ready", function() {
	
	$(".btn-pdf").on("click", function()  {
		window.open(urlPdf + $(".select-cause-resiliation").val(),"Lettre de résiliation","menubar=no, status=no, scrollbars=no, menubar=no, width=500, height=600");
	});
	
	$(".select-cause-resiliation").on("change", function() {
		$("div.cause-resiliation").hide();
		$(".cause-resiliation-" + $(this).val()).show();
	});
	$(".select-cause-resiliation").trigger("change");
	
	$(".btn-preview-modify").on("click", function()  {
		$(".btn-preview-validate").removeClass("hidden");
		$(".btn-preview-modify").hide();
		$(".btn-preview-validate").show();
		$('div.cause-resiliation-address:visible').replaceWith(function(){
		    return $("<textarea class='pull-right text-justify cause-resiliation-address' rows='4' />").val($.trim($(this).html()).replace(/<br>/g, "\r"));
		});
		
		$('div.cause-resiliation-textarea:visible').replaceWith(function(){
		    return $("<textarea class='form-control text-justify cause-resiliation-textarea' rows='15' />").val($.trim($(this).html()).replace(/<br>/g, "\r"));
		});
	});

	$(".btn-preview-validate").on("click", function()  {
		$(".btn-preview-validate").hide();
		$(".btn-preview-modify").show();
		
		$('textarea.cause-resiliation-address:visible').replaceWith(function(){
		    return $("<div class='pull-right cause-resiliation-address'/>").html($(this).val().replace(/\n/g,"<br>"));
		});
		
		$('textarea.cause-resiliation-textarea:visible').replaceWith(function(){
		    return $("<div class='text-justify cause-resiliation-textarea' />").html($(this).val().replace(/\n/g,"<br>"));
		});
		
	});
});