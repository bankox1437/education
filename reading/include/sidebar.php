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
                    <h6 class="mb-0"><b>ระบบส่งเสริมการอ่าน</b></h6>
                    <p class="mb-0">ยินดีต้อนรับ <span style="font-size:10px"><?php echo $_SESSION['user_data']->role_name ?></span></p>
                    <h6 class="mb-0"><?php echo $_SESSION['user_data']->name . ' ' . $_SESSION['user_data']->surname; ?></h6>
                </div>
            </div>
        </div>

        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree" style="margin-bottom:20px;">
            <?php if ($_SESSION['user_data']->role_id != 4) { ?>
                <li class="<?php echo $routeName == "manage_media_reading_add" ||  $routeName == "manage_media_reading_edit" ? 'active' : '' ?>">
                    <a href="manage_media_reading">
                        <i class="ti-book" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span><?php echo ($_SESSION['user_data']->role_id == 3) ? 'จัดการ' : '' ?>สื่อการอ่าน</span>
                    </a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['user_data']->role_id == 4) { ?>
                <li class="<?php echo $routeName == "reading_test" || $routeName == "manage_test_reading_add" || $routeName == "manage_test_reading_edit"  ? 'active' : '' ?>">
                    <a href="manage_test_reading">
                        <i class="fa fa-file-text" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span><?php echo ($_SESSION['user_data']->role_id == 3) ? 'จัดการ' : '' ?>การสอบอ่านออกเสียง</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($_SESSION['user_data']->role_id != 4) { ?>
                <li>
                    <a href="report_media">
                        <i class="fa fa-file-text" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>รายงานเกี่ยวกับสื่อ</span>
                    </a>
                </li>
            <?php } ?>

            <!-- <li>
                <a href="reading_test">
                    <i class="fa fa-file-text" aria-hidden="true" style="margin-right: 5px;"></i>
                    <span>จัดการสอบอ่าน</span>
                </a>
            </li>
            <li>
                <a href="simple-audio/index">
                    <i class="fa fa-file-text" aria-hidden="true" style="margin-right: 5px;"></i>
                    <span>จัดการสอบอ่าน 2</span>
                </a>
            </li> -->
        </ul>
        <div class="sidebar-footer" style="position: absolute;bottom: auto;">
            <?php
            $user_data = $_SESSION['user_data'];
            $status_use_system = json_decode($user_data->status);
            ?>
            <?php if ($status_use_system->view_grade == '1') { ?>
                <!-- item-->
                <a href="../view-grade/index" class="link link-edu-btn" data-toggle="tooltip" title="ระบบสืบค้นผลการเรียน" data-original-title="view-grade">
                    <i class="fa fa-bar-chart"></i>
                    <span style="font-size: 12px;">สืบค้นผลการเรียน</span>
                </a>
            <?php } ?>

            <?php if ($status_use_system->visit_online == '1') { ?>
                <!-- item-->
                <a href="../visit-online/index" class="link link-edu-btn" data-toggle="tooltip" title="ระบบนิเทศการสอน ติดตามการปฏิบัติงาน" data-original-title="visit-online">
                    <i class="fa fa-calendar"></i>
                    <span style="font-size: 12px;">นิเทศการสอน</span>
                </a>
            <?php } ?>
            <?php if ($status_use_system->std_tracking == '1' && $_SESSION['user_data']->role_id != 4) { ?>
                <!-- item-->
                <a href="../student-tracking/index" class="link link-edu-btn" data-toggle="tooltip" title="ระบบฐานข้อมูลนักศึกษา" data-original-title="students-tracking">
                    <i class="fa fa-address-book"></i>
                    <span style="font-size: 12px;">ฐานข้อมูลนักศึกษา</span>
                </a>
            <?php } ?>
            <!-- item-->
            <?php
            if ($_SESSION['user_data']->role_id == 1) { ?>
                <a href="../admin/manage_admin" class="link link-edu-btn" data-toggle="tooltip" title="ระบบแอดมิน" data-original-title="admin">
                    <i class=" ti-user"></i>
                    <span style="font-size: 12px;">แอดมิน</span>
                </a>
            <?php } ?>
            <!-- item-->

            <?php
            if ($_SESSION['user_data']->role_id != 5) { ?>
                <a href="../main_menu" class="link link-edu-btn" data-toggle="tooltip" title="หน้าหลัก" data-original-title="หน้าหลัก">
                    <i class="fa fa-list"></i>
                    <span style="font-size: 12px;">หน้าเมนูหลัก</span>
                </a>
            <?php } ?>
            <!-- item-->
        </div>
    </section>
</aside>