<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มจัดการคะแนน กพช.</title>
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
                $whereHour = "";
                $term_id = isset($_GET["term_id"]) ? $_GET["term_id"] : $_SESSION['term_active']->term_id;
                $term_name = isset($_GET["term_name"]) ? $_GET["term_name"] : $_SESSION['term_active']->term_name;
                if (isset($_GET['edit'])) {
                    $whereHour = "	,IFNULL(( SELECT SUM( `hour` ) FROM vg_kpc kpc WHERE kpc.std_id = std.std_id AND kpc.term_id = " .  $term_id . " ) , 0 )  hours\n";
                }
                $sql = "SELECT\n" .
                    "	std.std_id,\n" .
                    "	std.std_code,\n" .
                    "	std.std_prename,\n" .
                    "	std.std_name,\n" .
                    "	edu.district_id\n" .
                    $whereHour .
                    "FROM\n" .
                    "	tb_students std\n" .
                    "	LEFT JOIN tb_users users ON std.user_create = users.id\n" .
                    "	LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id\n" .
                    "WHERE\n" .
                    "	std.user_create = :user_create \n" .
                    "	AND std.std_status = 'กำลังศึกษา' AND std.std_class = :std_class \n";
                $std_class = 'ประถม';
                if (isset($_GET['std_class'])) {
                    $std_class = $_GET['std_class'];
                }
                $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id, 'std_class' =>  $std_class]);
                $std_data = json_decode($data);
                ?>
                
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_kpc'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มบันทึก กพช. ปีการศึกษา <?php echo  $term_name; ?></b>
                                    </h6>
                                </div>
                                <form class="form" id="form_kpc_add" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group row">
                                                    <label for="std_class" class="col-sm-3 col-form-label">เลือกระดับชั้น</label>
                                                    <div class="col-sm-4">
                                                        <form action="" method="GET" class="col-md-2 mt-3">
                                                            <input type="hidden" name="term_id" id="term_id" value="<?php echo  $term_id ?>">
                                                            <select class="form-control select2" name="std_class" id="std_class" onchange="this.form.submit()" data-placeholder="เลือกระดับชั้น" style="width: 100%;">
                                                                <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ประถม" ? "selected" : "" ?> value="ประถม">ประถม</option>
                                                                <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ม.ต้น" ? "selected" : "" ?> value="ม.ต้น">ม.ต้น</option>
                                                                <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ม.ปลาย" ? "selected" : "" ?> value="ม.ปลาย">ม.ปลาย</option>
                                                            </select>
                                                            <?php if (isset($_GET['edit'])) {
                                                                echo "<input type='hidden' name='edit' value='1'>";
                                                            } ?>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="font-size: 12px;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 200px;" class="text-center">
                                                                    รหัสนักศึกษา</th>
                                                                <th>ชื่อ-สกุล</th>
                                                                <th style="width: 200px;" class="text-center">
                                                                    จำนวนชั่วโมง
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="body-std">
                                                            <?php
                                                            if (count($std_data) > 0) {
                                                                foreach ($std_data as $obj_std) {
                                                                    $hours =  isset($obj_std->hours) ? $obj_std->hours : '0';
                                                                    echo '<tr>
                                                                            <td class="text-center">
                                                                                ' . $obj_std->std_code . '
                                                                                <input type="hidden" class="std_id_array" value="' . $obj_std->std_id . '">
                                                                            </td>
                                                                            <td>' . $obj_std->std_prename . $obj_std->std_name . '</td>
                                                                            <td style="padding: 5px 20px;">
                                                                                <div class="form-group mb-0">
                                                                                    <input type="number" class="form-control text-center hour" autocomplete="off" placeholder="กรอกจำนวนชั่วโมง" value="' . $hours . '">
                                                                                </div>
                                                                            </td>
                                                                        </tr>';
                                                                }
                                                            } else {
                                                                echo '<tr>
                                                                            <td class="text-center" colspan="3">
                                                                                ไม่มีข้อมูล
                                                                            </td>
                                                                        </tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
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
        $(document).ready(() => {
            $('#std_id').select2()
        })

        $('#form_kpc_add').submit((e) => {
            e.preventDefault();
            $('.btn').attr('disabled', true)
            const term_id = $('#term_id').val();
            const hour_arr = [];
            const std_id_arr = [];

            for (const std_id_array of $('.std_id_array')) {
                std_id_arr.push(std_id_array.value)
            }

            for (const hour of $('.hour')) {
                if (!hour.value) {
                    alert('โปรดกรอกวิชาบังคับ')
                    hour.focus()
                    return false;
                }
                hour_arr.push(hour.value)
            }

            let formData = new FormData();
            formData.append('std_id', JSON.stringify(std_id_arr));
            formData.append('term_id', term_id);
            formData.append('hour_arr', JSON.stringify(hour_arr));
            formData.append('std_class', $("#std_class").val());
            formData.append('mode', '<?php echo isset($obj_std->hours) ? 'edit' : 'add'; ?>');
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