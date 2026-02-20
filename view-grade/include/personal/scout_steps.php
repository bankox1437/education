<div class="col-lg-6 col-12">
    <div class="box">
        <!-- /.box-header -->
        <div class="form">
            <div class="box-body p-0">
                <div style="padding: 1.5rem 1.5rem 0">
                    <h4 class="box-title text-info mb-0">ขั้นลูกเสือ</h4>
                    <hr class="my-15" style="margin-bottom: 0px !important;">
                </div>
                <div class="table-responsive">
                    <table id="table-royal" style="max-height: 300px;" class="table" data-toggle="table" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/credit_controller?getDataCredit=true" data-locale="th-TH">
                        <thead>
                            <tr>
                                <th data-valign="middle" data-align="center" data-width="250px">ชื่อ</th>
                                <th data-field="concat_name" data-valign="middle" data-align="center" data-width="200px">ได้รับเมื่อ</th>
                                <th data-valign="middle" data-align="center" data-width="50px">แก้ไข</th>
                                <th data-valign="middle" data-align="center" data-width="50px">ลบ</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-right">
                <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                    <i class="ti-save-alt"></i> บันทึกขั้นลูกเสือ
                </button>
            </div>
        </div>
    </div>
    <!-- /.box -->
</div>