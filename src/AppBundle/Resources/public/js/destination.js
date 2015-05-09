$(document).ready(function(){
    $('.slider-weather').slick({
        autoplay: 	false,
    });
    $('.slider').slick({
        autoplay: 	false,
        centerMode: true,
        slidesToShow: 5
    });
    $('.slider-side').slick({
        autoplay: 	true,
        arrows: false
    });
});
