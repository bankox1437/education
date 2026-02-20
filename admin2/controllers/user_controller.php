<?php
session_start();
include "../../config/class_database.php";
include '../models/users_model.php';
include '../models/education_model.php';
include('../../config/main_function.php');
$main_func = new ClassMainFunctions();
$DB = new Class_Database();

if (isset($_REQUEST['getDataUsers'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $manageRole = isset($_REQUEST['manageRole']);
    $result_total = $userModel->adminGetDataUser($manageRole);
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}


if (isset($_POST['addAdmin'])) {
    $response = array();
    $userModel = new User_Model($DB);

    $edu_type = htmlentities($_POST['radio']);
    $role_id = htmlentities($_POST['role_radio']);

    $edu_id = "";
    $name = htmlentities($_POST['name']);
    $surname = htmlentities($_POST['surname']);
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);

    $password =  $main_func->encryptData($password);

    $array_role_status = [
        "std_tracking" => isset($_POST['role_status_2']) ? 1 : 0,
        "view_grade" => isset($_POST['role_status_1']) ? 1 : 0,
        "visit_online" => isset($_POST['role_status_3']) || $role_id == 5 || $role_id == 'custom' ? 1 : 0,
        "search" => isset($_POST['role_status_4']) ? 1 : 0,
        "see_people" => isset($_POST['role_status_5']) ? 1 : 0,
        "reading" => isset($_POST['role_status_6']) || $role_id == 5 ? 1 : 0,
        "after" => isset($_POST['role_status_7']) ? 1 : 0,
        "estimate" => isset($_POST['role_status_8']) ? 1 : 0,
        "dashboard" => isset($_POST['role_status_9']) ? 1 : 0,
        "calendar_new" => isset($_POST['role_status_10']) ? 1 : 0,
        "teach_more" => isset($_POST['role_status_11']) ? 1 : 0,
        "guide" => isset($_POST['role_status_12']) ? 1 : 0,
    ];

    $username_result = $userModel->checkUsernameDupicate($username);
    if (count($username_result) > 0) {
        $response = ['status' => false, 'msg' => 'ชื่อผู้ใช้นี้มีอยู่แล้ว', "reload" => false];
        echo json_encode($response);
        exit();
    }
    if ($role_id == 3) {
        if ($edu_type == 'edu') {
            if ($_POST['check_new'] == 'new') {
                $edu_name =  htmlentities($_POST['new_edu_name_hidden']);
                if (!empty($_POST['new_edu_sub_dis_name'])) {
                    $edu_name .= "-" . htmlentities($_POST['new_edu_sub_dis_name']);
                }
                $arr_new_edu = [
                    'name' => $edu_name,
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
            if ($_POST['check_new'] == 'new') {
                $arr_new_edu = [
                    'name' => htmlentities($_POST['new_edu_name_other']),
                    'code' => "0", //htmlentities($_POST['new_edu_code_other']),
                    'user_create' => $_SESSION['user_data']->id
                ];
                $edu_lastID = $userModel->InsertNewEduOther($arr_new_edu);
                if ($edu_lastID != 0) {
                    $edu_id =  $edu_lastID;
                } else {
                    $response = ['status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่', "reload" => true];
                    echo json_encode($response);
                    exit();
                }
            } else {
                $edu_id = htmlentities($_POST['edu_other_select']);
            }
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
            "sub_district_am" => "",
            "district_am" => "",
            "province_am" => "",
            "sub_district_am_id" => "",
            "district_am_id" => "",
            "province_am_id" => "",
            "status" => json_encode($array_role_status)
        ];
    } else if ($role_id == 2 || $role_id == 5) {
        $array_data = [
            "name" => $name,
            "surname" => $surname,
            "username" => $username,
            "password" => $password,
            "edu_id" => 0,
            "edu_type" => $role_id == 2 ? "amphur" : 'libraries',
            "role_id" => $role_id,
            "user_create" => $_SESSION['user_data']->id,
            "sub_district_am" => $_POST['sub_name_text'],
            "district_am" => $_POST['dis_name_text'],
            "province_am" => $_POST['pro_name_text'],
            "sub_district_am_id" => $_POST['sub_name'],
            "district_am_id" => $_POST['dis_name'],
            "province_am_id" => $_POST['pro_name'],
            "status" => json_encode($array_role_status)
        ];
    } else if ($role_id == 6) {
        // $array_role_status = [
        //     "std_tracking" => 0,
        //     "view_grade" => 0,
        //     "visit_online" => 0,
        //     "search" => 0,
        //     "see_people" => 0,
        //     "reading" => 0,
        //     "after" => 0,
        //     "estimate" => 0,
        //     "dashboard" => 0,
        //     "calendar_new" => 0,
        //     "teach_more" => 0
        // ];

        $array_data = [
            "name" => $name,
            "surname" => $surname,
            "username" => $username,
            "password" => $password,
            "edu_id" => 0,
            "edu_type" => 'lib',
            "role_id" => $role_id,
            "user_create" => $_SESSION['user_data']->id,
            "sub_district_am" => "",
            "district_am" => "",
            "province_am" => $_POST['pro_name_text'],
            "sub_district_am_id" => "",
            "district_am_id" => "",
            "province_am_id" => $_POST['pro_name'],
            "status" => json_encode($array_role_status)
        ];
    } else {
        $array_role_status = [
            "std_tracking" => 1,
            "view_grade" => 1,
            "visit_online" => 1,
            "search" => 1,
            "see_people" => 1,
            "reading" => 1,
            "after" => 1,
            "estimate" => 1,
            "dashboard" => 1,
            "calendar_new" => 1,
            "teach_more" => 1,
            "guide" => 1
        ];
        $array_data = [
            "name" => $name,
            "surname" => $surname,
            "username" => $username,
            "password" => $password,
            "edu_id" => 0,
            "edu_type" => 'admin',
            "role_id" => $role_id,
            "user_create" => $_SESSION['user_data']->id,
            "sub_district_am" => "",
            "district_am" => "",
            "province_am" => "",
            "sub_district_am_id" => "",
            "district_am_id" => "",
            "province_am_id" => "",
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

if (isset($_POST['getDataUserEdit'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $id = htmlentities($_POST['id']);
    $resultInsert = $userModel->getDataUserWhereId($id);
    $response = ['status' => true, 'data' => $resultInsert];
    echo json_encode($response);
}


if (isset($_POST['editAdmin'])) {
    $response = array();
    $response1 = array();
    $userModel = new User_Model($DB);
    $eduModel = new Education_Model($DB);
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
        "visit_online" => isset($_POST['role_status_3']) || $role_id == 5 || $role_id == 'custom' ? 1 : 0,
        "search" => isset($_POST['role_status_4']) ? 1 : 0,
        "see_people" => isset($_POST['role_status_5']) ? 1 : 0,
        "reading" => isset($_POST['role_status_6']) || $role_id == 5 ? 1 : 0,
        "after" => isset($_POST['role_status_7']) ? 1 : 0,
        "estimate" => isset($_POST['role_status_8']) ? 1 : 0,
        "dashboard" => isset($_POST['role_status_9']) ? 1 : 0,
        "calendar_new" => isset($_POST['role_status_10']) ? 1 : 0,
        "teach_more" => isset($_POST['role_status_11']) ? 1 : 0,
        "guide" => isset($_POST['role_status_12']) ? 1 : 0,
    ];

    if ($role_id == 3) {
        $edu_id = htmlentities($_POST['edu_id']);
        $edu_name =  htmlentities($_POST['new_edu_name_hidden']);
        if (!empty($_POST['new_edu_sub_dis_name'])) {
            $edu_name .= "-" . htmlentities($_POST['new_edu_sub_dis_name']);
        }
        $edu_name = htmlentities($_POST['edu_type'] == 'edu' ? $edu_name : $_POST['edu_other_name']);

        $array_edu = [
            "edu_name" => $edu_name,
            "edu_id" => $edu_id
        ];

        if ($_POST['edu_type'] == 'edu') {
            $result = $eduModel->editEdu($array_edu);
        } elseif ($_POST['edu_type'] == 'edu_other') {
            $result = $eduModel->editEduOther($array_edu);
        }

        // if ($result == 1) {
        //     $response1 = ['status' => true, 'msg' => '', "reload" => true];
        // } else {
        //     $response1 = ['status' => false, 'msg' => $result, "reload" => true];
        // }
        // echo json_encode($response1);
    }


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



if (isset($_POST['searchDataUsers'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $keyword = htmlentities($_POST['keyword']);
    $role_id = htmlentities($_POST['role_id']);
    $result = $userModel->SearchUsers($keyword, $role_id);
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_POST['getDataProDistSub'])) {
    $userModel = new User_Model($DB);
    $table = isset($_POST['table']) ? $_POST['table'] : '';
    $result = $userModel->getDataProDistSub($table);
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_POST['edit_profile'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $name = htmlentities($_POST['name']);
    $surname = htmlentities($_POST['surname']);
    $password = htmlentities($_POST['password']);
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
        $response = ['status' => true, 'msg' => ''];
    } else {
        $response = ['status' => false, 'msg' => $resultInsert];
    }
    echo json_encode($response);
}

if (isset($_REQUEST['getDataUserDuplicate'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $result_total = $userModel->adminGetDataUserDuplicate();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}


if (isset($_POST['delete_dup'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $username = $_POST['username'];
    $resultDelete = $userModel->getUserDupToDelete($username);
    if ($resultDelete) {
        $response = ['status' => true, 'msg' => 'ลบรายการสำเร็จ'];
    } else {
        $response = ['status' => false, 'msg' => $resultDelete];
    }
    echo json_encode($response);
}

if (isset($_REQUEST['getLogs'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $result_total = $userModel->getLogsData();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}

if (isset($_REQUEST['update_role_only'])) {
    $response = array();
    $userModel = new User_Model($DB);

    $id = $_POST['id'];

    $role_data = $userModel->getRole($_POST['id']);
    $role_data = $role_data[0]->status;
    $role_data = json_decode($role_data);

    $array_role_status = [
        "std_tracking",
        "view_grade",
        "visit_online",
        "search",
        "see_people",
        "reading",
        "after",
        "estimate",
        "dashboard",
        "calendar_new",
        "teach_more",
        "guide"
    ];

    $role_values = [];
    foreach ($array_role_status as $role) {
        $value = $_POST['role'] == $role ? ($_POST['value'] == 'true') ? 1 : 0 : (isset($role_data->$role) ? $role_data->$role : 0);
        $role_values[$role] = $value;
    }

    $role_encode = json_encode($role_values);

    $result_update = $userModel->updateRole($id, $role_encode);
    if ($result_update == 1) {
        $response = ['status' => true, 'msg' => ''];
    } else {
        $response = ['status' => false, 'msg' => $result_update];
    }
    echo json_encode($response);
}
