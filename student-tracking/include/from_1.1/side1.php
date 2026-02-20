<?php
$name = "";
$nickname = "";
$std_birthday = "";
$age = "";
$father_name = "";
$father_job = "";
$father_phone = "";

$mather_name = "";
$mather_job = "";
$mather_phone = "";

$phone = "";

if (isset($std_per_id)) {
    $name = $std_per_data->name;
    $nickname = $std_per_data->nickname;
    $std_birthday = $std_per_data->std_birthday;
    $age = $std_per_data->age;

    // include "../config/main_function.php";
    $main_func = new ClassMainFunctions();

    $father_name = $std_per_data->std_father_name;
    $father_job = $std_per_data->std_father_job;
    $father_phone = $main_func->decryptData($std_per_data->std_father_phone);

    $mather_name = $std_per_data->std_mather_name;
    $mather_job = $std_per_data->std_mather_job;
    $mather_phone = $main_func->decryptData($std_per_data->std_mather_phone);

    $phone = $std_per_data->phone;
} ?>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label><b>1.1</b> ชื่อ-สกุล</label>
            <input type="text" value="<?php echo $name ?>" class="form-control height-input" disabled name="std_name" id="std_name" autocomplete="off" placeholder="กรอกชื่อ-สกุล">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>ชื่อเล่น </label>
            <input type="text" value="<?php echo $nickname ?>" class="form-control height-input required" name="nickname" id="nickname" autocomplete="off" placeholder="กรอกชื่อเล่น">
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label>อายุ</label>
            <input type="text" value="<?php echo $age ?>" class="form-control height-input" disabled name="age_show" id="age_show" autocomplete="off" placeholder="กรอกอายุ">
            <input type="hidden" id="age" name="age" value="<?php echo $age ?>">

        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>วัน/เดือน/ปีเกิด</label>
            <input type="text" value="<?php echo $std_birthday ?>" class="form-control height-input" disabled name="std_birthday" id="std_birthday" autocomplete="off" placeholder="กรอก วัน/เดือน/ปีเกิด">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>หมายเลขโทรศัพท์</label>
            <input type="text" value="<?php echo $phone ?>" pattern="\d*" maxlength="10" class="form-control height-input required" name="phone" id="phone" autocomplete="off" placeholder="กรอกหมายเลขโทรศัพท์">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>ชื่อ-สกุล (บิดา)</label>
            <input type="text" value="<?php echo $father_name ?>" class="form-control height-input" name="father_name" id="father_name" autocomplete="off" placeholder="กรอกชื่อ-สกุล (บิดา)">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>อาชีพ </label>
            <input type="text" value="<?php echo $father_job ?>" class="form-control height-input required" name="father_job" id="father_job" autocomplete="off" placeholder="กรอกอาชีพ">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>หมายเลขโทรศัพท์ </label>
            <input type="text" value="<?php echo $father_phone ?>" pattern="\d*" maxlength="10" class="form-control height-input required" name="father_phone" id="father_phone" autocomplete="off" placeholder="กรอกหมายเลขโทรศัพท์">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>ชื่อ-สกุล (มารดา)</label>
            <input type="text" value="<?php echo $mather_name ?>" class="form-control height-input" name="mather_name" id="mather_name" autocomplete="off" placeholder="กรอกชื่อ-สกุล (มารดา)">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>อาชีพ </label>
            <input type="text" value="<?php echo $mather_job ?>" class="form-control height-input required" name="mather_job" id="mather_job" autocomplete="off" placeholder="กรอกอาชีพ">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>หมายเลขโทรศัพท์ </label>
            <input type="text" value="<?php echo $mather_phone ?>" pattern="\d*" maxlength="10" class="form-control height-input required" name="mather_phone" id="mather_phone" autocomplete="off" placeholder="กรอกหมายเลขโทรศัพท์">
        </div>
    </div>
</div>