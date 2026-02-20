<?php session_start() ?>

<?php

$url = "main_menu";
if (isset($_SESSION['user_data'])) {
    $url = "view-grade/main_dashboard";
}

include "config/class_database.php";
$DB = new Class_Database();

$sql = "select * from tb_setting_attribute where key_name = 'system_name'";
$data_result = $DB->Query($sql, []);
$data_result = json_decode($data_result);

$system_name1 = "";
$font_name1 = "1.7142857142857142rem";
$color_name1 = "#475F7B";

$system_name2 = "";
$font_name2 = "1.7142857142857142rem";
$color_name2 = "#475F7B";

$system_name3 = "";
$font_name3 = "1.7142857142857142rem";
$color_name3 = "#475F7B";

$system_name4 = "";
$font_name4 = "1.7142857142857142rem";
$color_name4 = "#475F7B";

$system_name5 = "";
$font_name5 = "1.7142857142857142rem";
$color_name5 = "#475F7B";

$file_image_old = "";

if (count($data_result) > 0) {
    $data_result = $data_result[0]->value;

    $data_result = json_decode($data_result, true);

    $system_name1 = $data_result['system_name1'];
    $font_name1 = $data_result['font_name1'] ?? '1.7142857142857142rem';
    $color_name1 = $data_result['color_name1'] ?? '#475F7B';

    $system_name2 = $data_result['system_name2'];
    $font_name2 = $data_result['font_name2'] ?? '1.7142857142857142rem';
    $color_name2 = $data_result['color_name2'] ?? '#475F7B';

    $system_name3 = $data_result['system_name3'];
    $font_name3 = $data_result['font_name3'] ?? '1.7142857142857142rem';
    $color_name3 = $data_result['color_name3'] ?? '#475F7B';

    $system_name4 = $data_result['system_name4'];
    $font_name4 = $data_result['font_name4'] ?? '1.7142857142857142rem';
    $color_name4 = $data_result['color_name4'] ?? '#475F7B';

    $system_name5 = $data_result['system_name5'];
    $font_name5 = $data_result['font_name5'] ?? '1.7142857142857142rem';
    $color_name5 = $data_result['color_name5'] ?? '#475F7B';

    $file_image_old = $data_result['file_image'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="images/index-logo.jpg?v=<?php echo time() ?>">
    <link rel="apple-touch-icon" href="images/index-logo.jpg?v=<?php echo time() ?>">

    <title>หน้าหลัก</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="assets/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skin_color.css">
    <link rel="stylesheet" href="view-grade/css/main_std.css">
    <style>
        .show-image {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* margin-top: 30px; */
        }

        .goto-site {
            width: 300px;
        }

        .show-image img {
            width: 300px;
            margin-bottom: 10px;
        }

        .dev-name {
            font-size: 20px;
        }

        .content-header h3:nth-child(1) {
            color: <?php echo $color_name1 ?> !important;
            font-size: <?php echo $font_name1 ?>px !important;
        }

        .content-header h3:nth-child(2) {
            color: <?php echo $color_name2 ?> !important;
            font-size: <?php echo $font_name2 ?>px !important;
        }

        .content-header h3:nth-child(3) {
            color: <?php echo $color_name3 ?> !important;
            font-size: <?php echo $font_name3 ?>px !important;
        }

        .text-eng:nth-child(2) {
            color: <?php echo $color_name4 ?> !important;
            font-size: <?php echo $font_name4 ?>px !important;
        }

        .text-eng:nth-child(3) {
            color: <?php echo $color_name5 ?> !important;
            font-size: <?php echo $font_name5 ?>px !important;
        }

        @media (max-width: 300px) {
            .goto-site {
                width: 200px;
            }

            .show-image img {
                width: 250px;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 390px) {
            .dev-name {
                font-size: 16px;
            }

            .content-header h3 {
                font-size: 18px !important;
            }
        }

        #btn_upto_top {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.2s;
        }

        #btn_upto_top:hover {
            background-color: #555;
            /* Add a dark-grey background on hover */
        }
    </style>
    <?php include("include/script-hitstat.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" style="position: relative;">
    <div class="container-full">
        <section class="content">
            <div class="container card" style="padding-bottom: 30px;">
                <div class="content-header pt-3">
                    <h3 class="text-center mt-4 text-dark"><b><?php echo  $system_name1 ?></b></h3>
                    <h3 class="text-center text-dark"><b><?php echo  $system_name2 ?></b></h3>
                    <h3 class="text-center text-dark"><b><?php echo  $system_name3 ?></b></h3>
                </div>
                <div class="show-image">
                    <img src="images/<?php echo $file_image_old ?>?v=<?php echo time() ?>" alt="index-logo">
                    <h4 class="text-center text-dark text-eng"><b><?php echo  $system_name4 ?></b></h4>
                    <h4 class="text-center text-dark text-eng"><b><?php echo  $system_name5 ?></b></h4>
                    <a type="button" href="<?php echo $url; ?>" class="mt-4 waves-effect waves-light btn mb-5 bg-gradient-primary goto-site">เข้าสู่เว็บไซต์</a>
                    <p class="mt-4 text-dark dev-name"><b>พัฒนาโดย นายศิรสิชย์ สุวรรณรัตน์</b></p>
                    <div class="row">
                        <div class="col-md-12  text-center">
                            <p>จำนวนผู้เข้าชม</p>
                            <div id="histats_counter"></div>
                        </div>
                    </div>
                </div>

                <div class="row  justify-content-center">
                    <?php
                    $sql = "select * from tb_setting_attribute where key_name = 'share_app'";
                    $data_result = $DB->Query($sql, []);
                    $data_result = json_decode($data_result, true);
                    foreach ($data_result as $key => $value) {
                        $value_decode = json_decode($value['value'], true);
                    ?>
                        <div class="col-lg-8 col-12">
                            <div class="row mt-4 mx-4">
                                <div class="col-md-12 mb-3">
                                    <div class="d-flex flex-md-row flex-column align-items-center">
                                        <div style="width: 100px; height: 100px; flex-shrink: 0;">
                                            <img src="<?php echo $value_decode['app_icon'] ?>" class="img-fluid" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <div>
                                            <h5 class="mb-1 text-dark text-title text-md-left text-center"><b><?php echo $value_decode['app_name'] ?></b></h5>
                                            <p class="mb-0"><?php echo $value_decode['app_des'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>


                <?php
                $sql2 = "select * from tb_setting_attribute where key_name = 'banner_form'";
                $data_result_banner = $DB->Query($sql2, []);
                $data_result_banner = json_decode($data_result_banner, true);

                $banners = array_filter($data_result_banner, function ($value) {
                    $value_decode = json_decode($value['value'], true);
                    return isset($value_decode['type']) && $value_decode['type'] == 3;
                });
                // Sort the filtered array by the 'order' key in the decoded 'value'
                usort($banners, function ($a, $b) {
                    $a_decode = json_decode($a['value'], true);
                    $b_decode = json_decode($b['value'], true);

                    // Compare the 'order' key to sort in ascending order
                    return $a_decode['order'] - $b_decode['order'];
                });

                ?>

                <?php if (count($data_result_banner) > 0) { ?>
                    <div class="content-header pt-3">
                        <h4 class="text-center mt-4 text-dark"><b>ผู้ให้การสนับสนุน</b></h4>
                    </div>
                <?php } ?>

                <div class="row  justify-content-center">
                    <?php
                    foreach ($banners as $key => $value) {
                        $value_decode = json_decode($value['value'], true);
                    ?>

                        <div class="col-lg-12 col-12 my-2">
                            <a href="<?php echo $value_decode['link'] ?>">
                                <div style="width: 100%; flex-shrink: 0;" class="text-left">
                                    <img src="admin/upload/banners/<?php echo  $value_decode['banner'] ?>" class="img-fluid" alt="Logo" style="width: 100%; height: 100%;">
                                </div>
                            </a>
                        </div>

                    <?php } ?>
                </div>

                <div class="row justify-content-start mt-4 mx-4">
                    <?php
                    $sql2 = "select * from tb_setting_attribute where key_name = 'banner_form'";
                    $data_result_banner = $DB->Query($sql2, []);
                    $data_result_banner = json_decode($data_result_banner, true);

                    $link = array_filter($data_result_banner, function ($value) {
                        $value_decode = json_decode($value['value'], true);
                        return isset($value_decode['type']) && $value_decode['type'] != 3;
                    });

                    foreach ($link as $key => $value) {
                        $value_decode = json_decode($value['value'], true);
                    ?>
                        <div class="col-md-6">
                            <?php if ($value_decode['type'] == 1) { ?>
                                <a href="<?php echo $value_decode['link'] ?>" target="_blank" class="my-2">
                                    <h5 class="mb-1 text-info"><b><?php echo $value_decode['title'] ?></b></h5>
                                </a>
                            <?php } ?>
                            <?php if ($value_decode['type'] == 2) { ?>
                                <h5 class="mb-1 text-dark"><b><?php echo $value_decode['title'] ?></b></h5>
                            <?php } ?>
                        </div>
                    <?php } ?>

                </div>



                <!-- content area -->
            </div>
        </section>
    </div>
    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary btn-sm mb-5" id="btn_upto_top"><i class="ti-angle-up"></i></button>

</body>
<script>
    $(document).ready(function() {
        $(window).scroll(function() {
            if ($(window).scrollTop() > 100) {
                $('#btn_upto_top').fadeIn();
            } else {
                $('#btn_upto_top').fadeOut();
            }
        });

        // เมื่อคลิกที่ปุ่ม ให้เลื่อนขึ้นไปด้านบน
        $('#btn_upto_top').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 'smooth');
        });
    });
</script>

</html>