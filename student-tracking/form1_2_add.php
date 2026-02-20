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
                                    <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form1_2'"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มแบบบันทึกการเยี่ยมบ้าน</b></h6>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="h4"><b>1. ข้อมูลนักศึกษา <span class="text-danger">*</span></b></label>
                                                <select class="form-control select2" name="std_class" id="std_class" data-placeholder="ชั้น" style="width: 100%;" onchange="getDataStd(this.value)">
                                                    <option value="">ชั้นทั้งหมด</option>
                                                    <option value="ประถม">ประถม</option>
                                                    <option value="ม.ต้น">ม.ต้น</option>
                                                    <option value="ม.ปลาย">ม.ปลาย</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mt-1" style="margin-bottom: 0px;">
                                                <label class="mb-2"> &nbsp; </label>
                                                <select class="form-control select2" name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;" onchange="getFMdata(this)">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อ-สกุล (บิดา)</label>
                                                <input type="text" value="" class="form-control height-input" name="father" id="father" autocomplete="off" placeholder="กรอกชื่อ-สกุล (บิดา)">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>อาชีพ</label>
                                                <input type="text" value="" class="form-control height-input required" name="father_job" id="father_job" autocomplete="off" placeholder="กรอกอาชีพ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อ-สกุล (มารดา)</label>
                                                <input type="text" value="" class="form-control height-input" name="mather" id="mather" autocomplete="off" placeholder="กรอกชื่อ-สกุล (มารดา)">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>อาชีพ</label>
                                                <input type="text" value="" class="form-control height-input required" name="mather_job" id="mather_job" autocomplete="off" placeholder="กรอกอาชีพ">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h4><b>2. สภาพทั่วไปที่พบบ้านนักศึกษา</b></h4>
                                    <div class="form-group">
                                        <label><b>2.1 สภาพแวดล้อม / ท้องถิ่นของนักศึกษา <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <input name="side_2_1" type="radio" id="very_good_2_1" class="with-gap radio-col-info" value="very_good" checked>
                                            <label for="very_good_2_1" class="mr-30">ดีมาก</label>
                                            <input name="side_2_1" type="radio" id="good_2_1" class="with-gap radio-col-info" value="good">
                                            <label for="good_2_1" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_2_1" type="radio" id="poor_2_1" class="with-gap radio-col-info" value="poor">
                                            <label for="poor_2_1" class="mr-30">ปานกลาง</label>
                                            <input name="side_2_1" type="radio" id="unsure_2_1" class="with-gap radio-col-info" value="unsure">
                                            <label for="unsure_2_1" class="mr-30">ไม่แน่ใจ เพราะ</label>
                                            <textarea rows="3" style="display: none;" id="input_unsure_2_1" class="form-control" placeholder="กรุณากรอกสภาพแวดล้อม"></textarea>
                                        </div>
                                        <label id="side_2_2"><b>2.2 สภาพบ้าน / และครอบครัว <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <input name="side_2_2" type="radio" id="very_good_2_2" class="with-gap radio-col-info" value="very_good" checked>
                                            <label for="very_good_2_2" class="mr-30">ดีมาก</label>
                                            <input name="side_2_2" type="radio" id="good_2_2" class="with-gap radio-col-info" value="good">
                                            <label for="good_2_2" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_2_2" type="radio" id="poor_2_2" class="with-gap radio-col-info" value="poor">
                                            <label for="poor_2_2" class="mr-30">ปานกลาง</label>
                                            <input name="side_2_2" type="radio" id="unsure_2_2" class="with-gap radio-col-info" value="unsure">
                                            <label for="unsure_2_2" class="mr-30">ไม่แน่ใจ เพราะ</label>
                                            <textarea rows="3" style="display: none;" id="input_unsure_2_2" class="form-control" placeholder="กรุณากรอกสภาพบ้าน"></textarea>
                                        </div>
                                        <label id="side_2_3"><b>2.3 ความสัมพันธ์ของครอบครัว <span class="text-danger">*</span></b></label>
                                        <div class=" c-inputs-stacked">
                                            <input name="side_2_3" type="radio" id="very_good_2_3" class="with-gap radio-col-info" value="very_good" checked>
                                            <label for="very_good_2_3" class="mr-30">ดีมาก</label>
                                            <input name="side_2_3" type="radio" id="good_2_3" class="with-gap radio-col-info" value="good">
                                            <label for="good_2_3" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_2_3" type="radio" id="poor_2_3" class="with-gap radio-col-info" value="poor">
                                            <label for="poor_2_3" class="mr-30">ปานกลาง</label>
                                            <input name="side_2_3" type="radio" id="unsure_2_3" class="with-gap radio-col-info" value="unsure">
                                            <label for="unsure_2_3" class="mr-30">ไม่แน่ใจ เพราะ</label>
                                            <textarea rows="3" style="display: none;" id="input_unsure_2_3" class="form-control" placeholder="กรุณากรอกความสัมพันธ์ของครอบครัว"></textarea>
                                        </div>
                                        <label id="side_2_4"><b>2.4 ข้อมูลด้านอื่นๆ</b></label>
                                        <div class="c-inputs-stacked">
                                            <textarea rows="3" id="another_2_4" class="form-control" placeholder="กรุณากรอกข้อมูลอื่นๆ "></textarea>
                                        </div>
                                    </div>

                                    <hr class="mt-4 mb-4">

                                    <h4><b>3. ความคิดเห็นของผู้ปกครองต่อนักศึกษา</b></h4>
                                    <div class="form-group">
                                        <label><b>3.1 ภารกิจที่รับผิดชอบ คือ <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <textarea rows="3" id="text_3_1" class="form-control" placeholder="กรุณากรอกภารกิจที่รับผิดชอบ "></textarea>
                                            <input name="side_3_1" type="radio" id="very_good_3_1" class="with-gap radio-col-info" value="very_good" checked>
                                            <label for="very_good_3_1" class="mt-2" class="mr-30">ดีมาก</label>
                                            <input name="side_3_1" type="radio" id="good_3_1" class="with-gap radio-col-info" value="good">
                                            <label for="good_3_1" class="mt-2" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_3_1" type="radio" id="meliorate_3_1" class="with-gap radio-col-info" value="meliorate">
                                            <label for="meliorate_3_1" class="mt-2" class="mr-30">ปรับปรุง</label>
                                        </div>
                                        <label><b>3.2 การใช้เวลาว่างที่บ้าน ได้แก่ <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <textarea rows="3" id="text_3_2" class="form-control" placeholder="กรุณากรอกการใช้เวลาว่างที่บ้าน  "></textarea>
                                            <input name="side_3_2" type="radio" id="very_good_3_2" class="with-gap radio-col-info" value="very_good" checked>
                                            <label for="very_good_3_2" class="mt-2" class="mr-30">ดีมาก</label>
                                            <input name="side_3_2" type="radio" id="good_5" class="with-gap radio-col-info" value="good">
                                            <label for="good_5" class="mt-2" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_3_2" type="radio" id="meliorate_2" class="with-gap radio-col-info" value="meliorate">
                                            <label for="meliorate_2" class="mt-2" class="mr-30">ปรับปรุง</label>
                                        </div>
                                        <label><b>3.3 การมีสัมพันธภาพต่อครอบครัว ได้แก่ <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <textarea rows="3" id="text_3_3" class="form-control" placeholder="กรุณากรอกการมีสัมพันธภาพต่อครอบครัว"></textarea>
                                            <input name="side_3_3" type="radio" id="very_good_3_3" class="with-gap radio-col-info" value="very_good" checked>
                                            <label for="very_good_3_3" class="mt-2" class="mr-30">ดีมาก</label>
                                            <input name="side_3_3" type="radio" id="good_3_3" class="with-gap radio-col-info" value="good">
                                            <label for="good_3_3" class="mt-2" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_3_3" type="radio" id="meliorate_3_3" class="with-gap radio-col-info" value="meliorate">
                                            <label for="meliorate_3_3" class="mt-2" class="mr-30">ปรับปรุง</label>
                                        </div>
                                        <label><b>3.4 การเอาใจใส่ต่อการเรียน <span class="text-danger">*</span></b></label>
                                        <div class="c-inputs-stacked">
                                            <!-- <textarea rows="2" id="text_3_4" class="form-control" placeholder="การเอาใจใส่ต่อการเรียน"></textarea> -->
                                            <input name="side_3_4" type="radio" id="very_good_3_4" class="with-gap radio-col-info" value="very_good" checked>
                                            <label for="very_good_3_4" class="mt-2" class="mr-30">ดีมาก</label>
                                            <input name="side_3_4" type="radio" id="good_3_4" class="with-gap radio-col-info" value="good">
                                            <label for="good_3_4" class="mt-2" class="mr-30">ค่อนข้างดี</label>
                                            <input name="side_3_4" type="radio" id="meliorate_3_4" class="with-gap radio-col-info" value="meliorate">
                                            <label for="meliorate_3_4" class="mt-2" class="mr-30">ปรับปรุง</label>
                                        </div>
                                        <label><b>3.5 อื่นๆ</b></label>
                                        <div class="c-inputs-stacked">
                                            <textarea rows="3" id="side_3_5" class="form-control" placeholder="อื่นๆ"></textarea>
                                        </div>
                                    </div>

                                    <hr class="mt-4 mb-4">

                                    <div class="form-group">
                                        <h4><b>4. สรุปผลการเยี่ยมบ้านนักศึกษา (โดยรวมพบว่า) <span class="text-danger">*</span></b></h4>
                                        <div class="c-inputs-stacked">
                                            <input name="side_4" type="radio" id="very_good_4" class="with-gap radio-col-info" value="very_good" checked>
                                            <label for="very_good_4" class="mr-30">ดีมาก</label>
                                            <input name="side_4" type="radio" id="promote_4" class="with-gap radio-col-info" value="promote">
                                            <label for="promote_4" class="mr-30">ควรส่งเสริม</label>
                                            <input name="side_4" type="radio" id="help_4" class="with-gap radio-col-info" value="help">
                                            <label for="help_4" class="mr-30">ควรช่วยเหลือเร่งด่วน</label>
                                            <textarea rows="3" style="display: none;" id="text_4" class="form-control" placeholder="กรุณากรอกสรุปผลการเยี่ยมบ้านนักศึกษา"></textarea>

                                        </div>
                                    </div>

                                    <hr class="mt-4 mb-4">

                                    <div class="form-group">
                                        <label class="h4 mt-3">
                                            <b>5. แผนที่ทางไปบ้านนักศึกษา </b> <span class="text-danger">( <a href="https://www.google.co.th/maps" target="_blank" rel="noopener noreferrer">Link Google Map</a> )</span>
                                        </label>
                                        <label class="mt-3"> </label>
                                        <input type="text" id="side_5" class="form-control" placeholder="กรอก url google map">
                                    </div>

                                    <div class="form-group">
                                        <label class="h4 mt-3">
                                            <b>6. แนบรูปภาพบ้านนักศึกษา <span class="text-danger">*</span></b>
                                        </label>
                                        <label class="mt-3"> </label>
                                        <input type="file" id="side_6" accept="image/png, image/gif, image/jpeg" class="form-control" placeholder="กรอก url google map" onchange="changeInputFile(this)">
                                    </div>
                                    <div><img src="" id="preview" style="display: none;"></div>

                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer" id="footer_btn">
                                    <button type="button" class="btn btn-rounded btn-primary btn-outline" onclick="submitFormVisit()">
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
    <script src="js/view_js/form_1.2_add.js?v=<?php echo $version; ?>"></script>
    <script>
        function getFMdata(select) {
            let selectedOption = $(select).find('option:selected');

            // Retrieve data attributes from the selected option
            let fatherName = selectedOption.attr('data-father');
            let matherName = selectedOption.attr('data-mather');
            let fatherJob = selectedOption.attr('data-father-job');
            let matherJob = selectedOption.attr('data-mather-job');

            $('#father').val(fatherName);
            $('#mather').val(matherName);
            $('#father_job').val(fatherJob);
            $('#mather_job').val(matherJob);
        }
    </script>
</body>

</html>