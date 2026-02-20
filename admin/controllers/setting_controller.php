<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";

$DB = new Class_Database();
$mainFunc = new ClassMainFunctions();

if (isset($_POST['mode']) && $_POST['mode'] == 'system_name') {
    $response = "";

    $file_old = $_POST['file_image_old'];
    unset($_POST['mode']);
    unset($_POST['file_image_old']);
    $_POST['file_image'] = $file_old;

    if (count($_FILES) > 0 && isset($_FILES['file'])) {
        $uploadDir = '../../images/';
        $resizeDir = '../upload/';
        $file_response = $mainFunc->UploadFileImage($_FILES['file'], $uploadDir, $resizeDir);
        if (!$file_response['status']) {
            $response = array('status' => false, 'msg' => $file_response['result']);
            echo json_encode($response);
            exit();
        }
        if (!empty($file_old)) {
            unlink($uploadDir . $file_old);
        }

        $_POST['file_image'] = $file_response['result'];
    }

    $sql = "DELETE FROM tb_setting_attribute WHERE key_name = 'system_name'";
    $DB->Delete($sql, []);

    $sql = "Insert into tb_setting_attribute(key_name,value) values ('system_name', '" . json_encode($_POST, JSON_UNESCAPED_UNICODE) . "')";
    $data = $DB->Insert($sql, []);
    if ($data == 1) {
        $response = array('status' => true, 'msg' => "บันทึกตั้งค่าหน้าแรกระบบสำเร็จ");
    }
    echo json_encode($response);
}

function getUploadedFileById($files, $id)
{
    return [
        'name' => $files["icon_image"]['name'][$id] ?? null,
        'type' => $files["icon_image"]['type'][$id] ?? null,
        'tmp_name' => $files["icon_image"]['tmp_name'][$id] ?? null,
        'error' => $files["icon_image"]['error'][$id] ?? null,
        'size' => $files["icon_image"]['size'][$id] ?? null,
    ];
}

if (isset($_POST['mode']) && $_POST['mode'] == 'setting_menu') {
    
    $success = [];
    $error = [];

    // Collect all data for batch insert
    foreach ($_POST['menu'] as $key => $menu) {

        $uploadDir = '../../images/icon-menu/';
        $uploadDirName = 'images/icon-menu/';

        $menu_id = $key;
        $menu_name = $menu["menu_name"] ?? '';
        $color = $menu["menu_color"] ?? '#000000';
        $old_icon = $menu["icon_old"] ?? '';

        $uploaded_file_path = $old_icon;

        $fileCurr = getUploadedFileById($_FILES, $menu_id);

        // Handle file upload if a new file is provided
        if (!empty($fileCurr['name'])) {
            $resizeDir = '../upload/';
            $file_response = $mainFunc->UploadFileImage($fileCurr, $uploadDir, $resizeDir);
            if (!$file_response['status']) {
                $response = array('status' => false, 'msg' => $file_response['result']);
                echo json_encode($response);
                exit();
            }


            if (strpos($uploaded_file_path, 'images/icon-menu-bk/') !== true) {
                if (!empty($uploaded_file_path) && file_exists($uploaded_file_path)) {
                    unlink($uploaded_file_path);
                }
            }

            $uploaded_file_path = $file_response['result'];
            $uploadDirName .= $uploaded_file_path;
        } else {
            $uploadDirName = $old_icon;
        }


        // Add this menu item to the array
        $menu_data = [
            'menu_name' => $menu_name,
            'menu_color' => $color,
            'menu_icon' => $uploadDirName,
            'menu_id' => $menu_id
        ];

        $sql = "UPDATE tb_menus SET menu_name = :menu_name, menu_color = :menu_color, menu_icon = :menu_icon WHERE menu_id = :menu_id";
        $data = $DB->Update($sql, $menu_data);
        if ($data == 1) {
            $success[$key] = $menu_name . "สำเร็จ";
        } else {
            $error[$key] = $menu_name . "เกิดข้อผิดพลาด" . json_encode($data);
        }
    }

    $response = array('status' => true, 'msg' => "บันทึกตั้งค่าเมนูสำเร็จ", "success" => $success, "error" => $error);
    echo json_encode($response);
}

