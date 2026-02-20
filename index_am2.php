<?php session_start() ?>

<?php

$url = "main_menu";
if (isset($_SESSION['index_menu'])) {
    $url = "main_menu?index_menu=" . $_SESSION['index_menu'];
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

    <link rel="icon" href="images/777546.jpg?v=<?php echo time() ?>">
    <link rel="apple-touch-icon" href="images/777546.jpg?v=<?php echo time() ?>">

    <title>ศูนย์ส่งเสริมการเรียนรู้ระดับอำเภอ</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="assets/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skin_color.css">
    <link rel="stylesheet" href="include_am/style.css">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .img-border {
            border: 5px solid #fff;
            border-radius: 10px;
            height: 30rem;
        }

        .img-border-banner {
            border: 5px solid #fff;
            border-radius: 10px;
            height: 17rem;
            width: 410px;
        }

        .fb-frame-wrapper {
            width: 500px;
            height: 600px;
            overflow: auto;
            border: 1px solid #ccc;
            margin-bottom: 1rem;
        }

        .fb-frame-wrapper iframe {
            width: 500px;
            height: 1000px;
            /* กำหนดให้ใหญ่พอเพื่อให้ scroll ได้ */
            border: none;
        }

        /* WebKit Browsers (Chrome, Safari, Edge) */
        ::-webkit-scrollbar {
            width: 1px;
            /* Scrollbar width */
        }

        ::-webkit-scrollbar-track {
            background: #b300ff;
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
            scrollbar-color: #ffcc00 #b300ff;
            /* Thumb color | Track color */
        }

        @media (max-width: 300px) {}

        @media screen and (max-width: 576px) {
            .img-border {
                height: auto;
            }
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" style="position: relative;">


    <?php include("include_am/banner.php") ?>


    <div class="container-full" style="background-color: #fff;">
        <section class="content pt-0">
            <?php
            $noImage = "images/preview/50908204-88b7-4592-be95-ea24985d2180.jpg";
            ?>
            <div class="container-fluid" style="padding-bottom: 30px;">
                <div class="row">
                    <div class="col-md-10 p-3">

                        <div class="content-header p-0 d-flex justify-content-end mb-3">
                            <i class="d-block d-md-none fa fa-bars" id="toggleMenu" style="font-size: 24px;padding-top: 3px;"></i>
                        </div>

                        <!-- <div class="content-body">
                            <div class="row justify-content-center">
                                <div class="col-md-6 mb-3">
                                    <img src="images/777186.jpg" alt="Image 1">
                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="content-header p-0 mb-3" style="border-bottom: 3px solid #ea9715;;margin-top: 50px;">
                            <h3 class="text-bold bg-warning p-2 m-0" style="width: 187px;">ปฏิทิน</h3>
                        </div> -->
                        <div class="content-body">
                            <div class="content-item row justify-content-center mb-3" style="height: 500px;">
                                <?php

                                $sql2 = "select * from tb_setting_attribute where key_name = 'banner_display'";
                                $banner_display = $DB->Query($sql2, []);
                                $banner_display = json_decode($banner_display, true);
                                $mode = $banner_display[0]['value'];

                                $sql2 = "select * from tb_setting_attribute where key_name = 'banner_index_" . $mode . "'";
                                $banner_file = $DB->Query($sql2, []);
                                $banner_file = json_decode($banner_file, true);
                                $fileBanner = $banner_file[0]['value'];

                                $fileBanner = "823369.jpg";

                                if ($mode == 1) { ?>
                                    <div class="col-12 col-md-11 text-start mb-2 mb-md-0" style="height: 100%;">
                                        <img src="admin/upload/banners/<?php echo $fileBanner ?>" alt="" class="img-border img-fluid" style="width: 100%;height: 100%;">
                                    </div>
                                <?php } else { ?>
                                    <div class="col-12 col-md-11 text-start mb-2 mb-md-0">
                                        <div class="text-center video-container d-flex justify-content-center">
                                            <video autoplay muted controls loop style="height: 500px;width: 100%">
                                                <source src="admin/upload/videos/<?php echo $fileBanner ?>" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="content-header p-0 d-flex justify-content-between mb-3" style="border-bottom: 3px solid #ea9715;">
                            <h3 class="text-bold bg-warning p-2 m-0">ข่าวสาร ประชาสัมพันธ์ระดับอำเภอ</h3>
                        </div>
                        <div class="content-body d-flex justify-content-start mb-4" style="gap: 20px;flex-wrap: wrap;">
                            <div class="fb-frame-wrapper">
                                <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FKhokphoDLEC%2Fposts%2Fpfbid02EfYcPpfmijvNoC67fnG7t52VC7m7d8uUy46rejSNnGAhmTkT13DtVdZP1Vs7BF3Cl&show_text=true&width=500"
                                    allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                            </div>

                            <div class="fb-frame-wrapper">
                                <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FKhokphoDLEC%2Fposts%2Fpfbid0qierMociDwGJK1MpKATaXBjXLysnMrRyybT2wJPjR7jToy7MRbwuQBo5vfFsETxzl&show_text=true&width=500"
                                    allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                            </div>
                        </div>

                        <div class="content-header p-0 d-flex justify-content-between mb-3" style="border-bottom: 3px solid #ea9715;">
                            <h3 class="text-bold bg-warning p-2 m-0">ข่าวสาร ประชาสัมพันธ์ระดับตำบล</h3>
                        </div>
                        <div class="content-body d-flex justify-content-start mb-4" style="gap: 20px;flex-wrap: wrap;">
                            <div class="fb-frame-wrapper">
                                <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FKhokphoDLEC%2Fposts%2Fpfbid01ESawDHkAJ42KXbFuYmSYa7so6Yvr6P5kh6F7VzRvL4hmrUno5rsiW9Z9yc6Whiel&show_text=true&width=500" width="500" height="250" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                            </div>

                            <div class="fb-frame-wrapper">
                                <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FKhokphoDLEC%2Fposts%2Fpfbid0We5uaUjsSNt5DPXX6qw9yPEotBCX81qf1sEQhNBd71dt5m2aNsKdoeY7k8CZZk2ql&show_text=true&width=500" width="500" height="890" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                            </div>

                            <div class="fb-frame-wrapper">
                                <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FKhokphoDLEC%2Fposts%2Fpfbid0a7U9UCUHMMwPCJompYbXzKbvGfZqrudZ275NtMy12RXcEustayRxsnv3Z2dtb1wNl&show_text=true&width=500" width="500" height="838" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                            </div>
                        </div>

                        <div class="content-header p-0 d-flex justify-content-between mb-3" style="border-bottom: 3px solid #ea9715;">
                            <h3 class="text-bold bg-warning p-2 m-0">ข่าวประชาสัมพันธ์</h3>
                        </div>
                        <div class="content-body" id="public_relations">
                            <div class="row">
                                <!-- คอนเทนต์ 1 -->
                                <div class="col-md-6 content-item row align-items-start mb-3">
                                    <div class="col-12 col-md-4 text-center mb-2 mb-md-0">
                                        <img src="images/777968.jpg" alt="รูปภาพ" class="img-fluid rounded">
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <h3 class="m-0 responsive-heading">สกร.ระดับอำเภอโคกโพธิ์ จัดกิจกรรม #อ่านสร้างสุขสนุกรับโชค​ #วันเด็กแห่งชาติ2568 ณ หอประชุมอำเภอโคกโพธิ์ จังหวัดปัตตานี</h3>
                                        <p class="mb-0 responsive-text">วันเสาร์ ที่ 11 มกราคม 2568 ศูนย์ส่งเสริมการเรียนรู้ระดับอำเภอโคกโพธิ์ ภายใต้การอำนวยการของ นางสาวอาซีซะห์ ฮา สาอิ ผู้อำนวยการ สกร.
                                            ระดับอำเภอโคกโพธิ์ จัดกิจกรรมอ่านสร้างสุข​ สนุกรับโชค​ เนื่องในวันเด็กแห่งชาติ 2568 ระหว่างวันที่ 10 - 11 มกราคม 2567 ณ หอประชุม​อำเภอ​โคกโพธิ์ จัดโดยเทศบาลตำบลโคกโพธิ์ โดยมี ผู้นำท้องที่ ผู้นำท้องถิ่น หน่วยงาน โรงเรียน ผู้ปกครอง เด็กและเยาวชนในพื้นที่ ร่วมกิจกรรมฯ ในการนี้ สกร.ระดับอำเภอโคกโพธิ์ มีกิจกรรมให้ร่วมสนุก ดังนี้
                                            - วาดภาพระบายสี
                                            - วงล้อส่งเสริมการอ่านสร้างทักษะภาษาพาสนุก
                                            - ใบ้คำ
                                            - เกมบันไดงู
                                            - ร้องเพลงผ่านคาราโอเกะ</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="content-body" id="public_relations">
                            <div class="row justify-content-start px-0 pb-4" style="overflow: hidden;gap: 10px;">
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
                                foreach ($banners as $key => $value) {
                                    $value_decode = json_decode($value['value'], true);
                                ?>

                                    <div class="d-flex justify-content-center">
                                        <a href="<?php echo  $value_decode['link'] ?>">
                                            <div style="width: 100%; flex-shrink: 0;" class="text-left">
                                                <img src="admin/upload/banners/<?php echo  $value_decode['banner'] ?>" class="img-fluid img-border-banner" alt="Logo">
                                            </div>
                                        </a>
                                    </div>

                                <?php } ?>
                                <div class="d-flex justify-content-center">
                                    <a href="<?php echo  $value_decode['link'] ?>">
                                        <div style="width: 100%; flex-shrink: 0;" class="text-left">
                                            <img src="admin/upload/banners/<?php echo  $value_decode['banner'] ?>" class="img-fluid img-border-banner" alt="Logo">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include("include_am/sidebar.php") ?>


                </div>

                <!-- <div class="row mt-4">
                    <div class="col-md-12  text-center">
                        <p>จำนวนผู้เข้าชม</p>
                        <div id="histats_counter"></div>
                    </div>
                </div> -->
                <!-- content area -->
            </div>
        </section>
    </div>

    <?php include("include_am/footer.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>