<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>เพิ่มข้อมูลการสอบอ่าน</title>
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
                <?php include "../config/class_database.php";
                $DB = new Class_Database();
                $sql = "SELECT std.std_id,std.std_code,std.std_prename,std.std_name,edu.district_id FROM tb_students std \n" .
                    "LEFT JOIN tb_users users ON std.user_create = users.id\n" .
                    "LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id\n" .
                    "WHERE std.user_create = :user_create";
                $data = $DB->Query($sql, ['user_create' => $_SESSION['user_data']->id]);
                $std_data = json_decode($data);
                ?>
                <input type="hidden" name="term_id" id="term_id" value="<?php echo $_SESSION['term_active']->term_id ?>">
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_test_reading'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                            <b>ฟอร์มเพิ่มข้อมูลการสอบอ่าน ปีการศึกษา <?php echo  $_SESSION['term_active']->term_name; ?></b>
                                        </h4>
                                    </div>
                                </div>
                                <form class="form" id="form_add_test_reading" enctype="multipart/form-data">
                                    <input type="hidden" name="insertTestReading">
                                    <div class="box-body">
                                        <?php if ($_SESSION['user_data']->role_id == 2) {
                                            //include("include/form-add-teacher.php");
                                        } ?>
                                         <div class="row">
                                            <div class="col-md-3 col-lg-2">
                                                <div class="form-group">
                                                     <label>เลือกระดับชั้น <b class="text-danger">*</b></label>
                                                        <select class="form-control select2" name="std_class" id="std_class" data-placeholder="เลือกระดับชั้น" autocomplete="off" style="width: 100%;">
                                                            <option value="ประถม">ประถม</option>
                                                            <option value="ม.ต้น">ม.ต้น</option>
                                                            <option value="ม.ปลาย">ม.ปลาย</option>
                                                        </select>
                                                </div>
                                            </div>
                                              <!-- <div class="col-md-3" id="std_section" style="display: block;">
                                                <label>นักศึกษา <b class="text-danger">*</b></label>
                                                <select class="form-control" id="std_id" style="width: 100%;">
                                                    <option value="">เลือกนักศึกษา</option>
                                                    <?php foreach ($std_data as $obj_std) {
                                                        echo "<option value='" . $obj_std->std_id . "'>" . $obj_std->std_code . "-" . $obj_std->std_prename . $obj_std->std_name . "</option>";
                                                    } ?>
                                                </select>
                                            </div> -->
                                        </div>
                                          <div class="row mt-2">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>ชื่อการสอบอ่าน <b class="text-danger">*</b></label>
                                                        <textarea class="form-control height-input" name="test_reading_name" id="test_reading_name" autocomplete="off" placeholder="กรอกชื่อการสอบอ่าน" role="2"></textarea>
                                                    </div>
                                                </div>
                                        </div>
                                          <div class="row mt-2">
                                          
                                             <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วันที่สอบ <b class="text-danger">*</b></label>
                                                    <input type="date" class="form-control height-input" name="date_test" id="date_test" autocomplete="off" placeholder="กรอกวันที่สอบ">
                                                    <input type="hidden" name="insertTestReading">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วันที่หมดเขตสอบ <b class="text-danger">*</b></label>
                                                    <input type="date" class="form-control height-input" name="date_out_test" id="date_out_test" autocomplete="off" placeholder="กรอกวันที่หมดเขตสอบ">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>สื่อการอ่าน <b class="text-danger">*</b></label>
                                                     <select class="form-control select2" id="media_reading_select" style="width: 100%;">
                                                        <option value="0">เลือกสื่อการอ่าน</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="row mt-2">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>รายละเอียด <b class="text-danger">*</b></label>
                                                        <textarea class="form-control height-input" name="description" id="description" autocomplete="off" placeholder="กรอกรายละเอียด" role="3"></textarea>
                                                    </div>
                                                </div>
                                        </div>
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
                    <?php include "./include/loader_include.php"; ?>
                </div>

            </div>
        </div>
        <!-- /.content-wrapper -->

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
     <!-- <script src="js/init-table/manage_test_reading.js>"></script> -->
     <script>

        $(document).ready(async function() {
            await getDataMediaReading();

            $('#media_reading_select').select2()
            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        });

        $('#form_add_test_reading').submit((e) => {
            e.preventDefault();
            if (!validateFormAddTestReading()) {
                return;
            }
            $.ajax({
                type: "POST",
                url: "controllers/test_reading_controller",
                data: validateFormAddTestReading(),
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.href = 'manage_test_reading';
                    } else {
                        alert(json.msg);
                        window.location.reload();
                    }
                },
            });
        })

    function validateFormAddTestReading() {
        const std_class = $('#std_class').val();
        const test_reading_name = $('#test_reading_name').val();
        const date_test = $('#date_test').val();
        const date_out_test = $('#date_out_test').val();
        const description = $('#description').val();
        const media_reading_select = $('#media_reading_select').val();

    if (!test_reading_name) {
        alert('โปรดชื่อการสอบ')
        $('#test_reading_name').focus()
        return false;
    }
    if (!date_test) {
        alert('โปรดกรอกวันที่สอบ')
        $('#date_test').focus()
        return false;
    }
    if (!date_out_test) {
        alert('โปรดกรอกวันที่หมดเขตสอบสอบ')
        $('#date_out_test').focus()
        return false;
    }
       if (!description) {
        alert('โปรดกรอกรายละเอียด')
        $('#description').focus()
        return false;
    }
   
    if (!media_reading_select) {
        alert('โปรดเลือกสื่อการอ่าน')
        $('#media_reading_select').focus()
        return false;
    }

    if(date_out_test < date_test){
        alert('โปรดเลือกวันที่หมดเขตสอบมากกว่าวันที่สอบ')
        $('#date_out_test').focus()
        $('#date_out_test').val('')
        return false; 
    }
    
    let formData = new FormData();
    formData.append('media_id', media_reading_select);
    formData.append('test_reading_name', test_reading_name);
    formData.append('date_test', date_test);
    formData.append('date_out_test', date_out_test);
    formData.append('description', description);
    formData.append('std_class', std_class);
    formData.append('insertTestReading', true);
    
    return formData;
}

    async function getDataMediaReading() {
            $.ajax({
                type: "POST",
                url: "controllers/media_controller.php",
                data: {
                    getDataMediaReading: true
                },
                dataType: "json",
                success: async function(json_data) {
                    if(json_data.status){
                         var data = json_data.data;
                        const media_reading_select = document.getElementById('media_reading_select');
                        data.forEach((element, id) => {
                            media_reading_select.innerHTML += ` <option value="${element.media_id}" data-value="${element.media_id}">${element.media_name}</option>`
                        });
                    }
                  
                    
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed with status ' + status + ': ' + error);
                }
            });
        }

    </script>
</body>

</html>