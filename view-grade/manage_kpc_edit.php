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
                $sql = "SELECT\n" .
                    "	kpc.*,CONCAT( std.std_code, '-', std.std_prename, std.std_name ) std_name \n" .
                    "FROM\n" .
                    "	vg_kpc kpc\n" .
                    "	LEFT JOIN tb_students std ON kpc.std_id = std.std_id \n" .
                    "WHERE\n" .
                    "	kpc.kpc_id = :kpc_id";
                $data = $DB->Query($sql, ['kpc_id' => $_GET['kpc_id']]);
                $kpc_data = json_decode($data);
                if (count($kpc_data) == 0) {
                    echo "<script>location.href = 404</script>";
                }
                $kpc_data = $kpc_data[0];
                ?>
                <input type="hidden" name="kpc_id" id="kpc_id" value="<?php echo $kpc_data->kpc_id; ?>">
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_kpc'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                            <b>ฟอร์มแก้ไข กพช. ปีการศึกษา <?php echo  $_SESSION['term_active']->term_name; ?></b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form_add_kpc" enctype="multipart/form-data">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>นักศึกษา <b class="text-danger">*</b></label>
                                                <select class="form-control" id="std_id" style="width: 100%;" disabled>
                                                    <option><?php echo $kpc_data->std_name ?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>จำนวนชั่วโมง <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="hour" id="hour" autocomplete="off" placeholder="กรอกจำนวนชั่วโมง" value="<?php echo $kpc_data->hour ?>">
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
        $('#form_add_kpc').submit((e) => {
            e.preventDefault();
            const kpc_id = $('#kpc_id').val();
            const hour = $('#hour').val();
            if (!hour) {
                alert('โปรดกรอกจำนวนชั่วโมง')
                $('#hour').focus()
                return false;
            }
            let formData = new FormData();
            formData.append('kpc_id', kpc_id);
            formData.append('hour', hour);
            formData.append('updateKPC', true);

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
                        window.location.reload();
                    }
                },
            });
        })
    </script>
</body>

</html>