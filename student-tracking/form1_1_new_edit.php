<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มแก้ไขข้อมูลนักศึกษารายบุคคล</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <?php include 'include/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content">
                    <div class="row">
                        <div class="col-12">

                            <?php include "../config/class_database.php";
                            $DB = new Class_Database();
                            $sql = "SELECT\n" .
                                "	sp.*,\n" .
                                "	CONCAT( std.std_code, '-', std.std_prename, std.std_name ) std_name, \n" .
                                "	CONCAT( std.std_prename, std.std_name ) name, \n" .
                                "   std.std_birthday, \n" .
                                "   std.std_father_name, \n" .
                                "   std.std_father_job, \n" .
                                "   std.std_mather_name, \n" .
                                "   std.std_mather_job, \n" .
                                "   std.std_father_phone, \n" .
                                "   std.std_mather_phone \n" .
                                "FROM\n" .
                                "	stf_tb_form_student_person_new sp\n" .
                                "	LEFT JOIN tb_students std ON sp.std_id = std.std_id \n" .
                                "WHERE\n" .
                                "	std_per_id = :std_per_id";
                            $data = $DB->Query($sql, ['std_per_id' => $_GET['std_per_id']]);
                            $std_per_data = json_decode($data);
                            if (count($std_per_data) == 0) {
                                echo "<script>location.href = 404</script>";
                            }
                            $std_per_data = $std_per_data[0];
                            $std_per_id = $_GET['std_per_id'];
                            ?>

                            <div class="box">
                                <div class="box-body">
                                    <h6 class="box-title text-info" style="margin: 0;">
                                        <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form1_1_new'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="ti-user mr-15"></i> <b>ฟอร์มแก้ไขข้อมูลนักศึกษารายบุคคล</b>
                                    </h6>
                                    <hr class="my-15">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เลือกนักศึกษา <b class="text-danger">*</b></label>
                                                <select class="form-control" style="width: 100%;" disabled>
                                                    <option><?php echo $std_per_data->std_name; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-2">
                                            <button onclick="addValue()" class="btn btn-primary mt-4">
                                                จำลองข้อมูล
                                            </button>
                                        </div> -->
                                    </div>
                                    <form id="form-edit-student-data">
                                        <?php
                                        include "include/from_1.1/side1.php";
                                        include "include/from_1.1/side2.php";
                                        include "include/from_1.1/side3.php";
                                        include "include/from_1.1/side4.php";
                                        include "include/from_1.1/side5.php";
                                        include "include/from_1.1/side6.php";
                                        include "include/from_1.1/side7.php";
                                        ?>
                                        <input type="hidden" name="std_per_id" value="<?php echo $_GET['std_per_id'] ?>">
                                        <input type="hidden" name="std_id" value="<?php echo $std_per_data->std_id ?>">
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                    </form>
                                </div>

                            </div>


                        </div>
                    </div>
            </div>
        </div>
        <?php include '../include/footer.php'; ?>
        </section>
        <!-- /.content -->
        <div class="preloader">
            <?php include "../include/loader_include.php"; ?>
        </div>

    </div>
    </div>
    <!-- /.content-wrapper -->


    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>

    <script type="text/javascript" src="js/view_js/form_1.1_edit.js?v=<?php echo $version; ?>"></script>
</body>

</html>