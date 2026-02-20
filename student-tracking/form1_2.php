<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แบบบันทีกการเยี่ยมบ้าน (1.2).1 </title>
</head>
<style>
        .fixed-table-toolbar {
            display: none;
        }
    </style>
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
                                <div class="box-header with-border">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <h4 class="box-title">แบบบันทึกการเยี่ยมบ้าน</h4>
                                        </div>
                                    </div>
                                    <div class="row mt-3 align-items-center">
                                        <?php
                                        if ($_SESSION['user_data']->role_id == 1) { ?>
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
                                        <?php if ($_SESSION['user_data']->role_id != 3 && $_SESSION['user_data']->edu_type != 'edu_other') { ?>
                                            <div class="col-md-2">
                                                <select class="form-control select2" id="subdistrict_select" style="width: 100%;">
                                                    <option value="0">เลือกตำบล</option>
                                                </select>
                                                <input type="hidden" name="district_select_value" id="district_select_value" value="">
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-2">
                                            <select class="form-control" id="class_dropdown">
                                            </select>
                                        </div>
                                        <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                            <!-- <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="#" id="filter-data"><i class="ti-search"></i>&nbsp;ค้นหา</a> -->
                                            <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="form1_2_add"><i class="ti-plus"></i>&nbsp;บันทึกการเยี่ยมบ้าน</a>
                                        <?php } else { ?>
                                            <!-- <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="#" id="filter-data"><i class="ti-search"></i>&nbsp;ค้นหา</a> -->
                                            <a class="waves-effect waves-light btn btn-primary btn-flat ml-2" href="#" id="show-all"><i class="ti-search"></i>&nbsp;ทั้งหมด</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <!-- <div class="table-responsive">
                                        <table class="table table-hover" style="font-size: 14px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">ลำดับ</th>
                                                    <th>รหัสนักศึกษา</th>
                                                    <th>ชื่อ - สกุล</th>
                                                    <th>ชั้น</th>
                                                    <th>ผู้บันทึก</th>
                                                    <th>สถานศึกษา</th>
                                                    <th>แผนที่บ้าน</th>
                                                    <?php if ($_SESSION['user_data']->role_id != 3 && ($_SESSION['user_data']->edu_type != 'edu_other')) { ?>
                                                        <th>ตำบล</th>
                                                        <th>อำเภอ</th>
                                                        <th>จังหวัด</th>
                                                    <?php } ?>
                                                    <th class="text-center">พิมพ์ PDF</th>
                                                    <?php if ($_SESSION['user_data']->role_id != 2) { ?>
                                                        <th class="text-center">แก้ไข</th>
                                                        <th class="text-center">เยี่ยมบ้านเพิ่มเติม</th>
                                                        <th class="text-center">ลบ</th>
                                                    <?php  } ?>
                                                </tr>
                                            </thead>
                                            <tbody id="body-visit">
                                            </tbody>
                                        </table>
                                    </div> -->
                                    <table id="table" data-icons="icons" data-search="false" data-show-refresh="false" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/form_visit_home_controllers?getDataVisitHomeBS=true">
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
    <!-- <script src="assets/js/view_js/form_1.2.js"></script> -->
     <script src="js/form_1.2.js?v=<?php echo $version ?>"></script>
    <script>
        $(document).ready(async function() {
            // getDataVisitHome();
            initTable();
            getClassInDropdown(
                "getClassInDropdown",
                "controllers/form_visit_home_controllers"
            );
            await getDataProDistSub();
            if (role_id == 2) {
                $('#subdistrict_select').select2()
            }
            if (role_id == 1) {
                $('#province_select').select2()
                $('#district_select').select2()
                $('#subdistrict_select').select2()
            }
            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                console.log($(this).data('select2').$dropdown.find('.select2-search__field'));
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        });

           function deleteDataForm(id, name, filename) {
            const confirmDelete = confirm("ต้องการลบข้อมูลของ " + name + " หรือไม่?");
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/form_visit_home_controllers",
                    data: {
                        delete_form_1_2: true,
                        id: id,
                        filename: filename
                    },
                    dataType: "json",
                    success: function(data) {
                           if (data.status) {
                            $table.bootstrapTable('refresh');
                        } else {
                            alert(data.msg);
                        }
                    },
                });
            }
        }


    //     function getDataVisitHome() {
    //         const Tbody = document.getElementById("body-visit");
    //         Tbody.innerHTML = "";
    //         Tbody.innerHTML += `
    //         <tr>
    //             <td colspan="${role_id != 3 && type_user != "edu_other" ? 13 : 10
    // }" class="text-center">
    //              load incluse 
    //             </td>
    //         </tr>
    //     `;
    //         $.ajax({
    //             type: "POST",
    //             url: "controllers/form_visit_home_controllers",
    //             data: {
    //                 getDataVisitHome: true,
    //             },
    //             dataType: "json",
    //             success: function(json_res) {
    //                 genHtmlTable(json_res.data);
    //             },
    //         });
    //     }

    //     function genHtmlTable(data) {
    //         const Tbody = document.getElementById("body-visit");
    //         Tbody.innerHTML = "";
    //         if (data.length == 0) {
    //             Tbody.innerHTML += `
    //         <tr>
    //             <td colspan="${role_id != 3 && type_user != "edu_other" ? 13 : 10
    //   }" class="text-center">
    //                 ไม่มีข้อมูล
    //             </td>
    //         </tr>
    //     `;
    //             return;
    //         }
    //         data.forEach((element, i) => {
    //             Tbody.innerHTML += `
    //         <tr>
    //             <td class="text-center">${i + 1}</td>
    //             <td>${element.std_code}</td>
    //             <td>${element.std_prename}${element.std_name}</td>
    //             <td>${element.std_class}</td>
    //             <td>${element.user_create_data}</td>
    //             <td>${element.edu_name}</td>
    //             <td class="text-center"><a href="${element.location == ""
    //     ? "https://www.google.co.th/maps/"
    //     : element.location
    //   }" target="_blank"><i class="ti-map-alt" style="font-size:20px"></i></a></td>
    //             ${role_id != 3 && type_user != "edu_other"
    //     ? `
    //                 <td>${element.sub_district != null ? element.sub_district : "-"
    //     }</td>
    //                 <td>${element.district != null ? element.district : "-"
    //     }</td>
    //                 <td>${element.province != null ? element.province : "-"
    //     }</td>    
    //             `
    //     : ""
    //   }
    //             <td class="text-center">
    //                 <a href="pdf/แบบบันทึกการเยี่ยมบ้าน?form_id=${element.form_visit_id
    //   }" target="_blank">
    //                     <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-printer"></i></button>
    //                 </a>
    //             </td>
    //             ${role_id != 2 ?
    //     `
    //               <td class="text-center">
    //                   <a href="form1_2_edit.php?form_visit_id=${element.form_visit_id}&std_name=${element.std_prename}${element.std_name}">
    //                               <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
    //                           </a>
    //               </td>
    //                 <td class="text-center">
    //                 ${element.form_status == 1 ?
    //       `
    //                            <a href="form1_3_new_edit.php?form_visit_id=${element.form_visit_id
    //       }&std_name=${element.std_prename}${element.std_name}">
    //                               <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
    //                           </a>
    //                           `
    //       :
    //       `
    //                             <a href="form1_3_add_new.php?form_visit_id=${element.form_visit_id
    //       }&std_name=${element.std_prename}${element.std_name}">
    //                               <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-plus"></i></button>
    //                           </a>
                             
    //                           `
    //     }
    //                       </td>
    //               <td class="text-center">
                      
    //                   <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5" onclick="deleteDataForm(${element.form_visit_id
    //     },'${element.std_name}','${element.home_img}')"><i class="ti-trash"></i></button>
    //               </td>
    //               ` : ''
    //   }
    //         </tr>
    //     `;
    //         });
    //         // <a href="manage_admin_edit?form_id=${element.form_evaluate_id}">
    //         //     <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
    //         // </a>
    //     }

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
        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true,
                    table: 'stf_tb_form_student_person_new'
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
                        let dis_data;
                        await getDistrictDataAmphur().then((result) => {
                            dis_data = result.data[0]
                        })
                        const sub_name = document.getElementById('subdistrict_select');
                        sub_name.innerHTML = "";
                        sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
                        $('#district_select_value').val(dis_data.dis_id);
                        const sub_district = main_sub_district_id.filter((sub) => {
                            return sub.district_id == dis_data.dis_id
                        })
                        sub_district.forEach((element, id) => {
                            sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                        });
                    }
                },
            });
        }

        $('#province_select').change((e) => {
            getDataByWhere()
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
            getDataByWhere()
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

        // $('#filter-data').click(() => getDataByWhere())
        $('#subdistrict_select').change((e) => {
            getDataByWhere()
        })

        $('#class_dropdown').change((e) => {
            getDataByWhere()
        })

        $('#show-all').click(() => {
            // getStudentPerson();
            $("#province_select").val(0).change();
            $("#district_select").val(0).change();
            $("#subdistrict_select").val(0).change();
            $("#class_dropdown").val(0).change();
            getDataByWhere()
        });

       
        function getDataByWhere() {
            const pro_id = $('#province_select').val() ?? 0
            const dis_id = $('#district_select').val() ?? 0
            const sub_dis_id = $('#subdistrict_select').val() ?? 0
            const std_class = $('#class_dropdown').val() ?? "";

            var urlWithParams = $table.data('url') + `&pro_id=${pro_id}&dis_id=${dis_id}&sub_dis_id=${sub_dis_id}&std_class=${std_class}`;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
            $table.bootstrapTable('refresh');
        }

        // function getDataByWhere() {
        //     const pro_id = $('#province_select').val() ?? 0
        //     const dis_id = $('#district_select').val() ?? 0
        //     const sub_district_id = $('#subdistrict_select').val() ?? 0
        //     const std_class = $("#class_dropdown").val() ?? 0
        //     console.log("pro_id=>", pro_id, "dis_id", dis_id, "sub_district_id", sub_district_id, "std_class", std_class);
        //     if (pro_id == '0' && dis_id == '0' && sub_district_id == '0' && std_class == "0") {
        //         getDataVisitHome();
        //     } else {
        //         let obj = {}
        //         if (role_id == 1) {
        //             obj = {
        //                 pro_id: pro_id,
        //                 dis_id: dis_id,
        //                 std_class: std_class,
        //                 sub_district_id: sub_district_id,
        //                 getDataVisitHomeByClass: true
        //             }
        //         }

        //         if (role_id == 2) {
        //             obj = {
        //                 pro_id: pro_id,
        //                 dis_id: dis_id,
        //                 std_class: std_class,
        //                 sub_district_id: sub_district_id,
        //                 getDataVisitHomeByAmphur: true
        //             }
        //         }

        //         if (role_id == 3) {
        //             obj = {
        //                 pro_id: pro_id,
        //                 dis_id: dis_id,
        //                 std_class: std_class,
        //                 sub_district_id: sub_district_id,
        //                 getDataVisitHomeByClass: true
        //             }
        //         }

        //         $.ajax({
        //             type: "POST",
        //             url: "controllers/form_visit_home_controllers",
        //             data: obj,
        //             dataType: "json",
        //             success: function(json_res) {
        //                 if (json_res.status) {
        //                     genHtmlTable(json_res.data);
        //                 }
        //             },
        //         });
        //     }
        // }

        // function getDataByWhere() {
        //   const std_class = $("#class_dropdown").val();
        //   let sub_district_id = 0;
        //   if (role_id != 3 && type_user != "edu_other") {
        //     sub_district_id = $("#subdistrict_select").val();
        //   }
        //   if (std_class == "0" && sub_district_id == "0") {
        //     getDataVisitHome();
        //   } else {
        //     $.ajax({
        //       type: "POST",
        //       url: "controllers/form_visit_home_controllers",
        //       data: {
        //         getDataVisitHomeByClass: true,
        //         std_class: std_class ?? 0,
        //         sub_district_id: sub_district_id ?? 0,
        //       },
        //       dataType: "json",
        //       success: function (json_res) {
        //         if (json_res.status) {
        //           genHtmlTable(json_res.data);
        //         }
        //       },
        //     });
        //   }
        // }
    </script>
</body>

</html>