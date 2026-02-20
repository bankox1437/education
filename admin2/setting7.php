<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ตั้งค่าพื้นหลัง</title>
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
                                    <h4 class="box-title">ตั้งค่าพื้นหลัง</h4>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            $sql2 = "select * from tb_setting_attribute where key_name = 'bg_image'";
                                            $bg_image = $DB->Query($sql2, []);
                                            $bg_image = json_decode($bg_image, true);
                                            ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>รูปพื้นหลัง</label>
                                                        <input type="hidden" class="form-control" id="bg_image_old" name="bg_image_old" value="<?php echo $bg_image[0]['value'] ?>">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="bg_image" name="bg_image" accept="image/png, image/gif, image/jpeg" onchange="setlabelFilename('bg_image')">
                                                            <label class="custom-file-label" for="bg_image" id="bg_image_label" style="overflow: hidden;">เลือกไฟล์รูปภาพ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline" style="margin-top: 23px;width: 100%;" onclick="UploadFile('bg_image')">
                                                        <i class="ti-save-alt"></i> บันทึก
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-12 mb-3">
                                                    <div style="width: 100%; height: auto; flex-shrink: 0; margin-right: 15px;" class="text-left">
                                                        <img src="../manage_am/images/am_images/<?php echo $bg_image[0]['value'] ?>" class="img-fluid" alt="Logo" style="width: 100%; height: 100%;">
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
        formData.append("bg_image", true);

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