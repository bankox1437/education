<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/test_reading_model.php";

$DB = new Class_Database();
$mainFunc = new ClassMainFunctions();
$test_reading_model = new Test_Reading_Model($DB);

if (isset($_POST['insertTestReading'])) {
    $response = "";
    $array_data = [];
    $array_data = [
        'test_reading_name' => $_POST['test_reading_name'],
        'date_test' => $_POST['date_test'],
        'date_out_test' => $_POST['date_out_test'],
        'description' => $_POST['description'],
        'media_id' => $_POST['media_id'],
        'std_class' => $_POST['std_class'],
        'user_create' => $_SESSION['user_data']->id
    ];

    // echo "<pre>";
    // print_r($array_data);
    // echo "</pre>";
    $result = $test_reading_model->InsertTestReading($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'บันทึกข้อมูลการสอบอ่านสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['editTestReading'])) {
    $response = "";
    $array_data = [];

    $array_data = [
        'test_reading_name' => $_POST['test_reading_name'],
        'date_test' => $_POST['date_test'],
        'date_out_test' => $_POST['date_out_test'],
        'description' => $_POST['description'],
        'media_id' => $_POST['media_id'],
        'std_class' => $_POST['std_class'],
        'test_read_id' => $_POST['test_read_id']
    ];
    $result = $test_reading_model->EditTestReading($array_data);
    if ($result) {

        $response = array(
            'status' => $result ? true : false,
            'msg' => $result ? 'แก้ไขข้อมูลการสอบอ่านสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
        );
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['getDataTestReading'])) {
    $response = array();
    if ($_SESSION['user_data'] && $_SESSION['user_data']->role_id == 4) {
        $result_total = $test_reading_model->getDataTestReading();
    } else {
        $result_total = $test_reading_model->getDataTestReadingOther();
        foreach ($result_total[2] as &$value) {
            if (is_object($value) && isset($value->media_file_name) && !empty($value->media_file_name)) {
                $filePath = '../uploads/media/' . $value->media_file_name;
                $value->media_file_name = file_exists($filePath)
                    ? "uploads/media/" . $value->media_file_name
                    : "https://drive.google.com/file/d/{$value->media_file_name}/view";
            }
        }
    }
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1]];
    echo json_encode($response);
}


if (isset($_POST['deleteTestReading'])) {
    $response = array();
    $test_read_id = $_POST['test_read_id'];
    $result = $test_reading_model->deleteTestReading($test_read_id);
    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบข้อมูลการสอบอ่านสำเร็จ');
        // unlink($uploadDirCover);
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}
