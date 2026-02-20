<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการแอดมิน</title>
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
                                <div class="row align-items-center mt-4 px-2">
                                    <div class="col-md-3">
                                        <h4 class="mt-2 ml-3">ตารางข้อมูลแอดมินทั้งหมด</h4>
                                    </div>
                                    <div class="col-md-2">
                                        <select select class="form-control" id="role_select" onchange="getDatauserByProDisSub()">
                                            <option value="0">แอดมินทั้งหมด</option>
                                            <option value="1">แอดมินเจ้าของระบบ</option>
                                            <option value="7">แอดมินระดับภาค</option>
                                            <option value="6">แอดมินจังหวัด</option>
                                            <option value="2">แอดมินอำเภอ</option>
                                            <option value="3">แอดมินครู</option>
                                            <option value="5">บรรณารักษ์</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-body no-padding">

                                    <div class="row align-items-center px-2">
                                        <div class="col-md-2 mt-2">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="pro_name" id="pro_name" data-placeholder="เลือกจังหวัด" style="width: 100%;">
                                                    <option value="0">เลือกจังหวัด</option>
                                                </select>
                                                <input type="hidden" name="pro_name_text" id="pro_name_text" value="">
                                                <!-- <input type="text" class="form-control height-input" name="pro_name" id="pro_name" placeholder="กศน. จังหวัด"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-2">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="dis_name" id="dis_name" disabled data-placeholder="เลือกอำเภอ" style="width: 100%;">
                                                    <option value="0">เลือกอำเภอ</option>
                                                    <input type="hidden" name="dis_name_text" id="dis_name_text" value="">
                                                </select>
                                                <!-- <input type="text" class="form-control height-input" name="dis_name" id="dis_name" placeholder="กศน. อำเภอ"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-2" id="sub_dis" style="display: block;">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="sub_name" id="sub_name" disabled data-placeholder="เลือกตำบล" style="width: 100%;">
                                                    <option value="0">เลือกตำบล</option>
                                                </select>
                                                <!-- <input type="text" class="form-control height-input" name="sub_name" id="sub_name" placeholder="กศน. ตำบล"> -->
                                            </div>
                                        </div>
                                        <a class="col-md-2 mt-2 waves-effect waves-light btn btn-success btn-flat ml-2" onclick="gotoAdd()"><i class="ti-plus"></i>&nbsp;เพิ่มแอดมิน</a>

                                        <div class="col-md-2 ml-auto mt-1" style="min-width: 200px;">
                                            <input type="text" class="form-control" id="searchInput" placeholder="ค้นหาด้วยชื่อ" onkeyup="getDatauserByProDisSub()" />
                                        </div>
                                    </div>
                                    <table id="table" data-icons="icons" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/user_controller?getDataUsers=true">
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
    <script src="js/manage_admin_table.js?v=<?php echo rand(1, 99) ?>"></script>
    <?php include 'js/prodissub.js.php'; ?>
    <script>
        let pro = "0"
        let dis = "0"
        let sub = "0"
        $(document).ready(async function() {
            initTable()
            await getDataProDistSub();

            let pro_active = '<?php echo isset($_GET['pro']) ? $_GET['pro'] : '0' ?>'
            let dis_active = '<?php echo isset($_GET['dis']) ? $_GET['dis'] : '0' ?>'
            let sub_active = '<?php echo isset($_GET['sub']) ? $_GET['sub'] : '0' ?>'
            let page_number = '<?php echo isset($_GET['page_number']) ? $_GET['page_number'] : '0' ?>'

            $('#pro_name').select2()
            $('#dis_name').select2()
            $('#sub_name').select2()

            setTimeout(() => {
                if (pro_active != '0') {
                    $('#pro_name').val(pro_active).trigger('change');
                }
                if (dis_active != '0') {
                    $('#dis_name').val(dis_active).trigger('change');
                }
                if (sub_active != '0') {
                    $('#sub_name').val(sub_active).trigger('change');
                }
                if (page_number != '0') {
                    $table.bootstrapTable('refreshOptions', {
                        pageNumber: parseInt(page_number)
                    });
                }
            }, 1000)
            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        });

        $('#pro_name').on('change', (e) => getDistrictByProvince(e.target.value, getDatauserByProDisSub));
        $('#dis_name').on('change', (e) => getSubDistrictByDistrict(e.target.value, getDatauserByProDisSub));
        $('#sub_name').on('change', () => getDatauserByProDisSub());

        function gotoAdd() {
            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;
            location.href = `manage_admin_add?pro=${pro}&dis=${dis}&sub=${sub}&page_number=${currentPageNumber}`;
        }

        function gotoEdit(id) {
            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;
            location.href = `manage_admin_edit?user_id=${id}&pro=${pro}&dis=${dis}&sub=${sub}&page_number=${currentPageNumber}`;
        }

        const getDatauserByProDisSub = () => {
            let paramPlus = "";
            pro = $('#pro_name').val()
            dis = $('#dis_name').val()
            sub = $('#sub_name').val()
            let role_id = $('#role_select').val()
            let search = $('#searchInput').val()
            paramPlus += '&role_id=' + role_id;
            if (role_id == 1) {
                closeSelectOption(true)
            } else {
                closeSelectOption()
            }

            if (pro != 0) {
                paramPlus += '&province_id=' + pro;
            }
            if (dis != 0) {
                paramPlus += '&district_id=' + dis;
            }
            if (sub != 0) {
                paramPlus += '&subdistrict_id=' + sub;
            }
            if (search != "") {
                paramPlus += '&search=' + search;
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

        function deleteAdmin(id, name, edu_id_del) {
            const confirmDelete = confirm('ต้องการลบแอดมิน ' + name + ' หรือไม่?');
            const role_value = $('#role_value').val()
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/user_controller",
                    data: {
                        delete_admin: true,
                        id: id,
                        edu_id: edu_id_del
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