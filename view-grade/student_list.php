<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>สมุดบันทึกนักศึกษา</title>
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

        .delete_multi_std {
            margin-top: 10px;
        }

        .delete_std {
            font-size: 14px;
            margin-top: 5px;
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
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="box-title mr-3">รายชื่อนักศึกษาที่บันทึกสรุปการเรียนแล้ว</h4>
                                        <!-- <div class="row">
                                            <div class="col">
                                                <input type="file" id="import_excel_students" hidden accept=".xls,.xlsx" onchange="importStudent(this)" />
                                                <label for="import_excel_students" class="import-excel"><i class="ti-import"></i>&nbsp;&nbsp;
                                                    นำเข้าข้อมูลนักศึกษา</label>
                                            </div>
                                            <a href="uploads/example-students.xlsx" class="example-import">ดาวน์โหลดตัวอย่าง Excel นักศึกษา</a>
                                        </div> -->
                                        <!-- <div class="row">
                                            <div class="col text-right">
                                                <a style="display: block;" class="waves-effect waves-light btn btn-danger btn-flat ml-2" href="#" id="delete_multi_show"><i class="ti-widget-alt"></i>&nbsp;ลบหลายรายการ</a>
                                                <a style="display: none;" class="waves-effect waves-light btn btn-danger btn-flat ml-2" href="#" id="cancel_delete"><i class="ti-widget-alt"></i>&nbsp;ยกเลิก</a>
                                                <a style="display: none;" class="waves-effect waves-light btn btn-danger btn-flat ml-2" href="#" id="delete_multi"><i class="ti-widget-alt"></i>&nbsp;ลบที่เลือก</a>
                                            </div>
                                        </div> -->
                                    </div>

                                    <?php include "../config/class_database.php";
                                    $DB = new Class_Database();
                                    $sql = "SELECT\n" .
                                        "	std.std_id,\n" .
                                        "	std.std_code,\n" .
                                        "	CONCAT( std.std_prename, ' ', std.std_name ) AS std_name,\n" .
                                        "	COUNT( se.event_id ) AS count_se \n" .
                                        "FROM\n" .
                                        "	tb_students std\n" .
                                        "	LEFT JOIN vg_save_event se ON std.std_id = se.std_id \n" .
                                        "WHERE\n" .
                                        "	std.user_create = :user_create \n" .
                                        "GROUP BY\n" .
                                        "	std.std_code,\n" .
                                        "	std.std_prename,\n" .
                                        "	std.std_name \n" .
                                        "HAVING\n" .
                                        "	count_se != 0 \n" .
                                        "ORDER BY\n" .
                                        "	std.std_code ASC;";
                                    $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id]);
                                    $event_data = json_decode($data);
                                    ?>

                                </div>
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-hover" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5px;">#</th>
                                                    <th>รหัสนักศึกษา</th>
                                                    <th>ชื่อ-สกุล นักศึกษา</th>
                                                    <th class="text-center">ดูสมุดบันทึก</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body-screening-std">
                                                <?php if (count($event_data) == 0) {
                                                    echo  '<tr>
                                                                <td colspan="4" class="text-center">
                                                                    ไม่มีข้อมูล
                                                                </td>
                                                            </tr>';
                                                } else {
                                                    $i = 1;
                                                    foreach ($event_data as $key => $value) { ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $i; ?></td>
                                                            <td><?php echo $value->std_code ?></td>
                                                            <td><?php echo $value->std_name ?></td>
                                                            <td class="text-center">
                                                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5">
                                                                    <a href="manage_save_event?std_id=<?php echo $value->std_id ?>&name=<?php echo $value->std_name ?>">
                                                                        <i class="fa fa-book"></i>
                                                                    </a>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                <?php $i++;
                                                    }
                                                } ?>

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
    <!-- <button type="button" class="btn btn-primary" id="click-show-modal" data-toggle="modal" data-target="#modal-fill" style="visibility: hidden;">
    </button> -->
    <!-- Modal -->
    <!-- <div class="modal modal-fill fade" data-backdrop="false" id="modal-fill" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="">
                    <h2 class="modal-title m-0 text-danger"><b>แจ้งเตือน</b></h2>
                </div>
                <div class="modal-body">
                    <h2>ท่านจะยังไม่สามารถใช้งานระบบได้ เนื่องจาก</h2>
                    <h2>แอดมินอำเภอยังไม่ได้ตั้งค่าปีการศึกษา</h2>
                    <br>
                    <h2>โปรดติดต่อแอดมินอำเภอหรือแอดมินระบบ</h2>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-danger" onclick="logout()">ออกจากระบบ</button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- /.modal -->

    <?php include 'include/scripts.php'; ?>

    <script>
        $(document).ready(function() {
            <?php if (!isset($_SESSION['term_active']) && $_SESSION['user_data']->role_id == 3) { ?>
                // document.getElementById("click-show-modal").click();
            <?php } ?>
            // getDataStd()
        });

        function importStudent(file) {
            const CSVfile = file.files[0];
            var formData = new FormData();
            formData.append("csv_file", CSVfile);
            formData.append("import_students", true)

            var xhttp = new XMLHttpRequest();
            const url = "controllers/std_controller.php";
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
                    file.value = null;
                }
            };
            xhttp.send(formData);
        }

        function getDataStd() {
            const Tbody = document.getElementById('body-screening-std');
            Tbody.innerHTML = "";
            Tbody.innerHTML += `
                    <tr>
                        <td colspan="15" class="text-center">
                            <?php include "include/loader_include.php"; ?>
                        </td>
                    </tr>
                `
            $.ajax({
                type: "POST",
                url: "controllers/std_controller",
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
                        <td colspan="15" class="text-center">
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
                        <!-- <td  class="text-center">${element.std_gender == "" ? "-" : element.std_gender == 'ชาย' ? 
                            `<i class="fa fa-male" style="font-size:14px;color:#2BA8E2" aria-hidden="true"></i>`: 
                            `<i class="fa fa-female" style="font-size:14px;color:#F17AA8" aria-hidden="true"></i>`}
                        </td>
                        <td class="${element.std_father_name != "" ? "" : "text-center"}">${element.std_father_name == "" ? "-" : element.std_father_name}</td>
                        <td class="${element.std_father_job != "" ? "" : "text-center"}">${element.std_father_job == "" ? "-" : element.std_father_job}</td>
                        <td class="${element.std_mather_name != "" ? "" : "text-center"}">${element.std_mather_name == "" ? "-" : element.std_mather_name}</td>
                        <td class="${element.std_mather_job != "" ? "" : "text-center"}">${element.std_mather_job == "" ? "-" : element.std_mather_job}</td>
                        <td class="${element.phone != "" ? "" : "text-center"}">${element.phone == "" ? "-" : element.phone}</td>
                        <td class="${element.address != "" ? "" : "text-center"}">${element.address == "" ? "-" : element.address}</td> -->
                        <td class="text-center">
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5">
                                <a href="manage_save_event?std_id=${element.std_id}&name=${element.std_prename}${element.std_name}">
                                    <i class="ti-file"></i>
                                </a>
                            </button>
                           
                        </td>
                        <td class="text-center">
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-outline-danger" onclick="deleteStd(${
                                element.std_id
                                },'${element.std_prename}${element.std_name}')"><i class="ti-trash"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <div class="delete_multi_std" style="display:none">
                                <input type="checkbox" id="md_checkbox_${i}" value="${element.std_id}" class="filled-in chk-col-danger" onchange="check_cancel()">
                                <label for="md_checkbox_${i}" style="padding-left: 20px"></label>
                            </div>
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 delete_std" onclick="deleteStd(${
                                element.std_id
                                },'${element.std_prename}${element.std_name}','deleteStd')"><i class="ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }

        function deleteStd(id, std_name, mode = "") {

            let textAlert = "ต้องการลบข้อมูลนักศึกษา " + std_name + " หรือไม่?";
            let textAlertSucess = "ลบข้อมูลนักศึกษาเรียบร้อย";
            if (mode == 'deleteStd') {
                textAlert = "ต้องการลบบัญชีนักศึกษา " + std_name + " หรือไม่?";
                textAlertSucess = "ลบบัญชีนักศึกษาเรียบร้อย";
            }

            const confirmDelete = confirm(textAlert);

            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/std_controller",
                    data: {
                        delete_std: true,
                        id: id,
                        mode: mode
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            alert(textAlertSucess);
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
            $('#show_all_text').text('ลบผู้ใช้')
            changeBox = 0
            const delete_multi_std = $('.delete_multi_std')
            const delete_std = $('.delete_std');
            for (let i = 0; i < delete_std.length; i++) {
                delete_std[i].style.display = 'block'
                delete_std[i].parentElement.style.display = 'flex'
                delete_std[i].parentElement.style.justifyContent = 'center'
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
                    url: "controllers/std_controller",
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