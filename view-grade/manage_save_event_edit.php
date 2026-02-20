<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_std.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แก้ไขสรุปการเรียน</title>
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">
                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT se.*,std.std_id,std.std_prename,std.std_name FROM vg_save_event se \n" .
                    "LEFT JOIN vg_terms term ON se.term_id = term.term_id\n" .
                    "LEFT JOIN tb_students std ON se.std_id = std.std_id\n" .
                    "WHERE se.event_id = :event_id";
                $data = $DB->Query($sql, ['event_id' => $_GET['event_id']]);
                $event_data = json_decode($data);
                if (count($event_data) == 0) {
                    echo '<script>location.href = "404"</script>';
                }
                $data_event = $event_data[0];
                ?>
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_save_event'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-book mr-15"></i>
                                            <b>ฟอร์มแก้ไขสรุปการเรียน
                                                <?php if ($_SESSION['user_data']->role_id == 3) {
                                                    echo $data_event->std_prename; ?>
                                                <?php echo $data_event->std_name;
                                                } ?>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form-edit-save-event" enctype="multipart/form-data">
                                    <input type="hidden" name="editEvent">
                                    <input type="hidden" name="event_id" id="event_id" value="<?php echo $data_event->event_id; ?>">
                                    <div class="box-body">
                                        <div class="row justify-content-center">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label>หัวข้อ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="event_name" id="event_name" value="<?php echo $data_event->event_name; ?>" autocomplete="off" placeholder="กรอกหัวข้อ">
                                                    <input type="hidden" name="insertEvent">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-2 justify-content-center">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label><b>รายละเอียด <span class="text-danger">*</span></b></label>
                                                    <textarea rows="5" class="form-control" placeholder="กรอกรายละเอียด" name="event_detail" id="event_detail"><?php echo $data_event->event_detail; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <!-- <label class="ml-2 mt-3 col-md-12 row justify-content-center"><b>ต้องแนบรูปภาพประกอบ 2-4 รูป <span class="text-danger">( png, jpg, jpeg, gif )</span></b></label> -->
                                            <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file1')">
                                                <img class="card-img-top" src="<?php echo $data_event->img_event_1 != "" ? 'uploads/save_event/' . $data_event->img_event_1 : 'images/no-image.jpg' ?>" alt="card image cap" id="preview_image_file1">
                                                <input type="file" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file1" name="image_file1" style="display: none;" onchange="changeInputFile('image_file1')">
                                            </div>
                                            <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file2')">
                                                <img class="card-img-top" src="<?php echo $data_event->img_event_2 != "" ? 'uploads/save_event/' . $data_event->img_event_2 : 'images/no-image.jpg' ?>" alt="card image cap" id="preview_image_file2">
                                                <input type="file" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file2" name="image_file2" style="display: none;" onchange="changeInputFile('image_file2')">
                                            </div>
                                            <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file3')">
                                                <img class="card-img-top" src="<?php echo $data_event->img_event_3 != "" ? 'uploads/save_event/' . $data_event->img_event_3 : 'images/no-image.jpg' ?>" alt="card image cap" id="preview_image_file3">
                                                <input type="file" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file3" name="image_file3" style="display: none;" onchange="changeInputFile('image_file3')">
                                            </div>
                                            <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file4')">
                                                <img class="card-img-top" src="<?php echo $data_event->img_event_4 != "" ? 'uploads/save_event/' . $data_event->img_event_4 : 'images/no-image.jpg' ?>" alt="card image cap" id="preview_image_file4">
                                                <input type="file" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file4" name="image_file4" style="display: none;" onchange="changeInputFile('image_file4')">
                                            </div>
                                        </div>
                                        <div class="col-md-12 row justify-content-center">
                                            <button type="submit" class="btn btn-rounded btn-primary btn-outline mt-4">
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

        $('#form-edit-save-event').submit((e) => {
            e.preventDefault()
            const event_id = $('#event_id').val();
            const event_name = $('#event_name').val();
            const event_detail = $('#event_detail').val();

            const image_file1 = document.getElementById('image_file1').files[0];
            const image_file2 = document.getElementById('image_file2').files[0];
            const image_file3 = document.getElementById('image_file3').files[0];
            const image_file4 = document.getElementById('image_file4').files[0];

            const image_file1_old = '<?php echo $data_event->img_event_1 ?>';
            const image_file2_old = '<?php echo $data_event->img_event_2 ?>';
            const image_file3_old = '<?php echo $data_event->img_event_3 ?>';
            const image_file4_old = '<?php echo $data_event->img_event_4 ?>';
            if (!event_name) {
                alert('กรอกหัวข้อกิจกรรม')
                $('#event_name').focus()
                return false;
            }
            if (!event_detail) {
                alert('กรอกรายละเอียดกิจกรรม')
                $('#event_detail').focus()
                return false;
            }
            let formData = new FormData();

            formData.append('event_id', event_id);
            formData.append('event_name', event_name);
            formData.append('event_detail', event_detail);

            formData.append('image_file1_old', image_file1_old);
            formData.append('image_file2_old', image_file2_old);
            formData.append('image_file3_old', image_file3_old);
            formData.append('image_file4_old', image_file4_old);

            formData.append('image_file1', image_file1);
            formData.append('image_file2', image_file2);
            formData.append('image_file3', image_file3);
            formData.append('image_file4', image_file4);
            formData.append('editEvent', true);

            $.ajax({
                type: "POST",
                url: "controllers/save_event_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = "manage_save_event"
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