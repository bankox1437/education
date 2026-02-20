<?php
$links = [
    [
        "title" => "เกี่ยวกับ สกร.อำเภอ",
        "link" => "#"
    ],
    [
        "title" => "บุคลากร",
        "link" => "personal_list"
    ],
    [
        "title" => "การเรียนรู้ตลอดชีวิต",
        "link" => "#"
    ],
    [
        "title" => "การเรียนรู้เพื่อพัฒนาตนเอง",
        "link" => "#"
    ],
    [
        "title" => "การเรียนรู้เพื่อคุณวุฒิตามระดับ",
        "link" => "https://do-el.net/main_menu"
    ],
    [
        "title" => "ประเมินโครงการ",
        "link" => "#"
    ],
    [
        "title" => "เว็บไซต์ห้องสมุด",
        "link" => "https://khokphoblog.blogspot.com/",
        "target" => "_blank"
    ],
    [
        "title" => "facebook ห้องสมุด",
        "link" => "https://www.facebook.com/share/18J2AtYMvr/",
        "target" => "_blank"
    ]
];

$linksChart = [
    [
        "title" => "จำนวน นศ.แบ่งตามระดับชั้น",
        "chart_url" => '<iframe width="470" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vRQ-t5o-5YUNJvVUTfgdReelcqR4kVJ7uYY-hInXmeGcRtV6Vu3z_gZ97R4-bj0txRwpr5asV3FiVSh/pubchart?oid=1391882574&amp;format=interactive"></iframe>'
    ],
    [
        "title" => "จำนวน นศ.แบ่งตามตำบล",
        "chart_url" => '<iframe width="597" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vRQ-t5o-5YUNJvVUTfgdReelcqR4kVJ7uYY-hInXmeGcRtV6Vu3z_gZ97R4-bj0txRwpr5asV3FiVSh/pubchart?oid=1643805906&amp;format=interactive"></iframe>'
    ],
    [
        "title" => "จำนวน นศ.ที่มีสิทธิสอบ แบ่งตามระดับชั้น",
        "chart_url" => '<iframe width="539" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vRQ-t5o-5YUNJvVUTfgdReelcqR4kVJ7uYY-hInXmeGcRtV6Vu3z_gZ97R4-bj0txRwpr5asV3FiVSh/pubchart?oid=507317531&amp;format=interactive"></iframe>'
    ]
];

$executiveProfile = "images/777547.jpg";

?>

