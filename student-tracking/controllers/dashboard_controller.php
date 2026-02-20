<?php
session_start();
include "../../config/class_database.php";
include('../models/dashboard_model.php');
$DB = new Class_Database();

if (isset($_POST['getdatacount'])) {
    $response = array();
    $dashboard_model = new dashboard_Model($DB);

    $result_count_std = $dashboard_model->getdatacount();
    $response = array('status' => true, 'data' => $result_count_std);
    echo json_encode($response);
}

function reformatArray($data)
{
    $formattedData = [];

    foreach ($data as $item) {
        foreach ($item as $key => $value) {
            $formattedData[$key] = $value;
        }
    }

    return $formattedData;
}

if (isset($_POST['getdatacountDashboard'])) {
    $response = array();
    $dashboard_model = new dashboard_Model($DB);

    $result_count_std = $dashboard_model->getdatacount();
    $result_count_std = reformatArray($result_count_std);

    $newArray = [
        [
            "std_class" => "ประถม",
            "male" => $result_count_std["std_gender1"],
            "female" => $result_count_std["std_gender4"],
            "break" => $result_count_std["pratom_break"],
            "finish" => $result_count_std["pratom_finish"],
            "sum" =>  $result_count_std["std_gender1"] + $result_count_std["std_gender4"] //+ $result_count_std["pratom_break"] + $result_count_std["pratom_finish"]
        ],
        [
            "std_class" => "ม.ต้น",
            "male" => $result_count_std["std_gender2"],
            "female" => $result_count_std["std_gender5"],
            "break" => $result_count_std["mt_break"],
            "finish" => $result_count_std["mt_finish"],
            "sum" =>  $result_count_std["std_gender2"] + $result_count_std["std_gender5"] //+ $result_count_std["mt_break"] + $result_count_std["mt_finish"]
        ],
        [
            "std_class" => "ม.ปลาย",
            "male" => $result_count_std["std_gender3"],
            "female" => $result_count_std["std_gender6"],
            "break" => $result_count_std["mp_break"],
            "finish" => $result_count_std["mp_finish"],
            "sum" =>  $result_count_std["std_gender3"] + $result_count_std["std_gender6"] //+ $result_count_std["mp_break"] + $result_count_std["mp_finish"]
        ],
    ];

    $newArray[] = [
        "std_class" => "รวม",
        "male" => $result_count_std["std_gender1"] + $result_count_std["std_gender2"] +  $result_count_std["std_gender3"],
        "female" =>  $result_count_std["std_gender4"] + $result_count_std["std_gender5"] +  $result_count_std["std_gender6"],
        "break" => $result_count_std["pratom_break"] + $result_count_std["mt_break"] + $result_count_std["mp_break"],
        "finish" => $result_count_std["pratom_finish"] + $result_count_std["mt_finish"] + $result_count_std["mp_finish"],
        "sum" =>  $newArray[0]["sum"] + $newArray[1]["sum"] + $newArray[2]["sum"]
    ];

    $response = array('status' => true, 'data' => $newArray);
    echo json_encode($response);
}

if (isset($_POST['getdatacountAdmin'])) {
    $response = array();
    $dashboard_model = new dashboard_Model($DB);
    $province_id = $_POST['province_id'];
    $district_id = $_POST['district_id'];
    $sub_district_id = $_POST['sub_district_id'];
    $teacherId = $_POST['teacherId'];
    // echo "controller => " . $dashboard_model->getUserCreateForCount('std');
    $result_count_std = $dashboard_model->getdatacountAdmin($province_id, $district_id, $sub_district_id, $teacherId);
    $response = array('status' => true, 'data' => $result_count_std);
    echo json_encode($response);
}

if (isset($_POST['getDistrictDataAmphur'])) {
    $dashboard_model = new dashboard_Model($DB);
    $result = $dashboard_model->getDistrictDataAmphur();
    $result = json_decode($result);
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_POST['getdatacountAmphur'])) {
    $response = array();
    $dashboard_model = new dashboard_Model($DB);
    $district_id = $_POST['district_id'];
    $sub_district_id = $_POST['sub_district_id'];
    $teacherId = $_POST['teacherId'];
    $result_count_std = $dashboard_model->getdatacountAdmin("", $district_id, $sub_district_id, $teacherId, "amphur");
    $response = array('status' => true, 'data' => $result_count_std);
    echo json_encode($response);
}

