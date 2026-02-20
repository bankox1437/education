<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/estimate_model.php";

$DB = new Class_Database();
$estimateModel = new EstimateModel($DB);

if (isset($_POST['getDataEstimate'])) {
    $response = array();
    $result_total = $estimateModel->getDataEstimate();
    $response = ['rows' => $result_total[0], "sql" => (string)$result_total[1]];
    echo json_encode($response);
}

if (isset($_POST['addEstimate'])) {
    $jsonParamDecode = json_decode($_POST['jsonParamObj']);

    $arr_data = [
        "std_id" => $_POST['std_select'],
        "year" => $_POST['year'],
        "user_create" => $_SESSION['user_data']->id
    ];

    $lastId = $estimateModel->insertEstimate($arr_data);
    $response = "";

    foreach ($jsonParamDecode as $key => $valueSide) {
        foreach ($valueSide as $key => $value) {
            $arr_data = [
                "estimate_id" => $lastId,
                "side" => $value->side,
                "sub_side" => $value->sub_side,
                "checked" => $value->checked,
                "premise_select" => $value->premise_select
            ];
            $estimateModel->insertEstimateDetail($arr_data);
        }
    }

    if ($lastId) {
        $response = array('status' => true, 'msg' => 'ประเมินคุณธรรมนักศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }

    echo json_encode($response);
}

if (isset($_REQUEST['deleteEstimate'])) {
    $response = array();
    $estimate_id = $_POST['estimate_id'];
    $result = $estimateModel->deleteEstimate($estimate_id);
    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบข้อมูลการประเมินสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}


if (isset($_POST['editEstimate'])) {
    $jsonParamDecode = json_decode($_POST['jsonParamObj']);

    $response = "";
    $lastId = "";
    foreach ($jsonParamDecode as $key => $valueSide) {
        foreach ($valueSide as $key => $value) {
            $arr_data = [
                "checked" => $value->checked,
                "premise_select" => $value->premise_select,
                "estimate_det_id" => $value->estimate_det_id,
            ];
            $lastId = $estimateModel->updateEstimateDetail($arr_data);
        }
    }

    if ($lastId) {
        $response = array('status' => true, 'msg' => 'แก้ไขประเมินคุณธรรมนักศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }

    echo json_encode($response);
}
