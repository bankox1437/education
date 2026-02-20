<?php
session_start();

if (isset($_POST['logout_method'])) {
    session_destroy();
    $response = array('status' => true, 'msg' => 'ออกจากระบบ');
    echo json_encode($response);
}
