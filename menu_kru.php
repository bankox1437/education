<?php
$calendar_new = false;
if ($_SESSION['user_data']->role_id != 4) {
    $status = json_decode($_SESSION['user_data']->status);
    $calendar_new = isset($status->calendar_new)  && !empty($status->calendar_new) ? true : false;
}
$calendarRedirect = "manage_calendar?class=0";
if ($calendar_new) {
    $calendarRedirect = "manage_calendar?class=1";
}


$sql = "SELECT * FROM tb_menus WHERE type = 'kru' ORDER BY order_number ASC";
$data_result = $DB->Query($sql, []);
$data_result = json_decode($data_result, true);

// Initialize menu list with default values
$menu_list = $data_result;

$menu1 = $menu_list[0];
$menu2 = $menu_list[1];

unset($menu_list[0]);
unset($menu_list[1]);

?>
<div class="row justify-content-center" style="margin-top: 20px;">
    <div class="col-md-12 header-titile">
        <h2 class="text-center">สำหรับครู</h2>
    </div>
    <div class="col-md-12 mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-md-3 icon-container">
                    <a href="student_list">
                        <img src="<?php echo $menu1['menu_icon']; ?>" alt="<?php echo $menu1['menu_icon']; ?>">
                        <p style="color: <?php echo $menu1['menu_color']; ?>"><?php echo $menu1['menu_name']; ?></p>
                    </a>
                </div>
                <div class="col-6 col-md-3 icon-container">
                    <a href="#" onclick="checkRoleSystem('<?php echo $menu2['role'] ?>','<?php echo isset($_SESSION['user_data']) ? $menu2['url'] : $menu2['url_login'] ?>')" style="<?php echo isset($statusRole[$menu2['role']]) && $statusRole[$menu2['role']] ? 'cursor: pointer;' : 'cursor: no-drop;' ?>">
                        <img src="<?php echo $menu2['menu_icon']; ?>" alt="<?php echo $menu2['menu_icon']; ?>">
                        <p style="color: <?php echo $menu2['menu_color']; ?>"><?php echo $menu2['menu_name']; ?> <?php echo isset($statusRole[$menu2['role']]) && $statusRole[$menu2['role']] ? '' : '<i class="fa fa-lock"></i>' ?></p>
                    </a>
                </div>
            </div>
            <div class="row text-center">
                <?php foreach ($menu_list as $key => $menu) {
                    if (empty($menu['role'])) {
                        $param = "";
                        if ($menu['menu_id'] == 39) {
                            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                            $host = $_SERVER['HTTP_HOST'];
                            $fullUrl = $protocol . $host;
                            $fullUrlLink = $fullUrl . "/" . explode('/', $_SERVER['REQUEST_URI'])[1] . "/" . explode('/', $_SERVER['REQUEST_URI'])[2]; // localhost
                            // $fullUrlLink = $fullUrl . "/" . explode('/', $_SERVER['REQUEST_URI'])[2] . "/" . explode('/', $_SERVER['REQUEST_URI'])[3];
                            $param = $fullUrlLink;
                        }  ?>
                        <div class="col-6 col-md-3 icon-container">
                            <a href="<?php echo isset($_SESSION['user_data']) ? $menu['url'] .  $param : $menu['url_login'] ?>">
                                <img src="<?php echo $menu['menu_icon']; ?>" alt="<?php echo $menu['menu_icon']; ?>">
                                <p style="color: <?php echo $menu['menu_color']; ?>"><?php echo $menu['menu_name']; ?></p>
                            </a>
                        </div>
                    <?php } else {
                        $param = "";
                        if ($menu['menu_id'] == 31) {
                            $param = $calendarRedirect;
                        }
                    ?>
                        <div class="col-6 col-md-3 icon-container">
                            <a href="#" onclick="checkRoleSystem('<?php echo $menu['role'] ?>','<?php echo isset($_SESSION['user_data']) ? $menu['url'] . $param : $menu['url_login'] ?>')" style="<?php echo isset($statusRole[$menu['role']]) && $statusRole[$menu['role']] ? 'cursor: pointer;' : 'cursor: no-drop;' ?>">
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
        background-color: #e50102 !important;
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