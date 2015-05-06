$(document).ready(function(){
    $('.slider').slick({
        autoplay: 	true,
        fade: 		true
    });
    

	$('video').on('ended', function () {
		this.load();
		this.play();
	});
});