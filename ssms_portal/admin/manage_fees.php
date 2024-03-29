<?php include './include/header.php'; ?>
	<style>
		.edit-wrapper {
			position: absolute;
			min-width: 60%;
			z-index: 2400;
			left: 20%;
			top: 2%;
		}

		@media screen and (max-width: 768px) {
			.edit-wrapper {
				min-width: 94%;
				left: 0;
				right: 0;
			}
		}
	</style>
	<div id="body" data-action="<?php echo $action; ?>" data-query="DESC" class="container-fluid manage-page mb-5">
		<div class="overlay" id="fees-overlay"></div>
		<div class="row">
			<div class="edit-wrapper" style="display: none"></div>
			<div class="col-md-9 s-border-top s-md-border-top-none s-md-border-right">
				<div class="manage-fees my-2">
					<div class="p-2 w3-black"><i class="fad fa-money-check"></i> Manage School Fees</div>
					<span class="w3-large">Available Fees Scheme</span>
					<div id="resp-mess-term" class="alert alert-info m-0 resp-mess" style="display: none"></div>
					<table class="table table-hover table-striped table-borderless table-sm table-light fees-table">
						<thead class="thead-dark">
						<tr>
							<th class="j-link" id="id">#</th>
							<th class="j-link" id="class">Class</th>
							<th class="j-link" id="session">Session</th>
							<th class="j-link" id="term">Term</th>
							<th class="j-link" id="amount">Amount</th>
							<th><i class="fa fa-pencil mx-1"></i> Edit</th>
						</tr>
						</thead>
						<tbody id="fees-data" style="display: ">
						<tr>
							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
						</tr>
						</tbody>
					</table>
					<hr />
				</div>
			</div>

			<div class="col-md-3 order-first order-md-0">
				<div class="j-link d-md-none p-2 w3-green" id="school-fees-toggle">
					<div class="d-flex justify-content-between align-items-center">
						<span><i class="far fa-plus-circle"></i> Add Fess Scheme</span>
						<i class="w3-text-white caret fa fa-caret-circle-down"></i>
						<i class="w3-text-white caret fa fa-caret-circle-up" style="display: none"></i>
					</div>
				</div>
				<div id="add-fees-scheme">
					<form action="./include/classes/manage.php" method="post" id="add-fees-form">
						<div class="form-group">
							<label for="class_sel">Class: </label>
							<div class="input-group">
								<i class="p-2 far fa-calendar-day"></i>
								<select name="class" id="class_sel" class="form-control form-control-sm" required>
									<option value="" selected disabled>Select Class...</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="session_sel" disabled="">Session: </label>
							<div class="input-group">
								<i class="p-2 far fa-calendar-alt"></i>
								<select name="session" id="session_sel" class="form-control form-control-sm" required disabled>
									<option value="" selected disabled>Select a class first...</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="term_sel">Term: </label>
							<div class="input-group">
								<i class="p-2 far fa-calendar-day"></i>
								<select name="term" id="term_sel" class="form-control form-control-sm" required disabled>
									<option value="" selected disabled>Select a session first...</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="amount_inp">Amount: </label>
							<div class="input-group">
								<i class="p-2 far fa-money-bill-alt"></i>
								<span class="form-control form-control-sm w3-light-grey" style="max-width: 30px">&#x20A6;</span>
								<input name="amount" id="amount_inp" class="form-control form-control-sm" placeholder="Select Class, Session and Term first..." required disabled />
							</div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-success btn-sm my-md-0 my-1"><i class="far fa-plus-circle"></i> Add Fees Scheme</button>
						</div>
						<div id="mess" style="display:none">
							<span class="text-info"><i class="text-danger fa fa-exclamation"></i> Please wait...</span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function () {
			let requested = false,
				fees_form_id = '#add-fees-form';

			function clearText(valid_text, valid_text_html) {
				valid_text.html(valid_text_html).fadeOut();
			}

			function clearInputs(form) {
				let inputs = $(form + ' input, ' + form + ' select, ' + form + ' textarea'),
					i;

				for (i = 0; i < inputs.length; i++) {
					$(inputs).val('');
				}
			}

			function formatAmountInput() {
				let amount_inp = $('#amount_inp');
				$(amount_inp).blur(function () {
					let val = $(this).val();
					if (val !== '') {
						let amount = $(this).val(),
							new_amount = accounting.formatNumber(amount);

						$(this).val(new_amount, '');
						val = $(this).val();
						if (val === '0') {
							alert('Please input an amount!!!');
						}
					}
				});
			}

			// Function to automatically position the Footer
			function dynamicFooter() {
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

			function toggleVisibility() {
				let body_width = $(body).width(),
					fess_tag = $('#add-fees-scheme');

				if ($('.caret')[1].style.display !== 'none') {
					fess_tag.css('display', 'block');
				}

				if (body_width > '735') {
					if (fess_tag.css('display') === 'none') {
						fess_tag.css('display', 'block')
					}
				}

				if (body_width < '735') {
					if ($('.caret')[1].style.display !== 'none') {
						fess_tag.css('display', 'block');

					} else if (fess_tag.css('display') === 'block') {
						fess_tag.css('display', 'none')
					}
				}
			}

			function hideMessage() {
				let mess_tag = $('#mess');

				mess_tag.mouseenter(function (e) {
					e.preventDefault();
					$('.remove', this).click(function (e) {
						e.preventDefault();
						$(this).fadeOut();
						dynamicFooter();
					});

					$('.continue', this).click(function (e) {
						e.preventDefault();
						if ($('kbd', this).mouseIsOver() === true) {
							// copyToClipboard('kbd', this);

						} else {
							$(this).fadeOut();
							dynamicFooter();
						}
					});
				});
			}

			function validation() {
				$('.form-group').each(function () {
					let selected = this;

					function removeValidText(selected) {
						$('.valid-text', selected).fadeOut();
						dynamicFooter();
						$('.valid-text > div', selected)
							.html('<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>')
							.prepend('<small><i class="fa fa-exclamation-triangle"></i> This Field is required!!!</small>');
					}

					function addValidText(selected) {
						if ($('.valid-text > div', selected).html().length < 48) {
							$('.valid-text > div', selected).prepend('<small><i class="fa fa-exclamation-triangle"></i> This Field is required!!!</small>');
							$('.valid-text', selected).fadeIn();
							dynamicFooter();

						} else {
							$('.valid-text', selected).fadeIn();
							dynamicFooter();
						}
					}

					$('.valid-text > div > span', this).click(function (e) {
						e.preventDefault();
						$('input, select, textarea', selected).removeClass('regerr');
						removeValidText(selected);
					});


					$('input, textarea', this).keyup(function () {
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

			function orderFees() {
				$('.fees-table th.j-link').each(function (index, value) {
					$(this).attr('title', 'Click to change order: Ascending or Descending');
					$(this).click(function () {
						let text = $(this).text(),
							column_name = $(this).attr('id'),
							query = localStorage.getItem(column_name);

						if (query === 'ASC' || query === '') {
							query = 'DESC';
							resp_text = 'Descending'

						} else {
							query = 'ASC';
							resp_text = 'Ascending'
						}

						$('#resp-mess-term').html('<small>Order School by ' + text + ': ' + resp_text + '</small>').slideDown(800);
						localStorage.setItem(value.id, query);
						manageFees(column_name, query, 'refresh');
						dynamicFooter()
					});
				});
			}

			function loadSchoolClassSessionsAndTerms() {
				let term = $('#term_sel'),
					amount = $('#amount_inp'),
					class_sel = $('#class_sel'),
					session = $('#session_sel');

				$.post('./include/stu_classes.php', {
					action: 'get-classes'
				}, function (response) {
					class_sel.append(response);
					class_sel.change(function () {
						if (session.attr('disabled')) {
							session.removeAttr('disabled');
							amount.attr('placeholder', 'Select a Session and a Term...');
							session.children(':selected').text('Select Session...');
						}
					});

					$.post('./include/school_session_term.php', {
						action: 'get-sessions'
					}, function (response) {
						session.append(response);
						session.change(function () {
							if (term.attr('disabled')) {
								term.removeAttr('disabled');
								amount.attr('placeholder', 'Select a Term...');
								term.children(':selected').text('Select Term...');
							}
						});

						$.post('./include/school_session_term.php', {
							action: 'get-terms'
						}, function (response) {
							term.append(response);
							term.change(function () {
								if (amount.attr('disabled')) {
									amount.removeAttr('disabled');
									amount.attr('placeholder', 'Input Amount...');
								}
							});
						});
					});
				});
			}

			function manageFees(c, q, getType) {
				let fees_body = $('#fees-data');

				if (requested) {
					return;
				}
				requested = true;

				$.ajax({
					url: './include/classes/manage.php',
					method: 'POST',
					data: {
						action: 'manage-fees',
						column: c,
						query: q
					},
					dataType: 'json',
					success: function (response) {
						let fees_info = response.data.fees.data.info,
							fees_infoHTML = '';

						if (response.data.fees.status === '200') {
							$.each(fees_info, function (index, value) {
								fees_infoHTML += value;
							});

						} else {
							fees_infoHTML = fees_info;
						}
						fees_body.fadeOut(800);
						setTimeout(function () {
							fees_body.html(fees_infoHTML).fadeIn(1000);
							let fee_tag = $('.fee-amount');

							fee_tag.each(function () {
								let amount = $(this).html(),
									new_amount = accounting.formatMoney(amount, '&#x20A6;', 0);
								$(this).html(new_amount);
							});

							$('.fees-table .edit').each(function () {
								$(this).click(function (e) {
									e.preventDefault();
									let fees_id = $(this).data('id');
									editFeesForm('.edit-wrapper', fees_id);
								});
							});
							// TODO: Delete Fees
							$('.fees-table .delete').each(function () {
								$(this).click(function (e) {
									e.preventDefault();
									let fees_id = $(this).data('id');
									// deleteSessionTerm(session, 'delete-session', 'Session');
								});
							});
							dynamicFooter();
						}, 900);

						$('.fees-table th.j-link').each(function (index, value) {
							if (getType === 'fresh') {
								localStorage.removeItem(value.id)
							}
						});
					}
				});
				requested = false
			}

			function addSchoolFeeScheme(form, action) {
				let mess_tag = $('#mess'),
					mess = mess_tag.html(),
					form_action = $(form).attr('action'),
					new_amount = accounting.unformat($('#amount_inp').val());

				mess_tag.html(mess);

				$(form).ajaxSubmit({
					url: form_action,
					method: 'POST',
					data: {
						action: action,
						amount: new_amount
					},
					dataType: 'json',
					success: function (response) {
						if (response.data.add_fees.data.status === '400') {
							if (confirm(response.data.add_fees.data.message)) {
								let fees_id = response.data.add_fees.data.id;
								editFeesForm('.edit-wrapper', fees_id);
							}
							
						} else if (response.data.add_fees.data.status !== '400') {
							mess_tag.html(response.data.add_fees.data.message);
							manageFees('school_fees.id', 'ASC', 'fresh');
						}
					}
				});
			}

			function updateFeeScheme(form, element, fees_id, action, mess_tag, mess, v_t, v_t_h) {
				let form_action = $(form).attr('action'),
					new_amount = accounting.unformat($('#amount_inp').val());

				if (requested) {
					return;
				}
				requested = true;
				mess_tag.html(mess);
				mess_tag.fadeIn();

				$(form).ajaxSubmit({
					url: form_action,
					method: 'POST',
					data: {
						action: action,
						fees_id: fees_id,
						amount: new_amount
					},
					dataType: 'json',
					success: function (response) {
						clearText(v_t, v_t_h);
						if (response.data.status === '200') {
							mess_tag.html(response.data.fee.data.message);
							if (response.data.fee.data.status === '200') {
								setTimeout(function () {
									editFeesForm(element, fees_id);
								}, 2800);
							}

						} else if (response.data.status === '300') {
							mess_tag.html(response.data.message);
						}
						hideMessage();
						validation();
					}
				});
				requested = false;
			}

			function editFeesForm(element, fees_id) {
				$.ajax({
					url: './include/classes/manage.php',
					method: 'POST',
					data: {
						action: 'get-fees-info',
						fees_id: fees_id
					},
					dataType: 'json',
					success: function (response) {
						let info = response.data.fees_info.data.info;

						$(element).load('./include/template/fees_edit_form.php', function () {
							let mess_tag = $('#mess'),
								mess = mess_tag.html(),
								valid_text = $('.valid-text'),
								valid_text_html = valid_text.html();

							loadSchoolClassSessionsAndTerms();
							setTimeout(function () {
								$.each(info, function (index, value) {
									let new_amount = accounting.formatNumber(value.amount, 0);

									$(element + ' #class_sel option[value=' + value.class_id + ']').prop('selected', 'selected');
									$(element + ' #session_sel option[value=' + value.session_id + ']').prop('selected', 'selected');
									$(element + ' #term_sel option[value=' + value.term_id + ']').prop('selected', 'selected');
									$(element + ' #amount_inp').val(new_amount);
								});
								formatAmountInput();
								$('#edit-fees-form').submit(function (e) {
									e.preventDefault();
									updateFeeScheme(this, element, fees_id, 'update-fees-scheme', mess_tag, mess, valid_text, valid_text_html);
								});
							}, 200);

							$('#fees-overlay').fadeIn(function () {
								$(element).fadeIn(800);
								$(element + ' .card-heading > a').click(function (e) {
									e.preventDefault();
									manageFees('school_fees.id', 'ASC', 'refresh');
									setTimeout(function () {
										$(element).fadeOut(1000, function () {
											$('#fees-overlay').fadeOut(500);
										});
									}, 200);
								});
							});

							$('.clear').click(function (e) {
								e.preventDefault();
								let form = $(this).data('form');
								clearInputs('#' + form);
							});

							$('.reset').click(function (e) {
								e.preventDefault();
								editFeesForm(element, fees_id);
							});
						});
					}
				});
			}

			$('#school-fees-toggle').click(function (e) {
				e.preventDefault();
				let fees_wrapper = $('#add-fees-scheme');

				fees_wrapper.animate({
					'height': 'toggle',
					'padding-top': 'toggle'
				}, 800);

				$('.caret').animate({
					'height': 'toggle'
				}, 0);
				setTimeout(function () {
					dynamicFooter();
				}, 900);
			});

			$(fees_form_id).submit(function (e) {
				e.preventDefault();
				addSchoolFeeScheme(fees_form_id, 'add-fees');
			});

			$(window).resize(function () {
				toggleVisibility();
			});

			manageFees('school_fees.id', 'ASC', 'fresh');
			loadSchoolClassSessionsAndTerms();
			formatAmountInput();
			toggleVisibility();
			orderFees();
		});
	</script>
<?php include './include/footer.php'; ?>