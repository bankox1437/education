<?php session_start() ?>

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
    <link rel="stylesheet" href="include_am/style.css?v=<?php echo time() ?>">
    <style>

    </style>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" style="position: relative;">

    <?php include("include_am/banner.php") ?>

    <div class="container-full" style="background-color: #fff;">
        <section class="content pt-0">
            <?php
            $noImage = "https://static.vecteezy.com/system/resources/previews/004/141/669/non_2x/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg";
            $noImage = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkIa4dF_FqRqUUeSjRDiGqVEt-KMrUUlptoA&s";
            ?>
            <div class="container-fluid" style="padding-bottom: 30px;">
                <div class="row">
                    <div class="col-md-12 p-3">
                        <div class="content-header p-0 d-flex justify-content-between mb-3" style="border-bottom: 3px solid #ea9715;">
                            <a href="https://khokpho-dole.com/">
                                <h3 class="text-bold bg-warning p-2 m-0">ย้อนกลับ</h3>
                            </a>
                            <h3 class="text-bold bg-warning p-2 m-0">ทำเนียบบุคลากร</h3>
                        </div>
                        <div class="container my-4">
                            <div class="content-body" id="executive">
                                <!-- Section: ผู้อำนวยการ -->
                                <div class="row mb-3 justify-content-center">
                                    <div class="col-12">
                                        <h4 class="text-center text-uppercase fw-bold mb-3"><b>ผู้อำนวยการ</b></h4>
                                    </div>
                                    <div class="col-12 col-md-3 text-center mt-3">
                                        <img src="images/777547.jpg" alt="ผู้อำนวยการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: นางสาวอาซีซะห์ สาอิ</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: ผู้อำนวยการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <div class="menu-relative">
                                            <p class="text-muted m-0" style="cursor: pointer;">
                                                <span data-id="1" onclick="addPopup(this)"><b>ดูข้อมูล</b></span>
                                            </p>
                                            <div class="menu-absolute menu-absolute1"></div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="bg-primary m-0 p-0">

                                <!-- Section: ข้าราชการ -->
                                <div class="row mb-3 justify-content-center mt-3">
                                    <div class="col-12">
                                        <h4 class="text-center text-uppercase fw-bold mb-3"><b>ข้าราชการ</b></h4>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ข้าราชการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: ข้าราชการ 1</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: ข้าราชการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <div class="menu-relative">
                                            <p class="text-muted m-0" style="cursor: pointer;" data-id="2" onclick="addPopup(this)">
                                                <b>ดูข้อมูล</b>
                                            </p>
                                            <div class="menu-absolute menu-absolute2"></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ข้าราชการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: ข้าราชการ 2</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: ข้าราชการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <div class="menu-relative">
                                            <p class="text-muted m-0" style="cursor: pointer;" data-id="3" onclick="addPopup(this)">
                                                <b>ดูข้อมูล</b>
                                            </p>
                                            <div class="menu-absolute menu-absolute3"></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ข้าราชการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: ข้าราชการ 3</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: ข้าราชการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <div class="menu-relative">
                                            <p class="text-muted m-0" style="cursor: pointer;" data-id="4" onclick="addPopup(this)">
                                                <b>ดูข้อมูล</b>
                                            </p>
                                            <div class="menu-absolute menu-absolute4"></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ข้าราชการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: ข้าราชการ 4</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: ข้าราชการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <div class="menu-relative">
                                            <p class="text-muted m-0" style="cursor: pointer;" data-id="5" onclick="addPopup(this)">
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
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ครูอาสาสมัครฯ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: ครูอาสาสมัครฯ 1</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: ครูอาสาสมัครฯ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ครูอาสาสมัครฯ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: ครูอาสาสมัครฯ 2</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: ครูอาสาสมัครฯ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ครูอาสาสมัครฯ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: ครูอาสาสมัครฯ 3</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: ครูอาสาสมัครฯ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="ครูอาสาสมัครฯ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: ครูอาสาสมัครฯ 4</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: ครูอาสาสมัครฯ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
                                    </div>
                                </div>

                                <hr class="bg-primary m-0 p-0">

                                <!-- Section: พนักงานราชการ -->
                                <div class="row mb-3 justify-content-center mt-3">
                                    <div class="col-12">
                                        <h4 class="text-center text-uppercase fw-bold mb-3"><b>พนักงานราชการ</b></h4>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="พนักงานราชการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: พนักงานราชการ 1</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: พนักงานราชการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="พนักงานราชการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: พนักงานราชการ 2</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: พนักงานราชการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="พนักงานราชการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: พนักงานราชการ 3</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: พนักงานราชการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="พนักงานราชการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: พนักงานราชการ 4</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: พนักงานราชการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
                                    </div>
                                </div>

                                <hr class="bg-primary m-0 p-0">

                                <!-- Section: จ้างเหมาบริการ -->
                                <div class="row mb-3 justify-content-center mt-3">
                                    <div class="col-12">
                                        <h4 class="text-center text-uppercase fw-bold mb-3"><b>จ้างเหมาบริการ</b></h4>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="จ้างเหมาบริการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: จ้างเหมาบริการ 1</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: จ้างเหมาบริการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="จ้างเหมาบริการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: จ้างเหมาบริการ 2</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: จ้างเหมาบริการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="จ้างเหมาบริการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: จ้างเหมาบริการ 3</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: จ้างเหมาบริการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
                                    </div>
                                    <div class="col-6 col-md-3 text-center mt-3">
                                        <img src="https://i.pinimg.com/564x/d5/b0/4c/d5b04cc3dcd8c17702549ebc5f1acf1a.jpg" alt="จ้างเหมาบริการ" class="img-fluid custom-image mb-2">
                                        <h5 class="fw-bold m-0">ชื่อ: จ้างเหมาบริการ 4</h5>
                                        <p class="text-muted m-0">ตำแหน่ง: จ้างเหมาบริการ</p>
                                        <p class="text-muted m-0">งานที่รับผิดชอบ: -</p>
                                        <p class="text-muted m-0" style="cursor: pointer;"><b>ดูข้อมูล</b></p>
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

    <?php include("include_am/footer.php") ?>

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