<?php
if ($_SESSION['user_data']->role_id != 3 && $_SESSION['user_data']->role_id != 2 && $_SESSION['user_data']->role_id != 1 && $_SESSION['user_data']->role_id != 6) {
    echo '<script>location.href = "index";</script>';
}
