<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการคะแนนสอบแต่ละเทอม</title>
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
                                <div class="box-body no-padding">
                                    <div id="toolbar" class="row">
                                        <div class="col-12 row align-items-center">
                                            <h4 class="col-md-4">ข้อมูลคะแนนสอบแต่ละเทอม</h4>
                                            <div class="col-md-4">
                                                <select class="form-control" id="format" onchange="getBywhere()">
                                                    <option value="0">รายบุคคล</option>
                                                    <option value="1">ระดับชั้น</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control " id="term_name" onchange="getBywhere()">
                                                    <option value="0">ปีการศึกษาทั้งหมด &nbsp;&nbsp;</option>
                                                    <?php foreach ($_SESSION['term_data'] as $value) { ?>
                                                        <?php $selected = ($value->term_id == $_SESSION['term_active']->term_id) ? 'selected' : ''; ?>
                                                        <?php $current = ($value->term_id == $_SESSION['term_active']->term_id) ? ' (ปัจจุบัน)' : ''; ?>
                                                        <option value="<?php echo $value->term_id ?>" <?php echo $selected ?>><?php echo $value->term_name . $current ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="manage_test_grade_add"><i class="ti-plus"></i>&nbsp;เพิ่มคะแนนสอบ</a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-12 row align-items-center">
                                            <?php
                                            if ($_SESSION['user_data']->role_id == 1) { ?>
                                                <div class="col-md-4 mt-2">
                                                    <select class="form-control select2" id="province_select" style="width: 100%;" onchange="getBywhere()">
                                                        <option value="0">เลือกจังหวัด</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <select class="form-control select2" id="district_select" style="width: 100%;" onchange="getBywhere()">
                                                        <option value="0">เลือกอำเภอ</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2" id="sub_dis">
                                                    <select class=" form-control select2" id="subdistrict_select" style="width: 100%;" onchange="getBywhere()">
                                                        <option value="0">เลือกตำบล</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/test_grade_controller?getDataTestGrade=true">
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
        <button type="button" class="btn btn-primary" id="click-show-modal" data-toggle="modal" data-target="#modal-fill" style="visibility: hidden;">
        </button>
        <!-- Modal -->
        <div class="modal modal-fill fade" data-backdrop="false" id="modal-fill" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content text-center">
                    <div class="">
                        <h2 class="modal-title m-0 text-danger"><b>แจ้งเตือน</b></h2>
                    </div>
                    <div class="modal-body">
                        <h2>ท่านจะยังไม่สามารถใช้งานระบบได้ เนื่องจาก</h2>
                        <h2>แอดมินอำเภอยังไม่ได้ตั้งค่าปีการศึกษา</h2>
                        <br>
                        <h2>โปรดติดต่อแอดมินอำเภอหรือแอดมินระบบ</h2>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-danger" onclick="logout()">ออกจากระบบ</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->
        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script src="js/init-table/manage_test_grade.js?v=<?php echo $version ?>"></script>

    <script>
        $(document).ready(async function() {
            checkRoleSystem("view-grade") 
            <?php if (!isset($_SESSION['term_active']) && $_SESSION['user_data']->role_id == 3) { ?>
                document.getElementById("click-show-modal").click();
            <?php } ?>
            initTable()
            await getDataProDistSub();
            if (role_id == 1) {
                $('#province_select').select2()
                $('#district_select').select2()
                $('#subdistrict_select').select2()
            }
            $('.search input').attr('placeholder', 'ค้นหาด้วยชื่อหรือรหัส นศ.');
            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });

            // Assuming you have a select input with id="format"
            $('#format').change(function() {
                var selectedValue = $(this).val();
                toggleColumnVisibility('std_class', selectedValue == 1);
            });

            function toggleColumnVisibility(columnField, isVisible) {
                $table.bootstrapTable('hideColumn', columnField);
                if (isVisible) {
                    $table.bootstrapTable('showColumn', columnField);
                }
            }
        });

        function getByFormat(format) {
            var urlWithParams = $table.data('url') + '&format=' + format;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }

        function getByTerm(term_id) {
            var urlWithParams = $table.data('url') + '&term_id=' + term_id;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }

        function getBywhere() {
            const pro_id = $('#province_select').val() ?? 0
            const dis_id = $('#district_select').val() ?? 0
            const sub_dis_id = $('#subdistrict_select').val() ?? 0
            const format = $('#format').val() ?? 0;
            const term_id = $('#term_name').val() ?? 0;

            var urlWithParams = $table.data('url') + `&pro_id=${pro_id}&dis_id=${dis_id}&sub_dis_id=${sub_dis_id}` +
                '&format=' + format + '&term_id=' + term_id;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
            $table.bootstrapTable('refresh');

        }

        function deleteTestGrade(grade_id, file_name) {
            const confirmDelete = confirm('ต้องการลบรายการนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/test_grade_controller",
                    data: {
                        deleteTestGrade: true,
                        grade_id: grade_id,
                        file_name: file_name
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

        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true,
                    table: "vg_test_grade"
                },
                dataType: "json",
                success: async function(json_data) {
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district_id = json_data.data.sub_district;
                    if (role_id == 1) {
                        const province_select = document.getElementById('province_select');
                        main_provinces.forEach((element, id) => {
                            province_select.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                        });
                    }

                    if (role_id == 2) {
                        let dis_id = '<?php echo $_SESSION['user_data']->district_am_id ?>';
                        const sub_name = document.getElementById('subdistrict_select');
                        sub_name.innerHTML = "";
                        sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
                        $('#district_select_value').val(dis_id);
                        const sub_district = main_sub_district_id.filter((sub) => {
                            return sub.district_id == dis_id
                        })
                        sub_district.forEach((element, id) => {
                            sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                        });
                    }
                },
            });
        }

        $('#province_select').change((e) => {
            getDistrictByProvince(e.target.value)
        })

        function getDistrictByProvince(pro_id) {
            const district_select = document.getElementById('district_select');
            district_select.innerHTML = "";
            district_select.innerHTML += ` <option value="0">เลือกอำเภอ</option>`;
            const sub_name = document.getElementById('subdistrict_select');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
            const district = main_district.filter((dist) => {
                return dist.province_id == pro_id
            })
            district.forEach((element) => {
                district_select.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
            });
        }
        $('#district_select').change((e) => {
            getSubDistrictByDistrict(e.target.value)
        })
        async function getSubDistrictByDistrict(dist_id) {
            const sub_name = document.getElementById('subdistrict_select');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
            const sub_district = main_sub_district_id.filter((sub) => {
                return sub.district_id == dist_id
            })
            sub_district.forEach((element, id) => {
                sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
            });
        }

        function getDataByAddress() {
            const pro_id = $('#province_select').val() ?? 0
            const dis_id = $('#district_select').val() ?? 0
            const sub_dis_id = $('#subdistrict_select').val() ?? 0
            var urlWithParams = $table.data('url') + `&pro_id=${pro_id}&dis_id=${dis_id}&sub_dis_id=${sub_dis_id}`;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }

        function checkRoleSystem(system, url = "") {
            let systemText = "";
            let systemTitle = "";

            if (system === 'visit-online') {
                systemText = "visit_online";
                systemTitle = "ระบบนิเทศการสอน ติดตามการปฏิบัติงาน";
            } else if (system === 'student-tracking') {
                systemText = "std_tracking";
                systemTitle = "ระบบฐานข้อมูลนักศึกษา";
            } else if (system === 'reading') {
                systemText = "reading";
                systemTitle = "หัวข้อส่งเสริมการอ่าน";
            } else if (system === 'view-grade') {
                systemText = "view_grade";
                systemTitle = "ระบบสืบค้นผลการเรียน";
            } else if (system === 'after') {
                systemText = "after";
                systemTitle = "หัวข้อแบบติดตามหลังจบการศึกษา";
            } else if (system === 'search') {
                systemText = "search";
                systemTitle = '<?php echo isset($_SESSION['index_menu']) && $_SESSION['index_menu'] == 5 ? "หัวข้อสืบค้นวุฒิการศึกษา" : "หัวข้อทะเบียนผู้จบการศึกษา" ?>';
            } else if (system === 'see_people') {
                systemText = "see_people";
                systemTitle = "หัวข้อฐานข้อมูลประชากรด้านการศึกษา";
            } else if (system === 'estimate') {
                systemText = "estimate";
                systemTitle = "หัวข้อประเมินคุณธรรมนักศึกษา";
            }

            $.ajax({
                type: "POST",
                url: "../checkSystem",
                data: {
                    mode: 'checkSystem',
                    systemText: systemText
                },
                success: function(data) {
                    if (data != "") {
                        let dataJson = JSON.parse(data);
                        if (!dataJson.status) {
                            alert("ไม่สามารถใช้งานเมนูได้ เนื่องจากแอดมินระบบไม่ได้เปิดสิทธิ์ใช้งาน\n" + systemTitle + " ให้กับคุณ \nโปรดติดต่อแอดมินระบบ")
                            location.href = '../main_menu';
                        }
                    }
                }
            });

            return false;
        }
    </script>
</body>

</html>