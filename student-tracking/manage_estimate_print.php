<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ประเมินคุณธรรมนักศึกษา</title>
    <style>
        #table-estimate td {
            padding: 5px 10px;
        }

        #table-estimate tbody td:nth-child(2) {
            align-items: center;
            cursor: pointer;
        }

        #table-estimate tbody td:nth-child(3) {
            align-items: center;
            cursor: pointer;
        }

        #table-estimate tbody label {
            padding: 0px;
            padding-right: 20px;
        }

        #table-estimate tbody td:nth-child(2):hover,
        #table-estimate tbody td:nth-child(3):hover {
            background: #c3c3c3;
            transition: all;
        }

        .border-red {
            border: 1px solid red;
        }

        .form-group {
            margin-bottom: 0;
        }
    </style>
    <script>
        const sideList = {
            "side1": [],
            "side2": [],
            "side3": [],
            "side4": [],
            "side5": [],
            "side6": [],
            "side7": [],
            "side8": [],
            "side9": [],
            "side10": [],
            "side11": []
        }
    </script>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT\n" .
                    "	es.*,\n" .
                    "	std_code,\n" .
                    "	CONCAT( std.std_prename, '', std.std_name ) std_name\n" .
                    "FROM\n" .
                    "	stf_tb_estimate es\n" .
                    "	LEFT JOIN tb_users u ON es.user_create = u.id\n" .
                    "	INNER JOIN tb_students std ON es.std_id = std.std_id\n" .
                    "	\n" .
                    "WHERE es.estimate_id = :estimate_id";
                $data = $DB->Query($sql, ['estimate_id' => $_GET['estimate_id']]);
                $estimate_data = json_decode($data);
                if (count($estimate_data) == 0) {
                    echo "<script>location.href = '../404' </script>";
                }
                $estimate_data = $estimate_data[0];

                $mode = "print";
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border ">
                                    <h6 class="box-title text-info" style="margin: 0;">
                                        <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_estimate_index'"></i>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-envelope mr-15"></i>
                                        <b>ปริ้นประเมินคุณธรรมนักศึกษา</b>&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-dark"></span>
                                    </h6>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <div class="row m-2">
                                        <div class="col-md-12 d-flex justify-content-center">
                                            <?php
                                            $term_year = "";
                                            foreach ($_SESSION['term_data'] as $value) {
                                                if ($value->term_id == $estimate_data->year) {
                                                    $term_year = $value->term_name;
                                                    break;
                                                }
                                            } ?>
                                            <h4 class="text-center mt-2"><?php echo $estimate_data->std_code . " - " . $estimate_data->std_name ?> ปีการศึกษา <?php echo $term_year ?></h4>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" style="font-size: 14px;" id="table-estimate">
                                            <thead class="text-center">
                                                <tr>
                                                    <th style="width: 45%;">คุณธรรม/พฤติกรรมบ่งชี้</th>
                                                    <th style="width: 15%;">ผ่าน</th>
                                                    <th style="width: 15%;">ไม่ผ่าน</th>
                                                    <th style="width: 25%;">หลักฐานการประเมิน</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include("include/estimate/side1.php");
                                                include("include/estimate/side2.php");
                                                include("include/estimate/side3.php");
                                                include("include/estimate/side4.php");
                                                include("include/estimate/side5.php");
                                                include("include/estimate/side6.php");
                                                include("include/estimate/side7.php");
                                                include("include/estimate/side8.php");
                                                include("include/estimate/side9.php");
                                                include("include/estimate/side10.php");
                                                include("include/estimate/side11.php");
                                                ?>

                                                <tr>
                                                    <td class="text-center"><b>สรุปในภาพรวม</b></td>
                                                    <td colspan="3" class="text-center"><b id="sum_all">0</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="display: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body text-center">โปรดรอสักครู่ . . .</div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <button type="button" class="btn btn-primary" id="modal-click" style="display: none;" data-toggle="modal" data-target=".bs-example-modal-sm"></button>

    <?php include 'include/scripts.php'; ?>
    <script>
        $(document).ready(() => {
            calculateValue()
            disableRadio()
            $('#modal-click').click()
            setTimeout(() => {
                $('.close').click()
                printPage()
            }, 2000);
        });

        function disableRadio() {
            let radioInput = $('input[type="radio"]');
            for (let i = 0; i < radioInput.length; i++) {
                radioInput[i].parentElement.parentElement.parentElement.removeAttribute('onclick');
                radioInput[i].disabled = true;
            }
        }

        function getDataStd_new() {
            $.ajax({
                type: "POST",
                url: "controllers/student_controller",
                data: {
                    getDataStudent: true,
                },
                dataType: "json",
                success: function(json_res) {
                    const std_select = document.getElementById("std_select");
                    std_select.innerHTML = "";
                    std_select.innerHTML += `<option value="0">เลือกนักศึกษา</option>`;
                    data_std = json_res.data
                    data_std.forEach((element, i) => {
                        std_select.innerHTML += `<option value="${element.std_id}">${element.std_code} - ${element.std_prename}${element.std_name}</option>`;
                    });
                },
            });
        }

        function checkedbehavior(side, name, id) {
            // Get the radio button element
            const radioButton = document.getElementById(id);

            // If the radio button is already checked, return
            if (radioButton.checked) {
                return;
            }

            // Check the radio button
            radioButton.checked = true;

            let key = "side" + side;

            // If id is in sideList[side], update its value based on isCorrect
            sideList[key][name] = $('input[name="' + name + '"]:checked').val();

            // Calculate the sum of scores in sideList[side]
            let sum_side = sideList[key].reduce((acc, curr) => {
                return parseInt(acc) + parseInt(curr);
            });
            $('#sum_side_' + side).html(sum_side);
            console.log(sideList);
            calculateValue()
        }

        function calculateValue() {
            let sum = 0;
            for (let i = 0; i < 11; i++) {
                sum += parseInt($('#sum_side_' + (i + 1)).html());
            }
            sum = (sum / 1100) * 100;
            $('#sum_all').html(parseInt(sum));
        }

        function saveData() {
            if ($('#std_select').val() == '0') {
                alert('โปรดเลือกนักศึกษา');
                $('#std_select').next('.select2-container').find('.select2-selection').focus();
                return;
            }
            if ($('#year').val() == '') {
                alert('โปรดกรอกปีการศึกษา');
                $('#year').focus();
                return;
            }
            let jsonParamObj = {}
            for (let i = 0; i < 11; i++) {
                if (getValueSide((i + 1))) {
                    jsonParamObj['side' + (i + 1)] = getValueSide((i + 1))
                } else {
                    return
                }
            }

            $.ajax({
                type: "POST",
                url: "controllers/estimate_controller",
                data: {
                    lastId: '<?php echo $_GET['estimate_id'] ?>',
                    jsonParamObj: JSON.stringify(jsonParamObj),
                    editEstimate: true,
                },
                dataType: "json",
                success: async function(json) {
                    console.log(json);
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = "manage_estimate_index";
                    } else {
                        alert(json.msg);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                },
            });
        }

        function getValueSide(side) {
            // Initialize an empty array to store the values
            let arrValueSide = [];

            // Flag to indicate if any radio button is unchecked
            let isRadioUnchecked = false;
            let msg = "";

            // Iterate over each row in the specified side
            $('.side_' + side).each(function(index, ele) {
                let values = {};
                values['side'] = side;
                values['sub_side'] = side + "." + (index + 1);
                values['estimate_det_id'] = $(this).find('input[type="hidden"]').val();
                // Get the selected radio button value
                const radio = $(this).find('input[type="radio"]:checked');
                if (radio.length > 0) {
                    values['checked'] = radio.val();
                } else {
                    // If a radio button is not checked, set the flag and return false
                    isRadioUnchecked = true;
                    $(this).find('input[type="radio"]').eq(0).focus(); // Focus on the first radio button in the row
                    msg = `โปรดประเมินข้อที่ ${side}.${index+1}`;
                    return false; // Exit the each loop
                }

                // Get the selected option from the <select> element
                const select = $(this).find('select');
                if (select.length > 0) {
                    if (select.val() == 0) {
                        isRadioUnchecked = true;
                        select.focus();
                        msg = `โปรดเลือกหลักฐานของข้อที่ ${side}.${index+1}`;
                        return false; // Exit the each loop
                    }
                    values['premise_select'] = select.val();
                }
                arrValueSide.push(values);
            });

            // Check if any radio button was unchecked
            if (isRadioUnchecked) {
                alert(msg);
                return false;
            }

            // Return the array containing the values
            return arrValueSide;
        }

        function printPage() {
            $('.box-header').hide();
            $('.box-footer').hide();
            setTimeout(() => {
                window.print();
            }, 1000);
        }

        window.addEventListener("afterprint", (event) => {
            $('.box-header').show();
            $('.box-footer').show();
            location.href = "manage_estimate_index";
        });
    </script>
</body>

</html>