<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ตั้งค่ารูปภาพกิจกรรม</title>
    <style>
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
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">ตั้งค่ารูปภาพกิจกรรม</h4>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>รูปภาพกิรกรรม</label>
                                                        <input type="hidden" class="form-control" id="event_ver_id" name="event_ver_id" value="">
                                                        <input type="hidden" class="form-control" id="image_old" name="image_old" value="">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/png, image/gif, image/jpeg" onchange="setlabelFilename('image')">
                                                            <label class="custom-file-label" for="image" id="image_label" style="overflow: hidden;">เลือกไฟล์รูปภาพ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline" style="margin-top: 23px;width: 100%;" onclick="saveEventVer()">
                                                        <i class="ti-save-alt"></i> บันทึก
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="table" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/setting_controller?getDataEventVerAm=true">
                                        </table>
                                    </div>
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


</body>
<?php include 'include/scripts.php'; ?>
<script>
    const $table = $("#table");

    function formatOps(data, row) {
        let html = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>`;
        html += `<button type="button" onclick="deleteCredit(${row.std_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
        return html;
    }

    function formatCounter(data, row, index) {
        const options = $table.bootstrapTable("getOptions");
        const currentPage = options.pageNumber;
        let itemsPerPage = options.pageSize;
        if (itemsPerPage == "All") {
            const data = $table.bootstrapTable("getData");
            itemsPerPage = data.length;
        }
        const offset = (currentPage - 1) * itemsPerPage;
        return index + 1 + offset;
    }

    initTable()

    function initTable() {
        $table.bootstrapTable("destroy").bootstrapTable({
            locale: "th-TH",
            columns: [
                [{
                        title: "ลำดับ",
                        align: "center",
                        width: "50px",
                        formatter: function(value, row, index) {
                            const options = $table.bootstrapTable("getOptions");
                            const currentPage = options.pageNumber;
                            let itemsPerPage = options.pageSize;
                            if (itemsPerPage == "All") {
                                const data = $table.bootstrapTable("getData");
                                itemsPerPage = data.length;
                            }
                            const offset = (currentPage - 1) * itemsPerPage;
                            return index + 1 + offset;
                        },
                    },
                    {
                        field: "image",
                        title: "รูปภาพ",
                        align: "center",
                        width: "100px",
                        formatter: function(value) {
                            return `<img src="../manage_am/images/am_events_ver/${value}" style="height: 50px;">`;
                        }
                    },
                    {
                        title: "จัดการ",
                        align: "center",
                        width: "100px",
                        formatter: function(value, row) {
                            return `<button class="btn btn-sm btn-warning" onclick="editEventVer(${row.event_ver_id})">แก้ไข</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteEventVer(${row.event_ver_id}, '${row.image}')">ลบ</button> `;
                        }
                    }
                ]
            ],
        });
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

    function saveEventVer() {
        let formData = new FormData();
        formData.append("saveEventVerAm", true);

        let event_ver_id = document.getElementById("event_ver_id")?.value;
        if (event_ver_id) {
            formData.append("event_ver_id", event_ver_id);
        }
        // รับไฟล์ภาพ
        let fileimage = document.getElementById("image").files[0];
        let fileOld = document.getElementById("image_old").value;
        if (fileimage) {
            formData.append("file", fileimage);
        } else if (!fileimage && !post_id) {
            alert("กรุณาเลือกไฟล์รูปภาพ");
            return;
        }
        formData.append("fileOld", fileOld);

        // ส่งข้อมูลด้วย AJAX
        $.ajax({
            url: 'controllers/setting_controller',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.msg);
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function(xhr, status, error) {
                alert("เกิดข้อผิดพลาด: " + error);
            }
        });
    }

    function editEventVer(event_ver_id) {
        $.ajax({
            url: 'controllers/setting_controller',
            type: 'POST',
            data: {
                getDataEventVerAmById: true,
                event_ver_id: event_ver_id
            },
            dataType: 'json',
            success: function(response) {
                const data = response.data;

                // กรอกข้อมูลลงในฟอร์ม
                $('#event_ver_id').val(data.event_ver_id); // ต้องมี input hidden id="post_id"
                $('#image_old').val(data.image);
                $('#image_label').text(data.image); // แสดงชื่อไฟล์เดิม

                $('html, body').animate({
                    scrollTop: 0
                }, 'fast'); // เลื่อนขึ้นไปยังฟอร์ม
            },
            error: function() {
                alert("เกิดข้อผิดพลาดในการโหลดข้อมูล");
            }
        });
    }

    function deleteEventVer(event_ver_id, image_old) {
        if (!confirm("คุณแน่ใจหรือไม่ว่าต้องการลบรูปภาพนี้?")) return;

        $.ajax({
            url: 'controllers/setting_controller',
            type: 'POST',
            data: {
                deleteEventVer: true,
                event_ver_id: event_ver_id,
                image_old: image_old
            },
            dataType: 'json',
            success: function(response) {
                alert(response.msg);
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function() {
                alert("เกิดข้อผิดพลาดในการลบข้อมูล");
            }
        });
    }


    function setDisplay(type) {
        $.ajax({
            url: 'controllers/setting_controller',
            type: 'POST',
            data: {
                "setDisplay": true,
                "type": type
            },
            dataType: 'json',
            success: function(response) {}
        });
    }
</script>

</html>