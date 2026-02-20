<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลผลการเรียนนักศึกษา</title>
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

        .input-custom-table {
            border: 0;
            border-radius: 0;
        }

        .credit-header p {
            margin: 0;
            font-size: 12px;
        }

        .credit-header i.ti-pencil-alt {
            font-size: 14px;
            position: absolute;
            right: 50px;
            top: 7px;
            cursor: pointer;
        }

        .credit-header i.ti-trash {
            font-size: 14px;
            position: absolute;
            right: 15px;
            top: 7px;
            cursor: pointer;
        }

        .credit-header i.ti-write {
            font-size: 14px;
            position: absolute;
            left: 15px;
            top: 7px;
            cursor: pointer;
            z-index: 10;
        }

        table>thead>tr>th {
            padding: 0px 5px !important;
        }

        table>tbody>tr>td>input {
            padding: 0px !important;
            font-size: 12px !important;
        }

        @media (max-width: 440px) {
            .credit-header i.ti-pencil-alt {
                font-size: 16px;
                right: 35px;
                top: 4px;
            }

            .credit-header i.ti-trash {
                font-size: 16px;
                right: 10px;
                top: 5px;
            }

            .credit-header i.ti-write {
                font-size: 16px;
                right: 10px;
                top: 5px;
            }
        }

        #table-term tbody tr td {
            padding: 5px;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <?php if ($_SESSION['user_data']->role_id != 4) {
            include 'include/sidebar.php';
        } ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" <?php echo $_SESSION['user_data']->role_id != 4 ? '' : 'style="margin:0"' ?>>
            <div class="container-full">

                <?php include "../config/class_database.php";
                $DB = new Class_Database();

                $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $subStr = explode('?', $actual_link);
                $actual_link = $subStr[1];
                
                $subStr = explode('page', $actual_link);
                $actual_link = $subStr[0];
                $actual_link = trim($actual_link, '&');

                $user_create = "";
                if ($_SESSION['user_data']->role_id == 3) {
                    $user_create =  $_SESSION['user_data']->id;
                } else if ($_SESSION['user_data']->role_id == 4) {
                    $user_create =  $_SESSION['user_data']->user_create;
                }

                $std_class = "";
                if (isset($_GET['std_class']) && !empty($_GET['std_class'])) {
                    $std_class =  " AND std_class = '" . $_GET['std_class'] . "'";
                }

                $std_id = "";
                if (isset($_GET['std_id'])) {
                    $std_id =  " AND std_id = '" . $_GET['std_id'] . "'";
                }

                // รับค่าจาก request (เช่น หน้าปัจจุบันและจำนวนรายการต่อหน้า)
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // หน้าปัจจุบัน (default = 1)
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20; // จำนวนรายการต่อหน้า (default = 10)

                // คำนวณ OFFSET
                $offset = ($page - 1) * $limit;

                // SQL สำหรับนับจำนวนทั้งหมด
                $sqlCount = "SELECT COUNT(*) as total FROM tb_students WHERE user_create = :user_create $std_id $std_class";
                $totalData = $DB->Query($sqlCount, ["user_create" => $user_create]);
                $totalData = json_decode($totalData, true);
                $totalRecords = $totalData[0]['total']; // จำนวนรายการทั้งหมด

                $sql = "SELECT * FROM tb_students WHERE user_create = :user_create $std_id $std_class ORDER BY std_class ASC,  std_code ASC LIMIT $limit OFFSET $offset";
                $data = $DB->Query($sql, [
                    "user_create" => $user_create
                ]);

                $std_data = json_decode($data);

                // คำนวณจำนวนหน้าทั้งหมด
                $totalPages = ceil($totalRecords / $limit);
                ?>


                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <?php if ($_SESSION['user_data']->role_id != 4) { ?>
                                    <div class="box-header with-border">
                                        <div class="row">
                                            <h4 class="box-title col-md-10 text-left" style="margin: 0;">
                                                ข้อมูลผลการเรียนนักศึกษา
                                            </h4>
                                        </div>
                                        <div class="row mt-2">
                                            <?php
                                            if (!isset($_GET['std_id']) && empty($_GET['std_id'])) {
                                            ?>
                                                <div class="col-md-2">
                                                    <form action="" method="GET">
                                                        <input type="hidden" name="mode" id="mode" value="view">
                                                        <select class="form-control mt-1" id="std_class" name="std_class" onchange="this.form.submit();" style="width: 100%;">
                                                            <option value="">ชั้นทั้งหมด</option>
                                                            <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ประถม" ? "selected" : "" ?> value="ประถม">ประถม</option>
                                                            <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ม.ต้น" ? "selected" : "" ?> value="ม.ต้น">ม.ต้น</option>
                                                            <option <?php echo isset($_GET['std_class']) && $_GET['std_class'] == "ม.ปลาย" ? "selected" : "" ?> value="ม.ปลาย">ม.ปลาย</option>
                                                        </select>
                                                        <?php
                                                        if (isset($_GET['term']) && !empty($_GET['term'])) {
                                                            echo "<input type='hidden' name='term' value='" . $_GET['term'] . "'>";
                                                        }
                                                        if (isset($_GET['std_id']) && !empty($_GET['std_id'])) {
                                                            echo "<input type='hidden' name='std_id' value='" . $_GET['std_id'] . "'>";
                                                        }
                                                        ?>
                                                    </form>
                                                </div>
                                            <?php } ?>

                                            <div class="col-md-2">
                                                <form action="" method="GET">
                                                    <input type="hidden" name="mode" id="mode" value="view">
                                                    <select class="form-control mt-1" id="term" name="term" onchange="this.form.submit();" style="width: 100%;">
                                                        <option value="">เลือกเทอม</option>
                                                        <?php
                                                        $sql = "SELECT term_id,credit_id,current FROM vg_credit c WHERE c.user_create = :user_create GROUP BY c.term_id ORDER BY c.create_date ASC";
                                                        $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id]);
                                                        $term_data = json_decode($data);
                                                        foreach ($term_data as $key => $term) {
                                                            $termSelected = isset($_GET['term']) ? $_GET['term'] : '';
                                                        ?>
                                                            <option value="<?php echo $term->term_id ?>" <?php echo $term->term_id == $termSelected ? "selected" : "" ?>><?php echo $term->term_id ?></option>
                                                        <?php }

                                                        if (isset($_GET['std_class']) && !empty($_GET['std_class'])) {
                                                            echo "<input type='hidden' name='std_class' value='" . $_GET['std_class'] . "'>";
                                                        }
                                                        if (isset($_GET['std_id']) && !empty($_GET['std_id'])) {
                                                            echo "<input type='hidden' name='std_id' value='" . $_GET['std_id'] . "'>";
                                                        }
                                                        ?>
                                                    </select>
                                                </form>
                                            </div>

                                            <div class="col-md-2">
                                                <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                    <a class="waves-effect waves-light btn btn-success btn-flat mt-1" style="width: 100%;" href="manage_credit_new_add?action=<?php echo urlencode($actual_link) ?>"><i class="ti-plus"></i>&nbsp;บันทึกผลการเรียน</a>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                    <a class="waves-effect waves-light btn btn-success btn-flat mt-1" style="width: 100%;" data-toggle="modal" data-target="#termCreditModal"><i class="ti-write"></i>&nbsp;เลือกรายเทอม</a>
                                                <?php } ?>
                                            </div>
                                            <div class="col-12 row align-items-center">
                                                <?php
                                                if ($_SESSION['user_data']->role_id == 1) { ?>
                                                    <div class="col-md-4 mt-2">
                                                        <select class="form-control select2" id="province_select" style="width: 100%;" onchange="updateTable()">
                                                            <option value="0">เลือกจังหวัด</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <select class="form-control select2" id="district_select" style="width: 100%;" onchange="updateTable()">
                                                            <option value="0">เลือกอำเภอ</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2" id="sub_dis">
                                                        <select class=" form-control select2" id="subdistrict_select" style="width: 100%;" onchange="updateTable()">
                                                            <option value="0">เลือกตำบล</option>
                                                        </select>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <form class="form" id="form_credit_edit_new" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <?php
                                        if (count($std_data) > 0) {
                                            foreach ($std_data as $key => $std) { ?>
                                                <div class="row bg-primary credit-header" style="position: relative;padding: 5px;">
                                                    <div class="col-md-12 d-flex justify-content-center" id="std_section">
                                                        <p><?php echo $std->std_code . " - " . $std->std_prename . $std->std_name ?></p>
                                                    </div>
                                                </div>
                                                <?php
                                                $term_id = "";
                                                if (isset($_GET['current']) || (isset($_GET['term']) && !empty($_GET['term']))) {
                                                    $termVal = isset($_GET['current']) ? $_GET['current'] : $_GET['term'];
                                                    $term_id =  "AND credit.term_id = '" . $termVal . "'";
                                                }
                                                $sql = "SELECT\n" .
                                                    "	credit.credit_id,\n" .
                                                    "	credit.std_id,\n" .
                                                    "	credit.term_id,\n" .
                                                    "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
                                                    "	std.std_code\n" .
                                                    "FROM\n" .
                                                    "	vg_credit credit\n" .
                                                    "	LEFT JOIN tb_students std ON credit.std_id = std.std_id \n" .
                                                    "WHERE\n" .
                                                    "	credit.std_id = :std_id " . $term_id . " ORDER BY credit.term_id ASC";
                                                $data = $DB->Query($sql, ['std_id' => $std->std_id]);
                                                $credit_data = json_decode($data);
                                                // if (count($credit_data) == 0) {
                                                //     echo '<script>location.href = "manage_credit_new";</script>';
                                                //     exit(0);
                                                // }

                                                $view_mode = "";
                                                if (isset($_GET['mode']) && $_GET['mode'] == "view") {
                                                    $view_mode = ' disabled style="background-color: #fff;" ';
                                                }

                                                // $credit_id = $_GET['credit_id'];

                                                $arrSumgrade = [];

                                                if (count($credit_data) > 0) {
                                                    foreach ($credit_data as $key => $value) {
                                                        $credit_id = $value->credit_id;
                                                ?>
                                                        <div class="row credit-header" style="position: relative;padding: 5px;background-color: #b4b4b4;color: #fff;">
                                                            <?php if ($_SESSION['user_data']->role_id != 4) { ?>
                                                                <i class="ti-write" style="width: 16px;" onclick="window.open('pdf/register_pdf?credit_id=<?php echo $value->credit_id; ?>', '_blank');return false;" title="ใบลงทะเบียน"></i>
                                                            <?php } ?>
                                                            <div class="col-md-12 d-flex justify-content-center" id="std_section">
                                                                <p><b>ปีการศึกษาที่ <?php echo $value->term_id ?></b></p>
                                                            </div>
                                                            <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                                <i title="แก้ไขหน่วยกิต" class="ti-pencil-alt" onclick="location.href=`manage_credit_new_edit?credit_id=<?php echo $value->credit_id ?>&std_id=<?php echo $value->std_id ?>&action=<?php echo urlencode($actual_link) ?>`"></i>
                                                                <i title="ลบผลรวมหน่วยกิตนี้" class="ti-trash" onclick="deleteCredit(`<?php echo $value->credit_id; ?>`,`<?php echo $value->term_id ?>`)"></i>
                                                            <?php  } ?>
                                                        </div>
                                                        <div class="row mt-1">
                                                            <?php
                                                            include("include/credit/table1.php");
                                                            include("include/credit/table2.php");
                                                            include("include/credit/table3.php");
                                                            ?>
                                                        </div>
                                                    <?php }
                                                } else { ?>
                                                    <div class="row credit-header">
                                                        <div class="col-md-12 d-flex justify-content-center m-2">
                                                            <p><b>ยังไม่ได้บันทึกผลการเรียน</b></p>
                                                        </div>
                                                    </div>
                                            <?php }
                                            } ?>
                                        <?php } else { ?>
                                            <div class="row credit-header">
                                                <div class="col-md-12 d-flex justify-content-center m-2">
                                                    <p><b>ไม่พบนักศึกษาในระดับชั้นที่เลือก</b></p>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php $current_page = $page;

                                        if ($_SESSION['user_data']->role_id == 3) { ?>
                                            <!-- HTML Pagination -->
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination justify-content-center">
                                                    <!-- ปุ่ม "Previous" -->
                                                    <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                                                        <a class="page-link" href="?<?php echo $actual_link ?>&page=<?= $current_page - 1 ?>" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>

                                                    <!-- ตัวเลขของหน้า -->
                                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                        <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                                            <a class="page-link" href="?<?php echo $actual_link ?>&page=<?= $i ?>"><?= $i ?></a>
                                                        </li>
                                                    <?php endfor; ?>

                                                    <!-- ปุ่ม "Next" -->
                                                    <li class="page-item <?= $current_page >= $totalPages ? 'disabled' : '' ?>">
                                                        <a class="page-link" href="?<?php echo $actual_link ?>&page=<?= $current_page + 1 ?>" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        <?php  } ?>
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

        <div id="termCreditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="termCreditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="termCreditModalLabel">ใบลงทะเบียนรายเทอม</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="table-responsive">
                            <table class="table b-1 border-dark table-bordered mb-0" id="table-term">
                                <thead class="bg-inverse">
                                    <tr>
                                        <th>เทอม</th>
                                        <th class="text-center" style="width: 30%;">พิมพ์</th>
                                        <th class="text-center" style="width: 30%;">ระบุเทอมปัจุบัน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT term_id,credit_id,current FROM vg_credit c WHERE c.user_create = :user_create GROUP BY c.term_id ORDER BY c.create_date ASC";
                                    $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id]);
                                    $term_data = json_decode($data);
                                    foreach ($term_data as $key => $term) { ?>
                                        <tr>
                                            <td><?php echo $term->term_id ?></td>
                                            <td class="text-center">
                                                <a href="pdf/register_pdf?term=<?php echo $term->term_id ?>" target="_blank" style="padding-top: 8px;" type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 btn-xs"><i class="ti-write"></i></a>
                                            </td>
                                            <td class="text-center">
                                                <div class="c-inputs-stacked">
                                                    <input name="currentUsed" type="radio" id="radio_<?php echo $term->credit_id ?>" value="<?php echo $term->term_id ?>" <?php echo !empty($term->current) ? "checked" : '' ?> onchange="setCurrentTerm(this.value)">
                                                    <label for="radio_<?php echo $term->credit_id ?>" class="ml-2"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        function deleteCredit(credit_id, term) {
            const confirmDelete = confirm('ต้องการลบผลรวมหน่วยกิตของปีการศึกษา ' + term + ' หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/credit_controller",
                    data: {
                        deleteCredit: true,
                        credit_id: credit_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            window.location.reload();
                        } else {
                            alert(data.msg)
                        }
                    },
                });
            }
        }

        function setCurrentTerm(term_id) {
            console.log("setCurrentTerm", term_id);
            $.ajax({
                type: "POST",
                url: "controllers/credit_controller",
                data: {
                    setCurrentTerm: true,
                    term_id: term_id
                },
                dataType: "json",
                success: function(data) {

                },
            })
        }
    </script>
</body>

</html>