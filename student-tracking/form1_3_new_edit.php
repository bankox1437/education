<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการข้อมูลเยี่ยมบ้านเพิ่มเติม</title>
    <style>
        table tbody td:nth-child(3) {
            align-items: center;
            cursor: pointer;
        }

        table tbody td:nth-child(3) label {
            padding: 0;
            margin: 0;
            margin-top: 10px;
            margin-left: 5px;
        }

        table tbody td:nth-child(3):hover {
            background: #c3c3c3;
            transition: all;
        }

        .border-red {
            border: 1px solid red;
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
                                <div class="box-header with-border row">
                                    <h6 class="box-title text-info" style="margin: 0;">
                                        <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form1_2'"></i>
                                        &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                        <b>ฟอร์มแก้ไขเยี่ยมบ้านเพิ่มเติม</b>&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-dark"><?php echo $_GET['std_name']; ?></span> 
                                    </h6>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" style="font-size: 14px;">
                                            <thead class="text-center">
                                                <tr>
                                                    <th style="width: 45%;">รายการ</th>
                                                    <th>ข้อมูล / รายละเอียดที่พบ</th>
                                                    <th style="width: 20%;"></th>
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
                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline" id="saveVisit" id="btn-submit">
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

    <script src="js/view_js/form_1.3_new_edit.js"></script>
</body>

</html>