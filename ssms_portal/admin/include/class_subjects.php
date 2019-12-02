<?php require 'session.php' ?>

<?php
	if (isset($_POST) && !empty($_POST['action'])) {
		extract($_POST);
	}

	$subject = [];
	$subjects = [];

	if ($action == 'get-subjects') {
		$q = $connect->query("SELECT * FROM `subjects` WHERE `class_id` = '{$class_id}' AND `session_id` = '{$session_id}'  AND `term_id` = '{$term_id}' ORDER BY `subject`");
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$subjects[] = $row;
			}

			foreach ($subjects as $subject) {
				echo '
					<option id="' . $subject['id'] . '" value="' . $subject['id'] . '">' . $subject['subject'] . '</option>
				';
			}
		}
	}
