<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มแก้ไขข้อมูลนักศึกษารายบุคคล</title>
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

                            <?php include "../config/class_database.php";
                            $DB = new Class_Database();
                            $sql = "SELECT\n" .
                                "	after_g.*,\n" .
                                "	CONCAT( std.std_code, '-', std.std_prename, std.std_name ) std_name, \n" .
                                "	CONCAT( std.std_prename, std.std_name ) name \n" .
                                "FROM\n" .
                                "	stf_tb_after_gradiate after_g\n" .
                                "	LEFT JOIN tb_students std ON after_g.std_id = std.std_id \n" .
                                "WHERE\n" .
                                "	after_g.after_id = :after_id";
                            $data = $DB->Query($sql, ['after_id' => $_GET['after_id']]);
                            $after_data = json_decode($data);
                            if (count($after_data) == 0) {
                                echo "<script>location.href = '../404' </script>";
                            }
                            $after_data = $after_data[0];
                            ?>
                            <div class="box">
                                <div class="box-body">
                                    <?php
                                    if ($_SESSION['user_data']->role_id != 4) { ?>
                                        <h6 class="box-title text-info" style="margin: 0;">
                                            <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form_after_gradiate'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="ti-user mr-15"></i> <b>ฟอร์มแก้ไขข้อมูลแบบติดตามหลังจบการศึกษา</b>
                                        </h6>
                                    <?php } else { ?>
                                        <h6 class="box-title text-info" style="margin: 0;">
                                            <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='after_gradiate'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="ti-user mr-15"></i> <b>ฟอร์มแก้ไขข้อมูลแบบติดตามหลังจบการศึกษา</b>
                                        </h6>
                                    <?php } ?>
                                    <hr class="my-15">
                                    <form id="form-add-after-gradiate">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><b>เลือกนักศึกษา</b> <b class="text-danger">*</b></label>
                                                    <select class="form-control select2" disabled name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;">
                                                        <option selected><?php echo $after_data->std_name ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><b>ปีการศึกษาที่จบ</b> <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input required" name="end_year" id="end_year" autocomplete="off" placeholder="กรุณากรอกปีการศึกษาที่จบ" value="<?php echo $after_data->end_year ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label><b>ระดับชั้นที่จบ </b><b class="text-danger">*</b></label>
                                                    <div class="c-inputs-stacked">
                                                        <input name="end_class" type="radio" <?php echo $after_data->end_class == 1 ? 'checked' : '' ?> id="pratom" class="with-gap radio-col-primary required" placeholder="ระบุระดับชั้นที่จบ" value="1">
                                                        <label for="pratom" class="mr-30">ประถม</label>
                                                        <input name="end_class" type="radio" <?php echo $after_data->end_class == 2 ? 'checked' : '' ?> id="m_ton" class="with-gap radio-col-primary required" placeholder="ระบุระดับชั้นที่จบ" value="2">
                                                        <label for="m_ton" class="mr-30">ม.ต้น</label>
                                                        <input name="end_class" type="radio" <?php echo $after_data->end_class == 3 ? 'checked' : '' ?> id="m_pai" class="with-gap radio-col-primary required" placeholder="ระบุระดับชั้นที่จบ" value="3">
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
        });

        $('input[name="edu_qualification"]').change(function() {
            // Get the value of the selected radio button
            var selectedValue = $(this).val();
            $('#edu_qualification_school').hide();
            if (selectedValue == 1) {
                $('#edu_qualification_school').show();
            }

        });

        $('#form-add-after-gradiate').submit((e) => {
            e.preventDefault();
            let isValidate = true;
            const onjectData = {
                editAfterGradiate: true
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
            onjectData['after_id'] = '<?php echo $_GET['after_id'] ?>';

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