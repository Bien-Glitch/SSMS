<?php
require_once '../session.php';
require_once 'admin.php';
sleep(number_format(0.5));

use admin\admin;

/**
 * Class manage
 */
class manage
{
	private $link;

	/**
	 * manage constructor.
	 * @param $link mysqli
	 */
	public function __construct($link)
	{
		$this->link = $link;
	}

	/**
	 * @param $class_id
	 * @return bool
	 */
	public function classExists($class_id)
	{
		$q = $this->link->query("SELECT * FROM `class` WHERE `id` = '{$class_id}' LIMIT 1");

		if ($q->num_rows > 0) {
			return true;

		} else {
			return false;
		}
	}

	/**
	 * @param $session_id
	 * @return bool
	 */
	public function sessionExists($session_id)
	{
		$q = $this->link->query("SELECT * FROM `session` WHERE `id` = '{$session_id}' LIMIT 1");

		if ($q->num_rows > 0) {
			return true;

		} else {
			return false;
		}
	}

	public function termExists($term_id)
	{
		$q = $this->link->query("SELECT * FROM `term` WHERE `id` = '{$term_id}' LIMIT 1");

		if ($q->num_rows > 0) {
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Checks if student exists using Students' admission number
	 * @param $adm_id string Students' Admission number
	 * @return bool Return true if student exists else return false
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
	 * Checks if student exists using Students' name
	 * @param $fname string students' first name
	 * @param $mname string students' middle name
	 * @param $lname string students' last name
	 * @return bool Return true if student exists else return false
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
	 * @param $fees_id
	 * @return array
	 */
	public function getFees($fees_id)
	{
		$data = NULL;

		$q = $this->link->query("SELECT * FROM `school_fees` WHERE `id` = '{$fees_id}' LIMIT 1");

		if ($q->num_rows > 0) {
			$row = $q->fetch_array();
			$info[] = $row;
			$data['info'] = $info;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * @param $subject_id
	 * @return array
	 */
	public function getSubject($subject_id)
	{
		$data = NULL;

		$q = $this->link->query("SELECT * FROM `subjects` WHERE `id` = '{$subject_id}' LIMIT 1");

		if ($q->num_rows > 0) {
			$row = $q->fetch_array();
			$info[] = $row;
			$data['info'] = $info;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * @return array
	 */
	public function getClasses()
	{
		$data = NULL;
		$info = NULL;
		$classes = NULL;

		$q = $this->link->query("SELECT * FROM `class`");

		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$info[] = $row;
			}
			$data['info'] = $info;

			foreach ($data['info'] as $class) {
				$classes[] = '
					<option id="' . $class['id'] . '" value="' . $class['id'] . '">' . $class['class'] . '</option>
				';
			}

			$data['classes'] = $classes;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * @return array
	 */
	public function getSessions()
	{
		$data = NULL;
		$info = NULL;
		$sessions = NULL;

		$q = $this->link->query("SELECT * FROM `session`");

		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$info[] = $row;
			}
			$data['info'] = $info;

			foreach ($data['info'] as $session) {
				if ($session['current_session'] == '*') {
					$cSession = $session['session'] . ' *';

				} else {
					$cSession = $session['session'];
				}

				$sessions[] = '
					<option id="' . $session['id'] . '" value="' . $session['id'] . '">' . $cSession . '</option>
				';
			}

			$data['sessions'] = $sessions;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * @param $class_id
	 * @return array
	 */
	public function getStudentsByClass($class_id)
	{
		$data = NULL;
		$info = NULL;
		$students = NULL;

		$q = $this->link->query("SELECT * FROM `students` WHERE `class_id` = '{$class_id}' ORDER BY `lname`, `mname`, `fname`");

		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$info[] = $row;
			}
			$data['info'] = $info;

			foreach ($data['info'] as $student) {
				$stu_name = $student['lname'] . ' ' . $student['mname'] . ' ' . $student['fname'];

				$students[] = '
					<option id="' . $student['id'] . '" value="' . $student['id'] . '">' . $stu_name . '</option>
				';
			}

			$data['students'] = $students;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * @param $class_id
	 * @param $session_id
	 * @param $term_id
	 * @return array
	 */
	public function getSubjects($class_id, $session_id, $term_id)
	{
		$data = NULL;
		$info = NULL;
		$subjects = NULL;

		$q = $this->link->query("SELECT * FROM `subjects` WHERE `class_id` = '{$class_id}' AND `session_id` = '{$session_id}'  AND `term_id` = '{$term_id}' ORDER BY `subject`");

		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$info[] = $row;
			}
			$data['info'] = $info;

			foreach ($data['info'] as $subject) {
				$subjects[] = '
					<option id="' . $subject['id'] . '" value="' . $subject['id'] . '">' . $subject['subject'] . '</option>
				';
			}

			$data['subjects'] = $subjects;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * @return array
	 */
	public function getTerms()
	{
		$data = NULL;
		$info = NULL;
		$terms = NULL;

		$q = $this->link->query("SELECT * FROM `term`");

		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$info[] = $row;
			}
			$data['info'] = $info;

			foreach ($data['info'] as $term) {
				if ($term['current_term'] == '*') {
					$cTerm = $term['term'] . ' *';

				} else {
					$cTerm = $term['term'];
				}

				$terms[] = '
					<option id="' . $term['id'] . '" value="' . $term['id'] . '">' . $cTerm . '</option>
				';
			}

			$data['terms'] = $terms;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * Get students' info by admission number
	 * @param $adm_id string students' admission number
	 * @return array Return Associative array of students' info
	 */
	public function getStudentByID($adm_id)
	{
		$data = NULL;

		$q = $this->link->query("SELECT * FROM `students` inner join parents p on students.adm_id = p.student_id WHERE `adm_id` = '{$adm_id}' LIMIT 1");

		if ($q->num_rows > 0) {
			$row = $q->fetch_array();
			$data['info'] = $row;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * Get students' info by name
	 * @param $fname string students' first name
	 * @param $mname string students' middle name
	 * @param $lname string students' last name
	 * @return array Return Associative array of students' info
	 */
	public function getStudentByName($fname, $mname, $lname)
	{
		$data = NULL;

		$q = $this->link->query("SELECT * FROM `students` inner join parents p on students.adm_id = p.student_id WHERE `fname` = '{$fname}' AND `mname` = '{$mname}' AND `lname` = '{$lname}' LIMIT 1");

		if ($q->num_rows > 0) {
			$row = $q->fetch_array();
			$info = $row;
			$data['info'] = $info;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * @param $adm_id
	 * @param $session
	 * @param $term
	 * @return array
	 */
	public function getStudentPaymentDetails($adm_id, $session, $term)
	{
		$q = $this->link->query("SELECT * FROM `all_payments` inner join session s on all_payments.session_id = s.id inner join term t on all_payments.term_id = t.id WHERE student_id = '{$adm_id}' AND `session_id` = '{$session}' AND `term_id` = '{$term}' ORDER BY `receipt_no` DESC, `session_id` DESC, `term_id`  DESC");

		$info = NULL;
		$payment_complete_message = NULL;
		$payment_complete_status = NULL;
		$payment_complete_owing = NULL;
		$pin = NULL;
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$info[] = $row;
			}
			$data['payments'] = $info;

			$is_payment_complete = $this->checkPaymentCompletion($adm_id, $session, $term);
			$data['p_c_message'] = $is_payment_complete['data']['message'];
			$data['p_c_status'] = $is_payment_complete['data']['status'];
			$data['p_c_owing'] = $is_payment_complete['data']['owing'];

			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * Get students' payment info
	 * @param $adm_id string students' admission number
	 * @return array Return Associative array of students' payment info
	 */
	public function getStudentPayments($adm_id)
	{
		$q = $this->link->query("SELECT * FROM payments inner join session s2 on payments.session_id = s2.id inner join term t on payments.term_id = t.id WHERE student_id = '{$adm_id}' ORDER BY session DESC, term DESC");

		$info = NULL;
		$payment_complete_message = NULL;
		$payment_complete_status = NULL;
		$payment_complete_owing = NULL;
		$pin = NULL;
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$info[] = $row;
			}
			$data['payments'] = $info;

			foreach ($data['payments'] as $info) {
				$session = $info['session_id'];
				$term = $info['term_id'];
				$pin_id = $info['pin'];

				$q = $this->link->query("SELECT * FROM `result_pin` WHERE `id` = '{$pin_id}'");

				if ($q->num_rows > 0) {
					$row = $q->fetch_array();
					$pin[] = $row['pin'];

				} else {
					$pin[] = NULL;
				}

				$is_payment_complete = $this->checkPaymentCompletion($adm_id, $session, $term);
				$payment_complete_message[] = $is_payment_complete['data']['message'];
				$payment_complete_status[] = $is_payment_complete['data']['status'];
				$payment_complete_owing[] = $is_payment_complete['data']['owing'];
			}

			$data['p_c_message'] = $payment_complete_message;
			$data['p_c_status'] = $payment_complete_status;
			$data['p_c_owing'] = $payment_complete_owing;
			$data['pin'] = $pin;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * Delete all students' data by admission number
	 * @param $adm_id string students' admission number
	 * @return array Return message and status of action as an array
	 */
	public function deleteStudentById($adm_id)
	{
		$data = NULL;

		$q = $this->link->query("DELETE FROM `parents` WHERE `student_id` = '{$adm_id}'");
		if ($q) {
			$q = $this->link->query("DELETE FROM `payments` WHERE `student_id` = '{$adm_id}'");

			if ($q) {
				$q = $this->link->query("DELETE FROM `student_passports` WHERE `student_id` = '{$adm_id}'");

				if ($q) {
					$q = $this->link->query("DELETE FROM `students` WHERE `adm_id` = '{$adm_id}'");

					if ($q) {
						$data['message'] = 'Data of student with admission number: ' . $adm_id . ' deleted successfully!!!';
						$data['status'] = '200';

					} else {
						$data['message'] = 'Oops that was from us, please contact us if this error continues: Unable to delete data from students table' . "\r\n\r\n" . mysqli_error($this->link);
						$data['status'] = '300';
					}

				} else {
					$data['message'] = 'Oops that was from us, please contact us if this error continues: Unable to delete students passport(s)' . "\r\n\r\n" . mysqli_error($this->link);
					$data['status'] = '300';
				}

			} else {
				$data['message'] = 'Oops that was from us, please contact us if this error continues: Unable to delete student payment(s)' . "\r\n\r\n" . mysqli_error($this->link);
				$data['status'] = '300';
			}

		} else {
			$data['message'] = 'Oops that was from us, please contact us if this error continues: Unable to delete student parents data' . "\r\n\r\n" . mysqli_error($this->link);
			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	/**
	 * @param $adm_id
	 * @param $session
	 * @param $term
	 * @return array
	 */
	public function deletePayment($adm_id, $session, $term)
	{
		$data = NULL;

		$q = $this->link->query("SELECT `pin` FROM `payments` WHERE student_id = '{$adm_id}' AND `session_id` = '{$session}' AND `term_id` = '{$term}'");

		if ($q->num_rows > 0) {
			$row = $q->fetch_array();
			$pin_id = $row['pin'];

			$this->link->query("DELETE FROM `result_pin` WHERE `id` = '{$pin_id}'");
		}

		$q = $this->link->query("DELETE FROM `payments` WHERE `student_id` = '{$adm_id}' AND `session_id` = '{$session}' AND `term_id` = '{$term}'");
		if ($q) {
			$q = $this->link->query("DELETE FROM `all_payments` WHERE student_id = '{$adm_id}' AND `session_id` = '{$session}' AND `term_id` = '{$term}'");

			if ($q) {
				$data['message'] = 'Payment receipts for selected session and term deleted successfully!!!';
				$data['status'] = '200';

			} else {
				$data['message'] = 'Oops that was from us, please contact us if this error continues: Unable to delete from all payments' . "\r\n\r\n" . mysqli_error($this->link);
				$data['status'] = '300';
			}

		} else {
			$data['message'] = 'Oops that was from us, please contact us if this error continues: Unable to delete payment detail' . "\r\n\r\n" . mysqli_error($this->link);
			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	/**
	 * Delete a Class by id
	 * @param $class_id string id of class to be deleted
	 * @return array Return message and status of action as an array
	 */
	public function deleteClassById($class_id)
	{
		$data = NULL;

		$q1 = $this->link->query("DELETE FROM `class` WHERE `id` = '{$class_id}'");

		if ($q1) {
			$data['message'] = 'Class with id: ' . $class_id . ' deleted successfully!!!';
			$data['status'] = '200';

		} else {
			$data['message'] = mysqli_error($this->link);
			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	/**
	 * Delete a school session by id
	 * @param $session_id string id of session to be deleted
	 * @return array Return message and status of action as an array
	 */
	public function deleteSessionById($session_id)
	{
		$data = NULL;

		$q1 = $this->link->query("DELETE FROM `session` WHERE `id` = '{$session_id}'");

		if ($q1) {
			$data['message'] = 'Session with id: ' . $session_id . ' deleted successfully!!!';
			$data['status'] = '200';

		} else {
			$data['message'] = mysqli_error($this->link);
			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	/**
	 * Delete a school term by id
	 * @param $term_id string id of term to be deleted
	 * @return array Return message and status of action as an array
	 */
	public function deleteTermById($term_id)
	{
		$data = NULL;


		$q1 = $this->link->query("DELETE FROM `term` WHERE `id` = '{$term_id}'");

		if ($q1) {
			$data['message'] = 'Term with id: ' . $term_id . ' deleted successfully!!!';
			$data['status'] = '200';

		} else {
			$data['message'] = mysqli_error($this->link);
			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	/**
	 * @param $column
	 * @param $query
	 * @param $connect
	 * @return array
	 * @throws Exception
	 */
	public function manageStudents($column, $query, $connect)
	{
		$data = NULL;
		$admin = new admin($connect);

		$date = date("Y-m-d"); ## Current Date
		$start = new DateTime($date); ## Start new DateTime interface using today's date and assign it to variable $start
		$admin_info = $admin->getAdminById($_SESSION['admin_id']);

		$admin_type = $admin_info['data'];
		$admin_type = $admin_type['info'][0];
		$admin_type = $admin_type['privilege'];

		$table_details_td = NULL;

		$q = $this->link->query("SELECT * FROM `students` inner join class c on students.class_id = c.id inner join parents p on students.adm_id = p.student_id ORDER BY $column $query");

		$info = [];
		$infos = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$infos[] = $row;
			}
			$data['info'] = $infos;

			foreach ($data['info'] as $infos) {
				$interval = $start->diff(new DateTime($infos['dob']));
				$age = $interval->y; ## Current age

				if (empty($infos['med_con_det'])) {
					$infos['med_con_det'] = 'None';
				}

				if ($admin_type == 'admin') {
					$table_details_td = '
						<td>
							<a href="" class="receipts mx-1" data-id="' . $infos['adm_id'] . '" title="Student receipts"><i class="text-primary far fa-receipt"></i></a>
							<a href="" class="edit mx-1" data-id="' . $infos['adm_id'] . '" title="Edit Student Info"><i class="text-primary far fa-pencil"></i></a>
							<a href="" class="delete mx-1" data-id="' . $infos['adm_id'] . '" title="Delete Student"><i class="text-danger far fa-trash-alt"></i></a>
						</td>
					';

				} elseif ($admin_type == 'principal') {
					$table_details_td = '
						<td>
							<a href="" class="edit mx-1" data-id="' . $infos['adm_id'] . '" title="Edit Student Info"><i class="text-primary far fa-pencil"></i></a>
						</td>
					';

				} elseif ($admin_type !== 'bursar') {
					$table_details_td = '
						<td>
							<i class="fad fa-do-not-enter mx-3" title="No action"></i>
						</td>
					';

				} else {
					$table_details_td = '
						<td>
							<a href="" class="receipts mx-1" data-id="' . $infos['adm_id'] . '" title="Student receipts"><i class="text-primary far fa-receipt"></i></a>
						</td>
					';
				}

				$info[] = '
					<tr>
						<td>' . $infos[0] . '</td>
						<td>' . $infos['adm_id'] . '</td>
						<td>' . $infos['class'] . '</td>
						<td>' . $infos['fname'] . '</td>
						<td>' . $infos['mname'] . '</td>
						<td>' . $infos['lname'] . '</td>
						<td>' . $infos['gender'] . '</td>
						<td>' . $infos['religion'] . '</td>
						<td>' . $infos['med_con'] . '</td>
						<td>' . $infos['med_con_det'] . '</td>
						<td>' . $infos['r_address'] . '</td>
						<td>' . $infos['sor'] . '</td>
						<td>' . $infos['lga'] . '</td>
						<td>' . $age . ' yrs</td>
						<td>' . $infos['name'] . '</td>
						' . $table_details_td . '
					</tr>
				';
			}
			$data['info'] = $info;

			$data['table'] = '
				<table class="table table-responsive-xl table-striped table-condensed table-bordered table-hover">
					<thead class="thead-dark">
					<tr>
						<th id="students.id" class="j-link">#id</th>
						<th id="adm_id" class="j-link">Adm No.</th>
						<th id="class" class="j-link">Class</th>
						<th id="fname" class="j-link">First Name</th>
						<th id="mname" class="j-link">Middle Name</th>
						<th id="lname" class="j-link">Last Name</th>
						<th id="gender" class="j-link">Gender</th>
						<th id="religion" class="j-link">Religion</th>
						<th id="med_con" class="j-link">Health Issue(s)?</th>
						<th id="med_con_det" class="j-link">Health Issue(s) (If yes)</th>
						<th id="r_address" class="j-link">Residential Address</th>
						<th id="sor" class="j-link">State of Origin</th>
						<th id="lga" class="j-link">L G A</th>
						<th id="dob" class="j-link">Age</th>
						<th id="name" class="j-link">P / G Name</th>
						<th id=""><i class="fa fa-pencil mx-1"></i> Edit</th>
					</tr>
					</thead>
					<tbody class="detail-pane"></tbody>
				</table>
			';
		}
		return ['data' => $data];
	}

	/**
	 * View details of all students
	 * @param $column
	 * @param $query
	 * @return array
	 * @throws Exception
	 */
	public function viewStudents($column, $query)
	{
		$data = NULL;

		$date = date("Y-m-d"); ## Current Date
		$start = new DateTime($date); ## Start new DateTime interface using today's date and assign it to variable $start
		$table_details_td = NULL;

		$q = $this->link->query("SELECT * FROM `students` inner join class c on students.class_id = c.id inner join parents p on students.adm_id = p.student_id ORDER BY $column $query");

		$info = [];
		$infos = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$infos[] = $row;
			}
			$data['info'] = $infos;

			foreach ($data['info'] as $infos) {
				$interval = $start->diff(new DateTime($infos['dob']));
				$age = $interval->y; ## Current age

				if (empty($infos['med_con_det'])) {
					$infos['med_con_det'] = 'None';
				}

				$info[] = '
					<div class="col-md-6 my-2">
		                <div class="w3-card student-details-card bg-light p-2 shadow">
		                    <div class="d-flex align-items-center">
			                    <div class="stu_pic"><img src="../' . $infos['passport'] . '" alt="' . $infos['lname'] . '" class="img-fluid" style="width:100px; height: 100px"></div>
			                    <div class="student-details d-flex flex-column flex-fill justify-content-end px-2 pt-2">
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Admission Number: </span>
			                            <span>' . $infos['adm_id'] . '</span>
			                        </div>
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Name: </span>
			                            <span>' . $infos['lname'] . ' ' . $infos['mname'] . ' ' . $infos['fname'] . '</span>
			                        </div>
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Class: </span>
			                            <span>' . $infos['class'] . '</span>
			                        </div>
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Gender: </span>
			                            <span>' . $infos['gender'] . '</span>
			                        </div>
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Age: </span>
			                            <span>' . $age . ' Yrs.</span>
			                        </div>
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Phone Number: </span>
			                            <span>' . $infos['pnum'] . '</span>
			                        </div>
			                    </div>
			                </div>
			                <div class="j-link text-primary view-other-details">View Other details</div>
			                <div class="other-details" style="display: none">
			                    <hr/>
			                    <span class="h6">Other Information</span>
				                <div class="student-details d-flex flex-column flex-fill justify-content-end px-2 pt-2">
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Religion: </span>
			                            <span>' . $infos['religion'] . '</span>
			                        </div>
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">State & LGA: </span>
			                            <span>' . $infos['lga'] . ', ' . $infos['sor'] . '</span>
			                        </div>
			                        
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Medical Condition(s): </span>
			                            <span>' . $infos['med_con_det'] . '</span>
			                        </div>
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Residential Address: </span>
			                            <span>' . $infos['r_address'] . '</span>
			                        </div>
		                        </div>
		                        <hr />
		                        <span class="h6">Parent / Guardian Information</span>
		                        <div class="student-details d-flex flex-column flex-fill justify-content-end px-2 pt-2">
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Parent / Guardian Name: </span>
			                            <span>' . $infos['name'] . '</span>
			                        </div>
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">State & LGA: </span>
			                            <span>' . $infos['phone'] . '</span>
			                        </div>
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Parent / Guardian Occupation: </span>
			                            <span>' . $infos['occupation'] . '</span>
			                        </div>
			                        <div class="d-flex flex-row justify-content-start align-items-end" style="max-width:50%">
			                            <span class="d-none d-lg-inline">Parent / Guardian Address: </span>
			                            <span>' . $infos['address'] . '</span>
			                        </div>
		                        </div>
	                        </div>
	                    </div>
	                </div>
				';
			}
			$data['info'] = $info;

			$data['row'] = '
				<div class="container-fluid"><div class="row detail-pane"></div></div>
			';
		}
		return ['data' => $data];
	}

	/**
	 * @param $column
	 * @param $query
	 * @return array
	 */
	public function manageFees($column, $query)
	{
		$data = NULL;

		$q = $this->link->query("SELECT * FROM `school_fees` inner join class c on school_fees.class_id = c.id inner join session s on school_fees.session_id = s.id inner join term t on school_fees.term_id = t.id ORDER BY $column $query");

		$info = [];
		$infos = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$infos[] = $row;
			}
			$data['info'] = $infos;

			foreach ($data['info'] as $infos) {
				$info[] = '
					<tr>
						<td>' . $infos[0] . '</td>
						<td>' . $infos['class'] . '</td>
						<td>' . $infos['session'] . '</td>
						<td>' . $infos['term'] . '</td>
						<td class="fee-amount">' . $infos['amount'] . '</td>
						<td>
							<a href="" class="edit mx-1" data-id="' . $infos[0] . '" title="Edit this Fees Scheme"><i class="text-primary far fa-pencil"></i></a>
							<a href="" class="delete mx-1" data-id="' . $infos[0] . '" title="Delete this Fees Scheme"><i class="text-danger far fa-trash"></i></a>
						</td>
					</tr>
				';
			}
			$data['info'] = $info;
			$data['status'] = '200';

		} else {
			$data['info'] = '
				<tr>
					<td>-</td>
					<td>no class data</td>
					<td>no session data</td>
					<td>no term data</td>
					<td>no fee data</td>
					<td>
						<span><i class="text-primary far fa-times"></i></span>
						<span><i class="text-danger far fa-times"></i></span>
					</td>
				</tr>
			';
			$data['status'] = '300';
		}
		return ['data' => $data];
	}

	public function manageSubjects($column, $query)
	{
		$data = NULL;

		$q = $this->link->query("SELECT * FROM `subjects` inner join class c on subjects.class_id = c.id inner join term t on subjects.term_id = t.id ORDER BY $column $query");

		$info = [];
		$infos = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$infos[] = $row;
			}
			$data['info'] = $infos;

			foreach ($data['info'] as $infos) {
				$info[] = '
					<tr>
						<td>' . $infos[0] . '</td>
						<td>' . $infos['class'] . '</td>
						<td>' . $infos['term'] . '</td>
						<td class="subject">' . $infos['subject'] . '</td>
						<td>
							<a href="" class="edit mx-1" data-id="' . $infos[0] . '" title="Edit this Subject"><i class="text-primary far fa-pencil"></i></a>
							<a href="" class="delete mx-1" data-id="' . $infos[0] . '" title="Delete this Subject"><i class="text-danger far fa-trash"></i></a>
						</td>
					</tr>
				';
			}
			$data['info'] = $info;
			$data['status'] = '200';

		} else {
			$data['info'] = '
				<tr>
					<td>-</td>
					<td>no class data</td>
					<td>no term data</td>
					<td>no subject data</td>
					<td>
						<span><i class="text-primary far fa-times"></i></span>
						<span><i class="text-danger far fa-times"></i></span>
					</td>
				</tr>
			';
			$data['status'] = '300';
		}
		return ['data' => $data];
	}

	/**
	 * @param $column
	 * @param $query
	 * @return array
	 */
	public function manageClasses($column, $query)
	{
		$data = NULL;

		$q = $this->link->query("SELECT * FROM `class` ORDER BY $column $query");

		$info = [];
		$infos = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$infos[] = $row;
			}
			$data['info'] = $infos;

			foreach ($data['info'] as $infos) {
				$info[] = '
					<tr>
						<td>' . $infos['id'] . '</td>
						<td>' . $infos['class'] . '</td>
						<td>
							<a href="" class="edit mx-1" data-class="' . $infos['class'] . '" title="Edit this Class"><i class="text-primary far fa-pencil"></i></a>
							<a href="" class="delete mx-1" data-id="' . $infos['id'] . '" title="Delete this Class"><i class="text-danger far fa-trash"></i></a>
						</td>
					</tr>
				';
			}
			$data['info'] = $info;
			$data['status'] = '200';

		} else {
			$data['info'] = '
				<tr>
					<td>-</td>
					<td>No Class Data</td>
					<td>
						<span><i class="text-primary far fa-times"></i></span>
						<span><i class="text-danger far fa-times"></i></span>
					</td>
				</tr>
			';
			$data['status'] = '300';
		}
		return ['data' => $data];
	}

	/**
	 * @param $column
	 * @param $query
	 * @return array
	 */
	public function manageSessions($column, $query)
	{
		$data = NULL;

		$q = $this->link->query("SELECT * FROM `session` ORDER BY $column $query");

		$info = [];
		$infos = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$infos[] = $row;
			}
			$data['info'] = $infos;

			foreach ($data['info'] as $infos) {
				$info[] = '
					<tr>
						<td>' . $infos['id'] . '</td>
						<td>' . $infos['session'] . '</td>
						<td>' . $infos['current_session'] . '</td>
						<td>
							<a href="" class="edit mx-1" data-session="' . $infos['session'] . '" title="Edit this Session"><i class="text-primary far fa-pencil"></i></a>
							<a href="" class="delete mx-1" data-id="' . $infos['id'] . '" title="Delete this Session"><i class="text-danger far fa-trash"></i></a>
						</td>
					</tr>
				';
			}
			$data['info'] = $info;
			$data['status'] = '200';

		} else {
			$data['info'] = '
				<tr>
					<td>-</td>
					<td>No Session Data</td>
					<td>nil</td>
					<td>
						<span><i class="text-primary far fa-times"></i></span>
						<span><i class="text-danger far fa-times"></i></span>
					</td>
				</tr>
			';
			$data['status'] = '300';
		}
		return ['data' => $data];
	}

	/**
	 * @param $column
	 * @param $query
	 * @return array
	 */
	public function manageTerms($column, $query)
	{
		$data = NULL;

		$q = $this->link->query("SELECT * FROM `term` ORDER BY $column $query");

		$info = [];
		$infos = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$infos[] = $row;
			}
			$data['info'] = $infos;

			foreach ($data['info'] as $infos) {
				$info[] = '
					<tr>
						<td>' . $infos['id'] . '</td>
						<td>' . $infos['term'] . '</td>
						<td>' . $infos['current_term'] . '</td>
						<td>
							<a href="" class="edit mx-1" data-term="' . $infos['term'] . '" title="Edit this Term"><i class="text-primary fad fa-pencil"></i></a>
							<a href="" class="delete mx-1" data-id="' . $infos['id'] . '" title="Delete this Term"><i class="text-danger fad fa-trash"></i></a>
						</td>
					</tr>
				';
			}
			$data['info'] = $info;
			$data['status'] = '200';

		} else {
			$data['info'] = '
				<tr>
					<td>-</td>
					<td>No Term Data</td>
					<td>nil</td>
					<td>
						<span><i class="text-primary far fa-times"></i></span>
						<span><i class="text-danger far fa-times"></i></span>
					</td>
				</tr>
			';
			$data['status'] = '300';
		}
		return ['data' => $data];
	}

	/**
	 * @param $class
	 * @param $session
	 * @param $term
	 * @param $amount
	 * @return array
	 */
	public function addFeesScheme($class, $session, $term, $amount)
	{
		$data['message'] = '';
		$class_exists = $this->classExists($class);
		$session_exists = $this->sessionExists($session);
		$term_exists = $this->termExists($term);

		if ($class_exists && $session_exists && $term_exists) {
			$q = $this->link->query("SELECT * FROM `school_fees` WHERE (class_id = '{$class}' AND `session_id` = '{$session}' AND `term_id` = '{$term}')");
			if ($q->num_rows < 1) {
				$q = $this->link->query("INSERT INTO `school_fees` (`id`, `class_id`, `session_id`, `term_id`, `amount`) VALUES (NULL, '{$class}', '{$session}', '{$term}', '{$amount}')");
				if ($q) {
					$q = $this->link->query("SELECT * FROM `school_fees` inner join class c on school_fees.class_id = c.id inner join session s on school_fees.session_id = s.id inner join term t on school_fees.term_id = t.id WHERE (class_id = '{$class}' AND `session_id` = '{$session}' AND `term_id` = '{$term}')");
					$row = $q->fetch_array();
					$data['message'] = '
						<script>
							alert("" +
							    "School fees scheme added successfully!!!\r\n"+
								"Class: ' . $row['class'] . '\r\n"+
								"Session: ' . $row['session'] . '\r\n"+
								"Term: ' . $row['term'] . '\r\n"+
								"Amount: "+ accounting.formatMoney("' . $amount . '", "N" , 0) +
							"");
						</script>
					';

				} else {
					$data['message'] = '
						<script>
							alert("" +
								"Oops that was from us, please contact us if this error continues:\r\n" +
								"Failed to add fees scheme!!!\r\n" + "' . mysqli_error($this->link) . '" +
							"")
						</script>';
					$data['status'] = '300';
				}

			} else {
				$row = $q->fetch_array();
				$data['message'] = 'The School Fees scheme for selected class, session and term already exists.' . "\r\n" . 'Do you want to edit it?';
				$data['id'] = $row['id'];
				$data['status'] = '400';
			}

		} else {
			if (!$class_exists) {
				$data['message'] = '
					<script>
						alert("The selected class doesn\'t exist or hasn\'t been created yet!!!");
					</script>
				';
			}

			if (!$session_exists) {
				$data['message'] = '
					<script>
						alert("The selected school session doesn\'t exist or hasn\'t been created yet!!!");
					</script>
				';
			}

			if (!$term_exists) {
				$data['message'] = '
					<script>
						alert("The selected term doesn\'t exist or hasn\'t been created yet!!!");
					</script>
				';
			}

			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	public function addSubject($class, $term, $subject)
	{
		$data['message'] = '';
		$class_exists = $this->classExists($class);
		$term_exists = $this->termExists($term);

		if ($class_exists && $term_exists) {
			$q = $this->link->query("SELECT * FROM `subjects` WHERE (class_id = '{$class}' AND `term_id` = '{$term}' AND `subject` = '{$subject}')");
			if ($q->num_rows < 1) {
				$q = $this->link->query("INSERT INTO `subjects` (`id`, `class_id`, `term_id`, `subject`) VALUES (NULL, '{$class}', '{$term}', '{$subject}')");
				if ($q) {
					$q = $this->link->query("SELECT * FROM `subjects` inner join class c on subjects.class_id = c.id inner join term t on subjects.term_id = t.id WHERE (class_id = '{$class}' AND `term_id` = '{$term}' AND `subject` = '{$subject}')");
					$row = $q->fetch_array();
					$data['message'] = '
						<script>
							alert(""+
							    "Subject added successfully!!!\r\n"+
								"Class: ' . $row['class'] . '\r\n"+
								"Term: ' . $row['term'] . '\r\n"+
								"Subject name: ' . $row['subject'] . '\r\n"+
							"");
						</script>
					';

				} else {
					$data['message'] = '
						<script>
							alert(""+
								"Oops that was from us, please contact us if this error continues:\r\n" +
								"Failed to add subject!!!\r\n" + "' . mysqli_error($this->link) . '" +
							"")
						</script>';
					$data['status'] = '300';
				}

			} else {
				$row = $q->fetch_array();
				$data['message'] = 'This Subject for selected Class and Term already exists.' . "\r\n" . 'Do you want to edit it?';
				$data['id'] = $row['id'];
				$data['status'] = '400';
			}

		} else {
			if (!$class_exists) {
				$data['message'] .= '
					<script>
						alert("The selected class doesn\'t exist or hasn\'t been created yet!!!");
					</script>
				';
			}

			if (!$term_exists) {
				$data['message'] .= '
					<script>
						alert("The selected term doesn\'t exist or hasn\'t been created yet!!!");
					</script>
				';
			}

			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	/**
	 * @param $class_edit
	 * @param $new_class
	 * @return array
	 */
	public function editClass($class_edit, $new_class)
	{
		$data['message'] = '';

		$q = $this->link->query("SELECT * FROM `class` WHERE `class` = '{$class_edit}' LIMIT 1");
		if ($q->num_rows > 0) {
			$q = $this->link->query("UPDATE `class` SET `class` = '{$new_class}' WHERE `class` = '{$class_edit}'");
			if ($q) {
				$data['message'] = 'Class: ' . $class_edit . ' updated successfully' . "\r\n" . 'New name: ' . $class_edit;
				$data['status'] = '200';

			} else {
				$data['message'] = 'Error, Please Contact us if this continues: Unable to update Class!!!';
				$data['status'] = '300';
			}

		} else {
			$data['message'] = 'Class: ' . $class_edit . ' doesn\'t exist!!!' . "\r\n" . 'To add a new class, Use the \'Add Class\' form above!!!';
			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	public function addClass($class)
	{
		$data['message'] = '';

		$q = $this->link->query("SELECT * FROM `class` WHERE `class` = '{$class}'");
		if ($q->num_rows < 1) {
			$q = $this->link->query("INSERT INTO `class` (id, class) VALUES (NULL, '{$class}')");
			if ($q) {
				$data['message'] = 'Class: ' . $class . ' added successfully';
				$data['status'] = '200';

			} else {
				$data['message'] = 'Error, Please Contact us if this continues: Unable to register Class to DB!!!';
				$data['status'] = '300';
			}

		} else {
			$data['message'] = 'Class: ' . $class . ' already exists!!!' . "\r\n" . 'Click on the pencil beside it to edit it!!!';
			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	public function addSession($session, $c_session)
	{
		$data['message'] = '';

		$q = $this->link->query("SELECT * FROM `session` WHERE session = '{$session}'");
		if ($q->num_rows < 1) {
			if ($c_session == '*') {
				$this->link->query("UPDATE `session` SET current_session = '-' WHERE current_session = '*'");
			}

			$q = $this->link->query("INSERT INTO `session` (id, session, current_session) VALUES (NULL, '{$session}', '{$c_session}')");
			if ($q) {
				$data['message'] = 'Session: ' . $session . ' added successfully';
				$data['status'] = '200';

			} else {
				$data['message'] = 'Error, Please Contact us if this continues: Unable to register Session to DB!!!';
				$data['status'] = '300';
			}

		} else {
			if ($c_session == '*') {
				$this->link->query("UPDATE `session` SET current_session = '-' WHERE current_session = '*'");
			}

			$q = $this->link->query("UPDATE `session` SET current_session = '{$c_session}' WHERE session = '{$session}'");
			if ($q) {
				$data['message'] = 'Session: ' . $session . ' has been updated successfully';
				$data['status'] = '200';
			}
		}

		return (['data' => $data]);
	}

	/**
	 * Add a new school term
	 * @param $term string Term to add
	 * @param $c_term string Set if term is the current term
	 * @return array Return the message and status of action as an array
	 */
	public function addTerm($term, $c_term)
	{
		$data['message'] = '';

		$q = $this->link->query("SELECT * FROM `term` WHERE term = '{$term}'");
		if ($q->num_rows < 1) {
			if ($c_term == '*') {
				$this->link->query("UPDATE `term` SET current_term = '-' WHERE current_term = '*'");
			}

			$q = $this->link->query("INSERT INTO `term` (id, term, current_term) VALUES (NULL, '{$term}', '{$c_term}')");
			if ($q) {
				$data['message'] = 'Term: ' . $term . ' added successfully';
				$data['status'] = '200';

			} else {
				$data['message'] = 'Oops that was from us, Please Contact us if this continues: Unable to register Term to DB!!!';
				$data['status'] = '300';
			}

		} else {
			if ($c_term == '*') {
				$this->link->query("UPDATE `term` SET current_term = '-' WHERE current_term = '*'");
			}

			$q = $this->link->query("UPDATE `term` SET current_term = '{$c_term}' WHERE term = '{$term}'");
			if ($q) {
				$data['message'] = 'Term: ' . $term . ' has been updated successfully';
				$data['status'] = '200';
			}
		}

		return (['data' => $data]);
	}

	public function checkPaymentCompletion($admno, $session, $term)
	{
		$stu_info = $this->getStudentByID($admno);
		$stu_info = $stu_info['data']['info'];
		$class_id = $stu_info['class_id'];
		$data['status'] = '300';
		$data['message'] = '';
		$data['owing'] = NULL;

		$q1 = $this->link->query("SELECT SUM(`amount`) AS `total_amount` FROM `all_payments` WHERE (`student_id` = '{$admno}' AND `session_id` = '{$session}' AND `term_id` = '{$term}')");
		$q2 = $this->link->query("SELECT `amount` FROM `payments` WHERE (`student_id` = '{$admno}' AND `session_id` = '{$session}' AND `term_id` = '{$term}')");

		if (($q1 && $q2) && ($q1->num_rows > 0 && $q2->num_rows > 0)) {
			$row1 = $q1->fetch_array();
			$row2 = $q2->fetch_array();

			$total_amount = $row1['total_amount'];
			$amount = $row2['amount'];

			if ($amount == $total_amount) {

				$q = $this->link->query("SELECT * FROM school_fees WHERE `class_id` = '{$class_id}' AND `session_id` = '{$session}' AND `term_id` = '{$term}'");

				if ($q && $q->num_rows > 0) {
					$row = $q->fetch_array();
					$payable_amount = $row['amount'];

					if ($total_amount == $payable_amount) {
						$data['message'] = 'Payment for this session and term fully paid for';
						$data['status'] = '200';

					} else {
						$owing = $payable_amount - $total_amount;
						$data['message'] = 'left to complete payment for this session and term';
						$data['status'] = '400';
						$data['owing'] = $owing;
					}

				} else {
					$data['status'] = '300';
				}

			} else {
				$data['message'] = 'An error occurred: Amount sum of receipts don\'t match. Please contact the admin!!!';
				$data['status'] = '300';
			}

		} else {
			if (!$q1) {
				$data['message'] .= 'Oops that was from us: ' . mysqli_error($this->link);
			}

			if (!$q2) {
				$data['message'] .= 'An error occurred: ' . mysqli_error($this->link);
			}
			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	/**
	 * @param $admno
	 * @param $session
	 * @param $term
	 * @param $receiptno
	 * @param $amount
	 * @return array
	 */
	public function addPayment($admno, $session, $term, $receiptno, $amount)
	{
		$data['message'] = '';
		$data['token'] = '';
		$class_id = $this->getStudentByID($admno);
		$class_id = $class_id['data']['info'][0];
		$is_payment_complete = $this->checkPaymentCompletion($admno, $session, $term);
		$payment_status = $is_payment_complete['data']['status'];

		$q1 = $this->link->query("SELECT * FROM `payments` WHERE `student_id` = '{$admno}' AND `session_id` = '{$session}' AND `term_id` = '{$term}'");
		$q2 = $this->link->query("SELECT * FROM `payments` WHERE `receipt_no` = '{$receiptno}'");
		$q3 = $this->link->query("SELECT * FROM `all_payments` WHERE `receipt_no` = '{$receiptno}'");

		if ($payment_status !== '200') {
			if (($q1->num_rows < 1) && ($q2->num_rows < 1) && ($q3->num_rows < 1)) {

				$q = $this->link->query("SELECT * FROM school_fees WHERE `class_id` = '{$class_id}' AND `session_id` = '{$session}' AND `term_id` = '{$term}'");
				$row = $q->fetch_array();

				$current_amount = $row['amount'];

				if ($amount <= $current_amount) {

					$q1 = $this->link->query("INSERT INTO `payments`(`id`, `student_id`, `session_id`, `term_id`, `receipt_no`, `amount`) VALUES (NULL, '{$admno}', '{$session}', '{$term}', '{$receiptno}', '{$amount}')");
					$q2 = $this->link->query("INSERT INTO `all_payments`(`id`, `student_id`, `session_id`, `term_id`, `receipt_no`, `amount`) VALUES (NULL, '{$admno}', '{$session}', '{$term}', '{$receiptno}', '{$amount}')");

					if ($q1 && $q2) {
						$is_payment_complete = $this->checkPaymentCompletion($admno, $session, $term);
						$payment_status = $is_payment_complete['data']['status'];

						if ($payment_status == '200') {
							$token = '1234567890qwertyuiopasdfghjklzxcvbnm';
							$token = substr(str_shuffle($token), 0, 10);

							$q = $this->link->query("INSERT INTO `result_pin`(id, `session_id`, `term_id`, `pin`, `pin_count`) VALUES (NULL, '{$session}', '{$term}', '{$token}', '6')");

							if ($q) {
								$q = $this->link->query("SELECT * FROM `result_pin` WHERE `session_id` = '{$session}' AND `term_id` = '{$term}' ORDER BY `id` DESC LIMIT 1");
								$row = $q->fetch_array();
								$pin_id = $row['id'];

								$q = $this->link->query("UPDATE `payments` SET `pin` = '{$pin_id}' WHERE `student_id` = '{$admno}' AND `session_id` = '{$session}' AND `term_id` = '$term'");

								if ($q) {
									$data['message'] = '
										<div class="alert alert-success continue">
											<small>
												<i class="fa fa-check-double"></i>
												Payment info added successfully!!!<br />
												Result Checking pin is <kbd class="w3-medium">' . $token . '</kbd><br />
												Click the pin to copy!!!<br />
												<small>Click to dismiss</small>
											</small>
										</div>
									';
									$data['status'] = '200';
									$data['token'] = $token;

								} else {
									$data['message'] = '
										<div class="alert alert-danger remove">
											<small>
												<i class="fa fa-exclamation-circle"></i>
												Oops that was from us, please contact us if this error continues: Pin generated but not saved!!!<br />
												' . mysqli_error($this->link) . '
												<small>Click to dismiss</small>
											</small>
										</div>
									';
									$data['status'] = '300';
								}

							} else {
								$data['message'] = '
									<div class="alert alert-danger remove">
										<small>
											<i class="fa fa-exclamation-circle"></i>
											Oops that was from us, please contact us if this error continues: Pin couldn\'t be generated!!!<br />
											' . mysqli_error($this->link) . '
											<small>Click to dismiss</small>
										</small>
									</div>
								';
								$data['status'] = '300';
							}

						} elseif ($payment_status == '400') {
							$payment_owing = $is_payment_complete['data']['owing'];
							$payment_message = $is_payment_complete['data']['message'];

							$data['message'] = '
								<script>
									$("#receipt-number-form #amount").addClass("regerr");
									$("#amount-mess").html(accounting.formatMoney("' . $payment_owing . '", "&#x20A6;" , 0));
								</script>
								<div class="alert alert-info">
									<small>
										<i class="fa fa-check-double"></i>
										Payment info added successfully!!!<br />
										<span id="amount-mess"></span> ' . $payment_message . ', and generate a result checking pin!!!<br />
										<i class="fa fa-spin fa-spinner-third"></i> Please Wait...
									</small>
								</div>
							';
							$data['status'] = '200';

						} else {
							$payment_message = $is_payment_complete['data']['message'];

							$data['message'] = '
								<div class="alert alert-danger remove">
									<small>
										<i class="fa fa-exclamation-triangle"></i>
										' . $payment_message . '<br />
										<small>Click to dismiss</small>
									</small>
								</div>
							';
							$data['status'] = '300';
						}

					} else {
						$data['message'] = '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									An error has occurred: Add Payment Info has been aborted!!!<br />
									' . mysqli_error($this->link) . '
									<small>Click to dismiss</small>
								</small>
							</div>
						';
						$data['status'] = '300';
					}

				} else {
					$data['message'] .= '
						<script>
							$("#receipt-number-form #amount_inp").addClass("regerr");
							$("#amount-mess").html(accounting.formatMoney("' . $current_amount . '", "&#x20A6;" , 0));
						</script>
						<div class="alert alert-danger remove">
							<small>
								<i class="fa fa-exclamation-circle"></i>
								Entered Amount exceeds payable amount for selected session and term!!!<br />
								Amount payable: <span id="amount-mess"></span><br />
								<small>Click to dismiss</small>
							</small>
						</div>
					';
					$data['status'] = '300';
				}

			} else {
				if ($q1->num_rows > 0 && $q2->num_rows < 1 && $q3->num_rows < 1) {
					$row = $q1->fetch_array();
					$current_amount = $row['amount'];
					$new_amount = $current_amount + $amount;

					if ($payment_status == '400') {
						$owing = $is_payment_complete['data']['owing'];

						if ($owing >= $amount) {
							$q1 = $this->link->query("UPDATE `payments` SET `amount` = '{$new_amount}', `receipt_no` = '{$receiptno}' WHERE `student_id` = '{$admno}' AND `session_id` = '{$session}' AND `term_id` = '{$term}'");
							$q2 = $this->link->query("INSERT INTO `all_payments`(`id`, `student_id`, `session_id`, `term_id`, `receipt_no`, `amount`) VALUES (NULL, '{$admno}', '{$session}', '{$term}', '{$receiptno}', '{$amount}')");

							if ($q1 && $q2) {
								$is_payment_complete = $this->checkPaymentCompletion($admno, $session, $term);
								$payment_status = $is_payment_complete['data']['status'];

								if ($payment_status == '200') {
									$token = '1234567890qwertyuiopasdfghjklzxcvbnm';
									$token = substr(str_shuffle($token), 0, 10);

									$q = $this->link->query("INSERT INTO `result_pin`(id, `session_id`, `term_id`, `pin`, `pin_count`) VALUES (NULL, '{$session}', '{$term}', '{$token}', '6')");

									if ($q) {
										$q = $this->link->query("SELECT * FROM `result_pin` WHERE `session_id` = '{$session}' AND `term_id` = '{$term}'");
										$row = $q->fetch_array();
										$pin_id = $row['id'];

										$q = $this->link->query("UPDATE `payments` SET `pin` = '{$pin_id}' WHERE `student_id` = '{$admno}' AND `session_id` = '{$session}' AND `term_id` = '$term'");

										if ($q) {
											$data['message'] = '
												<div class="alert alert-success continue">
													<small>
														<i class="fa fa-check-double"></i>
														Payment info added successfully!!!<br />
														Result Checking pin is <kbd class="w3-medium">' . $token . '</kbd><br />
														Click the pin to copy!!!<br />
														<small>Click to dismiss</small>
													</small>
												</div>
											';
											$data['status'] = '200';
											$data['token'] = $token;

										} else {
											$data['message'] = '
												<div class="alert alert-danger remove">
													<small>
														<i class="fa fa-exclamation-circle"></i>
														Oops that was from us, please contact us if this error continues: Pin generated but not saved!!!<br />
														' . mysqli_error($this->link) . '
														<small>Click to dismiss</small>
													</small>
												</div>
											';
											$data['status'] = '300';
										}

									} else {
										$data['message'] = '
											<div class="alert alert-danger remove">
												<small>
													<i class="fa fa-exclamation-circle"></i>
													Oops that was from us, please contact us if this error continues: Pin couldn\'t be generated!!!<br />
													' . mysqli_error($this->link) . '
													<small>Click to dismiss</small>
												</small>
											</div>
										';
										$data['status'] = '300';
									}

								} elseif ($payment_status == '400') {
									$payment_owing = $is_payment_complete['data']['owing'];
									$payment_message = $is_payment_complete['data']['message'];

									$data['message'] = '
										<script>
											$("#receipt-number-form #amount").addClass("regerr");
											$("#amount-mess").html(accounting.formatMoney("' . $payment_owing . '", "&#x20A6;" , 0));
										</script>
										<div class="alert alert-info">
											<small>
												<i class="fa fa-check-double"></i>
												Payment info for selected session and term updated successfully!!!<br />
												<span id="amount-mess"></span> ' . $payment_message . ', and generate a result checking pin!!!<br />
												<i class="fa fa-spin fa-spinner-third"></i> Please Wait...
											</small>
										</div>
									';
									$data['status'] = '200';

								} else {
									$payment_message = $is_payment_complete['data']['message'];
									$data['message'] = '
										<div class="alert alert-danger remove">
											<small>
												<i class="fa fa-exclamation-triangle"></i>
												' . $payment_message . '<br />
												<small>Click to dismiss</small>
											</small>
										</div>
									';
									$data['status'] = '300';
								}

							} else {
								$data['message'] = '
									<div class="alert alert-danger remove">
										<small>
											<i class="fa fa-exclamation-circle"></i>
											Oops that was from us, please contact us if this error continues: Unable to update payment for selected session and term!!!<br />
											' . mysqli_error($this->link) . '<br />
											<small>Click to dismiss</small>
										</small>
									</div>
								';
								$data['status'] = '300';
							}

						} else {
							$data['message'] .= '
								<script>
									$("#receipt-number-form #amount_inp").addClass("regerr");
									$("#amount-mess").html(accounting.formatMoney("' . $owing . '", "&#x20A6;" , 0));
								</script>
								<div class="alert alert-danger remove">
									<small>
										<i class="fa fa-exclamation-circle"></i>
										Entered Amount exceeds amount been owed for selected session and term!!!<br />
										Amount owed: <span id="amount-mess"></span><br />
										<small>Click to dismiss</small>
									</small>
								</div>
							';
							$data['status'] = '300';
						}

					} elseif ($payment_status == '200') {
						$data['message'] = '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									' . $is_payment_complete['data']['message'] . '<br />
									<small>Click to dismiss</small>
								</small>
							</div>
						';
						$data['status'] = '200';

					} else {
						$data['message'] = '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									' . $is_payment_complete['data']['message'] . '<br />
									<small>Click to dismiss</small>
								</small>
							</div>
						';
						$data['status'] = '300';
					}

				} elseif ($q2->num_rows > 0 || $q3->num_rows > 0) {
					$data['message'] .= '
						<script>$("#receipt-number-form #receiptno").addClass("regerr");</script>
						<div class="alert alert-danger remove">
							<small>
								<i class="fa fa-exclamation-circle"></i>
								Inputted Receipt Number already exists!!!<br />
								<small>Click to dismiss</small>
							</small>
						</div>
					';
					$data['status'] = '300';
				}
			}

		} else {
			if ($payment_status == '200') {
				$data['message'] = '
					<div class="alert alert-success continue">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							' . $is_payment_complete['data']['message'] . '<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
				$data['status'] = '300';
			}
		}
		return (['data' => $data]);
	}

	/**
	 * @param $fees_id
	 * @param $class
	 * @param $session
	 * @param $term
	 * @param $amount
	 * @return array
	 */
	public function updateFeeScheme($fees_id, $class, $session, $term, $amount)
	{
		$data['message'] = '';
		$class_exists = $this->classExists($class);
		$session_exists = $this->sessionExists($session);
		$term_exists = $this->termExists($term);

		if ($class_exists && $session_exists && $term_exists) {
			$q = $this->link->query("UPDATE `school_fees` SET `class_id` = '{$class}', `session_id` = '{$session}', `term_id` = '{$term}', `amount` = '{$amount}' WHERE `id` = '{$fees_id}'");

			if ($q) {
				$data['message'] = '
					<div class="alert alert-success">
						<small>
							<i class="fa fa-check-double"></i>
							Fees Scheme Update Successfully!!!<br />
							<i class="fa fa-spin fa-spinner-third"></i> Please Wait...
						</small>
					</div>
				';
				$data['status'] = '200';

			} else {
				$data['message'] = '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							Oops that was from us, please contact us if this error continues: Unable to update fee scheme!!!<br />
							' . mysqli_error($this->link) . '<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
				$data['status'] = '300';
			}
		} else {
			if (!$class_exists) {
				$data['message'] .= '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							The selected class doesn\'t exist or hasn\'t bee created yet!!!<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
			}

			if (!$session_exists) {
				$data['message'] = '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							The selected school session doesn\'t exist or hasn\'t bee created yet!!!<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
			}

			if (!$term_exists) {
				$data['message'] = '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							The selected term doesn\'t exist or hasn\'t bee created yet!!!<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
			}
		}
		return (['data' => $data]);
	}

	/**
	 * @param $subject_id
	 * @param $class
	 * @param $term
	 * @param $subject
	 * @return array
	 */
	public function updateSubject($subject_id, $class, $term, $subject)
	{
		$data['message'] = '';
		$class_exists = $this->classExists($class);
		$term_exists = $this->termExists($term);

		if ($class_exists && $term_exists) {
			$q = $this->link->query("UPDATE `subjects` SET `class_id` = '{$class}', `term_id` = '{$term}', `subject` = '{$subject}' WHERE `id` = '{$subject_id}'");

			if ($q) {
				$data['message'] = '
					<div class="alert alert-success">
						<small>
							<i class="fa fa-check-double"></i>
							Subject Updated Successfully!!!<br />
							<i class="fa fa-spin fa-spinner-third"></i> Please Wait...
						</small>
					</div>
				';
				$data['status'] = '200';

			} else {
				$data['message'] = '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							Oops that was from us, please contact us if this error continues: Unable to update subject!!!<br />
							' . mysqli_error($this->link) . '<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
				$data['status'] = '300';
			}
		} else {
			if (!$class_exists) {
				$data['message'] .= '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							The selected class doesn\'t exist or hasn\'t bee created yet!!!<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
			}

			if (!$term_exists) {
				$data['message'] = '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							The selected term doesn\'t exist or hasn\'t bee created yet!!!<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
			}
		}
		return (['data' => $data]);
	}

	/**
	 * @param $score
	 * @return array
	 */
	public function getGrade($score)
	{
		$data['message'] = NULL;
		$infos = NULL;
		$scores = NULL;

		$q = $this->link->query("SELECT * FROM `grades` WHERE `score` <= '{$score}' LIMIT 1");
		if ($q->num_rows > 0) {
			$row = $q->fetch_array();

			$data['id'] = $row['id'];
			$data['message'] = $row['grade'];
			$data['status'] = '200';

		} else {
			$data['message'] = 'An error occurred: ' . mysqli_error($this->link) . '!!!';
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * @param $student
	 * @param $class
	 * @param $session
	 * @param $term
	 * @return array
	 */
	public function getAverage($student, $class, $session, $term)
	{
		$data['message'] = NULL;

		$q = $this->link->query("SELECT SUM(`total`) AS `cumulative_total` FROM `student_results` WHERE `student_id` = '{$student}' AND `class_id` = '{$class}' AND `session_id` = '{$session}' AND `term_id` = '{$term}'");

		if ($q) {
			$row = $q->fetch_array();
			$data['cumulative_total'] = $row['cumulative_total'];
			$q = $this->link->query("SELECT * FROM `student_results` WHERE `student_id` = '{$student}' AND `class_id` = '{$class}' AND `session_id` = '{$session}' AND `term_id` = '{$term}'");
			$data['result_subject_count'] = $q->num_rows;

			if ($q && $data['result_subject_count'] > 0) {

				$q = $this->link->query("SELECT * FROM `subjects` WHERE `class_id` = '{$class}' AND `session_id` = '{$session}' AND `term_id` = '{$term}'");
				$data['subject_count'] = $q->num_rows;

				if ($q && $data['subject_count'] > 0) {

					if (($data['result_subject_count'] == $data['subject_count'])) {
						$data['average'] = $data['cumulative_total'] / $data['result_subject_count'];
						$data['message'] = $data['average'];
						$data['status'] = '200';

					} else {
						$data['message'] .= '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									Please upload all subjects scores for selected Class, Student, Session and Term to continue!!!<br />
									<small>Click to dismiss</small>
								</small>
							</div>
						';
						$data['status'] = '300';
					}

				} else {
					if (!$q) {
						$data['message'] .= '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									Oops that was from us, please contact us if this error continues: Problem fetching subjects for selected class, session and term!!!<br />
									' . mysqli_error($this->link) . '
									<small>Click to dismiss</small>
								</small>
							</div>
						';
					}

					if ($data['subject_count'] < 1) {
						$data['message'] .= '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									No subject available for selected class, session and term!!!<br />
									<small>Click to dismiss</small>
								</small>
							</div>
						';
					}
					$data['status'] = '300';
				}

			} else {
				if (!$q) {
					$data['message'] .= '
						<div class="alert alert-danger remove">
							<small>
								<i class="fa fa-exclamation-circle"></i>
								Oops that was from us, please contact us if this error continues: Problem fetching student\'s result details!!!<br />
								' . mysqli_error($this->link) . '
								<small>Click to dismiss</small>
							</small>
						</div>
					';
				}

				if ($data['result_subject_count'] < 1) {
					$data['message'] .= '
						<div class="alert alert-danger remove">
							<small>
								<i class="fa fa-exclamation-circle"></i>
								No result to compute for selected class, session, term and student!!!<br />
								<small>Click to dismiss</small>
							</small>
						</div>
					';
				}
				$data['status'] = '300';
			}

		} else {
			$data['message'] .= '
				<div class="alert alert-danger remove">
					<small>
						<i class="fa fa-exclamation-circle"></i>
						Oops that was from us, please contact us if this error continues: Unable to get cumulative_total!!!<br />
						' . mysqli_error($this->link) . '
						<small>Click to dismiss</small>
					</small>
				</div>
			';
			$data['status'] = '300';
		}
		return (['data' => $data]);
	}

	/**
	 * @param $action
	 * @param $class
	 * @param $session
	 * @param $term
	 * @param $student
	 * @param $subject
	 * @param $ca_one
	 * @param $ca_two
	 * @param $exam
	 * @return array
	 */
	public function uploadResult($action, $class, $session, $term, $student, $subject, $ca_one, $ca_two, $exam)
	{
		$data['message'] = NULL;

		$q = $this->link->query("SELECT * FROM `student_results` INNER JOIN `students` stu ON student_results.student_id = stu.id RIGHT JOIN `class` c ON student_results.class_id = c.id RIGHT OUTER JOIN `session` s ON student_results.session_id = s.id RIGHT OUTER JOIN `term` t ON student_results.term_id = t.id RIGHT OUTER JOIN `subjects` sub ON student_results.subject_id = sub.id  RIGHT OUTER JOIN grades g on student_results.grade_id = g.id  WHERE student_results.student_id = '{$student}' AND student_results.class_id = '{$class}' AND student_results.session_id = '{$session}' AND student_results.term_id = '{$term}' AND student_results.subject_id = '{$subject}'");

		if ($ca_one < 21 && $ca_two < 21 && $exam < 61) {
			if ($action == 'upload-result') {
				if ($q->num_rows < 1) {
					$total = (int)$ca_one + (int)$ca_two + (int)$exam;
					$grade_id = $this->getGrade($total);
					$grade_id = $grade_id['data']['id'];

					$q = $this->link->query("INSERT INTO `student_results` (`id`, `student_id`, `class_id`, `session_id`, `term_id`, `subject_id`, `CA1_score`, `CA2_score`, `exam_score`, `total`, grade_id) VALUES (NULL, '{$student}', '{$class}', '{$session}', '{$term}', '{$subject}', '{$ca_one}', '{$ca_two}', '{$exam}', '{$total}', '{$grade_id}')");

					if ($q) {
						$data['message'] = '
							<div class="alert alert-success">
								<small>
									<i class="fa fa-check-double"></i>
									Result Uploaded Successfully!!!<br />
									<i class="fa fa-spin fa-spinner-third"></i> Please Wait...
								</small>
							</div>
						';
						$data['status'] = '200';

					} else {
						$data['message'] = '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									Oops that was from us, please contact us if this error continues: Unable to upload result!!!<br />
									' . mysqli_error($this->link) . '
									<small>Click to dismiss</small>
								</small>
							</div>
						';
						$data['status'] = '300';
					}

				} else {
					$row = $q->fetch_array();
					$stu_name = $row['lname'] . ' ' . $row['mname'] . ' ' . $row['fname'];
					$stu_class = $row['class'];
					$session = $row['session'];
					$subject = $row['subject'];
					$ca_one_score = $row['CA1_score'];
					$ca_two_score = $row['CA2_score'];
					$exam_score = $row['exam_score'];
					$grade = $row['grade'];
					$total = $row['total'];
					$term = $row['term'];

					$data['message'] = 'This Students\' result for selected subject, session and term has already been uploaded!!!' . "\r\n\r\n" . 'Student: ' . $stu_name . '' . "\r\n" . 'Class: ' . $stu_class . '' . "\r\n" . 'Session: ' . $session . '' . "\r\n" . 'Term: ' .
					                   $term . '' . "\r\n" . 'Subject: ' . $subject . '' . "\r\n" . 'CA 1 Score: ' . $ca_one_score . '' . "\r\n" . 'CA 2 Score: ' . $ca_two_score . '' . "\r\n" . 'Exam Score: ' . $exam_score . '' . "\r\n" . 'Grade: ' . $grade . '' . "\r\n" .
					                   'Total Score: ' . $total . '' . "\r\n\r\n"
					                   . 'Do you want to update it!!!?';
					$data['status'] = '400';
				}

			} elseif ($action == 'update-result') {
				$total = (int)$ca_one + (int)$ca_two + (int)$exam;
				$grade_id = $this->getGrade($total);
				$grade_id = $grade_id['data']['id'];

				$q = $this->link->query("UPDATE `student_results` SET `CA1_score` = '{$ca_one}', `CA2_score` = '{$ca_two}', `exam_score` = '{$exam}', `total` = '{$total}', grade_id = '{$grade_id}' WHERE `student_id` = '{$student}' AND `class_id` = '{$class}' AND `session_id` = '{$session}' AND `term_id` = '{$term}' AND `subject_id` = '{$subject}'");

				if ($q) {
					$data['message'] = '
						<div class="alert alert-success remove">
							<small>
								<i class="fa fa-check-double"></i>
								Result Uploaded Successfully!!!<br />
								<small>Click to dismiss...</small>
							</small>
						</div>
					';
					$data['status'] = '200';

				} else {
					$data['message'] = '
						<div class="alert alert-danger remove">
							<small>
								<i class="fa fa-exclamation-circle"></i>
								Oops that was from us, please contact us if this error continues: Result update failed!!!<br />
								' . mysqli_error($this->link) . '
								<small>Click to dismiss</small>
							</small>
						</div>
					';
					$data['status'] = '300';
				}
			}

		} else {
			if ($ca_one > 20) {
				$data['message'] .= '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							Score for CA1 must be between 0 - 20<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
			}

			if ($ca_two > 20) {
				$data['message'] .= '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							Score for CA2 must be between 0 - 20<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
			}

			if ($exam > 60) {
				$data['message'] .= '
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							Exam score must be between 0 - 60<br />
							<small>Click to dismiss</small>
						</small>
					</div>
				';
			}
			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	public function viewResults($student, $class, $session, $term)
	{
		$data = NULL;
		$infos = NULL;
		$info = NULL;

		$q = $this->link->query("SELECT * FROM `student_results` RIGHT OUTER JOIN subjects s on student_results.subject_id = s.id RIGHT OUTER JOIN grades g on student_results.grade_id = g.id WHERE student_results.`student_id` = '{$student}' AND student_results.`class_id` = '{$class}' AND student_results.`session_id` = '{$session}' AND student_results.`term_id` = '{$term}'");

		if ($q && $q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$infos[] = $row;
			}
			$data['info'] = $infos;

			foreach ($data['info'] as $infos) {
				$info[] = '
					<tr>
						<td>' . $infos[0] . '</td>
						<td>' . $infos['subject'] . '</td>
						<td>' . $infos['CA1_score'] . '</td>
						<td>' . $infos['CA2_score'] . '</td>
						<td>' . $infos['exam_score'] . '</td>
						<td>' . $infos['total'] . '</td>
						<td>' . $infos['grade'] . '</td>
					</tr>
				';
			}
			$data['info'] = $info;

		} else {
			$data['info'] = 'Nothing';
		}

		return (['data' => $data]);
	}

	/**
	 * @param $admno
	 * @param $passport
	 * @param $date
	 * @return array
	 */
	public function passportUpdate($admno, $passport, $date)
	{
		$data['message'] = '';
		$student_id_exists = $this->studentIDExists($admno);

		if ($student_id_exists) {
			$success = '
					<div class="alert alert-success">
						<small>
							<i class="fa fa-check-double"></i>
							Passport successfully updated!!!<br />
							<i class="fa fa-spin fa-spinner-third"></i> 
							Please wait...
						</small>
					</div>
				';

			$failure = '
				<div class="alert alert-danger remove">
					<small>
						<i class="fa fa-exclamation-circle"></i>
						Oops that was from us, contact us if this error continues: Update DB!!!<br />
						' . mysqli_error($this->link) . '<br />
						<small>Click to dismiss</small>
					</small>
				</div>
			';

			$n_admno = $admno;
			$n_admno = str_replace('/', '-', $n_admno);

			$pic_settings = [
				'path' => './../../../data/student_pics/' . $n_admno . '/',
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
							$data['message'] .= $success;
							$data['status'] = '200';

						} else {
							$data['message'] = $failure;
							$data['status'] = '300';
						}

					} else {
						$data['message'] .= '
							<script>$("#passport").addClass("regerr").focus()</script>
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									Oops that was from us, please contact us if this error continues: Cannot move file to specified location -- Upload aborted!!!<br />
									' . mysqli_error($this->link) . '<br />
									<small>CLick to dismiss</small>
								</small>
							</div>
						';
						$data['status'] = '300';
					}

				} else {
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
				$data['message'] .= '
					<script>$("#passport").addClass("regerr").focus()</script>
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-circle"></i>
							Selected file is not an image; Please select an image with any of the following formats: \'jpg\', \'png\', \'gif\' or \'bmp\' -- Upload aborted<br />
							<small>CLick to dismiss</small>
						</small>
					</div>
				';
				$data['status'] = '300';
			}
		}
		return ['data' => $data];
	}

	/**
	 * @param $id
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
	 * @param $med_con
	 * @param $raddress
	 * @param $med_det
	 * @return array
	 */
	public function updateStudentInfo($id, $fname, $mname, $lname, $admno, $class, $religion, $state_sel, $lga_sel, $dob, $gender, $phone, $med_con, $raddress, $med_det)
	{
		$sie = '';
		$sne = '';
		$data['message'] = '';
		$student_exists = $this->studentIDExists($id);
		$student_id_exists = $this->studentIDExists($admno);
		$id_stu_admno = $this->getStudentByID($admno);
		$id_stu_name = $this->getStudentByName($fname, $mname, $lname);
		$student_name_exists = $this->studentNameExists($fname, $mname, $lname);

		if (($id_stu_admno['data']['status'] == '200') && ($id_stu_name['data']['status'] == '200')) {
			$stu_admno_id = $id_stu_admno['data']['info'];
			$stu_admno_id = $stu_admno_id['adm_id'];

			$stu_name_id = $id_stu_name['data']['info'];
			$stu_name_id = $stu_name_id['adm_id'];

		} else {
			if (($id_stu_admno['data']['status'] == '200')) {
				$stu_admno_id = $id_stu_admno['data']['info'];
				$stu_admno_id = $stu_admno_id['adm_id'];

			} else {
				$stu_admno_id = '300';
			}

			if (($id_stu_name['data']['status'] == '200')) {
				$stu_name_id = $id_stu_name['data']['info'];
				$stu_name_id = $stu_name_id['adm_id'];

			} else {
				$stu_name_id = '300';
			}

		}

		if ($student_exists) {
			if (($student_id_exists) && ($id == $stu_admno_id)) {
				$sie = '200';

			} else {
				if (!$student_id_exists) {
					$sie = '200';
				}

				if (($student_id_exists) && ($id !== $stu_admno_id)) {
					$sie = $stu_admno_id;
				}
			}

			if (($student_name_exists) && ($id == $stu_name_id)) {
				$sne = '200';

			} else {
				if (!$student_name_exists) {
					$sne = '200';
				}

				if (($student_name_exists) && ($id !== $stu_name_id)) {
					$sne = $stu_name_id;
				}
			}

			if (($sie == '200') && ($sne == '200')) {
				if ((strlen($fname) < 51 && strlen($fname) > 1) && (strlen($phone) < 16 && strlen($phone) > 4)) {
					$q = $this->link->query("UPDATE `students` SET `fname` = '{$fname}', `mname` = '{$mname}', `lname` = '{$lname}', `adm_id` = '{$admno}', `class_id` = '{$class}', `religion` = '{$religion}', `sor` = '{$state_sel}', `lga` = '{$lga_sel}', `dob` = '{$dob}', `gender` = '{$gender}', `pnum` = '{$phone}', `med_con` = '$med_con', `r_address` = '{$raddress}', `med_con_det` = '$med_det' WHERE `adm_id` = '{$id}'");

					if ($q) {
						if ($med_con == 'no') {
							$this->link->query("UPDATE `students` SET `med_con_det` = '' WHERE `adm_id` = '{$id}'");
						}

						$data['message'] = '
							<div class="alert alert-success">
								<small>
									<i class="fa fa-check-double"></i>
									Student Info updated successfully<br />
									<i class="fa fa-spin fa-spinner-third"></i> Please Wait...
								</small>
							</div>
						';
						$data['status'] = '200';

					} else {
						$data['message'] = '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									Oops, that was from us, contact us if this error continues: Update student info failed!!!<br />
									<small>Click to dismiss</small>
								</small>
							</div>
						';
						$data['status'] = '300';
					}

				} else {
					if (strlen($fname) < 4 || strlen($fname) > 50) {
						$data['message'] .= '
							<script>
								$("#edit-student-form #fname").addClass("regerr");
								$("#edit-student-form #fnameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Field length is between 4 - 50 characters!!!</small>");
								$("#edit-student-form #fnameValidate")
								.removeClass("alert-success")
								.removeClass("alert-danger")
								.addClass("alert-danger")
								.fadeIn();
							</script>
						';
					}

					if (strlen($phone) < 5 || strlen($phone) > 15) {
						$data['message'] .= '
							<script>
								$("#edit-student-form #phone").addClass("regerr").focus();
								$("#edit-student-form #phoneValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Phone number must be between 5 - 15 digits!!!</small>");
								$("#edit-student-form #phoneValidate")
								.removeClass("alert-success")
								.removeClass("alert-danger")
								.addClass("alert-danger")
								.fadeIn();							
							</script>
						';
					}
					$data['status'] = '3002';
				}

			} else {
				if ($sie !== '200') {
					$data['message'] .= '
						<script>$("#edit-student-form #admno").addClass("regerr").focus();</script>
						<div class="alert alert-danger remove">
							<small>
								<i class="fa fa-exclamation-circle"></i>
								A student is already assigned the Admission Number!!!<br />
								<small>Click to dismiss</small>
							</small>
						</div>
					';
				}

				if ($sne !== '200') {
					$data['message'] .= '
						<script>$("#edit-student-form #fname").addClass("regerr").focus();</script>
						<div class="alert alert-danger remove">
							<small>
								<i class="fa fa-exclamation-circle"></i>
								Duplicate name!!! Check Student with Admission Number: ' . $sne . '<br />
								Change either First name, Middle name, Last name or all!!!<br />
								<small>Click to dismiss</small>
							</small>
						</div>
					';
				}
				$data['status'] = '300';
			}

		} else {
			$data['message'] .= '
				<div class="alert alert-danger remove">
					<small>
						<i class="fa fa-exclamation-circle"></i>
						Update failed, student doesn\'t exist!!!<br />
						<small>Click to dismiss</small>
					</small>
				</div>
			';
			$data['status'] = '300';
		}

		return ['data' => $data];
	}

	/**
	 * @param $admno
	 * @param $p_g_name
	 * @param $p_g_phone
	 * @param $p_g_occ
	 * @param $p_g_raddress
	 * @return array
	 */
	public function updateParentInfo($admno, $p_g_name, $p_g_phone, $p_g_occ, $p_g_raddress)
	{
		$data['message'] = '';
		$student_exists = $this->studentIDExists($admno);

		if ($student_exists) {
			if ((strlen($p_g_name) < 103 && strlen($p_g_name) > 3) && (strlen($p_g_phone) < 16 && strlen($p_g_phone) > 4)) {
				$q = $this->link->query("SELECT * FROM `parents` WHERE `student_id` = '{$admno}' LIMIT 1");

				if ($q && $q->num_rows > 0) {
					$q = $this->link->query("UPDATE `parents` SET `name` = '{$p_g_name}', `phone` = '{$p_g_phone}', `occupation` = '{$p_g_occ}', `address` = '{$p_g_raddress}' WHERE `student_id` = '{$admno}'");
					if ($q) {
						$data['message'] = '
							<div class="alert alert-success">
								<small>
									<i class="fa fa-check-double"></i>
									Parent Info updated successfully<br />
									<i class="fa fa-spin fa-spinner-third"></i> Please Wait...
								</small>
							</div>
						';
						$data['status'] = '200';

					} else {
						$data['message'] .= '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									Oops, that was from us, contact us if this error continues: Update parent info failed!!!<br />
									<small>Click to dismiss</small>
								</small>
							</div>
						';
						$data['status'] = '300';
					}

				} else {
					if (!$q) {
						$data['message'] .= '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									Oops, that was from us, contact us if this error continues: Student-Parent Validate failed!!!<br />
									<small>Click to dismiss</small>
								</small>
							</div>
						';
					}

					if ($q->num_rows < 0) {
						$data['message'] .= '
							<div class="alert alert-danger remove">
								<small>
									<i class="fa fa-exclamation-circle"></i>
									There has been an error, contact us if this continues: Student-Parent DB conflict!!!<br />
									<small>Click to dismiss</small>
								</small>
							</div>
						';
					}
					$data['status'] = '300';
				}

			} else {
				if (strlen($p_g_name) < 4 || strlen($p_g_name) > 102) {
					$data['message'] .= '
						<script>
							$("#edit-parent-form #p_g_name").addClass("regerr");
							$("#edit-parent-form #p_g_nameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Field length is between 4 - 102 characters!!!</small>");
							$("#edit-parent-form #p_g_nameValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

				if (strlen($p_g_phone) < 5 || strlen($p_g_phone) > 15) {
					$data['message'] .= '
						<script>
							$("#edit-parent-form #p_g_phone").addClass("regerr").focus();
							$("#edit-parent-form #p_g_phoneValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Phone number must be between 5 - 15 digits!!!</small>");
							$("#edit-parent-form #p_g_phoneValidate")
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
			$data['message'] .= '
				<div class="alert alert-danger remove">
					<small>
						<i class="fa fa-exclamation-circle"></i>
						Update failed, student with admission number: ' . $admno . ' doesn\'t exist!!!<br />
						<small>Click to dismiss</small>
					</small>
				</div>
			';
			$data['status'] = '300';
		}
		return ['data' => $data];
	}
}

// Initialize POST actions
if ((isset($_POST) || isset($_GET)) && (!empty($_POST['action']) || !empty($_GET['action']))) {
	if (!empty($_GET)) {
		extract($_GET);
		$action = $_GET['action']; ## Assign GET index: action; to variable $action

	} elseif (!empty($_POST['action'])) {
		extract($_POST);
		$action = $_POST['action']; ## Assign POST index: action; to variable $action
	}

	$data['message'] = '';

	if ($action == 'manage_students') {
		$students = new manage($connect);

		try {
			$data['students'] = $students->manageStudents($column, $query, $connect);

		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$data['status'] = '300';
		}

		$data['type'] = $type;
		echo json_encode(['data' => $data]);
	}

	if ($action == 'view_students') {
		$students = new manage($connect);

		try {
			$data['students'] = $students->viewStudents($column, $query);

		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$data['status'] = '300';
		}

		$data['type'] = $type;
		echo json_encode(['data' => $data]);
	}

	if ($action == 'delete-student') {

		if (!empty($admno)) {
			$delete_stu = new manage($connect);
			$data['delete_stu'] = $delete_stu->deleteStudentById($admno);
			$data['status'] = '200';

		} else {
			$data['message'] = 'Error: Student not found or admission number doesn\'t exist!!!';
			$data['status'] = '300';
		}
		echo json_encode(['data' => $data]);
	}

	if ($action == 'delete-payment') {

		if (!empty($admno)) {
			$delete_payment = new manage($connect);
			$data['delete_payment'] = $delete_payment->deletePayment($admno, $session, $term);
			$data['status'] = '200';

		} else {
			$data['message'] = 'Error: Student not found or admission number doesn\'t exist!!!';
			$data['status'] = '300';
		}
		echo json_encode(['data' => $data]);
	}

	if ($action == 'manage-fees') {
		$fees = new manage($connect);
		$data['fees'] = $fees->manageFees($column, $query);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'manage-subjects') {
		$subjects = new manage($connect);
		$data['subjects'] = $subjects->manageSubjects($column, $query);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'manage-classes') {
		$classes = new manage($connect);
		$data['classes'] = $classes->manageClasses($column, $query);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'manage-sessions') {
		$sessions = new manage($connect);
		$data['sessions'] = $sessions->manageSessions($column, $query);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'manage-terms') {
		$terms = new manage($connect);
		$data['terms'] = $terms->manageTerms($column, $query);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'add-fees') {
		$add_fees = new manage($connect);
		$data['add_fees'] = $add_fees->addFeesScheme($class, $session, $term, $amount);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'add-subject') {
		$add_subject = new manage($connect);
		$data['add_subject'] = $add_subject->addSubject($class, $term, $subject);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'delete-class') {
		$delete_class = new manage($connect);
		$data['delete_class'] = $delete_class->deleteClassById($table_id);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'edit-class') {
		$edit_class = new manage($connect);
		$data['edit_class'] = $edit_class->editClass($class_edit, $new_class);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'add-class') {
		$add_class = new manage($connect);
		$data['add_class'] = $add_class->addClass($class);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'add-session') {
		$add_session = new manage($connect);
		$data['add_session'] = $add_session->addSession($session, $c_session);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'add-term') {
		$add_term = new manage($connect);
		$data['add_term'] = $add_term->addTerm($term, $c_term);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'delete-session') {
		$delete_session = new manage($connect);
		$data['delete_session'] = $delete_session->deleteSessionById($table_id);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'delete-term') {
		$delete_term = new manage($connect);
		$data['delete_term'] = $delete_term->deleteTermById($table_id);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'get-fees-info') {
		$fees_info = new manage($connect);
		$data['fees_info'] = $fees_info->getFees($fees_id);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'get-subject-info') {
		$subject_info = new manage($connect);
		$data['subject_info'] = $subject_info->getSubject($subject_id);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'get-student-info') {
		$stu_info = new manage($connect);
		$data['stu_info'] = $stu_info->getStudentByID($admno);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'get-student-payments') {
		$stu_payments = new manage($connect);
		$data['stu_payments'] = $stu_payments->getStudentPayments($admno);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'get-payment-details') {
		$stu_payment_details = new manage($connect);
		$data['stu_payment_details'] = $stu_payment_details->getStudentPaymentDetails($admno, $session, $term);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'update-passport') {
		extract($_FILES);

		if (!empty($passport)) {
			$data['message'] = '
				<script>
					$("passport-update-form #passport").removeClass("regerr");
					$("#passport-update-form #passportValidate").fadeOut("");
				</script>
			';
			$passport_update = new manage($connect);
			$data['passport_update'] = $passport_update->passportUpdate($admno, $passport, $date);
			$data['status'] = '200';

		} else {
			if (empty($passport)) {
				$data['message'] = '
					<script>
						$("#passport-update-form #passport").addClass("regerr");
						$("#passport-update-form #passportValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> A passport photo is required!!!</small>");
						$("#passport-update-form #passportValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}
			$data['status'] = '300';
		}
		echo json_encode(['data' => $data]);
	}

	if ($action == 'add-payment-info') {
		if (!empty($session) && !empty($term) && !empty($receiptno) && (!empty($amount) || $amount !== '0')) {
			$data['message'] = '
				<script>
					$("#receipt-number-form #session").removeClass("regerr");
					$("#receipt-number-form #term").removeClass("regerr");
					$("#receipt-number-form #receiptno").removeClass("regerr");
					$("#receipt-number-form #amount_inp").removeClass("regerr");
					
					$("#receipt-number-form #sessionValidate").fadeOut("");
					$("#receipt-number-form #termValidate").fadeOut("");
					$("#receipt-number-form #receiptnoValidate").fadeOut("");
					$("#receipt-number-form #amount_inpValidate").fadeOut("");
                </script>
			';
			$add_payment = new manage($connect);
			$data['add_payment'] = $add_payment->addPayment($admno, $session, $term, $receiptno, $amount);
			$data['status'] = '200';

		} else {
			if (empty($session)) {
				$data['message'] .= '
					<script>
						$("#receipt-number-form #session").addClass("regerr");
						$("#receipt-number-form #sessionValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please select a session!!!</small>");
						$("#receipt-number-form #sessionValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($term)) {
				$data['message'] .= '
					<script>
						$("#receipt-number-form #term").addClass("regerr");
						$("#receipt-number-form #termValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please select a term!!!</small>");
						$("#receipt-number-form #termValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($receiptno)) {
				$data['message'] .= '
					<script>
						$("#receipt-number-form #receiptno").addClass("regerr");
						$("#receipt-number-form #receiptnoValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please input receipt number!!!</small>");
						$("#receipt-number-form #receiptnoValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if ((empty($amount) || $amount == '0')) {
				$data['message'] .= '
					<script>
						$("#receipt-number-form #amount_inp").addClass("regerr");
						$("#receipt-number-form #amountValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please input an amount!!!</small>");
						$("#receipt-number-form #amountValidate")
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

	if ($action == 'update-student-table') {
		$interval = $start->diff(new DateTime("{$dob}")); ## $interval: Calculate difference btw current date and Date of Birth
		$age = $interval->y; ## Current age

		if ((!empty($fname) && !empty($lname) && !empty($admno) && !empty($class) && !empty($religion) && !empty($state_sel) && !empty($lga_sel) && !empty($dob) && !empty($gender) && !empty($raddress) && !empty($med_con))) {

			if (empty($med_det)) {
				$med_det = NULL;
			}

			$m_m = NULL;
			$m_p = NULL;

			$raddress = preg_replace("/\n/", "<br />", "$raddress");
			$med_det = preg_replace("/\n/", "<br />", "$med_det");

			$fname = str_replace("'", "''", $fname);
			$lname = str_replace("'", "''", $lname);
			$mname = str_replace("'", "''", $mname);
			$admno = str_replace("'", "''", $admno);
			$phone = str_replace("'", "''", $phone);
			$raddress = str_replace("'", "''", $raddress);
			$med_det = str_replace("'", "''", $med_det);

			if (!empty($mname) || !empty($phone)) {
				if (!empty($mname)) {
					if (strlen($mname) < 2 || strlen($mname) > 50) {
						$data['message'] .= '
							<script>
								$("#edit-student-form #mname").addClass("regerr");
								$("#edit-student-form #mnameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Field length must be between 2 - 50 characters!!!</small>");
								$("#edit-student-form #mnameValidate")
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
								$("#edit-student-form #phone").addClass("regerr");
								$("#edit-student-form #phoneValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Phone Number must be between 5 - 15 digits!!!</small>");
								$("#edit-student-form #phoneValidate")
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
							$("#edit-student-form #dob").addClass("regerr").focus();
							$("#edit-student-form #dobValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> You must be between 8 - 20 yrs of age!!!</small>");
							$("#edit-student-form #dobValidate")
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
						$("#edit-student-form #fname").removeClass("regerr");
						$("#edit-student-form #mname").removeClass("regerr");
						$("#edit-student-form #lname").removeClass("regerr");
						$("#edit-student-form #admno").removeClass("regerr");
						$("#edit-student-form #class").removeClass("regerr");
						$("#edit-student-form #religion").removeClass("regerr");
						$("#edit-student-form #state_sel").removeClass("regerr");
						$("#edit-student-form #lga_sel").removeClass("regerr");
						$("#edit-student-form #dob").removeClass("regerr");
						$("#edit-student-form #gender").removeClass("regerr");
						$("#edit-student-form #phone").removeClass("regerr");
						$("#edit-student-form #raddress").removeClass("regerr");
						$("#edit-student-form #med_det").removeClass("regerr");
			
						$("#edit-student-form #fnameValidate").fadeOut("");
						$("#edit-student-form #mnameValidate").fadeOut("");
						$("#edit-student-form #lnameValidate").fadeOut("");
						$("#edit-student-form #admnoValidate").fadeOut("");
						$("#edit-student-form #classValidate").fadeOut("");
						$("#edit-student-form #religionValidate").fadeOut("");
						$("#edit-student-form #state_selValidate").fadeOut("");
						$("#edit-student-form #lga_selValidate").fadeOut("");
						$("#edit-student-form #dobValidate").fadeOut("");
						$("#edit-student-form #genderValidate").fadeOut("");
						$("#edit-student-form #phoneValidate").fadeOut("");
						$("#edit-student-form #raddressValidate").fadeOut("");
						$("#edit-student-form #med_conValidate").fadeOut("");
						$("#edit-student-form #med_detValidate").fadeOut("");
					</script>
				';
				$student = new manage($connect);
				$data['student'] = $student->updateStudentInfo($id, $fname, $mname, $lname, $admno, $class, $religion, $state_sel, $lga_sel, $dob, $gender, $phone, $med_con, $raddress, $med_det);
				$data['status'] = '200';

			} else {
				$data['message'] .= '
					<script>
						$("#edit-student-form #med_det").addClass("regerr");
						$("#edit-student-form #med_detValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please input you medical condition(s)!!!</small>");
						$("#edit-student-form #med_detValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
				$data['status'] = '300';
			}

		} else {
			if (empty($fname)) {
				$data['message'] .= '
					<script>
						$("#edit-student-form #fname").addClass("regerr");
						$("#edit-student-form #fnameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> First name field is required!!!</small>");
						$("#edit-student-form #fnameValidate")
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
						$("#edit-student-form #lname").addClass("regerr");
						$("#edit-student-form #lnameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Last name field is required!!!</small>");
						$("#edit-student-form #lnameValidate")
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
						$("#edit-student-form #admno").addClass("regerr");
						$("#edit-student-form #admnoValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Admission Number is required!!!</small>");
						$("#edit-student-form #admnoValidate")
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
						$("#edit-student-form #class").addClass("regerr");
						$("#edit-student-form #classValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please select your class!!!</small>");
						$("#edit-student-form #classValidate")
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
						$("#edit-student-form #religion").addClass("regerr");
						$("#edit-student-form #religionValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please select your religion!!!</small>");
						$("#edit-student-form #religionValidate")
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
						$("#edit-student-form #state_sel").addClass("regerr");
						$("#edit-student-form #state_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please select your state!!!</small>");
						$("#edit-student-form #state_selValidate")
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
						$("#edit-student-form #lga_sel").addClass("regerr");
						$("#edit-student-form #lga_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please choose your L.G.A!!!</small>");
						$("#edit-student-form #lga_selValidate")
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
						$("#edit-student-form #dob").addClass("regerr");
						$("#edit-student-form #dobValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Date of Birth is required!!!</small>");
						$("#edit-student-form #dobValidate")
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
						$("#edit-student-form #gender").addClass("regerr");
						$("#edit-student-form #genderValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please select your gender!!!</small>");
						$("#edit-student-form #genderValidate")
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
						$("#edit-student-form #raddress").addClass("regerr");
						$("#edit-student-form #raddressValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Current Residential Address is required!!!</small>");
						$("#edit-student-form #raddressValidate")
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
						$("#edit-student-form #med_conValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please choose an option!!!</small>");
						$("#edit-student-form #med_conValidate")
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

	if ($action == 'update-parent-table') {
		if ((!empty($p_g_name) && !empty($p_g_phone) && !empty($p_g_occ) && !empty($p_g_raddress))) {
			$p_g_occ = preg_replace("/\n/", "<br />", "$p_g_occ");
			$p_g_raddress = preg_replace("/\n/", "<br />", "$p_g_raddress");

			$p_g_name = str_replace("'", "''", $p_g_name);
			$p_g_phone = str_replace("'", "''", $p_g_phone);
			$p_g_occ = str_replace("'", "''", $p_g_occ);
			$p_g_raddress = str_replace("'", "''", $p_g_raddress);

			$data['message'] = '
				<script>
					$("#edit-parent-form #p_g_name").removeClass("regerr");
					$("#edit-parent-form #p_g_phone").removeClass("regerr");
					$("#edit-parent-form #p_g_occ").removeClass("regerr");
					$("#edit-parent-form #p_g_raddress").removeClass("regerr");
	
					$("#edit-parent-form #p_g_nameValidate").fadeOut("");
					$("#edit-parent-form #p_g_phoneValidate").fadeOut("");
					$("#edit-parent-form #p_g_occValidate").fadeOut("");
					$("#edit-parent-form #p_g_raddressValidate").fadeOut("");
				</script>
			';
			$parent = new manage($connect);
			$data['parent'] = $parent->updateParentInfo($id, $p_g_name, $p_g_phone, $p_g_occ, $p_g_raddress);
			$data['status'] = '200';

		} else {
			if (empty($p_g_name)) {
				$data['message'] .= '
					<script>
						$("#edit-parent-form #p_g_name").addClass("regerr");
						$("#edit-parent-form #p_g_nameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Parent/Guardian Name is required!!!</small>");
						$("#edit-parent-form #p_g_nameValidate")
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
						$("#edit-parent-form #p_g_phone").addClass("regerr");
						$("#edit-parent-form #p_g_phoneValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Parent/Guardian Phone Number is required!!!</small>");
						$("#edit-parent-form #p_g_phoneValidate")
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
						$("#edit-parent-form #p_g_occ").addClass("regerr");
						$("#edit-parent-form #p_g_occValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Parent/Guardian Occupation is required!!!</small>");
						$("#edit-parent-form #p_g_occValidate")
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
						$("#edit-parent-form #p_g_raddress").addClass("regerr");
						$("#edit-parent-form #p_g_raddressValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Parent/Guardian Current Residential Address is required!!!</small>");
						$("#edit-parent-form #p_g_raddressValidate")
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
	}

	if ($action == 'update-fees-scheme') {
		if ((!empty($class) && !empty($session) && !empty($term) && !empty($amount))) {
			$data['message'] = '
				<script>
					$("edit-fees-form #class_sel").removeClass("regerr");
					$("edit-fees-form #session_sel").removeClass("regerr");
					$("edit-fees-form #term_sel").removeClass("regerr");
					$("edit-fees-form #amount_inp").removeClass("regerr");
	
					$("edit-fees-form #class_selValidate").fadeOut("");
					$("edit-fees-form #session_selValidate").fadeOut("");
					$("edit-fees-form #term_selValidate").fadeOut("");
					$("edit-fees-form #amount_inpValidate").fadeOut("");
				</script>
			';
			$fee = new manage($connect);
			$data['fee'] = $fee->updateFeeScheme($fees_id, $class, $session, $term, $amount);
			$data['status'] = '200';

		} else {
			if (empty($class)) {
				$data['message'] .= '
					<script>
						$("#edit-fees-form #class_sel").addClass("regerr");
						$("#edit-fees-form #class_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Class!!!</small>");
						$("#edit-fees-form #class_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($session)) {
				$data['message'] .= '
					<script>
						$("#edit-fees-form #session_sel").addClass("regerr");
						$("#edit-fees-form #session_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Session!!!</small>");
						$("#edit-fees-form #session_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($term)) {
				$data['message'] .= '
					<script>
						$("#edit-fees-form #term_sel").addClass("regerr");
						$("#edit-fees-form #term_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Term!!!</small>");
						$("#edit-fees-form #term_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($amount)) {
				$data['message'] .= '
					<script>
						$("#edit-fees-form #amount_inp").addClass("regerr");
						$("#edit-fees-form #amount_inpValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please input amount!!!</small>");
						$("#edit-fees-form #amount_inpValidate")
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

	if ($action == 'update-subject') {
		if ((!empty($class) && !empty($term) && !empty($subject))) {
			$data['message'] = '
				<script>
					$("edit-subject-form #class_sel").removeClass("regerr");
					$("edit-subject-form #term_sel").removeClass("regerr");
					$("edit-subject-form #subject_inp").removeClass("regerr");
	
					$("edit-subject-form #class_selValidate").fadeOut("");
					$("edit-subject-form #term_selValidate").fadeOut("");
					$("edit-subject-form #subject_inpValidate").fadeOut("");
				</script>
			';
			$subject_update = new manage($connect);
			$data['subject_update'] = $subject_update->updateSubject($subject_id, $class, $term, $subject);
			$data['status'] = '200';

		} else {
			if (empty($class)) {
				$data['message'] .= '
					<script>
						$("#edit-subject-form #class_sel").addClass("regerr");
						$("#edit-subject-form #class_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Class!!!</small>");
						$("#edit-subject-form #class_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($term)) {
				$data['message'] .= '
					<script>
						$("#edit-subject-form #term_sel").addClass("regerr");
						$("#edit-subject-form #term_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Term!!!</small>");
						$("#edit-subject-form #term_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($subject)) {
				$data['message'] .= '
					<script>
						$("#edit-subject-form #subject_inp").addClass("regerr");
						$("#edit-subject-form #subject_inpValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please enter subject name!!!</small>");
						$("#edit-subject-form #subject_inpValidate")
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


	if ($action == 'upload-result' || $action == 'update-result') {
		if ((!empty($class) && !empty($session) && !empty($term) && !empty($student) && !empty($sub) && !empty($ca_one) && !empty($ca_two) && !empty($exam))) {
			$data['message'] = '
				<script>
					$("edit-subject-form #class_sel").removeClass("regerr");
					$("edit-subject-form #session_sel").removeClass("regerr");
					$("edit-subject-form #term_sel").removeClass("regerr");
					$("edit-subject-form #stu_sel").removeClass("regerr");
					$("edit-subject-form #sub_sel").removeClass("regerr");
					$("edit-subject-form #ca_one").removeClass("regerr");
					$("edit-subject-form #ca_two").removeClass("regerr");
					$("edit-subject-form #exam").removeClass("regerr");

					$("edit-subject-form #class_selValidate").fadeOut("");
					$("edit-subject-form #session_selValidate").fadeOut("");
					$("edit-subject-form #term_selValidate").fadeOut("");
					$("edit-subject-form #stu_selValidate").fadeOut("");	
					$("edit-subject-form #sub_selValidate").fadeOut("");
					$("edit-subject-form #ca_oneValidate").fadeOut("");
					$("edit-subject-form #ca_twoValidate").fadeOut("");
					$("edit-subject-form #examValidate").fadeOut("");
				</script>
			';
			$subject_update = new manage($connect);
			$data['result_upload'] = $subject_update->uploadResult($action, $class, $session, $term, $student, $sub, $ca_one, $ca_two, $exam);
			$data['status'] = '200';

		} else {
			if (empty($class)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #class_sel").addClass("regerr");
						$("#update-result-form #class_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Class!!!</small>");
						$("#update-result-form #class_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($session)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #session_sel").addClass("regerr");
						$("#update-result-form #session_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Session!!!</small>");
						$("#update-result-form #session_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($term)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #term_sel").addClass("regerr");
						$("#update-result-form #term_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Term!!!</small>");
						$("#update-result-form #term_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($student)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #stu_sel").addClass("regerr");
						$("#update-result-form #stu_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Student!!!</small>");
						$("#update-result-form #stu_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($sub)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #sub_sel").addClass("regerr");
						$("#update-result-form #sub_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Subject!!!</small>");
						$("#update-result-form #sub_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($ca_one)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #ca_one").addClass("regerr");
						$("#update-result-form #ca_oneValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please enter score for CA 1!!!</small>");
						$("#update-result-form #ca_oneValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($ca_two)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #ca_two").addClass("regerr");
						$("#update-result-form #ca_twoValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please enter score for CA 2!!!</small>");
						$("#update-result-form #ca_twoValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($exam)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #exam").addClass("regerr");
						$("#update-result-form #examValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please enter Exam score!!!</small>");
						$("#update-result-form #examValidate")
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

	if ($action == 'compute-result') {
		if ((!empty($class) && !empty($session) && !empty($term) && !empty($student))) {
			$data['message'] = '
				<script>
					$("edit-subject-form #class_sel").removeClass("regerr");
					$("edit-subject-form #session_sel").removeClass("regerr");
					$("edit-subject-form #term_sel").removeClass("regerr");
					$("edit-subject-form #stu_sel").removeClass("regerr");
	
					$("edit-subject-form #class_selValidate").fadeOut("");
					$("edit-subject-form #session_selValidate").fadeOut("");
					$("edit-subject-form #term_selValidate").fadeOut("");
					$("edit-subject-form #stu_selValidate").fadeOut("");
				</script>
			';
			$compute_result = new manage($connect);
			$data['compute_result'] = $compute_result->getAverage($student, $class, $session, $term);
			$data['status'] = '200';

		} else {
			if (empty($class)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #class_sel").addClass("regerr");
						$("#update-result-form #class_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Class!!!</small>");
						$("#update-result-form #class_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($session)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #session_sel").addClass("regerr");
						$("#update-result-form #session_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Session!!!</small>");
						$("#update-result-form #session_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($term)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #term_sel").addClass("regerr");
						$("#update-result-form #term_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Term!!!</small>");
						$("#update-result-form #term_selValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($student)) {
				$data['message'] .= '
					<script>
						$("#update-result-form #stu_sel").addClass("regerr");
						$("#update-result-form #stu_selValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Please Select a Student!!!</small>");
						$("#update-result-form #stu_selValidate")
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
						Select required fields to continue!!!<br />
						<small>Click to dismiss</small>
					</small>
				</div>
			';
			$data['status'] = '300';
		}
		echo json_encode(['data' => $data]);
	}

	if ($action == 'get-classes') {
		$classes = new manage($connect);
		$data['classes'] = $classes->getClasses();
		$data['status'] = '200';
		echo json_encode(['data' => $data]);
	}

	if ($action == 'get-sessions') {
		$sessions = new manage($connect);
		$data['sessions'] = $sessions->getSessions();
		$data['status'] = '200';
		echo json_encode(['data' => $data]);
	}

	if ($action == 'get-terms') {
		$terms = new manage($connect);
		$data['terms'] = $terms->getTerms();
		$data['status'] = '200';
		echo json_encode(['data' => $data]);
	}

	if ($action == 'get-students') {
		$students = new manage($connect);
		$data['students'] = $students->getStudentsByClass($class_id);
		$data['status'] = '200';
		echo json_encode(['data' => $data]);
	}

	if ($action == 'get-subjects') {
		$subjects = new manage($connect);
		$data['subjects'] = $subjects->getSubjects($class_id, $session_id, $term_id);
		$data['statufs'] = '200';
		echo json_encode(['data' => $data]);
	}

	if ($action == 'view-result') {
		$result = new manage($connect);
		$data['view_result'] = $result->viewResults(1, 3, 2, 1);
		echo json_encode(['data' => $data]);
	}
}

//$average = new manage($connect);
//$data['average'] = $average->getAverage(1, 3, 2, 1);
//echo json_encode(['data' => $data]);

//$average = new manage($connect);
//$data['average'] = $average->viewResults(1, 3, 2, 1);
//echo json_encode(['data' => $data]);