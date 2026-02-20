<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_std.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>รายชื่อนักศึกษาที่จบการศึกษา ( List of Graduated )</title>
    <style>
        #table td {
            padding: 10px;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <input type="hidden" id="role_value" value="0">
                                <div class="box-body no-padding">
                                    <div id="toolbar" class="row align-items-center">
                                        <h4 class="ml-2 mt-1text-left mr-2" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='index_student'"></i>
                                            &nbsp;&nbsp;<i class="fa fa-mortar-board mr-15"></i>
                                            <b>รายชื่อนักศึกษาที่จบการศึกษา ( List of Graduated )</b>
                                        </h4>
                                        <div>
                                            <select class="form-control" id="term_select" onchange="getBytermAndClass()">
                                                <option value="">เลือกปีการศึกษา&nbsp;&nbsp;&nbsp;</option>
                                                <?php foreach ($_SESSION['term_data'] as $term) {
                                                    echo "<option value='" . $term->term_name . "'>" . $term->term_name . "</option>";
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="ml-2">
                                            <select class="form-control" id="std_class" onchange="getBytermAndClass()">
                                                <option value="">เลือกชั้น&nbsp;&nbsp;&nbsp;</option>
                                                <option value="ประถม">ประถม</option>
                                                <option value="ม.ต้น">ม.ต้น</option>
                                                <option value="ม.ปลาย">ม.ปลาย</option>
                                            </select>
                                        </div>
                                    </div>
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/std_finish_controller?stdGetDataStdFinish=true">
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
    <script src="js/init-table/view_std_finish.js"></script>

    <script>
        $(document).ready(function() {
            initTable()
        });

        function getBytermAndClass() {
            const std_class = document.getElementById('std_class').value;
            const term_select = document.getElementById('term_select').value;
            var urlWithParams = $table.data('url') + '&term_name=' + term_select + '&std_class=' + std_class;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
            $table.bootstrapTable('refresh');
        }
    </script>
</body>

</html>