<?php
session_start();
include "../../config/class_database.php";
include "../models/n_net_model.php";
$DB = new Class_Database();
$n_net_Model = new N_Net_Model($DB);

if (isset($_POST['insert_n_net'])) {
    $std_checked = $_POST['std_checked'];
    $term_id = $_POST['term_id'];
    foreach ($std_checked as $std_obj) {
        $status_n_net = $n_net_Model->checkStatus($term_id, $std_obj['std_id']);
        $std_obj['user_create'] = $_SESSION['user_data']->id;
        $std_obj['term_id'] = $term_id;
        $std_obj['std_class'] = $_POST['std_class'];
        if (count($status_n_net) > 0) {
            if ($status_n_net[0]->status != $std_obj['status']) {
                // $arr_data = [
                //     "status_text" => $std_obj['status_text'],
                //     "status" => $std_obj['status'],
                //     "n_net_id" => $status_n_net[0]->n_net_id
                // ];
                // $result = $n_net_Model->insertN_Net($arr_data, "update");
                $result = $n_net_Model->deleteN_Net($status_n_net[0]->n_net_id);
            }
        } else {
            if ($std_obj['status'] == "true") {
                $result = $n_net_Model->insertN_Net($std_obj);
                if ($result != 1) {
                    $response = array('status' => false, 'msg' => "เกิดข้อผิดพลาย ลองใหม่");
                    echo json_encode($response);
                    exit();
                }
            }
        }
    }
    $response = array('status' => true, 'msg' => "บันทึกตะแนน N-Net สำเร็จ");
    echo json_encode($response);
}

if (isset($_REQUEST['getDataN_Net'])) {
    $response = array();
    $result_event = $n_net_Model->getDataN_Net();
    $response = ['rows' => $result_event[2], "total" => (int)$result_event[0], "totalNotFiltered" => (int)$result_event[1], "sql" => $result_event[3]];
    echo json_encode($response);
}


if (isset($_REQUEST['stdGetDataN_Net'])) {
    $response = array();
    $result_event = $n_net_Model->stdGetDataN_Net();
    $response = ['rows' => $result_event[2], "total" => (int)$result_event[0], "totalNotFiltered" => (int)$result_event[1]];
    echo json_encode($response);
}
