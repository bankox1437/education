<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>รายชื่อครูตำบล</title>
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
                                <div class="box-header">
                                    <input type="hidden" id="role_value" value="0">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <h4 class="box-title">ตารางรายชื่อครูตำบลทั้งหมด</h4>
                                        </div>
                                    </div>
                                    <div class="row mt-3 align-items-center">
                                        <?php if ($_SESSION['user_data']->role_id == 1) { ?>
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
                                        <div class="col-md-2">
                                            <select class="form-control select2" id="subdistrict_select" style="width: 100%;">
                                                <option value="0">เลือกตำบล</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control select2" id="teacher_select" style="width: 100%;" onchange="chooseTeacher()">
                                                <option value="0">เลือกครู</option>
                                            </select>
                                        </div>
                                        <!-- <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="#" onclick="searchSubDis()"><i class="ti-search"></i>&nbsp;ค้นหา</a> -->
                                        <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="#" id="show-all"><i class="ti-search"></i>&nbsp;ดูทั้งหมด</a>
                                        <!-- <input class="col-md-2 form-control" type="text" name="search_admin" placeholder="ค้นหาชื่อสถานศึกษา" oninput="searchUser(this)"> -->
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table id="table" data-icons="icons" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="../visit-online/controllers/am_controller?getDataUsersBT=true">
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

    <?php
    include 'include/scripts.php';
    include '../include/teacher_list_select.php';
    ?>

    <script>
        var $table = $("#table");
        var $remove = $("#remove");
        var selections = [];

        $(document).ready(async function() {
            getDataProDistSub()
            initTable()

            let pro_active = '<?php echo isset($_GET['pro']) ? $_GET['pro'] : '0' ?>'
            let dis_active = '<?php echo isset($_GET['dis']) ? $_GET['dis'] : '0' ?>'
            let sub_active = '<?php echo isset($_GET['sub']) ? $_GET['sub'] : '0' ?>'
            let page_number = '<?php echo isset($_GET['page_number']) ? $_GET['page_number'] : '0' ?>'

            if (role_id == 2) {
                $('#subdistrict_select').select2()
            }
            if (role_id == 1) {
                $('#province_select').select2()
                $('#district_select').select2()
                $('#subdistrict_select').select2()
            }

            setTimeout(() => {
                if (pro_active != '0') {
                    $('#province_select').val(pro_active).trigger('change');
                }
                if (dis_active != '0') {
                    $('#district_select').val(dis_active).trigger('change');
                }
                if (sub_active != '0') {
                    $('#subdistrict_select').val(sub_active).trigger('change');
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

        function checkChannelFormat(data, row) {
            if (row.channel == null || row.channel == '') {
                return `ยังไม่ได้เพิ่มช่องทางการติดต่อ`;
            }
            return row.channel;
        }

        function checkEduFormat(data, row) {
            if (row.edu_name == null) {
                return `-`;
            }
            return row.edu_name;
        }

        function checkSubDistrictFormat(data, row) {
            if (row.sub_district == null) {
                return `-`;
            }
            return row.sub_district;
        }

        function checkDistrictFormat(data, row) {
            let district_text = "";
            if (row.district != null && row.role_id != 2) {
                district_text = row.district
            }
            if (row.district == null && row.role_id == 2) {
                district_text = row.district_am
            }

            return district_text;
        }

        function checkProvinceFormat(data, row) {
            let province_text = "";
            if (row.province != null && row.role_id != 2) {
                province_text = row.province
            }
            if (row.province == null && row.role_id == 2) {
                province_text = row.province_am
            }

            return province_text;
        }

        function opsView(data, row) {
            let pro = $('#province_select').val() ?? '0';
            let dis = $('#district_select').val() ?? '0';
            let sub = $('#subdistrict_select').val() ?? '0';

            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;

            return ` <a href="manage_estimate?pro=${pro}&dis=${dis}&sub=${sub}&page_number=${currentPageNumber}&user_id=${row.id}&name=${row.name} ${row.surname}">
                        <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-eye"></i></button>
                    </a>`
        }

        function opsReport(data, row) {
            let pro = $('#province_select').val() ?? '0';
            let dis = $('#district_select').val() ?? '0';
            let sub = $('#subdistrict_select').val() ?? '0';

            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;

            return ` <a href="manage_summary?pro=${pro}&dis=${dis}&sub=${sub}&page_number=${currentPageNumber}&user_id=${row.id}&name=${row.name} ${row.surname}">
                        <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5"><i class="ti-agenda"></i></button>
                    </a>`
        }

        function opsSummary(data, row) {
            let pro = $('#province_select').val();
            let dis = $('#district_select').val();
            let sub = $('#subdistrict_select').val();

            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;

            return ` <a href="manage_index?pro=${pro}&dis=${dis}&sub=${sub}&page_number=${currentPageNumber}&user_id=${row.id}&name=${row.name} ${row.surname}">
                        <button type="button" class="waves-effect waves-circle btn btn-circle btn-info mb-5"><i class="ti-zip"></i></button>
                    </a>`
        }


        function initTable() {
            $table.bootstrapTable("destroy").bootstrapTable({
                locale: "th-TH",
                columns: [
                    [{
                            title: "ลำดับ",
                            align: "center",
                            width: "30px",
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
                            field: "concat_name_users",
                            title: "ชื่อ-สกุล",
                            align: "left",
                        },
                        {
                            title: "สถานศึกษา",
                            align: "left",
                            formatter: checkEduFormat
                        },
                        {
                            title: "ตำบล",
                            align: "left",
                            formatter: checkSubDistrictFormat
                        },
                        {
                            title: "อำเภอ",
                            align: "left",
                            formatter: checkDistrictFormat
                        },
                        {
                            title: "จังหวัด",
                            align: "left",
                            formatter: checkProvinceFormat
                        },
                        {
                            title: "ดูรายละเอียดการประเมิน",
                            align: "center",
                            formatter: opsView
                        },
                    ],
                ],
            });
        }


        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true,
                    table: 'tb_users'
                },
                dataType: "json",
                success: async function(json_data) {
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district_id = json_data.data.sub_district;
                    let role_id = '<?php echo $_SESSION['user_data']->role_id; ?>';
                    if (role_id == 1) {
                        const province_select = document.getElementById('province_select');
                        main_provinces.forEach((element, id) => {
                            province_select.innerHTML +=
                                ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                        });
                    }

                    if (role_id == 2) {
                        const sub_name = document.getElementById('subdistrict_select');
                        sub_name.innerHTML = "";
                        sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;

                        const sub_district = main_sub_district_id.filter((sub) => {
                            return sub.district_id ==
                                '<?php echo $_SESSION['user_data']->district_am_id ?>';
                        })
                        sub_district.forEach((element, id) => {
                            sub_name.innerHTML +=
                                ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                        });
                    }
                },
            });
        }

        $('#province_select').change((e) => {
            searchSubDis()
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
                district_select.innerHTML +=
                    ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
            });
        }
        $('#district_select').change((e) => {
            searchSubDis()
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
                sub_name.innerHTML +=
                    ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
            });
        }

        $('#subdistrict_select').change((e) => {
            searchSubDis()
        })

        $('#show-all').click(() => {
            var urlWithParams = $table.data('url');
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
            $("#province_select").val(0).change();
            $("#district_select").val(0).change();
            $("#subdistrict_select").val(0).change();
        });

        function searchSubDis() {
            $("#teacher_select").val(0).change();
            let paramPlus = "";
            let pro = $('#province_select').val();
            let dis = $('#district_select').val();
            let sub = $('#subdistrict_select').val();
            const teacherId = $('#teacher_select').val();
            if (role_id == 1) {
                if (pro != 0) {
                    paramPlus += '&province_id=' + pro;
                }
                if (dis != 0) {
                    paramPlus += '&district_id=' + dis;
                }
            }
            if (sub != 0) {
                paramPlus += '&subdistrict_id=' + sub;
            }

            paramPlus += '&teacherId=' + teacherId;

            var urlWithParams = $table.data('url') + paramPlus;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });

            getTeacherList(pro, dis, sub)
        }

        function chooseTeacher() {
            let paramPlus = "";
            const teacherId = $('#teacher_select').val();
            paramPlus += '&teacherId=' + teacherId;

            var urlWithParams = $table.data('url') + paramPlus;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }
    </script>
</body>

</html>