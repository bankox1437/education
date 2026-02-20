<?php

session_start();
include "../../config/class_database.php";
include "../models/form_visit_home_model.php";

$DB = new Class_Database();


// if (isset($_POST['AddDataVisit2'])) {
//     $response = array();
//     $form_visit_model = new FormVisitHomeModel($DB);
//     $std_id = htmlentities($_POST['std_id']);
//     $side2 = $_POST['side2'];
//     $side3 = $_POST['side3'];
//     $side4 = $_POST['side4'];
//     $location = htmlentities($_POST['side5']);

//     $arr_data_visit = [
//         "std_id" => $std_id,
//         "location" => $location,
//         "user_create" => $_SESSION['user_data']->id
//     ];
//     $form_visit_id = $form_visit_model->InsertFormVisitHome($arr_data_visit);
//     if ($form_visit_id != 0) {
//         InsertSide2($side2, $form_visit_id, $form_visit_model);
//         InsertSide3($side3, $form_visit_id, $form_visit_model);
//         InsertSide4($side4, $form_visit_id, $form_visit_model);
//         $response = array('status' => true, 'msg' => 'บันทึกการเยี่ยมบ้านสำเร็จ');
//     } else {
//         $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาดบางอย่าง ลองใหม่');
//     }
//     echo json_encode($response);
// }

