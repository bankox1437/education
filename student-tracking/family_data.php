<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลประชากรด้านการศึกษา</title>
    <style>
        #table td {
            padding: 1px 5px;
        }

        .input-group-text {
            cursor: pointer;
        }

        .input-group-text:hover {
            background-color: #3c2bc1;
            color: #ffffff;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php //include 'include/sidebar.php'; 
        ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <?php
                $main_func = new ClassMainFunctions();

                $searchSession = isset($_SESSION['search_param_gradiate']) ? $_SESSION['search_param_gradiate'] : '';
                $searchSession = $main_func->decryptData($searchSession);

                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row align-items-center">
                                        <h4 class="box-title">ข้อมูลประชากรด้านการศึกษา</h4>
                                        <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                            <a class="col-md-2 waves-effect waves-light btn btn-success btn-flat ml-2 my-2" href="family_data_add"><i class="ti-plus"></i>&nbsp;บันทึกข้อมูล</a>
                                        <?php } ?>
                                    </div>
                                    <div class="row <?php echo $_SESSION['user_data']->role_id != 3 ? 'mt-3' : '' ?> align-items-center">
                                        <?php
                                        if ($_SESSION['user_data']->role_id == 1) { ?>
                                            <div class="col-md-2">
                                                <select class="form-control" id="province_select" style="width: 100%;" onchange="getBywhere()">
                                                    <option value="0">เลือกจังหวัด</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-control" id="district_select" style="width: 100%;" onchange="getBywhere()">
                                                    <option value="0">เลือกอำเภอ</option>
                                                </select>
                                            </div>
                                        <?php } ?>
                                        <?php if ($_SESSION['user_data']->role_id != 3) { ?>
                                            <div class="col-md-2">
                                                <select class="form-control" id="subdistrict_select" style="width: 100%;" onchange="getBywhere()">
                                                    <option value="0">เลือกตำบล</option>
                                                </select>
                                                <input type="hidden" name="district_select_value" id="district_select_value" value="">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <table id="table" data-icons="icons" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/family_controller?getFamilyData=true">
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>

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
    <script>
        var $table = $("#table");
        window.icons = {
            refresh: "fa-refresh",
        };

        function formatClass(data, row) {
            if (row.class == 1) {
                return "ประถม"
            }
            if (row.class == 2) {
                return "ม.ต้น"
            }
            if (row.class == 3) {
                return "ม.ปลาย"
            }
        }

        function formatButtonView(data, row) {
            let html = `<a href="family_data_detail?family_id=${row.family_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
            return html;
        }

        function formatButtonDelete(data, row) {
            let html = `<button type="button" onclick="deleteFamily(${row.family_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
            return html;
        }

        function initTable() {
            $table.bootstrapTable("destroy").bootstrapTable({
                locale: "th-TH",
                columns: [{
                        title: "ลำดับ",
                        align: "center",
                        width: "50px",
                        formatter: function(value, row, index) {
                            const options = $table.bootstrapTable("getOptions");
                            const currentPage = options.pageNumber;
                            let itemsPerPage = options.pageSize;
                            if (itemsPerPage == "All") {
                                const data = $table.bootstrapTable("getData");
                                itemsPerPage = data.length;
                            }
                            const offset = (currentPage - 1) * itemsPerPage;
                            return index + 1 + offset;
                        },
                    },
                    {
                        field: "home_number",
                        title: "บ้านเลขที่",
                        align: "left",
                    },
                    {
                        field: "moo",
                        title: "หมู่",
                        align: "left",
                    },
                    {
                        field: "street",
                        title: "ถนน",
                        align: "left",
                    },
                    {
                        field: "alley",
                        title: "ตรอก",
                        align: "left",
                    },
                    {
                        field: "alley1",
                        title: "ซอย",
                        align: "left",
                    },
                    {
                        field: "subdistrict_th",
                        title: "ตำบล",
                        align: "center",
                        width: "100px",
                    },
                    {
                        field: "district_th",
                        title: "อำเภอ",
                        align: "center",
                        width: "100px",
                    },
                    {
                        field: "province_th",
                        title: "จังหวัด",
                        align: "center",
                        width: "120px",
                    },
                    {
                        field: "user_create_data",
                        title: "ผู้บันทึก",
                        width: "180px",
                    },
                    {
                        title: "ดูรายละเอียดเพิ่มเติม",
                        align: "center",
                        width: "50px",
                        formatter: formatButtonView
                    },
                    // {
                    //     field: "edit_opr",
                    //     title: "แก้ไข",
                    //     align: "center",
                    //     width: "50px",
                    //     formatter: formatButtonEdit,
                    //     visible: role_id == 3 ? true : false
                    // },
                    {
                        field: "del_opr",
                        title: "ลบ",
                        align: "center",
                        width: "50px",
                        formatter: formatButtonDelete,
                        visible: role_id == 3 ? true : false
                    },
                ],
            });
        }

        $(document).ready(async function() {
            initTable()
            await getDataProDistSub();
            if (role_id == 1) {
                $('#province_select').select2()
                $('#district_select').select2()
                $('#subdistrict_select').select2()
            }

            if (role_id == 2) {
                $('#subdistrict_select').select2()
            }
            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });

            <?php if (!empty($searchSession)) { ?>
                getBywhere()
            <?php } ?>
        });
    </script>

    <script>
        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true,
                    table: "stf_tb_family_data"
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

        function getBywhere() {
            const pro_id = $('#province_select').val() ?? 0
            const dis_id = $('#district_select').val() ?? 0
            const sub_dis_id = $('#subdistrict_select').val() ?? 0

            var urlWithParams = $table.data('url') + `&pro_id=${pro_id}&dis_id=${dis_id}&sub_dis_id=${sub_dis_id}`;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
            $table.bootstrapTable('refresh');
        }

        function search() {
            getBywhere()
        }

        function isEmptyInputSearch() {
            if ($("#search").val() == '') {
                getBywhere()
            }
        }

        function deleteFamily(family_id) {
            const confirmDelete = confirm('ต้องการลบข้อมูลประชากรด้านการศึกษาของนักศึกษาคนนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/family_controller",
                    data: {
                        deleteFamily: true,
                        family_id: family_id
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