<?php
session_start();
include "../../config/class_database.php";
include('../models/report_model.php');
include('../../config/main_function.php');

$DB = new Class_Database();
function CheckUploadFileImage($file, $file_old = "")
{
    $mainFunc = new ClassMainFunctions();
    $uploadDir = '../uploads/report_img/';
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

if (isset($_POST['getDataReport'])) {
    $response = array();
    $reportM = new Report_Model($DB);
    $user_id = $_SESSION['user_data']->id;
    if ($_POST['user_id'] != 0) {
        $user_id = $_POST['user_id'];
    }
    $result = $reportM->getDataReport($user_id);
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_POST['getDataReportNew'])) {
    $response = array();
    $reportM = new Report_Model($DB);
    $user_id = $_SESSION['user_data']->id;
    if ($_POST['user_id'] != 0) {
        $user_id = $_POST['user_id'];
    }
    $result = $reportM->getDataReportNew($user_id);
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_POST['insertReport'])) {
    $response = array();
    $reportM = new Report_Model($DB);
    $report_name = htmlentities($_POST['report_name']);
    $report_detail = htmlentities($_POST['report_detail']);
    $user_create = $_SESSION['user_data']->id;
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

    $arr_learning = [
        "report_name" => $report_name,
        "report_detail" => $report_detail,
        "img_name_1" => $image_file1,
        "img_name_2" => $image_file2,
        "img_name_3" => $image_file3,
        "img_name_4" => $image_file4,
        "user_create" => $user_create
    ];
    $result = $reportM->InsertReport($arr_learning);
    if ($result != 0) {
        $response = array('status' => true, 'msg' => 'บันทึกรายงานการดำเนินการสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['updateReport'])) {
    $response = array();

    $report_name = htmlentities($_POST['report_name']);
    $report_detail = htmlentities($_POST['report_detail']);
    $report_id = $_POST['report_id'];

    $image_file1 = $_POST['image_file1_old'];
    $image_file2 = $_POST['image_file2_old'];
    $image_file3 = $_POST['image_file3_old'];
    $image_file4 = $_POST['image_file4_old'];

    if (isset($_FILES['image_file1'])) {
        $image_file1 = CheckUploadFileImage($_FILES['image_file1'], $image_file1);
    }
    if (isset($_FILES['image_file2'])) {
        $image_file2 = CheckUploadFileImage($_FILES['image_file2'], $image_file2);
    }
    if (isset($_FILES['image_file3'])) {
        $image_file3 = CheckUploadFileImage($_FILES['image_file3'], $image_file3);
    }
    if (isset($_FILES['image_file4'])) {
        $image_file4 = CheckUploadFileImage($_FILES['image_file4'], $image_file4);
    }
    $arr = [
        'report_name' => $report_name,
        'report_detail' => $report_detail,
        "img_name_1" => $image_file1,
        "img_name_2" => $image_file2,
        "img_name_3" => $image_file3,
        "img_name_4" => $image_file4,
        'report_id' => $report_id
    ];
    $reportM = new Report_Model($DB);
    $result = $reportM->UpdateReport($arr);
    if ($result != 0) {
        $response = array('status' => true, 'msg' => 'แก้ไขรายงานการดำเนินการสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['delete_summary'])) {
    $reportM = new Report_Model($DB);
    $report = $_POST['id'];
    $img_1 = $_POST['img_1'];
    $img_2 = $_POST['img_2'];
    $img_3 = $_POST['img_3'];
    $img_4 = $_POST['img_4'];
    $result = $reportM->DeleteReport($report);
    $uploadDir = '../uploads/report_img/';

    if ($result == 1) {
        if ($img_1 != "") {
            unlink($uploadDir . $img_1);
        }
        if ($img_2 != "") {
            unlink($uploadDir . $img_2);
        }
        if ($img_3 != "") {
            unlink($uploadDir . $img_3);
        }
        if ($img_4 != "") {
            unlink($uploadDir . $img_4);
        }
        $response = array('status' => true, 'msg' => 'ลบรายงานการดำเนินการสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['delete_summary_new'])) {
    $reportM = new Report_Model($DB);
    $report = $_POST['report_id'];
    $filename = $_POST['filename'];
    // $img_2 = $_POST['img_2'];
    // $img_3 = $_POST['img_3'];
    // $img_4 = $_POST['img_4'];
    $result = $reportM->DeleteReportNew($report);
    $uploadDir = '../uploads/report_pdf/';

    if ($result == 1) {
        if ($filename != "") {
            unlink($uploadDir . $filename);
        }
        $response = array('status' => true, 'msg' => 'ลบรายงานผลการปฏิบัติงานสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}


function CheckUploadFilePDF($file, $file_old = "")
{
    $mainFunc = new ClassMainFunctions();
    $uploadDir = '../uploads/report_pdf/';

    $file_response = $mainFunc->UploadFile($file, $uploadDir);
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

if (isset($_POST['insertReportNew'])) {
    $response = array();

    unset($_POST['insertReportNew']);

    $user_create = $_SESSION['user_data']->id;

    $reportM = new Report_Model($DB);
    $report_file = isset($_POST['report_file_old']) ? $_POST['report_file_old'] : '';
    $report_file_raw = "";
    if (isset($_FILES['report_file'])) {
        $report_file = CheckUploadFilePDF($_FILES['report_file'], $report_file);
        $report_file_raw = $_FILES['report_file']['name'];
    } else {
        $report_file = $_POST['report_file_old'];
    }

    $arr = [];
    $type = 1;
    $msg = "บันทึกไฟล์ผลการเรียนการสอนสำเร็จ";
    $arr = [
        "filename" => $report_file,
        "filename_raw" =>  $report_file_raw,
        "user_create" => $user_create
    ];

    $result = $reportM->InsertReportNew($arr);
    if ($result != 0) {
        $response = array('status' => true, 'msg' => $msg);
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}
