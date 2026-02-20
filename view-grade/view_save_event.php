<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>สมุดบันทึก</title>
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
            padding-left: 180px;
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



        .card-img-top {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            height: 190px;
            object-fit: cover;
        }

        .img-hover:hover {
            cursor: pointer;
        }

        .img-hover {
            position: relative;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" id="print_content">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <?php
        $marGin = "margin: 0;";
        if ($_SESSION['user_data']->role_id != 4) {
            include 'include/sidebar.php';
            $marGin = '';
        } ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="<?php echo $marGin ?>">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border no-padding no-print">
                                    <div class="row align-items-center">
                                        <?php if ($_SESSION['user_data']->role_id == 4) { ?>
                                            <h4 class="ml-2 text-left mr-2" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_save_event'"></i>
                                                &nbsp;&nbsp;<i class="fa fa-book mr-15"></i>
                                                <b>สมุดบันทึก</b>
                                            </h4>
                                        <?php } else { ?>
                                            <h4 class="ml-2 text-left mr-2" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_save_event<?php echo isset($_GET['name']) ? '?std_id=' . $_GET['std_id'] . '&name=' . $_GET['name'] : '' ?>'"></i>
                                                &nbsp;&nbsp;<i class="fa fa-book mr-15"></i>
                                                <b>สมุดบันทึก <?php echo isset($_GET['name']) ? $_GET['name'] : "" ?></b>
                                            </h4>
                                        <?php } ?>
                                        <button class="btn btn-success ml-2 no-print" onclick="printPage()"><i class="ti-printer"></i>&nbsp; ปริ้น</button>
                                    </div>
                                </div>
                                <?php include ".././config/class_database.php";
                                $DB = new Class_Database();
                                $sql = "SELECT * FROM vg_save_event e LEFT JOIN tb_students std ON e.std_id = std.std_id \n" .
                                    "WHERE event_id = :event_id";
                                $data = $DB->Query($sql, ['event_id' => $_GET['event_id']]);
                                $data = json_decode($data);
                                if (count($data) == 0) {
                                    echo '<script>location.href = "404"</script>';
                                }
                                $data_event = $data[0];
                                ?>

                                <div class="box-body">
                                    <div class="container" id="box-print">
                                        <div class="d-flex justify-content-center">
                                            <h3 class="m-1 box-title title-show">
                                                <b>ข้อมูลสมุดบันทึก
                                                    <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                    <?php echo $data_event->std_prename . " " . $data_event->std_name;
                                                    } ?></b>
                                            </h3>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12 my-2">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>หัวข้อ</b></h4>
                                                    <p class="detail-text" id="side_1">
                                                        <?php echo $data_event->event_name; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 my-2">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>รายละเอียด</b></h4>
                                                    <p class="detail-text" id="side_2">
                                                        <?php echo $data_event->event_detail; ?></p>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- <div class="row my-2">
                                            <h4 class="mb-1 box-title"><b>รูปภาพประกอบกิจกรรม</b></h4>
                                            <div class="col-md-12 row">
                                                <div class="card col-md-5 p-0 m-3 img-hover">
                                                    <img class="card-img-top" src="<?php echo $data_event->img_event_1 != "" ? 'uploads/save_event/' . $data_event->img_event_1 : 'images/no-image.jpg' ?>" alt="img_event_1" id="img_event_1">
                                                </div>
                                                <div class="card col-md-5 p-0 m-3 img-hover">
                                                    <img class="card-img-top" src="<?php echo $data_event->img_event_2 != "" ? 'uploads/save_event/' . $data_event->img_event_2 : 'images/no-image.jpg' ?>" alt="img_event_2" id="img_event_2">
                                                </div>
                                                <div class="card col-md-5 p-0 m-3 img-hover">
                                                    <img class="card-img-top" src="<?php echo $data_event->img_event_3 != "" ? 'uploads/save_event/' . $data_event->img_event_3 : 'images/no-image.jpg' ?>" alt="img_event_3" id="img_event_3">
                                                </div>
                                                <div class="card col-md-5 p-0 m-3 img-hover">
                                                    <img class="card-img-top" src="<?php echo $data_event->img_event_4 != "" ? 'uploads/save_event/' . $data_event->img_event_4 : 'images/no-image.jpg' ?>" alt="img_event_4" id="img_event_4">
                                                </div>
                                            </div>
                                        </div> -->
                                        <h4 class="mb-3 box-title"><b>รูปภาพประกอบ</b></h4>
                                        <div class="row row-cols-1 row-cols-md-3 g-4" id="img_learn">
                                            <?php if ($data_event->img_event_1 != "") { ?>
                                                <div class="col col-sm-3 col-md-3 col-lg-3">
                                                    <div class="card">
                                                        <img src="<?php echo $data_event->img_event_1 != "" ? 'uploads/save_event/' . $data_event->img_event_1 : 'images/no-image.jpg' ?>" alt="img_1" id="img_1" class="img_fit card-img-top">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($data_event->img_event_2 != "") { ?>
                                                <div class="col col-sm-3 col-md-3 col-lg-3">

                                                    <div class="card">
                                                        <img src="<?php echo $data_event->img_event_2 != "" ? 'uploads/save_event/' . $data_event->img_event_2 : 'images/no-image.jpg' ?>" alt="img_2" id="img_2" class="img_fit card-img-top">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($data_event->img_event_3 != "") { ?>
                                                <div class="col col-sm-3 col-md-3 col-lg-3">

                                                    <div class="card">
                                                        <img src="<?php echo $data_event->img_event_3 != "" ? 'uploads/save_event/' . $data_event->img_event_3 : 'images/no-image.jpg' ?>" alt="img_3" id="img_3" class="img_fit card-img-top">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($data_event->img_event_4 != "") { ?>
                                                <div class="col col-sm-3 col-md-3 col-lg-3">

                                                    <div class="card">
                                                        <img src="<?php echo $data_event->img_event_4 != "" ? 'uploads/save_event/' . $data_event->img_event_4 : 'images/no-image.jpg' ?>" alt="img_4" id="img_4" class="img_fit card-img-top">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($data_event->img_event_1 == "" && $data_event->img_event_2 == "" && $data_event->img_event_3 == "" && $data_event->img_event_4 == "") { ?>
                                                <div class="col col-sm-3 col-md-3 col-lg-3">
                                                    <p>ไมมีรูปภาพประกอบ</p>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <br>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>

                    </div>
            </div>
            </section>

        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script src="js/init-table/view_test_grade.js"></script>

    <script>
        function printPage() {

            window.print();
        }

        window.addEventListener("afterprint", (event) => {
            // $('.title-show').css('display', 'none');
            // $('#kru_name').hide();
            // if (role_id != 3) {
            //     $('#reason_text').hide();
            //     $('#reason_form').show();
            // }
        });
    </script>
</body>

</html>