<div class="col-lg-6 col-12">
    <div class="box">
        <!-- /.box-header -->
        <div class="form">
            <div class="box-body p-0">
                <div style="padding: 1.5rem 1.5rem 0">
                    <h4 class="box-title text-info mb-0">ข้อมูลการเข้ารับการอบรม</h4>
                    <hr class="my-15" style="margin-bottom: 0px !important;">
                </div>
                <?php if (!$isRead) { ?>
                    <div class="row" style="padding: 1rem 1.5rem 0">
                        <div class="col-md-4">
                            <label>ประเภทการเข้าอบรม</label>
                            <select class="form-control" id="training_type" onchange="changeTypeTraining(this.value)">
                                <option value="1">การอบรมแบบออฟไลน์</option>
                                <option value="2">การอบรมแบบออนไลน์</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>เรื่องที่อบรม <b class="text-danger">*</b></label>
                                <input type="text" class="form-control training_form" id="training_name" autocomplete="off" placeholder="กรอกเรื่องที่อบรม">
                                <input type="hidden" id="training_id" value="">
                            </div>
                        </div>
                        <div class="col-md-4" id="location_traning">
                            <div class="form-group">
                                <label>สถานที่ <b class="text-danger">*</b></label>
                                <input type="text" class="form-control training_form" id="training_location" autocomplete="off" placeholder="กรอกสถานที่">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>หน่วยงานที่จัด <b class="text-danger">*</b></label>
                                <input type="text" class="form-control training_form" id="training_agency" autocomplete="off" placeholder="กรอกหน่วยงานที่จัด">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ไฟล์วุฒิบัตร</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="training_diploma_file" name="training_diploma_file" accept="application/pdf" onchange="setlabelFilename('training_diploma_file')">
                                    <input type="hidden" id="training_diploma_file_old">
                                    <label class="custom-file-label" for="training_diploma_file" id="training_diploma_file_label">เลือกไฟล์ PDF เท่านั้น</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-date-training_date">
                                <label>วันที่รับการอบรม <b class="text-danger">*</b></label>
                                <input type="text" class="form-control training_form date-text" id="training_dateText" placeholder="เลือกวันที่รับการอบรม" onclick="hideInputDate('training_date','training_dateText')">
                                <input style="display: none;" type="text" class="form-control training_form" id="training_date" placeholder="เลือกวันที่รับการอบรม">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="row justify-content-center mb-4">
                        <button type="button" class="btn btn-rounded btn-primary btn-outline" onclick="submitTraing()">
                            <i class="ti-save-alt"></i> บันทึกการเข้ารับการอบรม
                        </button>
                    </div>
                <?php } ?>
                <div class="table-responsive">
                    <table id="info_training" data-height="<?php echo $isRead ? '485' : '375' ?>" data-toggle="table" data-minimum-count-columns="2" data-url="controllers/info_controller?getTrainingData=true<?php echo $isRead ? '&user_id=' . $_GET['user_id'] : '' ?>" data-locale="th-TH">
                        <thead>
                            <tr>
                                <th data-field="training_name" data-valign="middle" data-align="center" data-width="250px">เรื่องที่อบรม</th>
                                <th data-field="training_agency" data-valign="middle" data-align="center" data-width="200px">หน่วยงานที่จัด</th>
                                <th data-field="training_location" data-valign="middle" data-align="center" data-width="200px">สถานที่</th>
                                <th data-field="training_date" data-valign="middle" data-align="center" data-width="100px" data-formatter="formatTraingDate">วันที่รับการอบรม</th>
                                <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatTraingType">ประเภท</th>
                                <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonViewTrainingFile">ไฟล์</th>
                                <?php if (!$isRead) { ?>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonEditTraining">แก้ไข</th>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonDeleteTraining">ลบ</th>
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
    function changeTypeTraining(value) {
        if (value == 2) {
            $('#location_traning').hide();
        } else {
            $('#location_traning').show();
        }
    }
    const $info_training = $("#info_training");

    function formatTraingType(data, row) {
        let html = row.training_type == 2 ? `<i class="fa fa-circle text-success" aria-hidden="true"></i>` : `<i class="fa fa-circle text-danger" aria-hidden="true"></i>`;
        return html;
    }

    function formatButtonEditTraining(data, row) {
        let html = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"
                    onclick="editTraining(${row.training_id},'${row.training_type}','${row.training_name}','${row.training_location}', '${row.training_agency}','${row.training_diploma_file}','${row.training_date}')"></i></button>`;
        return html;
    }

    function formatButtonDeleteTraining(data, row) {
        let html = `<button type="button" onclick="deleteTraining(${row.training_id},'${row.training_diploma_file}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
        return html;
    }

    function formatButtonViewTrainingFile(data, row) {
        let html = "-";
        if (row.training_diploma_file != '') {
            html = `<a href="uploads/info/training/${row.training_diploma_file}" target="_blank">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
        }
        return html;
    }

    function formatTraingDate(data, row) {
        let date = formatToBuddhistDate(row.training_date);
        return date;
    }

    function submitTraing() {
        let training_id = $('#training_id').val();
        let training_type = $('#training_type').val();
        let training_name = $('#training_name').val();
        let training_location = $('#training_location').val();
        let training_agency = $('#training_agency').val();
        let training_diploma_file = document.getElementById('training_diploma_file').files[0];
        let training_diploma_file_old = $('#training_diploma_file_old').val();
        let training_date = $('#training_date').val();

        if (!validateInput()) {
            return false;
        }

        // if (training_diploma_file == undefined) {
        //     alert("โปรดแนบไฟล์วุฒิบัตร");
        //     $('#training_diploma_file').focus();
        //     return;
        // }

        let formData = new FormData();
        formData.append("training_id", training_id);
        formData.append("training_type", training_type);
        formData.append("training_name", training_name);
        formData.append("training_location", training_location);
        formData.append("training_agency", training_agency);
        formData.append("training_diploma_file", training_diploma_file);
        formData.append("training_diploma_file_old", training_diploma_file_old);
        formData.append("training_date", training_date);
        formData.append("update_training", true);

        $.ajax({
            type: "POST",
            url: "controllers/info_controller",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: async function(response) {
                if (response == 1) {
                    alert("บันทึกการเข้ารับการอบรมสำเร็จ");
                    $info_training.bootstrapTable('refresh');
                    resetInputTraining()
                }
            },
        });
    }

    function validateInput() {
        let isValid = true;

        $('.training_form').each(function(i, e) {
            if ($(e).val() == '') {
                if (e.getAttribute('id') == 'training_location' && $('#training_type').val() == '2') {

                } else {
                    alert(`โปรด${e.getAttribute('placeholder')}`);
                    $(e).focus();
                    isValid = false;
                    return false; // This stops the .each loop
                }

            }
        });

        return isValid;
    }

    function deleteTraining(training_id, training_diploma_file_old) {
        if (confirm('ต้องการลบเครื่องราชนี้หรือไม่?')) {
            $.ajax({
                type: "POST",
                url: "controllers/info_controller",
                data: {
                    deleteTraining: true,
                    training_id: training_id,
                    training_diploma_file_old: training_diploma_file_old
                },
                success: async function(response) {
                    if (response == 1) {
                        alert("ลบการเข้ารับการอบรมสำเร็จ");
                        $info_training.bootstrapTable('refresh');
                    }
                },
            });
        }
    }

    function editTraining(training_id, training_type, training_name, training_location, training_agency, training_diploma_file_old, training_date) {
        $('#training_id').val(training_id);
        $('#training_type').val(training_type).change();
        $('#training_name').val(training_name);
        if (training_type == 1) {
            $('#training_location').val(training_location);
        }
        $('#training_agency').val(training_agency);
        $('#training_diploma_file_old').val(training_diploma_file_old);

        initFlatpickr('training_date', training_date);
    }

    function resetInputTraining() {
        $('#training_id').val('');
        $('#training_type').val('1').change();
        $('#training_name').val('');
        $('#training_location').val('');
        $('#training_agency').val('');
        $('#training_diploma_file_old').val('');

        initFlatpickr('training_date', '');

        document.getElementById('training_diploma_file_label').innerText = "เลือกไฟล์ PDF เท่านั้น";
        document.getElementById('training_diploma_file').files[0] = undefined;
    }
</script>