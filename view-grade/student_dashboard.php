<?php

$sql = "SELECT std.*,edu.name edu_name,CONCAT(u.name,' ',u.surname) u_name,i.phone u_phone, CONCAT(ustd.name,' ',ustd.surname) ustd_name FROM tb_students std
LEFT JOIN tb_users u ON std.user_create = u.id
LEFT JOIN tb_users ustd ON std.std_id = ustd.edu_type
LEFT JOIN info i ON std.user_create = i.user_id
LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id
WHERE std_id = :std_id";
$data = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
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

$sql = "SELECT IFNULL(sum(hour),0) hour FROM vg_kpc
WHERE std_id = :std_id";
$data = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
$kpc_data = json_decode($data);
if (count($kpc_data) == 0) {
    echo "<script>location.href = 404</script>";
}
$kpc_data = $kpc_data[0];


$sql = "SELECT\n" .
    "	ts.* \n" .
    "FROM\n" .
    "	vg_test_result ts \n" .
    "WHERE\n" .
    "	std_id = :std_id";
$data = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
$test_result_data = json_decode($data);

$spanTestResult = '<span>ยังไม่ประกาศ</span>';
if (count($test_result_data) != 0) {
    $test_result_data = $test_result_data[0];
    $status_class = 'success';
    if ($test_result_data->status == 'false') {
        $status_class = 'danger';
    }
    $spanTestResult = '<span class="badge badge-pill badge-' . $status_class . '">' . $test_result_data->status_text . '</span>';
}

$sql = "SELECT\n" .
    "	net.* \n" .
    "FROM\n" .
    "	vg_n_net net \n" .
    "WHERE\n" .
    "	std_id = :std_id";
$data = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
$n_net_data = json_decode($data);

$spanNNET = '<span>-</span>';
if (count($n_net_data) != 0) {
    $n_net_data = $n_net_data[0];
    $status_class_n_net = 'success';
    if ($n_net_data->status == 'false') {
        $status_class_n_net = 'danger';
    }
    $spanNNET = '<span class="badge badge-pill badge-' . $status_class_n_net . '">' . $n_net_data->status_text . '</span>';
}


$std_profile = 'view-grade/uploads/profile-empty.jpg';
$std_profile_back = 'view-grade/uploads/profile-empty.jpg';
if (!empty($std_data->std_profile_image)) {
    $std_profile = 'view-grade/uploads/profile_students/' . $std_data->std_profile_image;
}

if (!empty($std_data->std_profile_image_back)) {
    $std_profile_back = 'view-grade/uploads/profile_students/' . $std_data->std_profile_image_back;
}


$sql = "SELECT\n" .
    "u.name u_name,u.surname,edu.name edu_name,\n" .
    "tsd.name_th sub_name,\n" .
    "td.name_th dis_name,\n" .
    "tp.name_th pro_name\n" .
    "FROM\n" .
    "tb_users u\n" .
    "LEFT JOIN tbl_non_education edu on u.edu_id = edu.id\n" .
    "LEFT JOIN tbl_sub_district tsd on edu.sub_district_id = tsd.id\n" .
    "LEFT JOIN tbl_district td on edu.district_id = td.id\n" .
    "LEFT JOIN tbl_provinces tp on edu.province_id = tp.id\n" .
    " WHERE u.id = :id\n";
$data = $DB->Query($sql, ['id' => $_SESSION['user_data']->user_create]);
$data = json_decode($data);
$data = $data[0];

$sql = "select\n" .
    "(\n" .
    "select\n" .
    "SUM(kpc.HOUR)\n" .
    "from\n" .
    "vg_kpc kpc\n" .
    "where\n" .
    "kpc.std_id = " . $_SESSION['user_data']->edu_type . "\n" .
    ") sum_hour ,\n" .
    "(\n" .
    "select\n" .
    "vnn.status_text\n" .
    "from\n" .
    "vg_n_net vnn\n" .
    "where\n" .
    "vnn.std_id = " . $_SESSION['user_data']->edu_type . " and vnn.term_id = " . $_SESSION['term_active']->term_id . "\n" .
    ") n_net,\n" .
    "(\n" .
    "select\n" .
    "vsf.status_text\n" .
    "from\n" .
    "vg_std_finish vsf\n" .
    "where\n" .
    "vsf.std_id = " . $_SESSION['user_data']->edu_type . " and vsf.term_id = " . $_SESSION['term_active']->term_id . "\n" .
    ") std_finish,\n" .
    "(\n" .
    "select\n" .
    "vtr.status_text\n" .
    "from\n" .
    "vg_test_result vtr\n" .
    "where\n" .
    "vtr.std_id = " . $_SESSION['user_data']->edu_type . " and vtr.term_id = " . $_SESSION['term_active']->term_id . "\n" .
    ") test_result\n";
