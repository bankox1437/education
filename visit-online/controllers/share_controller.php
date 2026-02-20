<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/share_model.php";

$DB = new Class_Database();
$share_model = new Share_Model($DB);

if (isset($_REQUEST['getShare'])) {
    $response = array();
    $result = $share_model->getShare();
    $response = ['rows' => $result[2], "total" => (int)$result[0], "totalNotFiltered" => (int)$result[1], "sql" => $result[3]];
    echo json_encode($response);
}

if (isset($_POST['updateShare'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();

    $uploadDir = '../uploads/teach_more/';

    $array_data = [
        'share_name' => $_POST['share_name'],
        'share_link' => $_POST['share_link'],
        'user_create' => $_SESSION['user_data']->id
    ];

    $mode = "INSERT";
    if (!empty($_POST['share_id'])) {
        $array_data['share_id'] =  $_POST['share_id'];
        $mode = "UPDATE";
    }

    $result = $share_model->InsertShare($array_data, $mode);
    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? !empty($_POST['share_id']) ? 'แก้ไข' . 'การเรียนรู้เพื่อพัฒนาตนเองสำเร็จ' : 'บันทึก' . 'การเรียนรู้เพื่อพัฒนาตนเองสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}

if (isset($_POST['viewsUpdate'])) {
    $response = array();
    $share_id = $_POST['share_id'];
    $result = $share_model->viewUpdate($share_id);
    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? 'เข้าชมสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}

if (isset($_POST['deleteShare'])) {
    $response = array();
    $share_id = $_POST['share_id'];
    $result = $share_model->deleteShare($share_id);

    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? 'ลบข้อมูลการสอนเสริมสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}
