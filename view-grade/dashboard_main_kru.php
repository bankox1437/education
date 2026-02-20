<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แดชบอร์ดสรุปผล</title>
    <style>
        .preloader {
            display: flex;
            justify-content: center;
        }

        .box-content {
            border-radius: 20px;
            padding: 20px 20px;
            color: #fff;
            margin-bottom: 15px;
        }

        h4 {
            margin: 0px;
            font-size: 22px;
        }

        .fixed-table-toolbar {
            padding: 0px;
        }

        table tr td {
            padding: 10px 10px !important;
            align-content: center;
        }

        @media screen and (max-width: 480px) {
            h4 {
                margin: 0px;
                font-size: 14px;
            }

            .box-content {
                padding: 10px 20px;
                margin-bottom: 5px;
            }

            .box-flex-row {
                padding-right: 0;
            }

            .box-flex-row .col-md-4 {
                padding: 0;
            }
        }

        .table tbody tr:nth-child(odd) {
            background-color: #d6d6d6;
        }
    </style>

    <style>
        .fixed-table-toolbar .bs-bars {
            width: 70%;
        }

        @media only screen and (max-width: 600px) {
            .pagination-detail .pagination {
                margin-left: 100px;
            }
        }

        .table thead tr th {
            padding: 5px 5px !important;
            align-content: center;
        }

        .table tbody tr td {
            padding: 10px 10px;
            align-content: center;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #d6d6d6;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.18.3/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.18.3/extensions/print/bootstrap-table-print.min.css">
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

                $sql = "SELECT\n" .
                    "u.name u_name,u.surname,edu.name edu_name,\n" .
                    "tsd.name_th sub_name,\n" .
                    "td.name_th dis_name,\n" .
                    "tp.name_th pro_name\n" .
                    "FROM\n" .
                    "tb_users u\n" .
                    "LEFT JOIN tbl_non_education edu on u.edu_id = edu.id\n" .
                    "LEFT JOIN tbl_sub_district tsd on edu.sub_district_id = tsd.id\n" .
                    "LEFT JOIN tbl_district td on edu.district_id = td.id\n" .
                    "LEFT JOIN tbl_provinces tp on edu.province_id = tp.id\n" .
                    " WHERE u.id = :id\n";
                $data = $DB->Query($sql, ['id' => $_SESSION['user_data']->id]);
                $data = json_decode($data);
                $data = $data[0];


                $termArr = explode('/', $_SESSION['term_active']->term_name);
                $term = $termArr[0];
                $year = $termArr[1];
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="container d-flex justify-content-center">
                        <div class="row">
                            <div class="col-md-12 text-center text-info mb-2">
                                <h4><b><?php echo $data->u_name . " " . $data->surname ?></b></h4>
                                <h4><b>ศกร.ระดับตำบล <?php echo $data->sub_name ?></b></h4>
                                <h4><b>สกร.ระดับอำเภอ <?php echo $data->dis_name ?></b></h4>
                                <h4><b>สกร.ประจำจังหวัด <?php echo $data->pro_name ?></b></h4>
                                <h4><b>ภาคเรียนที่ <?php echo $term ?> ปีการศึกษา <?php echo $year ?></b></h4>
                            </div>
                        </div>
                    </div>
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-2 px-4 row justify-content-between">
                                <div class="mt-2 mb-2">
                                    <a href="../main_menu?index_menu=<?php echo $_SESSION['index_menu'] ?>">
                                        <h5 class="text-info"><b>เข้าสู่หน้าเมนูหลัก</b></h5>
                                    </a>
                                </div>
                            </div>
                            <button id="printBtn" class="col-md-2 btn btn-primary mb-3">พิมพ์หน้านี้</button>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table-striped" data-toggle="table" id="table-d-kru" data-locale="th-TH">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th data-field="std_class" data-valign="middle" data-align="center" data-width="200px">#</th>
                                            <th data-field="male" data-valign="middle" data-align="center" data-width="40px">ชาย</th>
                                            <th data-field="female" data-valign="middle" data-align="center" data-width="40px">หญิง</th>
                                            <th data-field="sum" data-valign="middle" data-align="center" data-width="40px">รวม</th>
                                            <th data-field="break" data-valign="middle" data-align="center" data-width="40px">พักการเรียน</th>
                                            <th data-field="finish" data-valign="middle" data-align="center" data-width="40px">จบการศึกษา</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <input type="hidden" id="role_value" value="0">
                                <div class="row align-items-center">
                                    <!-- <div class="col-md-2 mt-4">
                                        <h4 class="mt-2 ml-3">ภาพรวมข้อมูล </h4>
                                    </div> -->
                                    <div class="col-md-2 mt-4">
                                        <div class="form-group mb-0">
                                            <input type="hidden" id="pro_name" value="<?php echo $_SESSION['user_data']->province_am_id ?>">
                                            <input type="hidden" id="dis_name" value="0">
                                            <select class="form-control select2" name="std_class" id="std_class" style="width: 100%;">
                                                <option value="">ชั้นทั้งหมด</option>
                                                <option value="ประถม">ประถม</option>
                                                <option value="ม.ต้น">ม.ต้น</option>
                                                <option value="ม.ปลาย">ม.ปลาย</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-2 mt-4">
                                        <div class="form-group mb-0">
                                            <select class="form-control select2" name="term_select" id="term_select" style="width: 100%;">
                                                <option value="0">เลือกปีการศึกษา</option>
                                                <?php foreach ($_SESSION['term_data'] as $value) { ?>
                                                    <?php $selected = ($value->term_id == $_SESSION['term_active']->term_id) ? 'selected' : ''; ?>
                                                    <?php $current = ($value->term_id == $_SESSION['term_active']->term_id) ? ' (ปัจจุบัน)' : ''; ?>
                                                    <option value="<?php echo $value->term_id ?>" <?php echo $selected ?>><?php echo $value->term_name . $current ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> -->
                                    <a href="dashboard_kru_print" target="_blank" class="col-md-2"><button id="printBtn" class="btn btn-success mt-4" style="width: 100%;">พิมพ์หน้านี้</button></a>
                                </div>
                                <div class="box-body no-padding mt-2">
                                    <?php
                                    $pro_id = $_SESSION['user_data']->province_am_id;
                                    $dis_id = $_SESSION['user_data']->district_am_id;
                                    ?>
                                    <table class="table-striped" data-toggle="table" id="table-d-kru2" data-minimum-count-columns="2" data-pagination="true" ata-page-list="[10, 25, 50, 100, all]" data-id-field="id" data-side-pagination="server" data-url="controllers/am_controller?getDataDashboardKru=true&term_id=<?php echo $_SESSION['term_active']->term_id ?>" data-locale="th-TH">
                                        <thead class="bg-dark">
                                            <tr>
                                                <th data-valign="middle" rowspan="2" data-align="center" data-width="20px" data-formatter="formatCounter">ลำดับ</th>
                                                <th data-field="std_name" rowspan="2" data-valign="middle" data-align="left" data-width="200px">ชื่อ-สกุล</th>
                                                <th data-field="phone" data-align="center" rowspan="2" data-valign="middle" data-align="left" data-width="50px">หมายเลขโทรศัพท์</th>
                                                <th data-field="hours" rowspan="2" data-valign="middle" data-align="center" data-width="50px">กพช.</th>
                                                <th data-valign="middle" rowspan="2" data-align="center" data-width="50px" data-formatter="formatEstimate">ผลการประเมิน</th>
                                                <th data-field="status_text" rowspan="2" data-valign="middle" data-align="center" data-width="50px">ผลสอบ N NET</th>
                                                <th data-valign="middle" colspan="3" data-align="center" data-width="40px">หน่วยกิต</th>
                                                <th data-valign="middle" rowspan="2" data-align="center" data-width="50px" data-formatter="formatButtonViewData">ผลการเรียน</th>
                                            </tr>
                                            <tr>
                                                <th data-field="cc" data-valign="middle" data-align="center" data-width="40px">วิชาบังคับ</th>
                                                <th data-field="ce" data-valign="middle" data-align="center" data-width="40px">วิชาบังคับเลือก</th>
                                                <th data-field="cfe" data-valign="middle" data-align="center" data-width="40px">วิชาเลือกเสรี</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>

                        <!-- <div class="row mt-4">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="col-md-12 row justidy-content-center">
                                    <div class="col-md-4 mt-2 mb-2 text-center">
                                        <a href="../student_list?url=main_dashboard">
                                            <h4 class="text-info"><b>รายชื่อนักศึกษา</b></h4>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mt-2 mb-2 text-center">
                                        <a href="dashboard_index?url=main_dashboard">
                                            <h4 class="text-info"><b>แดชบอร์ดภาพรวมข้อมูล</b></h4>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mt-2 mb-2 text-center">
                                        <a href="../main_menu?index_menu=<?php echo $_SESSION['index_menu'] ?>">
                                            <h4 class="text-info"><b>เข้าสู่หน้าเมนูหลัก</b></h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div> -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.18.3/bootstrap-table.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.18.3/extensions/print/bootstrap-table-print.min.js"></script>
    <script src="js/am_dashboard.js?v=<?php echo $version ?>"></script>
    <?php include '../admin/js/prodissub.js.php'; ?>
    <script>
        const $tableDam = $("#table-d-kru");

        function formatCounter(data, row, index) {
            const options = $tableDam.bootstrapTable("getOptions");
            const currentPage = options.pageNumber;
            let itemsPerPage = options.pageSize;
            if (itemsPerPage == "All") {
                const data = $tableDam.bootstrapTable("getData");
                itemsPerPage = data.length;
            }
            const offset = (currentPage - 1) * itemsPerPage;
            return index + 1 + offset;
        }

        $(document).ready(function() {
            getdatacount();
        });

        function getdatacount() {
            showLoader('table-d-kru', 6); // Show loader before starting AJAX request
            $.ajax({
                type: "POST",
                url: "../student-tracking/controllers/dashboard_controller",
                data: {
                    getdatacountDashboard: true,
                },
                dataType: 'json',
                success: function(json_res) {
                    $('#table-d-kru').bootstrapTable('load', json_res.data);
                    hideLoader('table-d-kru'); // Show loader before starting AJAX request
                },
            });
        }

        // Function to show the loader in the table body
        function showLoader(id, colspan = 18) {
            $('#' + id + ' tbody').html('<tr><td colspan="' + colspan + '" class="text-center">กำลังโหลดข้อมูล กรุณารอสักครู่...</td></tr>'); // Adjust colspan as needed
        }

        // Function to hide the loader in the table body
        function hideLoader(id) {
            $('#' + id + ' tbody').find('tr:has(td:contains("กำลังโหลดข้อมูล กรุณารอสักครู่..."))').remove();
        }


        let printWindow = null; // Track the print window
        $('#printBtn').click(function() {
            // If the print window is already open, focus it and return
            if (printWindow && !printWindow.closed) {
                printWindow.focus();
                return;
            }

            // Clone the table element
            var table = document.getElementById('table-d-kru');
            var tableClone = table.cloneNode(true);

            // Remove the 'table-striped' class and thead styles from the clone
            tableClone.classList.remove('table-striped');
            var thead = tableClone.querySelector('thead');
            if (thead) {
                thead.style.backgroundColor = '';
                thead.style.color = '';
            }

            // Create a new window and print the cloned table
            printWindow = window.open('', '', 'height=500,width=800');
            printWindow.document.write('<html><head><title>ข้อมูลนักศึกษา <?php echo $data->u_name . " " . $data->surname ?> ภาคเรียนที่ <?php echo $term ?> ปีการศึกษา <?php echo $year ?></title>');
            printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
            printWindow.document.write('</head><body>');
            printWindow.document.write(tableClone.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            printWindow.focus();
            printWindow.print();

            // Attempt to close the print window after a delay
            setTimeout(function() {
                if (printWindow && !printWindow.closed) {
                    printWindow.close();
                }
            }, 100); // Adjust the timeout as needed
        });
    </script>

    <script>
        const $tableDKru = $("#table-d-kru2");
        $(document).ready(async function() {
            $("#term_select").select2();
        });

        $('#std_class').on('change', () => getDatauserByStdClass());

        $('#term_select').on('change', () => getDatauserByStdClass());

        const getDatauserByStdClass = () => {
            let paramPlus = "";
            let std_class = $('#std_class').val();
            let term_id = $('#term_select').val();

            var urlWithParams = $tableDKru.data('url') + `&std_class=${std_class}&term_id=${term_id}`;
            $tableDKru.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }


        function formatCounter(data, row, index) {
            const options = $tableDKru.bootstrapTable("getOptions");
            const currentPage = options.pageNumber;
            let itemsPerPage = options.pageSize;
            if (itemsPerPage == "All") {
                const data = $tableDKru.bootstrapTable("getData");
                itemsPerPage = data.length;
            }
            const offset = (currentPage - 1) * itemsPerPage;
            return index + 1 + offset;
        }

        function formatButtonViewData(data, row) {
            let html = "-";
            if (row.count_cre > 0) {
                html = `<a target="_blank" href="manage_credit_new_view?mode=view&std_id=${row.std_id}" style="display: flex; justify-content: center; align-items: center;">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-info mb-5 mt-1" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;">
                        <i class="ti-eye" style="font-size: 14px;"></i>
                    </button>
                </a>`;
            }
            return html;
        }

        function formatEstimate(data, element) {
            let resultSum = 0;
            let sum1 = parseInt(element.side1) + parseInt(element.side2) + parseInt(element.side3);
            sum1 = (sum1 / 300) * 100;
            sum1 = sum1.toFixed()

            let sum2 = parseInt(element.side4) + parseInt(element.side5) + parseInt(element.side6);
            sum2 = (sum2 / 300) * 100;
            sum2 = sum2.toFixed()

            let sum3 = parseInt(element.side7) + parseInt(element.side8) + parseInt(element.side9);
            sum3 = (sum3 / 300) * 100;
            sum3 = sum3.toFixed()

            let sum4 = parseInt(element.side10) + parseInt(element.side11);
            sum4 = (sum4 / 200) * 100;
            sum4 = sum4.toFixed()

            let sumAll = (parseInt(sum1) + parseInt(sum2) + parseInt(sum3) + parseInt(sum4))
            sumAll = ((sumAll / 400) * 100).toFixed();
            if (parseFloat(sumAll)) {
                let sumAllText = calculateStatus(sumAll);
                return sumAllText;
            }

        }

        function calculateStatus(sumAll) {
            let msg = "ปรับปรุง";
            if (sumAll >= 90) {
                msg = "ดีมาก";
            } else if (sumAll >= 70) {
                msg = "ดี";
            } else if (sumAll >= 50) {
                msg = "พอใช้";
            }
            return msg;
        }
    </script>
</body>

</html>