<div class="col-md-2 p-3 d-none d-md-block">
    <div class="container">
        <div class="quick-menu">
            <div class="content-header p-0 d-flex align-items-center flex-column">
                <img src="<?php echo $executiveProfile; ?>" alt="Image 6" style="max-width: 80%;">
                <p style="font-size: 16px;font-weight: bold;" class="mt-1 px-2 text-center">
                    <span>นางสาวอาซีซะห์ สาอิ</span><br>
                    <span>ผู้อำนวยการศูนย์ส่งเสริมการเรียนรู้</span><br>
                    <span>ระดับอำเภอโคกโพธิ์</span>
                </p>
            </div>
            <div class="menu row">
                <?php foreach ($links as $link) { ?>
                    <!-- Button to toggle menu -->
                    <a href="<?php echo $link['link'] ?>" <?php echo isset($link['target']) ? "target='_blank'" : "" ?> class="col-md-12 mt-2 btn btn-warning text-uppercase fw-bold text-center rounded-pill" type="button">
                        <p class="m-0" style="font-weight: bold;"><?php echo $link["title"] ?> <span class="close-collapse-edu"></span></p>
                    </a>
                <?php } ?>
                <!-- Button to toggle menu -->
                <a class="col-md-12 mt-2 btn btn-warning d-flex align-items-center justify-content-center text-uppercase fw-bold text-center rounded-pill mt-2" onclick="setRadius(this, 'close-collapse-chart')" type="button" data-toggle="collapse" data-target="#collapsibleMenuChart" aria-expanded="false" aria-controls="collapsibleMenuChart">
                    <p class="m-0" style="font-weight: bold;">กราฟสถิติข้อมูล <span class="close-collapse-chart"></span></p>
                </a>
                <!-- Collapsible Menu -->
                <div class="collapse col-md-12 p-0" id="collapsibleMenuChart">
                    <ul class="list-group">
                        <?php foreach ($linksChart as $link) {
                            // Extract iframe attributes
                            preg_match_all('/(\w+)=["\']([^"\']+)["\']/', $link['chart_url'], $matches);
                            $attributes = array_combine($matches[1], $matches[2]);

                            // Convert attributes to JSON for use in data-chart-url
                            $dataChartUrl = htmlspecialchars(json_encode($attributes), ENT_QUOTES, 'UTF-8');
                        ?>
                            <li class="list-group-item px-1" data-chart-url="<?php echo $dataChartUrl; ?>" style="cursor: pointer;">
                                <a class="text-dark"><b><?php echo $link["title"] ?></b></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Sidebar -->
<div class="mobile-menu d-block d-md-none">
    <div id="sidebar" class="sidebar">
        <div class="quick-menu" style="padding: 0px;">
            <div class="content-header p-0 d-flex align-items-center flex-column">
                <img src="<?php echo $executiveProfile; ?>" alt="Image 6" style="max-width: 50%;">
                <p style="font-size: 12px;font-weight: bold;" class="mt-1 px-0 text-center">
                    <span>นางสาวอาซีซะห์ สาอิ</span><br>
                    <span>ผู้อำนวยการศูนย์ส่งเสริมการเรียนรู้</span><br>
                    <span>ระดับอำเภอโคกโพธิ์</span>
                </p>
            </div>
            <div class="menu row" id="menu">
                <?php foreach ($links as $link) { ?>
                    <!-- Button to toggle menu -->
                    <a href="<?php echo $link['link'] ?>" <?php echo isset($link['target']) ? "target='_blank'" : "" ?> class="col-md-12 mt-2 btn btn-warning text-uppercase fw-bold text-center rounded-pill" type="button">
                        <p class="m-0" style="font-weight: bold;color: #fff;"><?php echo $link["title"] ?> <span class="close-collapse-edu"></span></p>
                    </a>
                <?php } ?>

                <!-- Button to toggle menu -->
                <a class="col-md-12 mt-2 btn btn-warning d-flex align-items-center justify-content-center text-uppercase fw-bold text-center rounded-pill mt-2" onclick="setRadius(this, 'close-collapse-chart')" type="button" data-toggle="collapse" data-target="#collapsibleMenuChart" aria-expanded="false" aria-controls="collapsibleMenuChart">
                    <p class="m-0" style="font-weight: bold;color: #ffffff;">กราฟสถิติข้อมูล <span class="close-collapse-chart"></span></p>
                </a>
                <!-- Collapsible Menu -->
                <div class="collapse" id="collapsibleMenuChart">
                    <ul class="list-group">
                        <?php foreach ($linksChart as $link) {
                            // Extract iframe attributes
                            preg_match_all('/(\w+)=["\']([^"\']+)["\']/', $link['chart_url'], $matches);
                            $attributes = array_combine($matches[1], $matches[2]);

                            // Convert attributes to JSON for use in data-chart-url
                            $dataChartUrl = htmlspecialchars(json_encode($attributes), ENT_QUOTES, 'UTF-8');
                        ?>
                            <li class="list-group-item px-1" data-chart-url="<?php echo $dataChartUrl; ?>" style="cursor: pointer;">
                                <a class="text-dark"><b><?php echo $link["title"] ?></b></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal for Displaying Chart -->
<div class="modal center-modal fade" id="chartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chartModalLabel">Chart Title</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Ensure horizontal scroll in this container -->
                <div id="chartIframeContainer"
                    class="d-flex justify-content-center">
                </div>
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

    function showHide(show, hide) {
        $("#" + hide).fadeOut(300, function() { // ซ่อน hide ด้วย fadeOut และรอจนเสร็จ
            $("#" + show).fadeIn(300); // แสดง show ด้วย fadeIn หลังจาก fadeOut เสร็จ
        });
    }

    function redirect(index_menu) {
        let link = 'https://do-el.net/view-grade/login?index_menu=' + index_menu;
        window.open(link, '_blank');
    }

    function setRadius(btn, className) {
        let active = btn.classList.contains('btn-set-radius') ? 1 : 0;
        if (active == 0) {
            btn.classList.add('btn-set-radius');
            btn.classList.remove('rounded-pill');
            active = 1;
            $("." + className).text("[ ปิดเมนู ]");
        } else {
            btn.classList.add('rounded-pill');
            btn.classList.remove('btn-set-radius');
            active = 0;
            $("." + className).text("");
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const listItems = document.querySelectorAll('.list-group-item');
        const chartModal = new bootstrap.Modal(document.getElementById('chartModal'));
        const chartIframeContainer = document.getElementById('chartIframeContainer');
        const chartModalLabel = document.getElementById('chartModalLabel');

        // Function to create iframe dynamically and display chart
        function displayChart(container, chartOptions, title) {
            // Clear any existing iframe
            container.innerHTML = '';

            // Create a new iframe element
            const iframe = document.createElement('iframe');
            iframe.width = chartOptions.width || '100%';
            iframe.height = chartOptions.height || '300';
            iframe.seamless = chartOptions.seamless === '';
            iframe.frameBorder = chartOptions.frameborder || '0';
            iframe.scrolling = "yes";
            iframe.src = chartOptions.src;

            // Append iframe to the container
            container.appendChild(iframe);

            // Update modal title
            chartModalLabel.textContent = title;

            // Show modal
            chartModal.show();
        }

        // Attach click event to each list item
        listItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent default action

                // Parse the JSON data from data-chart-url
                const chartOptions = JSON.parse(item.getAttribute('data-chart-url'));

                // Get the chart title from the item's text content
                const chartTitle = item.textContent.trim();

                // Call the displayChart function
                displayChart(chartIframeContainer, chartOptions, chartTitle);
            });
        });
    });
</script>