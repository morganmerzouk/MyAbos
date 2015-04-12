$(document).ready(function(){
    $('.slider').slick({
        autoplay: 	true,
        fade: 		true
    });

    $('.lienHome li').css("height", $('.lienHome li').css('width'));
});

$(window).on('resize', function() {
    $('.lienHome li').css("height", $('.lienHome li').css('width'));
});