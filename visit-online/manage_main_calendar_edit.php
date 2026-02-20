<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แก้ไขปฎิทินการพบกลุ่ม</title>
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
                <?php
                include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT * FROM cl_main_calendar WHERE m_calendar_id = :m_calendar_id";
                $data = $DB->Query($sql, ["m_calendar_id" => $_GET['m_calendar_id']]);
                $data = json_decode($data);
                if (count($data) == 0) {
                    echo "<script>location.href = '../404'</script>";
                }
                $data = $data[0];
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_main_calendar'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar mr-15"></i> <b>แก้ไขปฎิทินการพบกลุ่ม</b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form-add-main-calendar">
                                    <div class=" box-body">
                                        <div class="row">
                                            <!-- <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>ครั้งที่พบกลุ่ม <span class="text-danger">*</span></b></label>
                                                    <input type="number" name="time" id="time" class="form-control" placeholder="กรอกครั้ง เช่น 1" value="<?php echo $data->time ?>">
                                                </div>
                                            </div> -->
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>ภาคเรียน <span class="text-danger">*</span></b></label>
                                                    <input type="number" name="term" id="term" class="form-control" placeholder="กรอกภาคเรียน" value="<?php echo $data->term ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>ปีการศึกษา <span class="text-danger">*</span></b></label>
                                                    <input type="number" name="year" id="year" class="form-control" placeholder="กรอกปีการศึกษา" value="<?php echo $data->year ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>เลือกระดับชั้น <span class="text-danger">*</span></b></label>
                                                    <select class="form-control select2" name="std_class" id="std_class" data-placeholder="เลือกระดับชั้น" autocomplete="off" style="width: 100%;">
                                                        <option disabled selected value="">ยังไม่ได้เลือกระดับชั้น</option>
                                                        <option <?php echo $data->std_class == "ประถม" ? "selected" : ""; ?> value="ประถม">ประถม</option>
                                                        <option <?php echo $data->std_class == "ม.ต้น" ? "selected" : ""; ?> value="ม.ต้น">ม.ต้น</option>
                                                        <option <?php echo $data->std_class == "ม.ปลาย" ? "selected" : ""; ?> value="ม.ปลาย">ม.ปลาย</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><b>ชื่อปฎิทินการพบกลุ่ม</b></label>
                                                    <input type="text" class="form-control height-input" name="main_calendar_name" id="main_calendar_name" autocomplete="off" placeholder="กรอกชื่อปฎิทินการพบกลุ่ม" value="<?php echo $data->m_calendar_name ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><b>ไฟล์ปฎิทินการพบกลุ่ม</b></label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="main_calendar_file" name="main_calendar_file" accept="application/pdf" onchange="setlabelFilename('main_calendar_file')">
                                                        <label class="custom-file-label" for="main_calendar_file" id="main_calendar_file_label">เลือกไฟล์
                                                            PDF เท่านั้น</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                            <i class="ti-save-alt"></i> บันทึกปฎิทินการพบกลุ่ม
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
            const file = document.getElementById(id).files[0];
            document.getElementById(id + '_label').innerText = file.name;
        }

        $('#form-add-main-calendar').submit((e) => {
            e.preventDefault()
            let m_calendar_id = '<?php echo $_GET['m_calendar_id'] ?>';
            let m_calendar_file_old = '<?php echo $data->m_calendar_file ?>';

            const term = $('#term').val();
            const year = $('#year').val();
            const std_class = $('#std_class').val();
            const main_calendar_name = $('#main_calendar_name').val();
            const main_calendar_file = document.getElementById('main_calendar_file').files[0];
            // if (!time) {
            //     alert('โปรดกรอกครั้งที่')
            //     $('#time').focus()
            //     return false;
            // }
            if (!term) {
                alert('โปรดกรอกภาคเรียน')
                $('#term').focus()
                return false;
            }
            if (!year) {
                alert('โปรดกรอกปีการศึกษา')
                $('#year').focus()
                return false;
            }
            if (!std_class) {
                alert('โปรดเลือกระดับชั้น')
                $('#std_class').focus()
                return false;
            }

            let formData = new FormData();
            // formData.append('file', file);
            formData.append('main_calendar_file', main_calendar_file);
            formData.append('term', term);
            formData.append('year', year);
            formData.append('std_class', std_class);
            formData.append('time', 1);
            formData.append('main_calendar_name', main_calendar_name);
            //formData.append('insertMainCalendar', true);
            // if (mode == 0) {
            //     formData.append('insertMainCalendar', true);
            // } else {
            formData.append('editMainCalendar', true);
            formData.append('main_calendar_id', m_calendar_id);
            formData.append('main_calendar_file_old', m_calendar_file_old);
            // }
            $.ajax({
                type: "POST",
                url: "controllers/calendar_controller",
                data: formData, //validateFormAddMainCalendar(m_calendar_id, m_calendar_file_old),
                dataType: "json",
                processData: false,
                contentType: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = "manage_main_calendar"
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