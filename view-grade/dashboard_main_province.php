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

        /* Target specific th by using nth-child (e.g., first column) */
        #table-d-am thead tr:nth-child(1) th:nth-child(3),
        #table-d-am2 thead tr:nth-child(1) th:nth-child(3) {
            background-color: #ff733b;
            /* Light gray background for first column */
        }

        /* Target specific th by using nth-child (e.g., first column) */
        #table-d-am thead tr:nth-child(1) th:nth-child(4),
        #table-d-am2 thead tr:nth-child(1) th:nth-child(4) {
            background-color: #fcba03;
            /* Light gray background for first column */
        }

        /* Target specific th by using nth-child (e.g., first column) */
        #table-d-am thead tr:nth-child(1) th:nth-child(5),
        #table-d-am2 thead tr:nth-child(1) th:nth-child(5) {
            background-color: #4d76ff;
            /* Light gray background for first column */
        }

        /* Target specific th by using nth-child (e.g., first column) */
        #table-d-am thead tr:nth-child(1) th:nth-child(6) {
            background-color: #50d95c;
            /* Light gray background for first column */
        }

        /* Target specific th by using nth-child (e.g., first column) */
        #table-d-am2 thead tr:nth-child(1) th:nth-child(6) {
            background-color: #50d95c;
            /* Light gray background for first column */
        }

        /* #table-d-am tbody tr:last-child {
            background-color: red;
            font-weight: bold;
        } */

        #table-d-am tbody tr td:last-child {
            background-color: #50d95c;
            /* Light blue background */
        }

        /* #table-d-am2 tbody tr:last-child {
            background-color: red;
            font-weight: bold;
        } */
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
                    "tp.id pro_id,tp.name_th pro_name\n" .
                    "FROM\n" .
                    "tb_users u\n" .
                    "LEFT JOIN tbl_provinces tp on u.province_am_id = tp.id\n" .
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
                                <h4><b>สกร.ประจำจังหวัด <?php echo $data->pro_name ?></b></h4>
                                <h4><b>แสดงจำนวนนักศึกษา ภาคเรียนที่ <?php echo $term ?> ปีการศึกษา <?php echo $year ?></b></h4>
                            </div>
                        </div>
                    </div>
                    <div class="container">

                        <div class="row">
                            <div class="col-md-2 px-4 row justify-content-between">
                                <div class="mt-2 mb-2">
                                    <a href="../main_menu?index_menu=<?php echo $_SESSION['index_menu'] ?>">
                                        <h5 class="text-info"><b>เข้าสู่หน้าเมนูหลัก</b></h5>
                                    </a>
                                </div>
                                <!-- <div class="mt-2 mb-2">
                                    <a href="dashboard?url=main_dashboard">
                                        <h5 class="text-info"><b>ข้อมูลระบบสืบค้นผลการเรียน</b></h5>
                                    </a>
                                </div> -->
                            </div>
                            <button id="printBtn" class="col-md-2 btn btn-primary mb-3">พิมพ์หน้านี้</button>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table-striped" data-toggle="table" id="table-d-am" data-locale="th-TH">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" data-valign="middle" data-align="center" data-width="20px" data-formatter="formatCounter">ลำดับ</th>
                                            <th data-field="edu_name" data-valign="middle" rowspan="2" data-align="left" data-width="200px">อำเภอ</th>
                                            <th colspan="3" data-valign="middle" data-align="center" data-width="200px">ประถม</th>
                                            <th colspan="3" data-valign="middle" data-align="center" data-width="200px">ม.ต้น</th>
                                            <th colspan="3" data-valign="middle" data-align="center" data-width="200px">ม.ปลาย</th>
                                            <th data-field="sumall" data-align="center" rowspan="2" data-valign="middle" data-align="center" data-width="50px">รวม</th>
                                        </tr>
                                        <tr>
                                            <th data-field="pratom_male" data-valign="middle" data-align="center" data-width="40px">ชาย</th>
                                            <th data-field="pratom_female" data-valign="middle" data-align="center" data-width="40px">หญิง</th>
                                            <!-- <th data-field="pratom_break" data-valign="middle" data-align="center" data-width="40px">พักการเรียน</th>
                                            <th data-field="pratom_finish" data-valign="middle" data-align="center" data-width="40px">จบการศึกษา</th> -->
                                            <th data-field="pratom_sum" data-valign="middle" data-align="center" data-width="40px">รวม</th>

                                            <th data-field="mt_male" data-valign="middle" data-align="center" data-width="40px">ชาย</th>
                                            <th data-field="mt_female" data-valign="middle" data-align="center" data-width="40px">หญิง</th>
                                            <!-- <th data-field="mt_break" data-valign="middle" data-align="center" data-width="40px">พักการเรียน</th>
                                            <th data-field="mt_finish" data-valign="middle" data-align="center" data-width="40px">จบการศึกษา</th> -->
                                            <th data-field="mt_sum" data-valign="middle" data-align="center" data-width="40px">รวม</th>

                                            <th data-field="mp_male" data-valign="middle" data-align="center" data-width="40px">ชาย</th>
                                            <th data-field="mp_female" data-valign="middle" data-align="center" data-width="40px">หญิง</th>
                                            <!-- <th data-field="mp_break" data-valign="middle" data-align="center" data-width="40px">พักการเรียน</th>
                                            <th data-field="mp_finish" data-valign="middle" data-align="center" data-width="40px">จบการศึกษา</th> -->
                                            <th data-field="mp_sum" data-valign="middle" data-align="center" data-width="40px">รวม</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 50px;">
                            <button id="printBtn2" class="col-md-3 btn btn-primary mb-3">พิมพ์จำนวนการจบของนักศึกษา</button>
                            <div class="col-md-2 mt-1">
                                <div class="form-group mb-0">
                                    <select class="form-control select2" name="term_select" id="term_select" style="width: 100%;" onchange="getDataListStd()">
                                        <!-- <option value="0">เลือกปีการศึกษา</option> -->
                                        <?php foreach ($_SESSION['term_data'] as $value) { ?>
                                            <?php $selected = ($value->term_id == $_SESSION['term_active']->term_id) ? 'selected' : ''; ?>
                                            <?php $current = ($value->term_id == $_SESSION['term_active']->term_id) ? ' (ปัจจุบัน)' : ''; ?>
                                            <option value="<?php echo $value->term_id ?>" <?php echo $selected ?>><?php echo $value->term_name . $current ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table-striped" data-toggle="table" id="table-d-am2" data-locale="th-TH">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" data-valign="middle" data-align="center" data-width="20px" data-formatter="formatCounter">ลำดับ</th>
                                            <th data-field="edu_name" data-valign="middle" rowspan="2" data-align="left" data-width="200px">อำเภอ</th>
                                            <th colspan="3" data-valign="middle" data-align="center" data-width="200px">ประถม</th>
                                            <th colspan="3" data-valign="middle" data-align="center" data-width="200px">ม.ต้น</th>
                                            <th colspan="3" data-valign="middle" data-align="center" data-width="200px">ม.ปลาย</th>
                                        </tr>
                                        <tr>
                                            <th data-field="pratom_test_result" data-valign="middle" data-align="center" data-width="40px">มีสิทธิ์สอบ</th>
                                            <th data-field="pratom_gradiate" data-valign="middle" data-align="center" data-width="40px">คาดว่าจะจบ</th>
                                            <th data-field="pratom_std_finish" data-valign="middle" data-align="center" data-width="40px">จบการศึกษา</th>

                                            <th data-field="mt_test_result" data-valign="middle" data-align="center" data-width="40px">มีสิทธิ์สอบ</th>
                                            <th data-field="mt_gradiate" data-valign="middle" data-align="center" data-width="40px">คาดว่าจะจบ</th>
                                            <th data-field="mt_std_finish" data-valign="middle" data-align="center" data-width="40px">จบการศึกษา</th>

                                            <th data-field="mp_test_result" data-valign="middle" data-align="center" data-width="40px">มีสิทธิ์สอบ</th>
                                            <th data-field="mp_gradiate" data-valign="middle" data-align="center" data-width="40px">คาดว่าจะจบ</th>
                                            <th data-field="mp_std_finish" data-valign="middle" data-align="center" data-width="40px">จบการศึกษา</th>
                                        </tr>
                                    </thead>
                                </table>
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

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.18.3/bootstrap-table.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.18.3/extensions/print/bootstrap-table-print.min.js"></script>
    <script>
        const $tableDam = $("#table-d-am");

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
            getDataListStd();
        });

        function getdatacount() {
            showLoader('table-d-am', 18); // Show loader before starting AJAX request
            $.ajax({
                type: "POST",
                url: "../student-tracking/controllers/dashboard_controller",
                data: {
                    getdatacountProvinceDashboard: true,
                    province_id: '<?php echo $data->pro_id ?>',
                },
                dataType: 'json',
                success: function(json_res) {
                    $('#table-d-am').bootstrapTable('load', json_res.data);
                    let total = json_res.total;
                    $('#table-d-am').append(`
                        <tr  class="text-center" style="background-color: red;font-weight: bold;">
                            <td colspan="2">${total.edu_name}</td>
                            <td>${total.pratom_male}</td>
                            <td>${total.pratom_female}</td>
                            <!--<td>${total.pratom_break}</td>-->
                            <!--<td>${total.pratom_finish}</td> -->
                            <td>${total.pratom_sum}</td>
                            <td>${total.mt_male}</td>
                            <td>${total.mt_female}</td>
                            <!--<td>${total.mt_break}</td> -->
                            <!--<td>${total.mt_finish}</td>-->
                            <td>${total.mt_sum}</td>
                            <td>${total.mp_male}</td>
                            <td>${total.mp_female}</td>
                            <!--<td>${total.mp_break}</td> -->
                            <!--<td>${total.mp_finish}</td>-->
                            <td>${total.mp_sum}</td>
                            <td style="background-color: yellow;font-weight: bold;">${total.sumall}</td>
                        </tr>
                    `)
                    hideLoader('table-d-am'); // Show loader before starting AJAX request
                },
            });
        }

        function getDataListStd() {
            showLoader('table-d-am2', 11); // Show loader before starting AJAX request
            let term_id = $("#term_select").val();
            $.ajax({
                type: "POST",
                url: "../student-tracking/controllers/dashboard_controller",
                data: {
                    getDataListStdProvinceDashboard: true,
                    province_id: '<?php echo $data->pro_id ?>',
                    term_id: term_id
                },
                dataType: 'json',
                success: function(json_res) {
                    console.log(json_res);
                    $('#table-d-am2').bootstrapTable('load', json_res.data);
                    let total = json_res.total;
                    $('#tr_sum').remove();
                    $('#table-d-am2').append(`
                        <tr  class="text-center" id="tr_sum" style="background-color: red;font-weight: bold;">
                            <td colspan="2">${total.edu_name}</td>
                            <td>${total.pratom_test_result}</td>
                            <td>${total.pratom_gradiate}</td>
                            <td>${total.pratom_std_finish}</td>
                            <td>${total.mt_test_result}</td>
                            <td>${total.mt_gradiate}</td>
                            <td>${total.mt_std_finish}</td>
                            <td>${total.mp_test_result}</td>
                            <td>${total.mp_gradiate}</td>
                            <td>${total.mp_std_finish}</td>
                        </tr>
                    `)
                    hideLoader('table-d-am2');
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
            var table = document.getElementById('table-d-am');
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
            printWindow.document.write('<html><head><title>ข้อมูลนักศึกษา จังหวัด <?php echo $data->pro_name ?> ภาคเรียนที่ <?php echo $term ?> ปีการศึกษา <?php echo $year ?></title>');
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


        let printWindow2 = null; // Track the print window
        $('#printBtn2').click(function() {
            // If the print window is already open, focus it and return
            if (printWindow2 && !printWindow2.closed) {
                printWindow2.focus();
                return;
            }

            // Clone the table element
            var table = document.getElementById('table-d-am2');
            var tableClone = table.cloneNode(true);

            // Remove the 'table-striped' class and thead styles from the clone
            tableClone.classList.remove('table-striped');
            var thead = tableClone.querySelector('thead');
            if (thead) {
                thead.style.backgroundColor = '';
                thead.style.color = '';
            }

            // Create a new window and print the cloned table
            printWindow2 = window.open('', '', 'height=500,width=800');
            printWindow2.document.write('<html><head><title>ข้อมูลนักศึกษา จังหวัด <?php echo $data->pro_name ?> ภาคเรียนที่ <?php echo $term ?> ปีการศึกษา <?php echo $year ?></title>');
            printWindow2.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
            printWindow2.document.write('</head><body>');
            printWindow2.document.write(tableClone.outerHTML);
            printWindow2.document.write('</body></html>');
            printWindow2.document.close();

            printWindow2.focus();
            printWindow2.print();

            // Attempt to close the print window after a delay
            setTimeout(function() {
                if (printWindow2 && !printWindow2.closed) {
                    printWindow2.close();
                }
            }, 100); // Adjust the timeout as needed
        });
    </script>
</body>

</html>