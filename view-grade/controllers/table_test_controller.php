<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/table_test_model.php";

$DB = new Class_Database();
$tableTestModel = new TableTestModel($DB);

if (isset($_POST['insertTableTest'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();

    $table_test_file = $_FILES['table_test_file'];
    $uploadDir = '../uploads/table_test_pdf/';

    $fileNameRes = $mainFunc->UploadFile($table_test_file, $uploadDir);
    if (!$fileNameRes['status']) {
        $response = array('status' => false, 'msg' => $fileNameRes['result']);
        echo json_encode($response);
        exit();
    }
    $array_data = [
        'std_id' => $_POST['std_id'],
        'term_id' => $_POST['term_id'],
        'std_class' => $_POST['std_class'],
        'file_name' => $fileNameRes['result'],
        'user_create' => $_SESSION['user_data']->id
    ];
    $result = $tableTestModel->insertTableTest($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'บันทึกตารางสอบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['getDataTableTest'])) {
    $response = array();
    $result_total = $tableTestModel->getDataTableTest();

    foreach ($result_total[2] as &$value) {
        if (is_object($value) && isset($value->file_name) && !empty($value->file_name)) {
            $filePath = '../uploads/table_test_pdf/' . $value->file_name;
            $value->file_name = file_exists($filePath)
                ? "uploads/table_test_pdf/" . $value->file_name
                : "https://drive.google.com/file/d/{$value->file_name}/view";
        }
    }

    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}

if (isset($_POST['updateTableTest'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();

    $t_test_id = $_POST['t_test_id'];
    $table_test_file_old = $_POST['table_test_file_old'];
    $uploadDir = '../uploads/table_test_pdf/';
    $file_new = $table_test_file_old;
    if (count($_FILES) != 0) {
        $table_test_file = $_FILES['table_test_file'];
        $fileNameRes = "";
        $fileNameRes = $mainFunc->UploadFile($table_test_file, $uploadDir);
        if (!$fileNameRes['status']) {
            $response = array('status' => false, 'msg' => $fileNameRes['result']);
            echo json_encode($response);
            exit();
        }
        unlink($uploadDir . $table_test_file_old);
        $file_new =  $fileNameRes['result'];
    }

    $array_data = [
        'file_name' => $file_new,
        't_test_id' => $t_test_id
    ];
    $result = $tableTestModel->UpdateTableTest($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'แก้ไขตารางสอบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['deleteTableTest'])) {
    $response = array();
    $t_test_id = $_POST['t_test_id'];
    $uploadDir = '../uploads/table_test_pdf/' . $_POST['file_name'];
    $result = $tableTestModel->deleteTableTest($t_test_id);
    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบตารางสอบสำเร็จ');
        unlink($uploadDir);
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['stdGetDataTableTest'])) {
    $response = array();
    $result_total = $tableTestModel->stdGetDataTableTest();

    foreach ($result_total[2] as &$value) {
        if (is_object($value) && isset($value->file_name) && !empty($value->file_name)) {
            $filePath = '../uploads/table_test_pdf/' . $value->file_name;
            $value->file_name = file_exists($filePath)
                ? "uploads/table_test_pdf/" . $value->file_name
                : "https://drive.google.com/file/d/{$value->file_name}/view";
        }
    }

    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1]];
    echo json_encode($response);
}
