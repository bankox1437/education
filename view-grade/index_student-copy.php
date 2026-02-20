<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_std.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>หน้าหลักนักศึกษา</title>
    <link rel="stylesheet" href="css/main_std.css">
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="container" style="margin-top: 40px;">
                        <div class="row row-custom">
                            <a href="view_test_grade" class="col-md-6 text-left col-border">
                                <i class="fa fa fa-bar-chart" aria-hidden="true"></i>&nbsp;
                                <b>ผลสอบ</b> <span>( Test Grade Result )</span>
                            </a>
                            <a href="view_n_net" class="col-md-6 text-left col-border">
                                <i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;
                                <b>ผลการสอบ N-Net</b> <span>( N-NET Result )</span>
                            </a>
                            <a href="view_table_test" class="col-md-6 text-left col-border">
                                <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;
                                <b>ตารางสอบ</b> <span>( Exam Schedule )</span>
                            </a>
                            <a href="view_moral" class="col-md-6 text-left col-border">
                                <i class="fa fa-clipboard" aria-hidden="true"></i>&nbsp;
                                <b>คุณธรรม จริยธรรม</b> <span>( Moral )</span>
                            </a>
                            <a href="view_std_test" class="col-md-6 text-left col-border">
                                <i class="fa fa-vcard" aria-hidden="true"></i>&nbsp;
                                <b>รายชื่อนักศึกษาที่มีสิทธิ์สอบ</b> <span>( List of Eligible Students )</span>
                            </a>
                            <a href="view_std_gradiate" class="col-md-6 text-left col-border">
                                <i class="fa fa-mortar-board" aria-hidden="true"></i>&nbsp;
                                <b>รายชื่อนักศึกษาที่คาดว่าจะจบ</b> <span>( List of Graduates )</span>
                            </a>
                            <a href="view_kpc" class="col-md-6 text-left col-border">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;
                                <b>กพช. สะสม</b> <span>( KPCH )</span>
                            </a>
                            <a href="manage_save_event" class="col-md-6 text-left col-border">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;
                                <b>บันทึกกิจกรรม</b> <span>( Activity Log )</span>
                            </a>
                            <a href="manage_save_event" class="col-md-6 text-left col-border">
                                <i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <b>ผลรวมหน่วยกิต</b> <span>( Total Credits )</span>
                            </a>
                            <a href="manage_save_event" class="col-md-6 text-left col-border">
                                <i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <b>ผลรวมหน่วยกิต</b> <span>( Total Credits )</span>
                            </a>
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