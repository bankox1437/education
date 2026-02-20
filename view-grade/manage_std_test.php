<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการรายชื่อผู้มีสิทธิ์สอบ</title>
    <style>
        #table td {
            padding: 10px;
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
                                <div class="box-body no-padding">
                                    <div id="toolbar" class="row">
                                        <div class="col-12 row align-items-center">
                                            <h4 class="col-md-4">ตาราผู้มีสิทธิ์สอบ</h4>
                                            <div class="col-md-4">
                                                <select class="form-control" id="std_class" onchange="getBywhere()">
                                                    <option value="">ชั้นทั้งหมด &nbsp;&nbsp;</option>
                                                    <option value="ประถม">ประถม</option>
                                                    <option value="ม.ต้น">ม.ต้น</option>
                                                    <option value="ม.ปลาย">ม.ปลาย</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4" style="display: none;">
                                                <select class="form-control" id="term_name" onchange="getBywhere()">
                                                    <option value="0">ปีการศึกษาทั้งหมด &nbsp;&nbsp;</option>
                                                    <?php foreach ($_SESSION['term_data'] as $value) { ?>
                                                        <?php $selected = ($value->term_id == $_SESSION['term_active']->term_id) ? 'selected' : ''; ?>
                                                        <?php $current = ($value->term_id == $_SESSION['term_active']->term_id) ? ' (ปัจจุบัน)' : ''; ?>
                                                        <option value="<?php echo $value->term_id ?>" <?php echo $selected ?>><?php echo $value->term_name . $current ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                <a class="waves-effect waves-light btn btn-success btn-flat ml-2 mt-3" id="btn_add" onclick="goToAdd()"><i class="ti-pencil-alt"></i>&nbsp;รายชื่อผู้มีสิทธิ์สอบ</a>
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
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/std_test_controller?getDataStdTest=true">
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
    <script src="js/init-table/manage_std_test.js?v=<?php echo $version ?>"></script>

    <script>
        function goToAdd() {
            let term_id = $('#term_name').val();
            let term = $('#term_name option:selected').text();
            location.href = "manage_std_test_add?term_id=" + term_id + "&term=" + term
        }

        $(document).ready(async function() {
            initTable()
            $('.search input').attr('placeholder', 'ค้นหาด้วยชื่อหรือปีการศึกษา');
            await getDataProDistSub();
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

        function getByClass(std_class) {
            // Add additional parameters to the data-url
            var urlWithParams = $table.data('url') + '&std_class=' + std_class;

            // Update the data-url attribute with the new URL containing parameters
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });

            // Use the 'refresh' method to reload data from the updated data source and update the table
            $table.bootstrapTable('refresh');
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
            const std_class = $('#std_class').val() ?? 0;
            const term_id = $('#term_name').val() ?? 0;

            if (term_id == 0) {
                $("#btn_add").css("visibility", "hidden");
            } else {
                $("#btn_add").css("visibility", "visible");
            }

            var urlWithParams = $table.data('url') + `&pro_id=${pro_id}&dis_id=${dis_id}&sub_dis_id=${sub_dis_id}` +
                '&std_class=' + std_class + '&term_id=' + term_id;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
            $table.bootstrapTable('refresh');

        }

        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true,
                    table: "vg_test_result"
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
    </script>
</body>

</html>