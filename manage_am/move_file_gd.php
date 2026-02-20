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
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title"></h4>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div id="file-list" class="row"></div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="button" class="btn btn-rounded btn-info btn-outline mr-1" onclick="getListFile()">
                                        <i class="ti-reload"></i> โหลดข้อมูลล่าสุด
                                    </button>
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

    <button type="button" class="btn btn-primary" id="BTNuploadLoadingModal" data-toggle="modal" data-target="#uploadLoadingModal" data-backdrop="static" data-keyboard="false" style="visibility: hidden;">
    </button>
    <!-- Bootstrap Loading Modal -->
    <div class="modal fade" id="uploadLoadingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <h5 class="mt-3">
                    <div class="spinner-border text-primary" id="loadingIcon" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                    <span id="uploadLoadingModalText">
                        กำลังอัปโหลดไฟล์ โปรดรอสักครู่...
                    </span>
                </h5>

                <button type="button" class="closeText btn btn-danger mt-2" id="closeText" data-dismiss="modal" style="display: none;cursor: pointer;">
                    <span>
                        ปิด popup
                    </span>
                </button>
            </div>
        </div>
    </div>
</body>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(async function() {
        const cacheData = localStorage.getItem("folderTomove");
        if (!cacheData) {
            getListFile()
        } else {
            const localData = JSON.parse(cacheData);
            const localDataDate = localData.date;
            const firstDate = new Date(localDataDate);
            const secondDate = new Date();
            const firstDay = firstDate.getDate();
            const secondDay = secondDate.getDate();

            console.log(firstDay, secondDay);

            if (firstDay != secondDay) {
                getListFile()
            } else {
                const json = localData.data;
                geenerateHTML(json)
            }
        }

    });

    function getListFile() {
        $.ajax({
            type: "POST",
            url: "controllers/manage_file_controller",
            data: {
                getListFile: true
            },
            dataType: "json",
            beforeSend: function() {
                $("#file-list").html("<p>Loading folders...</p>");
            },
            success: function(json) {
                geenerateHTML(json)
                localStorage.setItem("folderTomove", JSON.stringify({
                    data: json,
                    date: new Date()
                }));
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                $("#file-list").html("<p style='color:red;'>Failed to load folder sizes</p>");
            }
        });
    }

    function geenerateHTML(json) {
        $("#file-list").html(""); // Clear loading message
        json.forEach((folder, index) => {
            setTimeout(() => {
                $("#file-list").append(
                    `<div class="col-md-3 mt-4">
                                <p><strong>${folder.folder}</strong>: <span class="text-danger">${folder.size}</span></p>
                                <button onclick="moveToDrive(${folder.index})" class="waves-effect waves-light btn btn-secondary mb-5">Move to Google Drive <i class="ti-sharethis"></i></button>
                            </div>`
                );
            }, index * 500); // Delay each folder display
        });
    }

    function moveToDrive(folderIndex) {

        let confirmMove = confirm("ต้องการย้ายไฟล์ใน Folder นี้หรือไม่?");
        if (confirmMove) {
            $("#BTNuploadLoadingModal").click();
            $('#uploadLoadingModalText').text('กำลังอัปโหลดไฟล์ โปรดรอสักครู่...');
            $("#loadingIcon").show();
            $("#closeText").hide();
            // $('#uploadLoadingModal').show();
            $.ajax({
                type: "POST",
                url: "controllers/manage_file_controller",
                data: {
                    moveToDrive: true,
                    folderIndex: folderIndex
                },
                dataType: "json",
                success: function(json) {
                    console.log(json);
                    if (!json.status && json.url) {
                        window.open(json.url, "_blank", "width=800,height=600");
                        location.reload();
                        return;
                    }

                    // $('#uploadLoadingModal').hide();
                    $('#uploadLoadingModalText').text(json.message);
                    $("#loadingIcon").hide();
                    $("#closeText").show();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        }
    }
</script>

</html>