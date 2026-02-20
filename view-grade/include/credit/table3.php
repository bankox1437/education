<div class="col-md-12 mb-4 p-0">
    <h6 class="text-center text-dark m-0"><b>วิชาเลือกเสรี</b>
        <?php if (!isset($_GET['mode'])) { ?>
            <span class="badge badge-pill badge-success" style="cursor: pointer;" onclick="addRow('body_table3')" id="badge_body_table3">เพิ่มวิชา</span>
            <input type="checkbox" id="body_table3_no_subject" class="filled-in chk-col-danger" onchange="disabledRow('body_table3')">
            <label for="body_table3_no_subject">ไม่มีวิชา</label>
        <?php } ?>
    </h6>

    <?php
    if (isset($_GET['credit_id']) || isset($_GET['mode'])) {
        $sql = "SELECT * FROM vg_credit_free_electives WHERE credit_id = :credit_id";
        $data = $DB->Query($sql, ['credit_id' => $credit_id]);
        $free_electives_data = json_decode($data);
    }
    ?>
    <div class="table-responsive">
        <table class="table table-bordered mb-1" style="font-size: 12px;margin-bottom: 0;">
            <thead>
                <tr style="background-color: #e4e0ff;">
                    <th style="width: 20%;" class="text-center">
                        รหัสวิชา
                    </th>
                    <th style="width: 50%;" class="text-left">ชื่อรายวิชา</th>
                    <th style="width: 10%;" class="text-center">
                        หน่วยกิต
                    </th>
                    <th style="width: 10%;" class="text-center">
                        เกรด
                    </th>
                    <?php
                    if (!isset($_GET['mode'])) {
                        echo ' <th style="width: 10;" class="text-center">ลบ</th>';
                    }
                    ?>

                </tr>
            </thead>
            <tbody id="body_table3">
                <?php if (!isset($_GET['mode'])) {
                    if (!isset($_GET['credit_id'])) {
                ?>
                        <tr>
                            <td><input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกรหัสวิชา"></td>
                            <td><input type="text" class="form-control input-custom-table text-left" autocomplete="off" placeholder="กรอกชื่อรายวิชา"></td>
                            <td><input type="number" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกหน่วยกิต"></td>
                            <td><input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกเกรด"></td>
                            <td class="text-center"><span class="badge badge-pill badge-danger" style="cursor: pointer;" onclick="removeRow(this)">ลบ</span></td>
                        </tr>
                        <?php
                    } else {
                        $index = 0;
                        if (count($free_electives_data) == 0) { ?>
                            <tr>
                                <td><input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกรหัสวิชา"></td>
                                <td><input type="text" class="form-control input-custom-table text-left" autocomplete="off" placeholder="กรอกชื่อรายวิชา"></td>
                                <td><input type="number" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกหน่วยกิต"></td>
                                <td><input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกเกรด"></td>
                                <td class="text-center"><span class="badge badge-pill badge-danger" style="cursor: pointer;" onclick="removeRow(this)">ลบ</span></td>
                            </tr>
                            <?php } else {
                            foreach ($free_electives_data as $key => $value) {  ?>
                                <tr>
                                    <td><input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกรหัสวิชา" value="<?php echo $value->sub_id ?>"></td>
                                    <td><input type="text" class="form-control input-custom-table text-left" autocomplete="off" placeholder="กรอกชื่อรายวิชา" value="<?php echo $value->sub_name ?>"></td>
                                    <td><input type="number" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกหน่วยกิต" value="<?php echo $value->credit ?>"></td>
                                    <td><input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกเกรด" value="<?php echo is_numeric($value->grade) ? number_format($value->grade, 2, '.', '') : $value->grade; ?>"></td>
                                    <td style="display: none;"><input type="hidden" value="<?php echo $value->free_electives_id ?>"></td>
                                    <?php echo '<td class="text-center"><span class="badge badge-pill badge-danger" style="cursor: pointer;" onclick="removeRowUpdate(3,' . $value->free_electives_id . ',this)">ลบ</span></td>' ?>
                                </tr>
                        <?php
                                $index++;
                            }
                        }
                    }
                } else {
                    if (count($free_electives_data) == 0) { ?>
                        <tr>
                            <td colspan="4" class="text-center">ไม่มีวิชา</td>
                        </tr>
                        <?php } else {
                        $sumCreditGrade = 0;
                        $sumCreditOnly = 0;
                        foreach ($free_electives_data as $key => $value) {
                            $grade = $value->grade == '' || !is_numeric($value->grade) ? 0 : $value->grade;
                            $sumCreditGrade += ($value->credit *  $grade);
                            $sumCreditOnly += $value->credit;
                        ?>
                            <tr>
                                <td><input <?php echo $view_mode ?> type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกรหัสวิชา" value="<?php echo $value->sub_id ?>"></td>
                                <td><input <?php echo $view_mode ?> type="text" class="form-control input-custom-table text-left" autocomplete="off" placeholder="กรอกชื่อรายวิชา" value="<?php echo $value->sub_name ?>"></td>
                                <td><input <?php echo $view_mode ?> type="number" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกหน่วยกิต" value="<?php echo $value->credit ?>"></td>
                                <td><input <?php echo $view_mode ?> type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกเกรด" value="<?php echo is_numeric($value->grade) ? number_format($value->grade, 2, '.', '') : $value->grade; ?>"></td>
                                <td style="display: none;"><input type="hidden" value="<?php echo $value->free_electives_id ?>"></td>
                            </tr>
                    <?php }
                    }
                }

                if (isset($arrSumgrade)) {
                    $arrSumgrade['sum_credit3'] = $sumCreditGrade;
                    $arrSumgrade['sum_creditonly3'] = $sumCreditOnly;

                    $sum_credit1 = isset($arrSumgrade['sum_credit1']) ? $arrSumgrade['sum_credit1'] : 0;
                    $sum_credit2 = isset($arrSumgrade['sum_credit2']) ? $arrSumgrade['sum_credit2'] : 0;
                    $sum_credit3 = isset($arrSumgrade['sum_credit3']) ? $arrSumgrade['sum_credit3'] : 0;

                    $sum_creditonly1 = isset($arrSumgrade['sum_creditonly1']) ? $arrSumgrade['sum_creditonly1'] : 0;
                    $sum_creditonly2 = isset($arrSumgrade['sum_creditonly2']) ? $arrSumgrade['sum_creditonly2'] : 0;
                    $sum_creditonly3 = isset($arrSumgrade['sum_creditonly3']) ? $arrSumgrade['sum_creditonly3'] : 0;

                    $summaryGradeAll = $sum_credit1 + $sum_credit2 + $sum_credit3;
                    $summaryCreditAll = $sum_creditonly1 + $sum_creditonly2 + $sum_creditonly3;
                    $gradeCalculate = ($summaryGradeAll / $summaryCreditAll);
                    ?>
                    <tr>
                        <th colspan="2" class="text-center" style="padding: 5px;">เกรดเฉลี่ย</th>
                        <th colspan="2" class="text-center" style="padding: 5px;"><?php echo !empty($gradeCalculate) ? number_format($gradeCalculate, 2, '.', '') : $gradeCalculate ?></th>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>