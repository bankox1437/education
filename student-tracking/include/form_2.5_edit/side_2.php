<?php
$sql = "SELECT * FROM stf_tb_form_screening_side_2 WHERE screening_id = :screening_id";
$data = $DB->Query($sql, ["screening_id" => $_GET['screening_id']]);
$Side2 = json_decode($data);
$Side2 = $Side2[0];
?>
<h5><b>2. ด้านสุขภาพ</b></h5>
<div class="row ml-4">
    <div class="col-md-12">
        <div class="demo-radio-button">
            <input name="side_health" type="radio" value="ปกติ" id="normal_health" class="with-gap radio-col-primary" <?php echo $Side2->status == 'ปกติ' ? 'checked' : '' ?>>
            <label for="normal_health">ปกติ</label>
            <input name="side_health" type="radio" value="เสี่ยง" id="risk_health" class="with-gap radio-col-primary" <?php echo $Side2->status == 'เสี่ยง' ? 'checked' : '' ?>>
            <label for="risk_health">เสี่ยง</label>
            <input name="side_health" type="radio" value="มีปัญหา" id="problem_health" class="with-gap radio-col-primary" <?php echo $Side2->status == 'มีปัญหา' ? 'checked' : '' ?>>
            <label for="problem_health">มีปัญหา</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_1" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_1 == 'false' ? '' : 'checked' ?>>
                    <label for="health_1">น้ำหนักผิดปกติและไม่สัมพันธ์กับส่วนสูงหรืออายุเล็กน้อย</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_2" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_2 == 'false' ? '' : 'checked' ?>>
                    <label for="health_2">สุขภาพร่างกายไม่แข็งแรง</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_3" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_3 == 'false' ? '' : 'checked' ?>>
                    <label for="health_3">มีโรคประจำตัวที่ส่งผลกระทบต่อการเรียนหรือเจ็บป่วยบ่อย</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_4" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_4 == 'false' ? '' : 'checked' ?>>
                    <label for="health_4">มีปัญหาด้านสายตา /สั้น /เอียง</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_5" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_5 == 'false' ? '' : 'checked' ?>>
                    <label for="health_5">มีปัญหาในการได้ยินไม่ชัดเจน</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_6" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_6 == 'false' ? '' : 'checked' ?>>
                    <label for="health_6">ผลการเรียนเฉลี่ย 1.00 – 2.00</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_7" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_7 == 'false' ? '' : 'checked' ?>>
                    <label for="health_7">มาโรงเรียนสาย 3 ครั้ง/สัปดาห์</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_8" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_8 == 'false' ? '' : 'checked' ?>>
                    <label for="health_8">ติด 0 , ร , มส 1 – 2 วิชาใน 1 ภาคเรียน</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_9" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_9 == 'false' ? '' : 'checked' ?>>
                    <label for="health_9">อ่านหนังสือไม่คล่อง</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_10" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_10 == 'false' ? '' : 'checked' ?>>
                    <label for="health_10">ไม่เข้าเรียนหลายครั้งโดยไม่มีเหตุจำเป็น</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_11" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_11 == 'false' ? '' : 'checked' ?>>
                    <label for="health_11">ออทิสติก</label>
                </div>
            </div>
            <div class="col-md-12 d-flex align-items-center">
                <div class="demo-checkbox" style="max-width: 90px;">
                    <input type="checkbox" id="health_12" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_12 == 'false' ? '' : 'checked' ?> onchange="showInput('health_12')">
                    <label for="health_12" style="min-width: 60px;margin-right: 5px;">อื่นๆระบุ</label>
                </div>
                <div class="form-group" style="display: <?php echo $Side2->side_2_12 == 'false' ? 'none' : 'block' ?>;" id="health_12_input">
                    <input style="width: 200px;" type="text" value="<?php echo $Side2->side_2_12 == 'false' ? '' : $Side2->side_2_12  ?>" class="form-control height-input" name="health_12_other" id="health_12_other" autocomplete="off" placeholder="ระบุอื่น ๆ">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_13" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_13 == 'false' ? '' : 'checked' ?>>
                    <label for="health_13">น้ำหนักผิดปกติและไม่สัมพันธ์กับส่วนสูงหรืออายุมากชัดเจน</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_14" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_14 == 'false' ? '' : 'checked' ?>>
                    <label for="health_14">มีความพิการทางร่างกาย</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_15" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_15 == 'false' ? '' : 'checked' ?>>
                    <label for="health_15">ป่วยเป็นโรคร้ายแรง / เรื้อรัง</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_16" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_16 == 'false' ? '' : 'checked' ?>>
                    <label for="health_16">มีปัญหาในการมองเห็น(ไม่มีแว่นตาใส่)</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_17" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_17 == 'false' ? '' : 'checked' ?>>
                    <label for="health_17">มีความบกพร่องทางการได้ยินมาก</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_18" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_18 == 'false' ? '' : 'checked' ?>>
                    <label for="health_18">ผลการเรียนเฉลี่ยต่ำกว่า 1.50</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_19" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_19 == 'false' ? '' : 'checked' ?>>
                    <label for="health_19">อ่านหนังสือไม่ออก</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_20" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_20 == 'false' ? '' : 'checked' ?>>
                    <label for="health_20">ติด 0 , ร , มส , มผ 3 วิชาขึ้นไป</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_21" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_21 == 'false' ? '' : 'checked' ?>>
                    <label for="health_21">ไม่ส่งงานหลายวิชา</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_22" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_22 == 'false' ? '' : 'checked' ?>>
                    <label for="health_22">เขียนหนังสือไม่ถูกต้องสะกดคำผิดแม้แต่คำง่ายๆ</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="health_23" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_23 == 'false' ? '' : 'checked' ?>>
                    <label for="health_23">บกพร่องในการพูด</label>
                </div>
            </div>
            <div class="col-md-12 d-flex align-items-center">
                <div class="demo-checkbox" style="max-width: 90px;">
                    <input type="checkbox" id="health_24" class="health filled-in chk-col-primary" <?php echo $Side2->side_2_24 == 'false' ? '' : 'checked' ?> onchange="showInput('health_24')">
                    <label for="health_24" style="min-width: 60px;margin-right: 5px;">อื่นๆระบุ</label>
                </div>
                <div class="form-group" style="display: <?php echo $Side2->side_2_24 == 'false' ? 'none' : 'block' ?>;" id="health_24_input">
                    <input style="width: 200px;" type="text" value="<?php echo $Side2->side_2_24 == 'false' ? '' : $Side2->side_2_24 ?>" class="form-control height-input" name="health_24_other" id="health_24_other" autocomplete="off" placeholder="ระบุอื่น ๆ">
                </div>
            </div>
        </div>
    </div>
</div>