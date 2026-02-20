<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ดูรายการข้อมูลซ้ำ</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php include 'include/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <input type="hidden" id="role_value" value="0">
                                <div class="row align-items-center mt-4">
                                    <div class="col-md-3">
                                        <h4 class="mt-2 ml-3">ตารางดูรายการข้อมูลซ้ำ</h4>
                                    </div>
                                </div>
                                <div class="box-body no-padding">

                                    <div id="toolbar" class="row align-items-center">
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="pro_name" id="pro_name" data-placeholder="เลือกจังหวัด" style="width: 100%;">
                                                    <option value="0">เลือกจังหวัด</option>
                                                </select>
                                                <input type="hidden" name="pro_name_text" id="pro_name_text" value="">
                                                <!-- <input type="text" class="form-control height-input" name="pro_name" id="pro_name" placeholder="กศน. จังหวัด"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="dis_name" id="dis_name" disabled data-placeholder="เลือกอำเภอ" style="width: 100%;">
                                                    <option value="0">เลือกอำเภอ</option>
                                                    <input type="hidden" name="dis_name_text" id="dis_name_text" value="">
                                                </select>
                                                <!-- <input type="text" class="form-control height-input" name="dis_name" id="dis_name" placeholder="กศน. อำเภอ"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-2" id="sub_dis" style="display: block;">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="sub_name" id="sub_name" disabled data-placeholder="เลือกตำบล" style="width: 100%;">
                                                    <option value="0">เลือกตำบล</option>
                                                </select>
                                                <!-- <input type="text" class="form-control height-input" name="sub_name" id="sub_name" placeholder="กศน. ตำบล"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="filter_dup" id="filter_dup" data-placeholder="เลือกตำบล" style="width: 100%;">
                                                    <option value="1">เลข ปชช./ชื่อผู้ใช้</option>
                                                    <option value="2">ชื่อ-สกุล</option>
                                                </select>
                                                <!-- <input type="text" class="form-control height-input" name="sub_name" id="sub_name" placeholder="กศน. ตำบล"> -->
                                            </div>
                                        </div>
                                    </div>
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="false" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/user_controller?getDataUserDuplicate=true" data-response-handler="responseHandler">
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </section>
                <!-- /.content -->
                <div class="preloader">
                    <?php include "../include/loader_include.php"; ?>
                </div>

            </div>
        </div>
        <!-- /.content-wrapper -->

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script src="js/view_duplicate_data.js?v=<?php echo $version ?>"></script>
    <?php include 'js/prodissub.js.php'; ?>
    <script>
        $(document).ready(async function() {
            initTable()
            await getDataProDistSub();
            $('#pro_name').select2()
            $('#dis_name').select2()
            $('#sub_name').select2()

            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                console.log($(this).data('select2').$dropdown.find('.select2-search__field'));
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        });

        $('#pro_name').on('change', (e) => getDistrictByProvince(e.target.value, getDatauserByProDisSub));
        $('#dis_name').on('change', (e) => getSubDistrictByDistrict(e.target.value, getDatauserByProDisSub));
        $('#sub_name').on('change', () => getDatauserByProDisSub());
        $('#filter_dup').on('change', () => getDatauserByProDisSub());

        const getDatauserByProDisSub = () => {
            let paramPlus = "";
            let pro = $('#pro_name').val()
            let dis = $('#dis_name').val()
            let sub = $('#sub_name').val()
            let filter_dup = $('#filter_dup').val()
            paramPlus += '&filter_dup=' + filter_dup;

            if (pro != 0) {
                paramPlus += '&province_id=' + pro;
            }
            if (dis != 0) {
                paramPlus += '&district_id=' + dis;
            }
            if (sub != 0) {
                paramPlus += '&subdistrict_id=' + sub;
            }
            var urlWithParams = $table.data('url') + paramPlus;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }

        function closeSelectOption(status = false) {
            if (status) {
                $('#pro_name').val(0).trigger('change.select2');
                $('#dis_name').val(0).trigger('change.select2');
                $('#sub_name').val(0).trigger('change.select2');
                pro_name.setAttribute("disabled", status)
                dis_name.setAttribute("disabled", status)
                sub_name.setAttribute("disabled", status)
            } else {
                pro_name.removeAttribute("disabled")
            }
        }

        function deleteDup(username) {
            const confirmDelete = confirm('ต้องการ ลบ รายการที่ซ้ำกันทั้งหมดหรือไม่?');
            const role_value = $('#role_value').val()
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/user_controller",
                    data: {
                        delete_dup: true,
                        username: username
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            $table.bootstrapTable('refresh');
                        } else {
                            alert(data.msg)
                        }
                    },
                });
            }
        }
    </script>
</body>

</html>