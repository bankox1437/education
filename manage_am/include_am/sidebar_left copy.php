<style>
    .quick-menu {
        padding: 15px;
        /* border: 1px solid #ddd; */
        /* เส้นขอบ */
        border-radius: 5px;
        /* มุมโค้ง */
    }

    .menu-item img {
        flex-shrink: 0;
        /* ให้ภาพไม่ถูกบีบ */
        background-color: #f8f5e9;
        /* สีพื้นหลัง */
    }

    .menu-item span {
        color: #5a5a5a;
        /* สีข้อความ */
        font-size: 16px;
        /* ขนาดข้อความ */
        line-height: 1.2;
    }

    .menu-item:hover span {
        color: #000;
        /* เปลี่ยนสีข้อความเมื่อ hover */
    }
</style>
<?php

$links = [
    [
        "title" => "LEIS",
        "link" => "index_am"
    ],
    [
        "title" => "ส่งเสริมการอ่าน",
        "link" => "#"
    ],
    [
        "title" => "แนะแนวและให้คำปรึกษา",
        "link" => "#"
    ],
    [
        "title" => "บุคลากร",
        "link" => "#"
    ],
    [
        "title" => "องค์กรนักศึกษา",
        "link" => "#"
    ],
    [
        "title" => "กรรมการสถานศึกษา",
        "link" => "#"
    ]
];

$executiveProfile = "images/a4a94b33-2184-48e9-8d89-d0729aefffee-removebg-preview.png";

?>

<div class="col-md-2 p-3 d-none d-md-block">
    <div class="container">
        <div class="quick-menu">
            <!-- <div class="content-header p-0 d-flex align-items-center flex-column">
                <img src="<?php echo $executiveProfile; ?>" alt="Image 6" style="max-width: 100%;">
                <p style="font-size: 24px;font-weight: bold;" class="bg-info mt-1 px-2">ผู้พัฒนา</p>
            </div> -->
            <div class="menu">
                <?php foreach ($links as $link) { ?>
                    <a href="<?php echo $link["link"] ?>"
                        class="btn btn-warning d-flex align-items-center justify-content-center text-uppercase fw-bold text-center mb-3 rounded-pill"
                        style="height: 50px;">
                        <h3 class="m-0" style="font-weight: bold;"><?php echo $link["title"] ?></h3>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Sidebar -->
<div class="mobile-menu d-block d-md-none">
    <div id="sidebar" class="sidebar">
        <div class="quick-menu" style="padding: 0px;">
            <div class="content-header p-0 d-flex align-items-center flex-column">
                <img src="<?php echo $executiveProfile; ?>" alt="Image 6" style="max-width: 100%;">
                <p style="font-size: 24px;font-weight: bold;"  class="bg-info mt-1 px-2">ผู้พัฒนา</p>
            </div>
            <div class="menu">
                <?php foreach ($links as $link) { ?>
                    <a href="<?php echo $link["link"] ?>"
                        class="btn btn-warning d-flex align-items-center justify-content-center text-uppercase fw-bold text-center mb-3 rounded-pill"
                        style="height: 40px;color: #fff;">
                        <h6 class="m-0" style="font-weight: bold;"><?php echo $link["title"] ?></h6>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<script>
    // เปิด Sidebar
    document.getElementById("toggleMenu").addEventListener("click", function() {
        document.getElementById("sidebar").classList.add("open");
    });

    // ปิด Sidebar เมื่อคลิกนอก Sidebar
    document.addEventListener("click", function(event) {
        const sidebar = document.getElementById("sidebar");
        const toggleMenuButton = document.getElementById("toggleMenu");

        // ตรวจสอบว่าคลิกเกิดนอก sidebar และไม่ได้คลิกที่ปุ่มเปิดเมนู
        if (sidebar.classList.contains("open") && !sidebar.contains(event.target) && event.target !== toggleMenuButton) {
            sidebar.classList.remove("open");
        }
    });
</script>