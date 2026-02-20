<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>การแนะแนวและให้คำปรึกษา</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <?php if ($_SESSION['user_data']->role_id == 3) { ?>
            <style>
                .sidebar-footer a {
                    width: 50%;
                }

                .user-profile .info {
                    height: 65px;
                }

                .sidebar-menu {
                    padding-bottom: 0px;
                }
            </style>
            <aside class="main-sidebar">
                <?php $routeName =  basename($_SERVER["SCRIPT_FILENAME"], '.php'); ?>
                <!-- sidebar-->
                <section class="sidebar" style="position: relative;">
                    <!-- sidebar menu-->
                    <ul class="sidebar-menu" data-widget="tree" style="margin-bottom:20px;">
                        <li class="<?php echo $routeName == "manage_guide_std_add" ? 'active' : '' ?>">
                            <a href="manage_guide_std">
                                <i class="fa fa-file-text" aria-hidden="true" style="margin-right: 5px;"></i>
                                <span>การแนะแนวและให้คำปรึกษา</span>
                            </a>
                        </li>
                        <!-- <li class="<?php echo $routeName == "manage_kpc_add" ||  $routeName == "manage_kpc_edit" ? 'active' : '' ?>">
                        <a href="manage_kpc">
                            <i class="fa fa-file-text-o" aria-hidden="true" style="margin-right: 5px;"></i>
                            <span>ผลวิเคราะห์ข้อมูลผู้เรียน</span>
                        </a>
                    </li> -->
                    </ul>
                    <div class="sidebar-footer" style="position: absolute;bottom: auto;">
                        <!-- item-->
                        <a href="../main_menu" class="link link-edu-btn" data-toggle="tooltip" title="หน้าหลัก" data-original-title="หน้าหลัก">
                            <i class="fa fa-list"></i>
                            <span style="font-size: 12px;">หน้าเมนูหลัก</span>
                        </a>
                    </div>
                </section>
            </aside>
        <?php } ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" <?php echo $_SESSION['user_data']->role_id == 3 ? '' : 'style="margin: 0px;"' ?>>
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body no-padding">
                                    <div id="toolbar" class="row">
                                        <h4 class="mt-2 mr-4">
                                            <?php if ($_SESSION['user_data']->role_id == 2) {
                                                $user_id = isset($_GET['user_id']) ? "user_id=" . $_GET['user_id'] . "&" : '';
                                                $name = isset($_GET['name']) ? "name=" . $_GET['name'] . "&" : '';
                                                $pro = isset($_GET['pro']) ? "pro=" . $_GET['pro'] . "&" : '';
                                                $dis = isset($_GET['dis']) ? "dis=" . $_GET['dis'] . "&" : '';
                                                $sub = isset($_GET['sub']) ? "sub=" . $_GET['sub'] . "&" : '';
                                                $page_number = isset($_GET['page_number']) ? "page_number=" . $_GET['page_number'] : '';
                                            ?>
                                                <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='<?php echo '../visit-online/teacher_list?' . $pro . $dis . $sub .  $page_number ?>'"></i>
                                            <?php } ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-text mr-15"></i>
                                            การแนะแนวและให้คำปรึกษา <?php echo ($_SESSION['user_data']->role_id == 2) ? 'ของ ' . $_GET['name'] : '' ?>
                                        </h4>
                                        <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                            <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="manage_guide_std_add"><i class="ti-pencil-alt"></i>&nbsp;บันทึกการแนะแนว</a>
                                        <?php } ?>
                                    </div>
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="false" data-show-refresh="false" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server"
                                        data-url="controllers/guide_std_controller?getGuide=true<?php echo isset($_GET['user_id']) ? '&user_id=' . $_GET['user_id'] : "" ?>">
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
        var $table = $("#table");

        function formatButtonEdit(data, row) {
            let html = `<a href="manage_guide_std_add?g_id=${row.g_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
            return html;
        }

        function formatButtonView(data, row) {
            let html = `<a href="manage_guide_std_add?g_id=${row.g_id}&view=true<?php echo $_SESSION['user_data']->role_id == 2 ? "&" . $user_id . $name . $pro . $dis . $sub .  $page_number : '' ?>">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
            return html;
        }

        function formatButtonDelete(data, row) {
            let html = `<button type="button" onclick="deleteGuide(${row.g_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
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
                            field: "std_name",
                            title: "ชื่อ-สกุล",
                            align: "lefet",
                            width: "170px",
                        },
                        {
                            field: "edit_opr",
                            title: "ดูข้อมูล",
                            align: "center",
                            width: "50px",
                            formatter: formatButtonView
                        },
                        {
                            field: "edit_opr",
                            title: "แก้ไข",
                            align: "center",
                            width: "50px",
                            formatter: formatButtonEdit,
                            visible: role_id == 3 ? true : false
                        },
                        {
                            field: "del_opr",
                            title: "ลบ",
                            align: "center",
                            width: "50px",
                            formatter: formatButtonDelete,
                            visible: role_id == 3 ? true : false
                        },
                    ],
                ],
            });
        }
    </script>

    <script>
        $(document).ready(async function() {
            initTable()
        });

        function deleteGuide(g_id) {
            const confirmDelete = confirm('ต้องการลบการแนะแนวและให้คำปรึกษานี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/guide_std_controller",
                    data: {
                        deleteGuide: true,
                        g_id: g_id
                    },
                    dataType: "json",
                    success: function(data) {
                        alert(data.message)
                        if (data.status) {
                            $table.bootstrapTable('refresh');
                        }
                    },
                });
            }
        }
    </script>
</body>

</html>