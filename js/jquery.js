$(function() {
	$('#kwota').on('blur', function() {
		var expense_amount = $('#kwota').val();
		var expense_category_select = $('.custom-select').val();

		var dane = "expense_amount=" + expense_amount + "&expense_category_select=" + expense_category_select;

		$.post('classes/Ajax.php', dane, function(data) {
			$('#infoLimit').html(data).hide().fadeIn(800);
		});


	});		

	$('.custom-select').change(function() {
			var expense_amount = $('#kwota').val();
			var expense_category_select = $('.custom-select').val();

			var dane = "expense_amount=" + expense_amount + "&expense_category_select=" + expense_category_select;

			$.post('classes/Ajax.php', dane, function(data) {
				$('#infoLimit').html(data).hide().fadeIn(800);
		});

	});
});