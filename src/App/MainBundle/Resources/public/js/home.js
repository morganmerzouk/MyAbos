$(document).ready(function() {
	$(".btn-start").on("click", function() {
		$("#firstname").val($("#fos_user_registration_form_firstname").val());
		$("#lastname").val($("#fos_user_registration_form_lastname").val());
		$("#email").val($("#fos_user_registration_form_email").val());
	});
});