<?php

session_start();
include "../../config/class_database.php";
include "../models/form_student_person_model.php";
include('../models/student_model.php');
// include "../../config/main_function.php";

$DB = new Class_Database();
$main_func = new ClassMainFunctions();

if (isset($_POST['addStudentPerson'])) {
    $response = array();
    $form_student_personModel = new FormStudentPersonmodel($DB);
    $std_id = htmlentities($_POST['std_id']);
    $std_type = htmlentities($_POST['std_type']);
    $num_siblings = htmlentities($_POST['num_siblings']);
    $num_younger = htmlentities($_POST['num_younger']);
    $num_son = htmlentities($_POST['num_son']);
    $relation = htmlentities($_POST['relation']);
    $live_present = htmlentities($_POST['live_present']);
    $feel_me = htmlentities($_POST['feel_me']);
    $best_friend_name = htmlentities($_POST['best_friend_name']);
    $want_around_people = htmlentities($_POST['want_around_people']);
    $afraid_others = htmlentities($_POST['afraid_others']);
    $life_myseft = htmlentities($_POST['life_myseft']);
    $not_life_myseft = htmlentities($_POST['not_life_myseft']);
    $want_improve = htmlentities($_POST['want_improve']);
    $pride = htmlentities($_POST['pride']);
    $impressive_event = htmlentities($_POST['impressive_event']);
    $uneasy = htmlentities($_POST['uneasy']);
    $person_discuss_problems = htmlentities($_POST['person_discuss_problems']);
    $activity = htmlentities($_POST['activity']);
    $money_per_day = htmlentities($_POST['money_per_day']);
    $use_money_per_day = htmlentities($_POST['use_money_per_day']);
    $action_regret = htmlentities($_POST['action_regret']);
    $feel_for_school_and_teacher = htmlentities($_POST['feel_for_school_and_teacher']);
    $gpa = htmlentities($_POST['gpa']);
    $favorite_subject = htmlentities($_POST['favorite_subject']);
    $not_favorite_subject = htmlentities($_POST['not_favorite_subject']);
    $reason_not_favorite_subject = htmlentities($_POST['reason_not_favorite_subject']);
    $health_problems = htmlentities($_POST['health_problems']);


    $arr_data = array(
        "std_id" => $std_id,
        "std_type" => $std_type,
        "num_siblings" => $num_siblings,
        "num_younger" => $num_younger,
        "num_son" => $num_son,
        "relation" => $relation,
        "live_present" => $live_present,
        "feel_me" => $feel_me,
        "best_friend_name" => $best_friend_name,
        "want_around_people" => $want_around_people,
        "afraid_others" => $afraid_others,
        "life_myseft" => $life_myseft,
        "not_life_myseft" => $not_life_myseft,
        "want_improve" => $want_improve,
        "pride" => $pride,
        "impressive_event" => $impressive_event,
        "uneasy" => $uneasy,
        "person_discuss_problems" => $person_discuss_problems,
        "activity" => $activity,
        "money_per_day" => $money_per_day,
        "use_money_per_day" => $use_money_per_day,
        "action_regret" => $action_regret,
        "feel_for_school_and_teacher" => $feel_for_school_and_teacher,
        "gpa" => $gpa,
        "favorite_subject" => $favorite_subject,
        "not_favorite_subject" => $not_favorite_subject,
        "reason_not_favorite_subject" => $reason_not_favorite_subject,
        "health_problems" => $health_problems,
        "user_id" => $_SESSION['user_data']->id
    );

    $result = $form_student_personModel->addStudent_Person($arr_data);

    if ($result == 1) {
        $response = ['status' => true, 'msg' => ''];
    } else {
        $response = ['status' => false, 'msg' => $result];
    }

    echo json_encode($response);
}


