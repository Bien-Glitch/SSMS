<?php include '../session.php'; ?>
<div class="w3-card bg-light shadow">
	<div class="card-header w3-black">
		<div class="card-heading d-flex justify-content-between">
			<span>SUBJECT UPDATE FORM</span>
			<a class="text-danger j-link" title="Close"><i class="far fa-times"></i></a>
		</div>
	</div>
	<div class="card-body">
		<div id="mess" style="display: none">
			<i class="text-danger fa fa-exclamation-circle"></i> <span class="text-primary">Please Wait...</span>
		</div>

		<form action="./include/classes/manage.php" method="post" id="edit-subject-form">
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

			<div class="form-group">
				<div class="d-flex align-items-center"><label for="term_sel">Term:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
				<div class="input-group">
					<i class="p-2 far fa-calendar-day"></i>
					<select name="term" id="term_sel" class="form-control form-control-sm">
						<option value="" id="" disabled>Select a Term...</option>
					</select>
				</div>
				<div id="term_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
					<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
				</div>

				<div class="form-group">
					<div class="d-flex align-items-center"><label for="subject_inp">Subject:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
					<div class="input-group">
						<i class="p-2 far fa-book-reader"></i>
						<input name="subject" id="subject_inp" class="form-control form-control-sm" />
					</div>
					<div id="subject_inpValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
						<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
					</div>
				</div>

				<div class="form-group">
					<div class="d-md-inline d-flex flex-column">
						<button type="submit" class="btn btn-primary my-md-0 my-1">Submit</button>
						<a class="clear j-link btn btn-danger my-md-0 my-1" data-form="edit-subject-form"><i class="fa fa-times"></i> clear</a>
						<a class="reset j-link btn btn-secondary my-md-0 my-1" data-form="edit-subject-form"><i class="fa fa-redo"></i> Reset</a>
					</div>
				</div>
		</form>
	</div>
</div>