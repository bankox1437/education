<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>หน้าหลักนักศึกษา</title>
    <link rel="stylesheet" href="css/main_std.css">
    <style>
        .admin-use {
            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .admin-use i {
            font-size: 36px;
        }

        .col-border {
            font-size: 30px;
        }

        .box-title-text {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            flex-direction: column;
        }

        .box-title-text h4 {
            font-size: 25px;
        }

        .content-header h3 {
            font-size: 2rem;
        }

        @media only screen and (max-width: 600px) {
            .box-title-text h4 {
                font-size: 18px;
            }

            .box-title-text {
                align-items: center;
                text-align: center;
                margin-left: 5px;
            }

            .content-header h3 {
                font-size: 24px;
            }
        }

        .main-footer {
            margin: 5px;
            padding-top: 5px;
            padding-bottom: 5px;
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
                    <div class="container">
                        <div class="row justify-content-center">

                            <div class="col-md-12 row justify-content-center mt-2">
                                <div class="col-xl-7 col-md-6 col-12">
                                    <a href="after_gradiate">
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