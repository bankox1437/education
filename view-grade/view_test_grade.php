<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_std.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ดูผลสอบ ( Grade Result )</title>
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
                                            &nbsp;&nbsp;<i class="fa fa fa-bar-chart mr-15"></i>
                                            <b>ดูผลสอบ ( Grade Result )</b>
                                        </h4>
                                        <div>
                                            <select class="form-control" id="format" onchange="getByFormat(this.value)">
                                                <option value="0">รายบุคคล</option>
                                                <option value="1">ระดับชั้น</option>
                                            </select>
                                            <input type="hidden" id="user_create_std" value="<?php echo $_SESSION['user_data']->user_create; ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <h3>ข้อมูลคะแนนสอบ <span id="title">รายบุคคล</span></h3>
                                        </div>
                                    </div>
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/test_grade_controller?stdGetDataTestGrade=true">
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
    <script src="js/init-table/view_test_grade.js"></script>

    <script>
        $(document).ready(function() {
            initTable()
            $table.bootstrapTable('hideColumn', 'std_class');
        });

        function getByFormat(format) {
            const user_create_std = $('#user_create_std').val();
            if (!parseInt(format)) {
                $('#title').html(`รายบุคคล`)
                $table.bootstrapTable('hideColumn', 'std_class');
            } else {
                $('#title').html(`ระดับชั้น`)
                $table.bootstrapTable('showColumn', 'std_class');
            }
            var urlWithParams = $table.data('url') + '&format=' + format + "&user_create_std=" + user_create_std;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }
    </script>
</body>

</html>