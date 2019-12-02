<?php include 'include/header.php'; ?>
<div id="body" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 offset-lg-2 col-md-10 col-lg-8">
            <form action="./include/classes/student.php" method="post" id="register-form" enctype="multipart/form-data">
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
                            <label for="passport" class="label">Select Passport to Upload... <span class="w3-text-red w3-large">*</span></label>
                            <div class="input-group">
                                <i class="p-2 fa fa-passport"></i>
                                <input type="file" name="passport" id="passport" class="form-control form-control-file form-control-sm" placeholder="Upload a Passport" />
                            </div>
                            <div id="passportValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
                                <div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="d-flex align-items-center"><label for="fname">First Name:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
                            <div class="input-group">
                                <i class="p-2 fa fa-user"></i>
                                <input type="text" name="fname" id="fname" class="form-control form-control-sm" placeholder="Input Firstname" />
                            </div>
                            <div id="fnameValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
                                <div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mname">Middle Name:</label>
                            <div class="input-group">
                                <i class="p-2 fa fa-user-plus d-md-none"></i>
                                <input type="text" name="mname" id="mname" class="form-control form-control-sm" placeholder="Input Middle name" />
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
                                <i class="p-2 fa fa-user-plus d-md-none"></i>
                                <input type="text" name="lname" id="lname" class="form-control form-control-sm" placeholder="Input Last name" />
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
                                <i class="p-2 fa fa-user-tag"></i>
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
                                <i class="p-2 fa fa-users-class"></i>
                                <select type="text" name="class" id="class" class="form-control form-control-sm">
                                    <option value="" disabled selected>Select your class...</option>
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
                                <i class="p-2 fa fa-church"></i>
                                <select type="text" name="religion" id="religion" class="form-control form-control-sm">
                                    <option value="" disabled selected>Choose you religion...</option>
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
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="d-flex align-items-center"><label for="state_sel">State</label> <span class="w3-text-red w3-large mx-1">*</span></div>
                            <div class="input-group">
                                <i class="p-2 fa fa-landmark"></i>
                                <select class="form-control form-control-sm" id="state_sel" name="state_sel" required>
                                    <option value="" disabled selected>Select Your State...</option>
                                    <option id="1">Abia State</option>
                                    <option id="2">Adamawa State</option>
                                    <option id="3">Akwa Ibom State</option>
                                    <option id="4">Anambara State</option>
                                    <option id="5">Bauchi State</option>
                                    <option id="6">Bayelsa State</option>
                                    <option id="7">Benue State</option>
                                    <option id="8">Borno State</option>
                                    <option id="9">Cross-Rivers State</option>
                                    <option id="10">Delta State</option>
                                    <option id="11">Ebonyi State</option>
                                    <option id="12">Edo State</option>
                                    <option id="13">Ekiti State</option>
                                    <option id="14">Enugu State</option>
                                    <option id="15">Gombe State</option>
                                    <option id="16">Imo State</option>
                                    <option id="17">Jigawa State</option>
                                    <option id="18">Kaduna State</option>
                                    <option id="19">Kano State</option>
                                    <option id="20">Katsina State</option>
                                    <option id="21">Kebbi State</option>
                                    <option id="22">Kogi State</option>
                                    <option id="23">Kwara State</option>
                                    <option id="24">Lagos State</option>
                                    <option id="25">Nassarawa State</option>
                                    <option id="26">Niger State</option>
                                    <option id="27">Ogun State</option>
                                    <option id="28">Ondo State</option>
                                    <option id="39">Osun State</option>
                                    <option id="30">Oyo State</option>
                                    <option id="31">Plateau State</option>
                                    <option id="32">Rivers State</option>
                                    <option id="33">Sokoto State</option>
                                    <option id="34">Taraba State</option>
                                    <option id="35">Yobe State</option>
                                    <option id="36">Zamfara State</option>
                                    <option id="37">Abuja FCT</option>
                                </select>
                            </div>
                            <div id="state_selValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
                                <div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="d-flex align-items-center"><label for="lga_sel">L.G.A:</label> <span class="w3-text-red w3-large mx-1">*</span></div>
                            <div class="input-group">
                                <i class="p-2 fa fa-map-marker-alt"></i>
                                <select class="form-control form-control-sm" id="lga_sel" name="lga_sel" disabled required>
                                    <option value="" disabled selected>Select Your State first...</option>
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
                                <i class="p-2 fa fa-calendar-alt"></i>
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
                                <i class="p-2 fa fa-transgender-alt"></i>
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
                                <i class="p-2 fa fa-phone"></i>
                                <input type="text" pattern="^[0-9]\d*$" class="form-control form-control-sm" name="phone" minlength="5" maxlength="15" id="phone" placeholder="Phone">
                            </div>
                        </div>
                        <div id="phoneValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
                            <div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="d-flex align-items-center">Do you have any medical conditions? <span class="w3-text-red w3-large mx-1">*</span></div>
                            <div class="input-group">
                                <i class="p-2 fa fa-question-circle"></i>
                                <div class="d-flex">
                                    <div class="d-flex align-items-center mr-2"><label for="med_con_yes" class="mx-1">Yes:</label> <input type="radio" name="med_con" id="med_con_yes" value="yes" /></div>
                                    <div class="d-flex align-items-center ml-2"><label for="med_con_no" class="mx-1">No:</label> <input type="radio" name="med_con" id="med_con_no" value="no" checked /></div>
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
                                <i class="p-2 py-4 fa fa-home"></i>
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
                                <i class="p-2 py-4 fa fa-medkit"></i>
                                <textarea name="med_det" id="med_det" rows="" cols="" class="form-control form-control-sm" placeholder="Medical Conditions..." disabled></textarea>
                            </div>
                            <div id="med_detValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
                                <div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />

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

                    <div class="col-md-6">
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
<script>
$(document).ready(function() {
    let stu_class = $('#class');

    $.post('./include/stu_classes.php', {
        action: 'get-classes'
    }, function(response) {
        stu_class.append(response);
    });
});
</script>

<?php include './include/footer.php'; ?>