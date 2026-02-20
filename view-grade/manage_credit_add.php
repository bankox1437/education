<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>บันทึกผลรวมหน่วยกิต</title>
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
                    "WHERE std.user_create = :user_create AND std_class = :std_class";
                $std_class = 'ประถม';
                if (isset($_GET['std_class'])) {
                    $std_class = $_GET['std_class'];
                }
                $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id, 'std_class' =>  $std_class]);
                $std_data = json_decode($data);
                ?>
                <input type="hidden" name="term_id" id="term_id" value="<?php echo $_SESSION['term_active']->term_id ?>">
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_credit'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มบันทึกผลรวมหน่วยกิต ปีการศึกษา <?php echo  $_SESSION['term_active']->term_name; ?></b>
                                    </h6>
                                </div>
                                <form class="form" id="form_credit_add" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group row">
                                                    <label for="std_class" class="col-sm-3 col-form-label">เลือกระดับชั้น</label>
                                                    <div class="col-sm-4">
                                                        <form action="" method="GET" class="col-md-2 mt-3">
                                                            <select class="form-control select2" name="std_class" id="std_class" onchange="this.form.submit()" data-placeholder="เลือกระดับชั้น" style="width: 100%;" onchange="getDataStdToTable(this.value)">
                                                                <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ประถม" ? "selected" : "" ?> value="ประถม">ประถม</option>
                                                                <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ม.ต้น" ? "selected" : "" ?> value="ม.ต้น">ม.ต้น</option>
                                                                <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ม.ปลาย" ? "selected" : "" ?> value="ม.ปลาย">ม.ปลาย</option>
                                                            </select>
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
                                                                <th style="width: 150px;" class="text-center">
                                                                    วิชาบังคับ
                                                                </th>
                                                                <th style="width: 150px;" class="text-center">
                                                                    วิชาบังคับเลือก
                                                                </th>
                                                                <th style="width: 150px;" class="text-center">
                                                                    วิชาเลือกเสรี
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="body-std">
                                                            <?php
                                                            foreach ($std_data as $obj_std) {
                                                                echo '<tr>
                                                                        <td class="text-center">
                                                                            ' . $obj_std->std_code . '
                                                                            <input type="hidden" class="std_id_array" value="' . $obj_std->std_id . '">
                                                                        </td>
                                                                        <td>' . $obj_std->std_prename . $obj_std->std_name . '</td>
                                                                        <td style="padding: 5px 20px;">
                                                                            <div class="form-group mb-0">
                                                                                <input type="number" class="form-control text-center compulsory_subjects" autocomplete="off" placeholder="กรอกหน่วยกิต" value="0">
                                                                            </div>
                                                                        </td>
                                                                        <td style="padding: 5px 20px;">
                                                                            <div class="form-group mb-0">
                                                                                <input type="number" class="form-control text-center elective_subjects" autocomplete="off" placeholder="กรอกหน่วยกิต" value="0">
                                                                            </div>
                                                                        </td>
                                                                        <td style="padding: 5px 20px;">
                                                                            <div class="form-group mb-0">
                                                                                <input type="number" class="form-control text-center free_electives" autocomplete="off" placeholder="กรอกหน่วยกิต" value="0">
                                                                            </div>
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

        $('#form_credit_add').submit((e) => {
            e.preventDefault();
            const term_id = $('#term_id').val();
            const compulsory_subjects_arr = [];
            const elective_subjects_arr = [];
            const free_electives_arr = [];
            const std_id_arr = [];

            for (const std_id_array of $('.std_id_array')) {
                std_id_arr.push(std_id_array.value)
            }

            for (const compulsory_subjects of $('.compulsory_subjects')) {
                if (!compulsory_subjects.value) {
                    alert('โปรดกรอกวิชาบังคับ')
                    compulsory_subjects.focus()
                    return false;
                }
                compulsory_subjects_arr.push(compulsory_subjects.value)
            }
            for (const elective_subjects of $('.elective_subjects')) {
                if (!elective_subjects.value) {
                    alert('โปรดกรอกวิชาบังคับเลือก')
                    elective_subjects.focus()
                    return false;
                }
                elective_subjects_arr.push(elective_subjects.value)
            }
            for (const free_electives of $('.free_electives')) {
                if (!free_electives.value) {
                    alert('โปรดกรอกวิชาเลือกเสรี')
                    free_electives.focus()
                    return false;
                }
                free_electives_arr.push(free_electives.value)
            }

            let formData = new FormData();
            formData.append('std_id', JSON.stringify(std_id_arr));
            formData.append('term_id', term_id);
            formData.append('compulsory_subjects', JSON.stringify(compulsory_subjects_arr));
            formData.append('elective_subjects', JSON.stringify(elective_subjects_arr));
            formData.append('free_electives', JSON.stringify(free_electives_arr));
            formData.append('insertCredit', true);

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
                    }
                },
            });
        })
    </script>
</body>

</html>