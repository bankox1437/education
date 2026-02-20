<?php
session_start();
include "../../config/class_database.php";
include('../../config/main_function.php');
include('../models/index_model.php');

$DB = new Class_Database();
$mainFunc = new ClassMainFunctions();
$index_model = new Index_Model($DB);

if (isset($_POST['getDataIndex'])) {
    $response = array();
    $user_id = $_SESSION['user_data']->id;
    if ($_POST['user_id'] != 0) {
        $user_id = $_POST['user_id'];
    }
    $result = $index_model->getDataIndex($user_id);
    $response = ['status' => true, 'data' => $result];
    echo json_encode($response);
}

if (isset($_POST['insertIndex'])) {
    $response = array();
    $result = "";

    if (count($_FILES) == 0) {
        $response = array('status' => false, 'msg' => 'โปรดแนบไฟล์ตัวชี้วัดอย่างน้อย 1 ไฟล์');
        echo json_encode($response);
        exit();
    }

    if (isset($_POST['title_index'])) {
        foreach ($_POST['title_index'] as $key => $value) {
            $file = reArrayFiles($_FILES['index_file'], $key);

            $m_calendar_id = $_SESSION['main_calendar']->m_calendar_id;
            $user_create = $_SESSION['user_data']->id;
            $title_index = $_POST['title_index'][$key];
            $video = $_POST['video'][$key];

            $array_data = [
                'm_calendar_id' => $m_calendar_id,
                'user_create' =>  $user_create,
                'title_index' => $title_index,
                'video' => $video
            ];

            $index_id = $index_model->InsertIndex($array_data);

            if ($index_id != 0) {
                $uploadDir = '../uploads/index_files/';
                for ($i = 0; $i < count($file); $i++) {
                    $filenameRes = $mainFunc->UploadFile($file[$i], $uploadDir);
                    if (!$filenameRes['status']) {
                        $response = array('status' => false, 'msg' => $filenameRes['result']);
                        echo json_encode($response);
                        exit();
                    }
                    $array_data = [
                        'file_name' => $filenameRes['result'],
                        'file_name_old' => $file[$i]["name"],
                        'index_id' => $index_id,
                    ];
                    $result = $index_model->InsertIndexFile($array_data);
                }
            }
        }
    }

    if ($result != 0) {
        $response = array('status' => true, 'msg' => 'บันทึกเอกสารการประเมินพนักงานราชการสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['editIndex'])) {
    $response = array();
    $result = 1;

    foreach ($_POST['title_index'] as $key => $value) {
        $title_index = $_POST['title_index'][$key];
        $video = $_POST['video'][$key];

        $array_data = [
            'title_index' => $title_index,
            'video' => $video,
            'index_id' => $_POST['index_id'],
        ];

        $index_model->UpdateTitleIdex($array_data);

        if (isset($_FILES['index_file'])) {
            $file = reArrayFiles($_FILES['index_file']);
            $uploadDir = '../uploads/index_files/';
            for ($i = 0; $i < count($file); $i++) {
                $filenameRes = $mainFunc->UploadFile($file[$i], $uploadDir);
                if (!$filenameRes['status']) {
                    $response = array('status' => false, 'msg' => $filenameRes['result']);
                    echo json_encode($response);
                    exit();
                } else {
                    unlink($uploadDir . $_POST['index_file_old'][$i]);
                }
                $array_data = [
                    'file_name' => $filenameRes['result'],
                    'file_name_old' => $file[$i]["name"],
                    'index_file_id' => $_POST['index_file_id'][$i],
                ];
                $result = $index_model->UpdateIndexFile($array_data);
            }
        }
    }

    if ($result != 0) {
        $response = array('status' => true, 'msg' => 'แก้ไขเอกสารการประเมินพนักงานราชการสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}


if (isset($_POST['deleteIndex'])) {
    $index_id = $_POST['index_id'];
    $result = $index_model->DeleteIndex($index_id);
    $dataFile = $index_model->getIndexFile($index_id);
    if ($result) {
        for ($i = 0; $i < count($dataFile); $i++) {
            deleteIndexFile($dataFile[$i]->file_name);
            $index_model->DeleteIndexFile($dataFile[$i]->index_file_id);
        }
        $response = array('status' => true, 'msg' => 'ลบเอกสารการประเมินพนักงานราชการสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}


if (isset($_POST['save_reason'])) {
    unset($_POST['save_reason']);
    $result = $index_model->UpdateIndex($_POST);
    if ($result) {
        $response = array('status' => true, 'msg' => 'บันทึกผลประเมินและความคิดเห็นสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}

if (isset($_POST['deleteIndexFile'])) {
    $index_file_id = $_POST['index_file_id'];
    $result = $index_model->DeleteIndexFile($index_file_id);
    if ($result) {
        deleteIndexFile($_POST['file_name']);
        $response = array('status' => true, 'msg' => '');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่!');
    }
    echo json_encode($response);
}


function deleteIndexFile($file_name)
{
    $uploadDir = '../uploads/index_files/';
    unlink($uploadDir . $file_name);
}

function reArrayFiles($file_post, $index = 0)
{
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        if ($i == $index) {
            foreach ($file_keys as $key) {
                $file_ary[0][$key] = $file_post[$key][$i];
            }
        }
    }
    return $file_ary;
}
