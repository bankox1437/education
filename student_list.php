<?php
session_start();
if (!isset($_SESSION['user_data'])) {
    $_SESSION['std_import'] = 1;
    header('location:  view-grade/login');
}

if ($_SESSION['user_data']->role_id != 3) {
    unset($_SESSION['user_data']);
    echo '<script>alert("ไม่สามารถเข้าใช้งานเมนูนี้ได้");location.href = "index";</script>';
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
    <style>
        .import-excel {
            display: inline-block;
            background-color: #1e613b;
            color: white;
            cursor: pointer;
        }

        .example-import {
            display: inline-block;
            padding: 0.5rem;
            border-radius: 0.3rem;
            cursor: pointer;
            text-decoration: none;
        }

        .table tbody tr td {
            padding: 5px;
        }

        .delete_multi_std {
            margin-top: 10px;
        }

        .delete_std {
            font-size: 14px;
        }

        .preloader {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
        }

        .overflow-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            /* You can add other styling properties as needed */
            max-width: 270px;
            /* Set a maximum width if desired */
        }

        @media screen and (max-width: 576px) {
            .overflow-ellipsis {
                max-width: 170px;
                /* Set a maximum width if desired */
                font-size: 14px;
            }

            .back-main {
                font-size: 14px;
            }

            .back-text {
                display: none;
            }
        }

        @media (min-width: 811px) {
            .overflow-ellipsis {
                max-width: 500px;
                /* Set a maximum width if desired */
            }
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">
    <div class="wrapper">

        <?php //include 'include/nav-header.php'; 
        ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php //include 'include/sidebar.php'; 
        ?>
        <header class="main-header">
            <div class="d-flex align-items-center logo-box justify-content-start">

            </div>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top pl-10" style="flex-wrap: unset;">
                <!-- Sidebar toggle button-->
                <div class="app-menu">
                    <ul class="header-megamenu nav">
                        <li class="dropdown user user-menu">
                            <?php
                            $url = isset($_GET['url']) ? "view-grade/" . $_GET['url'] : 'main_menu?index_menu=2';
                            ?>
                            <a href="<?php echo $url ?>" style="width: 100px;" class="text-primary back-main"><i class="ti-arrow-left"></i><span class="back-text">กลับหน้าเมนูหลัก</span></a>
                        </li>
                    </ul>
                </div>

                <div class="navbar-custom-menu r-side">
                    <ul class="nav navbar-nav">
                        <li class="btn-group nav-item d-lg-inline-flex">
                            <h3 style="margin-top: 13px;" class="overflow-ellipsis"><?php
                                                                                    echo $_SESSION['user_data']->name . " " . $_SESSION['user_data']->surname . "  ";
                                                                                    if ($_SESSION['user_data']->edu_name != null) {
                                                                                        if ($_SESSION['user_data']->role_id == 3) {
                                                                                            echo $_SESSION['user_data']->edu_name;
                                                                                        } else {
                                                                                            echo $_SESSION['user_data']->name . " " . $_SESSION['user_data']->surname;
                                                                                        }
                                                                                    } else if ($_SESSION['user_data']->edu_name == null && $_SESSION['user_data']->role_id == 2) {
                                                                                        echo "อำเภอ-" . $_SESSION['user_data']->district_am;
                                                                                    } else {
                                                                                        echo  'แอดมินเจ้าของระบบ';
                                                                                    }
                                                                                    ?></h3>
                        </li>
                        <li class="btn-group nav-item d-lg-inline-flex d-none">
                            <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link rounded full-screen" title="Full Screen">
                                <i class="ti-fullscreen"></i>
                            </a>
                        </li>

                        <!-- User Account-->
                        <li class="dropdown user user-menu">
                            <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown" title="User">
                                <i class="ti-power-off text-danger"></i>
                            </a>
                            <ul class="dropdown-menu animated flipInX">
                                <li class="user-body">
                                    <a class="dropdown-item" href="view-grade/edit_admin?url=<?php echo "https://do-el.net/student_list" ?>"><i class=" ti-user text-muted mr-2"></i>แก้ไขโปรไฟล์</a>
                                </li>
                                <?php if ($_SESSION['user_data']->role_id == 3) {
                                    // Get the protocol (HTTP or HTTPS)
                                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

                                    // Get the hostname
                                    $host = $_SERVER['HTTP_HOST'];

                                    // Construct the full URL
                                    $fullUrl = $protocol . $host;
                                    $fullUrl .= "/edu"; // localhost
                                ?>
                                    <li class="user-body">
                                        <a class="dropdown-item" href="<?php echo $fullUrl ?>/view-grade/manage_private_data?url=<?php echo $fullUrl . "/" . explode('/', $_SERVER['REQUEST_URI'])[2] ?>"><i class="fa fa-address-card-o text-muted mr-2"></i>ข้อมูลส่วนตัวครู</a>
                                    </li>
                                <?php } ?>
                                <li class="user-body">
                                    <a class="dropdown-item" onclick="logout()" style="cursor: pointer;"><i class="ti-lock text-muted mr-2"></i>ออกจากระบบ</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">

                                    <div class="row mb-3">
                                        <div class="mb-0 mt-2 col-12 col-md-12 col-lg-2 col-xl-1">
                                            <h4 style="margin-bottom: 0;">รายชื่อนักศึกษา</h4>
                                        </div>
                                        <div class="mt-1 col-12 col-md-12 col-lg-2 col-xl-1">
                                            <a style="display: block;" class="waves-effect waves-light btn btn-success" href="view-grade/add_student"><i class="ti-plus"></i>&nbsp;เพิ่มนักศึกษา</a>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-2">
                                            <input type="file" id="import_excel_students" hidden accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel" onchange="importStudent(this)" />
                                            <label for="import_excel_students" class="import-excel text-center waves-effect waves-light btn mt-1" style="width: 100%;">
                                                <i class="ti-import"></i>&nbsp;&nbsp;นำเข้าข้อมูลนักศึกษาด้วย Excel
                                            </label>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-2 col-xl-1">
                                            <!-- <a href="student-tracking/images/example-students.xlsx" class="example-import col-md-6">ดาวน์โหลดตัวอย่าง Excel นักศึกษา <i class="fa fa-info-circle"></i></a> -->
                                            <a href="student-tracking/images/example-students.xlsx" download="" class="example-import pt-0" title="ไฟล์ตัวอย่างการนำเข้ารายชื่อนักศึกษา">
                                                ดาวน์โหลดตัวอย่าง Excel นักศึกษา <i class="fa fa-info-circle"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-2 mt-2 text-right">
                                            <a style="display: block;" class="waves-effect waves-light btn btn-info" href="#" id="change_multi_show"><i class="ti-widget-alt"></i>&nbsp;เลื่อนชั้นหลายรายการ</a>
                                            <a style="display: none;" class="waves-effect waves-light btn btn-info" href="#" id="cancel_change"><i class="ti-widget-alt"></i>&nbsp;ยกเลิก</a>
                                            <a style="display: none;" class="waves-effect waves-light btn btn-info" href="#" id="change_multi"><i class="ti-widget-alt"></i>&nbsp;เลื่อนชั้นจากที่เลือก</a>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-2 mt-2 text-right">
                                            <a style="display: block;" class="waves-effect waves-light btn-outline btn btn-danger" href="#" id="delete_multi_show_data"><i class="ti-widget-alt"></i>&nbsp;ลบข้อมูลหลายรายการ</a>
                                            <a style="display: none;" class="waves-effect waves-light btn-outline btn btn-danger" href="#" id="cancel_delete_data"><i class="ti-widget-alt"></i>&nbsp;ยกเลิก</a>
                                            <a style="display: none;" class="waves-effect waves-light btn-outline btn btn-danger" href="#" id="delete_multi_data"><i class="ti-widget-alt"></i>&nbsp;ลบข้อมูลที่เลือก</a>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-2 mt-2 text-right">
                                            <a style="display: block;" class="waves-effect waves-light btn btn-danger" href="#" id="delete_multi_show"><i class="ti-widget-alt"></i>&nbsp;ลบบัญชีหลายรายการ</a>
                                            <a style="display: none;" class="waves-effect waves-light btn btn-danger" href="#" id="cancel_delete"><i class="ti-widget-alt"></i>&nbsp;ยกเลิก</a>
                                            <a style="display: none;" class="waves-effect waves-light btn btn-danger" href="#" id="delete_multi"><i class="ti-widget-alt"></i>&nbsp;ลบบัญชีที่เลือก</a>
                                        </div>

                                    </div>

                                </div>
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-hover" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5px;">#</th>
                                                    <th>รหัสนักศึกษา</th>
                                                    <th>ชื่อ-สกุล นักศึกษา</th>
                                                    <th>ว/ด/ป เกิด</th>
                                                    <th class="text-center">เลขบัตร ปชช.</th>
                                                    <th class="text-center">รหัสผ่าน</th>
                                                    <th class="text-center" style="width: 100px;">
                                                        <span id="show_all_text_class">ชั้น</span>
                                                        <div id="show_all_text_checkbox_class" style="display: none;">
                                                            <input type="checkbox" id="ch_checkbox_all" class="filled-in chk-col-info">
                                                            <label for="ch_checkbox_all" style="padding-left: 20px"></label>
                                                        </div>
                                                    </th>
                                                    <th class="text-center">เพศ</th>
                                                    <!-- <th>บิดา</th>
                                                    <th>อาชีพ</th>
                                                    <th>มารดา</th>
                                                    <th>อาชีพ</th> 
                                                    <th>โทรศัพท์</th> -->
                                                    <th class="text-center">เข้าเรียนเมื่อ</th> 
                                                    <th class="text-center" style="width: 100px;">
                                                        <span id="show_all_text_data">ลบข้อมูล</span>
                                                        <div id="show_all_text_checkbox_data" style="display: none;">
                                                            <input type="checkbox" id="dt_checkbox_all" class="filled-in chk-col-danger">
                                                            <label for="dt_checkbox_all" style="padding-left: 20px"></label>
                                                        </div>
                                                    </th>
                                                    <th class="text-center" style="width: 100px;">
                                                        <span id="show_all_text">ลบบัญชี</span>
                                                        <div id="show_all_text_checkbox" style="display: none;">
                                                            <input type="checkbox" id="md_checkbox_all" class="filled-in chk-col-danger">
                                                            <label for="md_checkbox_all" style="padding-left: 20px"></label>
                                                        </div>
                                                    </th>
                                                    <th class="text-center" style="width: 150px;">สถานะ</th>
                                                    <th class="text-center" style="width: 100px;">แก้ไข</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body-screening-std">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
                <div class="preloader">
                    <?php include "include/loader_include.php"; ?>
                </div>

            </div>
        </div>
        <!-- /.content-wrapper -->

        <?php include 'include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <button type="button" class="btn btn-primary" id="click-show-modal" data-toggle="modal" data-target="#modal-center" style="visibility: hidden;">
    </button>
    <!-- Modal -->
    <div class="modal center-modal fade" id="modal-center" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เลือกลำดับชั้นถัดไป</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4" id="render_std_show" style="max-height: 300px;overflow-y: scroll;">
                        <p class="col-md-6 text-center">นางน้อมจิต แก้วมณี</p>
                    </div>

                    <div>
                        <select class="form-control" id="std_class_change" style="width: 100%;">
                            <option value="0">เลือกชั้น</option>
                            <option value="ประถม">ประถม</option>
                            <option value="ม.ต้น">ม.ต้น</option>
                            <option value="ม.ปลาย">ม.ปลาย</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer modal-footer-uniform">
                    <button type="button" class="btn btn-primary float-right" onclick="saveChangeClass()">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->


    <button type="button" class="btn btn-primary" id="click-show-modal-status" data-toggle="modal" data-target="#modal-center-status" style="visibility: hidden;">
    </button>
    <!-- Modal -->
    <div class="modal center-modal fade" id="modal-center-status" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เปลี่ยนสถานะนักศึกษา</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4" id="render_std_show_status" style="max-height: 300px;overflow-y: scroll;">
                        <p class="col-md-6 text-center">นางน้อมจิต แก้วมณี</p>
                    </div>

                    <div>
                        <input type="hidden" id="std_id_status" name="std_id_status" value="">
                        <select class="form-control" id="std_status_change" style="width: 100%;">
                            <option value="0">เลือกสถานะ</option>
                            <option value="กำลังศึกษา">กำลังศึกษา</option>
                            <option value="พักการเรียน">พักการเรียน</option>
                            <option value="จบการศึกษา">จบการศึกษา</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer modal-footer-uniform">
                    <button type="button" class="btn btn-primary float-right" onclick="saveChangeStatus()">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <button type="button" class="btn btn-primary" id="click-show-modal-gender" data-toggle="modal" data-target="#modal-center-gender" style="visibility: hidden;">
    </button>
    <!-- Modal -->
    <div class="modal center-modal fade" id="modal-center-gender" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ระบุเพศนักศึกษา</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4" id="render_std_show_gender" style="max-height: 300px;overflow-y: scroll;">
                        <p class="col-md-6 text-center">นางน้อมจิต แก้วมณี</p>
                    </div>

                    <div>
                        <input type="hidden" id="std_id_gender" name="std_id_gender" value="">
                        <select class="form-control" id="std_gender_change" style="width: 100%;">
                            <option value="0">เลือกเพศ</option>
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer modal-footer-uniform">
                    <button type="button" class="btn btn-primary float-right" onclick="saveChangeGender()">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->


    <button type="button" class="btn btn-primary" id="btn-hide-show-warning-import" data-toggle="modal" data-target="#modal-show-warning-import" style="visibility: hidden;">
    </button>
    <!-- Modal -->
    <div class="modal center-modal fade" id="modal-show-warning-import" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายการนำเข้าที่มีปัญหา</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 0;">
                    <div class="row">
                        <!-- <div style="max-height: 400px; overflow-y: auto;"> -->
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ-สกุล</th>
                                    <th>เหตุผล</th>
                                </tr>
                            </thead>
                            <tbody id="show-warning"></tbody>
                        </table>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- Vendor JS -->
    <script src="assets/js/vendors.min.js"></script>
    <script src="assets/icons/feather-icons/feather.min.js"></script>

    <!-- Florence Admin App -->
    <script src="assets/js/template.js"></script>
    <script src="assets/js/preloader.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script> -->
    <script src="assets/vendor_components/select2/dist/js/select2.full.js"></script>

    <!-- <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script> -->
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table-locale-all.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/export/bootstrap-table-export.min.js"></script>

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
                        console.log(json_data);
                        if (json_data.status) {
                            window.location.href = "index";
                        }
                    },
                });
            } else {
                return;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            <?php if (!isset($_SESSION['term_active']) && $_SESSION['user_data']->role_id == 3) { ?>
                document.getElementById("click-show-modal").click();
            <?php } ?>
            getDataStd();
        });

        function importStudent(file) {
            const CSVfile = file.files[0];
            var formData = new FormData();
            formData.append("csv_file", CSVfile);
            formData.append("import_students", true)

            var xhttp = new XMLHttpRequest();
            const url = "view-grade/controllers/std_controller.php";
            xhttp.open("POST", url, true);
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    if (response.status) {
                        alert(response.msg);
                        if (response.invalid_rows) {
                            let rowInvalid = response.invalid_rows;
                            rowInvalid.forEach(row => {
                                let errorText = "";
                                for (let i = 0; i < row.errors.length; i++) {
                                    if (i > 0) {
                                        errorText += ", <br>";
                                    }
                                    errorText += row.errors[i]
                                }
                                $('#show-warning').append(
                                    `
                                    <tr>
                                        <td  style="padding:10px;">${row.row_data[0]}</td>
                                        <td>${row.row_data[1]}</td>
                                        <td>${errorText}</td>
                                    </tr>
                                    `
                                )
                            });
                            $('#btn-hide-show-warning-import').click();
                        }
                        getDataStd();
                    } else {
                        alert(response.msg);
                        window.location.reload();
                    }

                    file.value = "";
                    file.files[0] = undefined;
                }
            };
            xhttp.send(formData);
        }

        function getDataStd() {
            const Tbody = document.getElementById('body-screening-std');
            Tbody.innerHTML = "";
            Tbody.innerHTML += `
                    <tr>
                        <td colspan="12" class="text-center">
                            <?php include "include/loader_include.php"; ?>
                        </td>
                    </tr>
                `
            $.ajax({
                type: "POST",
                url: "student-tracking/controllers/student_controller",
                data: {
                    getDataStudent: true,
                    all: true
                },
                dataType: 'json',
                success: function(json_res) {
                    genHtmlTable(json_res.data)
                },
            });
        }

        function genHtmlTable(data) {
            const Tbody = document.getElementById('body-screening-std');
            Tbody.innerHTML = "";
            if (data.length == 0) {
                Tbody.innerHTML += `
                    <tr>
                        <td colspan="12" class="text-center">
                            ไม่มีข้อมูล
                        </td>
                    </tr>
                `
                return;
            }
            data.forEach((element, i) => {
                let text_color_status = "";
                switch (element.std_status) {
                    case "พักการเรียน":
                        text_color_status = "text-warning";
                        break;
                    case "กำลังศึกษา":
                        text_color_status = "text-info";
                        break;
                    case "จบการศึกษา":
                        text_color_status = "text-success";
                        break;
                    default:
                        break;
                }

                let text_color_gender = "";
                switch (element.std_gender) {
                    case "ชาย":
                        text_color_gender = "#5BCFFA";
                        break;
                    case "หญิง":
                        text_color_gender = "#F5AAB9";
                        break;
                    default:
                        text_color_gender = "#000";
                        break;
                }

                if(!element.std_term) {
                    element.std_term = '-'
                }

                if(!element.std_year) {
                    element.std_year = '-'
                }


                Tbody.innerHTML += `
                    <tr>
                        <td class="text-center">${i+1}</td>
                        <td>${element.std_code}</td>
                        <td>${element.std_prename}${element.std_name}</td>
                        <td>${element.std_birthday}</td>
                        <td class="text-center">${element.national_id}</td>
                        <td class="text-center">${element.password}</td>
                        <td class="text-center">
                            ${element.std_class}
                            <div class="change_multi_std" style="display:none">
                                <input type="checkbox" id="ch_checkbox_${i}" value="${element.std_id}" data-stdName="${element.std_prename}${element.std_name}" class="filled-in chk-col-info" onchange="check_cancel('change_multi_std','change_multi_show','change_multi','cancel_change')">
                                <label for="ch_checkbox_${i}" style="padding-left: 20px"></label>
                            </div>
                            <button type="button" class="btn-xs waves-effect waves-circle btn btn-circle btn-info mb-5 change_std" onclick="openmModalChangeClass(${element.std_id},'${element.std_prename}${element.std_name}')">
                                <i class="fa fa-exchange"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            ${element.std_gender != '-' ? `<span style="color:${text_color_gender}"><b>${element.std_gender}</b></span>` : 
                            `<button type="button" class="btn-xs waves-effect btn btn-outline btn-success mb-5" onclick="openmModalChangeGender(${element.std_id},'${element.std_prename}${element.std_name}')">ระบุเพศ</button>`}
                        </td>
                        <td class="text-center">${element.std_term + '/' + element.std_year}</td>
                        <td class="text-center">
                            <div class="delete_multi_std_data" style="display:none">
                                <input type="checkbox" id="dt_checkbox_${i}" value="${element.std_id}" class="filled-in chk-col-danger" onchange="check_cancel('delete_multi_std_data','delete_multi_show_data','delete_multi_data','cancel_delete_data')">
                                <label for="dt_checkbox_${i}" style="padding-left: 20px"></label>
                            </div>
                            <button type="button" class="btn-xs waves-effect waves-circle btn btn-circle btn-outline btn-danger mb-5 delete_std_data" onclick="deleteStd(${
                                element.std_id
                                },'${element.std_prename}${element.std_name}','deleteStd')"><i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <div class="delete_multi_std" style="display:none">
                                <input type="checkbox" id="md_checkbox_${i}" value="${element.std_id}" class="filled-in chk-col-danger" onchange="check_cancel('delete_multi_std','delete_multi_show','delete_multi','cancel_delete')">
                                <label for="md_checkbox_${i}" style="padding-left: 20px"></label>
                            </div>
                            <button type="button" class="btn-xs waves-effect waves-circle btn btn-circle btn-danger mb-5 delete_std" onclick="deleteStd(${
                                element.std_id
                                },'${element.std_prename}${element.std_name}','deleteStd')"><i class="fa fa-user-times" aria-hidden="true"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <span class="${text_color_status}"><b>${element.std_status}</b></span>
                            <button type="button" 
                            class="btn-xs waves-effect waves-circle btn btn-circle btn-outline btn-success mb-5" onclick="openmModalChangeStatus(${element.std_id},'${element.std_prename}${element.std_name}')"><i class="fa fa-exchange"></i></button>
                        </td>
                        <td class="text-center">
                            <a href="view-grade/manage_students?std_id=${element.std_id}<?php echo isset($_GET['url']) ? "&url_redirect=" . $_GET['url'] : "" ?>" class="btn-xs waves-effect waves-circle btn btn-circle btn-warning mb-5">
                                <i class="ti-pencil-alt" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                `;
            });
        }

        function deleteStd(id, std_class, mode = "") {
            let text = "ต้องการลบข้อมูลของ " + std_class + " หรือไม่?";
            if (mode == "deleteStd") {
                text = "ต้องการลบบัญชีของ " + std_class + " หรือไม่?";
            }
            const confirmDelete = confirm(text);

            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "student-tracking/controllers/student_controller",
                    data: {
                        delete_std: true,
                        id: id,
                        mode: mode
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            getDataStd()
                        } else {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                });
            }
        }


        $('#delete_multi_show').click(() => {
            const delete_multi_std = $('.delete_multi_std')
            const delete_std = $('.delete_std');
            $('#delete_multi_show').hide()
            $('#cancel_delete').show()
            $('#cancel_delete').css('display', 'block');
            for (let i = 0; i < delete_std.length; i++) {
                delete_std[i].style.display = 'none'
                delete_multi_std[i].style.display = 'block'
            }
            $('#show_all_text_checkbox').show()
            $('#show_all_text').text('ลบบัญชีทั้งหมด')
        });

        $('#change_multi_show').click(() => {
            const change_multi_std = $('.change_multi_std')
            const change_std = $('.change_std');
            $('#change_multi_show').hide()
            $('#cancel_change').show()
            $('#cancel_change').css('display', 'block');
            for (let i = 0; i < change_std.length; i++) {
                change_std[i].style.display = 'none'
                change_multi_std[i].style.display = 'block'
            }
            $('#show_all_text_checkbox_class').show()
            $('#show_all_text_class').text('เลื่อนชั้นทั้งหมด')
        });

        $('#delete_multi_show_data').click(() => {
            const delete_multi_std_data = $('.delete_multi_std_data')
            const delete_std_data = $('.delete_std_data');
            $('#delete_multi_show_data').hide()
            $('#cancel_delete_data').show()
            $('#cancel_delete_data').css('display', 'block');
            for (let i = 0; i < delete_std_data.length; i++) {
                delete_std_data[i].style.display = 'none'
                delete_multi_std_data[i].style.display = 'block'
            }
            $('#show_all_text_checkbox_data').show()
            $('#show_all_text_data').text('ลบข้อมูลทั้งหมด')
        });

        function check_cancel(class_multi_std, class_multi_show, class_multi, cancel_class) {
            const delete_multi_std = $('.' + class_multi_std);
            let check = false;
            for (let i = 0; i < delete_multi_std.length; i++) {
                if (delete_multi_std[i].children[0].checked == true) {
                    check = true;
                    changeBox = 1
                    break;
                }
                changeBox = 0
            }
            $('#' + class_multi_show).hide()
            if (check) {
                $('#' + class_multi).show()
                $('#' + class_multi).css('display', 'block')
                $('#' + cancel_class).hide()
            } else {
                $('#' + cancel_class).show()
                $('#' + cancel_class).css('display', 'block')
                $('#' + class_multi).hide()
            }
        }

        $('#cancel_delete').click(() => {
            $('#delete_multi_show').show()
            $('#cancel_delete').hide()
            $('#show_all_text_checkbox').hide()
            $('#show_all_text').text('ลบ')
            changeBox = 0
            const delete_multi_std = $('.delete_multi_std')
            const delete_std = $('.delete_std');
            for (let i = 0; i < delete_std.length; i++) {
                delete_std[i].style.display = 'inline-block'
                delete_multi_std[i].style.display = 'none'
            }
        });

        $('#cancel_change').click(() => {
            $('#change_multi_show').show()
            $('#cancel_change').hide()
            $('#show_all_text_checkbox_class').hide()
            $('#show_all_text_class').text('ลบ')
            changeBox = 0
            const change_multi_std = $('.change_multi_std')
            const change_std = $('.change_std');
            for (let i = 0; i < change_std.length; i++) {
                change_std[i].style.display = 'inline-block'
                change_multi_std[i].style.display = 'none'
            }
        });

        $('#cancel_delete_data').click(() => {
            $('#delete_multi_show_data').show()
            $('#cancel_delete_data').hide()
            $('#show_all_text_checkbox_data').hide()
            $('#show_all_text_data').text('ลบ')
            changeBox = 0
            const delete_multi_std_data = $('.delete_multi_std_data')
            const delete_std_data = $('.delete_std_data');
            for (let i = 0; i < delete_std_data.length; i++) {
                delete_std_data[i].style.display = 'inline-block'
                delete_multi_std_data[i].style.display = 'none'
            }
        });


        $('#show_all_text_checkbox').change((e) => {
            const delete_multi_std = $('.delete_multi_std');
            if (e.target.checked) {
                $('#delete_multi').show()
                $('#delete_multi').css('display', 'block');
                $('#cancel_delete').hide()
                changeBox = 1
                for (let i = 0; i < delete_multi_std.length; i++) {
                    delete_multi_std[i].children[0].checked = true
                }
            } else {
                $('#cancel_delete').show()
                $('#delete_multi').hide()
                for (let i = 0; i < delete_multi_std.length; i++) {
                    delete_multi_std[i].children[0].checked = false
                }
            }
        })

        $('#show_all_text_checkbox_class').change((e) => {
            const change_multi_std = $('.change_multi_std');
            if (e.target.checked) {
                $('#change_multi').show()
                $('#change_multi').css('display', 'block');
                $('#cancel_change').hide()
                changeBox = 1
                for (let i = 0; i < change_multi_std.length; i++) {
                    change_multi_std[i].children[0].checked = true
                }
            } else {
                $('#cancel_change').show()
                $('#change_multi').hide()
                for (let i = 0; i < change_multi_std.length; i++) {
                    change_multi_std[i].children[0].checked = false
                }
            }
        })

        $('#show_all_text_checkbox_data').change((e) => {
            const delete_multi_std_data = $('.delete_multi_std_data');
            if (e.target.checked) {
                $('#delete_multi_data').show()
                $('#delete_multi_data').css('display', 'block');
                $('#cancel_delete_data').hide()
                changeBox = 1
                for (let i = 0; i < delete_multi_std_data.length; i++) {
                    delete_multi_std_data[i].children[0].checked = true
                }
            } else {
                $('#cancel_delete_data').show()
                $('#delete_multi_data').hide()
                for (let i = 0; i < delete_multi_std_data.length; i++) {
                    delete_multi_std_data[i].children[0].checked = false
                }
            }
        })


        $('#delete_multi').click(() => {
            const delete_multi_std = $('.delete_multi_std')
            const array_delete = [];
            for (let i = 0; i < delete_multi_std.length; i++) {
                if (delete_multi_std[i].children[0].checked) {
                    array_delete.push(delete_multi_std[i].children[0].value)
                }
            }
            const confirmDelete = confirm(
                "ต้องการลบข้อมูลนักศึกษาที่เลือกหรือไม่?"
            );

            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "student-tracking/controllers/student_controller",
                    data: {
                        delete_multiple_std: true,
                        arr_edu_id: JSON.stringify(array_delete),
                        mode: "deleteStd",
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            $('#delete_multi_show').show()
                            $('#cancel_delete').hide()
                            $('#show_all_text_checkbox').hide()
                            $('#show_all_text').text('ลบ')
                            $('#delete_multi').hide()
                            $('#md_checkbox_all').prop('checked', false);
                            getDataStd()
                        } else {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                });
            }
        })

        let array_change = [];
        $('#change_multi').click(() => {
            const confirmchange = confirm(
                "ต้องการเลื่อนชั้นนักศึกษาที่เลือกหรือไม่?"
            );
            if (confirmchange) {
                array_change = [];
                const change_multi_std = $('.change_multi_std');
                $('#render_std_show').empty();
                for (let i = 0; i < change_multi_std.length; i++) {
                    if (change_multi_std[i].children[0].checked) {
                        let std_name = change_multi_std[i].children[0].getAttribute("data-stdName");
                        array_change.push({
                            "std_id": change_multi_std[i].children[0].value,
                            "std_name": std_name
                        })

                        $('#render_std_show').append(`<p class="col-md-6 text-center">${std_name}</p>`)
                    }
                }
                document.getElementById("click-show-modal").click();
                return;
            }
        })

        $('#delete_multi_data').click(() => {
            const delete_multi_std_data = $('.delete_multi_std_data')
            const array_delete_data = [];
            for (let i = 0; i < delete_multi_std_data.length; i++) {
                if (delete_multi_std_data[i].children[0].checked) {
                    array_delete_data.push(delete_multi_std_data[i].children[0].value)
                }
            }
            const confirmDelete = confirm(
                "ต้องการลบข้อมูลนักศึกษาที่เลือกหรือไม่?"
            );

            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "student-tracking/controllers/student_controller",
                    data: {
                        delete_multiple_std: true,
                        arr_edu_id: JSON.stringify(array_delete_data),
                        mode: "delete_data",
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            $('#delete_multi_show_data').show()
                            $('#cancel_delete_data').hide()
                            $('#show_all_text_checkbox_data').hide()
                            $('#show_all_text_data').text('ลบ')
                            $('#delete_multi_data').hide()
                            $('#dt_checkbox_all').prop('checked', false);
                            getDataStd()
                        } else {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                });
            }
        })

        function openmModalChangeClass(std_id, std_name) {
            array_change = [];
            array_change.push({
                "std_id": std_id,
                "std_name": std_name
            })
            $('#render_std_show').empty();
            $('#render_std_show').append(`<p class="col-md-12 text-center">${std_name}</p>`)
            document.getElementById("click-show-modal").click();
        }

        function openmModalChangeStatus(std_id, std_name) {
            // array_change = [];
            // array_change.push({
            //     "std_id": std_id,
            //     "std_name": std_name
            // })
            $('#std_id_status').val(std_id);
            $('#render_std_show_status').empty();
            $('#render_std_show_status').append(`<p class="col-md-12 text-center">${std_name}</p>`)
            document.getElementById("click-show-modal-status").click();
        }

        function openmModalChangeGender(std_id, std_name) {
            $('#std_id_gender').val(std_id);
            $('#render_std_show_gender').empty();
            $('#render_std_show_gender').append(`<p class="col-md-12 text-center">${std_name}</p>`)
            document.getElementById("click-show-modal-gender").click();
        }


        function saveChangeClass() {
            if ($('#std_class_change').val() == "0") {
                $('#std_class_change').focus();
                alert('โปรดเลือกชั้น');
                return;
            }
            $.ajax({
                type: "POST",
                url: "student-tracking/controllers/student_controller",
                data: {
                    change_multiple_std: true,
                    arr_std: JSON.stringify(array_change),
                    class_name: $('#std_class_change').val()
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.status) {
                        alert(data.msg);
                        location.reload();
                    } else {
                        alert(data.msg);
                        window.location.reload();
                    }
                },
            });
        }

        function saveChangeStatus() {
            if ($('#std_status_change').val() == "0") {
                $('#std_status_change').focus();
                alert('โปรดเลือกสถานะ');
                return;
            }
            $.ajax({
                type: "POST",
                url: "student-tracking/controllers/student_controller",
                data: {
                    change_status_std: true,
                    std_id: $('#std_id_status').val(),
                    status: $('#std_status_change').val()
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    alert(data.msg);
                    window.location.reload();
                },
            });
        }

        function saveChangeGender() {
            if ($('#std_gender_change').val() == "0") {
                $('#std_gender_change').focus();
                alert('โปรดเลือกเพศ');
                return;
            }
            $.ajax({
                type: "POST",
                url: "student-tracking/controllers/student_controller",
                data: {
                    change_gender_std: true,
                    std_id: $('#std_id_gender').val(),
                    gender: $('#std_gender_change').val()
                },
                dataType: "json",
                success: function(data) {
                    alert(data.msg);
                    window.location.reload();
                },
            });
        }
    </script>

    <body>

</html>