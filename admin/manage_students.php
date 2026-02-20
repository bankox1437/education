<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลนักศึกษาทั้งหมด</title>
    <style>
        #table {
            font-size: 10px;
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
                                <input type="hidden" id="role_value" value="0">
                                <div class="row align-items-center mt-4">
                                    <div class="col-md-3">
                                        <h4 class="mt-2 ml-3">ตารางข้อมูลนักศึกษาทั้งหมด</h4>
                                    </div>
                                    <div class="col-md-2" style="padding: 0px 15px;">
                                        <select class="form-control select2" id="edu_select" style="width: 100%;">
                                            <option value="0">เลือกสถานศึกษา</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-body no-padding">

                                    <div class="row align-items-center px-2">
                                        <div class="col-md-2 mt-2">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="pro_name" id="pro_name" data-placeholder="เลือกจังหวัด" style="width: 100%;">
                                                    <option value="0">เลือกจังหวัด</option>
                                                </select>
                                                <input type="hidden" name="pro_name_text" id="pro_name_text" value="">
                                                <!-- <input type="text" class="form-control height-input" name="pro_name" id="pro_name" placeholder="กศน. จังหวัด"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-2">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="dis_name" id="dis_name" disabled data-placeholder="เลือกอำเภอ" style="width: 100%;">
                                                    <option value="0">เลือกอำเภอ</option>
                                                    <input type="hidden" name="dis_name_text" id="dis_name_text" value="">
                                                </select>
                                                <!-- <input type="text" class="form-control height-input" name="dis_name" id="dis_name" placeholder="กศน. อำเภอ"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-2" id="sub_dis" style="display: block;">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="sub_name" id="sub_name" disabled data-placeholder="เลือกตำบล" style="width: 100%;">
                                                    <option value="0">เลือกตำบล</option>
                                                </select>
                                                <!-- <input type="text" class="form-control height-input" name="sub_name" id="sub_name" placeholder="กศน. ตำบล"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-2" style="display: block;">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="teacher_name" id="teacher_name" data-placeholder="เลือกครู" style="width: 100%;">
                                                    <option value="0">เลือกครู</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 ml-auto mt-1" style="min-width: 200px;">
                                            <input type="text" class="form-control" id="searchInput" placeholder="ค้นหาด้วยชื่อ นศ." onkeyup="getByWhere()" />
                                        </div>
                                        <div class="col-md-12">
                                            <span class="badge badge-pill mt-2 badge-danger" id="delete_btn" style="cursor: pointer;">ลบข้อมูลที่เลือก</span>
                                        </div>
                                        <!-- <a class="col-md-2 mt-2 waves-effect waves-light btn btn-success btn-flat ml-2" href="manage_admin_add"><i class="ti-plus"></i>&nbsp;เพิ่มแอดมิน</a> -->
                                    </div>
                                    <table id="table" data-icons="icons" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/student_controller?getDataStudentAdminNew=true">
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

    <button type="button" class="btn btn-primary" id="click-show-modal" data-toggle="modal" data-target="#modal_move" style="visibility: hidden;">
    </button>
    <!-- Modal -->
    <div class="modal center-modal fade" id="modal_move" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ย้ายข้อมูลนักศึกษา</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    include "../config/class_database.php";
                    $DB = new Class_Database();

                    $sql = "SELECT edu.*,concat(tu.name,' ',tu.surname) uname,tu.id uid FROM tbl_non_education edu
                                LEFT JOIN tb_users tu ON edu.id = tu.edu_id AND role_id  = 3";
                    $query = $DB->Query($sql, []);
                    $edu_data = json_decode($query);

                    ?>
                    <div class="row mb-2" id="render_std_show_gender">
                        <h3 class="col-md-12 text-center" id="std_move_name"></h3>
                        <input type="hidden" id="std_move_id" value="">
                        <p class="col-md-12 text-center"><i class="fa fa-retweet" style="font-size:30px"></i></p>
                    </div>
                    <div>
                        <select class="form-control select2" id="edu_move" style="width: 100%;">
                            <option value="0">เลือกสถานศึกษาหรือกลุ่มที่ต้องการย้ายไป</option>
                            <?php foreach ($edu_data as $key => $value) { ?>
                                <option value="<?php echo $value->uid ?>"><?php echo $value->name ?> - <?php echo $value->uname ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer modal-footer-uniform text-center">
                    <button type="button" class="btn btn-primary" onclick="saveMoveStd()">บันทึกการย้าย</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <?php include 'include/scripts.php'; ?>
    <script src="js/manage_students.js?v=<?php echo rand(0, 9) ?>"></script>
    <?php include 'js/prodissub.js.php'; ?>
    <script>
        $(document).ready(async function() {
            getTeacherStd();
            getEduOfStd()
            initTable()
            await getDataProDistSub();
            $('#edu_select').select2()
            $('#pro_name').select2()
            $('#dis_name').select2()
            $('#sub_name').select2()
            $('#teacher_name').select2()

            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                console.log($(this).data('select2').$dropdown.find('.select2-search__field'));
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        });

        let changeBox = 0;
        let beforeSelect = 0

        $('#pro_name').on('change', (e) => getDistrictByProvince(e.target.value, getDataStdByProDisSub));
        $('#dis_name').on('change', (e) => getSubDistrictByDistrict(e.target.value, getDataStdByProDisSub));
        $('#sub_name').on('change', () => getDataStdByProDisSub());
        $('#edu_select').on('change', () => getDataStdByProDisSub());
        $('#teacher_name').on('change', () => getDataStdByProDisSub("teacherChange"));

        const getByWhere = () => {
            let paramPlus = "";
            let pro = $('#pro_name').val()
            let dis = $('#dis_name').val()
            let sub = $('#sub_name').val()
            let teacher = $('#teacher_name').val()
            let edu_id = $('#edu_select').val()
            let search = $('#searchInput').val()

            if (pro != 0) {
                paramPlus += '&province_id=' + pro;
                $('#edu_select').attr('disabled', true)
            } else {
                $('#edu_select').removeAttr('disabled')
            }
            if (dis != 0) {
                paramPlus += '&district_id=' + dis;
            }
            if (sub != 0) {
                paramPlus += '&subdistrict_id=' + sub;
            }
            if (teacher != 0) {
                paramPlus += '&teacher_id=' + teacher;
            }
            if (search != "") {
                paramPlus += '&search=' + search;
            }
            var urlWithParams = $table.data('url') + paramPlus;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }

        const getDataStdByProDisSub = (mode = "") => {
            if (mode == '') {
                getTeacherStd();
            }
            let paramPlus = "";
            let pro = $('#pro_name').val()
            let dis = $('#dis_name').val()
            let sub = $('#sub_name').val()
            let teacher = $('#teacher_name').val()
            let edu_id = $('#edu_select').val()
            let search = $('#searchInput').val()
            if (edu_id != 0) {
                $('#pro_name').attr('disabled', true)
                $('#dis_name').attr('disabled', true)
                $('#sub_name').attr('disabled', true)
            } else {
                $('#pro_name').removeAttr('disabled')
            }
            let edu_type = $($('#edu_select').select2('data')[0].element).attr("data-edu-type");
            paramPlus += '&edu_id=' + edu_id + '&edu_type=' + edu_type;

            if (changeBox == 1) {
                const confirmChange = confirm('หากเปลี่ยนสถานศึกษาข้อมูลที่เลือกจะรีเซ็ต แน่ใจหรือไม่?');
                if (confirmChange) {
                    $('#md_checkbox_all').prop('checked', false);
                    changeBox = 0
                }
            }

            if (pro != 0) {
                paramPlus += '&province_id=' + pro;
                $('#edu_select').attr('disabled', true)
            } else {
                $('#edu_select').removeAttr('disabled')
            }
            if (dis != 0) {
                paramPlus += '&district_id=' + dis;
            }
            if (sub != 0) {
                paramPlus += '&subdistrict_id=' + sub;
            }
            if (teacher != 0) {
                paramPlus += '&teacher_id=' + teacher;
            }
            if (search != "") {
                paramPlus += '&search=' + search;
            }
            var urlWithParams = $table.data('url') + paramPlus;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
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
                        $('#edu_select').append(`<option value="${element.edu_id}" data-edu-type="${element.edu_type}">${element.edu_name}</option>`)
                    });
                },
            });
        }

        function selectAll(e) {
            const delete_multi_std = $('.delete_multi_std');
            if (e.checked) {
                changeBox = 1
                for (let i = 0; i < delete_multi_std.length; i++) {
                    delete_multi_std[i].checked = true
                }
            } else {
                changeBox = 0
                for (let i = 0; i < delete_multi_std.length; i++) {
                    delete_multi_std[i].checked = false
                }
            }
        }

        function check_cancel() {
            const delete_multi_std = $('.delete_multi_std');
            let check = false;
            for (let i = 0; i < delete_multi_std.length; i++) {
                if (delete_multi_std[i].checked == true) {
                    check = true;
                    changeBox = 1
                    break;
                }
                changeBox = 0
            }
            // $('#delete_multi_show').hide()
            // if (check) {
            //     $('#delete_multi').show()
            //     $('#cancel_delete').hide()
            // } else {
            //     $('#cancel_delete').show()
            //     $('#delete_multi').hide()
            // }
        }

        $('#delete_btn').click(() => {
            const delete_multi_std = $('.delete_multi_std')
            const array_delete = [];
            for (let i = 0; i < delete_multi_std.length; i++) {
                if (delete_multi_std[i].checked) {
                    array_delete.push(delete_multi_std[i].value)
                }
            }

            if (array_delete.length == 0) {
                alert('โปรดเลือกข้อมูลที่ต้องการลบ')
                return;
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
                            $('#md_checkbox_all').prop('checked', false);
                            $table.bootstrapTable('refresh');
                        } else {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                });
            }
        })

        function getTeacherStd() {
            $('#teacher_name').val(0)
            let edu_type = ($('#edu_select').val() != 0 ? $($('#edu_select').select2('data')[0].element).attr("data-edu-type") : '');
            let dataFilter = {
                province_id: $('#pro_name').val(),
                district_id: $('#dis_name').val(),
                subdistrict_id: $('#sub_name').val(),
                edu_id: $('#edu_select').val(),
                edu_type: edu_type
            };

            $.post("controllers/student_controller", {
                getTeacherStd: true,
                dataFilter: dataFilter
            }, function(json_res) {

                let selectedValue = $('#teacher_name').val();
                let options = '<option value="0">เลือกครู</option>';

                json_res.data.forEach(element => {
                    options += `<option value="${element.id}">${element.full_name}</option>`;
                });

                $('#teacher_name').html(options).val(selectedValue);
            }, 'json');
        }

        function openModal(std_id, std_name) {
            $('#std_move_id').val(std_id);
            $('#std_move_name').html(std_name);
            document.getElementById("click-show-modal").click();
            $('#edu_move').select2({
                dropdownParent: $("#modal_move")
            })
        }

        function saveMoveStd() {
            let edu_move = $('#edu_move').val();
            let std_move_id = $('#std_move_id').val();
            let std_move_name = $('#std_move_name').text();
            if (edu_move == 0) {
                alert('โปรดเลือกสถานศึกษาหรือกลุ่มที่ต้องการย้ายไป')
                return;
            }

            const confirmMove = confirm(
                `ต้องการย้ายข้อมูลนักศึกษา ${std_move_name} หรือไม่?`
            );

            if (confirmMove) {
                $.ajax({
                    type: "POST",
                    url: "controllers/student_controller",
                    data: {
                        move_std: true,
                        edu_move: edu_move,
                        std_id: std_move_id
                    },
                    dataType: "json",
                    success: function(data) {
                        alert(data.msg);
                        if (data.status) {
                            $table.bootstrapTable('refresh');
                        } else {
                            window.location.reload();
                        }
                        $('.close').click()
                    },
                });
            }
        }
    </script>
</body>

</html>