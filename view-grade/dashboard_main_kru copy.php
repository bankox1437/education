<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แดชบอร์ดสรุปผล</title>
    <style>
        .preloader {
            display: flex;
            justify-content: center;
        }

        .box-content {
            border-radius: 20px;
            padding: 20px 20px;
            color: #fff;
            margin-bottom: 15px;
        }

        h4 {
            margin: 0px;
            font-size: 22px;
        }

        /* .col-md-4 {
            padding: 0 !important;
        } */

        .box1 {
            background-color: #4473C3;
        }

        .box2 {
            background-color: #ED7F32;
        }

        .box3 {
            background-color: #BE9102;
        }

        .box4 {
            background-color: #538234;
        }

        @media screen and (max-width: 480px) {
            h4 {
                margin: 0px;
                font-size: 14px;
            }

            .box-content {
                padding: 10px 20px;
                margin-bottom: 5px;
            }

            .box-flex-row {
                padding-right: 0;
            }

            .box-flex-row .col-md-4 {
                padding: 0;
            }
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">


                <?php
                include "../config/class_database.php";
                $DB = new Class_Database();

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
                $data = $DB->Query($sql, ['id' => $_SESSION['user_data']->id]);
                $data = json_decode($data);
                $data = $data[0];


                $termArr = explode('/', $_SESSION['term_active']->term_name);
                $term = $termArr[0];
                $year = $termArr[1];
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="container d-flex justify-content-center">
                        <div class="row">
                            <div class="col-md-12 text-center text-info mb-2">
                                <h4><b><?php echo $data->u_name . " " . $data->surname ?></b></h4>
                                <h4><b>ศกร.ระดับตำบล <?php echo $data->sub_name ?></b></h4>
                                <h4><b>ศกร.ระดับอำเภอ <?php echo $data->dis_name ?></b></h4>
                                <h4><b>ศกร.ประจำจังหวัด <?php echo $data->pro_name ?></b></h4>
                                <h4><b>ภาคเรียนที่ <?php echo $term ?> ปีการศึกษา <?php echo $year ?></b></h4>
                            </div>
                            <!-- start box 1 -->
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="box-content box1">
                                    <h4>นักศึกษาทั้งหมดจำนวน <span id="stdALL"></span> คน</h4>
                                    <h4>ชาย <span id="maleAll"></span> คน</h4>
                                    <h4>หญิง <span id="femaleAll"></span> คน</h4>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <!-- end box 1 -->

                            <div class="col-md-12 row box-flex-row">

                                <!-- start box 2 -->
                                <!-- <div class="col-md-4"></div> -->
                                <div class="col-md-4">
                                    <div class="box-content box2">
                                        <h4>ระดับ ประถม ทั้งหมด <span id="sumStd1"></span> คน</h4>
                                        <h4>ชาย <span id="std_gender1"></span> คน</h4>
                                        <h4>หญิง <span id="std_gender4"></span> คน</h4>
                                    </div>
                                </div>
                                <!-- <div class="col-md-4"></div> -->
                                <!-- end box 2 -->

                                <!-- start box 3 -->
                                <!-- <div class="col-md-4"></div> -->
                                <div class="col-md-4">
                                    <div class="box-content box3">
                                        <h4>ระดับ ม.ต้น ทั้งหมด <span id="sumStd2"></span> คน</h4>
                                        <h4>ชาย <span id="std_gender2"></span> คน</h4>
                                        <h4>หญิง <span id="std_gender5"></span> คน</h4>
                                    </div>
                                </div>
                                <!-- <div class="col-md-4"></div> -->
                                <!-- end box 3 -->

                                <!-- start box 4 -->
                                <!-- <div class="col-md-4"></div> -->
                                <div class="col-md-4">
                                    <div class="box-content box4">
                                        <h4>ระดับ ม.ปลาย ทั้งหมด <span id="sumStd3"></span> คน</h4>
                                        <h4>ชาย <span id="std_gender3"></span> คน</h4>
                                        <h4>หญิง <span id="std_gender6"></span> คน</h4>
                                    </div>
                                </div>
                                <!-- <div class="col-md-4"></div> -->
                                <!-- end box 4 -->
                            </div>

                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="col-md-12 row justidy-content-center">
                                    <div class="col-md-4 mt-2 mb-2 text-center">
                                        <a href="../student_list?url=main_dashboard">
                                            <h4 class="text-info"><b>รายชื่อนักศึกษา</b></h4>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mt-2 mb-2 text-center">
                                        <a href="dashboard_index?url=main_dashboard">
                                            <h4 class="text-info"><b>แดชบอร์ดภาพรวมข้อมูล</b></h4>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mt-2 mb-2 text-center">
                                        <a href="../main_menu?index_menu=<?php echo $_SESSION['index_menu'] ?>">
                                            <h4 class="text-info"><b>เข้าสู่หน้าเมนูหลัก</b></h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
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
        $(document).ready(function() {
            getdatacount()
        });

        function getdatacount() {
            $.ajax({
                type: "POST",
                url: "../student-tracking/controllers/dashboard_controller",
                data: {
                    getdatacount: true
                },
                dataType: 'json',
                success: function(json_res) {
                    console.log(json_res);

                    let male_class_1 = parseInt(json_res.data[3].std_gender1);
                    let female_class_1 = parseInt(json_res.data[6].std_gender4);
                    let std1 = parseInt(male_class_1) + parseInt(female_class_1);

                    document.getElementById('std_gender1').innerHTML = male_class_1; // ประถม ชาย
                    document.getElementById('std_gender4').innerHTML = female_class_1; // ประถม หญิง
                    document.getElementById('sumStd1').innerHTML = std1; // รวม นศ ปะถม

                    let male_class_2 = parseInt(json_res.data[4].std_gender2);
                    let female_class_2 = parseInt(json_res.data[7].std_gender5);
                    let std2 = parseInt(male_class_2) + parseInt(female_class_2);

                    document.getElementById('std_gender2').innerHTML = male_class_2; // ม.ต้น ชาย
                    document.getElementById('std_gender5').innerHTML = female_class_2; // ม.ต้น หญิง
                    document.getElementById('sumStd2').innerHTML = std2; // รวม นศ ม.ต้น

                    let male_class_3 = parseInt(json_res.data[5].std_gender3);
                    let female_class_3 = parseInt(json_res.data[8].std_gender6);
                    let std3 = parseInt(male_class_3) + parseInt(female_class_3);

                    document.getElementById('std_gender3').innerHTML = male_class_3; // ม.ปลาย ชาย
                    document.getElementById('std_gender6').innerHTML = female_class_3; // ม.ปลาย หญิง
                    document.getElementById('sumStd3').innerHTML = std3; // รวม นศ ม.ต้น


                    let maleAll = male_class_1 + male_class_2 + male_class_3; // รวมผู้ชายทั้งหมด
                    let femaleAll = female_class_1 + female_class_2 + female_class_3; // รวมผู้หญิงทั้งหมด
                    let stdALL = maleAll + femaleAll; // รวมทั้งหมด

                    document.getElementById('maleAll').innerHTML = maleAll;
                    document.getElementById('femaleAll').innerHTML = femaleAll;
                    document.getElementById('stdALL').innerHTML = stdALL;
                },
            });
        }
    </script>
</body>

</html>