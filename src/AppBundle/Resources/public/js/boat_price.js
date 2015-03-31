$(document).ready(function() {
	$('h3').click(function() {
		$(this).toggleClass('title-hover');
		$(this).next().toggle('slow');
		return false;
	}).next().hide();
});