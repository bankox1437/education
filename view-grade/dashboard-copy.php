<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>หน้าแดชบอร์ด</title>
    <style>
        /* Styles for devices with a maximum width of 480px (typical smartphones) */
        .icon i {
            font-size: 1.5rem;
        }

        @media (max-width: 480px) {
            .box-body {
                padding: 0;
            }

            .icon {
                margin-left: 5px;
            }

            .icon i {
                width: 40px;
                height: 40px;
                line-height: 40px;
                font-size: 15px;
            }

            .box-body div:nth-child(1) div:nth-child(2) :is(h3, p) {
                margin-right: 20px;
            }

            .text-count {
                display: flex;
                align-items: center;
                flex-direction: row-reverse;
            }

            .text-count h3 {
                margin-top: 0;
            }
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
                        <?php
                        if ($_SESSION['user_data']->role_id == 1) { ?>
                            <div class="col-md-2 mt-2">
                                <select class="form-control" id="province_select" style="width: 100%;" onchange="getDataCountAll()">
                                    <option value="0">เลือกจังหวัด</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-2">
                                <select class="form-control" id="district_select" style="width: 100%;" onchange="getDataCountAll()">
                                    <option value="0">เลือกอำเภอ</option>
                                </select>
                            </div>
                        <?php } ?>
                        <div class="col-md-2 mt-2" id="sub_dis" style="display: block;">
                            <div class="form-group">
                                <select class="form-control" id="subdistrict_select" style="width: 100%;" onchange="getDataCountAll()">
                                    <option value="0">เลือกตำบล</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center justify-content-between p-1">
                                        <div class="icon rounded-circle" style="background-color: #f9bdbb;">
                                            <i class="mr-0 fa fa-bar-chart" style="color: #e51c23;"></i>
                                        </div>
                                        <div class="text-count">
                                            <h3 class="text-dark text-right mb-0 font-weight-500" id="test_grade_count">0</h3>
                                            <p class="text-mute mb-0">ผลสอบภาคเรียนนี้</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center justify-content-between p-1">
                                        <div class="icon rounded-circle" style="background-color: #f8bbd0;">
                                            <i class="mr-0 fa fa-file-text" style="color: #e91e63;"></i>
                                        </div>
                                        <div class="text-count">
                                            <h3 class="text-dark text-right mb-0 font-weight-500" id="n_net_count">0</h3>
                                            <p class="text-mute mb-0">ผลสอบ N NET ภาคเรียนนี้</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center justify-content-between p-1">
                                        <div class="icon rounded-circle" style="background-color: #e1bee7;">
                                            <i class="mr-0 fa fa-file-text-o" style="color: #9c27b0;"></i>
                                        </div>
                                        <div class="text-count">
                                            <h3 class="text-dark text-right mb-0 font-weight-500" id="kpc_count">0</h3>
                                            <p class="text-mute mb-0">กพช. สะสม</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center justify-content-between p-1">
                                        <div class="icon rounded-circle" style="background-color: #d1c4e9;">
                                            <i class="mr-0 fa fa-calendar" style="color: #673ab7;"></i>
                                        </div>
                                        <div class="text-count">
                                            <h3 class="text-dark text-right mb-0 font-weight-500" id="table_test_count">0</h3>
                                            <p class="text-mute mb-0">ตารางสอบ</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center justify-content-between p-1">
                                        <div class="icon rounded-circle" style="background-color: #9fa8da;">
                                            <i class="mr-0 fa fa-vcard" style="color: #3f51b5;"></i>
                                        </div>
                                        <div class="text-count">
                                            <h3 class="text-dark text-right mb-0 font-weight-500" id="test_result_count">0</h3>
                                            <p class="text-mute mb-0">รายชื่อผู้มีสิทธิ์สอบ</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center justify-content-between p-1">
                                        <div class="icon rounded-circle" style="background-color: #d0d9ff;">
                                            <i class="mr-0 fa fa-mortar-board" style="color: #5677fc;"></i>
                                        </div>
                                        <div class="text-count">
                                            <h3 class="text-dark text-right mb-0 font-weight-500" id="graduate_count">0</h3>
                                            <p class="text-mute mb-0">รายชื่อ นศ. ที่ตาดว่าจะจบ</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center justify-content-between p-1">
                                        <div class="icon rounded-circle" style="background-color: #b3e5fc;">
                                            <i class="mr-0 fa fa-mortar-board" style="color: #03a9f4;"></i>
                                        </div>
                                        <div class="text-count">
                                            <h3 class="text-dark text-right mb-0 font-weight-500" id="finish_count">0</h3>
                                            <p class="text-mute mb-0">รายชื่อ นศ. ที่จบการศึกษาภาคเรียนนี้</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center justify-content-between p-1">
                                        <div class="icon rounded-circle" style="background-color: #b2ebf2;">
                                            <i class="mr-0 fa fa-clipboard" style="color:#00bcd4;"></i>
                                        </div>
                                        <div class="text-count">
                                            <h3 class="text-dark text-right mb-0 font-weight-500" id="moral_count">0</h3>
                                            <p class="text-mute mb-0">คะแนนคุณธรรม จริยธรรม</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center justify-content-between p-1">
                                        <div class="icon rounded-circle" style="background-color: #ffecb3;">
                                            <i class="mr-0 fa fa-file-text" style="color: #ffb300;"></i>
                                        </div>
                                        <div class="text-count">
                                            <h3 class="text-dark text-right mb-0 font-weight-500" id="credit_count">0</h3>
                                            <p class="text-mute mb-0">ผลรวมหน่วยกิต</p>
                                        </div>
                                    </div>
                                </div>
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
        $(document).ready(async () => {
            await getDataProDistSub();
            if (role_id == 2) {
                $('#subdistrict_select').select2()
            }
            if (role_id == 1) {
                $('#province_select').select2()
                $('#district_select').select2()
                $('#subdistrict_select').select2()
            }
            getDataCountAll();
        })

        function getDataCountAll() {
            const pro_id = $('#province_select').val() ?? 0
            const dis_id = $('#district_select').val() ?? 0
            const sub_district_id = $('#subdistrict_select').val() ?? 0
            $.ajax({
                type: "POST",
                url: "controllers/dashboard_controller",
                data: {
                    getDataCount: true,
                    subdistrict_id: sub_district_id,
                    province_id: pro_id,
                    district_id: dis_id
                },
                dataType: "json",
                success: async function(json) {
                    let result = json.result;
                    for (const key in json.result) {
                        const value = result[key];
                        const h3Element = document.getElementById(key);

                        if (h3Element) {
                            h3Element.textContent = value;
                        } else {
                            console.error(`Element with ID ${key} not found.`);
                        }
                    }
                },
            });
        }

        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true
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
    </script>
</body>

</html>