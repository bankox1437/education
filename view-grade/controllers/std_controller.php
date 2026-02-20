<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/std_model.php";
$DB = new Class_Database();
$std_model = new STD_Model($DB);
$main_func = new ClassMainFunctions();

function CheckUploadFileImage($file, $file_old = "")
{
    $mainFunc = new ClassMainFunctions();
    $uploadDir = '../uploads/profile_students/';
    $resizeDir = '../uploads/';

    $file_response = $mainFunc->UploadFileImage($file, $uploadDir, $resizeDir);
    if (!$file_response['status']) {
        $response = array('status' => false, 'msg' => $file_response['result']);
        echo json_encode($response);
        exit();
    }
    if (!empty($file_old) && file_exists($uploadDir . $file_old)) {
        unlink($uploadDir . $file_old);
    }
    return $file_response['result'];
}

if (isset($_POST['getDataStdToTable'])) {
    $std_class = $_POST['std_class'];
    $term_id = isset($_POST['term_id']) ? $_POST['term_id'] : 0;
    $result = $std_model->getDataStdToTable($std_class, $term_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}
if (isset($_POST['getDataStdMoralToTable'])) {
    $std_class = $_POST['std_class'];
    $result = $std_model->getDataStdMoralToTable($std_class);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getDataStdToTableGradiate'])) {
    $std_class = $_POST['std_class'];
    $term_id = isset($_POST['term_id']) ? $_POST['term_id'] : 0;
    $result = $std_model->getDataStdToTableGradiate($std_class, $term_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getDataStdToTableN_Net'])) {
    $std_class = $_POST['std_class'];
    $term_id = isset($_POST['term_id']) ? $_POST['term_id'] : 0;
    $result = $std_model->getDataStdToTableN_Net($std_class, $term_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getDataStdToTableFinish'])) {
    $std_class = $_POST['std_class'];
    $term_id = isset($_POST['term_id']) ? $_POST['term_id'] : 0;
    $result = $std_model->getDataStdToTableFinish($std_class, $term_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getDataStudent'])) {
    $response = "";
    $user_id = $_SESSION['user_data']->id;
    $result = $std_model->getDataStudent($user_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['import_students2'])) {
    $response = "";
    $result = 0;
    //$file = $_FILES["csv_file"]["tmp_name"];
    $fileName = $_FILES["csv_file"]["name"];
    $fileExtension = explode('.', $fileName);


    $fileExtension = strtolower(end($fileExtension));
    if ($fileExtension != "xlsx" && $fileExtension != "xls" && $fileExtension != "csv") {
        $response = array('status' => false, 'msg' => 'ไฟล์ที่นำเข้าไม่ถูกต้อง');
        echo json_encode($response);
        exit();
    }

    $newfileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;
    $targetDirectory = "../uploads/" . $newfileName;
    move_uploaded_file($_FILES['csv_file']['tmp_name'], $targetDirectory);

    error_reporting(0);
    ini_set('display_errors', 0);
    require '../../config/excelReader/excel_reader2.php';
    require '../../config/excelReader/SpreadsheetReader.php';

    $reader = new SpreadsheetReader($targetDirectory);
    $i = 0;

    $arrayStdDataInsert = [];
    $arrayStdDataUpdate = [];

    $std_code_check = true;
    $class_check = true;
    $birthday_check = true;
    $national_id_check = true;

    foreach ($reader as $key => $row) {
        if ($i > 0) {
            if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])) {
                if (!is_numeric($row[0])) {
                    $std_code_check = false;
                }

                if (!$main_func->validateClass($row[2])) {
                    $class_check = false;
                }
                if (!$main_func->validateDateFormatImport($row[3])) {
                    $birthday_check = false;
                }

                $user_id = $_SESSION['user_data']->id;
                $checkStd = $std_model->checkStudentWhereSTDNumber($row[0], $user_id);
                $cutname = $main_func->cutPrename($row[1]);
                $data_import = [
                    "std_code" => $row[0],
                    "std_prename" => $cutname[0],
                    "std_name" => $cutname[1],
                    "std_gender" => "",
                    "std_class" => $row[2],
                    "std_birthday" => $row[3],
                    "std_father_name" => "",
                    "std_father_job" => "",
                    "std_mather_name" => "",
                    "std_mather_job" => "",
                    "phone" => "",
                    "address" => "",
                    "national_id" => trim($row[4]),
                    "password" => trim($row[5]),
                    "user_create" => $user_id
                ];

                if (count($checkStd) > 0) {
                    $data_import['std_id'] = $checkStd[0]->std_id;
                    array_push($arrayStdDataUpdate, $data_import); // update data
                } else {
                    $checkNationalId = $std_model->checkNationalId(trim($row[4]), $user_id);
                    if (count($checkNationalId) > 0) {
                        $national_id_check = false;
                    }
                    array_push($arrayStdDataInsert, $data_import); // insert new data
                }
            }
        }
        $i++;
    }
    unlink($targetDirectory);
    if (!$class_check) {
        $response = array('status' => false, 'msg' => "ชั้นเรียนต้องเป็น [ประถม , ม.ต้น , ม.ปลาย] เท่านั้น \nโปรดตรวงสอบชั้นเรียนก่อนนำเข้า");
        echo json_encode($response);
        exit();
    }
    if (!$national_id_check) {
        $response = array('status' => false, 'msg' => "รูปแบบเลขประจำตัวประชาชนไม่ถูกต้อง หรือซ้ำ \nโปรดตรวจสอบเลขประจำตัวประชาชนก่อนนำเข้า");
        echo json_encode($response);
        exit();
    }
    $result = InsertOrUpdateStdFromImport($arrayStdDataInsert, $std_model, $main_func);
    $result = InsertOrUpdateStdFromImport($arrayStdDataUpdate, $std_model, $main_func, "update");
    if ($result) {
        $response = array('status' => true, 'msg' => 'นำเข้าข้อมูลนักศึกษาเรียบร้อย');
        $std_model->checkAndUpdateGenderStudents();
    } else {
        $response = array('status' => false, 'msg' => $result);
    }
    echo json_encode($response);
}

if (isset($_POST['import_students'])) {
    $response = [];
    $allowedExtensions = ['xlsx', 'xls', 'csv'];

    $reader = [];

    if (isset($_FILES["csv_file"])) {
        $fileName = $_FILES["csv_file"]["name"];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo json_encode(['status' => false, 'msg' => 'ไฟล์ที่นำเข้าไม่ถูกต้อง']);
            exit();
        }

        $newFileName = date("Y.m.d - h.i.sa") . "." . $fileExtension;
        $targetDirectory = "../uploads/" . $newFileName;
        move_uploaded_file($_FILES['csv_file']['tmp_name'], $targetDirectory);

        error_reporting(0);
        ini_set('display_errors', 0);
        require '../../config/excelReader/excel_reader2.php';
        require '../../config/excelReader/SpreadsheetReader.php';

        $reader = new SpreadsheetReader($targetDirectory);
    } else {
        $reader[1] = [
            trim($_POST['std_code']),
            trim($_POST['std_name']),
            trim($_POST['std_class']),
            trim($_POST['birthday']),
            trim($_POST['national_id']),
            trim($_POST['password'])
        ];
    }

    $dataInsert = [];
    $dataUpdate = [];
    $invalidRows = [];

    $userId = $_SESSION['user_data']->id;

    $std_model->deleteNullData();

    foreach ($reader as $index => $row) {
        if ($index == 0) continue; // Skip header row

        // Initialize validation checks
        $isValid = true;
        $errors = [];

        if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])) {
            $stdCode = $row[0];
            $class = $row[2];
            $birthday = $row[3];
            $nationalId = trim($row[4]);
            $password = trim($row[5]);

            // Validate student code
            // if (!is_numeric($stdCode)) {
            //     $isValid = false;
            //     $errors[] = 'รหัสนักเรียนไม่ถูกต้อง';
            // }

            // Validate class
            if (!$main_func->validateClass($class)) {
                $isValid = false;
                $errors[] = 'ชั้นเรียนไม่ถูกต้อง ชั้นเรียนต้องเป็น [ประถม , ม.ต้น , ม.ปลาย] เท่านั้น';
            }

            // Validate birthday
            // if (!$main_func->validateDateFormatImport($birthday)) {
            //     $isValid = false;
            //     $errors[] = 'วันเกิดไม่ถูกต้อง';
            // }

            // Validate national ID
            $existingNationalId = $std_model->checkNationalId($nationalId, $userId);
            if (!empty($existingNationalId)) {
                $isValid = false;
                $errors[] = 'เลขประจำตัวประชาชนซ้ำ นำเข้าจาก ' . $existingNationalId[0]->u_name;
            }

            // Prepare student data
            $cutName = $main_func->cutPrename($row[1]);
            $studentData = [
                "std_code" => $stdCode,
                "std_prename" => $cutName[0],
                "std_name" => $cutName[1],
                "std_gender" => "",
                "std_class" => $class,
                "std_birthday" => $birthday,
                "std_father_name" => "",
                "std_father_job" => "",
                "std_mather_name" => "",
                "std_mather_job" => "",
                "phone" => "",
                "address" => "",
                "national_id" => $nationalId,
                "password" => $password,
                "user_create" => $userId
            ];

            // If row is valid, determine if it should be inserted or updated
            if ($isValid) {
                $existingStudent = $std_model->checkStudentWhereSTDNumber($stdCode, $userId);
                if (!empty($existingStudent)) {
                    $studentData['std_id'] = $existingStudent[0]->std_id;
                    $dataUpdate[] = $studentData; // Update data
                } else {
                    $dataInsert[] = $studentData; // Insert new data
                }
            } else {
                // Add invalid row to the invalidRows array with errors
                $invalidRows[] = [
                    'row_data' => $row,
                    'errors' => $errors
                ];
            }
        }
    }

    if (isset($_FILES["csv_file"])) {
        unlink($targetDirectory);
    }
    // Process insert and update
    $resultInsert = InsertOrUpdateStdFromImport($dataInsert, $std_model, $main_func);
    $resultUpdate = InsertOrUpdateStdFromImport($dataUpdate, $std_model, $main_func, "update");

    // Build the response
    if ($resultInsert || $resultUpdate) {
        $std_model->checkAndUpdateGenderStudents();
        $response['status'] = true;
        $response['msg'] = 'นำเข้าข้อมูลนักศึกษาเรียบร้อย';
    } else {
        $response['status'] = false;
        $response['msg'] = 'เกิดข้อผิดพลาดในการนำเข้าข้อมูล';
    }

    // Include invalid rows in the response
    if (!empty($invalidRows)) {
        $response['invalid_rows'] = $invalidRows;
        $response['msg'] .= ' แต่มีบางรายการที่ไม่สามารถนำเข้าได้';
    }

    echo json_encode($response);
}

