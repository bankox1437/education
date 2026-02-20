<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>บันทึกการจัดการเรียนรู้ครั้งที่ 1 ภาคเรียนที่ 2/2566</title>
    <style>
        .detail-text {
            font-size: 18px;
            color: #475f7b;
            word-wrap: break-word;
            /* border-bottom-style: dotted; */
        }

        .box-body {
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }

        @media print {

            body {
                margin: 0;
                color: #000;
                background-color: #fff;
            }

        }

        #box-print {
            padding-left: 80px;
            padding-right: 80px;
        }

        @media (max-width: 768px) {
            #box-print {
                padding-left: 10px;
                padding-right: 10px;
            }
        }

        #link_a:hover #link{
            color: red;
        }

        #link_a {
            color: red;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" id="print_content">

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
                                <div class="box-header with-border no-print">
                                    <div class="row justify-content-between align-items-center">
                                        <h4 class="box-title text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='learning_list?term=<?php echo $_GET['term'] ?>&year=<?php echo $_GET['year'] ?>&user_id=<?php echo $_GET['user_id'] ?>'"></i>
                                            &nbsp;<b>บันทึกการจัดการเรียนรู้ครั้งที่ <?php echo $_GET['time'] ?> ภาคเรียนที่ <?php echo $_GET['term'] . '/' . $_GET['year'] ?></b>
                                        </h4>
                                        <div>
                                            <button class="btn btn-success ml-2" onclick="printPage()"><i class="ti-printer"></i>&nbsp; ปริ้น</button>
                                            <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                <a class="btn btn-warning ml-2" href="manage_learning_edit?time=<?php echo $_GET['time'] ?>&term=<?php echo  $_GET['term'] ?>&year=<?php echo $_GET['year'] ?>&user_id=<?php echo $_GET['user_id'] ?>&learning_id=<?php echo  $_GET['learning_id'] ?>"><i class="ti-write"></i>&nbsp; แก้ไข</a>
                                                <button class="btn btn-danger ml-2" onclick="deleteLearn('<?php echo  $_GET['learning_id'] ?>')"><i class="ti-trash"></i>&nbsp; ลบ</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="container" id="box-print">
                                        <div class="d-flex justify-content-center">
                                            <h3 class="m-1 box-title"><b>บันทึกการจัดการเรียนรู้</b></h3>
                                        </div>
                                        <div class="row mt-3 no-print m-0">
                                            <div class="col-md-12">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>ลิ้งการสอน</b></h4>
                                                    <a href="" id="link_a">
                                                        <p class="detail-text" id="link"></p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>1. ผลการจัดการเรียนการรู้</b></h4>
                                                    <p class="detail-text" id="side_1"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>2. ปัญหาและอุปสรรค</b></h4>
                                                    <p class="detail-text" id="side_2"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>3. ข้อเสนอแนะ/แนวทางแก้ไข</b></h4>
                                                    <p class="detail-text" id="side_3"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>ความคิดเห็นของหัวหน้าสถานศึกษาหรือผู้ที่ได้รับมอบหมาย</b></h4>
                                                    <p class="detail-text" id="reason_text" style="display: block;">ยังไม่ได้ลงความเห็น</p>
                                                    <div id="reason_form" style="display: none;">
                                                        <div class="form-group mt-2 no-print">
                                                            <textarea rows="5" class="form-control" placeholder="กรอกความเห็นของหัวหน้าสถานศึกษาหรือผู้ที่ได้รับมอบหมาย" name="reason" id="reason"> </textarea>
                                                        </div>
                                                        <button class="btn btn-rounded btn-primary btn-outline no-print" onclick="save_reason()">
                                                            <i class="ti-save-alt"> </i> บันทึกความคิดเห็น
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <br>
                                    <br>
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
            getlearnDetail()
        });

        function getlearnDetail() {
            let role_id = '<?php echo $_SESSION['user_data']->role_id ?>';
            $.ajax({
                type: "POST",
                url: "controllers/learning_controller",
                data: {
                    getlearnDetail: true,
                    learning_id: '<?php echo $_GET['learning_id'] ?>'
                },
                dataType: "json",
                success: function(json_res) {
                    console.log(json_res);
                    document.getElementById('side_1').innerHTML = `${json_res[0].side_1}`;
                    document.getElementById('side_2').innerHTML = `${json_res[0].side_2}`;
                    document.getElementById('side_3').innerHTML = `${json_res[0].side_3}`;
                    document.getElementById('link_a').href = json_res[0].learning_link;
                    document.getElementById('link').innerHTML = json_res[0].learning_link;
                    if (role_id == 2) {
                        $('#reason_text').hide();
                        $('#reason_form').show();
                        if (json_res[0].reason == null) {
                            document.getElementById('reason').innerHTML = '';
                        } else {
                            document.getElementById('reason').innerHTML = json_res[0].reason;
                            document.getElementById('reason_text').innerHTML = json_res[0].reason;
                        }
                    } else {
                        $('#reason_text').show();
                        $('#reason_form').hide();
                        if (json_res[0].reason == null) {
                            document.getElementById('reason_text').innerHTML = 'ยังไม่ได้ลงความเห็น';
                        } else {
                            document.getElementById('reason_text').innerHTML = json_res[0].reason;
                        }
                    }
                    //getHtmlData(json_res);
                },
            });
        }

        function save_reason() {
            const reason = document.getElementById('reason');
            const learning_id = '<?php echo  $_GET['learning_id'] ?>';
            if (reason.value == "") {
                reason.focus()
                return;
            }
            $.ajax({
                type: "POST",
                url: "controllers/learning_controller",
                data: {
                    learning_id: learning_id,
                    reason: reason.value,
                    add_reason: true
                },
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.reload();
                    } else {
                        alert(json.msg);
                        window.location.reload();
                    }
                },
            });
        }

        function printPage() {
            $('#reason_text').show();
            window.print();
        }

        window.addEventListener("afterprint", (event) => {
            let role_id = '<?php echo $_SESSION['user_data']->role_id ?>';
            if (role_id == 2) {
                $('#reason_text').hide();
            }
        });

        function deleteLearn(id) {
            const confirmDelete = confirm('ต้องการลบบันทึกการเรียนรู้นี้ หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/learning_controller",
                    data: {
                        delete_learn_save: true,
                        id: id,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            alert(data.msg);
                            window.location.href = 'learning_list?term=<?php echo $_GET['term'] ?>&year=<?php echo $_GET['year'] ?>&user_id=<?php echo $_GET['user_id'] ?>'
                        } else {
                            alert(data.msg)
                            window.location.reload();
                        }
                    },
                });
            }
        }
    </script>
</body>

</html>