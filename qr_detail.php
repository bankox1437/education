<?php
session_start();
include "config/class_database.php";
include('view-grade/models/term_model.php');
$DB = new Class_Database();
$termModel = new Term_Model($DB);

$term_active = $termModel->getrTermActive();
if (count($term_active) > 0) {
    $_SESSION['term_active'] = $term_active[0];
}

$whereHour = "";
$sql = "SELECT std.*,edu.name edu_name,CONCAT(u.name,' ',u.surname) u_name,i.phone u_phone, CONCAT(ustd.name,' ',ustd.surname) ustd_name FROM tb_students std
LEFT JOIN tb_users u ON std.user_create = u.id
LEFT JOIN tb_users ustd ON std.std_id = ustd.edu_type
LEFT JOIN info i ON std.user_create = i.user_id
LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id
WHERE std_id = :std_id";
$data = $DB->Query($sql, ['std_id' => $_GET['std_id']]);
$std_data = json_decode($data);
if (count($std_data) == 0) {
    echo "<script>location.href = 404</script>";
}
$std_data = $std_data[0];

$sql = "SELECT\n" .
    "	SUM(\n" .
    "	IFNULL( cc.total_credit, 0 )) AS cc,\n" .
    "	SUM(\n" .
    "	IFNULL( ce.total_credit, 0 )) AS ce,\n" .
    "	SUM(\n" .
    "	IFNULL( cfe.total_credit, 0 )) AS cfe\n" .
    "FROM\n" .
    "	vg_credit c\n" .
    "	LEFT JOIN ( SELECT credit_id, SUM( credit ) AS total_credit FROM vg_credit_compulsory WHERE grade > 0 GROUP BY credit_id ) cc ON cc.credit_id = c.credit_id\n" .
    "	LEFT JOIN ( SELECT credit_id, SUM( credit ) AS total_credit FROM vg_credit_electives WHERE grade > 0 GROUP BY credit_id ) ce ON ce.credit_id = c.credit_id\n" .
    "	LEFT JOIN ( SELECT credit_id, SUM( credit ) AS total_credit FROM vg_credit_free_electives WHERE grade > 0 GROUP BY credit_id ) cfe ON cfe.credit_id = c.credit_id \n" .
    "WHERE\n" .
    "	c.std_id = :std_id;";
$data = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
$credit_data = json_decode($data);
if (count($credit_data) == 0) {
    echo "<script>location.href = 404</script>";
}
$credit_data = $credit_data[0];

$sql = "select\n" .
    "(\n" .
    "select\n" .
    "SUM(kpc.HOUR)\n" .
    "from\n" .
    "vg_kpc kpc\n" .
    "where\n" .
    "kpc.std_id = " . $std_data->std_id . "\n" .
    ") sum_hour ,\n" .
    "(\n" .
    "select\n" .
    "vnn.status_text\n" .
    "from\n" .
    "vg_n_net vnn\n" .
    "where\n" .
    "vnn.std_id = " . $std_data->std_id . " and vnn.term_id = " . $_SESSION['term_active']->term_id . "\n" .
    ") n_net,\n" .
    "(\n" .
    "select\n" .
    "vsf.status_text\n" .
    "from\n" .
    "vg_std_finish vsf\n" .
    "where\n" .
    "vsf.std_id = " . $std_data->std_id . " and vsf.term_id = " . $_SESSION['term_active']->term_id . "\n" .
    ") std_finish,\n" .
    "(\n" .
    "select\n" .
    "vtr.status_text\n" .
    "from\n" .
    "vg_test_result vtr\n" .
    "where\n" .
    "vtr.std_id = " . $std_data->std_id . " and vtr.term_id = " . $_SESSION['term_active']->term_id . "\n" .
    ") test_result\n";
$data_result_std = $DB->Query($sql, []);
$data_result_std = json_decode($data_result_std);
$data_result_std = $data_result_std[0];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/logo.jpg">
    <link rel="apple-touch-icon" href="images/logo.jpg">

    <link rel="stylesheet" href="assets/css/main.css?v=<?php echo $version; ?>">
    <!-- Vendors Style-->
    <link rel="stylesheet" href="assets/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/Loader.css">
    <link rel="stylesheet" href="assets/css/skin_color.css">
    <link rel="stylesheet" href="view-grade/css/main.css">
    <link href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">

    <title>นำเข้านักศึกษา</title>
</head>

<body>
    <div class="content-wrapper" style="margin: 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h3 class="highlight-header"><?php echo $std_data->std_prename.$std_data->std_name ?></h3>
                    <!-- Card 2: ข้อมูลหน่วยกิต -->
                    <div class="col-md-12">
                        <div class="card card-custom">
                            <div class="card-body text-center">
                                <div class="row justify-content-between mb-2">
                                    <h4 class="highlight-text">วิชาบังคับ หน่วยกิตสะสม :</h4>
                                    <h4 class="highlight-text-value"><span><?php echo $credit_data->cc ?></span></h4>
                                </div>
                                <div class="row justify-content-between mb-2">
                                    <h4 class="highlight-text">วิชาบังคับเลือก หน่วยกิตสะสม :</h4>
                                    <h4 class="highlight-text-value"><span><?php echo $credit_data->ce ?></span></h4>
                                </div>
                                <div class="row justify-content-between">
                                    <h4 class="highlight-text">วิชาเลือกเสรี หน่วยกิตสะสม :</h4>
                                    <h4 class="highlight-text-value"><span><?php echo $credit_data->cfe ?></span></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: สถานะการสอบและการจบ -->
                    <div class="col-md-12" id="box-result">
                        <div class="card card-custom">
                            <div class="card-body text-center">
                                <div class="row justify-content-between mb-2">
                                    <h4 class="highlight-text">สถานะการสอบ :</h4>
                                    <h4 class="highlight-text-value">
                                        <span><?php echo !empty($data_result_std->test_result) ? $data_result_std->test_result : '-' ?></span>
                                    </h4>
                                </div>
                                <div class="row justify-content-between mb-2">
                                    <h4 class="highlight-text">สถานะการจบ :</h4>
                                    <h4 class="highlight-text-value">
                                        <span><?php echo !empty($data_result_std->std_finish) ? $data_result_std->std_finish : '-' ?></span>
                                    </h4>
                                </div>
                                <div class="row justify-content-between">
                                    <h4 class="highlight-text">ผลสอบ N NET :</h4>
                                    <h4 class="highlight-text-value">
                                        <span><?php echo !empty($data_result_std->n_net) ? $data_result_std->n_net : '-' ?></span>
                                    </h4>
                                </div>
                                <div class="row justify-content-between">
                                    <h4 class="highlight-text">กพช.สะสม :</h4>
                                    <h4 class="highlight-text-value">
                                        <span><?php echo !empty($data_result_std->sum_hour) ? $data_result_std->sum_hour : '0' ?>
                                            ชั่วโมง</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>