<?php
session_start();
include "../../config/class_database.php";
include "../models/std_gradiate_model.php";
$DB = new Class_Database();
$std_gradiate_model = new STD_Gradiate_Model($DB);

if (isset($_POST['insert_std_gradiate'])) {
    $std_checked = $_POST['std_checked'];
    $term_id = $_POST['term_id'];
    foreach ($std_checked as $std_obj) {
        $statusGradiate = $std_gradiate_model->checkStatus($term_id, $std_obj['std_id']);
        $std_obj['user_create'] = $_SESSION['user_data']->id;
        $std_obj['term_id'] = $term_id;
        $std_obj['std_class'] = $_POST['std_class'];
        if (count($statusGradiate) > 0) {
            if ($statusGradiate[0]->status != $std_obj['status']) {
                // $arr_data = [
                //     "status_text" => $std_obj['status_text'],
                //     "status" => $std_obj['status'],
                //     "gradiate_id" => $statusGradiate[0]->gradiate_id
                // ];
                // $result = $std_gradiate_model->insertStdGradiate($arr_data, "update");
                $result = $std_gradiate_model->deleteStdGradiate($statusGradiate[0]->gradiate_id);
            }
        } else {
            if ($std_obj['status'] == "true") {
                $result = $std_gradiate_model->insertStdGradiate($std_obj);
                if ($result != 1) {
                    $response = array('status' => false, 'msg' => "เกิดข้อผิดพลาย ลองใหม่");
                    echo json_encode($response);
                    exit();
                }
            }
        }
    }
    $response = array('status' => true, 'msg' => "บันทึกรายชื่อนักศึกษาที่คาดว่าจะจบสำเร็จ");
    echo json_encode($response);
}

if (isset($_REQUEST['getDataStdGradiate'])) {
    $response = array();
    $result_event = $std_gradiate_model->getDataStdGradiate();
    $response = ['rows' => $result_event[2], "total" => (int)$result_event[0], "totalNotFiltered" => (int)$result_event[1], "sql" => $result_event[3]];
    echo json_encode($response);
}

if (isset($_REQUEST['stdGetDataStdGradiate'])) {
    $response = array();
    $result_event = $std_gradiate_model->stdGetDataStdGradiate();
    $response = ['rows' => $result_event[2], "total" => (int)$result_event[0], "totalNotFiltered" => (int)$result_event[1]];
    echo json_encode($response);
}
