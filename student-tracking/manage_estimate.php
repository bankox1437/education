<?php
if (session_status() === PHP_SESSION_ACTIVE) {
} else {
    // Session is not active
    include 'include/check_login.php';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ประเมินคุณธรรมนักศึกษา</title>
    <style>
        .table tbody tr td {
            padding: 1px 5px;
        }

        .rotate {
            -webkit-transform: rotate(-180deg);
            -moz-transform: rotate(-180deg);
            -ms-transform: rotate(-180deg);
            -o-transform: rotate(-180deg);
            transform: rotate(-180deg);
            writing-mode: vertical-lr;
        }

        @media print {
            body {
                margin: 0;
                -webkit-print-color-adjust: exact;
                /* Fix for Chrome */
                color-adjust: exact;
                /* Fix for Firefox */
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
                font-size: 10px;
                /* Adjust the font size as needed */
            }

            th {
                background-color: #f2f2f2;
            }

            @page {
                margin: 10px;
            }
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php // include 'include/sidebar.php'; 
        ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <?php if ($_SESSION['user_data']->role_id != 3) {

                                            $pro = isset($_GET['pro']) ? "pro=" . $_GET['pro'] . "&" : '';
                                            $dis = isset($_GET['dis']) ? "dis=" . $_GET['dis'] . "&" : '';
                                            $sub = isset($_GET['sub']) ? "sub=" . $_GET['sub'] . "&" : '';
                                            $page_number = isset($_GET['page_number']) ? "page_number=" . $_GET['page_number'] : '';

                                        ?>
                                            <h4 class="box-title" style="margin: 0;">
                                                <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_estimate_index<?php echo '?' . $pro . $dis . $sub .  $page_number ?>'"></i>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-envelope mr-15"></i>
                                                <b>ข้อมูลประเมินคุณธรรมนักศึกษาของ&nbsp;<?php echo $_GET['name'] ?></b>
                                            </h4>
                                        <?php } else { ?>
                                            <h4 class="box-title">ข้อมูลประเมินคุณธรรมนักศึกษา</h4>
                                        <?php } ?>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-3 ml-2">
                                            <button type="button" class="waves-effect waves-light btn btn-primary mb-5 btn-swith-class" onclick="switchClass(0)">ประถม</button>
                                            <button type="button" class="waves-effect waves-light btn btn-secondary mb-5 btn-swith-class" onclick="switchClass(1)">ม.ต้น</button>
                                            <button type="button" class="waves-effect waves-light btn btn-secondary mb-5 btn-swith-class" onclick="switchClass(2)">ม.ปลาย</button>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control mt-1 mb-2" id="year" onchange="changeTerm(this)">
                                                <?php foreach ($_SESSION['term_data'] as $value) { ?>
                                                    <?php $selected = ($value->term_id == $_SESSION['term_active']->term_id) ? 'selected' : ''; ?>
                                                    <?php $current = ($value->term_id == $_SESSION['term_active']->term_id) ? ' (ปัจจุบัน)' : ''; ?>
                                                    <option value="<?php echo $value->term_id ?>" <?php echo $selected ?> data-term="<?php echo $value->term_name ?>"><?php echo $value->term_name . $current ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                            <a class="col-md-1" href="manage_estimate_add">
                                                <button type="button" class="waves-effect waves-light btn btn-success mb-5"><i class="ti-plus"></i>&nbsp;ประเมิน</button>
                                            </a>
                                        <?php } ?>
                                        <button type="button" class="waves-effect waves-light btn btn-info mb-5  col-md-2 ml-4" onclick="printPage()"><i class="ti-printer"></i>&nbsp;ปริ้นทั้งหมด</button>
                                    </div>
                                </div>
                                <div class="box-body no-padding content-print">
                                    <div class="table-responsive" style="overflow-x: auto;">
                                        <table class="table table-bordered table-striped" style="font-size: 10px;min-width: 120%;">
                                            <thead>
                                                <tr>
                                                    <th rowspan=" 2">#</th>
                                                    <th rowspan="2" class="text-center" style="width: 150px;">รหัสนักศึกษา</th>
                                                    <th rowspan="2" class="text-center" style="width: 200px;">ชื่อ-สกุล</th>
                                                    <th colspan="4" class="text-center">คุณธรรมเพื่อการพัฒนาตนเอง</th>
                                                    <th colspan="4" class="text-center">คุณธรรมเพื่อการพัฒนาการทำงาน</th>
                                                    <th colspan="4" class="text-center">คุณธรรมเพื่อการพัฒนาการอยู่ร่วมกันในสังคม</th>
                                                    <th colspan="3" class="text-center">คุณธรรมเพื่อการพัฒนาประเทศ</th>
                                                    <th rowspan="2" class="text-center">รวม</th>
                                                    <th rowspan="2" class="text-center" style="width: 60px;">ผลการประเมิน</th>
                                                    <?php
                                                    if ($_SESSION['user_data']->role_id == 3) { ?>
                                                        <th rowspan="2" class="text-center ops" style="width: 50px;">ปริ้น</th>
                                                        <th rowspan="2" class="text-center ops" style="width: 50px;">แก้ไข</th>
                                                        <th rowspan="2" class="text-center ops" style="width: 50px;">ลบ</th>
                                                    <?php  }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">ข้อ 1 (5)</th>
                                                    <th class="text-center">ข้อ 2 (4)</th>
                                                    <th class="text-center">ข้อ 3 (4)</th>
                                                    <th class="text-center">สรุป</th>

                                                    <th class="text-center">ข้อ 4 (5)</th>
                                                    <th class="text-center">ข้อ 5 (5)</th>
                                                    <th class="text-center">ข้อ 6 (5)</th>
                                                    <th class="text-center">สรุป</th>

                                                    <th class="text-center">ข้อ 7 (4)</th>
                                                    <th class="text-center">ข้อ 8 (4)</th>
                                                    <th class="text-center">ข้อ 9 (4)</th>
                                                    <th class="text-center">สรุป</th>

                                                    <th class="text-center">ข้อ 10 (2)</th>
                                                    <th class="text-center">ข้อ 11 (2)</th>
                                                    <th class="text-center">สรุป</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-body">
                                                <tr>
                                                    <td colspan="23" class="text-center">
                                                        <?php include "../include/loader_include.php"; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        $(document).ready(() => {
            getDataEstimate()
        });

        function getDataEstimate(className = 0, year = '') {
            if (year == '') {
                year = '<?php echo $_SESSION['term_active']->term_id; ?>';
            }
            $.ajax({
                type: "POST",
                url: "controllers/estimate_controller",
                data: {
                    getDataEstimate: true,
                    className: className,
                    year: year,
                    <?php if (isset($_GET['user_id'])) { ?>
                        userCreate: '<?php echo isset($_GET['user_id']) ? $_GET['user_id'] : 0 ?>'
                    <?php } ?>
                },
                dataType: "json",
                success: function(json_res) {
                    getHtmlData(json_res.rows, className);
                },
            });
        }

        function getHtmlData(data, className) {
            $('.btn-swith-class').each(function(index, ele) {
                if ($(this).hasClass('btn-primary')) {
                    $('#std_class_span').html($(this).text());
                    $('#header_class').html($(this).text());
                }
            })
            const htmlTable = document.getElementById('data-body');
            htmlTable.innerHTML = "";
            if (data.length == 0) {
                htmlTable.innerHTML += `<tr>
                                                <td colspan="23" class="text-center">
                                                    ยังไม่มีข้อมูล
                                                </td>
                                            </tr>`
                return;
            }

            let resultSum = 0;
            data.forEach((element, i) => {

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
                let sumAllText = calculateStatus(sumAll);

                resultSum += parseInt(sumAll);

                htmlTable.innerHTML += `
                    <tr>
                        <td class="text-center">${i+1}</td>
                        <td>${element.std_code}</td>
                        <td>${element.std_name}</td>
                        <td class="text-center">${element.side1}</td>
                        <td class="text-center">${element.side2}</td>
                        <td class="text-center">${element.side3}</td>
                        <td class="text-center"><b>${sum1}</b></td>

                        <td class="text-center">${element.side4}</td>
                        <td class="text-center">${element.side5}</td>
                        <td class="text-center">${element.side6}</td>
                        <td class="text-center"><b>${sum2}</b></td>

                        <td class="text-center">${element.side7}</td>
                        <td class="text-center">${element.side8}</td>
                        <td class="text-center">${element.side9}</td>
                        <td class="text-center"><b>${sum3}</b></td>

                        <td class="text-center">${element.side10}</td>
                        <td class="text-center">${element.side11}</td>
                        <td class="text-center"><b>${sum4}</b></td>

                        <td class="text-center"><b>${sumAll}</b></td>
                        <td class="text-center"><b>${sumAllText}</b></td>

                        ${role_id == 3 ? 
                            `
                            <td class="text-center ops">    
                                <a href="manage_estimate_print?estimate_id=${element.estimate_id}">
                                    <button style="width:30px;height:30px;" type="button" class="waves-effect waves-circle btn btn-circle btn-primary"><i class="ti-printer"></i></button>
                                </a>
                            </td>
                            <td class="text-center ops">    
                                <a href="manage_estimate_edit?estimate_id=${element.estimate_id}">
                                    <button style="width:30px;height:30px;" type="button" class="waves-effect waves-circle btn btn-circle btn-warning"><i class="ti-pencil-alt"></i></button>
                                </a>
                            </td>
                            <td class="text-center ops">
                                <button style="width:30px;height:30px;" type="button" class="waves-effect waves-circle btn btn-circle btn-danger" onclick="deleteEstimate(${element.estimate_id})"><i class="ti-trash"></i></button>
                            </td>` : ''
                        }
                    </tr>`;
            });


            resultSum = parseInt(resultSum);
            resultSum = parseInt((resultSum / (data.length * 100)) * 100);
            let resultSumText = calculateStatus(resultSum);

            htmlTable.innerHTML += `
                    <tr>
                        <td class="text-center py-2" colspan="18"><b>เฉลี่ยรวมระดับ <span id="std_class_span">${className == 0 ? 'ประถม' : className == 1 ? 'ม.ต้น' : 'ม.ปลาย'}</span> ปีการศึกษา <span id="year_span"><?php echo $_SESSION['term_active']->term_name; ?></span></b></td>
                        <td class="text-center py-2"><b>${resultSum}</b></td>
                        <td class="text-center py-2"><b>${resultSumText}</b></td>
                    </tr>`;

            var selectedOption = $('#year').find('option:selected')
            var attributeValue = $(selectedOption).attr('data-term');

            $('#year_span').html(attributeValue);
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

        let termSelectNow = 0;

        function switchClass(classIndex) {
            $('.btn-swith-class').each(function(index, ele) {
                if (index == classIndex) {
                    $(this).addClass('btn-primary')
                    $(this).removeClass('btn-secondary')
                } else {
                    if (!$(this).hasClass('btn-secondary')) {
                        $(this).addClass('btn-secondary')
                        $(this).removeClass('btn-primary')
                    } else {
                        $(this).removeClass('btn-primary')
                    }
                }
            })
            let year = $('#year').val();
            termSelectNow = classIndex;
            getDataEstimate(classIndex, year)
        }

        function changeTerm(year) {
            getDataEstimate(termSelectNow, year.value)
        }
    </script>

    <script>
        function deleteEstimate(estimate_id) {
            const confirmDelete = confirm('ต้องการลบข้อมูลประเมินนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/estimate_controller",
                    data: {
                        deleteEstimate: true,
                        estimate_id: estimate_id,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            location.reload();
                        } else {
                            alert(data.msg)
                        }
                    },
                });
            }
        }

        function printPage() {
            $('.table').css('min-width', '100%')
            $('.ops').hide();
            $('.box-header').hide();
            window.print();
        }

        window.addEventListener("afterprint", (event) => {
            $('.table').css('min-width', '120%')
            $('.ops').show();
            $('.box-header').show();
        });
    </script>
</body>

</html>