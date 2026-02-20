<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการรายชื่อผู้บริหาร</title>
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
        <?php include 'include/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body no-padding">
                                    <div id="toolbar" class="row">
                                        <div class="col-md-12 row align-items-center">
                                            <h4 class="col-md-6 mt-3" id="title-table">ตารางข้อมูลรายชื่อผู้บริหาร</h4>
                                            <div class="col-md-4">
                                                <a id="btn_add" class="waves-effect waves-light btn btn-success btn-flat ml-2 mt-2" href="manage_list_name_add"><i class="ti-plus"></i>&nbsp;เพิ่มรายชื่อ</a>
                                            </div>
                                        </div>
                                        <div class="col-12 row align-items-center">
                                            <?php
                                            if ($_SESSION['user_data']->role_id == 1) { ?>
                                                <div class="col-md-4 mt-2">
                                                    <select class="form-control select2" id="province_select" style="width: 100%;" onchange="getBywhere()">
                                                        <option value="0">เลือกจังหวัด</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <select class="form-control select2" id="district_select" style="width: 100%;" onchange="getBywhere()">
                                                        <option value="0">เลือกอำเภอ</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2" id="sub_dis">
                                                    <select class=" form-control select2" id="subdistrict_select" style="width: 100%;" onchange="getBywhere()">
                                                        <option value="0">เลือกตำบล</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="false" data-show-refresh="false" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/user_controller?getListName=true">
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
    <script src="js/init-table/manage_list_name.js?v=<?php echo $version ?>"></script>

    <script>
        $(document).ready(async function() {
            initTable()
            checkHaveListName();
        });

        function checkHaveListName() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    checkHaveListName: true
                },
                dataType: "json",
                success: function(data) {
                    if (data.rows.length == 0) {
                        $("#btn_add").show();
                        $('#title-table').addClass('col-md-6');
                        $('#title-table').removeClass('col-md-12');
                    } else {
                        $("#btn_add").hide();
                        $('#title-table').addClass('col-md-12');
                        $('#title-table').removeClass('col-md-6');
                    }
                },
            });
        }

        function deleteListName(list_name_id) {
            const confirmDelete = confirm('ต้องการรายชื่อเหล่านี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/user_controller",
                    data: {
                        deleteListName: true,
                        list_name_id: list_name_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            $table.bootstrapTable('refresh');
                            checkHaveListName();
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