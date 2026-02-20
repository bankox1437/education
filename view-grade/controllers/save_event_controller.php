<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/save_event_model.php";

$DB = new Class_Database();
$eventModel = new Save_Event_Model($DB);
function CheckUploadFileImage($file, $file_old = "")
{
    $mainFunc = new ClassMainFunctions();
    $uploadDir = '../uploads/save_event/';
    $resizeDir = '../uploads/';

    $file_response = $mainFunc->UploadFileImage($file, $uploadDir, $resizeDir);
    if (!$file_response['status']) {
        $response = array('status' => false, 'msg' => $file_response['result']);
        echo json_encode($response);
        exit();
    }
    if (!empty($file_old)) {
        unlink($uploadDir . $file_old);
    }
    return $file_response['result'];
}

if (isset($_REQUEST['getSaveEvent'])) {
    $response = array();
    $result_event = $eventModel->getSaveEvent();
    $response = ['rows' => $result_event[2], "total" => (int)$result_event[0], "totalNotFiltered" => (int)$result_event[1]];
    echo json_encode($response);
}

if (isset($_POST['insertEvent'])) {
    $response = array();
    $eventModel = new Save_Event_Model($DB);

    $std_id = ($_SESSION['user_data']->role_id == 3) ? htmlentities($_POST['std_id']) : htmlentities($_SESSION['user_data']->edu_type);
    $event_name = htmlentities($_POST['event_name']);
    $event_detail = htmlentities($_POST['event_detail']);
    $term_id = htmlentities($_POST['term_id']);
    $user_create = $_SESSION['user_data']->edu_type;
    $image_file1 = "";
    $image_file2 = "";
    $image_file3 = "";
    $image_file4 = "";

    if (isset($_FILES['image_file1'])) {
        $image_file1 = CheckUploadFileImage($_FILES['image_file1']);
    }
    if (isset($_FILES['image_file2'])) {
        $image_file2 = CheckUploadFileImage($_FILES['image_file2']);
    }
    if (isset($_FILES['image_file3'])) {
        $image_file3 = CheckUploadFileImage($_FILES['image_file3']);
    }
    if (isset($_FILES['image_file4'])) {
        $image_file4 = CheckUploadFileImage($_FILES['image_file4']);
    }

    $arr_event = [
        "std_id" => $std_id,
        "term_id" => $term_id,
        "event_name" => $event_name,
        "event_detail" => $event_detail,
        "img_event_1" => $image_file1,
        "img_event_2" => $image_file2,
        "img_event_3" => $image_file3,
        "img_event_4" => $image_file4,
        "user_create" => $user_create
    ];
    $result = $eventModel->InsertEvent($arr_event);
    if ($result != 0) {
        $response = array('status' => true, 'msg' => 'บันทึกกิจกรรมสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['editEvent'])) {
    $response = array();
    $eventModel = new Save_Event_Model($DB);

    $uploadDir = '../uploads/save_event/';

    $event_id = htmlentities($_POST['event_id']);
    $event_name = htmlentities($_POST['event_name']);
    $event_detail = htmlentities($_POST['event_detail']);

    $image_file1 = $_POST['image_file1_old'];
    $image_file2 = $_POST['image_file2_old'];
    $image_file3 = $_POST['image_file3_old'];
    $image_file4 = $_POST['image_file4_old'];

    if (isset($_FILES['image_file1'])) {
        unlink($uploadDir . $image_file1);
        $image_file1 = CheckUploadFileImage($_FILES['image_file1']);
    }
    if (isset($_FILES['image_file2'])) {
        unlink($uploadDir . $image_file2);
        $image_file2 = CheckUploadFileImage($_FILES['image_file2']);
    }
    if (isset($_FILES['image_file3'])) {
        unlink($uploadDir . $image_file3);
        $image_file3 = CheckUploadFileImage($_FILES['image_file3']);
    }
    if (isset($_FILES['image_file4'])) {
        unlink($uploadDir . $image_file4);
        $image_file4 = CheckUploadFileImage($_FILES['image_file4']);
    }

    $arr_event = [
        "event_name" => $event_name,
        "event_detail" => $event_detail,
        "img_event_1" => $image_file1,
        "img_event_2" => $image_file2,
        "img_event_3" => $image_file3,
        "img_event_4" => $image_file4,
        "event_id" => $event_id
    ];

    $result = $eventModel->UpdateEvent($arr_event);
    if ($result != 0) {
        $response = array('status' => true, 'msg' => 'แก้ไขกิจกรรมนักเรียนสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['delete_event'])) {
    $response = array();
    $eventModel = new Save_Event_Model($DB);
    $uploadDir = '../uploads/save_event/';
    $imageList = $eventModel->getImageEventById($_POST['id']);
    $imageList = json_decode($imageList);
    if (!empty($imageList[0]->img_event_1)) unlink($uploadDir . $imageList[0]->img_event_1);
    if (!empty($imageList[0]->img_event_2)) unlink($uploadDir . $imageList[0]->img_event_2);
    if (!empty($imageList[0]->img_event_3)) unlink($uploadDir . $imageList[0]->img_event_3);
    if (!empty($imageList[0]->img_event_4)) unlink($uploadDir . $imageList[0]->img_event_4);
    $delete = $eventModel->deleteEvent($_POST['id']);
    if ($delete) {
        $response = array('status' => true, 'msg' => 'ลบข้อมูลกิจกรรมสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}
