<?php
session_start();
include "../../config/class_database.php";
include '../models/users_model.php';
include '../models/education_model.php';
include('../../config/main_function.php');
$main_func = new ClassMainFunctions();
$DB = new Class_Database();

if (isset($_POST['getDataUsers'])) {
    $response = array();
    $userModel = new User_Model($DB);
    $role_id = htmlentities($_POST['role_id']);
    $result = $userModel->getDataUser($role_id);
    $response = ['status' => true, 'data' => $result];
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
