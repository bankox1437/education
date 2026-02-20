<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แบบบันทึกการเยี่ยมบ้าน ดล.1.2</title>
    <style>
        #preview {
            width: 30%;
        }

        @media only screen and (max-width: 600px) {
            #preview {
                width: 100%;
            }
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
                            <div class="box">
                                <div class="box-header with-border">
                                    <h6 class="box-title text-info" style="margin: 0;">
                                        <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form1_2'"></i>
                                        &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มแบบบันทึกการเยี่ยมบ้าน</b>
                                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-dark"><?php echo $_GET['std_name']; ?></span>
                                    </h6>
                                </div>
                                <?php
                                include "../config/class_database.php";
                                $DB = new Class_Database();
                                $sql = "SELECT * FROM stf_tb_form_visit_home
                                LEFT JOIN tb_students ON stf_tb_form_visit_home.std_id = tb_students.std_id
                                 WHERE form_visit_id = :form_visit_id";
                                $data = $DB->Query($sql, ["form_visit_id" => $_GET['form_visit_id']]);
                                $visitData = json_decode($data);
                                $visitData = $visitData[0];
                                ?>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="h4"><b>1. ข้อมูลนักศึกษา <span class="text-danger">*</span></b></label>
                                                <h5><?php echo $_GET['std_name']; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อ-สกุล (บิดา)</label>
                                                <input type="text" value="<?php echo $visitData->std_father_name ?>" class="form-control height-input" name="father" id="father" autocomplete="off" placeholder="กรอกชื่อ-สกุล (บิดา)">
                                                <input type="hidden" value="<?php echo $visitData->std_id ?>"  name="std_id" id="std_id">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>อาชีพ</label>
                                                <input type="text" value="<?php echo $visitData->std_father_job ?>" class="form-control height-input required" name="father_job" id="father_job" autocomplete="off" placeholder="กรอกอาชีพ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อ-สกุล (มารดา)</label>
                                                <input type="text" value="<?php echo $visitData->std_mather_name ?>" class="form-control height-input" name="mather" id="mather" autocomplete="off" placeholder="กรอกชื่อ-สกุล (มารดา)">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>อาชีพ</label>
                                                <input type="text" value="<?php echo $visitData->std_mather_job ?>" class="form-control height-input required" name="mather_job" id="mather_job" autocomplete="off" placeholder="กรอกอาชีพ">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php
                                    $sql = "SELECT * FROM stf_tb_form_visit_home_side_2 WHERE form_visit_id = :form_visit_id";
                                    $data = $DB->Query($sql, ["form_visit_id" => $_GET['form_visit_id']]);
                                    $visit2 = json_decode($data);
                                    $visit2 = $visit2[0];
                                    ?>
                                    <h4><b>2. สภาพทั่วไปที่พบบ้านนักศึกษา</b></h4>
                                    <div class="form-group">
                                        <label><b>2.1 สภาพแวดล้อม / ท้องถิ่นของนักศึกษา <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <input name="side_2_1" type="radio" id="very_good_2_1" class="with-gap radio-col-info" value="very_good" <?php echo $visit2->side_2_1 == 'very_good' ? 'checked' : '' ?>>
                                            <label for="very_good_2_1" class="mr-30">ดีมาก</label>
                                            <input name="side_2_1" type="radio" id="good_2_1" class="with-gap radio-col-info" value="good" <?php echo $visit2->side_2_1 == 'good' ? 'checked' : '' ?>>
                                            <label for="good_2_1" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_2_1" type="radio" id="poor_2_1" class="with-gap radio-col-info" value="poor" <?php echo $visit2->side_2_1 == 'poor' ? 'checked' : '' ?>>
                                            <label for="poor_2_1" class="mr-30">ยากจน</label>
                                            <input name="side_2_1" type="radio" id="unsure_2_1" class="with-gap radio-col-info" value="unsure" <?php echo $visit2->side_2_1 != 'unsure' && $visit2->side_2_1 != 'poor' && $visit2->side_2_1 != 'good' && $visit2->side_2_1 != 'very_good'  ? 'checked' : '' ?>>
                                            <label for="unsure_2_1" class="mr-30">ไม่แน่ใจ เพราะ</label>
                                            <textarea rows="3" style="display: <?php echo $visit2->side_2_1 != 'unsure' && $visit2->side_2_1 != 'poor' && $visit2->side_2_1 != 'good' && $visit2->side_2_1 != 'very_good'  ? 'block' : 'none' ?>;" id="input_unsure_2_1" class="form-control text-left" placeholder="กรุณากรอกสภาพแวดล้อม"><?php echo $visit2->side_2_1 != 'unsure' && $visit2->side_2_1 != 'poor' && $visit2->side_2_1 != 'good' && $visit2->side_2_1 != 'very_good'  ? $visit2->side_2_1 : '' ?></textarea>
                                        </div>
                                        <label id="side_2_2"><b>2.2 สภาพบ้าน / และครอบครัว <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <input name="side_2_2" type="radio" id="very_good_2_2" class="with-gap radio-col-info" value="very_good" <?php echo $visit2->side_2_2 == 'very_good' ? 'checked' : '' ?>>
                                            <label for="very_good_2_2" class="mr-30">ดีมาก</label>
                                            <input name="side_2_2" type="radio" id="good_2_2" class="with-gap radio-col-info" value="good" <?php echo $visit2->side_2_2 == 'good' ? 'checked' : '' ?>>
                                            <label for="good_2_2" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_2_2" type="radio" id="poor_2_2" class="with-gap radio-col-info" value="poor" <?php echo $visit2->side_2_2 == 'poor' ? 'checked' : '' ?>>
                                            <label for="poor_2_2" class="mr-30">ยากจน</label>
                                            <input name="side_2_2" type="radio" id="unsure_2_2" class="with-gap radio-col-info" value="unsure" <?php echo $visit2->side_2_2 != 'unsure' && $visit2->side_2_2 != 'poor' && $visit2->side_2_2 != 'good' && $visit2->side_2_2 != 'very_good'  ? 'checked' : '' ?>>
                                            <label for="unsure_2_2" class="mr-30">ไม่แน่ใจ เพราะ</label>
                                            <textarea rows="3" style="display: <?php echo $visit2->side_2_2 != 'unsure' && $visit2->side_2_2 != 'poor' && $visit2->side_2_2 != 'good' && $visit2->side_2_2 != 'very_good'  ? 'block' : 'none' ?>;" id="input_unsure_2_2" class="form-control" placeholder="กรุณากรอกสภาพบ้าน"><?php echo $visit2->side_2_2 != 'unsure' && $visit2->side_2_2 != 'poor' && $visit2->side_2_2 != 'good' && $visit2->side_2_2 != 'very_good'  ? $visit2->side_2_2 : '' ?></textarea>
                                        </div>
                                        <label id="side_2_3"><b>2.3 ความสัมพันธ์ของครอบครัว <span class="text-danger">*</span></b></label>
                                        <div class=" c-inputs-stacked">
                                            <input name="side_2_3" type="radio" id="very_good_2_3" class="with-gap radio-col-info" value="very_good" <?php echo $visit2->side_2_3 == 'very_good' ? 'checked' : '' ?>>
                                            <label for="very_good_2_3" class="mr-30">ดีมาก</label>
                                            <input name="side_2_3" type="radio" id="good_2_3" class="with-gap radio-col-info" value="good" <?php echo $visit2->side_2_3 == 'good' ? 'checked' : '' ?>>
                                            <label for="good_2_3" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_2_3" type="radio" id="poor_2_3" class="with-gap radio-col-info" value="poor" <?php echo $visit2->side_2_3 == 'poor' ? 'checked' : '' ?>>
                                            <label for="poor_2_3" class="mr-30">ยากจน</label>
                                            <input name="side_2_3" type="radio" id="unsure_2_3" class="with-gap radio-col-info" value="unsure" <?php echo $visit2->side_2_3 != 'unsure' && $visit2->side_2_3 != 'poor' && $visit2->side_2_3 != 'good' && $visit2->side_2_3 != 'very_good'  ? 'checked' : '' ?>>
                                            <label for="unsure_2_3" class="mr-30">ไม่แน่ใจ เพราะ</label>
                                            <textarea rows="3" style="display: <?php echo $visit2->side_2_3 != 'unsure' && $visit2->side_2_3 != 'poor' && $visit2->side_2_3 != 'good' && $visit2->side_2_3 != 'very_good'  ? 'block' : 'none' ?>;" id="input_unsure_2_3" class="form-control" placeholder="กรุณากรอกความสัมพันธ์ของครอบครัว"><?php echo $visit2->side_2_3 != 'unsure' && $visit2->side_2_3 != 'poor' && $visit2->side_2_3 != 'good' && $visit2->side_2_3 != 'very_good'  ? $visit2->side_2_3 : '' ?></textarea>
                                        </div>
                                        <label id="side_2_4"><b>2.4 ข้อมูลด้านอื่นๆ</b></label>
                                        <div class="c-inputs-stacked">
                                            <textarea rows="3" id="another_2_4" class="form-control" placeholder="กรุณากรอกข้อมูลอื่นๆ "><?php echo htmlspecialchars($visit2->side_2_4) ?></textarea>
                                        </div>
                                    </div>

                                    <hr class="mt-4 mb-4">
                                    <?php
                                    $sql = "SELECT * FROM stf_tb_form_visit_home_side_3 WHERE form_visit_id = :form_visit_id";
                                    $data = $DB->Query($sql, ["form_visit_id" => $_GET['form_visit_id']]);
                                    $visit3 = json_decode($data);
                                    $visit3 = $visit3[0];
                                    ?>
                                    <h4><b>3. ความคิดเห็นของผู้ปกครองต่อนักศึกษา</b></h4>
                                    <div class="form-group">
                                        <label><b>3.1 ภารกิจที่รับผิดชอบ คือ <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <textarea rows="3" id="text_3_1" class="form-control" placeholder="กรุณากรอกภารกิจที่รับผิดชอบ "><?php echo $visit3->text_3_1 ?></textarea>
                                            <input name="side_3_1" type="radio" id="very_good_3_1" class="with-gap radio-col-info" value="very_good" <?php echo $visit3->side_3_1 == 'very_good' ? 'checked' : '' ?>>
                                            <label for="very_good_3_1" class="mt-2" class="mr-30">ดีมาก</label>
                                            <input name="side_3_1" type="radio" id="good_3_1" class="with-gap radio-col-info" value="good" <?php echo $visit3->side_3_1 == 'good' ? 'checked' : '' ?>>
                                            <label for="good_3_1" class="mt-2" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_3_1" type="radio" id="meliorate_3_1" class="with-gap radio-col-info" value="meliorate" <?php echo $visit3->side_3_1 == 'meliorate' ? 'checked' : '' ?>>
                                            <label for="meliorate_3_1" class="mt-2" class="mr-30">ปรับปรุง</label>
                                        </div>
                                        <label><b>3.2 การใช้เวลาว่างที่บ้าน ได้แก่ <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <textarea rows="3" id="text_3_2" class="form-control" placeholder="กรุณากรอกการใช้เวลาว่างที่บ้าน  "><?php echo $visit3->text_3_2 ?></textarea>
                                            <input name="side_3_2" type="radio" id="very_good_3_2" class="with-gap radio-col-info" value="very_good" <?php echo $visit3->side_3_2 == 'very_good' ? 'checked' : '' ?>>
                                            <label for="very_good_3_2" class="mt-2" class="mr-30">ดีมาก</label>
                                            <input name="side_3_2" type="radio" id="good_5" class="with-gap radio-col-info" value="good" <?php echo $visit3->side_3_2 == 'good' ? 'checked' : '' ?>>
                                            <label for="good_5" class="mt-2" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_3_2" type="radio" id="meliorate_2" class="with-gap radio-col-info" value="meliorate" <?php echo $visit3->side_3_2 == 'meliorate' ? 'checked' : '' ?>>
                                            <label for="meliorate_2" class="mt-2" class="mr-30">ปรับปรุง</label>
                                        </div>
                                        <label><b>3.3 การมีสัมพันธภาพต่อครอบครัว ได้แก่ <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <textarea rows="3" id="text_3_3" class="form-control" placeholder="กรุณากรอกการมีสัมพันธภาพต่อครอบครัว"><?php echo $visit3->text_3_3 ?></textarea>
                                            <input name="side_3_3" type="radio" id="very_good_3_3" class="with-gap radio-col-info" value="very_good" <?php echo $visit3->side_3_3 == 'very_good' ? 'checked' : '' ?>>
                                            <label for="very_good_3_3" class="mt-2" class="mr-30">ดีมาก</label>
                                            <input name="side_3_3" type="radio" id="good_3_3" class="with-gap radio-col-info" value="good" <?php echo $visit3->side_3_3 == 'good' ? 'checked' : '' ?>>
                                            <label for="good_3_3" class="mt-2" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_3_3" type="radio" id="meliorate_3_3" class="with-gap radio-col-info" value="meliorate" <?php echo $visit3->side_3_3 == 'meliorate' ? 'checked' : '' ?>>
                                            <label for="meliorate_3_3" class="mt-2" class="mr-30">ปรับปรุง</label>
                                        </div>
                                        <label><b>3.4 การเอาใจใส่ต่อการเรียน <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <!-- <textarea rows="2" id="text_3_4" class="form-control" placeholder="การเอาใจใส่ต่อการเรียน"></textarea> -->
                                            <input name="side_3_4" type="radio" id="very_good_3_4" class="with-gap radio-col-info" value="very_good" <?php echo $visit3->side_3_4 == 'very_good' ? 'checked' : '' ?>>
                                            <label for="very_good_3_4" class="mt-2" class="mr-30">ดีมาก</label>
                                            <input name="side_3_4" type="radio" id="good_3_4" class="with-gap radio-col-info" value="good" <?php echo $visit3->side_3_4 == 'good' ? 'checked' : '' ?>>
                                            <label for="good_3_4" class="mt-2" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_3_4" type="radio" id="meliorate_3_4" class="with-gap radio-col-info" value="meliorate" <?php echo $visit3->side_3_4 == 'meliorate' ? 'checked' : '' ?>>
                                            <label for="meliorate_3_4" class="mt-2" class="mr-30">ปรับปรุง</label>
                                        </div>
                                        <label><b>3.5 อื่นๆ</b></label>
                                        <div class="c-inputs-stacked">
                                            <textarea rows="3" id="side_3_5" class="form-control" placeholder="อื่นๆ"><?php echo $visit3->side_3_5 ?></textarea>
                                        </div>
                                    </div>

                                    <hr class="mt-4 mb-4">
                                    <?php
                                    $sql = "SELECT * FROM stf_tb_form_visit_home_side_4 WHERE form_visit_id = :form_visit_id";
                                    $data = $DB->Query($sql, ["form_visit_id" => $_GET['form_visit_id']]);
                                    $visit4 = json_decode($data);
                                    $visit4 = $visit4[0];
                                    ?>
                                    <div class="form-group">
                                        <h4><b>4. สรุปผลการเยี่ยมบ้านนักศึกษา (โดยรวมพบว่า) <span class="text-danger">*</span></b></h4>
                                        <div class="c-inputs-stacked">
                                            <input name="side_4" type="radio" id="very_good_4" class="with-gap radio-col-info" value="very_good" <?php echo $visit4->status == 'very_good' ? 'checked' : '' ?>>
                                            <label for="very_good_4" class="mr-30">ดีมาก</label>
                                            <input name="side_4" type="radio" id="promote_4" class="with-gap radio-col-info" value="promote" <?php echo $visit4->status == 'promote' ? 'checked' : '' ?>>
                                            <label for="promote_4" class="mr-30">ควรส่งเสริม</label>
                                            <input name="side_4" type="radio" id="help_4" class="with-gap radio-col-info" value="help" <?php echo $visit4->status == 'help' ? 'checked' : '' ?>>
                                            <label for="help_4" class="mr-30">ควรช่วยเหลือเร่งด่วน</label>
                                            <textarea rows="3" style="display: <?php echo $visit4->status == 'promote' || $visit4->status == 'help' ? 'block' : 'none' ?>;" id="text_4" class="form-control" placeholder="กรุณากรอกสรุปผลการเยี่ยมบ้านนักศึกษา"><?php echo $visit4->text  ?></textarea>

                                        </div>
                                    </div>

                                    <hr class="mt-4 mb-4">
                                    <?php
                                    $sql = "SELECT * FROM stf_tb_form_visit_home WHERE form_visit_id = :form_visit_id";
                                    $data = $DB->Query($sql, ["form_visit_id" => $_GET['form_visit_id']]);
                                    $visit5 = json_decode($data);
                                    $visit5 = $visit5[0];
                                    ?>
                                    <div class="form-group">
                                        <label class="h4 mt-3">
                                            <b>5. แผนที่ทางไปบ้านนักศึกษา </b> <span class="text-danger">( <a href="https://www.google.co.th/maps" target="_blank" rel="noopener noreferrer">Link Google Map</a> )</span>
                                        </label>
                                        <label class="mt-3"> </label>
                                        <input type="text" id="side_5" class="form-control" value="<?php echo $visit5->location  ?>" placeholder="กรอก url google map">
                                    </div>
                                    <div class="form-group">
                                        <label class="h4 mt-3">
                                            <b>6. แนบรูปภาพบ้านนักศึกษา</b>
                                        </label>
                                        <label class="mt-3"> </label>
                                        <input type="file" id="side_6" accept="image/png, image/gif, image/jpeg" class="form-control" placeholder="กรอก url google map" onchange="changeInputFile(this)">
                                        <input type="hidden" id="side_6_old" value="<?php echo $visit5->home_img; ?>">
                                    </div>
                                    <div><img src="<?php echo !empty($visit5->home_img) ? "uploads/visit_home_img/" . $visit5->home_img : "images/no-image.jpg" ?>" id="preview" style="display: block;"></div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer" id="footer_btn">
                                    <button type="button" class="btn btn-rounded btn-primary btn-outline" onclick="submitEditFormVisit()">
                                        <i class="ti-save-alt"></i> บันทึกข้อมูล
                                    </button>
                                </div>
                                <!-- /.box -->
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
    <script src="js/form_visit_home.js?v=<?php echo $version; ?>"></script>
    <script src="js/view_js/form_1.2_edit.js?v=<?php echo $version; ?>"></script>
</body>

</html>