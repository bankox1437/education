<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("manage_am/include_am/header-bs.php") ?>
    <link rel="stylesheet" href="manage_am/include_am/style.css?v=<?php echo time() ?>">
    <style>
        .custom-image {
            width: 200px;
            height: 250px;
            object-fit: cover;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
    </style>
</head>

<body class="index">

    <?php
    include_once("manage_am/include_am/get_data.php");
    include_once("manage_am/include_am/banner.php");
    ?>

    <!-- Start Latest News Section -->
    <div class="container-full" style="background-color: #fff;">
        <section class="content pt-0">
            <?php
            $noImage = "https://static.vecteezy.com/system/resources/previews/004/141/669/non_2x/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg";
            $noImage = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkIa4dF_FqRqUUeSjRDiGqVEt-KMrUUlptoA&s";
            ?>
            <div class="container" style="padding-bottom: 30px;">
                <div class="row">
                    <div class="col-md-12 p-3">
                        <div class="content-header clearfix" style="border-bottom: 3px solid #e5bd4e; margin-bottom: 15px; padding: 0;">
                            <a href="https://khokpho-dole.com/" class="pull-left">
                                <h3 style="font-weight: bold; background-color: #e5bd4e; padding: 10px; margin: 0;color: #000000;">หน้าแรก</h3>
                            </a>
                            <h3 class="pull-right" style="font-weight: bold; background-color: #e5bd4e; padding: 10px; margin: 0;">ทำเนียบบุคลากร</h3>
                        </div>
                        <div class="container">
                            <div class="content-body" id="executive">
                                <!-- Section: ผู้อำนวยการ -->
                                <div class="row mb-3 justify-content-center">
                                    <div class="col-12">
                                        <h4 class="text-center text-uppercase fw-bold mb-3"><b>ผู้อำนวยการ</b></h4>
                                    </div>
                                    <div class="col-xs-12 col-md-12 text-center" style="margin-top: 15px;">
                                        <img src="images/777547.jpg" alt="ผู้อำนวยการ" class="img-responsive center-block custom-image" style="margin-bottom: 10px;">
                                        <h5 style="font-weight: bold;">ชื่อ: นางสาวอาซีซะห์ สาอิ</h5>
                                        <p class="text-muted">ตำแหน่ง: ผู้อำนวยการ</p>
                                        <p class="text-muted">งานที่รับผิดชอบ: -</p>
                                    </div>
                                </div>

                                <hr class="bg-primary m-0 p-0">

                                <!-- Section: ข้าราชการ -->
                                <div class="row mb-3 justify-content-center mt-3">
                                    <div class="col-12">
                                        <h4 class="text-center text-uppercase fw-bold mb-3"><b>ข้าราชการ</b></h4>
                                    </div>
                                    <div class="col-xs-6 col-md-3 text-center" style="margin-top: 15px;">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ข้าราชการ" class="img-responsive center-block custom-image" style="margin-bottom: 10px;">
                                        <h5 style="font-weight: bold; margin: 0;">ชื่อ: ข้าราชการ 1</h5>
                                        <p class="text-muted" style="margin: 0;">ตำแหน่ง: ข้าราชการ</p>
                                        <p class="text-muted" style="margin: 0;">งานที่รับผิดชอบ: -</p>
                                        <div class="menu-relative">
                                            <p class="text-muted" style="cursor: pointer; margin: 0;" data-id="2" onclick="addPopup(this)">
                                                <b>ดูข้อมูล</b>
                                            </p>
                                            <div class="menu-absolute menu-absolute2"></div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-md-3 text-center" style="margin-top: 15px;">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ข้าราชการ" class="img-responsive center-block custom-image" style="margin-bottom: 10px;">
                                        <h5 style="font-weight: bold; margin: 0;">ชื่อ: ข้าราชการ 2</h5>
                                        <p class="text-muted" style="margin: 0;">ตำแหน่ง: ข้าราชการ</p>
                                        <p class="text-muted" style="margin: 0;">งานที่รับผิดชอบ: -</p>
                                        <div class="menu-relative">
                                            <p class="text-muted" style="cursor: pointer; margin: 0;" data-id="3" onclick="addPopup(this)">
                                                <b>ดูข้อมูล</b>
                                            </p>
                                            <div class="menu-absolute menu-absolute3"></div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-md-3 text-center" style="margin-top: 15px;">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ข้าราชการ" class="img-responsive center-block custom-image" style="margin-bottom: 10px;">
                                        <h5 style="font-weight: bold; margin: 0;">ชื่อ: ข้าราชการ 1</h5>
                                        <p class="text-muted" style="margin: 0;">ตำแหน่ง: ข้าราชการ</p>
                                        <p class="text-muted" style="margin: 0;">งานที่รับผิดชอบ: -</p>
                                        <div class="menu-relative">
                                            <p class="text-muted" style="cursor: pointer; margin: 0;" data-id="4" onclick="addPopup(this)">
                                                <b>ดูข้อมูล</b>
                                            </p>
                                            <div class="menu-absolute menu-absolute4"></div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-md-3 text-center" style="margin-top: 15px;">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ข้าราชการ" class="img-responsive center-block custom-image" style="margin-bottom: 10px;">
                                        <h5 style="font-weight: bold; margin: 0;">ชื่อ: ข้าราชการ 2</h5>
                                        <p class="text-muted" style="margin: 0;">ตำแหน่ง: ข้าราชการ</p>
                                        <p class="text-muted" style="margin: 0;">งานที่รับผิดชอบ: -</p>
                                        <div class="menu-relative">
                                            <p class="text-muted" style="cursor: pointer; margin: 0;" data-id="5" onclick="addPopup(this)">
                                                <b>ดูข้อมูล</b>
                                            </p>
                                            <div class="menu-absolute menu-absolute5"></div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="bg-primary m-0 p-0">

                                <!-- Section: ครูอาสาสมัครฯ -->
                                <div class="row mb-3 justify-content-center mt-3">
                                    <div class="col-12">
                                        <h4 class="text-center text-uppercase fw-bold mb-3"><b>ครูอาสาสมัครฯ</b></h4>
                                    </div>
                                </div>

                                <hr class="bg-primary m-0 p-0">

                                <!-- Section: พนักงานราชการ -->
                                <div class="row mb-3 justify-content-center mt-3">
                                    <div class="col-12">
                                        <h4 class="text-center text-uppercase fw-bold mb-3"><b>พนักงานราชการ</b></h4>
                                    </div>
                                </div>

                                <hr class="bg-primary m-0 p-0">

                                <!-- Section: จ้างเหมาบริการ -->
                                <div class="row mb-3 justify-content-center mt-3">
                                    <div class="col-12">
                                        <h4 class="text-center text-uppercase fw-bold mb-3"><b>จ้างเหมาบริการ</b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- content area -->
            </div>
        </section>
    </div>
    <!-- End Latest News Section -->

    <?php include_once("manage_am/include_am/footer-bs.php") ?>

    <script>
        setTimeout(() => {
            setActiveStyleSheet('yellow');
        }, 1000);
    </script>

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

    function addPopup(seeMoreBtn) {
        let listMenu = [
            "ข้อมูลส่วนตัว",
            "จำนวน นศ.",
            "นิเทศการสอน",
            "นิเทศการปฏิบัติงาน",
            "วิจัยในชั้นเรียน",
            "การแนะแนว",
        ];
        const htmlPopup = `
        <ul class="list-group">
            ${listMenu.map((menu) => `
                <li class="list-group-item text-center">
                    <a href="https://do-el.net/view-grade/login?index_menu=3&back=<?php echo urlencode("https://khokpho-dole.com/personal_list") ?>">${menu}</a>
                </li>
            `).join('')}
        </ul>`;

        const uniqId = $(seeMoreBtn).attr('data-id');
        const $menuAbsolute = $('.menu-absolute' + uniqId);
        const isActive = $(seeMoreBtn).hasClass('popup-active');

        // Update popup content only when it's not already set
        if (!$menuAbsolute.html().trim()) {
            $menuAbsolute.html(htmlPopup);
        }

        if (!isActive) {
            $menuAbsolute.show();
            $(seeMoreBtn).addClass('popup-active');
            // Attach a one-time click event to the document to hide the popup
            $(document).on('click.hidePopup', function(event) {
                // Check if the click is outside the popup and the button
                if (!$(event.target).closest(seeMoreBtn).length && !$(event.target).closest($menuAbsolute).length) {
                    $menuAbsolute.hide();
                    $(seeMoreBtn).removeClass('popup-active');
                    $(document).off('click.hidePopup'); // Remove the event listener
                }
            });
        } else {
            $menuAbsolute.hide();
            $(seeMoreBtn).removeClass('popup-active');
            $(document).off('click.hidePopup'); // Remove the event if manually toggled
        }
    }
</script>

</html>