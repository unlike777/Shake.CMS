function window_resize() {

	var $window = $(window),
		$body = $('body');

	window.ww = $window.width();
	window.wh = $window.height();

	/* adaptive classes */
//	ww <= 1900 ? $body.addClass('w1900') : $body.removeClass('w1900');
//	
//	wh <= 800 ? $body.addClass('h800') : $body.removeClass('h800');
	/*___________________*/
	
	$('.content').css({minHeight: wh - parseInt($body.css('padding-top'), 10)});
	
}

$(window).resize(function() {
	window_resize();
});