$data_result_std = $DB->Query($sql, []);
$data_result_std = json_decode($data_result_std);
$data_result_std = $data_result_std[0];

// notification
$sql = "SELECT * FROM tb_notifications WHERE user_create = :user_create AND ( std_class = :std_class OR std_class = 'ทั้งหมด' ) ORDER BY std_class ASC";
$dataNoti = $DB->Query($sql, ['user_create' => $std_data->user_create, 'std_class' => $std_data->std_class]);
$noti_data = json_decode($dataNoti);

function convertDateTime($dateTime)
{
    // กำหนดชื่อเดือนภาษาไทย
    $thaiMonths = [
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤศจิกายน",
        "ธันวาคม"
    ];

    // แปลงวันที่เป็น timestamp
    $timestamp = strtotime($dateTime);

    // ดึงวันที่, เดือน, ปี
    $day = date("d", $timestamp);
    $month = date("n", $timestamp) - 1;
    $year = date("Y", $timestamp) + 543;

    // ดึงเวลา (ชั่วโมง:นาที)
    $time = date("H:i", $timestamp);

    return "{$day} {$thaiMonths[$month]} {$year} {$time}";
}

$bgColor1 = '#2f006a';
$bgColor2 = '#f9f3ff';

$sql = "SELECT * FROM tb_colors WHERE user_create = :user_create AND std_class = 'ทั้งหมด' LIMIT 1";
$dataColor = $DB->Query($sql, ['user_create' => $std_data->user_create]);
$color_data = json_decode($dataColor);
if (count($color_data) > 0) {
    $bgColor1 = $color_data[0]->color1;
    $bgColor2 = $color_data[0]->color2;
}


$sql = "SELECT * FROM tb_colors WHERE user_create = :user_create AND std_class = :std_class LIMIT 1";
$dataColor = $DB->Query($sql, ['user_create' => $std_data->user_create, 'std_class' => $std_data->std_class]);
$color_data = json_decode($dataColor);
if (count($color_data) > 0) {
    $bgColor1 = $color_data[0]->color1;
    $bgColor2 = $color_data[0]->color2;
}

?>

<style type="text/css" media="print">
    @media print {
        body {
            -webkit-print-color-adjust: exact;
        }

        @page {
            size: auto;
            margin: 0;
            overflow: hidden !important;
        }

        div.os-scrollbar,
        ::-webkit-scrollbar {
            display: none !important;
        }
    }
</style>

