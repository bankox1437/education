<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แก้ไขผู้จบการศึกษา</title>
    <style>
        #preview {
            width: 30%;
        }

        @media only screen and (max-width: 600px) {
            #preview {
                width: 100%;
            }
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php // include 'include/sidebar.php'; 
        ?>

        <?php include "../config/class_database.php";
        $DB = new Class_Database();
        $sql = "SELECT\n" .
            "	* \n" .
            "FROM\n" .
            "	stf_tb_gradiate_reg gra\n" .
            "WHERE\n" .
            "	gra.gra_reg_id = :gra_reg_id";
        $data = $DB->Query($sql, ['gra_reg_id' => $_GET['gra_reg_id']]);
        $gra_reg_data = json_decode($data);
        if (count($gra_reg_data) == 0) {
            echo "<script>location.href = 404</script>";
        }
        $gra_reg_data = $gra_reg_data[0];
        ?>

        <input type="hidden" id="gra_reg_id" value="<?php echo $gra_reg_data->gra_reg_id ?>">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='graduate_reg'"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มแก้ไขผู้จบการศึกษา</b></h6>
                                </div>
                                <div class="box-body">
                                    <!-- <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><b>เลือกนักศึกษา</b></label>
                                                <select class="form-control select2" name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;" onchange="chooseStudent()">
                                                </select>
                                                <input type="hidden" id="std_id">
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>รหัสนักศึกษา <span class="text-danger">*</span></b></label>
                                                <input type="text" id="std_code" class="form-control" placeholder="กรอกรหัสนักศึกษา" value="<?php echo $gra_reg_data->std_code ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>ชื่อ-สกุล</b></label>
                                                <input type="text" id="std_name" class="form-control" placeholder="กรอกชื่อ-สกุล" value="<?php echo $gra_reg_data->std_name ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>เลขประจำตัวประชาชน <span class="text-danger">*</span></b></label>
                                                <input type="text" id="national_id" class="form-control" placeholder="กรอกเลขประจำตัวประชาชน" value="<?php echo $gra_reg_data->national_id ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>ปีการศึกษาที่จบ <span class="text-danger">*</span></b></label>
                                                <input type="text" id="gra_year" class="form-control" placeholder="กรอกปีการศึกษาที่จบ" value="<?php echo $gra_reg_data->years ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <b>แนบไฟล์เพิ่มเติม </b> <span class="text-danger"> ( ต้องเป็นไฟล์ PDF เท่านั้น ) </span>
                                                </label>
                                                <input type="file" id="file" class="form-control" accept=".pdf">
                                                <input type="hidden" name="file_old" id="file_old" value="<?php echo  $gra_reg_data->file_name; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>ระดับชั้นที่จบ </b><b class="text-danger">*</b></label>
                                                <div class="c-inputs-stacked mt-2">
                                                    <input name="std_class" type="radio" id="pratom" <?php echo $gra_reg_data->class == "1" ? "checked" : "" ?> class="with-gap radio-col-primary" value="1">
                                                    <label for="pratom" class="mr-30">ประถม</label>
                                                    <input name="std_class" type="radio" id="m_ton" <?php echo $gra_reg_data->class == "2" ? "checked" : "" ?> class="with-gap radio-col-primary" value="2">
                                                    <label for="m_ton" class="mr-30">ม.ต้น</label>
                                                    <input name="std_class" type="radio" id="m_pai" <?php echo $gra_reg_data->class == "3" ? "checked" : "" ?> class="with-gap radio-col-primary" value="3">
                                                    <label for="m_pai" class="mr-30">ม.ปลาย</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer" id="footer_btn">
                                    <button type="button" class="btn btn-rounded btn-primary btn-outline" onclick="submit()">
                                        <i class="ti-save-alt"></i> บันทึกข้อมูล
                                    </button>
                                </div>
                                <!-- /.box -->
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
        function submit() {
            const gra_reg_id = $('#gra_reg_id').val();
            const std_code = $('#std_code').val();
            const std_name = $('#std_name').val();
            const national_id = $('#national_id').val();
            const gra_year = $('#gra_year').val();

            const std_class = $("input[name=std_class]:checked").val();

            const file = document.getElementById('file').files[0];
            const file_old = $('#file_old').val();

            if (!std_code) {
                alert('โปรดกรอกรหัสนักศึกษา')
                $('#std_code').focus()
                return false;
            }
            if (!std_name) {
                alert('โปรดกรอกชื่อ-สกุล')
                $('#std_name').focus()
                return false;
            }
            if (!national_id) {
                alert('โปรดกรอกเลขประจำตัวประชาชน')
                $('#national_id').focus()
                return false;
            }
            if (!gra_year) {
                alert('โปรดกรอกปีการศึกษาที่จบ')
                $('#gra_year').focus()
                return false;
            }
            if (!std_class) {
                alert('โปรดระบุชั้น')
                $('input[name=std_class]').focus()
                return false;
            }

            let formData = new FormData();
            formData.append('gra_reg_id', gra_reg_id);
            formData.append('std_code', std_code);
            formData.append('std_name', std_name);
            formData.append('national_id', national_id);
            formData.append('gra_year', gra_year);
            formData.append('file', file);
            formData.append('file_old', file_old);
            formData.append('std_class', std_class);
            formData.append('editGraReg', true);
            $.ajax({
                type: "POST",
                url: "controllers/gradiate_reg_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'graduate_reg';
                    } else {
                        alert(json.msg);
                    }
                },
            });
        }
    </script>
</body>

</html>