$(document).ready(function() {
	$('.filter-price').on('click', function(evt) {
		evt.preventDefault();
		var attr=$(this).data('attr');
        $.ajax
        ({
            type: "POST",
            url: search_result_content_url + '/' + attr,
            cache: false,
            success: function(html)
            {
    			$(".search-result-content").html(html);
            } 
        });
	});
});