<?php
include "../config/class_database.php";
$DB = new Class_Database();

if (isset($_POST['mode']) && $_POST['mode'] === 'setting_title') {
    $sql = "DELETE FROM tb_setting_attribute WHERE key_name = 'am_web_title1'";
    $DB->Delete($sql, []);
    $sql = "INSERT INTO tb_setting_attribute(key_name,`value`) VALUES ('am_web_title1', ?)";
    $result = $DB->Insert($sql, [$_POST['title1']]);

    $sql = "DELETE FROM tb_setting_attribute WHERE key_name = 'am_web_title2'";
    $DB->Delete($sql, []);
    $sql = "INSERT INTO tb_setting_attribute(key_name,`value`) VALUES ('am_web_title2', ?)";
    $result = $DB->Insert($sql, [$_POST['title2']]);

    $sql = "DELETE FROM tb_setting_attribute WHERE key_name = 'am_web_title3'";
    $DB->Delete($sql, []);
    $sql = "INSERT INTO tb_setting_attribute(key_name,`value`) VALUES ('am_web_title3', ?)";
    $result = $DB->Insert($sql, [$_POST['title3']]);

    // ตรวจสอบผลลัพธ์
    echo json_encode([
        'success' => $result == 1,
        'msg' => $result == 1 ? 'อัปเดตหัวข้อสำเร็จ' : 'ไม่สามารถอัปเดตหัวข้อได้'
    ]);

    exit;
}
?>
<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ตั้งค่าชื่อหัวข้อ</title>
    <style>
        /* .tooltip-custom {
            cursor: pointer;
        }

        .tooltiptext {
            display: none;
        } */

        .tooltip-custom {
            cursor: pointer;
            position: relative;
        }

        .tooltip-custom:before {
            content: attr(data-text);
            /* here's the magic */
            position: absolute;

            /* vertically center */
            top: 50%;
            transform: translateY(-50%);

            /* move to right */
            left: 100%;
            margin-left: 15px;
            /* and add a small left margin */

            /* basic styles */
            width: 200px;
            padding: 10px;
            border-radius: 10px;
            background: #5949d6;
            color: #fff;
            text-align: left;

            display: none;
            /* hide by default */
        }

        .tooltip-custom:hover:before {
            display: block;
        }

        .checkbox label {
            padding-left: 25px;
        }
    </style>
    <?php include 'include/scripts.php'; ?>
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
                        <div class="col-lg-12 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">ตั้งค่าชื่อหัวข้อ</h4>
                                </div>
                                <!-- /.box-header -->
                                <?php
                                $sql = "SELECT * FROM tb_setting_attribute where key_name IN ('am_web_title1', 'am_web_title2', 'am_web_title3')";
                                $title = $DB->Query($sql, []);
                                $title = json_decode($title, true);
                                ?>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>หัวข้อที่ 1 ข่าวสาร/โพสต์</label>
                                                        <input type="text" class="form-control height-input" name="title1" id="title1" autocomplete="off" placeholder="กรอกหัวข้อที่ 1 ข่าวสาร/โพสต์" value="<?php echo $title[0]['value'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>หัวข้อที่ 2 รูปภาพกิจกรรม</label>
                                                        <input type="text" class="form-control height-input" name="title2" id="title2" autocomplete="off" placeholder="กรอกหัวข้อที่ 2 รูปภาพกิจกรรม"
                                                            value="<?php echo $title[1]['value'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>หัวข้อที่ 3 แบนเนอร์ข่าวสาร</label>
                                                        <input type="text" class="form-control height-input" name="title3" id="title3" autocomplete="off" placeholder="กรอกหัวข้อที่ 3 แบนเนอร์ข่าวสาร"
                                                            value="<?php echo $title[2]['value'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button class="btn btn-rounded btn-primary btn-outline" style="margin-top: 23px;width: 100%;" onclick="updateTitle()">
                                                        <i class="ti-save-alt"></i> บันทึก
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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


</body>
<script>
    function updateTitle() {
        // สร้าง FormData
        const formData = new FormData();
        formData.append("mode", "setting_title");

        // เก็บค่าจาก input ใน parentRow
        const title1 = $('#title1').val();
        const title2 = $('#title2').val();
        const title3 = $('#title3').val();

        formData.append("title1", title1);
        formData.append("title2", title2);
        formData.append("title3", title3);

        // ส่ง AJAX
        $.ajax({
            type: "POST",
            url: "",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(json) {
                alert(json.msg);
                if (json.success) {
                    window.location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("เกิดข้อผิดพลาด: " + xhr.responseText);
            }
        });
    }
</script>

</html>