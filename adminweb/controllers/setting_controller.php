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

if ($_POST['setDisplayAm']) {
    $type = $_POST['type'];
    $sql = "DELETE FROM tb_setting_attribute WHERE key_name = 'banner_display_am'";
    $data = $DB->Delete($sql, []);
    if ($data == 1) {
        $sql = "INSERT INTO tb_setting_attribute(key_name, value) values ('banner_display_am', '" . $type . "')";
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

if ($_POST['banner_vedio_am']) {
    $response = "";
    $banner_id = $_POST['banner_id'];

    $file_old = $_POST['fileOld'];

    if (count($_FILES) > 0 && isset($_FILES['file'])) {
        if ($banner_id == "am_banner" || $banner_id == "am_banner_main") {
            $uploadDir = '../../manage_am/images/am_images/';
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
            $uploadDir = '../../manage_am/images/videos/';
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

    $sql = "DELETE FROM tb_setting_attribute WHERE key_name = '$banner_id'";
    $data = $DB->Delete($sql, []);
    if ($data == 1) {
        $sql = "INSERT INTO tb_setting_attribute(key_name,value) values ('$banner_id', '" . $file_old . "')";
        $data = $DB->Insert($sql, []);
        if ($data == 1) {
            $tyepMessage = 'แบนเนอร์';
            $response = array('status' => true, 'msg' => "บันทึกตั้งค่า" . $tyepMessage . "สำเร็จ");
        }
    }

    echo json_encode($response);
}

if (isset($_REQUEST['getDataPostAm'])) {
    //ถ้ามีการค้นหา
    $search = "";
    if (isset($_REQUEST['search'])) {
        $search = " WHERE title LIKE '%" . $_REQUEST['search'] . "%' \n";
        $search .= " OR detail LIKE '%" . $_REQUEST['search'] . "%' ";
    }

    //นับจำนวนทั้งหมด
    $sql_order = "SELECT count(*) totalnotfilter FROM am_post_am";
    $totalnotfilter = $DB->Query($sql_order, []);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;

    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM am_post_am " . $search;

    $sql_total = $sql;
    $total_result = $DB->Query($sql_total, []);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, []);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter,];
    echo json_encode($response);
}

if (isset($_REQUEST['getPostAmById'])) {
    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM am_post_am WHERE post_id = " . $_POST['post_id'];
    $data_result = $DB->Query($sql, []);
    $data_result = json_decode($data_result);
    echo json_encode(['data' => $data_result[0]]);
}

if ($_POST['savePostAm']) {
    $response = "";

    $file_old = $_POST['fileOld'];

    if (count($_FILES) > 0 && isset($_FILES['file'])) {
        $uploadDir = '../../manage_am/images/post_am/';
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
    }

    $response = array('status' => false, 'msg' => "เกิดข้อผิดพลาด โปรดลองใหม่");

    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $title = $_POST['title'];
    $detail = $_POST['detail'];
    $link = $_POST['link'];

    $post_date = getThaiDate($day, $month, $year);

    $user_create = $_SESSION['user_data']->id;
    $filename = $file_old;

    if ($post_id) {
        // UPDATE
        $sql = "UPDATE am_post_am 
                SET title = ?, detail = ?, link = ?, `image` = ?, `date` = ? 
                WHERE post_id = ?";
        $params = [$title, $detail, $link, $filename, $post_date, $post_id];
        $data = $DB->Update($sql, $params);
        $typeMessage = "แก้ไข";
    } else {
        // INSERT
        $sql = "INSERT INTO am_post_am (title, detail, link, `image`, `date`, `user_create`)
                VALUES (?, ?, ?, ?, ?, ?)";
        $params = [$title, $detail, $link, $filename, $post_date,  $user_create];
        $data = $DB->Insert($sql, $params);
        $typeMessage = "เพิ่ม";
    }
    if ($data == 1) {
        $response = array('success' => true, 'msg' => "บันทึกข้อมูลสำเร็จ");
    } else {
        $response = array('success' => false, 'msg' => "เกิดข้อผิดพลาดในการบันทึก");
    }
    echo json_encode($response);
}

function getThaiDate($day, $month, $year)
{
    $thaiMonths = array(
        1 => "มกราคม",
        2 => "กุมภาพันธ์",
        3 => "มีนาคม",
        4 => "เมษายน",
        5 => "พฤษภาคม",
        6 => "มิถุนายน",
        7 => "กรกฎาคม",
        8 => "สิงหาคม",
        9 => "กันยายน",
        10 => "ตุลาคม",
        11 => "พฤศจิกายน",
        12 => "ธันวาคม"
    );

    // แปลงปี ค.ศ. เป็น พ.ศ.
    $thaiYear = (int)$year;
    $thaiMonth = $thaiMonths[(int)$month];

    return "$day $thaiMonth $thaiYear";
}

if (isset($_POST['deletePost']) && $_POST['deletePost']) {
    $post_id = $_POST['post_id'];
    $image_old = $_POST['image_old'];

    $sql = "DELETE FROM am_post_am WHERE post_id = ?";
    $result = $DB->Delete($sql, [$post_id]);

    if ($result == 1) {
        // check and delete file old
        if (!empty($image_old)) {
            $uploadDir = '../../manage_am/images/post_am/';
            if (file_exists($uploadDir . $image_old)) {
                unlink($uploadDir . $image_old);
            }
        }
    }

    echo json_encode([
        'success' => $result == 1,
        'msg' => $result == 1 ? 'ลบโพสต์สำเร็จ' : 'ไม่สามารถลบโพสต์ได้'
    ]);
}

if ($_POST['saveEventAm']) {
    $response = "";

    $file_old = $_POST['fileOld'];

    if (count($_FILES) > 0 && isset($_FILES['file'])) {
        $uploadDir = '../../manage_am/images/am_events/';
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
    }

    $event_id = isset($_POST['event_id']) ? $_POST['event_id'] : null;
    $user_create = $_SESSION['user_data']->id;
    $filename = $file_old;

    if ($event_id) {
        // UPDATE
        $sql = "UPDATE am_event_image 
                SET `image` = ? WHERE event_id = ?";
        $params = [$filename, $event_id];
        $data = $DB->Update($sql, $params);
        $typeMessage = "แก้ไข";
    } else {
        // INSERT
        $sql = "INSERT INTO am_event_image (`image`,`user_create`)
                VALUES (?, ?)";
        $params = [$filename, $user_create];
        $data = $DB->Insert($sql, $params);
        $typeMessage = "เพิ่ม";
    }
    if ($data == 1) {
        $response = array('success' => true, 'msg' => "บันทึกข้อมูลสำเร็จ");
    } else {
        $response = array('success' => false, 'msg' => "เกิดข้อผิดพลาดในการบันทึก");
    }
    echo json_encode($response);
}

if (isset($_REQUEST['getDataEventAm'])) {
    //นับจำนวนทั้งหมด
    $sql_order = "SELECT count(*) totalnotfilter FROM am_event_image";
    $totalnotfilter = $DB->Query($sql_order, []);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;

    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM am_event_image ";

    $sql_total = $sql;
    $total_result = $DB->Query($sql_total, []);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, []);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter,];
    echo json_encode($response);
}