if (isset($_POST['update_share_app'])) {
    $attr_id = $_POST['attr_id'];
    unset($_POST['update_share_app']);
    unset($_POST['attr_id']);
    $response = array('status' => false, 'msg' => "เกิดข้อผิดพลาด โปรดลองใหม่");
    if (isset($attr_id) && !empty($attr_id)) {
        $sql = "UPDATE tb_setting_attribute SET value = '" . json_encode($_POST, JSON_UNESCAPED_UNICODE) . "' WHERE attr_id = " . $attr_id;
        $data = $DB->Update($sql, []);
        if ($data == 1) {
            $response = array('status' => true, 'msg' => "บันทึกตั้งค่าแนะนำแอปสำเร็จ");
        }
    } else {
        $sql = "INSERT INTO tb_setting_attribute(key_name,value) values ('share_app', '" . json_encode($_POST, JSON_UNESCAPED_UNICODE) . "')";
        $data = $DB->Insert($sql, []);
        if ($data == 1) {
            $response = array('status' => true, 'msg' => "บันทึกตั้งค่าแนะนำแอปสำเร็จ");
        }
    }
    echo json_encode($response);
}

if (isset($_POST['delete_share_app'])) {
    $response = array('status' => false, 'msg' => "เกิดข้อผิดพลาด โปรดลองใหม่");
    $sql = "DELETE FROM tb_setting_attribute WHERE attr_id = '" . $_POST['attr_id'] . "'";
    $data = $DB->Delete($sql, []);
    if ($data == 1) {
        $response = array('status' => true, 'msg' => "ลบตั้งค่าแนะนำแอปสำเร็จ");
    }
    echo json_encode($response);
}


if (isset($_POST['banner_form'])) {
    $response = "";
    $attr_id = $_POST['attr_id'];
    $file_old = $_POST['banner_old'];

    unset($_POST['banner_form']);
    unset($_POST['banner_old']);
    unset($_POST['attr_id']);

    $_POST['banner'] = $file_old;

    if (count($_FILES) > 0 && isset($_FILES['file'])) {
        $uploadDir = '../upload/banners/';
        $resizeDir = '../upload/';
        $file_response = $mainFunc->UploadFileImage($_FILES['file'], $uploadDir, $resizeDir);
        if (!$file_response['status']) {
            $response = array('status' => false, 'msg' => $file_response['result']);
            echo json_encode($response);
            exit();
        }
        if (!empty($file_old)) {
            unlink($uploadDir . $file_old);
        }

        $_POST['banner'] = $file_response['result'];
    }

    $response = array('status' => false, 'msg' => "เกิดข้อผิดพลาด โปรดลองใหม่");
    if (isset($attr_id) && !empty($attr_id)) {
        $sql = "UPDATE tb_setting_attribute SET value = '" . json_encode($_POST, JSON_UNESCAPED_UNICODE) . "' WHERE attr_id = " . $attr_id;
        $data = $DB->Update($sql, []);
        if ($data == 1) {
            $response = array('status' => true, 'msg' => "บันทึกตั้งค่าลิงก์ข่าวสารและแบนเนอร์สำเร็จ");
        }
    } else {

        $sql = "INSERT INTO tb_setting_attribute(key_name,value) values ('banner_form', '" . json_encode($_POST, JSON_UNESCAPED_UNICODE) . "')";
        $data = $DB->Insert($sql, []);
        if ($data == 1) {
            $response = array('status' => true, 'msg' => "บันทึกตั้งค่าลิงก์ข่าวสารและแบนเนอร์สำเร็จ");
        }
    }
    echo json_encode($response);
}

if (isset($_POST['delete_banner'])) {
    $response = array('status' => false, 'msg' => "เกิดข้อผิดพลาด โปรดลองใหม่");
    $sql = "DELETE FROM tb_setting_attribute WHERE attr_id = '" . $_POST['attr_id'] . "'";
    $data = $DB->Delete($sql, []);
    if ($data == 1) {
        if (!empty($_POST['banner'])) {
            $uploadDir = '../upload/banners/';
            if (file_exists($uploadDir . $_POST['banner'])) {
                unlink($uploadDir . $_POST['banner']);
            }
        }
        $response = array('status' => true, 'msg' => "ลบ" . $_POST['typeText'] . "สำเร็จ");
    }
    echo json_encode($response);
}

