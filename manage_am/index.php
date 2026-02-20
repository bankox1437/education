<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php
include "config/class_database.php";
$DB = new Class_Database();

$sql2 = "select * from tb_setting_attribute where key_name = 'bg_image'";
$bg_image = $DB->Query($sql2, []);
$bg_image = json_decode($bg_image, true);
?>

<head>
    <?php include_once("include_am/header-bs.php") ?>
    <style>
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

        body {
            background-image: url('manage_am/images/am_images/<?php echo $bg_image[0]['value'] ?>');
            background-repeat: repeat-y;
            background-size: cover;
            background-position: center;
            height: 90vh;
            width: 100%;
            background-color: #efc803;
        }

        .video-container {
            width: 100%;
            /* Ensures it fits within its column */
            max-width: 100%;
            /* Prevents overflow */
        }

        .video-container video {
            /* Makes video responsive */
            height: auto;
            /* Maintains aspect ratio */
            display: block;
            /* Prevents extra spacing issues */
            border-radius: 10px;
            /* Optional: Adds rounded corners */
        }

        @media screen and (max-width: 576px) {
            .video-container video {
                width: 100vw;
                height: auto;
            }
        }
    </style>
    <?php include("include/script-hitstat.php") ?>
</head>

<body class="index">
    <?php
    $sql = "select * from tb_setting_attribute where key_name = 'am_banner'";
    $data_result = $DB->Query($sql, []);
    $data_result = json_decode($data_result);


    $sql = "SELECT * FROM tb_setting_attribute where key_name IN ('am_web_title1', 'am_web_title2', 'am_web_title3')";
    $title = $DB->Query($sql, []);
    $title = json_decode($title, true);
    ?>
    <?php include_once("manage_am/include_am/get_data.php") ?>

    <?php include_once("manage_am/include_am/nav_mobile.php") ?>

    <!-- Navigation -->
    <?php
    //include_once("manage_am/include_am/nav-bar-bs.php") 
    include_once("manage_am/include_am/banner.php");
    ?>

    <section style="display: flex;justify-content: center;">
        <div class="row" style="width: 100%;">
            <div class="col-md-10">

                <?php
                $sql2 = "select * from tb_setting_attribute where key_name = 'banner_display_am'";
                $banner_display_am = $DB->Query($sql2, []);
                $banner_display_am = json_decode($banner_display_am, true);
                $mode = $banner_display_am[0]['value'];
                ?>
                <!-- Start Home Page Slider -->
                <section>
                    <!-- Carousel -->
                    <div class="carousel slide" data-ride="carousel">
                        <!-- Carousel inner -->
                        <?php if ($mode == 1) { ?>
                            <div class="carousel-inner">
                                <div class="item2 item-image active" style="margin-top: 20px;">
                                    <?php
                                    $sql = "select * from tb_setting_attribute where key_name = 'am_banner_main'";
                                    $am_banner_main = $DB->Query($sql, []);
                                    $am_banner_main = json_decode($am_banner_main);
                                    ?>
                                    <img class="img-responsive banner-first" src="manage_am/images/am_images/<?php echo $am_banner_main[0]->value ?>" alt="slider">
                                </div>
                                <!--/ Carousel item end -->
                            </div>
                            <!-- Carousel inner end-->
                        <?php } else {
                            $sql = "select * from tb_setting_attribute where key_name = 'am_video_main'";
                            $am_video_main = $DB->Query($sql, []);
                            $am_video_main = json_decode($am_video_main);
                        ?>
                            <div class="text-center video-container" style="display: flex;justify-content: center;margin-top: 25px;">
                                <video autoplay muted controls loop>
                                    <source src="manage_am/images/videos/<?php echo $am_video_main[0]->value ?>" type="video/mp4">
                                </video>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- /carousel -->
                </section>
                <!-- End Home Page Slider -->

                <!-- Start Latest News Section -->
                <section id="latest-news" class="latest-news-section" style="margin-left: 20px;margin-right: 20px;padding-top: 20px;">
                    <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center">
                                <h3><?php echo $title[0]['value'] ?? "ข่าวสาร ประชาสัมพันธ์ระดับอำเภอ" ?></h3>
                                <p style="padding-bottom: 20px;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="latest-news">
                            <?php
                            $sql = "SELECT * FROM am_post_am ORDER BY post_id DESC LIMIT 20";
                            $am_post_am = $DB->Query($sql, []);
                            $am_post_am = json_decode($am_post_am);
                            foreach ($am_post_am as $key => $post) {
                                $datePOST = explode(" ", $post->date);
                            ?>
                                <div class="col-md-12">
                                    <div class="latest-post">
                                        <img src="manage_am/images/post_am/<?php echo $post->image ?>"
                                            class="img-responsive" alt="">
                                        <h4 style="color: rgb(107 0 255 / 76%);"><?php echo $post->title ?></h4>
                                        <div class="post-details">
                                            <span class="date" style="background-color: rgb(107 0 255 / 76%);"><strong><?php echo $datePOST[0] ?></strong> <br><?php echo $datePOST[1] ?> <?php echo $datePOST[2] ?></span></span>
                                        </div>
                                        <p><?php echo $post->detail ?></p>
                                        <a href="<?php echo $post->link ?>" target="_blank" class="btn btn-primary" style="background-color: rgb(107 0 255 / 76%);">อ่านเพิ่มเติม</a>
                                    </div>
                                </div>
                            <?php  } ?>
                        </div>
                    </div>
                    <!-- </div> -->
                </section>
                <!-- End Latest News Section -->


                <!-- Start Latest News Section -->
                <!-- <section id="latest-news" class="latest-news-section" style="margin-left: 20px;margin-right: 20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center">
                                <h3>กิจกรรมการเรียนรู้</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="latest-news">
                            <div class="col-md-12">
                                <div class="latest-post">
                                    <img src="manage_am/images/am_images/473995393_2645673898972259_238504712752993619_n.jpg"
                                        class="img-responsive" alt="">
                                    <h4><a href="#" style="color: rgb(144 89 220 / 76%);">สกร.ระดับอำเภอโคกโพธิ์ จังหวัดปัตตานี</a></h4>
                                    <div class="post-details">
                                        <span class="date" style="background-color: rgb(144 89 220 / 76%);"><strong>17</strong> <br>มกราคม 2568</span>
                                    </div>
                                    <p>#เนื่องในโอกาสวันครู ประจำปี 2568
                                        สกร.ระดับอำเภอโคกโพธิ์ ของแสดงความยินดีกับ
                                        นางสาวอาซีซะห์ สาอิ ผู้อำนวยการ สกร.ระดับอำเภอโคกโพธิ์
                                        นางสาวหทัยกาญจน์ ชุมพราม ครูอาสาสมัครการศึกษานอกโรงเรียน
                                        นางสาวมัซณี เจะแม็ง ครู
                                        และนางสาวนารีซะห์ ดอเลาะ ครูอาสาสมัคร ฯ ประจำสถาบันศึกษาปอเนาะ
                                        โอกาสที่ได้รับการพิจารณาจาก สำนักงานส่งเสริมการเรียนรู้ประจำจังหวัดปัตตานี
                                        #การคัดเลือกการปฏิบัติงาน #สกร.ดีเด่น ระดับจังหวัด ประจำปี 2567</p>
                                    <a href="https://www.facebook.com/share/p/1AoD6LPzCL/" target="_blank" class="btn btn-primary" style="background-color: rgb(144 89 220 / 76%);">อ่านเพิ่มเติม</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
                <!-- End Latest News Section -->

                <!-- Start Latest News Section -->
                <section id="latest-news" class="latest-news-section" style="margin-left: 20px;margin-right: 20px;padding-top: 20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center">
                                <h3><?php echo $title[1]['value'] ?? "รูปภาพกิจกรรม" ?></h3>
                                <p style="padding-bottom: 20px;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="latest-news">
                            <?php
                            $sql = "SELECT * FROM am_event_image ORDER BY event_id DESC LIMIT 20";
                            $am_event_image = $DB->Query($sql, []);
                            $am_event_image = json_decode($am_event_image);
                            foreach ($am_event_image as $key => $event) {
                            ?>
                                <div class="col-md-12">
                                    <div class="latest-post">
                                        <img src="manage_am/images/am_events/<?php echo $event->image ?>"
                                            class="img-responsive" alt="" style="width: 100%;">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </section>
                <!-- End Latest News Section -->

                <!-- Start Latest News Section -->
                <section id="latest-news" class="latest-news-section" style="margin-left: 20px;margin-right: 20px;padding-top: 20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center">
                                <h3><?php echo $title[2]['value'] ?? "แบนเนอร์ข่าวสาร" ?></h3>
                                <p style="padding-bottom: 20px;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="latest-news">
                            <?php
                            $sql = "SELECT * FROM am_event_image_vertical ORDER BY event_ver_id DESC LIMIT 20";
                            $am_event_image_vertical = $DB->Query($sql, []);
                            $am_event_image_vertical = json_decode($am_event_image_vertical);
                            foreach ($am_event_image_vertical as $key => $event) {
                            ?>
                                <div class="col-md-12">
                                    <div class="vertical-banner">
                                        <img src="manage_am/images/am_events_ver/<?php echo $event->image ?>"
                                            class="img-responsive" alt="">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </section>
                <!-- End Latest News Section -->

                <div class="text-center">
                    <div id="histats_counter"></div>
                </div>
            </div>

            <div class="col-md-2 sidebar">
                <?php include_once("manage_am/include_am/sidebar_left.php") ?>
            </div>
        </div>
    </section>

    <section id="contact" class="contact">
        <footer class="style-1" style="background-color: #5949d6;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h5 style="margin: 0; color: #ffffff;">
                            License by Sirasit Suwannarat
                        </h5>
                    </div>
                </div>
            </div>
        </footer>
    </section>

    <div id="loader">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>

    <div id="chartModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-close">&times;</span>
            <h4 id="chartModalLabel" style="margin: 0;">Chart Title</h4>
            <hr>
            <div style="overflow-y: auto;">
                <div id="chartIframeContainer" style="display: flex;justify-content: center;"></div>
            </div>
        </div>
    </div>


    <?php include_once("include_am/footer-bs.php") ?>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Toggle dropdown manually (Bootstrap 3 auto-toggle might fail in stacked nav)
        $(document).ready(function() {
            $('.nav-stacked .dropdown-toggle').click(function(e) {
                e.preventDefault();
                var $parent = $(this).parent();
                $parent.toggleClass('open');
                $parent.siblings('.dropdown').removeClass('open'); // close others
            });

            // Chart link trigger
            $('.chart-link').click(function(e) {
                e.preventDefault();
                var chartData = $(this).data('chart-url');
                console.log(chartData);
                const chartOptions = chartData;
                const chartTitle = $(this).text().trim();
                displayChart(document.getElementById('chartIframeContainer'), chartOptions, chartTitle);
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chartModal = document.getElementById('chartModal'); // Custom modal div
            const chartIframeContainer = document.getElementById('chartIframeContainer');
            const chartModalLabel = document.getElementById('chartModalLabel');
            const chartModalClose = document.querySelector('.custom-close'); // Assuming your modal has this

            // Optional: Close modal when clicking outside
            window.onclick = function(event) {
                if (event.target === chartModal) {
                    closeModal();
                }
            };

            if (chartModalClose) {
                chartModalClose.addEventListener('click', closeModal);
            }
        });

        // Show modal
        function showModal() {
            chartModal.style.display = 'block';
        }

        // Hide modal
        function closeModal() {
            chartModal.style.display = 'none';
        }

        // Function to create iframe dynamically and display chart
        function displayChart(container, chartOptions, title) {
            container.innerHTML = ''; // Clear existing

            const iframe = document.createElement('iframe');
            iframe.width = chartOptions.width || '100%';
            iframe.height = chartOptions.height || '300';
            iframe.seamless = chartOptions.seamless === '';
            iframe.frameBorder = chartOptions.frameborder || '0';
            iframe.scrolling = "yes";
            iframe.src = chartOptions.src;

            container.appendChild(iframe);
            chartModalLabel.textContent = title;

            showModal(); // Custom show
        }


        setTimeout(() => {
            setActiveStyleSheet('yellow');
        }, 1000);
    </script>
</body>

</html>