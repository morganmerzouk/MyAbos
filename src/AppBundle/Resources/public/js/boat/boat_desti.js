$(document).ready(function() {
	$('a[id^="lien"]').click(function(evt) {
		evt.preventDefault();
		id = $(this).attr('id').split('-')[1];
		$('#cible-'+id).parent().trigger('click');
	});
	$('h3').not(".boat-desti-localisation").parent().click(function() {
		$(this).toggleClass('title-hover');
		$(this).next().slideToggle('slow');
		return false;
	}).next().hide();
});