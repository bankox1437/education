<?php
session_start();

if (!isset($_SESSION['user_data'])) {
    header('location:  ../main_menu');
}

include "../config/class_database.php";
$DB = new Class_Database();
$sql = "select * from tb_setting_attribute where key_name = 'system_name'";
$data_result = $DB->Query($sql, []);
$data_result = json_decode($data_result);
$file_image_old = "";

if (count($data_result) > 0) {
    $data_result = $data_result[0]->value;

    $data_result = json_decode($data_result, true);

    $file_image_old = $data_result['file_image'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ห้องเรียนออนไลน์แบบยืดหยุ่น</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="../images/<?php echo $file_image_old ?>?v=<?php echo time() ?>">
    <link rel="apple-touch-icon" href="../images/<?php echo $file_image_old ?>?v=<?php echo time() ?>">

    <!-- Vendors Style-->
    <link rel="stylesheet" href="../assets/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/skin_color.css">
    <style>
        body {
            background-image: url('images/background5.jpg');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: right;
            height: 94vh;
            width: 100%;
            background-color: #824215;
        }

        .card-container {
            background: white;
            padding: 20px;
            border-radius: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 20px solid #fb6833;
        }

        .btn-category {
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
        }

        /* WebKit Browsers (Chrome, Safari, Edge) */
        ::-webkit-scrollbar {
            width: 10px;
            /* Scrollbar width */
        }

        ::-webkit-scrollbar-track {
            background: #5a2d00;
            /* Track color */
            border-radius: 10px;
            /* Rounded corners */
        }

        ::-webkit-scrollbar-thumb {
            background: #ffcc00;
            /* Scrollbar color */
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2980b9;
            /* Darker color on hover */
        }

        /* Firefox */
        * {
            scrollbar-width: thin;
            /* Thin scrollbar */
            scrollbar-color: #ffcc00 #5a2d00;
            /* Thumb color | Track color */
        }

        .row-btn {
            margin-top: 50px;
            position: relative;
        }

        .fa-reply {
            font-size: 4rem;
            position: absolute;
            left: 50px;
            top: -20px;
            color: #ffffff;
        }

        .box-card {
            width: 100%;
            margin-top: 70px;
        }

        .btn-class-custom {
            border: #000000 4px solid;
            font-size: 2.5rem;
        }

        .text-black {
            color: #000;
        }

        .title-1 {
            font-size: 7rem;
        }

        .title-2 {
            font-size: 4rem;
        }

        .title-3 {
            font-size: 3rem;
        }

        .title-4 {
            color: #fff;
            font-size: 2rem;
            background-color: #dc3545;
            border: 3px solid #000;
            margin-top: 20px;
        }

        .title-5 {
            font-size: 2rem;
            margin-top: 10px;
        }

        .fa-hand-pointer-o {
            color: #ffffff;
        }

        .box-card-content {
            height: 70vh;
            width: 100%;
            margin-bottom: 50px;
        }
    </style>
    <link rel="stylesheet" href="css/index-responsive.css">
</head>

<body>

    <?php
    $checkClass = "";
    if ($_SESSION['user_data']->role_id == 4) {
        $sql = "select std_class from tb_students where std_id = :std_id";
        $data_class = $DB->Query($sql, ["std_id" => $_SESSION['user_data']->edu_type]);
        $data_class = json_decode($data_class);
        $checkClass = $data_class[0]->std_class;
    }
    ?>
    <div class="row justify-content-center row-btn">
        <a href="../main_menu"><i class="fa fa-reply"></i></a>
        <?php if ($checkClass == "ประถม" || $checkClass == "") { ?>
            <button class="col-sm-4 col-md-4 col-lg-4 col-xl-3 btn btn-category mt-4 mx-2 font-weight-bold btn-class-custom" style="background-color: #ffd83f;" onclick="location.href='manage_calendar?class=1'">ระดับประถมศึกษา <i class="fa fa-hand-pointer-o"></i></button>
        <?php } ?>

        <?php if ($checkClass == "ม.ต้น" || $checkClass == "") { ?>
            <button class="col-sm-4 col-md-4 col-lg-4 col-xl-3 btn btn-category mt-4 mx-2 font-weight-bold btn-class-custom" style="background-color: #39b7fc;" onclick="location.href='manage_calendar?class=2'">ระดับมัธยมศึกษาตอนต้น <i class="fa fa-hand-pointer-o"></i></button>
        <?php } ?>

        <?php if ($checkClass == "ม.ปลาย" || $checkClass == "") { ?>
            <button class="col-sm-4 col-md-4 col-lg-4 col-xl-3 btn btn-category mt-4 mx-2 font-weight-bold btn-class-custom" style="background-color: #fc65c3;" onclick="location.href='manage_calendar?class=3'">ระดับมัธยมศึกษาตอนปลาย <i class="fa fa-hand-pointer-o"></i></button>
        <?php } ?>
    </div>
    <div class="d-flex align-items-center justify-content-center box-card">
        <div class="row justify-content-center box-card-content">
            <div class="col-md-11 col-lg-11 col-xl-6 card-container text-center d-flex flex-column align-items-center justify-content-center p-0" style="height: 100%;">
                <h1 class="font-weight-bold mt-4 mb-3 title-1 text-black">ยินดีต้อนรับเข้าสู่</h1>
                <h2 class="font-weight-bold mt-4 mb-3 text-black title-2">Flexible Online Classroom</h2>
                <h3 class="font-weight-bold mt-4 mb-3 text-black title-3">ห้องเรียนออนไลน์แบบยืดหยุ่น</h3>
                <p class="font-weight-bold mt-4 mb-3 btn-category title-4">การเรียนรู้เพื่อคุณวุฒิตามระดับ</p>
                <p class="font-weight-bold mt-4 mb-3 text-black title-5">เรียนได้ทุกที่ ทุกเวลา</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>