<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-การประเมินพนักงานราชการ</title>
    <style>
        .table tbody tr td {
            padding: 5px 5px;
        }

        @media (max-width: 767.98px) {
            .title_index {
                width: 280px !important;
            }
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
                <section class="content" id="section_content">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_index'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-zip mr-15"></i> <b>ฟอร์มแก้ไขเอกสารการประเมินพนักงานราชการ</b>
                                        </h4>
                                    </div>
                                </div>

                                <?php include "../config/class_database.php";
                                $DB = new Class_Database();
                                $sql = "SELECT * FROM cl_index \n" .
                                    "WHERE index_id = :index_id";
                                $dataIndex = $DB->Query($sql, ['index_id' => $_GET['index_id']]);
                                $dataIndex = json_decode($dataIndex);

                                if (count($dataIndex) == 0) {
                                    echo '<script>location.href = "../404"</script>';
                                }

                                $sql = "SELECT * FROM cl_index_file \n" .
                                    "WHERE index_id = :index_id";
                                $data = $DB->Query($sql, ['index_id' => $_GET['index_id']]);
                                $data = json_decode($data);

                                $data_index_file = $data;
                                ?>

                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-4">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>หัวข้อ</th>
                                                    <th>ลิงค์วิดีโอ</th>
                                                    <th>ชื่อไฟล์</th>
                                                    <th class="text-center">ดูไฟล์</th>
                                                    <th>ไฟล์ใหม่</th>
                                                    <!-- <th class="text-center" style="width: 5%;">ลบ</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 0; $i < count($data_index_file); $i++) {
                                                    $filePath = 'uploads/index_files/' . $data_index_file[$i]->file_name;
                                                    if (isset($data_index_file[$i]->file_name) && !empty($data_index_file[$i]->file_name)) {
                                                        $data_index_file[$i]->file_name = file_exists($filePath)
                                                            ? "uploads/index_files/" . $data_index_file[$i]->file_name
                                                            : "https://drive.google.com/file/d/{$data_index_file[$i]->file_name}/view";
                                                    }
                                                ?>
                                                    <tr id="index_file_<?php echo $i ?>">
                                                        <td>
                                                            <input type="text" class="form-control title_index" value="<?php echo $dataIndex[$i]->title_index ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control video_index" value="<?php echo $dataIndex[$i]->video ?>">
                                                        </td>
                                                        <input type="hidden" class="index_file_old" value="<?php echo $data_index_file[$i]->file_name ?>">
                                                        <input type="hidden" class="index_file_id" value="<?php echo $data_index_file[$i]->index_file_id ?>">
                                                        <td><?php echo $data_index_file[$i]->file_name_old ?></td>
                                                        <td class="text-center"><a class="font-size-18 text-gray hover-info" href="<?php echo $data_index_file[$i]->file_name ?>" target="_blank"><i class="fa fa-download"></i></a></td>
                                                        <td><input type="file" class="index_file" accept="application/pdf"></td>
                                                        <!-- <td class="text-center"><i class="ti-close" style="cursor: pointer;color:red" onclick="removeIndexFile(<?php echo $i ?>,<?php echo $data_index_file[$i]->index_file_id ?>,'<?php echo $data_index_file[$i]->file_name ?>')"></i></td> -->
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-rounded btn-primary btn-outline mt-4" onclick="Edit()">
                                        <i class="ti-save-alt"></i> บันทึกการแก้ไขข้อมูล
                                    </button>
                                </div>
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
        function removeIndexFile(index, file_id, file_name) {
            if (confirm('หากคุณลบ ไฟล์นี้จะหายไป')) {
                $.ajax({
                    type: "POST",
                    url: "controllers/index_controller",
                    data: {
                        deleteIndexFile: true,
                        index_file_id: file_id,
                        file_name: file_name
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            $("#index_file_" + index).remove();
                        } else {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                });

            }
        }

        function Edit() {
            let formData = new FormData();
            $('.index_file').each((index, ele) => {
                const file_old = $(ele).parent().parent().children()[1];
                const file_id = $(ele).parent().parent().children()[2];
                if (ele.files[0] != undefined) {
                    formData.append('index_file[]', ele.files[0]);
                    formData.append('index_file_old[]', file_old.value);
                    formData.append('index_file_id[]', file_id.value);
                }

            })

            let validate = true;
            $('.title_index').each((index, ele) => {
                if (!ele.value) {
                    ele.focus();
                    validate = false;
                    return false;
                }
                formData.append('title_index[]', ele.value);
            })

            $('.video_index').each((index, ele) => {
                // if (!ele.value) {
                //     ele.focus();
                //     validate = false;
                //     return false;
                // }
                formData.append('video[]', ele.value);
            })

            if (!validate) {
                return;
            }

            formData.append('index_id', '<?php echo $_GET['index_id'] ?>');
            formData.append('editIndex', true);

            $.ajax({
                type: "POST",
                url: "controllers/index_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    console.log(json);
                    alert(json.msg);
                    if (json.status) {
                        window.location.href = "manage_index"
                    } else {
                        window.location.reload();
                    }
                },
            });
        }
    </script>
</body>

</html>