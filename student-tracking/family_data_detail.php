<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลประชากรด้านการศึกษา</title>
    <style>
        .form-border {
            border: 1px solid #E5E5E5;
            border-radius: 10px;
            padding: 10px;
            position: relative;
        }

        .form-border-close {
            position: absolute;
            right: 10px;
            color: red;
            cursor: pointer;
            z-index: 99;
        }

        .form-control:disabled {
            background-color: #fff;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <?php
        if ($_SESSION['user_data']->role_id != 4) {
            // include 'include/sidebar.php';
        }
        ?>

        <div class="content-wrapper" <?php echo $_SESSION['user_data']->role_id != 4 ? 'style="margin: 0"' : 'style="margin: 0"' ?>>
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content">
                    <div class="row">
                        <div class="col-12">

                            <?php include "../config/class_database.php";
                            $DB = new Class_Database();
                            $sql = "SELECT\n" .
                                "	fdd.*,\n" .
                                "	fd.* ,\n" .
                                "	p.name_th province_th,\n" .
                                "	d.name_th district_th,\n" .
                                "	sd.name_th subdistrict_th\n" .
                                "FROM\n" .
                                "	`stf_tb_family_data_detail` fdd\n" .
                                "	LEFT JOIN stf_tb_family_data fd ON fdd.family_id = fd.family_id\n" .
                                "	LEFT JOIN tbl_sub_district sd ON fd.subdistrict = sd.id\n" .
                                "	LEFT JOIN tbl_district d ON fd.district = d.id\n" .
                                "	LEFT JOIN tbl_provinces p ON fd.province = p.id \n" .
                                "WHERE\n" .
                                "	fdd.family_id = :family_id";
                            $data = $DB->Query($sql, ['family_id' => $_GET['family_id']]);
                            $family_data = json_decode($data);
                            if (count($family_data) == 0) {
                                echo "<script>location.href = '../404' </script>";
                            }

                            // echo "<pre>";
                            // print_r($family_data);
                            // echo "</pre>";
                            ?>

                            <div class="box">
                                <div class="box-body">
                                    <h6 class="box-title text-info" style="margin: 0;">
                                        <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='<?php echo $_SESSION['user_data']->role_id != 4 ? 'family_data' : 'student_family_data' ?>'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="ti-user mr-15"></i> <b>ข้อมูลประชากรด้านการศึกษา</b>
                                    </h6>
                                    <hr class="my-15">
                                    <!-- <form id="form-add-family"> -->
                                    <div class="row">
                                        <?php //if ($_SESSION['user_data']->role_id == 3 || $_SESSION['user_data']->role_id == 4) { 
                                        ?>
                                        <div class="col-md-2">
                                            <label><b>จังหวัด</b></label>
                                            <select class="form-control" id="province_select" style="width: 100%;" disabled>
                                                <option><?php echo $family_data[0]->province_th ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label><b>อำเภอ / เขต</b></label>
                                            <select class="form-control" id="district_select" style="width: 100%;" disabled>
                                                <option><?php echo $family_data[0]->district_th ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label><b>ตำบล / แขวง</b></label>
                                            <select class="form-control" id="subdistrict_select" style="width: 100%;" disabled>
                                                <option><?php echo $family_data[0]->subdistrict_th ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label><b>บ้านเลขที่</b></label>
                                                <input type="text" name="home_number" id="home_number" class="form-control" value="<?php echo $family_data[0]->home_number ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label><b>หมู่ที่</b></label>
                                                <input type="text" name="moo" id="moo" class="form-control" value="<?php echo $family_data[0]->moo ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label><b>ตรอก</b></label>
                                                <input type="text" name="alley" id="alley" class="form-control" value="<?php echo $family_data[0]->alley ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label><b>ซอย</b></label>
                                                <input type="text" name="alleyly" id="alleyly" class="form-control" value="<?php echo $family_data[0]->alley1 ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label><b>ถนน</b></label>
                                                <input type="text" name="street" id="street" class="form-control" value="<?php echo $family_data[0]->street ?>">
                                            </div>
                                        </div>
                                        <?php //} 
                                        ?>
                                    </div>
                                    <div id="box_form_element" class="mb-4 mt-2">
                                        <?php
                                        $index = 1;
                                        foreach ($family_data as $key => $data) { ?>
                                            <div class="row form-border">
                                                <?php if ($_SESSION['user_data']->role_id == 3 || $_SESSION['user_data']->role_id == 4) { ?>
                                                    <a href="family_data_edit?family_det_id=<?php echo $data->family_det_id ?>"><i class="ti-pencil-alt text-warning form-border-close"></i></a>
                                                <?php } ?>
                                                <div class="col-md-12 row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label><b>คนที่ <?php echo $index; ?> ชื่อ-สกุล</b></label>
                                                            <input type="text" name="name_1" id="name_1" class="form-control" value="<?php echo $data->name ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label><b>เพศ</b></label>
                                                            <select class="form-control" name="gender_1" id="gender_1" style="width: 100%;" required>
                                                                <option <?php echo $data->gender == 0 ? 'selected' : '' ?> value="0">เลือกเพศ</option>
                                                                <option <?php echo $data->gender == 1 ? 'selected' : '' ?> value="1">ชาย</option>
                                                                <option <?php echo $data->gender == 2 ? 'selected' : '' ?> value="2">หญิง</option>
                                                                <option <?php echo $data->gender == 3 ? 'selected' : '' ?> value="3">อื่น ๆ</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label><b>อายุ</b></label>
                                                            <input type="text" name="age_1" id="age_1" class="form-control" value="<?php echo $data->age ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label><b>อาชีพ</b></label>
                                                            <input type="text" name="job_1" id="job_1" class="form-control" value="<?php echo $data->job ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>การศึกษา</b></label>
                                                        <div class="c-inputs-stacked">
                                                            <input name="education_<?php echo $index ?>" <?php echo $data->education == "1" ? 'checked' : '' ?> type="radio" id="education_<?php echo $index ?>_1" class="with-gap radio-col-primary">
                                                            <label for="education_<?php echo $index ?>_1" class="mr-30">ต่ำกว่าประถม</label><br>

                                                            <input name="education_<?php echo $index ?>" <?php echo $data->education == 2 ? 'checked' : '' ?> type="radio" id="education_<?php echo $index ?>_2" class="with-gap radio-col-primary">
                                                            <label for="education_<?php echo $index ?>_2" class="mr-30">ประถม</label><br>

                                                            <input name="education_<?php echo $index ?>" <?php echo $data->education == 3 ? 'checked' : '' ?> type="radio" id="education_<?php echo $index ?>_3" class="with-gap radio-col-primary">
                                                            <label for="education_<?php echo $index ?>_3" class="mr-30">ม.ต้น</label><br>

                                                            <input name="education_<?php echo $index ?>" <?php echo $data->education == 4 ? 'checked' : '' ?> type="radio" id="education_<?php echo $index ?>_4" class="with-gap radio-col-primary">
                                                            <label for="education_<?php echo $index ?>_4" class="mr-30">ม.ปลาย</label><br>

                                                            <input name="education_<?php echo $index ?>" <?php echo $data->education == 5 ? 'checked' : '' ?> type="radio" id="education_<?php echo $index ?>_5" class="with-gap radio-col-primary">
                                                            <label for="education_<?php echo $index ?>_5" class="mr-30">สูงกว่า ม.ปลาย</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>ผ่านการอบรมหลักสูตร </b></label>
                                                        <div class="form-group col-md-6 pl-0">
                                                            <input type="text" name="training_<?php echo $index ?>_1" id="training_<?php echo $index ?>_1" value="<?php echo $data->training_1 ?>" class="form-control" placeholder="กรอกการอบรมหลักสูตร 1">
                                                        </div>
                                                        <div class="form-group col-md-6 pl-0">
                                                            <input type="text" name="training_<?php echo $index ?>_2" id="training_<?php echo $index ?>_2" value="<?php echo $data->training_2 ?>" class="form-control" placeholder="กรอกการอบรมหลักสูตร 2">
                                                        </div>
                                                        <div class="form-group col-md-6 pl-0">
                                                            <input type="text" name="training_<?php echo $index ?>_3" id="training_<?php echo $index ?>_3" value="<?php echo $data->training_3 ?>" class="form-control" placeholder="กรอกการอบรมหลักสูตร 3">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>ต้องการพัฒนาตนเองในด้าน</b></label>
                                                        <div class="c-inputs-stacked">
                                                            <?php $need_trainingID = [1, 2, 3, 4, 5] ?>
                                                            <input name="needTraining_<?php echo $index ?>" <?php echo $data->need_training === "1" ? 'checked' : '' ?> type="radio" id="need_training_<?php echo $index ?>_1" class="with-gap radio-col-primary">
                                                            <label for="need_training_<?php echo $index ?>_1" class="mr-30">อาชีพ</label><br>

                                                            <input name="needTraining_<?php echo $index ?>" <?php echo $data->need_training == "2" ? 'checked' : '' ?> type="radio" id="need_training_<?php echo $index ?>_2" class="with-gap radio-col-primary">
                                                            <label for="need_training_<?php echo $index ?>_2" class="mr-30">สุขภาพ</label><br>

                                                            <input name="needTraining_<?php echo $index ?>" <?php echo $data->need_training == "3" ? 'checked' : '' ?> type="radio" id="need_training_<?php echo $index ?>_3" class="with-gap radio-col-primary">
                                                            <label for="need_training_<?php echo $index ?>_3" class="mr-30">สิ่งแวดล้อม</label><br>

                                                            <input name="needTraining_<?php echo $index ?>" <?php echo $data->need_training == "4" ? 'checked' : '' ?> type="radio" id="need_training_<?php echo $index ?>_4" class="with-gap radio-col-primary">
                                                            <label for="need_training_<?php echo $index ?>_4" class="mr-30">การเมืองการปกครอง</label><br>

                                                            <input name="needTraining_<?php echo $index ?>" <?php echo $data->need_training == "5" ? 'checked' : '' ?> type="radio" id="need_training_<?php echo $index ?>_5" class="with-gap radio-col-primary">
                                                            <label for="need_training_<?php echo $index ?>_5" class="mr-30">การพัฒนาบุคลิกภาพ</label>
                                                            <div class="p-0 d-flex align-items-center">
                                                                <div class="demo-checkbox" style="max-width: 90px;">

                                                                    <input name="needTraining_<?php echo $index ?>" type="radio" id="need_training_<?php echo $index ?>_6" class="with-gap radio-col-primary" <?php echo !in_array($data->need_training, $need_trainingID) ? 'checked' : '' ?>>
                                                                    <label for="need_training_<?php echo $index ?>_6" style="min-width: 60px;" class="m-0">อื่นๆ</label>
                                                                </div>
                                                                <div class="form-group mb-0" style="display: <?php echo !in_array($data->need_training, $need_trainingID) ? 'flex' : 'none' ?>;margin-left: 10px;" id="need_training_<?php echo $index ?>_6_text_display">
                                                                    <input type="text" class="form-control" name="need_training_<?php echo $index ?>_6_text" id="need_training_<?php echo $index ?>_6_text" autocomplete="off" placeholder="ระบุอื่น ๆ" value="<?php echo $data->need_training ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>ความสามารถพิเศษ </b></label>
                                                        <div class="form-group col-md-6 pl-0">
                                                            <input type="text" name="ability_1" id="ability_1" class="form-control" value="<?php echo $data->ability ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>บทบาทในชุมชน </b></label>
                                                        <div class="form-group col-md-6 pl-0">
                                                            <input type="text" name="roleVillage_1" id="roleVillage_1" class="form-control" value="<?php echo $data->role_village ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        <?php $index++;
                                        } ?>
                                    </div>
                                    <!-- </form> -->
                                </div>

                            </div>


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
        $(document).ready(function() {
            $('.form-control').attr('disabled', 'true');
            $('.radio-col-primary').attr('disabled', 'true');
        });
    </script>
</body>

</html>