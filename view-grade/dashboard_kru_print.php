<!DOCTYPE html>
<html lang="en">

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

    .fixed-table-toolbar {
        padding: 0;
    }
</style>
</head>

<body>
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body no-padding">
                                    <table data-toggle="table" id="table-d-kru" data-minimum-count-columns="2" data-pagination="false" data-id-field="id" data-side-pagination="server" data-url="controllers/am_controller?getDataDashboardKru=true" data-locale="th-TH">
                                        <thead>
                                            <tr>
                                                <th data-valign="middle" rowspan="2" data-align="center" data-width="20px" data-formatter="formatCounter">ลำดับ</th>
                                                <th data-field="std_name" rowspan="2" data-valign="middle" data-align="left" data-width="200px">ชื่อ-สกุล</th>
                                                <th data-field="phone" data-align="center" rowspan="2" data-valign="middle" data-align="left" data-width="50px">หมายเลขโทรศัพท์</th>
                                                <th data-field="hours" rowspan="2" data-valign="middle" data-align="center" data-width="50px">กพช.</th>
                                                <th data-valign="middle" rowspan="2" data-align="center" data-width="50px" data-formatter="formatEstimate">ผลการประเมิน</th>
                                                <th data-field="status_text" rowspan="2" data-valign="middle" data-align="center" data-width="50px">ผลสอบ N NET</th>
                                                <th data-valign="middle" colspan="3" data-align="center" data-width="40px">หน่วยกิต</th>
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

            </div>
        </div>
        <!-- /.content-wrapper -->

        <?php include '../include/footer.php'; ?>
        <!-- Vendor JS -->
        <script src="../assets/js/vendors.min.js"></script>
        <script src="../assets/icons/feather-icons/feather.min.js"></script>

        <!-- Florence Admin App -->
        <script src="../assets/js/template.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
        <script src="js/main.js?v=<?php $version ?>"></script>
        <script src="../assets/vendor_components/select2/dist/js/select2.full.js"></script>

        <!-- <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script> -->
        <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table-locale-all.min.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/export/bootstrap-table-export.min.js"></script>
        <script>
            const $tableDKru = $("#table-d-kru");

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

            $(document).ready(function() {
                const $tableDKru = $("#table-d-kru");

                $tableDKru.on('load-success.bs.table', function() {
                    // Trigger the print dialog after the table data has been fully loaded
                    setTimeout(() => {
                        window.print();
                    }, 500);
                });
            });
        </script>
    </div>
</body>

</html>