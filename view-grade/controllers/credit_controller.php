<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/credit_model.php";

$DB = new Class_Database();
$creditModel = new Credit_Model($DB);

if (isset($_POST['insertCredit'])) {
    $response = "";

    $compulsory_subjects = json_decode($_POST['compulsory_subjects']);
    $elective_subjects = json_decode($_POST['elective_subjects']);
    $free_electives = json_decode($_POST['free_electives']);
    $std_id = json_decode($_POST['std_id']);
    $result = "";
    for ($i = 0; $i < count($std_id); $i++) {
        $array_data = [
            'std_id' => $std_id[$i],
            'term_id' => $_POST['term_id'],
            'compulsory_subjects' => $compulsory_subjects[$i],
            'elective_subjects' => $elective_subjects[$i],
            'free_electives' =>  $free_electives[$i],
            'user_create' => $_SESSION['user_data']->id
        ];
        $result = $creditModel->insertCredit($array_data);
    }
    if ($result) {
        $response = array('status' => true, 'msg' => 'บันทึกผลรวมหน่วยกิตสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['getDataCredit'])) {
    $response = array();
    $result_total = $creditModel->getDataCredit();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}

if (isset($_POST['updateCredit'])) {
    $response = "";
    $array_data = [
        'compulsory_subjects' => $_POST['compulsory_subjects'],
        'elective_subjects' => $_POST['elective_subjects'],
        'free_electives' => $_POST['free_electives'],
        'credit_id' => $_POST['credit_id'],
    ];
    $result = $creditModel->updateCredit($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'แก้ไขผลรวมหน่วยกิตสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}


if (isset($_REQUEST['deleteCredit'])) {
    $response = array();
    $credit_id = $_POST['credit_id'];
    $result = $creditModel->deleteCredit($credit_id);
    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบผลรวมหน่วยกิตสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}


if (isset($_POST['insertCreditNew'])) {
    $response = "";

    $dataTable1 = json_decode($_POST['dataTable1']);
    $dataTable2 = json_decode($_POST['dataTable2']);
    $dataTable3 = json_decode($_POST['dataTable3']);
    $std_id = json_decode($_POST['std_id']);
    $term = json_decode($_POST['term']);

    $std_class = $_POST['std_class'];

    if (isset($_POST['classChecked']) && $_POST['classChecked'] == 'true') {
        $sqlCLass = "SELECT * FROM tb_students WHERE std_class = :std_class AND user_create = :user_create";
        $result = $DB->Query($sqlCLass, ["std_class" => $std_class, "user_create" => $_SESSION['user_data']->id]);
        $result = json_decode($result);
        if (count($result) > 0) {
            foreach ($result as $key => $std) {
                $array_data = [
                    'std_id' => $std->std_id,
                    'term_id' => $term,
                    'user_create' => $_SESSION['user_data']->id
                ];
                $credit_id = $creditModel->insertCredit($array_data);
                if ($credit_id) {
                    addSubject(1, $credit_id, $dataTable1, $creditModel);
                    addSubject(2, $credit_id, $dataTable2, $creditModel);
                    addSubject(3, $credit_id, $dataTable3, $creditModel);
                    $response = array('status' => true, 'msg' => 'บันทึกผลรวมหน่วยกิตสำเร็จ');
                } else {
                    $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
                }
            }
        } else {
            $response = array('status' => false, 'msg' => 'ไม่มีนักศึกษาในระดับชั้นนี้');
        }
    } else {
        $array_data = [
            'std_id' => $std_id,
            'term_id' => $term,
            'user_create' => $_SESSION['user_data']->id
        ];
        $credit_id = $creditModel->insertCredit($array_data);
        if ($credit_id) {
            addSubject(1, $credit_id, $dataTable1, $creditModel);
            addSubject(2, $credit_id, $dataTable2, $creditModel);
            addSubject(3, $credit_id, $dataTable3, $creditModel);
            $response = array('status' => true, 'msg' => 'บันทึกผลรวมหน่วยกิตสำเร็จ');
        } else {
            $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
        }
    }

    echo json_encode($response);
}

function addSubject($type, $credit_id, $arr, $creditModel)
{
    for ($i = 0; $i < count($arr); $i++) {
        $array_data = [
            'sub_id' => $arr[$i]->sub_id,
            'sub_name' => $arr[$i]->sub_name,
            'credit' => $arr[$i]->credit,
            'grade' => $arr[$i]->grade,
            'credit_id' => $credit_id
        ];
        if ($type == 1) {
            $creditModel->insertCompulsory($array_data);
        } else if ($type == 2) {
            $creditModel->insertElectives($array_data);
        } else {
            $creditModel->insertFreeElectives($array_data);
        }
    }
}

if (isset($_POST['updateCreditNew'])) {
    $response = "";

    $dataTable1 = json_decode($_POST['dataTable1']);
    $dataTable2 = json_decode($_POST['dataTable2']);
    $dataTable3 = json_decode($_POST['dataTable3']);

    $result = false;
    $result = editSubject(1, $dataTable1, $creditModel);
    $result = editSubject(2, $dataTable2, $creditModel);
    $result = editSubject(3, $dataTable3, $creditModel);
    if ($result) {
        $response = array('status' => true, 'msg' => 'แก้ไขผลรวมหน่วยกิตสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

function editSubject($type, $arr, $creditModel)
{
    $resultUpdate = "";
    for ($i = 0; $i < count($arr); $i++) {
        if (isset($arr[$i]->id)) {
            $array_data = [
                'sub_id' => $arr[$i]->sub_id,
                'sub_name' => $arr[$i]->sub_name,
                'credit' => $arr[$i]->credit,
                'grade' => $arr[$i]->grade
            ];
            if ($type == 1) {
                $resultUpdate = $creditModel->updateCompulsory($array_data, $arr[$i]->id);
            } else if ($type == 2) {
                $resultUpdate = $creditModel->updateElectives($array_data, $arr[$i]->id);
            } else {
                $resultUpdate = $creditModel->updateFreeElectives($array_data, $arr[$i]->id);
            }
        } else {
            $array_data = [
                'sub_id' => $arr[$i]->sub_id,
                'sub_name' => $arr[$i]->sub_name,
                'credit' => $arr[$i]->credit,
                'grade' => $arr[$i]->grade,
                'credit_id' => $arr[$i]->credit_id
            ];
            if ($type == 1) {
                $resultUpdate = $creditModel->insertCompulsory($array_data);
            } else if ($type == 2) {
                $resultUpdate = $creditModel->insertElectives($array_data);
            } else {
                $resultUpdate = $creditModel->insertFreeElectives($array_data);
            }
        }
    }
    if (count($arr) == 0) {
        $resultUpdate = "1";
    }
    return $resultUpdate;
}

if (isset($_REQUEST['removeRowUpdate'])) {
    $response = array();
    $id = $_POST['id'];
    $mode = $_POST['mode'];
    $result = 0;
    if ($mode == 1) {
        $result = $creditModel->removeRowUpdate("vg_credit_compulsory", "compulsory_id", $id);
    } else if ($mode == 2) {
        $result = $creditModel->removeRowUpdate("vg_credit_electives", "elective_id", $id);
    } else {
        $result = $creditModel->removeRowUpdate("vg_credit_free_electives", "free_electives_id", $id);
    }

    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ลบวิชาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['insertCreditSet'])) {
    $response = "";

    $dataTable1 = json_decode($_POST['dataTable1']);
    $dataTable2 = json_decode($_POST['dataTable2']);
    $dataTable3 = json_decode($_POST['dataTable3']);
    $set_name = $_POST['set_name'];

    $result = "";
    $array_data = [
        'set_name' => $set_name,
        'user_create' => $_SESSION['user_data']->id
    ];
    $set_id = $creditModel->insertCreditSet($array_data);
    if ($set_id) {
        addSubjectSet(1, $set_id, $dataTable1, $creditModel);
        addSubjectSet(2, $set_id, $dataTable2, $creditModel);
        addSubjectSet(3, $set_id, $dataTable3, $creditModel);
        $response = array('status' => true, 'msg' => 'บันทึกชื่อกลุ่มวิชาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

function addSubjectSet($type, $set_id, $arr, $creditModel)
{
    $resultUpdate = "";
    for ($i = 0; $i < count($arr); $i++) {
        $array_data = [
            'sub_id' => $arr[$i]->sub_id,
            'sub_name' => $arr[$i]->sub_name,
            'credit' => $arr[$i]->credit,
            'set_id' => $set_id
        ];
        if ($type == 1) {
            $resultUpdate = $creditModel->insertSetCompulsory($array_data);
        } else if ($type == 2) {
            $resultUpdate = $creditModel->insertSetElectives($array_data);
        } else {
            $resultUpdate = $creditModel->insertSetFreeElectives($array_data);
        }
    }
    return $resultUpdate;
}

if (isset($_POST['getSubjectSet'])) {
    $response = "";
    $set_id = $_POST['set_id'];
    $data_compulsory = $creditModel->getSubjectSet("vg_credit_set_compulsory", $set_id);
    $data_electives = $creditModel->getSubjectSet("vg_credit_set_electives", $set_id);
    $data_free_electives = $creditModel->getSubjectSet("vg_credit_set_free_electives", $set_id);
    $response = ['data_compulsory' => $data_compulsory, "data_electives" => $data_electives, "data_free_electives" => $data_free_electives];
    echo json_encode($response);
}

if (isset($_REQUEST['getDataCreditSet'])) {
    $response = array();
    $result_total = $creditModel->getDataCreditSet();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}

if (isset($_REQUEST['deleteCreditSet'])) {
    $response = array();
    $set_id = $_POST['set_id'];
    $result = $creditModel->deleteCreditSet($set_id);
    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบกลุ่มวิชาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['removeRowUpdateSet'])) {
    $response = array();
    $id = $_POST['id'];
    $mode = $_POST['mode'];
    $result = 0;
    if ($mode == 1) {
        $result = $creditModel->removeRowUpdateSet("vg_credit_set_compulsory", "compulsory_id", $id);
    } else if ($mode == 2) {
        $result = $creditModel->removeRowUpdateSet("vg_credit_set_electives", "elective_id", $id);
    } else {
        $result = $creditModel->removeRowUpdateSet("vg_credit_set_free_electives", "free_electives_id", $id);
    }

    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ลบวิชาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['updateCreditSet'])) {
    $response = "";

    $dataTable1 = json_decode($_POST['dataTable1']);
    $dataTable2 = json_decode($_POST['dataTable2']);
    $dataTable3 = json_decode($_POST['dataTable3']);

    $set_name = $_POST['set_name'];
    $set_id = $_POST['set_id'];

    $result = $creditModel->updateCreditSet($set_name, $set_id);

    $result = false;
    $result = editSubjectSet(1, $dataTable1, $creditModel);
    $result = editSubjectSet(2, $dataTable2, $creditModel);
    $result = editSubjectSet(3, $dataTable3, $creditModel);
    if ($result) {
        $response = array('status' => true, 'msg' => 'แก้ไขกลุ่มวิชาสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

function editSubjectSet($type, $arr, $creditModel)
{
    $resultUpdate = "";
    for ($i = 0; $i < count($arr); $i++) {
        if (isset($arr[$i]->id)) {
            $array_data = [
                'sub_id' => $arr[$i]->sub_id,
                'sub_name' => $arr[$i]->sub_name,
                'credit' => $arr[$i]->credit,
            ];
            if ($type == 1) {
                $resultUpdate = $creditModel->updateCompulsorySet($array_data, $arr[$i]->id);
            } else if ($type == 2) {
                $resultUpdate = $creditModel->updateElectivesSet($array_data, $arr[$i]->id);
            } else {
                $resultUpdate = $creditModel->updateFreeElectivesSet($array_data, $arr[$i]->id);
            }
        } else {
            $array_data = [
                'sub_id' => $arr[$i]->sub_id,
                'sub_name' => $arr[$i]->sub_name,
                'credit' => $arr[$i]->credit,
                'set_id' => $arr[$i]->set_id
            ];
            if ($type == 1) {
                $resultUpdate = $creditModel->insertSetCompulsory($array_data);
            } else if ($type == 2) {
                $resultUpdate = $creditModel->insertSetElectives($array_data);
            } else {
                $resultUpdate = $creditModel->insertSetFreeElectives($array_data);
            }
        }
    }
    if (count($arr) == 0) {
        $resultUpdate = "1";
    }

    return $resultUpdate;
}

if (isset($_POST['importSubject'])) {
    $response = "";

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

    $types = [];

    foreach ($reader as $key => $row) {
        if ($i > 0) {
            switch ($row['3']) {
                case 1:
                    $types['type1'][] = [
                        "code" => $row[0],
                        "name" => $row[1],
                        "creditor" => $row[2]
                    ];
                    break;
                case 2:
                    $types['type2'][] = [
                        "code" => $row[0],
                        "name" => $row[1],
                        "creditor" => $row[2]
                    ];
                    break;
                case 3:
                    $types['type3'][] = [
                        "code" => $row[0],
                        "name" => $row[1],
                        "creditor" => $row[2]
                    ];
                    break;
            }
        }
        $i++;
    }
    unlink($targetDirectory);
    echo json_encode($types);
}


if (isset($_POST['setCurrentTerm'])) {
    $response = "";
    $creditModel->getCreditByTermId($_POST['term_id']);
    $response = array('status' => true, 'msg' => 'สำเร็จ');
    echo json_encode($response);
}
