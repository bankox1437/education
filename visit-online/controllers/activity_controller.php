<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/activity_model.php";

$DB = new Class_Database();
$activityModel = new Activity_Model($DB);

if (isset($_POST['insertCalendarActivity'])) {
    $response = array();

    $mainFunc = new ClassMainFunctions();

    $user_create = $_SESSION['user_data']->id;
    $term_id = $_SESSION['term_active']->term_id;

    if (count($_FILES) > 0) {
        $activity_file = $_FILES['activity_file'];
        $uploadDir = '../uploads/activity_calendar/';

        $filenameResActivity_file = $mainFunc->UploadFile($activity_file, $uploadDir);
        if (!$filenameResActivity_file['status']) {
            $response = array('status' => false, 'msg' => $filenameResActivity_file['result']);
            echo json_encode($response);
            exit();
        }
    }

    $file_name = isset($filenameResActivity_file['result']) ? $filenameResActivity_file['result'] : '';

    $arr_data = [
        "date_time" => $_POST['dateTime'],
        "act_name" => $_POST['activity_name'],
        "take_response" => $_POST['take_response'],
        "note" => $_POST['note'],
        "act_file_name" => $file_name,
        "user_create" => $user_create,
        "term_id" => $term_id
    ];

    $result = $activityModel->insertActivity($arr_data);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'บันทึกปฎิทินกิจกรรมสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}


if (isset($_POST['getDataCalendarActivity'])) {
    $response = array();
    $term_id = 0;
    $user_create = 0;
    if (isset($_POST['term_id']) && $_POST['term_id'] != 0) {
        $term_id = $_POST['term_id'];
    }
    if (isset($_POST['user_create']) && $_POST['user_create'] != 0) {
        $user_create = $_POST['user_create'];
    }
    $result = $activityModel->getDataCalendarActivity($term_id, $user_create);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['editCalendarActivity'])) {
    $response = array();

    $mainFunc = new ClassMainFunctions();

    $user_create = $_SESSION['user_data']->id;
    $term_id = $_SESSION['term_active']->term_id;

    if (count($_FILES) > 0) {
        $activity_file = $_FILES['activity_file'];
        $uploadDir = '../uploads/activity_calendar/';

        $filenameResActivity_file = $mainFunc->UploadFile($activity_file, $uploadDir);
        if (!$filenameResActivity_file['status']) {
            $response = array('status' => false, 'msg' => $filenameResActivity_file['result']);
            echo json_encode($response);
            exit();
        }
        if (!empty($_POST['activity_file_old'])) {
            unlink($uploadDir . $_POST['activity_file_old']);
        }
    }

    $file_name = isset($filenameResActivity_file['result']) ? $filenameResActivity_file['result'] : $_POST['activity_file_old'];

    $arr_data = [
        "date_time" => $_POST['dateTime'],
        "act_name" => $_POST['activity_name'],
        "take_response" => $_POST['take_response'],
        "note" => $_POST['note'],
        "act_file_name" => $file_name,
        "user_create" => $user_create,
        "term_id" => $term_id
    ];

    $result = $activityModel->insertActivity($arr_data, "UPDATE", $_POST['act_id']);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'แก้ไขปฎิทินกิจกรรมสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}


if (isset($_POST['delete_calendar_activity'])) {
    $response = array();

    $result = $activityModel->deleteCalendarAct($_POST['act_id']);
    if ($result == 1) {
        if (!empty($_POST['act_file_name'])) {
            $uploadDir = '../uploads/activity_calendar/' . $_POST['act_file_name'];
            if (file_exists($uploadDir)) {
                unlink($uploadDir);
            }
        }
        $activityModel->deleteCalendarActJoin($_POST['act_id']);
        $response = array('status' => true, 'msg' => 'ลบปฎิทินกิจกรรมสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['joinActivity'])) {
    $response = array();
    $result = $activityModel->joinActivity($_POST['act_id']);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ยืนยันเข้าร่วมกิจกรรมสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['getDataStdAct'])) {
    $response = array();
    $result = $activityModel->getDataStdAct($_POST['act_id']);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}
