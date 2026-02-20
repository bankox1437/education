<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แบบบันทึกข้อมูลนักศึกษารายบุคคล</title>
    <style>
        #table td {
            padding: 5px 10px;
        }

        .fixed-table-toolbar {
            padding: 0 !important;
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
                                <!-- <div class="box-header with-border">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <h4 class="box-title">ข้อมูลนักศึกษารายบุคคล</h4>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control" id="class_dropdown" onchange="getDataByWhere()">
                                            </select>
                                        </div>
                                        <?php if ($_SESSION['user_data']->role_id != 3 && $_SESSION['user_data']->edu_type != 'edu_other') { ?>
                                            <div class="col-md-2">
                                                <select class="form-control" id="subdistrict_select" onchange="getDataByWhere()">
                                                </select>
                                            </div>
                                        <?php }

                                        if ($_SESSION['user_data']->role_id == 3) { ?>
                                            <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="form1_1_add"><i class="ti-plus"></i>&nbsp;ข้อมูลนักศึกษา</a>
                                        <?php } ?>
                                    </div>
                                </div> -->
                                <div class="box-header with-border">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <h4 class="box-title">ข้อมูลนักศึกษารายบุคคล</h4>
                                        </div>
                                    </div>
                                    <div class="row mt-3 align-items-center">
                                        <?php
                                        if ($_SESSION['user_data']->role_id == 1) { ?>
                                            <div class="col-md-2">
                                                <select class="form-control select2" id="province_select" style="width: 100%;">
                                                    <option value="0">เลือกจังหวัด</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-control select2" id="district_select" style="width: 100%;">
                                                    <option value="0">เลือกอำเภอ</option>
                                                </select>
                                            </div>
                                        <?php } ?>
                                        <?php if ($_SESSION['user_data']->role_id != 3 && $_SESSION['user_data']->edu_type != 'edu_other') { ?>
                                            <div class="col-md-2">
                                                <select class="form-control select2" id="subdistrict_select" style="width: 100%;">
                                                    <option value="0">เลือกตำบล</option>
                                                </select>
                                                <input type="hidden" name="district_select_value" id="district_select_value" value="">
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-2">
                                            <select class="form-control" id="class_dropdown">
                                            </select>
                                        </div>
                                        <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                            <!-- <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="#" id="filter-data"><i class="ti-search"></i>&nbsp;ค้นหา</a> -->
                                            <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="form1_1_new_add"><i class="ti-plus"></i>&nbsp;ข้อมูลนักศึกษา</a>
                                        <?php } else { ?>
                                            <!-- <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="#" id="filter-data"><i class="ti-search"></i>&nbsp;ค้นหา</a> -->
                                            <a class="waves-effect waves-light btn btn-primary btn-flat ml-2" href="#" id="show-all"><i class="ti-search"></i>&nbsp;ทั้งหมด</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <!-- <div class="table-responsive">
                                        <table class="table table-hover" style="font-size: 14px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">ลำดับ</th>
                                                    <th>รหัสนักศึกษา</th>
                                                    <th>ชื่อ - สกุล</th>
                                                    <th>ชั้น</th>
                                                    <th>ผู้บันทึก</th>
                                                    <th>สถานศึกษา</th>
                                                    <?php if ($_SESSION['user_data']->role_id != 3 && ($_SESSION['user_data']->edu_type != 'edu_other')) { ?>
                                                        <th>ตำบล</th>
                                                        <th>อำเภอ</th>
                                                        <th>จังหวัด</th>
                                                    <?php } ?>
                                                    <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                        <th class="text-center">วิเคราะห์ผู้เรียน</th>
                                                    <?php  } ?>
                                                    <th class="text-center">พิมพ์ PDF</th>
                                                    <?php if ($_SESSION['user_data']->role_id != 2) { ?>
                                                        <th class="text-center">แก้ไข</th>
                                                        <th class="text-center">ลบ</th>
                                                    <?php  } ?>
                                                </tr>
                                            </thead>
                                            <tbody id="data-student">
                                            </tbody>
                                        </table>
                                    </div> -->

                                    <table id="table" data-icons="icons" data-search="false" data-show-refresh="false" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/form_student_person_controller?getStudentPersonBS=true">
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

    <!-- <script type = "text/javascript" src="assets/js/view_js/form_1.1.js"></script> -->
    <script src="js/form_1.1.new.js?v=<?php echo $version ?>"></script>
    <script>
        $(document).ready(async function() {
            initTable();
            getClassInDropdown(
                "getClassInDropdown",
                "controllers/form_student_person_controller"
            ); // get class
            await getDataProDistSub();
            if (role_id == 2) {
                $('#subdistrict_select').select2()
            }
            if (role_id == 1) {
                $('#province_select').select2()
                $('#district_select').select2()
                $('#subdistrict_select').select2()
            }

            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        });

        function deleteStudent(id, name) {
            const confirmDelete = confirm("ต้องการลบนักศึกษาชื่อ " + name + " หรือไม่?");
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/form_student_person_controller",
                    data: {
                        delete_student: true,
                        id: id,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            $table.bootstrapTable('refresh');
                        } else {
                            alert(data.msg);
                        }
                    },
                });
            }
        }

        async function getDistrictDataAmphur() {
            return Promise.resolve($.ajax({
                type: "POST",
                url: "controllers/dashboard_controller",
                data: {
                    getDistrictDataAmphur: true,
                },
                dataType: "json",
            }));
        }
        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true,
                    table: 'stf_tb_form_student_person_new'
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
                        let dis_data;
                        await getDistrictDataAmphur().then((result) => {
                            dis_data = result.data[0]
                        })
                        const sub_name = document.getElementById('subdistrict_select');
                        sub_name.innerHTML = "";
                        sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
                        $('#district_select_value').val(dis_data.dis_id);
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

        $('#province_select').change((e) => {
            getDataByWhere()
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
            getDataByWhere()
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

        // $('#filter-data').click(() => getDataByWhere())
        $('#subdistrict_select').change((e) => {
            getDataByWhere()
        })

        $('#class_dropdown').change((e) => {
            getDataByWhere()
        })

        $('#show-all').click(() => {
            // getStudentPerson();
            $("#province_select").val(0).change();
            $("#district_select").val(0).change();
            $("#subdistrict_select").val(0).change();
            $("#class_dropdown").val(0).change();
            getDataByWhere()
        });

       
        function getDataByWhere() {
            const pro_id = $('#province_select').val() ?? 0
            const dis_id = $('#district_select').val() ?? 0
            const sub_dis_id = $('#subdistrict_select').val() ?? 0
            const std_class = $('#class_dropdown').val() ?? "";

            var urlWithParams = $table.data('url') + `&pro_id=${pro_id}&dis_id=${dis_id}&sub_dis_id=${sub_dis_id}&std_class=${std_class}`;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
            $table.bootstrapTable('refresh');
        }
    </script>
</body>

</html>