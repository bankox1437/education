<?php

session_start();

if (!isset($_SESSION['user_data'])) {
    echo '<script>location.href = "main_menu";</script>';
}

if ($_SESSION['user_data']->role_id == 3) {
    include('dashboard_main_kru.php');
} else if ($_SESSION['user_data']->role_id == 2) {
    include('dashboard_main_district.php');
} else if ($_SESSION['user_data']->role_id == 6) {
    include('dashboard_main_province.php');
}else{
    header('location: ../main_menu');
}
