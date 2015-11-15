$(document).ready(function() {
	$(".btn-start").on("click", function() {
		$("#fos_user_registration_form_firstname").val($("#firstname").val());
		$("#fos_user_registration_form_lastname").val($("#lastname").val());
		$("#fos_user_registration_form_email").val($("#email").val());
	});
});