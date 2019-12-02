<?php include 'session.php'; ?>
<?php
	//Send request to server to get http or https address
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

	//Set $currentURL as the http or https address
	$currentURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
	$host = $protocol . $_SERVER['HTTP_HOST'];

	if (!strstr($currentURL, 'skool')) {
		# code...
		$main_nav = '
        
    ';
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- [Stylesheets] -->
	<!-- Bootstrap -->
	<link rel="stylesheet" href="./design/css/bootstrap/bootstrap.min.css">

	<!-- Fontawesome -->
	<link rel="stylesheet" href="./design/css/custom/all.min.css">

	<!-- sl slider -->
	<link rel="stylesheet" href="./design/assets/slslider/css/custom.css">
	<link rel="stylesheet" href="./design/assets/slslider/css/demo.css">
	<link rel="stylesheet" href="./design/assets/slslider/css/style.css">
	<noscript>
		<link rel="stylesheet" href="./design/assets/slslider/css/styleNoJS.css">
	</noscript>

	<!-- Custom -->
	<link rel="stylesheet" href="./design/css/custom/w3.css">
	<link rel="stylesheet" href="./design/css/custom/fonts.css">
	<link rel="stylesheet" href="./design/css/custom/site.css">

	<!-- [Scripts] -->
	<!-- Jquery -->
	<script src="./design/js/jquery/jquery-3.2.1.min.js"></script>
	<script src="./design/js/jquery/jquery.form.js"></script>
	<script src="./design/js/jquery/jquery.validate.min.js"></script>
	<script src="./design/js/jquery/popper.min.js"></script>
	<!--	<script src="./design/js/jquery/jquery-ui.min.js"></script>-->
	<!--	    <script src="./design/js/assets/js/accounting.min.js"></script>-->
	<script src="./design/js/jquery/theme.js"></script>
	<!--        <script src="./design/js/jquery/jquery.validate.min.js"></script>-->

	<!-- Bootstrap -->
	<script src="./design/js/bootstrap/bootstrap.min.js"></script>

	<!-- sl slider -->
	<script src="./design/assets/slslider/js/modernizr.custom.79639.js"></script>

	<!-- Custom -->
	<script src="./design/js/custom/site.js"></script>
</head>

<div class="container-fluid search-wrapper fixed-top">
	<div class="row">
		<div class="col-12 py-2 bg-dark">
			<form action="" method="POST" class="search-form d-flex" id="search-form">
				<input type="search" name="" id="search-input" class="form-control px-3" placeholder="Search..." />
				<a class="j-link p-2 w3-hover-text-red d-none d-sm-inline" id="search-close"><i class="fa fa-times fa-1x"></i></a>
			</form>
		</div>
	</div>
</div>

<script>

</script>

<nav class="main-nav navbar navbar-expand navbar-dark bg-primary fixed-top shadow">
	<a class="navbar-brand" href="./">
		<img src="./design/imgs/ssms-logo.png" alt="ssms-logo" class="bg-transparent" width="50px">
		<span class="brand-text d-none d-sm-inline">SSMS</span>
	</a>
	<div class="d-flex flex-grow-1 justify-content-center" id="">
		<ul class="navbar-nav">
			<li class="nav-item dropdown">
				<a class="j-link nav-link dropdown-toggle" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Home</a>
				<div class="dropdown-menu" aria-labelledby="dropdownId">
					<a class="dropdown-item" href="#">About Us</a>
					<a class="dropdown-item" href="#">Contact Us</a>
					<a class="dropdown-item" href="#">Principals Welcome Speech</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="j-link nav-link dropdown-toggle" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admission</a>
				<div class="dropdown-menu" aria-labelledby="dropdownId">
					<a class="dropdown-item" href="#">Application Guide</a>
					<a class="dropdown-item" href="#">Apply Online</a>
					<a class="dropdown-item" href="#">Entrance Examination</a>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">News/Events</a>
			</li>
		</ul>
	</div>

	<div class="d-flex flex-grow-1 justify-content-end">
		<ul class="navbar-nav">
			<a class="j-link nav-link px-3 w3-text-black w3-hover-light-grey" id="search-open" title="Search"><i class="fa fa-search"></i></a>
			<li class="nav-item dropdown">
				<a class="j-link nav-link px-3 rounded rounded-circle w3-text-black w3-hover-text-blue w3-hover-light-grey" id="dropdownId" data-toggle="dropdown"
				   aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-ellipsis-v"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownId">
					<a class="dropdown-item" href="./ssms_portal" target="_blank">Online Portal</a>
				</div>
			</li>
		</ul>
	</div>
</nav>

</html>