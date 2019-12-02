<?php include './include/header.php'; ?>
	<style>
		@media screen and (max-width: 767px) {
			#add-class {
				display: none;
			}
		}
	</style>
	<div id="body" data-action="<?php echo $action; ?>" data-query="DESC" class="container-fluid manage-page mb-5">
		<div class="row">
			<div class="col-md-9 s-border-top s-md-border-top-none s-md-border-right">
				<div class="manage-classes mb-5 mt-4">
					<div class="p-2 w3-black">Manage Classes</div>
					<span class="w3-large">Available Classes</span>
					<div id="resp-mess-class" class="alert alert-info m-0 resp-mess" style="display: none"></div>
					<table class="table table-hover table-striped table-borderless table-sm table-light class-table">
						<thead class="thead-dark">
						<tr>
							<th class="j-link" id="id">#</th>
							<th class="j-link" id="class">Class</th>
							<th><i class="fa fa-pencil mx-1"></i> Edit</th>
						</tr>
						</thead>
						<tbody id="class-data" style="display: ">
						<tr>
							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
							<td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
						</tr>
						</tbody>
					</table>
					<hr />
				</div>
			</div>

			<div class="col-md-3 order-first order-md-0">
				<div class="j-link d-md-none p-2 w3-green" id="class-toggle">
					<div class="d-flex justify-content-between align-items-center">
						<span><i class="far fa-plus-circle"></i> Add Class</span>
						<i class="w3-text-white caret fa fa-caret-circle-down"></i>
						<i class="w3-text-white caret fa fa-caret-circle-up" style="display: none"></i>
					</div>
				</div>
				<div id="add-class">
					<div class="alert alert-info py-1">
						<small><i class="fa fa-exclamation-circle"></i> Class Name must be in Uppercase!!!</small>
					</div>

					<div id="mess" style="display: none">
						<i class="text-danger fa fa-exclamation-circle"></i> <span class="text-primary">Please Wait...</span>
					</div>
					<div class="p-2 w3-black">Add Class</div>
					<form action="./include/classes/manage.php" method="post" id="add-class-form">
						<div class="form-group">
							<label for="class_inp">Class Name: </label>
							<div class="input-group">
								<i class="p-2 far fa-users-class"></i>
								<input type="text" pattern="^[A-Z0-9]*$" name="class" id="class_inp" class="form-control form-control-sm" required />
							</div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-sm my-md-0 my-1"><i class="far fa-plus-circle"></i> Add Class</button>
						</div>
					</form>

					<hr />

					<div class="p-2 w3-black">Edit Class</div>
					<form action="./include/classes/manage.php" method="post" id="edit-class-form">
						<div class="form-group">
							<label for="class_inp_edit">Class Name: </label>
							<div class="input-group">
								<i class="p-2 far fa-users-class"></i>
								<input type="text" pattern="^[A-Z0-9]*$" name="class_edit" id="class_inp_edit" class="form-control form-control-sm" required />
							</div>
						</div>

						<div class="form-group">
							<label for="new_class_inp">New Class Name: </label>
							<div class="input-group">
								<i class="p-2 far fa-users-class"></i>
								<input type="text" pattern="^[A-Z0-9]*$" name="new_class" id="new_class_inp" class="form-control form-control-sm" required />
							</div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-secondary btn-sm my-md-0 my-1"><i class="far fa-cloud-upload-alt"></i> Update Class</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function () {
			let requested = false,
				class_form_id = '#add-class-form',
				edit_class_form_id = '#edit-class-form';

			// Function to automatically position the Footer
			function dynamicFooter() {
				if ($('html').hasScrollBar()) {
					console.log('true');
					$('.footer').css({
						'position': 'relative',
						'z-index': '1500'
					});

				} else {
					console.log('false');
					$('.footer').css({
						'position': 'fixed',
						'bottom': '0',
						'right': '0',
						'left': '0'
					});
				}
			}

			function toggleVisibility() {
				let body_width = $(body).width(),
					class_tag = $('#add-class');

				if (body_width > '735') {
					if (class_tag.css('display') === 'none') {
						class_tag.css('display', 'block')
					}
				}

				if (body_width < '735') {
					if ($('.caret')[1].style.display !== 'none') {
						class_tag.css('display', 'block');

					} else if (class_tag.css('display') === 'block') {
						class_tag.css('display', 'none')
					}
				}
			}

			function orderClass() {
				$('.class-table th.j-link').each(function (index, value) {
					$(this).attr('title', 'Click to change order: Ascending or Descending');
					$(this).click(function () {
						let text = $(this).text(),
							column_name = $(this).attr('id'),
							query = localStorage.getItem(column_name);

						if (query === 'ASC' || query === '') {
							query = 'DESC';
							resp_text = 'Descending'

						} else {
							query = 'ASC';
							resp_text = 'Ascending'
						}

						$('#resp-mess-class').html('<small>Order Class by ' + text + ': ' + resp_text + '</small>').slideDown(800);
						localStorage.setItem(value.id, query);
						manageClass(column_name, query, 'refresh');
						dynamicFooter()
					});
				});
			}

			function manageClass(c, q, getType) {
				let class_body = $('#class-data');

				if (requested) {
					return;
				}
				requested = true;

				$.ajax({
					url: './include/classes/manage.php',
					method: 'POST',
					data: {
						action: 'manage-classes',
						column: c,
						query: q
					},
					dataType: 'json',
					success: function (response) {
						let classes_info = response.data.classes.data.info,
							classes_infoHTML = '';

						if (response.data.classes.status === '200') {
							$.each(classes_info, function (index, value) {
								classes_infoHTML += value;
							});

						} else {
							classes_infoHTML = classes_info;
						}
						class_body.fadeOut(800);
						setTimeout(function () {
							class_body.html(classes_infoHTML).fadeIn(1000);

							$('.class-table .edit').each(function () {
								$(this).click(function (e) {
									e.preventDefault();
									let _class = $(this).data('class');
									$('#class_inp_edit').val(_class)
								});
							});
							$('.class-table .delete').each(function () {
								$(this).click(function (e) {
									e.preventDefault();
									let _class = $(this).data('id');
									deleteClass(_class, 'delete-class', 'Class');
								});
							});
							dynamicFooter();
						}, 900);

						$('.class-table th.j-link').each(function (index, value) {
							if (getType === 'fresh') {
								localStorage.removeItem(value.id)
							}
						});
					}
				});
				requested = false
			}

			function addEditClass(form, action) {
				let mess_tag = $('#mess'),
					mess = mess_tag.html(),
					form_action = $(form).attr('action');

				mess_tag.html(mess);
				mess_tag.fadeIn();

				$(form).ajaxSubmit({
					url: form_action,
					method: 'POST',
					data: {
						action: action
					},
					dataType: 'json',
					success: function (response) {
						mess_tag.fadeOut();
						if (action === 'add-class') {
							alert(response.data.add_class.data.message);
						}

						if (action === 'edit-class') {
							alert(response.data.edit_class.data.message);
						}
						manageClass('id', 'ASC', 'fresh');
						dynamicFooter();
					}
				});
			}

			function deleteClass(table_id, action, table) {
				if (confirm('Are you sure you want to delete ' + table + ' with id: ' + table_id + '?\r\nThis action cannot be undone!!!')) {
					$.ajax({
						url: './include/classes/manage.php',
						method: 'POST',
						data: {
							action: action,
							table_id: table_id
						},
						dataType: 'json',
						success: function (response) {
							alert(response.data.delete_class.data.message);
							manageClass('id', 'ASC', 'fresh');
							dynamicFooter();
						}
					});

				} else {
					alert(table + ' deletion cancelled!!!');
				}
			}

			$('#class-toggle').click(function (e) {
				e.preventDefault();
				let class_wrapper = $('#add-class');

				class_wrapper.animate({
					'height': 'toggle',
					'padding-top': 'toggle'
				}, 800);

				$('.caret').animate({
					'height': 'toggle'
				}, 0);
				setTimeout(function () {
					dynamicFooter();
				}, 900);
			});

			$('.resp-mess').each(function () {
				$(this).click(function () {
					$(this).fadeOut(800);
					dynamicFooter();
				});
			});

			$(class_form_id).submit(function (e) {
				e.preventDefault();
				addEditClass(class_form_id, 'add-class');
			});

			$(edit_class_form_id).submit(function (e) {
				e.preventDefault();
				addEditClass(edit_class_form_id, 'edit-class');
			});

			$(window).resize(function () {
				toggleVisibility();
			});

			manageClass('id', 'ASC', 'fresh');
			orderClass();
		});
	</script>
<?php include './include/footer.php'; ?>