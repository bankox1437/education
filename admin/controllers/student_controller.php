<?php
session_start();
include "../../config/class_database.php";
include '../models/student_model.php';
$DB = new Class_Database();

if (isset($_POST['getDataStudentAdmin'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $edu_id = "";
    if (isset($_POST['edu_id'])) {
        $edu_id = $_POST['edu_id'];
    }
    $result = $std_model->getDataStudentAdmin($edu_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_REQUEST['getDataStudentAdminNew'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $result_total = $std_model->getDataStudentAdminNew();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1]];
    echo json_encode($response);
}

if (isset($_POST['getEduOfStd'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $result = $std_model->getEduOfStd();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getTeacherStd'])) {
    $response = "";
    $data = $_POST['dataFilter'];
    $std_model = new Student_Model($DB);
    $result = $std_model->getTeacherStd($data);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['delete_std'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $id = $_POST['id'];
    $result = $std_model->deleteStd($id);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ลบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => $result);
    }

    echo json_encode($response);
}

if (isset($_POST['delete_multiple_std'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $arr_edu_id = json_decode($_POST['arr_edu_id']);
    for ($i = 0; $i < count($arr_edu_id); $i++) {
        $result = $std_model->deleteStd($arr_edu_id[$i]);
    }
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ลบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => $result);
    }

    echo json_encode($response);
}


function convertDate($date)
{
    $parts = explode('/', $date);
    $day = $parts[0];
    $month = $parts[1];
    $year = $parts[2];

    // Convert Thai Buddhist era year to Gregorian year
    //$year -= 543;

    // Format the date in the desired format
    $formattedDate = sprintf('%04d-%02d-%02d', $year, $month, $day);

    return $formattedDate;
}

if (isset($_POST['move_std'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $result = $std_model->updateMoveStd($_POST['edu_move'], $_POST['std_id']);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ย้ายนักศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => $result);
    }
    echo json_encode($response);
}
