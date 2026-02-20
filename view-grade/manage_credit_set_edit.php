<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แก้ไขรายวิชา</title>
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

                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT * FROM\n" .
                    "	vg_credit_set credit_set\n" .
                    "WHERE\n" .
                    "	credit_set.set_id = :set_id";
                $data = $DB->Query($sql, ['set_id' => $_GET['set_id']]);
                $set_data = json_decode($data);
                // print_r($set_data);
                $view_mode = "";
                $set_id = $_GET['set_id'];
                ?>

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h6 class="box-title text-info" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_credit_set'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i> <b>ฟอร์มแก้ไขรายวิชา</b>
                                    </h6>
                                </div>
                                <form class="form" id="form_credit_edit_set" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="row  justify-content-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" name="set_name" id="set_name" class="form-control" placeholder="กรอกชื่อกลุ่มวิชา" value="<?php echo $set_data[0]->set_name ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <?php
                                            include("include/credit_set/table1.php");
                                            include("include/credit_set/table2.php");
                                            include("include/credit_set/table3.php");
                                            ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <button type="submit" class="btn btn-rounded btn-primary btn-outline mt-4">
                                                    <i class="ti-save-alt"></i> บันทึกข้อมูล
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
            const compulsoryCount = '<?php echo count($compulsory_data) ?>';
            const electivesCount = '<?php echo count($electives_data) ?>';
            const free_electivesCount = '<?php echo count($free_electives_data) ?>';
            if (parseInt(compulsoryCount) == 0) {
                $(`#body_table1_no_subject`).attr('checked', true);
                disabledRow('body_table1')
            }
            if (parseInt(electivesCount) == 0) {
                $(`#body_table2_no_subject`).attr('checked', true);
                disabledRow('body_table2')
            }
            if (parseInt(free_electivesCount) == 0) {
                $(`#body_table3_no_subject`).attr('checked', true);
                disabledRow('body_table3')
            }
        })


        function addRow(id) {
            let tbody = document.getElementById(id);
            let newRow = tbody.insertRow();
            newRow.id = "row" + tbody.rows.length;

            let cell1 = newRow.insertCell(0);
            let cell2 = newRow.insertCell(1);
            let cell3 = newRow.insertCell(2);
            let cell4 = newRow.insertCell(3);

            cell1.innerHTML = '<input type="text" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกรหัสวิชา">';
            cell2.innerHTML = '<input type="text" class="form-control input-custom-table text-left" autocomplete="off" placeholder="กรอกชื่อรายวิชา">';
            cell3.innerHTML = '<input type="number" class="form-control input-custom-table text-center" autocomplete="off" placeholder="กรอกหน่วยกิต">';
            cell4.classList.add('text-center');
            cell4.innerHTML = '<span class="badge badge-pill badge-danger" style="cursor: pointer;" onclick="removeRow(this)">ลบ</span>';
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
                        let id = $(Tr).find('td:eq(3) input').val();
                        if (sub_id == "" && !checkNosubject) {
                            $($(Tr).children()[0]).children()[0].focus();
                        } else if (sub_name == "" && !checkNosubject) {
                            $($(Tr).children()[1]).children()[0].focus();
                        } else if (credit == "" && !checkNosubject) {
                            $($(Tr).children()[2]).children()[0].focus();
                        } else {
                            if (sub_id != "" && sub_name != "" && credit != "") {
                                let obj = {
                                    sub_id: sub_id,
                                    sub_name: sub_name,
                                    credit: credit,
                                    id: id,
                                    set_id: '<?php echo  isset($_GET['set_id']) ? $_GET['set_id'] : '' ?>'
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

        $('#form_credit_edit_set').submit(async (e) => {
            e.preventDefault();
            const set_id = '<?php echo isset($_GET['set_id']) ? $_GET['set_id'] : '' ?>';
            const set_name = $('#set_name').val();
            if (set_name == "") {
                alert("โปรดกรอกชื่อกลุ่มวิชา")
                $('#set_name').focus();
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
            console.table(dataTable1);
            console.table(dataTable2);
            console.table(dataTable3);

            let formData = new FormData();
            formData.append('set_id', set_id);
            formData.append('set_name', set_name);
            formData.append('dataTable1', JSON.stringify(dataTable1));
            formData.append('dataTable2', JSON.stringify(dataTable2));
            formData.append('dataTable3', JSON.stringify(dataTable3));
            formData.append('updateCreditSet', true);

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
                        window.location.reload();
                    } else {
                        alert(json.msg);
                    }
                },
            });
        });

        function removeRowUpdate(mode, id, element) {
            const confirmDelete = confirm('ต้องการลบวิชานี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/credit_controller",
                    data: {
                        mode: mode,
                        id: id,
                        removeRowUpdateSet: true
                    },
                    dataType: "json",
                    success: async function(json) {
                        if (json.status) {
                            removeRow(element)
                        } else {
                            alert(json.msg);
                        }
                    },
                });
            }
        }
    </script>
</body>

</html>