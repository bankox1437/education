<?php
session_start();
include "../../config/class_database.php";
include('../models/learning_model.php');
include "../../config/main_function.php";

$DB = new Class_Database();

function CheckUploadFileImage($file, $file_old = "")
{
    $mainFunc = new ClassMainFunctions();
    $uploadDir = '../uploads/images_learn/';
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

if (isset($_POST['insertLearning'])) {
    $response = array();
    unset($_POST['insertLearning']);
    $calendar_id = htmlentities($_POST['calendar_id']);
    $side_1 = htmlentities($_POST['side_1']);
    $side_2 = htmlentities($_POST['side_2']);
    $side_3 = htmlentities($_POST['side_3']);
    $user_create = $_SESSION['user_data']->id;

    $arr_learning = [
        "calendar_id" => $calendar_id,
        "side_1" => $side_1,
        "side_2" => $side_2,
        "side_3" => $side_3,
        "user_create" => $user_create
    ];


    $learModel = new Learning_Model($DB);
    $result = $learModel->InsertLearnSaved($arr_learning);

    $image_file1 = "";
    $image_file2 = "";
    $image_file3 = "";
    $image_file4 = "";
    if (isset($_FILES['image_file1'])) {
        $image_file1 = CheckUploadFileImage($_FILES['image_file1']);
    }
    if (isset($_FILES['image_file2'])) {
        $image_file2 = CheckUploadFileImage($_FILES['image_file2']);
    }
    if (isset($_FILES['image_file3'])) {
        $image_file3 = CheckUploadFileImage($_FILES['image_file3']);
    }
    if (isset($_FILES['image_file4'])) {
        $image_file4 = CheckUploadFileImage($_FILES['image_file4']);
    }

    if ($result != 0) {
        $learning_id = $result;
        $arr_images = [
            "learning_id" => $learning_id,
            "img_name_1" => $image_file1,
            "img_name_2" => $image_file2,
            "img_name_3" => $image_file3,
            "img_name_4" => $image_file4,
        ];
        $result = $learModel->InsertLearnImage($arr_images);
        if ($result != 0) {
            $response = array('status' => true, 'msg' => 'บันทึกการจัดการเรียนรู้สำเร็จ');
        } else {
            $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
        }
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['updateLearning'])) {
    $response = array();

    $side_1 = htmlentities($_POST['side_1']);
    $side_2 = htmlentities($_POST['side_2']);
    $side_3 = htmlentities($_POST['side_3']);
    $learning_id = $_POST['learning_id'];

    $arr = [
        'side_1' => $side_1,
        'side_2' => $side_2,
        'side_3' => $side_3,
        'learning_id' => $learning_id
    ];
    $learModel = new Learning_Model($DB);
    $result = $learModel->UpdateLearnSaved($arr);

    $image_file1 = $_POST['image_file1_old'];
    $image_file2 = $_POST['image_file2_old'];
    $image_file3 = $_POST['image_file3_old'];
    $image_file4 = $_POST['image_file4_old'];

    if (isset($_FILES['image_file1'])) {
        $image_file1 = CheckUploadFileImage($_FILES['image_file1'], $image_file1);
    }
    if (isset($_FILES['image_file2'])) {
        $image_file2 = CheckUploadFileImage($_FILES['image_file2'], $image_file2);
    }
    if (isset($_FILES['image_file3'])) {
        $image_file3 = CheckUploadFileImage($_FILES['image_file3'], $image_file3);
    }
    if (isset($_FILES['image_file4'])) {
        $image_file4 = CheckUploadFileImage($_FILES['image_file4'], $image_file4);
    }

    if ($result != 0) {
        $arr_images = [
            "img_name_1" => $image_file1,
            "img_name_2" => $image_file2,
            "img_name_3" => $image_file3,
            "img_name_4" => $image_file4,
            "learning_id" => $learning_id,
        ];
        $result = $learModel->UpdateLearnImages($arr_images);
        if ($result != 0) {
            $response = array('status' => true, 'msg' => 'แก้ไขการจัดการเรียนรู้สำเร็จ');
        } else {
            $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
        }
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['getCountSeved'])) {
    $learModel = new Learning_Model($DB);
    $term = $_POST['term'];
    $year = $_POST['year'];
    $user_id = $_POST['user_id'];
    $countSaved = $learModel->getCountLearnSaved($term, $year, $user_id);
    //$countPlan = $learModel->getCountEduPlan($term, $year, $user_id);
    //echo json_encode(array($countSaved[0], $countPlan[0]));
    echo json_encode($countSaved[0]);
}

if (isset($_POST['getlearnList'])) {
    $learModel = new Learning_Model($DB);
    $user_id = $_POST['user_id'];
    $result = $learModel->getCountLearnList($user_id);
    echo json_encode($result);
}

if (isset($_POST['getlearnDetail'])) {
    $learModel = new Learning_Model($DB);
    $learning_id = $_POST['learning_id'];
    $result = $learModel->getCountLearnDetail($learning_id);
    $result[0]->side_1 = nl2br($result[0]->side_1);
    $result[0]->side_2 = nl2br($result[0]->side_2);
    $result[0]->side_3 = nl2br($result[0]->side_3);
    echo json_encode($result);
}

if (isset($_POST['getDataDetail'])) {
    $learModel = new Learning_Model($DB);
    $calendar_id = $_POST['calendar_id'];
    $new = isset($_POST['new']) ? $_POST['new'] : false;
    $result = $learModel->getCountDataDetail($calendar_id, $new);
    $result[0]->side_1 = nl2br($result[0]->side_1);
    $result[0]->side_2 = nl2br($result[0]->side_2);
    $result[0]->side_3 = nl2br($result[0]->side_3);
    foreach ($result as &$value) {
        if (is_object($value) && isset($value->plan_file)) {
            $value->plan_file_raw = $value->plan_file;
        }

        if (is_object($value) && isset($value->content_file)) {
            $value->content_file_raw = $value->content_file;
        }

        if (is_object($value) && isset($value->content_file) && !empty($value->content_file)) {
            $filePath = '../uploads/edu_plan_new/' . $value->content_file;
            $value->content_file = file_exists($filePath)
                ? "uploads/edu_plan_new/" . $value->content_file
                : "https://drive.google.com/file/d/{$value->content_file}/view";
        }

        // if (is_object($value) && isset($value->plan_file) && !empty($value->plan_file)) {
        //     $value->plan_file = "https://drive.google.com/file/d/{$value->plan_file}/view";
        // }

        if (is_object($value) && isset($value->plan_file) && !empty($value->plan_file)) {
            $filePath = '../uploads/plan_time/' . $value->plan_file;
            $value->plan_file = file_exists($filePath)
                ? "uploads/plan_time/" . $value->plan_file
                : "https://drive.google.com/file/d/{$value->plan_file}/view";
        }

        if (is_object($value) && isset($value->img_name_1) && !empty($value->img_name_1)) {
            $file_path_img_name_1 = '../uploads/images_learn/' . $value->img_name_1;
            $value->img_name_1 = file_exists($file_path_img_name_1)
                ? "uploads/images_learn/" . $value->img_name_1
                : "https://drive.google.com/thumbnail?id={$value->img_name_1}&sz=w1000";
        }

        if (is_object($value) && isset($value->img_name_2) && !empty($value->img_name_2)) {
            $file_path_img_name_2 = '../uploads/images_learn/' . $value->img_name_2;
            $value->img_name_2 = file_exists($file_path_img_name_2)
                ? "uploads/images_learn/" . $value->img_name_2
                : "https://drive.google.com/thumbnail?id={$value->img_name_2}&sz=w1000";
        }

        if (is_object($value) && isset($value->img_name_3) && !empty($value->img_name_3)) {
            $file_path_img_name_3 = '../uploads/images_learn/' . $value->img_name_3;
            $value->img_name_3 = file_exists($file_path_img_name_3)
                ? "uploads/images_learn/" . $value->img_name_3
                : "https://drive.google.com/thumbnail?id={$value->img_name_3}&sz=w1000";
        }

        if (is_object($value) && isset($value->img_name_4) && !empty($value->img_name_4)) {
            $file_path_img_name_4 = '../uploads/images_learn/' . $value->img_name_4;
            $value->img_name_4 = file_exists($file_path_img_name_4)
                ? "uploads/images_learn/" . $value->img_name_4
                : "https://drive.google.com/thumbnail?id={$value->img_name_4}&sz=w1000";
        }
    }
    echo json_encode($result);
}


if (isset($_POST['add_reason'])) {
    $learModel = new Learning_Model($DB);
    $learning_id = $_POST['learning_id'];
    $reason = htmlentities($_POST['reason']);

    $checkReason = $learModel->selectCheckReason($learning_id);
    if ($checkReason[0]->reason == 0) {
        $result = $learModel->InsertLearnReason($learning_id, $reason);
    } else {
        $result = $learModel->UpdateLearnReason($reason, $learning_id);
    }

    if ($result != 0) {
        $response = array('status' => true, 'msg' => 'อัปเดตความคิดเห็นสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['delete_learn_save'])) {
    $learModel = new Learning_Model($DB);
    $learning_id = $_POST['id'];
    $result = $learModel->DeleteLearn($learning_id);
    if ($result == 1) {
        $response = array('status' => true, 'msg' => 'ลบบันทึกการเรียนรู้สำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}


function CheckUploadFilePDF($file, $file_old = "")
{
    $mainFunc = new ClassMainFunctions();
    $uploadDir = '../uploads/learning_pdf/';

    $file_response = $mainFunc->UploadFile($file, $uploadDir);
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

if (isset($_POST['insertSaveLearning'])) {
    $response = array();

    unset($_POST['insertSaveLearning']);

    $calendar_id = htmlentities($_POST['calendar_id']);
    $learning_id = isset($_POST['learning_id']) ? $_POST['learning_id'] : 0;
    $user_create = $_SESSION['user_data']->id;

    $learModel = new Learning_Model($DB);
    $save_learning_file = isset($_POST['save_learning_file_old']) ? $_POST['save_learning_file_old'] : '';

    if (isset($_FILES['save_learning_file'])) {
        $save_learning_file = CheckUploadFilePDF($_FILES['save_learning_file'], $save_learning_file);
    } else {
        $save_learning_file = $_POST['save_learning_file_old'];
    }

    $arr_images = [];
    $type = 1;
    $msg = "บันทึกไฟล์ผลการเรียนการสอนสำเร็จ";
    if (!empty($calendar_id)) {
        $arr_images = [
            "calendar_id" => $calendar_id,
            "learning_file" => $save_learning_file,
            "user_create" => $user_create
        ];
    } else {
        $arr_images = [
            "learning_id" => $learning_id,
            "user_create" => $user_create,
            "learning_file" => $save_learning_file,
        ];
        $type = 0;
        $msg = "แก้ไขไฟล์ผลการเรียนการสอนสำเร็จ";
    }

    $result = $learModel->InsertLearnFile($arr_images, $type);
    if ($result != 0) {
        $response = array('status' => true, 'msg' => $msg);
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}
