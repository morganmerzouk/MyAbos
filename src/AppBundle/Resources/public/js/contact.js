$(document).ready(function() {
	
	$('.btn-send').on('click', function(evt){
		evt.preventDefault();
		$('.loading').css("display", "block");
        
		$.ajax
	    ({
	        type: "POST",
	        url: urlContactAjax,
	        data:
            {
                nom : $(".input-nom").val(),
                email : $(".input-email").val(),
                message : $('.textarea-message').val(),
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