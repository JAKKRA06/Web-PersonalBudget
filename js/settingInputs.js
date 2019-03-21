$(function() {

	$('#inputLimit').hide();
	$('#inputName').hide();

	$('#zaznaczLimit').on('click', function() {
		$('#inputLimit').slideToggle(300);
	});
	$('#zaznaczName').on('click', function() {
		$('#inputName').slideToggle(300);
	});

});
