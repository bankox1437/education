<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>บันทึกผู้จบการศึกษา</title>
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


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper0" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='graduate_reg'"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มบันทึกผู้จบการศึกษา</b></h6>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label><b>ค้นหาด้วยชั้น</b></label>
                                                <select class="form-control select2" name="std_class" id="std_class" data-placeholder="ชั้น" style="width: 100%;" onchange="getDataStd_new(this.value)">
                                                    <option value="">ชั้นทั้งหมด</option>
                                                    <option value="ประถม">ประถม</option>
                                                    <option value="ม.ต้น">ม.ต้น</option>
                                                    <option value="ม.ปลาย">ม.ปลาย</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><b>เลือกนักศึกษา</b></label>
                                                <select class="form-control select2" name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;" onchange="chooseStudent()">
                                                </select>
                                                <input type="hidden" id="std_id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>รหัสนักศึกษา <span class="text-danger">*</span></b></label>
                                                <input type="text" id="std_code" class="form-control" placeholder="กรอกรหัสนักศึกษา">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>ชื่อ-สกุล</b></label>
                                                <input type="text" id="std_name" class="form-control" placeholder="กรอกชื่อ-สกุล">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>เลขประจำตัวประชาชน <span class="text-danger">*</span></b></label>
                                                <input type="text" id="national_id" class="form-control" placeholder="กรอกเลขประจำตัวประชาชน">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>ปีการศึกษาที่จบ <span class="text-danger">*</span></b></label>
                                                <input type="text" id="gra_year" class="form-control" placeholder="กรอกปีการศึกษาที่จบ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <b>แนบไฟล์เพิ่มเติม <span class="text-danger">*</span></b> <span class="text-danger"> ( ต้องเป็นไฟล์ PDF เท่านั้น ) </span>
                                                </label>
                                                <input type="file" id="file" class="form-control" accept=".pdf">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>ระดับชั้นที่จบ </b><b class="text-danger">*</b></label>
                                                <div class="c-inputs-stacked mt-2">
                                                    <input name="std_class" type="radio" id="pratom" class="with-gap radio-col-primary required" placeholder="ระบุระดับชั้นที่จบ" value="1">
                                                    <label for="pratom" class="mr-30">ประถม</label>
                                                    <input name="std_class" type="radio" id="m_ton" class="with-gap radio-col-primary required" placeholder="ระบุระดับชั้นที่จบ" value="2">
                                                    <label for="m_ton" class="mr-30">ม.ต้น</label>
                                                    <input name="std_class" type="radio" id="m_pai" class="with-gap radio-col-primary required" placeholder="ระบุระดับชั้นที่จบ" value="3">
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
        $(document).ready(function() {
            $("#std_select").select2();
            getDataStd_new();
        });

        function getDataStd_new(std_class = "") {
            $.ajax({
                type: "POST",
                url: "controllers/student_controller",
                data: {
                    getDataStudent: true,
                    std_class: std_class
                },
                dataType: "json",
                success: function(json_res) {
                    const std_select = document.getElementById("std_select");
                    std_select.innerHTML = "";
                    std_select.innerHTML += `<option value="0">ไม่เลือกนักศึกษา</option>`;
                    data_std = json_res.data
                    data_std.forEach((element, i) => {
                        std_select.innerHTML += `<option value="${element.std_id}" data-std='${JSON.stringify(element)}'>${element.std_code} - ${element.std_prename}${element.std_name}</option>`;
                    });
                },
            });
        }

        function chooseStudent() {
            let std_data = $("#std_select option:selected").attr("data-std");
            if (std_data) {
                std_data = JSON.parse(std_data);
                $('#std_id').val(`${std_data.std_id}`);
                $('#std_code').val(`${std_data.std_code}`);
                // $('#std_code').attr("disabled", "true");

                $('#std_name').val(`${std_data.std_prename}${std_data.std_name}`);
                // $('#std_name').attr("disabled", "true");

                $('#national_id').val(`${std_data.national_id}`);
                // $('#national_id').attr("disabled", "true");

                if (std_data.std_class == "ประถม") {
                    $("#pratom").attr('checked', 'checked');
                }
                if (std_data.std_class == "ม.ต้น") {
                    $("#m_ton").attr('checked', 'checked');
                }
                if (std_data.std_class == "ม.ปลาย") {
                    $("#m_pai").attr('checked', 'checked');
                }
                // $('input[name=std_class]').attr("disabled", "true");
            } else {
                $('#std_code').val(``);
                $('#std_code').removeAttr("disabled");

                $('#std_name').val(``);
                $('#std_name').removeAttr("disabled");

                $('#national_id').val(``);
                $('#national_id').removeAttr("disabled");

                $("input[name=std_class]").removeAttr('checked');
                $('input[name=std_class]').removeAttr("disabled");

                $('#std_id').val(`0`);
            }
        }

        function submit() {
            const std_id = $('#std_id').val();
            const std_code = $('#std_code').val();
            const std_name = $('#std_name').val();
            const national_id = $('#national_id').val();
            const gra_year = $('#gra_year').val();

            const std_class = $("input[name=std_class]:checked").val();

            const file = document.getElementById('file').files[0];

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
            if (typeof file == 'undefined') {
                alert('โปรดแนบไฟล์เพิ่มเติม')
                $('#file').focus()
                return false;
            }
            if (!std_class) {
                alert('โปรดระบุชั้น')
                $('input[name=std_class]').focus()
                return false;
            }

            let formData = new FormData();
            formData.append('std_id', std_id);
            formData.append('std_code', std_code);
            formData.append('std_name', std_name);
            formData.append('national_id', national_id);
            formData.append('gra_year', gra_year);
            formData.append('file', file);
            formData.append('std_class', std_class);
            formData.append('insertGraReg', true);
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