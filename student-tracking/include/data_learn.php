<?php
$resultLearn = null;

if (!isset($_GET['learn_analys_id'])) {
    $data_learn = [
        "title_1" => "ด้านความรุ้ความสามารถและประสบการณ์",
        "side_1_1" => "ความรู้พื้นฐาน",
        "side_1_2" => "ความสามารถในการอ่าน",
        "side_1_3" => "ความสนใจ และสสมาธิในการเรียน",
        "title_2" => "ความพร้อมด้านสติปัญญา",
        "side_2_1" => "ความคิดริเริ่มสร้างสรรค์",
        "side_2_2" => "ความมีเหตุผล",
        "side_2_3" => "ความสามารถในการเรียนรู้",
        "title_3" => "ความพร้อมด้านพฤติกรรม",
        "side_3_1" => "การแสดงออก",
        "side_3_2" => "การควบคุมอารมณ์",
        "side_3_3" => "ความมุ่งมั่น อดทน ขยันหมั่นเพียร",
        "side_3_4" => "ความรับผิดชอบ",
        "title_4" => "ความพร้อมด้านร่างกายและจิตใจ",
        "side_4_1" => "สุขภาพร่างกายสมบูรณ์",
        "side_4_2" => "การเจริญเติบโตตามวัย",
        "side_4_3" => "ความสมบูรณ์",
        "title_5" => "ความพร้อมทางสังคม",
        "side_5_1" => "การปรับตัวเข้ากับผู้อื่น",
        "side_5_2" => "การเสียสละ ไม่เห็นแก่ตัว",
        "side_5_3" => "มีระเบียบวินัย เคารพกฏ กติกา"
    ];
} else {

    include "../config/class_database.php";
    $DB = new Class_Database();

    $sql = "SELECT note FROM stf_tb_learn_analysis WHERE learn_analys_id = :learn_analys_id";
    $resultLearn = $DB->Query($sql, ['learn_analys_id' => $_GET['learn_analys_id']]);
    $resultLearn = json_decode($resultLearn)[0];

    $sql = "SELECT * FROM stf_tb_learn_anlysis_side1 WHERE learn_analys_id = :learn_analys_id";
    $resultSide1 = $DB->Query($sql, ['learn_analys_id' => $_GET['learn_analys_id']]);
    $resultSide1 = json_decode($resultSide1)[0];

    $sql = "SELECT * FROM stf_tb_learn_anlysis_side2 WHERE learn_analys_id = :learn_analys_id";
    $resultSide2 = $DB->Query($sql, ['learn_analys_id' => $_GET['learn_analys_id']]);
    $resultSide2 = json_decode($resultSide2)[0];

    $sql = "SELECT * FROM stf_tb_learn_anlysis_side3 WHERE learn_analys_id = :learn_analys_id";
    $resultSide3 = $DB->Query($sql, ['learn_analys_id' => $_GET['learn_analys_id']]);
    $resultSide3 = json_decode($resultSide3)[0];

    $sql = "SELECT * FROM stf_tb_learn_anlysis_side4 WHERE learn_analys_id = :learn_analys_id";
    $resultSide4 = $DB->Query($sql, ['learn_analys_id' => $_GET['learn_analys_id']]);
    $resultSide4 = json_decode($resultSide4)[0];

    $sql = "SELECT * FROM stf_tb_learn_anlysis_side5 WHERE learn_analys_id = :learn_analys_id";
    $resultSide5 = $DB->Query($sql, ['learn_analys_id' => $_GET['learn_analys_id']]);
    $resultSide5 = json_decode($resultSide5)[0];

    // print_r($resultSide1);
    $data_learn = [
        "title_1" => ["ด้านความรุ้ความสามารถและประสบการณ์", $resultSide1->learn_analys_side_1_id, $resultSide1->note],
        "side_1_1" => ["ความรู้พื้นฐาน", $resultSide1->learn_1],
        "side_1_2" => ["ความสามารถในการอ่าน", $resultSide1->learn_2],
        "side_1_3" => ["ความสนใจ และสสมาธิในการเรียน", $resultSide1->learn_3],

        "title_2" => ["ความพร้อมด้านสติปัญญา", $resultSide2->learn_analys_side_2_id, $resultSide2->note],
        "side_2_1" => ["ความคิดริเริ่มสร้างสรรค์", $resultSide2->learn_1],
        "side_2_2" => ["ความมีเหตุผล", $resultSide2->learn_2],
        "side_2_3" => ["ความสามารถในการเรียนรู้", $resultSide2->learn_3],

        "title_3" => ["ความพร้อมด้านพฤติกรรม", $resultSide3->learn_analys_side_3_id, $resultSide3->note],
        "side_3_1" => ["การแสดงออก", $resultSide3->learn_1],
        "side_3_2" => ["การควบคุมอารมณ์", $resultSide3->learn_2],
        "side_3_3" => ["ความมุ่งมั่น อดทน ขยันหมั่นเพียร", $resultSide3->learn_3],
        "side_3_4" => ["ความรับผิดชอบ", $resultSide3->learn_4],

        "title_4" => ["ความพร้อมด้านร่างกายและจิตใจ", $resultSide4->learn_analys_side_4_id, $resultSide4->note],
        "side_4_1" => ["สุขภาพร่างกายสมบูรณ์", $resultSide4->learn_1],
        "side_4_2" => ["การเจริญเติบโตตามวัย", $resultSide4->learn_2],
        "side_4_3" => ["ความสมบูรณ์", $resultSide4->learn_3],

        "title_5" => ["ความพร้อมทางสังคม", $resultSide5->learn_analys_side_5_id, $resultSide5->note],
        "side_5_1" => ["การปรับตัวเข้ากับผู้อื่น", $resultSide5->learn_1],
        "side_5_2" => ["การเสียสละ ไม่เห็นแก่ตัว", $resultSide5->learn_2],
        "side_5_3" => ["มีระเบียบวินัย เคารพกฏ กติกา", $resultSide5->learn_3]
    ];
    // echo "<pre>";
    // print_r($data_learn);
    // echo "</pre>";
}