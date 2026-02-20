<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_std.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ดูผลการสอบ N-NET ( N-NET Result )</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">
                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT status_text,status FROM `vg_n_net`\n" .
                    "WHERE std_id = :std_id AND term_id = :term_id";
                $data = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type, 'term_id' => $_SESSION['term_active']->term_id]);
                $n_net_data = json_decode($data);
                $status = true;
                if (count($n_net_data) == 0) {
                    $status = false;
                }
                
                ?>
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body">
                                    <h4 class="ml-2 mt-1text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='index_student'"></i>
                                        &nbsp;&nbsp;<i class="fa fa-file-text mr-15"></i>
                                        <b>ดูผลการสอบ N-NET ( N-NET Result )</b>
                                    </h4>
                                    <h2 class="text-center" style="margin-top: 50px;margin-bottom: 50px;">
                                        <b>สถานะการสอบ N-NET ของคุณคือ
                                            <span class="<?php echo $status ? 'text-success' : 'text-danger' ?>"><?php echo $status ? 'ผ่าน' : 'ไม่ผ่าน' ?></span>
                                        </b>
                                    </h2>
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
    <script src="js/init-table/view_kpc.js"></script>

    <script>
        $(document).ready(function() {
            initTable()
        });
    </script>
</body>

</html>