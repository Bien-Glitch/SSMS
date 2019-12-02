<?php include 'include/header.php'; ?>
<div id="body" class="container-fluid">
	<div class="row">
		<div class="offset-md-1 offset-lg-3 col-md-10 col-lg-6">
			<form action="./include/classes/admin.php" method="post" id="register-form" enctype="multipart/form-data">
				<div class="row">
					<div class="col">
						<div class="alert alert-info">
							The <span class="w3-text-red w3-large">*</span> sign means the specified field is required!!!
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="name">Admin Name:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 fad fa-user"></i>
								<input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Input Name" />
							</div>
							<div id="nameValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="email">Email Address:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 fad fa-envelope"></i>
								<input type="text" name="email" id="email" class="form-control form-control-sm" placeholder="Input Email" />
							</div>
							<div id="emailValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="skey">Secret Key?</label> <span class="w3-text-red w3-large mx-1">*</span>
							<div class="input-group">
								<i class="p-2 fad fa-question"></i>
								<input type="password" class="form-control form-control-sm" name="skey" id="skey" placeholder="Secret key">
							</div>
							<div id="skeyValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="pword" class="col-form-label-sm pl-3">Password:</label>
							<div class="input-group">
								<i class="p-2 fad fa-user-lock"></i>
								<input type="password" name="pword" class="form-control form-control-sm" id="pword" placeholder="Password" />
							</div>
							<div id="pwordValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<div class="d-md-inline d-flex flex-column">
								<button type="submit" class="btn btn-primary my-md-0 my-1">Submit</button>
								<a id="clear" class="j-link btn btn-danger my-md-0 my-1">clear</a>
							</div>
						</div>
					</div>
				</div>
				<div id="mess" style="display: none">
					<i class="text-danger fa fa-exclamation-circle"></i> <span class="text-primary">Please Wait...</span>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="./design/js/student.js"></script>

<?php include './include/footer.php'; ?>