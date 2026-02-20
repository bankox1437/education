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

        .checkbox label {
            padding-left: 25px;
        }
    </style>
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
                            <form id="form-add-admin">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='pro_manage_user?pro=<?php echo $_GET['pro'] ?>&dis=<?php echo $_GET['dis'] ?>&page_number=<?php echo $_GET['page_number'] ?>'"></i>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มเพิ่มผู้ใช้งาน</b>
                                            </h4>
                                        </div>
                                        <hr class="my-15">
                                        <!-- <div class="row">
                                            <div class="demo-radio-button" id="role_radio">
                                                <input name="role_radio" type="radio" id="radio_0" class="with-gap radio-col-primary" value="3" onchange="showFormRole(this.value)">
                                                <label for="radio_0"><b>แอดมินครู</b></label>

                                                <input name="role_radio" type="radio" id="radio_0" class="with-gap radio-col-primary" value="3" onchange="showFormRole(this.value)">
                                                <label for="radio_0"><b>บรรณารักษ์</b></label>

                                                <input name="role_radio" type="radio" id="radio_0" class="with-gap radio-col-primary" value="3" onchange="showFormRole(this.value)">
                                                <label for="radio_0"><b>แอดมินครู</b></label>
                                            </div>
                                        </div> -->
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

                                        </div>
                                        <div id="form-container">
                                            <div class="row" id="edu-section">
                                                <div class="col-md-2">
                                                    <div class="demo-radio-button mt-2">
                                                        <input name="radio" onchange="chengeEduType('edu')" type="radio" value="edu" id="edu" class="with-gap radio-col-primary" checked>
                                                        <label for="edu">สถานศึกษา</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2" id="dis_id" style="display: block;">
                                                    <input type="hidden" name="pro_name_text" id="pro_name_text" value="<?php echo $_SESSION['user_data']->province_am ?>">
                                                    <input type="hidden" name="pro_name" id="pro_name" value="<?php echo $_SESSION['user_data']->province_am_id ?>">
                                                    <div class="form-group">
                                                        <select class="form-control select2" name="dis_name" id="dis_name" disabled data-placeholder="เลือกอำเภอ" style="width: 100%;" onchange="getSubDistrictByDistrict(this.value)">
                                                            <option value="0">เลือกอำเภอ</option>
                                                            <input type="hidden" name="dis_name_text" id="dis_name_text" value="">
                                                        </select>
                                                        <!-- <input type="text" class="form-control height-input" name="dis_name" id="dis_name" placeholder="กศน. อำเภอ"> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-15 line-section">
                                            <div class="row" id="data-section">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>ชื่อ <b class="text-danger">*</b></label>
                                                        <input type="text" class="form-control height-input" name="name" id="name" autocomplete="off" placeholder="กรุณากรอกชื่อ">
                                                        <input type="hidden" name="addAdmin">
                                                        <input type="hidden" name="role_id" value="2" id="role_select">
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

            // $('#pro_name').select2()
            $('#dis_name').select2()

            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                console.log($(this).data('select2').$dropdown.find('.select2-search__field'));
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        });

        let main_provinces = [];
        let main_district = [];
        let main_sub_district = []
        let main_edu = [];
        let main_edu_other = [];

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
                    // const dis_name = document.getElementById('dis_name');
                    // main_provinces.forEach((element, id) => {
                    //     dis_name.innerHTML += ` <option value="${element.id}">${element.name_th}</option>`
                    // });
                    getDistrictByProvince();
                },
            });
        }

        function getDistrictByProvince() {
            // const pro_name = $('#pro_name').find(':selected')[0].innerText
            let pro_id = $('#pro_name').val()
            const dis_name = document.getElementById('dis_name');
            dis_name.innerHTML = "";
            dis_name.innerHTML += ` <option value="0">เลือกอำเภอ</option>`
            const sub_name = document.getElementById('sub_name');

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
                        $('#sub_name').val("0").change();
                        $('#new_edu_name').val("");
                        $('#name').val("");
                        $('#surname').val("");
                        $('#username').val("");
                        $('#password').val("");
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