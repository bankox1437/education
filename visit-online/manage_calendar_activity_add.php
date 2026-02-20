<?php
date_default_timezone_set('Asia/Bangkok');
include 'include/check_login.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-เพิ่มข้อมูลปฎิทินกิจกรรม </title>
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

        .ui-timepicker-wrapper {
            width: 12% !important;
        }
    </style>
    <!-- Include Flatpickr library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_calendar_activity'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-calendar mr-15"></i>
                                            <b>ฟอร์มเพิ่มข้อมูลปฏิทินกิจกรรมสถานศึกษา</b>
                                        </h4>
                                    </div>
                                </div>

                                <div class="form"  enctype="multipart/form-data">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6    ">
                                                <div class="form-group">
                                                    <label>วันที่ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="datetime" id="datetime" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ชื่อกิจกรรม <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="activity_name" id="activity_name" autocomplete="off" placeholder="กรอกชื่อกิจกรรม">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ผู้รับผิดชอบ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="take_response" id="take_response" autocomplete="off" placeholder="กรอกผู้รับผิดชอบ">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ไฟล์รายงานผล</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="activity_file" name="activity_file" accept="application/pdf" onchange="setlabelFilename('activity_file')">
                                                        <label class="custom-file-label" for="activity_file" id="activity_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea type="text" class="form-control height-input" rows="4" name="note" id="note" autocomplete="off" placeholder="กรอกหมายเหตุ"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="box-footer">
                                        <button type="button" class="btn btn-rounded btn-primary btn-outline" id="form-add-calendar-activity">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                    </div>
                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>
    <script>
        $(document).ready(function() {

            flatpickr("#datetime", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                defaultDate: new Date(),
                time_24hr: true,
                locale: "th",
            });

            setTimeout(() => {
                $("#datetime").removeAttr('readonly');
            }, 500);
        });

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
        $('#form-add-calendar-activity').click((e) => {
            e.preventDefault();
            const dateTime = $('#datetime').val();
            const activity_name = $('#activity_name').val();
            const take_response = $('#take_response').val();
            const note = $('#note').val();
            const activity_file = document.getElementById('activity_file').files[0];

            if (!dateTime) {
                alert('โปรดกรอกข้อมูลวันที่')
                $('#datetime').focus()
                return false;
            }

            if (!activity_name) {
                alert('โปรดกรอกข้อมูลชื่อกิจกรรม')
                $('#activity_name').focus()
                return false;
            }

            if (!take_response) {
                alert('โปรดกรอกข้อมูลผู้รับผิดชอบ')
                $('#take_response').focus()
                return false;
            }

            // if (!activity_file) {
            //     alert('โปรดเลือกไฟล์รายงาน')
            //     $('#activity_file').focus()
            //     return false;
            // }

            // if (!dateTime) {
            //     alert('โปรดกรอกวันที่')
            //     $('#datetime').focus()
            //     return false;
            // }

            let formData = new FormData();
            formData.append('dateTime', dateTime);
            formData.append('activity_name', activity_name);
            formData.append('take_response', take_response);
            formData.append('activity_file', activity_file);
            formData.append('dateTime', dateTime);
            formData.append('note', note);
            formData.append('insertCalendarActivity', true);

            $.ajax({
                type: "POST",
                url: "controllers/activity_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    console.log(json);
                    alert(json.msg);
                    if (json.status) {
                        window.location.href = 'manage_calendar_activity';
                    }
                },
            });
        })
    </script>
</body>

</html>