if ($_POST['banner_vedio']) {
    $response = "";
    $type = $_POST['type'];

    $file_old = $_POST['fileOld'];

    if (count($_FILES) > 0 && isset($_FILES['file'])) {
        if ($type == 1) {
            $uploadDir = '../upload/banners/';
            $resizeDir = '../upload/';

            $file_response = $mainFunc->UploadFileImage($_FILES['file'], $uploadDir, $resizeDir);
            if (!$file_response['status']) {
                $response = array('status' => false, 'msg' => $file_response['message']);
                echo json_encode($response);
                exit();
            }
            if (!empty($file_old) && file_exists($uploadDir . $file_old)) {
                unlink($uploadDir . $file_old);
            }

            $file_old = $file_response['result'];
        } else {
            $uploadDir = '../upload/videos/';
            $file_response = uploadVideo($_FILES['file'], $uploadDir, $resizeDir);
            if (!$file_response['status']) {
                $response = array('status' => false, 'msg' => $file_response['message']);
                echo json_encode($response);
                exit();
            }

            if (!empty($file_old) && file_exists($uploadDir . $file_old)) {
                unlink($uploadDir . $file_old);
            }

            $file_old = $file_response['file'];
        }
    }

    $response = array('status' => false, 'msg' => "เกิดข้อผิดพลาด โปรดลองใหม่");

    $sql = "DELETE FROM tb_setting_attribute WHERE key_name = 'banner_index_" . $type . "'";
    $data = $DB->Delete($sql, []);
    if ($data == 1) {
        $sql = "INSERT INTO tb_setting_attribute(key_name,value) values ('banner_index_" . $type . "', '" . $file_old . "')";
        $data = $DB->Insert($sql, []);
        if ($data == 1) {
            $tyepMessage = $type == 1 ? 'แบนเนอร์' : 'วิดีโอ';
            $response = array('status' => true, 'msg' => "บันทึกตั้งค่า" . $tyepMessage . "สำเร็จ");
        }
    }

    echo json_encode($response);
}

if ($_POST['setDisplay']) {
    $type = $_POST['type'];
    $sql = "DELETE FROM tb_setting_attribute WHERE key_name = 'banner_display'";
    $data = $DB->Delete($sql, []);
    if ($data == 1) {
        $sql = "INSERT INTO tb_setting_attribute(key_name, value) values ('banner_display', '" . $type . "')";
        $data = $DB->Insert($sql, []);
        if ($data == 1) {
            $tyepMessage = $type == 1 ? 'แบนเนอร์' : 'วิดีโอ';
            $response = array('status' => true, 'msg' => "บันทึก" . $tyepMessage . "สำเร็จ");
        }
    }
    echo json_encode($response);
}


function uploadVideo($file, $uploadDir)
{
    $allowedTypes = ['mp4', 'avi', 'mov', 'mkv']; // Allowed video formats
    $maxFileSize = 50 * 1024 * 1024; // 50MB limit

    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ["status" => false, "message" => "Error: No file uploaded or upload failed."];
    }

    $fileName = basename($file["name"]);
    $fileSize = $file["size"];
    $fileTmp = $file["tmp_name"];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validate file type
    if (!in_array($fileExt, $allowedTypes)) {
        return ["status" => false, "message" => "Error: Invalid file type. Only MP4, AVI, MOV, MKV are allowed."];
    }

    // Validate file size
    if ($fileSize > $maxFileSize) {
        return ["status" => false, "message" => "Error: File size exceeds 50MB."];
    }

    // Generate a unique filename
    $newFileName = date("Ymd") . "-" . $_SESSION['user_data']->id . "-" . uniqid() .   '.' . $fileExt;
    $targetFilePath = $uploadDir . $newFileName;

    // Move the uploaded file to the destination
    if (move_uploaded_file($fileTmp, $targetFilePath)) {
        return ["status" => true, "message" => "Success: Video uploaded.", "file" => $newFileName];
    } else {
        return ["status" => false, "message" => "Error: Failed to move the uploaded file."];
    }
}
