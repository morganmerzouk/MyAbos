$(document).ready(function() {
	if(locale == "en") {
	    $(".searchHome .input-date-depart, .searchHome .input-date-retour").datepicker({ "dateFormat": "mm/dd/yy"});
	} else {
	    $(".searchHome .input-date-depart, .searchHome .input-date-retour").datepicker({ "dateFormat": "dd/mm/yy"});
	}
});