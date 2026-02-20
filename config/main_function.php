<?php
class ClassMainFunctions
{

    function version_script()
    {
        $version = time();
        return $version;
    }
    public function getDataAll($table, $join, $order_by, $db, $column = '*', $arr = [], $where = "")
    {
        $option = "WHERE ";
        if (!empty($where)) {
            $option = "AND ";
        }
        $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n" .
            "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        $address = "";
        $edu_name = "IFNULL( edu.NAME, edu_o.NAME ) edu_name \n";
        if ($_SESSION['user_data']->role_id == 3) {
            $where .= "$option u.id = :user_id\n";
        }
        if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu') {
            $where .= "$option edu.district_id = ( SELECT district_id FROM tb_users us LEFT JOIN tbl_non_education edu ON us.edu_id = edu.id WHERE us.id = :user_id) \n";
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $where .= "$option edu_o.id = :edu_id\n";
        }
        if ($_SESSION['user_data']->edu_type == 'edu_other') {
            $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n";
            $address = "";
            $edu_name = "edu_o.NAME edu_name \n";
        } else if ($_SESSION['user_data']->edu_type == 'edu') {
            $joinEDU = "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
            $address = "	,( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province \n";
            $edu_name = "edu.NAME edu_name \n";
        } else {
            $address = "	,( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province \n";
            $edu_name = "IFNULL( edu.NAME, edu_o.NAME ) edu_name \n";
        }
        $sql = "SELECT\n" .
            $column .
            $edu_name .
            $address .
            "FROM\n" .
            "	$table\n" .
            $join . "\n" .
            $joinEDU .
            $where .
            $order_by;
        $data = $db->Query($sql, $arr);
        return json_decode($data);
    }


    public function getDataClass($table, $join, $group_by, $column = '*', $db)
    {
        $where = "";
        $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n" .
            "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        if ($_SESSION['user_data']->role_id == 3) {
            $where .= "WHERE u.id = :user_id\n";
        }
        if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu') {
            $where .= "WHERE edu.district_id = ( SELECT district_id FROM tb_users us LEFT JOIN tbl_non_education edu ON us.edu_id = edu.id WHERE us.id = :user_id) \n";
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $where .= "WHERE edu_o.id = :edu_id\n";
        }
        if ($_SESSION['user_data']->edu_type == 'edu_other') {
            $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n";
        } else if ($_SESSION['user_data']->edu_type == 'edu') {
            $joinEDU = "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        }
        $sql = "SELECT\n" .
            $column .
            "FROM\n" .
            $table .
            $join .
            $joinEDU . "\n" .
            $where . $group_by;

        if ($_SESSION['user_data']->role_id == 1) {
            $data = $db->Query($sql, []);
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $data = $db->Query($sql, ['edu_id' => $_SESSION['user_data']->edu_id]);
        } else {
            $data = $db->Query($sql, ['user_id' => $_SESSION['user_data']->id]);
        }
        return json_decode($data);
    }

    // function UploadFile($file, $uploadDir)
    // {
    //     $response = "";
    //     $fileName = $file["name"];
    //     $fileExtension = explode('.', $fileName);
    //     $fileExtension = strtolower(end($fileExtension));
    //     $fileName = date("Ymd") . $_SESSION['user_data']->id . uniqid() .   '.' . $fileExtension;
    //     if ($fileExtension != "pdf") {
    //         $response = array('status' => false, 'result' => 'ไฟล์ที่อัปโหลดต้องเป็น PDF เท่านั้น');
    //         return $response;
    //     }
    //     if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
    //         $response = array('status' => true, 'result' => $fileName);
    //         return $response;
    //     } else {
    //         $response = array('status' => false, 'result' => 'เกิดข้อผิดพลาดอัปโหลดไม่สำเร็จ');
    //         return $response;
    //     }
    // }

    function UploadFile($file, $uploadDir)
    {
        $response = ['status' => false, 'result' => ''];

        // Extract the file extension
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Check if the file is a PDF
        if ($fileExtension !== 'pdf') {
            $response['result'] = 'ไฟล์ที่อัปโหลดต้องเป็น PDF เท่านั้น';
            return $response;
        }

        // Validate the filename (excluding path)
        $fileName = preg_replace('/[^\p{L}\p{N}\s_.-]/u', '', $file['name']);

        // Generate a unique filename
        $uniqueFileName = date("Ymd") . "-" . $_SESSION['user_data']->id . "-" . uniqid() . '.' . $fileExtension;

        // Move the uploaded file with the sanitized filename
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $uniqueFileName)) {
            $response = ['status' => true, 'result' => $uniqueFileName];
        } else {
            $response['result'] = 'เกิดข้อผิดพลาดอัปโหลดไม่สำเร็จ';
        }

        return $response;
    }


    function UploadFileImage($file, $uploadDir, $resizeDir = "")
    {
        $response = "";
        $fileName = $file["name"];
        $fileTmpName = $file['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));


        if ($fileExtension != "png" && $fileExtension != "jpg" && $fileExtension != "jpeg" && $fileExtension != "gif") {
            $response = array('status' => false, 'result' => 'ไฟล์ที่อัปโหลดต้องเป็น png,jpg,jpeg,gif เท่านั้น');
            return $response;
        }
        $fileNewName = date("Ymd") . "-" . $_SESSION['user_data']->id . "-" . uniqid() .   '.' . $fileExtension;
        $fileName = date("Ymd") . "-" . $_SESSION['user_data']->id . "-" . uniqid() .   '.' . $fileExtension;

        $fileResize =  $fileName;

        $maxFileSize = 2 * 1024 * 1024;
        $uploadedFileSize = $file['size'];
        // if ($uploadedFileSize > $maxFileSize) {
        //     $response = array('status' => false, 'result' => "ไฟล์ของท่านมีขนากใหญ่เกินไป \nไฟล์ที่อัปโหลดต้องไม่เกิน 3 MB");
        //     return $response;
        // }

        if (!empty($resizeDir) && ($uploadedFileSize > $maxFileSize)) {
            $sourceProperties = getimagesize($fileTmpName);

            $imageType = $sourceProperties[2];
            switch ($imageType) {
                case IMAGETYPE_PNG:
                    $imageResourceId = imagecreatefrompng($fileTmpName);
                    $targetLayer = $this->imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                    imagepng($targetLayer, $uploadDir . $fileName);
                    $fileResize = $uploadDir . $fileName;
                    break;
                case IMAGETYPE_GIF:
                    $imageResourceId = imagecreatefromgif($fileTmpName);
                    $targetLayer = $this->imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                    imagegif($targetLayer, $uploadDir . $fileName);
                    $fileResize = $uploadDir . $fileName;
                    break;
                case IMAGETYPE_JPEG:
                    $imageResourceId = imagecreatefromjpeg($fileTmpName);
                    $targetLayer = $this->imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                    imagejpeg($targetLayer, $uploadDir . $fileName);
                    $fileResize = $uploadDir . $fileName;
                    break;
                default:
                    echo "Invalid Image type.";
                    exit;
                    break;
            }
        }

        if (move_uploaded_file($fileTmpName, $uploadDir . $fileNewName)) {
            if (!empty($resizeDir) && ($uploadedFileSize > $maxFileSize)) {
                unlink($uploadDir . $fileNewName);
                $response = array('status' => true, 'result' => $fileName);
            } else {
                $response = array('status' => true, 'result' => $fileNewName);
            }
            return $response;
        } else {
            $response = array('status' => false, 'result' => 'เกิดข้อผิดพลาดอัปโหลดไม่สำเร็จ');
            if (!empty($resizeDir) && ($uploadedFileSize > $maxFileSize)) {
                unlink($uploadDir . $fileResize);
            }
            unlink($uploadDir . $fileNewName);
            return $response;
        }
    }

    function imageResize($imageResourceId, $width, $height)
    {
        $targetWidth = 1280;
        $targetHeight = 1280;
        $targetLayer = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
        return $targetLayer;
    }


    function convert_date_thai_to_number($thaiDate)
    {
        // Thai month names to numerical values mapping
        $thaiMonthToNumber = [
            'มกราคม' => '01',
            'กุมภาพันธ์' => '02',
            'มีนาคม' => '03',
            'เมษายน' => '04',
            'พฤษภาคม' => '05',
            'มิถุนายน' => '06',
            'กรกฎาคม' => '07',
            'สิงหาคม' => '08',
            'กันยายน' => '09',
            'ตุลาคม' => '10',
            'พฤศจิกายน' => '11',
            'ธันวาคม' => '12',
        ];

        // Explode the Thai date into its components
        $dateComponents = explode(' ', $thaiDate);
        $day = str_pad($dateComponents[0], 2, '0', STR_PAD_LEFT);
        $month = $thaiMonthToNumber[$dateComponents[1]];
        $year = $dateComponents[2];

        // Form the converted date
        $convertedDate = $day . $month . $year;

        return $convertedDate; // Output: 13062556
    }

    function checkRole_status($system)
    {
        $user_data = $_SESSION['user_data'];
        $status = json_decode($user_data->status);
        if ($system == "std_tracking") {
            if (isset($status->std_tracking)) {
                return $status->std_tracking;
            }
            return 0;
        }
        if ($system == "view_grade") {
            if (isset($status->view_grade)) {
                return $status->view_grade;
            }
            return 0;
        }
        if ($system == "visit_online") {
            if (isset($status->visit_online)) {
                return $status->visit_online;
            }
            return 0;
        }
        if ($system == "reading") {
            if (isset($status->reading)) {
                return $status->reading;
            }
            return 0;
        }
        if ($system == "after") {
            if (isset($status->after)) {
                return $status->after;
            }
            return 0;
        }
        if ($system == "search") {
            if (isset($status->search)) {
                return $status->search;
            }
            return 0;
        }
        if ($system == "see_people") {
            if (isset($status->see_people)) {
                return $status->see_people;
            }
            return 0;
        }
        if ($system == "estimate") {
            if (isset($status->estimate)) {
                return $status->estimate;
            }
            return 0;
        }

        if ($system == "dashboard") {
            if (isset($status->dashboard)) {
                return $status->dashboard;
            }
            return 0;
        }

        if ($system == "teach_more") {
            if (isset($status->teach_more)) {
                return $status->teach_more;
            }
            return 0;
        }

        if ($system == "guide") {
            if (isset($status->guide)) {
                return $status->guide;
            }
            return 0;
        }
    }

    function cutPrename($fullName)
    {
        // List of common Thai prenames
        $commonPrenames = ['นาย', 'น.', 'นางสาว', 'น.ส.', 'เด็กชาย', 'เด็กหญิง', 'ด.ช.', 'ด.ญ.', "นาง"];

        // Initialize the prename
        $prename = '';

        // Loop through the common prenames
        foreach ($commonPrenames as $pren) {
            if (strpos($fullName, $pren) === 0) {
                $prename = $pren;
                break;
            }
        }

        // If a prename is found, cut it from the full name
        if (!empty($prename)) {
            $fullName = substr($fullName, strlen($prename));
        }

        return array(trim($prename), trim($fullName));
    }

    function validateClass($type)
    {
        $allowedTypes = ['ประถม', 'ม.ต้น', 'ม.ปลาย'];

        return in_array($type, $allowedTypes);
    }

    function validateDateFormatImport($dateString)
    {
        // Array mapping Thai month names to English month names
        $thaiToEnglishMonths = [
            'มกราคม' => 'January',
            'กุมภาพันธ์' => 'February',
            'มีนาคม' => 'March',
            'เมษายน' => 'April',
            'พฤษภาคม' => 'May',
            'มิถุนายน' => 'June',
            'กรกฎาคม' => 'July',
            'สิงหาคม' => 'August',
            'กันยายน' => 'September',
            'ตุลาคม' => 'October',
            'พฤศจิกายน' => 'November',
            'ธันวาคม' => 'December'
        ];

        // Split the input date string into day, month, and year
        $dateParts = explode(' ', $dateString);
        $day = $dateParts[0];
        $monthThai = $dateParts[1];
        $year = $dateParts[2];

        // Convert Thai month name to English month name
        $monthEnglish = $thaiToEnglishMonths[$monthThai];

        // Create a new date string with the English month name
        $englishDateString = "$day $monthEnglish $year";

        // Attempt to create a DateTime object from the new date string
        $dateTime = DateTime::createFromFormat('d F Y', $englishDateString);

        // Check if the creation was successful
        return $dateTime !== false && !array_sum($dateTime::getLastErrors());
    }


    // $key = "az8RLYCc8ULZ9d4FfstyVimOF3fdTNWYMlgZLQOj2zM=";
    function encryptData($data)
    {
        $key = "do-el-key";
        $cipher = "aes-256-cbc";
        $ivLength = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encrypted = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted);
    }

    function decryptData($data)
    {
        $key = "do-el-key";
        $cipher = "aes-256-cbc";
        $ivLength = openssl_cipher_iv_length($cipher);
        $data = base64_decode($data);
        $iv = substr($data, 0, $ivLength);
        $encrypted = substr($data, $ivLength);
        return openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    }


    function getSqlFindAddress($start = " AND ", $startSub = " AND ", $mode = 0)
    {
        $pro_id = isset($_REQUEST['pro_id']) ? $_REQUEST['pro_id'] : 0;
        $dis_id = 0;
        if (isset($_REQUEST['dis_id']) && $_REQUEST['dis_id'] != 0) {
            $dis_id = $_REQUEST['dis_id'];
        } else if ($_SESSION['user_data']->role_id == 2) {
            $dis_id = $_SESSION['user_data']->district_am_id;
        }

        $bucket = " ";
        if ($mode == 1) {
            $bucket = " ( ";
        }
        $sub_dis_id = isset($_REQUEST['sub_dis_id']) ? $_REQUEST['sub_dis_id'] : 0;
        $full_sql = "";
        if ($pro_id != 0) {
            $full_sql .= "	$start $bucket edu.province_id = " . $pro_id;
            if ($mode == 1) {
                $full_sql .= " OR  (\n" .
                    "	SELECT\n" .
                    "		eduu.province_id \n" .
                    "	FROM\n" .
                    "		tb_students\n" .
                    "		LEFT JOIN tb_users uu ON tb_students.user_create = uu.id\n" .
                    "		LEFT JOIN tbl_non_education eduu ON uu.edu_id = eduu.id \n" .
                    "	WHERE\n" .
                    "		f.user_create = std_id \n" .
                    "	) = {$pro_id} \n" .
                    "	 ) ";
            }
        }
        if ($dis_id != 0) {
            $action = $_SESSION['user_data']->role_id == 2 && $start != ' AND ' ? " WHERE " : " AND ";
            $full_sql .= "	$action $bucket edu.district_id = " . $dis_id;
            if ($mode == 1) {
                $full_sql .= " OR  (\n" .
                    "	SELECT\n" .
                    "		eduu.district_id \n" .
                    "	FROM\n" .
                    "		tb_students\n" .
                    "		LEFT JOIN tb_users uu ON tb_students.user_create = uu.id\n" .
                    "		LEFT JOIN tbl_non_education eduu ON uu.edu_id = eduu.id \n" .
                    "	WHERE\n" .
                    "		f.user_create = std_id \n" .
                    "	) = {$dis_id} \n" .
                    "	 ) ";
            }
        }
        if ($sub_dis_id != 0) {
            $full_sql .= "	AND  $bucket edu.sub_district_id = " . $sub_dis_id;
            if ($mode == 1) {
                $full_sql .= " OR  (\n" .
                    "	SELECT\n" .
                    "		eduu.sub_district_id \n" .
                    "	FROM\n" .
                    "		tb_students\n" .
                    "		LEFT JOIN tb_users uu ON tb_students.user_create = uu.id\n" .
                    "		LEFT JOIN tbl_non_education eduu ON uu.edu_id = eduu.id \n" .
                    "	WHERE\n" .
                    "		f.user_create = std_id \n" .
                    "	) = {$sub_dis_id} \n" .
                    "	 ) ";
            }
        }

        return $full_sql;
    }

    // function UploadFileAudio($file, $uploadDir, $resizeDir = "")
    // {
    //     $response = "";
    //     // $uploadPath = __DIR__ . '/uploads/';
    //     $fileName = $_FILES['audio']['name'];
    //     $tempName = $_FILES['audio']['tmp_name'];
    //     $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    //     if ($fileExtension != "wav") {
    //         $response = array('status' => false, 'result' => 'ไฟล์ที่อัปโหลดต้องเป็น WAV เท่านั้น');
    //         return $response;
    //     }

    //     // Generate a unique filename
    //     $uniqueFileName = date("Ymd") . $_SESSION['user_data']->id . uniqid() . '.' . $fileExtension;

    //     // Move the uploaded file with the sanitized filename
    //     if (move_uploaded_file($tempName, $uploadDir . $uniqueFileName)) {
    //         $response = ['status' => true, 'result' => $uniqueFileName];
    //     } else {
    //         $response['result'] = 'เกิดข้อผิดพลาดอัปโหลดไม่สำเร็จ';
    //     }

    //     return $response;
    // }
    function UploadFileAudio($uploadDir, $resizeDir = "")
    {
        try {
            $response = "";
            $fileName = $_FILES['audio']['name'];
            $tempName = $_FILES['audio']['tmp_name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validate file extension
            if ($fileExtension != "wav") {
                $response = array('status' => false, 'result' => 'ไฟล์ที่อัปโหลดต้องเป็น WAV เท่านั้น');
                return $response;
            }

            // Validate file size
            $maxFileSize = 5242880; //10485760; // 10MB in bytes
            if ($_FILES['audio']['size'] > $maxFileSize) {
                // Generate a unique filename with .zip extension
                $uniqueFileName = date("Ymd") . "-" . $_SESSION['user_data']->id . "-" . uniqid() . '.zip';

                // Create a ZIP archive
                $zip = new ZipArchive();
                $zipFileName = $uploadDir . $uniqueFileName; // Store ZIP in upload directory
                if ($zip->open($zipFileName, ZipArchive::CREATE) !== true) {
                    $response = array('status' => false, 'result' => 'เกิดข้อผิดพลาดในการสร้างไฟล์ ZIP');
                    return $response;
                }

                // Add the original file to the ZIP archive
                if ($zip->addFile($tempName, basename($fileName)) === false) {
                    $response = array('status' => false, 'result' => 'ไม่สามารถเพิ่มไฟล์ลงในไฟล์ ZIP');
                    return $response;
                }

                // Close the ZIP archive
                $zip->close();

                $response = ['status' => true, 'result' => $uniqueFileName, 'resize' => 1];
            } else {
                // Move the uploaded file (original) if size is under limit
                $uniqueFileName = date("Ymd") . "-" . $_SESSION['user_data']->id . "-" . uniqid() . '.' . $fileExtension;
                $uploadPath = $resizeDir . $uniqueFileName;
                if (move_uploaded_file($tempName, $uploadPath)) {
                    $response = ['status' => true, 'result' => $uniqueFileName, 'resize' => 0];
                } else {
                    $response = ['status' => false, 'result' => 'เกิดข้อผิดพลาดอัปโหลดไม่สำเร็จ'];
                }
            }

            return $response;
        } catch (\Exception $e) {
            $response = ['status' => false, 'result' => $e->getMessage()];
            return $response;
        }
    }

    function cleanName($name)
    {
        $prefixes = ['นาย', 'เด็กชาย', 'เด็กหญิง', 'นาง', 'นางสาว'];
        foreach ($prefixes as $prefix) {
            if (strpos($name, $prefix) === 0) {
                return trim(substr($name, strlen($prefix)));
            }
        }
        return $name; // Return the name unchanged if no prefix is found
    }

    function getAttribute($db, $key)
    {
        $arr_data = [];
        $sql = "select * from tb_setting_attribute where key_name = '" . $key . "'";
        $data_result = $db->Query($sql, []);
        $data_result = json_decode($data_result, true);
        if (count($data_result) > 0) {
            $data = html_entity_decode($data_result[0]['value']);
            $arr_data = json_decode($data, true);
        }
        return $arr_data;
    }

    function getAttr($DB, $key)
    {
        $sql = "select * from tb_setting_attribute where key_name = '" . $key . "'";
        $data_result = $DB->Query($sql, []);
        $data_result = json_decode($data_result, true);
        return $data_result[0]['value'];
    }

    function setAttr($DB, $key, $value)
    {
        $sql = "DELETE FROM tb_setting_attribute WHERE key_name = '" . $key . "'";
        $DB->Delete($sql, []);

        $sql = "INSERT INTO tb_setting_attribute(key_name,value) VALUES ('" . $key . "', '" . $value . "')";
        $DB->Insert($sql, []);
    }


    function UploadToGoogleDrive($folderPath, $file, $GD_FolderId, $drive)
    {
        $fileName = $file; // ชื่อไฟล์ใน Google Drive
        $filePath = $folderPath . $file;
        $mimeType = mime_content_type($filePath); // จะคืนค่า image/png

        // อัปโหลดไฟล์ทั้งหมดในโฟลเดอร์
        $response = $drive->uploadFile($filePath, $fileName, $mimeType, $GD_FolderId);

        $responseId = false;

        if (isset($response['id'])) {
            $responseId = $response['id'];
        }

        return $responseId;
    }

    function deleteFileFromGoogleDrive($fileId, $drive)
    {
        $response = $drive->deleteFile($fileId);
        return $response;
    }
}
