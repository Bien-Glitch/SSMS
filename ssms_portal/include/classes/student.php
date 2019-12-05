<?php
	require_once '../session.php';
	sleep(number_format(0.5));

	/**
	 * Class student for SSMS Portal Students
	 * @author Fusion Bolt inc <fusionboltinc@gmail.com>
	 */
	class student
	{
		private $link;

		/**
		 * student constructor.
		 * @param $link mysqli identifier returned by mysqli connection
		 */
		public function __construct($link)
		{
			$this->link = $link;
		}

		/**
		 * Checks if student exists using student's admission number
		 * @param $adm_id string Student's admission number
		 * @return bool
		 */
		public function studentIDExists($adm_id)
		{
			$q = $this->link->query("SELECT * FROM `students` WHERE `adm_id` = '{$adm_id}' LIMIT 1");

			if ($q->num_rows > 0) {
				return true;

			} else {
				return false;
			}
		}

		/**
		 * Checks if student exists using student' name
		 * @param $fname string student's first name
		 * @param $mname string student's middle name
		 * @param $lname string student's last name
		 * @return bool
		 */
		public function studentNameExists($fname, $mname, $lname)
		{
			$q = $this->link->query("SELECT * FROM `students` WHERE (`fname` = '{$fname}' AND `mname` = '$mname' AND `lname` = '{$lname}') LIMIT 1");

			if ($q->num_rows > 0) {
				return true;

			} else {
				return false;
			}
		}

		/**
		 * @param $user_login
		 * @param $user_passcode
		 * @return array
		 */
		public function studentLogin($user_login, $user_passcode)
		{
			$data['message'] = '';
			$student_exists = $this->studentIDExists($user_login);

			if ($student_exists) {
				$user_passcode = md5($user_passcode);
				$q = $this->link->query("SELECT * FROM `students` WHERE (`adm_id` = '{$user_login}' AND `pcode` = '{$user_passcode}')");

				if ($q && $q->num_rows > 0) {
					$row = $q->fetch_array();
					$_SESSION['user_login'] = $user_login;

					$data['message'] .= '
						<script>
							$("#login-form #login").removeClass("regerr");
							$("#login-form #pcode").removeClass("regerr");
							
							$("#login-form #loginValidate").fadeOut();
							$("#login-form #pcodeValidate").fadeOut();
							localStorage.setItem(\'log_student_id\', "'.$row['id'].'");
						</script>
						<div class="alert alert-success">
							<small>
								<i class="fa fa-check-double"></i>
								Login Successful<br />
								<i class="fa fa-spin fa-spinner-third"></i> Please Wait...
							</small>
						</div>
					';
					$data['status'] = '200';

				} else {
					if (!$q) {
						$data['message'] .= '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									Oops, that was from us, contact us if this error continues: Login Validate failed!!!
									<small>Click to dismiss</small>
								</small>
							</div>
						';
					}

					if ($q->num_rows < 1) {
						$data['message'] = '
							<script>$("#login-form #pcode").addClass("regerr").focus();</script>
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									Login Failed, Passcode incorrect!!!<br />
									<small>Click to dismiss</small>
								</small>
							</div>
						';
					}
					$data['status'] = '300';
				}

			} else {
				$data['message'] .= '
					<script>$("#login-form #login").addClass("regerr").focus();</script>
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							Login failed, student with admission number: ' . $user_login . ' doesn\'t exist!!!<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
				$data['status'] = '300';
			}

			return ['data' => $data];
		}

		/**
		 * @param $passport
		 * @param $fname
		 * @param $mname
		 * @param $lname
		 * @param $admno
		 * @param $class
		 * @param $religion
		 * @param $state_sel
		 * @param $lga_sel
		 * @param $dob
		 * @param $gender
		 * @param $phone
		 * @param $raddress
		 * @param $med_con
		 * @param $med_det
		 * @param $p_g_name
		 * @param $p_g_phone
		 * @param $p_g_occ
		 * @param $p_g_raddress
		 * @return array
		 */
		public function studentRegister($passport, $fname, $mname, $lname, $admno, $class, $religion, $state_sel, $lga_sel, $dob, $gender, $phone, $raddress, $med_con, $med_det, $p_g_name, $p_g_phone, $p_g_occ, $p_g_raddress, $date)
		{
			$data['message'] = '';
			$student_id_exists = $this->studentIDExists($admno);
			$student_name_exists = $this->studentNameExists($fname, $mname, $lname);

			if (!$student_name_exists && !$student_id_exists) {
				if ((strlen($fname) < 51 && strlen($fname) > 1) && (strlen($p_g_name) < 103 && strlen($p_g_name) > 3)) {
					if (strlen($p_g_phone) < 16 && strlen($p_g_phone) > 4) {
						$pcode = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
						$pcode = substr(str_shuffle($pcode), 0, 8);
						$pcode_db = md5($pcode);

						$student_q = $this->link->query("INSERT INTO `students`(`id`, `adm_id`, `class_id`, `passport`, `fname`, `mname`, `lname`, `gender`, `dob`, `pnum`, `sor`, `lga`, `med_con`, `med_con_det`, `r_address`, `religion`, `pcode`, `token`, `reg_date`) VALUES (NULL, '{$admno}', '{$class}', '', '{$fname}', '{$mname}', '{$lname}', '{$gender}', '{$dob}', '{$phone}', '{$state_sel}', '{$lga_sel}', '{$med_con}', '{$med_det}', '{$raddress}', '{$religion}', '{$pcode_db}', '', '{$date}')");

						$success = '
							<div class="alert alert-success continue">
								<small>
									<i class="fa fa-check-double"></i>
									Registration Successful and your passcode is <kbd class="w3-medium">' . $pcode . '</kbd><br />
									Click the passcode to copy!!!<br />
									<i class="fa fa-spin fa-spinner-third"></i> 
									Click to continue...
								</small>
							</div>
						';

						$failure = '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									Oops that was from us, contact us if this error continues: Register to DB!!!<br />
									' . mysqli_error($this->link) . '<br />
									<small>Click to dismiss</small>
								</small>
							</div>
						';

						if ($student_q) {
							$q = $this->link->query("SELECT `id` FROM `students` WHERE `adm_id` = '{$admno}' LIMIT 1");
							$row = $q->fetch_assoc();
							$cid = $row['id'];

							if ($cid > 1) {
								$q = $this->link->query("SELECT `id` FROM `students` WHERE `id` < '{$cid}' ORDER BY `id` DESC LIMIT 1");
								$row = $q->fetch_assoc();
								$pid = $row['id'];

								$pid += 1;
								$q = $this->link->query("UPDATE `students` SET `id` = '{$pid}' WHERE `adm_id` = '{$admno}'");

								if ($q) {
									$p_check = $this->link->query("SELECT * FROM `parents` WHERE `student_id` = '{$admno}' LIMIT 1");
									if ($p_check->num_rows < 1) {
										$parent_q = $this->link->query("INSERT INTO `parents`(id, `student_id`, `name`, `phone`, `occupation`, `address`) VALUES(NULL, '{$admno}', '{$p_g_name}', '{$p_g_phone}', '{$p_g_occ}', '{$p_g_raddress}')");

										if ($parent_q) {
											$q = $this->link->query("SELECT `id` FROM `parents` WHERE `student_id` = '{$admno}'");
											$row = $q->fetch_assoc();
											$cid = $row['id'];

											if ($cid > 1) {
												$q = $this->link->query("SELECT `id` FROM `parents` WHERE `id` < '{$cid}' ORDER BY `id` DESC LIMIT 1");
												$row = $q->fetch_assoc();
												$pid = $row['id'];

												$pid += 1;
												$q = $this->link->query("UPDATE `parents` SET `id` = '{$pid}' WHERE `student_id` = '{$admno}'");

												if ($q) {
													$data['message'] = $success;
													$data['status'] = '200';
												}
											}

										} else {
											$q = $this->link->query("DELETE FROM `students` WHERE adm_id = '{$admno}'");
											$data['message'] = $failure;
											$data['status'] = '300';
										}

									} else {
										$q = $this->link->query("DELETE FROM `students` WHERE adm_id = '{$admno}'");
										$data['message'] .= '
											<script>$("#register-form #admno").addClass("regerr").focus();</script>
											<div class="alert alert-danger remove">
												<small>
													<i class="fa fa-exclamation-triangle"></i>
													Inputted admission number already exists!!!<br />
													<small>Click here to dismiss</small>
												</small>
											</div>
										';
										$data['status'] = '300';
									}
								}

							} else {
								$p_check = $this->link->query("SELECT * FROM `parents` WHERE `student_id` = '{$admno}' LIMIT 1");
								if ($p_check->num_rows < 1) {
									$parent_q = $this->link->query("INSERT INTO `parents`(id, `student_id`, `name`, `phone`, `occupation`, `address`) VALUES(NULL, '{$admno}', '{$p_g_name}', '{$p_g_phone}', '{$p_g_occ}', '{$p_g_raddress}')");
									if ($parent_q) {
										$q = $this->link->query("SELECT `id` FROM `parents` WHERE `student_id` = '{$admno}'");
										$row = $q->fetch_assoc();
										$cid = $row['id'];

										if ($cid < 2) {
											$data['message'] = $success;
											$data['status'] = '200';
										}

									} else {
										$q = $this->link->query("DELETE FROM `students` WHERE adm_id = '{$admno}'");
										$data['message'] = $failure;
										$data['status'] = '300';
									}

								} else {
									$q = $this->link->query("DELETE FROM `students` WHERE adm_id = '{$admno}'");
									$data['message'] .= '
											<script>$("#register-form #admno").addClass("regerr").focus();</script>
											<div class="alert alert-danger remove">
												<small>
													<i class="fa fa-exclamation-triangle"></i>
													Inputted admission number already exists!!!<br />
													<small>Click here to dismiss</small>
												</small>
											</div>
										';
									$data['status'] = '300';
								}
							}
							if ($data['message'] == $success) {

								$n_admno = $admno;
								$n_admno = str_replace('/', '-', $n_admno);

								$pic_settings = [
									'path' => './../../data/student_pics/' . $n_admno . '/',
									'db_path' => './data/student_pics/' . $n_admno . '/',
									'max_size' => '20971520',
									'allowed_ext' => ['jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG', 'gif', 'GIF', 'bmp', 'BMP'],
								];

								$pic_type = $passport['type'];
								$pic_size = $passport['size'];
								$pic_tmp_name = $passport['tmp_name'];
								$pic_name = basename($passport['name']);
								$pic_ext = explode('.', $pic_name);
								$ext = end($pic_ext);

								$pic_name = str_replace('_', '-', $pic_name);
								$pic_type = explode('/', $pic_type);
								$pic_type = $pic_type[0];

								if (($pic_type == 'image') && in_array($ext, $pic_settings['allowed_ext'])) {
									if ($pic_size <= $pic_settings['max_size']) {
										$chars = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
										$rand = substr(str_shuffle($chars), 0, 10);

										$final_dest = $pic_settings['path'] . $date . '/';
										$db_final_dest = $pic_settings['db_path'] . $date . '/';

										$pic_final_name = $date . '_' . $pic_name; ## Append current space separated time to name of image; concat with underscore

										$pic = $final_dest . $rand . '/' . $pic_final_name;
										$db_pic = $db_final_dest . $rand . '/' . $pic_final_name;

										if (!file_exists($pic_settings['path'])) {
											# code...
											mkdir($pic_settings['path']); ## Create the Upload Path
											mkdir($final_dest); ## Create the Final Upload Path
											mkdir($final_dest . $rand . '/');

										} else {
											# code...
											if (!file_exists($final_dest)) {
												# code...
												mkdir($final_dest); ## Create the Final Upload Path
											}
											mkdir($final_dest . $rand . '/'); ## Create the Final Upload Path
										}

										if (move_uploaded_file($pic_tmp_name, $pic)) {
											# code...
											$update_stu_passport = $this->link->query("UPDATE `students` SET `passport` = '{$db_pic}' WHERE `adm_id` = '{$admno}'");
											$insert_stu_passport = $this->link->query("INSERT INTO `student_passports`(`id`, `student_id`, `passport`) VALUES (NULL, '{$admno}', '{$db_pic}')");

											if ($update_stu_passport && $insert_stu_passport) {
												# code...
												$data['message'] = $success;
												$data['status'] = '200';

											} else {
												$q = $this->link->query("DELETE FROM `students` WHERE adm_id = '{$admno}'");
												$q = $this->link->query("DELETE FROM `parents` WHERE student_id = '{$admno}'");
												$q = $this->link->query("DELETE FROM `student_passports` WHERE student_id = '{$admno}'");
												$data['message'] = $failure;
												$data['status'] = '300';
											}

										} else {
											$q = $this->link->query("DELETE FROM `students` WHERE adm_id = '{$admno}'");
											$q = $this->link->query("DELETE FROM `parents` WHERE student_id = '{$admno}'");
											$q = $this->link->query("DELETE FROM `student_passports` WHERE student_id = '{$admno}'");
											$data['message'] .= '
												<script>$("#passport").addClass("regerr").focus()</script>
												<div class="alert alert-danger remove">
													<small>
														<i class="fa fa-exclamation-circle"></i>
														Oops that was from us, please contact us if this error continues: Cannot move file to specified location -- Registration aborted!!!<br />
														' . mysqli_error($this->link) . '<br />
														<small>CLick to dismiss</small>
													</small>
												</div>
											';
											$data['status'] = '300';
										}

									} else {
										$q = $this->link->query("DELETE FROM `students` WHERE adm_id = '{$admno}'");
										$q = $this->link->query("DELETE FROM `parents` WHERE student_id = '{$admno}'");
										$q = $this->link->query("DELETE FROM `student_passports` WHERE student_id = '{$admno}'");
										$data['message'] .= '
											<script>$("#passport").addClass("regerr").focus()</script>
											<div class="alert alert-danger remove">
												<small>
													<i class="fa fa-exclamation-circle"></i>
													Picture exceeds Max Upload size -- Registration aborted!!!<br />
													<small>CLick to dismiss</small>
												</small>
											</div>
										';
										$data['status'] = '300';
									}

								} else {
									$q = $this->link->query("DELETE FROM `students` WHERE adm_id = '{$admno}'");
									$q = $this->link->query("DELETE FROM `parents` WHERE student_id = '{$admno}'");
									$q = $this->link->query("DELETE FROM `student_passports` WHERE student_id = '{$admno}'");
									$data['message'] .= '
										<script>$("#passport").addClass("regerr").focus()</script>
										<div class="alert alert-danger remove">
											<small>
												<i class="fa fa-exclamation-circle"></i>
												Selected file is not an image; Please select an image with any of the following formats: \'jpg\', \'png\', \'gif\' or \'bmp\' -- Registration aborted<br />
												<small>CLick to dismiss</small>
											</small>
										</div>
									';
									$data['status'] = '300';
								}

							}

						} else {
							$data['message'] = $failure;
							$data['status'] = '300';
						}

					} else {
						$data['message'] = '
							<script>
								$("#register-form #p_g_phone").addClass("regerr").focus();
								$("#register-form #p_g_phoneValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Phone number must be between 5 - 15 digits!!!</small>");
								$("#register-form #p_g_phoneValidate")
								.removeClass("alert-success")
								.removeClass("alert-danger")
								.addClass("alert-danger")
								.fadeIn();							
							</script>
						';
					}

				} else {
					if (strlen($fname) < 2 || strlen($fname) > 50) {
						$data['message'] .= '
							<script>
								$("#register-form #fname").addClass("regerr");
								$("#register-form #fnameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Field length is between 2 - 50 characters!!!</small>");
								$("#register-form #fnameValidate")
								.removeClass("alert-success")
								.removeClass("alert-danger")
								.addClass("alert-danger")
								.fadeIn();
							</script>
						';
					}

					if (strlen($p_g_name) < 4 || strlen($p_g_name) > 102) {
						$data['message'] .= '
							<script>
								$("#register-form #p_g_name").addClass("regerr");
								$("#register-form #p_g_nameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Field length is between 4 - 102 characters!!!</small>");
								$("#register-form #p_g_nameValidate")
								.removeClass("alert-success")
								.removeClass("alert-danger")
								.addClass("alert-danger")
								.fadeIn();
							</script>
						';
					}
					$data['status'] = '300';
				}

			} else {
				if ($student_name_exists) {
					$data['message'] .= '
						<script>
							$("#register-form #fname").addClass("regerr").focus();
							$("#register-form #mname").addClass("regerr");
							$("#register-form #lname").addClass("regerr");
						</script>
						<div class="alert alert-danger remove">
							<small>
								<i class="fa fa-exclamation-triangle"></i>
								Inputted Students Name already exists!!!<br />
								Change either First name, Middle name, Last name or all!!!<br />
								<small>Click here to dismiss</small>
							</small>
						</div>
					';
				}

				if ($student_id_exists) {
					$data['message'] .= '
						<script>$("#register-form #admno").addClass("regerr").focus();</script>
						<div class="alert alert-danger remove">
							<small>
								<i class="fa fa-exclamation-triangle"></i>
								Inputted admission number already exists!!!<br />
								<small>Click here to dismiss</small>
							</small>
						</div>
					';
				}
				$data['status'] = '300';
			}
			return ['data' => $data];
		}
	}

	//----> Function Calls <----//
	if ((isset($_POST) || isset($_GET)) && (!empty($_POST['action']) || !empty($_GET['action']))) {
		if (!empty($_GET)) {
			$action = $_GET['action']; ## Assign GET index: action; to variable $action

		} elseif (!empty($_POST['action'])) {
			$action = $_POST['action']; ## Assign POST index: action; to variable $action
		}

		$data['message'] = '';

		// Initialize Login Script if $action = login
		if ($action == 'login') {
			extract($_POST); ## Extract POST values

			if (!empty($user_login) && !empty($user_passcode)) {
				$data['message'] = '
					<script>
						$("#login-form #login").removeClass("regerr");
						$("#login-form #pcode").removeClass("regerr");
						
						$("#login-form #loginValidate").fadeOut("");
						$("#login-form #pcodeValidate").fadeOut("");
					</script>
				';

				$login = new student($connect);
				$data['login'] = $login->studentLogin($user_login, $user_passcode);
				$data['status'] = '200';

			} else {
				if (empty($user_login)) {
					$data['message'] .= '
						<script>
							$("#login-form #login").addClass("regerr");
							$("#login-form #loginValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Admission Number is required!!!</small>");
							$("#login-form #loginValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($user_passcode)) {
					$data['message'] .= '
						<script>
							$("#login-form #pcode").addClass("regerr");
							$("#login-form #pcodeValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Passcode field is required!!!</small>");
							$("#login-form #pcodeValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				$data['message'] .= '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							Fill in all fields to continue!!!<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
				$data['status'] = '300';
			}

			echo json_encode(['data' => $data]);
		}

		// Initialize Register Script if $action = register
		if ($action == 'register') {
			extract($_POST); ## Extract POST values
			extract($_FILES); ## Extract FILES values

			$interval = $start->diff(new DateTime("{$dob}")); ## $interval: Calculate difference btw current date and Date of Birth
			$age = $interval->y; ## Current age

			if ((!empty($passport) && !empty($fname) && !empty($lname) && !empty($admno) && !empty($class) && !empty($religion) && !empty($state_sel) &&
			     !empty($lga_sel) && !empty($dob) && !empty($gender) && !empty($raddress) && !empty($p_g_name) && !empty($p_g_phone) &&
			     !empty($p_g_occ) && !empty($p_g_raddress) && !empty($med_con))) {

				if (empty($med_det)) {
					$med_det = NULL;
				}

				$m_m = NULL;
				$m_p = NULL;

				$raddress = preg_replace("/\n/", "<br />", "$raddress");
				$med_det = preg_replace("/\n/", "<br />", "$med_det");
				$p_g_occ = preg_replace("/\n/", "<br />", "$p_g_occ");
				$p_g_raddress = preg_replace("/\n/", "<br />", "$p_g_raddress");

				$fname = str_replace("'", "''", $fname);
				$lname = str_replace("'", "''", $lname);
				$mname = str_replace("'", "''", $mname);
				$admno = str_replace("'", "''", $admno);
				$phone = str_replace("'", "''", $phone);
				$raddress = str_replace("'", "''", $raddress);
				$med_det = str_replace("'", "''", $med_det);
				$p_g_name = str_replace("'", "''", $p_g_name);
				$p_g_phone = str_replace("'", "''", $p_g_phone);
				$p_g_occ = str_replace("'", "''", $p_g_occ);
				$p_g_raddress = str_replace("'", "''", $p_g_raddress);

				if (!empty($mname) || !empty($phone)) {
					if (!empty($mname)) {
						if (strlen($mname) < 2 || strlen($mname) > 50) {
							$data['message'] .= '
								<script>
									$("#register-form #mname").addClass("regerr");
									$("#register-form #mnameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Field length must be between 2 - 50 characters!!!</small>");
									$("#register-form #mnameValidate")
									.removeClass("alert-success")
									.removeClass("alert-danger")
									.addClass("alert-danger")
									.fadeIn();
								</script>
							';
							$data['status'] = '300';
							$m_m .= 'exit';
						}
					}

					if (!empty($phone)) {
						if (strlen($phone) < 4 || strlen($phone) > 15) {
							$data['message'] .= '
								<script>
									$("#register-form #phone").addClass("regerr");
									$("#register-form #phoneValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Phone Number must be between 5 - 15 digits!!!</small>");
									$("#register-form #phoneValidate")
									.removeClass("alert-success")
									.removeClass("alert-danger")
									.addClass("alert-danger")
									.fadeIn();
								</script>
							';
							$data['status'] = '300';
							$m_p .= 'exit';
						}
					}

					if (($m_m == 'exit') || $m_p == 'exit') {
						echo json_encode(['data' => $data]);
						exit();
					}
				}

				if (((($med_con) == 'no') && empty($med_det)) || (($med_con) == 'yes') && !empty($med_det)) {
					if (($age) < 8 || ($age) > 20) {
						$data['message'] .= '
							<script>
								$("#register-form #dob").addClass("regerr").focus();
								$("#register-form #dobValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> You must be between 8 - 20 yrs of age!!!</small>");
								$("#register-form #dobValidate")
								.removeClass("alert-success")
								.removeClass("alert-danger")
								.addClass("alert-danger")
								.fadeIn();
							</script>
						';
						$data['status'] = '300';
						echo json_encode(['data' => $data]);
						exit();
					}

					$data['message'] = '
						<script>
							$("#register-form #passport").removeClass("regerr");
							$("#register-form #fname").removeClass("regerr");
							$("#register-form #mname").removeClass("regerr");
							$("#register-form #lname").removeClass("regerr");
							$("#register-form #admno").removeClass("regerr");
							$("#register-form #class").removeClass("regerr");
							$("#register-form #religion").removeClass("regerr");
							$("#register-form #state_sel").removeClass("regerr");
							$("#register-form #lga_sel").removeClass("regerr");
							$("#register-form #dob").removeClass("regerr");
							$("#register-form #gender").removeClass("regerr");
							$("#register-form #phone").removeClass("regerr");
							$("#register-form #raddress").removeClass("regerr");
							$("#register-form #med_det").removeClass("regerr");
							
							$("#register-form #passportValidate").fadeOut("");
							$("#register-form #fnameValidate").fadeOut("");
							$("#register-form #mnameValidate").fadeOut("");
							$("#register-form #lnameValidate").fadeOut("");
							$("#register-form #admnoValidate").fadeOut("");
							$("#register-form #classValidate").fadeOut("");
							$("#register-form #religionValidate").fadeOut("");
							$("#register-form #state_selValidate").fadeOut("");
							$("#register-form #lga_selValidate").fadeOut("");
							$("#register-form #dobValidate").fadeOut("");
							$("#register-form #genderValidate").fadeOut("");
							$("#register-form #phoneValidate").fadeOut("");
							$("#register-form #raddressValidate").fadeOut("");
							$("#register-form #med_conValidate").fadeOut("");
							$("#register-form #med_detValidate").fadeOut("");
							
							$("#register-form #p_g_name").removeClass("regerr");
							$("#register-form #p_g_phone").removeClass("regerr");
							$("#register-form #p_g_occ").removeClass("regerr");
							$("#register-form #p_g_raddress").removeClass("regerr");
							
							$("#register-form #p_g_nameValidate").fadeOut("");
							$("#register-form #p_g_phoneValidate").fadeOut("");
							$("#register-form #p_g_occValidate").fadeOut("");
							$("#register-form #p_g_raddressValidate").fadeOut("");
						</script>
					';

					$register = new student($connect);
					$data['register'] = $register->studentRegister($passport, $fname, $mname, $lname, $admno, $class, $religion, $state_sel, $lga_sel, $dob, $gender, $phone, $raddress, $med_con, $med_det, $p_g_name, $p_g_phone, $p_g_occ, $p_g_raddress, $date);
					$data['status'] = '200';

				} else {
					$data['message'] .= '
						<script>
							$("#register-form #med_det").addClass("regerr");
							$("#register-form #med_detValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please input you medical condition(s)!!!</small>");
							$("#register-form #med_detValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
					$data['status'] = '300';
				}

			} else {
				if (empty($passport)) {
					$data['message'] .= '
						<script>
							$("#register-form #passport").addClass("regerr");
							$("#register-form #passportValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> A passport photo is required!!!</small>");
							$("#register-form #passportValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($fname)) {
					$data['message'] .= '
						<script>
							$("#register-form #fname").addClass("regerr");
							$("#register-form #fnameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> First name field is required!!!</small>");
							$("#register-form #fnameValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($lname)) {
					$data['message'] .= '
						<script>
							$("#register-form #lname").addClass("regerr");
							$("#register-form #lnameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Last name field is required!!!</small>");
							$("#register-form #lnameValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($admno)) {
					$data['message'] .= '
						<script>
							$("#register-form #admno").addClass("regerr");
							$("#register-form #admnoValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Admission Number is required!!!</small>");
							$("#register-form #admnoValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($class)) {
					$data['message'] .= '
						<script>
							$("#register-form #class").addClass("regerr");
							$("#register-form #classValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please select your class!!!</small>");
							$("#register-form #classValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($religion)) {
					$data['message'] .= '
						<script>
							$("#register-form #religion").addClass("regerr");
							$("#register-form #religionValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please select your religion!!!</small>");
							$("#register-form #religionValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($state_sel)) {
					$data['message'] .= '
						<script>
							$("#register-form #state_sel").addClass("regerr");
							$("#register-form #state_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please select your state!!!</small>");
							$("#register-form #state_selValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($lga_sel)) {
					$data['message'] .= '
						<script>
							$("#register-form #lga_sel").addClass("regerr");
							$("#register-form #lga_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please choose your L.G.A!!!</small>");
							$("#register-form #lga_selValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($dob)) {
					$data['message'] .= '
						<script>
							$("#register-form #dob").addClass("regerr");
							$("#register-form #dobValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Date of Birth is required!!!</small>");
							$("#register-form #dobValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($gender)) {
					$data['message'] .= '
						<script>
							$("#register-form #gender").addClass("regerr");
							$("#register-form #genderValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please select your gender!!!</small>");
							$("#register-form #genderValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($raddress)) {
					$data['message'] .= '
						<script>
							$("#register-form #raddress").addClass("regerr");
							$("#register-form #raddressValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Current Residential Address is required!!!</small>");
							$("#register-form #raddressValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($med_con)) {
					$data['message'] .= '
						<script>
							$("#register-form #med_conValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please choose an option!!!</small>");
							$("#register-form #med_conValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($p_g_name)) {
					$data['message'] .= '
						<script>
							$("#register-form #p_g_name").addClass("regerr");
							$("#register-form #p_g_nameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Parent/Guardian Name is required!!!</small>");
							$("#register-form #p_g_nameValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($p_g_phone)) {
					$data['message'] .= '
						<script>
							$("#register-form #p_g_phone").addClass("regerr");
							$("#register-form #p_g_phoneValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Parent/Guardian Phone Number is required!!!</small>");
							$("#register-form #p_g_phoneValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($p_g_occ)) {
					$data['message'] .= '
						<script>
							$("#register-form #p_g_occ").addClass("regerr");
							$("#register-form #p_g_occValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Parent/Guardian Occupation is required!!!</small>");
							$("#register-form #p_g_occValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (empty($p_g_raddress)) {
					$data['message'] .= '
						<script>
							$("#register-form #p_g_raddress").addClass("regerr");
							$("#register-form #p_g_raddressValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Parent/Guardian Current Residential Address is required!!!</small>");
							$("#register-form #p_g_raddressValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				$data['message'] .= '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							Fill in all fields to continue!!!<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
				$data['status'] = '300';
			}

			echo json_encode(['data' => $data]);
		}
	}