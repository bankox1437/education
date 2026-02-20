<?php
session_start();
include "../../config/class_database.php";
include "../models/term_model.php";

$DB = new Class_Database();

if (isset($_POST['insertTerm'])) {
    $response = "";
    $term_model = new Term_Model($DB);
    $term_model->changeTermUnActive($_SESSION['user_data']->id);
    $array_data = [
        'term' => $_POST['term'],
        'year' => $_POST['year'],
        'user_create' => $_SESSION['user_data']->id
    ];
    $result = $term_model->insertTerm($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'บันทึกข้อมูลเทอมสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['updateTerm'])) {
    $response = "";
    $term_model = new Term_Model($DB);
    $array_data = [
        'term' => $_POST['term'],
        'year' => $_POST['year'],
        'term_id' => $_POST['term_id']
    ];
    $result = $term_model->updateTerm($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'แก้ไขข้อมูลเทอมสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['getTerms'])) {
    $response = array();
    $userModel = new Term_Model($DB);
    $result_terms = $userModel->getCountTerm();
    $response = ['rows' => $result_terms[2], "total" => (int)$result_terms[0], "totalNotFiltered" => (int)$result_terms[1]];
    echo json_encode($response);
}

if (isset($_POST['delete_term'])) {
    $response = array();
    $userModel = new Term_Model($DB);
    $delete = $userModel->deleteTerm($_POST['id']);
    if ($delete) {
        $response = array('status' => true, 'msg' => 'ลบข้อมูลเทอมสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}
