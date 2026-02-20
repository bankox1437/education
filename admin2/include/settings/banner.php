<div class="box">
    <div class="box-header with-border">
        <h4 class="box-title">ตั้งค่าลิงก์ข่าวสารและแบนเนอร์</h4>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        <form class="form" id="banner_form">
            <input type="hidden" id="attr_id" name="attr_id" value="">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>ประเภท</label>
                        <select class="form-control" id="type" name="type" onchange="selectType(this.value)">
                            <option value="0">เลือกประเภท</option>
                            <option value="1">ลิงค์</option>
                            <option value="2">ข่าวสาร</option>
                            <option value="3">แบนเนอร์รูปภาพ</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4" id="box-title" style="display: none;">
                    <div class="form-group">
                        <label>หัวข้อ <b class="text-danger">*</b></label>
                        <input type="text" class="form-control" id="title" name="title" value="" placeholder="กรอกหัวข้อ">
                    </div>
                </div>
                <div class="col-md-3" id="box-banner" style="display: none;">
                    <div class="form-group">
                        <label>รูปแบนเนอร์ <b class="text-danger">*</b></label>
                        <input type="hidden" class="form-control" id="banner_old" name="banner_old" value="">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="banner" name="banner" accept="image/png, image/gif, image/jpeg" onchange="setlabelFilename('banner')">
                            <label class="custom-file-label" for="banner" id="banner_label" style="overflow: hidden;">เลือกไฟล์รูปภาพ</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" id="box-link" style="display: none;">
                    <div class="form-group">
                        <label>ลิงก์ <b class="text-danger">*</b></label>
                        <input type="text" class="form-control" id="link" name="link" value="" placeholder="กรอกลิงก์">
                    </div>
                </div>
                <div class="col-md-1" id="box-order" style="display: none;">
                    <div class="form-group">
                        <label>ลำดับ <b class="text-danger">*</b></label>
                        <input type="text" class="form-control" id="order" name="order" value="" placeholder="กรอกลำดับ">
                    </div>
                </div>
                <div class="col-md-2 align-items-end mb-3" id="box-btn" style="display: none;">
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
        $sql = "select * from tb_setting_attribute where key_name = 'banner_form'";
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
                        <!-- <div style="width: 100px; height: 100px; flex-shrink: 0; margin-right: 15px;">
                            <img src="<?php echo $value_decode['app_icon'] ?>" class="img-fluid" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
                        </div> -->
                        <div>
                            <?php if ($value_decode['type'] == 1) { ?>
                                <a href="<?php echo $value_decode['link'] ?>" target="_blank" class="my-2">
                                    <h5 class="mb-1 text-info"><b>(ลิงก์) <?php echo $value_decode['title'] ?></b></h5>
                                </a>
                            <?php } ?>
                            <?php if ($value_decode['type'] == 2) { ?>
                                <h5 class="mb-1 text-dark"><b>(ข่าวสาร) <?php echo $value_decode['title'] ?></b></h5>
                            <?php } ?>
                            <?php if ($value_decode['type'] == 3) { ?>
                                <a href="<?php echo $value_decode['link'] ?>">
                                    <div style="width: 300px; height: 100px; flex-shrink: 0; margin-right: 15px;" class="text-left">
                                        <img src="upload/banners/<?php echo  $value_decode['banner'] ?>" class="img-fluid" alt="Logo" style="width: 100%; height: 100%;">
                                    </div>
                                </a>
                            <?php } ?>

                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-warning" onclick="editBanner(<?php echo $value['attr_id'] ?>,'<?php echo $value_decode['title'] ?>','<?php echo $value_decode['link'] ?>','<?php echo $value_decode['banner'] ?>',<?php echo $value_decode['type'] ?>,'<?php echo $value_decode['order'] ?>')">แก้ไข</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteBanner(<?php echo $value['attr_id'] ?>,<?php echo $value_decode['type'] ?>,'<?php echo $value_decode['banner'] ?>')">ลบ</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- <div class="col-md-12 mb-3">
                <div class="d-flex flex-md-row flex-column align-items-center">
                    <div style="width: 300px; height: 100px; flex-shrink: 0; margin-right: 15px;">
                        <img src="uploads/banners/c2a8615e-1589-4728-ad40-63f7c3c6c1ba.jpg" class="img-fluid" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    <div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-warning" onclick="editApp(<?php echo $value['attr_id'] ?>,'<?php echo $value_decode['app_name'] ?>','<?php echo $value_decode['app_icon'] ?>','<?php echo $value_decode['app_des'] ?>')">แก้ไข</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteApp(<?php echo $value['attr_id'] ?>)">ลบ</button>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
<!-- /.box -->