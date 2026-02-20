<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการคะแนน กพช.</title>
    <?php
    if ($_SESSION['user_data']->role_id == 1) { ?>
        <style>
            #table td {
                padding: 10px;
            }
        </style>
    <?php }
    ?>
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
                                    <div class="d-flex flex-wrap align-items-center px-4 pt-4">
                                        <h4 class="mb-0 mr-3">ตารางข้อมูล กพช.</h4>

                                        <!-- ซ่อนปีการศึกษา -->
                                        <div class="mr-3" style="display: none;">
                                            <select class="form-control" id="term_name" onchange="getBywhere()">
                                                <option value="0">ปีการศึกษาทั้งหมด</option>
                                                <?php foreach ($_SESSION['term_data'] as $value) { ?>
                                                    <?php $selected = ($value->term_id == $_SESSION['term_active']->term_id) ? 'selected' : ''; ?>
                                                    <?php $current = ($value->term_id == $_SESSION['term_active']->term_id) ? ' (ปัจจุบัน)' : ''; ?>
                                                    <option value="<?php echo $value->term_id ?>" <?php echo $selected ?>>
                                                        <?php echo $value->term_name . $current ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <!-- ชั้น -->
                                        <div class="mr-3">
                                            <select class="form-control" id="std_class" onchange="getBywhere()" style="min-width: 160px;">
                                                <option value="">ชั้นทั้งหมด</option>
                                                <option value="ประถม">ประถม</option>
                                                <option value="ม.ต้น">ม.ต้น</option>
                                                <option value="ม.ปลาย">ม.ปลาย</option>
                                            </select>
                                        </div>

                                        <!-- ปุ่ม -->
                                        <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                            <!-- ปุ่มบันทึก กพช. -->
                                            <a class="btn btn-success btn-flat mr-2 mt-1" href="manage_kpc_add">
                                                <i class="ti-plus"></i>&nbsp;บันทึก กพช.
                                            </a>

                                            <!-- ปุ่มแก้ไข กพช. -->
                                            <a class="btn btn-warning btn-flat mr-2 mt-1" onclick="editKPC()">
                                                <i class="ti-pencil"></i>&nbsp;แก้ไข กพช.
                                            </a>

                                            <!-- ปุ่มนำเข้า Excel -->
                                            <div class="custom-file-upload mt-1 mr-2">
                                                <input type="file" id="import_excel_kpc" hidden
                                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel, .csv"
                                                    onchange="importKpc(this)" />
                                                <label for="import_excel_kpc" class="btn btn-info btn-flat m-0">
                                                    <i class="ti-import"></i>&nbsp;นำเข้าข้อมูล Excel
                                                </label>
                                            </div>

                                            <!-- ปุ่มดาวน์โหลดตัวอย่างไฟล์ Excel -->
                                            <a class="mt-1" href="images/example-kpc.xlsx" download title="ไฟล์ตัวอย่างการนำเข้าคะแนน กพช.">
                                                <i class="ti-download"></i>&nbsp;ดาวน์โหลดตัวอย่าง Excel
                                            </a>
                                        <?php } ?>

                                        <div class="ml-auto mt-1" style="min-width: 200px;">
                                            <input type="text" class="form-control" id="searchInput" placeholder="ค้นหาด้วยชื่อ นศ." onkeyup="getBywhere()" />
                                        </div>
                                    </div>


                                    <div class="row align-items-center">
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
                                    <table id="table" data-icons="icons" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/kpc_controller?getDataKPC=true">
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
    <script src="js/init-table/manage_kpc.js?v=<?php echo $version ?>"></script>

    <script>
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
            const term_id = $('#term_name').val() ?? 0;
            const std_class = $('#std_class').val() ?? "";
            const search = $('#searchInput').val() ?? "";

            var urlWithParams = $table.data('url') + `&pro_id=${pro_id}&dis_id=${dis_id}&sub_dis_id=${sub_dis_id}` +
                '&term_id=' + term_id + `&std_class=${std_class}&search=${search}`;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
            $table.bootstrapTable('refresh');
            $('.search input').attr('placeholder', 'ค้นหาด้วยชื่อหรือปีการศึกษา');
        }

        function deleteKPC(kpc_id) {
            const confirmDelete = confirm('ต้องการลบ กพช. นี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/kpc_controller",
                    data: {
                        deleteKPC: true,
                        kpc_id: kpc_id
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
                    table: "vg_kpc"
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

        function editKPC() {
            let term = $('#term_name').val();
            let term_name = $('#term_name option:selected').text();
            location.href = 'manage_kpc_add?edit=1&term_id=' + term + '&term_name=' + term_name;
        }

        function importKpc(file) {
            const KPCfile = file.files[0];
            const formData = new FormData();
            formData.append("kpc_file", KPCfile);
            formData.append("import_kpc", true);

            fetch("controllers/kpc_controller", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.msg);
                    $table.bootstrapTable('refresh');
                })
                .catch(error => {
                    console.error("Error:", error);
                });
            file.value = "";
            file.files[0] = undefined;
        }
    </script>
</body>

</html>