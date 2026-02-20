<?php
$edu_qualification1 = '';
$edu_qualification_text = "none";
$edu_qualification_school = '';

$edu_qualification2 = '';
$edu_qualification3 = '';
$edu_qualification4 = '';
$edu_qualification5 = '';
$edu_qualification6 = '';

$visit_edu1 = '';
$visit_edu2 = '';
$visit_edu3 = '';

$cooperate_edu1 = '';
$cooperate_edu2 = '';
$cooperate_edu3 = '';

$satisfaction1 = '';
$satisfaction2 = '';
$satisfaction3 = '';
$satisfaction4 = '';
$satisfaction5 = '';

if (isset($_REQUEST['after_id'])) {
    $edu_qualification1 = ($after_data->edu_qualification == 1) ? 'checked' : '';
    $edu_qualification_text = ($after_data->edu_qualification == 1 && $after_data->edu_qualification_school) ? 'block' : 'none';
    $edu_qualification_school = ($after_data->edu_qualification == 1 && $after_data->edu_qualification_school) ? $after_data->edu_qualification_school : '';

    $edu_qualification2 = ($after_data->edu_qualification == 2) ? 'checked' : '';
    $edu_qualification3 = ($after_data->edu_qualification == 3) ? 'checked' : '';
    $edu_qualification4 = ($after_data->edu_qualification == 4) ? 'checked' : '';
    $edu_qualification5 = ($after_data->edu_qualification == 5) ? 'checked' : '';
    $edu_qualification6 = ($after_data->edu_qualification == 6) ? 'checked' : '';

    $visit_edu1 = ($after_data->visit_edu == 1) ? 'checked' : '';
    $visit_edu2 = ($after_data->visit_edu == 2) ? 'checked' : '';
    $visit_edu3 = ($after_data->visit_edu == 3) ? 'checked' : '';

    $cooperate_edu1 = ($after_data->cooperate_edu == 1) ? 'checked' : '';
    $cooperate_edu2 = ($after_data->cooperate_edu == 2) ? 'checked' : '';
    $cooperate_edu3 = ($after_data->cooperate_edu == 3) ? 'checked' : '';

    $satisfaction1 = ($after_data->satisfaction == 1) ? 'checked' : '';
    $satisfaction2 = ($after_data->satisfaction == 2) ? 'checked' : '';
    $satisfaction3 = ($after_data->satisfaction == 3) ? 'checked' : '';
    $satisfaction4 = ($after_data->satisfaction == 4) ? 'checked' : '';
    $satisfaction5 = ($after_data->satisfaction == 5) ? 'checked' : '';
} ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label><b>วุฒิการศึกษาที่ได้รับ นำไปใช้ในด้านใด </b><b class="text-danger">*</b></label>
            <div class="c-inputs-stacked">
                <div class="d-flex align-items-center">
                    <div class="demo-checkbox" style="max-width: 185px;">
                        <input name="edu_qualification" <?php echo $edu_qualification1 ?> type="radio" id="edu_qualification1" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าวุฒิการศึกษาที่ได้รับ นำไปใช้ในด้านใด" value="1">
                        <label for="edu_qualification1" class="mr-30 mb-2">ศึกษาต่อในระดับที่สูงขึ้น</label><br>
                    </div>
                    <div class="form-group" style="display: <?php echo $edu_qualification_text ?>;margin-left: 5px;margin-bottom: 0;" id="edu_qualification_school">
                        <input style="width: 165px;margin-top: -5px;" type="text" class="form-control required" name="edu_qualification_school_text" id="edu_qualification_school_text" autocomplete="off" placeholder="ระบุสถานศึกษา" value="<?php echo $edu_qualification_school ?>">
                    </div>
                </div>
                <input name="edu_qualification" <?php echo $edu_qualification2 ?> type="radio" id="edu_qualification2" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าวุฒิการศึกษาที่ได้รับ นำไปใช้ในด้านใด" value="2">
                <label for="edu_qualification2" class="mr-30">นำไปสมัครงานเอกชน</label><br>
                <input name="edu_qualification" <?php echo $edu_qualification3 ?> type="radio" id="edu_qualification3" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าวุฒิการศึกษาที่ได้รับ นำไปใช้ในด้านใด" value="3">
                <label for="edu_qualification3" class="mr-30">นำไปใช้ปรับเงินเดือน</label><br>
                <input name="edu_qualification" <?php echo $edu_qualification4 ?> type="radio" id="edu_qualification4" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าวุฒิการศึกษาที่ได้รับ นำไปใช้ในด้านใด" value="4">
                <label for="edu_qualification4" class="mr-30">สอบเข้ารับราชการ</label><br>
                <input name="edu_qualification" <?php echo $edu_qualification5 ?> type="radio" id="edu_qualification5" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าวุฒิการศึกษาที่ได้รับ นำไปใช้ในด้านใด" value="5">
                <label for="edu_qualification5" class="mr-30">สมัครเป็นนักการเมืองท้องถิ่น</label><br>
                <input name="edu_qualification" <?php echo $edu_qualification6 ?> type="radio" id="edu_qualification6" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าวุฒิการศึกษาที่ได้รับ นำไปใช้ในด้านใด" value="6">
                <label for="edu_qualification6" class="mr-30">สมัครเป็นอาสาสมัคร</label><br>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label><b>หลังจบการศึกษาท่านจะกลับไปเยี่ยมสถานศึกษาเดิมหรือไม่ </b><b class="text-danger">*</b></label>
            <div class="c-inputs-stacked">
                <input name="visit_edu" <?php echo $visit_edu1 ?> type="radio" id="visit_edu1" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าหลังจบการศึกษาท่านจะกลับไปเยี่ยมสถานศึกษาเดิมหรือไม่" value="1">
                <label for="visit_edu1" class="mr-30">กลับไปแน่นอน</label><br>
                <input name="visit_edu" <?php echo $visit_edu2 ?> type="radio" id="visit_edu2" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าหลังจบการศึกษาท่านจะกลับไปเยี่ยมสถานศึกษาเดิมหรือไม่" value="2">
                <label for="visit_edu2" class="mr-30">ขอคิดดูก่อน</label><br>
                <input name="visit_edu" <?php echo $visit_edu3 ?> type="radio" id="visit_edu3" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าหลังจบการศึกษาท่านจะกลับไปเยี่ยมสถานศึกษาเดิมหรือไม่" value="3">
                <label for="visit_edu3" class="mr-30">ไม่กลับไป</label><br>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label><b>หลังจบการศึกษาท่านยินดีให้ความร่วมมือในการพัฒนาสถานศึกษาเดิมหรือไม่ </b><b class="text-danger">*</b></label>
            <div class="c-inputs-stacked">
                <input name="cooperate_edu" <?php echo $cooperate_edu1 ?> type="radio" id="cooperate_edu1" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าหลังจบการศึกษาท่านยินดีให้ความร่วมมือในการพัฒนาสถานศึกษาเดิมหรือไม่" value="1">
                <label for="cooperate_edu1" class="mr-30">ยินดีให้ความร่วมมือ</label><br>
                <input name="cooperate_edu" <?php echo $cooperate_edu2 ?> type="radio" id="cooperate_edu2" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าหลังจบการศึกษาท่านยินดีให้ความร่วมมือในการพัฒนาสถานศึกษาเดิมหรือไม่" value="2">
                <label for="cooperate_edu2" class="mr-30">ให้ความร่วมมือตามโอกาส</label><br>
                <input name="cooperate_edu" <?php echo $cooperate_edu3 ?> type="radio" id="cooperate_edu3" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าหลังจบการศึกษาท่านยินดีให้ความร่วมมือในการพัฒนาสถานศึกษาเดิมหรือไม่" value="3">
                <label for="cooperate_edu3" class="mr-30">ขอคิดดูก่อน</label><br>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label><b>ความพึงพอใจต่อสถานศึกษาที่จบมาอยู่ในระดับใด </b><b class="text-danger">*</b></label>
            <div class="c-inputs-stacked">
                <input name="satisfaction" <?php echo $satisfaction1 ?> type="radio" id="satisfaction1" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าความพึงพอใจต่อสถานศึกษาที่จบมาอยู่ในระดับใด" value="1">
                <label for="satisfaction1" class="mr-30">ดีมาก</label><br>
                <input name="satisfaction" <?php echo $satisfaction2 ?> type="radio" id="satisfaction2" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าความพึงพอใจต่อสถานศึกษาที่จบมาอยู่ในระดับใด" value="2">
                <label for="satisfaction2" class="mr-30">ดี</label><br>
                <input name="satisfaction" <?php echo $satisfaction3 ?> type="radio" id="satisfaction3" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าความพึงพอใจต่อสถานศึกษาที่จบมาอยู่ในระดับใด" value="3">
                <label for="satisfaction3" class="mr-30">ปานกลาง</label><br>
                <input name="satisfaction" <?php echo $satisfaction4 ?> type="radio" id="satisfaction4" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าความพึงพอใจต่อสถานศึกษาที่จบมาอยู่ในระดับใด" value="4">
                <label for="satisfaction4" class="mr-30">พอใช้</label><br>
                <input name="satisfaction" <?php echo $satisfaction5 ?> type="radio" id="satisfaction5" class="with-gap radio-col-primary required" placeholder="โปรดระบุว่าความพึงพอใจต่อสถานศึกษาที่จบมาอยู่ในระดับใด" value="5">
                <label for="satisfaction5" class="mr-30">ควรปรับปรุง</label><br>
            </div>
        </div>
    </div>
</div>