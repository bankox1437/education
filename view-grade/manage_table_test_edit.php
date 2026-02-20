<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มแก้ไขตารางสอบ</title>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
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
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_table_test'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                            <b>ฟอร์มแก้ไขตารางสอบ ปีการศึกษา <?php echo  $_SESSION['term_active']->term_name; ?></b>
                                        </h4>
                                    </div>
                                </div>
                                <?php include "../config/class_database.php";
                                $DB = new Class_Database();
                                $sql = "SELECT * FROM vg_table_test \n".
                                    " LEFT JOIN tb_students std ON std.std_id = vg_table_test.std_id\n".
                                    " WHERE t_test_id = :t_test_id";
                                $data = $DB->Query($sql, ['t_test_id' => $_GET['t_test_id']]);
                                $table_test_data = json_decode($data);
                                if (count($table_test_data) == 0) {
                                    echo "<script>location.href = 404</script>";
                                }
                                $table_test_data = $table_test_data[0];
                                ?>
                                <input type="hidden" name="t_test_id" id="t_test_id" value="<?php echo $table_test_data->t_test_id ?>">
                                <form class="form" id="form_edit_table_test" enctype="multipart/form-data">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>ระดับชั้น <b class="text-danger">*</b></label>
                                                <select class="form-control" id="std_id" style="width: 100%;" disabled>
                                                    <option value=""><?php echo $table_test_data->std_code."-".$table_test_data->std_prename." ".$table_test_data->std_name ?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ไฟล์ตารางสอบ</label>
                                                    <div class="custom-file">
                                                        <input type="hidden" name="table_test_file_old" id="table_test_file_old" value="<?php echo $table_test_data->file_name ?>">
                                                        <input type="file" class="custom-file-input" id="table_test_file" name="table_test_file" accept="application/pdf" onchange="setlabelFilename('table_test_file')">
                                                        <label class="custom-file-label" for="table_test_file" id="table_test_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-rounded btn-primary btn-outline mt-4">
                                                    <i class="ti-save-alt"></i> บันทึกข้อมูล
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    <script>
        function setlabelFilename(id) {
            const file = document.getElementById(id).files[0];
            document.getElementById(id + '_label').innerText = file.name;
        }
        $('#form_edit_table_test').submit((e) => {
            e.preventDefault();
            const t_test_id = $('#t_test_id').val();
            const table_test_file_old = $('#table_test_file_old').val();
            const table_test_file = document.getElementById('table_test_file').files[0];
            
            let formData = new FormData();
            formData.append('t_test_id', t_test_id);
            formData.append('table_test_file_old', table_test_file_old);
            formData.append('table_test_file', table_test_file);
            formData.append('updateTableTest', true);

            $.ajax({
                type: "POST",
                url: "controllers/table_test_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_table_test';
                    } else {
                        alert(json.msg);
                    }
                },
            });
        })
    </script>
</body>

</html>