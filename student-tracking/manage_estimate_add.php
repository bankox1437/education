<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการข้อมูลประเมินคุณธรรมนักศึกษา</title>
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
                                <div class="box-header with-border ">
                                    <h6 class="box-title text-info" style="margin: 0;">
                                        <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_estimate_index'"></i>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-envelope mr-15"></i>
                                        <b>ฟอร์มประเมินคุณธรรมนักศึกษา</b>
                                    </h6>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <div class="row m-2">
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label><b>ค้นหาด้วยชั้น</b></label>
                                                <select class="form-control" name="std_class" id="std_class" data-placeholder="ชั้น" style="width: 100%;" onchange="getDataStd_new(this.value, $('#year').val())">
                                                    <option value="ประถม">ประถม</option>
                                                    <option value="ม.ต้น">ม.ต้น</option>
                                                    <option value="ม.ปลาย">ม.ปลาย</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><b>เลือกนักศึกษา <span class="text-danger">*</span></b></label>
                                                <select class="form-control select2" name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;">
                                                </select>
                                                <input type="hidden" id="std_id">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label><b>ปีการศึกษา <span class="text-danger">*</span></b></label>
                                            <select class="form-control" id="year" onchange="getDataStd_new($('#std_class').val(), this.value)">
                                                <?php foreach ($_SESSION['term_data'] as $value) { ?>
                                                    <?php $selected = ($value->term_id == $_SESSION['term_active']->term_id) ? 'selected' : ''; ?>
                                                    <?php $current = ($value->term_id == $_SESSION['term_active']->term_id) ? ' (ปัจจุบัน)' : ''; ?>
                                                    <option value="<?php echo $value->term_id ?>" <?php echo $selected ?>><?php echo $value->term_name . $current ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="waves-effect waves-light btn btn-outline btn-primary" onclick="exampleData()">จำลอง</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" style="font-size: 14px;" id="table-estimate">
                                            <thead class="text-center">
                                                <tr>
                                                    <th style="width: 45%;">คุณธรรม/พฤติกรรมบ่งชี้</th>
                                                    <th style="width: 15%;">ผ่าน</th>
                                                    <th style="width: 15%;">ไม่ผ่าน</th>
                                                    <th style="width: 25%;">หลักฐานการประเมิน <span class="text-danger">*</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $mode = "add";
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
                                <div class="box-footer" id="footer_btn">
                                    <button class="btn btn-rounded btn-primary btn-outline" onclick="saveData()">
                                        <i class="ti-save-alt"></i> บันทึกข้อมูล
                                    </button>
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
        $(document).ready(function() {
            // getDataAdmin(0)
            if (role_id != 4) {
                $("#std_select").select2();
                getDataStd_new($("#std_class").val(), $("#year").val());
            }

            $($('.select2')[2]).change(function() {
                let value = $(this).val();
                $('.select2').each(function(index) {
                    if (index > 2) {
                        $(this).val(value); // Replace 'yourValue' with the value you want to set
                    }
                });

            })
        });

        function getDataStd_new(std_class = "", year = "") {
            $.ajax({
                type: "POST",
                url: "controllers/student_controller",
                data: {
                    getDataStudentEstimate: true,
                    std_class: std_class,
                    year: year,
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
        setDefaultArray(11, 16, "side1", 20);
        setDefaultArray(21, 25, "side2", 25);
        setDefaultArray(31, 35, "side3", 25);
        setDefaultArray(41, 46, "side4", 20);
        setDefaultArray(51, 56, "side5", 20);
        setDefaultArray(61, 66, "side6", 20);
        setDefaultArray(71, 75, "side7", 25);
        setDefaultArray(81, 85, "side8", 25);
        setDefaultArray(91, 95, "side9", 25);
        setDefaultArray(101, 103, "side10", 50);
        setDefaultArray(111, 113, "side11", 50);

        calculateValue()

        function setDefaultArray(start, end, array, value) {
            for (let i = 0; i < start; i++) {
                sideList[array][i] = 0;
            }

            for (let i = sideList[array].length; i < end; i++) {
                sideList[array][i] = value;
            }
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
                    std_select: $('#std_select').val(),
                    year: $('#year').val(),
                    jsonParamObj: JSON.stringify(jsonParamObj),
                    addEstimate: true,
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

        function exampleData() {
            let radioInput = $('input[type="radio"]');
            for (let i = 0; i < radioInput.length; i++) {
                if (radioInput[i].value != "0") {
                    radioInput[i].checked = true;
                }
            }

            let select2input = $('.select2')
            let select2inputremove = select2input.splice(2, (select2input.length - 1));
            for (let i = 0; i < select2inputremove.length; i++) {
                select2inputremove[i].value = Math.floor(Math.random() * (4 - 1 + 1)) + 1;;
            }

        }
    </script>
</body>

</html>