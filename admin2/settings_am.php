<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ตั้งค่าหน้าแรกระบบ</title>
    <style>
        /* .tooltip-custom {
            cursor: pointer;
        }

        .tooltiptext {
            display: none;
        } */

        .tooltip-custom {
            cursor: pointer;
            position: relative;
        }

        .tooltip-custom:before {
            content: attr(data-text);
            /* here's the magic */
            position: absolute;

            /* vertically center */
            top: 50%;
            transform: translateY(-50%);

            /* move to right */
            left: 100%;
            margin-left: 15px;
            /* and add a small left margin */

            /* basic styles */
            width: 200px;
            padding: 10px;
            border-radius: 10px;
            background: #5949d6;
            color: #fff;
            text-align: left;

            display: none;
            /* hide by default */
        }

        .tooltip-custom:hover:before {
            display: block;
        }

        .checkbox label {
            padding-left: 25px;
        }
    </style>
    <?php include 'include/scripts.php'; ?>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php include 'include/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">

                <?php
                include "../config/class_database.php";
                $DB = new Class_Database();
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">ตั้งค่าหน้าเว็บ</h4>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            $sql2 = "select * from tb_setting_attribute where key_name = 'banner_display_am'";
                                            $banner_display_am = $DB->Query($sql2, []);
                                            $banner_display_am = json_decode($banner_display_am, true);
                                            $mode = $banner_display_am[0]['value'];

                                            $sql = "select * from tb_setting_attribute where key_name = 'am_banner'";
                                            $am_banner = $DB->Query($sql, []);
                                            $am_banner = json_decode($am_banner, true);
                                            ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>รูปแบนเนอร์ TOP</label>
                                                        <input type="hidden" class="form-control" id="am_banner_old" name="am_banner_old" value="<?php echo $data_result[0]['value'] ?>">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="am_banner" name="am_banner" accept="image/png, image/gif, image/jpeg" onchange="setlabelFilename('am_banner')">
                                                            <label class="custom-file-label" for="am_banner" id="am_banner_label" style="overflow: hidden;">เลือกไฟล์รูปภาพ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline" style="margin-top: 23px;width: 100%;" onclick="UploadFile('am_banner')">
                                                        <i class="ti-save-alt"></i> บันทึก
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-12 mb-3">
                                                    <div style="width: 100%; height: auto; flex-shrink: 0; margin-right: 15px;" class="text-left">
                                                        <img src="../manage_am/images/am_images/<?php echo $am_banner[0]['value'] ?>" class="img-fluid" alt="Logo" style="width: 100%; height: 100%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <?php
                                            $sql = "select * from tb_setting_attribute where key_name = 'am_banner_main'";
                                            $am_banner_main = $DB->Query($sql, []);
                                            $am_banner_main = json_decode($am_banner_main, true);
                                            ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>รูปแบนเนอร์หลัก</label>
                                                        <input type="hidden" class="form-control" id="am_banner_main_old" name="am_banner_main_old" value="<?php echo $am_banner_main[0]['value'] ?>">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="am_banner_main" name="am_banner_main" accept="image/png, image/gif, image/jpeg" onchange="setlabelFilename('am_banner_main')">
                                                            <label class="custom-file-label" for="am_banner_main" id="am_banner_main_label" style="overflow: hidden;">เลือกไฟล์รูปภาพ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline" style="margin-top: 23px;width: 100%;" onclick="UploadFile('am_banner_main')">
                                                        <i class="ti-save-alt"></i> บันทึก
                                                    </button>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="demo-radio-button" style="margin-top: 30px;">
                                                        <input name="display" type="radio" id="radio_31" class="with-gap radio-col-primary" onchange="setDisplayAm(1)" <?php echo $mode == 1 ? "checked" : "" ?>>
                                                        <label for="radio_31">แสดงหน้าแรก</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-12 mb-3">
                                                    <div style="width: 100%; height: auto; flex-shrink: 0; margin-right: 15px;" class="text-left">
                                                        <img src="../manage_am/images/am_images/<?php echo $am_banner_main[0]['value'] ?>" class="img-fluid" alt="Logo" style="width: 100%; height: 100%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $sql = "select * from tb_setting_attribute where key_name = 'am_video_main'";
                                    $am_video_main = $DB->Query($sql, []);
                                    $am_video_main = json_decode($am_video_main, true);
                                    ?>

                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6" id="box-video">
                                                    <div class="form-group">
                                                        <label>วิดีโอ</label>
                                                        <input type="hidden" class="form-control" id="am_video_main_old" name="am_video_main_old" value="<?php echo $data_result[0]['value'] ?>">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="am_video_main" name="am_video_main" accept="video/mp4,video/x-m4v,video/*" onchange="setlabelFilename('am_video_main')">
                                                            <label class="custom-file-label" for="am_video_main" id="am_video_main_label" style="overflow: hidden;">เลือกไฟล์วิดีโอ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline" style="margin-top: 23px;width: 100%;" onclick="UploadFile('am_video_main')">
                                                        <i class="ti-save-alt"></i> บันทึก
                                                    </button>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="demo-radio-button" style="margin-top: 30px;">
                                                        <input name="display" type="radio" id="radio_32" class="with-gap radio-col-primary" onchange="setDisplayAm(2)" <?php echo $mode == 2 ? "checked" : "" ?>>
                                                        <label for="radio_32">แสดงหน้าแรก</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6 mb-3">
                                                    <div class="video-container">
                                                        <video muted controls loop>
                                                            <source src="../manage_am/images/videos/<?php echo $am_video_main[0]['value'] ?>" type="video/mp4">
                                                        </video>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->


</body>
<script>
    function setlabelFilename(id) {
        const file = document.getElementById(id).files;
        let fileName = '';
        for (let i = 0; i < file.length; i++) {
            if (i == 0) {
                fileName += file[i].name;
            } else {
                fileName += " , " + file[i].name;
            }
        }
        document.getElementById(id + '_label').innerText = fileName;
    }

    function UploadFile(type) {
        // รับค่าจากฟอร์ม
        let fileimage = null;
        let fileOld = null;
        let formData = new FormData();
        formData.append("banner_vedio_am", true);
        formData.append("banner_id", type);

        fileimage = document.getElementById(type).files[0];
        fileOld = document.getElementById(type + "_old").value;

        if (!fileimage) {
            alert("กรุณาเลือกไฟล์ก่อน");
            return;
        }

        formData.append("file", fileimage);
        formData.append("fileOld", fileOld);

        $.ajax({
            url: 'controllers/setting_controller',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                // จัดการการตอบกลับหลังจาก insert สำเร็จ
                alert(response.msg);
                window.location.reload();
            }
        });
    }

    function setDisplayAm(type) {
        $.ajax({
            url: 'controllers/setting_controller',
            type: 'POST',
            data: {
                "setDisplayAm": true,
                "type": type
            },
            dataType: 'json',
            success: function(response) {}
        });
    }
</script>

</html>