<?php
session_start();
if (!isset($_SESSION['user_data'])) {
    header('location:  login');
}
include "../config/main_function.php";
$mainFunc = new ClassMainFunctions();
$version = $mainFunc->version_script();
?>

<script>
    const user_id = '<?php echo $_SESSION['user_data']->id ?>';
    const role_id = '<?php echo $_SESSION['user_data']->role_id ?>';
    const type_user = '<?php echo $_SESSION['user_data']->edu_type ?>';
</script>