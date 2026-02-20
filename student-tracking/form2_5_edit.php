<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แบบบันทึกคัดกรองนักศึกษารายบุคคล แบบ ด.ล. 2.5</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php include 'include/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <form id="form_edit_screening_std">
                                <div class="box">
                                    <div class="box-body">
                                        <h6 class="box-title text-info" style="margin: 0;">
                                            <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form2_5'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                            <b>ฟอร์มแก้ไขแบบบันทึกคัดกรองนักศึกษารายบุคคล</b>&nbsp;&nbsp;<span class="text-dark"><?php echo $_GET['std_name']; ?></span>
                                        </h6>
                                        <?php include('include/form_2.5_edit/side_1.php'); ?>
                                        <hr class="my-15">
                                        <?php include('include/form_2.5_edit/side_2.php'); ?>
                                        <hr class="my-15">
                                        <?php include('include/form_2.5_edit/side_3.php'); ?>
                                        <hr class="my-15">
                                        <?php include('include/form_2.5_edit/side_4.php'); ?>
                                        <hr class="my-15">
                                        <?php include('include/form_2.5_edit/side_5.php'); ?>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer" id="footer_btn">
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline" id="btn-submit">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                    </div>
                                    <!-- /.box-footer-->
                                </div>
                            </form>
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
    <script src="js/form_screening.js"></script>
    <!-- <script src="assets/js/view_js/form_2.5_add.js"></script> -->
    <script>
        $("#form_edit_screening_std").submit((e) => {
            e.preventDefault();
            var query = window.location.search.substring(1);
            var params = parse_query_string(query);
            const ObjJson = {
                edit_screening: true,
                screening_id: params.screening_id,
                side_1: JSON.stringify(getValueSide1()),
                side_2: JSON.stringify(getValueSide2()),
                side_3: JSON.stringify(getValueSide3()),
                side_4: JSON.stringify(getValueSide4()),
                side_5: JSON.stringify(getValueSide5()),
            };
            $.ajax({
                type: "POST",
                url: "controllers/form_screening_controller",
                data: ObjJson,
                dataType: "json",
                success: async function(json_res) {
                    if (json_res.status) {
                        alert(json_res.msg);
                        window.location.href = "form2_5";
                    } else {
                        alert(json_res.msg);
                        window.location.reload();
                    }
                },
            });
        });
    </script>
</body>

</html>