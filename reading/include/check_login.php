<?php
session_start();
if (!isset($_SESSION['user_data'])) {
    header('location:  ../index');
}

include "../config/main_function.php";
$mainFunc = new ClassMainFunctions();
$version = $mainFunc->version_script();
?>

<script>
    const role_id = '<?php echo $_SESSION['user_data']->role_id ?>';
    const type_user = '<?php echo $_SESSION['user_data']->edu_type ?>';
</script>