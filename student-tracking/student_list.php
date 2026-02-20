<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นำเข้านักศึกษา</title>
    <style>
        .import-excel {
            display: inline-block;
            background-color: #1e613b;
            color: white;
            padding: 0.5rem;
            border-radius: 0.3rem;
            cursor: pointer;
        }

        .example-import {
            display: inline-block;
            padding: 0.5rem;
            border-radius: 0.3rem;
            cursor: pointer;
        }

        .table tbody tr td {
            padding: 5px;
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
                                <div class="box-header with-border">
                                    <h4 class="text-center mb-3 h3">รายชื่อนักศึกษา</h4>
                                    <div class="d-flex justify-content-between align-items-center">

                                        <!-- <div class="row">
                                            <div class="col">
                                                <input type="file" id="import_excel_students" hidden accept="" onchange="importStudent(this)" />
                                                <label for="import_excel_students" class="import-excel"><i class="ti-import"></i>&nbsp;&nbsp;
                                                    นำเข้าข้อมูลนักศึกษา</label>
                                            </div>
                                            <a href="images/example-students.xlsx" class="example-import">ดาวน์โหลดตัวอย่าง Excel นักศึกษา</a>
                                        </div> -->
                                        <div class="col text-right">
                                            <a style="display: block;" class="waves-effect waves-light btn btn-info btn-flat ml-2" href="#" id="change_multi_show"><i class="ti-widget-alt"></i>&nbsp;เลื่อนชั้นหลายรายการ</a>
                                            <a style="display: none;" class="waves-effect waves-light btn btn-info btn-flat ml-2" href="#" id="cancel_change"><i class="ti-widget-alt"></i>&nbsp;ยกเลิก</a>
                                            <a style="display: none;" class="waves-effect waves-light btn btn-info btn-flat ml-2" href="#" id="change_multi"><i class="ti-widget-alt"></i>&nbsp;เลื่อนชั้นจากที่เลือก</a>
                                        </div>
                                        <div class="col text-right">
                                            <a style="display: block;" class="waves-effect waves-light btn btn-danger btn-flat ml-2" href="#" id="delete_multi_show"><i class="ti-widget-alt"></i>&nbsp;ลบหลายรายการ</a>
                                            <a style="display: none;" class="waves-effect waves-light btn btn-danger btn-flat ml-2" href="#" id="cancel_delete"><i class="ti-widget-alt"></i>&nbsp;ยกเลิก</a>
                                            <a style="display: none;" class="waves-effect waves-light btn btn-danger btn-flat ml-2" href="#" id="delete_multi"><i class="ti-widget-alt"></i>&nbsp;ลบที่เลือก</a>
                                        </div>

                                    </div>

                                </div>
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-hover" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5px;">#</th>
                                                    <th>รหัสนักศึกษา</th>
                                                    <th>ชื่อ-สกุล นักศึกษา</th>
                                                    <th class="text-center">
                                                        <span id="show_all_text_class">ชั้น</span>
                                                        <div id="show_all_text_checkbox_class" style="display: none;">
                                                            <input type="checkbox" id="ch_checkbox_all" class="filled-in chk-col-info">
                                                            <label for="ch_checkbox_all" style="padding-left: 20px"></label>
                                                        </div>
                                                    </th>
                                                    <th>ว/ด/ป เกิด</th>
                                                    <th style="width: 100px;">เลขบัตร ปชช.</th>
                                                    <!-- <th>เพศ</th>
                                                    <th>บิดา</th>
                                                    <th>อาชีพ</th>
                                                    <th>มารดา</th>
                                                    <th>อาชีพ</th>
                                                    <th>โทรศัพท์</th>
                                                    <th>ที่อยู่</th> -->
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

    <button type="button" class="btn btn-primary" id="click-show-modal" data-toggle="modal" data-target="#modal-center" style="visibility: hidden;">
    </button>
    <!-- Modal -->
    <div class="modal center-modal fade" id="modal-center" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เลือกลำดับชั้นถัดไป</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4" id="render_std_show" style="max-height: 300px;overflow-y: scroll;">
                        <p class="col-md-6 text-center">นางน้อมจิต แก้วมณี</p>
                    </div>

                    <div>
                        <select class="form-control" id="std_class_change" style="width: 100%;">
                            <option value="0">เลือกชั้น</option>
                            <option value="ประถม">ประถม</option>
                            <option value="ม.ต้น">ม.ต้น</option>
                            <option value="ม.ปลาย">ม.ปลาย</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer modal-footer-uniform">
                    <button type="button" class="btn btn-primary float-right" onclick="saveChangeClass()">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <?php include 'include/scripts.php'; ?>

    <script>
        $(document).ready(function() {
            getDataStd()
        });

        function importStudent(file) {
            const CSVfile = file.files[0];
            var formData = new FormData();
            formData.append("csv_file", CSVfile);
            formData.append("import_students", true)

            var xhttp = new XMLHttpRequest();
            const url = "controllers/student_controller.php";
            xhttp.open("POST", url, true);
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    if (response.status) {
                        alert(response.msg);
                        getDataStd();
                    } else {
                        alert(response.msg);
                        window.location.reload();
                    }
                    file.value = "";
                }
            };
            xhttp.send(formData);
        }

        function getDataStd() {
            const Tbody = document.getElementById('body-screening-std');
            Tbody.innerHTML = "";
            Tbody.innerHTML += `
                    <tr>
                        <td colspan="13" class="text-center">
                            <?php include "../include/loader_include.php"; ?>
                        </td>
                    </tr>
                `
            $.ajax({
                type: "POST",
                url: "controllers/student_controller",
                data: {
                    getDataStudent: true
                },
                dataType: 'json',
                success: function(json_res) {
                    genHtmlTable(json_res.data)
                },
            });
        }

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
                        <td class="text-center">
                            ${element.std_class}
                            <div class="change_multi_std" style="display:none">
                                <input type="checkbox" id="ch_checkbox_${i}" value="${element.std_id}" data-stdName="${element.std_prename}${element.std_name}" class="filled-in chk-col-info" onchange="check_cancel('change_multi_std','change_multi_show','change_multi','cancel_change')">
                                <label for="ch_checkbox_${i}" style="padding-left: 20px"></label>
                            </div>
                            <button type="button" style="width:20px;height:20px;margin-top: 5px;width:20px;height:20px;padding-top: 2px;padding-right: 2px;" class="waves-effect waves-circle btn btn-circle btn-info mb-5 change_std" onclick="openmModalChangeClass(${element.std_id},'${element.std_prename}${element.std_name}')">
                                <i class="ti-exchange-vertical" style="font-size: 11px !important;"></i>
                            </button>
                        </td>
                        <td>${element.std_birthday}</td>
                        <td>${element.national_id}</td>
                       
                        <td class="text-center">
                            <div class="delete_multi_std" style="display:none">
                                <input type="checkbox" id="md_checkbox_${i}" value="${element.std_id}" class="filled-in chk-col-danger" onchange="check_cancel('delete_multi_std','delete_multi_show','delete_multi','cancel_delete')">
                                <label for="md_checkbox_${i}" style="padding-left: 20px"></label>
                            </div>
                            <button type="button" style="width:30px;height:30px;" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 delete_std" onclick="deleteStd(${
                                element.std_id
                                },'${element.std_prename}${element.std_name}')"><i class="ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }

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
            $('#cancel_delete').css('display', 'block');
            for (let i = 0; i < delete_std.length; i++) {
                delete_std[i].style.display = 'none'
                delete_multi_std[i].style.display = 'block'
            }
            $('#show_all_text_checkbox').show()
            $('#show_all_text').text('ทั้งหมด')
        });

        $('#change_multi_show').click(() => {
            const change_multi_std = $('.change_multi_std')
            const change_std = $('.change_std');
            $('#change_multi_show').hide()
            $('#cancel_change').show()
            $('#cancel_change').css('display', 'block');
            for (let i = 0; i < change_std.length; i++) {
                change_std[i].style.display = 'none'
                change_multi_std[i].style.display = 'block'
            }
            $('#show_all_text_checkbox_class').show()
            $('#show_all_text_class').text('ทั้งหมด')
        });

        function check_cancel(class_multi_std, class_multi_show, class_multi, cancel_class) {
            const delete_multi_std = $('.' + class_multi_std);
            let check = false;
            for (let i = 0; i < delete_multi_std.length; i++) {
                if (delete_multi_std[i].children[0].checked == true) {
                    check = true;
                    changeBox = 1
                    break;
                }
                changeBox = 0
            }
            $('#' + class_multi_show).hide()
            if (check) {
                $('#' + class_multi).show()
                $('#' + class_multi).css('display', 'block')
                $('#' + cancel_class).hide()
            } else {
                $('#' + cancel_class).show()
                $('#' + cancel_class).css('display', 'block')
                $('#' + class_multi).hide()
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
                delete_std[i].style.display = 'inline-block'
                delete_multi_std[i].style.display = 'none'
            }
        });

        $('#cancel_change').click(() => {
            $('#change_multi_show').show()
            $('#cancel_change').hide()
            $('#show_all_text_checkbox_class').hide()
            $('#show_all_text_class').text('ลบ')
            changeBox = 0
            const change_multi_std = $('.change_multi_std')
            const change_std = $('.change_std');
            for (let i = 0; i < change_std.length; i++) {
                change_std[i].style.display = 'inline-block'
                change_multi_std[i].style.display = 'none'
            }
        });


        $('#show_all_text_checkbox').change((e) => {
            const delete_multi_std = $('.delete_multi_std');
            if (e.target.checked) {
                $('#delete_multi').show()
                $('#delete_multi').css('display', 'block');
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

        $('#show_all_text_checkbox_class').change((e) => {
            const change_multi_std = $('.change_multi_std');
            if (e.target.checked) {
                $('#change_multi').show()
                $('#change_multi').css('display', 'block');
                $('#cancel_change').hide()
                changeBox = 1
                for (let i = 0; i < change_multi_std.length; i++) {
                    change_multi_std[i].children[0].checked = true
                }
            } else {
                $('#cancel_change').show()
                $('#change_multi').hide()
                for (let i = 0; i < change_multi_std.length; i++) {
                    change_multi_std[i].children[0].checked = false
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

        let array_change = [];
        $('#change_multi').click(() => {
            const confirmchange = confirm(
                "ต้องการเลื่อนชั้นนักศึกษาที่เลือกหรือไม่?"
            );
            if (confirmchange) {
                array_change = [];
                const change_multi_std = $('.change_multi_std');
                $('#render_std_show').empty();
                for (let i = 0; i < change_multi_std.length; i++) {
                    if (change_multi_std[i].children[0].checked) {
                        let std_name = change_multi_std[i].children[0].getAttribute("data-stdName");
                        array_change.push({
                            "std_id": change_multi_std[i].children[0].value,
                            "std_name": std_name
                        })

                        $('#render_std_show').append(`<p class="col-md-6 text-center">${std_name}</p>`)
                    }
                }
                document.getElementById("click-show-modal").click();
                return;
            }
        })

        function openmModalChangeClass(std_id, std_name) {
            array_change = [];
            array_change.push({
                "std_id": std_id,
                "std_name": std_name
            })
            $('#render_std_show').empty();
            $('#render_std_show').append(`<p class="col-md-12 text-center">${std_name}</p>`)
            document.getElementById("click-show-modal").click();
        }


        function saveChangeClass() {
            if ($('#std_class_change').val() == "0") {
                $('#std_class_change').focus();
                alert('โปรดเลือกชั้น');
                return;
            }
            $.ajax({
                type: "POST",
                url: "controllers/student_controller",
                data: {
                    change_multiple_std: true,
                    arr_std: JSON.stringify(array_change),
                    class_name: $('#std_class_change').val()
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.status) {
                        alert("Student changed class");
                        location.reload();
                    } else {
                        alert(data.msg);
                        window.location.reload();
                    }
                },
            });
        }
    </script>
</body>

</html>