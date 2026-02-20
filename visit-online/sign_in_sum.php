<?php include 'include/check_login.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-สรุปการพบกลุ่ม</title>
    <style>
        /* @media print {
            @page {
                size: A4 landscape;
            }
        } */

        .table thead>tr th,
        .table thead>tr td {
            padding: 0px 10px;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

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
                                <div class="box-header">
                                    <!-- <h4 class="box-title">รายชื่อผู้เข้าเรียน</h4> -->
                                    <?php

                                    include "../config/class_database.php";
                                    $DB = new Class_Database();

                                    $calendarClass = "";
                                    $pageBackClass = 0;
                                    if ($_GET['std_class'] == 'ประถม') {
                                        $calendarClass = "ประถมศึกษา";
                                        $pageBackClass = 1;
                                    } else if ($_GET['std_class'] == 'ม.ต้น') {
                                        $calendarClass = "มัธยมศึกษา ตอนต้น";
                                        $pageBackClass = 2;
                                    } else if ($_GET['std_class'] == 'ม.ปลาย') {
                                        $calendarClass = "มัธยมศึกษา ตอนปลาย";
                                        $pageBackClass = 3;
                                    }

                                    $back = "manage_calendar";
                                    if ($_SESSION['user_data']->role_id == 2 || $_SESSION['user_data']->role_id == 6 || $_SESSION['user_data']->role_id == 1) {
                                        $pro = isset($_GET['pro']) ? "pro=" . $_GET['pro'] . "&" : '';
                                        $dis = isset($_GET['dis']) ? "dis=" . $_GET['dis'] . "&" : '';
                                        $sub = isset($_GET['sub']) ? "sub=" . $_GET['sub'] . "&" : '';
                                        $page_number = isset($_GET['page_number']) ? "page_number=" . $_GET['page_number'] . "&" : '';
                                        $name = isset($_GET['name']) ? "name=" . $_GET['name'] . "&" : '';
                                        $user_id = isset($_GET['user_id']) ? "user_id=" . $_GET['user_id'] : '';
                                        $back = "../visit-online/manage_calendar?class=$pageBackClass&$pro$dis$sub$page_number$name$user_id";
                                    }
                                    ?>
                                    <h4 class="box-title"><i class="ti-arrow-left" style="cursor: pointer;"
                                            onclick="window.location.href='<?php echo $back ?>'"></i>
                                        <b class="ml-4" id="title-b">สรุปการพบกลุ่ม <?php echo $calendarClass ?></b>
                                    </h4>
                                    <a class="waves-effect waves-light btn btn-success btn-flat ml-2" id="print" onclick="printPage()"><i class="ti-printer"></i>&nbsp;ปริ้น</a>
                                </div>
                                <div class="box-body p-0">
                                    <div class="row" id="print_header" style="display: none;">
                                        <div class="col-md-12">
                                            <p style="font-size: 16px;font-weight: bold;">สรุปการพบกลุ่มทั้ง 18 ครั้ง <?php echo $_SESSION['user_data']->name . " " . $_SESSION['user_data']->surname ?></p>
                                            <p style="font-size: 16px;font-weight: bold;">ระดับชั้น <?php echo $calendarClass ?></p>
                                            <p style="font-size: 16px;font-weight: bold;"><?php echo $_SESSION['user_data']->edu_name ?></p>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" style="font-size: 14px;">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">ลำดับที่</th>
                                                    <th rowspan="2" style="width: 300px;">ชื่อ สกุล</th>
                                                    <th colspan="19" class="text-center">การพบกลุ่มครั้งที่ (18 ครั้ง)</th>
                                                </tr>
                                                <tr>
                                                    <?php for ($i = 0; $i < 18; $i++) { ?>
                                                        <th class="text-center"><?php echo $i + 1; ?></th>
                                                    <?php } ?>
                                                    <th class="text-center">รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body_sign">
                                                <tr>
                                                    <td colspan="21" class="text-center">
                                                        <?php include "../include/loader_include.php"; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row signature-box" style="margin-top: 50px;display: none;">
                                        <div class="col-6 text-center">
                                        </div>
                                        <div class="col-6 text-center">
                                            <p class="m-0" style="font-size: 16px;font-weight: bold;">ลงชื่อ .......................................................................................................</p>
                                            <p class="mt-3" style="font-size: 16px;font-weight: bold;">(...................................................................................................................)</p>
                                            <p class="text-center m-0" style="font-size: 16px;font-weight: bold;"><?php echo $_SESSION['user_data']->name . " " . $_SESSION['user_data']->surname ?></p>
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
                url: "controllers/calendar_new_controller",
                data: {
                    getDataStdSignInSum: true,
                    new: true,
                    std_class: '<?php echo $_GET['std_class'] ?>',
                    user_id: '<?php echo isset($_GET['user_id']) ? $_GET['user_id'] : '0' ?>',
                    term: '<?php echo isset($_GET['term_name']) ? $_GET['term_name'] : '0' ?>',
                },
                dataType: "json",
                success: function(json_res) {
                    console.log(json_res);
                    const std_sign_in = document.getElementById('body_sign');
                    std_sign_in.innerHTML = ``;

                    if (json_res.data.length == 0) {
                        std_sign_in.innerHTML = `<tr><td colspan="21" class="text-center">ยังไม่มีผู้เข้าเรียน</td></tr>`;
                    } else {
                        for (let i = 0; i < json_res.data.length; i++) {
                            let ele = json_res.data[i];

                            let columnChecked = '';
                            let sumStdPresent = 0;
                            for (let j = 0; j < 18; j++) {
                                let signObj = ele.sign_in[j];
                                console.log(signObj);
                                columnChecked += `
                                                <td class="text-center">
                                                    ${!parseInt(signObj) ? `-` : signObj == 1 ? `<i class="ti-check text-success"></i>` : `<i class="ti-close text-danger"></i>`}
                                                </td>`
                                sumStdPresent += signObj == 1 ? 1 : 0;
                            }

                            columnChecked += `
                                                <td class="text-center">
                                                    ${sumStdPresent}
                                                </td>`

                            std_sign_in.innerHTML += `<tr>
                                                        <td class="text-center">${i+1}</td>
                                                        <td>${ele.std_prename}${ele.std_name}</td>
                                                        ${columnChecked}
                                                    </tr>`;
                        }
                    }
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
    </script>
</body>

</html>