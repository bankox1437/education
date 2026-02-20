<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลชั่วโมง กพช.</title>
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
        if ($_SESSION['user_data']->role_id == "show") {
            include 'include/sidebar.php';
        } ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="<?php echo $_SESSION['user_data']->role_id == "show" ? '' : 'margin: 0;' ?>">
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
                                                <?php
                                                $pageBackClass = 0;
                                                if (isset($_GET['std_class'])) {
                                                    if ($_GET['std_class'] == 'ประถม') {
                                                        $pageBackClass = 1;
                                                    } elseif ($_GET['std_class'] == 'ม.ต้น') {
                                                        $pageBackClass = 2;
                                                    } elseif ($_GET['std_class'] == 'ม.ปลาย') {
                                                        $pageBackClass = 3;
                                                    }
                                                }

                                                $back = "../visit-online/manage_calendar?class=$pageBackClass";
                                                if ($_SESSION['user_data']->role_id == 2) {
                                                    $pro = isset($_GET['pro']) ? "pro=" . $_GET['pro'] . "&" : '';
                                                    $dis = isset($_GET['dis']) ? "dis=" . $_GET['dis'] . "&" : '';
                                                    $sub = isset($_GET['sub']) ? "sub=" . $_GET['sub'] . "&" : '';
                                                    $page_number = isset($_GET['page_number']) ? "page_number=" . $_GET['page_number'] . "" : '';
                                                    $name = isset($_GET['name']) ? "name=" . $_GET['name'] . "&" : '';
                                                    $user_id = isset($_GET['user_id']) ? "user_id=" . $_GET['user_id'] : '';
                                                    $back = "teacher_list?$pro$dis$sub$page_number";

                                                    echo  '<i class="ti-arrow-left ml-3" style="cursor: pointer;" onclick="window.location.href=\'' . $back . '\'"></i>';
                                                }
                                                ?>
                                                &nbsp; ข้อมูลชั่วโมง กพช.
                                            </h4>
                                            <?php
                                            if ($_SESSION['user_data']->role_id == 3) { ?>
                                                <div class="col-md-2">
                                                    <a id="btn_add" class="waves-effect waves-light btn btn-success btn-flat ml-2 mt-1" href="manage_sum_kpc_add"><i class="ti-plus"></i>&nbsp;เพิ่มรายการ กพช.</a>
                                                </div>
                                            <?php }
                                            ?>
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
                                    <table id="table" data-icons="icons" data-search="false" data-show-refresh="false" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" \
                                        data-url="../view-grade/controllers/sum_kpc_controller?getSumScore=true<?php echo isset($_GET['std_class']) ? "&std_class=" . urlencode($_GET['std_class']) : '' ?><?php echo isset($_GET['user_id']) ? '&user_id=' . $_GET['user_id'] : '' ?>" data-locale="th-TH">
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
            let html = `<a href="manage_sum_kpc_add?sub_id=${row.sub_id}&std_class=${row.std_class}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
            return html;
        }

        function formatButtonDelete(data, row) {
            let html = `<button type="button" onclick="deleteSumScrore(${row.sub_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
            return html;
        }

        function formatButtonCopy(data, row) {
            let html = `<button type="button" onclick="copySumScrore(${row.sub_id})" class="waves-effect waves-circle btn btn-circle btn-info mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-files" style="font-size:10px"></i></button>`;
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
                        // {
                        //     field: "std_code",
                        //     title: "รหัสนักศึกษา",
                        //     align: "left",
                        //     width: "300px",
                        // },
                        // {
                        //     field: "std_name",
                        //     title: "ชื่อนักศึกษา",
                        //     align: "left",
                        //     width: "300px",
                        // },
                        {
                            field: "term_name",
                            title: "ปีการศึกษา",
                            align: "left",
                            width: "300px",
                        },
                        {
                            field: "std_class",
                            title: "ระดับชั้น",
                            align: "left",
                            width: "300px",
                        },
                        {
                            field: "print_opr",
                            title: "ดูไฟล์",
                            align: "center",
                            width: "90px",
                            formatter: formatButtonPrint
                        },
                        // {
                        //     field: "copy_opr",
                        //     title: "คัดลอก",
                        //     align: "center",
                        //     width: "90px",
                        //     formatter: formatButtonCopy,
                        //     visible: role_id != 3 ? false : true
                        // },
                        {
                            field: "edit_opr",
                            title: "แก้ไข",
                            align: "center",
                            width: "90px",
                            formatter: formatButtonEdit,
                            visible: role_id != 3 ? false : true
                        },
                        {
                            field: "del_opr",
                            title: "ลบ",
                            align: "center",
                            width: "90px",
                            formatter: formatButtonDelete,
                            visible: role_id != 3 ? false : true
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
            window.open("manage_sum_kpc_print?sub_id=" + sub_id + "&std_class=" + std_class + usertext, "_blank");
        }

        function deleteSumScrore(sub_id) {
            const confirmDelete = confirm('ต้องการรายชื่อเหล่านี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "../view-grade/controllers/sum_kpc_controller",
                    data: {
                        deleteSumScrore: true,
                        sub_id: sub_id
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

        function copySumScrore(sub_id) {
            const confirmDelete = confirm('ต้องการคักลอกรายการนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "../view-grade/controllers/inter_study_controller",
                    data: {
                        copySumScrore: true,
                        sub_id: sub_id
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