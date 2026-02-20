<?php
session_start();
include "../../config/class_database.php";
include '../models/form_visit_summary_model.php';
$DB = new Class_Database();

if (isset($_POST['getDataVisit'])) {
    try {
        $response = array();
        $visitModel = new VisitSummaryModel($DB);
        $result = $visitModel->getVisitData();
        $response = ['status' => true, 'data' => $result];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_POST['getDataVisitSum'])) {
    try {
        $response = array();
        $visitModel = new VisitSummaryModel($DB);
        if (isset($_POST['std_class_change'])) {
            if ($_POST['std_class_change'] != '0') {
                $result = $visitModel->getVisitDataSum($_POST['std_class_change']);
            } else {
                $result = $visitModel->getVisitDataSum();
            }
        } else {
            $result = $visitModel->getVisitDataSum();
        }
        $response = ['status' => true, 'data' =>  $result];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_POST['getStudentVisit'])) {
    try {
        $response = array();
        $visitModel = new VisitSummaryModel($DB);
        $result = $visitModel->getStudentVisitData();
        $response = ['status' => true, 'data' => $result];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}


// if (isset($_POST['addVisitData'])) {
//     try {
//         $response = [];
//         $summary_detail = json_decode($_POST['summary_detail']);
//         $year = htmlentities($_POST['year']);
//         $std_class = htmlentities($_POST['std_class']);
//         $sum_male = htmlentities($_POST['sum_male']);
//         $sum_female = htmlentities($_POST['sum_female']);
//         $visitModel = new VisitSummaryModel($DB);


//         $array = array(
//             'user_create' => $_SESSION['user_data']->id,
//             'year'=> $year,
//             'std_class' => $std_class,
//             'sum_male' => $sum_male,
//             'sum_female' => $sum_female
//         );
//         $visitsummary_id = $visitModel->addFormVisitSummary($array);
//         if ($visitsummary_id > 0) {
//             insertVisitConclude($summary_detail, $visitsummary_id, $visitModel);
//             $response = ['status' => true, 'msg' => ''];
//         } else {
//             $response = ['status' => false, 'msg' => $result];
//         }
//         echo json_encode($response);
//     } catch (PDOException $e) {
//         $e->getMessage();
//     }
// }

// function insertVisitConclude($summary_detail, $visitsummary_id, $visitModel)
// {



//     for ($i = 0; $i < count($summary_detail); $i++) {
//         $arr_data = [
//             "visitsummary_id" => $visitsummary_id,
//             "sub_title_id" => $summary_detail[$i]->sub_id,
//             "counts_d" => $summary_detail[$i]->counts_d,
//             "counts_per" => $summary_detail[$i]->counts_per,

//         ];
//         $visitModel->insertVisitConclude($arr_data);
//     }
// }

if (isset($_POST['addVisitData'])) {
    try {
        $response = [];
        $summary_checked = json_decode($_POST['summary_checked']);
        $form_visit_id = json_decode($_POST['form_visit_id']);
        $visitModel = new VisitSummaryModel($DB);

        $array = array(
            'form_visit_id' => $form_visit_id,
            'user_create' => $_SESSION['user_data']->id
        );

        $visitsummary_id = $visitModel->addFormVisitSummary($array);
        if ($visitsummary_id > 0) {
            insertVisitConclude($summary_checked, $visitsummary_id, $visitModel);
            $visitModel->updateStatusVisit($form_visit_id);
            $response = ['status' => true, 'msg' => ''];
        } else {
            $response = ['status' => false, 'msg' => $result];
        }
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function insertVisitConclude($summary_checked, $visitsummary_id, $visitModel)
{

    for ($i = 0; $i < count($summary_checked); $i++) {
        $arr_data = [
            "visitsummary_id" => $visitsummary_id,
            "sub_title_id" => $summary_checked[$i]->sub_title_id,
            "checked" => $summary_checked[$i]->checked,
        ];
        $visitModel->insertVisitConclude($arr_data);
    }
}


if (isset($_POST['EditVisitData'])) {
    try {
        $response = [];
        $summary_checked = json_decode($_POST['summary_checked']);

        $visitModel = new VisitSummaryModel($DB);
        for ($i = 0; $i < count($summary_checked); $i++) {
            $arr_data = [
                "sub_title_id" => $summary_checked[$i]->sub_title_id,
                "checked" => $summary_checked[$i]->checked,
                "form_v_sum_det_id" => $summary_checked[$i]->v_sum_det_id
            ];
            $visitModel->updateVisitConclude($arr_data);
        }
        $response = ['status' => true, 'msg' => ''];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_POST['getDataStudentPerEdit'])) {
    try {
        $response = [];
        $form_visit_id = json_decode($_POST['form_visit_id']);
        $visitModel = new VisitSummaryModel($DB);

        $visitsummary_id = $visitModel->getVisitSumData($form_visit_id);
        if (count($visitsummary_id) > 0) {
            $result = $visitModel->getFormVisitSummary($visitsummary_id[0]->form_v_sum_id);
            $visitModel->updateStatusVisit($form_visit_id);
            $response = ['status' => true, 'msg' => $result];
        } else {
            $response = ['status' => false, 'msg' => $result];
        }
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}


if (isset($_POST['getDataVisitAll'])) {
    try {
        $response = array();
        $visitModel = new VisitSummaryModel($DB);
        $result = $visitModel->getVisitAllData();
        $response = ['status' => true, 'data' => $result];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_REQUEST['getDataVisitAllBS'])) {
    try {
         $visitModel = new VisitSummaryModel($DB);
        $response = array();
        $result_total = $visitModel->getDataVisitAllBS();
        $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => (string)$result_total[3]];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}


if (isset($_POST['delete_visit'])) {
    try {
        $response = array();
        $id = $_POST['id'];
        $visitModel = new VisitSummaryModel($DB);
        $result = $visitModel->deleteVisit($id, $visitModel);
        if ($result != 0) {
            $response = ['status' => true, 'msg' => ''];
        } else {
            $response = ['status' => false, 'msg' => $result];
        }
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_POST['getClassInDropdown'])) {
    $response = array();
    $visitModel = new VisitSummaryModel($DB);
    $result = $visitModel->getClassInDropdown();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

// if (isset($_POST['getDataVisitSummaryByStdClass'])) {
//     $response = array();
//     $visitModel = new VisitSummaryModel($DB);
//     $std_class = htmlentities($_POST['std_class']);
//     $sub_district_id = htmlentities($_POST['sub_district_id']);
//     $result = $visitModel->getDataVisitSummaryByStdClass($std_class, $sub_district_id);
//     $response = array('status' => true, 'data' => $result);
//     echo json_encode($response);
// }

if (isset($_POST['getSubDistrict'])) {
    $response = array();
    $visitModel = new VisitSummaryModel($DB);
    $result = $visitModel->getSubDistrict();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['addVisitSum'])) {
    try {
        $response = [];
        $summary_detail = json_decode($_POST['summary_detail']);
        $std_class = $_POST['std_class'];
        $count_std = $_POST['count_std'];
        $year = $_POST['year'];

        $visitModel = new VisitSummaryModel($DB);

        $array = array(
            'std_class' => $std_class,
            'count_std' => $count_std,
            'year' => $year,
            'user_create' => $_SESSION['user_data']->id
        );

        $visitsum_id = $visitModel->addVisitSum($array);
        if ($visitsum_id  > 0) {
            for ($i = 0; $i < count($summary_detail); $i++) {
                $array = array(
                    'v_sum_id' => $visitsum_id,
                    'sub_title_id' => $summary_detail[$i]->sub_id,
                    'std_quantity' => $summary_detail[$i]->counts_d,
                    "percent_quantity" => $summary_detail[$i]->counts_per
                );
                $visitModel->insertVisitSumDetail($array);
            }
            $response = ['status' => true, 'msg' => 'บันทึกสำเร็จ'];
        } else {
            $response = ['status' => false, 'msg' => $visitsum_id];
        }
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}


if (isset($_POST['getDataVisitSummaryByStdClass'])) {
    $response = array();
    $visitModel = new VisitSummaryModel($DB);

    $std_class = htmlentities($_POST['std_class']);
    $pro_id = htmlentities($_POST['pro_id']);
    $dis_id = htmlentities($_POST['dis_id']);
    $sub_district_id = htmlentities($_POST['sub_district_id']);

    $result = $visitModel->getDataVisitSummaryByStdClass($std_class, $sub_district_id, $dis_id, $pro_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getDataVisitSummaryByAmphur'])) {
    $response = array();
    $visitModel = new VisitSummaryModel($DB);

    $std_class = htmlentities($_POST['std_class']);
    $pro_id = htmlentities($_POST['pro_id']);
    $dis_id = htmlentities($_POST['dis_id']);
    $sub_district_id = htmlentities($_POST['sub_district_id']);

    $result = $visitModel->getDataVisitSummaryByAmphure($std_class, $sub_district_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}
