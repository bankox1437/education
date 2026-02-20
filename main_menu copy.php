<?php session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileUpload'])) {
    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';
    include "config/main_function.php";
    $mainFunc = new ClassMainFunctions();

    include "config/class_database.php";
    $DB = new Class_Database();
    $uploadDir = 'view-grade/uploads/profile_students/';
    $resizeDir = 'view-grade/uploads/';

    $sql = "SELECT std_profile_image FROM tb_students WHERE std_id = " . $_SESSION['user_data']->edu_type;
    $query = $DB->Query($sql, []);
    $data_profile = json_decode($query)[0];

    $profile_img = "";
    $fileNameRes = $mainFunc->UploadFileImage($_FILES['fileUpload'], $uploadDir, $resizeDir);
    if (!$fileNameRes['status']) {
        $response = array('status' => 'error', 'message' => $fileNameRes['result']);
        echo json_encode($response);
        exit();
    } else {
        if (!empty($data_profile->std_profile_image)) {
            unlink($uploadDir . $data_profile->std_profile_image);
        }
        $profile_img = $fileNameRes['result'];
    }

    $sql = "UPDATE tb_students SET std_profile_image = '" . $profile_img . "' WHERE std_id = " . $_SESSION['user_data']->edu_type;
    $update = $DB->Update($sql, []);
    if ($update == 1) {
        echo json_encode(['status' => 'success', 'message' => 'อัปโหลดรูปภาพสำเร็จ']);
    } else {
        unlink($uploadDir . $profile_img);
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดไม่สามารถอัปโหลดรูปภาพได้ โปรดลองใหม่']);
    }
    exit();
}

