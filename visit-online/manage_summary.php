<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>รายงานผลการปฏิบัติงาน</title>
    <style>
        .input-group-text {
            width: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .input-group-text:hover {
            cursor: pointer;
            background-color: #5949d6;
            color: #fff;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <?php
                $pro = isset($_GET['pro']) ? "pro=" . $_GET['pro'] . "&" : '';
                $dis = isset($_GET['dis']) ? "dis=" . $_GET['dis'] . "&" : '';
                $sub = isset($_GET['sub']) ? "sub=" . $_GET['sub'] . "&" : '';
                $page_number = isset($_GET['page_number']) ? "page_number=" . $_GET['page_number'] : '';

                ?>
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <?php if (isset($_GET['user_id'])) {
                                        echo '<h4 class="box-title"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href=`teacher_list?' . $pro . $dis . $sub .  $page_number . '`"></i>
                                        &nbsp;รายงานผลการปฏิบัติงาน ' . $_GET['name'] . '</h4>';
                                    } else {
                                        echo '<h4 class="box-title">รายงานผลการปฏิบัติงาน</h4>';
                                    } ?>

                                </div>
                                <div class="box-body p-0">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <?php if (!isset($_GET['user_id'])) {
                                                echo '<a class="waves-effect waves-light btn btn-success btn-flat mt-1 mb-1" href="manage_summary_add"><i class="ti-plus"></i>&nbsp;บันทึกรายงาน</a>';
                                            } ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover" style="font-size: 14px;">
                                                    <thead>
                                                        <tr>
                                                            <th>เรื่อง</th>
                                                            <th style="width: 45%;">เนื้อหา</th>
                                                            <th style="width: 150px;" class="text-center">ดูรายละเอียด</th>
                                                            <?php if (!isset($_GET['user_id'])) { ?>
                                                                <th style="width: 70px;" class="text-center">แก้ไข</th>
                                                                <th style="width: 70px;" class="text-center">ลบ</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="data-main-calendar-old">
                                                        <tr>
                                                            <td colspan="5" class="text-center">
                                                                <?php include "../include/loader_include.php"; ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <?php if (!isset($_GET['user_id'])) {
                                                echo  '<button class="waves-effect waves-light btn btn-primary btn-flat mt-1 mb-1" data-toggle="modal" data-target="#modalshow-modal-uploadfile"><i class="ti-plus"></i>&nbsp;อัปโหลดรายงาน PDF</button>';
                                            } ?>
                                            <table class="table table-bordered table-hover" style="font-size: 14px;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ชื่อไฟล์</th>
                                                        <th style="width: 20%;" class="text-center">เปิดไฟล์</th>
                                                        <?php if (!isset($_GET['user_id'])) { ?>
                                                            <!-- <th style="width: 70px;" class="text-center">แก้ไข</th> -->
                                                            <th style="width: 10%;" class="text-center">ลบ</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody id="data-main-calendar-new">
                                                    <tr>
                                                        <td colspan="3" class="text-center">
                                                            <?php include "../include/loader_include.php"; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>

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

        <!-- Modal -->
        <div id="modalshow-modal-uploadfile" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <form id="form-save-file-report">
                            <div class="row ">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-6 text-center">
                                    <div class="form-group">
                                        <label>อัปโหลดไฟล์รายงานผลการปฏิบัติงาน <b class="text-danger">*</b></label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="report_file" name="report_file" accept="application/pdf" onchange="setlabelFilename('report_file')">
                                            <label class="custom-file-label" for="report_file" id="report_file_label">เลือกไฟล์ PDF เท่านั้น</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                        <i class="ti-save-alt"></i> บันทึกไฟล์
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        $(document).ready(() => {
            getDataReport();
            getDataReportNew();
        });

        function setlabelFilename(id) {
            const file = document.getElementById(id).files[0];
            document.getElementById(id + '_label').innerText = file.name;
        }

        function getDataReport() {
            $.ajax({
                type: "POST",
                url: "controllers/report_controller",
                data: {
                    getDataReport: true,
                    user_id: '<?php echo isset($_GET['user_id']) ? $_GET['user_id'] : 0 ?>'
                },
                dataType: "json",
                success: function(json_res) {
                    getHtmlData(json_res.data);
                },
            });
        }

        function getDataReportNew() {
            $.ajax({
                type: "POST",
                url: "controllers/report_controller",
                data: {
                    getDataReportNew: true,
                    user_id: '<?php echo isset($_GET['user_id']) ? $_GET['user_id'] : 0 ?>'
                },
                dataType: "json",
                success: function(json_res) {
                    getHtmlDataNew(json_res.data);
                },
            });
        }

        function getHtmlData(data) {
            const main_calendar = document.getElementById('data-main-calendar-old');
            main_calendar.innerHTML = "";
            if (data.length == 0) {
                main_calendar.innerHTML += `<tr>
                                            <td colspan="3" class="text-center">
                                                ยังไม่มีข้อมูล
                                            </td>
                                        </tr>`
                return;
            }
            data.forEach(element => {
                main_calendar.innerHTML += `
                    <tr>
                        <td title="${element.report_name}">${element.report_name.length > 65 ? element.report_name.substring(0, 65)+'...' : element.report_name}</td>
                        <td title="${element.report_detail}">${element.report_detail.length > 90 ? element.report_detail.substring(0, 90)+'...' : element.report_detail}</td>
                        <td class="text-center">
                            <a href="report_detail?report_id=${element.report_id}<?php echo isset($_GET['user_id']) ? '&user_id=' . $_GET['user_id'] . '&name=' . $_GET['name'] : '' ?>">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye"></i></button>
                            </a>
                        </td>
                        ${role_id == 3 || role_id == 5 ? 
                        `<td class="text-center">    
                            <a href="manage_summary_edit?report_id=${element.report_id}">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt"></i></button>
                            </a>
                        </td>
                        <td class="text-center">
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteSummary(${element.report_id},'${element.img_1}','${element.img_2}','${element.img_3}','${element.img_4}')"><i class="ti-trash"></i></button>
                        </td>` : ''
                        }
                    </tr>`;
            });
        }

        function getHtmlDataNew(data) {
            const main_calendar = document.getElementById('data-main-calendar-new');
            main_calendar.innerHTML = "";
            if (data.length == 0) {
                main_calendar.innerHTML += `<tr>
                                            <td colspan="3" class="text-center">
                                                ยังไม่มีข้อมูล
                                            </td>
                                        </tr>`
                return;
            }
            data.forEach(element => {
                main_calendar.innerHTML += `
                    <tr>
                        <td class="text-center">${element.filename_raw}</td>
                        <td class="text-center">
                            <a href="uploads/report_pdf/${element.filename}" target="_blank">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye"></i></button>
                            </a>
                        </td>
                        ${role_id == 3 ? 
                            `<td class="text-center">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteSummaryNew(${element.report_id},'${element.filename}')"><i class="ti-trash"></i></button>
                            </td>` : ''
                        }
                    </tr>`;
            });
        }

        function deleteSummary(report_id, img_1, img_2, img_3, img_4) {
            const confirmDelete = confirm('ต้องการลบรายงานผลการปฏิบัติงานนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/report_controller",
                    data: {
                        delete_summary: true,
                        id: report_id,
                        img_1: img_1,
                        img_2: img_2,
                        img_3: img_3,
                        img_4: img_4
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            getDataReport()
                        } else {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                });
            }
        }

        function deleteSummaryNew(report_id, filename) {
            const confirmDelete = confirm('ต้องการลบรายงานผลการปฏิบัติงานนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/report_controller",
                    data: {
                        delete_summary_new: true,
                        report_id: report_id,
                        filename: filename,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            getDataReportNew()
                        } else {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                });
            }
        }

        $('#form-save-file-report').submit(function(e) {
            e.preventDefault();

            const report_file = document.getElementById('report_file').files[0];

            let formData = new FormData();
            if (typeof report_file == 'undefined') {
                alert('โปรดเลือกไฟล์รายงานผลการปฏิบัติงาน')
                $('#report_file').focus()
                return false;
            }

            formData.append('report_file', report_file);
            formData.append('insertReportNew', true);

            $.ajax({
                type: "POST",
                url: "controllers/report_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    alert(json.msg);
                    if (json.status) {
                        $('#modalshow-modal-uploadfile .close').click();
                        getDataReportNew()
                    }
                },
            });
        });
    </script>
</body>

</html>