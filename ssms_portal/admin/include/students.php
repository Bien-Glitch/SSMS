<?php require 'session.php' ?>

<?php
	if (isset($_POST) && !empty($_POST['action'])) {
		extract($_POST);
	}

	$student = [];
	$students = [];

	if ($action == 'get-students') {
		$q = $connect->query("SELECT * FROM `students` WHERE `class_id` = '{$class_id}' ORDER BY `lname`, `mname`, `fname`");
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$students[] = $row;
			}

			foreach ($students as $student) {
				echo '
					<option id="' . $student['id'] . '" value="' . $student['id'] . '">' . $student['lname'] . ' ' . $student['mname'] .  ' ' . $student['fname'] . '</option>
				';
			}
		}
	}