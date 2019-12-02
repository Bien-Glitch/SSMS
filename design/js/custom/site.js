$(document).ready(function() {
	//========> Search Open & Close Functions  <========//
	$('#search-open').click(function(e) {
		e.preventDefault();

		$('.search-wrapper').slideDown('slow');
		$(this).hide('slow');
		$('.main-nav').css({
			top: '46px',
			transition: 'top 1s ease 0.5s'
		});
		$('#search-input').focus();
	});

	$('#search-close').click(function(e) {
		e.preventDefault();

		$('.main-nav').css({
			top: '0px',
			transition: 'top 1s ease 0.5s'
		});
		$('.search-wrapper').slideUp('slow');
		$('#search-open').show();
	});
});
