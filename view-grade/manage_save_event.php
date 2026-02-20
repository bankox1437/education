<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>สมุดบันทึก</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <?php
        $marGin = "margin: 0;";
        if ($_SESSION['user_data']->role_id != 4) {
            include 'include/sidebar.php';
            $marGin = '';
        } ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="<?php echo $marGin ?>">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <input type="hidden" name="std_id" id="std_id" value="<?php echo isset($_GET['std_id']) ? $_GET['std_id'] : 0 ?>">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body no-padding">
                                    <div id="toolbar" class="row align-items-center">
                                        <?php if ($_SESSION['user_data']->role_id == 4) { ?>
                                            <h4 class="ml-2 mt-1text-left mr-2" style="margin: 0;">
                                                <!-- <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='<?php echo isset($_GET['index_student']) ? 'index_student' : '../main_menu?list=1' ?>'"></i> -->
                                                &nbsp;&nbsp;<i class="fa fa-book mr-15"></i>

                                                <b>สมุดบันทึก <?php echo isset($_GET['name']) ? $_GET['name'] : "" ?></b>
                                            </h4>
                                            <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="manage_save_event_add"><i class="ti-plus"></i>&nbsp;บันทึก</a>
                                        <?php } else { ?>
                                            <h4 class="box-title col-md-12 text-left" style="margin: 0;">
                                                <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='student_list'"></i>
                                                &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-book mr-15"></i>
                                                <b>สมุดบันทึก <?php echo isset($_GET['name']) ? $_GET['name'] : "" ?></b>
                                            </h4>
                                        <?php } ?>
                                    </div>
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/save_event_controller?getSaveEvent=true&std_id=<?php echo isset($_GET['std_id']) ? $_GET['std_id'] : '0'; ?>" data-response-handler="responseHandler">
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
    <script src="js/init-table/manage_save_event.js"></script>

    <script>
        $(document).ready(function() {
            initTable()
            $('.search input').attr('placeholder', 'ค้นหาด้วยหัวข้อ');

            if (role_id != 4) {
                $table.bootstrapTable('hideColumn', 'del_opr');
                $table.bootstrapTable('hideColumn', 'edit_opr');

                $table.bootstrapTable('hideColumn', 'term_name');
                $table.bootstrapTable('hideColumn', 'std_name');
            }
        });

        function deleteSaveEvent(id, name) {
            const confirmDelete = confirm('ต้องการลบกิจกรรมนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/save_event_controller",
                    data: {
                        delete_event: true,
                        id: id
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