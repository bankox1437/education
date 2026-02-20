<div class="col-md-12">
    <h5 class="text-center text-dark"><b>วิชาบังคับเลือก</b>
        <?php if (!isset($_GET['mode'])) { ?>
            <span class="badge badge-pill badge-success" style="cursor: pointer;" onclick="addRow('body_table2')" id="badge_body_table2">เพิ่มวิชา</span>
            <input type="checkbox" id="body_table2_no_subject" class="filled-in chk-col-danger" onchange="disabledRow('body_table2')">
            <label for="body_table2_no_subject">ไม่มีวิชา</label>
        <?php } ?>
    </h5>

    <?php
    if (isset($_GET['set_id']) || isset($_GET['mode'])) {
        $sql = "SELECT * FROM vg_credit_set_electives WHERE set_id = :set_id";
        $data = $DB->Query($sql, ['set_id' => $set_id]);
        $electives_data = json_decode($data);
    }
    ?>
    <div class="table-responsive">
        <table class="table table-bordered" style="font-size: 12px;">
            <thead>
                <tr style="background-color: #e4e0ff;">
                    <th style="width: 20%;" class="text-center">
                        รหัสวิชา
                    </th>
                    <th style="width: 50%;" class="text-left">ชื่อรายวิชา</th>
                    <th style="width: 10%;" class="text-center">หน่วยกิต</th>
                    <?php
                    if (!isset($_GET['mode'])) {
                        echo ' <th style="width: 10;" class="text-center">ลบ</th>';
                    }
                    ?>

                </tr>
            </thead>
            <tbody id="body_table2">
                <?php if (!isset($_GET['mode'])) {
                    if (!isset($_GET['set_id'])) {
                ?>
                        <tr>
                            <td><input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกรหัสวิชา"></td>
                            <td><input type="text" class="form-control input-custom-table text-left" autocomplete="off" placeholder="กรอกชื่อรายวิชา"></td>
                            <td><input type="number" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกหน่วยกิต"></td>
                            <td class="text-center"><span class="badge badge-pill badge-danger" style="cursor: pointer;" onclick="removeRow(this)">ลบ</span></td>
                        </tr>
                        <?php
                    } else {
                        $index = 0;
                        if (count($electives_data) == 0) { ?>
                            <tr>
                                <td><input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกรหัสวิชา"></td>
                                <td><input type="text" class="form-control input-custom-table text-left" autocomplete="off" placeholder="กรอกชื่อรายวิชา"></td>
                                <td><input type="number" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกหน่วยกิต"></td>
                                <td class="text-center"><span class="badge badge-pill badge-danger" style="cursor: pointer;" onclick="removeRow(this)">ลบ</span></td>
                            </tr>
                            <?php } else {
                            foreach ($electives_data as $key => $value) { ?>
                                <tr>
                                    <td><input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกรหัสวิชา" value="<?php echo $value->sub_id ?>"></td>
                                    <td><input type="text" class="form-control input-custom-table text-left" autocomplete="off" placeholder="กรอกชื่อรายวิชา" value="<?php echo $value->sub_name ?>"></td>
                                    <td><input type="number" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกหน่วยกิต" value="<?php echo $value->credit ?>"></td>
                                    <td style="display: none;"><input type="hidden" value="<?php echo $value->elective_id ?>"></td>
                                    <?php echo '<td class="text-center"><span class="badge badge-pill badge-danger" style="cursor: pointer;" onclick="removeRowUpdate(2,' . $value->elective_id . ',this)">ลบ</span></td>' ?>
                                </tr>
                        <?php
                                $index++;
                            }
                        }
                    }
                } else {
                    foreach ($electives_data as $key => $value) { ?>
                        <tr>
                            <td><input <?php echo $view_mode ?> type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกรหัสวิชา" value="<?php echo $value->sub_id ?>"></td>
                            <td><input <?php echo $view_mode ?> type="text" class="form-control input-custom-table text-left" autocomplete="off" placeholder="กรอกชื่อรายวิชา" value="<?php echo $value->sub_name ?>"></td>
                            <td><input <?php echo $view_mode ?> type="number" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกหน่วยกิต" value="<?php echo $value->credit ?>"></td>
                            <td style="display: none;"><input type="hidden" value="<?php echo $value->elective_id ?>"></td>
                        </tr>
                <?php }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>