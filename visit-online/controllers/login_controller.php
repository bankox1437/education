<?php
session_start();
include "../../config/class_database.php";
include('../models/users_model.php');
include('../../config/main_function.php');
include('../../view-grade/models/term_model.php');

$main_func = new ClassMainFunctions();
$DB = new Class_Database();
$userModel = new User_Model($DB);
$termModel = new Term_Model($DB);

if (isset($_POST['login_method'])) {
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $result = $userModel->checkLogIn($username, $password, 'edu');
    $user_id = 0;
    if (count($result) > 0) {
        $user_id = $result[0]->id;
        $_SESSION['user_data'] = $result[0];
        $response = array('status' => true, 'msg' => 'เข้าสู่ระบบสำเร็จ');
    } else {
        $result = $userModel->checkLogIn($username, $password, 'other');
        if (count($result) > 0) {
            $user_id = $result[0]->id;
            $_SESSION['user_data'] = $result[0];
            $response = array('status' => true, 'msg' => 'เข้าสู่ระบบสำเร็จ');
        } else {
            $result = $userModel->checkLogIn($username, $password, 'admin');
            if (count($result) > 0) {
                $user_id = $result[0]->id;
                $_SESSION['user_data'] = $result[0];
                $response = array('status' => true, 'msg' => 'เข้าสู่ระบบสำเร็จ');
            } else {
                $response = array('status' => false, 'msg' => 'ไม่สามารถเข้าสู่ระบบได้ โปรดลองใหม่');
            }
        }
    }

    if (isset($_SESSION['user_data'])) {
        $role_status = $main_func->checkRole_status("visit_online");
        if (!$role_status) {
            session_destroy();
            $response = array('status' => false, 'msg' => 'ไม่สามารถเข้าสู่ระบบนี้ได้ เนื่องจากแอดมินระบบไม่ได้เปิดสิทธิใช้งาน');
            echo json_encode($response);
            exit();
        }
        $main_calendar = $userModel->getMainCalendar($user_id);
        if (count($main_calendar) > 0) {
            $_SESSION['main_calendar'] = $main_calendar[0];
        }

        $term_data = $termModel->getTermByAdmin();
        $term_data = json_decode($term_data);
        $_SESSION['term_data'] = $term_data;

        $term_active = $termModel->getrTermActive();
        if (count($term_active) > 0) {
            $_SESSION['term_active'] = $term_active[0];
        }
    }
    echo json_encode($response);
}


if (isset($_POST['logout_method'])) {
    session_destroy();
    $response = array('status' => true, 'msg' => 'ออกจากระบบ');
    echo json_encode($response);
}
