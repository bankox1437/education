<?php include 'include/check_login.php';
include "../config/class_database.php";
$DB = new Class_Database();
$classSession = "";
$calendar_new = false;
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


if ($_SESSION['user_data']->role_id == 6) {
    $sql = "SELECT name,status FROM tb_users WHERE id = :id";
    $data_user_create = $DB->Query($sql, ['id' => $_GET['user_id']]);
    $data_user_create = json_decode($data_user_create);
    $statusSTD = json_decode($data_user_create[0]->status);
    $calendar_new = isset($statusSTD->calendar_new) ? true : false;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการการพบกลุ่ม</title>
    <style>
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

        <?php include('../include/nav-header.php'); ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php include 'include/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="<?php echo $_SESSION['user_data']->role_id == 6 ? "margin:0" : "" ?>">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <?php
                                if (isset($_GET['user_id']) || $_SESSION['user_data']->role_id == 4 || $_SESSION['user_data']->role_id == 1) {
                                    if (!empty($calendar_new) || $_SESSION['user_data']->role_id == 1) {
                                        include "include/calendar_new/calendar_display.js.php";
                                    } else {
                                        include "include/calendar/calendar_display.js.php";
                                    }
                                } else {
                                    if ($_SESSION['user_data']->role_id == 3) {
                                        if (!empty($calendar_new)) {
                                            include "include/calendar_new/calendar_display.js.php";
                                        } else {
                                            include "include/calendar/calendar_display.js.php";
                                        }
                                    }
                                    if ($_SESSION['user_data']->role_id != 3) {
                                        include "include/calendar/calendar_other_display.js.php";
                                    }
                                }

                                ?>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
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
    <?php
    if (isset($_GET['user_id'])) {
        if (!empty($calendar_new) || $_SESSION['user_data']->role_id == 1) {
            include "include/calendar_new/script_calendar.js.php";
        } else {
            include "include/calendar/script_calendar.js.php";
        }
    } else if ($_SESSION['user_data']->role_id == 4) {
        if (!empty($calendar_new)) {
            include "include/calendar_new/script_calendar_std.js.php";
        } else {
            include "include/calendar/script_calendar_std.js.php";
        }
    } else {
        if ($_SESSION['user_data']->role_id == 3) {
            if (!empty($calendar_new)) {
                include "include/calendar_new/script_calendar.js.php";
            } else {
                include "include/calendar/script_calendar.js.php";
            }
        }
        if ($_SESSION['user_data']->role_id != 3) {
            if (!empty($calendar_new)) {
                include "include/calendar_new/script_calendar_other.js.php";
            } else {
                include "include/calendar/script_calendar_other.js.php";
            }
        }
    }

    ?>

</body>

</html>