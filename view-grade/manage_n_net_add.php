<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มจัดการบันทึกคะแนน N-Net</title>
    <style>
        .table>thead>tr>th {
            padding: 0 5px;
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

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <form id="form-add-std-test">
                                <div class="box">
                                    <div class="box-body">
                                        <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_n_net'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มจัดการบันทึกคะแนน N-Net <?php echo $_GET['term'] ?></b></h6>
                                        <hr class="my-15">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group row">
                                                    <label for="std_class" class="col-sm-3 col-form-label">เลือกระดับชั้น <b class="text-danger">*</b></label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control select2" name="std_class" id="std_class" data-placeholder="เลือกระดับชั้น" style="width: 100%;" onchange="getDataStdToTable(this.value)">
                                                            <option value="ประถม">ประถม</option>
                                                            <option value="ม.ต้น">ม.ต้น</option>
                                                            <option value="ม.ปลาย">ม.ปลาย</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="font-size: 12px;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 150px;" class="text-center">
                                                                    <input type="checkbox" id="status_check" class="filled-in chk-col-success" onchange="checked_all()">
                                                                    <label for="status_check" style="margin-top: 10px;padding-left: 20px;font-size: 12px;">&nbsp;เลือกทั้งหมด</label>
                                                                </th>
                                                                <th style="width: 350px;" class="text-center">รหัสนักศึกษา</th>
                                                                <th>ชื่อ-สกุล</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="body-std">
                                                            <!-- <tr>
                                                                <td class="text-center">1</td>
                                                                <td class="text-center">62000121121</td>
                                                                <td>นายกอ ไก่</td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" id="status_check_01" class="filled-in chk-col-success status_check_box">
                                                                    <label for="status_check_01" style="margin-top: 10px;padding-left: 20px;"></label>
                                                                </td>
                                                            </tr> -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline" id="btn-submit">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                    </div>
                                </div>
                            </form>
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
        const term_id = '<?php echo $_GET['term_id'] ?>';
        $(document).ready(function() {
            const std_class = document.getElementById('std_class').value;
            getDataStdToTable(std_class)
        });


        function getDataStdToTable(std_class) {
            document.getElementById('status_check').checked = false
            $.ajax({
                type: "POST",
                url: "controllers/std_controller",
                data: {
                    getDataStdToTableN_Net: true,
                    std_class: std_class,
                    term_id: term_id
                },
                dataType: "json",
                success: function(json_res) {
                    const body_std = document.getElementById('body-std');
                    body_std.innerHTML = "";
                    if (json_res.data.length == 0) {
                        body_std.innerHTML += `
                            <tr>
                                <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                            </tr>`;
                        return;
                    }
                    let all_check = []
                    json_res.data.forEach((element, i) => {
                        let checked = "";
                        if (element.status == "true") {
                            all_check.push(element.status)
                            checked = "checked"
                        }
                        body_std.innerHTML += `
                            <tr>
                                <td class="text-center">
                                    <input ${checked} type="checkbox" id="status_check_${element.std_id}" data-std-id="${element.std_id}" class="filled-in chk-col-success status_check_box">
                                    <label for="status_check_${element.std_id}" style="margin-top: 10px;padding-left: 20px;"></label>
                                </td>
                                <td class="text-center">${element.std_code}</td>
                                <td>${element.std_name}</td>
                            </tr>`;
                    });
                    if (all_check.length == json_res.data.length) {
                        document.getElementById('status_check').checked = true
                    }
                },
            });
        }

        function checked_all() {
            const status_check_status = document.getElementById('status_check').checked;
            const status_check_box = document.getElementsByClassName('status_check_box');
            if (status_check_status) {
                for (const std_checked of status_check_box) {
                    std_checked.checked = true;
                }
            } else {
                for (const std_checked of status_check_box) {
                    std_checked.checked = false;
                }
            }

        }

        async function getSTD_checker() {
            const arr_std = [];
            const status_check_box = document.getElementsByClassName('status_check_box');
            for (const std_checked of status_check_box) {
                const std_id = std_checked.getAttribute("data-std-id");
                const status_text = std_checked.checked ? "ผ่าน" : "ไม่ผ่าน";
                const obj_std = {
                    std_id: std_id,
                    status_text: status_text,
                    status: std_checked.checked
                }
                arr_std.push(obj_std)
            }
            return arr_std;
        }

        $('#form-add-std-test').submit(async (e) => {
            e.preventDefault();
            const std_obj = await getSTD_checker();
            $.ajax({
                type: "POST",
                url: "controllers/n_net_controller",
                data: {
                    std_checked: std_obj,
                    insert_n_net: true,
                    std_class: $('#std_class').val(),
                    term_id: term_id
                },
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_n_net';
                    } else {
                        alert(json.msg);
                    }
                },
            });
        })
    </script>
</body>

</html>