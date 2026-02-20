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

        #link_a:hover #link {
            color: red;
        }

        #link_a {
            color: red;
        }

        .card img {
            border-radius: 10px;
            height: 190px;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" id="print_content">

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
                                <div class="box-header with-border  no-print">
                                    <div class="row justify-content-between align-items-center">
                                        <h4 class="box-title text-left" style="margin: 0;">
                                            <?php if ($_SESSION['user_data']->role_id != 3) { ?>
                                                <p><a href="manage_index?user_id=<?php echo $_GET['user_id'] ?>&name=<?php echo $_GET['name'] ?>"><i class="ti-arrow-left no-print" style="cursor: pointer;"></i></a>&nbsp;<span>รายละเอียดข้อมูลเอกสารการประเมินพนักงานราชการ</span> <b><?php echo $_GET['name'] ?></b></p>
                                            <?php } else { ?>
                                                <p><a href="manage_index"><i class="ti-arrow-left no-print" style="cursor: pointer;"></i></a>&nbsp;<span>รายละเอียดข้อมูลเอกสารการประเมินพนักงานราชการ</span></p>
                                            <?php } ?>
                                        </h4>
                                    </div>
                                </div>

                                <?php include "../config/class_database.php";

                                $DB = new Class_Database();
                                $sql = "SELECT * FROM cl_index \n" .
                                    "WHERE index_id = :index_id";
                                $dataIndex = $DB->Query($sql, ['index_id' => $_GET['index_id']]);
                                $dataIndex = json_decode($dataIndex);

                                if (count($dataIndex) == 0) {
                                    echo '<script>location.href = "../404"</script>';
                                }

                                $dataIndex =  $dataIndex[0];

                                $sql = "SELECT * FROM cl_index_file \n" .
                                    "WHERE index_id = :index_id";
                                $data = $DB->Query($sql, ['index_id' => $_GET['index_id']]);
                                $data = json_decode($data);

                                $data_index_file = $data;
                                ?>

                                <div class="box-body">
                                    <div class="container" id="box-print">
                                        <div class="row justify-content-center">
                                            <div class="col-md-6">
                                                <h3 class="box-title"><?php echo $dataIndex->title_index ?></h3>
                                            </div>
                                        </div>
                                        <?php if ($dataIndex->video != "") { ?>
                                            <div class="row justify-content-center">
                                                <div class="col-md-6">
                                                    <a href="<?php echo $dataIndex->video ?>" target="_blank">
                                                        <h5 class="box-title"><i class="ti-video-clapper"></i> วิดีโอ</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php for ($i = 0; $i < count($data_index_file); $i++) {
                                            $filePath = 'uploads/index_files/' . $data_index_file[$i]->file_name;
                                            if (isset($data_index_file[$i]->file_name) && !empty($data_index_file[$i]->file_name)) {
                                                $data_index_file[$i]->file_name = file_exists($filePath)
                                                    ? "uploads/index_files/" . $data_index_file[$i]->file_name
                                                    : "https://drive.google.com/file/d/{$data_index_file[$i]->file_name}/view";
                                            }
                                        ?>
                                            <div class="row justify-content-center">
                                                <div class="col-md-6">
                                                    <div class="media media-single">
                                                        <span class="font-size-24 text-primary"><i class="fa fa-file-text"></i></span>
                                                        <span class="title"><?php echo $data_index_file[$i]->file_name_old ?></span>
                                                        <a class="font-size-18 text-gray hover-info" href="<?php echo $data_index_file[$i]->file_name ?>" target="_blank"><i class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>


                                        <?php

                                        $sql = "SELECT * FROM cl_index \n" .
                                            "WHERE index_id = :index_id";
                                        $data_index = $DB->Query($sql, ['index_id' => $_GET['index_id']]);
                                        $data_index = json_decode($data_index)[0];

                                        if ($_SESSION['user_data']->role_id != 2) {
                                            $statusText = '
                                                <h4 class="mb-1 box-title text-secondary">
                                                    ยังไม่ได้ประเมิน
                                                </h4>
                                            ';
                                            if ($data_index->evaluation_results == 1 && $data_index->evaluation_results != null) {
                                                $statusText = '
                                                <h4 class="mb-1 box-title text-success">
                                                    ผ่าน
                                                </h4>
                                            ';
                                            } else if ($data_index->evaluation_results == 0 && $data_index->evaluation_results != null) {
                                                $statusText = '
                                                <h4 class="mb-1 box-title text-danger">
                                                    ไม่ผ่าน
                                                </h4>
                                            ';
                                            }
                                        ?>

                                            <di class="row mt-4">
                                                <div class="col-md-12 text-center">
                                                    <h4 class="mb-1 box-title">
                                                        <b>ผลการประเมินพนักงานราชการ</b>
                                                    </h4>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <?php echo $statusText ?>
                                                </div>
                                            </di>

                                        <?php } else { ?>

                                            <di class="row mt-4">
                                                <div class="col-md-12 text-center">
                                                    <div class="form-group">
                                                        <h4 class="mb-1 box-title">
                                                            <b>ผลการประเมินพนักงานราชการ</b>
                                                        </h4>
                                                        <div class="c-inputs-stacked">
                                                            <input name="evaluation_results" type="radio" id="status_success" <?php echo $data_index->evaluation_results == 1 && $data_index->evaluation_results != null ? "checked" : "" ?> class="with-gap radio-col-success" value="1">
                                                            <label for="status_success" class="mr-30">ผ่าน</label>
                                                            <input name="evaluation_results" type="radio" id="status_fail" <?php echo $data_index->evaluation_results == 0  && $data_index->evaluation_results != null  ? "checked" : "" ?> class="with-gap radio-col-danger" value="0">
                                                            <label for="status_fail" class="mr-30">ไม่ผ่าน</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </di>
                                        <?php  } ?>

                                        <div class="row">
                                            <div class="col-md-12  text-center">
                                                <h4 class="mb-1 box-title">
                                                    <b>ความคิดเห็นของหัวหน้าสถานศึกษาหรือผู้ที่ได้รับมอบหมาย</b>
                                                </h4>
                                            </div>
                                            <?php if ($_SESSION['user_data']->role_id != 2) { ?>
                                                <div class="col-md-12 text-center">
                                                    <h5><?php echo $data_index->suggestions ?></h5>
                                                </div>
                                            <?php } else { ?>

                                                <div class="col-md-12">
                                                    <div id="reason_form">
                                                        <div class="form-group mt-2">
                                                            <textarea rows="5" class="form-control no-print" placeholder="กรอกความเห็นของหัวหน้าสถานศึกษาหรือผู้ที่ได้รับมอบหมาย" name="suggestions" id="suggestions"><?php echo $data_index->suggestions ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>


                                            <?php if ($_SESSION['user_data']->role_id == 2) { ?>
                                                <div class="col-md-12  text-center">
                                                    <button class="btn btn-rounded btn-primary btn-outline no-print" onclick="save_reason()">
                                                        <i class="ti-save-alt"> </i> บันทึกความคิดเห็น
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

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
        function save_reason() {
            const evaluation_results = $('input[name="evaluation_results"]:checked').val();
            const suggestions = $('#suggestions').val();
            if (!evaluation_results) {
                alert('โปรดระบุผลการประเมิน');
                return;
            }
            $.ajax({
                type: "POST",
                url: "controllers/index_controller",
                data: {
                    evaluation_results: evaluation_results,
                    suggestions: suggestions,
                    index_id: '<?php echo $_GET['index_id'] ?>',
                    save_reason: true
                },
                dataType: "json",
                success: async function(json) {
                    alert(json.msg);
                    if (json.status) {
                        window.location.reload();
                    } else {
                        window.location.reload();
                    }
                },
            });
        }
    </script>
</body>

</html>