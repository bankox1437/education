<div class="box-header with-border">
    <div class="row align-items-center">
        <div class="col-md-4">
            <h4 class="box-title">ตารางแผนการเรียนรู้</h4>
        </div>
    </div>
    <div class="row mt-3 align-items-center">
        <?php if ($_SESSION['user_data']->role_id == 1) { ?>
            <div class="col-md-2">
                <select class="form-control" id="province_select" style="width: 100%;">
                    <option value="0">เลือกจังหวัด</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" id="district_select" style="width: 100%;">
                    <option value="0">เลือกอำเภอ</option>
                </select>
            </div>
        <?php } ?>
        <div class="col-md-2">
            <select class="form-control" id="subdistrict_select" style="width: 100%;">
                <option value="0">เลือกตำบล</option>
            </select>
        </div>
        <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="#" onclick="searchSubDis()"><i class="ti-search"></i>&nbsp;ค้นหา</a>
        <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="#" onclick="showAll()"><i class="ti-search"></i>&nbsp;ดูทั้งหมด</a>
    </div>
</div>
<div class="box-body p-0">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" style="font-size: 14px;">
            <thead>
                <tr>
                    <th>ชื่อ-สกุลครูตำบล</th>
                    <th>สถานศึกษา</th>
                    <th>ตำบล</th>
                    <th>อำเภอ</th>
                    <th>จังหวัด</th>
                    <th style="width: 150px;" class="text-center">ดูรายละเอียด</th>
                </tr>
            </thead>
            <tbody id="body-calender">
            </tbody>
        </table>
    </div>
</div>