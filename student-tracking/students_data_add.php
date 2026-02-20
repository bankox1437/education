<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลนักศึกษาส่วนบุคคล</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content">
                    <div class="row">
                        <div class="col-12">

                            <div class="box">
                                <div class="box-body">
                                    <h4 class="box-title">ข้อมูลนักศึกษาส่วนบุคคล 2</h4>
                                    <hr class="my-15">
                                    <input type="hidden" name="std_select" id="std_select" value="<?php echo $std_data->std_id ?>">
                                    
                                    <form id="form-add-student-data">
                                        <?php
                                        include "include/from_1.1/side1.php";
                                        include "include/from_1.1/side2.php";
                                        include "include/from_1.1/side3.php";
                                        include "include/from_1.1/side4.php";
                                        include "include/from_1.1/side5.php";
                                        include "include/from_1.1/side6.php";
                                        include "include/from_1.1/side7.php";
                                        ?>

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

    <script type="text/javascript" src="js/view_js/form_1.1_add.js?v=<?php echo $version; ?>"></script>
    <script>
        $(document).ready(function() {
            $("#std_name").val('<?php echo $std_data->std_prename . $std_data->std_name ?>')
            $("#std_birthday").val('<?php echo $std_data->std_birthday ?>')
            $("#age_show").val(calculateAge('<?php echo $std_data->std_birthday ?>'))
            $("#age").val(calculateAge('<?php echo $std_data->std_birthday ?>'))
        });
    </script>
</body>

</html>