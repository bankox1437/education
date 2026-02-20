<?php
session_start();
if ($_SESSION['user_data']->role_id == 3) {
    header('location: index-online');
} else if ($_SESSION['user_data']->role_id == 4) {
    header('location: index-online');
} else {
    header('location: teacher_list');
}
