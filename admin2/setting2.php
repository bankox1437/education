<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ตั้งค่าข่าวสารระดับอำเภอ</title>
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
                                    <h4 class="box-title">ตั้งค่าข่าวสารระดับอำเภอ</h4>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                            $thaiMonths = array(
                                                1 => "มกราคม",
                                                2 => "กุมภาพันธ์",
                                                3 => "มีนาคม",
                                                4 => "เมษายน",
                                                5 => "พฤษภาคม",
                                                6 => "มิถุนายน",
                                                7 => "กรกฎาคม",
                                                8 => "สิงหาคม",
                                                9 => "กันยายน",
                                                10 => "ตุลาคม",
                                                11 => "พฤศจิกายน",
                                                12 => "ธันวาคม"
                                            );
                                            ?>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>รูปภาพปก</label>
                                                        <input type="hidden" class="form-control" id="image_old" name="image_old" value="">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/png, image/gif, image/jpeg" onchange="setlabelFilename('image')">
                                                            <label class="custom-file-label" for="image" id="image_label" style="overflow: hidden;">เลือกไฟล์รูปภาพ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" style="display: flex;align-items: center;">
                                                    <div class="form-group mr-1">
                                                        <label>วันที่</label>
                                                        <input type="text" class="form-control height-input" name="day" id="day" autocomplete="off" placeholder="กรอกวันที่">
                                                    </div>
                                                    <div class="form-group mr-1" style="width: 50%;">
                                                        <label>เดือน</label>
                                                        <select class="form-control" id="month">
                                                            <?php foreach ($thaiMonths as $num => $name) { ?>
                                                                <option value="<?php echo $num ?>"><?php echo $name ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" style="width: 50%;">
                                                        <label>ปี</label>
                                                        <input type="text" class="form-control height-input" name="year_input" id="year_input" autocomplete="off" placeholder="กรอกปี">
                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="display: flex;align-items: center;">
                                                    <div class="form-group" style="width: 100%;">
                                                        <label>หัวข้อ</label>
                                                        <input type="text" class="form-control height-input" name="title" id="title" autocomplete="off" placeholder="กรอกหัวข้อ">
                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="display: flex;align-items: center;">
                                                    <div class="form-group" style="width: 100%;">
                                                        <label>เนื้อหา</label>
                                                        <input type="text" class="form-control height-input" name="detail" id="detail" autocomplete="off" placeholder="กรอกเนื้อหา">
                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="display: flex;align-items: center;">
                                                    <div class="form-group" style="width: 100%;">
                                                        <label>ลิงค์</label>
                                                        <input type="text" class="form-control height-input" name="link" id="link" autocomplete="off" placeholder="กรอกลิงค์">
                                                        <input type="hidden" name="post_id" id="post_id">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline" style="margin-top: 23px;width: 100%;" onclick="savePost()">
                                                        <i class="ti-save-alt"></i> บันทึก
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="table" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/setting_controller?getDataPostAm=true">
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
                        field: "date",
                        title: "วันที่",
                        align: "center",
                        width: "80px",
                    },
                    {
                        field: "title",
                        title: "หัวข้อ",
                        align: "left",
                        width: "200px",
                    },
                    {
                        field: "detail",
                        title: "เนื้อหา",
                        align: "left",
                        width: "400px",
                    },
                    {
                        field: "link",
                        title: "ลิงก์",
                        align: "left",
                        width: "100px",
                        formatter: function(value) {
                            return `<a href="${value}" target="_blank">${value}</a>`;
                        }
                    },
                    {
                        field: "image",
                        title: "รูปภาพ",
                        align: "center",
                        width: "100px",
                        formatter: function(value) {
                            return `<img src="../manage_am/images/post_am/${value}" style="height: 50px;">`;
                        }
                    },
                    {
                        title: "จัดการ",
                        align: "center",
                        width: "100px",
                        formatter: function(value, row) {
                            return `<button class="btn btn-sm btn-warning" onclick="editPost(${row.post_id})">แก้ไข</button>
                                    <button class="btn btn-sm btn-danger" onclick="deletePost(${row.post_id}, '${row.image}')">ลบ</button> `;
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

    function savePost() {
        let formData = new FormData();
        formData.append("savePostAm", true);

        let post_id = document.getElementById("post_id")?.value;
        if (post_id) {
            formData.append("post_id", post_id);
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

        // รับค่าจากฟอร์มอื่นๆ
        let day = document.getElementById("day").value;
        let month = document.getElementById("month").value;
        let year = document.getElementById("year_input").value;
        let title = document.getElementById("title").value;
        let detail = document.getElementById("detail").value;
        let link = document.getElementById("link").value;

        // ตรวจสอบความถูกต้อง (ตัวอย่าง)
        if (!title || !detail) {
            alert("กรุณากรอกข้อมูลหัวข้อและเนื้อหาให้ครบ");
            return;
        }

        // เพิ่มข้อมูลใน formData
        formData.append("day", day);
        formData.append("month", month);
        formData.append("year", year);
        formData.append("title", title);
        formData.append("detail", detail);
        formData.append("link", link);

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

    function editPost(post_id) {
        $.ajax({
            url: 'controllers/setting_controller',
            type: 'POST',
            data: {
                getPostAmById: true,
                post_id: post_id
            },
            dataType: 'json',
            success: function(response) {
                const data = response.data;

                // กรอกข้อมูลลงในฟอร์ม
                $('#post_id').val(data.post_id); // ต้องมี input hidden id="post_id"
                $('#title').val(data.title);
                $('#detail').val(data.detail);
                $('#link').val(data.link);

                const dateParts = data.date.split(" ");
                const day = dateParts[0];
                const monthName = dateParts[1];
                const year = dateParts[2];

                const thaiMonths = {
                    "มกราคม": 1,
                    "กุมภาพันธ์": 2,
                    "มีนาคม": 3,
                    "เมษายน": 4,
                    "พฤษภาคม": 5,
                    "มิถุนายน": 6,
                    "กรกฎาคม": 7,
                    "สิงหาคม": 8,
                    "กันยายน": 9,
                    "ตุลาคม": 10,
                    "พฤศจิกายน": 11,
                    "ธันวาคม": 12
                };

                const month = thaiMonths[monthName];

                $('#day').val(day);
                $('#month').val(month);
                $('#year_input').val(year);

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

    function deletePost(post_id, image_old) {
        if (!confirm("คุณแน่ใจหรือไม่ว่าต้องการลบโพสต์นี้?")) return;

        $.ajax({
            url: 'controllers/setting_controller',
            type: 'POST',
            data: {
                deletePost: true,
                post_id: post_id,
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