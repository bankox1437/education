<?php include 'include/check_login.php'; ?>

<?php
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
    <title>นิเทศออนไลน์-บันทึกการจัดการเรียนรู้</title>
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

        .card-img-top {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            height: 190px;
            object-fit: cover;
        }

        .img-hover:hover {
            cursor: pointer;
        }

        .img-hover {
            position: relative;
        }
    </style>
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
                                    <div class="row">
                                        <?php
                                        $backPage = "manage_calendar";
                                        if (!empty($calendar_new)) {
                                            $backPage = 'view_plan_calender_detail_new?calendar_id=' . $_GET['calendar_id'];
                                            $backPage .= isset($_GET['learning_id']) ? '&learning_id=' . $_GET['learning_id'] : '';
                                            $backPage .= $_SESSION['user_data']->role_id == 2 ? '&user_id=' . $_GET['user_id'] . '&name=' . $_GET['name'] : '';
                                        }
                                        ?>
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='<?php echo $backPage ?>'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มบันทึกการจัดการเรียนรู้</b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form-add-learning">
                                    <div class="box-body">
                                        <input type="hidden" name="calendar_id" id="calendar_id" value="<?php echo isset($_GET['calendar_id']) ? $_GET['calendar_id'] : '' ?>">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><b>1. ผลการจัดการเรียนการสอน <span class="text-danger">*</span></b></label>
                                                    <textarea rows="5" class="form-control" placeholder="กรอกผลการจัดการเรียนการสอน" name="side_1" id="side_1"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><b>2. ปัญหาและอุปสรรค <span class="text-danger">*</span></b></label>
                                                    <textarea rows="5" class="form-control" placeholder="กรอกปัญหาและอุปสรรค" name="side_2" id="side_2"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><b>3. ข้อเสนอแนะ/แนวทางการแก้ไข <span class="text-danger">*</span></b></label>
                                                    <textarea rows="5" class="form-control" placeholder="กรอกข้อเสนอแนะ/แนวทางการแก้ไข" name="side_3" id="side_3"></textarea>
                                                </div>
                                            </div>
                                            <br>
                                            <label class="ml-2  mt-3"><b>ใส่รูปภาพประกอบการเรียนการสอน <span class="text-danger">( png, jpg, jpeg, gif )</span></b></label>
                                            <div class="col-md-12 row">
                                                <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file1')">
                                                    <img class="card-img-top" src="images/no-image.jpg" alt="card image cap" id="preview_image_file1">
                                                    <input type="file" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file1" name="image_file1" style="display: none;" onchange="changeInputFile('image_file1')">
                                                </div>
                                                <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file2')">
                                                    <img class="card-img-top" src="images/no-image.jpg" alt="card image cap" id="preview_image_file2">
                                                    <input type="file" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file2" name="image_file2" style="display: none;" onchange="changeInputFile('image_file2')">
                                                </div>
                                                <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file3')">
                                                    <img class="card-img-top" src="images/no-image.jpg" alt="card image cap" id="preview_image_file3">
                                                    <input type="file" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file3" name="image_file3" style="display: none;" onchange="changeInputFile('image_file3')">
                                                </div>
                                                <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file4')">
                                                    <img class="card-img-top" src="images/no-image.jpg" alt="card image cap" id="preview_image_file4">
                                                    <input type="file" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file4" name="image_file4" style="display: none;" onchange="changeInputFile('image_file4')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                    </div>
                                </form>
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
        function changeInputFile(id) {
            const inputFile = document.getElementById(id);
            if (typeof inputFile.files == undefined) {
                //alert("ต้องเลือกรูปภาพ 4 ภาพ");
                return;
            }
            let file_label = "";
            file_label += inputFile.files[0].name + ", ";
            const file_src = URL.createObjectURL(inputFile.files[0]);
            $('#preview_' + id).attr('src', file_src);
        }

        function triggerFileInput(id) {
            const fileInput = document.getElementById(id);
            fileInput.click();
        }

        $('#form-add-learning').submit((e) => {
            e.preventDefault()
            const calendar_id = $('#calendar_id').val();
            const side_1 = $('#side_1').val();
            const side_2 = $('#side_2').val();
            const side_3 = $('#side_3').val();
            const image_file1 = document.getElementById('image_file1').files[0];
            const image_file2 = document.getElementById('image_file2').files[0];
            const image_file3 = document.getElementById('image_file3').files[0];
            const image_file4 = document.getElementById('image_file4').files[0];

            if (!side_1) {
                alert('กรอกข้อมูลผลการจัดการเรียนการสอน')
                $('#side_1').focus()
                return false;
            }
            if (!side_2) {
                alert('กรอกข้อมูลปัญหาและอุปสรรค')
                $('#side_2').focus()
                return false;
            }
            if (!side_3) {
                alert('กรอกข้อมูลข้อเสนอแนะ/แนวทางการแก้ไข')
                $('#side_3').focus()
                return false;
            }

            let formData = new FormData();

            formData.append('calendar_id', calendar_id);
            formData.append('side_1', side_1);
            formData.append('side_2', side_2);
            formData.append('side_3', side_3);
            formData.append('image_file1', image_file1);
            formData.append('image_file2', image_file2);
            formData.append('image_file3', image_file3);
            formData.append('image_file4', image_file4);
            // if (mode == 0) {

            // } else {
            //     formData.append('updateLearning', true);
            //     formData.append('learning_id', mode);
            //     formData.append('file_old', file_old);
            // }
            formData.append('insertLearning', true);

            $.ajax({
                type: "POST",
                url: "controllers/learning_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = "manage_calendar"
                    } else {
                        alert(json.msg);
                        window.location.reload();
                    }
                },
            });
        })
    </script>
</body>

</html>