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
                        <div class="col-lg-5 col-12">
                            <?php include("include/settings/home.php") ?>
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
    $(document).ready(async function() {

    });

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
    $("#setting_name").submit(function(e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append("mode", "system_name");

        let file_image_old = $("#file_image_old").val();
        let fileimage = document.getElementById("logo_image").files[0];
        let param_data = $("#setting_name").serializeArray();

        // Check for file image
        if ($('#system_name1').val() == "") {
            alert('โปรดกรอกชื่อระบบ 1');
            return false;
        }

        // Check for file image
        if (!file_image_old && !fileimage) {
            alert('โปรดเลือกรูปโลโก้หน้าหลัก');
            return false;
        }

        // Append file if it exists
        if (fileimage) {
            formData.append("file", fileimage);
        }

        // Append other form data
        param_data.forEach(item => {
            formData.append(item.name, item.value);
        });

        $.ajax({
            type: "POST",
            url: "controllers/setting_controller",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(json) {
                alert(json.msg);
                window.location.reload();
            },
        });
    });
</script>

</html>