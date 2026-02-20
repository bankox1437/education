<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข่าวประชาสัมพันธ์</title>
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
        <div class="content-wrapper" style="margin: 0px;">
            <div class="container-full">

                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $noti_data = [];
                $param = [
                    "user_create" => $_SESSION['user_data']->id
                ];
                $std_class = '';
                if (isset($_GET['std_class'])) {
                    $std_class = 'AND std_class = :std_class';
                    $param['std_class'] = $_GET['std_class'];
                }
                $sql = "SELECT * FROM tb_notifications WHERE user_create = :user_create " . $std_class . " ORDER BY noti_id ASC LIMIT 5";
                $data = $DB->Query($sql, $param);
                $noti_data = json_decode($data);

                $color_data = [];
                $sql = "SELECT * FROM tb_colors WHERE user_create = :user_create " . $std_class . " LIMIT 1";
                $data = $DB->Query($sql, $param);
                $color_data = json_decode($data);
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">

                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;">
                                            <i class="ti-announcement mr-15"></i>
                                            <b>ข่าวประชาสัมพันธ์</b>
                                        </h4>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>เลือกระดับชั้น</label>
                                                        <form action="" method="GET">
                                                            <select class="form-control select2" name="std_class" id="std_class" onchange="this.form.submit()" data-placeholder="เลือกระดับชั้น" style="width: 100%;">
                                                                <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ทั้งหมด" ? "selected" : "" ?> value="ทั้งหมด">ชั้นทั้งหมด</option>
                                                                <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ประถม" ? "selected" : "" ?> value="ประถม">ประถม</option>
                                                                <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ม.ต้น" ? "selected" : "" ?> value="ม.ต้น">ม.ต้น</option>
                                                                <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ม.ปลาย" ? "selected" : "" ?> value="ม.ปลาย">ม.ปลาย</option>
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <form class="form" id="form_noti">
                                                <?php for ($i = 0; $i < 5; $i++) { ?>
                                                    <input type="hidden" value="<?php echo !empty($noti_data[$i]) ? $noti_data[$i]->noti_id : '' ?>" name="noti_id[]">
                                                    <input type="hidden" value="<?php echo !empty($noti_data[$i]) ? $noti_data[$i]->noti_msg : '' ?>" name="noti_msg_old[]">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">ประกาศ <?php echo ($i + 1) ?></label>
                                                        <textarea class="form-control" rows="3" name="noti_msg[]"><?php echo !empty($noti_data[$i]) ? $noti_data[$i]->noti_msg : '' ?></textarea>
                                                    </div>
                                                <?php } ?>

                                                <button class="btn btn-rounded btn-primary btn-outline" type="button" onclick="submitFormWithoutNotiID()">
                                                    <i class="ti-save-alt"></i> บันทึกข้อมูล
                                                </button>
                                            </form>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="form-group row">
                                                <input type="hidden" value="<?php echo !empty($color_data[0]) ? $color_data[0]->color_id : '' ?>" name="color_id" id="colorId">
                                                <label class="col-form-label col-md-2"></label>
                                                <label class="col-form-label col-md-3" style="line-height: 2.5;">สีพื้นหลังหน้าแรกนักศึกษา 1</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="color" id="color1" name="color2" value="<?php echo !empty($color_data) ? $color_data[0]->color1 : '' ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-2"></label>
                                                <label class="col-form-label col-md-3" style="line-height: 2.5;">สีพื้นหลังหน้าแรกนักศึกษา 2</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="color" id="color2" name="color2" value="<?php echo !empty($color_data) ? $color_data[0]->color2 : '' ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-4"></label>
                                                <button class="col-md-3 btn btn-rounded btn-primary btn-outline" type="button" onclick="submitColor()">
                                                    <i class="ti-save-alt"></i> บันทึกสีพื้นหลัง
                                                </button>
                                                <label class="col-form-label col-md-2"></label>
                                            </div>
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
        function submitFormWithoutNotiID() {
            // Serialize the form data
            var formData = $('#form_noti').serialize();

            if ($('#std_select').val() == "0") {
                alert("โปรดเลือกนักศึกษา")
                $('#std_select').focus();
                return false;
            }

            let std_class = $('#std_class').val();

            formData = `${formData}&std_class=${std_class}&update_noti=1`;

            $.ajax({
                url: 'controllers/noti_controller',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(json) {
                    alert(json.msg);
                    if (json.status) {
                        window.location.reload();
                    }
                }
            });
        }

        function submitColor() {
            let colorId = $('#colorId').val();
            let color1 = $('#color1').val();
            let color2 = $('#color2').val();
            let std_class = $('#std_class').val();
            $.ajax({
                url: 'controllers/noti_controller',
                type: 'POST',
                data: {
                    color_id: colorId,
                    color1: color1,
                    color2: color2,
                    std_class: std_class,
                    update_color: 1
                },
                dataType: 'json',
                success: function(json) {
                    alert(json.msg);
                    if (json.status) {
                        window.location.reload();
                    }
                }
            });
        }
    </script>
</body>

</html>