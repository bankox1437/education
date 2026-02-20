<?php

if ($_SESSION['user_data']->role_id != 4) {
    if ($_SESSION['user_data']->role_id == 2) {
        header('location:  manage_terms');
    } else if ($_SESSION['user_data']->role_id == 3) {
        header('location:  student_list');
    } else {
        header('location:  manage_test_grade');
    }
}
