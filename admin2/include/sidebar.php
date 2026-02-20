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
                    <p class="mb-0">ยินดีต้อนรับ</p>
                    <h6 class="mb-0"><?php echo $_SESSION['user_data']->name . ' ' . $_SESSION['user_data']->surname; ?></h6>
                </div>
            </div>
        </div>

        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">
            <?php if ($_SESSION['user_data']->role_id == 1) {
            ?>
                <?php
                $activeAm1 = '';
                $activeAm2 = '';
                $activeAm3 = '';
                $activeAm4 = '';
                $activeAm5 = '';
                $activeAm7 = '';

                if ($routeName == 'settings_am') {
                    $activeAm1 = 'active';
                } else if ($routeName == 'setting2') {
                    $activeAm2 = 'active';
                } else if ($routeName == 'setting3') {
                    $activeAm3 = 'active';
                } else if ($routeName == 'setting4') {
                    $activeAm4 = 'active';
                } else if ($routeName == 'setting5') {
                    $activeAm5 = 'active';
                } else if ($routeName == 'setting7') {
                    $activeAm7 = 'active';
                }
                ?>
                <li class="treeview menu-open">
                    <a href="#">
                        <i class="ti-settings"></i>ตั้งค่าเว็บระบบอำเภอ
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu" style="display: block;">
                        <li class="<?php echo  $activeAm1 ?>">
                            <a href="settings_am">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>ตั้งค่าแบนเนอร์เว็บ</span>
                            </a>
                        </li>
                        <li class="<?php echo  $activeAm2 ?>">
                            <a href="setting2">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>ตั้งค่าข่าวสารระดับอำเภอ</span>
                            </a>
                        </li>
                        <li class="<?php echo  $activeAm3 ?>">
                            <a href="setting3">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>ตั้งค่ารูปภาพกิจกรรม</span>
                            </a>
                        </li>
                        <li class="<?php echo  $activeAm4 ?>">
                            <a href="setting4">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>ตั้งค่าแบนเนอร์ข่าวสาร(แนวตั้ง)</span>
                            </a>
                        </li>
                        <li class="<?php echo  $activeAm7 ?>">
                            <a href="setting7">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>ตั้งค่าพื้นหลังเว็บ</span>
                            </a>
                        </li>
                        <li class="<?php echo $activeAm5 ?>">
                            <a href="setting5">
                                <i class="ti-settings" style="margin-right: 5px;"></i>
                                <span>ตั้งค่าชื่อเมนูหลัก</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo $routeName == "setting6" ? 'active' : '' ?>">
                    <a href="setting6">
                        <i class="ti-settings" aria-hidden="true" style="margin-right: 5px;"></i>
                        <span>ตั้งค่าบุคลากร</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </section>
</aside>