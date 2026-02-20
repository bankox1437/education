<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>เพิ่มนักศึกษา</title>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .tooltip-custom {
            cursor: pointer;
            position: relative;
        }

        .tooltip-custom:before {
            content: attr(data-text);
            /* here's the magic */
            position: absolute;

            /* vertically center */
            top: 50%;
            transform: translateY(-50%);

            /* move to right */
            left: 100%;
            margin-left: 15px;
            /* and add a small left margin */

            /* basic styles */
            width: 200px;
            padding: 10px;
            border-radius: 10px;
            background: #5949d6;
            color: #fff;
            text-align: left;

            display: none;
            /* hide by default */
        }

        .tooltip-custom:hover:before {
            display: block;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='../student_list'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มเพิ่มนักศึกษา</b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form-add-std">
                                    <div class=" box-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>รหัสนักศึกษา <span class="text-danger">*</span></b></label>
                                                    <input type="text" name="std_code" id="std_code" class="form-control" placeholder="กรอกรหัสนักศึกษา">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>คำนำหน้าชื่อ <span class="text-danger">*</span></b></label>
                                                    <select class="form-control" name="std_prename" id="std_prename">
                                                        <option value="">เลือกคำนำหน้าชื่อ</option>
                                                        <option value="เด็กหญิง">เด็กหญิง</option>
                                                        <option value="เด็กชาย">เด็กชาย</option>
                                                        <option value="นางสาว">นางสาว</option>
                                                        <option value="นาง">นาง</option>
                                                        <option value="นาย">นาย</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>ชื่อ-สกุล <span class="text-danger">*</span></b></label>
                                                    <input type="text" name="std_name" id="std_name" class="form-control" placeholder="กรอกชื่อ-สกุล">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label><b>ชั้น <span class="text-danger">*</span></b></label>
                                                    <select class="form-control" name="std_class" id="std_class">
                                                        <option value="ประถม">ประถม</option>
                                                        <option value="ม.ต้น">ม.ต้น</option>
                                                        <option value="ม.ปลาย">ม.ปลาย</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label><b>เลขประจำตัวประชาชน <span class="text-danger">*</span></b></label>
                                                    <input type="text" maxlength="13" name="national_id" id="national_id" class="form-control" placeholder="กรอกเลขประจำตัวประชาชน">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>รหัสผ่าน <b class="text-danger">*</b></label>
                                                    <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                        type="number"
                                                        maxlength="8"
                                                        class="form-control height-input" maxlength="8" name="password" id="password" autocomplete="off" placeholder="กรุณากรอกรหัสผ่าน">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label><b>วันเกิด <span class="text-danger">*</span></b></label>
                                                    <select class="form-control" id="day_b">
                                                        <?php for ($i = 1; $i < 32; $i++) {
                                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label><b>เดือนเกิด <span class="text-danger">*</span></b></label>
                                                    <select class="form-control" id="month_b">
                                                        <?php
                                                        $months = [
                                                            "มกราคม",
                                                            "กุมภาพันธ์",
                                                            "มีนาคม",
                                                            "เมษายน",
                                                            "พฤษภาคม",
                                                            "มิถุนายน",
                                                            "กรกฎาคม",
                                                            "สิงหาคม",
                                                            "กันยายน",
                                                            "ตุลาคม",
                                                            "พฤศจิกายน",
                                                            "ธันวาคม"
                                                        ];
                                                        foreach ($months as $index => $month) {
                                                            echo '<option value="' . $month . '">' . $month . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label><b>ปีเกิด <span class="text-danger">*</span></b></label>
                                                    <input type="number" name="year_b" id="year_b" class="form-control" placeholder="กรอกปีเกิด">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                    </div>
                                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>

    <?php include 'include/scripts.php'; ?>
    <script>
        function verifyPassword(password) {
            // Check if password contains at least one lowercase letter and one digit
            const lowercaseRegex = /[a-z]/;
            const digitRegex = /\d/;
            const hasLowercase = lowercaseRegex.test(password);
            const hasDigit = digitRegex.test(password);

            // Check if password length is greater than or equal to 8
            const hasValidLength = password.length >= 8;
            const labelCheckPassword = document.getElementById("checkPassword");
            if (!hasLowercase) {
                //alert("รูปแบบรหัสผ่านต้องเป็นตัวพิมพ์เล็ก");
                labelCheckPassword.innerHTML = "รูปแบบรหัสผ่านต้องเป็นตัวพิมพ์เล็ก";
                labelCheckPassword.style.display = "block";
                return false;
            }
            if (!hasDigit) {
                labelCheckPassword.innerHTML = "รูปแบบรหัสผ่านต้องมีตัวเลข";
                labelCheckPassword.style.display = "block";
                return false;
            }
            if (!hasValidLength) {
                labelCheckPassword.innerHTML = "รูปแบบรหัสผ่านต้องมีอย่าง 8 ตัว";
                labelCheckPassword.style.display = "block";
                return false;
            }
            labelCheckPassword.style.display = "none";
            return hasLowercase && hasDigit && hasValidLength;
        }

        $('#form-add-std').submit((e) => {
            e.preventDefault();

            const std_code = document.getElementById('std_code');
            const std_prename = document.getElementById('std_prename');
            const std_name = document.getElementById('std_name');
            const std_class = document.getElementById('std_class');
            const national_id = document.getElementById('national_id');
            const password = document.getElementById('password');
            const day_b = document.getElementById('day_b');
            const month_b = document.getElementById('month_b');
            const year_b = document.getElementById('year_b');

            // Validation checks
            if (!std_code.value.trim()) {
                alert("กรุณากรอกรหัสนักศึกษา");
                std_code.focus();
                return;
            }
            if (!std_prename.value.trim()) {
                alert("กรุณาเลือกคำนำหน้าชื่อ");
                std_prename.focus();
                return;
            }
            if (!std_name.value.trim()) {
                alert("กรุณากรอกชื่อ-สกุล");
                std_name.focus();
                return;
            }
            if (!national_id.value.trim() || national_id.value.length !== 13) {
                alert("กรุณากรอกเลขประจำตัวประชาชนให้ครบ 13 หลัก");
                national_id.focus();
                return;
            }
            if (!password.value.trim() || password.value.length < 8) {
                alert("รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร");
                password.focus();
                return;
            }
            if (!day_b.value || !month_b.value || !year_b.value.trim()) {
                alert("กรุณากรอกวัน เดือน ปีเกิดให้ครบถ้วน");
                if (!day_b.value) day_b.focus();
                else if (!month_b.value) month_b.focus();
                else year_b.focus();
                return;
            }

            // Prepare data for API
            const data = {
                std_code: std_code.value.trim(),
                std_name: std_prename.value.trim() + std_name.value.trim(),
                std_class: std_class.value,
                national_id: national_id.value.trim(),
                password: password.value.trim(),
                birthday: `${day_b.value} ${month_b.value} ${year_b.value.trim()}`,
                import_students: true
            };


            $.ajax({
                type: "POST",
                url: "controllers/std_controller",
                data: data,
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = "../student_list"
                    } else {
                        alert(json.msg);
                        window.location.reload();
                    }
                },
            });
        })
    </script>
</body>

</html>