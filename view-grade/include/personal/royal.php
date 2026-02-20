<div class="col-lg-6 col-12">
    <div class="box">
        <!-- /.box-header -->
        <div class="form">
            <div class="box-body p-0">
                <div style="padding: 1.5rem 1.5rem 0">
                    <h4 class="box-title text-info mb-0">โล่ เข็ม เกียรติบัตร ที่ได้รับ</h4>
                    <hr class="my-15" style="margin-bottom: 0px !important;">
                </div>
                <?php if (!$isRead) { ?>
                    <div class="row" style="padding: 1rem 1.5rem 0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ชื่อโล่ เข็ม เกียรติบัตร <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" id="royal_name" placeholder="ชื่อโล่ เข็ม เกียรติบัตร" autocomplete="off">
                                <input type="hidden" id="royal_id" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-date-get_royal">
                                <label>วันที่ได้รับ <b class="text-danger">*</b></label>
                                <input type="text" class="form-control date-text" id="get_royalText" placeholder="วันที่ได้รับ" onclick="hideInputDate('get_royal','get_royalText')">
                                <input style="display: none;" type="text" class="form-control" id="get_royal" placeholder="วันที่ได้รับ">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-4">
                        <button type="button" class="btn btn-rounded btn-primary btn-outline" onclick="submitRoyal()">
                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                        </button>
                    </div>
                <?php } ?>
                <div class="table-responsive">
                    <table id="table_royal" data-height="300" class="table" data-toggle="table" data-minimum-count-columns="2" data-url="controllers/info_controller?getRoyal=true<?php echo $isRead ? '&user_id=' . $_GET['user_id'] : '' ?>" data-locale="th-TH">
                        <thead>
                            <tr>
                                <th data-field="royal_name" data-valign="middle" data-align="center" data-width="250px">ชื่อ</th>
                                <th data-field="royal_get" data-valign="middle" data-align="center" data-width="200px" data-formatter="formatRoyalDate">ได้รับเมื่อ</th>
                                <?php if (!$isRead) { ?>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonEditRoyal">แก้ไข</th>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonDelete">ลบ</th>
                                <?php } ?>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- /.box -->
</div>

<script>
    const $tableRoyal = $("#table_royal");

    function formatButtonEditRoyal(data, row) {
        let html = `<button type="button" onclick="editRoyal(${row.royal_id},'${row.royal_name}','${row.royal_get}')" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>`;
        return html;
    }

    function formatButtonDelete(data, row) {
        let html = `<button type="button" onclick="deleteRoyal(${row.royal_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
        return html;
    }

    function formatRoyalDate(data, row) {
        let date = formatToBuddhistDate(row.royal_get);
        return date;
    }

    function submitRoyal() {
        let royal_id = $('#royal_id').val();
        let royal_name = $('#royal_name').val();
        let get_royal = $('#get_royal').val();
        if (!royal_name) {
            alert("โปรดกรอกชื่อเครื่องราช");
            $('#royal_name').focus();
            return;
        }
        if (!get_royal) {
            alert("โปรดเลือกวันที่ได้รับ");
            $('#get_royal').focus();
            return;
        }
        $.ajax({
            type: "POST",
            url: "controllers/info_controller",
            data: {
                insertRoyal: true,
                royal_id: royal_id,
                royal_name: royal_name,
                get_royal: get_royal
            },
            success: async function(response) {
                if (response == 1) {
                    alert("บันทึกสำเร็จ");
                    $tableRoyal.bootstrapTable('refresh');
                    resetInputRoyal()
                }
            },
        });
    }

    function deleteRoyal(royal_id) {
        if (confirm('ต้องการลบเครื่องราชนี้หรือไม่?')) {
            $.ajax({
                type: "POST",
                url: "controllers/info_controller",
                data: {
                    deleteRoyal: true,
                    royal_id: royal_id,
                },
                success: async function(response) {
                    if (response == 1) {
                        alert("ลบสำเร็จ");
                        $tableRoyal.bootstrapTable('refresh');
                    }
                },
            });
        }
    }

    function editRoyal(royal_id, royal_name, royal_get) {
        $('#royal_id').val(royal_id)
        $('#royal_name').val(royal_name)
        initFlatpickr('get_royal', royal_get);
    }

    function resetInputRoyal() {
        $('#royal_id').val('')
        $('#royal_name').val('')
        initFlatpickr('get_royal', '');
    }
</script>