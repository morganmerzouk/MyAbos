$(document).ready(function() {
	$('h3').click(function() {
		$(this).toggleClass('title-hover');
		$(this).next().slideToggle('slow');
		return false;
	});
});