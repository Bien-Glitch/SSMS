<?php require_once 'connect.php'; ?>
<?php
	// Set Default timezone to Lagos: GMT +01:00
	date_default_timezone_set("Africa/Lagos");

	$datetime = date("Y-m-d H:i:s"); ## Current Datetime
	$date = date("Y-m-d"); ## Current Date
	$year = date("Y"); ## Current Year

	try {
		$start = new DateTime($date); ## Start new DateTime interface using today's date and assign it to variable $start
	} catch (Exception $e) {
		echo $e->getMessage();
	}

	//Send request to server to get http or https address
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

	//Set $currentURL as the http or https address
	$currentURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];

	session_start(); ## Initialize Session Data

	if (isset($_SESSION['admin_login']) && !empty($_SESSION['admin_login'])) {
		# code...
		$user = @$_SESSION['admin_login'];

		$q = $connect->query("SELECT * FROM `admin` WHERE `email` = '{$user}' LIMIT 1");
		if ($q->num_rows > 0) {
			$set_active = $connect->query("UPDATE `admin` SET `active` = 'yes' WHERE `email` = '{$user}'");
			$admin_info = $q->fetch_array();

			$a_name = $admin_info['name'];
			$a_email = $admin_info['email'];
			$a_type = $admin_info['privilege'];
		}

	} else {
		$user = NULL;
	}
?>