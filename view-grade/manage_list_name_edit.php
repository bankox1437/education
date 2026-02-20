<?php include 'include/check_login.php'; ?>
<?php include 'include/check_role_kru.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>แก้ไขรายชื่อผู้บริหาร</title>
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

                    <?php include "../config/class_database.php";
                    $DB = new Class_Database();
                    $sql = "SELECT * FROM vg_list_name ln WHERE ln.list_name_id = :list_name_id";
                    $data = $DB->Query($sql, ['list_name_id' => $_GET['edit']]);
                    $list_name_data = json_decode($data);
                    if (count($list_name_data) == 0) {
                        echo "<script>location.href = 404</script>";
                    }
                    $list_name_data = $list_name_data[0];
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_list_name'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                            <b>ฟอร์มแก้ไขรายชื่อผู้บริหาร</b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form_list_name_edit">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>เจ้าหน้าที่การศึกษาขั้นพื้นฐาน</label>
                                                    <input type="text" class="form-control" id="name1" placeholder="กรอกชื่อเจ้าหน้าที่การศึกษาขั้นพื้นฐาน" value="<?php echo $list_name_data->name1 ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>นายทะเบียน</label>
                                                    <input type="text" class="form-control" id="name2" placeholder="กรอกชื่อนายทะเบียน" value="<?php echo $list_name_data->name2 ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ชื่อครูผู้รับผิดชอบ</label>
                                                    <input type="text" class="form-control" id="name3" placeholder="กรอกชื่อ ชื่อครูผู้รับผิดชอบ" value="<?php echo $list_name_data->name3 ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ประเภทครูผู้รับผิดชอบ</label>
                                                    <input type="text" class="form-control" id="name4" placeholder="กรอกชื่อ ประเภทครูผู้รับผิดชอบ" value="<?php echo $list_name_data->name4 ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-2">
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
                    <?php include ".//include/loader_include.php"; ?>
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
        })

        function setlabelFilename(id) {
            const file = document.getElementById(id).files[0];
            document.getElementById(id + '_label').innerText = file.name;
        }
        $('#form_list_name_edit').submit((e) => {
            e.preventDefault();
            const name1 = $('#name1').val();
            const name2 = $('#name2').val();
            const name3 = $('#name3').val();
            const name4 = $('#name4').val();

            const data_obj = {
                name1: name1,
                name2: name2,
                name3: name3,
                name4: name4,
                list_name_id: '<?php echo $_GET['edit'] ?>',
                editListName: 1
            }
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: data_obj,
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_list_name';
                    } else {
                        alert(json.msg);
                    }
                },
            });
        });
    </script>
</body>

</html>