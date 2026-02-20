<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/kpc_model.php";

$DB = new Class_Database();
$kpcModel = new KPC_Model($DB);

if (isset($_POST['insertKPC'])) {
    $response = "";

    $hour = json_decode($_POST['hour_arr']);
    $std_id = json_decode($_POST['std_id']);
    $mode = $_POST['mode'];

    $result = "";
    for ($i = 0; $i < count($hour); $i++) {
        $array_data = [
            'term_id' => $_POST['term_id'],
            'std_class' => $_POST['std_class'],
            'hour' => $hour[$i],
            'user_create' => $_SESSION['user_data']->id,
            'std_id' => $std_id[$i]
        ];
        $result = $kpcModel->insertKPC($array_data, $mode);
    }

    if ($result) {
        $response = array('status' => true, 'msg' => 'บันทึกคะแนน กพช. สำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['getDataKPC'])) {
    $response = array();
    $result_total = $kpcModel->getDataKPC();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => (string)$result_total[3]];
    echo json_encode($response);
}

if (isset($_POST['updateKPC'])) {
    $response = "";
    $array_data = [
        'hour' => $_POST['hour'],
        'kpc_id' => $_POST['kpc_id'],
    ];
    $result = $kpcModel->updateKPC($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'แก้ไขคะแนน กพช. สำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}


if (isset($_REQUEST['deleteKPC'])) {
    $response = array();
    $kpc_id = $_POST['kpc_id'];
    $result = $kpcModel->deleteKPC($kpc_id);
    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบ กพช. สำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['import_kpc'])) {
    $response = [];
    $allowedExtensions = ['xlsx', 'xls', 'csv'];

    if (isset($_FILES["kpc_file"])) {
        $fileName = $_FILES["kpc_file"]["name"];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo json_encode(['status' => false, 'msg' => 'ไฟล์ที่นำเข้าไม่ถูกต้อง']);
            exit();
        }

        $newFileName = date("Ymd_His") . "." . $fileExtension;
        $targetDirectory = "../uploads/" . $newFileName;
        move_uploaded_file($_FILES['kpc_file']['tmp_name'], $targetDirectory);

        // ปิด error report เพื่อป้องกันการแสดงผล
        error_reporting(0);
        ini_set('display_errors', 0);

        // เรียกใช้คลาส
        require '../../config/excelReader/excel_reader2.php';
        require '../../config/excelReader/SpreadsheetReader.php';

        try {
            $reader = new SpreadsheetReader($targetDirectory);

            // กำหนดให้ใช้ sheet แรก (ถ้ามีหลาย sheet)
            $sheets = $reader->Sheets();

            $reader->ChangeSheet(0);

            if (count($reader) > 0) {
                foreach ($reader as $index => $row) {
                    if ($index == 0) continue; // Skip header row
                    $stdCode = $row[0];
                    $hour = $row[1];
                    $stdData = $kpcModel->getSTDByStdCode($stdCode);
                    $stdData = json_decode($stdData);

                    if (!empty($stdData)) {
                        $kpcData = $kpcModel->getKPCByStdId($stdData[0]->std_id);
                        $kpcData = json_decode($kpcData);
                        $mode = "update";
                        $array_data = [
                            'term_id' => $_SESSION['term_active']->term_id,
                            'std_class' => "",
                            'hour' => $hour,
                            'user_create' => $_SESSION['user_data']->id,
                            'std_id' => 0
                        ];

                        if (empty($kpcData)) {
                            $mode = "add";
                            $array_data['std_class'] = $stdData[0]->std_class;
                            $array_data['std_id'] = $stdData[0]->std_id;
                        } else {
                            $array_data['std_class'] = $kpcData[0]->std_class;
                            $array_data['std_id'] = $kpcData[0]->std_id;
                        }

                        $result = $kpcModel->insertKPC($array_data, $mode);
                    }
                }

                if ($result) {
                    $response = array('status' => true, 'msg' => 'นำเข้าข้อมูลคะแนน กพช. สำเร็จ');
                } else {
                    $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
                }
            } else {
                $response = array('status' => false, 'msg' => 'ไม่พบข้อมูลในไฟล์');
            }

            if (file_exists($targetDirectory)) {
                unlink($targetDirectory);
            }

            echo json_encode($response);
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'msg' => 'ไม่สามารถอ่านไฟล์ได้: ' . $e->getMessage()]);
            if (file_exists($targetDirectory)) {
                unlink($targetDirectory);
            }
        }
    }
}
