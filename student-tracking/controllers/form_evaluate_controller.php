<?php

session_start();
include "../../config/class_database.php";
include "../models/form_evaluate_model.php";

$DB = new Class_Database();

if (isset($_POST['add_evaluate_std'])) {
    $response = array();
    $form_evaluateModel = new FormEvaluatemodel($DB);
    $std_id = htmlentities($_POST['std_id']);
    $note = htmlentities($_POST['note']);
    $score_1 = htmlentities($_POST['score_1']);
    $score_2 = htmlentities($_POST['score_2']);
    $score_3 = htmlentities($_POST['score_3']);
    $score_4 = htmlentities($_POST['score_4']);
    $sum_score = htmlentities($_POST['sum_score']);
    $score_5 = htmlentities($_POST['score_5']);

    $arr_data = array(
        "std_id" => $std_id,
        "note" => $note,
        "side_1_score" => $score_1,
        "side_2_score" => $score_2,
        "side_3_score" => $score_3,
        "side_4_score" => $score_4,
        "sum_score" => $sum_score,
        "side_5_score" => $score_5,
        "user_create" => $_SESSION['user_data']->id
    );

    $resultInsert_form_evaluate = $form_evaluateModel->addEvaluate_student($arr_data);

    $behavior_data = json_decode($_POST['behavior_data']);
    for ($i = 0; $i < count($behavior_data); $i++) {
        $result = $form_evaluateModel->addBehavior($behavior_data[$i]->id, $behavior_data[$i]->behavior_status, $resultInsert_form_evaluate);
        if ($result != 1) {
            $response = array('status' => false, 'msg' => 'insert stf_tb_form_evaluate_student_detail failed');
            exit();
        }
    }

    $response = array('status' => true, 'msg' => 'insert successfuly');
    echo json_encode($response);
}

if (isset($_POST['getDataEvaluate'])) {
    $response = array();
    $form_evaluateModel = new FormEvaluatemodel($DB);
    $result = $form_evaluateModel->getDataEvaluate();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['delete_form_evaluate'])) {
    $response = array();
    $form_evaluateModel = new FormEvaluatemodel($DB);
    $form_eva_id = $_POST['form_eva_id'];
    $result = $form_evaluateModel->deleteEvaluateData($form_eva_id);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ลบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => $result);
    }

    echo json_encode($response);
}

if (isset($_POST['getClassInDropdown'])) {
    $response = array();
    $form_evaluateModel = new FormEvaluatemodel($DB);
    $result = $form_evaluateModel->getClassInDropdown();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getDataEvaluateByWhere'])) {
    $response = array();
    $form_evaluateModel = new FormEvaluatemodel($DB);

    $std_class = htmlentities($_POST['std_class']);
    $pro_id = htmlentities($_POST['pro_id']);
    $dis_id = htmlentities($_POST['dis_id']);
    $sub_district_id = htmlentities($_POST['sub_district_id']);

    $result = $form_evaluateModel->getDataEvaluateByStdClass($std_class, $sub_district_id, $dis_id, $pro_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getDataEvaluateByAmphur'])) {
    $response = array();
    $form_evaluateModel = new FormEvaluatemodel($DB);

    $std_class = htmlentities($_POST['std_class']);
    $pro_id = htmlentities($_POST['pro_id']);
    $dis_id = htmlentities($_POST['dis_id']);
    $sub_district_id = htmlentities($_POST['sub_district_id']);

    $result = $form_evaluateModel->getDataEvaluateByAmphur($std_class, $sub_district_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getSubDistrict'])) {
    $response = array();
    $form_evaluateModel = new FormEvaluatemodel($DB);
    $result = $form_evaluateModel->getSubDistrict();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getdataedit'])) {
    $eva_id = htmlentities($_POST['eva_id']);
    $response = array();
    $form_evaluateModel = new FormEvaluatemodel($DB);
    $result = $form_evaluateModel->getdataedit($eva_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['edit_evaluate_std'])) {
    $response = array();
    $form_evaluateModel = new FormEvaluatemodel($DB);
    $form_id = htmlentities($_POST['form_id']);
    $note = htmlentities($_POST['note']);
    $score_1 = htmlentities($_POST['score_1']);
    $score_2 = htmlentities($_POST['score_2']);
    $score_3 = htmlentities($_POST['score_3']);
    $score_4 = htmlentities($_POST['score_4']);
    $sum_score = htmlentities($_POST['sum_score']);
    $score_5 = htmlentities($_POST['score_5']);


    $arr_data = array(
        "note" => $note,
        "side_1_score" => $score_1,
        "side_2_score" => $score_2,
        "side_3_score" => $score_3,
        "side_4_score" => $score_4,
        "sum_score" => $sum_score,
        "side_5_score" => $score_5,
        "user_update" => $_SESSION['user_data']->id,
        "update_date" => date("Y-m-d"),
        "form_id" => $form_id,
    );

    $resulUpdate_form_evaluate = $form_evaluateModel->editEvaluate_student($arr_data);
    if ($resulUpdate_form_evaluate == 1) {
        $behavior_data = json_decode($_POST['behavior_data']);
        for ($i = 0; $i < count($behavior_data); $i++) {
            $result = $form_evaluateModel->UpdateBehavior($behavior_data[$i]->behavior_status, $behavior_data[$i]->form_det_id);
            if ($result != 1) {
                $response = array('status' => false, 'msg' => 'insert stf_tb_form_evaluate_student_detail failed');
                exit();
            }
        }
    }

    $response = array('status' => true, 'msg' => 'insert successfuly');
    echo json_encode($response);
}
