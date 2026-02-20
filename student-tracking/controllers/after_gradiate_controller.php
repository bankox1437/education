<?php
session_start();
include "../../config/class_database.php";
include "../models/after_gradiate_model.php";

$DB = new Class_Database();
$afterGradiateModel = new after_gradiate_model($DB);

if (isset($_POST['addAfterGradiate'])) {
    $response = array();
    unset($_POST['addAfterGradiate']);
    if ($_SESSION['user_data']->role_id == 3) {
        $_POST['user_create'] = $_SESSION['user_data']->id;
    } else {
        $_POST['user_create'] = $_SESSION['user_data']->user_create;
    }

    $result = $afterGradiateModel->addAfterGradiate($_POST);

    if ($result == 1) {
        $response = ['status' => true, 'msg' => 'บันทึกแบบติดตามหลังจบการศึกษาสำเร็จ'];
    } else {
        $response = ['status' => false, 'msg' => $result];
    }

    echo json_encode($response);
}

if (isset($_POST['editAfterGradiate'])) {
    $response = array();
    unset($_POST['editAfterGradiate']);
    $result = $afterGradiateModel->editAfterGradiate($_POST);
    if ($result == 1) {
        $response = ['status' => true, 'msg' => 'แก้ไขแบบติดตามหลังจบการศึกษาสำเร็จ'];
    } else {
        $response = ['status' => false, 'msg' => $result];
    }

    echo json_encode($response);
}

if (isset($_POST['getDataAfterGra'])) {
    $response = array();
    $result = $afterGradiateModel->getDataAfterGra();
    $response = array('status' => true, 'data' => $result[0], "sql" => $result[1]);
    echo json_encode($response);
}

if (isset($_POST['searchDataafterGra'])) {
    $response = array();
    $std_class = htmlentities($_POST['std_class']);
    $pro_id = htmlentities($_POST['pro_id']);
    $dis_id = htmlentities($_POST['dis_id']);
    $sub_district_id = htmlentities($_POST['sub_district_id']);
    $result = $afterGradiateModel->searchDataafterGra($std_class, $sub_district_id, $pro_id, $dis_id);
    $response = array('status' => true, 'data' => $result[0], "sql" => $result[1]);
    echo json_encode($response);
}

if (isset($_POST['getClassInDropdown'])) {
    $response = array();
    $result = $afterGradiateModel->getClassInDropdown();
    $response = array('status' => true, 'data' => $result[0], "sql" => $result[1]);
    echo json_encode($response);
}

if (isset($_POST['deleteAfterGradiate'])) {
    $response = array();
    $after_id = $_POST['after_id'];
    $result = $afterGradiateModel->deleteAfterGradiate($after_id);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ลบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => $result);
    }
    echo json_encode($response);
}