if (isset($_SESSION['user_data']) && $_SESSION['user_data']->role_id == 1) {
    header('location: admin/manage_admin');
}
$statusRole = [];
if (isset($_SESSION['user_data'])) {
    $statusRole = json_decode($_SESSION['user_data']->status, true);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="images/logo-do-el.jpg">
    <link rel="apple-touch-icon" href="images/logo-do-el.jpg">

    <title>เมนูหลักระบบ</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="assets/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skin_color.css">
    <link rel="stylesheet" href="view-grade/css/main_std.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .admin-use {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .admin-use i {
            font-size: 36px;
        }

        .btn-custom-menu {
            padding: 10px;
            border-radius: 10px;
            font-size: 24px;
            font-weight: bold;
        }

        .submenu-item {
            border-top: 1px solid #ddd;
            padding: 5px;
        }

        .submenu-item:first-child {
            border-top: none;
            padding-top: 15px;
            /* Remove border-top for the first child */
        }

        .submenu-item:last-child {
            border-bottom: none;
            /* Remove border-bottom for the last child */
        }

        .custom-std:hover {
            background-color: #0000ff;
        }

        .card-collapse {
            margin-top: -10px;
        }

        .card-collapse ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .card-collapse ul li {
            padding: 10px;
            font-size: 18px;
        }

        .card {
            border-radius: unset;
            border-radius: 0 0 10px 10px;
            padding-bottom: 0;
        }

        /* default */
        .custom-student {
            border: #0000ff solid 2px !important;
            box-shadow: #0000ff 0px 3px 8px;
            color: #0000ff;
        }

        .custom-teacher {
            border: #e50102 solid 2px !important;
            box-shadow: #e50102 0px 3px 8px;
            color: #e50102;
        }

        .custom-boss {
            border: #03a9f5 solid 2px !important;
            box-shadow: #03a9f5 0px 3px 8px;
            color: #03a9f5;
        }

        .custom-edu {
            border: #65B741 solid 2px !important;
            box-shadow: #65B741 0px 3px 8px;
            color: #65B741;
        }

        .custom-read {
            border: #fc9d03 solid 2px !important;
            box-shadow: #fc9d03 0px 3px 8px;
            color: #fc9d03;
        }

        .custom-family {
            border: #fc9d03 solid 2px !important;
            box-shadow: #fc9d03 0px 3px 8px;
            color: #fc9d03;
        }

        /* hover */
        .custom-student:hover {
            background-color: #0000ff;
            color: #fff;
            box-shadow: unset;
        }

        .custom-teacher:hover {
            background-color: #e50102;
            color: #fff;
            box-shadow: unset;
        }

        .custom-boss:hover {
            background-color: #03a9f5;
            color: #fff;
            box-shadow: unset;
        }

        .custom-edu:hover {
            background-color: #65B741;
            color: #fff;
            box-shadow: unset;
        }

        .custom-family:hover {
            background-color: #fc9d03;
            color: #fff;
            box-shadow: unset;
        }

        /* active */
        .custom-active-student {
            background-color: blue !important;
            box-shadow: unset;
            color: #fff !important;
        }

        .custom-active-teacher {
            background-color: #e50102 !important;
            box-shadow: unset;
            color: #fff !important;
        }

        .custom-active-boss {
            background-color: #03a9f5 !important;
            box-shadow: unset;
            color: #fff !important;
        }

        .custom-active-edu {
            background-color: #65B741 !important;
            box-shadow: unset;
            color: #fff !important;
        }

        .content-header h3:nth-child(2) {
            max-width: 100%;
        }

        @media (max-width: 400px) {
            .waves-effect {
                font-size: 16px;
            }

        }

        .input-group-text {
            cursor: pointer;
            width: 60px;
            display: flex;
            justify-content: center;
        }

        .input-group-text:hover {
            background-color: #3c2bc1;
            color: #ffffff;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" style="position: relative;">

    <div class="wrapper" style="overflow: scroll;">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">
                <!-- Main content -->
                <!-- <div class="content-header pt-3">
                    <h3 class="text-center m-0 text-primary"><b>ระบบช่วยเหลือ</b></h3>
                    <h3 class="text-center m-0 text-primary"><b>ผู้เรียน ผู้สอน ผู้บริหาร สถานศึกษา</b></h3>
                    <h3 class="text-center m-0 text-primary"><b>กรมส่งเสริมการเรียนรู้</b></h3>
                </div> -->
                <section class="content">
                    <div class="container">
                        <?php if (isset($_GET['index_menu']) || isset($_SESSION['index_menu'])) { ?>
                            <?php if ($_SESSION['index_menu'] == 4) { ?>
                                <!-- <div class="row justify-content-center" style="margin-top: 20px;">
                                    <div class="col-md-6">
                                        <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-student" <?php echo isset($_SESSION['user_data']) ? 'data-toggle="collapse" data-target="#studentMenu"' : '' ?> onclick="<?php echo isset($_SESSION['user_data']) ? "closeOtherMenus(this,1,'#teacherMenu, #bossMenu')" : "redirect(1)" ?>">สำหรับนักศึกษา</button>
                                        <div class="collapse card-collapse" id="studentMenu">
                                            <div class="card card-body" style="padding: 5px;">
                                                <ul class="px-4">
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'visit-online/index' : 'view-grade/login?system=visit-online' ?>"><i class="mr-0 fa fa-caret-square-o-right"></i> ห้องเรียนออนไลน์</a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'view-grade/index' : 'view-grade/login?system=view-grade' ?>"><i class="mr-0 fa fa fa-bar-chart"></i> สืบค้นผลการเรียน</a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'view-grade/manage_save_event' : 'view-grade/login?system=view-grade' ?>"><i class="mr-0 fa fa-floppy-o"></i> บันทึกการเข้าร่วมกิจกรรม</a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'student-tracking/after_gradiate' : 'view-grade/login?system=view-grade' ?>"><i class="mr-0 fa fa-clipboard"></i> แบบติดตามผู้สำเร็จการศึกษา</a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'student-tracking/students_data' : 'view-grade/login?system=view-grade' ?>"><i class="mr-0 fa fa-clipboard"></i> แบบบันทึกข้อมูลส่วนบุคคล</a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'student-tracking/student_family_data' : 'view-grade/login?system=student-tracking' ?>"><i class="mr-0 fa fa-clipboard"></i> แบบสำรวจข้อมูลประชากร</a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'student-tracking/manage_estimate_print_std?std_id=' . $_SESSION['user_data']->edu_type : 'view-grade/login?system=student-tracking' ?>"><i class="mr-0 fa fa-clipboard"></i> ผลประเมินคุณธรรมนักศึกษา</a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'visit-online/manage_calendar_activity' : 'view-grade/login?system=visit-online' ?>"><i class="mr-0 ti-calendar"></i> ปฏิทินกิจกรรมสถานศึกษา</a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'reading/manage_test_reading' : 'view-grade/login?system=reading' ?>"><i class="mr-0 fa fa-clipboard"></i> ส่งเสริมการอ่าน</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div> -->
                                <?php include('view-grade/student_dashboard.php') ?>
                            <?php } ?>
                            <?php if ($_SESSION['index_menu'] == 3) { ?>
                                <div class="row justify-content-center" style="margin-top: 20px;">
                                    <div class="col-md-6">
                                        <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-teacher" data-toggle="collapse" data-target="#teacherMenu" onclick="closeOtherMenus(this,2,'#studentMenu, #bossMenu')">สำหรับครู</button>
                                        <div class="collapse card-collapse" id="teacherMenu">
                                            <div class="card card-body" style="padding: 5px;">
                                                <ul class="px-4">
                                                    <li class="submenu-item"><a href="student_list"> <i class="mr-0 fa fa-group (alias)"></i> ข้อมูลและการนำเข้านักศึกษา</a></li>
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['dashboard']) && $statusRole['dashboard'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('dashboard','<?php echo isset($_SESSION['user_data']) ? 'view-grade/dashboard_index' : 'view-grade/login?system=view-grade' ?>')"> <i class="fa fa-table"></i> แดชบอร์ดภาพรวมข้อมูล <?php echo isset($statusRole['dashboard']) && $statusRole['dashboard'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['view_grade']) && $statusRole['view_grade'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('view-grade','<?php echo isset($_SESSION['user_data']) ? 'view-grade/index' : 'view-grade/login?system=view-grade' ?>')"> <i class="fa fa-bar-chart"></i> จัดการระบบสืนค้นผลการเรียน <?php echo isset($statusRole['view_grade']) && $statusRole['view_grade'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['visit_online']) && $statusRole['visit_online'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('visit-online','<?php echo isset($_SESSION['user_data']) ? 'visit-online/index' : 'view-grade/login?system=visit-online' ?>')"> <i class="mr-0 fa fa-caret-square-o-right"></i> จัดการห้องเรียนออนไลน์ <?php echo isset($statusRole['visit_online']) && $statusRole['visit_online'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['std_tracking']) && $statusRole['std_tracking'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('student-tracking','<?php echo isset($_SESSION['user_data']) ? 'student-tracking/index' : 'view-grade/login?system=student-tracking' ?>')"> <i class="mr-0 fa fa-address-book"></i> จัดการระบบฐานข้อมูลนักศึกษา <?php echo isset($statusRole['std_tracking']) && $statusRole['std_tracking'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['visit_online']) && $statusRole['visit_online'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('visit-online','<?php echo isset($_SESSION['user_data']) ? 'visit-online/index' : 'view-grade/login?system=visit-online' ?>')"> <i class="mr-0 fa fa-file-text"></i> บันทึกรายงานการสอน <?php echo isset($statusRole['visit_online']) && $statusRole['visit_online'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['estimate']) && $statusRole['estimate'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('estimate','<?php echo isset($_SESSION['user_data']) ? 'student-tracking/manage_estimate_index' : 'view-grade/login?system=student-tracking' ?>')"> <i class="mr-0 fa fa-clipboard"></i> ประเมินคุณธรรมนักศึกษา <?php echo isset($statusRole['estimate']) && $statusRole['estimate'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['search']) && $statusRole['search'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('search','<?php echo isset($_SESSION['user_data']) ? 'student-tracking/graduate_reg' : 'view-grade/login?system=student-tracking' ?>')"> <i class="mr-0 fa fa-clipboard"></i> ทะเบียนผู้จบการศึกษา <?php echo isset($statusRole['search']) && $statusRole['search'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['after']) && $statusRole['after'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('after','<?php echo isset($_SESSION['user_data']) ? 'student-tracking/form_after_gradiate' : 'view-grade/login?system=student-tracking' ?>')"> <i class="mr-0 fa fa-mortar-board"></i> แบบติดตามหลังจบการศึกษา <?php echo isset($statusRole['after']) && $statusRole['after'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <!-- <li class="submenu-item"><a <?php echo isset($statusRole['see_people']) && $statusRole['see_people'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('see_people','<?php echo isset($_SESSION['user_data']) ? 'student-tracking/family_data' : 'view-grade/login?system=student-tracking' ?>')"> <i class="mr-0 fa fa-clipboard"></i> ฐานข้อมูลประชากรด้านการศึกษา <?php echo isset($statusRole['see_people']) && $statusRole['see_people'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li> -->
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['visit_online']) && $statusRole['visit_online'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('visit-online','<?php echo isset($_SESSION['user_data']) ? ($_SESSION['user_data']->role_id == 3 ? 'visit-online/manage_summary' : 'visit-online/index') : 'view-grade/login?system=visit-online' ?>')"> <i class="mr-0 fa fa-file-text-o"></i> บันทึกรายงานผลการปฏิบัติงาน <?php echo isset($statusRole['visit_online']) && $statusRole['visit_online'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'visit-online/manage_calendar_activity' : 'view-grade/login?system=visit-online' ?>"><i class="mr-0 ti-calendar"></i> ปฏิทินกิจกรรมสถานศึกษา</a></li>
                                                    <!-- <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'visit-online/manage_summary' : 'view-grade/login?system=visit-online' ?>"><i class="mr-0 fa fa-file-text-o"></i> รายงานผลการดำเนินงาน</a></li> -->
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'visit-online/manage_index' : 'view-grade/login?system=visit-online' ?>"><i class="mr-0 ti-zip"></i> การประเมินพนักงานราชการ</a></li>
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['reading']) && $statusRole['reading'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('reading','<?php echo isset($_SESSION['user_data']) ? 'reading/manage_test_reading' : 'view-grade/login?system=visit-online' ?>')"> <i class="mr-0 fa fa-file-text-o"></i> ส่งเสริมการอ่าน <?php echo isset($statusRole['reading']) && $statusRole['reading'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'visit-online/manage_plan' : 'view-grade/login?system=visit-online' ?>"><i class="mr-0 ti-agenda"></i> แผนการสอน</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($_SESSION['index_menu'] == 2) { ?>
                                <div class="row justify-content-center" style="margin-top: 20px;">
                                    <div class="col-md-6">
                                        <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-boss" data-toggle="collapse" data-target="#bossMenu" onclick="closeOtherMenus(this,3,'#studentMenu, #teacherMenu')">สำหรับผู้บริหาร</button>
                                        <div class="collapse card-collapse" id="bossMenu">
                                            <div class="card card-body" style="padding: 5px;">
                                                <ul class="px-4">
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'view-grade/am_manage_teacher' : 'view-grade/login?system=visit-online' ?>"><i class="mr-0 ti-user"></i> จัดการแอดมินครูตำบล</a></li>
                                                    <!-- <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'view-grade/am_dashboard' : 'view-grade/login?system=view-grade' ?>"><i class="mr-0 ti-dashboard"></i> แดชบอร์ด</a></li> -->
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['dashboard']) && $statusRole['dashboard'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('dashboard','<?php echo isset($_SESSION['user_data']) ? 'view-grade/dashboard_index' : 'view-grade/login?system=view-grade' ?>')"> <i class="fa fa-table"></i> ข้อมูลบุคลากร <?php echo isset($statusRole['dashboard']) && $statusRole['dashboard'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'visit-online/index' : 'view-grade/login?system=visit-online' ?>"><i class="mr-0 fa fa-bookmark"></i> ประเมินพนักงานราชการ</a></li>
                                                    <li class="submenu-item"><a href="<?php echo isset($_SESSION['user_data']) ? 'visit-online/index' : 'view-grade/login?system=visit-online' ?>"><i class="mr-0 fa fa-calendar"></i> นิเทศการสอน ติดตามการปฏิบัติงาน</a></li>
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['reading']) && $statusRole['reading'] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('reading','<?php echo isset($_SESSION['user_data']) ? 'reading/manage_media_reading' : 'view-grade/login?system=visit-online' ?>')"> <i class="mr-0 fa fa-file-text-o"></i> ส่งเสริมการอ่าน <?php echo isset($statusRole['reading']) && $statusRole['reading'] ? '' : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- <?php if ($_SESSION['index_menu'] == 5) {
                                    ?>
                                <div class="row justify-content-center" style="margin-top: 20px;">
                                    <div class="col-md-6">
                                        <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-edu" data-toggle="collapse" data-target="#eduMenu" onclick="closeOtherMenus(this,5,'#studentMenu, #teacherMenu')">สำหรับสถานศึกษา</button>
                                        <div class="collapse card-collapse" id="eduMenu">
                                            <div class="card card-body" style="padding: 5px;">
                                                <ul class="px-4">
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['search']) && $statusRole['search'] ? "" : 'style="cursor: no-drop;"' ?> href="<?php echo isset($statusRole['search']) && $statusRole['search'] ? "student-tracking/graduate_reg" : '#' ?>"><i class="mr-0 fa fa-bookmark"></i> สืบค้นวุฒิการศึกษา <?php echo isset($statusRole['search']) && $statusRole['search'] ? "" : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                    <li class="submenu-item"><a <?php echo isset($statusRole['see_people']) && $statusRole['see_people'] ? "" : 'style="cursor: no-drop;"' ?> href="<?php echo isset($statusRole['see_people']) && $statusRole['see_people'] ? "student-tracking/family_data" : '#' ?>"><i class="mr-0 fa fa-calendar"></i> ฐานข้อมูลประชากรด้านการศึกษา <?php echo isset($statusRole['see_people']) && $statusRole['see_people'] ? "" : '( ไม่มีสิทธิ์ )' ?></a></li>
                                                </ul>
                                            </div>
                                            <?php
                                            if (!$statusRole['search'] && !$statusRole['see_people']) { ?>
                                                <div class="d-flex justify-content-center">
                                                    <a onclick="logout()" class="text-center text-danger" style="cursor: pointer;font-size: 18px;">ออกจากระบบ</a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?> -->
                        <?php } else { ?>
                            <!-- ยังไม่มี session  -->
                            <div class="row justify-content-center" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-student" onclick="redirect(1)">สำหรับนักศึกษา</button>
                                </div>
                            </div>
                            <div class="row justify-content-center" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-teacher" onclick="redirect(2)">สำหรับครู</button>
                                </div>
                            </div>
                            <div class="row justify-content-center" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-boss" onclick="redirect(3)">สำหรับแอดมินอำเภอ</button>
                                </div>
                            </div>
                            <div class="row justify-content-center" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-edu" onclick="redirect(3)">สำหรับแอดมินจังหวัด</button>
                                </div>
                            </div>
                            <!-- <div class="row justify-content-center" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-edu" onclick="redirect(5)">สำหรับสถานศึกษา</button>
                                </div>
                            </div>
                            <div class="row justify-content-center" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <a href="reading/index">
                                        <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-read">ส่งเสริมการอ่าน</button>
                                    </a>
                                </div>
                            </div> -->
                            <!-- <div class="row justify-content-center" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <button type="button" class="waves-effect waves-light btn col-md-12 btn-custom-menu custom-family" onclick="location.href='view-grade/login?system=student-tracking&family_data='">ฐานข้อมูลประชากรด้านการศึกษา</button>
                                </div>
                            </div> -->
                        <?php } ?>

                        <!-- <div class="row justify-content-center mt-4">
                            <div class="form-group mb-0 col-md-6">
                                <div class="input-group" style="height: 50px;">
                                    <input type="text" id="search" class="form-control" placeholder="ค้นหาผู้จบการศึกษา ด้วยชื่อ-สกุล หรือ เลขประจำตัวประชาชน" autocomplete="off">
                                    <div class="input-group-append" onclick="search()">
                                        <span class="input-group-text"><i class="ti-search button-icon-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </section>
                <!-- /.content -->

            </div>
        </div>
        <!-- /.content-wrapper -->
        <!-- ./wrapper -->
        <?php if (!isset($_GET['index_menu'])  && !isset($_SESSION['index_menu'])) { ?>
            <div class="admin-use">
                <a href="admin/login" title="แอดมินระบบ" onclick="alert('แจ้งเตือน\nเมนูนี้สำหรับผู้ดูแลระบบใช้งานเท่านั้น')"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
            </div>
        <?php } ?>
    </div>


    <!-- Vendor JS -->
    <script src="assets/js/vendors.min.js"></script>
    <script src="assets/icons/feather-icons/feather.min.js"></script>

    <!-- Florence Admin App -->
    <!-- <script src="assets/js/template.js"></script> -->

    <script>
        $(document).ready(function() {
            <?php if (isset($_GET['index_menu']) || isset($_SESSION['index_menu'])) {
                if ($_SESSION['index_menu'] == 4) {
                    echo '$(".custom-student").click()';
                } else if ($_SESSION['index_menu'] == 3) {
                    echo '$(".custom-teacher").click()';
                } else if ($_SESSION['index_menu'] == 5) {
                    echo '$(".custom-edu").click()';
                } else {
                    echo '$(".custom-boss").click()';
                }
            } ?>
        })

        function redirect(index_menu) {
            location.href = 'view-grade/login?index_menu=' + index_menu;
        }

        function search() {
            let searchParam = $('#search').val();
            if (searchParam == '') {
                alert('โปรดกรอกข้อมูลที่ต้องการค้นหา');
                return
            }
            location.href = "view-grade/login?system=student-tracking&search=" + searchParam;
        }

        function closeOtherMenus(button, btnNumber, collapseTargets) {
            var targets = document.querySelectorAll(collapseTargets);
            targets.forEach(function(target) {
                if (target !== null) {
                    $(target).collapse('hide');
                }
            });

            // Determine the custom-active class based on the button number
            let classActive = "";
            if (btnNumber == 1) {
                classActive = "custom-active-student";
            } else if (btnNumber == 2) {
                classActive = "custom-active-teacher";
            } else if (btnNumber == 5) {
                classActive = "custom-active-edu";
            } else {
                classActive = "custom-active-boss";
            }

            // Check if the button already has the active class
            const isAlreadyActive = button.classList.contains(classActive);

            // Remove custom-active class from all buttons
            document.querySelectorAll('.btn').forEach(function(btn) {
                btn.classList.remove(classActive);
                if (btnNumber == 1) {
                    btn.classList.remove("custom-active-teacher");
                    btn.classList.remove("custom-active-boss");
                } else if (btnNumber == 2) {
                    btn.classList.remove("custom-active-student");
                    btn.classList.remove("custom-active-boss");
                } else {
                    btn.classList.remove("custom-active-student");
                    btn.classList.remove("custom-active-teacher");
                }
            });

            // Toggle the custom-active class on the clicked button
            button.classList.toggle(classActive, !isAlreadyActive);
        }


        function checkRoleSystem(system, url) {
            let systemText = "";
            let systemTitle = "";

            if (system === 'visit-online') {
                systemText = "visit_online";
                systemTitle = "ระบบนิเทศการสอน ติดตามการปฏิบัติงาน";
            } else if (system === 'student-tracking') {
                systemText = "std_tracking";
                systemTitle = "ระบบฐานข้อมูลนักศึกษา";
            } else if (system === 'reading') {
                systemText = "reading";
                systemTitle = "หัวข้อส่งเสริมการอ่าน";
            } else if (system === 'view-grade') {
                systemText = "view_grade";
                systemTitle = "ระบบสืบค้นผลการเรียน";
            } else if (system === 'after') {
                systemText = "after";
                systemTitle = "หัวข้อแบบติดตามหลังจบการศึกษา";
            } else if (system === 'search') {
                systemText = "search";
                systemTitle = '<?php echo isset($_SESSION['index_menu']) && $_SESSION['index_menu'] == 5 ? "หัวข้อสืบค้นวุฒิการศึกษา" : "หัวข้อทะเบียนผู้จบการศึกษา" ?>';
            } else if (system === 'see_people') {
                systemText = "see_people";
                systemTitle = "หัวข้อฐานข้อมูลประชากรด้านการศึกษา";
            } else if (system === 'estimate') {
                systemText = "estimate";
                systemTitle = "หัวข้อประเมินคุณธรรมนักศึกษา";
            } else if (system === 'dashboard') {
                systemText = "dashboard";
                systemTitle = "แดชบอร์ดข้อมูลภาพรวม";
            }

            $.ajax({
                type: "POST",
                url: "checkSystem",
                data: {
                    mode: 'checkSystem',
                    systemText: systemText
                },
                success: function(data) {
                    if (data != "") {
                        let dataJson = JSON.parse(data);
                        if (dataJson.status) {
                            location.href = url;
                        } else {
                            alert("ไม่สามารถใช้งานเมนูได้ เนื่องจากแอดมินระบบไม่ได้เปิดสิทธิ์ใช้งาน\n" + systemTitle + " ให้กับคุณ \nโปรดติดต่อแอดมินระบบ")
                        }
                    }
                },
            });

            return false;
        }
    </script>

    <script>
        function logout() {
            const text = "ต้องการออกจากระบบหรือไม่ ?";
            if (confirm(text)) {
                $.ajax({
                    type: "POST",
                    url: "view-grade/controllers/login_controller",
                    data: {
                        logout_method: true,
                    },
                    success: function(data) {
                        const json_data = JSON.parse(data);
                        if (json_data.status) {
                            window.location.href = "main_menu";
                        }
                    },
                });
            } else {
                return;
            }
        }
    </script>
</body>

</html>