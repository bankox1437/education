<?php
session_start();

include "../config/main_function.php";
$mainFunc = new ClassMainFunctions();
$version = $mainFunc->version_script(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการคะแนนสอบแต่ละเทอม</title>
    <style>
        .preloader {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <header class="main-header">
            <div class="d-flex align-items-center logo-box justify-content-start">

            </div>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top pl-10" style="flex-wrap: unset;">
                <!-- Sidebar toggle button-->
                <div class="app-menu">
                    <ul class="header-megamenu nav">
                        <li class="dropdown user user-menu">
                            <a href="<?php echo isset($_SESSION['user_data']) && $_SESSION['user_data']->role_id == 3 ? "../main_menu" : isset($_SESSION['user_data']) && $_SESSION['user_data']->role_id == 5 ? "manage_media_reading" : "../main_menu" ?>" style="width: 100px;" class="text-primary back-main"><i class="ti-arrow-left"></i><span class="back-text"><?php echo isset($_SESSION['user_data']) && $_SESSION['user_data']->role_id == 3 ? "กลับหน้าเมนูหลัก" : isset($_SESSION['user_data']) && $_SESSION['user_data']->role_id == 5 ? "กลับเข้าระบบ" : "กลับหน้าเมนูหลัก" ?></span></a>
                        </li>
                    </ul>
                </div>

                <div class="navbar-custom-menu r-side">
                    <ul class="nav navbar-nav">
                        <!-- <li class="btn-group nav-item d-lg-inline-flex">
                            <h3 style="margin-top: 13px;" class="overflow-ellipsis"></h3>
                        </li> -->
                        <li class="btn-group nav-item d-lg-inline-flex">
                            <h3 style="margin-top: 13px;" class="overflow-ellipsis">
                                <?php
                                if (isset($_SESSION['user_data'])) {
                                    if ($_SESSION['user_data']->edu_name != null) {
                                        if ($_SESSION['user_data']->role_id == 3) {
                                            echo $_SESSION['user_data']->edu_name;
                                        } else {
                                            echo $_SESSION['user_data']->name . " " . $_SESSION['user_data']->surname;
                                        }
                                    } else if ($_SESSION['user_data']->edu_name == null && $_SESSION['user_data']->role_id == 2) {
                                        echo "อำเภอ-" . $_SESSION['user_data']->district_am;
                                    } else if ($_SESSION['user_data']->role_id == 5) {
                                        echo $_SESSION['user_data']->name . " " . $_SESSION['user_data']->surname;
                                    } else {
                                        echo  'แอดมินเจ้าของระบบ';
                                    }
                                }
                                ?></h3>
                        </li>
                        <li class="btn-group nav-item d-lg-inline-flex d-none">
                            <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link rounded full-screen" title="Full Screen">
                                <i class="ti-fullscreen"></i>
                            </a>
                        </li>
                        <?php if (!isset($_SESSION['user_data'])) { ?>
                            <li class="user-body-login">
                                <a class="dropdown-item" href="../view-grade/login?system=reading" style="margin-top: 17px;"><i class="ti-user text-muted mr-2"></i> เข้าสู่ระบบ</a>
                            </li>
                            <li class="user-body-login" style="display: none;">
                                <a class="dropdown-item" href="#"></a>
                            </li>
                        <?php } else { ?>
                            <!-- User Account-->
                            <li class="dropdown user user-menu">
                                <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown" title="User">
                                    <i class="ti-power-off text-danger"></i>
                                </a>
                                <ul class="dropdown-menu animated flipInX">
                                    <li class="user-body">
                                        <a class="dropdown-item" onclick="logout()" style="cursor: pointer;"><i class="ti-lock text-muted mr-2"></i>ออกจากระบบ</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body no-padding text-center">
                                    <div id="toolbar" class="row">
                                        <div class="col-12 d-flex align-items-center">
                                            <h4 class="mt-2">รายการสื่อการอ่าน</h4>
                                        </div>
                                    </div>
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/media_controller?getDataMediaReadingBS=true">
                                    </table>
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
    <script src="js/init-table/index.js?v=<?php echo $version ?>"></script>

    <script>
        function logout() {
            const text = "ต้องการออกจากระบบหรือไม่ ?";
            if (confirm(text)) {
                $.ajax({
                    type: "POST",
                    url: "controllers/login_controller",
                    data: {
                        logout_method: true,
                    },
                    success: function(data) {
                        const json_data = JSON.parse(data);
                        console.log(json_data);
                        if (json_data.status) {
                            window.location.href = "../";
                        }
                    },
                });
            } else {
                return;
            }
        }

        $(document).ready(async function() {
            initTable()
            $('.search input').attr('placeholder', 'ค้นหาด้วยชื่อสื่อการอ่าน');
        });

        function addCountRead(media_id) {
            $.ajax({
                type: "POST",
                url: "controllers/media_controller",
                data: {
                    addDurationView: true,
                    media_id: media_id,
                    mode: 'count'
                },
                dataType: "json",
                success: function(data) {
                    location.href = "reading_read?media_id=" + media_id
                },
            });
        }
    </script>
</body>

</html>