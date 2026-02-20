<?php
$use_internet_more1 = "checked";
$use_internet_more2 = "";
$use_internet_more3 = "";
$use_internet_more4 = "";

$reason_edu1 = "checked";
$reason_edu2 = "";
$reason_edu3 = "";
$reason_edu4 = "";

$reason_learning_format1 = "";
$reason_learning_format2 = "";
$reason_learning_format3 = "";
$reason_learning_format4 = "";
$reason_learning_format5 = "";
$reason_learning_format6 = "checked";
$reason_learning_format_text = "";
$reason_learning_format_show_text = "block";


if (isset($std_per_id)) {
    $use_internet_more1 = $std_per_data->use_internet_more == 1 ? "checked" : "";
    $use_internet_more2 = $std_per_data->use_internet_more == 2 ? "checked" : "";
    $use_internet_more3 = $std_per_data->use_internet_more == 3 ? "checked" : "";
    $use_internet_more4 = $std_per_data->use_internet_more == 4 ? "checked" : "";

    $reason_edu1 = $std_per_data->reason_edu == 1 ? "checked" : "";
    $reason_edu2 = $std_per_data->reason_edu == 2 ? "checked" : "";
    $reason_edu3 = $std_per_data->reason_edu == 3 ? "checked" : "";
    $reason_edu4 = $std_per_data->reason_edu == 4 ? "checked" : "";

    $reason_learning_format1 = $std_per_data->reason_learning_format == 1 ? "checked" : "";
    $reason_learning_format2 = $std_per_data->reason_learning_format == 2 ? "checked" : "";
    $reason_learning_format3 = $std_per_data->reason_learning_format == 3 ? "checked" : "";
    $reason_learning_format4 = $std_per_data->reason_learning_format == 4 ? "checked" : "";
    $reason_learning_format5 = $std_per_data->reason_learning_format == 5 ? "checked" : "";
    $reason_learning_format6 = $std_per_data->reason_learning_format == 6 ? "checked" : "";
    $reason_learning_format_text = $std_per_data->reason_learning_format == 6 ? $std_per_data->reason_learning_format_text : "";
    $reason_learning_format_show_text = $std_per_data->reason_learning_format == 6 ? "block" : "none";
} ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label><b>1.10</b> ผู้เรียนใช้สัญญาณ Internet จากแหล่งที่มาใดมากที่สุด: </label>
            <div class="c-inputs-stacked">
                <input name="use_internet_more" <?php echo $use_internet_more1 ?> type="radio" id="myself" class="with-gap radio-col-primary required" placeholder="ระบุแหล่งที่มา Internet" value="1">
                <label for="myself" class="mr-30">ของตนเอง</label>
                <input name="use_internet_more" <?php echo $use_internet_more2 ?> type="radio" id="school" class="with-gap radio-col-primary required" placeholder="ระบุแหล่งที่มา Internet" value="2">
                <label for="school" class="mr-30">ห้องสมุด/สถานศึกษา</label>
                <input name="use_internet_more" <?php echo $use_internet_more3 ?> type="radio" id="work" class="with-gap radio-col-primary required" placeholder="ระบุแหล่งที่มา Internet" value="3">
                <label for="work" class="mr-30">ที่ทำงาน</label>
                <input name="use_internet_more" <?php echo $use_internet_more4 ?> type="radio" id="public" class="with-gap radio-col-primary required" placeholder="ระบุแหล่งที่มา Internet" value="4">
                <label for="public" class="mr-30">สาธารณะ</label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label><b>1.11</b> ท่านมาเรียน ศกร. ด้วยเหตุผลใด : </label>
            <div class="c-inputs-stacked">
                <input name="reason_edu" type="radio" <?php echo $reason_edu1 ?> id="for_further_education" class="with-gap radio-col-primary required" placeholder="ระบุเหตุผลที่มาเรียน" value="1">
                <label for="for_further_education" class="mr-30">เพื่อศึกษาต่อ</label>
                <input name="reason_edu" type="radio" <?php echo $reason_edu2 ?> id="for_money" class="with-gap radio-col-primary required" placeholder="ระบุเหตุผลที่มาเรียน" value="2">
                <label for="for_money" class="mr-30">เพื่อปรับเงินเดือน</label>
                <input name="reason_edu" type="radio" <?php echo $reason_edu3 ?> id="for_friend" class="with-gap radio-col-primary required" placeholder="ระบุเหตุผลที่มาเรียน" value="3">
                <label for="for_friend" class="mr-30">เพื่อให้มีเพื่อน/มีสังคม</label>
                <input name="reason_edu" type="radio" <?php echo $reason_edu4 ?> id="for_work" class="with-gap radio-col-primary required" placeholder="ระบุเหตุผลที่มาเรียน" value="4">
                <label for="for_work" class="mr-30">เพื่อให้มีงานทำ</label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label><b>1.12</b> ท่านคิดว่า ศกร. ควรจัดการเรียนการสอนในรูปแบบใด มากที่สุด: </label>
            <div class="c-inputs-stacked row">
                <div class="col-md-2">
                    <input name="reason_learning_format" <?php echo $reason_learning_format1 ?> type="radio" id="group" class="with-gap radio-col-primary required" placeholder="ระบุรูปแบบการจัดการเรียนการสอน" value="1">
                    <label for="group" class="mr-30">การพบกลุ่ม</label>
                </div>
                <div class="col-md-2">
                    <input name="reason_learning_format" <?php echo $reason_learning_format2 ?> type="radio" id="far_edu" class="with-gap radio-col-primary required" placeholder="ระบุรูปแบบการจัดการเรียนการสอน" value="2">
                    <label for="far_edu" class="mr-30">การศึกษาทางไกล</label>
                </div>
                <div class="col-md-2">
                    <input name="reason_learning_format" <?php echo $reason_learning_format3 ?> type="radio" id="class_edu" class="with-gap radio-col-primary required" placeholder="ระบุรูปแบบการจัดการเรียนการสอน" value="3">
                    <label for="class_edu" class="mr-30">การสอนแบบชั้นเรียน</label>
                </div>
                <div class="col-md-2">
                    <input name="reason_learning_format" <?php echo $reason_learning_format4 ?> type="radio" id="project_make" class="with-gap radio-col-primary required" placeholder="ระบุรูปแบบการจัดการเรียนการสอน" value="4">
                    <label for="project_make" class="mr-30">การทำโครงงาน</label>
                </div>
                <div class="col-md-2">
                    <input name="reason_learning_format" <?php echo $reason_learning_format5 ?> type="radio" id="learning_by_myseft" class="with-gap radio-col-primary required" placeholder="ระบุรูปแบบการจัดการเรียนการสอน" value="5">
                    <label for="learning_by_myseft" class="mr-30">การเรียนรู้ด้วยตนเอง</label>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <div class="demo-checkbox" style="max-width: 90px;">
                        <input name="reason_learning_format" <?php echo $reason_learning_format6 ?> type="radio" id="reason_learning_format_other" class="with-gap radio-col-primary required" placeholder="ระบุรูปแบบการจัดการเรียนการสอน" value="6">
                        <label for="reason_learning_format_other" style="min-width: 60px;">อื่นๆ</label>
                    </div>
                    <div class="form-group" style="display: <?php echo $reason_learning_format_show_text ?>;margin-left: 5px;" id="reason_learning_format_other_text_display">
                        <input style="width: 130px;margin-top: -5px;" type="text" class="form-control required" name="reason_learning_format_other_text" id="reason_learning_format_other_text" autocomplete="off" placeholder="ระบุอื่น ๆ" value="<?php echo $reason_learning_format_text ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>