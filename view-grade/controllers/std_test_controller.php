<?php
session_start();
include "../../config/class_database.php";
include "../models/std_test_model.php";
$DB = new Class_Database();
$std_test_model = new STD_TEST_Model($DB);

if (isset($_POST['insert_std_test'])) {
    $std_checked = $_POST['std_checked'];
    $term_id = $_POST['term_id'];
    foreach ($std_checked as $std_obj) {
        $statusTest = $std_test_model->checkStatus($term_id, $std_obj['std_id']);
        $std_obj['user_create'] = $_SESSION['user_data']->id;
        $std_obj['term_id'] = $term_id;
        $std_obj['std_class'] = $_POST['std_class'];
        if (count($statusTest) > 0) {
            if ($statusTest[0]->status != $std_obj['status']) {
                $arr_data = [
                    "status_text" => $std_obj['status_text'],
                    "status" => $std_obj['status'],
                    "test_result_id" => $statusTest[0]->test_result_id
                ];
                $result = $std_test_model->insertStdTest($arr_data, "update");
            }
        } else {
            $result = $std_test_model->insertStdTest($std_obj);
            if ($result != 1) {
                $response = array('status' => false, 'msg' => "เกิดข้อผิดพลาย ลองใหม่");
                echo json_encode($response);
                exit();
            }
        }
    }
    $response = array('status' => true, 'msg' => "บันทึกรายชื่อผู้มีสิทธิ์สอบสำเร็จ");
    echo json_encode($response);
}

if (isset($_REQUEST['getDataStdTest'])) {
    $response = array();
    $result_event = $std_test_model->getDataStdTest();
    $response = ['rows' => $result_event[2], "total" => (int)$result_event[0], "totalNotFiltered" => (int)$result_event[1], "sql" => (string)$result_event[3]];
    echo json_encode($response);
}

if (isset($_REQUEST['stdGetDataStdTest'])) {
    $response = array();
    $result_event = $std_test_model->stdGetDataStdTest();
    $response = ['rows' => $result_event[2], "total" => (int)$result_event[0], "totalNotFiltered" => (int)$result_event[1]];
    echo json_encode($response);
}
