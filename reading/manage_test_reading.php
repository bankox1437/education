<?php //include 'include/check_login.php'; 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>สื่อการอ่าน</title>
    <script>
        const role_id = '<?php echo $_SESSION['user_data']->role_id ?>';
        const type_user = '<?php echo $_SESSION['user_data']->edu_type ?>';
    </script>
    <style>
        .table tbody tr td {
            padding-top: 13px;
            padding-bottom: 13px;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php
        if ($_SESSION['user_data'] && $_SESSION['user_data']->role_id != 1) {
            include '../include/nav-header.php';
        }
        ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php //include 'include/sidebar.php'; 
        ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h3 class="pt-3 pb-0 pl-2 m-0 box-title">
                                                <?php if (!$_SESSION['user_data'] || $_SESSION['user_data']->role_id == 1) { ?>
                                                    <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='../'"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    สื่อการเรียนรู้ตลอดชีวิต
                                                <?php } else { ?>
                                                    ข้อมูลสื่อการอ่าน
                                                <?php } ?>
                                                &nbsp;&nbsp;
                                            </h3>
                                        </div>
                                        <div class="col-md-2 mt-3 px-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="search" placeholder="ค้นหาด้วยชื่อเรื่อง" onkeyup="searchTeachMore()">
                                            </div>
                                        </div>
                                    </div>
                                    <table id="table" data-icons="icons" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]"
                                        data-page-size="20" data-side-pagination="server" data-url="controllers/test_reading_controller?getDataTestReading=true">
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
        <!-- /.modal -->
        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        const user_id = '<?php echo $_SESSION['user_data']->id ?>';
    </script>
    <script src="js/init-table/manage_test_reading.js?v=<?php echo $version ?>"></script>

    <script>
        $(document).ready(async function() {
            <?php if (!isset($_SESSION['term_active']) && $_SESSION['user_data']->role_id == 3) { ?>
                document.getElementById("click-show-modal").click();
            <?php } ?>
            initTable()
            if (role_id == 1) {
                // await getDataProDistSub();
                // $('#province_select').select2()
                // $('#district_select').select2()
                // $('#subdistrict_select').select2()
            }
            $('.search input').attr('placeholder', 'ค้นหาด้วยชื่อเรื่อง');
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


        function searchTeachMore() {
            let param = '';
            $('#search').val() != '' ? param += '&search=' + $('#search').val() : '';
            $('#province_select').val() != '0' ? param += '&province_select=' + $('#province_select').val() : '';
            $('#district_select').val() != '0' ? param += '&district_select=' + $('#district_select').val() : '';

            var urlWithParams = $table.data('url') + param;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }

        function deleteMedia(media_id, media_file_name, media_file_name_cover) {
            const confirmDelete = confirm('ต้องการลบรายการนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/media_controller",
                    data: {
                        deleteMedia: true,
                        media_id: media_id,
                        media_file_name: media_file_name,
                        media_file_name_cover: media_file_name_cover
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


        function deleteTestReading(test_read_id, file_test) {
            const confirmDelete = confirm('ต้องการลบรายการนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/test_reading_controller",
                    data: {
                        deleteTestReading: true,
                        test_read_id: test_read_id,
                        file_test: file_test
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

        function closeTestReading(test_read_id, file_test) {
            const confirmDelete = confirm('ต้องการปิดการใช้งานรายการนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/test_reading_controller",
                    data: {
                        deleteTestReading: true,
                        test_read_id: test_read_id,
                        file_test: file_test
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

        function addCountRead(statusRead, media_id, eBook = "") {
            $.ajax({
                type: "POST",
                url: "controllers/media_controller",
                data: {
                    addDurationView: true,
                    media_id: media_id,
                    mode: 'count'
                },
                dataType: "json",
                success: function(data) {
                    if (eBook != "") {
                        window.open(eBook, '_blank');
                    } else {
                        location.href = `reading_test?media_id=${media_id}&read=${statusRead}`;
                    }
                },
            });
        }
    </script>
</body>

</html>