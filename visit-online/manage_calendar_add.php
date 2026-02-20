<?php include 'include/check_login.php'; ?>
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
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_calendar'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar-check-o mr-15"></i>
                                            <b>ฟอร์มเพิ่มข้อมูลการพบกลุ่ม</b>
                                        </h4>
                                    </div>
                                </div>

                                <form class="form" id="form-add-calendar" enctype="multipart/form-data">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <!-- <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ครั้งที่ <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="time" id="time" autocomplete="off" placeholder="กรอกครั้งเช่น 1">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ภาคเรียน <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="term" id="term" autocomplete="off" placeholder="กรอกภาคเรียน">
                                                    <input type="hidden" name="insertCalendar">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ปีการศึกษา <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="year" id="year" autocomplete="off" placeholder="กรอกปีการศึกษา">
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ชื่อปฎิทินการพบกลุ่ม <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="calendar_name" id="calendar_name" autocomplete="off" placeholder="กรอกชื่อปฎิทินการพบกลุ่ม">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ไฟล์ปฎิทินการพบกลุ่ม <b class="text-danger">*</b></label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="calendar_file" name="calendar_file" accept="application/pdf" onchange="setlabelFilename('calendar_file')">
                                                        <label class="custom-file-label" for="calendar_file" id="calendar_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-md-3 col-lg-2">
                                                <div class="form-group">
                                                     <label>เลือกระดับชั้น <b class="text-danger">*</b></label>
                                                        <select class="form-control select2" name="std_class" id="std_class" data-placeholder="เลือกระดับชั้น" autocomplete="off" style="width: 100%;">
                                                            <option value="ประถม">ประถม</option>
                                                            <option value="ม.ต้น">ม.ต้น</option>
                                                            <option value="ม.ปลาย">ม.ปลาย</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>ครั้งที่ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="time_step" id="time_step" autocomplete="off" placeholder="กรอกครั้งที่">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ชื่อแผนการจัดการเรียนรู้ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="plan_name" id="plan_name" autocomplete="off" placeholder="กรอกชื่อแผนการจัดการเรียนรู้">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>ไฟล์แผนการจัดการเรียนรู้ <b class="text-danger">*</b></label>
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
                                                    <label>ลิงค์การสอน 1 <b class="text-danger"></b></label>
                                                    <input type="text" class="form-control height-input" name="link" id="link" autocomplete="off" placeholder="กรอกลิงค์การสอน 1">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ลิงค์การสอน 2 <b class="text-danger"></b></label>
                                                    <input type="text" class="form-control height-input" name="link2" id="link2" autocomplete="off" placeholder="กรอกลิงค์การสอน 2">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ลิงค์การสอน 3 <b class="text-danger"></b></label>
                                                    <input type="text" class="form-control height-input" name="link3" id="link3" autocomplete="off" placeholder="กรอกลิงค์การสอน 3">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ลิงค์การสอน 4 <b class="text-danger"></b></label>
                                                    <input type="text" class="form-control height-input" name="link4" id="link4" autocomplete="off" placeholder="กรอกลิงค์การสอน 4">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ใบงาน (สามารถเลือกได้หลายไฟล์)</label>
                                                    <div class="custom-file">
                                                        <!-- <input type="file" class="custom-file-input" multiple id="work_file" name="work_file" accept="application/pdf" onchange="setlabelFilename('work_file')"> -->
                                                        <input type="file" class="form-control" multiple id="work_file" name="work_file" accept="application/pdf">
                                                        <!-- <label class="custom-file-label" for="work_file" id="work_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label> -->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ไฟล์ที่เกี่ยวข้อง (สามารถเลือกได้หลายไฟล์)</label>
                                                    <div class="custom-file">
                                                        <!-- <input type="file" class="custom-file-input" multiple id="work_file" name="work_file" accept="application/pdf" onchange="setlabelFilename('work_file')"> -->
                                                        <input type="file" class="form-control" multiple id="other_file" name="other_file" accept="application/pdf">
                                                        <!-- <label class="custom-file-label" for="work_file" id="work_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label> -->
                                                    </div>
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
        $('#form-add-calendar').submit((e) => {
            e.preventDefault();
            console.log($('#std_class').val());
            if (!validateFormAddCalendar()) {
                return;
            }
            $.ajax({
                type: "POST",
                url: "controllers/calendar_controller",
                data: validateFormAddCalendar(),
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
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