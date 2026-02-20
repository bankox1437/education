<?php

session_start();
include "../../config/class_database.php";

$DB = new Class_Database();

if (isset($_POST['insert_guide'])) {
    $response = array();
    try {
        // Extract payload data
        $std_select = isset($_POST['std_select']) ? $_POST['std_select'] : '';
        $learning = isset($_POST['learning']) ? $_POST['learning'] : '';
        $skill = isset($_POST['skill']) ? $_POST['skill'] : '';
        $other_subject = isset($_POST['other_subject']) ? $_POST['other_subject'] : '';
        $other_consult = isset($_POST['other_consult']) ? $_POST['other_consult'] : '';
        $plan = isset($_POST['plan']) ? $_POST['plan'] : '';

        // Prepare response data
        $arr_data = array(
            'std_id' => $std_select,
            'learning' => $learning,
            'skill' => $skill,
            'other_subject' => $other_subject,
            'other_consult' => $other_consult,
            'plan' => $plan,
            'user_create' => $_SESSION['user_data']->id
        );

        if (isset($_POST['g_id'])) {
            $arr_data = array_merge($arr_data, array('g_id' => $_POST['g_id']));
            $arr_data['std_id'] = $_POST['std_id'];
            $sql = "UPDATE vg_guide_std
                    SET
                        std_id = :std_id,
                        learning = :learning,
                        skill = :skill,
                        other_subject = :other_subject,
                        other_consult = :other_consult,
                        plan = :plan,
                        user_create = :user_create
                    WHERE g_id = :g_id";
            $data = $DB->Update($sql, $arr_data);
        } else {
            $sql = "INSERT INTO vg_guide_std (std_id, learning, skill, other_subject, other_consult, plan ,user_create)
            VALUES (:std_id, :learning, :skill, :other_subject, :other_consult, :plan, :user_create)";
            $data = $DB->Insert($sql, $arr_data);
        }
        if ($data) {
            $response = ['status' => true, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
        } else {
            $response = ['status' => false, 'msg' => $data];
        }
        echo json_encode($response);
    } catch (Exception $e) {
        $response = array('status' => false, 'data' => [], 'msg' => $e->getMessage());
        echo json_encode($response);
    }
}

if (isset($_REQUEST['getGuide'])) {
    $response = array();
    // ค้นหา
    $search = "";
    $params = [];

    $params['user_create'] = $_SESSION['user_data']->id;
    if (isset($_REQUEST['user_id'])) {
        $params['user_create'] = $_REQUEST['user_id'];
    }

    // นับจำนวนทั้งหมด
    $sql_total = "SELECT COUNT(*) as totalnotfilter FROM vg_guide_std WHERE user_create = :user_create";
    $stmt = $DB->Query($sql_total, $params);
    $totalnotfilter =  json_decode($stmt)[0]->totalnotfilter;

    // นับจำนวนที่มีการ filter
    $sql_count = "SELECT COUNT(*) as total FROM vg_guide_std WHERE user_create = :user_create ";
    $total_result = $DB->Query($sql_count, $params);
    $total = json_decode($total_result)[0]->total;

    // จำกัดจำนวน
    $limit = "";
    if (!empty($_REQUEST['limit']) && isset($_REQUEST['offset'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . ", " . $_REQUEST['limit'];
    }

    // ดึงข้อมูล
    $sql = "SELECT g.*,CONCAT(std.std_prename, std.std_name) std_name FROM vg_guide_std g
    LEFT JOIN tb_students std ON std.std_id = g.std_id
    WHERE g.user_create = :user_create " . $limit;
    $data_result = $DB->Query($sql, $params);
    $data_result = json_decode($data_result);
    $response = ['rows' => $data_result, "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter];
    echo json_encode($response);
}


if (isset($_REQUEST['deleteGuide'])) {
    $g_id = $_POST['g_id'];

    try {
        $sql = "DELETE FROM vg_guide_std WHERE g_id = :g_id";
        $result = $DB->Query($sql, ["g_id" => $g_id]);

        if ($result) {
            echo json_encode(["status" => "success", "message" => "ลบข้อมูลสําเร็จ"]);
        } else {
            echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่อีกครั้ง"]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
