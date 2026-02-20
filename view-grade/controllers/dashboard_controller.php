<?php
session_start();
include "../../config/class_database.php";
include "../models/dashboard_model.php";

$DB = new Class_Database();
$dashModel = new Dashboard_Model($DB);

if (isset($_REQUEST['getDataCount'])) {
    $response = array();

    if ($_SESSION['user_data']->role_id == 2) {
        $_REQUEST['district_id'] = $_SESSION['user_data']->district_am_id;
    }
    if ($_SESSION['user_data']->role_id == 6) {
        $_REQUEST['province_id'] = $_SESSION['user_data']->province_am_id;
    }
    $result = $dashModel->getDataCountAll();
    $response = ['result' => $result[0], 'sql' => $result[1]];
    echo json_encode($response);
}

if (isset($_REQUEST['getDataSubDistrict'])) {
    $response = array();

    $district_id = $_SESSION['user_data']->district_am_id;

    $result = $dashModel->getDataSubDistrict($district_id);
}

if (isset($_REQUEST['getDataDashbord'])) {
    if ($_SESSION['user_data']->role_id == 2) {
        $_REQUEST['province_id'] = $_SESSION['user_data']->province_am_id;
        $_REQUEST['district_id'] = $_SESSION['user_data']->district_am_id;
    }

    if ($_SESSION['user_data']->role_id == 6) {
        $_REQUEST['province_id'] = $_SESSION['user_data']->province_am_id;
    }

    $_REQUEST['dhByTerm'] = true;

    $getDataCountAll = $dashModel->getDataCountAll();
    $getCountSTDAll = $dashModel->getCountSTDAll();

    $newGetCountGender = processGenderData($getCountSTDAll['std_gender']);
    $newCountTestResGender = processGenderData($getCountSTDAll['test_result_gender']);
    $newCountGradiateResGender = processGenderData($getCountSTDAll['gradiate_gender']);
    $newCountFinishResGender = processGenderData($getCountSTDAll['finish_gender']);

    $ListReturnData = [
        "SummaryCount" => $getDataCountAll[0],
        "CountGender" => $newGetCountGender,
        "CountAge" => $getCountSTDAll['std_age'],
        "CountTestResGender" => $newCountTestResGender,
        "CountTestResAge" => $getCountSTDAll['test_result_age'],
        "CountGradiateResGender" => $newCountGradiateResGender,
        "CountGradiateResAge" => $getCountSTDAll['gradiate_age'],
        "CountFinishResGender" => $newCountFinishResGender,
        "CountFinishResAge" => $getCountSTDAll['finish_age']
    ];

    echo json_encode($ListReturnData);
}

function processGenderData($data)
{
    $mergedData = [];
    $totalAllGenderMale = 0;
    $totalAllGenderFemale = 0;
    $totalAllUnknownGender = 0;

    foreach ($data as $item) {
        $class = $item->std_class;
        $gender = $item->std_gender;

        if (!isset($mergedData[$class])) {
            $mergedData[$class] = (object) [
                'std_class' => $class,
                'genders' => []
            ];
        }

        if ($gender == 'ชาย') {
            $gender = "male";
            $totalAllGenderMale += $item->total_students;
        } elseif ($gender == 'หญิง') {
            $gender = "female";
            $totalAllGenderFemale += $item->total_students;
        } else {
            $gender = "gender_unknown";
            $totalAllUnknownGender += $item->total_students;
        }

        if (!isset($mergedData[$class]->genders[$gender])) {
            $mergedData[$class]->genders[$gender] = 0;
        }
        $mergedData[$class]->genders[$gender] += $item->total_students;
    }

    $mergedData = array_values($mergedData);

    $result = formatClassGenderData($mergedData, $totalAllGenderMale, $totalAllGenderFemale, $totalAllUnknownGender);

    return $result;
}

function formatClassGenderData(array $mergedData, $totalAllGenderMale, $totalAllGenderFemale, $totalAllUnknownGender)
{
    $verifyClassNotEmpty = ["ประถม", "ม.ต้น", "ม.ปลาย", "ทั้งหมด"];

    // Create a map from std_class to data
    $indexedResult = [];
    foreach ($mergedData as $item) {
        if (isset($item->std_class)) {
            $indexedResult[$item->std_class] = $item;
        }
    }

    // Add the "ทั้งหมด" entry if there is any data
    if (!empty($mergedData)) {
        $indexedResult["ทั้งหมด"] = [
            'std_class' => "ทั้งหมด",
            'genders' => [
                "male" => $totalAllGenderMale,
                "female" => $totalAllGenderFemale,
                "gender_unknown" => $totalAllUnknownGender
            ]
        ];
    }

    // Build result in correct order
    $result = [];
    foreach ($verifyClassNotEmpty as $class) {
        if (isset($indexedResult[$class])) {
            $result[] = $indexedResult[$class];
        } else {
            $result[] = [
                'std_class' => $class,
                'genders' => [
                    "male" => 0,
                    "female" => 0,
                    "gender_unknown" => 0
                ]
            ];
        }
    }

    return $result;
}

function reformatAgeDataWithDefault(array $data): array
{
    $expectedClasses = ["ประถม", "ม.ต้น", "ม.ปลาย", "รวมทั้งหมด"];
    $ageKeys = ['age_61_79', 'age_45_60', 'age_29_44', 'age_13_28', 'age_unknown'];

    // Re-index data by std_class
    $classMap = [];
    foreach ($data as $item) {
        $classMap[$item->std_class] = $item;
    }

    $result = [];
    foreach ($expectedClasses as $class) {
        if (isset($classMap[$class])) {
            $item = $classMap[$class];
        } else {
            // Add empty entry if not present
            $item = ['std_class' => $class];
            foreach ($ageKeys as $key) {
                $item[$key] = 0;
            }
        }
        // Reformat to desired structure
        $formatted = [
            'std_class' => is_object($item) ? $item->std_class : $item['std_class'],
            'ages' => []
        ];
        foreach ($ageKeys as $key) {
            $formatted['ages'][$key] = isset($item->$key) ? (int)$item->$key : 0;
        }

        $result[] = $formatted;
    }

    return $result;
}
