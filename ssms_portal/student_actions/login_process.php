<?php include '../include/session.php';?>
<?php
if (!empty($_POST)) {
    # code...
    $user_login = @trim($_POST['user_login']);
    $user_passcode = @$_POST['user_pcode'];

    if (!empty($user_login) && !empty($user_passcode)) {
        # code...
        $user_passcode = md5($user_passcode);

        $u_exist_check = $connect->query("SELECT * FROM `students` WHERE `adm_id` = '{$user_login}'");

        if (($u_exist_check->num_rows) < 1) {
            # code...
            echo '
                <div class="alert alert-danger alert-dismissible" title="Click to dismiss">
                    <i class="fa fa-exclamation-circle"></i>
                    Account doesn\'t exist onn this platform!!!<br />
                    <small>click error to dismiss</small>
                </div>
            ';

        } elseif (($u_exist_check->num_rows) == 1) {
            # code...
            $u_validate = $connect->query("SELECT * FROM `students` WHERE `adm_id` = '{$user_login}' AND `pcode` = '{$user_passcode}'");

            if (($u_validate->num_rows) == 1) {
                # code...
                $_SESSION['user_login'] = $user_login;
    
                echo '
                    <div class="alert alert-success">
                        <i class="fa fa-check-double"></i>
                        Login Successful<br />
                        <small><i class="fa fa-spinner fa-spin"></i> Please wait</small>
                    </div>
                ';
    
            } else {
                # code...
                echo '
                    <div class="alert alert-danger alert-dismissible" title="Click to dismiss">
                        <i class="fa fa-exclamation-circle"></i>
                        Password is incorrect!!!<br />
                        <small>click error to dismiss</small>'.$user_passcode.'
                    </div>
                ';
            }

        } else {
            # code...
            echo '
                <div class="alert alert-danger alert-dismissible" title="Click to dismiss">
                    <i class="fa fa-exclamation-circle"></i>
                    error code: oo1Xla4ga3na
                    Oops that was from us, contact us at admin if this error continues!!!<br />
                    <small>click error to dismiss</small>
                </div>
            ';
            exit();
        }
    }
}
?>