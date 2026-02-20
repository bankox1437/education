<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>บันทึกผลการเรียน</title>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .input-custom-table {
            border: 0;
            border-radius: 0;
        }

        .table tbody tr td {
            padding: 0;
        }

        table>thead>tr>th {
            padding: 0px 5px !important;
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
                                    <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_credit_new_view?<?php echo $_GET['action'] ?>'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-text mr-15"></i> <b>ฟอร์มบันทึกผลการเรียน ปีการศึกษา <?php echo  $_SESSION['term_active']->term_name; ?></b>
                                    </h6>
                                </div>
                                <form class="form" id="form_credit_add_new" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="row  justify-content-start">
                                            <div class="col-md-2 row align-item-center">
                                                <div class="demo-checkbox">
                                                    <input type="checkbox" id="std_class_checked" class="filled-in chk-col-primary" onchange="changeFlowInsert(this.checked)">
                                                    <label for="std_class_checked" class="mb-0 mt-1">บันทึกเป็นระดับชั้น</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3" id="std_section">
                                                <?php include "../config/class_database.php";
                                                $DB = new Class_Database();
                                                $sql = "SELECT std.std_id,std.std_code,std.std_prename,std.std_name,edu.district_id FROM tb_students std \n" .
                                                    "LEFT JOIN tb_users users ON std.user_create = users.id\n" .
                                                    "LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id\n" .
                                                    "WHERE std.user_create = :user_create AND std.std_status = 'กำลังศึกษา'";
                                                $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id]);
                                                $std_data = json_decode($data);
                                                ?>
                                                <select class="form-control select2" id="std_id" style="width: 100%;">
                                                    <option value="">เลือกนักศึกษา</option>
                                                    <?php foreach ($std_data as $obj_std) {
                                                        echo "<option value='" . $obj_std->std_id . "'>" . $obj_std->std_code . "-" . $obj_std->std_prename . $obj_std->std_name . "</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3" id="std_class_section" style="display: none;">
                                                <select class="form-control select2" id="std_class" style="width: 100%;">
                                                    <option value="ประถม">ประถม</option>
                                                    <option value="ม.ต้น">ม.ต้น</option>
                                                    <option value="ม.ปลาย">ม.ปลาย</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3" id="std_section">
                                                <?php
                                                $sql = "SELECT * FROM vg_credit_set credit_set \n" .
                                                    "WHERE credit_set.user_create = :user_create";
                                                $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id]);
                                                $credit_set_data = json_decode($data);
                                                ?>
                                                <select class="form-control select2" id="set_id" style="width: 100%;" onchange="getSubject(this.value)">
                                                    <option value="">เลือกกลุ่มวิชา</option>
                                                    <?php foreach ($credit_set_data as $obj_std) {
                                                        echo "<option value='" . $obj_std->set_id . "'>
                                                            " . $obj_std->set_name . "
                                                        </option>";
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="text" name="term" id="term" class="form-control" placeholder="กรอกปีการศึกษา">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <?php
                                            include("include/credit/table1.php");
                                            include("include/credit/table2.php");
                                            include("include/credit/table3.php");
                                            ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <button type="submit" class="btn btn-rounded btn-primary btn-outline mt-4" id="btn_submit_credit">
                                                    <i class="ti-save-alt"></i> <span id="btn_text">บันทึกข้อมูล</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
        $(document).ready(() => {
            $('#std_id').select2()
            $('#set_id').select2()
            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        })

        function changeFlowInsert(checked) {
            if (checked) {
                $('#std_section').hide();
                $('#std_class_section').show();
            } else {
                $('#std_section').show();
                $('#std_class_section').hide();
            }
        }

        function addRow(id, sub_id = "", sub_name = "", credit = "") {
            let tbody = document.getElementById(id);
            let newRow = tbody.insertRow();
            newRow.id = "row" + tbody.rows.length;

            let cell1 = newRow.insertCell(0);
            let cell2 = newRow.insertCell(1);
            let cell3 = newRow.insertCell(2);
            let cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);

            cell1.innerHTML = `<input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกรหัสวิชา" value="${sub_id}">`;
            cell2.innerHTML = `<input type="text" class="form-control input-custom-table text-left" autocomplete="off" placeholder="กรอกชื่อรายวิชา" value="${sub_name}">`;
            cell3.innerHTML = `<input type="number" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกหน่วยกิต" value="${credit}">`;
            cell4.innerHTML = '<input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกเกรด">';
            cell5.classList.add('text-center');
            cell5.innerHTML = '<span class="badge badge-pill badge-danger" style="cursor: pointer;" onclick="removeRow(this)">ลบ</span>';
        }

        function removeRow(element) {
            var row = element.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        function disabledRow(id) {
            let checkNosubject = $(`#${id}_no_subject`).is(":checked");
            let element = document.getElementById(id);
            if (checkNosubject) {
                document.getElementById(`badge_${id}`).removeAttribute('onclick');
                for (let j = 0; j < element.children.length; j++) {
                    const tr = element.children[j].children;
                    for (let i = 0; i < (tr.length - 1); i++) {
                        tr[i].children[0].setAttribute("disabled", true);
                    }
                }

            } else {
                document.getElementById(`badge_${id}`).setAttribute('onclick', `addRow('${id}')`);
                for (let j = 0; j < element.children.length; j++) {
                    const tr = element.children[j].children;
                    for (let i = 0; i < (tr.length - 1); i++) {
                        tr[i].children[0].removeAttribute("disabled");
                    }
                }
            }
        }

        async function getValueFromTable(id) {
            let Arr = [];
            let validate = false;
            let checkNosubject = $(`${id}_no_subject`).is(":checked");

            $(id).each((index, tBody) => {
                if ($(tBody).children().length == 0) {
                    validate = true;
                } else {
                    $(tBody).children().each((index, Tr) => {
                        validate = false;
                        let sub_id = $(Tr).find('td:eq(0) input').val();
                        let sub_name = $(Tr).find('td:eq(1) input').val();
                        let credit = $(Tr).find('td:eq(2) input').val();
                        let grade = $(Tr).find('td:eq(3) input').val();
                        if (sub_id == "" && !checkNosubject) {
                            $($(Tr).children()[0]).children()[0].focus();
                        } else if (sub_name == "" && !checkNosubject) {
                            $($(Tr).children()[1]).children()[0].focus();
                        } else if (credit == "" && !checkNosubject) {
                            $($(Tr).children()[2]).children()[0].focus();
                            // } else if (grade == "" && !checkNosubject) {
                            //      $($(Tr).children()[3]).children()[0].focus();
                        } else {
                            if (sub_id != "" && sub_name != "" && credit != "") {
                                let obj = {
                                    sub_id: sub_id,
                                    sub_name: sub_name,
                                    credit: credit,
                                    grade: grade
                                };
                                Arr.push(obj);
                            }
                            validate = true;
                        }
                    });
                }
            });
            return validate ? Arr : validate;
        }

        function getSubject(set_id) {
            $.ajax({
                type: "POST",
                url: "controllers/credit_controller",
                data: {
                    getSubjectSet: true,
                    set_id: set_id
                },
                dataType: "json",
                success: function(data) {
                    const data_compulsory = data.data_compulsory;
                    const data_electives = data.data_electives;
                    const data_free_electives = data.data_free_electives;
                    $('#body_table1').empty();
                    $('#body_table2').empty();
                    $('#body_table3').empty();
                    if (data_compulsory.length == 0) {
                        addRow('body_table1');
                    } else {
                        data_compulsory.forEach(element => {
                            addRow('body_table1', element.sub_id, element.sub_name, element.credit);
                        });
                    }

                    if (data_electives.length == 0) {
                        addRow('body_table2');
                    } else {
                        data_electives.forEach(element => {
                            addRow('body_table2', element.sub_id, element.sub_name, element.credit);
                        });
                    }

                    if (data_free_electives.length == 0) {
                        addRow('body_table3');
                    } else {
                        data_free_electives.forEach(element => {
                            addRow('body_table3', element.sub_id, element.sub_name, element.credit);
                        });
                    }
                },
            });
        }

        $('#form_credit_add_new').submit(async (e) => {
            e.preventDefault();

            const std_id = $('#std_id').val();
            const term = $('#term').val();
            const std_class = $('#std_class').val();
            const classChecked = $("#std_class_checked").is(':checked');

            if (std_id == "" && !classChecked) {
                alert("โปรดเลือกนักศึกษา")
                $('#std_id').focus();
                return false;
            }
            if (term == "") {
                alert("โปรดกรอกปีการศึกษา")
                $('#term').focus();
                return false;
            }

            const dataTable1 = await getValueFromTable('#body_table1');
            if (!dataTable1) {
                return false; // Stop action if validation fails
            }
            const dataTable2 = await getValueFromTable('#body_table2');
            if (!dataTable2) {
                return false; // Stop action if validation fails
            }
            const dataTable3 = await getValueFromTable('#body_table3');
            if (!dataTable3) {
                return false; // Stop action if validation fails
            }

            if (dataTable1.length == 0 && dataTable2.length == 0 && dataTable3.length == 0) {
                alert("โปรดกรอกข้อมูลวิชาอย่างน้อย 1 รายการ");
                return false;
            }

            $('#btn_text').text('กำลังบันทึก. . .');
            $('#btn_submit_credit').attr('disabled', true);

            let formData = new FormData();
            formData.append('std_id', JSON.stringify(std_id));
            formData.append('std_class', std_class);
            formData.append('term', JSON.stringify(term));
            formData.append('dataTable1', JSON.stringify(dataTable1));
            formData.append('dataTable2', JSON.stringify(dataTable2));
            formData.append('dataTable3', JSON.stringify(dataTable3));
            formData.append('classChecked', classChecked);
            formData.append('insertCreditNew', true);

            $.ajax({
                type: "POST",
                url: "controllers/credit_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_credit_new_view?mode=view';
                    } else {
                        alert(json.msg);
                    }
                    $('#btn_text').text('บันทึกข้อมูล');
                    $('#btn_submit_credit').attr('disabled', false);
                },
            });
        });
    </script>
</body>

</html>