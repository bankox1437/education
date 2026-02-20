<style>
    <?php if ($isRead) { ?>.form-info-input {
        background-color: #ffffff !important;
    }

    <?php } ?>
</style>
<div class="col-lg-6 col-12">
    <div class="box">
        <!-- /.box-header -->
        <div class="form" id="form-edit-admin">
            <div class="box-body" style="padding-bottom: 171px;">
                <h4 class="box-title text-info mb-0">ข้อมูลพื้นฐาน</h4>
                <input type="hidden" id="info_id" name="info_id" class="form-control form-info-input">
                <hr class="my-15">
                <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ชื่อ <b class="text-danger ">*</b></label>
                            <input type="text" id="name" name="name" class="form-control form-info-input validate" placeholder="กรอกชื่อ" <?php echo $isRead ? 'disabled style="background:#fff;"' : '' ?>>
                            <input type="hidden" id="info_id" name="info_id" class="form-control form-info-input">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>นามสกุล <b class="text-danger ">*</b></label>
                            <input type="text" id="surname" name="surname" class="form-control form-info-input validate" placeholder="กรอกนามสกุล" <?php echo $isRead ? 'disabled style="background:#fff;"' : '' ?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ชื่อผู้ใช้</label>
                            <input type="text" id="username" name="username" class="form-control form-info-input validate" <?php echo $isRead ? 'disabled style="background:#fff;"' : 'disabled' ?> placeholder="กรอกชื่อผู้ใช้">
                        </div>
                    </div>
                    <?php if ($_SESSION['user_data']->role_id != 2) { ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>รหัสผ่าน</label>
                                <input type="text" class="form-control form-info-input" id="password" name="password" placeholder="รหัสผ่านใหม่">
                                <input type="hidden" id="password_old" name="password_old" class="form-info-input">
                            </div>
                        </div>
                    <?php } ?>
                </div> -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-date-birthday">
                            <label>วันเดือนปีเกิด</label>
                            <input type="text" class="form-control form-info-input date-text" id="birthdayText" name="birthdayText" placeholder="กรอกวันเดือนปีเกิด" onclick="hideInputDate('birthday','birthdayText')" <?php echo $isRead  ? 'disabled style="background:#fff;"' : '' ?> placeholder="กรอกชื่อผู้ใช้">
                            <input style="display: none;" type="text" class="form-control form-info-input" id="birthday" name="birthday" placeholder="กรอกวันเดือนปีเกิด" onchange="calculateAge()" <?php echo $isRead  ? 'disabled style="background:#fff;"' : '' ?> placeholder="กรอกชื่อผู้ใช้">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>อายุ</label>
                            <input type="text" class="form-control form-info-input" disabled id="age" name="age" placeholder="กรอกอายุ" <?php echo $isRead  ? 'disabled style="background:#fff;"' : '' ?> placeholder="กรอกชื่อผู้ใช้">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>เกษียณอายุราชการปี</label>
                            <input type="text" class="form-control form-info-input" disabled id="retire_work" name="retire_work" placeholder="เกษียณอายุราชการปี" <?php echo $isRead  ? 'disabled style="background:#fff;"' : '' ?>>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-date-start_work">
                            <label>เริ่มปฏิบัติงานเมื่อวันที่</label>
                            <input type="text" class="form-control form-info-input date-text" id="start_workText" name="start_workText" onclick="hideInputDate('start_work','start_workText')" placeholder="เริ่มปฏิบัติงานเมื่อวันที่" <?php echo $isRead  ? 'disabled style="background:#fff;"' : '' ?>>
                            <input style="display: none;" type="text" class="form-control form-info-input" id="start_work" name="start_work" onchange="calculateAgeWork()" placeholder="เริ่มปฏิบัติงานเมื่อวันที่" <?php echo $isRead  ? 'disabled style="background:#fff;"' : '' ?>>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>อายุงาน</label>
                            <input type="text" class="form-control form-info-input" disabled id="age_work" name="age_work" placeholder="อายุงาน" <?php echo $isRead ? 'disabled style="background:#fff;"' : '' ?>>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>เพศ</label>
                            <div class="c-inputs-stacked">
                                <input name="gender" type="radio" id="gender1" value="ชาย" <?php echo $isRead ? 'disabled' : '' ?> placeholder="กรอกชื่อผู้ใช้">
                                <label for="gender1" class="mr-30">ชาย</label>
                                <input name="gender" type="radio" id="gender2" value="หญิง" <?php echo $isRead ? 'disabled' : '' ?> placeholder="กรอกชื่อผู้ใช้">
                                <label for="gender2" class="mr-30">หญิง</label>
                                <!-- <input name="gender" type="radio" id="gender3" value="อื่น ๆ">
                                <label for="gender3" class="mr-30">อื่น ๆ</label> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ชั้นเครื่องราชที่ได้รับ</label>
                            <input type="text" class="form-control form-info-input" id="class_royal" name="class_royal" placeholder="กรอกชั้นเครื่องราชที่ได้รับ" <?php echo $isRead ? 'disabled style="background:#fff;"' : '' ?>>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-date-date_get_royal">
                            <label>ได้รับเมื่อวันที่</label>
                            <input type="text" class="form-control form-info-input date-text" id="date_get_royalText" name="date_get_royalText" placeholder="ได้รับเมื่อวันที่" onclick="hideInputDate('date_get_royal','date_get_royalText')" <?php echo $isRead ? 'disabled style="background:#fff;"' : '' ?>>
                            <input style="display: none;" type="text" class="form-control form-info-input" id="date_get_royal" name="date_get_royal" placeholder="ได้รับเมื่อวันที่" onchange="calculateSummary()" <?php echo $isRead ? 'disabled style="background:#fff;"' : '' ?>>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>รวมเป็นระยะเวลา</label>
                            <input type="text" class="form-control form-info-input" disabled id="sum_get_royal" name="sum_get_royal" placeholder="รวมเป็นระยะเวลา" <?php echo $isRead ? 'disabled style="background:#fff;"' : '' ?>>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ตำแหน่งขั้นทางลูกเสือ</label>
                            <input type="text" class="form-control form-info-input" id="scout_rank" name="scout_rank" placeholder="กรอกตำแหน่งขั้นทางลูกเสือ" <?php echo $isRead ? 'disabled style="background:#fff;"' : '' ?>>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>หมายเลขโทรศัพท์</label>
                            <input type="text" class="form-control form-info-input" pattern="\d*" maxlength="10" id="phone" name="phone" placeholder="กรอกหมายเลขโทรศัพท์" <?php echo $isRead ? 'disabled' : '' ?>>
                        </div>
                    </div>
                </div>
                <?php if (!$isRead) { ?>
                    <!-- /.box-body -->
                    <div class="row justify-content-center" style="margin: 37px 0;">
                        <button type="buttom" class="btn btn-rounded btn-primary btn-outline" onclick="editInfo()">
                            <i class="ti-save-alt"></i> บันทึกข้อมูลพื้นฐาน
                        </button>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- /.box -->
</div>

<script>
    $(document).ready(async function() {
        await getDataUserEdit();
    });

    async function getDataUserEdit() {
        $.ajax({
            type: "POST",
            url: "controllers/user_controller",
            data: {
                getDataUserEdit: true,
                id: '<?php echo $isRead ? $_GET['user_id'] : $_SESSION['user_data']->id; ?>'
            },
            dataType: "json",
            success: async function(json_data) {
                // renderDataToForm(json_data.data[0]);
                if (json_data.resultInfo.length > 0) {
                    renderDataToFormInfo(json_data.resultInfo[0]);
                }

            },
        });
    }

    function editInfo() {

        const dataParam = validateInputInfo();

        let gender = $('input[name="gender"]:checked').val();
        dataParam['gender'] = gender;
        dataParam['update_info'] = true;

        console.log(dataParam);

        $.ajax({
            type: "POST",
            url: "controllers/info_controller",
            data: dataParam,
            dataType: "json",
            success: async function(json) {
                if (json == 1) {
                    alert("บันทึกข้อมูลพื้นฐานสำเร็จ");
                    await getDataUserEdit();
                }
            },
        });
    };

    function validateInputInfo() {
        let isValid = true;
        let values = {};

        $('.form-info-input').each(function(i, e) {
            if ($(e).hasClass('validate') && $(e).val() === '') {
                alert(`โปรด${e.getAttribute('placeholder')}`);
                $(e).focus();
                isValid = false;
                return false; // This stops the .each loop
            } else {
                values[$(e).attr('id')] = $(e).val();
            }
        });

        return isValid ? values : {};
    }



    function renderDataToForm(data) {
        $('#name').val(data.name);
        $('#surname').val(data.surname);
        $('#username').val(data.username);
        $("#password_old").val(data.password);
    }

    function renderDataToFormInfo(data) {
        console.log(data);
        $('#age').val(data.age);
        $('#scout_rank').val(data.scout_rank);
        if(data.end_work) {
            $('#retire_work').val(formatToBuddhistDate(data.end_work));
        }
        $('#info_id').val(data.info_id);

        $('#class_royal').val(data.class_royal);
        $('#sum_get_royal').val(data.sum_get_royal);
        $('#age_work').val(data.age_work);
        $('#phone').val(data.phone);

        const radioGender = $('input:radio[name=gender]');
        if (data.gender == 'ชาย') {
            radioGender.filter('[value="ชาย"]').prop('checked', true);
        } else {
            radioGender.filter('[value="หญิง"]').prop('checked', true);
        }

        let dates = [{
            id: 'birthday',
            date: new Date(data.birthday)
        }, {
            id: 'start_work',
            date: new Date(data.start_work)
        }, {
            id: 'date_get_royal',
            date: new Date(data.date_get_royal)
        }]
        dates.forEach(element => {
            initFlatpickr(element.id, element.date);
        });
    }

    function calculateAge() {
        let birthday = $('#birthday').val();

        // Calculate age
        if (birthday) {
            let birthDate = new Date(birthday);
            let today = new Date();

            let years = today.getFullYear() - birthDate.getFullYear();
            let months = today.getMonth() - birthDate.getMonth();
            let days = today.getDate() - birthDate.getDate();

            if (days < 0) {
                months--;
                days += new Date(today.getFullYear(), today.getMonth(), 0).getDate(); // Adjust for days in the previous month
            }

            if (months < 0) {
                years--;
                months += 12; // Adjust for months
            }

            let monthText = '';
            if (months != 0) {
                monthText = ` ${months} เดือน`;
            }
            $('#age').val(`${years} ปี${monthText}`);

            calculateWorksRetire(birthday)
        }
    }

    function calculateSummary() {
        let date_get_royal = $('#date_get_royal').val();

        // Calculate age
        if (date_get_royal) {
            let date_get_royalDate = new Date(date_get_royal);
            let today = new Date();

            let years = today.getFullYear() - date_get_royalDate.getFullYear();
            let months = today.getMonth() - date_get_royalDate.getMonth();
            let days = today.getDate() - date_get_royalDate.getDate();

            if (days < 0) {
                months--;
                days += new Date(today.getFullYear(), today.getMonth(), 0).getDate(); // Adjust for days in the previous month
            }

            if (months < 0) {
                years--;
                months += 12; // Adjust for months
            }

            let monthText = '';
            if (months != 0) {
                monthText = ` ${months} เดือน`;
            }
            $('#sum_get_royal').val(`${years} ปี${monthText}`);
        }
    }


    const thaiMonths = [
        "มกราคม", // January
        "กุมภาพันธ์", // February
        "มีนาคม", // March
        "เมษายน", // April
        "พฤษภาคม", // May
        "มิถุนายน", // June
        "กรกฎาคม", // July
        "สิงหาคม", // August
        "กันยายน", // September
        "ตุลาคม", // October
        "พฤศจิกายน", // November
        "ธันวาคม" // December
    ];

    function formatDayMonth(day, month) {
        let formattedDay = String(day).padStart(2, '0');
        let formattedMonth = String(month).padStart(2, '0');
        return {
            day: formattedDay,
            month: formattedMonth
        };
    }

    function calculateWorksRetire(birthday) {

        let retire_work = $('#retire_work');

        if (birthday) {
            let birthDate = new Date(birthday);
            let maxRetireDate = new Date(birthDate);
            maxRetireDate.setFullYear(maxRetireDate.getFullYear() + 60); // Set retirement date to 60 years after birth date

            let startWorkDate = new Date(birthday);
            let actualRetireDate = new Date(startWorkDate);

            if (startWorkDate < maxRetireDate) {
                actualRetireDate = maxRetireDate;
            }

            // Convert to Thai date
            let thaiYear = actualRetireDate.getFullYear() + 543;
            let thaiMonth = actualRetireDate.getMonth() + 1; // Months are 0-based
            let thaiDay = actualRetireDate.getDate();
            let {
                day,
                month
            } = formatDayMonth(thaiDay, thaiMonth);
            let thaiDate = `${day}-${month}-${thaiYear}`;
            // Update the retire_work field with the Thai date
            // retire_work.val(actualRetireDate);

            retire_work.val(thaiDate); // Set the value in the format YYYY-MM-DD

        }
    }

    function calculateAgeWork() {
        let start_work = $('#start_work').val();

        // Calculate age
        if (start_work) {
            let birthDate = new Date(start_work);
            let today = new Date();

            let years = today.getFullYear() - birthDate.getFullYear();
            let months = today.getMonth() - birthDate.getMonth();
            let days = today.getDate() - birthDate.getDate();

            if (days < 0) {
                months--;
                days += new Date(today.getFullYear(), today.getMonth(), 0).getDate(); // Adjust for days in the previous month
            }

            if (months < 0) {
                years--;
                months += 12; // Adjust for months
            }

            let monthText = '';
            if (months != 0) {
                monthText = ` ${months} เดือน`;
            }
            $('#age_work').val(`${years} ปี${monthText}`);
        }
    }
</script>