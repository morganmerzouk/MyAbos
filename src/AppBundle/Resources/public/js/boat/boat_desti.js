$(document).ready(function() {
	$('a[id^="lien"]').click(function(evt) {
		evt.preventDefault();
		id = $(this).attr('id').split('-')[1];
		$('html,body').animate({scrollTop: $('#cible-'+id).offset().top},'slow');
	});
});
