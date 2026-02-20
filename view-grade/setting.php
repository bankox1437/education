<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ตั้งค่าหน้าแรกระบบ</title>
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
    <?php include 'include/scripts.php'; ?>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <?php
                include "../config/class_database.php";
                $DB = new Class_Database();
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <h3>setting</h3>
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h4 class="box-title">ผู้อำนวยการ</h4>
                                        <button class="waves-effect waves-light btn btn-success btn-flat mt-1 mb-1" onclick="openModalAdd(1)"><i class="ti-plus"></i>&nbsp;บันทึกรายงาน</button>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <form class="form" id="banner_form">
                                        <div class="row">
                                            <?php

                                            $sql = "select * from web_personal where type = 1 and user_create = :user_create";
                                            $personType1 = $DB->Query($sql, ["user_create" => $_SESSION['user_data']->district_am_id]);
                                            $personType1 = json_decode($personType1);

                                            foreach ($personType1 as $key => $person) { ?>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <!-- Card Body -->
                                                        <div class="card-body" style="position: relative;">
                                                            <div class="row">
                                                                <!-- Edit Button -->
                                                                <button style="position: absolute;right: 50;" class="btn btn-sm btn-outline-primary mr-2" title="Edit">
                                                                    <i class="fa fa-edit"></i> <!-- Font Awesome Edit Icon -->
                                                                </button>
                                                                <!-- Delete Button -->
                                                                <button style="position: absolute;right: 0;" class="btn btn-sm btn-outline-danger" title="Delete">
                                                                    <i class="fa fa-trash"></i> <!-- Font Awesome Trash Icon -->
                                                                </button>
                                                                <!-- Left Side: Image -->
                                                                <div class="col-4">
                                                                    <img src="https://via.placeholder.com/100" alt="User Image" class="img-fluid rounded-circle">
                                                                </div>
                                                                <!-- Right Side: User Info -->
                                                                <div class="col-8">
                                                                    <h5 class="card-title">John Doe</h5>
                                                                    <p class="card-text"><strong>Position:</strong> Software Engineer</p>
                                                                    <p class="card-text"><strong>Department:</strong> Engineering</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php  }  ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h4 class="box-title">ข้าราชการ</h4>
                                        <a class="waves-effect waves-light btn btn-success btn-flat mt-1 mb-1" href="manage_summary_add"><i class="ti-plus"></i>&nbsp;บันทึกรายงาน</a>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <form class="form" id="banner_form">
                                        <div class="row">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">ครูอาสาสมัครฯ</h4>
                                </div>

                                <div class="box-body">
                                    <form class="form" id="banner_form">
                                        <div class="row">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">พนักงานราชการ</h4>
                                </div>

                                <div class="box-body">
                                    <form class="form" id="banner_form">
                                        <div class="row">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">จ้างเหมาบริการ</h4>
                                </div>

                                <div class="box-body">
                                    <form class="form" id="banner_form">
                                        <div class="row">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.box -->
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

    <!-- Modal -->
    <button type="button" class="btn btn-primary" id="btn-hide-show-modal" data-toggle="modal" data-target="#modalshow-modal-uploadfile" style="visibility: hidden;">
    </button>
    <div id="modalshow-modal-uploadfile" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h4 class="modal-title"><span id="title_modal_type"></span>รายงานผลการปฏิบัติงาน</h4>
                        <h4 class="modal-title mt-0" id="plan_name"></h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></button>
                </div>
                <div class="modal-body" id="std_sign_in">
                    <form id="setting_personal">
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>รูปภาพ <b class="text-danger">*</b></label>
                                    <div class="custom-file">
                                        <input type="hidden" name="mode" id="mode" value="add">
                                        <input type="hidden" name="type" id="type">
                                        <input type="hidden" name="image_profile_old" id="image_profile_old" autocomplete="off">
                                        <input type="file" class="custom-file-input" accept=".png, .gif, .jpeg, .jpg" id="image_profile" name="image_profile" style="display: none;" onchange="setlabelFilename('image_profile')">
                                        <label class="custom-file-label" for="image_profile" id="image_profile_label">เลือกไฟล์ .png, .gif, .jpeg, .jpg เท่านั้น</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ชื่อ-สกุล <b class="text-danger">*</b></label>
                                    <input type="text" class="form-control height-input" name="name" id="name" autocomplete="off" placeholder="กรอกชื่อ-สกุล">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ตำแหน่ง <b class="text-danger">*</b></label>
                                    <input type="text" class="form-control height-input" name="position" id="position" autocomplete="off" placeholder="กรอกตำแหน่ง">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>งานที่รับผิดชอบ <b class="text-danger">*</b></label>
                                    <input type="text" class="form-control height-input" name="task" id="task" autocomplete="off" placeholder="กรอกงานที่รับผิดชอบ">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                    <i class="ti-save-alt"></i> บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->
</body>
<script>
    $(document).ready(async function() {

    });

    function openModalAdd(type) {
        $('#btn-hide-show-modal').click();
        $('#type').val(type);
    }

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

    function getFormData($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i) {
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }


    $("#setting_personal").submit(function(e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append("setting_personal", true);

        const imageProfile = $('#image_profile')[0];
        const name = $('#name').val().trim();
        const position = $('#position').val().trim();
        const task = $('#task').val().trim();
        const mode = $('#mode').val().trim();

        let param_data = $("#setting_personal").serializeArray();

        // Validate image file
        if (imageProfile.files.length === 0 && mode == "add") {
            alert('กรุณาเลือกรูปภาพ');
            return;
        }

        if (imageProfile.files.length > 0) {
            const allowedExtensions = /(\.png|\.gif|\.jpeg|\.jpg)$/i;
            const file = imageProfile.files[0];
            if (!allowedExtensions.exec(file.name)) {
                alert('กรุณาเลือกไฟล์รูปภาพที่มีนามสกุล .png, .gif, .jpeg, หรือ .jpg เท่านั้น');
                return;
            }
            formData.append("profile", file);
        }

        // Validate text fields
        if (name === '') {
            alert('กรุณากรอกชื่อ-สกุล');
            $('#name').focus();
            return;
        }
        if (position === '') {
            alert('กรุณากรอกตำแหน่ง');
            $('#position').focus();
            return;
        }
        if (task === '') {
            alert('กรุณากรอกงานที่รับผิดชอบ');
            $('#task').focus();
            return;
        }

        // Append other form data
        param_data.forEach(item => {
            formData.append(item.name, item.value);
        });

        $.ajax({
            type: "POST",
            url: "controllers/web_controller",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(json) {
                alert(json.message);
                window.location.reload();
            },
        });
    });
</script>

</html>