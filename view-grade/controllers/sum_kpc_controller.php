<?php
set_time_limit(0); // ปิดการจำกัดเวลาประมวลผล
ini_set('memory_limit', '1G'); // เพิ่มหน่วยความจำเป็น 1GB
ini_set('max_input_vars', '10000');

session_start();
include "../../config/class_database.php";

$DB = new Class_Database();

if (isset($_POST['add_data'])) {
    $sub_id = isset($_POST['sub_id']) ? $_POST['sub_id'] : '';
    $sub_code = ''; // $_POST['subject_code'];
    $sub_name = ''; //$_POST['subject_name'];
    $std_class = $_POST['std_class'];
    $term = $_SESSION['term_active']->term_id;

    if (!empty($sub_id)) {
        $sql = "UPDATE vg_sum_kpc SET sub_code = :sub_code, sub_name = :sub_name, term = :term WHERE sub_id = :sub_id";
        $DB->Update($sql, ["sub_code" => $sub_code, "sub_name" => $sub_name, "term" => $term, "sub_id" => $sub_id]);
    } else {
        $sql = "INSERT INTO vg_sum_kpc (sub_code, sub_name, std_class,term, user_create) VALUES (:sub_code, :sub_name,:std_class, :term, :user_create)";
        $sub_id = $DB->InsertLastID($sql, ["sub_code" => $sub_code, "sub_name" => $sub_name, "std_class" => $std_class, "term" => $term, "user_create" => $_SESSION['user_data']->id]);
    }

    $result = false;
    if ($sub_id > 0) {
        $dataColumnWorksheet = $_POST['dataColumnWorksheet'];
        foreach ($dataColumnWorksheet as $key => $column) {
            $work_id = $column['work_id'];
            if (empty($work_id)) {
                $sql = "INSERT INTO vg_sum_kpc_worksheet (sub_id, work_name, user_create) VALUES (:sub_id, :work_name, :user_create)";
                $work_id = $DB->InsertLastID($sql, ["sub_id" => $sub_id, "work_name" => $column['text'], "user_create" => $_SESSION['user_data']->id]);
            } else {
                $sql = "UPDATE vg_sum_kpc_worksheet SET work_name = :work_name WHERE work_id = :work_id";
                $DB->Update($sql, ["work_name" => $column['text'], "work_id" => $work_id]);
            }

            $dataStdList = $_POST['dataStdList'];
            foreach ($dataStdList[$key] as $std) {
                $inter_id = $std['inter_id'];
                if (!empty($inter_id)) {
                    $sql = "UPDATE vg_sum_kpc_students SET reason = :reason, score = :score, final_score = :final_score, total_score = :total_score, level = :level, sum_score = :sum_score WHERE inter_id = :inter_id";
                    $stdInsert = $DB->Update($sql, ["reason" => $std['reason'], "score" => $std['score'], "final_score" => $std['final_score'], "total_score" => $std['total_score'], "level" => $std['level'], "sum_score" => $std['sum_score'], "inter_id" => $inter_id]);
                } else {
                    $sql = "INSERT INTO vg_sum_kpc_students (std_id, reason, score, final_score, total_score, level, sum_score, work_id) VALUES (:std_id, :reason, :score, :final_score, :total_score, :level, :sum_score, :work_id)";
                    $stdInsert = $DB->Insert($sql, ["std_id" => $std['std_id'], "reason" => $std['reason'], "score" => $std['score'], "final_score" => $std['final_score'], "total_score" => $std['total_score'], "level" => $std['level'], "sum_score" => $std['sum_score'], "work_id" => $work_id]);
                }

                if ($stdInsert != 0) {
                    $result = true;
                    $sqlCredit = "SELECT * FROM vg_kpc WHERE term_id = :term_id AND std_id = :std_id";
                    $dataCredit = $DB->Query($sqlCredit, ["term_id" => $term, "std_id" => $std['std_id']]);
                    $dataCredit = json_decode($dataCredit);
                    if (count($dataCredit) > 0) {
                        $kpcId = $dataCredit[0]->kpc_id;
                        $hourNew = $std['sum_score'];

                        $sql = "UPDATE vg_kpc SET hour = :hourNew WHERE kpc_id = :kpc_id";
                        $DB->Update($sql, ["hourNew" => $hourNew, "kpc_id" => $kpcId]);
                        $result = true;
                    } else {
                        $sql = "INSERT INTO vg_kpc (std_id, std_class, term_id, hour, user_create) VALUES (:std_id, :std_class, :term_id, :hour, :user_create)";
                        $DB->Insert($sql, ["std_id" => $std['std_id'], "std_class" => $std_class, "term_id" => $term, "hour" => $std['sum_score'], "user_create" => $_SESSION['user_data']->id]);
                        $result = true;
                    }
                }
            }
        }
    }

    $storeDeleteInterId = isset($_POST['storeDeleteInterId']) ? $_POST['storeDeleteInterId'] : [];
    $storeDeleteWorkId = isset($_POST['storeDeleteWorkId']) ? $_POST['storeDeleteWorkId'] : [];
    $storeDeleteStdId = isset($_POST['storeDeleteStdId']) ? $_POST['storeDeleteStdId'] : [];

    if (count($storeDeleteInterId) > 0) {
        for ($i = 0; $i < count($storeDeleteInterId); $i++) {
            $sql = "DELETE FROM vg_sum_kpc_students WHERE inter_id = :inter_id";
            $DB->Delete($sql, ["inter_id" => $storeDeleteInterId[$i]]);
        }
    }

    if (count($storeDeleteWorkId) > 0) {
        for ($i = 0; $i < count($storeDeleteWorkId); $i++) {
            $sql = "DELETE FROM vg_sum_kpc_worksheet WHERE work_id = :work_id";
            $DB->Delete($sql, ["work_id" => $storeDeleteWorkId[$i]]);
        }
    }

    if (count($storeDeleteStdId) > 0) {
        for ($i = 0; $i < count($storeDeleteStdId); $i++) {
            $sql = "DELETE FROM vg_sum_kpc_students WHERE std_id = :std_id";
            $DB->Delete($sql, ["std_id" => $storeDeleteStdId[$i]]);
        }
    }
    if ($result) {
        $response = ['status' => true, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
    } else {
        $response = ['status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่'];
    }

    echo json_encode($response);
}

if (isset($_GET['getSumScore'])) {

    $std_class = "";
    if (isset($_GET['std_class']) && !empty($_GET['std_class'])) {
        $std_class = " AND std_class = '" . $_GET['std_class'] . "' ";
    }

    $sql_order = "SELECT count(*) totalnotfilter FROM vg_sum_kpc ss WHERE ss.user_create = :user_create $std_class";
    $totalnotfilter = $DB->Query($sql_order, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
    //จบการนับจำนวนทั้งหมด

    //นับจำนวนที่มีการ filter
    $sql = "SELECT ss.*, CONCAT(t.term, '/' , t.year) term_name FROM vg_sum_kpc ss 
    INNER JOIN vg_terms t ON ss.term = t.term_id
    WHERE ss.user_create = :user_create $std_class GROUP BY ss.sub_id ORDER BY ss.term ASC,ss.std_class ASC";
    $total_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter];
    echo json_encode($response);
}

if (isset($_POST['deleteSumScrore'])) {
    $response = array();
    $sub_id = $_POST['sub_id'];

    $sql = "DELETE FROM vg_sum_kpc WHERE sub_id = :sub_id";
    $result = $DB->Delete($sql, ["sub_id" => $sub_id]);

    $sql = "SELECT * FROM vg_sum_kpc_worksheet WHERE sub_id = :sub_id";
    $total_result = $DB->Query($sql, ["sub_id" => $sub_id]);
    $result = json_decode($total_result);

    foreach ($result as $key => $work) {
        $sql = "DELETE FROM vg_sum_kpc_students WHERE work_id = :work_id";
        $result = $DB->Delete($sql, ["work_id" => $work->work_id]);
    }

    $sql = "DELETE FROM vg_sum_kpc_worksheet WHERE sub_id = :sub_id";
    $result = $DB->Delete($sql, ["sub_id" => $sub_id]);

    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบข้อมูลสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}


if (isset($_POST['copySumScrore'])) {
    $response = array();
    $sub_id = $_POST['sub_id'];

    $sql = "SELECT sub_code, sub_name, user_create, std_class, term
            FROM vg_inter_study_subject
            WHERE sub_id = :sub_id;";
    $result = $DB->Query($sql, ["sub_id" => $sub_id]);
    $result = json_decode($result);

    $arrInsertSub = [
        "sub_code" => $result[0]->sub_code,
        "sub_name" => $result[0]->sub_name . " (คัดลอก)",
        "user_create" => $result[0]->user_create,
        "std_class" => $result[0]->std_class,
        "term" => $result[0]->term
    ];

    $sqlInsert = "INSERT INTO vg_inter_study_subject (sub_code, sub_name, user_create, std_class, term) VALUES (:sub_code, :sub_name, :user_create, :std_class, :term)";
    $newSubId = $DB->InsertLastID($sqlInsert, $arrInsertSub);

    $sql = "SELECT * FROM vg_inter_study_worksheet WHERE sub_id = :sub_id";
    $result = $DB->Query($sql, ["sub_id" => $sub_id]);
    $result = json_decode($result);

    foreach ($result as $key => $work) {
        $arrInsertWork = [
            "work_name" => $work->work_name,
            "sub_id" => $newSubId,
            "user_create" => $work->user_create
        ];

        $sqlInsert = "INSERT INTO vg_inter_study_worksheet (work_name, sub_id, user_create) VALUES (:work_name, :sub_id, :user_create)";
        $newWorkId = $DB->InsertLastID($sqlInsert, $arrInsertWork);

        $sql = "SELECT * FROM vg_inter_study_students WHERE work_id = :work_id";
        $result = $DB->Query($sql, ["work_id" => $work->work_id]);
        $result = json_decode($result);

        foreach ($result as $key => $std) {
            $arrInsertStudent = [
                "std_id" => $std->std_id,
                "reason" => $std->reason,
                "score" => $std->score,
                "final_score" => $std->final_score,
                "total_score" => $std->total_score,
                "level" => $std->level,
                "sum_score" => $std->sum_score,
                "work_id" => $newWorkId
            ];

            $sqlInsert = "  INSERT INTO vg_inter_study_students (std_id, reason, score, final_score, total_score, level, sum_score, work_id) 
                            VALUES (:std_id, :reason, :score, :final_score, :total_score, :level, :sum_score, :work_id)";
            $DB->Insert($sqlInsert, $arrInsertStudent);
        }
    }

    $response = array('status' => true, 'msg' => 'คัดลอกข้อมูลสำเร็จ');
    echo json_encode($response);
}
