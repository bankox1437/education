<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-บันทึกการจัดการเรียนรู้</title>
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
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title text-left" style="margin: 0;">
                                        <b>บันทึกการจัดการเรียนรู้</b>
                                    </h4>
                                    <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                        <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="manage_learning_add"><i class="ti-plus"></i>&nbsp;บันทึกการจัดการเรียนรู้</a>
                                    <?php } ?>

                                </div>
                                <div class="box-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover" style="font-size: 14px;">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="width: 190px;">การพบกลุ่ม-ปีการศึกษา</th>
                                                    <th>ผลการจัดการเรียนการสอน</th>
                                                    <th>ปัญหาและอุปสรรค</th>
                                                    <th>ข้อเสนอแนะ/แนวทางการแก้ไข</th>
                                                    <th>ความคิดเห็น</th>
                                                    <th class="text-center" style="width: 110px;">ดูรายละเอียด</th>
                                                    <th class="text-center" style="width: 150px;">แก้ไข/ลบ</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body-learning">
                                                <tr>
                                                    <td colspan="7" class="text-center">
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
            getlearnList()
        });

        function getlearnList() {
            $.ajax({
                type: "POST",
                url: "controllers/learning_controller",
                data: {
                    getlearnList: true,
                    user_id: '<?php echo isset($_GET['user_id']) ? $_GET['user_id'] : 0 ?>'
                },
                dataType: "json",
                success: function(json_res) {
                    console.log(json_res);
                    getHtmlData(json_res);
                },
            });
        }

        function getHtmlData(data) {
            const learn_list = document.getElementById('body-learning');
            learn_list.innerHTML = "";
            if (data.length == 0) {
                learn_list.innerHTML += `<tr>
                                            <td colspan="7" class="text-center">
                                                ยังไม่มีข้อมูล
                                            </td>
                                        </tr>`
                return;
            }
            data.forEach(element => {
                learn_list.innerHTML += `
                    <tr>
                        <td>${element.calendar}</td>
                        <td><span title="ทั้งหมดโปรดดูรายละเอียดเพิ่มเติม">${element.side_1.length > 20 ? `${element.side_1}. . .` : element.side_1 }</span></td>
                        <td><span title="ทั้งหมดโปรดดูรายละเอียดเพิ่มเติม">${element.side_2.length  > 20 ? `${element.side_2}. . .` : element.side_2 }</span></td>
                        <td><span title="ทั้งหมดโปรดดูรายละเอียดเพิ่มเติม">${element.side_3.length  > 20 ? `${element.side_3}. . .` : element.side_3 }</span></td>
                        <td><span title="ทั้งหมดโปรดดูรายละเอียดเพิ่มเติม">${element.reason == null ? 'ยังไม่ลงความเห็น' : element.reason.length  > 20 ? `${element.reason }. . .` : element.reason }</span></td>
                        <td class="text-center">
                            <a href="view_plan_calender_detail?calendar_id=${element.calendar_id}">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5"><i class="ti-eye"></i></button>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="manage_learning_edit?learning_id=${element.learning_id}&calendar_id=${element.calendar_id}">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
                            </a>
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5" onclick="deleteLearning(${element.learning_id})"><i class="ti-trash"></i></button>
                        </td>
                    </tr>`;
            });
        }

        function deleteLearning(learning_id) {
            const confirmDelete = confirm('ต้องการลบบันทึกการเรียนรู้นี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/learning_controller",
                    data: {
                        delete_learn_save: true,
                        id: learning_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            getlearnList()
                        } else {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                });
            }
        }
    </script>
</body>

</html>