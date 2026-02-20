<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>เพิ่มข้อมูลคะแนนสอบ</title>
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
                $sql = "SELECT std.std_id,std.std_code,std.std_prename,std.std_name,edu.district_id FROM tb_students std \n" .
                    "LEFT JOIN tb_users users ON std.user_create = users.id\n" .
                    "LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id\n" .
                    "WHERE std.user_create = :user_create";
                $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id]);
                $std_data = json_decode($data);
                ?>
                <input type="hidden" name="term_id" id="term_id" value="<?php echo $_SESSION['term_active']->term_id ?>">
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_test_grade'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                            <b>ฟอร์มเพิ่มข้อมูลคะแนนสอบ ปีการศึกษา <?php echo  $_SESSION['term_active']->term_name; ?></b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form_add_test_grade" enctype="multipart/form-data">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <?php if ($_SESSION['user_data']->role_id == 2) {
                                            //include("include/form-add-teacher.php");
                                        } ?>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>รูปแบบการบันทึก <b class="text-danger">*</b></label>
                                                <select class="form-control" style="width: 100%;" id="format" onchange="changeFormat(this.value)">
                                                    <option value="0">รายบุคคล</option>
                                                    <option value="1">ระดับชั้น</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-3" id="std_section" style="display: block;">
                                                <label>นักศึกษา <b class="text-danger">*</b></label>
                                                <select class="form-control" id="std_id" style="width: 100%;">
                                                    <option value="">เลือกนักศึกษา</option>
                                                    <?php foreach ($std_data as $obj_std) {
                                                        echo "<option value='" . $obj_std->std_id . "'>" . $obj_std->std_code . "-" . $obj_std->std_prename . $obj_std->std_name . "</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3" id="class_section" style="display: none;">
                                                <label>เลือกระดับชั้น <b class="text-danger">*</b></label>
                                                <select class="form-control" name="std_class" id="std_class" data-placeholder="เลือกระดับชั้น" style="width: 100%;" onchange="getDataStdToTable(this.value)">
                                                    <option value="ประถม">ประถม</option>
                                                    <option value="ม.ต้น">ม.ต้น</option>
                                                    <option value="ม.ปลาย">ม.ปลาย</option>
                                                </select>
                                            </div>
                                            <!-- <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ภาคเรียน <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="term" id="term" autocomplete="off" placeholder="กรอกภาคเรียน">
                                                    <input type="hidden" name="insertCalendar">
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>ภาคเรียน/ปีการศึกษา <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="year" id="year" autocomplete="off" placeholder="กรอกภาคเรียน/ปีการศึกษา">
                                                </div>
                                            </div> -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ไฟล์คะแนนสอบ <b class="text-danger">*</b></label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="test_grade_file" name="test_grade_file" accept="application/pdf" onchange="setlabelFilename('test_grade_file')">
                                                        <label class="custom-file-label" for="test_grade_file" id="test_grade_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>ประเภทการสอบ</label>
                                                <select class="form-control" id="test_type" style="width: 100%;">
                                                    <option value="0">การสอบปกติ</option>
                                                    <option value="1">การสอบซ่อม</option>
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
                    <?php include ".//include/loader_include.php"; ?>
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
            const term_id = $('#term_id').val();
            const test_type = $('#test_type').val();
            const test_grade_file = document.getElementById('test_grade_file').files[0];

            let formData = new FormData();
            if (!parseInt($('#format').val())) {
                const std_id = $('#std_id').val();
                if (!std_id) {
                    alert('โปรดเลือกนักศึกษา')
                    $('#std_id').focus()
                    return false;
                }
                formData.append('std_id', std_id);
            } else {
                const std_class = $('#std_class').val();
                formData.append('std_class', std_class);
            }
            if (typeof test_grade_file == 'undefined') {
                alert('โปรดเลือกไฟล์คะแนนสอบ')
                $('#test_grade_file').focus()
                return false;
            }
            formData.append('term_id', term_id);
            formData.append('test_grade_file', test_grade_file);
            formData.append('test_type', test_type);
            formData.append('insertTestGrade', true);

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
                    }
                },
            });
        })

        function changeFormat(format) {
            if (parseInt(format)) {
                $('#class_section').show()
                $('#std_section').hide()
            } else {
                $('#class_section').hide()
                $('#std_section').show()
            }
        }
    </script>
</body>

</html>