<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มบันทึกข้อมูลประชากรด้านการศึกษา</title>
    <style>
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

        <?php
        if ($_SESSION['user_data']->role_id != 4) {
            // include 'include/sidebar.php';
        }
        ?>

        <div class="content-wrapper" <?php echo $_SESSION['user_data']->role_id != 4 ? 'style="margin: 0"' : 'style="margin: 0"' ?>>
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content">
                    <div class="row">
                        <div class="col-12">

                            <div class="box">
                                <div class="box-body">
                                    <h6 class="box-title text-info" style="margin: 0;">
                                        <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='<?php echo $_SESSION['user_data']->role_id == 3 ? 'family_data' : 'student_family_data' ?>'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="ti-user mr-15"></i> <b>ฟอร์มบันทึกข้อมูลประชากรด้านการศึกษา</b>
                                    </h6>
                                    <hr class="my-15">
                                    <form id="form-add-family">
                                        <div class="row">
                                            <?php if ($_SESSION['user_data']->role_id == 3 || $_SESSION['user_data']->role_id == 4) { ?>
                                                <div class="col-md-2">
                                                    <label><b>จังหวัด <span class="text-danger">*</span></b></label>
                                                    <select class="form-control" id="province_select" style="width: 100%;">
                                                        <option value="0">เลือกจังหวัด</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label><b>อำเภอ / เขต <span class="text-danger">*</span></b></label>
                                                    <select class="form-control" id="district_select" style="width: 100%;">
                                                        <option value="0">เลือกอำเภอ</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label><b>ตำบล / แขวง <span class="text-danger">*</span></b></label>
                                                    <select class="form-control" id="subdistrict_select" style="width: 100%;">
                                                        <option value="0">เลือกตำบล</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label><b>บ้านเลขที่ <span class="text-danger">*</span></b></label>
                                                        <input type="text" name="home_number" id="home_number" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label><b>หมู่ที่ <span class="text-danger">*</span></b></label>
                                                        <input type="text" name="moo" id="moo" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label><b>ตรอก <span class="text-danger">*</span></b></label>
                                                        <input type="text" name="alley" id="alley" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label><b>ซอย <span class="text-danger">*</span></b></label>
                                                        <input type="text" name="alleyly" id="alleyly" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label><b>ถนน <span class="text-danger">*</span></b></label>
                                                        <input type="text" name="street" id="street" class="form-control">
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label><b>ตำบล <span class="text-danger">*</span></b></label>
                                                        <input type="text" name="subdistrict" id="subdistrict" class="form-control" placeholder="กรอกตำบล">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label><b>อำเภอ <span class="text-danger">*</span></b></label>
                                                        <input type="text" name="district" id="district" class="form-control" placeholder="กรอกอำเภอ">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label><b>จังหวัด <span class="text-danger">*</span></b></label>
                                                        <input type="text" name="province" id="province" class="form-control" placeholder="กรอกจังหวัด">
                                                    </div>
                                                </div> -->
                                            <?php } ?>
                                        </div>
                                        <div id="box_form_element" class="mb-4 mt-2">
                                            <div class="row form-border" id="ele_1">
                                                <div class="col-md-12 row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label><b>คนที่ 1 ชื่อ-สกุล <span class="text-danger">*</span></b></label>
                                                            <input type="text" name="name_1" id="name_1" class="form-control" placeholder="กรอกชื่อ-สกุล">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label><b>เพศ <span class="text-danger">*</span></b></label>
                                                            <select class="form-control" name="gender_1" id="gender_1" style="width: 100%;" required>
                                                                <option value="0">เลือกเพศ</option>
                                                                <option value="1">ชาย</option>
                                                                <option value="2">หญิง</option>
                                                                <option value="3">อื่น ๆ</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label><b>อายุ <span class="text-danger">*</span></b></label>
                                                            <input type="text" name="age_1" id="age_1" class="form-control" placeholder="กรอกอายุ">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label><b>อาชีพ <span class="text-danger">*</span></b></label>
                                                            <input type="text" name="job_1" id="job_1" class="form-control" placeholder="กรอกอาชีพ">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>การศึกษา </b><b class="text-danger">*</b></label>
                                                        <div class="c-inputs-stacked">
                                                            <input name="education_1" type="radio" id="education_1_1" class="with-gap radio-col-primary" value="1">
                                                            <label for="education_1_1" class="mr-30">ต่ำกว่าประถม</label><br>

                                                            <input name="education_1" type="radio" id="education_1_2" class="with-gap radio-col-primary" value="2">
                                                            <label for="education_1_2" class="mr-30">ประถม</label><br>

                                                            <input name="education_1" type="radio" id="education_1_3" class="with-gap radio-col-primary" value="3">
                                                            <label for="education_1_3" class="mr-30">ม.ต้น</label><br>

                                                            <input name="education_1" type="radio" id="education_1_4" class="with-gap radio-col-primary" value="4">
                                                            <label for="education_1_4" class="mr-30">ม.ปลาย</label><br>

                                                            <input name="education_1" type="radio" id="education_1_5" class="with-gap radio-col-primary" value="5">
                                                            <label for="education_1_5" class="mr-30">สูงกว่า ม.ปลาย</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>ผ่านการอบรมหลักสูตร </b></label>
                                                        <div class="form-group col-md-6 pl-0">
                                                            <input type="text" name="training_1_1" id="training_1_1" class="form-control" placeholder="กรอกการอบรมหลักสูตร 1">
                                                        </div>
                                                        <div class="form-group col-md-6 pl-0">
                                                            <input type="text" name="training_1_2" id="training_1_2" class="form-control" placeholder="กรอกการอบรมหลักสูตร 2">
                                                        </div>
                                                        <div class="form-group col-md-6 pl-0">
                                                            <input type="text" name="training_1_3" id="training_1_3" class="form-control" placeholder="กรอกการอบรมหลักสูตร 3">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>ต้องการพัฒนาตนเองในด้าน </b><b class="text-danger">*</b></label>
                                                        <div class="c-inputs-stacked">
                                                            <input name="needTraining_1" type="radio" id="need_training_1_1" class="with-gap radio-col-primary" value="1" onchange="showInputOther(1,1)">
                                                            <label for="need_training_1_1" class="mr-30">อาชีพ</label><br>

                                                            <input name="needTraining_1" type="radio" id="need_training_1_2" class="with-gap radio-col-primary" value="2" onchange="showInputOther(1,2)">
                                                            <label for="need_training_1_2" class="mr-30">สุขภาพ</label><br>

                                                            <input name="needTraining_1" type="radio" id="need_training_1_3" class="with-gap radio-col-primary" value="3" onchange="showInputOther(1,3)">
                                                            <label for="need_training_1_3" class="mr-30">สิ่งแวดล้อม</label><br>

                                                            <input name="needTraining_1" type="radio" id="need_training_1_4" class="with-gap radio-col-primary" value="4" onchange="showInputOther(1,4)">
                                                            <label for="need_training_1_4" class="mr-30">การเมืองการปกครอง</label><br>

                                                            <input name="needTraining_1" type="radio" id="need_training_1_5" class="with-gap radio-col-primary" value="5" onchange="showInputOther(1,5)">
                                                            <label for="need_training_1_5" class="mr-30">การพัฒนาบุคลิกภาพ</label>
                                                            <div class="p-0 d-flex align-items-center">
                                                                <div class="demo-checkbox" style="max-width: 90px;">
                                                                    <input name="needTraining_1" type="radio" id="need_training_1_6" class="with-gap radio-col-primary" value="6" onchange="showInputOther(1,6)">
                                                                    <label for="need_training_1_6" style="min-width: 60px;" class="m-0">อื่นๆ</label>
                                                                </div>
                                                                <div class="form-group mb-0" style="display: none;margin-left: 10px;" id="need_training_1_6_text_display">
                                                                    <input type="text" class="form-control" name="need_training_1_6_text" id="need_training_1_6_text" autocomplete="off" placeholder="ระบุอื่น ๆ" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>ความสามารถพิเศษ </b></label>
                                                        <div class="form-group col-md-6 pl-0">
                                                            <input type="text" name="ability_1" id="ability_1" class="form-control" placeholder="กรอกความสามารถพิเศษ">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>บทบาทในชุมชน </b></label>
                                                        <div class="form-group col-md-6 pl-0">
                                                            <input type="text" name="roleVillage_1" id="roleVillage_1" class="form-control" placeholder="กรอกบทบาทในชุมชน">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                        <button type="button" class="btn btn-rounded btn-info btn-outline" onclick="addForm()"><i class="ti-plus"></i>&nbsp;เพิ่มฟอร์ม</button>
                                    </form>
                                </div>

                            </div>


                        </div>
                    </div>
            </div>
        </div>
        <?php include '../include/footer.php'; ?>
        </section>
        <!-- /.content -->

        <div class="preloader">
            <?php include "../include/loader_include.php"; ?>
        </div>

    </div>
    </div>
    <!-- /.content-wrapper -->


    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        $(document).ready(function() {
            $('#province_select').select2()
            $('#district_select').select2()
            $('#subdistrict_select').select2()
            // getDataStd_new();
            getDataProDistSub();
        });

        function showInputOther(indexForm, value) {
            if (value == 6) {
                $(`#need_training_${indexForm}_${value}_text_display`).show();
            } else {
                $(`#need_training_${indexForm}_6_text_display`).hide();
            }
        }

        let defaultForm = 1;

        function addForm() {
            $('#remove_' + defaultForm).hide();
            defaultForm++
            $('#box_form_element').append(`
                <div class="row form-border mt-4" id="ele_${defaultForm}">
                    <i class="ti-close form-border-close" onclick="removeForm(${defaultForm})"></i>
                    <div class="col-md-12 row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>คนที่ ${defaultForm} ชื่อ-สกุล <span class="text-danger">*</span></b></label>
                                <input type="text" name="name_${defaultForm}" id="name_${defaultForm}" class="form-control" placeholder="กรอกชื่อ-สกุล">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><b>เพศ <span class="text-danger">*</span></b></label>
                                <select class="form-control" name="gender_${defaultForm}" id="gender_${defaultForm}" style="width: 100%;">
                                    <option value="0">เลือกเพศ</option>
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                    <option value="3">อื่น ๆ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label><b>อายุ <span class="text-danger">*</span></b></label>
                                <input type="text" name="age_${defaultForm}" id="age_${defaultForm}" class="form-control" placeholder="กรอกอายุ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><b>อาชีพ <span class="text-danger">*</span></b></label>
                                <input type="text" name="job_${defaultForm}" id="job_${defaultForm}" class="form-control" placeholder="กรอกอาชีพ">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>การศึกษา </b><b class="text-danger">*</b></label>
                            <div class="c-inputs-stacked">
                                <input name="education_${defaultForm}" type="radio" id="education_${defaultForm}_1" class="with-gap radio-col-primary" value="1">
                                <label for="education_${defaultForm}_1" class="mr-30">ต่ำกว่าประถม</label><br>

                                <input name="education_${defaultForm}" type="radio" id="education_${defaultForm}_2" class="with-gap radio-col-primary" value="2">
                                <label for="education_${defaultForm}_2" class="mr-30">ประถม</label><br>

                                <input name="education_${defaultForm}" type="radio" id="education_${defaultForm}_3" class="with-gap radio-col-primary" value="3">
                                <label for="education_${defaultForm}_3" class="mr-30">ม.ต้น</label><br>

                                <input name="education_${defaultForm}" type="radio" id="education_${defaultForm}_4" class="with-gap radio-col-primary" value="4">
                                <label for="education_${defaultForm}_4" class="mr-30">ม.ปลาย</label><br>

                                <input name="education_${defaultForm}" type="radio" id="education_${defaultForm}_5" class="with-gap radio-col-primary" value="5">
                                <label for="education_${defaultForm}_5" class="mr-30">สูงกว่า ม.ปลาย</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>ผ่านการอบรมหลักสูตร </b></label>
                            <div class="form-group col-md-6 pl-0">
                                <input type="text" name="training_${defaultForm}_1" id="training_${defaultForm}_1" class="form-control" placeholder="กรอกการอบรมหลักสูตร 1">
                            </div>
                            <div class="form-group col-md-6 pl-0">
                                <input type="text" name="training_${defaultForm}_2" id="training_${defaultForm}_2" class="form-control" placeholder="กรอกการอบรมหลักสูตร 2">
                            </div>
                            <div class="form-group col-md-6 pl-0">
                                <input type="text" name="training_${defaultForm}_3" id="training_${defaultForm}_3" class="form-control" placeholder="กรอกการอบรมหลักสูตร 3">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>ต้องการพัฒนาตนเองในด้าน </b><b class="text-danger">*</b></label>
                            <div class="c-inputs-stacked">
                                <input name="needTraining_${defaultForm}" type="radio" id="need_training_${defaultForm}_1" class="with-gap radio-col-primary" value="1"  onchange="showInputOther(${defaultForm},1)">
                                <label for="need_training_${defaultForm}_1" class="mr-30">อาชีพ</label><br>

                                <input name="needTraining_${defaultForm}" type="radio" id="need_training_${defaultForm}_2" class="with-gap radio-col-primary" value="2"  onchange="showInputOther(${defaultForm},2)">
                                <label for="need_training_${defaultForm}_2" class="mr-30">สุขภาพ</label><br>

                                <input name="needTraining_${defaultForm}" type="radio" id="need_training_${defaultForm}_3" class="with-gap radio-col-primary" value="3"  onchange="showInputOther(${defaultForm},3)">
                                <label for="need_training_${defaultForm}_3" class="mr-30">สิ่งแวดล้อม</label><br>

                                <input name="needTraining_${defaultForm}" type="radio" id="need_training_${defaultForm}_4" class="with-gap radio-col-primary" value="4"  onchange="showInputOther(${defaultForm},4)">
                                <label for="need_training_${defaultForm}_4" class="mr-30">การเมืองการปกครอง</label><br>

                                <input name="needTraining_${defaultForm}" type="radio" id="need_training_${defaultForm}_5" class="with-gap radio-col-primary" value="5"  onchange="showInputOther(${defaultForm},5)">
                                <label for="need_training_${defaultForm}_5" class="mr-30">การพัฒนาบุคลิกภาพ</label>

                                <div class="p-0 d-flex align-items-center">
                                    <div class="demo-checkbox" style="max-width: 90px;">
                                        <input name="needTraining_${defaultForm}" type="radio" id="need_training_${defaultForm}_6" class="with-gap radio-col-primary" value="6"  onchange="showInputOther(${defaultForm},6)">
                                        <label for="need_training_${defaultForm}_6" style="min-width: 60px;" class="m-0">อื่นๆ</label>
                                    </div>
                                    <div class="form-group mb-0" style="display: none;margin-left: 10px;" id="need_training_${defaultForm}_6_text_display">
                                        <input type="text" class="form-control" name="need_training_${defaultForm}_6_text" id="need_training_${defaultForm}_6_text" autocomplete="off" placeholder="ระบุอื่น ๆ" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>ความสามารถพิเศษ </b></label>
                            <div class="form-group col-md-6 pl-0">
                                <input type="text" name="ability_${defaultForm}" id="ability_${defaultForm}" class="form-control" placeholder="กรอกความสามารถพิเศษ">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>บทบาทในชุมชน </b></label>
                            <div class="form-group col-md-6 pl-0">
                                <input type="text" name="roleVillage_${defaultForm}" id="roleVillage_${defaultForm}" class="form-control" placeholder="กรอกบทบาทในชุมชน">
                            </div>
                        </div>
                    </div>
                </div>`);
            $(`#ele_${defaultForm}`).focus();
        }

        function removeForm(indexForm) {
            defaultForm--;
            $('#remove_' + defaultForm).show();
            $('#ele_' + indexForm).remove();
        }

        function getDataFormValidate() {
            // Reset error messages and borders
            $('.error-message').remove();
            $('#form-add-family input').css('border', '');

            let firstErrorInput = null;

            $('#form-add-family input[type="text"]').each(function() {
                const inputValue = $(this).val().trim();

                if (inputValue === '' && !$(this).attr('id').includes('training') && !$(this).attr('id').includes('roleVillage') && !$(this).attr('id').includes('ability')) {
                    if (!firstErrorInput) {
                        firstErrorInput = this;
                    }

                    $(this).css('border', '1px solid red');
                }
            });

            $('#form-add-family select').each(function() {
                const inputValue = $(this).val().trim();
                if (inputValue == '0') {
                    if (!firstErrorInput) {
                        firstErrorInput = this;
                    }
                    $(this).css('border', '1px solid red');
                } else {
                    $(this).css('border', '');
                }
            });


            $('#form-add-family input[type="radio"]').each(function() {
                const inputName = $(this).attr('name');
                const radioGroup = $(`[name="${inputName}"]:checked`);

                if (radioGroup.length === 0) {
                    if (!firstErrorInput) {
                        firstErrorInput = this;
                        let message = "โปรดเลือกว่าต้องการพัฒนาตนเองในด้านใด";
                        if ($(this).attr('name').includes('education')) {
                            message = "โปรดเลือกการศึกษา"
                        }
                        alert(message);
                        return false; // Stop the loop early
                    }
                }
            });


            // If there's any error, focus on the first input with an error and prevent form submission
            if (firstErrorInput) {
                $(firstErrorInput).focus();
                return false;
            }

            // If no error, allow form submission
            return true;
        }





        $('#form-add-family').submit(function(e) {
            e.preventDefault();

            const formInput = $('#form-add-family').serializeArray();

            $('#home_number').css('border', '');
            $('#subdistrict_select').css('border', '');
            $('#district_select').css('border', '');
            $('#province_select').css('border', '');
            $('#moo').css('border', '');
            $('#alley').css('border', '');
            $('#alleyly').css('border', '');
            $('#street').css('border', '');

            let isValid = true;
            let isFocus = '';
            if ($('#province_select').val() == "0") {
                alert("โปรดเลือกจังหวัด");
                $('#province_select').focus();
                return;
            }
            if ($('#district_select').val() == "0") {
                alert("โปรดเลือกอำเภอ / เขต");
                $('#district_select').focus();
                return;
            }
            if ($('#subdistrict_select').val() == "0") {
                alert("โปรดเลือกตำบล / แขวง");
                $('#subdistrict_select').focus();
                return;
            }
            if ($('#home_number').val() == "") {
                isValid = false;
                $('#home_number').css('border', '1px solid red');
                if (!isFocus) isFocus = '#home_number'
            }
            if ($('#moo').val() == "") {
                isValid = false;
                $('#moo').css('border', '1px solid red');
                if (!isFocus) isFocus = '#moo'
            }
            if ($('#alley').val() == "") {
                isValid = false;
                $('#alley').css('border', '1px solid red');
                if (!isFocus) isFocus = '#alley'
            }
            if ($('#alleyly').val() == "") {
                isValid = false;
                $('#alleyly').css('border', '1px solid red');
                if (!isFocus) isFocus = '#alleyly'
            }
            if ($('#street').val() == "") {
                isValid = false;
                $('#street').css('border', '1px solid red');
                if (!isFocus) isFocus = '#street'
            }
            if (!isValid) {
                $(isFocus).focus();
                return;
            }
            if (!getDataFormValidate()) {
                return;
            }

            const arrResult = [];
            for (let i = 0; i < defaultForm; i++) {
                const resultArray = filterArrayByNumber(formInput, (i + 1));
                arrResult.push(resultArray);
            }

            console.log({
                insertfamily: true,
                home_number: $('#home_number').val(),
                moo: $('#moo').val(),
                alley: $('#alley').val(),
                alleyly: $('#alleyly').val(),
                street: $('#street').val(),
                subdistrict: $('#subdistrict_select').val(),
                district: $('#district_select').val(),
                province: $('#province_select').val(),
                data: arrResult
            });

            $.ajax({
                type: "POST",
                url: "controllers/family_controller",
                data: {
                    insertfamily: true,
                    home_number: $('#home_number').val(),
                    moo: $('#moo').val(),
                    alley: $('#alley').val(),
                    alley1: $('#alleyly').val(),
                    street: $('#street').val(),
                    subdistrict: $('#subdistrict_select').val(),
                    district: $('#district_select').val(),
                    province: $('#province_select').val(),
                    data: JSON.stringify(arrResult)
                },
                dataType: "json",
                success: function(json_res) {
                    if (json_res.status) {
                        alert(json_res.msg);
                        window.location.href = '<?php echo $_SESSION['user_data']->role_id == 3 ? "family_data" : "student_family_data" ?>';
                    } else {
                        alert(json_res.msg);
                    }
                },
            });
        });

        function filterArrayByNumber(arr, number) {
            return arr.filter(item => {
                const match = item.name.match(/\d+/); // Extract the number from the 'name' property
                return match && parseInt(match[0]) === number;
            });
        }

        let main_provinces = null;
        let main_district = null;
        let main_sub_district_id = null;

        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true,
                },
                dataType: "json",
                success: async function(json_data) {
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district_id = json_data.data.sub_district;
                    const province_select = document.getElementById('province_select');
                    main_provinces.forEach((element, id) => {
                        province_select.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                    });
                },
            });
        }

        $('#province_select').change((e) => {
            getDistrictByProvince(e.target.value)
        })

        function getDistrictByProvince(pro_id) {
            const district_select = document.getElementById('district_select');
            district_select.innerHTML = "";
            district_select.innerHTML += ` <option value="0">เลือกอำเภอ</option>`;
            const sub_name = document.getElementById('subdistrict_select');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
            const district = main_district.filter((dist) => {
                return dist.province_id == pro_id
            })
            district.forEach((element) => {
                district_select.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
            });
        }
        $('#district_select').change((e) => {
            getSubDistrictByDistrict(e.target.value)
        })
        async function getSubDistrictByDistrict(dist_id) {
            const sub_name = document.getElementById('subdistrict_select');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
            const sub_district = main_sub_district_id.filter((sub) => {
                return sub.district_id == dist_id
            })
            sub_district.forEach((element, id) => {
                sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
            });
        }
    </script>
</body>

</html>