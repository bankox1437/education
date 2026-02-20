<style>
    .sidebar-footer a {
        width: 50%;
    }

    .user-profile .info {
        height: 65px;
    }

    .sidebar-menu {
        padding-bottom: 10px;
    }

    .treeview-menu>li.active a {
        background-color: rgba(89, 73, 214, 0) !important;
        color: rgb(89, 73, 214) !important;
    }
</style>
<aside class="main-sidebar">
    <?php $routeName =  basename($_SERVER["SCRIPT_FILENAME"], '.php'); ?>
    <!-- sidebar-->
    <section class="sidebar" style="position: relative;">
        <div class="user-profile px-10 py-15">
            <div class="d-flex align-items-center">
                <div class="info ml-10">
                    <h6 class="mb-0"><b>ระบบแอดมิน</b></h6>
                    <p class="mb-0">ยินดีต้อนรับ <span style="font-size:10px">(<?php echo $_SESSION['user_data']->role_name ?>)</span></p>
                    <h6 class="mb-0"><?php echo $_SESSION['user_data']->name . ' ' . $_SESSION['user_data']->surname; ?></h6>
                </div>
            </div>
        </div>

        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">
            <?php if ($_SESSION['user_data']->role_id == 1) {
            ?>
                <!-- <li class="treeview">
                    <a href="#">
                        <i class="ti-user"></i>
                        <span>แอดมินจัดการ</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                       
                        <li>
                            <a href="manage_students">
                                <i class="ti-more"></i>
                                <span>ข้อมูลนักนักศึกษา</span>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li class="<?php echo $routeName == "manage_admin_add" || $routeName == "manage_admin_edit" ? 'active' : '' ?>">
                    <a href="manage_admin"><i class="ti-user"></i>แอดมินทั้งหมด</a>
                </li>
                <li>
                    <a href="manage_role"><i class="fa fa-fw fa-check-square-o"></i><span>จัดการสิทธิ์ผู้ใช้</span></a>
                </li>
                <li>
                    <a href="manage_students"><i class="ti-user"></i><span>ข้อมูลนักศึกษา</span></a>
                </li>
                <li class="<?php echo $routeName == "manage_terms_add" || $routeName == "manage_terms_edit" ? 'active' : '' ?>">
                    <a href="manage_terms"><i class="fa fa-calendar"></i><span>จัดการปีการศึกษา</span></a>
                </li>
                <li>
                    <a href="view_duplicate_data"><i class="fa fa-files-o"></i><span>ดูรายการข้อมูลซ้ำ</span></a>
                </li>
                <li>
                    <a href="../visit-online/manage_plan"><i class="fa fa-files-o"></i><span>แผนการสอน</span></a>
                </li>
                <li>
                    <a href="../view-grade/dashboard_index"><i class="fa fa-table"></i><span>ข้อมูลบุคลากร</span></a>
                </li>
                <li>
                    <a href="manage_logs"><i class="fa fa-files-o"></i><span>บันทึก (logs)</span></a>
                </li>

                <?php
                // $active0 = '';
                $active1 = '';
                $active2 = '';
                $active3 = '';
                $active4 = '';
                $active5 = '';
                // if (($routeName == 'manage_calendar' || in_array($routeName, $fileRelate)) && $activeManageCalendar == "0") {
                //     $active0 = 'active';
                // } else 
                if ($routeName == 'settings') {
                    $active1 = 'active';
                } else if ($routeName == 'setting2') {
                    $active2 = 'active';
                } else if ($routeName == 'setting3') {
                    $active3 = 'active';
                } else if ($routeName == 'setting4') {
                    $active4 = 'active';
                } else if ($routeName == 'setting5') {
                    $active5 = 'active';
                }
                ?>
                <li class="treeview menu-open">
                    <a href="#">
                        <i class="ti-settings"></i>ตั้งค่าระบบ
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu" style="display: block;">
                        <li class="<?php echo  $active1 ?>">
                            <a href="settings">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>หน้าแรกระบบ</span>
                            </a>
                        </li>
                        <li class="<?php echo  $active2 ?>">
                            <a href="setting2">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>ชื่อเมนูหลัก</span>
                            </a>
                        </li>
                        <li class="<?php echo  $active3 ?>">
                            <a href="setting3">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>แนะนำแอป</span>
                            </a>
                        </li>
                        <li class="<?php echo  $active4 ?>">
                            <a href="setting4">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>ลิงก์ข่าวสารและแบนเนอร์</span>
                            </a>
                        </li>
                        <li class="<?php echo  $active5 ?>">
                            <a href="setting5">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>แบนเนอร์และวิดีโอ</span>
                            </a>
                        </li>
                        <li class="<?php echo $routeName == "move_file_gd" ? 'active' : '' ?>">
                            <a href="move_file_gd">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>ย้ายไฟล์ไปที่ google drive</span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
        <div class="sidebar-footer" style="position: absolute;bottom: auto;">

            <!-- item-->
            <a href="../view-grade/index" class="link link-edu-btn" data-toggle="tooltip" title="ระบบสืบค้นผลการเรียน" data-original-title="view-grade">
                <i class="fa fa-bar-chart"></i>
                <span style="font-size: 12px;">สืบค้นผลการเรียน</span>
            </a>

            <!-- item-->
            <a href="../visit-online/index" class="link link-edu-btn" data-toggle="tooltip" title="ระบบนิเทศการสอน ติดตามการปฏิบัติงาน" data-original-title="visit-online">
                <i class="fa fa-calendar"></i>
                <span style="font-size: 12px;">นิเทศการสอน</span>
            </a>

            <!-- item-->
            <a href="../student-tracking/index" class="link link-edu-btn" data-toggle="tooltip" title="ระบบฐานข้อมูลนักศึกษา" data-original-title="students-tracking">
                <i class="fa fa-address-book"></i>
                <span style="font-size: 12px;">ฐานข้อมูลนักศึกษา</span>
            </a>

            <!-- item-->
            <!-- <a href="../main_menu" class="link link-edu-btn" data-toggle="tooltip" title="หน้าหลัก" data-original-title="หน้าหลัก">
                <i class="fa fa-list"></i>
                <span style="font-size: 12px;">หน้าเมนูหลัก</span>
            </a> -->

        </div>
    </section>
</aside>