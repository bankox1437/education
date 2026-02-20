<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/read_model.php";

$DB = new Class_Database();
$mainFunc = new ClassMainFunctions();
$ReadbBookModel = new ReadbBookModel($DB);

function CheckUploadFileImage($file, $file_old = "")
{
    $mainFunc = new ClassMainFunctions();
    $uploadDir = '../uploads/images_read/';
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

if (isset($_POST['updateRead'])) {
    $array_data = [
        'date' => $_POST['date'],
        'month' => $_POST['month'],
        'year' => $_POST['year'],
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'publisher' => $_POST['publisher'],
        'book_type' => $_POST['type'],
        'summary' => $_POST['summary'],
        'analysis' => $_POST['analysis'],
        'reference' => $_POST['reference'],
        'user_create' => $_SESSION['user_data']->edu_type,
        'id' => !empty($_POST['id']) ? $_POST['id'] : null // กำหนดค่า ID ถ้ามี
    ];

    // ตรวจสอบว่ามี ID หรือไม่
    if (!empty($array_data['id']) && $array_data['id'] !== 'undefined') {
        // หากมี ID ให้ทำการ Update ข้อมูล
        unset($array_data['user_create']);
        $result = $ReadbBookModel->EditReadBook($array_data);
        if ($result  == 1) {
            $response = array('status' => true, 'msg' => 'อัปเดตข้อมูลสำเร็จ');
            $fileOld = $_POST['image_old'];
            if (isset($_FILES['image'])) {
                $image = CheckUploadFileImage($_FILES['image'], $fileOld);
                $ReadbBookModel->EditReadBookImage($image, $array_data['id']);
            }
        } else {
            $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาดในการอัปเดต');
        }
    } else {
        // ถ้าไม่มี ID ให้ทำการ Insert ข้อมูลใหม่
        unset($array_data['id']);
        $result = $ReadbBookModel->InsertReadBook($array_data);
        if ($result) {
            $response = array('status' => true, 'msg' => 'บันทึกข้อมูลสำเร็จ');
            if (isset($_FILES['image'])) {
                $image = CheckUploadFileImage($_FILES['image']);
                $ReadbBookModel->EditReadBookImage($image, $result);
            }
        } else {
            $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาดในการบันทึก');
        }
    }

    // ส่งผลลัพธ์กลับไปเป็น JSON
    echo json_encode($response);
}

if (isset($_REQUEST['getDataStudent'])) {
    $response = "";
    if ($_SESSION['user_data']->role_id == 5) {
        $result_total = $ReadbBookModel->getDataStudentLib();
    } else {
        $result_total = $ReadbBookModel->getDataStudent();
    }
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1]];
    echo json_encode($response);
}

if (isset($_REQUEST['getReadBooks'])) {
    $response = array();
    $result_total = $ReadbBookModel->getReadBooks();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}


if (isset($_POST['deleteReadBook'])) {
    $response = array();
    $id = $_POST['id'];
    $image = $_POST['image'];
    $result = $ReadbBookModel->deleteReadBook($id);
    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบข้อมูลบันทึกรักการอ่านสำเร็จ');
        $uploadDir = '../uploads/images_read/';
        if (file_exists($uploadDir . $image)) {
            unlink($uploadDir . $image);
        }
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}
