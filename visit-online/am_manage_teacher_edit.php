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
                    <?php //include("include/maintenance.php"); 
                    ?>
                    <div class="row" id="no_data" style="display: none;">
                        <div class="col-12 d-flex justify-content-center">
                            <h4>ไม่พบข้อมูล</h4>
                        </div>
                    </div>
                    <div class="row" id="row_form">
                        <div class="col-12">
                            <form id="form-edit-admin">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;">
                                                <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='<?php echo empty($_GET['url']) ? 'am_manage_teacher' : $_GET['url']; ?>'"></i>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มแก้ไขโปรไฟล์</b>
                                            </h4>
                                            <a class="box-title text-success col-md-2 text-left h5 m-0" onclick="newEdu(true)" style="display: none;cursor: pointer;" id="new_edu" style="margin: 0;"><b><i class="ti-plus"></i> สถานศึกษาใหม่</b>
                                            </a>
                                        </div>
                                        <hr class="my-15">
                                        <?php $status_role = json_decode($_SESSION['user_data']->status); ?>
                                        <div class="row mb-3">
                                            <!-- <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>สิทธิ์ผู้ใช้ <b class="text-danger">*</b></label>
                                                    <select class="form-control" name="role_id" id="role_select" onchange="showFormRole(this.value)">
                                                        <option value="0">เลือกสิทธิ์ผู้ใช้งาน</option>
                                                    </select>
                                                </div>
                                                </div> -->
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

                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>จังหวัด</label>
                                                    <input type="text" class="form-control height-input" disabled name="province_name" id="province_name">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>อำเภอ</label>
                                                    <input type="text" class="form-control height-input" disabled name="district_name" id="district_name">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>ตำบล</label>
                                                    <input type="text" class="form-control height-input" disabled name="sub_district_name" id="sub_district_name">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>สถานศึกษา</label>
                                                    <input type="text" class="form-control height-input" disabled name="edu_name" id="edu_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>ชื่อ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="name" id="name" autocomplete="off" placeholder="กรุณากรอกชื่อ">
                                                    <input type="hidden" name="editAdmin">
                                                    <input type="hidden" name="user_id" value="<?php echo $_GET['user_id'] ?>">
                                                    <input type="hidden" name="role_id" id="role_id">
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
                                                    <input type="hidden" name="username_old" id="username_old">
                                                    <input type="text" class="form-control height-input" name="username" id="username" autocomplete="off" placeholder="กรุณากรอกชื่อผู้ใช้">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>รหัสผ่านใหม่
                                                        <span data-text="- จำเป็นต้องมีภาษาอังกฤษ &nbsp;&nbsp;  - จำเป็นต้องมีตัวเลข &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp; - จำเป็นต้องกรอก 8 ตัวอักษร" class="tooltip-custom text-primary"><i class="ti-info-alt"></i></span>
                                                    </label>
                                                    <input type="password" class="form-control height-input" maxlength="8" name="password" id="password" autocomplete="off" placeholder="กรุณากรอกรหัสผ่าน" oninput="verifyPassword($('#password').val())">
                                                    <label id="checkPassword" style="display: none;" class="text-danger"></label>
                                                    <input type="hidden" name="password_old" id="password_old">
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
            await getDataUserEdit();
        });

        async function getDataUserEdit() {
            var query = window.location.search.substring(1);
            var params = parse_query_string(query);
            $('#id').val(params.user_id);
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataUserEdit: true,
                    id: params.user_id
                },
                dataType: "json",
                success: async function(json_data) {
                    console.log(json_data)
                    if (json_data.data.length == 0) {
                        document.getElementById('row_form').style.display = 'none';
                        document.getElementById('no_data').style.display = 'block';
                        return;
                    }
                    renderDataToForm(json_data.data[0]);
                },
            });
        }

        function renderDataToForm(data) {
            $('#role_id').val(data.role_id);
            $('#name').val(data.name);
            $('#surname').val(data.surname);
            $('#username').val(data.username);
            $('#username_old').val(data.username);
            $("#password_old").val(data.password);
            if (data.role_id == 2) {
                $("#province_name").val(data.province_am ?? '-');
                $("#district_name").val(data.district_am ?? '-');
            }
            $("#province_name").val(data.province ?? '-');
            $("#district_name").val(data.district ?? '-');
            $("#sub_district_name").val(data.sub_district ?? '-');
            $("#edu_name").val(data.edu_name ?? '-');

            const role_status = JSON.parse(data.status)
            role_status.std_tracking ? $("#role_status_2").prop('checked', true) : $().prop('checked', false);
            role_status.view_grade ? $("#role_status_1").prop('checked', true) : $().prop('checked', false);
            role_status.visit_online ? $("#role_status_3").prop('checked', true) : $().prop('checked', false);
            role_status.search ? $("#role_status_4").prop('checked', true) : $().prop('checked', false);
            role_status.see_people ? $("#role_status_5").prop('checked', true) : $().prop('checked', false);
            role_status.reading ? $("#role_status_6").prop('checked', true) : $().prop('checked', false);
            role_status.after ? $("#role_status_7").prop('checked', true) : $().prop('checked', false);
            role_status.estimate ? $("#role_status_8").prop('checked', true) : $().prop('checked', false);
        }

        $('#form-edit-admin').submit((e) => {
            e.preventDefault();
            if ($('#name').val() == '') {
                alert('โปรดกรอกชื่อ')
                $('#name').focus()
                return;
            }
            if ($('#surname').val() == '') {
                alert('โปรดกรอกนามสกุล')
                $('#surname').focus()
                return;
            }
            if ($('#username').val() == '') {
                alert('โปรดกรอกชื่อผู้ใช้')
                $('#username').focus()
                return;
            }
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: $('#form-edit-admin').serialize(),
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        alert('แก่ไขโปรไฟล์สำเร็จ');
                        window.location.reload();
                    } else {
                        alert(json.msg);
                        if (json.reload) {
                            window.location.reload();
                        }
                    }
                },
            });
        });
    </script>
</body>

</html>