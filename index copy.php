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
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="images/<?php echo $file_image_old ?>?v=<?php echo time() ?>">
    <link rel="apple-touch-icon" href="images/<?php echo $file_image_old ?>?v=<?php echo time() ?>">

    <title>หน้าหลัก</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="assets/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skin_color.css">
    <link rel="stylesheet" href="view-grade/css/main_std.css">

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- Slick Carousel JS -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script> -->

    <!-- Slick Carousel CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" /> -->


    <?php include("include/script-hitstat.php") ?>
    <style>
        body {
            background-image: url('images/background/background-index6.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 90vh;
            width: 100%;
            background-color: #c19bfe;
        }

        .header-title {
            font-size: 4rem;
            font-weight: bold;
            color: #ffcc00;
            text-shadow: -2px -2px 0 #5a2d00, 2px -2px 0 #5a2d00, -2px 2px 0 #5a2d00, 2px 2px 0 #5a2d00;
        }

        .header-sub-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #ffcc00;
            text-shadow: -2px -2px 0 #5a2d00, 2px -2px 0 #5a2d00, -2px 2px 0 #5a2d00, 2px 2px 0 #5a2d00;
        }

        .banner {
            border: 5px solid white;
            border-radius: 10px;
            overflow: hidden;
        }

        .menu-title-container {
            padding-left: 20px;
            padding-right: 20px;
            text-align: center;
        }

        .menu-title-container .menu-title {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .menu-title {
            width: 100%;
            margin: 10px auto;
            font-size: 18px;
            font-weight: bold;
            border-radius: 20px;
            padding: 20px;
            background-color: #875ec7;
            border: 5px solid white;
            color: #ffcc00;
            cursor: default !important;
            text-align: center;
        }

        .login-btn {
            width: 80%;
            margin: 10px auto;
            font-size: 18px;
            font-weight: bold;
            border-radius: 20px;
            padding: 10px;
            background-color: #ffffff;
            border: 5px solid #f8672f;
            color: #000;
            transition: all 0.3s ease-in-out;
        }

        .login-btn:hover {
            background-color: #875ec7;
            color: #fff;
        }

        .img-border {
            border: 5px solid #fff;
            border-radius: 10px;
            height: 30rem;
        }

        .img-border-banner {
            border: 5px solid #fff;
            border-radius: 10px;
            height: 13rem;
        }

        .video-container {
            width: 100%;
            /* Ensures it fits within its column */
            max-width: 100%;
            /* Prevents overflow */
        }

        .video-container video {
            /* Makes video responsive */
            height: 30rem;
            /* Maintains aspect ratio */
            display: block;
            /* Prevents extra spacing issues */
            border-radius: 10px;
            /* Optional: Adds rounded corners */
        }

        @media (max-width: 300px) {
            .header-title {
                font-size: 2.5rem;
            }

            .header-sub-title {
                font-size: 2.5rem;
            }
        }

        @media screen and (max-width: 576px) {
            .header-title {
                font-size: 1.7rem;
                text-shadow: -1px -1px 0 #5a2d00, 1px -1px 0 #5a2d00, -1px 2px 0 #5a2d00, 1px 2px 0 #5a2d00;
            }

            .header-sub-title {
                font-size: 1rem;
                text-shadow: -1px -1px 0 #5a2d00, 1px -1px 0 #5a2d00, -2px 1px 0 #5a2d00, 1px 1px 0 #5a2d00;
            }

            .video-container video {
                width: 100vw;
                height: auto;
            }

            .img-border {
                height: 17rem;
            }

            .img-border-banner {
                height: 14rem;
            }
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

        .slider-container {
            max-width: 90%;
            margin: auto;
        }

        .slick-slide img {
            width: 100%;
            border: 5px solid white;
            border-radius: 10px;
        }

        .slick-slide {
            margin: 10px;
            /* Add spacing between images */
        }
    </style>
</head>

<body>
    <div class="text-center mt-4">
        <h1 class="header-title"><?php echo $system_name1 ?></h1>
        <h5 class="header-sub-title"><?php echo $system_name2 ?></h5>
    </div>

    <div class="row" style="margin-top: 30px;">
        <?php

        $sql2 = "select * from tb_setting_attribute where key_name = 'banner_display'";
        $banner_display = $DB->Query($sql2, []);
        $banner_display = json_decode($banner_display, true);
        $mode = $banner_display[0]['value'];

        $sql2 = "select * from tb_setting_attribute where key_name = 'banner_index_" . $mode . "'";
        $banner_file = $DB->Query($sql2, []);
        $banner_file = json_decode($banner_file, true);
        $fileBanner = $banner_file[0]['value'];

        if ($mode == 1) { ?>
            <div class="col-md-8 mb-4">
                <div class="text-center">
                    <img src="admin/upload/banners/<?php echo $fileBanner ?>" alt="" class="img-border">
                </div>
            </div>
        <?php } else { ?>
            <div class="col-md-8 mb-4">
                <div class="text-center video-container d-flex justify-content-center">
                    <video autoplay muted controls loop>
                        <source src="admin/upload/videos/<?php echo $fileBanner ?>" type="video/mp4">
                    </video>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-4">
            <div class="menu-title-container">
                <a href="view-grade/login?index_menu=5">
                    <h2 class="menu-title" style="cursor: pointer !important;"><?php echo $system_name3 ?></h2>
                </a>
                <h2 class="menu-title"><?php echo $system_name4 ?></h2>
                <h2 class="menu-title"><?php echo $system_name5 ?></h2>
                <button class="login-btn" onclick="location.href='<?php echo $url; ?>'">เข้าสู่เว็บไซต์</button>
            </div>
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <h4 style="color: #000000;"><strong>จำนวนผู้เข้าชม</strong></h4>
                    <div id="histats_counter"></div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <h4 style="color: #000000;"><strong>พัฒนาโดย ศิรสิชย์ สุวรรณรัตน์</strong></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mt-4" style="background-color: #ad7df7;border-radius: 20px;">
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
                    <h4 class="text-center" style="color: #000000;"><strong>ผู้ให้การสนับสนุน</strong></h4>
                </div>
            <?php } ?>

            <div class="slider-container pb-4">
                <div class="slider">
                    <?php
                    $i = 0;
                    foreach ($banners as $key => $value) {
                        $value_decode = json_decode($value['value'], true);
                    ?>
                        <div>
                            <img src="admin/upload/banners/<?php echo  $value_decode['banner'] ?>" class="img-fluid img-border-banner" alt="Banner <?php echo $i + 1 ?>">
                        </div>
                    <?php $i++;
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        // $(document).ready(function() {
        //     $('.slider').slick({
        //         slidesToShow: 6, // Show 2 images at a time
        //         slidesToScroll: 1,
        //         autoplay: true,
        //         autoplaySpeed: 2000,
        //         arrows: true,
        //         dots: false,
        //         infinite: true,
        //         responsive: [{
        //             breakpoint: 768,
        //             settings: {
        //                 slidesToShow: 1 // Show 1 image on small screens
        //             }
        //         }]
        //     });
        // });
    </script>
</body>

</html>