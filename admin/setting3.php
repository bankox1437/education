<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ตั้งค่าแนะนำแอป</title>
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
                            <?php include("include/settings/advice_app.php") ?>
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
    $('#share_app').on('submit', function(e) {
        e.preventDefault(); // ป้องกันการ submit ฟอร์มแบบปกติ

        // รับค่าจากฟอร์ม
        const formData = {
            app_icon: $('#app_icon').val(),
            app_name: $('#app_name').val(),
            app_des: $('#app_des').val()
        };

        let isValid = true;

        // ตรวจสอบฟิลด์ทั้งหมดใน formData
        for (const [key, value] of Object.entries(formData)) {
            const input = $('#' + key);
            if (value.trim() === '') {
                isValid = false;
                const placeholderText = input.attr('placeholder'); // ดึง placeholder
                input.focus(); // โฟกัสไปที่ input ว่างตัวแรก
                alert('โปรก' + placeholderText); // แจ้งเตือนโดยใช้ placeholder
                break; // หยุดการวนลูปเมื่อเจอฟิลด์ที่ว่าง
            }
        }
        // หากฟอร์มไม่ถูกต้อง ให้หยุดการทำงาน
        if (!isValid) {
            return;
        }

        formData['update_share_app'] = true;
        formData['attr_id'] = $('#attr_id').val();

        $.ajax({
            url: 'controllers/setting_controller',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                // จัดการการตอบกลับหลังจาก insert สำเร็จ
                console.log(response);
                alert(response.msg);
                window.location.reload();
            }
        });
    });

    function editApp(itemId, appName, applink, appDes) {
        // Set the values in the form inputs
        $('#app_icon').val(applink)
        $('#app_name').val(appName)
        $('#app_des').val(appDes)
        $('#attr_id').val(itemId)
        $('#cancelEditBtn').show();
    }

    function cancelEdit() {
        $('#share_app')[0].reset();
        $('#cancelEditBtn').hide();
        $('#attr_id').val("")
    }

    function deleteApp(itemId) {
        if (confirm("ต้องการลบการแนะนำแอปนี้หรือไม่?")) {
            const formData = {
                attr_id: itemId,
                delete_share_app: true,
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