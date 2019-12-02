<div id="body" class="container-fluid login-page">
	<div class="row">
		<div class="col-12 d-xl-flex flex-grow-1 flex-fill justify-content-start align-items-center p-0">
			<div class="login-page-banner">
				<img src="design/imgs/index-slide-02.jpg" alt="" class="w-100 img-fluid">
			</div>

			<div class="login-page-form py-4 px-2 px-lg-5 px-xl-3">
				<form action="./include/classes/admin.php" method="post" id="login-form">
					<div class="form-group">
						<label for="login" class="col-form-label-sm pl-3">Email:</label>
						<div class="input-group">
							<i class="p-2 fad fa-user"></i>
							<input type="text" name="admin_login" class="form-control" id="login" placeholder="Email" />
						</div>
						<div id="loginValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>

					<div class="form-group">
						<label for="pword" class="col-form-label-sm pl-3">Password:</label>
						<div class="input-group">
							<i class="p-2 fad fa-user-lock"></i>
							<input type="password" name="admin_password" class="form-control" id="pword" placeholder="Password" />
						</div>
						<div id="pwordValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>

					<div class="form-group">
						<div class="d-flex justify-content-end align-items-end">
							<div class="d-flex flex-grow-1 justify-content-start mx-3"><a href="signup" class="">Register Here</a></div>
							<div class="mx-1">
								<a class="j-link btn btn-danger">Reset Password</a>
							</div>
							<div class="ml-1">
								<button type="submit" class="btn btn-primary">Login</button>
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
</div>

<?php include './include/footer.php'; ?>