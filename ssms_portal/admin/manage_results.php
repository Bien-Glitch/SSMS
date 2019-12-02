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
		<!--		<div class="row">-->
		<!--			<div class="edit-wrapper" style="display: none"></div>-->
		<!--			<div class="col-md-9 s-border-top s-md-border-top-none s-md-border-right">-->
		<!--				<div class="manage-fees my-2">-->
		<!--					<div class="p-2 w3-black"><i class="fad fa-money-check"></i> Manage School Fees</div>-->
		<!--					<span class="w3-large">Available Fees Scheme</span>-->
		<!--					<div id="resp-mess-term" class="alert alert-info m-0 resp-mess" style="display: none"></div>-->
		<!--					<table class="table table-hover table-striped table-borderless table-sm table-light fees-table">-->
		<!--						<thead class="thead-dark">-->
		<!--						<tr>-->
		<!--							<th class="j-link" id="id">#</th>-->
		<!--							<th class="j-link" id="class">Class</th>-->
		<!--							<th class="j-link" id="session">Session</th>-->
		<!--							<th class="j-link" id="term">Term</th>-->
		<!--							<th class="j-link" id="amount">Amount</th>-->
		<!--							<th><i class="fa fa-pencil mx-1"></i> Edit</th>-->
		<!--						</tr>-->
		<!--						</thead>-->
		<!--						<tbody id="fees-data" style="display: ">-->
		<!--						<tr>-->
		<!--							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>-->
		<!--							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>-->
		<!--							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>-->
		<!--							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>-->
		<!--							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>-->
		<!--							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>-->
		<!--						</tr>-->
		<!--						</tbody>-->
		<!--					</table>-->
		<!--					<hr />-->
		<!--				</div>-->
		<!--			</div>-->
		<!--			-->
		<!--			<div class="col-md-3 order-first order-md-0">-->
		<!--				<div class="j-link d-md-none p-2 w3-green" id="school-fees-toggle">-->
		<!--					<div class="d-flex justify-content-between align-items-center">-->
		<!--						<span><i class="far fa-plus-circle"></i> Add Fess Scheme</span>-->
		<!--						<i class="w3-text-white caret fa fa-caret-circle-down"></i>-->
		<!--						<i class="w3-text-white caret fa fa-caret-circle-up" style="display: none"></i>-->
		<!--					</div>-->
		<!--				</div>-->
		<!--				<div id="add-fees-scheme">-->
		<!--					<form action="./include/classes/manage.php" method="post" id="add-fees-form">-->
		<!--						<div class="form-group">-->
		<!--							<label for="class_sel">Class: </label>-->
		<!--							<div class="input-group">-->
		<!--								<i class="p-2 far fa-calendar-day"></i>-->
		<!--								<select name="class" id="class_sel" class="form-control form-control-sm" required>-->
		<!--									<option value="" selected disabled>Select Class...</option>-->
		<!--								</select>-->
		<!--							</div>-->
		<!--						</div>-->
		<!--						-->
		<!--						<div class="form-group">-->
		<!--							<label for="session_sel" disabled="">Session: </label>-->
		<!--							<div class="input-group">-->
		<!--								<i class="p-2 far fa-calendar-alt"></i>-->
		<!--								<select name="session" id="session_sel" class="form-control form-control-sm" required disabled>-->
		<!--									<option value="" selected disabled>Select a class first...</option>-->
		<!--								</select>-->
		<!--							</div>-->
		<!--						</div>-->
		<!--						-->
		<!--						<div class="form-group">-->
		<!--							<label for="term_sel">Term: </label>-->
		<!--							<div class="input-group">-->
		<!--								<i class="p-2 far fa-calendar-day"></i>-->
		<!--								<select name="term" id="term_sel" class="form-control form-control-sm" required disabled>-->
		<!--									<option value="" selected disabled>Select a session first...</option>-->
		<!--								</select>-->
		<!--							</div>-->
		<!--						</div>-->
		<!--						-->
		<!--						<div class="form-group">-->
		<!--							<label for="amount_inp">Amount: </label>-->
		<!--							<div class="input-group">-->
		<!--								<i class="p-2 far fa-money-bill-alt"></i>-->
		<!--								<span class="form-control form-control-sm w3-light-grey" style="max-width: 30px">&#x20A6;</span>-->
		<!--								<input name="amount" id="amount_inp" class="form-control form-control-sm" placeholder="Select Class, Session and Term first..." required disabled />-->
		<!--							</div>-->
		<!--						</div>-->
		<!--						-->
		<!--						<div class="form-group">-->
		<!--							<button type="submit" class="btn btn-success btn-sm my-md-0 my-1"><i class="far fa-plus-circle"></i> Add Fees Scheme</button>-->
		<!--						</div>-->
		<!--						<div id="mess" style="display:none">-->
		<!--							<span class="text-info"><i class="text-danger fa fa-exclamation"></i> Please wait...</span>-->
		<!--						</div>-->
		<!--					</form>-->
		<!--				</div>-->
		<!--			</div>-->
		<!--		</div>-->
		<form action="./include/classes/manage.php" method="post" id="update-result-form">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="class_sel">Class: </label>
						<div class="input-group">
							<i class="p-2 fad fa-users-class"></i>
							<select name="class" id="class_sel" class="form-control form-control-sm">
								<option value="" selected disabled>Select Class...</option>
							</select>
						</div>
						<div id="class_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="session_sel" disabled="">Session: </label>
						<div class="input-group">
							<i class="p-2 fad fa-calendar-alt"></i>
							<select name="session" id="session_sel" class="form-control form-control-sm" disabled>
								<option value="" selected disabled>Select a class first...</option>
							</select>
						</div>
						<div id="session_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="term_sel">Term: </label>
						<div class="input-group">
							<i class="p-2 fad fa-calendar-day"></i>
							<select name="term" id="term_sel" class="form-control form-control-sm" disabled>
								<option value="" selected disabled>Select a session first...</option>
							</select>
						</div>
						<div id="term_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="stu_sel">Student: </label>
						<div class="input-group">
							<i class="p-2 fad fa-user-graduate"></i>
							<select name="student" id="stu_sel" class="form-control form-control-sm" disabled>
								<option value="" selected disabled>Select a class and term first...</option>
							</select>
						</div>
						<div id="stu_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="s-border-top s-border-bottom my-md-5 mb-5 p-4">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="sub_sel">Subject: </label>
							<div class="input-group">
								<i class="p-2 fad fa-book-alt"></i>
								<select name="sub" id="sub_sel" class="form-control form-control-sm" disabled>
									<option value="" selected disabled>Select a Class and term first...</option>
								</select>
							</div>
							<div id="sub_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label for="ca_one">CA 1 Score: </label>
							<div class="input-group">
								<input name="ca_one" id="ca_one" class="form-control form-control-sm" placeholder="Select Subject first..." disabled />
							</div>
							<div id="ca_oneValidate" class="valid-text my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label for="ca_two">CA 2 Score: </label>
							<div class="input-group">
								<input name="ca_two" id="ca_two" class="form-control form-control-sm" placeholder="Select Subject first..." disabled />
							</div>
							<div id="ca_twoValidate" class="valid-text my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label for="exam">Exam Score: </label>
							<div class="input-group">
								<input name="exam" id="exam" class="form-control form-control-sm" placeholder="Select Subject first..." disabled />
							</div>
							<div id="examValidate" class="valid-text my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-sm my-md-0 my-1"><i class="far fa-arrow-alt-circle-right"></i> Upload Result</button>
				<a id="compute-result" class="j-link btn btn-danger btn-sm my-md-0 my-1"><i class="fa fa-calculator"></i> Compute Result</a>
			</div>

			<div class="form-group">
				<a href="./all_stu_results"><i class="fa fa-arrow-alt-circle-right"></i> View Results</a>
			</div>

			<div id="mess" style="display:none">
				<span class="text-info"><i class="text-danger fa fa-exclamation"></i> Please wait...</span>
			</div>
		</form>
	</div>

	<script>
		$(document).ready(function () {
			let requested = false,
				mess_tag = $('#mess'),
				mess = mess_tag.html(),
				valid_text = $('.valid-text'),
				valid_text_html = valid_text.html(),
				fees_form_id = '#add-fees-form';

			function clearText(valid_text, valid_text_html) {
				valid_text.html(valid_text_html).fadeOut();
			}

			function removeErr(form) {
				let inputs = $(form + ' input, ' + form + ' select, ' + form + ' textarea'), i;

				for (i = 0; i < inputs.length; i++) {
					$(inputs).removeClass('.regerr');
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

			function hideMessage() {
				mess_tag.mouseenter(function (e) {
					e.preventDefault();
					$('.remove', this).click(function (e) {
						e.preventDefault();
						$(this).fadeOut();
						setTimeout(function () {
							dynamicFooter();
						}, 1000);
					});

					$('.continue', this).click(function (e) {
						e.preventDefault();
						if ($('kbd', this).mouseIsOver() === true) {
							// copyToClipboard('kbd', this);

						} else {
							$(this).fadeOut();
							setTimeout(function () {
								dynamicFooter();
							}, 1000);
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

			function loadSchoolClassSessionsTermsStudentsAndSubjects() {
				let term = $('#term_sel'),
					student = $('#stu_sel'),
					class_sel = $('#class_sel'),
					session = $('#session_sel'),
					ca_one_inp = $('#ca_one'),
					ca_two_inp = $('#ca_two'),
					exam = $('#exam'),
					subject = $('#sub_sel'),
					result_form = $('#update-result-form');

				function classes() {
					if (requested) {
						return;
					}
					requested = true;

					$.ajax({
						url: './include/classes/manage.php',
						method: 'POST',
						data: {
							action: 'get-classes'
						},
						dataType: 'json',
						success: function (response) {
							let classes = response.data.classes.data.classes;

							$.each(classes, function (index, value) {
								class_sel.append(value);
								class_sel.change(function () {
									let class_id = class_sel.val();
									localStorage.setItem('class_id', class_id);

									if ((session.prop('disabled') === true) && (term.prop('disabled') === true)) {
										if (session.prop('disabled') === true) {
											session.prop('disabled', false);
											session.children(':selected').text('Please Wait...');
											student.children(':selected').text('Select a Session and a Term...');
											sessions();
										}
									}
								});
							});
						}
					});
					requested = false;
				}

				function sessions() {
					if (requested) {
						return;
					}
					requested = true;

					$.ajax({
						url: './include/classes/manage.php',
						method: 'POST',
						data: {
							action: 'get-sessions'
						},
						dataType: 'json',
						success: function (response) {
							let sessions = response.data.sessions.data.sessions;

							// student.prop('disabled', false);
							session.children(':selected').text('Select Session...');

							$.each(sessions, function (idx, val) {
								session.append(val);
								session.change(function () {
									let session_id = session.val();
									localStorage.setItem('session_id', session_id);

									if (term.prop('disabled') === true) {
										term.prop('disabled', false);
										term.children(':selected').text('Please Wait...');
										student.children(':selected').text('Select a Term...');
										terms();
									}
								});
							});
						}
					});
					requested = false;
				}

				function terms() {
					if (requested) {
						return;
					}
					requested = true;

					$.ajax({
						url: './include/classes/manage.php',
						method: 'POST',
						data: {
							action: 'get-terms'
						},
						dataType: 'json',
						success: function (response) {
							let terms = response.data.terms.data.terms;

							term.children(':selected').text('Select Term...');

							$.each(terms, function (idx, val) {
								term.append(val);
								term.change(function () {
									let term_id = term.val();
									localStorage.setItem('term_id', term_id);

									if (student.prop('disabled') === true) {
										student.children(':selected').text('Please Wait...');
									}
								});
							});
						}
					});
					requested = false;
				}

				class_sel.change(function () {
					if ((session.prop('disabled') === false) && (term.prop('disabled') === false) && (student.prop('disabled') === false)) {
						let class_id = class_sel.val();
						localStorage.setItem('class_id', class_id);
						getStudents();
					}
				});

				term.change(function () {
					if ((student.prop('disabled') === true)) {
						let term_id = term.val();
						localStorage.setItem('term_id', term_id);
						getStudents();

					} else {
						getStudents();
					}
				});

				session.change(function () {
					if ((session.prop('disabled') === false) && (term.prop('disabled') === false) && (student.prop('disabled') === false)) {
						let session_id = term.val();
						localStorage.setItem('session_id', session_id);
						getStudents();
					}
				});

				student.change(function () {
					let student_id = student.val();
					localStorage.setItem('student_id', student_id);
				});

				function getStudents() {
					let session_id = localStorage.getItem('session_id'),
						class_id = localStorage.getItem('class_id'),
						term_id = localStorage.getItem('term_id');

					if (requested) {
						return;
					}
					requested = true;

					subject.html('<option value="" selected disabled>Select Subject...</option>');
					ca_one_inp.val('');
					ca_two_inp.val('');
					exam.val('');

					ca_one_inp.attr('placeholder', 'Select Subject first...');
					ca_two_inp.attr('placeholder', 'Select Subject first...');
					exam.attr('placeholder', 'Select Subject first...');

					student.prop('disabled', true);
					subject.prop('disabled', true);
					ca_one_inp.prop('disabled', true);
					ca_two_inp.prop('disabled', true);
					exam.prop('disabled', true);

					$.ajax({
						url: './include/classes/manage.php',
						method: 'POST',
						data: {
							action: 'get-students',
							class_id: class_id
						},
						dataType: 'json',
						success: function (response) {
							let students = response.data.students.data.students;

							if ((session.prop('disabled') === false) && (term.prop('disabled') === false)) {
								student.html('<option value="" selected disabled>Select Student...</option>');
							}

							student.prop('disabled', false);
							student.children(':selected').text('Select Student...');
							localStorage.removeItem('student_id');

							$.each(students, function (idx, val) {
								student.append(val);
								student.change(function () {
									if ((subject.prop('disabled') === true)) {
										session_id = localStorage.getItem('session_id');
										class_id = localStorage.getItem('class_id');
										term_id = localStorage.getItem('term_id');
										subject.prop('disabled', false);
										subject.children(':selected').text('Please Wait...');
										getSubjects();
									}
								});
							});
						}
					});
					requested = false;
				}

				function getSubjects() {
					let session_id = localStorage.getItem('session_id'),
						class_id = localStorage.getItem('class_id'),
						term_id = localStorage.getItem('term_id');

					if (requested) {
						return;
					}
					requested = true;

					$.ajax({
						url: './include/classes/manage.php',
						method: 'POST',
						data: {
							action: 'get-subjects',
							class_id: class_id,
							session_id: session_id,
							term_id: term_id
						},
						dataType: 'json',
						success: function (response) {
							let subjects = response.data.subjects.data.subjects;

							if ((student.prop('disabled') === false)) {
								subject.html('<option value="" selected disabled>Select Subject...</option>');
							}

							subject.children(':selected').text('Select Subject...');

							$.each(subjects, function (idx, val) {
								subject.append(val);
								subject.change(function () {
									ca_one_inp.prop('disabled', false);
									ca_two_inp.prop('disabled', false);
									exam.prop('disabled', false);
									submitProcess();
								});
							});
						}
					});
					requested = false;
				}

				function submitProcess() {
					if ((ca_one_inp.prop('disabled') === false) && (ca_two_inp.prop('disabled') === false) && (exam.prop('disabled') === false)) {
						let sel_sub = subject.children(':selected').html();

						ca_one_inp.attr('placeholder', 'Input ' + sel_sub + ' CA1 score');
						ca_two_inp.attr('placeholder', 'Input ' + sel_sub + ' CA2 score');
						exam.attr('placeholder', 'Input ' + sel_sub + ' Exam score');

						ca_one_inp.prop('disabled', false);
						ca_two_inp.prop('disabled', false);
						exam.prop('disabled', false);
					}
				}

				result_form.submit(function (e) {
					e.preventDefault();
					let session_id = localStorage.getItem('session_id'),
						class_id = localStorage.getItem('class_id'),
						term_id = localStorage.getItem('term_id');

					updateStudentResult(this, 'upload-result', class_id, session_id, term_id);
				});

				$('#compute-result').click(function (e) {
					e.preventDefault();
					let session_id = localStorage.getItem('session_id'),
						student_id = localStorage.getItem('student_id'),
						class_id = localStorage.getItem('class_id'),
						term_id = localStorage.getItem('term_id');

					computeResult('compute-result', class_id, session_id, term_id, student_id);
				});
				classes();
			}

			function updateStudentResult(form, action, class_id, session_id, term_id) {
				if (requested) {
					return;
				}
				requested = true;
				mess_tag.html(mess);
				mess_tag.fadeIn();

				let form_action = $(form).attr('action');

				$(form).ajaxSubmit({
					url: form_action,
					method: 'POST',
					data: {
						action: action
					},
					dataType: 'json',
					success: function (response) {
						let resp_mess = response.data.message,
							resp_status = response.data.status;

						clearText(valid_text, valid_text_html);
						if (resp_status === '200') {
							if (response.data.result_upload.data.status === '400') {
								mess_tag.fadeOut();
								if (confirm(response.data.result_upload.data.message)) {
									updateStudentResult(form, 'update-result', class_id, session_id, term_id);
								}

							} else if (response.data.result_upload.data.status !== '400') {
								mess_tag.html(response.data.result_upload.data.message);
							}

						} else if (resp_status === '300') {
							mess_tag.html(resp_mess);
						}

						dynamicFooter();
						hideMessage();
						validation();
					}
				});
				requested = false;
			}

			function computeResult(action, class_id, session_id, term_id, student_id) {
				if (requested) {
					return;
				}
				requested = true;
				mess_tag.html(mess);
				mess_tag.fadeIn();

				removeErr('#update-result-form');
				$.ajax({
					url: './include/classes/manage.php',
					method: 'POST',
					data: {
						action: action,
						class: class_id,
						session: session_id,
						term: term_id,
						student: student_id
					},
					dataType: 'json',
					success: function (response) {
						let resp_mess = response.data.message,
							resp_status = response.data.status;

						clearText(valid_text, valid_text_html);
						if (resp_status === '200') {
							mess_tag.html(response.data.compute_result.data.message);

						} else if (resp_status === '300') {
							mess_tag.html(resp_mess);
						}

						dynamicFooter();
						hideMessage();
						validation();
					}
				});
				requested = false;
			}

			// $.ajax({
			// 	url: './include/classes/manage.php',
			// 	method: 'POST',
			// 	data: {
			// 		action: 'get-grade'
			// 	},
			// 	dataType: 'json',
			// 	success: function (response) {
			// 		console.log(response.data.grade.data);
			// 	}
			// });

			$(window).resize(function () {
				// toggleVisibility();
			});

			loadSchoolClassSessionsTermsStudentsAndSubjects();
			// formatAmountInput();
			// toggleVisibility();
			// orderFees();
		});
	</script>
<?php include './include/footer.php'; ?>