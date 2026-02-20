<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?><title>จัดการสิทธิ์ผู้ใช้</title>
    <style>
        .c-inputs-stacked label {
            padding-left: 20px;
            margin-bottom: -5px;
        }
    </style>
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
                                            <option value="2">แอดมินอำเภอ</option>
                                            <option value="3">แอดมินครู</option>
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
                                        <div class="col-md-2 ml-auto mt-1" style="min-width: 200px;">
                                            <input type="text" class="form-control" id="searchInput" placeholder="ค้นหาด้วยชื่อ" onkeyup="getDatauserByProDisSub()" />
                                        </div>
                                    </div>
                                    <!-- <table id="table" class="table table-striped" data-checkbox-header="false" data-click-to-select="true" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/user_controller?getDataUsers=true" data-response-handler="responseHandler">
                                    </table> -->
                                    <table data-toggle="table" data-icons="icons" id="table" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/user_controller?getDataUsers=true&manageRole=1" data-locale="th-TH">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" data-valign="middle" data-align="center" data-width="20px" data-formatter="autoNumberRow">ลำดับ</th>
                                                <th rowspan="2" data-field="concat_name" data-valign="middle" data-align="left" data-width="200px">ชื่อ-สกุล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                <th rowspan="2" data-valign="middle" data-align="left" data-formatter="formatEduName">สถานศึกษา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                <th rowspan="2" data-field="end_work" data-valign="middle" data-align="center" data-formatter="checkRoleFormat">สิทธิ์</th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_1" class="filled-in" onchange="selectAll(this.checked,1,'view_grade')">
                                                        <label for="checkbox_th_1" class="block"></label>
                                                    </div>
                                                </th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_2" class="filled-in" onchange="selectAll(this.checked,2,'std_tracking')">
                                                        <label for="checkbox_th_2" class="block"></label>
                                                    </div>
                                                </th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_3" class="filled-in" onchange="selectAll(this.checked,3, 'visit_online')">
                                                        <label for="checkbox_th_3" class="block"></label>
                                                    </div>
                                                </th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_4" class="filled-in" onchange="selectAll(this.checked,4, 'reading')">
                                                        <label for="checkbox_th_4" class="block"></label>
                                                    </div>
                                                </th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_5" class="filled-in" onchange="selectAll(this.checked,5, 'search')">
                                                        <label for="checkbox_th_5" class="block"></label>
                                                    </div>
                                                </th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_6" class="filled-in" onchange="selectAll(this.checked,6, 'see_people')">
                                                        <label for="checkbox_th_6" class="block"></label>
                                                    </div>
                                                </th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_7" class="filled-in" onchange="selectAll(this.checked,7, 'after')">
                                                        <label for="checkbox_th_7" class="block"></label>
                                                    </div>
                                                </th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_8" class="filled-in" onchange="selectAll(this.checked,8, 'estimate')">
                                                        <label for="checkbox_th_8" class="block"></label>
                                                    </div>
                                                </th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_9" class="filled-in" onchange="selectAll(this.checked,9, 'dashboard')">
                                                        <label for="checkbox_th_9" class="block"></label>
                                                    </div>
                                                </th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_10" class="filled-in" onchange="selectAll(this.checked,10, 'calendar_new')">
                                                        <label for="checkbox_th_10" class="block"></label>
                                                    </div>
                                                </th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_11" class="filled-in" onchange="selectAll(this.checked,11, 'teach_more')">
                                                        <label for="checkbox_th_11" class="block"></label>
                                                    </div>
                                                </th>
                                                <th data-valign="middle" data-align="center" class="selectAll">
                                                    เลือกทั้งคอลัมน์
                                                    <div class="c-inputs-stacked">
                                                        <input type="checkbox" id="checkbox_th_12" class="filled-in" onchange="selectAll(this.checked,12, 'guide')">
                                                        <label for="checkbox_th_12" class="block"></label>
                                                    </div>
                                                </th>
                                                <th rowspan="2" data-valign="middle" data-align="center" data-formatter="formatButtonOperation">แก้ไข</th>
                                            </tr>
                                            <tr>
                                                <!-- <th data-valign="middle" data-align="center" data-width="20px" data-formatter="autoNumberRow">ลำดับ</th> -->
                                                <!-- <th data-field="concat_name" data-valign="middle" data-align="left" data-width="200px">ชื่อ-สกุล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> -->
                                                <!-- <th data-field="age" data-valign="middle" data-align="left" data-formatter="formatEduName">สถานศึกษา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> -->
                                                <!-- <th data-field="end_work" data-valign="middle" data-align="center">สิทธิ์</th> -->
                                                <th data-field="role_1" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter1">ระบบสืบค้นผลการเรียน</th>
                                                <th data-field="role_2" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter2">ระบบฐานข้อมูลนักศึกษา</th>
                                                <th data-field="role_3" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter3">ระบบนิเทศการสอน</th>
                                                <th data-field="role_4" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter4">ระบบส่งเสริมการอ่าน</th>
                                                <th data-field="role_5" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter5">ทะเบียนผู้จบการศึกษา</th>
                                                <th data-field="role_6" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter6">ฐานข้อมูลประชากรด้านการศึกษา</th>
                                                <th data-field="role_7" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter7">แบบติดตามหลังจบการศึกษา</th>
                                                <th data-field="role_8" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter8">ประเมินคุณธรรมนักศึกษา</th>
                                                <th data-field="role_9" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter9">แดชบอร์ดภาพรวมข้อมูล</th>
                                                <th data-field="role_10" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter10">Smart Coach Room</th>
                                                <th data-field="role_11" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter11">การสอนเสริม</th>
                                                <th data-field="role_12" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter12">ห้องแนะแนวและให้คำปรึกษา</th>
                                            </tr>
                                        </thead>
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
    <script src="js/manage_role.js?v=<?php echo $version ?>"></script>
    <?php include 'js/prodissub.js.php'; ?>
    <script>
        let pro = "0"
        let dis = "0"
        let sub = "0"

        $(document).ready(async function() {
            // initTable()
            allRowCheck = await getCurrentRowCount()

            await getDataProDistSub();

            let pro_active = '<?php echo isset($_GET['pro']) ? $_GET['pro'] : '0' ?>'
            let dis_active = '<?php echo isset($_GET['dis']) ? $_GET['dis'] : '0' ?>'
            let sub_active = '<?php echo isset($_GET['sub']) ? $_GET['sub'] : '0' ?>'
            let page_number = '<?php echo isset($_GET['page_number']) ? $_GET['page_number'] : '0' ?>'

            $('#pro_name').select2()
            $('#dis_name').select2()
            $('#sub_name').select2()

            setTimeout(async () => {
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
                } else {
                    setCheckedSekectedAll()
                }
            }, 1000)
            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });

            $('#pro_name').on('change', (e) => getDistrictByProvince(e.target.value, getDatauserByProDisSub));
            $('#dis_name').on('change', (e) => getSubDistrictByDistrict(e.target.value, getDatauserByProDisSub));
            $('#sub_name').on('change', () => getDatauserByProDisSub());
        });

        $('#table').on('pre-body.bs.table', function() {
            resetData()
        });

        $('#table').on('load-success.bs.table', async function(e, data) {
            allRowCheck = await getCurrentRowCount()
            setCheckedSekectedAll()
        });

        async function getCurrentRowCount() {
            return new Promise(function(resolve, reject) {
                let rowCount = 0;
                setTimeout(() => {
                    rowCount = $('#table tbody tr').length;
                    resolve(rowCount);
                }, 500);

            })
        }

        async function setCheckedSekectedAll() {
            for (const element in allRoleCounts) {
                let roleCount = allRoleCounts[element];
                if (roleCount == allRowCheck) {
                    //checkbox_th_?
                    $("#" + element).attr("checked", true);
                } else {
                    $("#" + element).attr("checked", false);
                }
            }
        }

        function gotoAdd() {
            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;
            location.href = `manage_admin_add?pro=${pro}&dis=${dis}&sub=${sub}&page_number=${currentPageNumber}`;
        }

        function gotoEdit(id) {
            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;
            location.href = `manage_admin_edit?user_id=${id}&pro=${pro}&dis=${dis}&sub=${sub}&page_number=${currentPageNumber}&role=`;
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

        function updateRole(id, role, value, input = null) {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    update_role_only: true,
                    id: id,
                    role: role,
                    value: value
                },
            });
            let role_id = input ? $(input).attr('class').split(" ")[1].split('_')[1] : 0;
            if (role_id != 0) {
                if (value) {
                    allRoleCounts['checkbox_th_' + role_id] = allRoleCounts['checkbox_th_' + role_id] + 1;
                } else {
                    allRoleCounts['checkbox_th_' + role_id] = allRoleCounts['checkbox_th_' + role_id] - 1;
                }
                setCheckedSekectedAll();
            }

        }

        function selectAll(status, role_id, role_name) {
            // const th = $('.table').find('tr').eq(0).find('th').eq(4);
            $('.role_' + role_id).each(function(index, ele) {
                const userId = $(ele).attr('data-id');
                $(ele).attr('checked', status);
                updateRole(userId, role_name, status)
            });
        }
    </script>
</body>

</html>