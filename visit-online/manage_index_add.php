<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-การประเมินพนักงานราชการ</title>
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

        .card-img-top {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            height: 190px;
            object-fit: cover;
        }

        .img-hover:hover {
            cursor: pointer;
        }

        .img-hover {
            position: relative;
        }

        .form-control {
            height: 38px;
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
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_index'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-zip mr-15"></i> <b>ฟอร์มเพิ่มเอกสารการประเมินพนักงานราชการ</b>
                                        </h4>

                                    </div>
                                </div>
                                <form class="form" id="form-add-index">
                                    <div class="box-body">
                                        <input type="hidden" name="calendar_id" id="calendar_id" value="<?php echo isset($_GET['calendar_id']) ? $_GET['calendar_id'] : '' ?>">
                                        <h5><b>แนบไฟล์ตัวชี้วัด ไฟล์ต้องเป็น PDF เท่านั้น</b></h5>
                                        <div id="div_all_file">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" name="title" id="title" class="form-control title_index" placeholder="กรอกชื่อหัวข้อ">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" name="video" id="video" class="form-control video_index" placeholder="ลิงค์วิดีโอ">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="input-group mb-3">
                                                            <input type="file" class="form-control index_file" accept="application/pdf">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="ti-user" style="color: white;"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline" id="btn-submit-from">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                        <button type="button" class="btn btn-rounded btn-info btn-outline" onclick="addIndexFile()">
                                            <i class="ti-plus"></i> เพิ่มช่องแนบไฟล์ตัวชี้วัด
                                        </button>
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
        let index = 1;

        function addIndexFile() {
            index = index + 1;
            $('#div_all_file').append(
                `
                <div class="row" id="index_file_${index}">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="title" id="title" class="form-control title_index" placeholder="กรอกชื่อหัวข้อ">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="video" id="video" class="form-control video_index" placeholder="ลิงค์วิดีโอ">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control index_file" accept="application/pdf">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-close" style="cursor: pointer;color:red" onclick="removeIndexFile(${index})"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `
            )
        }

        function removeIndexFile(index) {
            $("#index_file_" + index).remove();
            index = index - 1;
        }
        $('#form-add-index').submit((e) => {
            e.preventDefault();

            $('#btn-submit-from').attr('disabled', true);
            let formData = new FormData();
            $('.index_file').each((index, ele) => {
                formData.append('index_file[]', ele.files[0]);
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

            formData.append('insertIndex', true);
            $('#btn-submit-from').attr('disabled', false);

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
        })
    </script>
</body>

</html>