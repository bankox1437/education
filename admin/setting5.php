<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ตั้งค่าลิงก์ข่าวสารและแบนเนอร์</title>
    <style>
        .video-container video {
            /* Makes video responsive */
            height: 15rem;
            /* Maintains aspect ratio */
            display: block;
            /* Prevents extra spacing issues */
            border-radius: 10px;
            /* Optional: Adds rounded corners */
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
                                    <h4 class="box-title">ตั้งค่าแบนเนอร์และวิดีโอหน้าแรก</h4>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            $sql = "select * from tb_setting_attribute where key_name = 'banner_index_1'";
                                            $data_result = $DB->Query($sql, []);
                                            $data_result = json_decode($data_result, true);

                                            $sql2 = "select * from tb_setting_attribute where key_name = 'banner_display'";
                                            $banner_display = $DB->Query($sql2, []);
                                            $banner_display = json_decode($banner_display, true);
                                            $mode = $banner_display[0]['value'];
                                            ?>
                                            <div class="row">
                                                <div class="col-md-6" id="box-banner">
                                                    <div class="form-group">
                                                        <label>รูปแบนเนอร์</label>
                                                        <input type="hidden" class="form-control" id="banner_old" name="banner_old" value="<?php echo $data_result[0]['value'] ?>">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="banner" name="banner" accept="image/png, image/gif, image/jpeg" onchange="setlabelFilename('banner')">
                                                            <label class="custom-file-label" for="banner" id="banner_label" style="overflow: hidden;">เลือกไฟล์รูปภาพ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline" style="margin-top: 23px;width: 100%;" onclick="UploadFile(1)">
                                                        <i class="ti-save-alt"></i> บันทึก
                                                    </button>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="demo-radio-button" style="margin-top: 30px;">
                                                        <input name="display" type="radio" id="radio_30" class="with-gap radio-col-primary" onchange="setDisplay(1)" <?php echo $mode == 1 ? "checked" : "" ?>>
                                                        <label for="radio_30">แสดงหน้าแรก</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6 mb-3">
                                                    <div style="width: 100%; height: 200px; flex-shrink: 0; margin-right: 15px;" class="text-left">
                                                        <img src="upload/banners/<?php echo $data_result[0]['value'] ?>" class="img-fluid" alt="Logo" style="width: 100%; height: 100%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <?php
                                            $sql = "select * from tb_setting_attribute where key_name = 'banner_index_2'";
                                            $data_result = $DB->Query($sql, []);
                                            $data_result = json_decode($data_result, true);
                                            ?>
                                            <div class="row">
                                                <div class="col-md-6" id="box-video">
                                                    <div class="form-group">
                                                        <label>วิดีโอ</label>
                                                        <input type="hidden" class="form-control" id="video_old" name="video_old" value="<?php echo $data_result[0]['value'] ?>">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="video" name="video" accept="video/mp4,video/x-m4v,video/*" onchange="setlabelFilename('video')">
                                                            <label class="custom-file-label" for="video" id="video_label" style="overflow: hidden;">เลือกไฟล์วิดีโอ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline" style="margin-top: 23px;width: 100%;" onclick="UploadFile(2)">
                                                        <i class="ti-save-alt"></i> บันทึก
                                                    </button>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="demo-radio-button" style="margin-top: 30px;">
                                                        <input name="display" type="radio" id="radio_31" class="with-gap radio-col-primary" onchange="setDisplay(2)" <?php echo $mode == 2 ? "checked" : "" ?>>
                                                        <label for="radio_31">แสดงหน้าแรก</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6 mb-3">
                                                    <div class="video-container">
                                                        <video muted controls loop>
                                                            <source src="upload/videos/<?php echo $data_result[0]['value'] ?>" type="video/mp4">
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
        formData.append("banner_vedio", true);
        formData.append("type", type);

        if (type == 1) {
            fileimage = document.getElementById("banner").files[0];
            fileOld = document.getElementById("banner_old").value;
        } else {
            fileimage = document.getElementById("video").files[0];
            fileOld = document.getElementById("video_old").value;

        }

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

    function setDisplay(type) {
        $.ajax({
            url: 'controllers/setting_controller',
            type: 'POST',
            data: {
                "setDisplay": true,
                "type": type
            },
            dataType: 'json',
            success: function(response) {}
        });
    }
</script>

</html>