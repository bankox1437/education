<?php
session_start();
include "../../config/class_database.php";
include '../models/users_model.php';
include('../../config/main_function.php');
$main_func = new ClassMainFunctions();
$DB = new Class_Database();

if (isset($_POST['getDataUserEdit'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $id = htmlentities($_POST['id']);
    $resultInsert = $userModel->getDataUserWhereId($id);
    $response = ['status' => true, 'data' => $resultInsert];
    echo json_encode($response);
}


if (isset($_POST['edit_profile'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $name = htmlentities($_POST['name']);
    $surname = htmlentities($_POST['surname']);
    $password = htmlentities($_POST['password']);

    $edu_name = htmlentities($_POST['edu_name']);
    $edu_id = htmlentities($_POST['edu_id']);

    $array_edu = [
        "edu_name" => $edu_name,
        "edu_id" => $edu_id
    ];

    $result = $userModel->editEdu($array_edu);
    if ($result == 1) {
        $_SESSION['user_data']->edu_name = $edu_name;
    }

    if (empty($password)) {
        $password = $_POST['password_old'];
    } else {
        $password = $main_func->encryptData($password);
    }

    $edit_date = date('Y-m-d H:i:s');
    $array_data = [
        "name" => $name,
        "surname" => $surname,
        "password" => $password,
        "edit_date" =>  $edit_date,
        "user_update" => $_SESSION['user_data']->id,
        "id" => $_SESSION['user_data']->id
    ];
    $resultInsert = $userModel->editProfile($array_data);
    if ($resultInsert == 1) {
        $_SESSION['user_data']->name = $name;
        $_SESSION['user_data']->surname = $surname;

        if ($_SESSION['user_data']->role_id == 4) {
            $stdTerm = $_POST['std_term'];
            $stdYear = $_POST['std_year'];
            $std_id = $_SESSION['user_data']->edu_type;
            $state = 'UPDATE ';
            $where = "WHERE std_id = {$std_id}";
            $sql =  $state . " tb_students SET \n" .
                "	std_term = '{$stdTerm}',\n" .
                "	std_year = '{$stdYear}'\n"
                . $where;
            $data = $DB->Update($sql, $arr_data);
        }

        $response = ['status' => true, 'msg' => ''];
    } else {
        $response = ['status' => false, 'msg' => $resultInsert];
    }
    echo json_encode($response);
}

if (isset($_POST['getDataProDistSub'])) {
    $userModel = new User_Model($DB);
    $table = isset($_POST['table']) ? $_POST['table'] : '';
    $result = $userModel->getDataProDistSub($table);
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_POST['addAdmin'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $edu_type = htmlentities($_POST['radio']);
    $role_id = htmlentities($_POST['role_id']);

    $edu_id = "";
    $name = htmlentities($_POST['name']);
    $surname = htmlentities($_POST['surname']);
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $password = $main_func->encryptData($password);

    $array_role_status = [
        "std_tracking" => isset($_POST['role_status_2']) ? 1 : 0,
        "view_grade" => isset($_POST['role_status_1']) ? 1 : 0,
        "visit_online" => isset($_POST['role_status_3']) ? 1 : 0,
    ];

    $username_result = $userModel->checkUsernameDupicate($username);
    if (count($username_result) > 0) {
        $response = ['status' => false, 'msg' => 'ชื่อผู้ใช่นี้มีอยู่แล้ว', "reload" => false];
        echo json_encode($response);
        exit();
    }
    if ($role_id == 3) {
        if ($edu_type == 'edu') {
            if ($_POST['check_new'] == 'new') {
                $arr_new_edu = [
                    'name' => htmlentities($_POST['new_edu_name']),
                    'code' => "0", //htmlentities($_POST['new_edu_code']),
                    'province_id' => htmlentities($_POST['pro_name']),
                    'district_id' => htmlentities($_POST['dis_name']),
                    'sub_district_id' => htmlentities($_POST['sub_name']),
                    'user_create' => $_SESSION['user_data']->id
                ];
                $edu_lastID = $userModel->InsertNewEdu($arr_new_edu);
                if ($edu_lastID != 0) {
                    $edu_id =  $edu_lastID;
                } else {
                    $response = ['status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่', "reload" => true];
                    echo json_encode($response);
                    exit();
                }
            } else {
                $edu_id = htmlentities($_POST['edu_select']);
            }
        } else {
            $edu_id = htmlentities($_POST['edu_other_select']);
        }
        $array_data = [
            "name" => $name,
            "surname" => $surname,
            "username" => $username,
            "password" => $password,
            "edu_id" => $edu_id,
            "edu_type" => $edu_type,
            "role_id" => $role_id,
            "user_create" => $_SESSION['user_data']->id,
            "district" => "",
            "province" => "",
            "district_id" => "",
            "province_id" => "",
            "status" => json_encode($array_role_status)
        ];
    } else if ($role_id == 2) {
        $array_data = [
            "name" => $name,
            "surname" => $surname,
            "username" => $username,
            "password" => $password,
            "edu_id" => 0,
            "edu_type" => 'amphur',
            "role_id" => $role_id,
            "user_create" => $_SESSION['user_data']->id,
            "district" => htmlentities($_POST['dis_name_text']),
            "province" => htmlentities($_POST['pro_name_text']),
            "district_id" => htmlentities($_POST['dis_name']),
            "province_id" => htmlentities($_POST['pro_name']),
            "status" => json_encode($array_role_status)
        ];
    } else {
        $array_data = [
            "name" => $name,
            "surname" => $surname,
            "username" => $username,
            "password" => $password,
            "edu_id" => 0,
            "edu_type" => 'admin',
            "role_id" => $role_id,
            "user_create" => $_SESSION['user_data']->id,
            "district_id" => "",
            "province_id" => "",
            "district_id" => "",
            "province_id" => "",
            "status" => json_encode($array_role_status)
        ];
    }


    $resultInsert = $userModel->addAdmin($array_data);
    if ($resultInsert == 1) {
        $response = ['status' => true, 'msg' => ''];
    } else {
        $response = ['status' => false, 'msg' => $resultInsert, "reload" => true];
    }

    echo json_encode($response);
}

if (isset($_POST['editAdmin'])) {
    $response = array();
    $userModel = new User_Model($DB);

    $id = htmlentities($_POST['user_id']);
    $role_id = htmlentities($_POST['role_id']);
    $name = htmlentities($_POST['name']);
    $surname = htmlentities($_POST['surname']);
    $username = htmlentities($_POST['username']);
    $username_old = htmlentities($_POST['username_old']);
    $password = htmlentities($_POST['password']);

    $array_role_status = [
        "std_tracking" => isset($_POST['role_status_2']) ? 1 : 0,
        "view_grade" => isset($_POST['role_status_1']) ? 1 : 0,
        "visit_online" => isset($_POST['role_status_3']) ? 1 : 0,
    ];

    if ($username != $username_old) {
        $username_result = $userModel->checkUsernameDupicate($username);
        if (count($username_result) > 0) {
            $response = ['status' => false, 'msg' => 'ชื่อผู้ใช้นี้มีอยู่แล้ว', "reload" => false];
            echo json_encode($response);
            exit();
        }
    }
    $password = $password;
    if (empty($password)) {
        $password = $_POST['password_old'];
    } else {
        $password = $main_func->encryptData($password);
    }
    $edit_date = date('Y-m-d H:i:s');
    $array_data = [
        "name" => $name,
        "surname" => $surname,
        "username" => $username,
        "password" => $password,
        "edit_date" =>  $edit_date,
        "user_update" => $_SESSION['user_data']->id,
        "status" => json_encode($array_role_status),
        "id" => $id
    ];
    $resultInsert = $userModel->editAdmin($array_data);
    if ($resultInsert == 1) {
        if ($role_id  == 1) {
            $_SESSION['user_data']->name = $name;
            $_SESSION['user_data']->surname = $surname;
        }
        $response = ['status' => true, 'msg' => '', "reload" => true];
    } else {
        $response = ['status' => false, 'msg' => $resultInsert, "reload" => true];
    }

    echo json_encode($response);
}


if (isset($_POST['delete_admin'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $id = htmlentities($_POST['id']);
    $edu_id = htmlentities($_POST['edu_id']);
    $resultDelete = $userModel->deleteAdmin($id, $edu_id);
    if ($resultDelete == 1) {
        $response = ['status' => true, 'msg' => ''];
    } else {
        $response = ['status' => false, 'msg' => $resultDelete];
    }
    echo json_encode($response);
}

if (isset($_POST['getTeacherList'])) {
    $userModel = new User_Model($DB);
    $result = $userModel->getTeacherList();
    $response = ['status' => true, 'data' => $result[0], "sql" => $result[1]];
    echo json_encode($response);
}
