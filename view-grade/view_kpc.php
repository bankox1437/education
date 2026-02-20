<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_std.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูล กพช. สะสม ( KPCH )</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">
                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT SUM(hour) sum_hour FROM vg_kpc kpc\n" .
                    "LEFT JOIN tb_students std ON kpc.std_id = std.std_id\n" .
                    "LEFT JOIN vg_terms term ON kpc.term_id = term.term_id\n" .
                    "WHERE kpc.std_id = :std_id ";

                $arr_data = ['std_id' => $_SESSION['user_data']->edu_type];

                $term_name_active = $_SESSION['term_active']->term_name;

                $sqlWhere = "";

                if (isset($_GET['term_name']) && $_GET['term_name'] != $term_name_active) {
                    $term_name = $_GET['term_name'];
                    $arr_data["term_name"] = $term_name;
                    $sqlWhere = " AND CONCAT(term.term,'/',term.year) = :term_name";
                    $sql .= $sqlWhere;
                }

                $data = $DB->Query($sql, $arr_data);
                $std_kpc_data = json_decode($data);
                $sum_hour = 0;
                if (count($std_kpc_data) != 0) {
                    $sum_hour =  $std_kpc_data[0]->sum_hour;
                }
                ?>
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="row align-items-center">
                                        <h4 class="col-md-3  ml-2 mt-1text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='index_student'"></i>
                                            &nbsp;&nbsp;<i class="fa fa-file-text-o mr-15"></i>
                                            <b>ข้อมูล กพช. สะสม ( KPCH )</b>
                                        </h4>
                                        <form action="" method="GET" class="col-md-2 mt-3">
                                            <select class="form-control" name="term_name" id="term_name" onchange="this.form.submit()">
                                                <?php
                                                if (isset($_GET['term_name'])) {
                                                    foreach ($_SESSION['term_data'] as $term) {
                                                        $selected = "";
                                                        $currentTerm = "";
                                                        if ($_GET['term_name'] == $term->term_name) {
                                                            $selected = "selected";
                                                        }
                                                        if ($_SESSION['term_active']->term_name == $term->term_name) {
                                                            $currentTerm = "(ปัจจุบัน)";
                                                        }
                                                        echo "<option $selected value='" . $term->term_name . "'>" . $term->term_name . " " . $currentTerm . "</option>";
                                                    }
                                                } else {
                                                    foreach ($_SESSION['term_data'] as $term) {
                                                        $selected = "";
                                                        $currentTerm = "";
                                                        if ($_SESSION['term_active']->term_name == $term->term_name) {
                                                            $selected = "selected";
                                                            $currentTerm = "(ปัจจุบัน)";
                                                        }
                                                        echo "<option $selected value='" . $term->term_name . "'>" . $term->term_name . " " . $currentTerm . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </form>
                                    </div>
                                    <h2 class="text-center" style="margin-top: 50px;margin-bottom: 50px;"><b>คะแนน กพช. สะสมรวมทั้งหมด <span class="text-primary"><?php echo $sum_hour ?? 0 ?></span> ชั่วโมง</b></h2>
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