<style>
    /* .wrapper {
        overflow-x: hidden !important;
        overflow-y: hidden !important;
    } */

    .content {
        padding: 0 !important;
    }

    .container {
        padding: 0;
    }

    .container-bg {
        max-width: 250mm;
        height: 120em;
        /* background-image: url('view-grade/uploads/profile_students/background-info2.jpg'); */
        /* background-position: top;
        background-repeat: no-repeat; */
        padding: 20px 80px;
        position: relative;
        z-index: 1;
        background: linear-gradient(to bottom, <?php echo $bgColor1 ?>, <?php echo $bgColor2 ?>);
    }

    .highlight-header {
        font-weight: bold;
        font-size: 18px;
        color: #fff;
        margin: 0px;
        /* background-color: #000; */
        display: inline-block;
        /* Limits background width to text */
        padding: 0px 15px;
        white-space: nowrap;
        /* Prevents text from breaking */
    }

    .highlight-subheader {
        font-weight: bold;
        font-size: 30px;
        color: #fff;
        margin-bottom: 30px;
    }

    .highlight-text {
        font-size: 18px;
        font-weight: bold;
        color: #000;
    }

    .highlight-text-value {
        font-size: 24px;
        color: #000;
    }

    .h5 {
        margin: 0;
    }

    .card-body {
        padding: 35px 35px 20px 35px;
    }

    .card-custom {
        background-color: rgba(255, 255, 255, 0.9);
        /* Add slight transparency */
        z-index: 2;
        /* Keep the card above the background */
        margin-top: 5px;
        margin-bottom: 20px !important;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    p {
        margin-bottom: 5px;
    }

    .profile-container {
        width: 400px;
        /* ขนาดของรูป */
        height: 250px;
        perspective: 1000px;
        /* ทำให้เกิดเอฟเฟกต์ 3D */
    }

    .profile-card {
        width: 100%;
        height: 100%;
        position: relative;
        transform-style: preserve-3d;
        transition: transform 0.6s;
    }

    .profile-container.flipped .profile-card {
        transform: rotateY(180deg);
    }

    .profile-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        backface-visibility: hidden;
        border-radius: 10px;
        /* มุมโค้ง */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .back {
        transform: rotateY(180deg);
    }

    .btn-custom {
        background-color: white;
        /* พื้นหลังสีขาว */
        color: black;
        /* เส้นขอบดำ */
        padding: 10px 20px;
        /* ระยะห่าง */
        margin: 5px;
        /* ระยะห่างระหว่างปุ่ม */
        border-radius: 5px;
        /* ขอบโค้งเล็กน้อย */
        font-size: 14px;
        font-weight: bold;
        /* ปุ่มจะขยายเท่ากัน และมีขนาด 45% ของพื้นที่ */
        text-align: center;
        /* กำหนดความกว้างสูงสุด */
        transition: all 0.3s ease-in-out;
    }

    .btn-custom:hover {
        background-color: #d1d1d1;
        color: black;
    }

    #menu-bottom {
        position: fixed;
        bottom: 0;
        left: 5px;
        width: 100%;
        background: #ffffff;
        padding: 10px 0;
        z-index: 2;
    }

    .menu-item {
        text-align: center;
        color: #333;
        font-size: 10px;
    }

    .menu-item button {
        background: none;
        border: none;
        color: inherit;
        width: 100%;
        padding: 10px 0;
        font-size: inherit;
    }

    .menu-item a {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .menu-item i {
        font-size: 18px;
        display: block;
    }

    .menu-item.active {
        color: #007bff;
    }

    .card-scroller {
        overflow-y: auto;
        /* Enable vertical scrolling */
        overflow-x: hidden;
        /* Hide horizontal scrollbar */
        max-height: 32rem;
        /* Adjust as needed */
    }

    /* WebKit (Chrome, Edge, Safari) */
    .card-scroller::-webkit-scrollbar {
        width: 8px;
        /* Width of the scrollbar */
    }

    .card-scroller::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Track background */
        border-radius: 10px;
    }

    .card-scroller::-webkit-scrollbar-thumb {
        background: #888;
        /* Scrollbar handle */
        border-radius: 10px;
    }

    .card-scroller::-webkit-scrollbar-thumb:hover {
        background: #555;
        /* Handle on hover */
    }
</style>

