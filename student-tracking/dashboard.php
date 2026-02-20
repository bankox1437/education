<?php include 'include/check_login.php';
if ($_SESSION['user_data']->role_id == 4) {
    header("location: index_student");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>หน้าหลัก </title>
    <style>
        #table_sum {
            font-size: 14px;
        }

        .font-weight-500 {
            font-weight: 500;
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
                    <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                        <?php include 'include/dashboard/card.php'; ?>
                    <?php  } else if ($_SESSION['user_data']->role_id == 2) { ?>
                        <?php //include 'include/dashboard/dashboard_amphur.php'; 
                        ?>
                        <?php include "include/form_prodissub.php"; ?>
                        <?php include 'include/dashboard/card.php'; ?>
                    <?php } else if ($_SESSION['user_data']->role_id == 1) { ?>
                        <?php //include 'include/dashboard/dashboard_admin.php'; 
                        ?>
                        <?php include "include/form_prodissub.php"; ?>
                        <?php include 'include/dashboard/card.php'; ?>
                    <?php } ?>


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
        let dis_data;
        $(document).ready(async function() {
            if (role_id == 3) {
                getdatacount()
            } else if (role_id == 2) {
                $('#sub_district_select').select2()
                await getDistrictDataAmphur().then(async (result) => {
                    dis_data = result.data[0]
                    $('#sub_dis_value').val(dis_data.dis_id);
                    await getdatacountAmphur()
                })
                await getDataProDistSub()
            } else if (role_id == 1) {
                $('#province_select').select2()
                $('#district_select').select2()
                $('#sub_district_select').select2()
                getDataProDistSub()
                getdatacountAdmin()
            }
            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                console.log($(this).data('select2').$dropdown.find('.select2-search__field'));
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        });

        function calculate_percent(count_std, data) {
            const result = ((parseInt(data) / parseInt(count_std)) * 100).toFixed(2);
            return isNaN(result) ? '0.0' : result + "%";
        }

        let main_provinces = [];
        let main_district = [];
        let main_sub_district = [];
        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true,
                    table: 'tb_students'
                },
                dataType: "json",
                success: async function(json_data) {
                    console.log(json_data);
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district_id = json_data.data.sub_district;
                    const province_select = document.getElementById('province_select');
                    if (role_id == 1) {
                        main_provinces.forEach((element, id) => {
                            province_select.innerHTML += ` <option value="${element.id}" data-value="${element.id}">${element.name_th}</option>`
                        });
                    }
                    if (role_id == 2) {

                        const sub_name = document.getElementById('sub_district_select');
                        sub_name.innerHTML = "";
                        sub_name.innerHTML += ` <option value="">เลือกตำบล</option>`;
                        console.log("dis_data.dis_id " + $('#sub_dis_value').val());
                        const sub_district = main_sub_district_id.filter((sub) => {
                            return sub.district_id == dis_data.dis_id
                        })
                        sub_district.forEach((element, id) => {
                            sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.id}">${element.name_th}</option>`
                        });
                    }

                },
            });
            return true;
        }
    </script>

    <?php if ($_SESSION['user_data']->role_id == 3) { ?>
        <!-- <script type="text/javascript" src="assets/js/view_js/dashboard.js"> -->
        <script>
            function getdatacount() {
                $.ajax({
                    type: "POST",
                    url: "controllers/dashboard_controller",
                    data: {
                        getdatacount: true
                    },
                    dataType: 'json',
                    success: function(json_res) {
                        document.getElementById('visit_home').innerHTML = json_res.data[1].visit_home
                        document.getElementById('std_person').innerHTML = json_res.data[15].std_person
                        document.getElementById('visit_sum').innerHTML = json_res.data[16].visit_sum
                    },
                });
            }
        </script>
    <?php  } else if ($_SESSION['user_data']->role_id == 2) { ?>
        <!-- <script type="text/javascript" src="assets/js/view_js/dashboard_amphur.js"></script> -->
        <script>
            async function getdatacountAmphur(sub_id = "") {
                console.log("sub_dis_value=>", $('#sub_dis_value').val());
                const teacherId = $('#teacher_select').val();
                $.ajax({
                    type: "POST",
                    url: "controllers/dashboard_controller",
                    data: {
                        getdatacountAmphur: true,
                        sub_district_id: sub_id,
                        district_id: $('#sub_dis_value').val(),
                        teacherId: teacherId
                    },
                    dataType: 'json',
                    success: function(json_res) {
                        document.getElementById('visit_home').innerHTML = json_res.data[1].visit_home
                        document.getElementById('std_person').innerHTML = json_res.data[15].std_person
                        document.getElementById('visit_sum').innerHTML = json_res.data[16].visit_sum
                    },
                });
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

            $("#view_all").click(() => {
                $("#sub_district_select").val("").change();
                $("#teacher_select").val("0").change();
                getdatacountAmphur()
                getTeacherList()
            })

            async function getBySubDistrict() {
                const sub_value = $('#sub_district_select').find(':selected').attr('data-value')
                $('#dist_value').val(sub_value)
                getdatacountAmphur(sub_value)
                getTeacherList(0, 0, sub_value)
            }
        </script>
    <?php } else if ($_SESSION['user_data']->role_id == 1) { ?>
        <!-- <script type="text/javascript" src="assets/js/view_js/dashboard_admin.js"></script> -->
        <script>
            function getdatacountAdmin(pro_id = "", dis_id = "", sub_id = "") {
                const teacherId = $('#teacher_select').val();
                console.log(pro_id, dis_id, sub_id, teacherId);
                $.ajax({
                    type: "POST",
                    url: "controllers/dashboard_controller",
                    data: {
                        getdatacountAdmin: true,
                        province_id: pro_id,
                        district_id: dis_id,
                        sub_district_id: sub_id,
                        teacherId: teacherId
                    },
                    dataType: 'json',
                    success: function(json_res) {
                        document.getElementById('visit_home').innerHTML = json_res.data[1].visit_home
                        document.getElementById('std_person').innerHTML = json_res.data[15].std_person
                        document.getElementById('visit_sum').innerHTML = json_res.data[16].visit_sum
                    },
                });
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
                $("#teacher_select").val("0").change();
                getdatacountAdmin()
                getTeacherList()
            })

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
                getTeacherList(pro_id)
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
                getTeacherList($('#province_select').val(), dist_id)
            }

            async function getBySubDistrict() {
                const pro_value = $('#pro_value').val()
                const dist_value = $('#dis_value').val()
                const sub_value = $('#sub_district_select').find(':selected').attr('data-value')
                const sub_id = $('#sub_district_select').val()
                $('#dist_value').val(sub_value)
                getdatacountAdmin(pro_value, dist_value, sub_value)
                getTeacherList(pro_value, dist_value, sub_value)
            }
        </script>
    <?php } ?>



</body>

</html>