<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลสรุปการเยี่ยมบ้าน</title>
    <style>
        label {
            display: inline-block;
            background-color: #1e613b;
            color: white;
            padding: 0.5rem;
            border-radius: 0.3rem;
            cursor: pointer;
            margin-top: 1rem;
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

                                <div class="box-header with-border">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <h4 class="box-title">ข้อมูลสรุปการเยี่ยมบ้าน</h4>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control" id="class_dropdown" onchange="getDataByWhere()">
                                            </select>
                                        </div>
                                        <?php if ($_SESSION['user_data']->role_id != 3 && $_SESSION['user_data']->edu_type != 'edu_other') { ?>
                                            <div class="col-md-2">
                                                <select class="form-control" id="subdistrict_select" onchange="getDataByWhere()">
                                                </select>
                                            </div>
                                        <?php } ?>

                                        <?php if ($_SESSION['user_data']->role_id == 3) { ?> <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="form1_3_view"><i class=""></i>&nbsp;ข้อมูลสรุปการเยี่ยมบ้าน</a> <?php  } ?>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-hover" style="font-size: 12px;">
                                           <thead>
                                                <tr>
                                                    <th style="width: 50px;">ลำดับ</th>
                                                    <th>รหัสนักศึกษา</th>
                                                    <th>ชื่อ - สกุล</th>
                                                    <th>ชั้น</th>
                                                    <th>ผู้บันทึก</th>
                                                    <th>สถานศึกษา</th>
                                                    <?php if ($_SESSION['user_data']->role_id != 3 && ($_SESSION['user_data']->edu_type != 'edu_other')) { ?>
                                                        <th>ตำบล</th>
                                                        <th>อำเภอ</th>
                                                        <th>จังหวัด</th>
                                                    <?php } ?>
                                                    <th class="text-center">สรุปการเยี่ยมบ้าน</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-student">
                                                <!-- <tr>
                                                    <td colspan="8" class="text-center">
                                                        <?php include "include/loader_include.php"; ?>
                                                    </td>
                                                </tr> -->
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
                    <?php include "../include/loader_include.php"; ?>
                </div>

            </div>
        </div>
        <!-- /.content-wrapper -->

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>

    <script src="assets/js/view_js/form_1.3_new.js"></script>
</body>

</html>