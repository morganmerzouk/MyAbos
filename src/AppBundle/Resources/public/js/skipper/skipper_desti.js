$(document).ready(function() {
	$('a[id^="lien"]').click(function(evt) {
		evt.preventDefault();
		id = $(this).attr('id').split('-')[1];
		$('#cible-'+id).parent().trigger('click');
	});
	
	$('.skipper-desti .cible').not(".boat-desti-localisation").click(function() {
		$(this).toggleClass('title-hover');
		$(this).next().slideToggle('slow');
		return false;
	}).next().hide();
});