<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มแก้ไขโปรไฟล์</title>
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
        <?php //include 'include/sidebar.php'; 
        ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
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
                                                <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='<?php echo empty($_GET['url']) ? 'manage_admin' : $_GET['url']; ?>'"></i>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มแก้ไขโปรไฟล์</b>
                                            </h4>
                                            <a class="box-title text-success col-md-2 text-left h5 m-0" onclick="newEdu(true)" style="display: none;cursor: pointer;" id="new_edu" style="margin: 0;"><b><i class="ti-plus"></i> สถานศึกษาใหม่</b>
                                            </a>
                                        </div>
                                        <hr class="my-15">
                                        <div class="row">
                                            <div class="col-md-2" style="<?php echo $_SESSION['user_data']->role_id == 3 ? '' : 'display:none;' ?>">
                                                <div class="form-group">
                                                    <label>สถานศึกษา <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="edu_name" id="edu_name" autocomplete="off" placeholder="กรุณากรอกสถานศึกษา">
                                                    <input type="hidden" id="edu_id" name="edu_id">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ชื่อ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="name" id="name" autocomplete="off" placeholder="กรุณากรอกชื่อ">
                                                    <input type="hidden" name="edit_profile">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>นามสถุล <b class="text-danger ">*</b></label>
                                                    <input type="text" class="form-control height-input" name="surname" id="surname" autocomplete="off" placeholder="กรุณากรอกนามสถุล">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ชื่อผู้ใช้ <b class="text-danger "> * </b>
                                                        <span data-text="- อักษรต้องเป็นภาษาอังกฤษ   -ไม่มีเว้นวรรคหรืออักษรพิเศษ" class="tooltip-custom text-primary"><i class="ti-info-alt"></i></span>
                                                    </label>
                                                    <input type="text" class="form-control height-input" disabled name="username" id="username" autocomplete="off" placeholder="กรุณากรอกชื่อผู้ใช้">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>รหัสผ่านใหม่
                                                        <span data-text="- จำเป็นต้องมีภาษาอังกฤษ &nbsp;&nbsp;  - จำเป็นต้องมีตัวเลข &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp; - จำเป็นต้องกรอก 8 ตัวขึ้นไป" class="tooltip-custom text-primary"><i class="ti-info-alt"></i></span>
                                                    </label>
                                                    <input type="text" class="form-control height-input" maxlength="8" name="password" id="password" autocomplete="off" placeholder="กรุณากรอกรหัสผ่าน" oninput="verifyPassword($('#password').val())">
                                                    <label id="checkPassword" style="display: none;" class="text-danger"></label>
                                                    <input type="hidden" name="password_old" id="password_old">
                                                </div>
                                            </div>
                                            <?php if ($_SESSION['user_data']->role_id == 4) { ?>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>ภาคเรียนที่เข้าเรียน</label>
                                                        <input type="text" class="form-control" name="std_term"  id="std_term" placeholder="ภาคเรียนที่เข้าเรียน เช่น 1" value="<?php echo $std_data->std_term ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>ปีการศึกษาที่เข้าเรียน</label>
                                                        <input type="text" class="form-control" name="std_year" id="std_year" placeholder="ปีการศึกษาที่เข้าเรียน เช่น <?php echo date('Y') + 543 ?>" value="<?php echo $std_data->std_year ?>">
                                                    </div>
                                                </div>
                                            <?php } ?>
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
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataUserEdit: true,
                    id: '<?php echo $_SESSION['user_data']->id; ?>'
                },
                dataType: "json",
                success: async function(json_data) {
                    console.log(json_data.data);
                    renderDataToForm(json_data.data[0]);
                },
            });
        }

        function renderDataToForm(data) {
            $('#name').val(data.name);
            $('#surname').val(data.surname);
            $('#username').val(data.username);
            $("#password_old").val(data.password);
            $("#edu_name").val(data.edu_name);
            <?php if ($_SESSION['user_data']->role_id == 4) { ?>
                $("#std_term").val(data.std_term);
                $("#std_year").val(data.std_year);
            <?php } ?>
            $("#edu_id").val(data.edu_id);

            // $("#province_name").val(data.province ?? "-");
            // $("#district_name").val(data.district ?? "-");
            // $("#sub_district_name").val(data.sub_district ?? "-");
            // $("#edu_name").val(data.edu_name ?? "-");
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
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: $('#form-edit-admin').serialize(),
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        alert('แก้ไขโปรไฟล์สำเร็จ');
                        window.location.href = 'edit_admin?url=' + '<?php echo $_GET['url']; ?>';
                    } else {
                        alert(json.msg);
                        window.location.reload();
                    }
                },
            });
        });
    </script>
</body>

</html>