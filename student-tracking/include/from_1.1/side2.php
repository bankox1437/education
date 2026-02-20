<?php
$address_who = "";
$number_home = "";
$moo = "";
$sub_district = "";
$district = "";
$province = "";
if (isset($std_per_id)) {
    $address_who = $std_per_data->address_who;
    $number_home = $std_per_data->number_home;
    $moo = $std_per_data->moo;
    $sub_district = $std_per_data->sub_district;
    $district = $std_per_data->district;
    $province = $std_per_data->province;
} ?>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label><b>1.2</b> อาศัยอยู่กับ </label>
            <input type="text" value="<?php echo $address_who ?>" class="form-control height-input required" name="address_who" id="address_who" autocomplete="off" placeholder="กรอกที่อยู่ปัจจุบันอาศัยอยู่กับ">
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label>บ้านเลขที่ </label>
            <input type="text" value="<?php echo $number_home ?>" class="form-control height-input required" name="number_home" id="number_home" autocomplete="off" placeholder="กรอกบ้านเลขที่">
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label>หมู่ที่ </label>
            <input type="text" value="<?php echo $moo ?>" class="form-control height-input required" name="moo" id="moo" autocomplete="off" placeholder="กรอกหมู่">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>ตำบล </label>
            <input type="text" value="<?php echo $sub_district ?>" class="form-control height-input required" name="sub_district" id="sub_district" autocomplete="off" placeholder="กรอกตำบล">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>อำเภอ </label>
            <input type="text" value="<?php echo $district ?>" class="form-control height-input required" name="district" id="district" autocomplete="off" placeholder="กรอกอำเภอ">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>จังหวัด </label>
            <input type="text" value="<?php echo $province ?>" class="form-control height-input required" name="province" id="province" autocomplete="off" placeholder="กรอกจังหวัด">
        </div>
    </div>
</div>