<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>เพิ่มข้อมูลเทอม</title>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_terms'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                            <b>ฟอร์มเพิ่มข้อมูลเทอม</b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form-add-calendar" enctype="multipart/form-data">
                                    <input type="hidden" name="insertCalendar">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ภาคเรียน <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="term" id="term" autocomplete="off" placeholder="กรอกภาคเรียน">
                                                    <input type="hidden" name="insertCalendar">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>ปีการศึกษา <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="year" id="year" autocomplete="off" placeholder="กรอกปีการศึกษา">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-rounded btn-primary btn-outline mt-4">
                                                    <i class="ti-save-alt"></i> บันทึกข้อมูล
                                                </button>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-2">
                                            <label>นักศึกษา <b class="text-danger">*</b></label>
                                            <select class="form-control" id="std_id" style="width: 100%;">
                                                <option value="">เลือกนักศึกษา</option>
                                            </select>
                                        </div> -->
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

        <?php include 'include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        $('#form-add-calendar').submit((e) => {
            e.preventDefault();
            const term = $('#term').val();
            const year = $('#year').val();
            if (!term) {
                alert('โปรดกรอกภาคเรียน')
                $('#term').focus()
                return false;
            }

            if (!year) {
                alert('โปรดกรอกการศึกษา')
                $('#year').focus()
                return false;
            }
            let formData = new FormData();
            formData.append('term', term);
            formData.append('year', year);
            formData.append('insertTerm', true);
            $.ajax({
                type: "POST",
                url: "controllers/term_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_terms';
                    } else {
                        alert(json.msg);
                    }
                },
            });
        })
    </script>
</body>

</html>