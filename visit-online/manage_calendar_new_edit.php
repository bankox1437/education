<?php include 'include/check_login.php';

$classSession = "";
if ($_SESSION['manage_calendar_class'] == "1") {
    $classSession = "ประถม";
}
if ($_SESSION['manage_calendar_class'] == "2") {
    $classSession = "ม.ต้น";
}
if ($_SESSION['manage_calendar_class'] == "3") {
    $classSession = "ม.ปลาย";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แก้ไขข้อมูลการพบกลุ่ม </title>
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
        <?php
        $styleNone = "style='margin: 0px;'";
        $isKru = ($_SESSION['user_data']->role_id == 3);
        if ($isKru) {
            include 'include/sidebar.php';
            $styleNone = "";
        } ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" <?php echo $styleNone ?>>
            <div class="container-full">

                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $table = "cl_calendar_new";
                $table2 = "cl_work_new";
                if (!$isKru) {
                    $table = "cl_calendar_new_am";
                    $table2 = "cl_work_new_am";
                }
                $sql = "SELECT * FROM $table WHERE calendar_id = :calendar_id";
                $data = $DB->Query($sql, ['calendar_id' => $_GET['calendar_id']]);
                $data = json_decode($data);
                if (count($data) == 0) {
                    // echo '<script>location.href = "../404"</script>';
                }

                $sql = "SELECT * FROM $table2 WHERE calendar_id = :calendar_id";
                $data_work = $DB->Query($sql, ['calendar_id' => $_GET['calendar_id']]);
                $data_work = json_decode($data_work);

                $data = $data[0];
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;">
                                            <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='<?php echo $isKru ? 'manage_calendar' : 'manage_calendar_new_am' ?>'"></i>
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
                                                    <select class="form-control select2" name="std_class" id="std_class" disabled data-placeholder="เลือกระดับชั้น" autocomplete="off" style="width: 100%;">
                                                        <option value="ประถม" <?= ($data->std_class == 'ประถม') ? 'selected' : '' ?>>ประถม</option>
                                                        <option value="ม.ต้น" <?= ($data->std_class == 'ม.ต้น') ? 'selected' : '' ?>>ม.ต้น</option>
                                                        <option value="ม.ปลาย" <?= ($data->std_class == 'ม.ปลาย') ? 'selected' : '' ?>>ม.ปลาย</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>สี</label>
                                                    <input type="color" class="form-control" id="color" name="color" value="<?php echo $data->color; ?>" style="height: 34px;">
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>ครั้งที่ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="time_step" id="time_step" autocomplete="off" placeholder="กรอกครั้งที่" value="<?php echo $data->time_step; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>ชื่อแผนการจัดการเรียนรู้ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="plan_name" id="plan_name" autocomplete="off" placeholder="กรอกชื่อแผนการจัดการเรียนรู้" value="<?php echo $data->plan_name; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-5" <?php echo ($isKru) ? '' : 'style="display: none;"' ?>>
                                                <div class="form-group">
                                                    <label>ไฟล์แผนการสอนรายครั้ง</label>
                                                    <div class="custom-file">
                                                        <input type="hidden" id="plan_file_old" name="plan_file_old" value="<?php echo $data->plan_file; ?>">
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
                                                    <label>แบบทดสอบก่อนเรียน (ลิงค์) <b class="text-danger"></b></label>
                                                    <input type="text" class="form-control height-input" name="test_before_link" id="test_before_link" autocomplete="off" placeholder="กรอกแบบทดสอบก่อนเรียน (ลิงค์)" value="<?php echo $data->test_before_link; ?>">
                                                </div>
                                            </div>
                                            <div class=" col-md-6">
                                                <div class="form-group">
                                                    <label>แบบทดสอบหลังเรียน (ลิงค์) <b class="text-danger"></b></label>
                                                    <input type="text" class="form-control height-input" name="test_after_link" id="test_after_link" autocomplete="off" placeholder="กรอกแบบทดสอบหลังเรียน (ลิงค์)" value="<?php echo $data->test_after_link; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>เนื้อหา (ลิงค์) <b class="text-danger"></b></label>
                                                    <input type="text" class="form-control height-input" name="content_link" id="content_link" autocomplete="off" placeholder="กรอกเนื้อหา (ลิงค์)" value="<?php echo $data->content_link; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>เนื้อหา (PDF)</label>
                                                    <div class="custom-file">
                                                        <input type="hidden" id="content_file_old_name" name="content_file_old_name" value="<?php echo $data->content_file; ?>">
                                                        <input type="file" class="custom-file-input" id="content_file" name="content_file" accept="application/pdf" onchange="setlabelFilename('content_file')">
                                                        <label class="custom-file-label" for="content_file" id="content_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ใบงาน (ลิงค์)</label>
                                                    <!-- <textarea rows="5" class="form-control" id="work_sheet" name="work_sheet" placeholder="ตัวอย่างกรณีมีหลายลิงค์ www.example.com, www.example2.com"><?php echo $data->work_sheet; ?></textarea> -->
                                                    <input type="text" class="form-control height-input" name="work_sheet" id="work_sheet" autocomplete="off" placeholder="กรอกใบงาน (ลิงค์)" value="<?php echo $data->work_sheet; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <?php
                                                // if (count($data_work) > 0) {
                                                for ($i = 0; $i < count($data_work); $i++) { ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>ใบงานที่ <?php echo $i + 1 ?> <i class="ti-trash text-danger" onclick="removeWork(<?php echo $data_work[$i]->work_id ?>,'<?php echo $data_work[$i]->file_name ?>')" style="cursor: pointer;"></i></label>
                                                            <div class="custom-file work_file_old">
                                                                <input type="hidden" class="work_file_old_name" value="<?php echo $data_work[$i]->file_name ?>">
                                                                <input type="hidden" class="work_file_old_id" value="<?php echo $data_work[$i]->work_id ?>">
                                                                <input type="file" class="custom-file-input" id="work_file<?php echo $data_work[$i]->work_id ?>" name="work_file<?php echo $data_work[$i]->work_id ?>" accept="application/pdf" onchange="setlabelFilename('work_file<?php echo $data_work[$i]->work_id ?>')">
                                                                <label class="custom-file-label" for="work_file<?php echo $data_work[$i]->work_id ?>" id="work_file<?php echo $data_work[$i]->work_id ?>_label">แก้ไขไฟล์ เลือกไฟล์ PDF เท่านั้น</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }
                                                // } else { 
                                                ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>ใบงาน (สามารถเลือกได้หลายไฟล์)</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" multiple id="work_file_add" name="work_file_add" accept="application/pdf" onchange="setlabelFilename('work_file_add')">
                                                            <label class="custom-file-label" style="overflow: hidden;" for="work_file_add" id="work_file_add_label">เลือกไฟล์
                                                                PDF เท่านั้น</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php //} 
                                                ?>
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
            if (fileName == '') {
                fileName = 'เลือกไฟล์ PDF เท่านั้น';
            }
            document.getElementById(id + '_label').innerText = fileName;
        }
        $('#form-edit-calendar').submit((e) => {
            e.preventDefault();

            let calendar_id = '<?php echo $_GET['calendar_id']; ?>';

            let work_file_name = []
            $('.work_file_old').each((index, ele) => {
                let div_cus = $(ele).children()
                work_file_name.push({
                    work_id: div_cus[1].value,
                    fileName_old: div_cus[0].value,
                    fileName: div_cus[2].files[0]
                })
            })

            if (!validateFormAddCalendarNew(calendar_id, work_file_name)) {
                return;
            }

            $.ajax({
                type: "POST",
                url: "controllers/calendar_new_controller",
                data: validateFormAddCalendarNew(calendar_id, work_file_name),
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    console.log(json);
                    if (json.status) {
                        alert(json.msg);
                        <?php if ($isKru) { ?>
                            window.location.href = 'manage_calendar?class=<?php echo $_SESSION['manage_calendar_class'] ?>';
                        <?php } else { ?>
                            window.location.href = 'manage_calendar_new_am';
                        <?php } ?>
                    } else {
                        alert(json.msg);
                        if(json.reload) {
                            window.location.reload();
                        }
                    }
                },
            });
        })

        function removeWork(work_id, work_name) {
            if (confirm('คุณต้องการลบใบงานนี้หรือไม่?')) {
                $.ajax({
                    type: "POST",
                    url: "controllers/calendar_new_controller",
                    data: {
                        removeWork: true,
                        work_id: work_id,
                        work_name: work_name
                    },
                    dataType: "json",
                    success: async function(json) {
                        alert(json.msg);
                        window.location.reload();
                    },
                });
            }
        }
    </script>
</body>

</html>