<?php
include 'include/check_login.php';

if ($_SESSION['user_data']->role_id == 3) {
    include_once('dashboard_kru.php');
} else{
    include_once('dashboard_am.php');
}