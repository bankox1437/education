<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มแก้ไขข้อมูลนักศึกษา</title>
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">
                <!-- Main content -->
                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT\n" .
                    "	std.*,\n" .
                    " CONCAT(u.NAME,' ',IFNULL(u.surname,'')) u_name,\n" .
                    "	u.username \n" .
                    "FROM\n" .
                    "	tb_students std\n" .
                    "	LEFT JOIN tb_users u ON std.std_id = u.edu_type \n" .
                    "WHERE\n" .
                    "	std.std_id = :std_id";
                $data = $DB->Query($sql, ['std_id' => $_GET['std_id']]);
                $std_data = json_decode($data);

                if (count($std_data) == 0) {
                    echo '<script>location.href = "../404"</script>';
                }

                $std_data = $std_data[0];
                ?>
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <?php
                                        $url = "../student_list";
                                        if (isset($_GET['url_redirect'])) {
                                            $url .= "?url=" . $_GET['url_redirect'];
                                        }

                                        ?>
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='<?php echo $url ?>'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                            <b>แก้ไขข้อมูลนักศึกษา</b>
                                        </h4>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <form id="form_edit_std" class="form">
                                        <input type="hidden" class="form-control" id="std_id" value="<?php echo $std_data->std_id ?>">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>รหัสนักศึกษา</label>
                                                            <input type="text" class="form-control" id="std_code" placeholder="รหัสนักศึกษา" value="<?php echo $std_data->std_code ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>ชื่อ-สกุลนักศึกษา</label>
                                                            <input type="text" class="form-control" id="std_name" placeholder="ชื่อ-สกุลนักศึกษา" value="<?php echo $std_data->u_name ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>วันเกิด</label>
                                                            <input type="text" class="form-control" id="birthday" placeholder="วันเกิด" value="<?php echo $std_data->std_birthday ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>เลขประจำตัวประชาชน</label>
                                                            <input type="text" class="form-control" id="national_id" placeholder="เลขประจำตัวประชาชน" value="<?php echo $std_data->national_id ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>รูปหน้าบัตรนักศึกษา</label>
                                                            <div class="custom-file">
                                                                <input type="hidden" class="form-control" id="front_image_old" value="<?php echo $std_data->std_profile_image ?>">
                                                                <input type="file" class="custom-file-input" id="front_image" name="front_image" accept="image/png, image/jpeg" onchange="setlabelFilename('front_image')">
                                                                <label class="custom-file-label" for="front_image" id="front_image_label">เลือกไฟล์รูปภาพเท่านั้น</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>รูปหลังบัตรนักศึกษา</label>
                                                            <div class="custom-file">
                                                                <input type="hidden" class="form-control" id="back_image_old" value="<?php echo $std_data->std_profile_image_back ?>">
                                                                <input type="file" class="custom-file-input" id="back_image" name="back_image" accept="image/png, image/jpeg" onchange="setlabelFilename('back_image')">
                                                                <label class="custom-file-label" for="back_image" id="back_image_label">เลือกไฟล์รูปภาพเท่านั้น</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>ภาคเรียนที่เข้าเรียน</label>
                                                            <input type="text" class="form-control" id="std_term" placeholder="ภาคเรียนที่เข้าเรียน เช่น 1" value="<?php echo $std_data->std_term ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>ปีการศึกษาที่เข้าเรียน</label>
                                                            <input type="text" class="form-control" id="std_year" placeholder="ปีการศึกษาที่เข้าเรียน เช่น <?php echo date('Y') + 543 ?>" value="<?php echo $std_data->std_year ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                                <i class="ti-save-alt"></i> บันทึกข้อมูล
                                            </button>
                                        </div>
                                    </form>
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
    <script>
        function setlabelFilename(id) {
            const file = document.getElementById(id).files;
            let fileName = '';
            for (let i = 0; i < file.length; i++) {
                if (i == 0) {
                    fileName += file[i].name;
                } else {
                    fileName += " , " + file[i].name;
                }
            }
            document.getElementById(id + '_label').innerText = fileName;
        }

        $('#form_edit_std').submit((e) => {
            e.preventDefault();
            const std_id = $('#std_id').val();
            const std_code = $('#std_code').val();
            const std_name = $('#std_name').val();
            const birthday = $('#birthday').val();
            const national_id = $('#national_id').val();
            const std_term = $('#std_term').val();
            const std_year = $('#std_year').val();

            if (!std_code) {
                alert('โปรดกรอกข้อมูลรหัสนักศึกษา')
                $('#std_code').focus()
                return false;
            }
            if (!std_name) {
                alert('โปรดกรอกข้อมูลชื่อ-สกุลนักศึกษา')
                $('#std_name').focus()
                return false;
            }
            if (!birthday) {
                alert('โปรดกรอกข้อมูลวันเกิด')
                $('#birthday').focus()
                return false;
            }
            if (!national_id) {
                alert('โปรดกรอกข้อมูลเลขประจำตัวประชาชน')
                $('#national_id').focus()
                return false;
            }

            if (!std_term) {
                alert('โปรดกรอกข้อมูลภาคเรียนที่เข้าเรียน')
                $('#std_term').focus()
                return false;
            }

            if (!std_year) {
                alert('โปรดกรอกข้อมูลปีการศึกษาที่เข้าเรียน')
                $('#std_year').focus()
                return false;
            }

            let formData = new FormData();
            formData.append('std_id', std_id);
            formData.append('std_code', std_code);
            formData.append('std_name', std_name);
            formData.append('birthday', birthday);
            formData.append('national_id', national_id);
            formData.append('std_term', std_term);
            formData.append('std_year', std_year);
            formData.append('editStudent', true);

            let front_image = document.getElementById('front_image').files[0];
            formData.append('front_image', front_image);
            formData.append('front_image_old', $('#front_image_old').val());
            let back_image = document.getElementById('back_image').files[0];
            formData.append('back_image', back_image);
            formData.append('back_image_old', $('#back_image_old').val());

            $.ajax({
                type: "POST",
                url: "controllers/std_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = '<?php echo $url ?>';
                    } else {
                        alert(json.msg);
                    }
                },
            });
        })
    </script>
</body>

</html>