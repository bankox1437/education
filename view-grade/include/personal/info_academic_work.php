<div class="col-lg-6 col-12">
    <div class="box">
        <!-- /.box-header -->
        <div class="form">
            <div class="box-body p-0">
                <div style="padding: 1.5rem 1.5rem 0">
                    <h4 class="box-title text-info mb-0">ผลงานวิชาการ / งานวิจัย / นวัตกรรม</h4>
                    <hr class="my-15" style="margin-bottom: 0px !important;">
                </div>
                <?php if (!$isRead) { ?>
                    <div class="row" style="padding: 1rem 1.5rem 0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>เรื่อง <b class="text-danger">*</b></label>
                                <input type="text" class="form-control academic_form" id="academic_name" autocomplete="off" placeholder="กรอกเรื่อง">
                                <input type="hidden" id="academic_id" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ไฟล์ผลงาน</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="academic_file" name="academic_file" accept="application/pdf" onchange="setlabelFilename('academic_file')">
                                    <input type="hidden" id="academic_file_old">
                                    <label class="custom-file-label" for="academic_file" id="academic_file_label">เลือกไฟล์ PDF เท่านั้น</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="row justify-content-center mb-4">
                        <button type="button" class="btn btn-rounded btn-primary btn-outline" onclick="submitAcademic()">
                            <i class="ti-save-alt"></i> บันทึกผลงานวิชาการ
                        </button>
                    </div>
                <?php } ?>
                <div class="table-responsive">
                    <table id="info_academic" data-height="300" data-toggle="table" data-minimum-count-columns="2" data-url="controllers/info_controller?getAcademicData=true<?php echo $isRead ? '&user_id=' . $_GET['user_id'] : '' ?>" data-locale="th-TH">
                        <thead>
                            <tr>
                                <th data-field="academic_name" data-valign="middle" data-align="center" data-width="250px">เรื่อง</th>
                                <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonViewAcademicFile">ไฟล์</th>
                                <?php if (!$isRead) { ?>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonEditAcademic">แก้ไข</th>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonDeleteAcademic">ลบ</th>
                                <?php } ?>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box -->
</div>

<script>
    const $info_academic = $("#info_academic");

    function formatButtonEditAcademic(data, row) {
        let html = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"
                    onclick="editAcademic(${row.academic_id},'${row.academic_name}','${row.academic_file}')"></i></button>`;
        return html;
    }

    function formatButtonDeleteAcademic(data, row) {
        let html = `<button type="button" onclick="deleteAcademic(${row.academic_id},'${row.academic_file}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
        return html;
    }

    function formatButtonViewAcademicFile(data, row) {
        let html = "-";
        if (row.academic_file != '') {
            html = `<a href="uploads/info/academic/${row.academic_file}" target="_blank">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
        }
        return html;
    }

    function submitAcademic() {
        let academic_id = $('#academic_id').val();
        let academic_name = $('#academic_name').val();
        let academic_file = document.getElementById('academic_file').files[0];
        let academic_file_old = $('#academic_file_old').val();

        if ($('#academic_name').val() == '') {
            alert(`โปรด${$('#academic_name').attr('placeholder')}`);
            $('#academic_name').focus();
            return false; // This stops the .each loop
        }

        let formData = new FormData();
        formData.append("academic_id", academic_id);
        formData.append("academic_name", academic_name);
        formData.append("academic_file", academic_file);
        formData.append("academic_file_old", academic_file_old);
        formData.append("update_academic", true);

        $.ajax({
            type: "POST",
            url: "controllers/info_controller",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: async function(response) {
                if (response == 1) {
                    alert("บันทึกผลงานวิชาการสำเร็จ");
                    $info_academic.bootstrapTable('refresh');
                    resetInputAcademic()
                }
            },
        });
    }

    function deleteAcademic(academic_id, academic_file_old) {
        if (confirm('ต้องการลบผลงานวิชาการนี้หรือไม่?')) {
            $.ajax({
                type: "POST",
                url: "controllers/info_controller",
                data: {
                    deleteAcademic: true,
                    academic_id: academic_id,
                    academic_file_old: academic_file_old
                },
                success: async function(response) {
                    if (response == 1) {
                        alert("ลบผลงานวิชาการสำเร็จ");
                        $info_academic.bootstrapTable('refresh');
                    }
                },
            });
        }
    }

    function editAcademic(academic_id, academic_name, academic_file_old) {
        $('#academic_id').val(academic_id);
        $('#academic_name').val(academic_name);
        $('#academic_file_old').val(academic_file_old);
    }

    function resetInputAcademic() {
        $('#academic_id').val('');
        $('#academic_name').val('');
        $('#academic_file_old').val('');
        document.getElementById('academic_file').files[0] = undefined;
        document.getElementById('academic_file').value = '';
        document.getElementById('academic_file_label').innerText = "เลือกไฟล์ PDF เท่านั้น";
    }
</script>