<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการผลการเรียน</title>
    <style>
        .fixed-table-toolbar .bs-bars {
            width: 70%;
        }

        #table-term tbody tr td {
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
                                            <h4 class="<?php echo $_SESSION['user_data']->role_id == 1 ? "col-md-4" : "col-md-3" ?> mt-2">ข้อมูลผลการเรียน นศ.</h4>
                                            <div class="col-md-3">
                                                <select class="form-control" id="std_class" onchange="updateTable()" style="width: 75%;">
                                                    <option value="">ชั้นทั้งหมด &nbsp;&nbsp;</option>
                                                    <option value="ประถม">ประถม</option>
                                                    <option value="ม.ต้น">ม.ต้น</option>
                                                    <option value="ม.ปลาย">ม.ปลาย</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                    <a class="waves-effect waves-light btn btn-success btn-flat mt-1" href="manage_credit_new_add"><i class="ti-plus"></i>&nbsp;บันทึกผลการเรียน</a>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-3">
                                                <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                    <a class="waves-effect waves-light btn btn-success btn-flat mt-1" data-toggle="modal" data-target="#termCreditModal"><i class="ti-write"></i>&nbsp;เลือกรายเทอม</a>
                                                <?php } ?>
                                            </div>
                                            <!-- <div class="col-md-4">
                                                <select class="form-control" id="term_name" onchange="updateTable()">
                                                    <option value="0">ปีการศึกษาทั้งหมด &nbsp;&nbsp;</option>
                                                    <?php foreach ($_SESSION['term_data'] as $value) { ?>
                                                        <?php $selected = ($value->term_id == $_SESSION['term_active']->term_id) ? 'selected' : ''; ?>
                                                        <?php $current = ($value->term_id == $_SESSION['term_active']->term_id) ? ' (ปัจจุบัน)' : ''; ?>
                                                        <option value="<?php echo $value->term_id ?>" <?php echo $selected ?>><?php echo $value->term_name . $current ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div> -->
                                        </div>
                                        <div class="col-12 row align-items-center">
                                            <?php
                                            if ($_SESSION['user_data']->role_id == 1) { ?>
                                                <div class="col-md-4 mt-2">
                                                    <select class="form-control select2" id="province_select" style="width: 100%;" onchange="updateTable()">
                                                        <option value="0">เลือกจังหวัด</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <select class="form-control select2" id="district_select" style="width: 100%;" onchange="updateTable()">
                                                        <option value="0">เลือกอำเภอ</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2" id="sub_dis">
                                                    <select class=" form-control select2" id="subdistrict_select" style="width: 100%;" onchange="updateTable()">
                                                        <option value="0">เลือกตำบล</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/credit_controller?getDataCredit=true">
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

    <div id="termCreditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="termCreditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="termCreditModalLabel">ใบลงทะเบียนรายเทอม</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table b-1 border-dark table-bordered mb-0" id="table-term">
                            <thead class="bg-inverse">
                                <tr>
                                    <th>เทอม</th>
                                    <th class="text-center" style="width: 30%;">พิมพ์</th>
                                    <th class="text-center" style="width: 30%;">ระบุเทอมปัจุบัน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../config/class_database.php";
                                $DB = new Class_Database();
                                $sql = "SELECT term_id,credit_id,current FROM vg_credit c WHERE c.user_create = :user_create GROUP BY c.term_id ORDER BY c.create_date ASC";
                                $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id]);
                                $term_data = json_decode($data);
                                foreach ($term_data as $key => $term) { ?>
                                    <tr>
                                        <td><?php echo $term->term_id ?></td>
                                        <td class="text-center">
                                            <a href="pdf/register_pdf?term=<?php echo $term->term_id ?>" target="_blank" style="padding-top: 8px;" type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 btn-xs"><i class="ti-write"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <div class="c-inputs-stacked">
                                                <input name="currentUsed" type="radio" id="radio_<?php echo $term->credit_id ?>" value="<?php echo $term->term_id ?>" <?php echo !empty($term->current) ? "checked" : '' ?> onchange="setCurrentTerm(this.value)">
                                                <label for="radio_<?php echo $term->credit_id ?>" class="ml-2"></label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <?php include 'include/scripts.php'; ?>
    <script src="js/init-table/manage_credit.js?v=<?php echo $version ?>"></script>

    <script>
        $(document).ready(async function() {
            initTable()
            $('.search input').attr('placeholder', 'ค้นหาด้วยชื่อ นศ.');
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

        function updateTable() {
            var std_class = document.getElementById('std_class').value;
            // var term_id = document.getElementById('term_name').value;
            const pro_id = $('#province_select').val() ?? 0
            const dis_id = $('#district_select').val() ?? 0
            const sub_dis_id = $('#subdistrict_select').val() ?? 0

            // Build the URL with both parameters
            var urlWithParams = $table.data('url') + `&pro_id=${pro_id}&dis_id=${dis_id}&sub_dis_id=${sub_dis_id}` +
                '&std_class=' + std_class;
            // Update the data-url attribute with the new URL containing parameters
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });

            // Use the 'refresh' method to reload data from the updated data source and update the table
            $table.bootstrapTable('refresh');
        }

        function deleteCredit(credit_id) {
            const confirmDelete = confirm('ต้องการลบผลรวมหน่วยกิต นี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/credit_controller",
                    data: {
                        deleteCredit: true,
                        credit_id: credit_id
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
                    table: "vg_credit"
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


        function setCurrentTerm(term_id) {
            console.log("setCurrentTerm", term_id);
            $.ajax({
                type: "POST",
                url: "controllers/credit_controller",
                data: {
                    setCurrentTerm: true,
                    term_id: term_id
                },
                dataType: "json",
                success: function(data) {

                },
            });
        }
    </script>
</body>

</html>