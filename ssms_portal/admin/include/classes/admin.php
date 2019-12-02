<?php

namespace admin;

use mysqli;
use mysqli_sql_exception;

require_once '../session.php';
sleep(number_format(0.5));

/**
 * Class admin for SSMS Portal ADMIN
 * @author Fusion Bolt inc <fusionboltinc@gmail.com>
 */
class admin
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
	 * Checks if admin exists using student's admission number
	 * @param $a_email string Admin Email
	 * @return bool
	 */
	public function adminEmailExists($a_email)
	{
		$q = $this->link->query("SELECT * FROM `admin` WHERE `email` = '{$a_email}' LIMIT 1");

		if ($q->num_rows > 0) {
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Checks if admin exists using admins' name
	 * @param $a_name string Admin Name
	 * @return bool
	 */
	public function adminNameExists($a_name)
	{
		$q = $this->link->query("SELECT * FROM `admin` WHERE `name` = '{$a_name}' LIMIT 1");

		if ($q->num_rows > 0) {
			return true;

		} else {
			return false;
		}
	}

	/**
	 * @param $a_id
	 * @return array
	 */
	public function getAdminById($a_id)
	{
		$q = $this->link->query("SELECT * FROM `admin` WHERE `id` = '{$a_id}' LIMIT 1");

		if ($q->num_rows > 0) {
			$row = $q->fetch_array();
			$info[] = $row;
			$data['info'] = $info;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return ['data' => $data];
	}

	/**
	 * @param $a_email
	 * @return array
	 */
	public function getAdminByEmail($a_email)
	{
		$q = $this->link->query("SELECT * FROM `admin` WHERE `email` = '{$a_email}' LIMIT 1");

		if ($q->num_rows > 0) {
			$row = $q->fetch_array();
			$info[] = $row;
			$data['info'] = $info;
			$data['status'] = '200';

		} else {
			$data['status'] = '300';
		}
		return ['data' => $data];
	}

	/**
	 * @param $admin_name
	 * @return array
	 */
	public function deleteAdminByName($admin_name)
	{
		$data = NULL;

		try {
			$q1 = $this->link->query("DELETE FROM `admin` WHERE `name` = '{$admin_name}'");

			$data['message'] = 'Admins data deleted successfully!!!';
			$data['status'] = '200';

		} catch (mysqli_sql_exception $exception) {
			$data['message'] = $exception->getMessage();
			$data['status'] = '300';
		}

		return (['data' => $data]);
	}

	/**
	 * @param $admin_login
	 * @param $admin_password
	 * @return array
	 */
	public function adminLogin($admin_login, $admin_password)
	{
		$data['message'] = '';
		$admin_exists = $this->adminEmailExists($admin_login);

		if ($admin_exists) {
			$admin_password = md5($admin_password);
			$q = $this->link->query("SELECT * FROM `admin` WHERE `email` = '{$admin_login}' AND `password` = '{$admin_password}' LIMIT 1");

			if ($q && $q->num_rows > 0) {
				$row = $q->fetch_array();

				$_SESSION['admin_type'] = $row['privilege'];
				$_SESSION['admin_login'] = $admin_login;
				$_SESSION['admin_id'] = $row['id'];

				$data['message'] .= '
					<script>
						$("#login-form #login").removeClass("regerr");
						$("#login-form #pcode").removeClass("regerr");
						
						$("#login-form #loginValidate").fadeOut();
						$("#login-form #pcodeValidate").fadeOut();
						localStorage.setItem("ssms_admin", "' . $admin_login . '");
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
					$data['message'] .= '
						<script>$("#login-form #pcode").addClass("regerr").focus();</script>
				        <div class="alert alert-danger remove">
							<small >
								<i class="fa fa-exclamation-circle" ></i >
								Login Failed, Password incorrect!!!<br />
								<small > Click to dismiss </small >
							</small >
						</div >
					';
				}
				$data['status'] = '300';
			}

		} else {
			$data['message'] .= '
				<script>$("#login-form #login").addClass("regerr").focus();</script>
				<div class="alert alert-danger remove">
					<small>
						<i class="fa fa-exclamation-circle" ></i>
						Login failed, Admin with email: ' . $admin_login . ' doesn\'t exist!!!<br />
						<small>Click to dismiss</small>
					</small>
				</div>
			';
			$data['status'] = '300';
		}

		return ['data' => $data];
	}

	/**
	 * @param $name
	 * @param $email
	 * @param $pword
	 * @param $skey
	 * @return array
	 */
	public function adminRegister($name, $email, $pword, $skey)
	{
		$data['message'] = '';
		$admin_name_exists = $this->adminNameExists($name);
		$admin_email_exists = $this->adminEmailExists($email);

		if (!$admin_name_exists && !$admin_email_exists) {
			if (strlen($name) < 51 && strlen($name) > 1) {
				if ($skey == 'admin@bolt2019admin*') {
					$admin_type = 'admin';

				} elseif ($skey == 'admin@bolt2019principal-') {
					$admin_type = 'principal';

				} elseif ($skey == 'admin@bolt2019teacher+') {
					$admin_type = 'teacher';

				} elseif ($skey == 'admin@bolt2019examofficer=') {
					$admin_type = 'exam officer';

				} elseif ($skey == 'admin@bolt2019exambursar0') {
					$admin_type = 'bursar';

				} else {
					$admin_type = 'wrong';
				}

				if ($admin_type !== 'wrong') {
					$pword = md5($pword);
					$admin_q = $this->link->query("INSERT INTO `admin` (`id`, `name`, `email`, `password`, `privilege`) VALUES (NULL, '{$name}', '{$email}', '{$pword}', '{$admin_type}')");

					$success = '
						<div class="alert alert-success continue">
							<small>
								<i class="fa fa-check-double"></i>
								Registration Successful<br />
								<i class="fa fa-spin fa-spinner-third"></i> 
								Please Wait...
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

					if ($admin_q) {
						$q = $this->link->query("SELECT `id` FROM `admin` WHERE `email` = '{$email}'");
						$row = $q->fetch_assoc();
						$cid = $row['id'];

						if ($cid > 1) {
							$q = $this->link->query("SELECT `id` FROM `admin` WHERE `id` < '{$cid}' ORDER BY `id` DESC LIMIT 1");
							$row = $q->fetch_assoc();
							$pid = $row['id'];

							$pid += 1;
							$q = $this->link->query("UPDATE `admin` SET `id` = '{$pid}' WHERE `email` = '{$email}'");

							if ($q) {
								$data['message'] = $success;
								$data['status'] = '200';

							} else {
								$q = $this->link->query("DELETE FROM `admin` WHERE `email` = '{$email}'");
								$data['message'] = $failure;
								$data['status'] = '300';
							}

						} else {
							$data['message'] = $success;
							$data['status'] = '200';
						}

					}

				} else {
					$data['message'] .= '
						<script>
							$("#register-form #skey").addClass("regerr");
							$("#register-form #skeyValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Incorrect Admin secret key!!!</small>");
							$("#register-form #skeyValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}

			} else {
				if (strlen($name) < 2 || strlen($name) > 50) {
					$data['message'] .= '
						<script>
							$("#register-form #name").addClass("regerr");
							$("#register-form #nameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Field length is between 2 - 50 characters!!!</small>");
							$("#register-form #nameValidate")
							.removeClass("alert-success")
							.removeClass("alert-danger")
							.addClass("alert-danger")
							.fadeIn();
						</script>
					';
				}
			}

		} else {
			if ($admin_name_exists) {
				$data['message'] .= '
					<script>$("#register-form #name").addClass("regerr").focus();</script>
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-triangle"></i>
							Inputted Admin Name already exists!!!<br />
							<small>Click here to dismiss</small>
						</small>
					</div>
				';
			}

			if ($admin_email_exists) {
				$data['message'] .= '
					<script>$("#register-form #email").addClass("regerr").focus();</script>
					<div class="alert alert-danger remove">
						<small>
							<i class="fa fa-exclamation-triangle"></i>
							Inputted Admin Email already exists!!!<br />
							<small>Click here to dismiss</small>
						</small>
					</div>
				';
			}
			$data['status'] = '300';
		}
		return ['data' => $data];
	}

	/**
	 * @param $a_email
	 * @return array
	 */
	public function getAdmins($a_email)
	{
		$data = NULL;
		$admin_info = $this->getAdminByEmail($a_email);
		$admin_type = $admin_info['data'];
		$admin_type = $admin_type['info'][0];
		$admin_type = $admin_type['privilege'];

		$table_details_td = NULL;
		$table_display_td = NULL;

		$q = $this->link->query("SELECT * FROM `admin` WHERE `email` <> '{$a_email}'");
		$info = [];
		$infos = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_array()) {
				$infos[] = $row;
			}
			$data['info'] = $infos;

			foreach ($data['info'] as $infos) {
				if (($admin_type == 'admin') || ($admin_type == 'principal')) {
					if ($admin_type !== 'admin' && $infos['privilege'] == 'admin') {
						$a = '
							<i class="fad fa-do-not-enter mx-3" title="No action"></i>
						';

					} else {
						$a = '
							<a href="" class="edit mx-1" data-type="' . $infos['privilege'] . '" data-name="' . $infos['name'] . '" title="Edit this User"><i class="text-primary fa fa-user-edit"></i></a>
							<a href="" class="delete mx-1" data-type="' . $infos['privilege'] . '" data-name="' . $infos['name'] . '" title="Delete this user"><i class="text-danger fa fa-trash-alt"></i></a>
						';
					}

					$table_details_td = '
						<td>
							' . $a . '
						</td>
					';

				} else {
					$table_details_td = '
						<td><i class="fad fa-do-not-enter mx-3" title="No action"></i></td>
					';
				}

				$table_display_td = '
					<td>Actions</td>
				';

				$info[] = '
					<tr>
						<td>' . $infos['id'] . '</td>
						<td>' . $infos['name'] . '</td>
						<td>' . $infos['email'] . '</td>
						<td>' . $infos['active'] . '</td>
						<td>' . $infos['privilege'] . '</td>
						' . $table_details_td . '
					</tr>
				';
			}
			$data['info'] = $info;

			$data['table'] = '
				<table class="table table-hover table-responsive-md table-condensed table-striped">
					<thead>
					<tr>
						<td>#</td>
						<td>Name</td>
						<td>Email</td>
						<td>Active</td>
						<td>Admin Type</td>
						' . $table_display_td . '
					</tr>
					</thead>
					<tbody class="detail-pane"></tbody>
				</table>
			';
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

		if (!empty($admin_login) && !empty($admin_password)) {
			$data['message'] = '
				<script>
					$("#login-form #login").removeClass("regerr");
					$("#login-form #pword").removeClass("regerr");
					
					$("#login-form #loginValidate").fadeOut("");
					$("#login-form #pwordValidate").fadeOut("");
				</script>
			';

			$login = new admin($connect);
			$data['login'] = $login->adminLogin($admin_login, $admin_password);
			$data['status'] = '200';

		} else {
			if (empty($admin_login)) {
				$data['message'] .= '
					<script>
						$("#login-form #login").addClass("regerr");
						$("#login-form #loginValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Admin Email is required!!!</small>");
						$("#login-form #loginValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($admin_password)) {
				$data['message'] .= '
					<script>
						$("#login-form #pword").addClass("regerr");
						$("#login-form #pwordValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Password field is required!!!</small>");
						$("#login-form #pwordValidate")
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

		if (!empty($name) && !empty($email) && !empty($pword) && !empty($skey)) {
			$data['message'] = '
				<script>
					$("#register-form #name").removeClass("regerr");
					$("#register-form #email").removeClass("regerr");
					$("#register-form #pword").removeClass("regerr");
					$("#register-form #skey").removeClass("regerr");
					
					$("#register-form #nameValidate").fadeOut("");
					$("#register-form #emailValidate").fadeOut("");
					$("#register-form #pwordValidate").fadeOut("");
					$("#register-form #skeyValidate").fadeOut("");
				</script>
			';

			$register = new admin($connect);
			$data['register'] = $register->adminRegister($name, $email, $pword, $skey);
			$data['status'] = '200';

		} else {
			if (empty($name)) {
				$data['message'] .= '
					<script>
						$("#register-form #name").addClass("regerr");
						$("#register-form #nameValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> This field is required!!!</small>");
						$("#register-form #nameValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($email)) {
				$data['message'] .= '
					<script>
						$("#register-form #email").addClass("regerr");
						$("#register-form #emailValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Email field is required!!!</small>");
						$("#register-form #emailValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($pword)) {
				$data['message'] .= '
					<script>
						$("#register-form #pword").addClass("regerr");
						$("#register-form #pwordValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Input Password!!!</small>");
						$("#register-form #pwordValidate")
						.removeClass("alert-success")
						.removeClass("alert-danger")
						.addClass("alert-danger")
						.fadeIn();
					</script>
				';
			}

			if (empty($skey)) {
				$data['message'] .= '
					<script>
						$("#register-form #skey").addClass("regerr");
						$("#register-form #skeyValidate > div").prepend("<small><i class=\\"fa fa-exclamation-triangle\\"></i> Input Admin secret key to continue!!!</small>");
						$("#register-form #skeyValidate")
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

	if ($action == 'get-admins') {
		$admins = new admin($connect);
		$data['admins'] = $admins->getAdmins($_SESSION['admin_login']);
		echo json_encode(['data' => $data]);
	}

	if ($action == 'delete-admin') {
		if (!empty($admin_name)) {
			$delete_admin = new admin($connect);
			$data['delete_admin'] = $delete_admin->deleteAdminByName($admin_name);
			$data['status'] = '200';
		} else {
			$data['message'] = 'Error: Admin not found or name doesn\'t exist!!!';
			$data['status'] = '300';
		}
		echo json_encode(['data' => $data]);
	}
}