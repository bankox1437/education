<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มบันทึกข้อมูลนักศึกษารายบุคคล</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <?php
        if ($_SESSION['user_data']->role_id != 4) {
            // include 'include/sidebar.php';
        }
        ?>

        <div class="content-wrapper" <?php echo $_SESSION['user_data']->role_id != 4 ? 'style="margin: 0"' : 'style="margin: 0"' ?>>
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content">
                    <div class="row">
                        <div class="col-12">

                            <div class="box">
                                <div class="box-body">
                                    <?php
                                    if ($_SESSION['user_data']->role_id != 4) { ?>
                                        <h6 class="box-title text-info" style="margin: 0;">
                                            <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form_after_gradiate'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="ti-user mr-15"></i> <b>ฟอร์มบันทึกข้อมูลแบบติดตามหลังจบการศึกษา</b>
                                        </h6>
                                    <?php } else { ?>
                                        <h6 class="box-title text-info" style="margin: 0;">
                                            <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='after_gradiate'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="ti-user mr-15"></i> <b>ฟอร์มบันทึกข้อมูลแบบติดตามหลังจบการศึกษา</b>
                                        </h6>
                                    <?php } ?>
                                    <hr class="my-15">
                                    <form id="form-add-after-gradiate">
                                        <div class="row">
                                            <?php if ($_SESSION['user_data']->role_id != 4) { ?>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><b>เลือกนักศึกษา</b> <b class="text-danger">*</b></label>
                                                        <select class="form-control select2" name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;" onchange="getDataStdbtStdId(this.value)">
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><b>ปีการศึกษาที่จบ</b> <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input required" name="end_year" id="end_year" autocomplete="off" placeholder="กรุณากรอกปีการศึกษาที่จบ">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label><b>ระดับชั้นที่จบ </b><b class="text-danger">*</b></label>
                                                    <div class="c-inputs-stacked">
                                                        <input name="end_class" type="radio" id="pratom" class="with-gap radio-col-primary required" placeholder="ระบุระดับชั้นที่จบ" value="1">
                                                        <label for="pratom" class="mr-30">ประถม</label>
                                                        <input name="end_class" type="radio" id="m_ton" class="with-gap radio-col-primary required" placeholder="ระบุระดับชั้นที่จบ" value="2">
                                                        <label for="m_ton" class="mr-30">ม.ต้น</label>
                                                        <input name="end_class" type="radio" id="m_pai" class="with-gap radio-col-primary required" placeholder="ระบุระดับชั้นที่จบ" value="3">
                                                        <label for="m_pai" class="mr-30">ม.ปลาย</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        include "include/form_after_gradiate/side.php";
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
    <script>
        $(document).ready(function() {
            $("#std_select").select2();
            getDataStd_new();
        });

        $('input[name="edu_qualification"]').change(function() {
            // Get the value of the selected radio button
            var selectedValue = $(this).val();
            $('#edu_qualification_school').hide();
            if (selectedValue == 1) {
                $('#edu_qualification_school').show();
            }

        });

        let data_std = null;

        function getDataStd_new() {
            $.ajax({
                type: "POST",
                url: "controllers/student_controller",
                data: {
                    getDataStudent: true,
                    all: true
                },
                dataType: "json",
                success: function(json_res) {
                    const std_select = document.getElementById("std_select");
                    std_select.innerHTML = "";
                    std_select.innerHTML += `<option value="0">เลือกนักศึกษา</option>`;
                    data_std = json_res.data
                    data_std.forEach((element, i) => {
                        std_select.innerHTML += `<option value="${element.std_id}">${element.std_code} - ${element.std_prename}${element.std_name}</option>`;
                    });
                },
            });
        }

        function getDataStdbtStdId(std_id) {
            let std_data = data_std.filter((std) => std.std_id == std_id);
            std_data = std_data[0];
            $("#std_name").val(`${std_data.std_prename}${std_data.std_name}`)
        }

        $('#form-add-after-gradiate').submit((e) => {
            e.preventDefault();
            let isValidate = true;
            if ($('#std_select').val() == "0") {
                alert("โปรดเลือกนักศึกษา")
                $('#std_select').focus();
                return false;
            }

            let std_add_id = '<?php echo $_SESSION['user_data']->role_id == 4 ? $_SESSION['user_data']->edu_type : 0 ?>';

            const onjectData = {
                addAfterGradiate: true,
                std_id: std_add_id == "0" ? $('#std_select').val() : std_add_id
            }
            $("#form-add-after-gradiate input:not(:disabled):visible").each((index, element) => {
                if (element.type == "radio") {
                    const groupName = $(element).attr("name");
                    const group = $(`input[name='${groupName}']`);
                    const checked = group.filter(":checked").length > 0;
                    if (!checked && $(element).hasClass("required")) {
                        alert(`${element.placeholder}`);
                        element.focus();
                        isValidate = false;
                        return false;
                    } else {
                        onjectData[`${groupName}`] = $(`input[name='${groupName}']:checked`).val();
                    }
                } else if (element.type == "text" && $(element).hasClass("required")) {
                    if (element.value == "") {
                        alert(element.placeholder)
                        element.focus();
                        isValidate = false;
                        return false;
                    } else {
                        onjectData[`${element.name}`] = element.value;
                    }
                }
            })
            if (!isValidate) {
                return false;
            }

            $.ajax({
                type: "POST",
                url: "controllers/after_gradiate_controller",
                data: onjectData,
                dataType: "json",
                success: function(json_res) {
                    if (json_res.status) {
                        alert(json_res.msg);
                        <?php if ($_SESSION['user_data']->role_id != 4) { ?>
                            window.location.href = "form_after_gradiate";
                        <?php } else { ?>
                            window.location.href = "after_gradiate";
                        <?php } ?>

                    } else {
                        alert(json_res.msg);
                    }
                },
            });
        })
    </script>
</body>

</html>