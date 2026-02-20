<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มเพิ่มผู้ใช้งาน</title>
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
                                            <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='am_manage_teacher?pro=<?php echo $_GET['pro'] ?>&dis=<?php echo $_GET['dis'] ?>&sub=<?php echo $_GET['sub'] ?>&page_number=<?php echo $_GET['page_number'] ?>'"></i>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มเพิ่มผู้ใช้งาน</b>
                                            </h4>
                                            <a class="box-title text-success col-md-2 text-left h5 m-0" onclick="newEdu()" style="display: none;cursor: pointer;" id="new_edu" style="margin: 0;"><b><i class="ti-plus"></i> สถานศึกษาใหม่</b>
                                            </a>
                                            <input type="hidden" name="check_new" id="check_new" value="">

                                            <input type="hidden" name="radio" id="radio" value="edu">
                                            <!-- <input type="hidden" name="role_id" id="role_id" value="3"> -->
                                            <input type="hidden" name="pro_name" id="pro_name" value="<?php echo $_GET['pro'] ?>">
                                            <input type="hidden" name="dis_name" id="dis_name" value="<?php echo $_GET['dis'] ?>">
                                            <input type="hidden" name="dis_name_text" id="dis_name_text" value="<?php echo $_SESSION['user_data']->district_am ?>">
                                            <input type="hidden" name="pro_name_text" id="pro_name_text" value="<?php echo $_SESSION['user_data']->province_am ?>">

                                            <input type="hidden" name="subdistrict_id" id="subdistrict_id" value="">
                                            <input type="hidden" name="subdistrict_text" id="subdistrict_text" value="">
                                        </div>
                                        <hr class="my-15">
                                        <div id="form-container">
                                            <div class="row">
                                                <div class="demo-radio-button" id="role_radio" style="margin-top: 3px;">
                                                </div>
                                                <div class="form-group" style="display: none;" id="custom_role">
                                                    <input type="text" class="form-control height-input" name="custom_role_name" id="custom_role_name" autocomplete="off" placeholder="กรอกชื่อสิทธิ์ใหม่">
                                                    <input type="hidden" class="form-control height-input" name="custom_role_id" id="custom_role_id">

                                                    <select class="form-control select2" name="role_cus_id" id="role_cus_id" data-placeholder="เลือกตำบล" style="width: 100%;" onchange="changeCustomRole(this)">
                                                    </select>
                                                </div>
                                            </div>
                                            <?php $status_role = json_decode($_SESSION['user_data']->status); ?>
                                            <div class="row mb-3 system_role">
                                                <?php if ($status_role->view_grade) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_1" id="role_status_1" type="checkbox" class="filled-in">
                                                                <label for="role_status_1"><b>ระบบสืบค้นผลการเรียน</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>

                                                <?php if ($status_role->std_tracking) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_2" id="role_status_2" type="checkbox" class="filled-in">
                                                                <label for="role_status_2"><b>ระบบฐานข้อมูลนักศึกษา</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>

                                                <?php if ($status_role->visit_online) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_3" id="role_status_3" type="checkbox" class="filled-in">
                                                                <label for="role_status_3"><b>ระบบนิเทศการสอน ติดตามการปฏิบัติงาน</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>

                                                <?php if ($status_role->reading) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_6" id="role_status_6" type="checkbox" class="filled-in">
                                                                <label for="role_status_6"><b>ระบบส่งเสริมการอ่าน</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>

                                                <?php if ($status_role->search) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_4" id="role_status_4" type="checkbox" class="filled-in">
                                                                <label for="role_status_4"><b>ทะเบียนผู้จบการศึกษา</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>

                                                <?php if ($status_role->see_people) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_5" id="role_status_5" type="checkbox" class="filled-in">
                                                                <label for="role_status_5"><b>ฐานข้อมูลประชากรด้านการศึกษา</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>

                                                <?php if ($status_role->after) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_7" id="role_status_7" type="checkbox" class="filled-in">
                                                                <label for="role_status_7"><b>แบบติดตามหลังจบการศึกษา</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>

                                                <?php if ($status_role->estimate) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_8" id="role_status_8" type="checkbox" class="filled-in">
                                                                <label for="role_status_8"><b>ประเมินคุณธรรมนักศึกษา</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>

                                                <?php if ($status_role->dashboard) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_9" id="role_status_9" type="checkbox" class="filled-in">
                                                                <label for="role_status_9"><b>แดชบอร์ดภาพรวมข้อมูล</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>

                                                <?php if ($status_role->calendar_new) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_10" id="role_status_10" type="checkbox" class="filled-in">
                                                                <label for="role_status_10"><b>Smart Coach Room</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>

                                                <?php if ($status_role->teach_more) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_11" id="role_status_11" type="checkbox" class="filled-in">
                                                                <label for="role_status_11"><b>การสอนเสริม</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>

                                                <?php if ($status_role->guide) { ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input name="role_status_12" id="role_status_12" type="checkbox" class="filled-in">
                                                                <label for="role_status_12"><b>ห้องแนะแนวและให้คำปรึกษา</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }  ?>
                                            </div>
                                            <div class="row" id="edu-section">
                                                <div class="col-md-2 p-0">
                                                    <div class="demo-radio-button mt-2">
                                                        <input name="radio" onchange="chengeEduType('edu')" type="radio" value="edu" id="edu" class="with-gap radio-col-primary" checked>
                                                        <label for="edu">สถานศึกษา</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2" id="sub_dis" style="display: block;">
                                                    <div class="form-group">
                                                        <select class="form-control select2" name="sub_name" id="sub_name" data-placeholder="เลือกตำบล" style="width: 100%;">
                                                            <option value="0">เลือกตำบล</option>
                                                        </select>
                                                        <!-- <input type="text" class="form-control height-input" name="sub_name" id="sub_name" placeholder="กศน. ตำบล"> -->
                                                    </div>
                                                </div>
                                                <div class="col-md-6 row" id="edu_non" style="display: block;">
                                                    <div class="col-md-12" style="display: block;" id="div_old_edu">
                                                        <div class="form-group">
                                                            <select class="form-control select2" name="edu_select" id="edu_select" disabled data-placeholder="เลือกสถานศึกษา" style="width: 100%;">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 row" style="display: none;" id="div_new_edu">
                                                        <!-- <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control height-input" onKeyPress="if(this.value.length==10) return false;" name="new_edu_code" id="new_edu_code" autocomplete="off" placeholder="กรุณากรอกรหัสสถานศึกษา">
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control height-input" name="new_edu_name" id="new_edu_name" autocomplete="off" placeholder="กรุณากรอกชื่อสถานศึกษา">
                                                            </div>
                                                        </div> -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control height-input" name="new_edu_name" id="new_edu_name" disabled autocomplete="off" placeholder="เลือกตำบลก่อน">
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
                                            <hr class="my-15">
                                            <div class="row" id="data-section">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>ชื่อ <b class="text-danger">*</b></label>
                                                        <input type="text" class="form-control height-input" name="name" id="name" autocomplete="off" placeholder="กรุณากรอกชื่อ">
                                                        <input type="hidden" name="addAdmin">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>นามสถุล <b class="text-danger ">*</b></label>
                                                        <input type="text" class="form-control height-input" name="surname" id="surname" autocomplete="off" placeholder="กรุณากรอกนามสถุล">
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

            getRoleCustom()

            $('#edu_select').select2()
            $('#sub_name').select2()

            newEdu();

        });

        let main_sub_district = []
        let main_edu = [];

        function chengeEduType(type) {
            if (type === 'edu') {
                $('#pro_name').removeAttr('disabled')
                $('#edu_other_select').attr('disabled', true)
                $("#edu_other_select").val(0).change();
            } else {
                $('#edu_other_select').removeAttr('disabled')
                $('#pro_name').attr('disabled', true)
                $("#pro_name").val(0).change();
                /// clear data
                $('#sub_name').val("0");
                $('#dis_name').val("0");
                $('#pro_name').val("0");
                genEduOPtion('edu_other_select', main_edu_other);
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
                        if (element.role_id == 3) {
                            // roleOption.innerHTML += ` <option value="${element.role_id}">${element.role_name}</option>`
                            roleOption.innerHTML += `   <input ${element.role_id == 3 ? 'checked' : ''} name="role_id" type="radio" id="radio_${id}" class="with-gap radio-col-primary" value="${element.role_id}" onchange="showFormRole(this.value)">
                                                        <label for="radio_${id}"><b>${element.role_name}</b></label>`
                        }
                    });

                    roleOption.innerHTML += `   <input name="role_id" type="radio" id="radio_8" class="with-gap radio-col-primary" value="custom" onchange="showFormRole(this.value)">
                                                        <label for="radio_8" style="min-width:100px"><b>กำหนดเอง</b></label>`
                },
            });
        }

        function getRoleCustom() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getRoleCustom: true
                },
                dataType: "json",
                success: async function(json_data) {
                    const role_cus_id = document.getElementById('role_cus_id');
                    role_cus_id.innerHTML = "";
                    role_cus_id.innerHTML = `<option value="0">ไม่เลือกสิทธิ์ที่เคยบันทึก</option>`;
                    json_data.forEach((element, id) => {
                        role_cus_id.innerHTML += `<option value="${element.role_id}">${element.role_name}</option>`
                    });
                },
            });
        }

        function showFormRole(role_id) {
            $("#custom_role").hide();
            $('#status_librarian').val('0');
            if (role_id == 3) {
                $('.system_role').show();
                $('#edu-section').show();
            }
            if (role_id == 5) {
                $('.system_role').hide();
                $('#edu-section').hide();
                document.getElementById('data-section').style.display = 'flex';
                $('#status_librarian').val('1');
            }

            if (role_id == "custom") {
                $('.system_role').hide();
                document.getElementById('custom_role').style.display = 'flex';
                // $('#edu-section').hide();
                $('#edu_non').hide();
                $('#edu-section').show();
            }
        }

        function changeCustomRole(role) {
            console.log(role.value);
            if (role.value == 0) {
                $("#custom_role_id").val("0")
                $("#custom_role_name").val("")
                $("#custom_role_name").attr("readonly", false)
            } else {
                $("#custom_role_id").val(role.value)
                $("#custom_role_name").val($("#role_cus_id option:selected").text())
                $("#custom_role_name").attr("readonly", true)
            }
        }

        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "../visit-online/controllers/user_controller",
                data: {
                    getDataProDistSub: true
                },
                dataType: "json",
                success: async function(json_data) {
                    main_sub_district = json_data.data.sub_district;
                    const sub_district = main_sub_district.filter((sub) => {
                        return sub.district_id == '<?php echo $_GET['dis'] ?>';
                    })
                    sub_name.removeAttribute("disabled");
                    sub_district.forEach((element, id) => {
                        sub_name.innerHTML += ` <option value="${element.id}">${element.name_th}</option>`
                    });
                },
            });
        }

        async function getEduBySubDistrict(sub_id) {
            if (sub_id == 0) {
                $('#edu_select').attr('disabled', true)
                return;
            }
            const edu_data = main_edu.filter((edu) => {
                return edu.sub_district_id == parseInt(sub_id)
            })
            $('#edu_select').removeAttr('disabled')

            await genEduOPtion('edu_select', edu_data);
            $('#new_edu').show();
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
                url: "../visit-online/controllers/user_controller",
                data: $('#form-add-admin').serialize(),
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        alert('บันทึกผู้ใช้งานสำเร็จ');
                        clearInput();
                        // window.location.href = 'am_manage_teacher?pro=<?php echo $_GET['pro'] ?>&dis=<?php echo $_GET['dis'] ?>&sub=<?php echo $_GET['sub'] ?>&page_number=<?php echo $_GET['page_number'] ?>';
                    } else {
                        alert(json.msg);
                        if (json.reload) {
                            window.location.reload();
                        }
                    }
                },
            });
        });

        function newEdu() {
            document.getElementById('div_old_edu').style.display = "none";
            document.getElementById('div_new_edu').style.display = "flex";
            document.getElementById('check_new').value = 'new';
        }

        $('#sub_name').change(function() {
            let textSubdistrict = $("#sub_name option:selected").text();

            $('#subdistrict_text').val(textSubdistrict);

            textSubdistrict = `ศกร.ระดับตำบล${textSubdistrict}`
            $('#new_edu_name').val(textSubdistrict);
            $('#new_edu_name_hidden').val(textSubdistrict);


        })

        function clearInput() {
            $("#sub_name").val(0).change();
            $('#new_edu_name').val('');
            $('#new_edu_name_hidden').val('');
            $('#new_edu_sub_dis_name').val('');
            $('#name').val('');
            $('#surname').val('');
            $('#username').val('');
            $('#password').val('');
            getRoleCustom()
            $('#custom_role_name').val('');
            $("#custom_role_id").val("0")
        }
    </script>
</body>

</html>