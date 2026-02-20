<?php
session_start();
include 'include/check_login.php';
if ($_SESSION['user_data']->role_id == 3) {
    header('location: manage_n_net');
}
if ($_SESSION['user_data']->role_id == 1) {
    header('location: dashboard');
}
if ($_SESSION['user_data']->role_id == 2) {
    header('location: dashboard');
}
if ($_SESSION['user_data']->role_id == 4) {
    header('location: index_student');
}
if ($_SESSION['user_data']->role_id == 6) {
    header('location: main_dashboard');
}
