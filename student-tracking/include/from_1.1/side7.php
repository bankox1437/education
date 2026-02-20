<?php
$reason_process1 = "checked";
$reason_process2 = "";
$reason_process3 = "";
$reason_process4 = "";
$reason_process5 = "";

$expectations = "";

if (isset($std_per_id)) {
    $reason_process1 = $std_per_data->reason_process == 1 ? "checked" : "";
    $reason_process2 = $std_per_data->reason_process == 2 ? "checked" : "";
    $reason_process3 = $std_per_data->reason_process == 3 ? "checked" : "";
    $reason_process4 = $std_per_data->reason_process == 4 ? "checked" : "";
    $reason_process5 = $std_per_data->reason_process == 5 ? "checked" : "";
    $expectations = $std_per_data->expectations;
} ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label><b>1.13</b> ท่านคิดว่า ควรจัดการประเมินผลระหว่างภาคเรียนและปลายภาคเรียนอย่างไร </label>
            <div class="c-inputs-stacked">
                <input name="reason_process" <?php echo $reason_process1 ?> type="radio" id="final_only" class="with-gap radio-col-primary required" placeholder="ระบุรูปแบบการประเมินผล" value="1">
                <label style="height: 35px;" for="final_only" class="mr-30">ตัดสินปลายภาคเรียนครั้งเดียว 100 คะแนน</label><br>
                <input name="reason_process" <?php echo $reason_process2 ?> type="radio" id="mid_1" class="with-gap radio-col-primary required" placeholder="ระบุรูปแบบการประเมินผล" value="2">
                <label style="height: 40px;" for="mid_1" class="mr-30">ระหว่างภาคเรียน 40 คะแนน และปลายภาค 60 คะแนน รวม 100 คะแนน</label><br>
                <input name="reason_process" <?php echo $reason_process3 ?> type="radio" id="mid_2" class="with-gap radio-col-primary required" placeholder="ระบุรูปแบบการประเมินผล" value="3">
                <label style="height: 40px;" for="mid_2" class="mr-30">ระหว่างภาคเรียน 50 คะแนน และปลายภาค 50 คะแนน รวม 100 คะแนน</label><br>
                <input name="reason_process" <?php echo $reason_process5 ?> type="radio" id="mid_4" class="with-gap radio-col-primary required" placeholder="ระบุรูปแบบการประเมินผล" value="5">
                <label style="height: 40px;" for="mid_4" class="mr-30">ระหว่างภาคเรียน 60 คะแนน และปลายภาค 40 คะแนน รวม 100 คะแนน</label><br>
                <input name="reason_process" <?php echo $reason_process4 ?> type="radio" id="mid_3" class="with-gap radio-col-primary required" placeholder="ระบุรูปแบบการประเมินผล" value="4">
                <label style="height: 40px;" for="mid_3" class="mr-30">ระหว่างภาคเรียน 70 คะแนน และปลายภาค 30 คะแนน รวม 100 คะแนน</label><br>
            </div>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-12">
        <div class="form-group">
            <label><b>1.14</b> ท่านมีความคาดหวังอะไรในการมาเรียน ศกร. </label>
            <textarea rows="3" id="expectations" name="expectations" class="form-control" placeholder="กรอกความคาดหวัง"><?php echo $expectations ?></textarea>
        </div>
    </div>
</div>