if (isset($_POST['getdatacountAmphurDashboard'])) {
    $response = [];
    $dashboard_model = new dashboard_Model($DB);
    $district_id = filter_var($_POST['district_id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch subdistrict data
    $sqlSubDis = "SELECT id, name_th FROM tbl_sub_district WHERE district_id = :district_id";
    $ListSubDis = json_decode($DB->Query($sqlSubDis, ["district_id" => $district_id]));

    // Initialize summary variables
    $totals = [
        'pratom_male' => 0,
        'pratom_female' => 0,
        'pratom_break' => 0,
        'pratom_finish' => 0,
        'pratom_sum' => 0,
        'mt_male' => 0,
        'mt_female' => 0,
        'mt_break' => 0,
        'mt_finish' => 0,
        'mt_sum' => 0,
        'mp_male' => 0,
        'mp_female' => 0,
        'mp_break' => 0,
        'mp_finish' => 0,
        'mp_sum' => 0,
        'sumall' => 0
    ];

    $arrayReturn = [];
    foreach ($ListSubDis as $key => $subDis) {

        $subId = $subDis->id;
        $subName = $subDis->name_th;

        $sqlList = "SELECT * FROM tbl_non_education WHERE sub_district_id = :sub_district_id";
        $ListEdu = json_decode($DB->Query($sqlList, ["sub_district_id" => $subId]));

        $total = [];
        $total['kru'] = "รวม";

        foreach ($ListEdu as $index => $edu) {
            $newData = [];

            if (is_object($edu) && property_exists($edu, 'name')) {
                $eduName = $edu->name;

                // Fetch user data
                $sqlUsers = "SELECT id, CONCAT(`name`, ' ', surname) kru_name FROM tb_users WHERE edu_id = :edu_id";
                $dataUsers = json_decode($DB->Query($sqlUsers, ["edu_id" => $edu->id]));
                $userId = $dataUsers[0]->id ?? 0;
                $newData['kru'] = $dataUsers[0]->kru_name . " - " . $eduName ?? "";

                // Fetch result counts
                $result_counts = $dashboard_model->getdatacountAdmin("", $district_id, $edu->sub_district_id, $userId, "amphur", true) ?? [];

                // Map the result counts to the new data array
                $fields = [
                    'pratom_male' => [0, 'std_gender1'],
                    'pratom_female' => [3, 'std_gender4'],
                    'mt_male' => [1, 'std_gender2'],
                    'mt_female' => [4, 'std_gender5'],
                    'mp_male' => [2, 'std_gender3'],
                    'mp_female' => [5, 'std_gender6'],
                ];

                foreach ($fields as $key => [$index, $field]) {
                    $newData[$key] = $result_counts[$index]->$field ?? 0;
                    $total[$key] += $newData[$key];
                    $totals[$key] += $newData[$key];
                }

                // Calculate sums
                $newData['pratom_sum'] = $newData['pratom_male'] + $newData['pratom_female']; //+ $newData['pratom_break'] + $newData['pratom_finish'];
                $newData['mt_sum'] = $newData['mt_male'] + $newData['mt_female']; //+ $newData['mt_break'] + $newData['mt_finish'];
                $newData['mp_sum'] = $newData['mp_male'] + $newData['mp_female']; //+ $newData['mp_break'] + $newData['mp_finish'];
                $newData['sumall'] = $newData['pratom_sum'] + $newData['mt_sum'] + $newData['mp_sum'];

                // Update total sums
                $total['pratom_sum'] += $newData['pratom_sum'];
                $total['mt_sum'] += $newData['mt_sum'];
                $total['mp_sum'] += $newData['mp_sum'];
                $total['sumall'] += $newData['sumall'];

                $totals['pratom_sum'] += $newData['pratom_sum'];
                $totals['mt_sum'] += $newData['mt_sum'];
                $totals['mp_sum'] += $newData['mp_sum'];
                $totals['sumall'] += $newData['sumall'];

                $groupedData[$subName][] = $newData;
            }
        }

        $groupedData[$subName][] = $total;
    }

    $arrayReturn = $groupedData;

    // Add the total row
    $totalArr = array_merge(['edu_name' => 'รวมทั้งหมด'], $totals);

    $response = ['status' => true, 'data' => $arrayReturn, 'total' => $totalArr];
    echo json_encode($response);
}


if (isset($_POST['getdatacountProvinceDashboard'])) {
    $response = [];
    $dashboard_model = new dashboard_Model($DB);
    $province_id = filter_var($_POST['province_id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch non-education data
    $sqlList = "SELECT * FROM tbl_district
    WHERE province_id = :province_id";
    $ListDistrict = json_decode($DB->Query($sqlList, ["province_id" => $province_id]));

    // Initialize summary variables
    $totals = [
        'pratom_male' => 0,
        'pratom_female' => 0,
        'pratom_break' => 0,
        'pratom_finish' => 0,
        'pratom_sum' => 0,
        'mt_male' => 0,
        'mt_female' => 0,
        'mt_break' => 0,
        'mt_finish' => 0,
        'mt_sum' => 0,
        'mp_male' => 0,
        'mp_female' => 0,
        'mp_break' => 0,
        'mp_finish' => 0,
        'mp_sum' => 0,
        'sumall' => 0
    ];

    $arrayReturn = [];

    foreach ($ListDistrict as $dis) {

        $newData = ['edu_name' => $dis->name_th];

        // Fetch result counts
        $result_counts = $dashboard_model->getdatacountAdmin("", $dis->id, 0, 0, "amphur", true) ?? [];

        // Map the result counts to the new data array
        $fields = [
            'pratom_male' => [0, 'std_gender1'],
            'pratom_female' => [3, 'std_gender4'],
            'mt_male' => [1, 'std_gender2'],
            'mt_female' => [4, 'std_gender5'],
            'mp_male' => [2, 'std_gender3'],
            'mp_female' => [5, 'std_gender6'],
            // 'pratom_break' => [6, 'pratom_break'],
            // 'pratom_finish' => [7, 'pratom_finish'],
            // 'mt_break' => [8, 'mt_break'],
            // 'mt_finish' => [9, 'mt_finish'],
            // 'mp_break' => [10, 'mp_break'],
            // 'mp_finish' => [11, 'mp_finish'],
        ];

        foreach ($fields as $key => [$index, $field]) {
            $newData[$key] = $result_counts[$index]->$field ?? 0;
            $totals[$key] += $newData[$key];
        }

        // Calculate sums
        $newData['pratom_sum'] = $newData['pratom_male'] + $newData['pratom_female']; //+ $newData['pratom_break'] + $newData['pratom_finish'];
        $newData['mt_sum'] = $newData['mt_male'] + $newData['mt_female']; // + $newData['mt_break'] + $newData['mt_finish'];
        $newData['mp_sum'] = $newData['mp_male'] + $newData['mp_female']; // + $newData['mp_break'] + $newData['mp_finish'];
        $newData['sumall'] = $newData['pratom_sum'] + $newData['mt_sum'] + $newData['mp_sum'];

        // Update total sums
        $totals['pratom_sum'] += $newData['pratom_sum'];
        $totals['mt_sum'] += $newData['mt_sum'];
        $totals['mp_sum'] += $newData['mp_sum'];
        $totals['sumall'] += $newData['sumall'];

        $arrayReturn[] = $newData;
    }

    // Add the total row
    $totalArr = array_merge(['edu_name' => 'รวม'], $totals);

    $response = ['status' => true, 'data' => $arrayReturn, "total" => $totalArr];
    echo json_encode($response);
}



if (isset($_POST['getDataListStdAmphurDashboard'])) {
    $dashboard_model = new dashboard_Model($DB);
    $district_id = filter_var($_POST['district_id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch subdistrict data
    $sqlSubDis = "SELECT id, name_th FROM tbl_sub_district WHERE district_id = :district_id";
    $ListSubDis = json_decode($DB->Query($sqlSubDis, ["district_id" => $district_id]));

    // Initialize total variables
    $totals = [
        'pratom_test_result' => 0,
        'pratom_gradiate' => 0,
        'pratom_std_finish' => 0,
        'mt_test_result' => 0,
        'mt_gradiate' => 0,
        'mt_std_finish' => 0,
        'mp_test_result' => 0,
        'mp_gradiate' => 0,
        'mp_std_finish' => 0,
        'sumall' => 0,
    ];

    $groupedData = [];
    $arrayReturn = [];
    // Process each education entry
    // $arrayReturn = array_map(function ($edu) use ($dashboard_model, $DB, $district_id, &$totals) {
    foreach ($ListSubDis as $key => $subDis) {

        $subId = $subDis->id;
        $subName = $subDis->name_th;

        // Fetch non-education data
        $sqlList = "SELECT * FROM tbl_non_education WHERE sub_district_id = :sub_district_id";
        $ListEdu = json_decode($DB->Query($sqlList, ["sub_district_id" => $subId]));

        $total = [];
        $total['edu_name'] = "รวม";

        foreach ($ListEdu as $index => $edu) {
            $newData = [];
            if (is_object($edu) && property_exists($edu, 'name')) {
                $eduName = $edu->name;

                if (!isset($groupedData[$eduName])) {
                    // Fetch user data
                    $sqlUsers = "SELECT id, CONCAT(`name`, ' ', surname) kru_name FROM tb_users WHERE edu_id = :edu_id";
                    $dataUsers = json_decode($DB->Query($sqlUsers, ["edu_id" => $edu->id]));
                    $userId = $dataUsers[0]->id ?? 0;
                    $result_counts = $dashboard_model->getDataListStd("", $district_id, $edu->sub_district_id, $userId, $_POST['term_id'], "amphur");

                    // Prepare the data for each education entry
                    $newData = [
                        'edu_name' => $dataUsers[0]->kru_name . " - " . $eduName ?? "",
                        'pratom_test_result' => $result_counts['test_result']['pratom'] ?? 0,
                        'pratom_gradiate' => $result_counts['gradiate']['pratom'] ?? 0,
                        'pratom_std_finish' => $result_counts['std_finish']['pratom'] ?? 0,
                        'mt_test_result' => $result_counts['test_result']['mt'] ?? 0,
                        'mt_gradiate' => $result_counts['gradiate']['mt'] ?? 0,
                        'mt_std_finish' => $result_counts['std_finish']['mt'] ?? 0,
                        'mp_test_result' => $result_counts['test_result']['mp'] ?? 0,
                        'mp_gradiate' => $result_counts['gradiate']['mp'] ?? 0,
                        'mp_std_finish' => $result_counts['std_finish']['mp'] ?? 0,
                        'sumall' => $result_counts['test_result']['pratom'] + $result_counts['gradiate']['pratom'] + $result_counts['std_finish']['pratom'] +
                            $result_counts['test_result']['mt'] + $result_counts['gradiate']['mt'] + $result_counts['std_finish']['mt'] +
                            $result_counts['test_result']['mp'] + $result_counts['gradiate']['mp'] + $result_counts['std_finish']['mp']
                    ];

                    // Accumulate totals
                    foreach ($totals as $key => $value) {
                        $totals[$key] += $newData[$key];
                        $total[$key] += $newData[$key];
                    }

                    $groupedData[$subName][] = $newData;
                }
            }
        }

        $groupedData[$subName][] = $total;
    }

    $arrayReturn = $groupedData;

    // Add total row
    $totalArr = array_merge(['edu_name' => 'รวมทั้งหมด'], $totals);

    echo json_encode(['status' => true, 'data' => $groupedData, 'total' => $totalArr]);
}



if (isset($_POST['getDataListStdProvinceDashboard'])) {
    $dashboard_model = new dashboard_Model($DB);
    $province_id = filter_var($_POST['province_id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch districts for the province
    $sqlList = "SELECT * FROM tbl_district WHERE province_id = :province_id";
    $ListDistrict = json_decode($DB->Query($sqlList, ["province_id" => $province_id]));

    // Initialize total variables
    $totals = [
        'pratom_test_result' => 0,
        'pratom_gradiate' => 0,
        'pratom_std_finish' => 0,
        'mt_test_result' => 0,
        'mt_gradiate' => 0,
        'mt_std_finish' => 0,
        'mp_test_result' => 0,
        'mp_gradiate' => 0,
        'mp_std_finish' => 0,
        'sumall' => 0,
    ];

    // Process each district entry
    $arrayReturn = array_map(function ($dis) use ($dashboard_model, &$totals) {
        $result_counts = $dashboard_model->getDataListStd("", $dis->id, "", "0", $_POST['term_id'], "amphur");

        // Prepare the data for each district
        $newData = [
            'edu_name' => $dis->name_th,
            'pratom_test_result' => $result_counts['test_result']['pratom'] ?? 0,
            'pratom_gradiate' => $result_counts['gradiate']['pratom'] ?? 0,
            'pratom_std_finish' => $result_counts['std_finish']['pratom'] ?? 0,
            'mt_test_result' => $result_counts['test_result']['mt'] ?? 0,
            'mt_gradiate' => $result_counts['gradiate']['mt'] ?? 0,
            'mt_std_finish' => $result_counts['std_finish']['mt'] ?? 0,
            'mp_test_result' => $result_counts['test_result']['mp'] ?? 0,
            'mp_gradiate' => $result_counts['gradiate']['mp'] ?? 0,
            'mp_std_finish' => $result_counts['std_finish']['mp'] ?? 0,
            'sumall' => $result_counts['test_result']['pratom'] + $result_counts['gradiate']['pratom'] + $result_counts['std_finish']['pratom'] +
                $result_counts['test_result']['mt'] + $result_counts['gradiate']['mt'] + $result_counts['std_finish']['mt'] +
                $result_counts['test_result']['mp'] + $result_counts['gradiate']['mp'] + $result_counts['std_finish']['mp']
        ];

        // Accumulate totals
        foreach ($totals as $key => $value) {
            $totals[$key] += $newData[$key];
        }

        return $newData;
    }, $ListDistrict);

    // Add total row
    $totalArr = array_merge(['edu_name' => 'รวม'], $totals);

    echo json_encode(['status' => true, 'data' => $arrayReturn, 'total' => $totalArr]);
}
