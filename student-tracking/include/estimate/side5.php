<tr>
    <td><b>5 การประหยัด</b></td>
    <td>
        <!-- <div class="form-group text-center">
            <div class="c-inputs-stacked">
                <input name="1" type="radio" id="1_1" class="with-gap radio-col-info input-vid" value="">
                <label for="1_1"></label>
            </div>
        </div> -->
    </td>
    <td>
        <!-- <div class="form-group text-center">
            <div class="c-inputs-stacked">
                <input name="1" type="radio" id="1_2" class="with-gap radio-col-info input-vid" value="">
                <label for="1_2"></label>
            </div>
        </div> -->
    </td>
    <td>
        <!-- <div class="form-group">
            <select class="form-control select2" name="std_select" id="std_select" data-placeholder="เลือกนักศึกษา" style="width: 100%;">
                <option>เลือกหลักฐานการประเมิน</option>
            </select>
        </div> -->
    </td>
</tr>

<?php
$side = 5;
if ($mode == 'edit' || $mode == 'print') {

    $sql = "SELECT\n" .
        "	* \n" .
        "FROM\n" .
        "	stf_tb_estimate_detail\n" .
        "WHERE estimate_id = :estimate_id AND side = :side";

    $data = $DB->Query($sql, ['estimate_id' => $_GET['estimate_id'], "side" => $side]);
    $estimate_side = json_decode($data);
    if (count($estimate_side) == 0) {
        include('goto_not_found.php');
    }
}