if (isset($_POST['AddDataVisit'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();
    $form_visit_model = new FormVisitHomeModel($DB);

    $std_id = htmlentities($_POST['std_id']);
    $side2 = json_decode($_POST['side2']);
    $side3 = json_decode($_POST['side3']);
    $side4 = json_decode($_POST['side4']);
    $location = htmlentities($_POST['side5']);

    $side6 = $_FILES['side6'];
    $uploadDir = '../uploads/visit_home_img/';
    $resizeDir = '../uploads/';

    $home_img = "";
    $fileNameRes = $mainFunc->UploadFileImage($side6, $uploadDir, $resizeDir);
    // $fileNameRes = $mainFunc->UploadFileImage($side6, $uploadDir, '../uploads/resize_img/');
    if (!$fileNameRes['status']) {
        $response = array('status' => false, 'msg' => $fileNameRes['result']);
        echo json_encode($response);
        exit();
    } else {
        $home_img = $fileNameRes['result'];
    }

    $arr_data_visit = [
        "std_id" => $std_id,
        "location" => $location,
        "home_img" => $home_img,
        "user_create" => $_SESSION['user_data']->id
    ];

    $form_visit_id = $form_visit_model->InsertFormVisitHome($arr_data_visit);

    if ($form_visit_id != 0) {
        InsertSide2($side2, $form_visit_id, $form_visit_model);
        InsertSide3($side3, $form_visit_id, $form_visit_model);
        InsertSide4($side4, $form_visit_id, $form_visit_model);
        $fm_data = [
            "father_name" => $_POST['father_name'],
            "father_job" => $_POST['father_job'],
            "mather_name" => $_POST['mather_name'],
            "mather_job" => $_POST['mather_job'],
            "std_id" => $std_id
        ];
        $form_visit_model->updateFMname($fm_data);
        $response = array('status' => true, 'msg' => 'บันทึกการเยี่ยมบ้านสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาดบางอย่าง ลองใหม่');
    }
    echo json_encode($response);
}

// if (isset($_POST['EditDataVisit2'])) {
//     $response = array();
//     $form_visit_model = new FormVisitHomeModel($DB);
//     $form_visit_id = htmlentities($_POST['form_visit_id']);
//     $side2 = $_POST['side2'];
//     $side3 = $_POST['side3'];
//     $side4 = $_POST['side4'];
//     $location = htmlentities($_POST['side5']);

//     $arr_data_visit = [
//         "location" => $location,
//         "form_visit_id" => $form_visit_id
//     ];
//     $result = $form_visit_model->UpdateFormVisitHome($arr_data_visit);
//     if ($result != 0) {
//         InsertSide2($side2, $form_visit_id, $form_visit_model, "edit");
//         InsertSide3($side3, $form_visit_id, $form_visit_model, "edit");
//         InsertSide4($side4, $form_visit_id, $form_visit_model, "edit");
//         $response = array('status' => true, 'msg' => 'บันทึกการเยี่ยมบ้านสำเร็จ');
//     } else {
//         $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาดบางอย่าง ลองใหม่');
//     }
//     echo json_encode($response);
// }

if (isset($_POST['EditDataVisit'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();
    $form_visit_model = new FormVisitHomeModel($DB);

    $form_visit_id = htmlentities($_POST['form_visit_id']);
    $side2 = json_decode($_POST['side2']);
    $side3 = json_decode($_POST['side3']);
    $side4 = json_decode($_POST['side4']);
    $location = htmlentities($_POST['side5']);
    $home_img = $_POST['side6_old'];

    if (count($_FILES) > 0) {
        $side6 = $_FILES['side6'];
        $uploadDir = '../uploads/visit_home_img/';
        $fileNameRes = $mainFunc->UploadFileImage($side6, $uploadDir);
        // $fileNameRes = $mainFunc->UploadFileImage($side6, $uploadDir, '../uploads/resize_img/');
        if (!$fileNameRes['status']) {
            $response = array('status' => false, 'msg' => $fileNameRes['result']);
            echo json_encode($response);
            exit();
        } else {
            $home_img = $fileNameRes['result'];
            unlink($uploadDir . $_POST['side6_old']);
        }
    }

    $arr_data_visit = [
        "location" => $location,
        "home_img" => $home_img,
        "form_visit_id" => $form_visit_id
    ];

    $result = $form_visit_model->UpdateFormVisitHome($arr_data_visit);
    if ($result != 0) {
        InsertSide2($side2, $form_visit_id, $form_visit_model, "edit");
        InsertSide3($side3, $form_visit_id, $form_visit_model, "edit");
        InsertSide4($side4, $form_visit_id, $form_visit_model, "edit");

        $fm_data = [
            "father_name" => $_POST['father_name'],
            "father_job" => $_POST['father_job'],
            "mather_name" => $_POST['mather_name'],
            "mather_job" => $_POST['mather_job'],
            "std_id" => $_POST['std_id']
        ];
        $form_visit_model->updateFMname($fm_data);
        $response = array('status' => true, 'msg' => 'บันทึกการเยี่ยมบ้านสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาดบางอย่าง ลองใหม่');
    }
    echo json_encode($response);
}

function InsertSide2($side_data, $form_visit_id, $form_visit_model, $mode = "add")
{
    $arr_data_side2 = [
        "side_2_1" => $side_data->side_2_1,
        "side_2_2" => $side_data->side_2_2,
        "side_2_3" => $side_data->side_2_3,
        "side_2_4" => $side_data->side_2_4,
        "form_visit_id" => $form_visit_id,
    ];
    if ($mode == "add") {
        $form_visit_model->InsertFormVisitHomeSide2($arr_data_side2);
    } else {
        $form_visit_model->UpdateFormVisitHomeSide2($arr_data_side2);
    }
}

function InsertSide3($side_data, $form_visit_id, $form_visit_model, $mode = "add")
{
    $arr_data_side3 = [
        "side_3_1" => $side_data->side_3_1,
        "text_3_1" => $side_data->text_3_1,
        "side_3_2" => $side_data->side_3_2,
        "text_3_2" => $side_data->text_3_2,
        "side_3_3" => $side_data->side_3_3,
        "text_3_3" => $side_data->text_3_3,
        "side_3_4" => $side_data->side_3_4,
        "side_3_5" => $side_data->side_3_5,
        "form_visit_id" => $form_visit_id,
    ];
    if ($mode == "add") {
        $form_visit_model->InsertFormVisitHomeSide3($arr_data_side3);
    } else {
        $form_visit_model->UpdateFormVisitHomeSide3($arr_data_side3);
    }
}

function InsertSide4($side_data, $form_visit_id, $form_visit_model, $mode = "add")
{
    $arr_data_side4 = [
        "status" => $side_data->status,
        "text" => $side_data->text,
        "form_visit_id" => $form_visit_id,
    ];
    if ($mode == "add") {
        $form_visit_model->InsertFormVisitHomeSide4($arr_data_side4);
    } else {
        $form_visit_model->UpdateFormVisitHomeSide4($arr_data_side4);
    }
}


if (isset($_POST['getDataVisitHome'])) {
    $response = array();
    $form_visit_model = new FormVisitHomeModel($DB);
    $result = $form_visit_model->getDataVisitHome();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_REQUEST['getDataVisitHomeBS'])) {
    try {
        $form_visit_model = new FormVisitHomeModel($DB);
        $response = array();
        $result_total = $form_visit_model->getDataVisitHomeBS();
        $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => (string)$result_total[3]];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_POST['delete_form_1_2'])) {
    $response = array();
    $form_visit_model = new FormVisitHomeModel($DB);
    $id = $_POST['id'];
    $filename = $_POST['filename'];
    $result = $form_visit_model->deleteForm($id);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ลบสำเร็จ');
        $uploadDir = '../uploads/visit_home_img/';
        unlink($uploadDir . $filename);
    } else {
        $response = array('status' => false, 'msg' => $result);
    }
    echo json_encode($response);
}

if (isset($_POST['getClassInDropdown'])) {
    $response = array();
    $form_visit_model = new FormVisitHomeModel($DB);
    $result = $form_visit_model->getClassInDropdown();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

// if (isset($_POST['getDataVisitHomeByClass'])) {
//     $response = array();
//     $form_visit_model = new FormVisitHomeModel($DB);
//     $std_class = htmlentities($_POST['std_class']);
//     $sub_district_id = htmlentities($_POST['sub_district_id']);
//     $result = $form_visit_model->getDataVisitHomeByStdClass($std_class, $sub_district_id);
//     $response = array('status' => true, 'data' => $result);
//     echo json_encode($response);
// }

if (isset($_POST['getDataVisitHomeByClass'])) {
    $response = array();
    $form_visit_model = new FormVisitHomeModel($DB);

    $std_class = htmlentities($_POST['std_class']);
    $pro_id = htmlentities($_POST['pro_id']);
    $dis_id = htmlentities($_POST['dis_id']);
    $sub_district_id = htmlentities($_POST['sub_district_id']);

    $result = $form_visit_model->getDataVisitHomeByStdClass($std_class, $sub_district_id, $dis_id, $pro_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getDataVisitHomeByAmphur'])) {
    $response = array();
    $form_visit_model = new FormVisitHomeModel($DB);

    $std_class = htmlentities($_POST['std_class']);
    $pro_id = htmlentities($_POST['pro_id']);
    $dis_id = htmlentities($_POST['dis_id']);
    $sub_district_id = htmlentities($_POST['sub_district_id']);

    $result = $form_visit_model->getDataVisitHomeByAmphur($std_class, $sub_district_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getSubDistrict'])) {
    $response = array();
    $form_visit_model = new FormVisitHomeModel($DB);
    $result = $form_visit_model->getSubDistrict();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}
