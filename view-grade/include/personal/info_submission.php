<div class="col-lg-6 col-12">
    <div class="box">
        <!-- /.box-header -->
        <div class="form">
            <div class="box-body p-0">
                <div style="padding: 1.5rem 1.5rem 0">
                    <h4 class="box-title text-info mb-0">การประกวด / ส่งผลงาน</h4>
                    <hr class="my-15" style="margin-bottom: 0px !important;">
                </div>
                <?php if (!$isRead) { ?>
                    <div class="row" style="padding: 1rem 1.5rem 0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ชื่อการประกวด / ส่งผลงาน <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" id="submission_name" autocomplete="off" placeholder="กรอกชื่อการประกวด / ส่งผลงาน">
                                <input type="hidden" id="submission_id" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="margin-top: 24px;">
                                <button type="button" class="btn btn-rounded btn-primary btn-outline" onclick="submitSubmission()">
                                    <i class="ti-save-alt"></i> บันทึกการประกวดผลงาน
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="table-responsive">
                    <table id="info_submission" data-height="300" data-toggle="table" data-minimum-count-columns="2" data-url="controllers/info_controller?getSubmissionData=true<?php echo $isRead ? '&user_id=' . $_GET['user_id'] : '' ?>" data-locale="th-TH">
                        <thead>
                            <tr>
                                <th data-field="submission_name" data-valign="middle" data-align="center" data-width="250px">เรื่อง</th>
                                <?php if (!$isRead) { ?>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonEditSubmission">แก้ไข</th>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonDeleteSubmission">ลบ</th>
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
    const $info_submission = $("#info_submission");

    function formatButtonEditSubmission(data, row) {
        let html = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"
                    onclick="editSubmission(${row.submission_id},'${row.submission_name}')"></i></button>`;
        return html;
    }

    function formatButtonDeleteSubmission(data, row) {
        let html = `<button type="button" onclick="deleteSubmission(${row.submission_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
        return html;
    }

    function submitSubmission() {
        let submission_id = $('#submission_id').val();
        let submission_name = $('#submission_name').val();

        if ($('#submission_name').val() == '') {
            alert(`โปรด${$('#submission_name').attr('placeholder')}`);
            $('#submission_name').focus();
            return false; // This stops the .each loop
        }

        let formData = new FormData();
        formData.append("submission_id", submission_id);
        formData.append("submission_name", submission_name);
        formData.append("update_submission", true);

        $.ajax({
            type: "POST",
            url: "controllers/info_controller",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: async function(response) {
                if (response == 1) {
                    alert("บันทึกการประกวดผลงานสำเร็จ");
                    $info_submission.bootstrapTable('refresh');
                    resetInputSubmission()
                }
            },
        });
    }

    function deleteSubmission(submission_id) {
        if (confirm('ต้องการลบการประกวดผลงานนี้หรือไม่?')) {
            $.ajax({
                type: "POST",
                url: "controllers/info_controller",
                data: {
                    deleteSubmission: true,
                    submission_id: submission_id
                },
                success: async function(response) {
                    if (response == 1) {
                        alert("ลบการประกวดผลงานสำเร็จ");
                        $info_submission.bootstrapTable('refresh');
                    }
                },
            });
        }
    }

    function editSubmission(submission_id, submission_name) {
        $('#submission_id').val(submission_id);
        $('#submission_name').val(submission_name);
    }

    function resetInputSubmission() {
        $('#submission_id').val('');
        $('#submission_name').val('');
    }
</script>