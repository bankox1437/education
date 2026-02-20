<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แก้ไขผลรวมหน่วยกิต</title>
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
                    "	credit.*,CONCAT( std.std_code, '-', std.std_prename, std.std_name ) std_name \n" .
                    "FROM\n" .
                    "	vg_credit credit\n" .
                    "	LEFT JOIN tb_students std ON credit.std_id = std.std_id \n" .
                    "WHERE\n" .
                    "	credit.credit_id = :credit_id";
                $data = $DB->Query($sql, ['credit_id' => $_GET['credit_id']]);
                $credit_data = json_decode($data);
                if (count($credit_data) == 0) {
                    echo "<script>location.href = 404</script>";
                }
                $credit_data = $credit_data[0];
                ?>
                <input type="hidden" name="credit_id" id="credit_id" value="<?php echo $credit_data->credit_id; ?>">
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_credit'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                            <b>ฟอร์มแก้ไขผลรวมหน่วยกิต ปีการศึกษา <?php echo  $_SESSION['term_active']->term_name; ?></b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form_credit_edit" enctype="multipart/form-data">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>นักศึกษา <b class="text-danger">*</b></label>
                                                <select class="form-control" id="std_id" style="width: 100%;" disabled>
                                                    <option><?php echo $credit_data->std_name ?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วิชาบังคับ <b class="text-danger">*</b></label>
                                                    <input type="number" value="<?php echo  $credit_data->compulsory_subjects ?>" class="form-control height-input" name="compulsory_subjects" id="compulsory_subjects" autocomplete="off" placeholder="กรอกวิชาบังคับ">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วิชาบังคับเลือก <b class="text-danger">*</b></label>
                                                    <input type="number" value="<?php echo  $credit_data->elective_subjects ?>" class="form-control height-input" name="elective_subjects" id="elective_subjects" autocomplete="off" placeholder="กรอกวิชาบังคับเลือก">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วิชาเลือกเสรี <b class="text-danger">*</b></label>
                                                    <input type="number" value="<?php echo  $credit_data->free_electives ?>" class="form-control height-input" name="free_electives" id="free_electives" autocomplete="off" placeholder="กรอกวิชาเลือกเสรี">
                                                </div>
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
        $('#form_credit_edit').submit((e) => {
            e.preventDefault();
            const credit_id = $('#credit_id').val();
            const compulsory_subjects = $('#compulsory_subjects').val();
            const elective_subjects = $('#elective_subjects').val();
            const free_electives = $('#free_electives').val();
            if (!compulsory_subjects) {
                alert('โปรดกรอกวิชาบังคับ')
                $('#compulsory_subjects').focus()
                return false;
            }
            if (!elective_subjects) {
                alert('โปรดกรอกวิชาบังคับเลือก')
                $('#elective_subjects').focus()
                return false;
            }
            if (!free_electives) {
                alert('โปรดกรอกวิชาเลือกเสรี')
                $('#free_electives').focus()
                return false;
            }
            let formData = new FormData();
            formData.append('credit_id', credit_id);
            formData.append('compulsory_subjects', compulsory_subjects);
            formData.append('elective_subjects', elective_subjects);
            formData.append('free_electives', free_electives);
            formData.append('updateCredit', true);

            $.ajax({
                type: "POST",
                url: "controllers/credit_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_credit';
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