<?php
include 'include/check_login.php';
include "../config/class_database.php";

$DB = new Class_Database();
$sql = "SELECT\n" .
    "	sp.*,\n" .
    "	CONCAT( std.std_code, '-', std.std_prename, std.std_name ) std_name, \n" .
    "	CONCAT( std.std_prename, std.std_name ) name, \n" .
    "   std.std_birthday, \n" .
    "   std.std_father_name, \n" .
    "   std.std_father_job, \n" .
    "   std.std_mather_name, \n" .
    "   std.std_mather_job, \n" .
    "   std.std_father_phone, \n" .
    "   std.std_mather_phone, \n" .
    "   std.std_id \n" .
    "FROM\n" .
    "	stf_tb_form_student_person_new sp\n" .
    "	LEFT JOIN tb_students std ON sp.std_id = std.std_id \n" .
    "WHERE\n" .
    "	sp.std_id = :std_id";
$data = $DB->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
$std_per_data = json_decode($data);

if (count($std_per_data) == 0) {
    $sql = "SELECT\n" .
        "	std.std_id,\n" .
        "	std.std_prename,\n" .
        "	std.std_name,\n" .
        "	std.std_birthday\n" .
        "FROM\n" .
        "	tb_users u \n" .
        "LEFT JOIN\n" .
        "	tb_students std ON u.edu_type = std.std_id\n" .
        "WHERE u.edu_type = :edu_type";
    $data = $DB->Query($sql, ['edu_type' => $_SESSION['user_data']->edu_type]);
    $std_data = json_decode($data);
    $std_data = $std_data[0];

    $std_id = $std_data->std_id;
    include_once("./students_data_add.php");
} else {
    $std_per_data = $std_per_data[0];
    $std_per_id = $std_per_data->std_per_id;
    $std_id = $_SESSION['user_data']->edu_type;
    // echo "<pre>";
    // print_r($std_per_data);
    // echo "</pre>";
    include_once("./students_data_index.php");
}
