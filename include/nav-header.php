<?php $routeName =  basename($_SERVER["SCRIPT_FILENAME"], '.php'); ?>
<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Get the hostname
$host = $_SERVER['HTTP_HOST'];

// Construct the full URL
$fullUrl = $protocol . $host;
$fullUrl .= "/edu"; // localhost
?>
<header class="main-header">
    <div class="d-flex align-items-center logo-box justify-content-start">
        <?php
        $arrNotMenu = [
            "manage_estimate_index",
            "graduate_reg",
            "form_after_gradiate",
            "family_data",
            "dashboard_index",
            "manage_calendar_activity",
            "manage_summary",
            "manage_index",
            "manage_plan",
            "dashboard",
            "manage_teach_more",
            "manage_test_reading",
            "students_read",
            "manage_media_reading",
            "pro_manage_user",
            "manage_notification_std",
            "manage_sum_score",
            "manage_sum_score_print",
            "manage_sum_kpc",
            "manage_sum_kpc_print",
            "manage_share",
            "manage_student_am"
        ];

        $arrNotMenuAdd = [
            "manage_estimate_add",
            "manage_estimate_edit",
            "graduate_reg_add",
            "graduate_reg_edit",
            "form_after_gradiate_add",
            "form_after_gradiate_edit",
            "family_data_add",
            "family_data_edit",
            "family_data_detail",
            "edit_admin",
            "manage_private_data",
            "main_dashboard",
            "manage_form_read_add",
            "manage_media_reading_add",
            "manage_media_reading_edit",
            "pro_manage_user_add",
            "pro_manage_user_edit",
            "add_student",
            "manage_sum_score_add",
            "manage_sum_kpc_add",
        ];
        if ($_SESSION['user_data']->role_id == 3) {
            $arrNotMenuAdd[] = 'manage_form_read';
            if (!empty($_SESSION['user_data']->role_custom_id)) {
                unset($arrNotMenu[6]);
            }
        } else {
            $arrNotMenu[] = 'manage_calendar_new_add';
            $arrNotMenu[] = 'manage_calendar_new_edit';
            $arrNotMenu[] = 'manage_calendar_new_am';
        }
        if ($_SESSION['user_data']->role_id == 5) {
            $arrNotMenuAdd[] = 'manage_form_read';
            // $arrNotMenuAdd[] = 'students_read';
        }
        if ($_SESSION['user_data']->role_id == 7) {
            $arrNotMenuAdd[] = 'dashboard_index';
        }
        if (!empty($_SESSION['user_data']->role_custom_id)) {
            $arrNotMenuAdd[] = 'manage_summary';
            $arrNotMenuAdd[] = 'manage_summary_add';
            $arrNotMenuAdd[] = 'manage_summary_edit';
            $arrNotMenuAdd[] = 'report_detail';
        }
        if ($_SESSION['user_data']->role_id != 4 && !in_array($routeName, $arrNotMenu) && !in_array($routeName, $arrNotMenuAdd)) {
            echo ' <a href="#" class="waves-effect waves-light nav-link rounded d-none d-md-inline-block mx-10 push-btn" data-toggle="push-menu" role="button">
                        <i class="ti-menu"></i>
                    </a>';
        } else if (in_array($routeName, $arrNotMenuAdd)) {
        } else {
            if ($routeName == 'manage_credit_new_view') { ?>
                <a href="../main_menu"
                    class="waves-effect waves-light nav-link rounded d-none d-md-inline-block mx-10 push-btn"> <i
                        class="ti-home"></i></a>
            <?php } else {

                $redirect = "../main_menu?list=1";
                if (isset($_GET['url']) && ($routeName == 'dashboard_index' || $routeName == 'dashboard')) {
                    $redirect = $_GET['url'];
                } ?>
                <a href="<?php echo $redirect ?>"
                    class="waves-effect waves-light nav-link rounded d-none d-md-inline-block mx-10 push-btn"> <i
                        class="ti-home"></i></a>
        <?php  }
        } ?>
    </div>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top pl-10" style="flex-wrap: unset;">
        <!-- Sidebar toggle button-->
        <div class="app-menu">
            <ul class="header-megamenu nav">
                <?php if ($_SESSION['user_data']->role_id != 4 && !in_array($routeName, $arrNotMenu) && !in_array($routeName, $arrNotMenuAdd)) {

                    echo '<li class="btn-group nav-item d-md-none">
                                <a href="#" class="waves-effect waves-light nav-link rounded push-btn mr-0" data-toggle="push-menu" role="button">
                                    <i class="ti-menu"></i>
                                </a>
                            </li>';
                } else if (in_array($routeName, $arrNotMenuAdd)) {
                } else {
                    if ($_SESSION['user_data']->role_id == 4 && ($routeName == 'manage_calendar' || $routeName == 'manage_testing_std')) {
                        echo '<li class="btn-group nav-item d-md-none">
                                <a href="#" class="waves-effect waves-light nav-link rounded push-btn mr-0" data-toggle="push-menu" role="button">
                                    <i class="ti-menu"></i>
                                </a>
                            </li>';
                    } else {
                        if ($routeName == 'manage_form_read_add') {
                        } else if ($routeName == 'edit_admin' || $routeName == 'main_dashboard' || $routeName == 'manage_students') {
                        } else if ($_SESSION['user_data']->role_id == 7 || !empty($_SESSION['user_data']->role_custom_id)) {
                        } else {
                            $redirect = "../main_menu?list=1";
                            if (isset($_GET['url']) && ($routeName == 'dashboard_index' || $routeName == 'dashboard')) {
                                $redirect = $_GET['url'];
                            }
                            echo '<li class="btn-group nav-item d-md-none">
                            <a href="' . $redirect . '" class="waves-effect waves-light nav-link rounded push-btn mr-0">
                                <i class="ti-home"></i>
                            </a>
                        </li>';
                        }
                    }
                } ?>
            </ul>
        </div>

        <div class="navbar-custom-menu r-side">
            <ul class="nav navbar-nav">
                <li class="btn-group nav-item d-lg-inline-flex">
                    <h3 style="margin-top: 10px;" class="overflow-ellipsis"><?php
                                                                            $userData = $_SESSION['user_data'];

                                                                            if ($userData->edu_name !== null) {
                                                                                // Display edu_name if role_id is 3, otherwise display full name
                                                                                echo ($userData->role_id == 3) ? $userData->edu_name : $userData->name . " " . $userData->surname;
                                                                            } elseif ($userData->edu_name === null && $userData->role_id == 2) {
                                                                                // Display district for role_id 2
                                                                                echo "อำเภอ-" . $userData->district_am;
                                                                            } elseif (in_array($userData->role_id, [4, 5, 6, 7])) {
                                                                                // Display full name for roles 4, 5, and 6
                                                                                echo $userData->name . " " . $userData->surname;
                                                                            } else if (!empty($_SESSION['user_data']->role_custom_id)) {
                                                                                // Default case for other roles
                                                                                echo $userData->name . " " . $userData->surname;
                                                                            } else {
                                                                                if ($_SESSION['user_data']->edu_type == "adminweb") {
                                                                                    // Default case for other roles
                                                                                    echo 'แอดมินเว็บไซต์';
                                                                                } else {
                                                                                    echo 'แอดมินระบบ';
                                                                                }
                                                                            }
                                                                            ?></h3>
                </li>
                <li class="btn-group nav-item d-lg-inline-flex d-none">
                    <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link rounded full-screen"
                        title="Full Screen">
                        <i class="ti-fullscreen"></i>
                    </a>
                </li>

                <!-- User Account-->
                <li class="dropdown user user-menu">
                    <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown" title="User">
                        <i class="ti-power-off text-danger"></i>
                    </a>
                    <ul class="dropdown-menu animated flipInX">
                        <?php //if ($_SESSION['user_data']->role_id != 4) { 
                        ?>
                        <li class="user-body">
                            <a class="dropdown-item"
                                href="edit_admin?url=<?php echo explode('/', $_SERVER['REQUEST_URI'])[3] ?>"><i
                                    class=" ti-user text-muted mr-2"></i>แก้ไขโปรไฟล์</a>
                        </li>
                        <?php //} 
                        ?>
                        <?php if ($_SESSION['user_data']->role_id == 3 || $_SESSION['user_data']->role_id == 2 || $_SESSION['user_data']->role_id == 5) {?>
                            <li class="user-body">
                                <a class="dropdown-item"
                                    href="<?php echo $fullUrl ?>/view-grade/manage_private_data?url=<?php echo $fullUrl . "/" . explode('/', $_SERVER['REQUEST_URI'])[2] . "/" . explode('/', $_SERVER['REQUEST_URI'])[3] ?>"><i
                                        class="fa fa-address-card-o text-muted mr-2"></i>ข้อมูลส่วนตัวครู</a>
                            </li>
                        <?php } ?>
                        <li class="user-body">
                            <a class="dropdown-item" onclick="logout()" style="cursor: pointer;"><i
                                    class="ti-lock text-muted mr-2"></i>ออกจากระบบ</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<script>
    function logout() {
        const text = "ต้องการออกจากระบบหรือไม่ ?";
        if (confirm(text)) {
            $.ajax({
                type: "POST",
                url: "<?php echo $fullUrl ?>/admin/controllers/login_controller",
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
</script>