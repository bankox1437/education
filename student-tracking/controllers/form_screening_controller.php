<?php
session_start();
include "../../config/class_database.php";
include('../models/form_screening_model.php');
$DB = new Class_Database();

if (isset($_POST['add_screening'])) {
    $response = "";
    $formScreeningModel = new FormScreeningStudentModel($DB);

    $std_id = json_decode($_POST['std_id']);
    $side_1 = json_decode($_POST['side_1']);
    $side_2 = json_decode($_POST['side_2']);
    $side_3 = json_decode($_POST['side_3']);
    $side_4 = json_decode($_POST['side_4']);
    $side_5 = json_decode($_POST['side_5']);

    $arr_data = [
        "std_id" => $std_id,
        "user_create" => $_SESSION['user_data']->id
    ];

    $result =  $formScreeningModel->InsertFormScreening($arr_data);
    if ($result != 0) {
        insertSide1($side_1, $result, $formScreeningModel);
        insertSide2($side_2, $result, $formScreeningModel);
        insertSide3($side_3, $result, $formScreeningModel);
        insertSide4($side_4, $result, $formScreeningModel);
        insertSide5($side_5, $result, $formScreeningModel);
        $response = array('status' => true, 'msg' => 'บันทึกแบบคัดกรองนักศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }

    echo json_encode($response);
}

if (isset($_POST['edit_screening'])) {
    $response = "";
    $formScreeningModel = new FormScreeningStudentModel($DB);

    $form_screening_id = $_POST['screening_id'];
    $side_1 = json_decode($_POST['side_1']);
    $side_2 = json_decode($_POST['side_2']);
    $side_3 = json_decode($_POST['side_3']);
    $side_4 = json_decode($_POST['side_4']);
    $side_5 = json_decode($_POST['side_5']);

    insertSide1($side_1, $form_screening_id, $formScreeningModel, "edit");
    insertSide2($side_2, $form_screening_id, $formScreeningModel, "edit");
    insertSide3($side_3, $form_screening_id, $formScreeningModel, "edit");
    insertSide4($side_4, $form_screening_id, $formScreeningModel, "edit");
    insertSide5($side_5, $form_screening_id, $formScreeningModel, "edit");

    $response = array('status' => true, 'msg' => 'บันทึกแบบคัดกรองนักศึกษาสำเร็จ');
    echo json_encode($response);
}

function insertSide1($side_1, $form_screening_id, $formScreeningModel, $mode = "add")
{
    $arr_side1 = $side_1->arr_side1;
    $arr_data = [];
    $arr_data['status'] = $side_1->status;
    for ($i = 0; $i < count($arr_side1); $i++) {
        $statusValue = "";
        if ($arr_side1[$i] == 1) {
            $statusValue = "true";
        } else if ($arr_side1[$i] != "") {
            $statusValue = $arr_side1[$i];
        } else {
            $statusValue = "false";
        }
        $arr_data["side_1_" . ($i + 1)] =  $statusValue;
    }
    $arr_data['side_1_1_1_have'] = $side_1->arr_side1_1;
    $arr_data['screening_id'] = $form_screening_id;
    if ($mode == 'add') {
        $formScreeningModel->InsertFormSide1($arr_data);
    } else {
        $formScreeningModel->UpdateFormSide1($arr_data);
    }
}

function insertSide2($side_2, $form_screening_id, $formScreeningModel, $mode = "add")
{
    $arr_side2 = $side_2->arr_side2;
    $arr_data = [];
    $arr_data['status'] = $side_2->status;
    for ($i = 0; $i < count($arr_side2); $i++) {
        $statusValue = "";
        if ($arr_side2[$i] == 1) {
            $statusValue = "true";
        } else if ($arr_side2[$i] != "") {
            $statusValue = $arr_side2[$i];
        } else {
            $statusValue = "false";
        }
        $arr_data["side_2_" . ($i + 1)] =  $statusValue;
    }
    $arr_data['screening_id'] = $form_screening_id;
    if ($mode == 'add') {
        $formScreeningModel->InsertFormSide2($arr_data);
    } else {
        $formScreeningModel->UpdateFormSide2($arr_data);
    }
}

function insertSide3($side_3, $form_screening_id, $formScreeningModel, $mode = "add")
{
    $arr_data = [
        "side_3_1" => $side_3->side_3_1, "side_3_2" => $side_3->side_3_2,
        "side_3_3" => $side_3->side_3_3, "side_3_4" => $side_3->side_3_4,
        "side_3_summary" => $side_3->side_3_summary,
        "screening_id" =>  $form_screening_id
    ];
    if ($mode == 'add') {
        $formScreeningModel->InsertFormSide3($arr_data);
    } else {
        $formScreeningModel->UpdateFormSide3($arr_data);
    }
}

function insertSide4($side_4, $form_screening_id, $formScreeningModel, $mode = "add")
{
    $arr_side4_1 = $side_4->arr_side4_1;
    $arr_side4_2 = $side_4->arr_side4_2;

    $arr_data = [];
    $arr_data['side_4_1_status'] = $side_4->status4_1;
    for ($i = 0; $i < count($arr_side4_1); $i++) {
        $statusValue = "";
        if ($arr_side4_1[$i] == 1) {
            $statusValue = "true";
        } else if ($arr_side4_1[$i] != "") {
            $statusValue = $arr_side4_1[$i];
        } else {
            $statusValue = "false";
        }
        $arr_data["side_4_1_" . ($i + 1)] =  $statusValue;
    }
    $arr_data['side_4_2_status'] = $side_4->status4_1;
    for ($i = 0; $i < count($arr_side4_2); $i++) {
        $statusValue = "";
        if ($arr_side4_2[$i] == 1) {
            $statusValue = "true";
        } else if ($arr_side4_2[$i] != "") {
            $statusValue = $arr_side4_2[$i];
        } else {
            $statusValue = "false";
        }
        $arr_data["side_4_2_" . ($i + 1)] =  $statusValue;
    }
    $arr_data['screening_id'] = $form_screening_id;
    if ($mode == 'add') {
        $formScreeningModel->InsertFormSide4($arr_data);
    } else {
        $formScreeningModel->UpdateFormSide4($arr_data);
    }
}

function insertSide5($side_5, $form_screening_id, $formScreeningModel, $mode = "add")
{
    $arr_data = [
        "side_5_1" => $side_5->side_5_1,
        "side_5_2" => $side_5->side_5_2,
        "side_5_3" => $side_5->side_5_3,
        "screening_id" =>  $form_screening_id,
    ];
    if ($mode == 'add') {
        $formScreeningModel->InsertFormSide5($arr_data);
    } else {
        $formScreeningModel->UpdateFormSide5($arr_data);
    }
}


if (isset($_POST['getDataScreeningStd'])) {
    $response = array();
    $form_screening = new FormScreeningStudentModel($DB);
    $result = $form_screening->getDataScreeningStd();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getClassInDropdown'])) {
    $response = array();
    $form_screening = new FormScreeningStudentModel($DB);
    $result = $form_screening->getClassInDropdown();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getDataScreeningStdByWhere'])) {
    $response = array();
    $form_screening = new FormScreeningStudentModel($DB);

    $std_class = htmlentities($_POST['std_class']);
    $pro_id = htmlentities($_POST['pro_id']);
    $dis_id = htmlentities($_POST['dis_id']);
    $sub_district_id = htmlentities($_POST['sub_district_id']);

    $result = $form_screening->getDataScreeningStdByClass($std_class, $sub_district_id, $dis_id, $pro_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getDataScreeningStdByAmphur'])) {
    $response = array();
    $form_screening = new FormScreeningStudentModel($DB);

    $std_class = htmlentities($_POST['std_class']);
    $pro_id = htmlentities($_POST['pro_id']);
    $dis_id = htmlentities($_POST['dis_id']);
    $sub_district_id = htmlentities($_POST['sub_district_id']);

    $result = $form_screening->getDataScreeningStdByAmphur($std_class, $sub_district_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['delete_form_2_5'])) {
    $response = array();
    $form_screening = new FormScreeningStudentModel($DB);
    $id = $_POST['id'];
    $result = $form_screening->deleteForm($id);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ลบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => $result);
    }
    echo json_encode($response);
}


if (isset($_POST['getSubDistrict'])) {
    $response = array();
    $form_screening = new FormScreeningStudentModel($DB);
    $result = $form_screening->getSubDistrict();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}
