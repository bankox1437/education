<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลนักศึกษาทั้งหมด</title>
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
                                <div class="box-header with-border">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <h4 class="box-title">ข้อมูลนักศึกษาทั้งหมด</h4>
                                        </div>
                                    </div>
                                    <div class="row mt-3 align-items-center">
                                        <div class="col-md-4">
                                            <select class="form-control" id="edu_select">
                                                <option value="0">เลือกสถานศึกษา</option>
                                            </select>
                                        </div>
                                        <a class="waves-effect waves-light btn btn-primary btn-flat ml-2" href="#" id="show-all"><i class="ti-search"></i>&nbsp;ทั้งหมด</a>
                                        <a style="display: block;" class="waves-effect waves-light btn btn-danger btn-flat ml-2" href="#" id="delete_multi_show"><i class="ti-widget-alt"></i>&nbsp;ลบหลายรายการ</a>
                                        <a style="display: none;" class="waves-effect waves-light btn btn-danger btn-flat ml-2" href="#" id="cancel_delete"><i class="ti-widget-alt"></i>&nbsp;ยกเลิก</a>
                                        <a style="display: none;" class="waves-effect waves-light btn btn-danger btn-flat ml-2" href="#" id="delete_multi"><i class="ti-widget-alt"></i>&nbsp;ลบที่เลือก</a>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-hover" style="font-size: 10px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5px;">#</th>
                                                    <th>รหัสนักศึกษา</th>
                                                    <th>ชื่อ-สกุล นักศึกษา</th>
                                                    <th>ชั้น</th>
                                                    <th>ว/ด/ป เกิด</th>
                                                    <th>เลข ปชช.</th>
                                                    <th>เพศ</th>
                                                    <th>บิดา</th>
                                                    <th>อาชีพ</th>
                                                    <th>มารดา</th>
                                                    <th>อาชีพ</th>
                                                    <th>โทรศัพท์มือถือ</th>
                                                    <!-- <th>ที่อยู่</th> -->
                                                    <th>ผู้บันทึก</th>
                                                    <th class="text-center">
                                                        <span id="show_all_text">ลบ</span>
                                                        <div id="show_all_text_checkbox" style="display: none;">
                                                            <input type="checkbox" id="md_checkbox_all" class="filled-in chk-col-danger">
                                                            <label for="md_checkbox_all" style="padding-left: 20px"></label>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="body-screening-std">
                                            </tbody>
                                        </table>
                                    </div>
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

    <script>
        $(document).ready(function() {
            getEduOfStd()
            getDataStd()
        });
        let changeBox = 0;
        let beforeSelect = 0

        function getDataStd(edu_id = '') {
            const Tbody = document.getElementById('body-screening-std');
            Tbody.innerHTML = "";
            Tbody.innerHTML += `
                    <tr>
                        <td colspan="13" class="text-center">
                            <?php include "../include/loader_include.php"; ?>
                        </td>
                    </tr>
                `
            let obj = {}
            if (edu_id == '') {
                obj = {
                    getDataStudentAdmin: true
                }
            } else {
                obj = {
                    getDataStudentAdmin: true,
                    edu_id: edu_id
                }
            }
            $.ajax({
                type: "POST",
                url: "controllers/student_controller",
                data: obj,
                dataType: 'json',
                success: function(json_res) {
                    genHtmlTable(json_res.data)
                },
            });
        }

        function getEduOfStd() {
            $.ajax({
                type: "POST",
                url: "controllers/student_controller",
                data: {
                    getEduOfStd: true
                },
                dataType: 'json',
                success: function(json_res) {
                    console.log(json_res);

                    json_res.data.forEach(element => {
                        $('#edu_select').append(`<option value="${element.id}">${element.edu_name}</option>`)
                    });
                },
            });
        }

        $('#edu_select').change((e) => {
            const edu_id = e.target.value;
            if (changeBox == 1) {
                const confirmChange = confirm('หากเปลี่ยนสถานศึกษาข้อมูลที่เลือกจะรีเซ็ต แน่ใจหรือไม่?');
                if (confirmChange) {
                    $('#delete_multi_show').show()
                    $('#cancel_delete').hide()
                    $('#show_all_text_checkbox').hide()
                    $('#show_all_text').text('ลบ')
                    $('#delete_multi').hide()
                    $('#md_checkbox_all').prop('checked', false);
                    if (edu_id != 0) {
                        getDataStd(edu_id)
                        beforeSelect = edu_id
                        $('#edu_select').val(beforeSelect)
                    } else {
                        beforeSelect = 0
                        $('#edu_select').val(beforeSelect)
                        getDataStd()
                    }
                } else {
                    $('#edu_select').val(beforeSelect)
                }
            } else {
                getDataStd(edu_id)
            }
        })

        function genHtmlTable(data) {
            const Tbody = document.getElementById('body-screening-std');
            Tbody.innerHTML = "";
            if (data.length == 0) {
                Tbody.innerHTML += `
                    <tr>
                        <td colspan="13" class="text-center">
                            ไม่มีข้อมูล
                        </td>
                    </tr>
                `
                return;
            }
            data.forEach((element, i) => {
                Tbody.innerHTML += `
                    <tr>
                        <td class="text-center">${i+1}</td>
                        <td>${element.std_code}</td>
                        <td>${element.std_prename}${element.std_name}</td>
                        <td>${element.std_class}</td>
                        <td>${element.std_birthday}</td>
                        <td>${element.national_id}</td>
                        <td  class="text-center">${element.std_gender == "" ? "-" : element.std_gender == 'ชาย' ? 
                            `<i class="fa fa-male" style="font-size:14px;color:#2BA8E2" aria-hidden="true"></i>`: 
                            `<i class="fa fa-female" style="font-size:14px;color:#F17AA8" aria-hidden="true"></i>`}
                        </td>
                        <td class="${element.std_father_name != "" ? "" : "text-center"}">${element.std_father_name == "" ? "-" : element.std_father_name}</td>
                        <td class="${element.std_father_job != "" ? "" : "text-center"}">${element.std_father_job == "" ? "-" : element.std_father_job}</td>
                        <td class="${element.std_mather_name != "" ? "" : "text-center"}">${element.std_mather_name == "" ? "-" : element.std_mather_name}</td>
                        <td class="${element.std_mather_job != "" ? "" : "text-center"}">${element.std_mather_job == "" ? "-" : element.std_mather_job}</td>
                        <td class="${element.phone != "" ? "" : "text-center"}">${element.phone == "" ? "-" : element.phone}</td>
                        
                        <td>${element.u_name == null || element.u_surname == null ? "-" : `${element.u_name } ${element.u_surname}`}</td>
                        <td class="text-center">
                            <div class="delete_multi_std" style="display:none">
                                <input type="checkbox" id="md_checkbox_${i}" value="${element.std_id}" class="filled-in chk-col-danger" onchange="check_cancel()">
                                <label for="md_checkbox_${i}" style="padding-left: 20px"></label>
                            </div>
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 delete_std" onclick="deleteStd(${
                                element.std_id
                                },'${element.std_prename}${element.std_name}')"><i class="ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            //<td>${element.home_no} ม.${element.home_moo} ต.${element.subdistrict} อ.${element.district} จ.${element.province}</td>
        }

        $('#show-all').click(() => {
            getDataStd()
        })

        function deleteStd(id, std_class) {
            const confirmDelete = confirm(
                "ต้องการลบข้อมูล " + std_class + " หรือไม่?"
            );

            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/student_controller",
                    data: {
                        delete_std: true,
                        id: id,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            getDataStd()
                        } else {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                });
            }
        }

        $('#delete_multi_show').click(() => {
            const delete_multi_std = $('.delete_multi_std')
            const delete_std = $('.delete_std');
            $('#delete_multi_show').hide()
            $('#cancel_delete').show()
            for (let i = 0; i < delete_std.length; i++) {
                delete_std[i].style.display = 'none'
                delete_multi_std[i].style.display = 'block'
            }
            $('#show_all_text_checkbox').show()
            $('#show_all_text').text('ทั้งหมด')
        });

        function check_cancel() {
            const delete_multi_std = $('.delete_multi_std');
            let check = false;
            for (let i = 0; i < delete_multi_std.length; i++) {
                if (delete_multi_std[i].children[0].checked == true) {
                    check = true;
                    changeBox = 1
                    break;
                }
                changeBox = 0
            }
            $('#delete_multi_show').hide()
            if (check) {
                $('#delete_multi').show()
                $('#cancel_delete').hide()
            } else {
                $('#cancel_delete').show()
                $('#delete_multi').hide()
            }
        }

        $('#cancel_delete').click(() => {
            $('#delete_multi_show').show()
            $('#cancel_delete').hide()
            $('#show_all_text_checkbox').hide()
            $('#show_all_text').text('ลบ')
            changeBox = 0
            const delete_multi_std = $('.delete_multi_std')
            const delete_std = $('.delete_std');
            for (let i = 0; i < delete_std.length; i++) {
                delete_std[i].style.display = 'block'
                delete_multi_std[i].style.display = 'none'
            }
        });


        $('#show_all_text_checkbox').change((e) => {
            const delete_multi_std = $('.delete_multi_std');
            if (e.target.checked) {
                $('#delete_multi').show()
                $('#cancel_delete').hide()
                changeBox = 1
                for (let i = 0; i < delete_multi_std.length; i++) {
                    delete_multi_std[i].children[0].checked = true
                }
            } else {
                $('#cancel_delete').show()
                $('#delete_multi').hide()
                for (let i = 0; i < delete_multi_std.length; i++) {
                    delete_multi_std[i].children[0].checked = false
                }
            }
        })


        $('#delete_multi').click(() => {
            const delete_multi_std = $('.delete_multi_std')
            const array_delete = [];
            for (let i = 0; i < delete_multi_std.length; i++) {
                if (delete_multi_std[i].children[0].checked) {
                    array_delete.push(delete_multi_std[i].children[0].value)
                }
            }
            const confirmDelete = confirm(
                "ต้องการลบข้อมูลนักศึกษาที่เลือกหรือไม่?"
            );

            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/student_controller",
                    data: {
                        delete_multiple_std: true,
                        arr_edu_id: JSON.stringify(array_delete),
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            $('#delete_multi_show').show()
                            $('#cancel_delete').hide()
                            $('#show_all_text_checkbox').hide()
                            $('#show_all_text').text('ลบ')
                            $('#delete_multi').hide()
                            $('#md_checkbox_all').prop('checked', false);
                            getDataStd()
                        } else {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                });
            }
        })
    </script>
</body>

</html>