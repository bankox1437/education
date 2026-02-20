<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลคะแนนระหว่างเรียน</title>
    <style>
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

        .table>thead>tr>th {
            padding: 5px;
        }

        @page {
            size: landscape;
            margin: 0;

            body {
                transform: scale(0.8);
            }
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">
                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $dataSubject = [];
                $sub_code = "";
                $sub_name = "";
                $sub_term = "";

                $userCreate = $_SESSION['user_data']->id;
                if ($_SESSION['user_data']->role_id == 2) {
                    $userCreate = $_GET['user_id'];
                }
                if (isset($_GET['sub_id'])) {
                    $sqlSubject = "SELECT * FROM vg_inter_study_subject WHERE sub_id = :sub_id AND user_create = :user_create AND std_class = :std_class";
                    $dataSubject = $DB->Query($sqlSubject, ["sub_id" => $_GET['sub_id'], "user_create" => $userCreate, "std_class" => $_GET['std_class']]);
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
                $data = $DB->Query($sql, ['user_create' => $userCreate, 'std_class' =>  $std_class]);
                $std_data = json_decode($data);
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">

                                <div class="box-body no-padding">
                                    <div class="text-center">
                                        <h5 style="color: #000000;font-weight: bold;">การประเมินผลการเรียน</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
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
                                                            <th rowspan="3" class="text-center" style="width: 100px;">รหัสประจำตัว</th>
                                                            <th rowspan="3" style="width: 200px;" class="text-center">ชื่อ - ชื่อสกุล</th>
                                                            <th colspan="<?php echo count($dataColumn) + 4; ?>" class="text-center">การวัดผลและประเมินผลการเรียนรายวิชา <?php echo $sub_code ?> <?php echo $sub_name ?></th>
                                                            <th rowspan="3" class="text-center" style="width: 100px;">หมายเหตุ</th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="<?php echo count($dataColumn) + 1; ?>" class="text-center" id="work_head" style="width: 500px;">คะแนนใบงานระหว่างภาคเรียน ปีการศึกษา <?php echo $sub_term ?></th>
                                                            <th rowspan="3" class="text-center vertical-header">คะแนนสอบปลายภาค</th>
                                                            <th rowspan="3" class="text-center vertical-header">รวมคะแนนทั้งสิ้น</th>
                                                            <th rowspan="3" class="text-center vertical-header">ระดับผลการเรียน</th>
                                                        </tr>
                                                        <tr id="col_work">
                                                            <?php
                                                            if (count($dataColumn) > 0) {
                                                                foreach ($dataColumn as $key => $value) {
                                                                    echo '<th class="text-center vertical-header">' . $value->work_name . '</th>';
                                                                }
                                                            }
                                                            ?>
                                                            <th class="text-center vertical-header">รวมคะแนนระหว่างภาคเรียน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (count($std_data) > 0) {
                                                            $index = 1; // For numbering
                                                            foreach ($std_data as $obj_std) {

                                                                if (isset($_GET['sub_id'])) {
                                                                    $checStdSql = "SELECT * FROM vg_inter_study_worksheet vw
                                                                                    LEFT JOIN vg_inter_study_students vs on vw.work_id = vs.work_id 
                                                                                    WHERE sub_id = :sub_id and vs.std_id = :std_id limit 1";
                                                                    $checkStd = $DB->Query($checStdSql, ["sub_id" => $_GET['sub_id'], "std_id" => $obj_std->std_id]);
                                                                    $checkStd = json_decode($checkStd);
                                                                }
                                                                if (count($checkStd) > 0) {
                                                                    echo '<tr data-std_id="' . $obj_std->std_id . '">';
                                                                    echo '<td style="width: 100px;"class="text-center">' . $obj_std->std_code . '</td>'; // รหัสนักศึกษา
                                                                    echo '<td style="width: 200px;">' . $obj_std->std_prename . $obj_std->std_name . '</td>'; // ชื่อ - สกุล

                                                                    if (count($dataColumn) > 0) {
                                                                        $sumScore = 0;
                                                                        $finalScore = 0;
                                                                        $totalScore = 0;
                                                                        $level = "";
                                                                        $reason = "";

                                                                        foreach ($dataColumn as $key => $value) {
                                                                            $sqlStudentScore = "SELECT * FROM vg_inter_study_students WHERE work_id = :work_id AND std_id = :std_id";
                                                                            $dataStudentScore = $DB->Query($sqlStudentScore, ["work_id" => $value->work_id, "std_id" => $obj_std->std_id]);
                                                                            $dataStudentScore = json_decode($dataStudentScore)[0];

                                                                            $sumScore = $dataStudentScore->sum_score;
                                                                            $finalScore = $dataStudentScore->final_score;
                                                                            $totalScore = $dataStudentScore->total_score;
                                                                            $level = $dataStudentScore->level;
                                                                            $reason = $dataStudentScore->reason;

                                                                            echo '<td style="padding: 5px 2px;" class="text-center">' . $dataStudentScore->score . '</td>';
                                                                        }

                                                                        echo '<td style="padding: 5px 2px;" class="text-center">' . $sumScore . '</td>';
                                                                        // หมายเหตุ
                                                                        echo '<td style="padding: 5px 2px;" class="text-center">' . $finalScore . '</td>';

                                                                        echo '<td style="padding: 5px 2px;" class="text-center">' . $totalScore . '</td>';
                                                                        echo '<td style="padding: 5px 2px;" class="text-center">' . $level . '</td>';
                                                                        echo '<td style="padding: 5px 2px;" class="text-center">' . $reason . '</td>';
                                                                    }
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                        } else {
                                                            echo '<tr><td class="text-center" colspan="11">ไม่มีข้อมูล</td></tr>';
                                                        }
                                                        ?>
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
    <script>
        $(window).on("load", function() {
            printScore();
        });

        function printScore() {
            setTimeout(() => {
                window.print();
            }, 1000);
        }
    </script>
</body>

</html>