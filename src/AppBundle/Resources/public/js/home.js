$(document).ready(function(){
    $('.slider').slick({
        autoplay: 	false,
        fade: 		true
    });
    $('.slider-destination').slick({
        autoplay: 	true,
        arrows: 	false,
        fade: 		true
    });
    
	$('video').on('ended', function () {
		this.load();
		this.play();
	});
});