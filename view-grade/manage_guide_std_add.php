<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการการแนะแนวและให้คำปรึกษา</title>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <?php if ($_SESSION['user_data']->role_id == 3) { ?>
            <style>
                .sidebar-footer a {
                    width: 50%;
                }

                .user-profile .info {
                    height: 65px;
                }

                .sidebar-menu {
                    padding-bottom: 0px;
                }
            </style>
            <aside class="main-sidebar">
                <?php $routeName =  basename($_SERVER["SCRIPT_FILENAME"], '.php'); ?>
                <!-- sidebar-->
                <section class="sidebar" style="position: relative;">
                    <!-- sidebar menu-->
                    <ul class="sidebar-menu" data-widget="tree" style="margin-bottom:20px;">
                        <li class="<?php echo $routeName == "manage_guide_std_add" ? 'active' : '' ?>">
                            <a href="manage_guide_std">
                                <i class="fa fa-file-text" aria-hidden="true" style="margin-right: 5px;"></i>
                                <span>การแนะแนวและให้คำปรึกษา</span>
                            </a>
                        </li>
                        <!-- <li class="<?php echo $routeName == "manage_kpc_add" ||  $routeName == "manage_kpc_edit" ? 'active' : '' ?>">
                            <a href="manage_kpc">
                                <i class="fa fa-file-text-o" aria-hidden="true" style="margin-right: 5px;"></i>
                                <span>ผลวิเคราะห์ข้อมูลผู้เรียน</span>
                            </a>
                        </li> -->
                    </ul>
                    <div class="sidebar-footer" style="position: absolute;bottom: auto;">
                        <!-- item-->
                        <a href="../main_menu" class="link link-edu-btn" data-toggle="tooltip" title="หน้าหลัก" data-original-title="หน้าหลัก">
                            <i class="fa fa-list"></i>
                            <span style="font-size: 12px;">หน้าเมนูหลัก</span>
                        </a>
                    </div>
                </section>
            </aside>
        <?php } ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" <?php echo $_SESSION['user_data']->role_id != 3 ? 'style="margin: 0px;"' : '' ?>>
            <div class="container-full">

                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $g_data = [];
                if (isset($_GET['g_id']) || isset($_GET['view'])) {
                    if (isset($_GET['view']) && !isset($_GET['g_id'])) {
                        $whereCase = " WHERE g.std_id = :std_id";
                        $param = ['std_id' => $_SESSION['user_data']->edu_type];
                    } else {
                        $whereCase = " WHERE g_id = :g_id";
                        $param = ['g_id' => $_GET['g_id']];
                    }
                    $sql = "SELECT g.*, std.std_id, CONCAT(std.std_prename, std.std_name) std_name,CONCAT(u.name, ' ',u.surname) user_name FROM vg_guide_std g
                        LEFT JOIN tb_students std ON std.std_id = g.std_id
                        LEFT JOIN tb_users u ON u.id = g.user_create " . $whereCase;
                    $data = $DB->Query($sql, $param);
                    $g_data = json_decode($data);
                }
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">

                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;">
                                            <?php if ($_SESSION['user_data']->role_id != 4) {
                                                $user_id = isset($_GET['user_id']) ? "?user_id=" . $_GET['user_id'] . "&" : '';
                                                $name = isset($_GET['name']) ? "name=" . $_GET['name'] . "&" : '';
                                                $pro = isset($_GET['pro']) ? "pro=" . $_GET['pro'] . "&" : '';
                                                $dis = isset($_GET['dis']) ? "dis=" . $_GET['dis'] . "&" : '';
                                                $sub = isset($_GET['sub']) ? "sub=" . $_GET['sub'] . "&" : '';
                                                $page_number = isset($_GET['page_number']) ? "page_number=" . $_GET['page_number'] : '';
                                            ?>
                                                <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='<?php echo 'manage_guide_std' .  $user_id . $name . $pro . $dis . $sub .  $page_number ?>'"></i>
                                            <?php }
                                            ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-text mr-15"></i>
                                            <b>การแนะแนวและให้คำปรึกษา</b>
                                        </h4>
                                    </div>
                                </div>
                                <?php if (!isset($_GET['view'])) { ?>
                                    <form class="form" id="form_guide_std_add">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-6">
                                                    <div class="row">
                                                        <?php if (!isset($_GET['g_id'])) { ?>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>ค้นหาด้วยชั้น</label>
                                                                    <select class="form-control select2" name="std_class" id="std_class" data-placeholder="ชั้น" style="width: 100%;" onchange="getDataStd_new(this.value)">
                                                                        <option value="">ชั้นทั้งหมด</option>
                                                                        <option value="ประถม">ประถม</option>
                                                                        <option value="ม.ต้น">ม.ต้น</option>
                                                                        <option value="ม.ปลาย">ม.ปลาย</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="col-md-<?php echo !isset($_GET['g_id']) ? 8 : 12 ?>">
                                                            <div class="form-group">
                                                                <?php if (!isset($_GET['g_id'])) { ?>
                                                                    <label>เลือกนักศึกษา</label>
                                                                <?php } ?>
                                                                <select class="form-control select2" name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;" <?php echo !isset($_GET['g_id']) ? "" : "disabled" ?>>
                                                                    <?php if (count($g_data) > 0 && isset($_GET['g_id'])) { ?>
                                                                        <option selected><?php echo $g_data[0]->std_name ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="font-weight-bold">ด้านการเรียน</label>
                                                        <textarea class="form-control" rows="3" id="learning" name="learning"><?php echo !isset($_GET['g_id']) ? "" : $g_data[0]->learning ?></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="font-weight-bold">ด้านทักษะอาชีพ</label>
                                                        <textarea class="form-control" rows="3" id="skill" name="skill"><?php echo !isset($_GET['g_id']) ? "" : $g_data[0]->skill ?></textarea>
                                                    </div>

                                                    <label class="font-weight-bold">ด้านอื่นๆ ที่นักศึกษาขอคำปรึกษา</label>

                                                    <div class="form-group row">
                                                        <label for="other_subject" class="col-sm-2 col-form-label">เรื่อง</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" value="<?php echo !isset($_GET['g_id']) ? "" : $g_data[0]->other_subject ?>" id="other_subject" name="other_subject">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="other_consult" class="col-sm-2 col-form-label">การให้คำปรึกษา</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" value="<?php echo !isset($_GET['g_id']) ? "" : $g_data[0]->other_consult ?>" id="other_consult" name="other_consult">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="font-weight-bold">การวางแผน / การนัดหมายครั้งต่อไป</label>
                                                        <input type="text" class="form-control" id="plan" name="plan" value="<?php echo !isset($_GET['g_id']) ? "" : $g_data[0]->plan ?>">
                                                        <input type="hidden" name="insert_guide">
                                                        <?php if (isset($_GET['g_id'])) { ?>
                                                            <input type="hidden" name="g_id" value="<?php echo $_GET['g_id'] ?>">
                                                            <input type="hidden" name="std_id" value="<?php echo $g_data[0]->std_id ?>">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                                <i class="ti-save-alt"></i> บันทึกข้อมูล
                                            </button>
                                        </div>
                                    </form>
                                <?php } else { ?>
                                    <!-- 🔹 ปุ่มพิมพ์ -->
                                    <?php if (count($g_data) > 0) { ?>
                                        <div class="text-right mr-3 mt-4">
                                            <button class="btn btn-primary print-button" onclick="printContent()">พิมพ์ข้อมูล</button>
                                        </div>
                                    <?php } ?>
                                    <div class="container print-container" id="printArea">
                                        <h4 class="text-center mt-4">การแนะแนวและให้คําปรึกษา</h4>

                                        <?php if (count($g_data) == 0) { ?>
                                            <div class="mt-3 text-center mb-4">
                                                <strong>ไม่พบข้อมูล</span>
                                            </div>
                                        <?php
                                        } else { ?>
                                            <div class="mt-3">
                                                <strong>ชื่อ - นามสกุล :</strong> <span> <?php echo $g_data[0]->std_name ?> </span>
                                            </div>

                                            <div class="mt-3">
                                                <div><strong>ด้านการเรียน</strong></div>
                                                <p><?php echo $g_data[0]->learning ?></p>
                                                <hr>
                                            </div>

                                            <div class="mt-3">
                                                <div><strong>ด้านความสามารถพิเศษ</strong></div>
                                                <p><?php echo $g_data[0]->skill ?></p>
                                                <hr>
                                            </div>

                                            <div class="mt-4">
                                                <p><strong>ด้านอื่น ๆ ที่นักศึกษาขอคำปรึกษา</strong></p>
                                                <p><strong>เรื่อง :</strong> <?php echo $g_data[0]->other_subject ?></p>
                                                <p><strong>การให้คำปรึกษา :</strong> <?php echo $g_data[0]->other_consult ?></p>
                                            </div>

                                            <div class="mt-4">
                                                <strong>การวางแผน / การนัดหมายครั้งต่อไป</strong>
                                                <p><?php echo $g_data[0]->plan ?></p>
                                            </div>

                                            <!-- 🔹 ส่วนลงชื่อ แยกซ้าย-ขวา -->
                                            <div class="row signature-box" style="margin-top: 100px;margin-bottom: 100px;">
                                                <div class="col-6 text-center">
                                                    <p class="m-0">ลงชื่อ .......................................................................................................</p>
                                                    <p class="text-center m-0"><?php echo $g_data[0]->std_name ?></p>
                                                </div>
                                                <div class="col-6 text-center">
                                                    <p class="m-0">ลงชื่อ .......................................................................................................</p>
                                                    <p class="text-center m-0"><?php echo $g_data[0]->user_name ?></p>
                                                </div>
                                            </div>
                                    </div>

                                    <!-- CSS สำหรับ Print -->
                                    <style>
                                        @media print {
                                            body {
                                                -webkit-print-color-adjust: exact;
                                            }

                                            .print-button {
                                                display: none;
                                            }

                                            /* ป้องกันการแสดงผลของหน้าเปล่า */
                                            html,
                                            body {
                                                height: auto;
                                                /* ทำให้ความสูงของหน้าไม่ถูกกำหนด */
                                                margin: 0;
                                                /* ลบมาร์จิ้น */
                                                padding: 0;
                                                /* ลบ Padding */
                                            }
                                        }

                                        .signature-box {
                                            margin-top: 40px;
                                        }
                                    </style>
                                <?php } ?>
                            <?php  } ?>
                            </div>
                        </div>

                    </div>
                </section>
                <!-- /.content -->
                <div class="preloader">
                    <?php include "../include/loader_include.php"; ?>
                </div>

            </div>
        </div>
        <!-- /.content-wrapper -->

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        function printContent() {
            var printContent = document.getElementById("printArea").innerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            location.reload(); // รีโหลดหน้าเพื่อคืนค่าเดิม
        }

        $(document).ready(function() {
            <?php if (!isset($_GET['g_id']) && !isset($_GET['view'])) { ?>
                $("#std_select").select2();
                getDataStd_new();
            <?php } ?>
        });

        function getDataStd_new(std_class = "") {
            $.ajax({
                type: "POST",
                url: "../student-tracking/controllers/student_controller",
                data: {
                    getDataStudent: true,
                    std_class: std_class
                },
                dataType: "json",
                success: function(json_res) {
                    const std_select = document.getElementById("std_select");
                    std_select.innerHTML = "";
                    std_select.innerHTML += `<option value="0">เลือกนักศึกษา</option>`;
                    data_std = json_res.data
                    data_std.forEach((element, i) => {
                        std_select.innerHTML += `<option value="${element.std_id}">${element.std_code} - ${element.std_prename}${element.std_name}</option>`;
                    });
                },
            });
        }

        // Attach a submit handler to the form
        $('#form_guide_std_add').on('submit', function(event) {
            // Prevent the form from submitting the traditional way
            event.preventDefault();

            // Serialize the form data
            var formData = $(this).serialize();

            if ($('#std_select').val() == "0") {
                alert("โปรดเลือกนักศึกษา")
                $('#std_select').focus();
                return false;
            }

            // Send the AJAX request
            $.ajax({
                url: 'controllers/guide_std_controller', // Replace with your API endpoint
                type: 'POST',
                data: formData, // or JSON.stringify(formData) if using JSON object
                dataType: 'json',
                success: function(json) {
                    alert(json.msg);
                    if (json.status) {
                        // window.location.href = role_id == 4 ? 'students_data' : "form1_1_new";
                        window.location.href = "manage_guide_std";
                    }
                }
            });
        });
    </script>
</body>

</html>