<style>
    input[type="color"] {
        height: 33px;
    }
</style>

<div class="box">
    <div class="box-header with-border">
        <h4 class="box-title">ตั้งค่าหน้าแรกระบบ</h4>
    </div>
    <!-- /.box-header -->
    <form class="form" id="setting_name" enctype="multipart/form-data">

        <?php

        $sql = "select * from tb_setting_attribute where key_name = 'system_name'";
        $data_result = $DB->Query($sql, []);
        $data_result = json_decode($data_result);

        $system_name1 = "";
        $font_name1 = "1.7142857142857142rem";
        $color_name1 = "#475F7B";

        $system_name2 = "";
        $font_name2 = "1.7142857142857142rem";
        $color_name2 = "#475F7B";

        $system_name3 = "";
        $font_name3 = "1.7142857142857142rem";
        $color_name3 = "#475F7B";

        $system_name4 = "";
        $font_name4 = "1.7142857142857142rem";
        $color_name4 = "#475F7B";

        $system_name5 = "";
        $font_name5 = "1.7142857142857142rem";
        $color_name5 = "#475F7B";

        $file_image_old = "";

        if (count($data_result) > 0) {
            $data_result = $data_result[0]->value;

            $data_result = json_decode($data_result, true);

            $system_name1 = $data_result['system_name1'];
            $font_name1 = $data_result['font_name1'] ?? '1.7142857142857142rem';
            $color_name1 = $data_result['color_name1'] ?? '#475F7B';

            $system_name2 = $data_result['system_name2'];
            $font_name2 = $data_result['font_name2'] ?? '1.7142857142857142rem';
            $color_name2 = $data_result['color_name2'] ?? '#475F7B';

            $system_name3 = $data_result['system_name3'];
            $font_name3 = $data_result['font_name3'] ?? '1.7142857142857142rem';
            $color_name3 = $data_result['color_name3'] ?? '#475F7B';

            $system_name4 = $data_result['system_name4'];
            $font_name4 = $data_result['font_name4'] ?? '1.7142857142857142rem';
            $color_name4 = $data_result['color_name4'] ?? '#475F7B';

            $system_name5 = $data_result['system_name5'];
            $font_name5 = $data_result['font_name5'] ?? '1.7142857142857142rem';
            $color_name5 = $data_result['color_name5'] ?? '#475F7B';

            $file_image_old = $data_result['file_image'];
        }

        ?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        <label>ชื่อระบบ 1 <b class="text-danger">*</b></label>
                        <input type="text" class="form-control" id="system_name1" name="system_name1" value="<?php echo $system_name1 ?>" placeholder="กรอกชื่อระบบ 1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ขนาดอักษร (px)</label>
                        <input type="text" class="form-control" id="font_name1" name="font_name1" value="<?php echo $font_name1 ?>" placeholder="กรอกขนาด">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>สี</label>
                        <input type="color" class="form-control" id="color_name1" name="color_name1" value="<?php echo $color_name1 ?>">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label>ชื่อระบบ 2</label>
                        <input type="text" class="form-control" id="system_name2" name="system_name2" value="<?php echo $system_name2 ?>" placeholder="กรอกชื่อระบบ 2">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ขนาดอักษร (px)</label>
                        <input type="text" class="form-control" id="font_name2" name="font_name2" value="<?php echo $font_name2 ?>" placeholder="กรอกขนาด">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>สี</label>
                        <input type="color" class="form-control" id="color_name2" name="color_name2" value="<?php echo $color_name2 ?>">
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="form-group">
                        <label>ชื่อระบบ 3</label>
                        <input type="text" class="form-control" id="system_name3" name="system_name3" value="<?php echo $system_name3 ?>" placeholder="กรอกชื่อระบบ 3">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ขนาดอักษร (px)</label>
                        <input type="text" class="form-control" id="font_name3" name="font_name3" value="<?php echo $font_name3 ?>" placeholder="กรอกขนาด">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>สี</label>
                        <input type="color" class="form-control" id="color_name3" name="color_name3" value="<?php echo $color_name3 ?>">
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="form-group">
                        <label>ชื่อระบบภาษาอังกฤษ 1</label>
                        <input type="text" class="form-control" id="system_name4" name="system_name4" value="<?php echo $system_name4 ?>" placeholder="กรอกชื่อระบบภาษาอังกฤษ 1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ขนาดอักษร (px)</label>
                        <input type="text" class="form-control" id="font_name4" name="font_name4" value="<?php echo $font_name4 ?>" placeholder="กรอกขนาด">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>สี</label>
                        <input type="color" class="form-control" id="color_name4" name="color_name4" value="<?php echo $color_name4 ?>">
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="form-group">
                        <label>ชื่อระบบภาษาอังกฤษ 2</label>
                        <input type="text" class="form-control" id="system_name5" name="system_name5" value="<?php echo $system_name5 ?>" placeholder="กรอกชื่อระบบภาษาอังกฤษ 2">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ขนาดอักษร (px)</label>
                        <input type="text" class="form-control" id="font_name5" name="font_name5" value="<?php echo $font_name5 ?>" placeholder="กรอกขนาด">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>สี</label>
                        <input type="color" class="form-control" id="color_name5" name="color_name5" value="<?php echo $color_name5 ?>">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>รูปโลโก้หน้าหลัก <?php if (empty($file_image_old)) { ?><b class="text-danger">*</b> <?php } ?></label>
                        <input type="hidden" class="form-control" id="file_image_old" name="file_image_old" value="<?php echo $file_image_old ?>">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo_image" name="logo_image" accept="image/png, image/gif, image/jpeg" onchange="setlabelFilename('logo_image')">
                            <label class="custom-file-label" for="logo_image" id="logo_image_label">เลือกไฟล์รูปภาพ</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                <i class="ti-save-alt"></i> บันทึก
            </button>
        </div>
    </form>
</div>
<!-- /.box -->