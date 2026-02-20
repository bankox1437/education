<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มเพิ่มแบบทดสอบ </title>
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
                                            <b>ฟอร์มเพิ่มแบบทดสอบ</b>
                                        </h4>
                                    </div>
                                </div>

                                <form class="form" id="form-add-testing">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <?php
                                        $termActive = $_SESSION['term_active'];
                                        $termExplode = explode('/', $termActive->term_name);
                                        ?>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>ภาคเรียน <span class="text-danger">*</span></b></label>
                                                    <input type="number" name="term" id="term" class="form-control" placeholder="กรอกภาคเรียน" value="<?php echo $termExplode[0] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>ปีการศึกษา <span class="text-danger">*</span></b></label>
                                                    <input type="number" name="year" id="year" class="form-control" placeholder="กรอกปีการศึกษา" value="<?php echo $termExplode[1] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label><b>เลือกระดับชั้น <span class="text-danger">*</span></b></label>
                                                <select class="form-control" name="std_class" id="std_class">
                                                    <option value="">ยังไม่ระบุชั้น &nbsp;&nbsp;</option>
                                                    <option value="ประถม">ประถม</option>
                                                    <option value="ม.ต้น">ม.ต้น</option>
                                                    <option value="ม.ปลาย">ม.ปลาย</option>
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
                                                                <input type="text" class="form-control height-input require" name="test_name1" id="test_name1" autocomplete="off" placeholder="กรอกชื่อแบบทดสอบวิชา">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>ลิงค์แบบทดสอบ<b class="text-danger">*</b></label>
                                                                <input type="text" class="form-control height-input require" name="link1" id="link1" autocomplete="off" placeholder="กรอกลิงค์แบบทดสอบ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>คำอธิบาย</label>
                                                                <textarea rows="5" class="form-control height-input" name="desc1" id="desc1" autocomplete="off" placeholder="กรอกคำอธิบาย"></textarea>
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
                                        <button type="button" class="btn btn-rounded btn-info btn-outline" onclick="addForm()"><i class="ti-plus"></i>&nbsp;เพิ่มฟอร์ม</button>
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
        let defaultForm = 1;

        function addForm() {
            $('#remove_' + defaultForm).hide();
            defaultForm++;
            $('#box_form').append(`
                <div class="row mt-4" id="ele_${defaultForm}">
                    <div class="col-md-6 form-border">
                        <i class="ti-close form-border-close" onclick="removeForm(${defaultForm})" id="remove_${defaultForm}"></i>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>ชื่อแบบทดสอบวิชา <b class="text-danger">*</b></label>
                                    <input type="text" class="form-control height-input require" name="test_name${defaultForm}" id="test_name${defaultForm}" autocomplete="off" placeholder="กรอกชื่อแบบทดสอบวิชา">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>ลิงค์แบบทดสอบ<b class="text-danger">*</b></label>
                                    <input type="text" class="form-control height-input require" name="link${defaultForm}" id="link${defaultForm}" autocomplete="off" placeholder="กรอกลิงค์แบบทดสอบ">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>คำอธิบาย</label>
                                    <textarea rows="5" class="form-control height-input" name="desc${defaultForm}" id="desc${defaultForm}" autocomplete="off" placeholder="กรอกคำอธิบาย"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);
            $(`#ele_${defaultForm}`).focus();
            $(`#test_name${defaultForm}`).focus();
        }

        function removeForm(indexForm) {
            defaultForm--;
            $('#remove_' + defaultForm).show();
            $('#ele_' + indexForm).remove();
        }


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

        $('#form-add-testing').submit((e) => {
            e.preventDefault();
            const term = $('#term').val();
            const year = $('#year').val();
            const std_class = $('#std_class').val();

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

            const formInput = $('#form-add-testing').serializeArray();

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
                    addTesting: true,
                    term: term,
                    year: year,
                    std_class: std_class,
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