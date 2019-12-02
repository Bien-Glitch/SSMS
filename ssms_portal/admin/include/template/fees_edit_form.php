<?php include '../session.php'; ?>
<div class="w3-card bg-light shadow">
	<div class="card-header w3-black">
		<div class="card-heading d-flex justify-content-between">
			<span>FEES SCHEME UPDATE FORM</span>
			<a class="text-danger j-link" title="Close"><i class="far fa-times"></i></a>
		</div>
	</div>
	<div class="card-body">
		<div id="mess" style="display: none">
			<i class="text-danger fa fa-exclamation-circle"></i> <span class="text-primary">Please Wait...</span>
		</div>

		<form action="./include/classes/manage.php" method="post" id="edit-fees-form">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="d-flex align-items-center"><label for="class_sel">Class:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
						<div class="input-group">
							<i class="p-2 far fa-calendar-day"></i>
							<select name="class" id="class_sel" class="form-control form-control-sm"></select>
						</div>
						<div id="class_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<div class="d-flex align-items-center"><label for="session_sel">Session:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
						<div class="input-group">
							<i class="p-2 far fa-calendar-alt"></i>
							<select name="session" id="session_sel" class="form-control form-control-sm"></select>
						</div>
						<div id="session_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="d-flex align-items-center"><label for="term_sel">Term:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
						<div class="input-group">
							<i class="p-2 far fa-calendar-day"></i>
							<select name="term" id="term_sel" class="form-control form-control-sm"></select>
						</div>
						<div id="term_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<div class="d-flex align-items-center"><label for="amount_inp">Amount:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
						<div class="input-group">
							<i class="p-2 far fa-money-bill-alt"></i>
							<span class="form-control form-control-sm w3-light-grey" style="max-width: 30px">&#x20A6;</span>
							<input name="amount" id="amount_inp" class="form-control form-control-sm" placeholder="Select Class, Session and Term first..." />
						</div>
						<div id="amount_inpValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
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
							<a class="clear j-link btn btn-danger my-md-0 my-1" data-form="edit-fees-form"><i class="fa fa-times"></i> clear</a>
							<a class="reset j-link btn btn-secondary my-md-0 my-1" data-form="edit-fees-form"><i class="fa fa-redo"></i> Reset</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>