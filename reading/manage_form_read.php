<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>บันทึกรักการอ่าน</title>
    <style>
        <?php if ($_SESSION['user_data']->role_id == 1) {
        ?>#table td {
            padding: 10px;
        }

        <?php
        }

        ?>#toolbar {
            width: 135%;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <div class="row">
                                        <div class="col-md-12">

                                        </div>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="col-md-12 mt-3 row align-items-center">
                                        <?php if ($_SESSION['user_data']->role_id == 4) { ?>
                                            <h4 class="mt-3 ml-2">บันทึกรักการอ่าน</h4>
                                            <a id="btn_add"
                                                class="waves-effect waves-light btn btn-success btn-flat ml-2 mt-2"
                                                href="manage_form_read_add"><i class="ti-plus"></i>&nbsp;บันทึก</a>
                                        <?php } else { ?>
                                            <h4 class="col-md-12 mt-3">
                                                <i class="ti-arrow-left" style="cursor: pointer;"
                                                    onclick="window.location.href='students_read'"></i>
                                                &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-book mr-15"></i>
                                                บันทึกรักการอ่าน <?php echo $_GET['std_name'] ?>
                                            </h4>
                                        <?php } ?>
                                    </div>
                                    <table id="table" data-search="false" data-show-refresh="false"
                                        data-minimum-count-columns="2" data-pagination="true" data-id-field="id"
                                        data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server"
                                        data-url="controllers/read_controller?getReadBooks=true<?php echo isset($_GET['std_id']) ? '&std_id=' . $_GET['std_id'] : '' ?>">
                                    </table>
                                </div>
                                <!-- /.box-body -->
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

    <?php include 'include/scripts.php'; ?>

    <script>
        $(document).ready(async function() {
            initTable()
        });

        var $table = $("#table");

        function formatButtonOperation(data, row) {
            let html = `<a href="manage_form_read_add?id=${row.id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
            let deleteBtn = "";
            deleteBtn = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteReadBook(${row.id},'${row.image}')"><i class="ti-trash" style="font-size:10px"></i></button>`;
            html += deleteBtn;
            return html;
        }

        function formatButtonPrint(data, row) {
            let html = `<a href="pdf/บันทึกรักการอ่าน?id=${row.id}" target="_blank">
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-printer"></i></button>
                        </a>`;
            return html;
        }

        function formatBookType(data, row) {
            let types = {
                1: "หนังสือ (Book)",
                2: "บทความ (Article)",
                3: "เรื่องสั้น (Short Story)",
                4: "อื่น ๆ (Others)"
            };
            let html = `<span class="badge badge-primary">${types[row.book_type]}</span>`;
            return html;
        }

        function formatMonth(data, row) {
            let months = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
            return months[row.month - 1];
        }

        function formatSummary(data, row) {
            if (row.summary && row.summary.length > 96) {
                let cutText = row.summary.substring(0, 96) + ' . . .';
                return cutText;
            }
            return row.summary || '';
        }

        function formatAnalysis(data, row) {
            if (row.analysis && row.analysis.length > 96) {
                let cutText = row.analysis.substring(0, 96) + ' . . .';
                return cutText;
            }
            return row.analysis || '';
        }

        function formatReference(data, row) {
            if (row.reference && row.reference.length > 96) {
                let cutText = row.reference.substring(0, 96) + ' . . .';
                return cutText;
            }
            return row.reference || '';
        }


        function initTable() {
            $table.bootstrapTable("destroy").bootstrapTable({
                locale: "th-TH",
                columns: [
                    [{
                            field: "date",
                            title: "วันที่",
                            align: "center",
                            width: "50px",
                        },
                        {
                            field: "month",
                            title: "เดือน",
                            align: "left",
                            width: "100px",
                            formatter: formatMonth
                        },
                        {
                            field: "year",
                            title: "ปี",
                            align: "center",
                            width: "50px",
                        },
                        {
                            field: "title",
                            title: "ชื่อหนังสือ/สื่อ",
                            align: "left",
                            width: "200px",
                        },
                        {
                            field: "author",
                            title: "ชื่อผู้แต่ง/ผู้เขียน/ผู้แปล",
                            align: "left",
                            width: "200px",
                        },
                        {
                            field: "publisher",
                            title: "สำนักพิมพ์",
                            align: "left",
                            width: "150px",
                        },
                        {
                            field: "book_type",
                            title: "ประเภท",
                            align: "center",
                            width: "150px",
                            formatter: formatBookType,
                        },
                        {
                            field: "summary",
                            title: "เนื้อหาโดยสรุป",
                            align: "left",
                            width: "300px",
                            formatter: formatSummary,
                        },
                        {
                            field: "analysis",
                            title: "ข้อคิด / ประโยชน์ที่ได้รับ",
                            align: "left",
                            width: "300px",
                            formatter: formatAnalysis,
                        },
                        {
                            field: "reference",
                            title: "แหล่งอ้างอิง / บรรณานุกรม",
                            align: "left",
                            width: "300px",
                            formatter: formatReference,
                        },
                        {
                            title: "ปริ้น",
                            align: "center",
                            width: "80px",
                            formatter: formatButtonPrint,
                        },
                        <?php if ($_SESSION['user_data']->role_id == 4) { ?> {
                                field: "ops",
                                title: "แก้ไข/ลบ",
                                align: "center",
                                width: "150px",
                                formatter: formatButtonOperation,
                            }
                        <?php } ?>
                    ],
                ]
            });

        }

        function deleteReadBook(id, image) {
            const confirmDelete = confirm('ต้องการลบรายการนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/read_controller",
                    data: {
                        deleteReadBook: true,
                        id: id,
                        image: image
                    },
                    dataType: "json",
                    success: function(data) {
                        alert(data.msg)
                        if (data.status) {
                            $table.bootstrapTable('refresh');
                        }
                    },
                });
            }
        }
    </script>
</body>

</html>