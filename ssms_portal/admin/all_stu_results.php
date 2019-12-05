<?php include './include/header.php'; ?>
<style>
	.display {
		font-size: 11px;
	}
</style>

<div id="body" data-action="<?php echo $action; ?>" data-query="DESC" class="container-fluid manage-page mb-5">
	<div class="row">
		<div class="col-md-8 s-md-border-right p-1 display">
			<div id="result-info">
				<div class="alert alert-info">Select Class, Session, Term and Student the Click on View result to view result</div>
			</div>
			<table class="table table-hover table-striped table-borderless table-sm table-light subject-table" hidden>
				<thead class="thead-dark">
				<tr>
					<th id="students.id" class="j-link">#id</th>
					<th id="subject" class="j-link">Subject</th>
					<th id="CA1_score" class="j-link">CA One</th>
					<th id="CA2_score" class="j-link">CA Two</th>
					<th id="exam" class="j-link">Exam</th>
					<th id="total" class="j-link">Total</th>
					<th id="grade" class="j-link">Grade</th>
				</tr>
				</thead>
				<tbody class="detail-pane"></tbody>
			</table>

			<div class="s-border-top compute" hidden>
				<div>Average: <span id="avg-score"></span></div>
			</div>
		</div>

		<div class="col-md-4 order-first order-md-last p-1">
			<div class="container-fluid">
				<form action="./include/classes/manage.php" method="post" id="view-result-form">
					<div class="row">
						<div class="col-sm-6 col-md-12">
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

						<div class="col-sm-6 col-md-12">
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
						<div class="col-sm-6 col-md-12">
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

						<div class="col-sm-6 col-md-12">
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

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-sm my-md-0 my-1"><i class="far fa-arrow-alt-circle-right"></i> View Result</button>
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
			mess_tag = $('#mess'),
			mess = mess_tag.html(),
			valid_text = $('.valid-text'),
			result_mess = $('#result-info'),
			valid_text_html = valid_text.html(),
			fees_form_id = '#add-fees-form';

		function loadSchoolClassSessionsTermsAndStudents() {
			let term = $('#term_sel'),
				student = $('#stu_sel'),
				class_sel = $('#class_sel'),
				session = $('#session_sel'),
				// ca_one_inp = $('#ca_one'),
				// ca_two_inp = $('#ca_two'),
				// exam = $('#exam'),
				// subject = $('#sub_sel'),
				result_form = $('#view-result-form');

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

				student.prop('disabled', true);

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
						});
					}
				});
				requested = false;
			}

			// function submitProcess() {
			// 	if ((ca_one_inp.prop('disabled') === false) && (ca_two_inp.prop('disabled') === false) && (exam.prop('disabled') === false)) {
			// 		let sel_sub = subject.children(':selected').html();
			//
			// 		ca_one_inp.attr('placeholder', 'Input ' + sel_sub + ' CA1 score');
			// 		ca_two_inp.attr('placeholder', 'Input ' + sel_sub + ' CA2 score');
			// 		exam.attr('placeholder', 'Input ' + sel_sub + ' Exam score');
			//
			// 		ca_one_inp.prop('disabled', false);
			// 		ca_two_inp.prop('disabled', false);
			// 		exam.prop('disabled', false);
			// 	}
			// }

			result_form.submit(function (e) {
				e.preventDefault();
				let session_id = localStorage.getItem('session_id'),
					student_id = localStorage.getItem('student_id'),
					class_id = localStorage.getItem('class_id'),
					term_id = localStorage.getItem('term_id');

				loadResults(student_id, class_id, session_id, term_id)
			});

			// $('#compute-result').click(function (e) {
			// 	e.preventDefault();
			// 	let session_id = localStorage.getItem('session_id'),
			// 		student_id = localStorage.getItem('student_id'),
			// 		class_id = localStorage.getItem('class_id'),
			// 		term_id = localStorage.getItem('term_id');
			//
			// 	computeResult('compute-result', class_id, session_id, term_id, student_id);
			// });

			classes();
		}

		function loadResults(student_id, class_id, session_id, term_id) {
			result_mess.html('<span class="text-info"><i class="text-danger fa fa-exclamation"></i> Please wait...</span>');
			$.ajax({
				url: './include/classes/manage.php',
				method: 'POST',
				data: {
					action: 'view-result',
					student_id: student_id,
					class_id: class_id,
					session_id: session_id,
					term_id: term_id
				},
				dataType: 'json',
				success: function (response) {
					$('.detail-pane').html(response.data.view_result.data.info);
					$('#avg-score').html(response.data.view_result.data.average);

					result_mess.fadeOut(function () {
						$('.display table').removeAttr('hidden');
						$('.display .compute').removeAttr('hidden');
					});
				}
			});
		}

		loadSchoolClassSessionsTermsAndStudents();
	});
</script>