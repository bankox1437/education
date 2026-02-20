<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการข้อมูลสรุปการเยี่ยมบ้าน</title>
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
                                <div class="box-header with-border ">
                                    <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form1_3'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มสรุปการเยี่ยมบ้าน</b></h6>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <div class="">
                                        <div class="row m-4 text-center">
                                            <div class="col-lg-3">
                                                <!-- <div class="form-group">
                                                    <label>ชั้น/ห้อง <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="std_class" id="std_class" placeholder="เช่น ป.5/5,ม.2/3" autocomplete="off">
                                                </div> -->
                                                <div class="form-group">
                                                    <label>ชั้น/ห้อง <b class="text-danger">*</b></label>
                                                    <?php
                                                    include "../config/class_database.php";
                                                    $DB = new Class_Database();
                                                    $sql = "SELECT\n" .
                                                        "	std.std_class \n" .
                                                        "FROM\n" .
                                                        "	stf_tb_form_visit_home vh\n" .
                                                        "	LEFT JOIN tb_students std ON vh.std_id = std.std_id \n" .
                                                        "WHERE	vh.user_create = :user_id\n" .
                                                        "GROUP BY\n" .
                                                        "	std.std_class";
                                                    $data = $DB->Query($sql, ["user_id" => $_SESSION['user_data']->id]);
                                                    $data = json_decode($data);
                                                    ?>
                                                    <select class="form-control select2" name="std_class" id="std_class" data-placeholder="เลือกชั้น" style="width: 100%;">
                                                        <option value='0'>เลือกชั้น/ห้อง</option>
                                                        <?php
                                                       if (isset($data) && is_array($data)) {
                                                         for ($i = 0; $i < count($data); $i++) { ?>
                                                            <option value='<?php echo $data[$i]->std_class ?>'><?php echo $data[$i]->std_class ?></option>
                                                         
                                                        <?php  }} ?>

                                                    </select>
                                                    <input type="hidden" name="" id="count_std">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ปีการศึกษา <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="year" id="year" placeholder="เช่น 2565,2566" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" style="font-size: 14px;">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>รายการ</th>
                                                    <th>ข้อมูล / รายละเอียดที่พบ</th>
                                                    <th>รวม (คน)</th>
                                                    <th>ร้อยละ</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-visit">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="data-sum">

                                    </div>
                                </div>
                                <div class="box-footer" id="footer_btn">
                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline" id="saveVisit">
                                        <i class="ti-save-alt"></i> บันทึกข้อมูล
                                    </button>
                                </div>
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

    <script src="js/view_js/form_1.3_add.js"></script>
</body>

</html>