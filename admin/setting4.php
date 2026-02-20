<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ตั้งค่าลิงก์ข่าวสารและแบนเนอร์</title>
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

        input[type="color"] {
            height: 33px;
        }
    </style>
    <?php include 'include/scripts.php'; ?>
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
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <?php include("include/settings/banner.php") ?>
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


</body>
<script>
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

    function selectType(type) {
        $("#box-title").hide();
        $("#box-link").hide();
        $("#box-banner").hide();
        $("#box-order").hide();
        $("#box-btn").hide();
        if (type == 1) {
            $("#box-title").show();
            $("#box-link").show();
            $("#box-btn").css("display", "flex");
        }
        if (type == 2) {
            $("#box-title").show();
            $("#box-btn").css("display", "flex");
        }
        if (type == 3) {
            $("#box-banner").show();
            $("#box-order").show();
            $("#box-link").show();
            $("#box-btn").css("display", "flex");
        }
    }
    $('#banner_form').on('submit', function(e) {
        e.preventDefault(); // ป้องกันการ submit ฟอร์มแบบปกติ

        // รับค่าจากฟอร์ม
        let formData = new FormData();
        formData.append("banner_form", true);

        let type = $("#type").val();
        let banner_old = $("#banner_old").val();
        let fileimage = document.getElementById("banner").files[0];
        let param_data = $("#banner_form").serializeArray();

        if (type == 1) {
            $("#box-title").show();
            // Check for file image
            if ($('#title').val() == "") {
                alert('โปรดกรอกหัวข้อ');
                $('#title').focus();
                return false;
            }
            if ($('#link').val() == "") {
                alert('โปรดกรอกลิงค์');
                $('#link').focus();
                return false;
            }
        }
        if (type == 2) {
            if ($('#title').val() == "") {
                alert('โปรดกรอกหัวข้อ');
                $('#title').focus();
                return false;
            }
        }

        if (type == 3) {
            // Check for file image
            if (!banner_old && !fileimage) {
                alert('โปรดเลือกรูปโลโก้หน้าหลัก');
                return false;
            }

            if ($('#link').val() == "") {
                alert('โปรดกรอกลิงค์');
                $('#link').focus();
                return false;
            }

            if ($('#order').val() == "") {
                alert('โปรดกรอกหัวข้อ');
                $('#order').focus();
                return false;
            }

            // Append file if it exists
            if (fileimage) {
                formData.append("file", fileimage);
            }
        }

        // Append other form data
        param_data.forEach(item => {
            formData.append(item.name, item.value);
        });

        $.ajax({
            url: 'controllers/setting_controller',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                // จัดการการตอบกลับหลังจาก insert สำเร็จ
                console.log(response);
                alert(response.msg);
                window.location.reload();
            }
        });
    });

    function editBanner(itemId, title, link, banner, type, order) {
        // Set the values in the form inputs
        $('#attr_id').val(itemId)
        $('#title').val(title)
        $('#link').val(link)
        $('#banner_old').val(banner)
        $('#type').val(type)
        $('#order').val(order)
        selectType(type)
        $('#cancelEditBtn').show();
    }

    function cancelEdit() {
        $('#banner_form')[0].reset();
        $('#cancelEditBtn').hide();
        $('#attr_id').val("")
        selectType(0)
    }

    function deleteBanner(itemId, type, banner) {
        let typeText = "";
        if (type == 1) {
            typeText = "ลิงก์";
        }
        if (type == 2) {
            typeText = "ข่าวสาร";
        }
        if (type == 3) {
            typeText = "แบนเนอร์";
        }
        if (confirm("ต้องการลบ" + typeText + "หรือไม่?")) {
            const formData = {
                attr_id: itemId,
                delete_banner: true,
                banner: banner,
                typeText: typeText
            };
            $.ajax({
                url: 'controllers/setting_controller',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // จัดการการตอบกลับหลังจาก insert สำเร็จ
                    alert(response.msg);
                    window.location.reload();
                }
            });
        }
    };
</script>

</html>