$(document).on("ready", function() {
	$(".filter-category").on("change", function() {
		var pieData = [];
		if($(this).val() == "") {
			$('.list-category').show();
		} else {
			$('.list-category').hide();
			$(".category-"+$(this).val()).show();
			$(".category-"+$(this).val()+ " li").each(function() {
				pieData.push({ value: $(this).data("amount"),
								label: $(this).data("name")
							});
			});
			generatePieChart(pieData);
		}
	});
});