<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลคะแนนระหว่างเรียน</title>
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

        /* Rotate table headers vertically */
        .vertical-header {
            writing-mode: sideways-lr;
            /* Vertical text (right-to-left) */
            text-orientation: mixed;
            /* Ensures proper text display */
            white-space: nowrap;
            /* Prevents text wrapping */
            height: 160px;
            /* Adjust height to fit text */
            vertical-align: middle;
            /* Centers text in the column */
            width: 50px;
        }
    </style>
    <script>
        // Use const for variables that won't be reassigned
        const stdSelected = new Set(); // Use Set for O(1) lookup
    </script>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php
        if ($_SESSION['user_data']->role_id == "show") {
            include 'include/sidebar.php';
        } ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="<?php echo $_SESSION['user_data']->role_id == "show" ? '' : 'margin: 0;' ?>">
            <div class="container-full">
                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $dataSubject = [];
                $sub_code = "";
                $sub_name = "";
                $sub_term = "";
                if (isset($_GET['sub_id'])) {
                    $sqlSubject = "SELECT * FROM vg_inter_study_subject WHERE sub_id = :sub_id AND user_create = :user_create AND std_class = :std_class";
                    $dataSubject = $DB->Query($sqlSubject, ["sub_id" => $_GET['sub_id'], "user_create" => $_SESSION['user_data']->id, "std_class" => $_GET['std_class']]);
                    $dataSubject = json_decode($dataSubject);
                }

                if (count($dataSubject) > 0) {
                    $sub_code = $dataSubject[0]->sub_code;
                    $sub_name = $dataSubject[0]->sub_name;
                    $sub_term = $dataSubject[0]->term;
                }

                $sql = "SELECT\n" .
                    "	std.std_id,\n" .
                    "	std.std_code,\n" .
                    "	std.std_prename,\n" .
                    "	std.std_name,\n" .
                    "	edu.district_id\n" .
                    "FROM\n" .
                    "	tb_students std\n" .
                    "	LEFT JOIN tb_users users ON std.user_create = users.id\n" .
                    "	LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id\n" .
                    "WHERE\n" .
                    "	std.user_create = :user_create \n" .
                    "	AND std.std_status = 'กำลังศึกษา' AND std.std_class = :std_class \n";
                $std_class = 'ประถม';
                if (isset($_GET['std_class'])) {
                    $std_class = $_GET['std_class'];
                }
                $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id, 'std_class' =>  $std_class]);
                $std_data = json_decode($data);
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_sum_score'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-bar-chart-alt mr-15"></i> <b>คะแนนระหว่างเรียน</b>
                                    </h6>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group row">
                                                <label for="std_class" class="col-sm-4 col-form-label">เลือกระดับชั้น</label>
                                                <div class="col-sm-8">
                                                    <form action="" method="GET" class="col-md-12 p-0 m-0">
                                                        <select class="form-control select2" name="std_class" id="std_class" onchange="this.form.submit()" data-placeholder="เลือกระดับชั้น" style="width: 100%;" <?php echo isset($_GET['sub_id']) ? 'disabled' : '' ?>>
                                                            <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ประถม" ? "selected" : "" ?> value="ประถม">ประถม</option>
                                                            <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ม.ต้น" ? "selected" : "" ?> value="ม.ต้น">ม.ต้น</option>
                                                            <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ม.ปลาย" ? "selected" : "" ?> value="ม.ปลาย">ม.ปลาย</option>
                                                        </select>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">เลือกนักศึกษา</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select2" name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;" onchange="getDataStdbtStdId(this.value)">
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group row">
                                                <label for="subject_code" class="col-sm-4 col-form-label pr-0">รหัสวิชา :</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" value="<?php echo $sub_code ?>" id="subject_code" placeholder="กรอกรหัสวิชา">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group row">
                                                <label for="subject_name" class="col-sm-4 col-form-label pr-0">ชื่อวิชา :</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" value="<?php echo $sub_name ?>" id="subject_name" placeholder="กรอกชื่อวิชา">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group row">
                                                <label for="subject_name" class="col-sm-4 col-form-label pr-0">ปีการศึกษา :</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" value="<?php echo $sub_term ?>" id="term" placeholder="กรอกชื่อปีการศึกษา">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group row">
                                                <!-- <button id="btn_confirm_std" class="col-sm-12 waves-effect waves-light btn btn-success btn-flat" style="margin-top: -3px;"><i class="ti-check"></i>&nbsp;ยืนยันนักศึกษา</button> -->
                                                <button id="btn_add" class="col-sm-12 waves-effect waves-light btn btn-success btn-flat" style="margin-top: -3px;"><i class="ti-plus"></i>&nbsp;เพิ่มหัวข้อ</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <input type="hidden" name="sub_id" id="sub_id" value="<?php echo isset($_GET['sub_id']) ? $_GET['sub_id'] : '' ?>">
                                                <table class="table table-bordered" style="font-size: 12px;">
                                                    <thead>
                                                        <?php
                                                        $dataColumn = [];
                                                        if (isset($_GET['sub_id'])) {
                                                            $sqlColumn = "SELECT * FROM vg_inter_study_worksheet WHERE sub_id = :sub_id";
                                                            $dataColumn = $DB->Query($sqlColumn, ["sub_id" => $_GET['sub_id']]);
                                                            $dataColumn = json_decode($dataColumn);
                                                        }
                                                        ?>
                                                        <tr>
                                                            <?php if (!isset($_GET['sub_id'])) { ?>
                                                                <th rowspan="2" class="text-center" style="width: 50px;">
                                                                    <input type="checkbox" id="status_check" class="filled-in chk-col-success" onchange="checked_all()">
                                                                    <label for="status_check" style="margin-top: 10px;padding-left: 20px;font-size: 12px;">&nbsp;เลือกทั้งหมด</label>
                                                                </th>
                                                            <?php } ?>
                                                            <th rowspan="2" class="text-center" style="width: 50px;">
                                                                รหัสประจำตัว
                                                            </th>
                                                            <th rowspan="2" style="width: 100px;" class="text-center">ชื่อ - ชื่อสกุล</th>
                                                            <th colspan="<?php echo count($dataColumn) + 1; ?>" class="text-center" id="work_head" style="width: 500px;">คะแนนใบงานระหว่างภาคเรียน</th>
                                                            <th rowspan="2" class="text-center vertical-header">คะแนนสอบปลายภาค</th>
                                                            <th rowspan="2" class="text-center vertical-header">รวมคะแนนทั้งสิ้น</th>
                                                            <th rowspan="2" class="text-center vertical-header">ระดับผลการเรียน</th>
                                                            <th rowspan="2" class="text-center" style="width: 100px;">หมายเหตุ</th>
                                                        </tr>
                                                        <tr id="col_work">
                                                            <?php
                                                            if (count($dataColumn) > 0) {
                                                                foreach ($dataColumn as $key => $value) {
                                                                    $numberKey = ($key + 1);
                                                                    echo '<th class="text-center vertical-header col-header" id="' . $numberKey . '" data-work_id="' . $value->work_id . '">' .
                                                                        '<span>' . $value->work_name . '</span>' .
                                                                        '<i class="ti-pencil-alt pb-1 text-warning" style="cursor:pointer;" onclick="changeText(this)"></i> <i class="ti-trash text-danger" style="cursor:pointer;" onclick="deleteColumn(this)"></i></th>';
                                                                }
                                                            }
                                                            ?>
                                                            <th class="text-center vertical-header">รวมคะแนนระหว่างภาคเรียน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="body-std">
                                                        <?php
                                                        if (count($std_data) > 0) {
                                                            $index = 1; // For numbering
                                                            foreach ($std_data as $obj_std) {
                                                                $checkStd = [];
                                                                if (isset($_GET['sub_id'])) {
                                                                    $checStdSql = "SELECT * FROM vg_inter_study_worksheet vw
                                                                                    LEFT JOIN vg_inter_study_students vs on vw.work_id = vs.work_id 
                                                                                    WHERE sub_id = :sub_id and vs.std_id = :std_id limit 1";
                                                                    $checkStd = $DB->Query($checStdSql, ["sub_id" => $_GET['sub_id'], "std_id" => $obj_std->std_id]);
                                                                    $checkStd = json_decode($checkStd);
                                                                }
                                                                if (count($checkStd) > 0 || !isset($_GET['sub_id'])) {
                                                                    echo '<tr data-std_id="' . $obj_std->std_id . '" class="std_row_' . $obj_std->std_id . '">';

                                                                    if (!isset($_GET['sub_id'])) {
                                                                        $tdStdcode = '<td class="text-center">';
                                                                        $tdStdcode .= '<input type="checkbox" id="status_check_' . $obj_std->std_id . '" data-std-id="' . $obj_std->std_id . '" class="filled-in chk-col-success status_check_box pr-2" onchange="CheckedRow(this.checked,this)">
                                                                            <label for="status_check_' . $obj_std->std_id . '" style="margin-top: 10px;padding-left: 20px;">';
                                                                        $tdStdcode .= '</td>';
                                                                        echo $tdStdcode;
                                                                    }

                                                                    echo '<td class="text-center">' .  $obj_std->std_code . '</td>'; // ชื่อ - สกุล
                                                                    echo '<td>' . $obj_std->std_prename . $obj_std->std_name . '</td>'; // ชื่อ - สกุล

                                                                    if (count($dataColumn) > 0) {
                                                                        $sumScore = 0;
                                                                        $finalScore = 0;
                                                                        $totalScore = 0;
                                                                        $level = 0;
                                                                        $reason = "";
                                                                        foreach ($dataColumn as $key => $value) {
                                                                            $sqlStudentScore = "SELECT * FROM vg_inter_study_students WHERE work_id = :work_id AND std_id = :std_id";
                                                                            $dataStudentScore = $DB->Query($sqlStudentScore, ["work_id" => $value->work_id, "std_id" => $obj_std->std_id]);
                                                                            $dataStudentScore = json_decode($dataStudentScore);

                                                                            $dataStudentScore = $dataStudentScore[0];

                                                                            $sumScore = $dataStudentScore->sum_score;
                                                                            $finalScore = $dataStudentScore->final_score;
                                                                            $totalScore = $dataStudentScore->total_score;
                                                                            $level = $dataStudentScore->level;
                                                                            $reason = $dataStudentScore->reason;

                                                                            $numberKey = ($key + 1);

                                                                            echo '<td style="padding: 5px 2px;" class="td_input td_input_' . $numberKey . '">
                                                                            <div class="form-group mb-0 input_score_' . $obj_std->std_id . '_' . $numberKey . '">
                                                                                <input type="number" class="form-control text-center input_score_' . $numberKey . ' input_score_sum_' . $obj_std->std_id . '" data-std_id="' . $obj_std->std_id . '" data-inter_id="' . $dataStudentScore->inter_id . '" data-work_id="' . $dataStudentScore->work_id . '" autocomplete="off" value="' . $dataStudentScore->score . '" onkeyup="onKeypressEnter(event, this , ' . $numberKey . ')">
                                                                                <input type="hidden" id="inter_id_' . $obj_std->std_id . '" value="' . $dataStudentScore->inter_id . '">
                                                                                <input type="hidden" id="work_id_' . $obj_std->std_id . '" value="' . $dataStudentScore->work_id . '">
                                                                            </div>
                                                                        </td>';
                                                                        }

                                                                        echo '<td style="padding: 5px 2px;">
                                                                            <div class="form-group mb-0">
                                                                                <input type="number" class="form-control text-center" id="sum_score_' . $obj_std->std_id . '" autocomplete="off" value="' . $sumScore . '">
                                                                            </div>
                                                                        </td>';
                                                                        // หมายเหตุ
                                                                        echo '<td style="padding: 5px 2px;">
                                                                            <div class="form-group mb-0">
                                                                                <input type="number" class="form-control text-center" id="final_score_' . $obj_std->std_id . '" autocomplete="off" value="' . $finalScore . '"  onkeyup="finalKeyup(' . $obj_std->std_id . ', this.value)">
                                                                            </div>
                                                                        </td>';

                                                                        echo '<td style="padding: 5px 2px;">
                                                                                <div class="form-group mb-0">
                                                                                    <input type="number" class="form-control text-center" id="total_score_' . $obj_std->std_id . '" autocomplete="off" value="' . $totalScore . '">
                                                                                </div>
                                                                            </td>';
                                                                        echo '<td style="padding: 5px 2px;">
                                                                                <div class="form-group mb-0">
                                                                                    <input type="number" class="form-control text-center" id="level_' . $obj_std->std_id . '" autocomplete="off" value="' . $level . '">
                                                                                </div>
                                                                            </td>';
                                                                        echo '<td style="padding: 5px 2px;">
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text" class="form-control text-center" id="reason_' . $obj_std->std_id . '" autocomplete="off" placeholder="หมายเหตุ" value="' . $reason . '">
                                                                                </div>
                                                                            </td>';
                                                                    } else {
                                                                        echo '<td style="padding: 5px 2px;">
                                                                        <div class="form-group mb-0">
                                                                            <input type="number" disabled class="form-control text-center" id="sum_score_' . $obj_std->std_id . '" autocomplete="off" placeholder="0" value="">
                                                                        </div>
                                                                    </td>';
                                                                        // หมายเหตุ
                                                                        echo '<td style="padding: 5px 2px;">
                                                                            <div class="form-group mb-0">
                                                                                <input type="number" disabled class="form-control text-center" id="final_score_' . $obj_std->std_id . '" autocomplete="off" placeholder="0" value="" onkeyup="finalKeyup(' . $obj_std->std_id . ', this.value)">
                                                                            </div>
                                                                        </td>';

                                                                        echo '<td style="padding: 5px 2px;">
                                                                            <div class="form-group mb-0">
                                                                                <input type="number" disabled class="form-control text-center" id="total_score_' . $obj_std->std_id . '" autocomplete="off" placeholder="0" value="">
                                                                            </div>
                                                                        </td>';
                                                                        echo '<td style="padding: 5px 2px;">
                                                                            <div class="form-group mb-0">
                                                                                <input type="number" disabled class="form-control text-center" id="level_' . $obj_std->std_id . '" autocomplete="off" placeholder="0" value="">
                                                                            </div>
                                                                        </td>';
                                                                        echo '<td style="padding: 5px 2px;">
                                                                            <div class="form-group mb-0">
                                                                                <input type="text" disabled class="form-control text-center" id="reason_' . $obj_std->std_id . '" autocomplete="off" placeholder="หมายเหตุ" value="">
                                                                            </div>
                                                                        </td>';
                                                                    }
                                                                    echo '<script>stdSelected.add(' . $obj_std->std_id . ');</script>';
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <button class="btn btn-rounded btn-primary btn-outline mt-4" onclick="submitForm()">
                                                <i class="ti-save-alt"></i> บันทึกข้อมูล
                                            </button>
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
    <script>
        $(document).ready(() => {
            $('#std_select').select2();
            //getDataStd_new('ประถม');
        })

        let allStudents = []; // Renamed for clarity
        let tempStdClass = []; // Renamed for clarity

        let storeDeleteInterId = [];
        let storeDeleteWorkId = [];
        let storeDeleteStdId = [];

        function checked_all() {
            const status_check_status = document.getElementById('status_check').checked;
            const status_check_box = document.getElementsByClassName('status_check_box');
            if (status_check_status) {
                for (const std_checked of status_check_box) {
                    std_checked.checked = true;
                    CheckedRow(true, std_checked)
                }
            } else {
                for (const std_checked of status_check_box) {
                    std_checked.checked = false;
                    CheckedRow(false, std_checked)
                }
            }
        }

        function CheckedRow(checked, inputCheck) {
            let tr = $(inputCheck).parent().parent();
            $(tr).find('input[type=number]').attr('disabled', !checked);
            $(tr).find('input[type=text]').attr('disabled', !checked);
        }

        function finalKeyup(std_id, value = 0) {
            if (!parseFloat(value)) {
                value = $('#final_score_' + std_id).val();
            }
            let sum_score = $('#sum_score_' + std_id).val();
            let total_score = parseFloat(value) + parseFloat(sum_score);
            total_score = total_score || 0;
            $('#total_score_' + std_id).val(total_score);
            const grade = calculateGrade(total_score);
            $('#level_' + std_id).val(grade || 0);
        }

        function calculateGrade(score) {
            // Validate score
            if (typeof score !== 'number' || isNaN(score) || score < 0) {
                return 'Invalid score';
            }

            // Grading scale
            if (score >= 80) {
                return 4;
            } else if (score >= 75 && score < 80) {
                return 3.5;
            } else if (score >= 70 && score < 75) {
                return 3;
            } else if (score >= 65 && score < 70) {
                return 2.5;
            } else if (score >= 60 && score < 65) {
                return 2;
            } else if (score >= 55 && score < 60) {
                return 1.5;
            } else if (score >= 50 && score < 55) {
                return 1;
            } else if (score >= 0 && score < 50) {
                return 0;
            }
        }

        // Utility function to create option HTML
        const createOption = (value, text, isDefault = false) =>
            `<option value="${value}">${isDefault ? text : `${text}`}</option>`;

        // Utility function to populate dropdown
        const updateDropdown = (students, selectElement) => {
            selectElement.innerHTML = createOption(0, "เลือกนักศึกษา", true) +
                students.map(student =>
                    createOption(student.std_id, `${student.std_code} - ${student.std_prename}${student.std_name}`)
                ).join('');
        };

        const fetchStudentData = (std_class = "") => {
            return $.ajax({
                type: "POST",
                url: "../student-tracking/controllers/student_controller",
                data: {
                    getDataStudent: true,
                    std_class
                },
                dataType: "json"
            });
        };

        function changeClass(value) {
            getDataStd_new(value);
        }

        async function getDataStd_new(std_class = "") {
            try {
                const stdSelect = document.getElementById("std_select");
                const response = await fetchStudentData(std_class);

                allStudents = response.data;

                if (std_class != tempStdClass) {
                    <?php if (!isset($_GET['sub_id'])) { ?>
                        stdSelected.clear();
                        $('#body-std').empty();
                    <?php } ?>
                }

                const filteredStudents = allStudents.filter(student => {
                    std_id_parse = parseInt(student.std_id)
                    return !stdSelected.has(std_id_parse)
                });

                updateDropdown(filteredStudents, stdSelect);
                tempStdClass = std_class;
            } catch (error) {
                console.error('Error fetching student data:', error);
            }
        }

        function getDataStdbtStdId(std_id) {
            const stdSelect = document.getElementById("std_select");
            const id = parseInt(std_id);

            stdSelected.add(id);

            const filteredHaveStudents = allStudents.filter(student => {
                return student.std_id == std_id
            });

            addRowWithStd(filteredHaveStudents[0]);

            const filteredStudents = allStudents.filter(student => {
                std_id_parse = parseInt(student.std_id)
                return !stdSelected.has(std_id_parse)
            });

            updateDropdown(filteredStudents, stdSelect);
        }

        function addRowWithStd(std_data) {
            if (!std_data) {
                return false;
            }

            $('.empty-data').remove();

            storeDeleteStdId = storeDeleteStdId.filter(num => num !== parseInt(std_data.std_id));

            // Create new row
            let tr = document.createElement("tr");
            tr.setAttribute('data-std_id', std_data.std_id);

            // 1. Student ID column
            let tdId = document.createElement("td");
            tdId.className = "text-center";
            tdId.innerHTML = `<i class="ti-trash text-danger" style="cursor:pointer;" onclick="deleteRow(this, ${std_data.std_id})"></i> ${std_data.std_code}`
            tr.appendChild(tdId);

            // 2. Student Name column
            let tdName = document.createElement("td");
            tdName.className = "text-center";
            tdName.textContent = std_data.std_prename + std_data.std_name || "-";
            tr.appendChild(tdName);

            // 3. Dynamic work scores column (assuming std_data.work_scores is an array)
            let col_work = $('#col_work').children();

            let count_header_length = col_work.length;
            if (count_header_length > 1) {
                for (let index = 0; index < count_header_length - 1; index++) {
                    const newCell = document.createElement("td");
                    newCell.classList.add(`td_input`, `td_input_${index + 1}`);
                    newCell.style.padding = "5px 2px";
                    newCell.innerHTML = `<div class="form-group mb-0 input_score_${std_data.std_id}_${index + 1}">
                                    <input type="number" class="form-control text-center input_score_${index + 1} input_score_sum_${std_data.std_id}" data-std_id="${std_data.std_id}" autocomplete="off" placeholder="0" value="" onkeyup="onKeypressEnter(event, this, ${index + 1})">
                                  </div>`;
                    tr.appendChild(newCell);
                };
            }

            const tdWorkTotal = document.createElement("td");
            tdWorkTotal.style.padding = "5px 2px";
            tdWorkTotal.innerHTML = `<div class="form-group mb-0">
                                    <input type="number" class="form-control text-center" id="sum_score_${std_data.std_id}" autocomplete="off" placeholder="0" value="">
                                </div>`;
            tr.appendChild(tdWorkTotal);

            // 4. Final exam score column
            let tdFinal = document.createElement("td");
            tdFinal.style.padding = "5px 2px";
            tdFinal.innerHTML = `<div class="form-group mb-0">
                                    <input type="number" class="form-control text-center" id="final_score_${std_data.std_id}" autocomplete="off" placeholder="0" value="">
                                </div>`;
            tr.appendChild(tdFinal);

            // 5. Grade column
            let tdGrade = document.createElement("td");
            tdGrade.style.padding = "5px 2px";
            tdGrade.innerHTML = `<div class="form-group mb-0">
                                    <input type="number" class="form-control text-center" id="total_score_${std_data.std_id}" autocomplete="off" placeholder="0" value="">
                                </div>`;
            tr.appendChild(tdGrade);

            // 6. Total score column (work scores + final exam)
            let tdTotal = document.createElement("td");
            tdTotal.style.padding = "5px 2px";
            tdTotal.innerHTML = `<div class="form-group mb-0">
                                    <input type="number" class="form-control text-center" id="level_${std_data.std_id}" autocomplete="off" placeholder="0" value="">
                                </div>`;
            tr.appendChild(tdTotal);

            // 7. Note column
            let tdNote = document.createElement("td");
            tdNote.style.padding = "5px 2px";
            tdNote.innerHTML = `<div class="form-group mb-0">
                                    <input type="text" class="form-control text-center" id="reason_${std_data.std_id}" autocomplete="off" placeholder="หมายเหตุ" value="">
                                </div>`;
            tr.appendChild(tdNote);

            // Add the row to the tbody (assuming you have a tbody with id="studentTableBody")
            document.getElementById("body-std").appendChild(tr);

            return true;
        }

        document.getElementById("btn_add").addEventListener("click", function() {

            if ($('#body-std').html().trim() === '') {
                alert("ไม่มีข้อมูลนักศึกษาในตาราง");
                return false;
            }

            const newColumnName = prompt("กรุณากรอกชื่อหัวข้อ:");

            if (newColumnName) {

                const headerRow = document.getElementById('col_work');
                const newHeader = document.createElement("th");
                newHeader.classList.add('vertical-header', 'col-header', 'text-center');
                newHeader.innerHTML += `<span>${newColumnName}</span> <i class="ti-pencil-alt pb-1 text-warning" style="cursor:pointer;" onclick="changeText(this)"></i> <i class="ti-trash text-danger" style="cursor:pointer;" onclick="deleteColumn(this)"></i>`
                newHeader.id = headerRow.children.length;

                // Append new header to the end of the header row
                headerRow.insertBefore(newHeader, headerRow.children[headerRow.children.length - 1]);

                let count_header_length = headerRow.children.length;

                // Update colspan of the first row if necessary
                $('#work_head').attr('colspan', count_header_length);

                // Add a new column to each row in the tbody
                const rows = document.querySelectorAll("table tbody tr");

                rows.forEach((row, index) => {
                    let std_id = $(row).attr('data-std_id');
                    const checkedStatus = $('#sub_id').val() != "" ? true : $('#status_check_' + std_id).is(":checked");
                    const newCell = document.createElement("td");
                    newCell.classList.add(`td_input`, `td_input_${count_header_length - 1}`);
                    newCell.style.padding = "5px 2px";
                    newCell.innerHTML = `<div class="form-group mb-0 input_score_${std_id}_${count_header_length - 1}">
                                    <input type="number" ${checkedStatus ? '' : 'disabled'} class="form-control text-center input_score_${count_header_length - 1} input_score_sum_${std_id}" data-std_id="${std_id}" autocomplete="off" placeholder="0" value="" onkeyup="onKeypressEnter(event, this, ${count_header_length - 1})">
                                  </div>`;
                    // Append new cell to the end of the row
                    row.insertBefore(newCell, row.children[row.children.length - 6]);
                });
            } else {
                alert("ชื่อคอลัมน์ไม่สามารถเป็นค่าว่างได้!");
            }
        });

        function onKeypressEnter(e, input, count_header_length) {
            sumScore($(input).attr('data-std_id'));
            if (e.which == 13) { // Check if the pressed key is "Enter"
                // Find the next input with the class 'input_score'
                let nextInput = $(input).parent().parent().parent().next().find('.input_score_' + (count_header_length));

                if (nextInput.length) {
                    nextInput.val("");
                    nextInput.focus(); // Focus the next input
                } else {
                    // Optional: If there is no next input, you can do something else (e.g., alert, focus the first one, etc.)
                    // For example, focus the first input if this is the last one
                    $('.input_score').first().focus();
                }
            }

        }

        function changeText(i) {
            let column = $(i).parent().find("span");
            let oldColumn = column[0].innerHTML;
            const newColumnName = prompt("กรุณากรอกชื่อหัวข้อใหม่:", oldColumn);
            if (newColumnName) {
                column[0].innerHTML = newColumnName;
            }
        }

        function deleteRow(i, std_id) {
            let td = $(i).parent();
            let tr = $(td).parent();
            $(tr).remove();
            stdSelected.delete(std_id)
            let classStd = $('#std_class').val();
            getDataStd_new(classStd);

            storeDeleteStdId.push(std_id);
        }

        function deleteColumn(i) {
            let column = $(i).parent();
            let columnId = column.attr("id");
            let columnSpan = $(i).parent().find("span");
            let oldColumn = columnSpan[0].innerHTML;

            let confirmText = confirm("คุณต้องการลบหัวข้อ " + oldColumn + " ไหม?");
            if (confirmText) {
                let inputArr = $('.td_input_' + columnId).find('input[type="number"]');
                let workId = $(inputArr[0]).attr('data-work_id');
                let std_id_arr = []
                for (const input of inputArr) {
                    let inter_id = $(input).attr('data-inter_id');
                    let std_id = $(input).attr('data-std_id');
                    if (inter_id) {
                        storeDeleteInterId.push(inter_id)
                    }
                    std_id_arr.push(std_id)
                }

                if (workId) {
                    storeDeleteWorkId.push(workId)
                }

                $(column).remove();
                $('.td_input_' + columnId).remove();
                $("#work_head").attr("colspan", $('#col_work').children().length)

                for (let index = 0; index < std_id_arr.length; index++) {
                    const std_id = std_id_arr[index];
                    sumScore(std_id)
                }

            }

            replaceElemntCol(columnId)
            replaceElemntTD(columnId)
        }

        function replaceElemntCol(columnId) {
            let col_header = $('.col-header')
            for (const td of col_header) {
                let idEle = $(td).attr('id');
                if (parseInt(idEle) > parseInt(columnId)) {
                    let newNumber = parseInt(idEle) - 1;
                    $(td).attr('id', newNumber)
                }
            }
        }

        function replaceElemntTD(columnId) {
            let td_input = $('.td_input')
            for (const td of td_input) {
                let className = $(td).attr('class');
                let tdClass = className.split(" ");
                className = tdClass[1];
                className = className.split("_");
                let num_td = className[2];

                if (parseInt(num_td) > parseInt(columnId)) {
                    let newNumber = num_td - 1;
                    // Replace the class names
                    const newTdClass = tdClass[1].replace(`_${num_td}`, `_${newNumber}`);
                    $(td).removeClass(tdClass[1]).addClass(newTdClass);

                    // Replace the class in the input element
                    let input = $(td).find('input[type="number"]');
                    let inputClass = input.attr('class');
                    let newInputClass = inputClass.replace(`_score_${num_td}`, `_score_${newNumber}`);
                    input.attr('class', newInputClass);

                    // Update the onKeypressEnter function call
                    let oldOnKeypress = input.attr('onkeyup');
                    let newOnKeypress = oldOnKeypress.replace(/,\s*\d+\)/, `, ${newNumber})`);
                    input.attr('onkeyup', newOnKeypress);
                }
            }
        }

        function sumScore(std_id) {
            let std_input = $(".input_score_sum_" + std_id);
            let sum_score = 0;
            for (const element of std_input) {
                sum_score += element.value == "" ? 0 : parseInt(element.value);
            }
            $("#sum_score_" + std_id).val(sum_score);
            finalKeyup(std_id)
        }

        function getAllDataInput() {
            let data = [];
            let col_work = $('.col-header');
            if (col_work.length > 0) {
                for (let i = 0; i < col_work.length; i++) {
                    let input_score = $('.input_score_' + (i + 1));
                    let input_score_array = [];
                    for (let j = 0; j < input_score.length; j++) {
                        let std_id = input_score[j].getAttribute('data-std_id');
                        let checkedStatus = $('#status_check_' + std_id).is(":checked");
                        <?php if (isset($_GET['sub_id'])) { ?>
                            checkedStatus = true;
                        <?php } ?>
                        if (checkedStatus) {
                            let input_score_val = input_score[j].value;
                            let final_score_val = $('#final_score_' + std_id).val();
                            let total_score_val = $('#total_score_' + std_id).val();
                            let level_val = $('#level_' + std_id).val();
                            let reason_val = $('#reason_' + std_id).val();
                            let sum_score_val = $('#sum_score_' + std_id).val();
                            let inter_id = 0;
                            let work_id = 0;
                            <?php if (isset($_GET['sub_id'])) { ?>
                                inter_id = input_score[j].getAttribute('data-inter_id');
                                work_id = input_score[j].getAttribute('data-work_id');
                            <?php } ?>
                            let score_obj = {
                                "std_id": std_id,
                                "score": input_score_val,
                                "final_score": final_score_val,
                                "total_score": total_score_val,
                                "level": level_val,
                                "reason": reason_val,
                                "sum_score": sum_score_val,
                                "inter_id": inter_id,
                                "work_id": work_id,
                            }
                            input_score_array.push(score_obj);
                        }
                    }
                    if (input_score_array.length > 0) {
                        data.push(input_score_array);
                    }
                }
            }
            return data;
        }

        function getDataColumnWorksheet() {
            let data = [];
            let col_header = $('.col-header');
            if (col_header.length > 0) {
                for (let i = 0; i < col_header.length; i++) {
                    let keyWorkId = 0;
                    <?php if (isset($_GET['sub_id'])) { ?>
                        keyWorkId = col_header[i].getAttribute('data-work_id');
                    <?php } ?>

                    let headObj = {
                        work_id: keyWorkId,
                        text: col_header[i].textContent.trim()
                    }

                    data.push(headObj);
                }
            }

            return data;
        }

        function submitForm() {
            let dataList = getAllDataInput()

            let dataColumnWorksheet = getDataColumnWorksheet()

            let subject_code = $('#subject_code').val();
            let subject_name = $('#subject_name').val();
            let std_class = $('#std_class').val();
            let term = $('#term').val();

            if (!subject_code) {
                alert('โปรดกรอกรหัสวิชา')
                $('#subject_code').focus()
                return false;
            }


            if (!subject_code) {
                alert('โปรดกรอกชื่อวิชา')
                $('#subject_name').focus()
                return false;
            }

            if (!term) {
                alert('โปรดกรอกปีการศึกษา')
                $('#term').focus()
                return false;
            }

            if (dataColumnWorksheet.length == 0) {
                alert('โปรดเพิ่มหัวข้อ');
                return false;
            }

            <?php if (!isset($_GET['sub_id'])) { ?>
                if (dataList.length == 0) {
                    alert('โปรดเลือกนักศึกษา');
                    return false;
                }
            <?php } ?>

            let objectData = {
                "subject_code": subject_code,
                "subject_name": subject_name,
                "std_class": std_class,
                "term": term,
                "dataStdList": dataList,
                "dataColumnWorksheet": dataColumnWorksheet,
                "storeDeleteInterId": storeDeleteInterId,
                "storeDeleteWorkId": storeDeleteWorkId,
                "storeDeleteStdId": storeDeleteStdId,
                "add_data": true,
                <?php if (isset($_GET['sub_id'])) { ?> "sub_id": '<?php echo $_GET['sub_id'] ?>'
                <?php } ?>
            }

            $('.btn').attr('disabled', true);

            console.log(objectData);

            $.ajax({
                type: "POST",
                url: "../view-grade/controllers/inter_study_controller",
                data: objectData,
                dataType: "json",
                success: async function(json) {
                    alert(json.msg);
                    location.href = 'manage_sum_score';
                },
            });
        }
    </script>
</body>

</html>