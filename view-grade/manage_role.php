<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-จัดการแอดมินครู</title>
    <style>
        .fixed-table-toolbar .bs-bars {
            width: 70%;
        }

        @media only screen and (max-width: 600px) {
            .pagination-detail .pagination {
                margin-left: 100px;
            }
        }

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
                                <div class="row align-items-center mt-4">
                                    <div class="col-md-3">
                                        <h4 class="mt-2 ml-3">ตารางข้อมูลแอดมินตำบลทั้งหมด</h4>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <input type="hidden" id="pro_name" value="0">
                                            <input type="hidden" id="dis_name" value="0">
                                            <select class="form-control select2" name="sub_name" id="sub_name" data-placeholder="เลือกตำบล" style="width: 100%;">
                                                <option value="0">เลือกตำบล</option>
                                            </select>
                                            <!-- <input type="text" class="form-control height-input" name="sub_name" id="sub_name" placeholder="กศน. ตำบล"> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <?php
                                    $pro_id = $_SESSION['user_data']->province_am_id;
                                    $dis_id = $_SESSION['user_data']->district_am_id;

                                    $role_json = json_decode($_SESSION['user_data']->status);
                                    ?>
                                    <!-- <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="../admin/controllers/user_controller?getDataUsers=true&role_id=3&province_id=<?php echo $pro_id; ?>&district_id=<?php echo $dis_id ?>" data-response-handler="responseHandler">
                                    </table> -->

                                    <table data-toggle="table" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" id="table" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="../admin/controllers/user_controller?getDataUsers=true&role_id=3&manageRole=1&province_id=<?php echo $pro_id; ?>&district_id=<?php echo $dis_id ?>" data-locale="th-TH">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" data-valign="middle" data-align="center" data-width="20px" data-formatter="autoNumberRow">ลำดับ</th>
                                                <th rowspan="2" data-field="concat_name" data-valign="middle" data-align="left" data-width="200px">ชื่อ-สกุล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                <th rowspan="2" data-valign="middle" data-align="left" data-formatter="formatEduName">สถานศึกษา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                <th rowspan="2" data-field="end_work" data-valign="middle" data-align="center" data-formatter="checkRoleFormat">สิทธิ์</th>
                                                <?php if (!empty($role_json->view_grade)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_1" class="filled-in" onchange="selectAll(this.checked,1,'view_grade')">
                                                            <label for="checkbox_th_1" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>
                                                <?php if (!empty($role_json->std_tracking)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_2" class="filled-in" onchange="selectAll(this.checked,2,'std_tracking')">
                                                            <label for="checkbox_th_2" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>
                                                <?php if (!empty($role_json->visit_online)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_3" class="filled-in" onchange="selectAll(this.checked,3, 'visit_online')">
                                                            <label for="checkbox_th_3" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->reading)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_4" class="filled-in" onchange="selectAll(this.checked,4, 'reading')">
                                                            <label for="checkbox_th_4" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->search)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_5" class="filled-in" onchange="selectAll(this.checked,5, 'search')">
                                                            <label for="checkbox_th_5" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->see_people)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_6" class="filled-in" onchange="selectAll(this.checked,6, 'see_people')">
                                                            <label for="checkbox_th_6" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->after)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_7" class="filled-in" onchange="selectAll(this.checked,7, 'after')">
                                                            <label for="checkbox_th_7" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->estimate)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_8" class="filled-in" onchange="selectAll(this.checked,8, 'estimate')">
                                                            <label for="checkbox_th_8" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->dashboard)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_9" class="filled-in" onchange="selectAll(this.checked,9, 'dashboard')">
                                                            <label for="checkbox_th_9" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->calendar_new)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_10" class="filled-in" onchange="selectAll(this.checked,10, 'calendar_new')">
                                                            <label for="checkbox_th_10" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->teach_more)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_11" class="filled-in" onchange="selectAll(this.checked,11, 'teach_more')">
                                                            <label for="checkbox_th_11" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->guide)) { ?>
                                                    <th data-valign="middle" data-align="center" class="selectAll">
                                                        เลือกทั้งคอลัมน์
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_th_12" class="filled-in" onchange="selectAll(this.checked,12, 'guide')">
                                                            <label for="checkbox_th_12" class="block"></label>
                                                        </div>
                                                    </th>
                                                <?php } ?>

                                                <th rowspan="2" data-valign="middle" data-align="center" data-formatter="formatButtonOperation">แก้ไข</th>
                                            </tr>
                                            <tr>
                                                <!-- <th data-valign="middle" data-align="center" data-width="20px" data-formatter="autoNumberRow">ลำดับ</th> -->
                                                <!-- <th data-field="concat_name" data-valign="middle" data-align="left" data-width="200px">ชื่อ-สกุล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> -->
                                                <!-- <th data-field="age" data-valign="middle" data-align="left" data-formatter="formatEduName">สถานศึกษา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> -->
                                                <!-- <th data-field="end_work" data-valign="middle" data-align="center">สิทธิ์</th> -->
                                                <?php if (!empty($role_json->view_grade)) { ?>
                                                    <th data-field="role_1" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter1">ระบบสืบค้นผลการเรียน</th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->std_tracking)) { ?>
                                                    <th data-field="role_2" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter2">ระบบฐานข้อมูลนักศึกษา</th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->visit_online)) { ?>
                                                    <th data-field="role_3" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter3">ระบบนิเทศการสอน</th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->reading)) { ?>
                                                    <th data-field="role_4" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter4">ระบบส่งเสริมการอ่าน</th>
                                                <?php } ?>
                                                <?php if (!empty($role_json->search)) { ?>
                                                    <th data-field="role_5" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter5">ทะเบียนผู้จบการศึกษา</th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->see_people)) { ?>
                                                    <th data-field="role_6" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter6">ฐานข้อมูลประชากรด้านการศึกษา</th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->after)) { ?>
                                                    <th data-field="role_7" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter7">แบบติดตามหลังจบการศึกษา</th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->estimate)) { ?>
                                                    <th data-field="role_8" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter8">ประเมินคุณธรรมนักศึกษา</th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->dashboard)) { ?>
                                                    <th data-field="role_9" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter9">แดชบอร์ดภาพรวมข้อมูล</th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->calendar_new)) { ?>
                                                    <th data-field="role_10" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter10">Smart Coach Room</th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->teach_more)) { ?>
                                                    <th data-field="role_11" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter11">การสอนเสริม</th>
                                                <?php } ?>

                                                <?php if (!empty($role_json->guide)) { ?>
                                                    <th data-field="role_12" data-valign="middle" data-align="center" data-formatter="inputCheckboxFormatter12">ห้องแนะแนวและให้คำปรึกษา</th>
                                                <?php } ?>
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
    <?php include '../admin/js/prodissub.js.php'; ?>
    <script>
        let role_of_am = '<?php echo $_SESSION['user_data']->status ?>';
        role_of_am = JSON.parse(role_of_am);
        console.log("==>", role_of_am);
        let pro = "0"
        let dis = "0"
        let sub = "0"
        $(document).ready(async function() {
            // initTable()
            allRowCheck = await getCurrentRowCount()

            await getDataProDistSub();

            let sub_active = '<?php echo isset($_GET['sub']) ? $_GET['sub'] : '0' ?>'
            let page_number = '<?php echo isset($_GET['page_number']) ? $_GET['page_number'] : '0' ?>'

            $('#sub_name').select2()

            setTimeout(() => {
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

        async function getDistrictDataAmphur() {
            return Promise.resolve($.ajax({
                type: "POST",
                url: "../student-tracking/controllers/dashboard_controller",
                data: {
                    getDistrictDataAmphur: true,
                },
                dataType: "json",
            }));
        }

        let main_provinces = null;
        let main_district = null;
        let main_sub_district_id = null;

        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "../student-tracking/controllers/user_controller",
                data: {
                    getDataProDistSub: true
                },
                dataType: "json",
                success: async function(json_data) {
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district_id = json_data.data.sub_district;

                    if (role_id == 2) {
                        let dis_data;
                        await getDistrictDataAmphur().then((result) => {
                            dis_data = result.data[0]
                        })
                        const sub_name = document.getElementById('sub_name');
                        sub_name.innerHTML = "";
                        sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
                        $('#dis_name').val(dis_data.dis_id);
                        const sub_district = main_sub_district_id.filter((sub) => {
                            return sub.district_id == dis_data.dis_id
                        })
                        sub_district.forEach((element, id) => {
                            sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                        });
                    }
                },
            });
        }

        $('#sub_name').on('change', () => getDatauserByProDisSub());

        function gotoAdd() {
            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;
            location.href = `am_manage_teacher_add?dis=<?php echo $dis_id ?>&sub=${sub}&page_number=${currentPageNumber}`;
        }

        function gotoEdit(id) {
            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;
            location.href = `am_manage_teacher_edit?user_id=${id}&pro=${pro}&dis=${dis}&sub=${sub}&page_number=${currentPageNumber}&url=manage_role`;
        }

        const getDatauserByProDisSub = () => {
            let paramPlus = "";
            pro = $('#pro_name').val()
            dis = $('#dis_name').val()
            sub = $('#sub_name').val()
            let role_id = 3;
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
            var urlWithParams = $table.data('url') + paramPlus;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }

        function closeSelectOption(status = false) {
            if (status) {
                $('#sub_name').val(0).trigger('change.select2');
                sub_name.setAttribute("disabled", status)
            }
        }

        function updateRole(id, role, value, input = null) {
            $.ajax({
                type: "POST",
                url: "../admin/controllers/user_controller",
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