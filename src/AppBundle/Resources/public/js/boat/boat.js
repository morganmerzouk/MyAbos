$(document).ready(function() {
	$('.slider-available').slick({
		autoplay : false
	});
	$('.slider-boat').slick({
		autoplay : true
	});

	$('.boat-photo').colorbox();
	$('.boat-slider-photo').colorbox({rel:'boat-slider-photo'});
});