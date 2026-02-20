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
    <title>เพิ่มข้อมูลการพบกลุ่ม </title>
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
                                            <b>ฟอร์มเพิ่มข้อมูลการพบกลุ่ม</b>
                                        </h4>
                                    </div>
                                </div>

                                <form class="form" id="form-add-calendar" enctype="multipart/form-data">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3 col-lg-2">
                                                <div class="form-group">
                                                    <label>เลือกระดับชั้น <b class="text-danger">*</b></label>
                                                    <select class="form-control select2" name="std_class" id="std_class" data-placeholder="เลือกระดับชั้น" <?php echo $isKru ? 'disabled' : '' ?> autocomplete="off" style="width: 100%;">
                                                        <?php if (!$isKru) { ?>
                                                            <option value="ประถม" selected>ประถม</option>
                                                            <option value="ม.ต้น">ม.ต้น</option>
                                                            <option value="ม.ปลาย">ม.ปลาย</option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $classSession ?>" selected><?php echo $classSession ?></option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>สี</label>
                                                    <input type="color" class="form-control" id="color" name="color" value="" style="height: 34px;">
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>ครั้งที่ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="time_step" id="time_step" autocomplete="off" placeholder="กรอกครั้งที่">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>ชื่อแผนการจัดการเรียนรู้ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="plan_name" id="plan_name" autocomplete="off" placeholder="กรอกชื่อแผนการจัดการเรียนรู้">
                                                </div>
                                            </div>
                                            <div class="col-md-5" <?php echo ($isKru) ? '' : 'style="display: none;"' ?>>
                                                <div class="form-group">
                                                    <label>ไฟล์แผนการสอนรายครั้ง</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="plan_file" name="plan_file" accept="application/pdf" onchange="setlabelFilename('plan_file')">
                                                        <label class="custom-file-label" for="plan_file" id="plan_file_label">เลือกไฟล์ PDF เท่านั้น</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>แบบทดสอบก่อนเรียน (ลิงค์) <b class="text-danger"></b></label>
                                                    <input type="text" class="form-control height-input" name="test_before_link" id="test_before_link" autocomplete="off" placeholder="กรอกแบบทดสอบก่อนเรียน (ลิงค์)">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>แบบทดสอบหลังเรียน (ลิงค์) <b class="text-danger"></b></label>
                                                    <input type="text" class="form-control height-input" name="test_after_link" id="test_after_link" autocomplete="off" placeholder="กรอกแบบทดสอบหลังเรียน (ลิงค์)">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>เนื้อหา (ลิงค์) <b class="text-danger"></b></label>
                                                    <input type="text" class="form-control height-input" name="content_link" id="content_link" autocomplete="off" placeholder="กรอกเนื้อหา (ลิงค์)">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>เนื้อหา (PDF)</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="content_file" name="content_file" accept="application/pdf" onchange="setlabelFilename('content_file')">
                                                        <label class="custom-file-label" for="content_file" id="content_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ใบงาน (ลิงค์)</label>
                                                    <!-- <textarea rows="5" class="form-control" id="work_sheet" name="work_sheet" placeholder="ตัวอย่างกรณีมีหลายลิงค์ www.example.com, www.example2.com"></textarea> -->
                                                    <input type="text" class="form-control height-input" name="work_sheet" id="work_sheet" autocomplete="off" placeholder="กรอกใบงาน (ลิงค์)">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ใบงาน (สามารถเลือกได้หลายไฟล์)</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" multiple id="work_file" name="work_file" accept="application/pdf" onchange="setlabelFilename('work_file')">
                                                        <label class="custom-file-label" style="overflow: hidden;" for="work_file" id="work_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline" id="btn-save">
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
        $('#form-add-calendar').submit((e) => {
            e.preventDefault();

            if (!validateFormAddCalendarNew()) {
                return;
            }

            $('#btn-save').attr('disabled', 'disabled');

            $.ajax({
                type: "POST",
                url: "controllers/calendar_new_controller",
                data: validateFormAddCalendarNew(),
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    $('#btn-save').removeAttr('disabled');
                    alert(json.msg);
                    if (json.status) {
                        <?php if ($isKru) { ?>
                            window.location.href = 'manage_calendar?class=<?php echo $_SESSION['manage_calendar_class'] ?>';
                        <?php } else { ?>
                            window.location.href = 'manage_calendar_new_am';
                        <?php } ?>

                    } else {
                        window.location.reload();
                    }
                },
            });
        })
    </script>
</body>

</html>