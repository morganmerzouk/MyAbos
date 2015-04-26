$(document).ready(function() {
	
	$('.btn-send').on('click', function(){
        $('.loading').css("display", "block");
        
        var ids = new Array();
        $('.selection:checked').each(function() {
        	ids.push($(this).val());
        });
        
		$.ajax
	    ({
	        type: "POST",
	        url: urlOffreSpecialeContactAjax,
	        data:
            {
                nom : $(".input-nom").val(),
                email : $(".input-email").val(),
                message : $('.textarea-message').val(),
                servicePayant: ids
            },
	        cache: false,
	        success: function(html)
	        {
	            $('.loading').css("display", "none");
	            $('.btn-sent').css("display", "block");
	        },
	        error: function() {
	            $('.loading').css("display", "none");
	        }
	    });	
	});
});