<?php include '../session.php'; ?>
<div class="w3-card bg-light shadow">
	<div class="card-header w3-black">
		<div class="card-heading d-flex justify-content-between">
			<span>STUDENT UPDATE FORM</span>
			<a class="text-danger j-link" title="Close"><i class="far fa-times"></i></a>
		</div>
	</div>
	<div class="card-body">
		<div class="image d-flex justify-content-between align-items-center">
			<img src="" alt="" class="img-thumbnail rounded mx-2" style="width: 100px; height: 110px" />
			<div style="">Select an image to change Passport</div>
		</div>
		<form action="./include/classes/manage.php" method="post" enctype="multipart/form-data" id="passport-update-form">
			<fieldset class="text-center">
				<input type="file" id="passport" name="passport" class="form-control-file form-control-sm" data-form="passport-update-form" />
				<button type="submit" id="submit" class="btn btn-primary" hidden>Upload</button>
				<div id="passportValidate" class="valid-text text-left my-1 py-1 px-2 w3-round alert" style="display: none">
					<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
				</div>
				<span id="pic-mess" class="text-primary" style="display: none"><i class="text-danger far fa-exclamation"></i> Please Wait...</span>
			</fieldset>
		</form>
		<hr />
		<div id="mess" style="display: none">
			<i class="text-danger fa fa-exclamation-circle"></i> <span class="text-primary">Please Wait...</span>
		</div>
		<div class="form">
			<form action="./include/classes/manage.php" method="post" id="edit-student-form">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="fname">First Name:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="far fa-user p-2"></i>
								<input type="text" name="fname" id="fname" class="form-control form-control-sm">
							</div>
							<div id="fnameValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label for="mname">Middle Name</label>
							<div class="input-group">
								<i class="far fa-user p-2 d-md-none"></i>
								<input type="text" name="mname" id="mname" class="form-control form-control-sm">
							</div>
							<div id="mnameValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="lname">Last Name:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="far fa-user p-2 d-md-none"></i>
								<input type="text" name="lname" id="lname" class="form-control form-control-sm">
							</div>
							<div id="lnameValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="admno">Admission Number:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 far fa-user-tag"></i>
								<input type="text" name="admno" id="admno" class="form-control form-control-sm" placeholder="Input Admission number" />
							</div>
							<div id="admnoValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="class">Class:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 far fa-users-class"></i>
								<select type="text" name="class" id="class" class="form-control form-control-sm">
									<option value="1">JSS1</option>
									<option value="2">JSS2</option>
									<option value="3">JSS3</option>
								</select>
							</div>
							<div id="classValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="religion">Religion:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 far fa-church"></i>
								<select type="text" name="religion" id="religion" class="form-control form-control-sm">
									<option value="christian">Christianity</option>
									<option value="muslim">Islamic</option>
									<option value="others">Others</option>
								</select>
							</div>
							<div id="religionValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="state_sel">State</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 far fa-landmark"></i>
								<select class="form-control form-control-sm" id="state_sel" name="state_sel" required>
									<option id="1" value="Abia State">Abia State</option>
									<option id="2" value="Adamawa State">Adamawa State</option>
									<option id="3" value="Akwa Ibom State">Akwa Ibom State</option>
									<option id="4" value="Anambara State">Anambara State</option>
									<option id="5" value="Bauchi State">Bauchi State</option>
									<option id="6" value="Bayelsa State">Bayelsa State</option>
									<option id="7" value="Benue State">Benue State</option>
									<option id="8" value="Borno State">Borno State</option>
									<option id="9" value="Cross-Rivers State">Cross-Rivers State</option>
									<option id="10" value="Delta State">Delta State</option>
									<option id="11" value="Ebonyi State">Ebonyi State</option>
									<option id="12" value="Edo State">Edo State</option>
									<option id="13" value="Ekiti State">Ekiti State</option>
									<option id="14" value="Enugu State">Enugu State</option>
									<option id="15" value="Gombe State">Gombe State</option>
									<option id="16" value="Imo State">Imo State</option>
									<option id="17" value="Jigawa State">Jigawa State</option>
									<option id="18" value="Kaduna State">Kaduna State</option>
									<option id="19" value="Kano State">Kano State</option>
									<option id="20" value="Katsina State">Katsina State</option>
									<option id="21" value="Kebbi State">Kebbi State</option>
									<option id="22" value="Kogi State">Kogi State</option>
									<option id="23" value="Kwara State">Kwara State</option>
									<option id="24" value="Lagos State">Lagos State</option>
									<option id="25" value="Nassarawa State">Nassarawa State</option>
									<option id="26" value="Niger State">Niger State</option>
									<option id="27" value="Ogun State">Ogun State</option>
									<option id="28" value="Ondo State">Ondo State</option>
									<option id="39" value="Osun State">Osun State</option>
									<option id="30" value="Oyo State">Oyo State</option>
									<option id="31" value="Plateau State">Plateau State</option>
									<option id="32" value="Rivers State">Rivers State</option>
									<option id="33" value="Sokoto State">Sokoto State</option>
									<option id="34" value="Taraba State">Taraba State</option>
									<option id="35" value="Yobe State">Yobe State</option>
									<option id="36" value="Zamfara State">Zamfara State</option>
									<option id="37" value="Abuja FCT">Abuja FCT</option>
								</select>
							</div>
							<div id="state_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="lga_sel">L.G.A:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 far fa-map-marker-alt"></i>
								<select class="form-control form-control-sm" id="lga_sel" name="lga_sel">
									<option value=""></option>
								</select>
							</div>
							<div id="lga_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="dob">Birth Date:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 far fa-calendar-alt"></i>
								<input type="date" min="1999-12-31" max="2010-12-31" name="dob" id="dob" class="form-control form-control-sm" placeholder="" />
							</div>
							<div id="dobValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="gender">Gender:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 far fa-transgender-alt"></i>
								<select name="gender" id="gender" class="form-control form-control-sm">
									<option value="" selected disabled>Select your Gender...</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
							<div id="genderValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="phone">Phone Number:</label></div>
							<div class="input-group">
								<i class="p-2 far fa-phone"></i>
								<input type="text" pattern="^[0-9]\d*$" class="form-control form-control-sm" name="phone" minlength="5" maxlength="15" id="phone" aria-describedby="helpId" placeholder="Phone">
							</div>
							<div id="phoneValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<div class="d-flex align-items-center">Do you have any medical conditions? <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 far fa-question-circle"></i>
								<div class="d-flex">
									<div class="d-flex align-items-center mr-2"><label for="med_con_yes" class="mx-1">Yes:</label> <input type="radio" name="med_con" class="med_con" id="med_con_yes" value="yes" /></div>
									<div class="d-flex align-items-center ml-2"><label for="med_con_no" class="mx-1">No:</label> <input type="radio" name="med_con" class="med_con" id="med_con_no" value="no" /></div>
								</div>
							</div>
							<div id="med_conValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="raddress">Residential Address:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 py-4 far fa-home"></i>
								<textarea name="raddress" id="raddress" rows="" cols="" class="form-control form-control-sm" placeholder="Residential Address..."></textarea>
							</div>
							<div id="raddressValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-6 order-md-last order-first">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="med_det">If Yes, Please give details:</label> <span class="med_req w3-text-red w3-large mx-1" hidden>*</span></div>
							<div class="input-group">
								<i class="p-2 py-4 far fa-medkit"></i>
								<textarea name="med_det" id="med_det" rows="" cols="" class="form-control form-control-sm" placeholder="Medical Conditions..."></textarea>
							</div>
							<div id="med_detValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
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
								<a class="clear j-link btn btn-danger my-md-0 my-1" data-form="edit-student-form"><i class="fa fa-times"></i> clear</a>
								<a class="reset j-link btn btn-secondary my-md-0 my-1" data-form="edit-parent-form"><i class="fa fa-redo"></i> Reset</a>
								<a class="switch-stu j-link btn btn-secondary my-md-0 my-1">Edit parent/guardian info <i class="fa fa-caret-circle-right"></i></a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="form" style="display: none">
			<form action="./include/classes/manage.php" method="post" id="edit-parent-form">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="p_g_name">Parent/Guardian Name:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 far fa-users"></i>
								<input type="text" name="p_g_name" id="p_g_name" class="form-control form-control-sm" placeholder="Input Parent/Guardian Name" />
							</div>
							<div id="p_g_nameValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-6 order-md-last order-first">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="p_g_phone">Parent/Guardian Phone:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 far fa-phone-plus"></i>
								<input type="text" name="p_g_phone" id="p_g_phone" pattern="^[0-9]\d*$" class="form-control form-control-sm" placeholder="Parent/Guardian Phone Number" />
							</div>
							<div id="p_g_phoneValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="p_g_occ">Parent/Guardian Occupation:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 py-4 far fa-building"></i>
								<textarea name="p_g_occ" id="p_g_occ" rows="" cols="" class="form-control form-control-sm" placeholder="Parent/Guardian Occupation..."></textarea>
							</div>
							<div id="p_g_occValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
								<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<div class="d-flex align-items-center"><label for="p_g_raddress">Parent/Guardian Residential Address:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
							<div class="input-group">
								<i class="p-2 py-4 far fa-home"></i>
								<textarea name="p_g_raddress" id="p_g_raddress" rows="" cols="" class="form-control form-control-sm" placeholder="Parent/Guardian Residential Address..."></textarea>
							</div>
							<div id="p_g_raddressValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
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
								<a class="clear j-link btn btn-danger my-md-0 my-1" data-form="edit-parent-form"><i class="fa fa-times"></i> Clear</a>
								<a class="reset j-link btn btn-secondary my-md-0 my-1" data-form="edit-parent-form"><i class="fa fa-redo"></i> Reset</a>
								<a class="switch-stu j-link btn btn-secondary my-md-0 my-1"><i class="fa fa-caret-circle-left"></i> Edit Student info</a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$('a.switch-stu').click(function (e) {
		$('.form').animate({
			'width': 'toggle',
			'padding-left': 'toggle',
			'padding-right': 'toggle',
			'opacity': 'toggle'
		})
	})
</script>