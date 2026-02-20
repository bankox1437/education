<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/gradiate_reg_mpdel.php";

$DB = new Class_Database();
$gra_reg = new GradiateRegModel($DB);

if (isset($_REQUEST['getDataGraReg'])) {
    $response = array();
    $result_total = $gra_reg->getDataGraReg();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => (string)$result_total[3]];
    echo json_encode($response);
}

if (isset($_POST['insertGraReg'])) {
    $mainFunc = new ClassMainFunctions();
    $file = $_FILES['file'];
    $uploadDir = '../uploads/gradiate_reg/';

    $fileNameRes = $mainFunc->UploadFile($file, $uploadDir);
    if (!$fileNameRes['status']) {
        $response = array('status' => false, 'msg' => $fileNameRes['result']);
        echo json_encode($response);
        exit();
    }

    $array_data = [
        'std_id' => $_POST['std_id'],
        'std_code' => $_POST['std_code'],
        'std_name' => $_POST['std_name'],
        'national_id' => $_POST['national_id'],
        'years' => $_POST['gra_year'],
        'class' => $_POST['std_class'],
        'file_name' => $fileNameRes['result'],
        'user_create' => $_SESSION['user_data']->id
    ];

    $result = $gra_reg->insertGraReg($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'บันทึกผู้จบการศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}


if (isset($_POST['editGraReg'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();

    $gra_reg_id = $_POST['gra_reg_id'];
    $file_old = $_POST['file_old'];

    $uploadDir = '../uploads/gradiate_reg/';

    $file_new = $file_old;

    if (count($_FILES) != 0) {
        $file = $_FILES['file'];
        $fileNameRes = "";
        $fileNameRes = $mainFunc->UploadFile($file, $uploadDir);
        if (!$fileNameRes['status']) {
            $response = array('status' => false, 'msg' => $fileNameRes['result']);
            echo json_encode($response);
            exit();
        }
        unlink($uploadDir . $file_old);
        $file_new =  $fileNameRes['result'];
    }

    $array_data = [
        'std_code' => $_POST['std_code'],
        'std_name' => $_POST['std_name'],
        'national_id' => $_POST['national_id'],
        'years' => $_POST['gra_year'],
        'class' => $_POST['std_class'],
        'file_name' => $file_new,
        'gra_reg_id' => $gra_reg_id
    ];

    $result = $gra_reg->insertGraReg($array_data, "update");
    if ($result) {
        $response = array('status' => true, 'msg' => 'แก้ไขผู้จบการศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['deleteGraReg'])) {
    $response = array();
    $gra_reg_id = $_POST['gra_reg_id'];
    $uploadDir = '../uploads/gradiate_reg/' . $_POST['file_name'];
    $result = $gra_reg->deleteGraReg($gra_reg_id);
    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบผู้จบการศึกษาสำเร็จ');
        unlink($uploadDir);
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}
