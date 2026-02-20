<?php
$listCreditPerClass = [
    "ประถม" => [
        "วิชาบังคับ" => 36,
        "วิชาเลือกบังคับ" => 4,
        "วิชาเลือกเสรี" =>  8,
        "กพช" => 200,
    ],
    "ม.ต้น" => [
        "วิชาบังคับ" => 40,
        "วิชาเลือกบังคับ" => 6,
        "วิชาเลือกเสรี" =>  10,
        "กพช" => 200,
    ],
    "ม.ปลาย" => [
        "วิชาบังคับ" => 44,
        "วิชาเลือกบังคับ" => 6,
        "วิชาเลือกเสรี" =>  26,
        "กพช" => 200,
    ]
];

function calculatePercent($value, $max)
{
    if ($max == 0) {
        return 0;
    }
    $percent = round(($value / $max) * 100);
    return min($percent, 100);
}

function generateTextBar($value, $max)
{
    return $value . " / " . $max;
}

?>

<div class="progress-wrapper">
    <div class="progress-item">
        <div class="progress-title">หน่วยกิตสะสม วิชาบังคับ เต็ม <?php echo $listCreditPerClass[$std_data->std_class]['วิชาบังคับ'] ?></div>
        <div class="bar">
            <div class="fill" style="width:<?php echo calculatePercent($credit_data->cc, $listCreditPerClass[$std_data->std_class]['วิชาบังคับ']) ?>%; background:linear-gradient(90deg,#26a69a,#009688);">
                <?php echo generateTextBar($credit_data->cc, $listCreditPerClass[$std_data->std_class]['วิชาบังคับ']) ?>
            </div>
        </div>
    </div>

    <div class="progress-item">
        <div class="progress-title">หน่วยกิตสะสม วิชาเลือกบังคับ เต็ม <?php echo $listCreditPerClass[$std_data->std_class]['วิชาเลือกบังคับ'] ?></div>
        <div class="bar">
            <div class="fill" style="width:<?php echo calculatePercent($credit_data->cc, $listCreditPerClass[$std_data->std_class]['วิชาเลือกบังคับ']) ?>%; background:linear-gradient(90deg,#26c6da,#00acc1);">
                <?php echo generateTextBar($credit_data->cc, $listCreditPerClass[$std_data->std_class]['วิชาเลือกบังคับ']) ?>
            </div>
        </div>
    </div>

    <div class="progress-item">
        <div class="progress-title">หน่วยกิตสะสม วิชาเลือกเสรี เต็ม <?php echo $listCreditPerClass[$std_data->std_class]['วิชาเลือกเสรี'] ?></div>
        <div class="bar">
            <div class="fill" style="width:<?php echo calculatePercent($credit_data->cc, $listCreditPerClass[$std_data->std_class]['วิชาเลือกเสรี']) ?>%; background:linear-gradient(90deg,#7e57c2,#5e35b1);">
                <?php echo generateTextBar($credit_data->cc, $listCreditPerClass[$std_data->std_class]['วิชาเลือกเสรี']) ?>
            </div>
        </div>
    </div>

    <?php

    $sql = "SELECT SUM(hour) sum_hour FROM vg_kpc kpc\n" .
        "LEFT JOIN tb_students std ON kpc.std_id = std.std_id\n" .
        "LEFT JOIN vg_terms term ON kpc.term_id = term.term_id\n" .
        "WHERE kpc.std_id = :std_id ";

    $arr_data = ['std_id' => $_SESSION['user_data']->edu_type];

    $term_name_active = $_SESSION['term_active']->term_name;

    $sqlWhere = "";

    if (isset($_GET['term_name']) && $_GET['term_name'] != $term_name_active) {
        $term_name = $_GET['term_name'];
        $arr_data["term_name"] = $term_name;
        $sqlWhere = " AND CONCAT(term.term,'/',term.year) = :term_name";
        $sql .= $sqlWhere;
    }

    $data = $DB->Query($sql, $arr_data);
    $std_kpc_data = json_decode($data);
    $sum_hour = 0;
    if (count($std_kpc_data) != 0) {
        $sum_hour =  $std_kpc_data[0]->sum_hour;
    }
    ?>

    <div class="progress-item">
        <div class="progress-title">คะแนน กพช. สะสม เต็ม <?php echo $listCreditPerClass[$std_data->std_class]['กพช'] ?></div>
        <div class="bar">
            <div class="fill" style="width:<?php echo calculatePercent($sum_hour, $listCreditPerClass[$std_data->std_class]['กพช']) ?>%; background:linear-gradient(90deg,#ec407a,#d81b60);">
                <?php echo generateTextBar($sum_hour, $listCreditPerClass[$std_data->std_class]['กพช']) ?>
            </div>
        </div>
    </div>
</div>

<style>
    .main-title {
        text-align: center;
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #444;
    }

    .progress-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin: 0 auto;
    }

    .progress-item {
        display: flex;
        flex-direction: column;
    }

    .progress-title {
        font-weight: 600;
        color: #ffffffff;
    }

    .bar {
        flex: 1;
        height: 35px;
        background: #e0e0e0;
        border-radius: 50px;
        overflow: hidden;
        position: relative;
    }

    .fill {
        height: 100%;
        border-radius: 50px;
        color: white;
        font-weight: bold;
        text-align: center;
        /* padding-left: 10px; */
        line-height: 35px;
        transition: width 0.5s;
        min-width: 90px;
    }
</style>