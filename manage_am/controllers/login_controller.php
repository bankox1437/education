<?php
session_start();
include "../../config/class_database.php";
include('../models/users_model.php');
include('../../view-grade/models/term_model.php');
include('../../config/main_function.php');
$main_func = new ClassMainFunctions();
$DB = new Class_Database();
if (isset($_POST['login_method'])) {
    $userModel = new User_Model($DB);
    $termModel = new Term_Model($DB);
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);

    $result_password = $userModel->getUserByUsername($username);
    $password_check = $main_func->decryptData($result_password[0]->password);
    if ($password_check ===  $password) {
        $result = $userModel->checkLogIn($username, 'edu');
        if (count($result) > 0) {
            $_SESSION['user_data'] = $result[0];
            $response = array('status' => true, 'msg' => 'เข้าสู่ระบบสำเร็จ');
        } else {
            $result = $userModel->checkLogIn($username, 'other');
            if (count($result) > 0) {
                $_SESSION['user_data'] = $result[0];
                $response = array('status' => true, 'msg' => 'เข้าสู่ระบบสำเร็จ');
            } else {
                $result = $userModel->checkLogIn($username, 'admin');
                if (count($result) > 0) {
                    $_SESSION['user_data'] = $result[0];
                    $response = array('status' => true, 'msg' => 'เข้าสู่ระบบสำเร็จ');
                } else {
                    $response = array('status' => false, 'msg' => "ไม่สามารถเข้าสู่ระบบได้\nโปรดตรวจสอบชื่อผู้ใช้และรหัสผ่าน \n ลองใหม่");
                }
            }
        }
    } else {
        $response = array('status' => false, 'msg' => "ไม่สามารถเข้าสู่ระบบได้\nโปรดตรวจสอบชื่อผู้ใช้และรหัสผ่าน \n ลองใหม่");
        echo json_encode($response);
        exit();
    }

    if ($_SESSION['user_data']->role_id != 1) {
        $response = array('status' => true, "role_id" => 0, 'msg' => 'ไม่สามารถเข้าสู่ระบบได้ เนื่องจากสิทธิ์ผู้ใช้งานไม่ถูกต้อง');
    }

    $term_data = $termModel->getTermByAdmin();
    $term_data = json_decode($term_data);
    $_SESSION['term_data'] = $term_data;

    $term_active = $termModel->getrTermActive();
    if (count($term_active) > 0) {
        $_SESSION['term_active'] = $term_active[0];
    }

    echo json_encode($response);
}


if (isset($_POST['logout_method'])) {
    session_destroy();
    $response = array('status' => true, 'msg' => 'ออกจากระบบ');
    echo json_encode($response);
}
