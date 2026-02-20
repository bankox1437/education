<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มแก้ไขแบบทดสอบ </title>
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

        .form-border {
            border: 1px solid #E5E5E5;
            border-radius: 10px;
            padding: 10px;
            position: relative;
        }

        .form-border-close {
            position: absolute;
            right: 10px;
            color: red;
            cursor: pointer;
            z-index: 99;
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
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_testing'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-pencil mr-15"></i>
                                            <b>ฟอร์มแก้ไขแบบทดสอบ</b>
                                        </h4>
                                    </div>
                                </div>

                                <form class="form" id="form-edit-testing">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <?php include "../config/class_database.php";
                                        $DB = new Class_Database();
                                        $sql = "SELECT * FROM cl_testing\n" .
                                            "WHERE testing_id = :testing_id";
                                        $data = $DB->Query($sql, ['testing_id' => $_GET['testing_id']]);
                                        $data = json_decode($data);
                                        if (count($data) == 0) {
                                            echo '<script>location.href = "../404"</script>';
                                        }
                                        $data_testing = $data[0];
                                        ?>
                                        <input type="hidden" name="testing_id" id="testing_id" class="form-control" placeholder="กรอกภาคเรียน" value="<?php echo $data_testing->testing_id ?>">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>ภาคเรียน <span class="text-danger">*</span></b></label>
                                                    <input type="number" name="term" id="term" class="form-control" placeholder="กรอกภาคเรียน" value="<?php echo $data_testing->term ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>ปีการศึกษา <span class="text-danger">*</span></b></label>
                                                    <input type="number" name="year" id="year" class="form-control" placeholder="กรอกปีการศึกษา" value="<?php echo $data_testing->year ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label><b>เลือกระดับชั้น <span class="text-danger">*</span></b></label>
                                                <select class="form-control" name="std_class" id="std_class">
                                                    <option value="">ยังไม่ระบุชั้น &nbsp;&nbsp;</option>
                                                    <option value="ประถม" <?php echo $data_testing->std_class == "ประถม" ? "selected" : "" ?>>ประถม</option>
                                                    <option value="ม.ต้น" <?php echo $data_testing->std_class == "ม.ต้น" ? "selected" : "" ?>>ม.ต้น</option>
                                                    <option value="ม.ปลาย" <?php echo $data_testing->std_class == "ม.ปลาย" ? "selected" : "" ?>>ม.ปลาย</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="box_form">
                                            <div class="row">
                                                <div class="col-md-6 form-border">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>ชื่อแบบทดสอบวิชา <b class="text-danger">*</b></label>
                                                                <input type="text" class="form-control height-input require" name="test_name1" id="test_name1" autocomplete="off" placeholder="กรอกชื่อแบบทดสอบวิชา" value="<?php echo $data_testing->test_name ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>ลิงค์แบบทดสอบ<b class="text-danger">*</b></label>
                                                                <input type="text" class="form-control height-input require" name="link1" id="link1" autocomplete="off" placeholder="กรอกลิงค์แบบทดสอบ" value="<?php echo $data_testing->link ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>คำอธิบาย</label>
                                                                <textarea rows="5" class="form-control height-input" name="desc1" id="desc1" autocomplete="off" placeholder="กรอกคำอธิบาย"><?php echo $data_testing->description ?></textarea>
                                                            </div>
                                                        </div>
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
        function validateForm() {
            let firstErrorInput = null;
            $('#box_form .require').each(function() {
                $(this).css('border', '');
                const inputValue = $(this).val().trim();
                if (inputValue === '') {
                    if (!firstErrorInput) {
                        firstErrorInput = this;
                    }

                    $(this).css('border', '1px solid red');
                }
            });

            if (firstErrorInput) {
                $(firstErrorInput).focus();
                return false;
            }

            // If no error, allow form submission
            return true;
        }

        $('#form-edit-testing').submit((e) => {
            e.preventDefault();
            const term = $('#term').val();
            const year = $('#year').val();
            const std_class = $('#std_class').val();
            const testing_id = $('#testing_id').val();
            if (!term) {
                $('#term').focus();
                $('#term').css('border', '1px solid red');
                return;
            }
            if (!year) {
                $('#year').focus();
                $('#year').css('border', '1px solid red');
                return;
            }
            if (!std_class) {
                $('#std_class').focus();
                $('#std_class').css('border', '1px solid red');
                return;
            }

            if (!validateForm()) {
                return;
            }

            const formInput = $('#form-edit-testing').serializeArray();

            // Filter the array based on names starting with "test_name", "link", and "desc"
            const resultObjects = [];

            // Iterate over the array and create a new object for each set of "test_name", "link", and "desc" keys
            let currentObject = {};
            formInput.forEach(item => {
                if (item.name.startsWith('test_name')) {
                    currentObject[`test_name`] = item.value;
                } else if (item.name.startsWith('link')) {
                    currentObject[`link`] = item.value;
                } else if (item.name.startsWith('desc')) {
                    currentObject[`desc`] = item.value;
                }
                // If a non-"test_name", non-"link", and non-"desc" item is encountered, push the currentObject to resultObjects
                if (Object.keys(currentObject).length == 3) {
                    resultObjects.push(currentObject);
                    currentObject = {}; // Reset currentObject
                }
            });

            $.ajax({
                type: "POST",
                url: "controllers/testing_controller",
                data: {
                    editTesting: true,
                    term: term,
                    year: year,
                    std_class: std_class,
                    testing_id: testing_id,
                    data: JSON.stringify(resultObjects)
                },
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_testing';
                    } else {
                        alert(json.msg);
                    }
                },
            });
        })
    </script>
</body>

</html>