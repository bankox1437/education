<?php
session_start();
include "../../config/class_database.php";
include('../models/education_model.php');
include('../models/am_model.php');

$DB = new Class_Database();
$amModel = new Am_Model($DB);

if (isset($_POST['getDataUsers'])) {
    $response = array();
    $edu_id = $_POST['edu_id'];
    $result = $amModel->getDataUser($edu_id);
    $count = $amModel->countUsers($edu_id);
    $edu_all = $amModel->getEduUser();
    $response = ['status' => true, 'data' => $result, 'count' =>  $count, "edu_all" => $edu_all];
    echo json_encode($response);
}

if (isset($_POST['getDataTeacher'])) {
    $response = array();
    $result = $amModel->getDataTeacher();
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_POST['getDataTeacherWhere'])) {
    $response = array();
    $pro_id = $_POST['pro_id'];
    $dis_id = $_POST['dis_id'];
    $sub_id = $_POST['sub_id'];
    $result = $amModel->getDataTeacher($sub_id, $pro_id, $dis_id);
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_GET['getDataUsersBT'])) {
    $response = array();
    $result_total = $amModel->getUsersBT();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}
