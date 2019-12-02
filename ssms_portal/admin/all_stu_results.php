<?php include './include/header.php'; ?>
<style>
	.display {
		font-size: 11px;
	}
</style>

<div id="body" data-action="<?php echo $action; ?>" data-query="DESC" class="container-fluid manage-page mb-5">
	<div class="row">
		<div class="col-md-8 s-md-border-right p-1 display">
			<table class="table table-hover table-striped table-borderless table-sm table-light subject-table">
				<thead class="thead-dark">
				<tr>
					<th id="students.id" class="j-link">#id</th>
					<th id="class" class="j-link">Subject</th>
					<th id="class" class="j-link">CA One</th>
					<th id="class" class="j-link">CA Two</th>
					<th id="class" class="j-link">Exam</th>
					<th id="class" class="j-link">Total</th>
					<th id="class" class="j-link">Grade</th>
				</tr>
				</thead>
				<tbody class="detail-pane"></tbody>
			</table>
		</div>

		<div class="col-md-4 order-first order-md-last p-1">
			s
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		function loadResults(student_id, class_id, session_id, term_id) {
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
				}
			});
		}

		loadResults();
	});
</script>