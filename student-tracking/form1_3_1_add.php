<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มแบบประเมินนักศึกษา</title>
    <style>
        table tbody td:nth-child(3),
        td:nth-child(4),
        td:nth-child(5) {
            cursor: pointer;
        }

        table tbody td:nth-child(3) label,
        td:nth-child(4) label,
        td:nth-child(5) label {
            padding: 0;
            margin: 0;
            margin-top: 5px;
            margin-left: 5px;
        }

        table tbody td:nth-child(3):hover {
            background: #c3c3c3;
            transition: all;
        }

        table tbody td:nth-child(4):hover {
            background: #c3c3c3;
        }

        table tbody td:nth-child(5):hover {
            background: #c3c3c3;
        }

        .border-red {
            border: 1px solid red;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php include 'include/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <form id="form-add-evaluate">
                                <div class="box">
                                    <div class="box-body">
                                        <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form1_3_1'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มแบบประเมินนักศึกษา</b></h6>
                                        <hr class="my-15">

                                        <div class="row justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="form-control select2" name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="row ml-3 mr-3">
                                            <div class="col-md">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="font-size: 14px;">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th style="width: 50px;">ที่</th>
                                                                <th>พฤติกรรมประเมิน</th>
                                                                <th style="width: 150px;">ไม่จริง</th>
                                                                <th style="width: 150px;">จริงบางครั้ง</th>
                                                                <th style="width: 150px;">จริง</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="body-behavior">
                                                            <?php
                                                            include "../config/class_database.php";
                                                            $DB = new Class_Database();
                                                            $sql = "SELECT * FROM stf_tb_behavior ORDER BY behavior_id ASC";
                                                            $data = $DB->Query($sql, []);
                                                            $databehavior = json_decode($data);
                                                            for ($i = 0; $i < count($databehavior); $i++) { ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $i + 1; ?></td>
                                                                    <td><?php echo $databehavior[$i]->behavior ?></td>
                                                                    <td class="text-center" onclick="checkedbehavior('false_<?php echo $databehavior[$i]->behavior_id ?>')">
                                                                        <input name="behavior-<?php echo $databehavior[$i]->behavior_id ?>" type="radio" id="false_<?php echo $databehavior[$i]->behavior_id ?>" data-id="<?php echo $databehavior[$i]->behavior_id ?>" data-side="<?php echo $databehavior[$i]->side ?>" data-score="<?php echo $databehavior[$i]->false_score ?>" class="with-gap radio-col-info" value="false">
                                                                        <label for="false_<?php echo $databehavior[$i]->behavior_id ?>"></label>
                                                                    </td>
                                                                    <td class="text-center" onclick="checkedbehavior('somthing_true_<?php echo $databehavior[$i]->behavior_id ?>')">
                                                                        <input name="behavior-<?php echo $databehavior[$i]->behavior_id ?>" type="radio" id="somthing_true_<?php echo $databehavior[$i]->behavior_id ?>" data-id="<?php echo $databehavior[$i]->behavior_id ?>" data-side="<?php echo $databehavior[$i]->side ?>" data-score="<?php echo $databehavior[$i]->something_score ?>" class="with-gap radio-col-info" value="somthing_true">
                                                                        <label for="somthing_true_<?php echo $databehavior[$i]->behavior_id ?>"></label>
                                                                    </td>
                                                                    <td class="text-center" onclick="checkedbehavior('true_<?php echo $databehavior[$i]->behavior_id ?>')">
                                                                        <input name="behavior-<?php echo $databehavior[$i]->behavior_id ?>" type="radio" id="true_<?php echo $databehavior[$i]->behavior_id ?>" data-id="<?php echo $databehavior[$i]->behavior_id ?>" data-side="<?php echo $databehavior[$i]->side ?>" data-score="<?php echo $databehavior[$i]->true_score ?>" class="with-gap radio-col-info" value="true">
                                                                        <label for="true_<?php echo $databehavior[$i]->behavior_id ?>"></label>
                                                                    </td>
                                                                </tr>
                                                            <?php   } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2 mb-4">
                                            <div class="col-md ml-4">
                                                <button type="button" class="btn btn-rounded btn-success" onclick="checkBehaviorChecked('cal_score')">
                                                    <i class="ti-light-bulb"></i> คำนวณคะแนนบันทึก
                                                </button>
                                            </div>
                                        </div>
                                        <div id="div_result" style="display: none;">
                                            <div class="form-group row ml-4 mt-4">
                                                <label for="note" class="col-sm-4 col-form-label">คุณมีความเห็นหรือความกังวลอื่นหรือไม่ (ไม่บังคับ)</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="" id="note" placeholder="กรอกความเห็นหรือความกังวลอื่น">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1 ml-4 ">
                                                <label for="score_1" class="col-sm-2 col-form-label text-left">คะแนนด้านที่ 1</label>
                                                <div class="col-sm-1">
                                                    <input class="form-control text-center" type="text" id="score_1" placeholder="" disabled>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label class="col-form-label">แปลผล : </label>
                                                    <label class="col-form-label" id="result_1">ปกติ </label>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1 ml-4 ">
                                                <label for="score_1" class="col-sm-2 col-form-label text-left">คะแนนด้านที่ 2</label>
                                                <div class="col-sm-1">
                                                    <input class="form-control text-center" type="text" id="score_2" placeholder="" disabled>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label class="col-form-label">แปลผล : </label>
                                                    <label class="col-form-label" id="result_2">ปกติ </label>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1 ml-4 ">
                                                <label for="score_1" class="col-sm-2 col-form-label text-left">คะแนนด้านที่ 3</label>
                                                <div class="col-sm-1">
                                                    <input class="form-control text-center" type="text" id="score_3" placeholder="" disabled>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label class="col-form-label">แปลผล : </label>
                                                    <label class="col-form-label" id="result_3">ปกติ </label>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1 ml-4 ">
                                                <label for="score_1" class="col-sm-2 col-form-label text-left">คะแนนด้านที่ 4</label>
                                                <div class="col-sm-1">
                                                    <input class="form-control text-center" type="text" id="score_4" placeholder="" disabled>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label class="col-form-label">แปลผล : </label>
                                                    <label class="col-form-label" id="result_4">ปกติ </label>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1 ml-4 ">
                                                <label for="score_1" class="col-sm-2 col-form-label text-left">รวมคะแนนทั้ง 4 ด้าน</label>
                                                <div class="col-sm-1">
                                                    <input class="form-control text-center" type="text" id="sum_score" placeholder="" disabled>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label class="col-form-label">แปลผล : </label>
                                                    <label class="col-form-label" id="result_sum">ปกติ </label>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1 ml-4 ">
                                                <label for="score_1" class="col-sm-2 col-form-label text-left">คะแนนด้านที่ 5</label>
                                                <div class="col-sm-1">
                                                    <input class="form-control text-center" type="text" id="score_5" placeholder="" disabled>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label class="col-form-label">แปลผล : </label>
                                                    <label class="col-form-label" id="result_5">ปกติ </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer" id="footer_btn" style="display: none;">
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline" id="btn-submit">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                    </div>
                                </div>
                            </form>


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

    <script src="js/view_js/form_1.3.1_add.js"></script>
</body>

</html>