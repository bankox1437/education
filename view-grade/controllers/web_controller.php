<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";

$DB = new Class_Database();

function CheckUploadFileImage($file, $file_old = "")
{
    $mainFunc = new ClassMainFunctions();
    $uploadDir = '../../images/personals/';
    $resizeDir = '../uploads/';

    $file_response = $mainFunc->UploadFileImage($file, $uploadDir, $resizeDir);
    if (!$file_response['status']) {
        $response = array('status' => false, 'msg' => $file_response['result']);
        echo json_encode($response);
        exit();
    }
    if (!empty($file_old)) {
        unlink($uploadDir . $file_old);
    }
    return $file_response['result'];
}

if (isset($_POST['setting_personal'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $type = $_POST['type'];
    $position = $_POST['position'];
    $task = $_POST['task'];
    $imageProfile = $_POST['image_profile_old'];

    // Handle file upload
    if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
        $imageProfile = CheckUploadFileImage($_FILES['profile'], $imageProfile);
    }

    // Insert or update data in the database
    try {
        // Example query (adjust based on your database structure)
        $query = "INSERT INTO web_personal (type, name, position, task, profile, user_create) VALUES (:type, :name, :position, :task, :image_profile, :user_create)";
        $params = [
            ':type' => $type,
            ':name' => $name,
            ':position' => $position,
            ':task' => $task,
            ':image_profile' => $imageProfile,
            ':user_create' => $_SESSION['user_data']->district_am_id
        ];
        $DB->query($query, $params);

        // Return success response
        echo json_encode(['status' => 'success', 'message' => 'บันทึกข้อมูลสําเร็จ']);
    } catch (Exception $e) {
        // Handle database errors
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