<?php include("include/responsive.css.php") ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<div class="content-wrapper" style="margin: 0;">
    <?php if (!isset($_GET['list'])) { ?>
        <div class="container container-bg">
            <div id="box-icon-action">
                <i class="ti-power-off text-danger"
                    style="font-size: 24px;position: absolute;right: 10px;top: 10px;cursor: pointer;"
                    onclick="logout()"></i>
                <!-- <a href="view-grade/edit_admin?url=https://do-el.net/main_menu" style="z-index: 99999;"><i
                        class="ti-user text-info"
                        style="font-size: 24px;position: absolute;right: 10px;top: 50px;cursor: pointer;"></i></a>

                <label for="files_uploads" class="btn mt-1"
                    style="margin:0; padding:0;padding-left: 30px;font-size: 24px;position: absolute;right: 10px;top: 90px;cursor: pointer;"><i
                        class="fa fa-file-image-o text-warning" style="font-size: 24px;"></i></label>
                <input id="files_uploads" style="width: 95px;visibility:hidden;position: absolute;" type="file"> -->
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12 text-center mb-3">
                    <div>
                        <p class="highlight-header">ยินดีต้อนรับ</p>
                    </div>
                    <div>
                        <p class="highlight-header">ชื่อ-สกุล : <?php echo $std_data->std_prename . $std_data->std_name; ?></p>
                    </div>
                    <div>
                        <p class="highlight-header">รหัส นศ. : <?php echo $std_data->std_code; ?></p>
                    </div>
                    <div>
                        <p class="highlight-header">ระดับชั้น <?php echo $std_data->std_class; ?></p>
                    </div>
                    <div>
                        <p class="highlight-header">ศกร.ระดับตำบล <?php echo $data->sub_name; ?></p>
                    </div>
                    <div>
                        <p class="highlight-header">สกร.ระดับอำเภอ <?php echo $data->dis_name; ?></p>
                    </div>
                </div>

                <!-- Profile Image with Flip Effect -->
                <div class="col-md-12 d-flex justify-content-center align-items-center" style="margin-bottom: 30px;margin-top: 20px;">
                    <div class="profile-container" onclick="flipCard()">
                        <div class="profile-card">
                            <!-- ด้านหน้า -->
                            <img src="<?php echo $std_profile; ?>" alt="Profile Front" class="profile-img front">
                            <!-- ด้านหลัง -->
                            <img src="<?php echo $std_profile_back; ?>" alt="Profile Back" class="profile-img back">
                        </div>
                    </div>
                </div>

                <!-- Menu Buttons -->
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <!-- <div class="col-6 col-md-3 mb-2">
                            <button class="btn btn-custom btn-block m-0" data-toggle="modal" data-target="#modal-show-data-credit">หน่วยกิตสะสม</button>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <button class="btn btn-custom btn-block m-0" onclick="window.location.href='visit-online/index'">ห้องเรียนออนไลน์</button>
                        </div> -->
                        <!-- <div class="col-6 col-md-3 mb-2">
                            <button class="btn btn-custom btn-block m-0" onclick="gotoMainMenu()">หน้าหลัก</button>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <button class="btn btn-custom btn-block m-0" data-toggle="modal" data-target="#modal-show-qr-code">QR Code</button>
                        </div> -->
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="row justify-content-center card-custom py-2 pb-2 mx-0" style="background-color: #fff;">
                        <h5 class="m-0" style="color: #000;font-weight: bold;">ติดต่อครู&nbsp;:&nbsp;</h5>
                        <h5 class="m-0" style="color: #000;font-weight: bold;">
                            <span><?php echo !empty($std_data->u_phone) ? $mainFunc->decryptData($std_data->u_phone) : '-' ?></span>
                        </h5>
                    </div>
                </div>

                <div class="col-md-12">
                    <?php include("include/progress.php") ?>
                </div>

                <!-- ประกาศ -->
                <div class="col-md-12" id="box-notification" style="margin-top: 30px;">
                    <div class="card card-custom" style="background: #ffffff;">
                        <div class="card-body p-3 card-scroller">
                            <h5 class="m-0" style="color: #000;font-weight: bold;">ข่าวประชาสัมพันธ์</h5>
                            <?php if (count($noti_data) > 0) {
                                $i = 0;
                                foreach ($noti_data as $key => $noti) { ?>
                                    <?php if (!empty($noti->noti_msg)) {
                                        if ($i != 0) { ?>
                                            <hr>
                                        <?php } ?>
                                        <div class="mt-2 card-notidetail">
                                            <p style="color: #555; font-size: 14px;">ประกาศเมื่อ <?php echo convertDateTime($noti->create_date) ?></p>
                                            <p style="color: #555; font-size: 14px;"><?php echo $noti->std_class ?> : <?php echo $noti->noti_msg ?></p>
                                        </div>
                                    <?php $i++;
                                    } ?>
                            <?php }
                            } else {
                                echo '<p style="color: #555; font-size: 14px;" class="m-0 text-center">ไม่มีข่าวประชาสัมพันธ์</p>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="menu-bottom">
                <div class="col text-center menu-item">
                    <button onclick="gotoMainMenu()">
                        <a href="#">
                            <i class="fa fa-list-ul"></i>
                            <div class="mt-1">หน้าเมนูหลัก</div>
                        </a>
                    </button>
                </div>
                <!-- <div class="col text-center menu-item">
                    <button>
                        <a href="view-grade/view_kpc">
                            <i class="fa fa-file-text-o"></i>
                            <div class="mt-1">กพช.</div>
                        </a>
                    </button>
                </div> -->
                <div class="col text-center menu-item">
                    <?php
                    $sql = "SELECT * FROM vg_credit WHERE current = 1 AND user_create = :user_create limit 1";
                    $credit_result = $DB->Query($sql, ["user_create" => $_SESSION['user_data']->user_create]);
                    $credit_result = json_decode($credit_result);

                    $txtButton = "";
                    $linkButton = "#";

                    if (count($credit_result) > 0) {

                        $sql = "SELECT\n" .
                            "	credit.credit_id,\n" .
                            "	credit.term_id,\n" .
                            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
                            "	std.std_code\n" .
                            "FROM\n" .
                            "	vg_credit credit\n" .
                            "	LEFT JOIN tb_students std ON credit.std_id = std.std_id \n" .
                            "WHERE\n" .
                            "	credit.std_id = :std_id AND credit.term_id = '" . $credit_result[0]->term_id . "'";
                        $data = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
                        $std_data_credit = json_decode($data);
                        if (count($std_data_credit) > 0) {
                            $txtButton = "วิชาที่เรียนเทอมนี้";
                            $linkButton = 'view-grade/manage_credit_new_view?mode=view&std_id=' . $_SESSION['user_data']->edu_type . '&current=' . $credit_result[0]->term_id;
                        } else {
                            $txtButton = "ยังไม่ได้ลงทะเบียน";
                        }
                    } else {
                        $txtButton = "ยังไม่ได้ระบุเทอม";
                    } ?>
                    <a href="<?php echo $linkButton ?>">
                        <button>
                            <i class="ti-bar-chart-alt"></i>
                            <div class="mt-1"><?php echo $txtButton ?></div>
                        </button>
                    </a>
                </div>
                <div class="col text-center menu-item">
                    <a href="visit-online/index">
                        <button>
                            <i class="fa fa-calendar-check-o"></i>
                            <div class="mt-1">ห้องเรียนออนไลน์</div>
                        </button>
                    </a>
                </div>
                <div class="col text-center menu-item">
                    <button>
                        <a href="reading/manage_form_read">
                            <i class="ti-book"></i>
                            <div class="mt-1">บันทึกรักอ่าน</div>
                        </a>
                    </button>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="container-full">
            <?php include("menu_std.php") ?>
        </div>
    <?php } ?>
</div>

<!-- Modal -->
<div class="modal center-modal fade" id="modal-show-data-credit" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="highlight-text mb-0 text-primary">หน่วยกิตสะสม</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row justify-content-between mb-2">
                    <h4 class="highlight-text mb-0">วิชาบังคับ หน่วยกิตสะสม :</h4>
                    <h4 class="highlight-text-value mb-0"><span><?php echo $credit_data->cc ?></span></h4>
                </div>
                <hr>
                <div class="row justify-content-between mb-2">
                    <h4 class="highlight-text mb-0">วิชาบังคับเลือก หน่วยกิตสะสม :</h4>
                    <h4 class="highlight-text-value mb-0"><span><?php echo $credit_data->ce ?></span></h4>
                </div>
                <hr>
                <div class="row justify-content-between">
                    <h4 class="highlight-text mb-0">วิชาเลือกเสรี หน่วยกิตสะสม :</h4>
                    <h4 class="highlight-text-value mb-0"><span><?php echo $credit_data->cfe ?></span></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal center-modal fade" id="modal-show-qr-code" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="highlight-text mb-0 text-primary">QR Code เพื่อดูข้อมูลนักศึกษา</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 d-flex justify-content-center">
                <div id="qrcode"></div>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<script>
    new QRCode(document.getElementById("qrcode"), "https://do-el.net/qr_detail?std_id=<?php echo $std_data->std_id ?>");

    $('#files_uploads').change((e) => {
        e.preventDefault();
        let file = document.getElementById('files_uploads').files[0];
        var formData = new FormData();
        formData.append('fileUpload', file);

        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                alert(response.message)
                location.reload();
            }
        });
    });

    function gotoMainMenu() {
        location.href = '?list=1'
    }

    function printPage() {
        // Hide the button before printing
        $('#btn-all').hide();
        $('#box-icon-action').hide();

        // Trigger print
        window.print();

        // Show the button again after printing
        setTimeout(() => {
            $('#btn-all').show();
            $('#box-icon-action').show();
        }, 500);
    }

    function flipCard() {
        document.querySelector(".profile-container").classList.toggle("flipped");
    }

    function startProgress() {
        let progress = 0;
        let progressBar = document.getElementById("progressBar");

        let interval = setInterval(() => {
            if (progress >= 100) {
                clearInterval(interval);
            } else {
                progress++;
                progressBar.style.width = progress + "%";
                progressBar.textContent = progress + "%";
            }
        }, 50);
    }
</script>