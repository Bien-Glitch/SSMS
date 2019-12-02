<?php include './include/header.php'; ?>
<?php
if (!$user) {
	# code...
	require_once './include/template/login_form.php';
	echo '<script src="./design/js/student.js"></script>';
	exit();
}
?>

	<body>
		<div id="body" class="container-fluid">
			<div class="p-2 my-3 border-bottom">
				<h3>Hello <?php echo $a_name ?></h3>
				<span style="letter-spacing: -0.5px">Control Type: <?php echo $_SESSION['admin_type'] ?></span>
			</div>

			<div class="row">
				<div class="col">
					<div class="card shadow">
						<div class="card-header w3-black">Other Admins</div>
						<div class="card-body get-admins display">
						</div>
					</div>
				</div>
			</div>

		</div>
		<script src="./design/js/site.js"></script>

		<script>
			$(document).ready(function () {
				let display_tag = $('.get-admins.display');

				function admin() {
					$.ajax({
						url: './include/classes/admin.php',
						method: 'POST',
						data: {
							action: 'get-admins'
						},
						dataType: 'json',
						success: function (response) {
							let table = response.data.admins.data.table,
								admins_info = response.data.admins.data.info,
								admins_infoHTML = '';

							display_tag.html(table);
							$.each(admins_info, function (index, value) {
								admins_infoHTML += value;
							});
							$('.detail-pane').html(admins_infoHTML);

							$('.delete').each(function (index, value) {
								$(this).click(function (e) {
									e.preventDefault();
									let a_name = value.dataset.name,
										a_type = value.dataset.type;
									deleteAdmin(a_name, a_type);
								})
							});
						}
					});
				}

				function deleteAdmin(a_name, a_type) {

					if (confirm('Are you sure you want to remove ' + a_type + ' with name: ' + a_name + '.\r\nThis action will remove all of this ' + a_type + '\'s data and cannot be undone!!!')) {
						$.ajax({
							method: 'POST',
							url: './include/classes/admin.php',
							data: {
								action: 'delete-admin',
								admin_name: a_name
							},
							dataType: 'json',
							success: function (response) {
								if (response.data.status === '200') {
									alert(response.data.delete_admin.data.status);
									admin();

								} else if (response.data.status === '300') {
									alert(response.data.message);
								}
							}
						});

					} else {
						alert('Delete Operation Cancelled!!!');
					}
				}

				admin();
			});
		</script>
	</body>

<?php include './include/footer.php'; ?>