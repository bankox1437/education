<?php
$sql = "SELECT * FROM stf_tb_form_screening_side_3 WHERE screening_id = :screening_id";
$data = $DB->Query($sql, ["screening_id" => $_GET['screening_id']]);
$Side3 = json_decode($data);
$Side3 = $Side3[0];
?>
<h5><b>3. ด้านสุขภาพจิตและพฤติกรรม (SDQ)</b></h5>
<div class="row ml-4">
    <div class="col-md-3 d-flex justify-content-start">
        <h5>1 ) ด้านอารมณ์</h5>
    </div>
    <div class="col-md-9">
        <div class="demo-radio-button ml-4">
            <input name="mind_1" type="radio" value="ปกติ" id="normal_mind_1" class="with-gap radio-col-primary" <?php echo $Side3->side_3_1 == 'ปกติ' ? 'checked' : '' ?>>
            <label for="mind_1_learning">ปกติ</label>
            <input name="mind_1" type="radio" value="เสี่ยง" id="risk_mind_1" class="with-gap radio-col-primary" <?php echo $Side3->side_3_1 == 'เสี่ยง' ? 'checked' : '' ?>>
            <label for="risk_mind_1">เสี่ยง</label>
            <input name="mind_1" type="radio" value="มีปัญหา" id="problem_mind_1" class="with-gap radio-col-primary" <?php echo $Side3->side_3_1 == 'มีปัญหา' ? 'checked' : '' ?>>
            <label for="problem_mind_1">มีปัญหา</label>
        </div>
    </div>
    <div class="col-md-3 d-flex justify-content-start">
        <h5>2 ) ด้านความพฤติกรรม /เกเร</h5>
    </div>
    <div class="col-md-9">
        <div class="demo-radio-button ml-4">
            <input name="mind_2" type="radio" value="ปกติ" id="mind_2_normal" class="with-gap radio-col-primary" <?php echo $Side3->side_3_2 == 'ปกติ' ? 'checked' : '' ?>>
            <label for="mind_2_normal">ปกติ</label>
            <input name="mind_2" type="radio" value="เสี่ยง" id="mind_2_risk" class="with-gap radio-col-primary" <?php echo $Side3->side_3_2 == 'เสี่ยง' ? 'checked' : '' ?>>
            <label for="mind_2_risk">เสี่ยง</label>
            <input name="mind_2" type="radio" value="มีปัญหา" id="mind_2_problem" class="with-gap radio-col-primary" <?php echo $Side3->side_3_2 == 'มีปัญหา' ? 'checked' : '' ?>>
            <label for="mind_2_problem">มีปัญหา</label>
        </div>
    </div>
    <div class="col-md-3 d-flex justify-content-start">
        <h5>3 ) ด้านพฤติกรรมอยู่ไม่นิ่ง/สมาธิสั้น</h5>
    </div>
    <div class="col-md-9">
        <div class="demo-radio-button ml-4">
            <input name="mind_3" type="radio" value="ปกติ" id="mind_3_normal" class="with-gap radio-col-primary" <?php echo $Side3->side_3_3 == 'ปกติ' ? 'checked' : '' ?>>
            <label for="mind_3_normal">ปกติ</label>
            <input name="mind_3" type="radio" value="เสี่ยง" id="mind_3_risk" class="with-gap radio-col-primary" <?php echo $Side3->side_3_3 == 'เสี่ยง' ? 'checked' : '' ?>>
            <label for="mind_3_risk">เสี่ยง</label>
            <input name="mind_3" type="radio" value="มีปัญหา" id="mind_3_problem" class="with-gap radio-col-primary" <?php echo $Side3->side_3_3 == 'มีปัญหา' ? 'checked' : '' ?>>
            <label for="mind_3_problem">มีปัญหา</label>
        </div>
    </div>
    <div class="col-md-3 d-flex justify-content-start">
        <h5>4 ) ด้านความสัมพันธ์กับเพื่อน</h5>
    </div>
    <div class="col-md-9">
        <div class="demo-radio-button ml-4">
            <input name="mind_4" type="radio" value="ปกติ" id="mind_4_normal" class="with-gap radio-col-primary" <?php echo $Side3->side_3_4 == 'ปกติ' ? 'checked' : '' ?>>
            <label for="mind_4_normal">ปกติ</label>
            <input name="mind_4" type="radio" value="เสี่ยง" id="mind_4_risk" class="with-gap radio-col-primary" <?php echo $Side3->side_3_4 == 'เสี่ยง' ? 'checked' : '' ?>>
            <label for="mind_4_risk">เสี่ยง</label>
            <input name="mind_4" type="radio" value="มีปัญหา" id="mind_4_problem" class="with-gap radio-col-primary" <?php echo $Side3->side_3_4 == 'มีปัญหา' ? 'checked' : '' ?>>
            <label for="mind_4_problem">มีปัญหา</label>
        </div>
    </div>
</div>
<div class="row mt-3 ml-4">
    <div class="col-12">
        <h5>สรุป ข้อมูลแบบประเมิน SDQ ( จากคะแนนรวม 4 ด้าน ) นักศึกษาอยู่ในกลุ่ม</h5>
    </div>
    <div class="col-md-8">
        <div class="demo-radio-button">
            <input name="summary_4" type="radio" value="ปกติ" id="summary_4_normal" class="with-gap radio-col-primary" <?php echo $Side3->side_3_summary == 'ปกติ' ? 'checked' : '' ?>>
            <label for="summary_4_normal">ปกติ</label>
            <input name="summary_4" type="radio" value="เสี่ยง" id="summary_4_risk" class="with-gap radio-col-primary" <?php echo $Side3->side_3_summary == 'เสี่ยง' ? 'checked' : '' ?>>
            <label for="summary_4_risk">เสี่ยง</label>
            <input name="summary_4" type="radio" value="มีปัญหา" id="summary_4_problem" class="with-gap radio-col-primary" <?php echo $Side3->side_3_summary == 'มีปัญหา' ? 'checked' : '' ?>>
            <label for="summary_4_problem">มีปัญหา</label>
        </div>
    </div>
</div>