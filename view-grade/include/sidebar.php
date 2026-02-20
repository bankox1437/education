<style>
    .sidebar-footer a {
        width: 50%;
    }

    .user-profile .info {
        height: 65px;
    }

    .sidebar-menu {
        padding-bottom: 0px;
    }
</style>
<aside class="main-sidebar">
    <?php $routeName =  basename($_SERVER["SCRIPT_FILENAME"], '.php'); ?>
    <!-- sidebar-->
    <section class="sidebar" style="position: relative;">
        <div class="user-profile px-10 py-15">
            <div class="d-flex align-items-center">
                <div class="info ml-10">
                    <h6 class="mb-0"><b>ระบบสืบค้นผลการเรียน</b></h6>
                    <p class="mb-0">ยินดีต้อนรับ <span style="font-size:10px"><?php echo $_SESSION['user_data']->role_name ?></span></p>
                    <h6 class="mb-0"><?php echo $_SESSION['user_data']->name . ' ' . $_SESSION['user_data']->surname; ?></h6>
                </div>
            </div>
        </div>

        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree" style="margin-bottom:20px;">
            <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                <!-- <li>
                    <a href="student_list">
                        <i class="fa fa-address-book" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>กิจกรรมนักศึกษา</span>
                    </a>
                </li> -->
            <?php } ?>

            <?php if ($_SESSION['user_data']->role_id == 1) { ?>
                <li>
                    <a href="dashboard">
                        <i class="fa fa-dashboard" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>หน้าแดชบอร์ด</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($_SESSION['user_data']->role_id == 2) { ?>
                <li class="<?php echo $routeName == "am_manage_teacher_add" ||  $routeName == "am_manage_teacher_edit" ||  $routeName == "am_manage_teacher_leave_day" ? 'active' : '' ?>">
                    <a href="am_manage_teacher">
                        <i class="fa fa-address-book" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการแอดมินครูตำบล</span>
                    </a>
                </li>
                <li>
                    <a href="manage_role">
                        <i class="fa fa-fw fa-check-square-o" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการสิทธิ์ผู้ใช้</span>
                    </a>
                </li>
                <li>
                    <a href="manage_student_am">
                        <i class="ti-user" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>ข้อมูลนักศึกษา</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($_SESSION['user_data']->role_id == 3  || $_SESSION['user_data']->role_id == 1) { ?>

                <!-- <li class="<?php echo $routeName == "manage_test_grade_add" ||  $routeName == "manage_test_grade_edit" ? 'active' : '' ?>">
                    <a href="manage_test_grade">
                        <i class="fa fa fa-bar-chart" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการคะแนนสอบแต่ละเทอม</span>
                    </a>
                </li> -->
                <li class="<?php echo $routeName == "manage_n_net_add" ? 'active' : '' ?>">
                    <a href="manage_n_net">
                        <i class="fa fa-file-text" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการคะแนน N-NET</span>
                    </a>
                </li>
                <li class="<?php echo $routeName == "manage_kpc_add" ||  $routeName == "manage_kpc_edit" ? 'active' : '' ?>">
                    <a href="manage_kpc">
                        <i class="fa fa-file-text-o" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการคะแนน กพช.</span>
                    </a>
                </li>
                <li class="<?php echo $routeName == "manage_table_test_add" ||  $routeName == "manage_table_test_edit" ? 'active' : '' ?>">
                    <a href="manage_table_test">
                        <i class="fa fa-calendar" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการตารางสอบ</span>
                    </a>
                </li>
                <li class="<?php echo $routeName == "manage_std_test_add" ? 'active' : '' ?>">
                    <a href="manage_std_test">
                        <i class="fa fa-vcard" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการรายชื่อผู้มีสิทธิ์สอบ</span>
                    </a>
                </li>
                <li class="<?php echo $routeName == "manage_std_gradiate_add" ? 'active' : '' ?>">
                    <a href="manage_std_gradiate">
                        <i class="fa fa-mortar-board" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการรายชื่อ นศ. ที่คาดว่าจะจบ</span>
                    </a>
                </li>
                <li class="<?php echo $routeName == "manage_std_finish_add" ? 'active' : '' ?>">
                    <a href="manage_std_finish">
                        <i class="fa fa-mortar-board" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการรายชื่อ นศ. ที่จบการศึกษา</span>
                    </a>
                </li>
                <!-- <li class="<?php echo $routeName == "manage_moral_add" ||  $routeName == "manage_moral_edit" ? 'active' : '' ?>">
                    <a href="manage_moral">
                        <i class="fa fa-clipboard" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการคะแนนคุณธรรม จริยธรรม</span>
                    </a>
                </li> -->
                <li class="<?php echo $routeName == "manage_credit_new_add" ||  $routeName == "manage_credit_new_edit" || $routeName == "manage_credit_new_view" ? 'active' : '' ?>">
                    <a href="manage_credit_new_view?mode=view">
                        <i class="fa fa-file-text" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการผลการเรียน</span>
                    </a>
                </li>
                <li class="<?php echo $routeName == "manage_set_subject" || $routeName == "manage_credit_set_edit" ? 'active' : '' ?>">
                    <a href="manage_credit_set">
                        <i class="ti-layers" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการรายวิชา</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="manage_save_event">
                        <i class="ti-layers" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>กิจกรรมนักศึกษา</span>
                    </a>
                </li> -->
                <li class="<?php echo $routeName == "manage_save_event" || $routeName == "view_save_event" ? 'active' : '' ?>">
                    <a href="student_list">
                        <i class="fa fa-book" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>สมุดบันทึกนักศึกษา</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                <li class="<?php echo $routeName == "manage_list_name_add" ||  $routeName == "manage_list_name_edit" ? 'active' : '' ?>">
                    <a href="manage_list_name">
                        <i class="fa fa-address-book" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>จัดการรายชื่อผู้บริหาร</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <div class="sidebar-footer" style="position: absolute;bottom: auto;">
            <?php
            $user_data = $_SESSION['user_data'];
            $status_use_system = json_decode($user_data->status);
            ?>

            <?php if ($status_use_system->visit_online == '1') { ?>
                <!-- item-->
                <a href="../visit-online/index" class="link link-edu-btn" data-toggle="tooltip" title="ระบบนิเทศการสอน ติดตามการปฏิบัติงาน" data-original-title="visit-online">
                    <i class="fa fa-calendar"></i>
                    <span style="font-size: 12px;">นิเทศการสอน</span>
                </a>
            <?php } ?>
            <?php if ($status_use_system->std_tracking == '1') { ?>
                <!-- item-->
                <a href="../student-tracking/index" class="link link-edu-btn" data-toggle="tooltip" title="ระบบฐานข้อมูลนักศึกษา" data-original-title="students-tracking">
                    <i class="fa fa-address-book"></i>
                    <span style="font-size: 12px;">ฐานข้อมูลนักศึกษา</span>
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
    </section>
</aside>