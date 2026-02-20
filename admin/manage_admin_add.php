<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มเพิ่มแอดมิน</title>
    <style>
        /* .tooltip-custom {
            cursor: pointer;
        }

        .tooltiptext {
            display: none;
        } */

        .tooltip-custom {
            cursor: pointer;
            position: relative;
        }

        .tooltip-custom:before {
            content: attr(data-text);
            /* here's the magic */
            position: absolute;

            /* vertically center */
            top: 50%;
            transform: translateY(-50%);

            /* move to right */
            left: 100%;
            margin-left: 15px;
            /* and add a small left margin */

            /* basic styles */
            width: 200px;
            padding: 10px;
            border-radius: 10px;
            background: #5949d6;
            color: #fff;
            text-align: left;

            display: none;
            /* hide by default */
        }

        .tooltip-custom:hover:before {
            display: block;
        }

        .checkbox label {
            padding-left: 25px;
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
                            <form id="form-add-admin">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_admin?pro=<?php echo $_GET['pro'] ?>&dis=<?php echo $_GET['dis'] ?>&sub=<?php echo $_GET['sub'] ?>&page_number=<?php echo $_GET['page_number'] ?>'"></i>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มเพิ่มแอดมิน</b>
                                            </h4>
                                            <a class="box-title text-success col-md-2 text-left h5 m-0" onclick="newEdu(true)" style="display: none;cursor: pointer;" id="new_edu" style="margin: 0;"><b><i class="ti-plus"></i> สถานศึกษาใหม่/กลุ่ม</b>
                                            </a>
                                            <a class="box-title text-danger col-md-2 text-center h5 m-0" onclick="hideNewEdu()" style="display: none;cursor: pointer;" id="hide_new_edu" style="margin: 0;"><b>ยกเลิกการเพิ่ม</b>
                                            </a>
                                            <input type="hidden" name="check_new" id="check_new" value="">
                                        </div>
                                        <hr class="my-15">
                                        <div class="row">
                                            <div class="demo-radio-button" id="role_radio">
                                            </div>
                                        </div>
                                        <div class="row system_role" style="display: none;">
                                            <!-- <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>สิทธิ์ผู้ใช้ <b class="text-danger">*</b></label>
                                                    <select class="form-control" name="role_id" id="role_select" onchange="showFormRole(this.value)">
                                                        <option value="0">เลือกสิทธิ์ผู้ใช้งาน</option>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_1" id="role_status_1" type="checkbox" class="filled-in">
                                                        <label for="role_status_1"><b>ระบบสืบค้นผลการเรียน</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_2" id="role_status_2" type="checkbox" class="filled-in">
                                                        <label for="role_status_2"><b>ระบบฐานข้อมูลนักศึกษา</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_3" id="role_status_3" type="checkbox" class="filled-in">
                                                        <label for="role_status_3"><b>ระบบนิเทศการสอน ติดตามการปฏิบัติงาน</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_6" id="role_status_6" type="checkbox" class="filled-in">
                                                        <label for="role_status_6"><b>ระบบส่งเสริมการอ่าน</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3" id="amphur_role" style="display: none;">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_4" id="role_status_4" type="checkbox" class="filled-in">
                                                        <label for="role_status_4"><b>ทะเบียนผู้จบการศึกษา</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_5" id="role_status_5" type="checkbox" class="filled-in">
                                                        <label for="role_status_5"><b>ฐานข้อมูลประชากรด้านการศึกษา</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_7" id="role_status_7" type="checkbox" class="filled-in">
                                                        <label for="role_status_7"><b>แบบติดตามหลังจบการศึกษา</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_8" id="role_status_8" type="checkbox" class="filled-in">
                                                        <label for="role_status_8"><b>ประเมินคุณธรรมนักศึกษา</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_9" id="role_status_9" type="checkbox" class="filled-in">
                                                        <label for="role_status_9"><b>แดชบอร์ดภาพรวมข้อมูล</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_10" id="role_status_10" type="checkbox" class="filled-in">
                                                        <label for="role_status_10"><b>Smart Coach Room</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_11" id="role_status_11" type="checkbox" class="filled-in">
                                                        <label for="role_status_11"><b>การสอนเสริม</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input name="role_status_12" id="role_status_12" type="checkbox" class="filled-in">
                                                        <label for="role_status_12"><b>ห้องแนะแนวและให้คำปรึกษา</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="form-container" style="display: none;">
                                            <div class="row" id="edu-section" style="display: none;">
                                                <div class="col-md-2">
                                                    <div class="demo-radio-button mt-2">
                                                        <input name="radio" onchange="chengeEduType('edu')" type="radio" value="edu" id="edu" class="with-gap radio-col-primary" checked>
                                                        <label for="edu">สถานศึกษา</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <select class="form-control select2" name="pro_name" id="pro_name" data-placeholder="เลือกจังหวัด" style="width: 100%;" onchange="getDistrictByProvince(this.value)">
                                                            <option value="0">เลือกจังหวัด</option>
                                                        </select>
                                                        <input type="hidden" name="pro_name_text" id="pro_name_text" value="">
                                                        <!-- <input type="text" class="form-control height-input" name="pro_name" id="pro_name" placeholder="กศน. จังหวัด"> -->
                                                    </div>
                                                </div>
                                                <div class="col-md-2" id="dis_id" style="display: block;">
                                                    <div class="form-group">
                                                        <select class="form-control select2" name="dis_name" id="dis_name" disabled data-placeholder="เลือกอำเภอ" style="width: 100%;" onchange="getSubDistrictByDistrict(this.value)">
                                                            <option value="0">เลือกอำเภอ</option>
                                                            <input type="hidden" name="dis_name_text" id="dis_name_text" value="">
                                                        </select>
                                                        <!-- <input type="text" class="form-control height-input" name="dis_name" id="dis_name" placeholder="กศน. อำเภอ"> -->
                                                    </div>
                                                </div>
                                                <div class="col-md-2" id="sub_dis" style="display: block;">
                                                    <div class="form-group">
                                                        <select class="form-control select2" name="sub_name" id="sub_name" disabled data-placeholder="เลือกตำบล" style="width: 100%;" onchange="getEduBySubDistrict(this.value)">
                                                            <option value="0">เลือกตำบล</option>
                                                        </select>
                                                        <input type="hidden" name="sub_name_text" id="sub_name_text" value="">
                                                        <!-- <input type="text" class="form-control height-input" name="sub_name" id="sub_name" placeholder="กศน. ตำบล"> -->
                                                    </div>
                                                </div>
                                                <div class="col-md-4 row" id="edu_non" style="display: block;">
                                                    <div class="col-md-12" style="display: none;" id="div_old_edu">
                                                        <div class="form-group">
                                                            <select class="form-control select2" name="edu_select" id="edu_select" disabled data-placeholder="เลือกสถานศึกษาใหม่/กลุ่ม" style="width: 100%;">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 row" style="display: none;" id="div_new_edu">
                                                        <!-- <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control height-input" onKeyPress="if(this.value.length==10) return false;" name="new_edu_code" id="new_edu_code" autocomplete="off" placeholder="กรอกรหัสสถานศึกษา">
                                                            </div>
                                                        </div> -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control height-input" name="new_edu_name" id="new_edu_name" disabled autocomplete="off" placeholder="">
                                                                <input type="hidden" name="new_edu_name_hidden" id="new_edu_name_hidden">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control height-input" name="new_edu_sub_dis_name" id="new_edu_sub_dis_name" autocomplete="off" placeholder="สถานศึกษา/กลุ่ม">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row" id="edu-other-section" style="display: none;">
                                                <div class="col-md-2" style="max-width: 19.6666666667%;">
                                                    <div class="demo-radio-button mt-2">
                                                        <input name="radio" onchange="chengeEduType('other')" type="radio" value="edu_other" id="edu_other" class="with-gap radio-col-primary">
                                                        <label for="edu_other">สถาบันการศึกษาทางไกล</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="div_old_edu_other" style="display: none;">
                                                    <div class="form-group">
                                                        <select class="form-control select2" name="edu_other_select" id="edu_other_select" disabled data-placeholder="เลือกสถานศึกษาใหม่/กลุ่ม" style="width: 100%;">
                                                        </select>
                                                    </div>
                                                </div>
                                                <a class="box-title text-success col-md-2 text-left h5" onclick="newEdu(true,true)" style="display:none;cursor: pointer;margin-top: 8px;" id="new_edu_other" style="margin: 0;"><b><i class="ti-plus"></i> สถานศึกษาใหม่/กลุ่ม</b>
                                                </a>
                                                <a class="box-title text-danger col-md-2 text-center h5" onclick="hideNewEdu(true)" style="display: none;cursor: pointer;margin-top: 8px;" id="hide_new_edu_other" style="margin: 0;"><b>ยกเลิกการเพิ่ม</b>
                                                </a>
                                                <div class="col-md-4 row" style="display: block;">
                                                    <div class="col-md-12 row" id="div_new_edu_other">
                                                        <!-- <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" disabled class="form-control height-input" onKeyPress="if(this.value.length==10) return false;" name="new_edu_code_other" id="new_edu_code_other" autocomplete="off" placeholder="กรอกรหัสสถานศึกษา">
                                                            </div>
                                                        </div> -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" disabled class="form-control height-input" name="new_edu_name_other" id="new_edu_name_other" autocomplete="off" placeholder="สถานศึกษาใหม่/กลุ่ม">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-15 line-section">
                                            <div class="row" id="data-section" style="display: none;">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>ชื่อ <b class="text-danger">*</b></label>
                                                        <input type="text" class="form-control height-input" name="name" id="name" autocomplete="off" placeholder="กรุณากรอกชื่อ">
                                                        <input type="hidden" name="addAdmin">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>นามสกุล <b class="text-danger ">*</b></label>
                                                        <input type="text" class="form-control height-input" name="surname" id="surname" autocomplete="off" placeholder="กรุณากรอกนามสกุล">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>ชื่อผู้ใช้ <b class="text-danger "> * </b>
                                                            <span data-text="- อักษรต้องเป็นภาษาอังกฤษ   -ไม่มีเว้นวรรคหรืออักษรพิเศษ" class="tooltip-custom text-primary"><i class="ti-info-alt"></i></span>
                                                        </label>
                                                        <input type="text" class="form-control height-input" name="username" id="username" autocomplete="off" placeholder="กรุณากรอกชื่อผู้ใช้">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>รหัสผ่าน <b class="text-danger">*</b>
                                                            <span data-text="- จำเป็นต้องมีภาษาอังกฤษ &nbsp;&nbsp;  - จำเป็นต้องมีตัวเลข &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp; - จำเป็นต้องกรอก 8 ตัวขึ้นไป" class="tooltip-custom text-primary"><i class="ti-info-alt"></i></span>
                                                        </label>
                                                        <input type="text" class="form-control height-input" maxlength="8" name="password" id="password" autocomplete="off" placeholder="กรุณากรอกรหัสผ่าน" oninput="verifyPassword($('#password').val())">
                                                        <label id="checkPassword" style="display: none;" class="text-danger"></label>
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
                                </div>
                            </form>


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
        $(document).ready(async function() {
            await getDataProDistSub();
            await getDataEducation();

            $('#edu_select').select2()
            $('#pro_name').select2()
            $('#dis_name').select2()
            $('#sub_name').select2()
            $('#edu_other_select').select2()

            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                console.log($(this).data('select2').$dropdown.find('.select2-search__field'));
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        });


        // $('input[name="role_radio"]').change(function() {
        //     var selectedValue = $('input[name="role_radio"]:checked').val();
        //     console.log("Selected Value: " + selectedValue);
        // });

        function showFormRole(role_id) {
            console.log(role_id);
            // document.getElementById('amphur_role').style.display = 'none';
            if (role_id == 0) {
                document.getElementById('form-container').style.display = 'none';
                return;
            }
            document.getElementById('form-container').style.display = 'block';
            if (role_id == 1) {
                $('.system_role').hide();
                document.getElementById('data-section').style.display = 'flex';
                document.getElementById('edu-section').style.display = 'none';
                document.getElementById('edu-other-section').style.display = 'none';
                document.getElementById('edu_non').style.display = 'none';
                document.getElementById('sub_dis').style.display = 'none';
                document.getElementById('amphur_role').style.display = 'none';
            }
            if (role_id == 2) {
                document.getElementById('data-section').style.display = 'flex';
                document.getElementById('edu-section').style.display = 'flex';
                document.getElementById('edu-other-section').style.display = 'none';
                document.getElementById('edu_non').style.display = 'none';
                document.getElementById('sub_dis').style.display = 'none';
                document.getElementById('amphur_role').style.display = 'flex';
                $("#dis_id").show();
                $('.system_role').show();
            }

            if (role_id == 3) {
                $('.system_role').show();
                document.getElementById('data-section').style.display = 'flex';
                document.getElementById('edu-section').style.display = 'flex';
                // document.getElementById('edu-other-section').style.display = 'flex';
                document.getElementById('edu_non').style.display = 'block';
                document.getElementById('sub_dis').style.display = 'block';
                document.getElementById('amphur_role').style.display = 'flex';
                $('#new_edu_name').show();
            }

            if (role_id == 5) {
                $('.system_role').hide();
                // $('#edu-section').hide();
                document.getElementById('edu-section').style.display = 'flex';
                // $('#edu-other-section').hide();
                $('.line-section').hide();
                document.getElementById('data-section').style.display = 'flex';
                $('#status_librarian').val('1');
                $('#role_status_1').prop('checked', false);
                $('#role_status_2').prop('checked', false);
                $('#role_status_3').prop('checked', false);
                $('#role_status_4').prop('checked', false);
                // $('#role_status_5').prop('checked', false);
                document.getElementById('amphur_role').style.display = 'none';
                document.getElementById('sub_dis').style.display = 'none';
                $('#new_edu_name').hide();
                $('#edu-other-section').hide();
            } else {
                $('#status_librarian').val('0');
            }

            if (role_id == 6) {
                $('.system_role').show();
                // $('#edu-section').hide();
                document.getElementById('edu-section').style.display = 'flex';
                // $('#edu-other-section').hide();
                $('.line-section').hide();
                document.getElementById('data-section').style.display = 'flex';
                $('#role_status_1').prop('checked', false);
                $('#role_status_2').prop('checked', false);
                $('#role_status_3').prop('checked', false);
                $('#role_status_4').prop('checked', false);
                // $('#role_status_5').prop('checked', false);
                document.getElementById('amphur_role').style.display = 'flex';
                document.getElementById('sub_dis').style.display = 'none';
                document.getElementById('dis_id').style.display = 'none';
                $('#new_edu_name').hide();
                $('#edu-other-section').hide();
            }
            if (role_id == 7) {
                $('.system_role').hide();
                $('#amphur_role').hide();
                document.getElementById('data-section').style.display = 'flex';
                document.getElementById('edu-section').style.display = 'none';
                document.getElementById('edu-other-section').style.display = 'none';
                document.getElementById('edu_non').style.display = 'none';
                document.getElementById('sub_dis').style.display = 'none';
            }
        }

        let main_provinces = [];
        let main_district = [];
        let main_sub_district = []
        let main_edu = [];
        let main_edu_other = [];

        function chengeEduType(type) {
            if (type === 'edu') {
                $('#pro_name').removeAttr('disabled')
                $('#edu_other_select').attr('disabled', true)
                $("#edu_other_select").val(0).change();
                // $('#new_edu_code_other').attr('disabled', true)
                $('#new_edu_name_other').attr('disabled', true)
            } else {
                $('#edu_other_select').removeAttr('disabled')
                $('#pro_name').attr('disabled', true)
                $("#pro_name").val(0).change();
                /// clear data
                $('#sub_name').val("0");
                $('#dis_name').val("0");
                $('#pro_name').val("0");
                //genEduOPtion('edu_other_select', main_edu_other);
                // $('#new_edu_other').show()
                // $('#new_edu_code_other').removeAttr('disabled')
                $('#new_edu_name_other').removeAttr('disabled')
                document.getElementById('check_new').value = 'new';
            }
        }

        async function getDataEducation() {
            $.ajax({
                type: "POST",
                url: "controllers/education_controller",
                data: {
                    getDataEducation: true
                },
                dataType: "json",
                success: async function(json_data) {
                    main_edu = json_data.data.edu;
                    main_edu_other = json_data.data.edu_other;
                    const role_data = json_data.data.role_data;
                    const roleOption = document.getElementById('role_radio');
                    role_data.forEach((element, id) => {
                        if (element.role_id != 4) {
                            // roleOption.innerHTML += ` <option value="${element.role_id}">${element.role_name}</option>`
                            roleOption.innerHTML += `   <input name="role_radio" type="radio" id="radio_${id}" class="with-gap radio-col-primary" value="${element.role_id}" onchange="showFormRole(this.value)">
                                                        <label for="radio_${id}"><b>${element.role_name}</b></label>`
                        }
                    });
                },
            });
        }

        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true
                },
                dataType: "json",
                success: async function(json_data) {
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district = json_data.data.sub_district;
                    const pro_name = document.getElementById('pro_name');
                    main_provinces.forEach((element, id) => {
                        pro_name.innerHTML += ` <option value="${element.id}">${element.name_th}</option>`
                    });
                },
            });
        }

        function getDistrictByProvince(pro_id) {
            const pro_name = $('#pro_name').find(':selected')[0].innerText
            $('#pro_name_text').val(pro_name)
            const dis_name = document.getElementById('dis_name');
            dis_name.innerHTML = "";
            dis_name.innerHTML += ` <option value="0">เลือกอำเภอ</option>`
            const sub_name = document.getElementById('sub_name');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`
            sub_name.setAttribute("disabled", true)
            $('#edu_select').attr('disabled', true)
            //$('#new_edu').hide();
            //newEdu(false)
            if (pro_id == 0) {
                dis_name.setAttribute("disabled", true)

                return;
            }
            const district = main_district.filter((dist) => {
                return dist.province_id == pro_id
            })
            dis_name.removeAttribute("disabled");
            district.forEach((element, id) => {
                dis_name.innerHTML += ` <option value="${element.id}">${element.name_th}</option>`
            });

        }

        async function getSubDistrictByDistrict(dist_id) {
            const dis_name = $('#dis_name').find(':selected')[0].innerText;
            $('#dis_name_text').val(dis_name)
            const sub_name = document.getElementById('sub_name');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`
            if (dist_id == 0) {
                sub_name.setAttribute("disabled", true)
                $('#edu_select').attr('disabled', true)
                //$('#new_edu').hide();
                //newEdu(false)
                return;
            }
            const sub_district = main_sub_district.filter((sub) => {
                return sub.district_id == dist_id
            })
            sub_name.removeAttribute("disabled");
            sub_district.forEach((element, id) => {
                sub_name.innerHTML += ` <option value="${element.id}">${element.name_th}</option>`
            });
        }

        async function getEduBySubDistrict(sub_id) {
            const sub_name = $('#sub_name').find(':selected')[0].innerText;
            $('#sub_name_text').val(sub_name)
            if (sub_id == 0) {
                $('#edu_select').attr('disabled', true)
                return;
            }
            const edu_data = main_edu.filter((edu) => {
                return edu.sub_district_id == parseInt(sub_id)
            })
            $('#edu_select').removeAttr('disabled')

            await genEduOPtion('edu_select', edu_data);
            // $('#new_edu').show();
            // $('#hide_new_edu').hide();
            if (parseInt($('input[name=role_radio]:checked').val()) == 3) {
                newEdu(true)
            }
        }

        async function genEduOPtion(id, edu_data) {
            const edu_select = document.getElementById(id);
            edu_select.innerHTML = "";
            edu_select.innerHTML += `<option value="0">เลือกสถานศึกษา</option>`;
            edu_data.forEach((element, i) => {
                edu_select.innerHTML += `<option value="${element.id}">${element.name}</option>`;
            });
        }

        $('#form-add-admin').submit((e) => {
            e.preventDefault();
            if (!validateFrom()) {
                return;
            }
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: $('#form-add-admin').serialize(),
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        alert('บันทึกแอดมินสำเร็จ');
                        $('#sub_name').val("0").change();
                        $('#new_edu_name').val("");
                        $('#name').val("");
                        $('#surname').val("");
                        $('#username').val("");
                        $('#password').val("");
                        // window.location.href = 'manage_admin';
                        // window.location.href = 'manage_admin?pro=<?php echo $_GET['pro'] ?>&dis=<?php echo $_GET['dis'] ?>&sub=<?php echo $_GET['sub'] ?>&page_number=<?php echo $_GET['page_number'] ?>';
                    } else {
                        alert(json.msg);
                        if (json.reload) {
                            window.location.reload();
                        }
                    }
                },
            });
        });

        function hideNewEdu(other = false) {
            document.getElementById('check_new').value = '';
            if (!other) {
                document.getElementById('hide_new_edu').style.display = "none";
                document.getElementById('new_edu').style.display = "block";
                document.getElementById('div_old_edu').style.display = "block";
                document.getElementById('div_new_edu').style.display = "none";
            } else {
                document.getElementById('hide_new_edu_other').style.display = "none";
                document.getElementById('new_edu_other').style.display = "block";
                document.getElementById('div_old_edu_other').style.display = "block";
                document.getElementById('div_new_edu_other').style.display = "none";
            }
        }

        function newEdu(check, other = false) {
            if (!other) {
                if (check) {
                    document.getElementById('div_old_edu').style.display = "none";
                    document.getElementById('div_new_edu').style.display = "flex";
                    document.getElementById('check_new').value = 'new';
                    //document.getElementById('hide_new_edu').style.display = "block";
                    document.getElementById('new_edu').style.display = "none";

                    let textSubdistrict = $("#sub_name option:selected").text();
                    textSubdistrict = `ศกร.ระดับตำบล${textSubdistrict}`
                    $('#new_edu_name').val(textSubdistrict);
                    $('#new_edu_name_hidden').val(textSubdistrict);
                } else {
                    document.getElementById('div_old_edu').style.display = "block";
                    document.getElementById('div_new_edu').style.display = "none";
                    document.getElementById('check_new').value = '';
                }
            } else {
                if (check) {
                    document.getElementById('div_old_edu_other').style.display = "none";
                    document.getElementById('div_new_edu_other').style.display = "flex";
                    document.getElementById('check_new').value = 'new';
                    document.getElementById('hide_new_edu_other').style.display = "block";
                    document.getElementById('new_edu_other').style.display = "none";
                } else {
                    document.getElementById('div_old_edu_other').style.display = "block";
                    document.getElementById('div_new_edu_other').style.display = "none";
                    document.getElementById('check_new').value = '';
                }
            }

        }
    </script>
</body>

</html>