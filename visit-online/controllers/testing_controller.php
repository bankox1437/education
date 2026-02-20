<?php
session_start();
include "../../config/class_database.php";
include('../models/testing_model.php');

$DB = new Class_Database();
$testingModel = new TestingModel($DB);

if (isset($_POST['addTesting'])) {
    $response = array();

    $data = json_decode($_POST['data'], true);
    $term = $_POST['term'];
    $year = $_POST['year'];
    $std_class = $_POST['std_class'];

    $result = 0;
    for ($i = 0; $i < count($data); $i++) {
        $arr_data = [
            "term" => $term,
            "year" => $year,
            "std_class" => $std_class,
            "test_name" => $data[$i]['test_name'],
            "link" => $data[$i]['link'],
            "description" => $data[$i]['desc'],
            "user_create" => $_SESSION['user_data']->id
        ];
        $result = $testingModel->addTesting($arr_data);
    }

    if ($result != 0) {
        $response = array('status' => true, 'msg' => 'บันทึกแบบทดสอบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['getDataTesting'])) {
    try {
        $user_id = "";
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
        } else {
            $user_id = $_SESSION['user_data']->id;
        }

        $classRoom = '';
        if(isset($_POST['classroom'])) {
            $classRoom = $_POST['classroom'];
        }

        $result = $testingModel->getDataTesting($user_id, $classRoom);
        $response = ['status' => true, 'data' => $result];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_POST['editTesting'])) {
    $response = array();

    $data = json_decode($_POST['data'], true);
    $term = $_POST['term'];
    $year = $_POST['year'];
    $std_class = $_POST['std_class'];
    $testing_id = $_POST['testing_id'];

    $result = 0;
    for ($i = 0; $i < count($data); $i++) {
        $arr_data = [
            "term" => $term,
            "year" => $year,
            "std_class" => $std_class,
            "test_name" => $data[$i]['test_name'],
            "link" => $data[$i]['link'],
            "description" => $data[$i]['desc'],
            "testing_id" => $testing_id
        ];
        $result = $testingModel->editTesting($arr_data);
    }

    if ($result != 0) {
        $response = array('status' => true, 'msg' => 'แก้ไขแบบทดสอบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['delete_testing'])) {
    try {
        $response = array();
        $testing_id = $_POST['testing_id'];

        $result = $testingModel->deleteTesting($testing_id);
        if ($result) {
            $response = ['status' => true, 'msg' => "ลบแบบทดสอบสำเร็จ"];
        } else {
            $response = ['status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!'];
        }

        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}
