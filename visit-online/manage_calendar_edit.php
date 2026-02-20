<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แก้ไขข้อมูลการพบกลุ่ม</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php include 'include/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT * FROM cl_calendar WHERE calendar_id = :calendar_id";
                $data = $DB->Query($sql, ['calendar_id' => $_GET['calendar_id']]);
                $data = json_decode($data);
                if (count($data) == 0) {
                    echo '<script>location.href = "../404"</script>';
                }

                $sql = "SELECT * FROM cl_work WHERE calendar_id = :calendar_id";
                $data_work = $DB->Query($sql, ['calendar_id' => $_GET['calendar_id']]);
                $data_work = json_decode($data_work);

                $sql_other = "SELECT * FROM cl_other_file WHERE calendar_id = :calendar_id";
                $data_other = $DB->Query($sql_other, ['calendar_id' => $_GET['calendar_id']]);
                $data_other = json_decode($data_other);

                $data = $data[0];
                ?>
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">

                    <div class="row" id="row_form">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_calendar'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar-check-o mr-15"></i>
                                            <b>ฟอร์มแก้ไขข้อมูลการพบกลุ่ม</b>
                                        </h4>
                                    </div>
                                </div>

                                <form class="form" id="form-edit-calendar" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3 col-lg-2">
                                                <div class="form-group">
                                                    <label>เลือกระดับชั้น <b class="text-danger">*</b></label>
                                                    <select class="form-control select2" name="std_class" id="std_class" data-placeholder="เลือกระดับชั้น" autocomplete="off" style="width: 100%;">
                                                        <option value="ประถม" <?= ($data->std_class == 'ประถม') ? 'selected' : '' ?>>ประถม</option>
                                                        <option value="ม.ต้น" <?= ($data->std_class == 'ม.ต้น') ? 'selected' : '' ?>>ม.ต้น</option>
                                                        <option value="ม.ปลาย" <?= ($data->std_class == 'ม.ปลาย') ? 'selected' : '' ?>>ม.ปลาย</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>ครั้งที่ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="time_step" id="time_step" autocomplete="off" placeholder="กรอกครั้งที่" value="<?php echo $data->time_step; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ชื่อแผนการจัดการเรียนรู้ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="plan_name" id="plan_name" autocomplete="off" placeholder="กรอกชื่อแผนการจัดการเรียนรู้" value="<?php echo $data->plan_name; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>ไฟล์แผนการจัดการเรียนรู้</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="plan_file" name="plan_file" accept="application/pdf" onchange="setlabelFilename('plan_file')">
                                                        <label class="custom-file-label" for="plan_file" id="plan_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ลิงค์การสอน 1 </label>
                                                    <input type="text" class="form-control height-input" name="link" id="link" autocomplete="off" placeholder="กรอกลิงค์การสอน 1" value="<?php echo $data->link; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ลิงค์การสอน 2 </label>
                                                    <input type="text" class="form-control height-input" name="link2" id="link2" autocomplete="off" placeholder="กรอกลิงค์การสอน 2" value="<?php echo $data->link2; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ลิงค์การสอน 3 </label>
                                                    <input type="text" class="form-control height-input" name="link3" id="link3" autocomplete="off" placeholder="กรอกลิงค์การสอน 1" value="<?php echo $data->link3; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ลิงค์การสอน 4 </label>
                                                    <input type="text" class="form-control height-input" name="link4" id="link4" autocomplete="off" placeholder="กรอกลิงค์การสอน 2" value="<?php echo $data->link4; ?>">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row">
                                                    <?php
                                                    // if (count($data_work) > 0) {
                                                    for ($i = 0; $i < count($data_work); $i++) { ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>ใบงานที่ <?php echo $i + 1 ?></label>
                                                                <div class="custom-file work_file_old">
                                                                    <input type="hidden" class="work_file_old_name" value="<?php echo $data_work[$i]->file_name ?>">
                                                                    <input type="hidden" class="work_file_old_id" value="<?php echo $data_work[$i]->work_id ?>">
                                                                    <input type="file" class="form-control" id="work_file" name="work_file" accept="application/pdf">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }
                                                    // } else { 
                                                    ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>เพิ่มใบงานใหม่ (สามารถเลือกได้หลายไฟล์)</label>
                                                            <div class="custom-file">
                                                                <!-- <input type="file" class="custom-file-input" multiple id="work_file" name="work_file" accept="application/pdf" onchange="setlabelFilename('work_file')"> -->
                                                                <input type="file" class="form-control" multiple id="work_file_add" name="work_file_add" accept="application/pdf">
                                                                <!-- <label class="custom-file-label" for="work_file" id="work_file_label">เลือกไฟล์
                                                                     PDF เท่านั้น</label> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php //} 
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <?php
                                                    // if (count($data_other) > 0) {
                                                    for ($i = 0; $i < count($data_other); $i++) { ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>ไฟล์ที่เกี่ยวข้อง <?php echo $i + 1 ?></label>
                                                                <div class="custom-file other_file_old">
                                                                    <input type="hidden" class="other_file_old_name" value="<?php echo $data_other[$i]->file_name ?>">
                                                                    <input type="hidden" class="other_file_old_id" value="<?php echo $data_other[$i]->other_id ?>">
                                                                    <input type="file" class="form-control" id="other_file" name="other_file" accept="application/pdf">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }
                                                    // } else { 
                                                    ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>เพิ่มไฟล์ที่เกี่ยวข้องใหม่ (สามารถเลือกได้หลายไฟล์)</label>
                                                            <div class="custom-file">
                                                                <!-- <input type="file" class="custom-file-input" multiple id="work_file" name="work_file" accept="application/pdf" onchange="setlabelFilename('work_file')"> -->
                                                                <input type="file" class="form-control" multiple id="other_file_add" name="other_file_add" accept="application/pdf">
                                                                <!-- <label class="custom-file-label" for="work_file" id="work_file_label">เลือกไฟล์
                                                                     PDF เท่านั้น</label> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php //} 
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
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

        $('#form-edit-calendar').submit((e) => {
            e.preventDefault()
            let calendar_id = '<?php echo $_GET['calendar_id']; ?>';
            let plan_file_old = '<?php echo $data->plan_file; ?>';
            let work_file_name = []
            let other_file_name = []
            $('.work_file_old').each((index, ele) => {
                let div_cus = $(ele).children()
                work_file_name.push({
                    work_id: div_cus[1].value,
                    fileName_old: div_cus[0].value,
                    fileName: div_cus[2].files[0]
                })
            })

            $('.other_file_old').each((index, ele) => {
                let div_cus = $(ele).children()
                other_file_name.push({
                    other_id: div_cus[1].value,
                    fileName_old: div_cus[0].value,
                    fileName: div_cus[2].files[0]
                })
            })


            if (!validateFormAddCalendar(calendar_id, plan_file_old, work_file_name, other_file_name)) {
                return;
            }

            $.ajax({
                type: "POST",
                url: "controllers/calendar_controller",
                data: validateFormAddCalendar(calendar_id, plan_file_old, work_file_name, other_file_name),
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    console.log(json);
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_calendar';
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