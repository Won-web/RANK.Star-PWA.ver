$('.mo_btn.open').on('click', function () {
	if (!$('.header').hasClass('curr')) {
		$('.header').addClass('curr');
	}
});
$('.mo_btn.close').on('click', function () {
	if ($('.header').hasClass('curr')) {
		$('.header').removeClass('curr');
	}
});