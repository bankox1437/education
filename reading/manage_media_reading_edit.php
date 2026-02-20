<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการสื่อการอ่าน</title>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php //include 'include/sidebar.php'; 
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">

                    <?php include "../config/class_database.php";
                    $DB = new Class_Database();
                    $sql = "SELECT\n" .
                        "	* \n" .
                        "FROM\n" .
                        "	rd_medias\n" .
                        "WHERE\n" .
                        "	media_id = :media_id";
                    $data = $DB->Query($sql, ['media_id' => $_GET['media_id']]);
                    $media_data = json_decode($data);
                    if (count($media_data) == 0) {
                        echo "<script>location.href = '../404'</script>";
                    }
                    $media_data = $media_data[0];
                    ?>
                    <input type="hidden" name="media_id" id="media_id" value="<?php echo $media_data->media_id; ?>">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_media_reading'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-book mr-15"></i>
                                            <b>ฟอร์มแก้ไขข้อมูลสื่อการอ่าน</b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form_media_reading_edit" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <!-- <div class="row col-md-8 mt-2"> -->
                                            <!-- <div class="col-md-6">
                                                <select class="form-control" id="std_class">
                                                    <option value="0" <?php echo $media_data->std_class == "0" ? 'selected' : '' ?>>ชั้นทั้งหมด</option>
                                                    <option value="ประถม" <?php echo $media_data->std_class == "ประถม" ? 'selected' : '' ?>>ประถม</option>
                                                    <option value="ม.ต้น" <?php echo $media_data->std_class == "ม.ต้น" ? 'selected' : '' ?>>ม.ต้น</option>
                                                    <option value="ม.ปลาย" <?php echo $media_data->std_class == "ม.ปลาย" ? 'selected' : '' ?>>ม.ปลาย</option>
                                                </select> -->
                                                <!-- <h5 for="">สำหรับ <?php echo $media_data->std_class == "0" ? 'ชั้นทั้งหมด' : $media_data->std_class ?></h5> -->
                                            <!-- </div> -->
                                        <!-- </div> -->
                                        <div class="row col-md-8 mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ชื่อเรื่อง <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="media_name" id="media_name" autocomplete="off" placeholder="กรอกชื่อเรื่อง" value="<?php echo $media_data->media_name ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ชื่อผู้แต่ง</label>
                                                    <input type="text" class="form-control height-input" name="author_name" id="author_name" autocomplete="off" placeholder="กรอกชื่อผู้แต่ง" value="<?php echo $media_data->author_name ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row col-md-8 mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ลิงค์ E-book </label>
                                                    <input type="text" class="form-control height-input" name="link_e_book" id="link_e_book" autocomplete="off" placeholder="กรอกลิงค์ E-book" value="<?php echo $media_data->link_e_book ?>">
                                                </div>
                                            </div>
                                            <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>ลิงค์แบบทดสอบ </label>
                                                        <input type="text" class="form-control height-input" name="link_test" id="link_test" autocomplete="off" placeholder="กรอกลิงค์แบบทดสอบ" value="<?php echo $media_data->link_test ?>">
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ลิงค์แบบบันทึกหลังอ่าน </label>
                                                    <input type="text" class="form-control height-input" name="link_know_test" id="link_know_test" autocomplete="off" placeholder="กรอกลิงค์แบบบันทึกหลังอ่าน" value="<?php echo $media_data->link_know_test ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row col-md-8 mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>หน้าปกสื่อ PDF</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="media_cover_file" name="media_cover_file" accept="application/pdf" onchange="setlabelFilename('media_cover_file')">
                                                        <label class="custom-file-label" for="media_cover_file" id="media_cover_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                    <input type="hidden" id="media_file_name_cover" name="media_file_name_cover" value="<?php echo $media_data->media_file_name_cover ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>แนบไฟล์ PDF สำหรับสื่อ</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="media_file" name="media_file" accept="application/pdf" onchange="setlabelFilename('media_file')">
                                                        <label class="custom-file-label" for="media_file" id="media_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                    <input type="hidden" id="media_file_name" name="media_file_name" value="<?php echo $media_data->media_file_name ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row col-md-2">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-rounded btn-primary btn-outline mt-4">
                                                    <i class="ti-save-alt"></i> บันทึกข้อมูล
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </section>
                <!-- /.content -->
                <div class="preloader">
                    <?php include ".//include/loader_include.php"; ?>
                </div>
                <?php include '../include/footer.php'; ?>
            </div>
        </div>
        <!-- /.content-wrapper -->


    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        $(document).ready(() => {
            $('#std_id').select2()
        })

        function setlabelFilename(id) {
            const file = document.getElementById(id).files[0];
            document.getElementById(id + '_label').innerText = file.name;
        }

        $('#form_media_reading_edit').submit((e) => {
            e.preventDefault();
            const media_id = $('#media_id').val();
            const std_class = 0;
            const media_name = $('#media_name').val();
            const author_name = $('#author_name').val();
            const link_e_book = $('#link_e_book').val();
            <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                const link_test = $('#link_test').val();
            <?php } ?>
            const link_know_test = $('#link_know_test').val();
            const media_file = document.getElementById('media_file').files[0];
            const media_file_name = $('#media_file_name').val();

            const media_file_cover = document.getElementById('media_cover_file').files[0];
            const media_file_name_cover = $('#media_file_name_cover').val();

            let formData = new FormData();
            if (!media_name) {
                alert('โปรดกรอกชื่อเรื่อง')
                $('#media_name').focus()
                return false;
            }
            // if (!link_e_book) {
            //     alert('กรอกลิงค์ e-book')
            //     $('#link_e_book').focus()
            //     return false;
            // }
            <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                // if (!link_test) {
                //     alert('โปรดกรอกลิงค์แบบทดสอบ')
                //     $('#link_test').focus()
                //     return false;
                // }
            <?php } ?>
            // if (!link_know_test) {
            //     alert('โปรดกรอกลิงค์ใบวัดความรู้หลังอ่าน')
            //     $('#link_know_test').focus()
            //     return false;
            // }

            formData.append('media_id', media_id);
            formData.append('media_name', media_name);
            formData.append('author_name', author_name);
            formData.append('std_class', std_class);
            formData.append('link_e_book', link_e_book);
            <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                formData.append('link_test', link_test);
            <?php } ?>
            formData.append('link_know_test', link_know_test);
            formData.append('media_file', media_file);
            if (media_file) {
                formData.append('media_file', media_file);
            }
            formData.append('media_file_name', media_file_name);

            if (media_file_cover) {
                formData.append('media_file_cover', media_file_cover);
            }
            formData.append('media_file_name_cover', media_file_name_cover);

            formData.append('updateMedia', true);

            $.ajax({
                type: "POST",
                url: "controllers/media_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_media_reading';
                    } else {
                        alert(json.msg);
                    }
                },
            });
        })
    </script>
</body>

</html>