if (isset($_POST['editStudentPerson'])) {
    $response = array();
    $form_student_personModel = new FormStudentPersonmodel($DB);
    $std_p_id = htmlentities($_POST['std_p_id']);
    $num_siblings = htmlentities($_POST['num_siblings']);
    $num_younger = htmlentities($_POST['num_younger']);
    $num_son = htmlentities($_POST['num_son']);
    $relation = htmlentities($_POST['relation']);
    $live_present = htmlentities($_POST['live_present']);
    $feel_me = htmlentities($_POST['feel_me']);
    $best_friend_name = htmlentities($_POST['best_friend_name']);
    $want_around_people = htmlentities($_POST['want_around_people']);
    $afraid_others = htmlentities($_POST['afraid_others']);
    $life_myseft = htmlentities($_POST['life_myseft']);
    $not_life_myseft = htmlentities($_POST['not_life_myseft']);
    $want_improve = htmlentities($_POST['want_improve']);
    $pride = htmlentities($_POST['pride']);
    $impressive_event = htmlentities($_POST['impressive_event']);
    $uneasy = htmlentities($_POST['uneasy']);
    $person_discuss_problems = htmlentities($_POST['person_discuss_problems']);
    $activity = htmlentities($_POST['activity']);
    $money_per_day = htmlentities($_POST['money_per_day']);
    $use_money_per_day = htmlentities($_POST['use_money_per_day']);
    $action_regret = htmlentities($_POST['action_regret']);
    $feel_for_school_and_teacher = htmlentities($_POST['feel_for_school_and_teacher']);
    $gpa = htmlentities($_POST['gpa']);
    $favorite_subject = htmlentities($_POST['favorite_subject']);
    $not_favorite_subject = htmlentities($_POST['not_favorite_subject']);
    $reason_not_favorite_subject = htmlentities($_POST['reason_not_favorite_subject']);
    $health_problems = htmlentities($_POST['health_problems']);


    $arr_data = array(
        "num_siblings" => $num_siblings,
        "num_younger" => $num_younger,
        "num_son" => $num_son,
        "relation" => $relation,
        "live_present" => $live_present,
        "feel_me" => $feel_me,
        "best_friend_name" => $best_friend_name,
        "want_around_people" => $want_around_people,
        "afraid_others" => $afraid_others,
        "life_myseft" => $life_myseft,
        "not_life_myseft" => $not_life_myseft,
        "want_improve" => $want_improve,
        "pride" => $pride,
        "impressive_event" => $impressive_event,
        "uneasy" => $uneasy,
        "person_discuss_problems" => $person_discuss_problems,
        "activity" => $activity,
        "money_per_day" => $money_per_day,
        "use_money_per_day" => $use_money_per_day,
        "action_regret" => $action_regret,
        "feel_for_school_and_teacher" => $feel_for_school_and_teacher,
        "gpa" => $gpa,
        "favorite_subject" => $favorite_subject,
        "not_favorite_subject" => $not_favorite_subject,
        "reason_not_favorite_subject" => $reason_not_favorite_subject,
        "health_problems" => $health_problems,
        "std_p_id" => $std_p_id,
    );

    $result = $form_student_personModel->editStudent_Person($arr_data);

    if ($result == 1) {
        $response = ['status' => true, 'msg' => ''];
    } else {
        $response = ['status' => false, 'msg' => $result];
    }

    echo json_encode($response);
}

if (isset($_POST['getDataStudentPerEdit'])) {
    $response = array();
    $form_student_personModel = new FormStudentPersonmodel($DB);
    $id = htmlentities($_POST['id']);
    $result = $form_student_personModel->getDataStudentPerEdit($id);
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_POST['getStudentPerson'])) {
    try {
        $response = array();
        $form_student_personModel = new FormStudentPersonmodel($DB);
        $result = $form_student_personModel->getStudentPerson();
        $response = ['status' => true, 'data' => $result[0], "sql" => $result[1]];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_REQUEST['getStudentPersonBS'])) {
    try {
        $form_student_personModel = new FormStudentPersonmodel($DB);
        $response = array();
        $result_total = $form_student_personModel->getStudentPersonBS();
        $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => (string)$result_total[3]];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_POST['delete_student'])) {
    $response = array();
    $form_student_personModel = new FormStudentPersonmodel($DB);
    $id = htmlentities($_POST['id']);
    $resultDelete = $form_student_personModel->deleteFormStudentPreson($id);
    if ($resultDelete == 1) {
        $response = ['status' => true, 'msg' => ''];
    } else {
        $response = ['status' => false, 'msg' => $resultDelete];
    }
    echo json_encode($response);
}

