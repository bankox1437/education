<?php include 'include/check_login.php'; ?>
<?php 
$classSession = "";
$calendar_new = false;
if ($_SESSION['user_data']->role_id != 4) {
    if (isset($_REQUEST['class'])) {
        $_SESSION['manage_calendar_class'] = $_REQUEST['class'];
    }
    if (!isset($_SESSION['manage_calendar_class']) || $_SESSION['manage_calendar_class'] == "0") {
        $classSession = "";
    } else {
        $status = json_decode($_SESSION['user_data']->status);
        $calendar_new = isset($status->calendar_new) ? true : false;
    }
    if (isset($_SESSION['manage_calendar_class']) && $_SESSION['manage_calendar_class'] == "1") {
        $classSession = "ประถม";
    }
    if (isset($_SESSION['manage_calendar_class']) && $_SESSION['manage_calendar_class'] == "2") {
        $classSession = "ม.ต้น";
    }
    if (isset($_SESSION['manage_calendar_class']) && $_SESSION['manage_calendar_class'] == "3") {
        $classSession = "ม.ปลาย";
    }
} else {

    $sql = "SELECT name,status FROM tb_users WHERE id = :id";
    $data_user_create = $DB->Query($sql, ['id' => $_SESSION['user_data']->user_create]);
    $data_user_create = json_decode($data_user_create);
    $statusSTD = json_decode($data_user_create[0]->status);
    $calendar_new = isset($statusSTD->calendar_new) ? true : false;

    $sql = "SELECT std_class FROM tb_students WHERE std_id = :std_id";
    $data_std = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
    $data_std = json_decode($data_std);
    $data_std_class = $data_std[0]->std_class;
    $classSession = $data_std_class;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แบบทดสอบ</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include('../include/nav-header.php'); ?>

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
                                <div class="box-header">

                                    <div class="row align-items-center">
                                        <h4 class="box-title">ตารางข้อมูลแบบทดสอบ</h4>
                                        <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="manage_testing_add"><i class="ti-plus"></i>&nbsp;เพิ่มแบบทดสอบ</a>
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
                                                    <th style="width: 100px;">ลิงค์แบทดสอบ</th>
                                                    <th style="width: 100px;" class="text-center">ภาคเรียนที่</th>
                                                    <th style="width: 100px;" class="text-center">ปีการศึกษา</th>
                                                    <th style="width: 50px;" class="text-center">แก้ไข</th>
                                                    <th style="width: 50px;" class="text-center">ลบ</th>
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
                    classroom: '<?php echo $classSession ?>'
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
                            <td colspan="${role_id == 3 ? 8 : 5}" class="text-center">
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
                        <td><a href="${element.link}" target="_blank">${element.link.length > 25 ?  element.link.substr(0,25)+' . . . ' : element.link}</a></td>
                        <td class="text-center">${element.term}</td>
                        <td class="text-center">${element.year}</td>
                        <td class="text-center">
                            <a href="manage_testing_edit?testing_id=${element.testing_id}">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt"></i></button>
                            </a>
                        </td>
                        <td>
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteTesting(${element.testing_id})"><i class="ti-trash"></i></button>
                        </td> 
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