<?php
$std_ability = "";
$have_internet = "";
$dont_have_internet = "checked";
$use_device1 = "checked";
$use_device2 = "";
$use_device3 = "";

if (isset($std_per_id)) {
    $std_ability = $std_per_data->std_ability;
    $have_internet = $std_per_data->have_internet ? "checked" : "";
    $dont_have_internet = $std_per_data->have_internet ? "" : "checked";
    $use_device1 = $std_per_data->use_device == 1 ? "checked" : "";
    $use_device2 = $std_per_data->use_device == 2 ? "checked" : "";
    $use_device3 = $std_per_data->use_device == 3 ? "checked" : "";
} ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label><b>1.6</b> ความสามารถพิเศษของผู้เรียน </label>
            <input type="text" value="<?php echo $std_ability ?>" class="form-control height-input required" name="std_ability" id="std_ability" autocomplete="off" placeholder="กรอกความสามารถพิเศษของผู้เรียน">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label><b>1.7</b> ผู้เรียนมีระบบ Internet หรือไม่ : </label>
            <div class="c-inputs-stacked">
                <input name="have_internet" <?php echo $have_internet ?> type="radio" id="have_internet" class="with-gap radio-col-primary required" placeholder="ระบุตัวเลือกระบบ Internet" value="1">
                <label for="have_internet" class="mr-30">มี</label>
                <input name="have_internet" <?php echo $dont_have_internet ?> type="radio" id="dont_have_internet" class="with-gap radio-col-primary required" placeholder="ระบุตัวเลือกระบบ Internet" value="0">
                <label for="dont_have_internet" class="mr-30">ไม่มี</label>
            </div>
        </div>
    </div>
</div>

<?php
$word = "";
$power_point = "";
$excel = "";
$photoshop = "";
if (isset($std_per_id)) {
    $sql_program =  "SELECT * FROM stf_tb_program_of_student_person \n" .
        "WHERE\n" .
        "	std_per_id = :std_per_id";
    $program_data = $DB->Query($sql_program, ['std_per_id' => $std_per_id]);
    $program_data = json_decode($program_data);

    if (count($program_data) > 0) {
        $program_data = $program_data[0];
        $word = $program_data->word ? "checked" : "";
        $power_point = $program_data->power_point ? "checked" : "";
        $excel = $program_data->excel ? "checked" : "";
        $photoshop = $program_data->photoshop ? "checked" : "";
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label><b>1.8</b> ผู้เรียนใช้โปรแกรม Microsoft office ใดได้บ้าง (เลือกได้มากกว่า 1 ข้อ) </label>
            <div class="demo-checkbox 1-8-checkbox-value">
                <input type="checkbox" name="program[word]" <?php echo $word ?> id="word" class="filled-in chk-col-primary required" placeholder="ระบุโปรแกรมที่ใช้" value="1">
                <label class="mb-0" for="word">Word</label>
                <input type="checkbox" name="program[power_point]" <?php echo $power_point ?> id="power_point" class="filled-in chk-col-primary required" placeholder="ระบุโปรแกรมที่ใช้" value="1">
                <label class="mb-0" for="power_point">Power Point</label>
                <input type="checkbox" name="program[excel]" <?php echo $excel ?> id="excel" class="filled-in chk-col-primary required" placeholder="ระบุโปรแกรมที่ใช้" value="1">
                <label class="mb-0" for="excel">Excel</label>
                <!-- <input type="checkbox" name="program[photoshop]" <?php echo $photoshop ?> id="photoshop" class="filled-in chk-col-primary required" placeholder="ระบุโปรแกรมที่ใช้" value="1">
                <label class="mb-0" for="photoshop">Photoshop</label> -->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label><b>1.9</b> ผู้เรียนมีอุปกรณ์ใดที่ใช้ในการศึกษา ค้นคว้าข้อมูลทางการศึกษาผ่านอินเทอร์เน็ต: </label>
            <div class="c-inputs-stacked">
                <input name="use_device" <?php echo $use_device2 ?> type="radio" id="smart_phone" class="with-gap radio-col-primary required" placeholder="ระบุอุปกรณ์ที่ใช้ศึกษา ค้นคว้า" value="2">
                <label for="smart_phone" class="mr-30">สมาร์ทโฟน</label>
                <input name="use_device" <?php echo $use_device3 ?> type="radio" id="conputer" class="with-gap radio-col-primary required" placeholder="ระบุอุปกรณ์ที่ใช้ศึกษา ค้นคว้า" value="3">
                <label for="conputer" class="mr-30">คอมพิวเตอร์</label>
                <input name="use_device" <?php echo $use_device1 ?> type="radio" id="not" class="with-gap radio-col-primary required" placeholder="ระบุอุปกรณ์ที่ใช้ศึกษา ค้นคว้า" value="1">
                <label for="not" class="mr-30">ไม่มี</label>
            </div>
        </div>
    </div>
</div>