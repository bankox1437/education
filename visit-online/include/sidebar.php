<style>
    .sidebar-footer a {
        width: 50%;
    }

    .user-profile .info {
        height: 75px;
    }

    .sidebar-menu {
        padding-bottom: 0px;
    }
</style>
<aside class="main-sidebar" style="<?php echo $_SESSION['user_data']->role_id == 6 ? "display: none;" : "" ?>">
    <?php $routeName =  basename($_SERVER["SCRIPT_FILENAME"], '.php'); ?>
    <!-- sidebar-->
    <section class="sidebar" style="position: relative;">
        <div class="user-profile px-10 py-15">
            <div class="d-flex align-items-center">
                <div class="info ml-10">
                    <h6 class="mb-0" style="font-size: 13px;"><b>ระบบนิเทศการสอน ติดตามการปฏิบัติงาน</b></h6>
                    <p class="mb-0">ยินดีต้อนรับ <span style="font-size:10px">(<?php echo $_SESSION['user_data']->role_name ?>)</span></p>
                    <h6 class="mb-0"><?php echo $_SESSION['user_data']->name . ' ' . $_SESSION['user_data']->surname; ?></h6>
                </div>
            </div>
        </div>

        <?php
        $activeManageCalendar = "";
        $fileRelate = [
            "manage_calendar_add",
            "manage_calendar_edit",
            "view_plan_calender_detail",
            "manage_learning_add",
            "manage_learning_edit",
            "sign_in_list",
            "manage_calendar_new_add",
            "view_plan_calender_detail_new",
            "manage_calendar_new_edit",
            "manage_score",
            "sign_in_sum",
            "manage_testing",
            "manage_testing_add",
            "manage_testing_edit"
        ];

        // Check if the route is 'manage_calendar' and if the class parameter exists
        if (isset($_REQUEST['class']) || isset($_SESSION['manage_calendar_class'])) {
            $activeManageCalendar = $_REQUEST['class'] ?? $_SESSION['manage_calendar_class'];
        }

        // Check if routeName is in the fileRelate array and match the class to activate the correct menu
        $active0 = '';
        $active1 = '';
        $active2 = '';
        $active3 = '';
        if (($routeName == 'manage_calendar' || in_array($routeName, $fileRelate)) && $activeManageCalendar == "0") {
            $active0 = 'active';
        } else if (($routeName == 'manage_calendar' || in_array($routeName, $fileRelate)) && $activeManageCalendar == "1") {
            $active1 = 'active';
        } else if (($routeName == 'manage_calendar' || in_array($routeName, $fileRelate)) && $activeManageCalendar == "2") {
            $active2 = 'active';
        } else if (($routeName == 'manage_calendar' || in_array($routeName, $fileRelate)) && $activeManageCalendar == "3") {
            $active3 = 'active';
        }

        if ($_SESSION['user_data']->role_id != 4) {
            $status = json_decode($_SESSION['user_data']->status);
            $calendar_new = isset($status->calendar_new) && !empty($status->calendar_new) ? true : false;
        }
        ?>

        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree" style="margin-bottom:20px;">
            <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                <li class="<?php echo $routeName == "manage_main_calender_add" || $routeName == "manage_main_calendar_edit" ? 'active' : '' ?>">
                    <a href="manage_main_calendar">
                        <i class="fa fa-calendar" style="margin-right: 5px;"></i>
                        <span>จัดการปฏิทินการพบกลุ่ม</span>
                    </a>
                </li>
                <?php if (empty($calendar_new)) { ?>
                    <li class="<?php echo  $active0 ?>">
                        <a href="manage_calendar?class=0">
                            <i class="fa fa-calendar-check-o" style="margin-right: 5px;"></i>
                            <span>จัดการการพบกลุ่ม</span>
                        </a>
                    </li>
                <?php } ?>
                <!-- <li class="<?php echo $routeName == 'manage_summary_add' || $routeName == 'manage_summary_edit' || $routeName == 'report_detail' ? 'active' : '' ?>">
                    <a href="manage_summary">
                        <i class="fa fa-file-text-o" style="margin-right: 5px;"></i>
                        <span>จัดการรายงานผลการดำเนินงาน</span>
                    </a>
                </li> -->
                <!-- <li class="<?php echo $routeName == 'manage_index_add' || $routeName == 'manage_index_edit' || $routeName == 'manage_index_detail' ? 'active' : '' ?>">
                    <a href="manage_index">
                        <i class="ti-zip" style="margin-right: 5px;"></i>
                        <span>จัดการการประเมิน</span>
                    </a>
                </li> -->
                <!-- <li class="<?php echo $routeName == 'manage_testing_add' || $routeName == 'manage_testing_edit' ? 'active' : '' ?>">
                    <a href="manage_testing">
                        <i class="ti-pencil" style="margin-right: 5px;"></i>
                        <span>แบบทดสอบ</span>
                    </a>
                </li> -->
                <?php if (!empty($calendar_new)) { ?>
                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="ti-more"></i>Smart Coach Room
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" style="display: block;">
                            <li class="<?php echo  $active1 ?>">
                                <a href="manage_calendar?class=1">
                                    <i class="fa fa-calendar-check-o" style="margin-right: 5px;"></i>
                                    <span>การพบกลุ่ม ประถม</span>
                                </a>
                            </li>
                            <li class="<?php echo  $active2 ?>">
                                <a href="manage_calendar?class=2">
                                    <i class="fa fa-calendar-check-o" style="margin-right: 5px;"></i>
                                    <span>การพบกลุ่ม ม.ต้น</span>
                                </a>
                            </li>
                            <li class="<?php echo  $active3 ?>">
                                <a href="manage_calendar?class=3">
                                    <i class="fa fa-calendar-check-o" style="margin-right: 5px;"></i>
                                    <span>การพบกลุ่ม ม.ปลาย</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="check_data">
                                    <i class="fa fa-folder-o" style="margin-right: 5px;"></i>
                                    <span>ตรวจสอบ/แก้ไขข้อมูลพบกลุ่ม</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <!-- <li class="<?php echo $routeName == 'manage_sum_score_add' ? 'active' : '' ?>">
                    <a href="manage_sum_score">
                        <i class="ti-bar-chart-alt" style="margin-right: 5px;"></i>
                        <span>กศน. 4</span>
                    </a>
                </li> -->
                <!-- <li class="<?php echo $routeName == 'manage_calendar_activity_add' || $routeName == 'manage_calendar_activity_edit' || $routeName == 'manage_calendar_activity_std' ? 'active' : '' ?>">
                    <a href="manage_calendar_activity">
                        <i class="ti-calendar" style="margin-right: 5px;"></i>
                        <span>จัดการปฏิทินกิจกรรม</span>
                    </a>
                </li> -->
            <?php } ?>
            <?php if ($_SESSION['user_data']->role_id != 3 && $_SESSION['user_data']->role_id != 4) { ?>
                <li class="<?php echo $routeName == "manage_calendar" || $routeName == 'view_plan_calender_detail' || $routeName == 'view_plan_calender_detail_new'
                                || $routeName == 'manage_summary' || $routeName == 'report_detail' || $routeName == 'manage_index' || $routeName == 'manage_index_detail' ? 'active' : '' ?>">
                    <a href="teacher_list">
                        <i class="fa fa-address-card-o" style="margin-right: 5px;"></i>
                        <span>รายชื่อครูตำบล</span>
                    </a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['user_data']->role_id == 2) { ?>
                <!-- <li class="<?php echo $routeName == "am_manage_teacher_add" || $routeName == "am_manage_teacher_edit" ? 'active' : '' ?>">
                    <a href="am_manage_teacher">
                        <i class="fa fa-address-card" style="margin-right: 5px;"></i>
                        <span>จัดการแอดมินครูตำบล</span>
                    </a>
                </li> -->
            <?php } ?>

            <?php if ($_SESSION['user_data']->role_id == 4) { ?>
                <li class="<?php echo $routeName == 'view_plan_calender_detail' || $routeName == 'view_plan_calender_detail_new' ? 'active' : '' ?>">
                    <a href="manage_calendar">
                        <i class="fa fa-address-card" style="margin-right: 5px;"></i>
                        <span>ข้อมูลการพบกลุ่ม</span>
                    </a>
                </li>
                <li>
                    <a href="manage_testing_std">
                        <i class="ti-pencil" style="margin-right: 5px;"></i>
                        <span>แบบทดสอบ</span>
                    </a>
                </li>
                <!-- <li class="<?php echo $routeName == 'manage_calendar_activity_std' ? 'active' : '' ?>">
                    <a href="manage_calendar_activity">
                        <i class="ti-calendar" style="margin-right: 5px;"></i>
                        <span>ปฏิทินกิจกรรม</span>
                    </a>
                </li> -->
            <?php } ?>
        </ul>
        <?php if ($_SESSION['user_data']->role_id != 4) {
            $user_data = $_SESSION['user_data'];
            $status_use_system = json_decode($user_data->status);
        ?>
            <div class="sidebar-footer" style="position: absolute;bottom: auto;">
                <!-- item-->
                <?php if ($status_use_system->std_tracking == '1') { ?>
                    <a href="../student-tracking/index" class="link link-edu-btn" data-toggle="tooltip" title="ระบบฐานข้อมูลนักศึกษา" data-original-title="students-tracking">
                        <i class="fa fa-address-book"></i>
                        <span style="font-size: 12px;">ฐานข้อมูลนักศึกษา</span>
                    </a>
                <?php } ?>

                <?php if ($status_use_system->view_grade == '1') { ?>
                    <!-- item-->
                    <a href="../view-grade/index" class="link link-edu-btn" data-toggle="tooltip" title="ระบบสืบค้นผลการเรียน" data-original-title="view-grade">
                        <i class="fa fa-bar-chart"></i>
                        <span style="font-size: 12px;">สืบค้นผลการเรียน</span>
                    </a>
                <?php } ?>
                <?php
                if ($_SESSION['user_data']->role_id == 1) { ?>
                    <a href="../admin/manage_admin" class="link link-edu-btn" data-toggle="tooltip" title="ระบบแอดมิน" data-original-title="admin">
                        <i class=" ti-user"></i>
                        <span style="font-size: 12px;">แอดมิน</span>
                    </a>
                <?php } ?>

                <!-- item-->
                <a href="../main_menu" class="link link-edu-btn" data-toggle="tooltip" title="หน้าหลัก" data-original-title="หน้าหลัก">
                    <i class="fa fa-list"></i>
                    <span style="font-size: 12px;">หน้าเมนูหลัก</span>
                </a>
            </div>
        <?php } else { ?>
            <div class="sidebar-footer" style="position: absolute;bottom: auto;">
                <!-- item-->
                <a href="../main_menu" class="link link-edu-btn" data-toggle="tooltip" title="หน้าหลัก" data-original-title="หน้าหลัก">
                    <i class="fa fa-list"></i>
                    <span style="font-size: 12px;">หน้าเมนูหลัก</span>
                </a>
            </div>
        <?php } ?>
    </section>
</aside>