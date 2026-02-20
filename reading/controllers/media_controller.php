<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/media_model.php";
include "../models/report_media_model.php";

$DB = new Class_Database();
$mainFunc = new ClassMainFunctions();
$mediaModel = new MediaModel($DB);
$reportMediaModel = new ReportMediaModel($DB);

if (isset($_REQUEST['getDataMedia'])) {
    $response = array();
    $result_total = $mediaModel->getDataMedia();
    $resultNew = [];
    foreach ($result_total[2] as $key => $value) {
        $media_file_name_cover = $value->media_file_name_cover;
        if (!file_exists("../uploads/media_cover/".$media_file_name_cover)) {
            $gd_media_file_name_cover = 'https://drive.google.com/file/d/' . $media_file_name_cover . '/view';
            $value->media_file_name_cover = $gd_media_file_name_cover;
        }else {
            $value->media_file_name_cover = "uploads/media_cover/".$media_file_name_cover;
        }
        $resultNew[] = $value;
    }
    $response = ['rows' => $resultNew, "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}

if (isset($_POST['insertMedia'])) {
    $response = "";

    $uploadDir = '../uploads/media/';
    $uploadDirCover = '../uploads/media_cover/';
    $fileNameRes = "";
    $fileNameResCover = "";

    if (isset($_FILES['media_file'])) {
        $media_file = $_FILES['media_file'];
        $fileNameRes = $mainFunc->UploadFile($media_file, $uploadDir);
        if (!$fileNameRes['status']) {
            $response = array('status' => false, 'msg' => $fileNameRes['result']);
            echo json_encode($response);
            exit();
        }
        $fileNameRes = $fileNameRes['result'];
    }

    if (isset($_FILES['media_cover_file'])) {
        $media_cover_file = $_FILES['media_cover_file'];
        $fileNameResCover = $mainFunc->UploadFile($media_cover_file, $uploadDirCover);
        if (!$fileNameResCover['status']) {
            $response = array('status' => false, 'msg' => $fileNameResCover['result']);
            echo json_encode($response);
            exit();
        }
        $fileNameResCover = $fileNameResCover['result'];
    }

    $array_data = [
        'media_name' => $_POST['media_name'],
        'link_e_book' => $_POST['link_e_book'],
        'link_test' => isset($_POST['link_test']) ? $_POST['link_test'] : '',
        'link_know_test' => $_POST['link_know_test'],
        'media_file_name' => $fileNameRes,
        'media_file_name_cover' => $fileNameResCover,
        'media_type' => $_SESSION['user_data']->edu_type,
        'std_class' => $_POST['std_class'],
        'author_name' => $_POST['author_name'],
        'isChecked' => $_POST['isChecked'],
        'user_create' => $_SESSION['user_data']->id
    ];

    $result = $mediaModel->insertMedia($array_data);

    if ($result) {
        $response = array('status' => true, 'msg' => 'บันทึกสื่อการอ่านสำเร็จ', 'data' => $result);
        $mediaModel->insertMediaAccept($_SESSION['user_data']->id, $result);
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['updateMedia'])) {
    $response = "";

    $media_file_name = $_POST['media_file_name'];
    $media_file_name_cover = $_POST['media_file_name_cover'];
    $uploadDir = '../uploads/media/';
    $uploadDirCover = '../uploads/media_cover/';

    $file_new = $media_file_name;
    if (isset($_FILES['media_file']) && !empty($_FILES['media_file'])) {
        $media_file = $_FILES['media_file'];
        $fileNameRes = "";
        $fileNameRes = $mainFunc->UploadFile($media_file, $uploadDir);
        if (!$fileNameRes['status']) {
            $response = array('status' => false, 'msg' => $fileNameRes['result']);
            echo json_encode($response);
            exit();
        }
        if (file_exists($uploadDir . $media_file_name)  && !empty($_POST['media_file_name'])) {
            unlink($uploadDir . $media_file_name);
        }
        $file_new =  $fileNameRes['result'];
    }

    $file_new_cover = $media_file_name_cover;
    if (isset($_FILES['media_file_cover']) && !empty($_FILES['media_file_cover'])) {
        $media_file_cover = $_FILES['media_file_cover'];
        $fileNameResCover = "";
        $fileNameResCover = $mainFunc->UploadFile($media_file_cover, $uploadDirCover);
        if (!$fileNameResCover['status']) {
            $response = array('status' => false, 'msg' => $fileNameResCover['result']);
            echo json_encode($response);
            exit();
        }
        if (file_exists($uploadDirCover . $media_file_name_cover) && !empty($_POST['media_file_name_cover'])) {
            unlink($uploadDirCover . $media_file_name_cover);
        }
        $file_new_cover =  $fileNameResCover['result'];
    }

    $array_data = [
        'media_name' => $_POST['media_name'],
        'link_e_book' => $_POST['link_e_book'],
        'link_test' => isset($_POST['link_test']) ? $_POST['link_test'] : '',
        'link_know_test' => $_POST['link_know_test'],
        'media_file_name' => $file_new,
        'media_file_name_cover' => $file_new_cover,
        'std_class' => $_POST['std_class'],
        'author_name' => $_POST['author_name'],
        'media_id' => $_POST['media_id'],
    ];

    $result = $mediaModel->updateMedia($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'แก้ไขสื่อการอ่านสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['changeWorkingMedia'])) {
    $response = array();
    $array_data = [
        'status_change' => $_POST['status_change'],
        'media_id' => $_POST['media_id'],
        'user_create' => $_SESSION['user_data']->id,
        'media_name' => $_POST['media_name']
    ];
    $result = $mediaModel->changeStatusWorkingMedia($array_data);
    if ($result) {

        $resultLast = changeUpdateWorkingMedia($array_data, $mediaModel);
        if ($resultLast) {
            $response = array('status' => true, 'msg' => 'แก้ไขการใช้งานสำเร็จ');
        }
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

function changeUpdateWorkingMedia($arr_data, $mediaModel)
{
    $statusWoring = $arr_data['status_change'];
    array_shift($arr_data);
    $result = $mediaModel->changeWorkingMedia($arr_data, $statusWoring);
    return $result;
}


if (isset($_POST['deleteMedia'])) {
    $response = array();
    $media_id = $_POST['media_id'];

    $result = $mediaModel->deleteMedia($media_id);
    if ($result) {
        $response = array('status' => true, 'msg' => 'ลบสื่อการอ่านสำเร็จ');

        $uploadDir = '../uploads/media/' . $_POST['media_file_name'];
        $uploadDirCover = '../uploads/media_cover/' . $_POST['media_file_name_cover'];
        if (file_exists($uploadDir) && !empty($_POST['media_file_name'])) {
            unlink($uploadDir);
        }
        if (file_exists($uploadDirCover) && !empty($_POST['media_file_name_cover'])) {
            unlink($uploadDirCover);
        }

        $audio = $mediaModel->getAudioFileForDelete($media_id);
        $uploadDirAu = '../uploads/audio_test/';
        $uploadDirResize = '../uploads/audio_test_resize/';
        foreach ($audio as $key => $value) {
            if ($value->type == '1') {
                if (file_exists($uploadDirAu . $value->file_audio_test)) {
                    unlink($uploadDirAu . $value->file_audio_test);
                }
            } else {
                if (file_exists($uploadDirResize . $value->file_audio_test)) {
                    unlink($uploadDirResize . $value->file_audio_test);
                }
            }
        }
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_REQUEST['getDataMediaReading'])) {
    $response = array();
    $result = $mediaModel->getDataMediaReading();
    if ($result) {
        $response = ['status' => true, "data" => $result];
    } else {
        $response = ['status' => false, "msg" => "เกิดข้อผิดพลาด"];
    }
    echo json_encode($response);
}

if (isset($_REQUEST['upload_audio_test'])) {
    $response = array();

    $media_id = $_POST['media_id'];
    $duration = $_POST['duration'];

    $uploadDir = "../uploads/audio_test/";
    $resizeDir = "../uploads/audio_test_resize/";
    if ($_FILES['audio']['error'] === UPLOAD_ERR_OK) {
        $responseUploadAudio = $mainFunc->UploadFileAudio($uploadDir, $resizeDir);
        if (!$responseUploadAudio['status']) {
            $response = ['status' => $responseUploadAudio['status'], "msg" =>  $responseUploadAudio['result']];
        }

        $array_data = [
            "test_read_id" => $media_id,
            "duration" => $duration,
            "type" => $responseUploadAudio['resize'],
            "file_audio_test" => $responseUploadAudio['result'],
            "user_create" => $_SESSION['user_data']->edu_type
        ];

        $result = $mediaModel->insertAudioTest($array_data);
        if ($result) {
            $response = array('status' => true, 'msg' => 'บันทึกการสอบอ่านออกเสียงสำเร็จ');
        } else {
            $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
        }
    } else {
        $response = ['status' => false, "msg" => "เกิดข้อผิดพลาดในการอัปโหลดไฟล์เสียง ลองใหม่"];
    }
    echo json_encode($response);
}


if (isset($_GET['getDataReportMedia'])) {
    $response = array();
    $result_total = $reportMediaModel->getDataReportMedia();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}

if (isset($_POST['getDataReportTimeOfMedia'])) {
    // if(){

    // }
    $result = $reportMediaModel->getDataReportTimeOfMedia($_POST['media_id']);
    echo json_encode($result);
}

if (isset($_REQUEST['getDataMediaReadingBS'])) {
    $response = array();
    $result_total = $reportMediaModel->getDataMediaReadingBS();
    $response = ['rows' => $result_total[2], "total" => (int)$result_total[0], "totalNotFiltered" => (int)$result_total[1], "sql" => $result_total[3]];
    echo json_encode($response);
}

if (isset($_REQUEST['addDurationView'])) {
    $response = array();
    $mode = $_REQUEST['mode'];
    $result = $mediaModel->insertViewMedia($_POST['media_id'], $mode);
    $response = ['status' => $result];
    echo json_encode($response);
}
