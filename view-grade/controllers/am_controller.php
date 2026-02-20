<?php
session_start();
include "../../config/class_database.php";
include('../models/education_model.php');
include('../models/am_model.php');

$DB = new Class_Database();
$amModel = new Am_Model($DB);

function calculateYearMonthFromNow($date)
{
    // Convert the input date into a DateTime object
    $startDate = DateTime::createFromFormat('Y-m-d', $date);
    $currentDate = new DateTime(); // Current date

    if (!$startDate) {
        return false;
    }

    // Calculate the difference in years and months
    $interval = $startDate->diff($currentDate);
    $yearsDifference = $interval->y;
    $monthsDifference = $interval->m;

    // Format the current date to Thai Buddhist calendar
    $thaiYear = $currentDate->format('Y') + 543; // Add 543 to convert to Thai year
    $thaiDate = sprintf('%02d-%02d-%04d', $currentDate->format('d'), $currentDate->format('m'), $thaiYear);

    return [
        'years_difference' => $yearsDifference,
        'months_difference' => $monthsDifference,
        'thai_date' => $thaiDate,
    ];
}

if (isset($_POST['getDataUsers'])) {
    $response = array();
    $edu_id = $_POST['edu_id'];
    $result = $amModel->getDataUser($edu_id);
    $count = $amModel->countUsers($edu_id);
    $edu_all = $amModel->getEduUser();
    $response = ['status' => true, 'data' => $result, 'count' =>  $count, "edu_all" => $edu_all];
    echo json_encode($response);
}

if (isset($_POST['getDataTeacher'])) {
    $response = array();
    $result = $amModel->getDataTeacher();
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_POST['getDataTeacherWhere'])) {
    $response = array();
    $pro_id = $_POST['pro_id'];
    $dis_id = $_POST['dis_id'];
    $sub_id = $_POST['sub_id'];
    $result = $amModel->getDataTeacher($sub_id, $pro_id, $dis_id);
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_GET['getDataDashboard'])) {
    $result_total = $amModel->getDataDashboard();
    foreach ($result_total[2] as $key => $value) {
        // Ensure $value is an object or array and has 'start_work'
        if (isset($value->start_work)) {
            $result = calculateYearMonthFromNow($value->start_work);
            if ($result) {
                $value->start_work = $result['years_difference'] . " ปี " . $result['months_difference'] . " เดือน";
            }
        }
    }
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}

if (isset($_GET['getDataDashboardKru'])) {
    $result_total = $amModel->getDataDashboardKru();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}
