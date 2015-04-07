$(document).ready(function() {
	$('a[id^="lien"]').click(function(evt) {
		evt.preventDefault();
		id = $(this).attr('id').split('-')[1];
		$('#cible-'+id).trigger('click');
	});
	$('h3').not(".boat-desti-localisation").click(function() {
		$(this).toggleClass('title-hover');
		$(this).next().slideToggle('slow');
		return false;
	}).next().hide();
});