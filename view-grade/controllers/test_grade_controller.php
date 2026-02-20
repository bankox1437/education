<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/test_grade_model.php";

$DB = new Class_Database();
$testGradeModel = new TestGradeModel($DB);

if (isset($_POST['insertTestGrade'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();
    $test_grade_file = $_FILES['test_grade_file'];
    $uploadDir = '../uploads/test_grade_pdf/';

    $fileNameRes = $mainFunc->UploadFile($test_grade_file, $uploadDir);
    if (!$fileNameRes['status']) {
        $response = array('status' => false, 'msg' => $fileNameRes['result']);
        echo json_encode($response);
        exit();
    }
    $std_id = 0;
    $format = 0;
    if (isset($_POST['std_id'])) {
        $std_id = $_POST['std_id'];
    } else {
        $format = 1;
        $std_id = $_POST['std_class'];
    }
    $array_data = [
        'std_id' => $std_id,
        'term_id' => $_POST['term_id'],
        'file_name' => $fileNameRes['result'],
        'test_type' => $_POST['test_type'],
        'format' => $format,
        'user_create' => $_SESSION['user_data']->id
    ];
    $result = $testGradeModel->insertTestGeade($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'บันทึกคะแนนสอบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['getDataTestGrade'])) {
    $response = array();
    $result_total = $testGradeModel->getDataTestGrade();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}

if (isset($_POST['UpdateTestGrade'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();

    $grade_id = $_POST['grade_id'];
    $test_grade_file_old = $_POST['test_grade_file_old'];
    $uploadDir = '../uploads/test_grade_pdf/';
    $file_new = $test_grade_file_old;
    if (count($_FILES) != 0) {
        $test_grade_file = $_FILES['test_grade_file'];
        $fileNameRes = "";
        $fileNameRes = $mainFunc->UploadFile($test_grade_file, $uploadDir);
        if (!$fileNameRes['status']) {
            $response = array('status' => false, 'msg' => $fileNameRes['result']);
            echo json_encode($response);
            exit();
        }
        unlink($uploadDir . $test_grade_file_old);
        $file_new =  $fileNameRes['result'];
    }

    $array_data = [
        'file_name' => $file_new,
        'test_type' => $_POST['test_type'],
        'grade_id' => $grade_id
    ];
    $result = $testGradeModel->UpdateTestGeade($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'แก้ไขคะแนนสอบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['deleteTestGrade'])) {
    $response = array();
    $grade_id = $_POST['grade_id'];
    $uploadDir = '../uploads/test_grade_pdf/' . $_POST['file_name'];
    $result = $testGradeModel->deleteTestGrade($grade_id);
    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบคะแนนสอบสำเร็จ');
        unlink($uploadDir);
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['stdGetDataTestGrade'])) {
    $response = array();
    $result_total = $testGradeModel->stdGetDataTestGrade();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3], "formatSTD" => $result_total[4]];
    echo json_encode($response);
}
