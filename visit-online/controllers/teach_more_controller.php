<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/teach_more_model.php";

$DB = new Class_Database();
$teach_model = new TeachMore_Model($DB);

if (isset($_REQUEST['getTeachMore'])) {
    $response = array();
    $result = $teach_model->getTeachMore();

    // Get the protocol (HTTP or HTTPS)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    // Get the hostname
    $host = $_SERVER['HTTP_HOST'];

    // Construct the full URL
    $fullUrl = $protocol . $host;
    // $fullUrl .= "/edu"; // localhost
    $fullUrl .= "/visit-online";

    // Process the teach_file URLs
    foreach ($result[2] as &$value) {
        if (is_object($value) && isset($value->teach_file)) {
            $filePath = '../uploads/teach_more/' . $value->teach_file;
            $value->teach_file = file_exists($filePath)
                ? $fullUrl . "/uploads/teach_more/" . $value->teach_file
                : "https://drive.google.com/file/d/{$value->teach_file}/view";
        }
    }
    $response = ['rows' => $result[2], "total" => (int)$result[0], "totalNotFiltered" => (int)$result[1]];
    echo json_encode($response);
}

if (isset($_POST['updateTeachMore'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();

    $uploadDir = '../uploads/teach_more/';

    $array_data = [
        'teach_subject_code' => $_POST['subject_code'],
        'teach_subject_name' => $_POST['subject_name'],
        'teach_cate' => $_POST['cate'],
        'teach_class' => $_POST['std_class'],
        'year' => $_POST['year'],
        'link' => $_POST['link'],
        'user_create' => $_SESSION['user_data']->id
    ];

    if (count($_FILES) > 0) {
        $plan_file = $_FILES['sh_plan_file'];
        $filenameResPlan_file = $mainFunc->UploadFile($plan_file, $uploadDir);
        if (!$filenameResPlan_file['status']) {
            $response = array('status' => false, 'msg' => $filenameResPlan_file['result']);
            echo json_encode($response);
            exit();
        }
        $array_data['teach_file'] = $filenameResPlan_file['result'];
        $array_data['teach_file_name'] = $plan_file['name'];
        if (!empty($_POST['sh_plan_file_old'])) {
            unlink($uploadDir . $_POST['sh_plan_file_old']);
        }
    }

    $mode = "INSERT";
    if (!empty($_POST['teach_m_id'])) {
        $array_data['teach_m_id'] =  $_POST['teach_m_id'];
        $mode = "UPDATE";
    }

    $result = $teach_model->InsertTeachmore($array_data, $mode);
    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? !empty($_POST['teach_m_id']) ? 'แก้ไข' . 'การสอนเสริมสำเร็จ' : 'บันทึก' . 'การสอนเสริมสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}

if (isset($_POST['deleteTeachMore'])) {
    $response = array();
    $teach_m_id = $_POST['teach_m_id'];
    $result = $teach_model->deleteTeachMore($teach_m_id);

    $uploadDir = '../uploads/teach_more/';
    $teach_file = $_POST['teach_file'];

    if ($result) {
        unlink($uploadDir . $teach_file);
    }
    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? 'ลบข้อมูลการสอนเสริมสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}

if (isset($_POST['downloadUpdate'])) {
    $response = array();
    $teach_m_id = $_POST['teach_m_id'];
    $result = $teach_model->downloadUpdate($teach_m_id);
    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? 'ดาวน์โหลดสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}

if (isset($_POST['viewsUpdate'])) {
    $response = array();
    $teach_m_id = $_POST['teach_m_id'];
    $result = $teach_model->viewUpdate($teach_m_id);
    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? 'เข้าชมสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}
