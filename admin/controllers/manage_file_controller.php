<?php

$directories = [
    [
        "path" => '../../visit-online/uploads/edu_plan',
        "table" => 'cl_learning_images',
        "table_id" => 'c_img_id',
        "table_field" => 'img_name_4',
        "drive_folder_id" => "1HjIWTjHT4WiiUMFhLrqFDBKX769V02Y9",
    ],
    [
        "path" => '../../visit-online/uploads/edu_plan_new',
        "table" => 'cl_calendar_new',
        "table_id" => 'calendar_id',
        "table_field" => 'content_file',
        "drive_folder_id" => "1k0aKiXVpUIBxPcJmiZiI2sEPa856Es6r",
    ],
    // [
    //     "path" => '../../visit-online/uploads/report_img',
    //     "table" => '',
    //     "table_id" => '',
    //     "table_field" => '',
    //     "drive_folder_id" => "1HjIWTjHT4WiiUMFhLrqFDBKX769V02Y9",
    // ],
    // [
    //     "path" => '../../visit-online/uploads/work',
    //     "table" => '',
    //     "table_id" => '',
    //     "table_field" => '',
    //     "drive_folder_id" => "1HjIWTjHT4WiiUMFhLrqFDBKX769V02Y9",
    // ],
    [
        "path" => '../../visit-online/uploads/work_new',
        "table" => 'cl_work_new',
        "table_id" => 'work_id',
        "table_field" => 'file_name',
        "drive_folder_id" => "148dbc-GP1YgW1v_B8ih_IaItj_YPoz3I",
    ],
    // [
    //     "path" => '../../view-grade/uploads/table_test_pdf',
    //     "table" => '',
    //     "table_id" => '',
    //     "table_field" => '',
    //     "drive_folder_id" => "1HjIWTjHT4WiiUMFhLrqFDBKX769V02Y9",
    // ],
    [
        "path" => '../../visit-online/uploads/index_files',
        "table" => 'cl_index_file',
        "table_id" => 'index_file_id',
        "table_field" => 'file_name',
        "drive_folder_id" => "1tzDBe4qdAovxCRWTn5Eesc_t6yrPjiKE",
    ],
    [
        "path" => '../../reading/uploads/media',
        "table" => 'rd_medias',
        "table_id" => 'media_id',
        "table_field" => 'media_file_name',
        "drive_folder_id" => "1dEWcjtFHzWyjeQu3SgE6pUslpDh8Hhgt",
    ],
    [
        "path" => '../../reading/uploads/media_cover',
        "table" => 'rd_medias',
        "table_id" => 'media_id',
        "table_field" => 'media_file_name_cover',
        "drive_folder_id" => "1noxN7lG4MXI6gys64dxRp7HrUxW3ZRN8",
    ],
];

if (isset($_POST['getListFile'])) {
    header('Content-Type: application/json');

    $response = [];

    for ($i = 0; $i < count($directories); $i++) {
        $directoryPathObj = $directories[$i];
        $directoryPath = $directoryPathObj['path'];

        if (!is_dir($directoryPathObj['path'])) {
            $response[] = [
                'folder' => basename($directoryPath),
                'size' => 'Invalid directory'
            ];
            continue;
        }

        $folderPath = $directoryPath;

        if (is_dir($folderPath)) {
            $folderSize = getFolderSize($folderPath);
            $response[] = [
                'folder' => basename($directoryPath),
                'size' => formatSize($folderSize),
                'index' => $i
            ];
            // Send partial response (Unbuffered output)
            ob_flush();
            flush();
        }
    }

    echo json_encode($response);
    exit();
}

function getFolderSize($folderPath)
{
    $totalSize = 0;
    if (!is_dir($folderPath)) {
        return 0;
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($folderPath, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($files as $file) {
        if ($file->isFile()) {
            $totalSize += $file->getSize();
        }
    }

    return $totalSize;
}

function formatSize($size)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $unitIndex = 0;

    while ($size >= 1024 && $unitIndex < count($units) - 1) {
        $size /= 1024;
        $unitIndex++;
    }

    return round($size, 2) . " " . $units[$unitIndex];
}


if ($_POST['moveToDrive']) {
    include("../../config/class_google_drive.php");
    include "../../config/class_database.php";
    include "../../config/main_function.php";

    $DB = new Class_Database();
    $mainFunc = new ClassMainFunctions();

    $clientID = $mainFunc->getAttr($DB, 'clientID');
    $clientSecret = $mainFunc->getAttr($DB, 'clientSecret');
    $redirectURI = $mainFunc->getAttr($DB, 'redirectURI');

    $drive = new GoogleDriveAPI($clientID, $clientSecret, $redirectURI);

    $refresh_token = $mainFunc->getAttr($DB, 'refresh_token');

    $drive->setRefreshToken($refresh_token);

    $responseRefresh = $drive->refreshAccessToken();

    if (isset($responseRefresh['status']) && empty($responseRefresh['status'])) {
        echo json_encode($responseRefresh);
        die();
    }

    $folderIndex = $_POST['folderIndex'];

    $mainFunc->setAttr($DB, 'access_token', $responseRefresh['access_token']);
    $mainFunc->setAttr($DB, 'expires_in', $responseRefresh['expires_in']);
    $mainFunc->setAttr($DB, 'refresh_token_expires_in', $responseRefresh['refresh_token_expires_in']);

    // กำหนด path ของโฟลเดอร์ที่ต้องการอัปโหลด
    $folderPath = $directories[$folderIndex]['path'];

    $table = $directories[$folderIndex]['table']; //'cl_learning_images';
    $table_id = $directories[$folderIndex]['table_id']; //'c_img_id';
    $table_field = $directories[$folderIndex]['table_field']; // 'img_name_4';
    $drive_folder_id = $directories[$folderIndex]['drive_folder_id'];

    // อัปโหลดไฟล์ทั้งหมดในโฟลเดอร์
    $uploadedFiles = $drive->uploadFolder($DB, $folderPath, $drive_folder_id, $table, $table_id, $table_field);

    $arrSQL = [];

    foreach ($uploadedFiles['uploaded_files'] as $key => $value) {
        $sql = "UPDATE $table set $table_field  = '" . $value['drive_id'] . "' WHERE $table_id = " . $value['table_id'];
        array_push($arrSQL, $sql);
        $updateStatus = $DB->Update($sql, []);
        if ($updateStatus) {
            if (file_exists($value['filePath'])) {
                unlink($value['filePath']);
            }
        }
    }

    // $uploadedFiles['SQL'] = $arrSQL;

    echo json_encode($uploadedFiles);
}
