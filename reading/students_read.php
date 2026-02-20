<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลนักศึกษา บันทึกรักการอ่าน</title>
    <style>
        #table {
            font-size: 10px;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box" style="padding-left: 20px;padding-right: 20px;">
                                <input type="hidden" id="role_value" value="0">
                                <div class="row align-items-center mt-4">
                                    <div class="col-md-2">
                                        <h4 class="mt-2 ml-3">ข้อมูลนักศึกษา บันทึกรักการอ่าน</h4>
                                    </div>
                                    <div class="col-md-1">
                                        <select class="form-control mt-2" id="std_class" onchange="getBywhere()">
                                            <option value="">ชั้นทั้งหมด &nbsp;&nbsp;</option>
                                            <option value="ประถม">ประถม</option>
                                            <option value="ม.ต้น">ม.ต้น</option>
                                            <option value="ม.ปลาย">ม.ปลาย</option>
                                        </select>
                                    </div>
                                    <?php if ($_SESSION['user_data']->role_id == 5) { ?>
                                        <div class="col-md-2">
                                            <div class="form-group mb-0 mt-2">
                                                <input type="hidden" id="pro_id" value="<?php echo $_SESSION['user_data']->province_am_id ?>">
                                                <input type="hidden" id="dis_id" value="<?php echo $_SESSION['user_data']->district_am_id ?>">
                                                <select class="form-control select2" name="subdis_id" id="subdis_id" data-placeholder="เลือกตำบล" style="width: 100%;" onchange="getBywhere();getTeacherList()">
                                                    <option value="0">เลือกตำบล</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-0 mt-2">
                                                <select class="form-control select2" id="teacher_select" style="width: 100%;" onchange="getBywhere()">
                                                    <option value="0">เลือกครู</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="box-body no-padding">
                                    <table id="table" data-icons="icons" data-search="false" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/read_controller?getDataStudent=true">
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
    <script src="js/init-table/manage_students.js?v=<?php echo rand(0, 9) ?>"></script>
    <script>
        $(document).ready(async function() {
            initTable();

            <?php if ($_SESSION['user_data']->role_id == 5) { ?>
                getDataProDistSub()
                getTeacherList()
                $('#subdis_id').select2()
                $('#teacher_select').select2()
            <?php } ?>
        });

        function getBywhere() {
            const std_class = $('#std_class').val() ?? "";
            const subdis_id = $('#subdis_id').val() ?? "";
            const teacher_id = $('#teacher_select').val() ?? "";

            var urlWithParams = $table.data('url') + `&std_class=${std_class}&subdis_id=${subdis_id}&teacher_id=${teacher_id}`;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
            $table.bootstrapTable('refresh');
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
                    console.log(json_data);
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district_id = json_data.data.sub_district;

                    let dis_data;
                    await getDistrictDataAmphur().then((result) => {
                        dis_data = result.data[0]
                    })

                    const sub_name = document.getElementById('subdis_id');
                    sub_name.innerHTML = "";
                    sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;

                    const sub_district = main_sub_district_id.filter((sub) => {
                        return sub.district_id == $('#dis_id').val()
                    })
                    sub_district.forEach((element, id) => {
                        sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                    });
                },
            });
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

        async function getTeacherList() {
            $.ajax({
                type: "POST",
                url: "../view-grade/controllers/user_controller",
                data: {
                    getTeacherList: true,
                    province_id: $('#pro_id').val(),
                    district_id: $('#dis_id').val(),
                    subdistrict_id: $('#subdis_id').val()
                },
                dataType: "json",
                success: async function(json) {
                    const data = json.data;
                    $('#teacher_select').empty();
                    $('#teacher_select').append(`<option value="0">เลือกครู</option>`);
                    data.forEach((element) => {
                        $('#teacher_select').append(`<option value="${element.id}">${element.concat_name}</option>`);
                    });
                },
            });
        }
    </script>
</body>

</html>