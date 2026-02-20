<div class="col-lg-6 col-12">
    <div class="box">
        <!-- /.box-header -->
        <div class="form">
            <div class="box-body p-0">
                <div style="padding: 1.5rem 1.5rem 0">
                    <h4 class="box-title text-info mb-0">การอบรมเป็นวิทยากร</h4>
                    <hr class="my-15" style="margin-bottom: 0px !important;">
                </div>
                <?php if (!$isRead) { ?>
                    <div class="row" style="padding: 1rem 1.5rem 0">
                        <div class="col-md-4">
                            <label>ประเภทการเข้าอบรม</label>
                            <select class="form-control" id="lecturer_type">
                                <option value="1">การเป็นวิทยากรภายใน</option>
                                <option value="2">การเป็นวิทยากรภายนอก</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>เรื่อง <b class="text-danger">*</b></label>
                                <input type="text" class="form-control lecturer_form" id="lecturer_name" autocomplete="off" placeholder="กรอกเรื่องที่อบรม">
                                <input type="hidden" id="lecturer_id" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>หน่วยงานที่เชิญ <b class="text-danger">*</b></label>
                                <input type="text" class="form-control lecturer_form" id="lecturer_agency" autocomplete="off" placeholder="กรอกหน่วยงานที่จัด">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ไฟล์หนังสือเชิญ</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="lecturer_diploma_file" name="lecturer_diploma_file" accept="application/pdf" onchange="setlabelFilename('lecturer_diploma_file')">
                                    <input type="hidden" id="lecturer_diploma_file_old">
                                    <label class="custom-file-label" for="lecturer_diploma_file" id="lecturer_diploma_file_label">เลือกไฟล์ PDF เท่านั้น</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-date-lecturer_date">
                                <label>วันที่รับการอบรม <b class="text-danger">*</b></label>
                                <input type="text" class="form-control lecturer_form" id="lecturer_dateText" placeholder="เลือกวันที่รับการอบรม" onclick="hideInputDate('lecturer_date','lecturer_dateText')">
                                <input style="display: none;" type="text" class="form-control lecturer_form" id="lecturer_date" placeholder="เลือกวันที่รับการอบรม">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="row justify-content-center mb-4">
                        <button type="button" class="btn btn-rounded btn-primary btn-outline" onclick="submitLecturer()">
                            <i class="ti-save-alt"></i> บันทึกการอบรมเป็นวิทยากร
                        </button>
                    </div>
                <?php } ?>
                <div class="table-responsive">
                    <table id="info_lecturer" data-height="375" data-toggle="table" data-minimum-count-columns="2" data-url="controllers/info_controller?getLecturerData=true<?php echo $isRead ? '&user_id=' . $_GET['user_id'] : '' ?>" data-locale="th-TH">
                        <thead>
                            <tr>
                                <th data-field="lecturer_name" data-valign="middle" data-align="center" data-width="250px">เรื่องที่อบรม</th>
                                <th data-field="lecturer_agency" data-valign="middle" data-align="center" data-width="200px">หน่วยงานที่จัด</th>
                                <th data-field="lecturer_date" data-valign="middle" data-align="center" data-width="100px" data-formatter="formatLecturerDate">วันที่รับการอบรม</th>
                                <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatLecturerType">ประเภท</th>
                                <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonViewLecturerFile">ไฟล์</th>
                                <?php if (!$isRead) { ?>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonEditLecturer">แก้ไข</th>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonDeleteLecturer">ลบ</th>
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
    const $info_lecturer = $("#info_lecturer");

    function formatLecturerType(data, row) {
        let html = row.lecturer_type == 2 ? `<i class="fa fa-circle text-success" aria-hidden="true"></i>` : `<i class="fa fa-circle text-danger" aria-hidden="true"></i>`;
        return html;
    }

    function formatButtonEditLecturer(data, row) {
        let html = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"
                    onclick="editLecturer(${row.lecturer_id},'${row.lecturer_type}','${row.lecturer_name}', '${row.lecturer_agency}','${row.lecturer_diploma_file}','${row.lecturer_date}')"></i></button>`;
        return html;
    }

    function formatButtonDeleteLecturer(data, row) {
        let html = `<button type="button" onclick="deleteLecturer(${row.lecturer_id},'${row.lecturer_diploma_file}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
        return html;
    }

    function formatButtonViewLecturerFile(data, row) {
        let html = "-";
        if (row.lecturer_diploma_file != '') {
            html = `<a href="uploads/info/lecturer/${row.lecturer_diploma_file}" target="_blank">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
        }
        return html;
    }

    function formatLecturerDate(data, row) {
        let date = formatToBuddhistDate(row.lecturer_date);
        return date;
    }

    function submitLecturer() {
        let lecturer_id = $('#lecturer_id').val();
        let lecturer_type = $('#lecturer_type').val();
        let lecturer_name = $('#lecturer_name').val();
        let lecturer_agency = $('#lecturer_agency').val();
        let lecturer_diploma_file = document.getElementById('lecturer_diploma_file').files[0];
        let lecturer_diploma_file_old = $('#lecturer_diploma_file_old').val();
        let lecturer_date = $('#lecturer_date').val();

        if (!validateInputLecturer()) {
            return false;
        }

        // if (lecturer_diploma_file == undefined) {
        //     alert("โปรดแนบไฟล์วุฒิบัตร");
        //     $('#lecturer_diploma_file').focus();
        //     return;
        // }

        let formData = new FormData();
        formData.append("lecturer_id", lecturer_id);
        formData.append("lecturer_type", lecturer_type);
        formData.append("lecturer_name", lecturer_name);
        formData.append("lecturer_agency", lecturer_agency);
        formData.append("lecturer_diploma_file", lecturer_diploma_file);
        formData.append("lecturer_diploma_file_old", lecturer_diploma_file_old);
        formData.append("lecturer_date", lecturer_date);
        formData.append("update_lecturer", true);

        $.ajax({
            type: "POST",
            url: "controllers/info_controller",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: async function(response) {
                if (response == 1) {
                    alert("บันทึกการอบรมเป็นวิทยากรสำเร็จ");
                    $info_lecturer.bootstrapTable('refresh');
                    resetInputLecturer()
                }
            },
        });
    }

    function validateInputLecturer() {
        let isValid = true;

        $('.lecturer_form').each(function(i, e) {
            if ($(e).val() == '') {
                alert(`โปรด${e.getAttribute('placeholder')}`);
                $(e).focus();
                isValid = false;
                return false; // This stops the .each loop
            }
        });

        return isValid;
    }

    function deleteLecturer(lecturer_id, lecturer_diploma_file_old) {
        if (confirm('ต้องการ การอบรมเป็นวิทยากรนี้หรือไม่?')) {
            $.ajax({
                type: "POST",
                url: "controllers/info_controller",
                data: {
                    deleteLecturer: true,
                    lecturer_id: lecturer_id,
                    lecturer_diploma_file_old: lecturer_diploma_file_old
                },
                success: async function(response) {
                    if (response == 1) {
                        alert("ลบการเข้ารับการอบรมสำเร็จ");
                        $info_lecturer.bootstrapTable('refresh');
                    }
                },
            });
        }
    }

    function editLecturer(lecturer_id, lecturer_type, lecturer_name, lecturer_agency, lecturer_diploma_file_old, lecturer_date) {
        $('#lecturer_id').val(lecturer_id);
        $('#lecturer_type').val(lecturer_type).change();
        $('#lecturer_name').val(lecturer_name);
        $('#lecturer_agency').val(lecturer_agency);
        $('#lecturer_diploma_file_old').val(lecturer_diploma_file_old);

        initFlatpickr('lecturer_date', lecturer_date);
    }

    function resetInputLecturer() {
        $('#lecturer_id').val('');
        $('#lecturer_type').val('1').change();
        $('#lecturer_name').val('');
        $('#lecturer_agency').val('');
        $('#lecturer_diploma_file_old').val('');

        initFlatpickr('lecturer_date', '');

        document.getElementById('lecturer_diploma_file_label').innerText = "เลือกไฟล์ PDF เท่านั้น";
        document.getElementById('lecturer_diploma_file').files[0] = undefined;
    }
</script>