<?php
include 'include/check_login.php'; ?>
<?php include 'include/check_role_std.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>หน้าหลักนักศึกษา</title>
    <link rel="stylesheet" href="css/main_std.css">
    <style>
        .submenu-item {
            border-top: 1px solid #ddd;
            padding: 10px;
        }

        .submenu-item:first-child {
            border-top: none;
            padding-top: 15px;
            /* Remove border-top for the first child */
        }

        .submenu-item:last-child {
            border-bottom: none;
            /* Remove border-bottom for the last child */
        }

        .custom-std:hover {
            background-color: #0000ff;
        }

        .card-collapse {
            margin-top: -10px;
        }

        .card-collapse ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .card-collapse ul li {
            padding: 10px;
            font-size: 18px;
        }

        .card {
            border-radius: unset;
            border-radius: 0 0 10px 10px;
            padding-bottom: 0;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" style="position: relative;">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    <!-- <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="view_test_grade">
                                        <div class="box overflow-hidden" style="box-shadow: blue 0px 3px 8px;">
                                            <div class="box-body d-flex p-2">
                                                <div class="icon rounded-circle w-60 h-60" style="background-color: blue;">
                                                    <i class="mr-0 font-size-20 fa fa fa-bar-chart"></i>
                                                </div>
                                                <div class="box-title-text">
                                                    <h4 class="m-0" style="color: blue;"><b>ผลสอบ</b></h4>
                                                    <h6 class="m-0"><b>( Test Grade Result )</b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="view_n_net">
                                        <div class="box overflow-hidden" style="box-shadow: #e50102 0px 3px 8px;">
                                            <div class="box-body d-flex p-2">
                                                <div class="icon rounded-circle w-60 h-60" style="background-color: #e50102;">
                                                    <i class="mr-0 font-size-20 fa fa-file-text"></i>
                                                </div>
                                                <div class="box-title-text">
                                                    <h4 class="m-0" style="color: #e50102;"><b>ผลการสอบ N-Net</b></h4>
                                                    <h6 class="m-0"><b>( N-NET Result )</b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="view_credit?mode=std_views">
                                        <div class="box overflow-hidden" style="box-shadow: #FF45CF 0px 3px 8px;">
                                            <div class="box-body d-flex p-2">
                                                <div class="icon rounded-circle w-60 h-60" style="background-color:  #FF45CF;">
                                                    <i class="mr-0 font-size-20 fa fa-tasks"></i>
                                                </div>
                                                <div class="box-title-text">
                                                    <h4 class="m-0" style="color: #FF45CF;"><b>ผลรวมหน่วยกิต</b></h4>
                                                    <h6 class="m-0"><b>( Total Credits )</b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="view_table_test">
                                        <div class="box overflow-hidden" style="box-shadow: #dfa700 0px 3px 8px;">
                                            <div class="box-body d-flex p-2">
                                                <div class="icon rounded-circle w-60 h-60" style="background-color: #dfa700;">
                                                    <i class="mr-0 font-size-20 fa fa-calendar"></i>
                                                </div>
                                                <div class="box-title-text">
                                                    <h4 class="m-0" style="color: #dfa700;"><b>ตารางสอบ</b></h4>
                                                    <h6 class="m-0"><b>( Exam Schedule )</b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="view_moral">
                                        <div class="box overflow-hidden" style="box-shadow: #03a9f5 0px 3px 8px;">
                                            <div class="box-body d-flex p-2">
                                                <div class="icon rounded-circle w-60 h-60" style="background-color: #03a9f5;">
                                                    <i class="mr-0 font-size-20 fa fa-clipboard"></i>
                                                </div>
                                                <div class="box-title-text">
                                                    <h4 class="m-0" style="color: #03a9f5;"><b>คุณธรรม จริยธรรม</b></h4>
                                                    <h6 class="m-0"><b>( Moral )</b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="view_std_test">
                                        <div class="box overflow-hidden" style="box-shadow: #9c28af 0px 3px 8px;">
                                            <div class="box-body d-flex p-2">
                                                <div class="icon rounded-circle w-60 h-60" style="background-color: #9c28af;">
                                                    <i class="mr-0 font-size-20 fa fa-vcard"></i>
                                                </div>
                                                <div class="box-title-text">
                                                    <h4 class="m-0" style="color: #9c28af;"><b>รายชื่อนักศึกษาที่มีสิทธิ์สอบ</b></h4>
                                                    <h6 class="m-0"><b>( List of Eligible Students )</b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="view_std_gradiate">
                                        <div class="box overflow-hidden" style="box-shadow: #4caf52 0px 3px 8px;">
                                            <div class="box-body d-flex p-2">
                                                <div class="icon rounded-circle w-60 h-60" style="background-color:  #4caf52;">
                                                    <i class="mr-0 font-size-20 fa fa-mortar-board"></i>
                                                </div>
                                                <div class="box-title-text">
                                                    <h4 class="m-0" style="color: #4caf52;"><b>รายชื่อนักศึกษาที่คาดว่าจะจบ</b></h4>
                                                    <h6 class="m-0"><b>( List of Graduates )</b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="view_std_finish">
                                        <div class="box overflow-hidden" style="box-shadow: #FF6B4C 0px 3px 8px;">
                                            <div class="box-body d-flex p-2">
                                                <div class="icon rounded-circle w-60 h-60" style="background-color:  #FF6B4C;">
                                                    <i class="mr-0 font-size-20 fa fa-mortar-board"></i>
                                                </div>
                                                <div class="box-title-text">
                                                    <h4 class="m-0" style="color: #FF6B4C;"><b>รายชื่อนักศึกษาที่จบการศึกษา</b></h4>
                                                    <h6 class="m-0"><b>( List of Graduated )</b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="view_kpc">
                                        <div class="box overflow-hidden" style="box-shadow: #eba33f 0px 3px 8px;">
                                            <div class="box-body d-flex p-2">
                                                <div class="icon rounded-circle w-60 h-60" style="background-color:  #eba33f;">
                                                    <i class="mr-0 font-size-20 fa fa-file-text-o"></i>
                                                </div>
                                                <div class="box-title-text">
                                                    <h4 class="m-0" style="color: #eba33f;"><b>กพช. สะสม</b></h4>
                                                    <h6 class="m-0"><b>( KPCH )</b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="manage_save_event?index_student=1">
                                        <div class="box overflow-hidden" style="box-shadow: #27c08a 0px 3px 8px;">
                                            <div class="box-body d-flex p-2">
                                                <div class="icon rounded-circle w-60 h-60" style="background-color:  #27c08a;">
                                                    <i class="mr-0 font-size-20 fa fa-floppy-o"></i>
                                                </div>
                                                <div class="box-title-text">
                                                    <h4 class="m-0" style="color: #27c08a;"><b>บันทึกกิจกรรม</b></h4>
                                                    <h6 class="m-0"><b>( Activity Log )</b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="../student-tracking/after_gradiate?index_student=1">
                                        <div class="box overflow-hidden" style="box-shadow: blue 0px 3px 8px;">
                                            <div class="box-body d-flex p-2">
                                                <div class="icon rounded-circle w-60 h-60" style="background-color: blue;">
                                                    <i class="mr-0 font-size-20 fa fa-clipboard"></i>
                                                </div>
                                                <div class="box-title-text">
                                                    <h4 class="m-0" style="color: blue;"><b>แบบติดตามนักศึกษาหลังจบการศึกษา</b></h4>
                                                    <h6 class="m-0"><b>( after graduate )</b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="container">
                        <div class="row justify-content-center" style="margin-top: 20px;">
                            <div class="col-md-6">
                                <div class="card-collapse" id="studentMenu">
                                    <div class="card card-body" style="padding: 5px;">
                                        <ul class="px-4">
                                            <!-- <li class="submenu-item"><a href="view_test_grade"><i class="mr-0 font-size-20 fa fa fa-bar-chart"></i> ผลสอบ</a></li> -->
                                            <li class="submenu-item"><a href="view_n_net"><i class="mr-0 font-size-20 fa fa-file-text"></i> ผลสอบ N-Net</a></li>
                                            <li class="submenu-item"><a href="view_credit?mode=std_views"><i class="mr-0 font-size-20 fa fa-tasks"></i> ผลการเรียน</a></li>
                                            <li class="submenu-item"><a href="view_table_test"><i class="mr-0 font-size-20 fa fa-calendar"></i> ตารางสอบ</a></li>
                                            <li class="submenu-item"><a href="view_moral"><i class="mr-0 font-size-20 fa fa-clipboard"></i> คุณธรรม จริยธรรม</a></li>
                                            <li class="submenu-item"><a href="view_std_test"><i class="mr-0 font-size-20 fa fa-vcard"></i> รายชื่อนักศึกษาที่มีสิทธิ์สอบ</a></li>
                                            <li class="submenu-item"><a href="view_std_gradiate"><i class="mr-0 font-size-20 fa fa-mortar-board"></i> รายชื่อนักศึกษาที่คาดว่าจะจบ</a></li>
                                            <li class="submenu-item"><a href="view_std_finish"><i class="mr-0 font-size-20 fa fa-mortar-board"></i> รายชื่อนักศึกษาที่จบการศึกษา</a></li>
                                            <li class="submenu-item"><a href="view_kpc"><i class="mr-0 font-size-20 fa fa-file-text-o"></i> กพช. สะสม</a></li>
                                            <li class="submenu-item"><a href="manage_save_event?index_student=1"><i class="mr-0 font-size-20 fa fa-floppy-o"></i> บันทึกกิจกรรม</a></li>
                                            <li class="submenu-item"><a href="../student-tracking/after_gradiate?index_student=1"><i class="mr-0 font-size-20 fa fa-clipboard"></i> แบบติดตามนักศึกษาหลังจบการศึกษา</a></li>
                                        </ul>
                                    </div>
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

        <?php include "../include/footer.php"; ?>
    </div>

    <?php include 'include/scripts.php'; ?>
</body>

</html>