if (isset($_REQUEST['getDataEventAmById'])) {
    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM am_event_image WHERE event_id = " . $_POST['event_id'];
    $data_result = $DB->Query($sql, []);
    $data_result = json_decode($data_result);
    echo json_encode(['data' => $data_result[0]]);
}


if (isset($_POST['deleteEvent']) && $_POST['deleteEvent']) {
    $event_id = $_POST['event_id'];
    $image_old = $_POST['image_old'];

    $sql = "DELETE FROM am_event_image WHERE event_id = ?";
    $result = $DB->Delete($sql, [$event_id]);

    if ($result == 1) {
        // check and delete file old
        if (!empty($image_old)) {
            $uploadDir = '../../manage_am/images/am_events/';
            if (file_exists($uploadDir . $image_old)) {
                unlink($uploadDir . $image_old);
            }
        }
    }

    echo json_encode([
        'success' => $result == 1,
        'msg' => $result == 1 ? 'ลบรูปภาพสำเร็จ' : 'ไม่สามารถลบรูปภาพได้'
    ]);
}


if ($_POST['saveEventVerAm']) {
    $response = "";

    $file_old = $_POST['fileOld'];

    if (count($_FILES) > 0 && isset($_FILES['file'])) {
        $uploadDir = '../../manage_am/images/am_events_ver/';
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
    }

    $event_ver_id = isset($_POST['event_ver_id']) ? $_POST['event_ver_id'] : null;
    $user_create = $_SESSION['user_data']->id;
    $filename = $file_old;

    if ($event_ver_id) {
        // UPDATE
        $sql = "UPDATE am_event_image_vertical 
                SET `image` = ? WHERE event_ver_id = ?";
        $params = [$filename, $event_ver_id];
        $data = $DB->Update($sql, $params);
        $typeMessage = "แก้ไข";
    } else {
        // INSERT
        $sql = "INSERT INTO am_event_image_vertical (`image`,`user_create`)
                VALUES (?, ?)";
        $params = [$filename, $user_create];
        $data = $DB->Insert($sql, $params);
        $typeMessage = "เพิ่ม";
    }
    if ($data == 1) {
        $response = array('success' => true, 'msg' => "บันทึกข้อมูลสำเร็จ");
    } else {
        $response = array('success' => false, 'msg' => "เกิดข้อผิดพลาดในการบันทึก");
    }
    echo json_encode($response);
}

