<style>
    @media (max-width: 767px) {
        .nav-tabs .nav-link {
            padding: 15px 20px;
        }

        .nav-tabs .nav-link i {
            font-size: 20px;
        }
    }
</style>
<div class="box">
    <div class="box-header with-border">
        <h4 class="box-title">ตั้งค่าชื่อเมนูหลัก</h4>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        <?php
        $pageActive = isset($_REQUEST['page']) ? $_REQUEST['page'] : 'std';
        ?>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs customtab2" role="tablist">
            <li class="nav-item"> <a class="nav-link <?php echo $pageActive == 'std' ? 'active' : ''; ?>" data-toggle="tab" style="cursor: pointer;" role="tab" onclick="location.href='?page=std'"><span class="hidden-sm-up">นักศึกษา</span> <span class="hidden-xs-down">นักศึกษา</span></a> </li>
            <li class="nav-item"> <a class="nav-link <?php echo $pageActive == 'kru' ? 'active' : ''; ?>" data-toggle="tab" style="cursor: pointer;" role="tab" onclick="location.href='?page=kru'"><span class="hidden-sm-up">ครู</span> <span class="hidden-xs-down">ครู</span></a> </li>
            <li class="nav-item"> <a class="nav-link <?php echo $pageActive == 'am' ? 'active' : ''; ?>" data-toggle="tab" style="cursor: pointer;" role="tab" onclick="location.href='?page=am'"><span class="hidden-sm-up">อำเภอ</span> <span class="hidden-xs-down">อำเภอ</span></a> </li>
            <li class="nav-item"> <a class="nav-link <?php echo $pageActive == 'pro' ? 'active' : ''; ?>" data-toggle="tab" style="cursor: pointer;" role="tab" onclick="location.href='?page=pro'"><span class="hidden-sm-up">จังหวัด</span> <span class="hidden-xs-down">จังหวัด</span></a> </li>
            <li class="nav-item"> <a class="nav-link <?php echo $pageActive == 'lib' ? 'active' : ''; ?>" data-toggle="tab" style="cursor: pointer;" role="tab" onclick="location.href='?page=lib'"><span class="hidden-sm-up">จังหวัด</span> <span class="hidden-xs-down">บรรณารักษ์</span></a> </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">

            <div class="tab-pane <?php echo $pageActive == 'std' ? 'active' : ''; ?>" id="std" role="tabpanel">
                <?php include("menu/std.php") ?>
            </div>

            <div class="tab-pane <?php echo $pageActive == 'kru' ? 'active' : ''; ?>" id="kru" role="tabpanel">
                <?php include("menu/kru.php") ?>
            </div>

            <div class="tab-pane <?php echo $pageActive == 'am' ? 'active' : ''; ?>" id="am" role="tabpanel">
                <?php include("menu/am.php") ?>
            </div>

            <div class="tab-pane <?php echo $pageActive == 'pro' ? 'active' : ''; ?>" id="pro" role="tabpanel">
                <?php include("menu/pro.php") ?>
            </div>

            <div class="tab-pane <?php echo $pageActive == 'lib' ? 'active' : ''; ?>" id="pro" role="tabpanel">
                <?php include("menu/lib.php") ?>
            </div>

        </div>
    </div>


</div>
<!-- /.box -->