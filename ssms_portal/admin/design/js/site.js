$(document).ready(function () {
	(function ($) {
		$.fn.hasScrollBar = function () {
			return this.get(0).scrollHeight > this.get(0).clientHeight;
		}
	})(jQuery);

	//========> Search Open & Close Functions  <========//
	$('#search-open').click(function (e) {
		e.preventDefault();

		$('.search-wrapper').slideDown('slow');
		$(this).hide('slow');
		$('#body').css({
			'margin-top': '125px',
			'transition': 'margin-top 1s ease 0.5s'
		});
		$('.main-nav').css({
			'top': '54px',
			'transition': 'top 1s ease 0.5s'
		});

		$('#search-input').focus();
	});

	$('#search-close').click(function (e) {
		e.preventDefault();

		$('#body').css({
			'margin-top': '70px',
			'transition': 'margin-top 1s ease 0.5s'
		});
		$('.main-nav').css({
			top: '0px',
			transition: 'top 1s ease 0.5s'
		});
		$('.search-wrapper').slideUp('slow');
		$('#search-open').show();
	});

	// Function to automatically position the Footer
	function dynamicFooter() {
		// var body_height = $(body).height();
		//
		// if (body_height < 564) {
		// 	$('.footer').css({
		// 		'position': 'fixed',
		// 		'bottom': '0',
		// 		'right': '0',
		// 		'left': '0'
		// 	});
		//
		// } else {
		// 	$('.footer').css({
		// 		'position': 'relative',
		// 		'z-index': '1500'
		// 	});
		// }
		if ($('html').hasScrollBar()) {
			console.log('true');
			$('.footer').css({
				'position': 'relative',
				'z-index': '1500'
			});

		} else {
			console.log('false');
			$('.footer').css({
				'position': 'fixed',
				'bottom': '0',
				'right': '0',
				'left': '0'
			});
		}
	}

	$(window).resize(function () {
		dynamicFooter();
	});

	dynamicFooter();
});
