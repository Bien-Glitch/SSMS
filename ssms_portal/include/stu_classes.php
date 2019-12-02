<?php require 'session.php' ?>

<?php
	if (isset($_POST) && !empty($_POST['action'])) {
		$action = $_POST['action'];
	}

	$class = [];
	$classes = [];

	if ($action == 'get-classes') {
		$q = $connect->query("SELECT * FROM `class`");
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$classes[] = $row;
			}

			foreach ($classes as $class) {
				echo '
					<option id="' . $class['id'] . '" value="' . $class['id'] . '">' . $class['class'] . '</option>
				';
			}
		}
	}