if (isset($_REQUEST['getDataEventVerAm'])) {
    //นับจำนวนทั้งหมด
    $sql_order = "SELECT count(*) totalnotfilter FROM am_event_image_vertical";
    $totalnotfilter = $DB->Query($sql_order, []);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;

    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM am_event_image_vertical ";

    $sql_total = $sql;
    $total_result = $DB->Query($sql_total, []);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, []);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter,];
    echo json_encode($response);
}

if (isset($_REQUEST['getDataEventVerAmById'])) {
    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM am_event_image_vertical WHERE event_ver_id = " . $_POST['event_ver_id'];
    $data_result = $DB->Query($sql, []);
    $data_result = json_decode($data_result);
    echo json_encode(['data' => $data_result[0]]);
}


if (isset($_POST['deleteEventVer']) && $_POST['deleteEventVer']) {
    $event_ver_id = $_POST['event_ver_id'];
    $image_old = $_POST['image_old'];

    $sql = "DELETE FROM am_event_image_vertical WHERE event_ver_id = ?";
    $result = $DB->Delete($sql, [$event_ver_id]);

    if ($result == 1) {
        // check and delete file old
        if (!empty($image_old)) {
            $uploadDir = '../../manage_am/images/am_events_ver/';
            if (file_exists($uploadDir . $image_old)) {
                unlink($uploadDir . $image_old);
            }
        }
    }

    echo json_encode([
        'success' => $result == 1,
        'msg' => $result == 1 ? 'ลบรูปภาพสำเร็จ' : 'ไม่สามารถลบรูปภาพได้'
    ]);
}


if ($_POST['bg_image']) {
    $response = "";

    $file_old = $_POST['bg_image_old'];

    if (count($_FILES) > 0 && isset($_FILES['file'])) {
        $uploadDir = '../../manage_am/images/am_images/';
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
    }

    $response = array('status' => false, 'msg' => "เกิดข้อผิดพลาด โปรดลองใหม่");

    $sql = "DELETE FROM tb_setting_attribute WHERE key_name = 'bg_image'";
    $data = $DB->Delete($sql, []);
    if ($data == 1) {
        $sql = "INSERT INTO tb_setting_attribute(key_name,value) values ('bg_image', '" . $file_old . "')";
        $data = $DB->Insert($sql, []);
        if ($data == 1) {
            $tyepMessage = 'พื้นหลัง';
            $response = array('status' => true, 'msg' => "บันทึกตั้งค่า" . $tyepMessage . "สำเร็จ");
        }
    }

    echo json_encode($response);
}
