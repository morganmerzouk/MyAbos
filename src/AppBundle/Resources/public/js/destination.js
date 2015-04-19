$(document).ready(function(){
	$('h2').click(function() {
		$(this).toggleClass('title-hover');
		$(this).next().slideToggle('slow');
		return false;
	}).next().hide();;
});
