<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>การวิเคราะห์ผู้เรียน</title>
    <style>
        table tbody td:nth-child(3),
        table tbody td:nth-child(4),
        table tbody td:nth-child(5),
        table tbody td:nth-child(6) {
            align-items: center;
            cursor: pointer;
        }

        table tbody td:nth-child(3) label,
        table tbody td:nth-child(4) label,
        table tbody td:nth-child(5) label,
        table tbody td:nth-child(6) label {
            padding: 0;
            margin: 0;
        }

        table tbody td:nth-child(3):hover,
        table tbody td:nth-child(4):hover,
        table tbody td:nth-child(5):hover,
        table tbody td:nth-child(6):hover {
            background: #c3c3c3;
            transition: all;
        }

        .border-red {
            border: 1px solid red;
        }

        .form-group {
            margin-bottom: unset;
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
                            <div class="box m-0">
                                <div class="box-header with-border ">
                                    <h6 class="box-title text-info" style="margin: 0;">
                                        <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form1_1_new'"></i>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-user mr-15"></i>
                                        <b>ฟอร์มการวิเคราะห์ผู้เรียน</b>&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-dark"><?php echo $_GET['std_name']; ?></span>
                                    </h6>
                                </div>
                                <!-- /.box-header -->
                                <input type="hidden" name="learn_analys_id" id="learn_analys_id" value="<?php echo $_GET['learn_analys_id'] ?>">
                                <input type="hidden" name="mode" id="mode" value="<?php echo isset($_GET['learn_analys_id']) ? 'update' : 'insert' ?>">
                                <?php include("include/data_learn.php");
                                ?>
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" style="font-size: 14px;margin-bottom: 0;">
                                            <thead class="text-center">
                                                <tr>
                                                    <th rowspan="2" style="width: 5%;">ลำดับ</th>
                                                    <th rowspan="2">รายการวิเคราะห์ผู้เรียน</th>
                                                    <th colspan="4">ผลการวิเคราะห์ผู้เรียน</th>
                                                    <th rowspan="2" style="width: 20%;">สิ่งที่ควรปรับปรุง/แก้ไข</th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 9%;">ดีมาก</th>
                                                    <th style="width: 9%;">ดี</th>
                                                    <th style="width: 9%;">ปานกลาง</th>
                                                    <th style="width: 9%;">ปรับปรุง แก้ไข</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $index_main = 0;
                                                $mainKey = "";
                                                $subKey = "";
                                                foreach ($data_learn as $key => $value) {

                                                    if (strpos($key, 'title') === 0) {
                                                        $mainKey = "";
                                                        $index_main += 1;
                                                        $index_sub = 0;
                                                        $mainKey = $key;
                                                ?>
                                                        <tr>
                                                            <td class="text-center"><b><?php echo $index_main ?></b></td>
                                                            <td><b><?php echo is_array($value) ? $value[0] : $value ?></b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td rowspan="<?php echo $index_main == 3 ? "5" : "4" ?>">
                                                                <textarea name="<?php echo $mainKey ?>_text" id="<?php echo $mainKey ?>_text" cols="30" rows="10"><?php echo is_array($value) ? $value[2] : "" ?></textarea>
                                                            </td>
                                                        </tr>
                                                    <?php } else {
                                                        $subKey = "";
                                                        $index_sub += 1;
                                                        $subKey = $mainKey;
                                                        $subKey = $subKey . "_" . $index_sub;
                                                        $text_sub = "";
                                                        if (is_array($value)) {
                                                            $text_sub = "(" . $index_sub . ") " . $value[0];
                                                        } else {
                                                            $text_sub = "(" . $index_sub . ") " . $value;
                                                        }
                                                    ?>
                                                        <tr class="text-left">
                                                            <td></td>
                                                            <td><?php echo $text_sub ?></td>
                                                            <td onclick="checkedbehavior('<?php echo $subKey ?>_very_good')">
                                                                <div class="form-group text-center">
                                                                    <div class="c-inputs-stacked">
                                                                        <input <?php echo is_array($value) && $value[1] == 3 ? "checked" : "" ?> name="<?php echo $subKey ?>" type="radio" id="<?php echo $subKey ?>_very_good" class="with-gap radio-col-info input-vid" data-title="<?php echo is_array($value) ? $value[0] : $value ?>" value="3">
                                                                        <label for="very_good" style="padding-left: 25px;"></label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td onclick="checkedbehavior('<?php echo $subKey ?>_good')">
                                                                <div class="form-group text-center">
                                                                    <div class="c-inputs-stacked">
                                                                        <input <?php echo is_array($value) && $value[1] == 2 ? "checked" : "" ?> name="<?php echo $subKey ?>" type="radio" id="<?php echo $subKey ?>_good" class="with-gap radio-col-info input-vid" data-title="<?php echo is_array($value) ? $value[0] : $value ?>" value="2">
                                                                        <label for="good" style="padding-left: 25px;"></label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td onclick="checkedbehavior('<?php echo $subKey ?>_medium')">
                                                                <div class="form-group text-center">
                                                                    <div class="c-inputs-stacked">
                                                                        <input <?php echo is_array($value) && $value[1] == 1 ? "checked" : "" ?> name="<?php echo $subKey ?>" type="radio" id="<?php echo $subKey ?>_medium" class="with-gap radio-col-info input-vid" data-title="<?php echo is_array($value) ? $value[0] : $value ?>" value="1">
                                                                        <label for="medium" style="padding-left: 25px;"></label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td onclick="checkedbehavior('<?php echo $subKey ?>_adjust')">
                                                                <div class="form-group text-center">
                                                                    <div class="c-inputs-stacked">
                                                                        <input <?php echo is_array($value) && $value[1] == 0 ? "checked" : "" ?> name="<?php echo $subKey ?>" type="radio" id="<?php echo $subKey ?>_adjust" class="with-gap radio-col-info input-vid" data-title="<?php echo is_array($value) ? $value[0] : $value ?>" value="0">
                                                                        <label for="adjust" style="padding-left: 25px;"></label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row m-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความคิดเห็น / ข้อเสนอแนะของครู <b class="text-danger">*</b></label>
                                            <textarea rows="5" class="form-control" id="note_comment" placeholder="กรอกความคิดเห็น / ข้อเสนอแนะของครู"><?php echo isset($_GET['learn_analys_id']) ? $resultLearn->note : '' ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer" id="footer_btn">
                                <button type="submit" class="btn btn-rounded btn-primary btn-outline" id="saveVisit">
                                    <i class="ti-save-alt"></i> บันทึกข้อมูล
                                </button>
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
    <script>
        function checkedbehavior(id) {
            document.getElementById(id).setAttribute("checked", true);
        }


        $('#saveVisit').click(() => {
            let mode = $('#mode').val()
            let std_per_id = '<?php echo $_GET['std_per_id'] ?>';
            const note_comment = $('#note_comment').val();
            const learn_analys_id = $('#learn_analys_id').val();
            const arr_data = [];
            let isValid = true;
            $('.input-vid').each((index, input) => {
                let object_data = {};
                const $input = $(input);
                if ($input.is(':radio')) {
                    if (!$('input[name=' + input.name + ']:checked').length) {
                        isValid = false;
                        alert(`โปรดวิเคราะห์หัวข้อ ${$input.data('title')}`);
                        $input.focus();
                        return false;
                    } else {
                        object_data[input.name] = $('input[name=' + input.name + ']:checked').val()
                    }
                }
                arr_data.push(object_data);
            });
            if (isValid) {
                if (note_comment == "") {
                    alert(`โปรดกรอกความคิดเห็น / ข้อเสนอแนะของครู`);
                    $('#note_comment').focus();
                    return false;
                }
                const resultObjectSide1 = filterObject(arr_data, "1")
                const resultObjectSide2 = filterObject(arr_data, "2")
                const resultObjectSide3 = filterObject(arr_data, "3")
                const resultObjectSide4 = filterObject(arr_data, "4")
                const resultObjectSide5 = filterObject(arr_data, "5")
                const objectPost = {
                    "std_per_id": std_per_id,
                    "note": note_comment,
                    "side_1": resultObjectSide1,
                    "side_2": resultObjectSide2,
                    "side_3": resultObjectSide3,
                    "side_4": resultObjectSide4,
                    "side_5": resultObjectSide5
                }

                let data_send = {
                    objectPost: objectPost,
                    learn_analysis_mode: mode
                }
                if (mode == "update") {
                    data_send['learn_analys_id'] = learn_analys_id
                }
                $.ajax({
                    type: "POST",
                    url: "controllers/form_student_person_controller",
                    data: data_send,
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            alert(data.msg);
                            window.location.href = "form1_1_new";
                        } else {
                            alert(data.msg);
                        }
                    },
                });
            }

        });

        function filterObject(data, index) {
            return data.reduce((result, item) => {
                result['note'] = $('#title_' + index + "_text").val()
                const key = Object.keys(item)[0];
                if (key.startsWith('title_' + index)) {
                    result[key] = parseInt(item[key]);
                }
                return result;
            }, {});
        }
    </script>
</body>

</html>