<?php include './include/header.php'; ?>
<?php
	if (!$user) {
		# code...
		require_once './include/template/login.php';
		echo '<script src="./design/js/student.js"></script>';
		exit();
	}
?>

	<body>
		<div id="body">
			<?php print_r($_SESSION); ?>
		</div>
		<script src="./design/js/site.js"></script>
	</body>

<?php include './include/footer.php'; ?>