<div class="row">
    <div class="col-xl-12 ">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <?php if ($_SESSION['user_data']->role_id == 1) { ?>
                        <div class="col-md-2">
                            <select class="form-control select2 mr-2" id="province_select" style="width: 100%;" onchange="getDistrictByProvince()">
                                <option value="">เลือกจังหวัด</option>
                            </select>
                            <input type="hidden" name="pro_value" id="pro_value">
                        </div>

                        <div class="col-md-2">
                            <select class="form-control select2 mr-2" disabled id="district_select" style="width: 100%;" onchange="getSubDistrictByDistrict()">
                                <option>เลือกอำเภอ</option>
                            </select>
                            <input type="hidden" name="dis_value" id="dis_value">
                        </div>
                    <?php } ?>
                    <div class="col-md-2">
                        <select class="form-control select2 mr-2" <?php echo $_SESSION['user_data']->role_id == 1 ? 'disabled' : '' ?> id="sub_district_select" style="width: 100%;" onchange="getBySubDistrict()">
                            <option>เลือกตำบล</option>
                        </select>
                        <input type="hidden" name="sub_value" id="sub_value">
                        <input type="hidden" name="sub_dis_value" id="sub_dis_value">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control select2" id="teacher_select" style="width: 100%;" <?php echo $_SESSION['user_data']->role_id == 1 ? 'onchange="getdatacountAdmin()"' : 'onchange="getdatacountAmphur()"' ?>>
                            <option value="0">เลือกครู</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <a href="#" id="view_all">
                            <h5 class="mt-2 ml-3">ดูทั้งหมด</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>