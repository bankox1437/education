<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>บันทึกการจัดการเรียนรู้ครั้งที่ 1 ภาคเรียนที่ 2/2566</title>
    <style>
        .detail-text {
            font-size: 18px;
            color: #475f7b;
            word-wrap: break-word;
            /* border-bottom-style: dotted; */
        }

        .box-body {
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }

        @media print {

            body {
                margin: 0;
                color: #000;
                background-color: #fff;
            }

        }

        #box-print {
            padding-left: 80px;
            padding-right: 80px;
        }

        @media (max-width: 768px) {
            #box-print {
                padding-left: 10px;
                padding-right: 10px;
            }
        }

        #link_a:hover #link {
            color: red;
        }

        #link_a {
            color: red;
        }

        .card img {
            border-radius: 10px;
            height: 190px;
        }

        .img_fit {
            object-fit: cover;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" id="print_content">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border  no-print">
                                    <div class="row justify-content-between align-items-center">
                                        <h4 class="box-title text-left" style="margin: 0;">
                                            <?php if ($_SESSION['user_data']->role_id != 3) { ?>
                                                <p><a href="manage_summary?user_id=<?php echo $_GET['user_id'] ?>&name=<?php echo $_GET['name'] ?>"><i class="ti-arrow-left no-print" style="cursor: pointer;"></i></a>&nbsp;<span>รายละเอียดรายงานการดำเนินการ</span> <b><?php echo $_GET['name'] ?></b></p>
                                            <?php } else { ?>
                                                <p><a href="manage_summary"><i class="ti-arrow-left no-print" style="cursor: pointer;"></i></a>&nbsp;<span>รายละเอียดรายงานการดำเนินการ</span></p>
                                            <?php } ?>
                                        </h4>
                                        <div>
                                            <button class="btn btn-success ml-2 no-print" onclick="printPage()"><i class="ti-printer"></i>&nbsp; ปริ้น</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="container" id="box-print">
                                        <div class="d-flex justify-content-center">
                                            <h3 class="m-1 box-title title-show" style="display:none">
                                                <b>รายงานการดำเนินการ</b>
                                            </h3>
                                        </div>
                                        <div class="row mt-3" style="display: none;" id="kru_name">
                                            <div class="col-md-12">
                                                <h4 class="mb-1 box-title"><b>ชื่อครูผู้ดำเนินการ</b></h4>
                                                <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                    <p class="detail-text"><?php echo $_SESSION['user_data']->name . " " . $_SESSION['user_data']->surname; ?></p>
                                                <?php } else { ?>
                                                    <p class="detail-text"><?php echo $_GET['name'] ?></p>
                                                <?php } ?>

                                            </div>
                                        </div>

                                        <?php include "../config/class_database.php";
                                        $DB = new Class_Database();
                                        $sql = "SELECT * FROM cl_report \n" .
                                            "WHERE report_id = :report_id";
                                        $data = $DB->Query($sql, ['report_id' => $_GET['report_id']]);
                                        $data = json_decode($data);
                                        if (count($data) == 0) {
                                            echo '<script>location.href = "../404"</script>';
                                        }
                                        $data_report = $data[0];
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>เรื่องรายงาน</b></h4>
                                                    <p class="detail-text" id="side_1"><?php echo $data_report->report_name; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>เนื้อหารายงาน</b></h4>
                                                    <p class="detail-text" id="side_2"><?php echo $data_report->report_detail; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row row-cols-1 row-cols-md-3 g-4" id="img_learn">
                                            <?php if ($data_report->img_1 != "") {
                                                $img1 = 'uploads/report_img/' . $data_report->img_1;
                                                if (!file_exists($img1)) {
                                                    $img1 = 'https://drive.google.com/thumbnail?id=' . $data_report->img_1 . '&sz=w1000';
                                                }
                                            ?>
                                                <div class="col col-sm-3 col-md-3 col-lg-3">

                                                    <div class="card">
                                                        <img src="<?php echo $img1 ?>" alt="img_1" id="img_1" class="img_fit">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($data_report->img_2 != "") {
                                                $img2 = 'uploads/report_img/' . $data_report->img_2;
                                                if (!file_exists($img2)) {
                                                    $img2 = 'https://drive.google.com/thumbnail?id=' . $data_report->img_2 . '&sz=w1000';
                                                } ?>
                                                <div class="col col-sm-3 col-md-3 col-lg-3">

                                                    <div class="card">
                                                        <img src="<?php echo $img2 ?>" alt="img_2" id="img_2" class="img_fit">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($data_report->img_3 != "") { 
                                                 $img3 = 'uploads/report_img/' . $data_report->img_3;
                                                 if (!file_exists($img3)) {
                                                     $img3 = 'https://drive.google.com/thumbnail?id=' . $data_report->img_3 . '&sz=w1000';
                                                 } ?>
                                                <div class="col col-sm-3 col-md-3 col-lg-3">

                                                    <div class="card">
                                                        <img src="<?php echo $img3 ?>" alt="img_3" id="img_3" class="img_fit">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($data_report->img_4 != "") { 
                                                $img4 = 'uploads/report_img/' . $data_report->img_4;
                                                if (!file_exists($img4)) {
                                                    $img4 = 'https://drive.google.com/thumbnail?id=' . $data_report->img_4 . '&sz=w1000';
                                                } ?>
                                                <div class="col col-sm-3 col-md-3 col-lg-3">

                                                    <div class="card">
                                                        <img src="<?php echo $img4 ?>" alt="img_4" id="img_4" class="img_fit">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <br>
                                    <br>
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
        // $(document).ready(() => {
        //     getDataDetail()
        // });

        function printPage() {
            $('#reason_text').show();
            $('#kru_name').show()
            $('.title-show').css('display', 'block');
            if (role_id != 3) {
                $('#reason_form').hide();
            }
            window.print();
        }

        window.addEventListener("afterprint", (event) => {
            $('.title-show').css('display', 'none');
            $('#kru_name').hide();
            if (role_id != 3) {
                $('#reason_text').hide();
                $('#reason_form').show();
            }
        });
    </script>
</body>

</html>