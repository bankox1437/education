<?php

$sql = "SELECT * FROM tb_menus WHERE type = 'std' ORDER BY order_number ASC";
$data_result = $DB->Query($sql, []);
$data_result = json_decode($data_result, true);
$menu_list = $data_result;
?>
<div class="row justify-content-center" style="margin-top: 20px;margin-left:10px;margin-right:10px;">
    <div class="col-md-12 header-titile">
        <h2 class="text-center">สำหรับนักศึกษา</h2>
    </div>
    <div class="col-md-12 mt-4">
        <div class="container">
            <div class="row justify-content-start">
                <div class="row justify-content-start">
                    <?php foreach ($menu_list as $key => $menu) {
                        $paramUrl12 = $menu['menu_id'] == 12 ? $_SESSION['user_data']->edu_type : '';
                    ?>
                        <?php
                        if ($menu['order_number'] == 12) {
                            $termArr = explode('/', $_SESSION['term_active']->term_name);
                            $sql = "SELECT m_calendar_file FROM cl_main_calendar WHERE user_create = " . $_SESSION['user_data']->user_create . " AND term = " . $termArr[0] . " AND year = " . $termArr[1];
                            $query = $DB->Query($sql, []);
                            $m_calendar_file = json_decode($query);
                            if (count($m_calendar_file) > 0) { ?>
                                <div class="col-6 col-md-4 icon-container">
                                    <a href="<?php echo 'visit-online/uploads/calendar/' . $m_calendar_file[0]->m_calendar_file ?>" target="_blank">
                                        <img src="<?php echo $menu['menu_icon']; ?>" alt="<?php echo $menu['menu_icon']; ?>">
                                        <p style="color: <?php echo $menu['menu_color']; ?>"><?php echo $menu['menu_name']; ?></p>
                                    </a>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="col-6 col-md-4 icon-container">
                                <a href="<?php echo isset($_SESSION['user_data']) ? $menu['url'] . $paramUrl12 : $menu['url_login'] ?>">
                                    <img src="<?php echo $menu['menu_icon']; ?>" alt="<?php echo $menu['menu_icon']; ?>">
                                    <p style="color: <?php echo $menu['menu_color']; ?>"><?php echo $menu['menu_name']; ?></p>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 mt-3">
        <a href="view-grade/main_dashboard">
            <p class="text-center"><i class="mr-0 fa fa-arrow-left"></i> ย้อนกลับหน้าแดชบอร์ด</p>
        </a>
    </div>
</div>

<style>
    .header-titile {
        background-color: #0000ff !important;
        box-shadow: unset;
        color: #fff;
        border-radius: 20px;
    }

    .icon-container {
        text-align: center;
        margin: 20px 0;
    }

    .icon-container p {
        font-weight: bold;
        color: #000;
    }

    .icon-container img {
        width: 50px;
        /* Set width for all images */
        height: 50px;
        /* Set height for all images */
        margin-bottom: 10px;
    }

    .icon-container a {
        text-decoration: none;
        /* Remove underline from link */
        color: inherit;
        /* Inherit the color from parent to keep the text color */
        display: block;
        /* Make the entire section clickable */
    }

    .icon-container a :hover {
        color: #5949d6;
    }
</style>