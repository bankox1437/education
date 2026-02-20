<?php
$like_subject1 = "";
$like_subject2 = "";
$dont_like_subject1 = "";
$dont_like_subject2 = "";

if (isset($std_per_id)) {
    $like_subject1 = $std_per_data->like_subject1;
    $like_subject2 = $std_per_data->like_subject2;
    $dont_like_subject1 = $std_per_data->dont_like_subject1;
    $dont_like_subject2 = $std_per_data->dont_like_subject2;
} ?>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label><b>1.4</b> วิชาที่ชอบ 1 </label>
            <input type="text" value="<?php echo $like_subject1 ?>" class="form-control height-input required" name="like_subject1" id="like_subject1" autocomplete="off" placeholder="กรอกวิชาที่ชอบ 1">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>วิชาที่ชอบ 2</label>
            <input type="text" value="<?php echo $like_subject2 ?>" class="form-control height-input" name="like_subject2" id="like_subject2" autocomplete="off" placeholder="กรอกวิชาที่ชอบ 2">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label><b>1.5</b> วิชาที่ไม่ชอบ 1 </label>
            <input type="text" value="<?php echo $dont_like_subject1 ?>" class="form-control height-input required" name="dont_like_subject1" id="dont_like_subject1" autocomplete="off" placeholder="กรอกวิชาที่ไม่ชอบ 1">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>วิชาที่ไม่ชอบ 2</label>
            <input type="text" value="<?php echo $dont_like_subject2 ?>" class="form-control height-input" name="dont_like_subject2" id="dont_like_subject2" autocomplete="off" placeholder="กรอกวิชาที่ไม่ชอบ 2">
        </div>
    </div>
</div>