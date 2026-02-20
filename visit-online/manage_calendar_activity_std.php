<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-รายชื่อผู้เข้าร่วมกิจกรรม</title>
    <style>
        .input-group-text {
            width: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .input-group-text:hover {
            cursor: pointer;
            background-color: #5949d6;
            color: #fff;
        }

        .table tbody tr td {
            padding: 5px 5px;
            align-content: center;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <!-- <h4 class="box-title">รายชื่อผู้เข้าเรียน</h4> -->
                                    <h4 class="box-title"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_calendar_activity'"></i>
                                        <b class="ml-4" id="title-b">รายชื่อผู้เข้าร่วมกิจกรรม <?php echo $_GET['act_name'] ?></b>
                                    </h4>
                                    <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                        <a class="waves-effect waves-light btn btn-success btn-flat ml-2" id="print" onclick="printPage()"><i class="ti-printer"></i>&nbsp;ปริ้น</a>
                                    <?php } ?>

                                </div>
                                <div class="box-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mb-0" style="font-size: 14px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 15%;" class="text-center">รหัสนักศึกษา</th>
                                                    <th style="width: 45%;">ชื่อ-สกุล</th>
                                                    <th style="width: 15%;" class="text-center">ชั้น</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body_std">
                                                <tr>
                                                    <td colspan="3" class="text-center">
                                                        <?php include "../include/loader_include.php"; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.box-body -->
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
            getDataStdAct()
        });

        function getDataStdAct() {
            $.ajax({
                type: "POST",
                url: "controllers/activity_controller",
                data: {
                    getDataStdAct: true,
                    act_id: '<?php echo $_GET['act_id'] ?>'
                },
                dataType: "json",
                success: function(json_res) {
                    const std_join = document.getElementById('body_std');
                    std_join.innerHTML = ``;

                    if (json_res.data.length == 0) {
                        std_join.innerHTML = `<tr><td colspan="3" class="text-center">ยังไม่มีผู้เข้าร่วมกิจกรรม</td></tr>`;
                    } else {
                        for (let i = 0; i < json_res.data.length; i++) {
                            let ele = json_res.data[i];
                            std_join.innerHTML += `<tr>
                                                        <td class="text-center">${ele.std_code}</td>
                                                        <td>${ele.std_name}</td>
                                                        <td class="text-center">${ele.std_class}</td>
                                                    </tr>`;
                        }
                    }
                    //     
                    //     std_sign_in.innerHTML = textHtml;
                },
            });
        }

        function printPage() {
            $('#print').hide()
            $('.ti-arrow-left').hide()
            $('#title-b').removeClass('ml-4')
            window.print();
        }

        window.addEventListener("afterprint", (event) => {
            $('#print').show()
            $('.ti-arrow-left').show()
            $('#title-b').addClass('ml-4')
        });
    </script>
</body>

</html>