<?php
include "../../config/class_database.php";
include('../models/education_model.php');
include('../models/users_model.php');

$DB = new Class_Database();

if (isset($_POST['getDataEducation'])) {
    $response = array();
    try {
        $eduModel = new Education_Model($DB);
        $userModel = new User_Model($DB);

        // $edu_data = $eduModel->getEducation();
        // $eduOther_data = $eduModel->getEducationOther();
        $role_data = $userModel->getRoleData();
        $edu_all_data = array(
            // 'edu' => $edu_data,
            // 'edu_other' => $eduOther_data,
            'role_data' => $role_data
        );
        $response = array('status' => true, 'data' => $edu_all_data);
        echo json_encode($response);
    } catch (Exception $e) {
        $response = array('status' => false, 'data' => [], 'msg' => $e->getMessage());
        echo json_encode($response);
    }
}

if (isset($_POST['getSubDisPro'])) {
    $response = array();
    $eduModel = new Education_Model($DB);
    $edu_id = htmlentities($_POST['edu_id']);
    $SubDisPro_data = $eduModel->getSubDisPro($edu_id);
    $response = array('status' => true, 'data' => $SubDisPro_data[0]);
    echo json_encode($response);
}