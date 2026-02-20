<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มบันทึกข้อมูลนักศึกษารายบุคคล</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <?php include 'include/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content">
                    <div class="row">
                        <div class="col-12">

                            <div class="box">
                                <div class="box-body">
                                    <h6 class="box-title text-info" style="margin: 0;">
                                        <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form1_1_new'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="ti-user mr-15"></i> <b>ฟอร์มบันทึกข้อมูลนักศึกษารายบุคคล</b>
                                    </h6>
                                    <hr class="my-15">

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>ค้นหาด้วยชั้น</label>
                                                <select class="form-control select2" name="std_class" id="std_class" data-placeholder="ชั้น" style="width: 100%;" onchange="getDataStd_new(this.value)">
                                                    <option value="">ชั้นทั้งหมด</option>
                                                    <option value="ประถม">ประถม</option>
                                                    <option value="ม.ต้น">ม.ต้น</option>
                                                    <option value="ม.ปลาย">ม.ปลาย</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เลือกนักศึกษา <b class="text-danger">*</b></label>
                                                <select class="form-control select2" name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;" onchange="getDataStdbtStdId(this.value)">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <form id="form-add-student-data">
                                        <?php
                                        include "include/from_1.1/side1.php";
                                        include "include/from_1.1/side2.php";
                                        include "include/from_1.1/side3.php";
                                        include "include/from_1.1/side4.php";
                                        include "include/from_1.1/side5.php";
                                        include "include/from_1.1/side6.php";
                                        include "include/from_1.1/side7.php";
                                        ?>
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                    </form>
                                </div>

                            </div>


                        </div>
                    </div>
            </div>
        </div>
        <?php include '../include/footer.php'; ?>
        </section>
        <!-- /.content -->
        <div class="preloader">
            <?php include "../include/loader_include.php"; ?>
        </div>

    </div>
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>

    <script type="text/javascript" src="js/view_js/form_1.1_add.js?v=<?php echo rand(1,10); ?>"></script>
</body>

</html>