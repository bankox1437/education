<style>
    .chart-link-hidden {
        display: none !important;
    }

    .chart-link-visible {
        display: block !important;
    }

    .sgr-hidden {
        display: none !important;
    }

    .sgr-visible {
        display: block !important;
    }

    .lib-hidden {
        display: none !important;
    }

    .lib-visible {
        display: block !important;
    }
</style>
<div class="">
    <!-- <div class="quick-menu text-center">
        <div class="content-header p-0 d-flex align-items-center flex-column justify-content-center">
            <?php $executiveProfile = "images/777547.jpg"; ?>
            <img src="<?php echo $executiveProfile; ?>" alt="Image 6">
            <p style="font-size: 16px;font-weight: bold;margin-top: 10px;color: #ffffff;" class="px-2 text-center">
                <span>นางสาวอาซีซะห์ สาอิ</span><br>
                <span>ผู้อำนวยการศูนย์ส่งเสริมการเรียนรู้</span><br>
                <span>ระดับอำเภอโคกโพธิ์</span>
            </p>
        </div>
    </div> -->

    <ul class="nav nav-pills nav-stacked nav-left-side text-center">
        <?php foreach ($links as $link) {
            $sql = "SELECT * FROM am_menu_left WHERE sub_menu = " . $link['menu_id'] . " ORDER BY menu_id ASC";
            $checkSubMenu = $DB->Query($sql, []);
            $checkSubMenu = json_decode($checkSubMenu, true);
            $checkSubMenu = $checkSubMenu;
            if (count($checkSubMenu) == 0) { ?>
                <li>
                    <a style="background-color: <?php echo $link['menu_color']; ?>;" href="<?php echo $link['link'] ?>" <?php echo !empty($link['target']) ? 'target="_blank"' : ''; ?>>
                        <?php echo $link["menu_name"] ?>
                    </a>
                </li>
            <?php } else { ?>
                <li onclick="ShowChartList('menu_dropdown_<?php echo $link['menu_id']; ?>')">
                    <a style="background-color: <?php echo $link['menu_color']; ?>; cursor: pointer;">
                        <?php echo $link["menu_name"] ?> <i class="ti-arrow-circle-down"></i>
                    </a>
                </li>

                <style>
                    .menu_dropdown_<?php echo $link['menu_id']; ?>-hidden {
                        display: none !important;
                    }

                    .menu_dropdown_<?php echo $link['menu_id']; ?>-visible {
                        display: block !important;
                    }
                </style>

                <?php foreach ($checkSubMenu as $subLink) {
                    if ($subLink['sub_menu'] == 30) {
                        preg_match_all('/(\w+)=["\']([^"\']+)["\']/', $subLink['link'], $matches);
                        $attributes = array_combine($matches[1], $matches[2]);
                        $dataChartUrl = htmlspecialchars(json_encode($attributes), ENT_QUOTES, 'UTF-8'); ?>
                        <li class="menu_dropdown_<?php echo $link['menu_id']; ?>-hidden">
                            <a style="background-color: <?php echo $subLink['menu_color']; ?>;color: #000000;cursor: pointer;" class="chart-link menu_dropdown_<?php echo $link['menu_id']; ?>" data-chart-url="<?php echo $dataChartUrl; ?>">
                                <?php echo $subLink["menu_name"]; ?>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="menu_dropdown_<?php echo $link['menu_id']; ?>-hidden">
                            <a style="background-color: <?php echo $subLink['menu_color']; ?>;color: #000000;cursor: pointer;" class="menu_dropdown_<?php echo $link['menu_id']; ?>" href="<?php echo $subLink['link'] ?>">
                                <?php echo $subLink["menu_name"]; ?>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            <?php  } ?>

        <?php } ?>

        <!-- <li onclick="ShowChartList('chart-link')" id="chartToggle">
            <a style="background-color: pink; cursor: pointer;">
                กราฟสถิติข้อมูล <i class="ti-arrow-circle-down"></i>
            </a>
        </li> -->

        <?php foreach ($linksChart as $link) {
            preg_match_all('/(\w+)=["\']([^"\']+)["\']/', $link['link'], $matches);
            $attributes = array_combine($matches[1], $matches[2]);
            $dataChartUrl = htmlspecialchars(json_encode($attributes), ENT_QUOTES, 'UTF-8');
        ?>
            <!-- <li class="chart-link-hidden">
                <a style="background-color: <?php echo $link['menu_color']; ?>;color: #000000;cursor: pointer;" class="chart-link" data-chart-url="<?php echo $dataChartUrl; ?>">
                    <?php echo $link["menu_name"]; ?>
                </a>
            </li> -->
        <?php } ?>

        <!-- <li onclick="ShowChartList('sgr')">
            <a style="background-color:#0fe912; cursor: pointer;">
                ศกร. ตำบล <i class="ti-arrow-circle-down"></i>
            </a>
        </li> -->

        <?php foreach ($linksSubDis as $link) { ?>
            <!-- <li class="sgr-hidden">
                <a style="background-color: <?php echo $link['menu_color']; ?>;color: #000000;cursor: pointer;" class="sgr" href="<?php echo $link['link'] ?>">
                    <?php echo $link["menu_name"]; ?>
                </a>
            </li> -->
        <?php } ?>

        <li>
            <?php
            $adminLink = "https://khokpho-dole.com/admin/login";
            if (count($_SESSION) > 0) {
                $adminLink = "https://khokpho-dole.com/admin/settings_am";
                if ($_SESSION['user_data']->edu_type == "adminweb") {
                    $adminLink = "https://khokpho-dole.com/adminweb/settings_am";
                }
            }
            ?>
            <a style="background-color: #ffffff;color: #000000;" href="<?php echo $adminLink ?>">
                Admin Login
            </a>
        </li>

    </ul>
</div>

<script>
    function ShowChartList(id) {
        document.querySelectorAll(`.${id}-hidden, .${id}-visible`).forEach(item => {
            if (item.classList.contains(`${id}-hidden`)) {
                item.classList.remove(`${id}-hidden`);
                item.classList.add(`${id}-visible`);
            } else {
                item.classList.remove(`${id}-visible`);
                item.classList.add(`${id}-hidden`);
            }
        });
    }

    // ซ่อนเมนูถ้าคลิกนอก
    document.addEventListener('click', function(event) {
        const chartToggle = document.getElementById('chartToggle');
        const isClickInside = chartToggle.contains(event.target) ||
            event.target.closest('.chart-link-visible'); // ยอมให้คลิกเมนูย่อย

        if (!isClickInside) {
            document.querySelectorAll('.chart-link-visible').forEach(item => {
                item.classList.remove('chart-link-visible');
                item.classList.add('chart-link-hidden');
            });
        }
    });
</script>