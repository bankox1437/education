<div class="col-lg-6 col-12">
    <div class="box">
        <!-- /.box-header -->
        <div class="form">
            <div class="box-body p-0">
                <div style="padding: 1.5rem 1.5rem 0">
                    <h4 class="box-title text-info mb-0">เครือข่ายในชุมชน</h4>
                    <hr class="my-15" style="margin-bottom: 0px !important;">
                </div>
                <?php if (!$isRead) { ?>
                    <div class="row" style="padding: 1rem 1.5rem 0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ชื่อเครือข่าย <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" id="community_name" autocomplete="off" placeholder="กรอกชื่อเครือข่าย">
                                <input type="hidden" id="community_id" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="margin-top: 24px;">
                                <button type="button" class="btn btn-rounded btn-primary btn-outline" onclick="submitCommunity()">
                                    <i class="ti-save-alt"></i> บันทึกเครือข่ายในชุมชน
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="table-responsive">
                    <table id="info_community" data-height="300" data-toggle="table" data-minimum-count-columns="2" data-url="controllers/info_controller?getCommunityData=true<?php echo $isRead ? '&user_id=' . $_GET['user_id'] : '' ?>" data-locale="th-TH">
                        <thead>
                            <tr>
                                <th data-field="community_name" data-valign="middle" data-align="center" data-width="250px">เรื่อง</th>
                                <?php if (!$isRead) { ?>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonEditCommunity">แก้ไข</th>
                                    <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonDeleteCommunity">ลบ</th>
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
    const $info_community = $("#info_community");

    function formatButtonEditCommunity(data, row) {
        let html = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"
                    onclick="editCommunity(${row.community_id},'${row.community_name}')"></i></button>`;
        return html;
    }

    function formatButtonDeleteCommunity(data, row) {
        let html = `<button type="button" onclick="deleteCommunity(${row.community_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
        return html;
    }

    function submitCommunity() {
        let community_id = $('#community_id').val();
        let community_name = $('#community_name').val();

        if ($('#community_name').val() == '') {
            alert(`โปรด${$('#community_name').attr('placeholder')}`);
            $('#community_name').focus();
            return false; // This stops the .each loop
        }

        let formData = new FormData();
        formData.append("community_id", community_id);
        formData.append("community_name", community_name);
        formData.append("update_community", true);

        $.ajax({
            type: "POST",
            url: "controllers/info_controller",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: async function(response) {
                if (response == 1) {
                    alert("บันทึกเครือข่ายในชุมชนสำเร็จ");
                    $info_community.bootstrapTable('refresh');
                    resetInputCommunity()
                }
            },
        });
    }

    function deleteCommunity(community_id) {
        if (confirm('ต้องการลบเครือข่ายในชุมชนนี้หรือไม่?')) {
            $.ajax({
                type: "POST",
                url: "controllers/info_controller",
                data: {
                    deleteCommunity: true,
                    community_id: community_id
                },
                success: async function(response) {
                    if (response == 1) {
                        alert("ลบเครือข่ายในชุมชนสำเร็จ");
                        $info_community.bootstrapTable('refresh');
                    }
                },
            });
        }
    }

    function editCommunity(community_id, community_name) {
        $('#community_id').val(community_id);
        $('#community_name').val(community_name);
    }

    function resetInputCommunity() {
        $('#community_id').val('');
        $('#community_name').val('');
    }
</script>