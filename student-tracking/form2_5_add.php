<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แบบบันทึกคัดกรองนักศึกษารายบุคคล แบบ ด.ล. 2.5</title>
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
                            <form id="form_add_screening_std">
                                <div class="box">
                                    <div class="box-body">
                                        <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form2_5'"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มแบบบันทึกการคัดกรองนักศึกษาเป็นรายบุคคล</b></h6>
                                        <hr class="my-15">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="form-control select2" name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php include('include/form_2.5/side_1.php'); ?>
                                        <hr class="my-15">
                                        <?php include('include/form_2.5/side_2.php'); ?>
                                        <hr class="my-15">
                                        <?php include('include/form_2.5/side_3.php'); ?>
                                        <hr class="my-15">
                                        <?php include('include/form_2.5/side_4.php'); ?>
                                        <hr class="my-15">
                                        <?php include('include/form_2.5/side_5.php'); ?>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer" id="footer_btn">
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline" id="btn-submit">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                    </div>
                                    <!-- /.box-footer-->
                                </div>
                            </form>
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
    <script src="js/form_screening.js"></script>
    <script src="js/view_js/form_2.5_add.js"></script>
</body>

</html>