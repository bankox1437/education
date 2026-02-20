<?php
$weight = "";
$height = "";
$blood_group = "";
$disease = "";
$drug_allergy = "";

if (isset($std_per_id)) {
    $weight = $std_per_data->weight;
    $height = $std_per_data->height;
    $blood_group = $std_per_data->blood_group;
    $disease = $std_per_data->disease;
    $drug_allergy = $std_per_data->drug_allergy;
   
} ?>
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label><b>1.3</b> ข้อมูลด้านสุขภาพ น้ำหนัก </label>
            <input type="number" value="<?php echo $weight ?>" class="form-control height-input required" name="weight" id="weight" autocomplete="off" placeholder="กรอกน้ำหนัก  (กก.)">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>ส่วนสูง </label>
            <input type="number" value="<?php echo $height ?>" class="form-control height-input required" name="height" id="height" autocomplete="off" placeholder="กรอกส่วนสูง (ซม.)">
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label>หมู่โลหิต (ถ้ามี)</label>
            <input type="text" value="<?php echo $blood_group ?>" class="form-control height-input" name="blood_group" id="blood_group" autocomplete="off" placeholder="กรอกหมู่โลหิต">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>โรคประจำตัว (ถ้ามี)</label>
            <input type="text" value="<?php echo $disease ?>" class="form-control height-input" name="disease" id="disease" autocomplete="off" placeholder="กรอกโรคประจำตัว">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>ประวัติการแพ้ยา/อาหาร (ถ้ามี)</label>
            <input type="text" value="<?php echo $drug_allergy ?>" class="form-control height-input" name="drug_allergy" id="drug_allergy" autocomplete="off" placeholder="กรอกประวัติการแพ้ยา/อาหาร">
        </div>
    </div>
</div>