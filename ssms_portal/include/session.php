<?php require_once 'connect.php'; ?>
<?php
	// Set Default timezone to Lagos: GMT +01:00
	date_default_timezone_set("Africa/Lagos");

	$datetime = date("Y-m-d H:i:s"); ## Current Datetime
	$date = date("Y-m-d"); ## Current Date
	$year = date("Y"); ## Current Year

	$start = new DateTime($date); ## Start new DateTime interface using today's date and assign it to variable $start

	//Send request to server to get http or https address
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

	//Set $currentURL as the http or https address
	$currentURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];

	session_start(); ## Initialize Session Data

	if (isset($_SESSION['user_login']) && !empty($_SESSION['user_login'])) {
		# code...
		$user = @$_SESSION['user_login'];

		$q = $connect->query("SELECT * FROM `students` WHERE `adm_id` = '{$user}' LIMIT 1");
		if ($q->num_rows > 0) {
			$stu_info = $q->fetch_array();

			$stu_passport = $stu_info['passport'];
			$stu_class = $stu_info['class'];
			$stu_fname = $stu_info['fname'];
			$stu_lname = $stu_info['lname'];
			$stu_oname = $stu_info['mname'];
			$stu_gender = $stu_info['gender'];
			$stu_dob = $stu_info['dob'];
			$stu_pnum = $stu_info['pnum'];
			$stu_sor = $stu_info['sor'];
			$stu_lga = $stu_info['lga'];
			$stu_religion = $stu_info['religion'];
			$stu_token = $stu_info['token'];
			$stu_reg_date = $stu_info['reg_date'];

			$stu_name = $stu_lname . ' ' . $stu_oname . ' ' . $stu_fname;

			$q = $connect->query("SELECT * FROM `parents` WHERE `student_id` = '{$user}' LIMIT 1");
			if ($q->num_rows > 0) {
				$parent_info = $q->fetch_array();

				$pg_name = $parent_info['name'];
				$pg_pnum = $parent_info['phone'];
				$pg_occu = $parent_info['occupation'];
				$pg_address = $parent_info['address'];
			}
		}

	} else {
		$user = NULL;
		$stu_name = NULL;
	}
?>