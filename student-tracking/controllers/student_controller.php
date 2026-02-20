<?php
session_start();
include "../../config/class_database.php";
include('../../config/main_function.php');
include '../models/student_model.php';

$DB = new Class_Database();
$main_func = new ClassMainFunctions();

if (isset($_POST['import_students'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $result = 0;
    //$file = $_FILES["csv_file"]["tmp_name"];
    $fileName = $_FILES["csv_file"]["name"];
    $fileExtension = explode('.', $fileName);


    $fileExtension = strtolower(end($fileExtension));
    if ($fileExtension != "xlsx" && $fileExtension != "xls" && $fileExtension != "csv") {
        $response = array('status' => false, 'msg' => 'ไฟล์ที่นำเข้าไม่ถูกต้อง');
        echo json_encode($response);
        exit();
    }

    $newfileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;
    $targetDirectory = "../images/" . $newfileName;
    move_uploaded_file($_FILES['csv_file']['tmp_name'], $targetDirectory);

    error_reporting(0);
    ini_set('display_errors', 0);
    require '../../config/excelReader/excel_reader2.php';
    require '../../config/excelReader/SpreadsheetReader.php';

    $reader = new SpreadsheetReader($targetDirectory);
    $i = 0;
    foreach ($reader as $key => $row) {
        if ($i > 0) {
            if (!empty($row[0]) && !empty($row[1]) && !empty($row[2])) {
                $user_id = $_SESSION['user_data']->id;
                $checkStd = $std_model->checkStudentWhereSTDNumber($row[0], $user_id);
                $data_insert = [
                    "std_code" => $row[0],
                    "std_prename" => $row[1],
                    "std_name" => $row[2],
                    "std_gender" => $row[3],
                    "std_class" => $row[4],
                    "std_birthday" => $row[5],
                    "std_father_name" => $row[6],
                    "std_father_job" => $row[7],
                    "std_mather_name" => $row[8],
                    "std_mather_job" => $row[9],
                    "phone" => $row[10],
                    "address" => $row[11],
                    "user_create" => $user_id
                ];
                if (count($checkStd) > 0) {
                    $result = $std_model->InsertStudent($data_insert, $checkStd[0]->std_id);
                } else {
                    $result = $std_model->InsertStudent($data_insert);
                }
            }
        }
        $i++;
    }
    unlink($targetDirectory);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'นำเข้าข้อมูลนักศึกษาเรียบร้อย');
    } else {
        $response = array('status' => false, 'msg' => $result);
    }
    echo json_encode($response);
}

if (isset($_POST['getDataStudent'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $user_id = $_SESSION['user_data']->id;
    $stdClass = isset($_POST['std_class']) ? $_POST['std_class'] : "";
    $all = isset($_POST['all']) ? $_POST['all'] : false;
    $result = $std_model->getDataStudent($user_id, $stdClass, $all);

    $new_data = [];

    foreach ($result as $key => $value) {
        $password = $main_func->decryptData($value->password);
        $value->password = $password;
        array_push($new_data, $value);
    }
    $response = array('status' => true, 'data' => $new_data);
    echo json_encode($response);
}

if (isset($_POST['getDataStudentEstimate'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $user_id = $_SESSION['user_data']->id;
    $stdClass = isset($_POST['std_class']) ? $_POST['std_class'] : "";
    $year = isset($_POST['year']) ? $_POST['year'] : "";
    $all = isset($_POST['all']) ? $_POST['all'] : false;
    $result = $std_model->getDataStudentEstimate($user_id, $stdClass, $year, $all);

    $new_data = [];

    foreach ($result as $key => $value) {
        $password = $main_func->decryptData($value->password);
        $value->password = $password;
        array_push($new_data, $value);
    }
    $response = array('status' => true, 'data' => $new_data);
    echo json_encode($response);
}

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

if (isset($_POST['getEduOfStd'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $result = $std_model->getEduOfStd();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['delete_std'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $id = $_POST['id'];
    $mode = $_POST['mode'];
    $result = $std_model->deleteStd($id, $mode);
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
    $mode = $_POST['mode'];
    for ($i = 0; $i < count($arr_edu_id); $i++) {
        $result = $std_model->deleteStd($arr_edu_id[$i], $mode);
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

if (isset($_POST['change_multiple_std'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $arr_std = json_decode($_POST['arr_std']);
    $class_name = $_POST['class_name'];
    for ($i = 0; $i < count($arr_std); $i++) {
        $result = $std_model->changeStd($arr_std[$i]->std_id, $class_name);
        $result_is = $std_model->deleteStdChangeClass($arr_std[$i]->std_id);
    }
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'เลื่อนชั้นนักศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => $result, 'result_is' => $result_is);
    }

    echo json_encode($response);
}

if (isset($_POST['change_status_std'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $std_id = $_POST['std_id'];
    $status = $_POST['status'];

    $result = $std_model->changeStatusStd($std_id, $status);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'เปลี่ยนสถานะนักศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => $result, 'result_is' => $result_is);
    }

    echo json_encode($response);
}

if (isset($_POST['change_gender_std'])) {
    $response = "";
    $std_model = new Student_Model($DB);
    $std_id = $_POST['std_id'];
    $gender = $_POST['gender'];

    $result = $std_model->changeGenderStd($std_id, $gender);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ระบุเพศนักศึกษาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => $result, 'result_is' => $result_is);
    }

    echo json_encode($response);
}
