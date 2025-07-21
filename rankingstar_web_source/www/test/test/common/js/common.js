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

$(window).on('scroll', function () {
	var sc = $('html').scrollTop() || $('body').scrollTop();
	var wW = $(window).width();
	if (wW < 1000 || !$('#wrap').hasClass('sub')) {
		return false;
	}
	if (sc > 0 && !$('.header').hasClass('scroll')) {
		$('.header').addClass('scroll');
	} else if (sc < 1 && $('.header').hasClass('scroll')) {
		$('.header').removeClass('scroll');
	}
});

