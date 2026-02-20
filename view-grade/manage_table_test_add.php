<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มบันทึกตารางสอบ</title>
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
                <input type="hidden" name="term_id" id="term_id" value="<?php echo $_SESSION['term_active']->term_id ?>">
                <!-- Main content -->
                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT std.std_id,std.std_code,std.std_class,std.std_prename,std.std_name,edu.district_id FROM tb_students std \n" .
                    "LEFT JOIN tb_users users ON std.user_create = users.id\n" .
                    "LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id\n" .
                    "WHERE std.user_create = :user_create AND std.std_status = 'กำลังศึกษา'";
                $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id]);
                $std_data = json_decode($data);
                ?>
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_table_test'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                            <b>ฟอร์มบันทึกตารางสอบ ปีการศึกษา <?php echo  $_SESSION['term_active']->term_name; ?></b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form_add_table_test" enctype="multipart/form-data">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>นักศึกษา <b class="text-danger">*</b></label>
                                                <select class="form-control" id="std_id" style="width: 100%;">
                                                    <option value="">เลือกนักศึกษา</option>
                                                    <?php foreach ($std_data as $obj_std) {
                                                        echo "<option value='" . $obj_std->std_id . "' data-class='" . $obj_std->std_class . "'>" . $obj_std->std_code . "-" . $obj_std->std_prename . $obj_std->std_name . "</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                            <!-- <div class="col-md-2">
                                                <label>ระดับชั้น <b class="text-danger">*</b></label>
                                                <select class="form-control" id="std_class" style="width: 100%;">
                                                    <option value="">เลือกระดับชั้น</option>
                                                    <option value="ประถม">ประถม</option>
                                                    <option value="ม.ต้น">ม.ต้น</option>
                                                    <option value="ม.ปลาย">ม.ปลาย</option>
                                                </select>
                                            </div> -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ไฟล์ตารางสอบ <b class="text-danger">*</b></label>
                                                    <div class="custom-file">
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
        $(document).ready(() => {
            $('#std_id').select2()
        })

        function setlabelFilename(id) {
            const file = document.getElementById(id).files[0];
            document.getElementById(id + '_label').innerText = file.name;
        }
        $('#form_add_table_test').submit((e) => {
            e.preventDefault();
            const term_id = $('#term_id').val();
            const std_id = $('#std_id').val();
            const std_class = $("#std_id").select2().find(":selected").data("class");
            const table_test_file = document.getElementById('table_test_file').files[0];
            if (!std_id) {
                alert('โปรดเลือกระดับชั้น')
                $('#std_id').focus()
                return false;
            }
            if (typeof table_test_file == 'undefined') {
                alert('โปรดเลือกไฟล์ตารางสอบ')
                $('#table_test_file').focus()
                return false;
            }
            let formData = new FormData();
            formData.append('std_id', std_id);
            formData.append('term_id', term_id);
            formData.append('std_class', std_class);
            formData.append('table_test_file', table_test_file);
            formData.append('insertTableTest', true);

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