<?php
session_start();
include "../../config/class_database.php";
include "../models/moral_model.php";

$DB = new Class_Database();
$moral_model = new Moral_model($DB);


if (isset($_POST['insert_moral'])) {
    try {
        $response = [];
        $array = [];
        $std_score = json_decode($_POST['std_score']);

        $moral_model = new Moral_model($DB);

        $arr = [];

        for ($i = 0; $i < count($std_score); $i++) {

            $checkStd = $moral_model->checkStatus($_SESSION['term_active']->term_id, $std_score[$i]->std_id);
            if (count($checkStd) > 0) {

                $array = [
                    'score' => $std_score[$i]->score_moral,
                    'moral_id' => $checkStd[0]->moral_id
                ];

                $result =  $moral_model->insertMoral($array, "update");
            } else {

                $array = [
                    'term_id' => $_SESSION['term_active']->term_id,
                    'std_class' => $_POST['std_class'],
                    'std_id' => $std_score[$i]->std_id,
                    'score' => $std_score[$i]->score_moral,
                    'user_create' => $_SESSION['user_data']->id,
                ];

                $result =  $moral_model->insertMoral($array);
            }
        }

        if ($result) {
            $response = ['status' => true, 'msg' => 'บันทึกคะแนนคุณธรรมสำเร็จ'];
        } else {
            $response = ['status' => false, 'msg' => $result];
        }
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_REQUEST['getDataMoral'])) {
    $response = array();
    $result_event = $moral_model->getDataMoral();
    $response = ['rows' => $result_event[2], "total" => (int)$result_event[0], "totalNotFiltered" => (int)$result_event[1], "sql" => (string)$result_event[3]];
    echo json_encode($response);
}

if (isset($_REQUEST['stdGetDataMoral'])) {
    $response = array();
    $result_event = $moral_model->stdGetDataMoral();
    $response = ['rows' => $result_event[2], "total" => (int)$result_event[0], "totalNotFiltered" => (int)$result_event[1]];
    echo json_encode($response);
}
