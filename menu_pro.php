<?php
$sql = "SELECT * FROM tb_menus WHERE type = 'pro' ORDER BY order_number ASC";
$data_result = $DB->Query($sql, []);
$menu_list = json_decode($data_result, true);

// Initialize menu list with default values
$menu_list = $menu_list;

?>
<div class="row justify-content-center" style="margin-top: 20px;">
    <div class="col-md-12 header-titile">
        <h2 class="text-center">สำหรับแอดมินจังหวัด</h2>
    </div>
    <div class="col-md-12 mt-4">
        <div class="container">
            <div class="row justify-content-start">
                <?php foreach ($menu_list as $key => $menu) {
                    if (empty($menu['role'])) { ?>
                        <div class="col-6 col-md-4 icon-container">
                            <a href="<?php echo isset($_SESSION['user_data']) ? $menu['url'] : $menu['url_login'] ?>">
                                <img src="<?php echo $menu['menu_icon']; ?>" alt="<?php echo $menu['menu_icon']; ?>">
                                <p style="color: <?php echo $menu['menu_color']; ?>"><?php echo $menu['menu_name']; ?></p>
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="col-6 col-md-4 icon-container">
                            <a href="#" <?php echo isset($statusRole[$menu['role']]) && $statusRole[$menu['role']] ? 'style="cursor: pointer;"' : 'style="cursor: no-drop;"' ?> onclick="checkRoleSystem('<?php echo $menu['role'] ?>','<?php echo isset($_SESSION['user_data']) ? $menu['url'] : $menu['url_login'] ?>')" style="<?php echo isset($statusRole[$menu['role']]) && $statusRole[$menu['role']] ? 'cursor: pointer;' : 'cursor: no-drop;' ?>">
                                <img src="<?php echo $menu['menu_icon']; ?>" alt="<?php echo $menu['menu_icon']; ?>">
                                <p style="color: <?php echo $menu['menu_color']; ?>"><?php echo $menu['menu_name']; ?> <?php echo isset($statusRole[$menu['role']]) && $statusRole[$menu['role']] ? '' : '<i class="fa fa-lock"></i>' ?></p>
                            </a>
                        </div>
                <?php    }
                } ?>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-8 mt-3">
        <a href="view-grade/main_dashboard">
            <p class="text-center"><i class="mr-0 fa fa-arrow-left"></i> ย้อนกลับหน้าแดชบอร์ด</p>
        </a>
    </div> -->
</div>

<style>
    .header-titile {
        background-color: #65B741 !important;
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