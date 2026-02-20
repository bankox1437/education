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
            background-color: #e1e1e192;
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
                    "td.id dis_id,td.name_th dis_name\n" .
                    "FROM\n" .
                    "tb_users u\n" .
                    "LEFT JOIN tbl_district td on u.district_am_id = td.id\n" .
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
                                <h4><b>สกร.ระดับอำเภอ <?php echo $data->dis_name ?></b></h4>
                                <h4><b>แสดงจำนวนนักศึกษา ภาคเรียนที่ <?php echo $term ?> ปีการศึกษา <?php echo $year ?></b></h4>
                            </div>
                        </div>
                    </div>
                    <div class="container">

                        <div class="row">
                            <div class="col-md-2 row justidy-content-center">
                                <div class="col-md-12 mt-2 mb-2">
                                    <a href="../main_menu?index_menu=<?php echo $_SESSION['index_menu'] ?>">
                                        <h5 class="text-info"><b>เข้าสู่หน้าเมนูหลัก</b></h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">รายงานจำนวน นศ. ตามระดับชั้น</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">รายงานจำนวน สถานะการศึกษา ตามระดับชั้น</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <button id="printBtn" class="col-md-2 btn btn-primary mb-3 mt-3">พิมพ์หน้านี้</button>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table-striped" data-toggle="table" id="table-d-am" data-locale="th-TH">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" data-valign="middle" data-align="center" data-width="20px" data-formatter="formatCounter">ลำดับ</th>
                                                            <th data-field="edu_name" data-valign="middle" rowspan="2" data-align="left" data-width="200px">ตำบล</th>
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
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <button id="printBtn2" class="col-md-3 btn btn-primary mb-3 mt-3">พิมพ์จำนวนการจบของนักศึกษา</button>
                                            <div class="col-md-2 mt-4 mb-3">
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
                                                            <th data-field="edu_name" data-valign="middle" rowspan="2" data-align="left" data-width="200px">ตำบล</th>
                                                            <th colspan="3" data-valign="middle" data-align="center" data-width="200px">ประถม</th>
                                                            <th colspan="3" data-valign="middle" data-align="center" data-width="200px">ม.ต้น</th>
                                                            <th colspan="3" data-valign="middle" data-align="center" data-width="200px">ม.ปลาย</th>
                                                            <!-- <th data-field="sumall" data-align="center" rowspan="2" data-valign="middle" data-align="center" data-width="50px">รวม</th> -->
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
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
            $("#term_select").select2()
        });

        function getdatacount() {
            const tableBody = $('#table-d-am tbody');

            // Show loader before starting AJAX request
            showLoader('table-d-am', 12);

            $.ajax({
                type: "POST",
                url: "../student-tracking/controllers/dashboard_controller",
                data: {
                    getdatacountAmphurDashboard: true,
                    district_id: '<?php echo $data->dis_id ?>',
                },
                dataType: 'json',
                success: function(json_res) {
                    // Clear the table body first
                    tableBody.empty();

                    // Render the table body using the main rendering function
                    renderTableBody(tableBody, json_res.data, json_res.total);

                    // Hide loader after updating the table
                    hideLoader('table-d-am');
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors gracefully
                    console.error("AJAX Error:", status, error);
                    hideLoader('table-d-am');
                    alert('เกิดข้อผิดพลาดในการดึงข้อมูล กรุณาลองใหม่อีกครั้ง');
                }
            });
        }

        /**
         * Renders the content of the table body based on the provided data.
         * @param {jQuery} tableBodyElement - The jQuery object representing the tbody element.
         * @param {Array<Object>} eduData - An array of education data objects.
         * @param {Object} overallTotal - The overall total data object.
         */
        function renderTableBody(tableBodyElement, eduData, overallTotal) {
            let htmlContent = '';

            for (const key in eduData) {
                if (Object.prototype.hasOwnProperty.call(eduData, key)) {
                    const element = eduData[key];

                    // Add education category row
                    htmlContent += createEducationCategoryRow(key);

                    // Add list of educational data
                    element.forEach((list, index) => {
                        if (index != (element.length - 1)) {
                            htmlContent += createDetailRow('detail', list, index); // ใช้ createDetailRow
                        }
                    });

                    // Add total row for the current education category
                    htmlContent += createDetailRow('subtotal', element[element.length - 1]); // ใช้ createDetailRow
                }
            }

            // Add overall total row to the table
            htmlContent += createOverallTotalRow(overallTotal);

            // Append all generated HTML at once to the provided tbody element
            tableBodyElement.append(htmlContent);
        }

        /**
         * Creates an HTML table row for an education category.
         * @param {string} eduName - The name of the education category.
         * @returns {string} The HTML string for the education category row.
         */
        function createEducationCategoryRow(eduName) {
            return `
                <tr class="text-left" style="background-color: #71bdffb0; font-weight: bold; color: #000000;">
                    <td colspan="12">ตำบล${eduName}</td>
                </tr>
            `;
        }

        /**
         * Creates an HTML table row for detailed data or a sub-total.
         * @param {string} type - The type of row: 'detail' for individual list items, 'subtotal' for category totals.
         * @param {Object} rowData - The data object for the row (list item or total).
         * @param {number} [index] - Optional. The index of the item (for numbering 'detail' rows).
         * @returns {string} The HTML string for the detail or sub-total row.
         */
        function createDetailRow(type, rowData, index = 0) {
            let className = 'text-center';
            let style = '';
            let firstCellContent = '';

            if (type === 'detail') {
                firstCellContent = `<td class="text-center">${(index + 1)}</td>`;
                firstCellContent += `<td class="text-left">${rowData.kru}</td>`;
            } else if (type === 'subtotal') {
                className += ' bg-light-gray'; // คลาสใหม่สำหรับรวมย่อยเพื่อให้เห็นความแตกต่าง
                style = 'background-color: #c8c8c8de; color: #000000;';
                firstCellContent = `<td colspan="2">รวม</td>`;
            }

            return `
                <tr class="${className}" style="${style}">
                    ${firstCellContent}
                    <td ${rowData.pratom_male > 0 ? 'style="font-weight: bold;"' : ''}>${rowData.pratom_male}</td>
                    <td ${rowData.pratom_female > 0 ? 'style="font-weight: bold;"' : ''}>${rowData.pratom_female}</td>
                    <td ${rowData.pratom_sum > 0 ? 'style="font-weight: bold;"' : ''}>${rowData.pratom_sum}</td>
                    <td ${rowData.mt_male > 0 ? 'style="font-weight: bold;"' : ''}>${rowData.mt_male}</td>
                    <td ${rowData.mt_female > 0 ? 'style="font-weight: bold;"' : ''}>${rowData.mt_female}</td>
                    <td ${rowData.mt_sum > 0 ? 'style="font-weight: bold;"' : ''}>${rowData.mt_sum}</td>
                    <td ${rowData.mp_male > 0 ? 'style="font-weight: bold;"' : ''}>${rowData.mp_male}</td>
                    <td ${rowData.mp_female > 0 ? 'style="font-weight: bold;"' : ''}>${rowData.mp_female}</td>
                    <td ${rowData.mp_sum > 0 ? 'style="font-weight: bold;"' : ''}>${rowData.mp_sum}</td>
                    <td style="background-color: yellow; font-weight: bold; color: #000000;">${rowData.sumall}</td>
                </tr>
            `;
        }

        /**
         * Creates an HTML table row for the overall grand total.
         * @param {Object} overallTotal - The data object for the grand total.
         * @returns {string} The HTML string for the overall total row.
         */
        function createOverallTotalRow(overallTotal) {
            return `
                <tr class="text-center" style="background-color: #ff8787; font-weight: bold; color: #000000;">
                    <td colspan="2">${overallTotal.edu_name}</td>
                    <td>${overallTotal.pratom_male}</td>
                    <td>${overallTotal.pratom_female}</td>
                    <td>${overallTotal.pratom_sum}</td>
                    <td>${overallTotal.mt_male}</td>
                    <td>${overallTotal.mt_female}</td>
                    <td>${overallTotal.mt_sum}</td>
                    <td>${overallTotal.mp_male}</td>
                    <td>${overallTotal.mp_female}</td>
                    <td>${overallTotal.mp_sum}</td>
                    <td style="background-color: yellow; font-weight: bold; color: #000000;">${overallTotal.sumall}</td>
                </tr>
            `;
        }

        function getDataListStd() {
            showLoader('table-d-am2', 11); // Show loader before starting AJAX request
            const tableBody = $('#table-d-am2 tbody');
            let term_id = $("#term_select").val();
            $.ajax({
                type: "POST",
                url: "../student-tracking/controllers/dashboard_controller",
                data: {
                    getDataListStdAmphurDashboard: true,
                    district_id: '<?php echo $data->dis_id ?>',
                    term_id: term_id
                },
                dataType: 'json',
                success: function(json_res) {
                    let eduData = json_res.data;
                    let overallTotal = json_res.total;

                    let htmlContent = '';

                    // Clear the table body first
                    tableBody.empty();

                    for (const key in eduData) {
                        let className = 'text-center';
                        let style = '';
                        let firstCellContent = '';

                        if (Object.prototype.hasOwnProperty.call(eduData, key)) {
                            const element = eduData[key];
                            // Add education category row
                            htmlContent += `<tr class="text-left" style="background-color: #71bdffb0; font-weight: bold; color: #000000;">
                                                <td colspan="12">ตำบล${key}</td>
                                            </tr>
                                        `;

                            // Add list of educational data
                            element.forEach((list, index) => {
                                if (index != (element.length - 1)) {
                                    firstCellContent = `<td class="text-center">${(index + 1)}</td>`;
                                    firstCellContent += `<td class="text-left">${list.edu_name}</td>`;
                                } else {
                                    className += ' bg-light-gray'; // คลาสใหม่สำหรับรวมย่อยเพื่อให้เห็นความแตกต่าง
                                    style = 'background-color: #c8c8c8de; color: #000000;';
                                    firstCellContent = `<td colspan="2">รวม</td>`;
                                }

                                htmlContent += `<tr class="${className}" style="${style}">
                                                    ${firstCellContent}
                                                <td ${list.pratom_test_result > 0 ? 'style="font-weight: bold;"' : ''}>${list.pratom_test_result}</td>
                                                <td ${list.pratom_gradiate > 0 ? 'style="font-weight: bold;"' : ''}>${list.pratom_gradiate}</td>
                                                <td ${list.pratom_std_finish > 0 ? 'style="font-weight: bold;"' : ''}>${list.pratom_std_finish}</td>
                                                <td ${list.mt_test_result > 0 ? 'style="font-weight: bold;"' : ''}>${list.mt_test_result}</td>
                                                <td ${list.mt_gradiate > 0 ? 'style="font-weight: bold;"' : ''}>${list.mt_gradiate}</td>
                                                <td ${list.mt_std_finish > 0 ? 'style="font-weight: bold;"' : ''}>${list.mt_std_finish}</td>
                                                <td ${list.mp_test_result > 0 ? 'style="font-weight: bold;"' : ''}>${list.mp_test_result}</td>
                                                <td ${list.mp_gradiate > 0 ? 'style="font-weight: bold;"' : ''}>${list.mp_gradiate}</td>
                                                <td ${list.mp_std_finish > 0 ? 'style="font-weight: bold;"' : ''}>${list.mp_std_finish}</td>
                                                </tr>`;

                            });
                        }
                    }

                    // Add overall total row to the table
                    htmlContent += `<tr class="text-center" style="background-color: #ff8787; font-weight: bold; color: #000000;">
                                        <td colspan="2">${overallTotal.edu_name}</td>
                                        <td>${overallTotal.pratom_test_result}</td>
                                        <td>${overallTotal.pratom_gradiate}</td>
                                        <td>${overallTotal.pratom_std_finish}</td>
                                        <td>${overallTotal.mt_test_result}</td>
                                        <td>${overallTotal.mt_gradiate}</td>
                                        <td>${overallTotal.mt_std_finish}</td>
                                        <td>${overallTotal.mp_test_result}</td>
                                        <td>${overallTotal.mp_gradiate}</td>
                                        <td>${overallTotal.mp_std_finish}</td>
                                    </tr>
                                `;

                    // Append all generated HTML at once to the provided tbody element
                    tableBody.append(htmlContent);

                    // Hide loader after updating the table
                    hideLoader('table-d-am2');
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors gracefully
                    console.error("AJAX Error:", status, error);
                    hideLoader('table-d-am');
                    alert('เกิดข้อผิดพลาดในการดึงข้อมูล กรุณาลองใหม่อีกครั้ง');
                }
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
            printWindow.document.write('<html><head><title>ข้อมูลนักศึกษา อำเภอ <?php echo $data->dis_name ?> ภาคเรียนที่ <?php echo $term ?> ปีการศึกษา <?php echo $year ?></title>');
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
            printWindow2.document.write('<html><head><title>ข้อมูลนักศึกษา อำเภอ <?php echo $data->dis_name ?> ภาคเรียนที่ <?php echo $term ?> ปีการศึกษา <?php echo $year ?></title>');
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