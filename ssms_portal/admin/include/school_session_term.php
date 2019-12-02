<?php require 'session.php' ?>

<?php
	if (isset($_POST) && !empty($_POST['action'])) {
		$action = $_POST['action'];
	}

	$term = [];
	$terms = [];

	$session = [];
	$sessions = [];

	if ($action == 'get-sessions') {
		$q = $connect->query("SELECT * FROM `session`");
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$sessions[] = $row;
			}

			foreach ($sessions as $session) {
				if ($session['current_session'] == '*') {
					$csession = $session['session'] . ' *';

				} else {
					$csession = $session['session'];
				}
				echo '
					<option id="' . $session['id'] . '" value="' . $session['id'] . '">' . $csession . '</option>
				';
			}
		}
	}

	if ($action == 'get-terms') {
		$q = $connect->query("SELECT * FROM `term`");
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$terms[] = $row;
			}

			foreach ($terms as $term) {
				if ($term['current_term'] == '*') {
					$cterm = $term['term'] . ' *';

				} else {
					$cterm = $term['term'];
				}
				echo '
					<option id="' . $term['id'] . '" value="' . $term['id'] . '">' . $cterm . '</option>
				';
			}
		}
	}