<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลคะแนนระหว่างเรียน</title>
    <style>
        <?php
        if ($_SESSION['user_data']->role_id == 1) { ?>#table td {
            padding: 10px;
        }

        <?php } ?>#toolbar {
            width: 135%;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php
        if ($_SESSION['user_data']->role_id == 3) {
            include 'include/sidebar.php';
        } ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="<?php echo $_SESSION['user_data']->role_id == 3 ? '' : 'margin: 0;' ?>">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body no-padding">
                                    <div class="row pl-2 mt-3 mb-3">
                                        <div class="col-md-12 row align-items-center">
                                            <!-- <h4 class="col-md-2 mt-3" id="title-table">ตารางข้อมูลรายชื่อผู้บริหาร</h4> -->
                                            <h4 class="box-title" style="margin: 0;">
                                                &nbsp; ข้อมูลแผนการจัดการเรียนรู้
                                            </h4>
                                            <a id="btn_add" class="waves-effect waves-light btn btn-success btn-flat ml-2 mt-1" href="manage_calendar_new_add"><i class="ti-plus"></i>&nbsp;เพิ่มข้อมูลการพบกลุ่ม</a>
                                            <div class="col-md-1">
                                                <div class="form-group m-0">
                                                    <select class="form-control select2" name="std_class" id="std_class" onchange="getBywhere()" style="width: 100%;">
                                                        <option value="">ชั้นทั้งหมด &nbsp;&nbsp;</option>
                                                        <option value="ประถม">ประถม</option>
                                                        <option value="ม.ต้น">ม.ต้น</option>
                                                        <option value="ม.ปลาย">ม.ปลาย</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="table" data-icons="icons" data-search="false" data-show-refresh="false" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server"
                                        data-url="controllers/calendar_new_controller?getDataCalenderGET=true" data-locale="th-TH">
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

    <?php include 'include/scripts.php'; ?>

    <script>
        $(document).ready(async function() {
            initTable()
            //checkHaveListName();
        });

        var $table = $("#table");

        function formatButtonPrint(data, row) {
            let html = `<button type="button" onclick="printScore(${row.sub_id},'${row.std_class}','<?php echo isset($_GET['user_id']) ? $_GET['user_id'] : '' ?>')" class="waves-effect waves-circle btn btn-circle btn-success mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>`;
            return html;
        }

        function formatButtonEdit(data, row) {
            let html = `<p class="m-0 p-2">-</p>`;
            if (parseInt(row.user_create) == parseInt('<?php echo $_SESSION['user_data']->id ?>')) {
                html = `<a href="manage_calendar_new_edit?calendar_id=${row.calendar_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:28px;height:28px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
            }
            return html;
        }

        function formatButtonDelete(data, row) {
            let html = `<p class="m-0 p-2">-</p>`;
            if (parseInt(row.user_create) == parseInt('<?php echo $_SESSION['user_data']->id ?>')) {
                html = `<button type="button" onclick="deletePlanCalendar(${row.calendar_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:28px;height:28px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
            }
            return html;
        }

        window.icons = {
            refresh: "fa-refresh",
        };

        function initTable() {
            $table.bootstrapTable("destroy").bootstrapTable({
                locale: "th-TH",
                columns: [
                    [{
                            title: "ลำดับ",
                            align: "center",
                            width: "50px",
                            formatter: function(value, row, index) {
                                const options = $table.bootstrapTable("getOptions");
                                const currentPage = options.pageNumber;
                                let itemsPerPage = options.pageSize;
                                if (itemsPerPage == "All") {
                                    const data = $table.bootstrapTable("getData");
                                    itemsPerPage = data.length;
                                }
                                const offset = (currentPage - 1) * itemsPerPage;
                                return index + 1 + offset;
                            },
                        },
                        {
                            field: "std_class",
                            title: "ระดับชั้น",
                            align: "center",
                            width: "30px",
                        },
                        {
                            field: "time_step",
                            title: "ครั้งที่",
                            align: "center",
                            width: "30px",
                        },
                        {
                            field: "plan_name",
                            title: "ชื่อแผนการจัดการเรียนรู้",
                            align: "left",
                            width: "300px",
                        },
                        {
                            field: "u_name",
                            title: "ผู้บันทึก",
                            align: "left",
                            width: "300px",
                        },
                        // {
                        //     field: "print_opr",
                        //     title: "ดูไฟล์",
                        //     align: "center",
                        //     width: "90px",
                        //     formatter: formatButtonPrint
                        // },
                        {
                            field: "edit_opr",
                            title: "แก้ไข",
                            align: "center",
                            width: "30px",
                            formatter: formatButtonEdit,
                        },
                        {
                            field: "del_opr",
                            title: "ลบ",
                            align: "center",
                            width: "30px",
                            formatter: formatButtonDelete,
                        },
                    ],
                ],
            });

        }

        function getBywhere() {

            const std_class = $('#std_class').val() ?? "";

            var urlWithParams = $table.data('url') + `&std_class=${std_class}`;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
            $table.bootstrapTable('refresh');
            $('.search input').attr('placeholder', 'ค้นหาด้วยชื่อหรือปีการศึกษา');
        }

        function printScore(sub_id, std_class, user_id) {
            let usertext = user_id != "" ? "&user_id=" + user_id : "";
            window.open("manage_sum_score_print?sub_id=" + sub_id + "&std_class=" + std_class + usertext, "_blank");
        }

        function deletePlanCalendar(calendar_id) {
            const confirmDelete = confirm('ต้องการรายชื่อเหล่านี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/calendar_new_controller",
                    data: {
                        deletePlanCalendar: true,
                        calendar_id: calendar_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            $table.bootstrapTable('refresh');
                        } else {
                            alert(data.msg)
                        }
                    },
                });
            }
        }
    </script>
</body>

</html>