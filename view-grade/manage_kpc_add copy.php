<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>บันทึกคะแนน กพช.</title>
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
                                    <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left"
                                            style="cursor: pointer;"
                                            onclick="window.location.href='manage_kpc'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                            class="ti-user mr-15"></i> <b>ฟอร์มบันทึก กพช. ปีการศึกษา <?php echo  $_SESSION['term_active']->term_name; ?></b>
                                    </h6>
                                </div>
                                <form class="form" id="form_add_kpc" enctype="multipart/form-data">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>นักศึกษา <b class="text-danger">*</b></label>
                                                <select class="form-control" id="std_id" style="width: 100%;">
                                                    <option value="">เลือกนักศึกษา</option>
                                                    <?php foreach ($std_data as $obj_std) {
                                                        echo "<option value='" . $obj_std->std_id . "'>" . $obj_std->std_code . "-" . $obj_std->std_prename . $obj_std->std_name . "</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>จำนวนชั่วโมง <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="hour" id="hour" autocomplete="off" placeholder="กรอกจำนวนชั่วโมง">
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

        $('#form_add_kpc').submit((e) => {
            e.preventDefault();
            const term_id = $('#term_id').val();
            const std_id = $('#std_id').val();
            const hour = $('#hour').val();
            if (!std_id) {
                alert('โปรดเลือกนักศึกษา')
                $('#std_id').focus()
                return false;
            }
            if (!hour) {
                alert('โปรดกรอกจำนวนชั่วโมง')
                $('#hour').focus()
                return false;
            }
            let formData = new FormData();
            formData.append('std_id', std_id);
            formData.append('term_id', term_id);
            formData.append('hour', hour);
            formData.append('insertKPC', true);

            $.ajax({
                type: "POST",
                url: "controllers/kpc_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_kpc';
                    } else {
                        alert(json.msg);
                    }
                },
            });
        })
    </script>
</body>

</html>