<?php include 'include/check_login.php'; ?>

<?php
$calendar_new = false;

include "../config/class_database.php";
$DB = new Class_Database();

if ($_SESSION['user_data']->role_id != 4) {
    if (isset($_REQUEST['class'])) {
        $_SESSION['manage_calendar_class'] = $_REQUEST['class'];
    }
    if (!isset($_SESSION['manage_calendar_class']) || $_SESSION['manage_calendar_class'] == "0") {
        $classSession = "";
    } else {
        $status = json_decode($_SESSION['user_data']->status);
        $calendar_new = isset($status->calendar_new) ? true : false;
    }
    if (isset($_SESSION['manage_calendar_class']) && $_SESSION['manage_calendar_class'] == "1") {
        $classSession = "ประถม";
    }
    if (isset($_SESSION['manage_calendar_class']) && $_SESSION['manage_calendar_class'] == "2") {
        $classSession = "ม.ต้น";
    }
    if (isset($_SESSION['manage_calendar_class']) && $_SESSION['manage_calendar_class'] == "3") {
        $classSession = "ม.ปลาย";
    }
} else {

    $sql = "SELECT name,status FROM tb_users WHERE id = :id";
    $data_user_create = $DB->Query($sql, ['id' => $_SESSION['user_data']->user_create]);
    $data_user_create = json_decode($data_user_create);
    $statusSTD = json_decode($data_user_create[0]->status);
    $calendar_new = isset($statusSTD->calendar_new) ? true : false;

    $sql = "SELECT std_class FROM tb_students WHERE std_id = :std_id";
    $data_std = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
    $data_std = json_decode($data_std);
    $data_std_class = $data_std[0]->std_class;
    $classSession = $data_std_class;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-รายชื่อผู้เข้าเรียน</title>
    <style>
        .input-group-text {
            width: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .input-group-text:hover {
            cursor: pointer;
            background-color: #5949d6;
            color: #fff;
        }

        .table tbody tr td {
            padding: 5px 5px;
            align-content: center;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #04b318;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #04b318;
        }

        input:not(:checked)+.slider {
            background-color: #d9534f;
            /* สีแดง */
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php include 'include/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <!-- <h4 class="box-title">รายชื่อผู้เข้าเรียน</h4> -->
                                    <?php
                                    $backPage = "manage_calendar";
                                    if (!empty($calendar_new)) {
                                        $backPage = 'view_plan_calender_detail_new?calendar_id=' . $_GET['calendar_id'];
                                        $backPage .= isset($_GET['learning_id']) ? '&learning_id=' . $_GET['learning_id'] : '';
                                        $backPage .= $_SESSION['user_data']->role_id == 2 ? '&user_id=' . $_GET['user_id'] . '&name=' . $_GET['name'] : '';
                                    }

                                    $joinReason = " LEFT JOIN cl_learning_save_file lf ON c.calendar_id = lf.calendar_id\n";
                                    $joinReason .= " LEFT JOIN cl_learning_reason r ON lf.learning_id = r.learning_id AND type_new = 1\n";

                                    $tableNew = " cl_calendar ";
                                    if (!empty($calendar_new)) {
                                        $joinReason = " LEFT JOIN cl_learning_saved l ON c.calendar_id = l.calendar_id\n";
                                        $joinReason .= " LEFT JOIN cl_learning_reason r ON l.learning_id = r.learning_id AND type_new = 2\n";
                                        $tableNew = " cl_calendar_new ";
                                    }

                                    $joinReason .= " LEFT JOIN tb_users ur ON r.user_create = ur.id  \n";
                                    $joinReason .= " LEFT JOIN tb_users urc ON c.user_create = urc.id  \n";

                                    $sql = "SELECT *,CONCAT(ur.name,' ',ur.surname) ur_name,CONCAT(urc.name,' ',urc.surname) urc_name FROM $tableNew c \n" .
                                        "   $joinReason \n" .
                                        "   WHERE c.calendar_id = :calendar_id";
                                    $calendarData = $DB->Query($sql, ['calendar_id' => $_GET['calendar_id']]);
                                    $calendarData = json_decode($calendarData);

                                    $calendarClass = "";
                                    if ($calendarData[0]->std_class == 'ประถม') {
                                        $calendarClass = "ประถมศึกษา";
                                    } else if ($calendarData[0]->std_class == 'ม.ต้น') {
                                        $calendarClass = "มัธยมศึกษา ตอนต้น";
                                    } else if ($calendarData[0]->std_class == 'ม.ปลาย') {
                                        $calendarClass = "มัธยมศึกษา ตอนปลาย";
                                    }

                                    ?>
                                    <h4 class="box-title"><i class="ti-arrow-left" style="cursor: pointer;"
                                            onclick="window.location.href='<?php echo $backPage ?>'"></i>
                                        <b class="ml-4" id="title-b">รายชื่อผู้เข้าเรียน การพบกลุ่มครั้งที่ <?php echo $calendarData[0]->time_step ?></b>
                                    </h4>
                                    <a class="waves-effect waves-light btn btn-success btn-flat ml-2" id="print" onclick="printPage()"><i class="ti-printer"></i>&nbsp;ปริ้น</a>
                                </div>
                                <div class="box-body p-0">
                                    <div class="row" style="display: none;" id="print_header">
                                        <div class="col-md-12">
                                            <p style="font-size: 16px;font-weight: bold;">การพบกลุ่มครั้งที่ <?php echo $calendarData[0]->time_step ?> <?php echo $calendarData[0]->urc_name ?> - <?php echo $calendarData[0]->ur_name ?></p>
                                            <p style="font-size: 16px;font-weight: bold;">ระดับชั้น <?php echo $calendarClass ?></p>
                                            <p style="font-size: 16px;font-weight: bold;">วันที่..........................เดือน..............................................พ.ศ....................</p>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" style="font-size: 14px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;" class="text-center">#</th>
                                                    <th style="width: 15%;">รหัสนักศึกษา</th>
                                                    <th style="width: 30%;">ชื่อ-สกุล</th>
                                                    <th style="width: 300px;" class="text-center">เวลาเข้าเรียนออนไลน์</th>
                                                    <th style="width: 300px;" class="text-center">เช็คชื่อออนไซต์</th>
                                                    <th style="width: 300px;" class="text-center">ขาดเรียน</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body_sign">
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <?php include "../include/loader_include.php"; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- <div class="row" id="print_count" style="margin-top: 50px;margin-right: 10px;">
                                        <div class="col-md-12" style="text-align: right;">
                                            <p style="font-size: 16px; font-weight: bold;">จำนวนนักศึกษาทั้งหมด <span id="total_count"></span> คน</p>
                                            <p style="font-size: 16px; font-weight: bold;">จำนวนนักศึกษาเข้าเรียน <span id="present_count"></span> คน</p>
                                            <p style="font-size: 16px; font-weight: bold;">จำนวนนักศึกษาขาดเรียน <span id="absent_count"></span> คน</p>
                                        </div>
                                    </div> -->

                                    <div class="row" id="print_count" style="margin-top: 50px;display: none;">
                                        <div class="col-7 text-center">
                                        </div>
                                        <div class="col-5 text-left">
                                            <p style="font-size: 16px; font-weight: bold;">จำนวนนักศึกษาทั้งหมด <span id="total_count"></span> คน</p>
                                            <p style="font-size: 16px; font-weight: bold;">จำนวนนักศึกษาเข้าเรียน <span id="present_count"></span> คน</p>
                                            <p style="font-size: 16px; font-weight: bold;">จำนวนนักศึกษาขาดเรียน <span id="absent_count"></span> คน</p>
                                        </div>
                                    </div>

                                    <div class="row signature-box" style="margin-top: 100px;display: none;">
                                        <div class="col-6 text-center">
                                        </div>
                                        <div class="col-6 text-center">
                                            <p class="m-0" style="font-size: 16px;font-weight: bold;">ลงชื่อ .......................................................................................................</p>
                                            <p class="mt-3" style="font-size: 16px;font-weight: bold;">(...................................................................................................................)</p>
                                            <p class="text-center m-0" style="font-size: 16px;font-weight: bold;"><?php echo $calendarData[0]->urc_name ?></p>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->
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
        $(document).ready(() => {
            getDataSignIn()
        });

        function getDataSignIn() {
            $.ajax({
                type: "POST",
                url: "controllers/calendar_controller",
                data: {
                    getDataStdSignInClass: true,
                    calendar_id: '<?php echo $_GET['calendar_id'] ?>',
                    <?php if (!empty($calendar_new)) { ?>
                        new: true
                    <?php } ?>
                },
                dataType: "json",
                success: function(json_res) {
                    console.log(json_res);
                    const std_sign_in = document.getElementById('body_sign');
                    std_sign_in.innerHTML = ``;

                    if (json_res.data.length == 0) {
                        std_sign_in.innerHTML = `<tr><td colspan="5" class="text-center">ยังไม่มีผู้เข้าเรียน</td></tr>`;
                    } else {
                        let total_count = json_res.data.length;
                        let present_count = 0;
                        let absent_count = 0;
                        for (let i = 0; i < json_res.data.length; i++) {
                            let ele = json_res.data[i];

                            present_count += ele.type_sign_in == "1" || ele.type_sign_in == "2" ? 1 : 0;

                            std_sign_in.innerHTML += `<tr>
                                                        <td class="text-center">${i+1}</td>
                                                        <td>${ele.std_code}</td>
                                                        <td>${ele.std_name}</td>
                                                        <td class="text-center">
                                                            <div class="check-box">
                                                                <input type="checkbox" id="online_${ele.std_id}" ${ele.type_sign_in == "1" ? "checked" : ''} class="filled-in chk-col-primary" onclick="return false">
                                                                <label for="online_${ele.std_id}" class="m-0"></label>
                                                            </div>
                                                             <div class="print-checkbox" style="display:none;">
                                                                <input type="checkbox" id="online_${ele.std_id}" ${ele.type_sign_in == "1" ? "checked" : ''} disabled="">
                                                                <label for="id="online_${ele.std_id}" class="m-0"></label>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="check-box">
                                                                <input type="checkbox" id="std_sign_in_${ele.std_id}" ${ele.type_sign_in == "2" ? "checked" : ''} class="filled-in chk-col-primary" onchange="onsiteSignIn(this.checked, ${ele.std_id}, 2)">
                                                                <label for="std_sign_in_${ele.std_id}" class="m-0"></label>
                                                            </div>
                                                            <div class="print-checkbox" style="display:none;">
                                                                <input type="checkbox" id="std_sign_in_${ele.std_id}" ${ele.type_sign_in == "2" ? "checked" : ''} disabled="">
                                                                <label for="id="std_sign_in_${ele.std_id}" class="m-0"></label>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="check-box">
                                                                <input type="checkbox" id="std_missing_${ele.std_id}" ${ele.type_sign_in == "3" ? "checked" : ''} class="filled-in chk-col-danger" onchange="onsiteSignIn(this.checked, ${ele.std_id}, 3)">
                                                                <label for="std_missing_${ele.std_id}" class="m-0"></label>
                                                            </div>
                                                            <div class="print-checkbox" style="display:none;">
                                                                <input type="checkbox" id="std_missing_${ele.std_id}" ${ele.type_sign_in == "3" ? "checked" : ''} disabled="">
                                                                <label for="id="std_missing_${ele.std_id}" class="m-0"></label>
                                                            </div>
                                                        </td>
                                                    </tr>`;
                        }

                        absent_count = total_count - present_count;

                        document.getElementById('total_count').innerHTML = total_count;
                        document.getElementById('present_count').innerHTML = present_count;
                        document.getElementById('absent_count').innerHTML = absent_count;
                    }
                    //     
                    //     std_sign_in.innerHTML = textHtml;
                },
            });
        }

        function printPage() {
            $('#print').hide()
            $('.box-header').hide()
            $('.check-box').hide()
            $('.print-checkbox').show()
            $('#print_header').show()
            $('#print_count').show()
            $('.signature-box').show()
            $('.check-demo input').attr("disabled", true)
            $('#title-b').removeClass('ml-4')
            window.print();
            location.reload();
        }

        function onsiteSignIn(checked, std_id, type) {
            let calendar_id = '<?php echo $_GET['calendar_id']; ?>';
            $.ajax({
                type: "POST",
                url: "controllers/calendar_controller",
                data: {
                    onsiteSignIn: true,
                    calendar_id: calendar_id,
                    std_id: std_id,
                    type: type,
                    checked: checked,
                    <?php if (!empty($calendar_new)) { ?>
                        new: true
                    <?php } ?>
                },
                dataType: "json",
                success: function(json_res) {
                    getDataSignIn()
                },
            });
        }
    </script>
</body>

</html>