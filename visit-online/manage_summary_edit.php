<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-แก้ไขรายงานการดำเนินการ</title>
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
                $sql = "SELECT * FROM cl_report \n" .
                    "WHERE report_id = :report_id";
                $data = $DB->Query($sql, ['report_id' => $_GET['report_id']]);
                $data = json_decode($data);
                if (count($data) == 0) {
                    echo '<script>location.href = "404"</script>';
                }
                $data_report = $data[0];
                ?>
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_summary'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-agenda mr-15"></i> <b>ฟอร์มแก้ไขรายงานการดำเนินการ</b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form-edit-learning">
                                    <div class="box-body">
                                        <input type="hidden" name="calendar_id" id="calendar_id" value="1">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><b>เรื่องรายงาน <span class="text-danger">*</span></b></label>
                                                    <input type="text" class="form-control height-input" name="report_name" id="report_name" value="<?php echo $data_report->report_name; ?>" autocomplete="off" placeholder="กรอกเรื่องรายงาน">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><b>เนื้อหารายงาน <span class="text-danger">*</span></b></label>
                                                    <textarea rows="5" class="form-control" placeholder="กรอกเนื้อหา" name="report_detail" id="report_detail"><?php echo $data_report->report_detail; ?></textarea>
                                                </div>
                                            </div>
                                            <br>
                                            <label class="ml-2  mt-3"><b>ใส่รูปภาพประกอบการดำเนินงาน <span class="text-danger">( png, jpg, jpeg, gif )</span></b></label>
                                            <div class="col-md-12 row">
                                                <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file1')">
                                                    <img class="card-img-top" src="<?php echo $data_report->img_1 != "" ? 'uploads/report_img/' . $data_report->img_1 : 'images/no-image.jpg' ?>" alt="card image cap" id="preview_image_file1">
                                                    <input type="file" value="<?php echo $data_report->img_1 ?>" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file1" name="image_file1" style="display: none;" onchange="changeInputFile('image_file1')">
                                                </div>
                                                <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file2')">
                                                    <img class="card-img-top" src="<?php echo $data_report->img_2 != "" ? 'uploads/report_img/' . $data_report->img_2 : 'images/no-image.jpg' ?>" alt="card image cap" id="preview_image_file2">
                                                    <input type="file" value="<?php echo $data_report->img_2 ?>" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file2" name="image_file2" style="display: none;" onchange="changeInputFile('image_file2')">
                                                </div>
                                                <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file3')">
                                                    <img class="card-img-top" src="<?php echo $data_report->img_3 != "" ? 'uploads/report_img/' . $data_report->img_3 : 'images/no-image.jpg' ?>" alt="card image cap" id="preview_image_file3">
                                                    <input type="file" value="<?php echo $data_report->img_3 ?>" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file3" name="image_file3" style="display: none;" onchange="changeInputFile('image_file3')">
                                                </div>
                                                <div class="card col-md-2 p-0 m-3 img-hover" onclick="triggerFileInput('image_file4')">
                                                    <img class="card-img-top" src="<?php echo $data_report->img_4 != "" ? 'uploads/report_img/' . $data_report->img_4 : 'images/no-image.jpg' ?>" alt="card image cap" id="preview_image_file4">
                                                    <input type="file" value="<?php echo $data_report->img_4 ?>" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_file4" name="image_file4" style="display: none;" onchange="changeInputFile('image_file4')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                            <i class="ti-save-alt"></i> แก้ไขข้อมูล
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

        $('#form-edit-learning').submit((e) => {
            e.preventDefault()
            // if (!validateDataLearning(learning_id)) {
            //     return;
            // }
            let report_id = '<?php echo $_GET['report_id'] ?>';
            const report_name = $('#report_name').val();
            const report_detail = $('#report_detail').val();

            const image_file1_old = '<?php echo $data_report->img_1 ?>';
            const image_file2_old = '<?php echo $data_report->img_2 ?>';
            const image_file3_old = '<?php echo $data_report->img_3 ?>';
            const image_file4_old = '<?php echo $data_report->img_4 ?>';

            const image_file1 = document.getElementById('image_file1').files[0];
            const image_file2 = document.getElementById('image_file2').files[0];
            const image_file3 = document.getElementById('image_file3').files[0];
            const image_file4 = document.getElementById('image_file4').files[0];

            if (!report_name) {
                alert('กรอกเรื่องรายงาน')
                $('#report_name').focus()
                return false;
            }
            if (!report_detail) {
                alert('กรอกเนื้อหารายงาน')
                $('#report_detail').focus()
                return false;
            }
            let formData = new FormData();
            formData.append('report_name', report_name);
            formData.append('report_detail', report_detail);

            formData.append('image_file1_old', image_file1_old);
            formData.append('image_file2_old', image_file2_old);
            formData.append('image_file3_old', image_file3_old);
            formData.append('image_file4_old', image_file4_old);

            formData.append('image_file1', image_file1);
            formData.append('image_file2', image_file2);
            formData.append('image_file3', image_file3);
            formData.append('image_file4', image_file4);

            formData.append('updateReport', true);
            formData.append('report_id', report_id);
            $.ajax({
                type: "POST",
                url: "controllers/report_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    alert(json.msg);
                    window.location.href = 'manage_summary';
                },
            });
        })
    </script>
</body>

</html>