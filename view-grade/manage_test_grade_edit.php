<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แก้ไขข้อมูลคะแนนสอบ</title>
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
                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT\n" .
                    "	tg.*,CONCAT( std.std_code, \"-\", std.std_prename, std.std_name ) std_name \n" .
                    "FROM\n" .
                    "	vg_test_grade tg\n" .
                    "	LEFT JOIN tb_students std ON tg.std_id = std.std_id \n" .
                    "WHERE\n" .
                    "	tg.grade_id = :grade_id";
                $data = $DB->Query($sql, ['grade_id' => $_GET['grade_id']]);
                $grade_data = json_decode($data);
                if (count($grade_data) == 0) {
                    echo "<script>location.href = 404</script>";
                }
                $grade_data = $grade_data[0];
                ?>
                <input type="hidden" name="grade_id" id="grade_id" value="<?php echo $grade_data->grade_id; ?>">
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_test_grade'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                            <b>ฟอร์มแก้ไขข้อมูลคะแนนสอบ ปีการศึกษา <?php echo  $_SESSION['term_active']->term_name; ?></b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form_add_test_grade" enctype="multipart/form-data">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <?php if ($grade_data->format) { ?>
                                                    <label>ระดับชั้น</label>
                                                    <select disabled class="form-control" id="std_id" style="width: 100%;">
                                                        <option><?php echo $grade_data->std_id; ?></option>
                                                    </select>
                                                <?php } else { ?>
                                                    <label>นักศึกษา</label>
                                                    <select disabled class="form-control" id="std_id" style="width: 100%;">
                                                        <option><?php echo $grade_data->std_name; ?></option>
                                                    </select>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ไฟล์คะแนนสอบ</label>
                                                    <div class="custom-file">
                                                        <input type="hidden" name="test_grade_file_old" id="test_grade_file_old" value="<?php echo  $grade_data->file_name; ?>">
                                                        <input type="file" class="custom-file-input" id="test_grade_file" name="test_grade_file" accept="application/pdf" onchange="setlabelFilename('test_grade_file')">
                                                        <label class="custom-file-label" for="test_grade_file" id="test_grade_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>ประเภทการสอบ</label>
                                                <select class="form-control" id="test_type" style="width: 100%;">
                                                    <option value="0" <?php echo $grade_data->test_type == 0 ? 'selected' : "" ?>>การสอบปกติ</option>
                                                    <option value="1" <?php echo $grade_data->test_type == 1 ? 'selected' : "" ?>>การสอบซ่อม</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
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
        $('#form_add_test_grade').submit((e) => {
            e.preventDefault();
            const grade_id = $("#grade_id").val();
            const test_grade_file_old = $('#test_grade_file_old').val();
            const test_type = $('#test_type').val()
            const test_grade_file = document.getElementById('test_grade_file').files[0];

            let formData = new FormData();
            formData.append('grade_id', grade_id);
            formData.append('test_grade_file', test_grade_file);
            formData.append('test_grade_file_old', test_grade_file_old);
            formData.append('test_type', test_type);
            formData.append('UpdateTestGrade', true);

            $.ajax({
                type: "POST",
                url: "controllers/test_grade_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_test_grade';
                    } else {
                        alert(json.msg);
                        window.location.reload();
                    }
                },
            });
        })
    </script>
</body>

</html>