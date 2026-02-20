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
                    <h6 class="mb-0"><b>ระบบฐานข้อมูลนักศึกษา</b></h6>
                    <p class="mb-0">ยินดีต้อนรับ <span style="font-size:10px">(<?php echo $_SESSION['user_data']->role_name ?>)</span></p>
                    <h6 class="mb-0"><?php echo $_SESSION['user_data']->name . ' ' . $_SESSION['user_data']->surname; ?></h6>
                </div>
            </div>
        </div>

        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree" style="margin-bottom:20px;">
            <li>
                <a href="dashboard">
                    <i class="ti-home" style="margin-right: 5px;"></i>
                    <span>หน้าหลัก</span>
                </a>
            </li>
            <!-- <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                <li>
                    <a href="student_list">
                        <i class="ti-user" style="margin-right: 5px;"></i>
                        <span>ข้อมูลนักศึกษา</span>
                    </a>
                </li>
            <?php } ?> -->
            <li class="header no-padding mt-2">
                <h5 class="m-0">แบบฟอร์มต่าง ๆ</h5>
            </li>
            <li class="<?php echo $routeName == "form1_1_new_add" || $routeName == "form1_1_new_edit" || $routeName == "learn_analysis" ? 'active' : '' ?>">
                <a href="form1_1_new">
                    <i class="ti-write" style="margin-right: 5px;"></i>
                    <span>ข้อมูลนักศึกษารายบุคคล</span>
                </a>
            </li>
            <li class="<?php echo $routeName == "form1_2_add" || $routeName == 'form1_2_edit' || $routeName == 'form1_3_new_edit'  ? 'active' : '' ?>">
                <a href="form1_2">
                    <i class="ti-clipboard" style="margin-right: 5px;"></i>
                    <span>การเยี่ยมบ้าน</span>
                </a>
            </li>
            <li class="<?php echo $routeName == "form1_3_add" ? 'active' : '' ?>">
                <a href="form1_3">
                    <i class="ti-agenda" style="margin-right: 5px;"></i>
                    <span>สรุปการเยี่ยมบ้าน</span>
                </a>
            </li>
            <!-- <li class="<?php echo $routeName == "form_after_gradiate_add" || $routeName == "form_after_gradiate_edit" ? 'active' : '' ?>">
                <a href="form_after_gradiate">
                    <i class="ti-bookmark-alt" style="margin-right: 5px;"></i>
                    <span>แบบติดตามหลังจบการศึกษา</span>
                </a>
            </li> -->
            <!-- <li class="<?php echo $routeName == "form1_3_1_add" || $routeName == "form1_3_1_edit"  ? 'active' : '' ?>">
                <a href="form1_3_1">
                    <i class="ti-files" style="margin-right: 5px;"></i>
                    <span>ประเมินนักศึกษา</span>
                </a>
            </li> -->
            <!-- <li class="<?php echo $routeName == "form2_5_add" || $routeName == "form2_5_edit" ? 'active' : '' ?>">
                <a href="form2_5">
                    <i class="ti-pencil-alt" style="margin-right: 5px;"></i>
                    <span>คัดกรองนักศึกษารายบุคคล</span>
                </a>
            </li> -->
            <?php
            if ($_SESSION['user_data']->role_id == 2) {
                $statusRole = json_decode($_SESSION['user_data']->status, true);

                $searchText = "";
                $searchBlock = 'cursor: pointer;';
                if ((isset($statusRole['search']) && !$statusRole['search']) || !isset($statusRole['search'])) {
                    $searchText = "(ไม่มีสิทธิ์)";
                    $searchBlock = "cursor: no-drop;";
                }

                $see_peopleText = "";
                $see_peopleBlock = 'cursor: pointer;';
                if ((isset($statusRole['see_people']) && !$statusRole['see_people']) || !isset($statusRole['see_people'])) {
                    $see_peopleText = "(ไม่มีสิทธิ์)";
                    $see_peopleBlock = "cursor: no-drop;";
                } ?>

                <!-- <li class="<?php echo $routeName == "graduate_reg_add" || $routeName == "graduate_reg_edit" ? 'active' : '' ?>">
                    <a href="<?php echo (isset($statusRole['search']) && $statusRole['search']) ? "graduate_reg" : "#" ?>" style="<?php echo $searchBlock ?>">
                        <i class="ti-harddrive" style="margin-right: 5px;"></i>
                        <span>ทะเบียนผู้จบการศึกษา <?php echo $searchText; ?></span>
                    </a>
                </li>
                <li class="<?php echo $routeName == "family_data_add" || $routeName == "family_data_edit" ? 'active' : '' ?>">
                    <a href="<?php echo (isset($statusRole['see_people']) && $statusRole['see_people']) ? "family_data" : "#" ?>" style="<?php echo $see_peopleBlock ?>">
                        <i class="ti-harddrive" style="margin-right: 5px;"></i>
                        <span>ข้อมูลประชากรด้านการศึกษา <?php echo $see_peopleText; ?></span>
                    </a>
                </li> -->
            <?php } else { ?>
                <!-- <li class="<?php echo $routeName == "graduate_reg_add" || $routeName == "graduate_reg_edit" ? 'active' : '' ?>">
                    <a href="graduate_reg">
                        <i class="ti-harddrive" style="margin-right: 5px;"></i>
                        <span>ทะเบียนผู้จบการศึกษา</span>
                    </a>
                </li> -->
                <!-- <li class="<?php echo $routeName == "family_data_add" || $routeName == "family_data_edit" ? 'active' : '' ?>">
                    <a href="family_data">
                        <i class="ti-harddrive" style="margin-right: 5px;"></i>
                        <span>ข้อมูลประชากรด้านการศึกษา</span>
                    </a>
                
                </li> -->
                <?php } ?>
                <!-- <li class="<?php echo $routeName == "manage_estimate" || $routeName == "manage_estimate_add" || $routeName == "manage_estimate_edit" ? 'active' : '' ?>">
                    <a href="manage_estimate_index">
                        <i class="ti-envelope" style="margin-right: 5px;"></i>
                        <span>ประเมินคุณธรรมนักศึกษา</span>
                    </a>
                </li> -->
        </ul>

        <div class=" sidebar-footer" style="position: absolute;bottom: auto;">
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
            <!-- item-->
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