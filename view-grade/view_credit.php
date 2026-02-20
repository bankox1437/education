<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_std.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ดูรายละเอียดผลการเรียน</title>
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

        .input-custom-table {
            border: 0;
            border-radius: 0;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT\n" .
                    "	credit.credit_id,\n" .
                    "	credit.term_id,\n" .
                    "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
                    "	std.std_code\n" .
                    "FROM\n" .
                    "	vg_credit credit\n" .
                    "	LEFT JOIN tb_students std ON credit.std_id = std.std_id \n" .
                    "WHERE\n" .
                    "	credit.std_id = :std_id";
                $data = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
                $std_data = json_decode($data);
                // echo "<pre>";
                // print_r($std_data);
                // echo "</pre>";
                $view_mode = "";
                if (isset($_GET['mode']) && ($_GET['mode'] == "view" || $_GET['mode'] == "std_views")) {
                    $view_mode = ' disabled style="background-color: #fff;" ';
                }

                $arrSumgrade = [];

                // $credit_id = "";
                // if ((isset($_GET['mode']) && $_GET['mode'] == "std_views") && count($std_data) != 0) {
                //     $credit_id = $std_data[0]->credit_id;
                // } else if (count($std_data) == 0) {
                //     $credit_id = "";
                // } else {
                //     $credit_id = $_GET['credit_id'];
                // }
                ?>


                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body">
                                    <h4 class="ml-2 mb-4 mt-1text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='index_student'"></i>
                                        &nbsp;&nbsp;<i class="fa fa-file-text-o mr-15"></i>
                                        <b>ข้อมูลผลการเรียน ( Total Credit )</b>
                                    </h4>
                                    <div class="row ">
                                        <div class="col-md-12 d-flex justify-content-center" id="std_section">
                                            <?php
                                            if (count($std_data) == 0) { ?>
                                                <h3>ยังไม่มีการบันทึกผลการเรียน</h3>
                                            <?php } else { ?>
                                                <!-- <h3><?php echo $std_data[0]->std_code . " - " . $std_data[0]->std_name ?></h3> -->
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if (count($std_data) != 0) {
                                        foreach ($std_data as $key => $value) {
                                            $credit_id = $value->credit_id;
                                    ?>
                                            <div class="row bg-primary" style="position: relative;">
                                                <div class="col-md-12 d-flex justify-content-center" id="std_section">
                                                    <h3>ปีการศึกษาที่ <?php echo $value->term_id ?></h3>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <?php
                                                include("include/credit/table1.php");
                                                include("include/credit/table2.php");
                                                include("include/credit/table3.php");
                                                ?>
                                            </div>
                                    <?php }
                                    } ?>

                                </div>
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
</body>

</html>