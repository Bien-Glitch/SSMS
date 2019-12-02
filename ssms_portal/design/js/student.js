$(document).ready(function () {
	let requested = false,
		reg_err = '.regerr',
		mess_tag = $('#mess'),
		mess = mess_tag.html(),
		valid_text = $('.valid-text'),
		reg_form = $('#register-form'),
		med_con_yes = $('#med_con_yes'),
		med_con_no = $('#med_con_no'),
		med_det = $('#med_det'),
		btn_clear = $('#clear'),
		valid_text_html = valid_text.html(),
		currentURL = window.location.href;

	function clearText() {
		valid_text.html(valid_text_html).fadeOut();
	}

	// Function to check if am element is hovered upon
	jQuery.fn.mouseIsOver = function () {
		return $(this[0]).is(':hover')
	};

	function clearInputs() {
		let inputs = $('form input, form select, form textarea'), i;

		for (i = 0; i < inputs.length; i++) {
			$(inputs).val('');
		}
	}

	function hideMessage() {
		mess_tag.mouseenter(function (e) {
			e.preventDefault();
			$('.remove', this).click(function (e) {
				e.preventDefault();
				$(this).fadeOut();
			});

			$('.continue', this).click(function (e) {
				e.preventDefault();
				if ($('kbd', this).mouseIsOver() === true) {
					copyToClipboard('kbd', this);

				} else {
					$(this).fadeOut();
				}
			});
		});
	}

	function copyToClipboard(element) {
		var temp = $('<input>');
		$('#body').append(temp);
		temp.val($(element).text()).select();
		document.execCommand('copy');
		temp.remove();
		alert('Copied!!!');
	}

	function selectLGA(form) {
		let lga = $('#lga_sel'),
			state_id = $(form).children(':selected').attr('id');
		// $(this.options[this.selectedIndex]).attr('id');

		$.post('./include/lga.php?state_id=' + state_id, function (data) {
			lga.html(data);
			lga.removeAttr('disabled');
		});
	}

	function urlAction() {
		let get_action = window.location.search,
			action = 'empty';

		if (get_action !== '') {
			action = get_action.split('=');
			action = action[1];
		}

		return action;
	}

	function med_detChange(act, dis, el) {
		act.click(function () {
			if (act.prop('checked') === true) {
				el.prop('disabled', '');
				$('.med_req').prop('hidden', '');
			}
		});

		dis.click(function () {
			if (dis.prop('checked') === true) {
				el.prop('disabled', 'disabled');
				$('.med_req').prop('hidden', 'hidden');
			}
		});
	}

	function validation() {
		$('.form-group').each(function () {
			let selected = this;

			function removeValidText(selected) {
				$('.valid-text', selected).fadeOut();
				$('.valid-text > div', selected)
					.html('<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>')
					.prepend('<small><i class="fa fa-exclamation-triangle"></i> This Field is required!!!</small>');
			}

			function addValidText(selected) {
				if ($('.valid-text > div', selected).html().length < 48) {
					$('.valid-text > div', selected).prepend('<small><i class="fa fa-exclamation-triangle"></i> This Field is required!!!</small>');
					$('.valid-text', selected).fadeIn();

				} else {
					$('.valid-text', selected).fadeIn();
				}
			}

			$('.valid-text > div > span', this).click(function (e) {
				e.preventDefault();
				$('input, select, textarea', selected).removeClass('regerr');
				removeValidText(selected);
			});


			$('input', this).keyup(function () {
				if ($(this).val().length > 0) {
					$(this).removeClass('regerr');
					removeValidText(selected);

				} else {
					$(this).addClass('regerr');
					addValidText(selected);
				}
			});

			$('select', this).change(function () {
				$(this).removeClass('regerr');
				removeValidText(selected);
			});
		});
	}

	function studentLogin(form) {
		let action = $(form).attr('action');
		mess_tag.html(mess);
		mess_tag.fadeIn();

		if (requested) {
			return;
		}
		requested = true;

		$(form).ajaxSubmit({
			method: 'POST',
			url: action,
			data: {action: 'login'},
			dataType: 'json',
			success: function (response) {
				clearText();
				if (response.data.status === '200') {
					mess_tag.html(response.data.login.data.message);
					if (response.data.login.data.status === '200') {
						setTimeout(function () {
							document.location.reload();
						}, 3800);
					}

				} else if (response.data.status === '300') {
					mess_tag.html(response.data.message);
				}
				validation();
				hideMessage();
			}
		});
		requested = false;
	}

	function studentRegister(form) {
		let action = $(form).attr('action');
		mess_tag.html(mess);
		mess_tag.fadeIn();

		if (requested) {
			return;
		}
		requested = true;

		$(form).ajaxSubmit({
			url: action,
			method: 'POST',
			data: {action: 'register'},
			dataType: 'json',
			success: function (response) {
				clearText();
				if (response.data.status === '200') {
					mess_tag.html(response.data.register.data.message);
					// if (response.data.login.data.status === '200') {
					// 	setTimeout(function () {
					// 		document.location.reload();
					// 	}, 3800);
					// }

				} else if (response.data.status === '300') {
					mess_tag.html(response.data.message);
				}
				validation();
				hideMessage();
			}
		});
		requested = false;
	}

	$('#state_sel').change(function (e) {
		e.preventDefault();
		selectLGA(this)
	});
	reg_form.submit(function (e) {
		e.preventDefault();
		studentRegister(this);
	});

	btn_clear.click(function (e) {
		e.preventDefault();
		clearInputs();
	});

	$('#login-form').submit(function (e) {
		e.preventDefault();
		studentLogin(this);
	});

	med_detChange(med_con_yes, med_con_no, med_det);
});