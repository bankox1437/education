<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แดชบอร์ดภาพรวมข้อมูล</title>
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
                                <input type="hidden" id="role_value" value="0">
                                <div class="row align-items-center mt-4">
                                    <div class="col-md-2 mt-4">
                                        <h4 class="mt-2 ml-3">แดชบอร์ดภาพรวมข้อมูล </h4>
                                    </div>
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
                                    <a href="dashboard_kru_print" target="_blank" class="col-md-1"><button id="printBtn" class="btn btn-success mt-4" style="width: 100%;">พิมพ์</button></a>
                                </div>
                                <div class="box-body no-padding">
                                    <?php
                                    $pro_id = $_SESSION['user_data']->province_am_id;
                                    $dis_id = $_SESSION['user_data']->district_am_id;
                                    ?>
                                    <table class="table-striped" data-toggle="table" id="table-d-kru" data-minimum-count-columns="2" data-pagination="true" ata-page-list="[10, 25, 50, 100, all]" data-id-field="id" data-side-pagination="server" data-url="controllers/am_controller?getDataDashboardKru=true&term_id=<?php echo $_SESSION['term_active']->term_id ?>" data-locale="th-TH">
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
    <script src="js/am_dashboard.js?v=<?php echo $version ?>"></script>
    <?php include '../admin/js/prodissub.js.php'; ?>
    <script>
        const $tableDKru = $("#table-d-kru");
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
                html = `<a target="_blank" href="manage_credit_new_view?mode=view&std_id=${row.std_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-info mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
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

        // let printWindow = null; // Track the print window

        // $('#printBtn').click(function() {
        //     // If the print window is already open, focus it and return
        //     if (printWindow && !printWindow.closed) {
        //         printWindow.focus();
        //         return;
        //     }

        //     // Clone the table element
        //     var table = document.getElementById('table-d-kru');
        //     var tableClone = table.cloneNode(true);

        //     // Remove the 'table-striped' class and thead styles from the clone
        //     tableClone.classList.remove('table-striped');
        //     var thead = tableClone.querySelector('thead');
        //     thead.classList.remove('bg-dark');
        //     var tbody = tableClone.querySelector('tbody');

        //     // Identify the "ผลการเรียน" column index by finding the header text
        //     var columnIndex = -1;
        //     if (thead) {
        //         let thCells = thead.querySelectorAll('th');
        //         for (let i = 0; i < thCells.length; i++) {
        //             if (thCells[i].textContent.includes('ผลการเรียน')) {
        //                 columnIndex = i;
        //                 break;
        //             }
        //         }
        //     }

        //     // If the column was found, remove the th and corresponding td elements
        //     if (columnIndex > -1) {
        //         // Remove the th (header) of the "ผลการเรียน" column
        //         if (thead) {
        //             for (let i = 0; i < 1; i++) {
        //                 let th = thead.rows[i].cells[columnIndex];
        //                 if (th) {
        //                     th.remove();
        //                 }
        //             }
        //         }

        //         columnIndex = columnIndex + 2;

        //         // Remove the corresponding td cells in tbody
        //         if (tbody) {
        //             for (let i = 0; i < tbody.rows.length; i++) {
        //                 let td = tbody.rows[i].cells[columnIndex];
        //                 if (td) {
        //                     td.remove();
        //                 }
        //             }
        //         }
        //     }

        //     // Create a new window and print the cloned table
        //     printWindow = window.open('', '', 'height=500,width=800');
        //     printWindow.document.write('<html><head><title>ข้อมูลนักศึกษา</title>');
        //     printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
        //     printWindow.document.write('</head><body>');
        //     printWindow.document.write(tableClone.outerHTML);
        //     printWindow.document.write('</body></html>');
        //     printWindow.document.close();

        //     // Ensure the print window closes after printing
        //     printWindow.onload = function() {
        //         printWindow.focus();
        //         printWindow.print();
        //     };

        //     printWindow.onafterprint = function() {
        //         printWindow.close();
        //     };
        // });



        // $('#printBtn').click(async function() {
        //     var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

        //     // Clone the table element
        //     var table = document.getElementById('table-d-kru');
        //     var tableClone = table.cloneNode(true);

        //     // Remove the 'table-striped' class and thead styles from the clone
        //     tableClone.classList.remove('table-striped');
        //     var thead = tableClone.querySelector('thead');
        //     thead.classList.remove('bg-dark');
        //     var tbody = tableClone.querySelector('tbody');

        //     // Identify the "ผลการเรียน" column index by finding the header text
        //     var columnIndex = -1;
        //     if (thead) {
        //         let thCells = thead.querySelectorAll('th');
        //         for (let i = 0; i < thCells.length; i++) {
        //             if (thCells[i].textContent.includes('ผลการเรียน')) {
        //                 columnIndex = i;
        //                 break;
        //             }
        //         }
        //     }

        //     // If the column was found, remove the th and corresponding td elements
        //     if (columnIndex > -1) {
        //         if (thead) {
        //             let th = thead.rows[0].cells[columnIndex];
        //             if (th) {
        //                 th.remove();
        //             }
        //         }

        //         columnIndex = columnIndex + 2;

        //         if (tbody) {
        //             for (let i = 0; i < tbody.rows.length; i++) {
        //                 let td = tbody.rows[i].cells[columnIndex];
        //                 if (td) {
        //                     td.remove();
        //                 }
        //             }
        //         }
        //     }

        //     // Hide other elements on the page except for the .box
        //     var otherElements = document.querySelectorAll('body > *:not(.box)');
        //     otherElements.forEach(el => {
        //         el.style.visibility = 'hidden';
        //     });

        //     // Show only the cloned table for printing
        //     document.body.appendChild(tableClone);

        //     // Adjustments for mobile if needed
        //     if (isMobile) {
        //         document.body.style.width = '100%';
        //         document.body.style.overflowX = 'auto';
        //     }

        //     // Trigger the print dialog
        //     await new Promise(resolve => setTimeout(resolve, 500)); // Wait for any possible rendering delays
        //     window.print();

        //     // Restore original visibility
        //     otherElements.forEach(el => {
        //         el.style.visibility = 'visible';
        //     });

        //     // Remove the cloned table from the DOM
        //     tableClone.remove();

        //     // Reset body styles
        //     document.body.style.width = '';
        //     document.body.style.overflowX = '';
        // });
    </script>
</body>

</html>