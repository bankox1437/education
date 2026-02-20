<?php
session_start();
include "../../config/class_database.php";
include('../models/users_model.php');
include('../models/std_model.php');
include('../models/term_model.php');
include('../../config/main_function.php');
$main_func = new ClassMainFunctions();
$DB = new Class_Database();

if (isset($_POST['login_method'])) {
    $response = "";
    $userModel = new User_Model($DB);
    $termModel = new Term_Model($DB);
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);

    $index_menu = $_POST['index_menu'];
    $role_check = 0;
    switch ($index_menu) {
        case '1':
            $role_check = 4;
            break;
        case '2':
            $role_check = 3;
            break;
        case '3':
            $role_check = 2;
            break;
        case '5':
            $role_check = 5;
            break;
        case '6':
            $role_check = 7;
            break;
        case '7':
            $role_check = "other_user";
            break;
        default:
            $role_check = 6;
            break;
    }

    $result_password = $userModel->getUserByUsername($username);
    if (count($result_password) == 0) {
        $response = array('status' => false, 'msg' => "ไม่สามารถเข้าสู่ระบบได้\nโปรดตรวจสอบชื่อผู้ใช้และรหัสผ่าน \n ลองใหม่");
        echo json_encode($response);
        exit();
    }
    $password_check = $main_func->decryptData($result_password[0]->password);

    if ($password_check ===  $password) {
        $result = $userModel->checkLogIn($username, 'edu');
        if (count($result) > 0) {
            $_SESSION['user_data'] = $result[0];
            $response = array('status' => true, 'msg' => 'เข้าสู่ระบบสำเร็จ', "role_id" =>  $result[0]->role_id);
        } else {
            $result = $userModel->checkLogIn($username, 'other');
            if (count($result) > 0) {
                $_SESSION['user_data'] = $result[0];
                $response = array('status' => true, 'msg' => 'เข้าสู่ระบบสำเร็จ', "role_id" =>  $result[0]->role_id);
            } else {
                $result = $userModel->checkLogIn($username);
                if (count($result) > 0) {
                    $_SESSION['user_data'] = $result[0];
                    $response = array('status' => true, 'msg' => 'เข้าสู่ระบบสำเร็จ', "role_id" =>  $result[0]->role_id);
                } else {
                    $response = array('status' => false, 'msg' => "ไม่สามารถเข้าสู่ระบบได้\nโปรดตรวจสอบชื่อผู้ใช้และรหัสผ่าน \n ลองใหม่");
                }
            }
        }
    } else {
        $response = array('status' => false, 'msg' => "ไม่สามารถเข้าสู่ระบบได้\nโปรดตรวจสอบชื่อผู้ใช้และรหัสผ่าน \n ลองใหม่");
    }

    if (isset($_SESSION['user_data'])) {
        if ($_POST['std_import'] == 'false') {
            if ($_SESSION['user_data']->role_id != 4 && $_POST['system'] == 'reading') {
                $system = "reading";
                $system_title = "ส่งเสริมการอ่าน";
                $role_status = $main_func->checkRole_status($system);
                if (!$role_status) {
                    session_destroy();
                    $response = array('status' => false, 'msg' => "ไม่สามารถเข้าสู่ระบบ" . $system_title . "ได้ \n เนื่องจากแอดมินระบบไม่ได้เปิดสิทธิ์ใช้งาน \n โปรดติดต่อแอดมินระบบ");
                    echo json_encode($response);
                    exit();
                }
            }
        }
        unset($_SESSION['std_import']);

        $textMsg = "";
        $roleTextMap = [
            2 => "บัญชีแอดมินอำเภอ",
            3 => "บัญชีแอดมินครู",
            4 => "บัญชีนักศึกษา",
            5 => "บรรณารักษ์",
            6 => "บัญชีแอดมินจังหวัด",
            7 => "บัญชีแอดมินระดับภาค"
        ];
        $roleText = $roleTextMap[$_SESSION['user_data']->role_id];

        if (!empty($_SESSION['user_data']->role_custom_id)) {
            $roleText = $_SESSION['user_data']->role_c_name;
        }

        //$roleText = $_SESSION['user_data']->role_id == 2 ? "บัญชีแอดมินอำเภอ" : $_SESSION['user_data']->role_id == 3 ? "บัญชีแอดมินครู" :  $_SESSION['user_data']->role_id == 4 ? "บัญชีนักศึกษา" : "บัญชีแอดมินจังหวัด";
        if ($index_menu == '1') {
            $textMsg = $roleText . " ไม่สามารถเข้าสู่ระบบสำหรับนักศึกษาได้";
        } else if ($index_menu == '2') {
            $textMsg = $roleText . " ไม่สามารถเข้าสู่ระบบสำหรับแอดมินครูได้";
        } else if ($index_menu == '3') {
            $textAm = "แอดมินอำเภอ";
            $textMsg = $roleText . " ไม่สามารถเข้าสู่ระบบสำหรับ" . $textAm . "ได้";
        } else if ($index_menu == '4') {
            $textAm = "แอดมินจังหวัด";
            $textMsg = $roleText . " ไม่สามารถเข้าสู่ระบบสำหรับ" . $textAm . "ได้";
        } else if ($index_menu == '5') {
            $textAm = "บรรณารักษ์";
            $textMsg = $roleText . " ไม่สามารถเข้าสู่ระบบสำหรับ" . $textAm . "ได้";
        } else if ($index_menu == '6') {
            $textAm = "แอดมินระดับภาค";
            $textMsg = $roleText . " ไม่สามารถเข้าสู่ระบบสำหรับ" . $textAm . "ได้";
        } else if ($index_menu == '7') {
            $textAm = "ผู้ใช้งานอื่น ๆ ";
            $textMsg = $roleText . " ไม่สามารถเข้าสู่ระบบสำหรับ" . $textAm . "ได้";
        }

        if (!empty($_SESSION['user_data']->role_custom_id)) {
            $textMsg .= "\nโปรดเข้าใช้งานสำหรับผู้ใช้งานอื่น ๆ";
        }

        if (empty($_SESSION['user_data']->role_custom_id) && $role_check != $_SESSION['user_data']->role_id && $role_check != 'other_user') {
            $response = array('status' => false, 'msg' => $textMsg, 'redirect' => true);
            echo json_encode($response);
            session_destroy();
            exit();
        } else if (!empty($_SESSION['user_data']->role_custom_id) && $role_check != 'other_user') {
            $response = array('status' => false, 'msg' => $textMsg, 'redirect' => true);
            echo json_encode($response);
            session_destroy();
            exit();
        } else if (empty($_SESSION['user_data']->role_custom_id) && $role_check == 'other_user') {
            $response = array('status' => false, 'msg' => $textMsg, 'redirect' => true);
            echo json_encode($response);
            session_destroy();
            exit();
        }
        // else {
        //     $response = array('status' => false, 'msg' => $textMsg. " debug ", 'redirect' => true);
        //     echo json_encode($response);
        //     session_destroy();
        //     exit();
        // }

        // $district_id = 0;
        // if ($result[0]->role_id == 2) {
        //     $district_id = $result[0]->district_am_id;
        // } else if ($result[0]->role_id == 3 || $result[0]->role_id == 4) {
        //     $district_id = $result[0]->district_id;
        // }

        $main_calendar = $userModel->getMainCalendar($_SESSION['user_data']->id);
        if (count($main_calendar) > 0) {
            $newMainCalendar = array();
            foreach ($main_calendar as $key => $value) {
                $newMainCalendar[$value->std_class] = $value;
            }
            $_SESSION['main_calendar'] = $newMainCalendar;
        }

        $term_data = $termModel->getTermByAdmin();
        $term_data = json_decode($term_data);
        $_SESSION['term_data'] = $term_data;

        $term_active = $termModel->getrTermActive();
        if (count($term_active) > 0) {
            $_SESSION['term_active'] = $term_active[0];
        }

        if (!empty($_POST['search'])) {
            $_SESSION['search_param_gradiate'] = $main_func->encryptData($_POST['search']);
        }

        if (!empty($_POST['index_menu']) && $_POST['index_menu'] == 5 && $_SESSION['user_data']->role_id == 2) {
            $_SESSION['index_menu'] = 5;
        } else {
            $_SESSION['index_menu'] = $_SESSION['user_data']->role_id;
        }

        $response['role_id'] = $_SESSION['user_data']->role_id;
        $response['role_custom_id'] = $_SESSION['user_data']->role_custom_id;
    }

    if (isset($_SESSION['user_data']) && $_SESSION['user_data']->role_id == 3) {
        $stdModel = new STD_Model($DB);
        $stdModel->checkAndUpdateGenderStudents($main_func);
    }

    if (isset($_SESSION['user_data'])) {
        $userModel->updateLastLogin($_SESSION['user_data']->id);
    }

    echo json_encode($response);
}


if (isset($_POST['logout_method'])) {
    session_destroy();
    $response = array('status' => true, 'msg' => 'ออกจากระบบ');
    echo json_encode($response);
}