if (isset($_POST['getClassInDropdown'])) {
    $response = array();
    $form_student_personModel = new FormStudentPersonmodel($DB);
    $result = $form_student_personModel->getClassInDropdown();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getSubDistrict'])) {
    $response = array();
    $form_student_personModel = new FormStudentPersonmodel($DB);
    $result = $form_student_personModel->getSubDistrict();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

// if (isset($_POST['getStudentPersonByClass'])) {
//     $response = array();
//     $form_student_personModel = new FormStudentPersonmodel($DB);
//     $std_class = htmlentities($_POST['std_class']);
//     $sub_district_id = htmlentities($_POST['sub_district_id']);
//     $result = $form_student_personModel->getDataStudentPersonByClass($std_class, $sub_district_id);
//     $response = array('status' => true, 'data' => $result);
//     echo json_encode($response);
// }


if (isset($_POST['getStudentPersonByWhere'])) {
    $response = array();
    $form_student_personModel = new FormStudentPersonmodel($DB);

    $std_class = htmlentities($_POST['std_class']);
    $pro_id = htmlentities($_POST['pro_id']);
    $dis_id = htmlentities($_POST['dis_id']);
    $sub_district_id = htmlentities($_POST['sub_district_id']);

    $result = $form_student_personModel->getDataStudentPersonByClass($std_class, $sub_district_id, $dis_id, $pro_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getStudentPersonByAmphur'])) {
    $response = array();
    $form_student_personModel = new FormStudentPersonmodel($DB);

    $std_class = htmlentities($_POST['std_class']);
    $pro_id = htmlentities($_POST['pro_id']);
    $dis_id = htmlentities($_POST['dis_id']);
    $sub_district_id = htmlentities($_POST['sub_district_id']);

    $result = $form_student_personModel->getStudentPersonByAmphur($std_class, $sub_district_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['add_std_data_new'])) {
    $response = "";
    $form_student_personModel = new FormStudentPersonmodel($DB);
    $list_program = isset($_POST['program']) ? $_POST['program'] : [];
    unset($_POST['program']);
    unset($_POST['add_std_data_new']);
    unset($_POST['age_show']);

    $f_name = $_POST['father_name'];
    $f_job = $_POST['father_job'];
    $m_name = $_POST['mather_name'];
    $m_job = $_POST['mather_job'];

    $m_phone = $_POST['mather_phone'];
    $f_phone = $_POST['father_phone'];

    unset($_POST['father_name']);
    unset($_POST['father_job']);
    unset($_POST['mather_name']);
    unset($_POST['mather_job']);
    unset($_POST['mather_phone']);
    unset($_POST['father_phone']);

    if (isset($_POST['reason_learning_format']) && $_POST['reason_learning_format'] == 6) {
        $_POST['reason_learning_format_other_text'] = $_POST['reason_learning_format_other_text'];
    }
    $_POST['user_create'] = $_SESSION['user_data']->role_id == 3 ? $_SESSION['user_data']->id : $_SESSION['user_data']->user_create;
    $result = $form_student_personModel->insertNew($_POST, "insert");
    if ($result > 0) {
        $newArray = [
            'word' => 0,
            'power_point' => 0,
            'excel' => 0,
            'photoshop' => 0,
            'std_per_id' => $result,
        ];

        foreach ($newArray as $key => $value) {
            if (isset($list_program[$key])) {
                $newArray[$key] = $list_program[$key];
            }
        }
        $result = $form_student_personModel->insertProgram($newArray);
        if ($result == 1) {
            $fm_data = [
                "father_name" => $f_name,
                "mather_name" => $m_name,
                "father_job" => $f_job,
                "mather_job" => $m_job,
                "father_phone" => $main_func->encryptData($f_phone),
                "mather_phone" => $main_func->encryptData($m_phone),
                "std_id" => $_POST['std_id']
            ];
            $form_student_personModel->updateFMname($fm_data);
            $response = ['status' => true, 'msg' => 'บันทึกข้อมูลนักศึกษาสำเร็จ'];
        } else {
            $response = ['status' => false, 'msg' => $result];
        }
    } else {
        $response = ['status' => false, 'msg' => $result];
    }
    echo json_encode($response);
}

if (isset($_POST['edit_std_data_new'])) {
    $response = "";
    $form_student_personModel = new FormStudentPersonmodel($DB);
    $list_program = isset($_POST['program']) ? $_POST['program'] : [];
    unset($_POST['program']);
    unset($_POST['edit_std_data_new']);

    $f_name = $_POST['father_name'];
    $f_job = $_POST['father_job'];
    $m_name = $_POST['mather_name'];
    $m_job = $_POST['mather_job'];

    $m_phone = $_POST['mather_phone'];
    $f_phone = $_POST['father_phone'];

    $std_id = $_POST['std_id'];

    unset($_POST['father_name']);
    unset($_POST['father_job']);
    unset($_POST['mather_name']);
    unset($_POST['mather_job']);

    unset($_POST['mather_phone']);
    unset($_POST['father_phone']);
    unset($_POST['std_id']);

    if (isset($_POST['reason_learning_format']) && $_POST['reason_learning_format'] == 6) {
        $_POST['reason_learning_format_other_text'] = $_POST['reason_learning_format_other_text'];
    }
    $result = $form_student_personModel->insertNew($_POST, "update");
    if ($result > 0) {
        $newArray = [
            'word' => 0,
            'power_point' => 0,
            'excel' => 0,
            'photoshop' => 0,
            'std_per_id' => $_POST['std_per_id'],
        ];

        foreach ($newArray as $key => $value) {
            if (isset($list_program[$key])) {
                $newArray[$key] = $list_program[$key];
            }
        }
        $result = $form_student_personModel->insertProgram($newArray, "update");
        if ($result == 1) {
            $fm_data = [
                "father_name" => $f_name,
                "mather_name" => $m_name,
                "father_job" => $f_job,
                "mather_job" => $m_job,
                "father_phone" => $main_func->encryptData($f_phone),
                "mather_phone" => $main_func->encryptData($m_phone),
                "std_id" => $std_id
            ];
            $form_student_personModel->updateFMname($fm_data);
            $response = ['status' => true, 'msg' => 'แก้ไขข้อมูลนักศึกษาสำเร็จ'];
        } else {
            $response = ['status' => false, 'msg' => $result];
        }
    } else {
    }
    echo json_encode($response);
}

if (isset($_POST['learn_analysis_mode'])) {
    $form_student_personModel = new FormStudentPersonmodel($DB);
    $response = "";

    $objectPost = $_POST['objectPost'];
    $std_per_id = $objectPost['std_per_id'];
    $note = $objectPost['note'];
    $side_1 = $objectPost['side_1'];

    $side_2 = $objectPost['side_2'];
    $side_3 = $objectPost['side_3'];
    $side_4 = $objectPost['side_4'];
    $side_5 = $objectPost['side_5'];
    $learn_analys_id_send = isset($_POST['learn_analys_id']) ? $_POST['learn_analys_id'] : 0;

    $arr_lear = ["std_per_id" => $std_per_id, "note" => $note];
    $msg = 'บันทึกวิเคราะห์นักศึกษาสำเร็จ';
    if ($_POST['learn_analysis_mode'] == "update") {
        $arr_lear['learn_analys_id'] = $learn_analys_id_send;
        $msg = 'แก้ไขวิเคราะห์นักศึกษาสำเร็จ';
    }

    $learn_analys_id = $form_student_personModel->insertLearnAnalysis($arr_lear, $_POST['learn_analysis_mode']);
    if ($learn_analys_id > 0) {

        $side_1['learn_analys_id'] =  $_POST['learn_analysis_mode'] == "insert" ? $learn_analys_id :  $learn_analys_id_send;
        $side_2['learn_analys_id'] =  $_POST['learn_analysis_mode'] == "insert" ? $learn_analys_id :  $learn_analys_id_send;
        $side_3['learn_analys_id'] =  $_POST['learn_analysis_mode'] == "insert" ? $learn_analys_id :  $learn_analys_id_send;
        $side_4['learn_analys_id'] =  $_POST['learn_analysis_mode'] == "insert" ? $learn_analys_id :  $learn_analys_id_send;
        $side_5['learn_analys_id'] =  $_POST['learn_analysis_mode'] == "insert" ? $learn_analys_id :  $learn_analys_id_send;

        $form_student_personModel->insertLearnAnalysisSide(1, $side_1, $_POST['learn_analysis_mode']);
        $form_student_personModel->insertLearnAnalysisSide(2, $side_2, $_POST['learn_analysis_mode']);
        $form_student_personModel->insertLearnAnalysisSide(3, $side_3, $_POST['learn_analysis_mode']);
        $form_student_personModel->insertLearnAnalysisSide(4, $side_4, $_POST['learn_analysis_mode']);
        $form_student_personModel->insertLearnAnalysisSide(5, $side_5, $_POST['learn_analysis_mode']);

        $response = ['status' => true, 'msg' => $msg];
    } else {
        $response = ['status' => false, 'msg' => $learn_analys_id];
    }
    echo json_encode($response);
}
