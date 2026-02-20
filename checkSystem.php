<?php
session_start();
include('config/main_function.php');
$main_func = new ClassMainFunctions();

if (isset($_REQUEST['mode'])) {
    $system = $_REQUEST['systemText'];
    $role_status = $main_func->checkRole_status($system);
    echo json_encode(array('status' => $role_status));
}
