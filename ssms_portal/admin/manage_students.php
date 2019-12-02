<?php include_once './include/header.php'; ?>

<?php
if (!$user) {
	echo '<script>window.location = "./error/op_error_401";</script>';
	exit();
}

if (isset($_GET) && !empty($_GET['q'])) {
	$action = $_GET['q'];

} else {
	$action = NULL;
}
?>
	<style>
		.display {
			font-size: 11px;
		}

		#view-overlay {
			background-color: rgba(0, 0, 0, 0.98) !important;
		}

		#view-all-overlay {
			z-index: 2500;
		}

		.edit-wrapper {
			position: absolute;
			min-width: 60%;
			z-index: 2400;
			left: 20%;
			top: 2%;
		}

		.display .spinner {
			position: fixed;
			top: 40%;
			left: 0%;
			right: 0%;
			text-align: center;
			display: block;
			z-index: 3000;
		}

		@media screen and (max-width: 768px) {
			.edit-wrapper {
				min-width: 94%;
				left: 0;
				right: 0;
			}
		}

		@media (max-width: 600px) {
			.student-details * {
				font-size: 10px !important;
			}

			.stu_pic > img {
				height: 80px !important;
				width: 80px !important;
			}
		}

		@media (min-width: 768px) {
			.student-details .d-flex > span {
				min-width: 80%;
			}
		}

		@media screen and (min-width: 996px) {
			.edit-wrapper .image > div {
				min-width: 60%
			}
		}

		@media (min-width: 1300px) {
			.student-details .d-flex > span {
				min-width: 50%;
			}
		}
	</style>

	<div id="body" data-action="<?php echo $action; ?>" data-query="DESC" class="container-fluid manage-page mb-2">
		<div class="overlay" id="manage-overlay"></div>
		<div class="overlay" id="view-overlay"></div>
		<div id="resp-mess" class="alert alert-info m-0" style="display: none"></div>
		<div class="row">
			<div class="col p-0 display">
				<div class="spinner">
					<img src="./design/imgs/805.svg" alt="" class="img img-fluid" style="">
				</div>
			</div>
			<div class="edit-wrapper" style="display: none"></div>
		</div>
	</div>

	<script>
		$(document).ready(function () {
			let page = $('div.manage-page'),
				page_action = page.data('action'),
				query = page.data('query'),
				display_tag = $('.display'),
				// mess_tag = $('#mess'),
				// mess = mess_tag.html(),
				// valid_text = $('.valid-text'),
				// valid_text_html = valid_text.html(),
				requested = false;

			// Function to check if am element is hovered upon
			jQuery.fn.mouseIsOver = function () {
				return $(this[0]).is(':hover');
			};

			// Function to automatically position the Footer
			function dynamicFooter() {
				let body_height = $(body).height();

				if (body_height < 564) {
					$('.footer').css({
						'position': 'fixed',
						'bottom': '0',
						'right': '0',
						'left': '0'
					});

				} else {
					$('.footer').css({
						'position': 'relative',
						'z-index': '1500'
					});
				}
			}

			function clearInputs(form) {
				let inputs = $(form + ' input, ' + form + ' select, ' + form + ' textarea'), i;

				for (i = 0; i < inputs.length; i++) {
					$(inputs).val('');
				}
			}

			function selectLGA(form) {
				let lga = $('#lga_sel'),
					state_id = $(form).children(':selected').attr('id');

				$.post('./include/lga.php?state_id=' + state_id, function (data) {
					lga.html(data);
					lga.removeAttr('disabled');
				});
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

			function clearText() {
				let valid_text = $('.valid-text'),
					valid_text_html = valid_text.html();

				valid_text.html(valid_text_html).fadeOut();
			}

			function hideMessage() {
				let mess_tag = $('#mess'),
					pic_mess_tag = $('#pic-mess');

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
							copyToClipboard('kbd', this);

						} else {
							$(this).fadeOut();
							dynamicFooter();
						}
					});
				});

				pic_mess_tag.mouseenter(function (e) {
					e.preventDefault();
					$('.remove', this).click(function (e) {
						e.preventDefault();
						$(this).fadeOut();
						dynamicFooter();
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

			function manage(c, q, action, getType) {
				if (requested) {
					return;
				}
				requested = true;

				$.ajax({
					method: 'POST',
					url: './include/classes/manage.php',
					data: {
						action: action,
						column: c,
						query: q,
						type: getType
					},
					dataType: 'json',
					success: function (response) {
						if (action === 'view_students') {
							let row = response.data.students.data.row,
								students_info = response.data.students.data.info,
								students_infoHTML = '';

							$('#manage-overlay').fadeOut(1000);
							display_tag.html(row);
							$.each(students_info, function (index, value) {
								students_infoHTML += value;
							});
							$('.detail-pane').html(students_infoHTML);

							$('.student-details-card').each(function (idx, val) {
								let card = this;

								$('.view-other-details', card).click(function () {
									$('.other-details', card).animate({
										'height': 'toggle',
										'padding-top': 'toggle'
									}, 500);
									// $('#view-overlay').animate({
									// 	'height': 'toggle'
									// }, 1000);

									if ($(card).css('position') === 'static') {
										$(card).css('position', 'absolute');
										$('#view-overlay').fadeIn(1000);

									} else {
										$(card).css('position', 'static');
										$('#view-overlay').fadeOut(1000);
									}

									$(card).css({
										'z-index': '2300',
										'right': '15px',
										'left': '15px'
									});
								});
							});
						}

						if (action === 'manage_students') {
							let table = response.data.students.data.table,
								students_info = response.data.students.data.info,
								students_infoHTML = '';

							$('#manage-overlay').fadeOut(1000);
							display_tag.html(table);
							$.each(students_info, function (index, value) {
								students_infoHTML += value;
							});
							$('.detail-pane').html(students_infoHTML);

							$('th.j-link').each(function (index, value) {
								if (response.data.type) {
									if (response.data.type === 'fresh') {
										localStorage.removeItem(value.id);
									}
								}
								$(this).attr('title', 'Click to change order: Ascending or Descending');
								$(this).click(function () {
									let text = $(this).text(),
										column_name = $(this).attr('id'),
										query = localStorage.getItem(column_name);

									if (query === 'ASC' || query === '') {
										query = 'DESC';
										resp_text = 'Descending';

									} else {
										query = 'ASC';
										resp_text = 'Ascending';
									}

									$('#resp-mess').html('<small>Order Students by ' + text + ': ' + resp_text + '</small>').slideDown(800);
									localStorage.setItem(value.id, query);
									manage(column_name, query, page_action, 'refresh');
								});
							});

							$('.receipts').each(function (index, value) {
								$(this).click(function (e) {
									e.preventDefault();
									let adm_no = value.dataset.id;
									studentPayments('.edit-wrapper', adm_no);
								});
							});

							$('.edit').each(function (index, value) {
								$(this).click(function (e) {
									e.preventDefault();
									let adm_no = value.dataset.id;
									editStudentForm('.edit-wrapper', adm_no);
								});
							});

							$('.delete').each(function (index, value) {
								$(this).click(function (e) {
									e.preventDefault();
									let adm_no = value.dataset.id;
									deleteStudent(adm_no);
								});
							});
						}
					}
				});
				requested = false;
			}

			function deleteStudent(adm_id) {

				if (confirm('Are you sure you want to delete Student with admission number: ' + adm_id + '.\r\nThis action will remove all of students data and cannot be undone!!!')) {
					$.ajax({
						method: 'POST',
						url: './include/classes/manage.php',
						data: {
							action: 'delete-student',
							admno: adm_id
						},
						dataType: 'json',
						success: function (response) {
							if (response.data.status === '200') {
								alert(response.data.delete_stu.data.message);
								manage('adm_id', 'ASC', page_action, 'refresh');

							} else if (response.data.status === '300') {
								alert(response.data.message);
							}
						}
					});

				} else {
					alert('Delete Operation Cancelled!!!');
				}
			}

			function updateStudentPassport(form, element, adm_id, daction, mess_tag, mess) {
				let action = $(form).attr('action'),
					file_element = document.getElementById('passport');

				if ('files' in file_element) {
					$(form).submit(function (e) {
						e.preventDefault();
						if (requested) {
							return;
						}
						requested = true;
						mess_tag.html(mess);
						mess_tag.fadeIn();

						$(form).ajaxSubmit({
							method: 'POST',
							url: action,
							data: {
								action: daction,
								admno: adm_id
							},
							dataType: 'JSON',
							success: function (response) {
								clearText();
								if (response.data.status === '200') {
									mess_tag.html(response.data.passport_update.data.message);
									if (response.data.passport_update.data.status === '200') {
										setTimeout(function () {
											editStudentForm(element, adm_id);
										}, 1800);
									}

								} else if (response.data.status === '300') {
									mess_tag.html(response.data.message);
								}
								hideMessage();
								validation();
							}
						});
						requested = false;
					});
					$(form + ' #submit').trigger('click');

				}
			}

			function updateStudentInfo(form, element, adm_id, daction, mess_tag, mess) {
				let action = $(form).attr('action');

				if (requested) {
					return;
				}
				requested = true;
				mess_tag.html(mess);
				mess_tag.fadeIn();

				$(form).ajaxSubmit({
					url: action,
					method: 'POST',
					data: {
						action: daction,
						id: adm_id
					},
					dataType: 'json',
					success: function (response) {
						clearText();
						if (daction === 'update-parent-table') {
							if (response.data.status === '200') {
								mess_tag.html(response.data.parent.data.message);
								if (response.data.parent.data.status === '200') {
									setTimeout(function () {
										editStudentForm(element, adm_id);
									}, 2800);
								}

							} else if (response.data.status === '300') {
								mess_tag.html(response.data.message);
							}
						}

						if (daction === 'update-student-table') {
							if (response.data.status === '200') {
								mess_tag.html(response.data.student.data.message);
								if (response.data.student.data.status === '200') {
									setTimeout(function () {
										editStudentForm(element, adm_id);
									}, 2800);
								}

							} else if (response.data.status === '300') {
								mess_tag.html(response.data.message);
							}
						}
						hideMessage();
						validation();
					}
				});
				requested = false;
			}

			function loadSchoolSessionsAndTerms() {
				$.post('./include/school_session_term.php', {action: 'get-sessions'}, function (response) {
					let term = $('#term'),
						amount = $('#amount_inp'),
						session = $('#session'),
						receiptno = $('#receiptno');

					session.append(response);
					session.change(function () {
						if (term.attr('disabled')) {
							term.removeAttr('disabled');
							term.children(':selected').text('Select Term...');
						}
					});

					$.post('./include/school_session_term.php', {action: 'get-terms'}, function (response) {
						term.append(response);
						term.change(function () {
							if ((amount.attr('disabled')) && (receiptno.attr('disabled'))) {
								amount.removeAttr('disabled');
								receiptno.removeAttr('disabled');

								amount.attr('placeholder', 'Input Amount');
								receiptno.attr('placeholder', 'Input Receipt Number');
							}
						});
					});
				});
			}

			function deletePayment(element, adm_id, session, term) {

				if (confirm('Are you sure you want to delete Payment receipts for selected Session and term ?.\r\nThis action will remove all payment receipts for the session and term and cannot be undone!!!')) {
					$.ajax({
						method: 'POST',
						url: './include/classes/manage.php',
						data: {
							action: 'delete-payment',
							admno: adm_id,
							session: session,
							term: term
						},
						dataType: 'json',
						success: function (response) {
							if (response.data.status === '200') {
								alert(response.data.delete_payment.data.message);
								studentPayments(element, adm_id);

							} else if (response.data.status === '300') {
								alert(response.data.message);
							}
						}
					});

				} else {
					alert('Delete Operation Cancelled!!!');
				}
			}

			function viewPaymentDetails(element, adm_id, session, term) {
				if (requested) {
					return;
				}

				$.ajax({
					url: './include/classes/manage.php',
					method: 'POST',
					data: {
						action: 'get-payment-details',
						admno: adm_id,
						session: session,
						term: term
					},
					dataType: 'json',
					success: function (response) {
						let payment_info = response.data.stu_payment_details.data.payments,
							owing_message = response.data.stu_payment_details.data.p_c_message,
							owing_status = response.data.stu_payment_details.data.p_c_status,
							owing_amount = response.data.stu_payment_details.data.p_c_owing,
							infoHTML = '';

						$('#view-all-overlay').fadeIn(function () {
							$.each(payment_info, function (index, value) {

								let new_amount = accounting.formatMoney(value.amount, '&#x20A6;', 0),
									session = '',
									term = '';

								if (value.current_session === '*' && value.current_term === '*') {
									session = value.session + ' <span class="w3-text-black">*</span>';
									term = value.term + ' <span class="w3-text-black">*</span>';

								} else {
									session = value.session;
									term = value.term;
								}

								infoHTML += '\n\
									<div style="line-height: 1pc">\n\
										<div><span style="font-size: 14px">Session:</span> <span style="font-size: 12px">' + session + '</span></div>\n\
										<div><span style="font-size: 14px">Term:</span> <span style="font-size: 12px">' + term + '</span></div>\n\
										<div><span style="font-size: 14px">Amount:</span> <span style="font-size: 12px">' + new_amount + '</span></div>\n\
										<div><span style="font-size: 14px">Receipt No:</span> <span style="font-size: 12px">' + value.receipt_no + '</span></div>\n\
									</div>\n\
									<hr />\n\
								';
							});
							$('#display-all-payments').html(infoHTML);
							$(element).fadeIn();
							$(element + ' .card-heading .close-all-payments').click(function (e) {
								e.preventDefault();
								$(element).fadeOut(1200, function () {
									$('#view-all-overlay').fadeOut(500);
								});
							});
						});
					}
				});
				requested = false;
			}

			function studentPayments(element, adm_id) {
				if (requested) {
					return;
				}

				$.ajax({
					url: './include/classes/manage.php',
					method: 'POST',
					data: {
						action: 'get-student-payments',
						admno: adm_id
					},
					dataType: 'json',
					success: function (response) {
						let payment_info = response.data.stu_payments.data.payments,
							owing_message = response.data.stu_payments.data.p_c_message,
							owing_status = response.data.stu_payments.data.p_c_status,
							owing_amount = response.data.stu_payments.data.p_c_owing,
							result_pin = response.data.stu_payments.data.pin,
							o_amount = '',
							infoHTML = '';

						$(element).load('./include/template/stu_payments.php', function () {
							let mess_tag = $('#mess'),
								mess = mess_tag.html(),
								valid_text = $('.valid-text'),
								valid_text_html = valid_text.html();

							if (response.data.stu_payments.data.status === '200') {
								$.each(payment_info, function (index, value) {

									let new_amount = accounting.formatMoney(value.amount, '&#x20A6;', 0),
										o_status = (owing_status[index]),
										o_message = (owing_message[index]),
										display_pin = (result_pin[index]),
										session = '',
										d_pin = '',
										term = '';

									if (o_status === '400') {
										o_amount = accounting.formatMoney(owing_amount[index], '&#x20A6;', 0);

									} else {
										o_amount = '';
									}

									if (value.current_session === '*' && value.current_term === '*') {
										session = value.session + ' <span class="w3-text-black">*</span>';
										term = value.term + ' <span class="w3-text-black">*</span>';

									} else {
										session = value.session;
										term = value.term;
									}

									if (display_pin !== null) {
										d_pin = '\n\
											<div><span style="font-size: 14px">Result Pin:</span> <span style="font-size: 12px">' + display_pin + '</span></div>\n\
										';

									} else {
										d_pin = '\n\
											<div><span style="font-size: 14px">Result Pin:</span> <span style="font-size: 12px">Complete payment first</span></div>\n\
										';
									}

									infoHTML += '\n\
										<div style="line-height: 1pc">\n\
											<div><span style="font-size: 14px">Session:</span> <span style="font-size: 12px">' + session + '</span></div>\n\
											<div><span style="font-size: 14px">Term:</span> <span style="font-size: 12px">' + term + '</span></div>\n\
											<div><span style="font-size: 14px">Amount:</span> <span style="font-size: 12px">' + new_amount + '</span></div>\n\
											<div><span style="font-size: 14px">Status:</span> <span style="font-size: 12px">' + o_amount + ' ' + o_message + '</span></div>\n\
											<div><span style="font-size: 14px">Receipt No:</span> <span style="font-size: 12px">' + value.receipt_no + '</span></div>\n\
											' + d_pin + '\n\
											<a href="" data-adm-id="' + adm_id + '" data-session="' + value[2] + '" data-term="' + value[3] + '" style="font-size: 12px" class="text-danger mr-1 delete-payment" \
											title="Delete">\n\
												<i class="fa fa-trash-alt"></i> Delete\n\
											</a>\n\
											\n\
											<a href="" data-adm-id="' + adm_id + '" data-session="' + value[2] + '" data-term="' + value[3] + '" style="font-size: 12px" class="text-info mr-1 view-payment-detail" title="View detailed info">\n\
												<i class="fa fa-file-invoice"></i> Detailed View\n\
											</a>\n\
										</div>\n\
										<hr />\n\
									';
								});

								$('.display-payment #payments').html(infoHTML);

							} else if (response.data.stu_payments.data.status === '300') {
								$('.display-payment #payments').html('No Payment has been recorded yet!!!');
							}

							$('#manage-overlay').fadeIn(function () {
								$(element).fadeIn(1000);
								$(element + ' .card-heading .close').click(function (e) {
									e.preventDefault();
									$(element).fadeOut(1200, function () {
										$('#manage-overlay').fadeOut(500);
									});
								});

								$(element + ' .card-heading .refresh').click(function (e) {
									e.preventDefault();
									studentPayments(element, adm_id);
								});

								$(element + ' .delete-payment').each(function (idx, val) {
									$(this).click(function (e) {
										e.preventDefault();
										let adm_id = val.dataset.admId,
											session = val.dataset.session,
											term = val.dataset.term;

										deletePayment(element, adm_id, session, term);
									})
								});

								$(element + ' .view-payment-detail').each(function (idx, val) {
									$(this).click(function (e) {
										e.preventDefault();
										let adm_id = val.dataset.admId,
											session = val.dataset.session,
											term = val.dataset.term;

										viewPaymentDetails('#all-payments', adm_id, session, term);
									})
								})
							});

							$('#receipt-toggle').click(function (e) {
								e.preventDefault();
								let card = $('.w3-card'),
									card_height = card.height(),
									screen_height = screen.height,
									receipt_form = $('#receipt-number-form');

								if (receipt_form.css('display') === 'none') {
									card.css({
										'min-height': 'calc(' + screen_height + 'px - 100px)'
									});

									card_height = card.height();
									$('.w3-card #payments').css({
										'max-height': 'calc(' + card_height + 'px - 440px)'
									});

								} else {
									card.css({
										'min-height': '',
										'max-height': 'calc(' + screen_height + 'px - 100px)'
									});

									$('.w3-card #payments').css({
										'max-height': 'calc(' + card_height + 'px - 292px)'
									});
								}

								receipt_form.animate({
									'height': 'toggle',
									'padding-top': 'toggle'
								});
								$('.caret').animate({
									'height': 'toggle'
								}, 0);
							});

							$('#payments-toggle').click(function (e) {
								e.preventDefault();
								$('#payments').animate({
									'height': 'toggle',
									'padding-top': 'toggle'
								});
								$('.pay-caret').animate({
									'height': 'toggle'
								}, 0);
							});

							$('#receipt-number-form').submit(function (e) {
								e.preventDefault();
								generatePayment(this, adm_id, mess_tag, mess, valid_text_html, valid_text);
							});
							loadSchoolSessionsAndTerms();
						});
					}
				});
				requested = false;
			}

			function generatePayment(form, adm_id, mess_tag, mess, valid_text_html, valid_text) {
				let action = $(form).attr('action'),
					new_amount = accounting.unformat($('#amount_inp').val());

				if (requested) {
					return;
				}

				mess_tag.html(mess);
				mess_tag.fadeIn();

				$(form).ajaxSubmit({
					url: action,
					method: 'POST',
					data: {
						action: 'add-payment-info',
						admno: adm_id,
						amount: new_amount
					},
					dataType: 'json',
					success: function (response) {
						valid_text.html(valid_text_html).fadeOut();
						if (response.data.status === '200') {
							mess_tag.html(response.data.add_payment.data.message);

							if (response.data.add_payment.data.status === '200') {
								if (response.data.add_payment.data.token === '') {
									setTimeout(function () {
										studentPayments('.edit-wrapper', adm_id);
									}, 3800);
								}
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

			function editStudentForm(element, adm_id) {
				$.ajax({
					url: './include/classes/manage.php',
					method: 'POST',
					data: {
						action: 'get-student-info',
						admno: adm_id
					},
					dataType: 'json',
					success: function (response) {
						let info = response.data.stu_info.data.info;

						$(element).load('./include/template/stu_edit_form.php', function () {
							let mess_tag = $('#mess'),
								mess = mess_tag.html(),
								pic_mess_tag = $('#pic-mess'),
								pic_mess = pic_mess_tag.html(),
								med_con_yes = $('#med_con_yes'),
								med_con_no = $('#med_con_no'),
								med_det = $('#med_det');

							$(element + ' img').attr('src', '../' + info.passport);

							$(element + ' #fname').val(info.fname);
							$(element + ' #lname').val(info.lname);
							$(element + ' #mname').val(info.mname);

							$(element + ' #admno').val(info.adm_id);
							$(element + ' #class option[value=' + info.class_id + ']').prop('selected', 'selected');
							$(element + ' #religion option[value=' + info.religion + ']').prop('selected', 'selected');

							$(element + ' #state_sel option[value=\"' + info.sor + '\"]').prop('selected', 'selected');
							$(element + ' #lga_sel option[value=""]').val(info.lga).text(info.lga);

							$(element + ' #dob').val(info.dob);
							$(element + ' #gender option[value=' + info.gender + ']').prop('selected', 'selected');

							$(element + ' #phone').val(info.pnum);
							$('input[name="med_con"]').each(function (idx, val) {
								if (val.value === info.med_con) {
									$(val, this).prop('checked', 'checked');
								}
							});

							$(element + ' #raddress').val(info.r_address);
							if (info.med_con === 'no') {
								$(element + ' #med_det').prop('disabled', 'true');

							} else if (info.med_con === 'yes') {
								$(element + ' #med_det').val(info.med_con_det);
							}

							$(element + ' #p_g_name').val(info.name);
							$(element + ' #p_g_phone').val(info.phone);
							$(element + ' #p_g_occ').val(info.occupation);
							$(element + ' #p_g_raddress').val(info.address);

							$('#manage-overlay').fadeIn(function () {
								$(element).fadeIn(1000);
								$(element + ' .card-heading > a').click(function (e) {
									e.preventDefault();
									manage('adm_id', 'ASC', page_action, 'refresh');
									$(element).fadeOut(1200, function () {
										$('#manage-overlay').fadeOut(500);
									});
								});
							});

							$('#state_sel').change(function (e) {
								e.preventDefault();
								selectLGA(this);
							});

							$('.clear').click(function (e) {
								e.preventDefault();
								let form = $(this).data('form');
								clearInputs('#' + form);
							});

							$('.reset').click(function (e) {
								e.preventDefault();
								editStudentForm(element, adm_id);
							});

							$('#passport').change(function (e) {
								e.preventDefault();
								let form = $(this).data('form');

								if ($(this).val() !== '') {
									updateStudentPassport('#' + form, element, adm_id, 'update-passport', pic_mess_tag, pic_mess);
								}
							});

							$('#edit-student-form').submit(function (e) {
								e.preventDefault();
								updateStudentInfo(this, element, adm_id, 'update-student-table', mess_tag, mess);
							});

							$('#edit-parent-form').submit(function (e) {
								e.preventDefault();
								updateStudentInfo(this, element, adm_id, 'update-parent-table', mess_tag, mess);
							});

							med_detChange(med_con_yes, med_con_no, med_det);
						});
					}
				});
			}

			// $.ajax({
			// 	url: './include/classes/manage.php',
			// 	method: 'POST',
			// 	data: {
			// 		action: 'get-payment-sum'
			// 	},
			// 	dataType: 'json',
			// 	success: function (response) {
			// 		console.log(response.data);
			// 	}
			// });

			manage('adm_id', 'ASC', page_action, 'fresh');
		});
	</script>

<?php include './include/footer.php'; ?>