if (isset($_POST['delete_std'])) {
    $response = "";
    $id = $_POST['id'];
    $mode = $_POST['mode'];
    $result = $std_model->deleteStd($id, $mode);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ลบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => $result);
    }

    echo json_encode($response);
}

if (isset($_POST['delete_multiple_std'])) {
    $response = "";
    $arr_edu_id = json_decode($_POST['arr_edu_id']);
    for ($i = 0; $i < count($arr_edu_id); $i++) {
        $result = $std_model->deleteStd($arr_edu_id[$i], "deleteStd");
    }
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ลบสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => $result);
    }

    echo json_encode($response);
}

function splitAndFilter($text)
{
    // Use preg_split with pattern to handle multiple spaces
    $parts = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

    // Trim each part to remove leading and trailing spaces
    $trimmedParts = array_map('trim', $parts);

    return $trimmedParts;
}

function InsertOrUpdateStdFromImport($arrValue, $std_model, $main_func, $type = 'insert')
{
    $result = 1;
    $array_role_status = [
        "std_tracking" => 1,
        "view_grade" => 1,
        "visit_online" => 1,
    ];
    foreach ($arrValue as $key => $value) {
        if ($type == 'insert') {
            $std_id_last = $std_model->InsertStudent($value);
            if ($std_id_last != 1) {
                // $nameParts = explode(' ', $value['std_name']);
                $nameParts = splitAndFilter($value['std_name']);
                $firstName = $nameParts[0];
                $lastName = $nameParts[1];
                // $dateFormatToPW = $main_func->convert_date_thai_to_number($value['std_birthday']);
                // $dateFormatToPW = $main_func->encryptData($dateFormatToPW);
                $password = $main_func->encryptData($value['password']);
                $array_data = [
                    "name" => $value['std_prename'] . $firstName,
                    "surname" =>  $lastName,
                    "username" => trim($value['national_id']),
                    "password" => $password,
                    "edu_id" => $_SESSION['user_data']->edu_id,
                    "edu_type" => $std_id_last, //$result,
                    "role_id" => 4,
                    "user_create" => $_SESSION['user_data']->id,
                    "district" => "",
                    "province" => "",
                    "district_id" => "",
                    "province_id" => "",
                    "status" => json_encode($array_role_status),
                ];

                $std_model->addToTbUsers($array_data);
                $result = $std_id_last;
            }
        } else {
            $updateLast = $std_model->InsertStudent($value, 1); // 1 is update type
            if ($updateLast != 0) {
                // $nameParts = explode(' ', $value['std_name']);
                $nameParts = splitAndFilter($value['std_name']);
                $firstName = $nameParts[0];
                $lastName = $nameParts[1];
                // $dateFormatToPW = $main_func->convert_date_thai_to_number($value['std_birthday']);
                // $dateFormatToPW = $main_func->encryptData($dateFormatToPW);
                $password = $main_func->encryptData($value['password']);
                $array_data = [
                    "name" => $value['std_prename'] . $firstName,
                    "surname" =>  $lastName,
                    "username" => trim($value['national_id']),
                    "password" => $password,
                    "edu_type" => $value['std_id']
                ];
                $std_model->updateToTbUsers($array_data);
                $result = $updateLast;
            }
        }
    }
    return $result;
}


