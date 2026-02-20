<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แบบทดสอบ</title>
    <style>
        <?php
        if ($_SESSION['user_data']->role_id == 4) {
        ?>.table tbody tr td {
            padding: 5px 5px !important;
        }

        <?php  } ?>
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include('../include/nav-header.php'); ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php include 'include/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">

                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT * FROM tb_students\n" .
                    "WHERE std_id = :std_id";
                $dataSTD = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
                $dataSTD = json_decode($dataSTD);
                $dataSTD = $dataSTD[0];
                $stdClass = $dataSTD->std_class;
                ?>
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <div class="row align-items-center">
                                        <h4 class="box-title">ตารางข้อมูลแบบทดสอบ</h4>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" style="font-size: 14px;">
                                            <thead>
                                                <tr class="text-center">
                                                    <th style="width: 10px;">ลำดับ</th>
                                                    <th class="text-center" style="width: 150px;">ชื่อแบบทดสอบวิชา</th>
                                                    <th style="width: 350px;">คำอธิบาย</th>
                                                    <th style="width: 100px;">ลิงค์แบบทดสอบ</th>
                                                    <th style="width: 100px;" class="text-center">ภาคเรียนที่</th>
                                                    <th style="width: 100px;" class="text-center">ปีการศึกษา</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body-testing">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
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

        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">คำอธิบายแบบทดสอบ</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></button>
                    </div>
                    <div class="modal-body">
                        <h4 class='text-left' id="desc_id"></h4>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        $(document).ready(async function() {
            getDataTesting();
        });

        function getDataTesting() {
            $.ajax({
                type: "POST",
                url: "controllers/testing_controller",
                data: {
                    getDataTesting: true,
                    user_id: '<?php echo $_SESSION['user_data']->user_create ?>',
                    classroom: '<?php echo $stdClass ?>'
                },
                dataType: "json",
                success: function(json_res) {
                    console.log(json_res);
                    genHtmlTable(json_res.data);
                },
            });
        }

        function genHtmlTable(data) {
            const Tbody = document.getElementById("body-testing");
            Tbody.innerHTML = "";
            if (data.length == 0) {
                Tbody.innerHTML += `
                        <tr>
                            <td colspan="${role_id == 3 ? 8 : 6}" class="text-center">
                                ยังไม่มีข้อมูล
                            </td>
                        </tr>
                    `;
                return;
            }
            data.forEach((element, i) => {
                Tbody.innerHTML += `
                    <tr>
                        <td class="text-center">${i + 1}</td>
                        <td>${element.test_name}</td>
                        <td><a data-toggle="modal" data-target="#myModal" style="cursor: pointer;" onclick="openModal(\`${element.description}\`)">${element.description.length > 80 ? element.description.substr(0,80)+' . . . <b>ดูเพิ่มเติม</b>' : element.description}</a></td>
                        <td><a href="${element.link}" target="_blank">${element.link.length > 30 ?  element.link.substr(0,30)+' . . . ' : element.link}</a></td>
                        <td class="text-center">${element.term}</td>
                        <td class="text-center">${element.year}</td>
                    </tr>
        `;
            });
        }

        function deleteTesting(testing_id) {
            const confirmDelete = confirm('ต้องการลบแบบทดสอบนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/testing_controller",
                    data: {
                        delete_testing: true,
                        testing_id: testing_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            getDataTesting();
                        } else {
                            alert(data.msg);
                        }
                    },
                });
            }
        }

        function openModal(desc) {
            $('#desc_id').html(desc ?? 'ไม่มีคำอธิบาย');
        }
    </script>

</body>

</html>