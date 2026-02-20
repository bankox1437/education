<div class="box">
    <div class="box-header with-border">
        <h4 class="box-title">ตั้งค่าแนะนำแอป</h4>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        <form class="form" id="share_app">
            <input type="hidden" id="attr_id" name="attr_id" value="" placeholder="กรอกรายละเอียด">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ลิงก์ไอคอนแอป <b class="text-danger">*</b></label>
                        <input type="text" class="form-control" id="app_icon" name="app_icon" value="" placeholder="กรอกลิงก์ไอคอนแอป">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ชื่อแอป <b class="text-danger">*</b></label>
                        <input type="text" class="form-control" id="app_name" name="app_name" value="" placeholder="กรอกชื่อแอป">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>รายละเอียด <b class="text-danger">*</b></label>
                        <input type="text" class="form-control" id="app_des" name="app_des" value="" placeholder="กรอกรายละเอียด">
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end mb-3">
                    <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                        <i class="ti-save-alt"></i> บันทึก
                    </button>
                    <button type="button" class="btn btn-rounded btn-warning btn-outline ml-3" id="cancelEditBtn" style="display: none;" onclick="cancelEdit()">
                        <i class="ti-save-alt"></i> ยกเลิกแก้ไข
                    </button>
                </div>
            </div>
        </form>

        <?php
        $sql = "select * from tb_setting_attribute where key_name = 'share_app'";
        $data_result = $DB->Query($sql, []);
        $data_result = json_decode($data_result, true);
        ?>
        <div class="row mt-4">
            <?php
            foreach ($data_result as $key => $value) {
                $value_decode = json_decode($value['value'], true);
            ?>
                <div class="col-md-12 mb-3">
                    <div class="d-flex flex-md-row flex-column align-items-center">
                        <div style="width: 100px; height: 100px; flex-shrink: 0; margin-right: 15px;">
                            <img src="<?php echo $value_decode['app_icon'] ?>" class="img-fluid" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h5 class="mb-1 text-dark"><b><?php echo $value_decode['app_name'] ?></b></h5>
                            <p class="mb-0"><?php echo $value_decode['app_des'] ?></p>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-warning" onclick="editApp(<?php echo $value['attr_id'] ?>,'<?php echo $value_decode['app_name'] ?>','<?php echo $value_decode['app_icon'] ?>','<?php echo $value_decode['app_des'] ?>')">แก้ไข</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteApp(<?php echo $value['attr_id'] ?>)">ลบ</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- /.box -->