$arrSide = [
    "มีการออม",
    "ทำบัญชีราย รับ-รายจ่าย ของตนเอง",
    "ใช้จ่ายเงินอย่างมีเหตุมีผลไม่ฟุ่มเฟือย",
    "ใช้ทรัพย์สิน สิ่งของสถานศึกษาและสาธารณะอย่างประหยัด",
    "ใช้ทรัพยากรอย่างคุ้มค่าเหมาะสมกับงาน"
];
if ($mode == 'add') {
    $sum = 100;
    for ($i = 0; $i < count($arrSide); $i++) { ?>
        <tr class="side_<?php echo $side ?>">
            <td><?php echo $side ?>.<?php echo ($i + 1) ?> <?php echo $arrSide[$i] ?></td>
            <td onclick="checkedbehavior(<?php echo $side ?>,<?php echo $side . ($i + 1) ?>,'<?php echo $side . '_' . ($i + 1) ?>_1')">
                <div class="form-group text-center">
                    <div class="c-inputs-stacked">
                        <input name="<?php echo $side . ($i + 1) ?>" type="radio" id="<?php echo $side . '_' . ($i + 1) ?>_1" class="with-gap radio-col-info input-vid" value="20" checked="true">
                        <label for="<?php echo $side . '_' . ($i + 1) ?>_1"></label>
                    </div>
                </div>
            </td>
            <td onclick="checkedbehavior(<?php echo $side ?>,<?php echo $side . ($i + 1) ?>,'<?php echo $side . '_' . ($i + 1) ?>_2')">
                <div class="form-group text-center">
                    <div class="c-inputs-stacked">
                        <input name="<?php echo $side . ($i + 1) ?>" type="radio" id="<?php echo $side . '_' . ($i + 1) ?>_2" class="with-gap radio-col-info input-vid" value="0">
                        <label for="<?php echo $side . '_' . ($i + 1) ?>_2"></label>
                    </div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <select class="form-control select2" name="premise_select_<?php echo $side . ($i + 1) ?>" id="premise_select_<?php echo $side . ($i + 1) ?>" data-placeholder="เลือกนักศึกษา" style="width: 100%;">
                        <option value="0">เลือกหลักฐานการประเมิน</option>
                        <option value="1">การสังเกต</option>
                        <option value="2">การสอบถาม</option>
                        <option value="3">การสัมภาษณ์</option>
                        <option value="4">แบบทดสอบ</option>
                        <option value="5">ใบงาน</option>
                    </select>
                </div>
            </td>
        </tr>
    <?php }
} else {
    $sum = 0;
    for ($i = 0; $i < count($estimate_side); $i++) {
        $sum += $estimate_side[$i]->checked; ?>
        <tr class="side_<?php echo $side ?>">
            <input type="hidden" value="<?php echo $estimate_side[$i]->estimate_det_id ?>">
            <td><?php echo $side ?>.<?php echo ($i + 1) ?> <?php echo $arrSide[$i] ?></td>
            <td onclick="checkedbehavior(<?php echo $side ?>,<?php echo $side . ($i + 1) ?>,'<?php echo $side . '_' . ($i + 1) ?>_1')">
                <div class="form-group text-center">
                    <div class="c-inputs-stacked">
                        <input name="<?php echo $side . ($i + 1) ?>" type="radio" id="<?php echo $side . '_' . ($i + 1) ?>_1" class="with-gap radio-col-info input-vid" value="20" <?php echo $estimate_side[$i]->checked == '20' ? 'checked' : '' ?>>
                        <label for="<?php echo $side . '_' . ($i + 1) ?>_1"></label>
                    </div>
                </div>
            </td>
            <td onclick="checkedbehavior(<?php echo $side ?>,<?php echo $side . ($i + 1) ?>,'<?php echo $side . '_' . ($i + 1) ?>_2')">
                <div class="form-group text-center">
                    <div class="c-inputs-stacked">
                        <input name="<?php echo $side . ($i + 1) ?>" type="radio" id="<?php echo $side . '_' . ($i + 1) ?>_2" class="with-gap radio-col-info input-vid" value="0" <?php echo $estimate_side[$i]->checked == '0' ? 'checked' : '' ?>>
                        <label for="<?php echo $side . '_' . ($i + 1) ?>_2"></label>
                    </div>
                </div>
            </td>
            <td <?php echo $mode == 'print' ? 'class="text-center"' : '' ?>>
                <?php if ($mode == 'edit') { ?>
                    <div class="form-group">
                        <select class="form-control select2" name="premise_select_<?php echo $side . ($i + 1) ?>" id="premise_select_<?php echo $side . ($i + 1) ?>" data-placeholder="เลือกนักศึกษา" style="width: 100%;">
                            <option <?php echo $estimate_side[$i]->premise_select == '0' ? 'selected' : '' ?> value="0">เลือกหลักฐานการประเมิน</option>
                            <option <?php echo $estimate_side[$i]->premise_select == '1' ? 'selected' : '' ?> value="1">การสังเกต</option>
                            <option <?php echo $estimate_side[$i]->premise_select == '2' ? 'selected' : '' ?> value="2">การสอบถาม</option>
                            <option <?php echo $estimate_side[$i]->premise_select == '3' ? 'selected' : '' ?> value="3">การสัมภาษณ์</option>
                            <option <?php echo $estimate_side[$i]->premise_select == '4' ? 'selected' : '' ?> value="4">แบบทดสอบ</option>
                            <option <?php echo $estimate_side[$i]->premise_select == '5' ? 'selected' : '' ?> value="5">ใบงาน</option>
                        </select>
                    </div>
                <?php  } else {
                    if ($estimate_side[$i]->premise_select == '1') {
                        echo "การสังเกต";
                    } else if ($estimate_side[$i]->premise_select == '2') {
                        echo "การสอบถาม";
                    } else if ($estimate_side[$i]->premise_select == '3') {
                        echo "การสัมภาษณ์";
                    } else if ($estimate_side[$i]->premise_select == '4') {
                        echo "แบบทดสอบ";
                    } else if ($estimate_side[$i]->premise_select == '5') {
                        echo "ใบงาน";
                    }
                } ?>
            </td>
        </tr>
<?php }
} ?>

<tr>
    <td class="text-center"><b>สรุป</b></td>
    <td colspan="3" class="text-center"><b id="sum_side_<?php echo $side ?>"><?php echo $sum ?></b></td>
</tr>

<?php
if ($mode == 'edit' || $mode == 'print') { ?>
    <script>
        <?php for ($i = 0; $i < count($estimate_side); $i++) { ?>
            sideList['side<?php echo $side ?>']['<?php echo $side . ($i + 1) ?>'] = '<?php echo $estimate_side[$i]->checked ?>'
        <?php } ?>
    </script>
<?php }
?>