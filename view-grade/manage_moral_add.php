<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มเพิ่มคะแนนคุณธรรม</title>
    <style>
        .table>thead>tr>th {
            padding: 0 5px;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
            text-align: center;
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
                            <form id="form-add-moral-score">
                                <div class="box">
                                    <div class="box-body">
                                        <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_moral'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มจัดการคะแนนคุณธรรม</b></h6>
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
                                                                <th style="width: 350px;" class="text-center">
                                                                    รหัสนักศึกษา</th>
                                                                <th>ชื่อ-สกุล</th>
                                                                <th style="width: 150px;" class="text-center">
                                                                    คะแนน
                                                                </th>
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
        $(document).ready(function() {
            const std_class = document.getElementById('std_class').value;
            getDataStdToTable(std_class)
        });


        function getDataStdToTable(std_class) {
            $.ajax({
                type: "POST",
                url: "controllers/std_controller",
                data: {
                    getDataStdMoralToTable: true,
                    std_class: std_class
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
                    json_res.data.forEach((element, i) => {

                        body_std.innerHTML += `
                            <tr>
                                <td class="text-center">${element.std_code}</td>
                                <td>${element.std_name}</td>
                                  <td class="d-flex align-items-center justify-content-center">
                                  <input type="hidden" value="${element.std_id}" id="std_id" class="input-std-id" >
                                    <input type="number" id="moral_score_${element.std_id}" value="${element.score ? element.score : 0}" data-std-id="${element.std_id}" class="form-control filled-in chk-col-success input-score-moral" onKeyPress="if(this.value.length==3) return false;" style="width:6rem; margin-top:2px ; margin-left:25px;">
                                    <label for="moral_score_${element.std_id}" style="margin-top: 10px;margin-left: 25px;"></label>
                                </td>
                            </tr>`;
                    });

                },
            });
        }

        $('#form-add-moral-score').submit((e) => {
            e.preventDefault();
            const count_score = document.querySelectorAll(".input-score-moral");
            const std_id = document.querySelectorAll(".input-std-id");
            const object_std = [];
            for (var i = 0; i < std_id.length; i++) {

                if (count_score[i].value == "") {
                    count_score[i].focus();
                    alert("โปรดกรอกคะแนนคุณธรรม จริยธรรม");
                    return;
                }
                const object_score = {
                    std_id: std_id[i].value,
                    score_moral: count_score[i].value
                };
                object_std.push(object_score);
            }
            $.ajax({
                type: "POST",
                url: "controllers/moral_controller",
                data: {
                    std_score: JSON.stringify(object_std),
                    insert_moral: true,
                    std_class: $('#std_class').val()
                },
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_moral';
                    } else {
                        alert(json.msg);
                    }
                },
            });
        })
    </script>
</body>

</html>