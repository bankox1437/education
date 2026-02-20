<?php
$sql = "SELECT * FROM stf_tb_form_screening_side_5 WHERE screening_id = :screening_id";
$data = $DB->Query($sql, ["screening_id" => $_GET['screening_id']]);
$Side5 = json_decode($data);
$Side5 = $Side5[0];
?>

<h5><b>5. ด้านอื่นๆ (ดูรายละเอียดตามเกณฑ์การคัดกรองของโรงเรียน)</b></h5>
<div class="row ml-4">
    <div class="col-md-3">
        <h5>5.1 ด้านเสพติด</h5>
    </div>
    <div class="col-md-9">
        <div class="demo-radio-button ml-4">
            <input name="addictive" type="radio" value="ปกติ" id="normal_addictive" class="with-gap radio-col-primary" <?php echo $Side5->side_5_1 == 'ปกติ' ? 'checked' : '' ?>>
            <label for="normal_addictive">ปกติ</label>
            <input name="addictive" type="radio" value="เสี่ยง" id="risk_addictive" class="with-gap radio-col-primary" <?php echo $Side5->side_5_1 == 'เสี่ยง' ? 'checked' : '' ?>>
            <label for="risk_addictive">เสี่ยง</label>
            <input name="addictive" type="radio" value="มีปัญหา" id="problem_addictive" class="with-gap radio-col-primary" <?php echo $Side5->side_5_1 == 'มีปัญหา' ? 'checked' : '' ?>>
            <label for="problem_addictive">มีปัญหา</label>
        </div>
    </div>
    <div class="col-md-3">
        <h5>5.2 ด้านพฤติกรรมทางเพศ</h5>
    </div>
    <div class="col-md-9">
        <div class="demo-radio-button ml-4">
            <input name="sexual" type="radio" value="ปกติ" id="normal_sexual" class="with-gap radio-col-primary" <?php echo $Side5->side_5_2 == 'ปกติ' ? 'checked' : '' ?>>
            <label for="normal_sexual">ปกติ</label>
            <input name="sexual" type="radio" value="เสี่ยง" id="risk_sexual" class="with-gap radio-col-primary" <?php echo $Side5->side_5_2 == 'เสี่ยง' ? 'checked' : '' ?>>
            <label for="risk_sexual">เสี่ยง</label>
            <input name="sexual" type="radio" value="มีปัญหา" id="problem_sexual" class="with-gap radio-col-primary" <?php echo $Side5->side_5_2 == 'มีปัญหา' ? 'checked' : '' ?>>
            <label for="problem_sexual">มีปัญหา</label>
        </div>
    </div>
    <div class="col-md-3">
        <h5>5.3 ด้านความปลอดภัย </h5>
    </div>
    <div class="col-md-9">
        <div class="demo-radio-button ml-4">
            <input name="security" type="radio" value="ปกติ" id="normal_security" class="with-gap radio-col-primary" <?php echo $Side5->side_5_3 == 'ปกติ' ? 'checked' : '' ?>>
            <label for="normal_security">ปกติ</label>
            <input name="security" type="radio" value="เสี่ยง" id="risk_security" class="with-gap radio-col-primary" <?php echo $Side5->side_5_3 == 'เสี่ยง' ? 'checked' : '' ?>>
            <label for="risk_security">เสี่ยง</label>
            <input name="security" type="radio" value="มีปัญหา" id="problem_security" class="with-gap radio-col-primary" <?php echo $Side5->side_5_3 == 'มีปัญหา' ? 'checked' : '' ?>>
            <label for="problem_security">มีปัญหา</label>
        </div>
    </div>
</div>