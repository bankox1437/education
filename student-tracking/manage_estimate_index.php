<?php
include 'include/check_login.php';

if ($_SESSION['user_data']->role_id == 3) {
    include("manage_estimate.php");
} else {
    include("manage_estimate_list.php");
}
