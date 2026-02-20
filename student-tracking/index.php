<?php session_start();
if (isset($_SESSION['user_data'])) {
    header('location: dashboard');
} else {
    header('location: ../');
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>หน้าหลัก</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="container-full">
            <header class="main-header">

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top pl-10">
                    <!-- Sidebar toggle button-->
                    <div class="app-menu">
                        <ul class="header-megamenu nav">
                            <li class="dropdown user user-menu">
                                <a href="../" style="width: 100px;font-size: 16px;" class="text-primary"><i class="ti-arrow-left"></i>กลับหน้าหลัก</a>
                            </li>
                        </ul>
                    </div>

                    <div class="navbar-custom-menu r-side">
                        <ul class="nav navbar-nav">
                            <li class="btn-group nav-item d-lg-inline-flex d-none">
                                <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link rounded full-screen" title="Full Screen">
                                    <i class="ti-fullscreen"></i>
                                </a>
                            </li>

                            <!-- User Account-->
                            <li class="dropdown user user-menu">
                                <a href="login" style="width: 100px;font-size: 16px;" class="text-primary">เข้าสู่ระบบ</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Main content -->
            <section class="content" id="section_content" style="display: none;">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-control mr-2 col-md-3" id="province_select" style="width: 100%;" onchange="getDistrictByProvince()">
                                    <option value="">เลือกจังหวัด</option>
                                </select>
                                <input type="hidden" name="pro_value" id="pro_value">
                            </div>

                            <div class="col-md-3">
                                <select class="form-control mr-2 col-md-3" disabled id="district_select" style="width: 100%;" onchange="getSubDistrictByDistrict()">
                                    <option>เลือกอำเภอ</option>
                                </select>
                                <input type="hidden" name="dis_value" id="dis_value">
                            </div>
                            <div class="col-md-3">
                                <select class="form-control mr-2 col-md-3" disabled id="sub_district_select" style="width: 100%;" onchange="getBySubDistrict()">
                                    <option>เลือกตำบล</option>
                                </select>
                                <input type="hidden" name="sub_value" id="sub_value">
                                <input type="hidden" name="sub_dis_value" id="sub_dis_value">
                            </div>
                            <div class="col-md-3">
                                <a href="#" id="view_all">
                                    <h5 class="mt-2 ml-3">ดูทั้งหมด</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include 'include/dashboard/card.php'; ?>
                <?php include 'include/dashboard/table.php'; ?>
            </section>
            <!-- /.content -->
            <div class="preloader">
                <?php include "../include/loader_include.php"; ?>
            </div>

        </div>
        <!-- /.content-wrapper -->

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        $(document).ready(async function() {
            $('#province_select').select2()
            $('#district_select').select2()
            $('#sub_district_select').select2()
            await getDataProDistSub()
            getdatacountAdmin()
        });

        function calculate_percent(count_std, data) {
            const result = ((parseInt(data) / parseInt(count_std)) * 100).toFixed(1);
            return isNaN(result) ? '0.0' : result + "%";
        }

        function getdatacountAdmin(pro_id = "", dis_id = "", sub_id = "") {
            $.ajax({
                type: "POST",
                url: "controllers/dashboard_controller",
                data: {
                    getdatacountAdmin: true,
                    province_id: pro_id,
                    district_id: dis_id,
                    sub_district_id: sub_id
                },
                dataType: 'json',
                success: function(json_res) {
                    console.log(json_res);
                    let count_std = parseInt(json_res.data[0].count_std)
                    document.getElementById('count_std').innerHTML = count_std
                    document.getElementById('visit_home').innerHTML = json_res.data[1].visit_home
                    document.getElementById('from_evoluate').innerHTML = json_res.data[2].from_evoluate
                    document.getElementById('std_person').innerHTML = json_res.data[9].std_person
                    document.getElementById('visit_sum').innerHTML = json_res.data[10].visit_sum
                    document.getElementById('screening').innerHTML = json_res.data[11].screening

                    document.getElementById('std_gender1').innerHTML = json_res.data[3].std_gender1
                    document.getElementById('std_gender2').innerHTML = json_res.data[4].std_gender2
                    document.getElementById('std_gender3').innerHTML = json_res.data[5].std_gender3
                    document.getElementById('std_gender4').innerHTML = json_res.data[6].std_gender4
                    document.getElementById('std_gender5').innerHTML = json_res.data[7].std_gender5
                    document.getElementById('std_gender6').innerHTML = json_res.data[8].std_gender6

                    document.getElementById('std_gender1per').innerHTML = calculate_percent(count_std, json_res.data[3].std_gender1)
                    document.getElementById('std_gender2per').innerHTML = calculate_percent(count_std, json_res.data[4].std_gender2)
                    document.getElementById('std_gender3per').innerHTML = calculate_percent(count_std, json_res.data[5].std_gender3)
                    document.getElementById('std_gender4per').innerHTML = calculate_percent(count_std, json_res.data[6].std_gender4)
                    document.getElementById('std_gender5per').innerHTML = calculate_percent(count_std, json_res.data[7].std_gender5)
                    document.getElementById('std_gender6per').innerHTML = calculate_percent(count_std, json_res.data[8].std_gender6)

                    document.getElementById('p_parent_fm').innerHTML = json_res.data[12].parent_fm
                    document.getElementById('p_parent_m').innerHTML = json_res.data[13].parent_m
                    document.getElementById('p_parent_f').innerHTML = json_res.data[14].parent_f
                    document.getElementById('p_parent_alone').innerHTML = json_res.data[15].parent_alone
                    document.getElementById('p_parent_other').innerHTML = json_res.data[16].parent_other

                    document.getElementById('p_parent_fm_per').innerHTML = calculate_percent(count_std, json_res.data[12].parent_fm)
                    document.getElementById('p_parent_m_per').innerHTML = calculate_percent(count_std, json_res.data[13].parent_m)
                    document.getElementById('p_parent_f_per').innerHTML = calculate_percent(count_std, json_res.data[14].parent_f)
                    document.getElementById('p_parent_alone_per').innerHTML = calculate_percent(count_std, json_res.data[15].parent_alone)
                    document.getElementById('p_parent_other_per').innerHTML = calculate_percent(count_std, json_res.data[16].parent_other)

                    document.getElementById('m_s_parent_fm').innerHTML = json_res.data[17].parent_fm
                    document.getElementById('m_s_parent_m').innerHTML = json_res.data[18].parent_m
                    document.getElementById('m_s_parent_f').innerHTML = json_res.data[19].parent_f
                    document.getElementById('m_s_parent_alone').innerHTML = json_res.data[20].parent_alone
                    document.getElementById('m_s_parent_other').innerHTML = json_res.data[21].parent_other

                    document.getElementById('m_s_parent_fm_per').innerHTML = calculate_percent(count_std, json_res.data[17].parent_fm)
                    document.getElementById('m_s_parent_m_per').innerHTML = calculate_percent(count_std, json_res.data[18].parent_m)
                    document.getElementById('m_s_parent_f_per').innerHTML = calculate_percent(count_std, json_res.data[19].parent_f)
                    document.getElementById('m_s_parent_alone_per').innerHTML = calculate_percent(count_std, json_res.data[20].parent_alone)
                    document.getElementById('m_s_parent_other_per').innerHTML = calculate_percent(count_std, json_res.data[21].parent_other)

                    document.getElementById('m_e_parent_fm').innerHTML = json_res.data[22].parent_fm
                    document.getElementById('m_e_parent_m').innerHTML = json_res.data[23].parent_m
                    document.getElementById('m_e_parent_f').innerHTML = json_res.data[24].parent_f
                    document.getElementById('m_e_parent_alone').innerHTML = json_res.data[25].parent_alone
                    document.getElementById('m_e_parent_other').innerHTML = json_res.data[26].parent_other

                    document.getElementById('m_e_parent_fm_per').innerHTML = calculate_percent(count_std, json_res.data[22].parent_fm)
                    document.getElementById('m_e_parent_m_per').innerHTML = calculate_percent(count_std, json_res.data[23].parent_m)
                    document.getElementById('m_e_parent_f_per').innerHTML = calculate_percent(count_std, json_res.data[24].parent_f)
                    document.getElementById('m_e_parent_alone_per').innerHTML = calculate_percent(count_std, json_res.data[25].parent_alone)
                    document.getElementById('m_e_parent_other_per').innerHTML = calculate_percent(count_std, json_res.data[26].parent_other)

                },
            });
        }

        let main_provinces = [];
        let main_district = [];
        let main_sub_district = [];
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
                    const province_select = document.getElementById('province_select');
                    main_provinces.forEach((element, id) => {
                        province_select.innerHTML += ` <option value="${element.id}" data-value="${element.id}">${element.name_th}</option>`
                    });
                },
            });
            return true;
        }

        function getDistrictByProvince() {
            const pro_value = $('#province_select').find(':selected').attr('data-value')
            const pro_id = $('#province_select').val()
            $('#pro_value').val(pro_value)
            getdatacountAdmin(pro_value)
            const district_select = document.getElementById('district_select');
            district_select.innerHTML = "";
            district_select.innerHTML += ` <option value="">เลือกอำเภอ</option>`;
            const sub_name = document.getElementById('sub_district_select');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="">เลือกตำบล</option>`;
            if (!pro_id) {
                district_select.setAttribute("disabled", true)
                sub_name.setAttribute("disabled", true)
                return;
            }
            const district = main_district.filter((dist) => {
                return dist.province_id == pro_id
            })
            district_select.removeAttribute("disabled");
            district.forEach((element, id) => {
                district_select.innerHTML += ` <option value="${element.id}" data-value="${element.id}">${element.name_th}</option>`
            });
        }

        async function getSubDistrictByDistrict() {
            const pro_value = $('#pro_value').val()
            const dist_value = $('#district_select').find(':selected').attr('data-value')
            const dist_id = $('#district_select').val()
            $('#dis_value').val(dist_value)
            getdatacountAdmin(pro_value, dist_value)
            const sub_name = document.getElementById('sub_district_select');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="">เลือกตำบล</option>`;
            if (!dist_id) {
                sub_name.setAttribute("disabled", true)
                return;
            }
            const sub_district = main_sub_district_id.filter((sub) => {
                return sub.district_id == dist_id
            })
            sub_name.removeAttribute("disabled");
            sub_district.forEach((element, id) => {
                sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.id}">${element.name_th}</option>`
            });
        }

        async function getBySubDistrict() {
            const pro_value = $('#pro_value').val()
            const dist_value = $('#dis_value').val()
            const sub_value = $('#sub_district_select').find(':selected').attr('data-value')
            const sub_id = $('#sub_district_select').val()
            $('#dist_value').val(sub_value)
            getdatacountAdmin(pro_value, dist_value, sub_value)
        }

        $("#view_all").click(() => {
            $("#province_select").val("").change();
            const district_select = document.getElementById('district_select');
            district_select.innerHTML = "";
            district_select.innerHTML += ` <option value="">เลือกอำเภอ</option>`;
            const sub_name = document.getElementById('sub_district_select');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="">เลือกตำบล</option>`;
            district_select.setAttribute("disabled", true)
            sub_name.setAttribute("disabled", true)
            getdatacountAdmin()
        })
    </script>
</body>

</html>