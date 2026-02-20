<?php
date_default_timezone_set('Asia/Bangkok');
if (isset($_REQUEST['code'])) {
    include("config/class_google_drive.php");
    include "config/class_database.php";
    include "config/main_function.php";

    $DB = new Class_Database();
    $mainFunc = new ClassMainFunctions();

    $clientID = $mainFunc->getAttr($DB, 'clientID');
    $clientSecret = $mainFunc->getAttr($DB, 'clientSecret');
    $redirectURI = $mainFunc->getAttr($DB, 'redirectURI');

    $drive = new GoogleDriveAPI($clientID, $clientSecret, $redirectURI);

    $response = $drive->getAccessTokenFromCode($_REQUEST['code']);

    function setAttr($DB, $key, $value)
    {
        $sql = "DELETE FROM tb_setting_attribute WHERE key_name = '" . $key . "'";
        $DB->Delete($sql, []);

        $sql = "INSERT INTO tb_setting_attribute(key_name,value) VALUES ('" . $key . "', '" . $value . "')";
        $DB->Insert($sql, []);
    }

    $access_token = $response["access_token"];
    $expires_in = $response["expires_in"] ?? 3600; // ตั้งค่า default ถ้า API ไม่ส่งมา
    $refresh_token = $response["refresh_token"] ?? null; // ดึง refresh_token ถ้ามี
    $expiry_time = time() + $expires_in; // คำนวณ timestamp ที่หมดอายุ

    setAttr($DB, 'access_token', $access_token);
    setAttr($DB, 'refresh_token', $refresh_token);
    setAttr($DB, 'expires_in', $expiry_time);

    echo "เชื่อมต่อ Google Drive สำเร็จ ปิดหน้าต่างนี้ได้เลย";
}
