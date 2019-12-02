<?php require 'constants.php';?>
<?php
$connect = new \mysqli(HOST, USER, PWORD, DB);

if ($connect->connect_error) {
    # code...
    echo '<div class="connect_error"><h5>Connection error occured: ' . $connect->connect_error . '</h5></div>';
}
?>