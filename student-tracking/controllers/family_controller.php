<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/family_model.php";

$DB = new Class_Database();
$familyModel = new FamilyModel($DB);

if (isset($_REQUEST['getFamilyData'])) {
    $response = array();
    $result_total = $familyModel->getFamilyData();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => (string)$result_total[3]];
    echo json_encode($response);
}

if (isset($_POST['insertfamily'])) {
    $home_number = $_POST['home_number'];
    $moo = $_POST['moo'];
    $alley = $_POST['alley'];
    $alley1 = $_POST['alley1'];
    $street = $_POST['street'];
    $subdistrict = $_POST['subdistrict'];
    $district = $_POST['district'];
    $province = $_POST['province'];
    $dataParam = json_decode($_POST['data'], true);

    $userCreate = $_SESSION['user_data']->role_id == 3 ? $_SESSION['user_data']->id : $_SESSION['user_data']->edu_type;

    $arr_data = [
        "home_number" => $home_number,
        "moo" => $moo,
        "subdistrict" => $subdistrict,
        "district" => $district,
        "province" => $province,
        "street" => $street,
        "alley" => $alley,
        "alley1" => $alley1,
        "user_create" => $userCreate
    ];

    $lastIdFamily = $familyModel->insertFamilyData($arr_data);
    // $lastIdFamily = "";
    // if (count($getDataWhereStdId) == 0) {

    // } else {
    //     $lastIdFamily = $getDataWhereStdId[0]['family_id'];
    // }


    $result = "";

    if ($lastIdFamily > 0) {
        for ($i = 0; $i < count($dataParam); $i++) {
            $needTraining = $dataParam[$i][8]['value'];
            if ($needTraining == 6) {
                $needTraining = $dataParam[$i][9]['value'];
            }
            $arr_data = [
                "family_id" => $lastIdFamily,
                "name" => $dataParam[$i][0]['value'],
                "gender" => $dataParam[$i][1]['value'],
                "age" => $dataParam[$i][2]['value'],
                "job" => $dataParam[$i][3]['value'],
                "education" => $dataParam[$i][4]['value'],
                "need_training" => $needTraining,
                "ability" => $dataParam[$i][10]['value'],
                "role_village" => $dataParam[$i][11]['value'],
                "training_1" => $dataParam[$i][5]['value'],
                "training_2" => $dataParam[$i][6]['value'],
                "training_3" => $dataParam[$i][7]['value'],
            ];
            $result = $familyModel->insertFamilyDataDetail($arr_data);
        }
    }
    if ($result) {
        $response = array('status' => true, 'msg' => 'บันทึกข้อมูลประชากรด้านการศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['deleteFamily'])) {
    $response = array();
    $family_id = $_POST['family_id'];
    $result = $familyModel->deleteFamily($family_id);
    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบข้อมูลประชากรด้านการศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}


if (isset($_POST['updatefamily'])) {

    $family_id = $_POST['family_id'];
    $family_det_id = $_POST['family_det_id'];
    $home_number = $_POST['home_number'];
    $moo = $_POST['moo'];
    $alley = $_POST['alley'];
    $alley1 = $_POST['alley1'];
    $street = $_POST['street'];
    $subdistrict = $_POST['subdistrict'];
    $district = $_POST['district'];
    $province = $_POST['province'];
    $dataParam = json_decode($_POST['data'], true);

    $arr_data = [
        "home_number" => $home_number,
        "moo" => $moo,
        "alley" => $alley,
        "alley1" => $alley1,
        "street" => $street,
        "subdistrict" => $subdistrict,
        "district" => $district,
        "province" => $province,
        "family_id" => $family_id
    ];

    $resultUpdate = $familyModel->updateFamilyData($arr_data);

    $result = "";

    if ($resultUpdate) {
        for ($i = 0; $i < count($dataParam); $i++) {
            $needTraining = $dataParam[$i][8]['value'];
            if ($needTraining == 6) {
                $needTraining = $dataParam[$i][9]['value'];
            }
            $arr_data = [
                "name" => $dataParam[$i][0]['value'],
                "gender" => $dataParam[$i][1]['value'],
                "age" => $dataParam[$i][2]['value'],
                "job" => $dataParam[$i][3]['value'],
                "education" => $dataParam[$i][4]['value'],
                "need_training" => $needTraining,
                "ability" => $dataParam[$i][10]['value'],
                "role_village" => $dataParam[$i][11]['value'],
                "training_1" => $dataParam[$i][5]['value'],
                "training_2" => $dataParam[$i][6]['value'],
                "training_3" => $dataParam[$i][7]['value'],
                "family_det_id" => $family_det_id
            ];
            $result = $familyModel->updateFamilyDataDetail($arr_data);
        }
    }
    if ($result) {
        $response = array('status' => true, 'msg' => 'แก้ไขข้อมูลประชากรด้านการศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}
