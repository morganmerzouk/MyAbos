$(document).ready(function(){
    $('.slider').slick({
        autoplay: 	true,
        fade: 		false
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