<style>
    @media (max-width: 720px) {
        .box-image {
            flex-direction: column;
        }
    }

    .box-credit h4 {
        margin: 0;
    }

    .info p {
        margin: 0;
        margin-bottom: 5px;
    }

    .box-body {
        padding: 10px;
    }

    .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
</style>



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
    "	LEFT JOIN ( SELECT credit_id, SUM( credit ) AS total_credit FROM vg_credit_compulsory WHERE grade > 1 GROUP BY credit_id ) cc ON cc.credit_id = c.credit_id\n" .
    "	LEFT JOIN ( SELECT credit_id, SUM( credit ) AS total_credit FROM vg_credit_electives WHERE grade > 1 GROUP BY credit_id ) ce ON ce.credit_id = c.credit_id\n" .
    "	LEFT JOIN ( SELECT credit_id, SUM( credit ) AS total_credit FROM vg_credit_free_electives WHERE grade > 1 GROUP BY credit_id ) cfe ON cfe.credit_id = c.credit_id \n" .
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
if (!empty($std_data->std_profile_image)) {
    $std_profile = 'view-grade/uploads/profile_students/' . $std_data->std_profile_image;
}
?>
<div class="content-wrapper" style="margin: 0;">
    <div class="container-full">
        <section class="content row justify-content-center">
            <div class="box col-md-8 container text-center" id="dashbordSTD" style="position: relative;<?php echo isset($_GET['list']) ? 'display: none;' : '' ?>">
                <h3>แดชบอร์ด นักศึกษา</h3>
                <i class="ti-power-off text-danger" style="font-size: 24px;position: absolute;right: 10px;top: 10px;cursor: pointer;" onclick="logout()"></i>
                <a href="view-grade/edit_admin?url=https://do-el.net/main_menu" style="z-index: 99999;"><i class="ti-user text-info" style="font-size: 24px;position: absolute;right: 10px;top: 50px;cursor: pointer;"></i></a>
                <div class="d-flex justify-content-center box-image">
                    <div class="d-flex flex-column align-items-center mb-2" style="position: relative;">
                        <img style="object-fit: cover;" src="<?php echo $std_profile ?>" alt="user" width="150" height="150">
                        <!-- <input type="file" class="mt-1" name="" id="" style="width: 95px;"> -->
                        <label for="files_uploads" class="btn mt-1" style="margin: 0;color: rgb(119, 146, 177) !important;">อัปโหลดรูปภาพ</label>
                        <input id="files_uploads" style="width: 95px;visibility:hidden;position: absolute;" type="file">
                    </div>
                    <div class="pl-20 info text-left mb-3">
                        <h4>ชื่อ-สกุล : <?php echo $std_data->ustd_name ?></h4>
                        <h4>ระดับชั้น : <?php echo $std_data->std_class ?></h4>
                        <h4>รหัสนักศึกษา : <?php echo $std_data->std_code ?></h4>
                        <h4>สถานะ : <span><?php echo $std_data->std_status ?></span></h4>
                        <h4>กลุ่มสถานศึกษา : <?php echo $std_data->edu_name ?></h4>
                        <h4>ครูผู้รับผิดชอบ : <?php echo $std_data->u_name ?></h4>
                        <h4>ติดต่อครู : <?php echo !empty($std_data->u_phone) ? $mainFunc->decryptData($std_data->u_phone) : '-' ?></h4>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 px-3">
                        <div class="box box-bordered border-primary" style="border-width: 2px;">
                            <div class="box-body text-left">
                                <div class="box-credit">
                                    <div class="row justify-content-between mb-2">
                                        <h4>วิชาบังคับ หน่วยกิตสะสม</h4>
                                        <h4><span><?php echo $credit_data->cc ?></span></h4>
                                    </div>
                                    <div class="row justify-content-between mb-2">
                                        <h4>วิชาบังคับเลือก หน่วยกิตสะสม</h4>
                                        <h4><span><?php echo $credit_data->ce ?></span></h4>
                                    </div>
                                    <div class="row justify-content-between">
                                        <h4>วิชาเลือกเสรี หน่วยกิตสะสม</h4>
                                        <h4><span><?php echo $credit_data->cfe ?></span></h4>
                                    </div>
                                    <!-- <div class="row justify-content-between">
                                        <h4>เกรดเฉลี่ย</h4>
                                        <h4><span>4.00</span></h4>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 px-3">
                        <div class="box box-bordered border-success" style="border-width: 2px;">
                            <div class="box-body text-left">
                                <div class="box-credit">
                                    <div class="row justify-content-center">
                                        <?php
                                        $sql = "SELECT * FROM vg_credit WHERE current = 1 AND user_create = :user_create limit 1";
                                        $credit_result = $DB->Query($sql, ["user_create" => $_SESSION['user_data']->user_create]);
                                        $credit_result = json_decode($credit_result);

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
                                            $std_data = json_decode($data);
                                            if (count($std_data) > 0) { ?>
                                                <a href="view-grade/manage_credit_new_view?mode=view&std_id=<?php echo $_SESSION['user_data']->edu_type ?>&current=<?php echo $credit_result[0]->term_id ?>">
                                                    <h4>ดูวิชาของเทอมปัจจุบัน</h4>
                                                </a>
                                            <?php } else { ?>
                                                <h4>ยังไม่ได้ลงทะเบียน</h4>
                                            <?php }
                                        } else { ?>
                                            <h4>ยังไม่ได้ระบุเทอม</h4>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <?php //include("subject_include.php") 
                ?>


                <div class="row justify-content-center mt-2">
                    <div class="col-md-7  px-3">
                        <div class="box box-bordered border-info" style="border-width: 2px;">
                            <div class="box-body text-left">
                                <div class="box-credit">
                                    <div class="row justify-content-between mb-2">
                                        <h4>กพช. สะสม</h4>
                                        <h4><span><?php echo $kpc_data->hour ?></span> ชั่วโมง</h4>
                                    </div>
                                    <div class="row justify-content-between mb-2">
                                        <h4>รายชื่อผู้มีสิทธิ์สอบ</h4>
                                        <h4><?php echo $spanTestResult ?></h4>
                                    </div>
                                    <div class="row justify-content-between">
                                        <h4>ผลการสอบ N-Net</h4>
                                        <h4><?php echo $spanNNET ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2 mt-1">
                    <div class="col-md-12">
                        <h4 style="cursor: pointer;" class="text-info" onclick="gotoMainMenu()">ไปที่เมนูหลัก</h4>
                    </div>
                </div>
            </div>
            <!-- <div class="row justify-content-center text-left mt-4" id="mainSTDmenu" style="display: none;">
                
            </div> -->
            <div class="col-md-6" id="mainSTDmenu" <?php echo !isset($_GET['list']) ? 'style="display: none;"' : '' ?>>
                <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-student" <?php echo isset($_SESSION['user_data']) ? 'data-toggle="collapse" data-target="#studentMenu"' : '' ?> onclick="<?php echo isset($_SESSION['user_data']) ? "closeOtherMenus(this,1,'#teacherMenu, #bossMenu')" : "redirect(1)" ?>">สำหรับนักศึกษา</button>
                <div class="collapse card-collapse" id="studentMenu">
                    <div class="card card-body" style="padding: 5px;">
                        <ul class="px-4">
                            <li class="submenu-item"><a style="color: #A02334 !important;font-weight: bold;" href="<?php echo isset($_SESSION['user_data']) ? 'view-grade/index' : 'view-grade/login?system=view-grade' ?>"><i class="mr-0 fa fa fa-bar-chart"></i> สืบค้นผลการเรียน</a></li>
                            <li class="submenu-item"><a style="color: #A02334 !important;font-weight: bold;" href="<?php echo isset($_SESSION['user_data']) ? 'student-tracking/manage_estimate_print_std?std_id=' . $_SESSION['user_data']->edu_type : 'view-grade/login?system=student-tracking' ?>"><i class="mr-0 fa fa-clipboard"></i> ผลประเมินคุณธรรมนักศึกษา</a></li>
                            <li class="submenu-item"><a style="color: #A02334 !important;font-weight: bold;" href="<?php echo isset($_SESSION['user_data']) ? 'visit-online/manage_calendar_activity' : 'view-grade/login?system=visit-online' ?>"><i class="mr-0 ti-calendar"></i> ปฏิทินกิจกรรมสถานศึกษา</a></li>

                            <li class="submenu-item"><a style="color: blue !important;font-weight: bold;" href="<?php echo isset($_SESSION['user_data']) ? 'visit-online/index' : 'view-grade/login?system=visit-online' ?>"><i class="mr-0 fa fa-caret-square-o-right"></i> ระบบห้องเรียนออนไลน์</a></li>
                            <li class="submenu-item"><a style="color: blue !important;font-weight: bold;" href="<?php echo isset($_SESSION['user_data']) ? 'reading/manage_test_reading' : 'view-grade/login?system=reading' ?>"><i class="mr-0 fa fa-clipboard"></i> ระบบส่งเสริมการอ่าน</a></li>

                            <li class="submenu-item"><a style="color: #bf1fff !important;font-weight: bold;" href="<?php echo isset($_SESSION['user_data']) ? 'student-tracking/students_data' : 'view-grade/login?system=view-grade' ?>"><i class="mr-0 fa fa-clipboard"></i> แบบบันทึกข้อมูลส่วนบุคคล</a></li>
                            <li class="submenu-item"><a style="color: #bf1fff !important;font-weight: bold;" href="<?php echo isset($_SESSION['user_data']) ? 'view-grade/manage_save_event' : 'view-grade/login?system=view-grade' ?>"><i class="mr-0 fa fa-book"></i> สมุดบันทึก</a></li>
                            <li class="submenu-item"><a style="color: #bf1fff !important;font-weight: bold;" href="<?php echo isset($_SESSION['user_data']) ? 'student-tracking/after_gradiate' : 'view-grade/login?system=view-grade' ?>"><i class="mr-0 fa fa-clipboard"></i> แบบบันทึกติดตามผู้สำเร็จการศึกษา</a></li>

                            <!-- <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'student-tracking/student_family_data' : 'view-grade/login?system=student-tracking' ?>"><i class="mr-0 fa fa-clipboard"></i> แบบสำรวจข้อมูลประชากร</a></li> -->


                            <li class="submenu-item"><a href="main_menu"><i class="mr-0 fa fa-arrow-left"></i> ย้อนกลับหน้าแดชบอร์ด</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </section>
        <!-- /.content -->
    </div>
</div>

<script>
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
</script>