if (isset($_POST['editStudent'])) {
    $response = "";

    $cutname = $main_func->cutPrename($_POST['std_name']);

    $front_image = $_POST['front_image_old'];
    $back_image = $_POST['back_image_old'];

    if (isset($_FILES['front_image'])) {
        $front_image = CheckUploadFileImage($_FILES['front_image']);
    }
    if (isset($_FILES['back_image'])) {
        $back_image = CheckUploadFileImage($_FILES['back_image']);
    }

    $array_data = [
        "std_code" => $_POST['std_code'],
        "std_prename" => $cutname[0],
        "std_name" => $cutname[1],
        "std_birthday" => $_POST['birthday'],
        "national_id" => trim($_POST['national_id']),
        "std_term" => trim($_POST['std_term']),
        "std_year" => trim($_POST['std_year']),
        "std_profile_image" => $front_image,
        "std_profile_image_back" => $back_image,
        "std_id" => $_POST['std_id']
    ];

    $result = $std_model->updateStd($array_data);

    if ($result == 1) {

        $nameParts = splitAndFilter($cutname[1]);

        $firstName = $nameParts[0];
        $lastName = $nameParts[1];

        $array_data = [
            "name" => $cutname[0] . $firstName,
            "surname" => $lastName,
            "username" => trim($_POST['national_id']),
            "edu_type" => $_POST['std_id']
        ];
        $result = $std_model->updateUserStd($array_data);
        $std_model->updateGender($cutname[0], $_POST['std_id']);
        $response = ($result == 1) ?
            array('status' => true, 'msg' => 'แก้ไขข้อมูลสำเร็จ') :
            array('status' => false, 'msg' => $result);
    } else {
        $response = array('status' => false, 'msg' => $result);
    }


    echo json_encode($response);
}
