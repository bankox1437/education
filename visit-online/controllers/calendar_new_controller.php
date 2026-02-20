<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/calendar_new_model.php";

$DB = new Class_Database();
$mainFunc = new ClassMainFunctions();

if (isset($_POST['insertCalendarNew'])) {
    $response = "";
    $calendar_model = new Calendar_New_Model($DB);

    $content_file_name = "";
    if (count($_FILES) > 0 && isset($_FILES['content_file'])) {
        $content_file = $_FILES['content_file'];
        $uploadDir = '../uploads/edu_plan_new/';

        $filenameRescontent_file = $mainFunc->UploadFile($content_file, $uploadDir);
        if (!$filenameRescontent_file['status']) {
            $response = array('status' => false, 'msg' => $filenameRescontent_file['result']);
            echo json_encode($response);
            exit();
        }

        $content_file_name = $filenameRescontent_file['result'];
    }

    $Plan_file_name = "";
    if (count($_FILES) > 0 && isset($_FILES['plan_file'])) {
        $Plan_file = $_FILES['plan_file'];
        $uploadDir = '../uploads/plan_time/';

        $filenameResPlan_file = $mainFunc->UploadFile($Plan_file, $uploadDir);
        if (!$filenameResPlan_file['status']) {
            $response = array('status' => false, 'msg' => $filenameResPlan_file['result']);
            echo json_encode($response);
            exit();
        }

        $plan_file_name = $filenameResPlan_file['result'];
    }

    $array_data = [
        "m_calendar_id" => $_SESSION['main_calendar'][$_POST['std_class']]->m_calendar_id,
        "plan_name" => $_POST['plan_name'],
        "content_link" => $_POST['content_link'],
        "content_file" => $content_file_name,
        "test_before_link" => $_POST['test_before_link'],
        "test_after_link" => $_POST['test_after_link'],
        "std_class" => $_POST['std_class'],
        "user_create" => $_SESSION['user_data']->id,
        "time_step" => $_POST['time_step'],
        "work_sheet" => $_POST['work_sheet'],
        "plan_file" => $plan_file_name
    ];

    $result = $calendar_model->InsertCalendar($array_data);
    if ($result > 0) {
        $calenda_id = $result;

        if (isset($_FILES['work_file']) && count($_FILES['work_file']) > 0) {
            $result = addWork($_FILES['work_file'], $mainFunc, $calenda_id, $calendar_model);
        }

        $response = array(
            'status' => $result ? true : false,
            'msg' => $result ? 'บันทึกการพบกลุ่มสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
        );
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['editCalendar'])) {
    $response = "";
    $calendar_model = new Calendar_New_Model($DB);



    $array_data = [];
    $calendar_id = $_POST['calendar_id'];
    $content_file_old_name = $_POST['content_file_old_name'];
    $plan_file_old = $_POST['plan_file_old'];

    $plan_file_name = $plan_file_old;

    if ($_SESSION['user_data']->role_id != 3) {
        $sql = "SELECT * FROM cl_calendar_new WHERE from_calendar_am = :from_calendar_am";
        $data = $DB->Query($sql, ["from_calendar_am" => $calendar_id]);
        $data = json_decode($data);
        if (count($data) > 0) {
            $response = array('status' => false, 'reload' => false, 'msg' => "การพบกลุ่มนี้มีครูเลือกไปใช้งานแล้ว\nไม่สามารถแก้ไขหรือลบได้");
            echo json_encode($response);
            exit();
        }
    }

    if (isset($_FILES['content_file']) && count($_FILES['content_file']) != 0) {
        $content_file = $_FILES['content_file'];
        $uploadDir = '../uploads/edu_plan_new/';

        $filenameResContent_file = $mainFunc->UploadFile($content_file, $uploadDir);
        if (!$filenameResContent_file['status']) {
            $response = array('status' => false, 'reload' => false, 'msg' => $filenameResContent_file['result']);
            echo json_encode($response);
            exit();
        }
        if (file_exists($uploadDir . $content_file_old_name)) {
            unlink($uploadDir . $content_file_old_name);
        }

        $content_file_old_name = $filenameResContent_file['result'];
    }

    if (count($_FILES) > 0 && isset($_FILES['plan_file'])) {
        $Plan_file = $_FILES['plan_file'];
        $uploadDir = '../uploads/plan_time/';

        $filenameResPlan_file = $mainFunc->UploadFile($Plan_file, $uploadDir);
        if (!$filenameResPlan_file['status']) {
            $response = array('status' => false, 'reload' => false, 'msg' => $filenameResPlan_file['result']);
            echo json_encode($response);
            exit();
        }

        if (file_exists($uploadDir . $plan_file_name)) {
            unlink($uploadDir . $plan_file_name);
        }

        $plan_file_name = $filenameResPlan_file['result'];
    }

    $array_data = [
        "plan_name" => $_POST['plan_name'],
        "content_link" => $_POST['content_link'],
        "content_file" => $content_file_old_name,
        "test_before_link" => $_POST['test_before_link'],
        "test_after_link" => $_POST['test_after_link'],
        "std_class" => $_POST['std_class'],
        "time_step" => $_POST['time_step'],
        "work_sheet" => $_POST['work_sheet'],
        "plan_file" => $plan_file_name,
        "calendar_id" => $calendar_id
    ];

    $result = $calendar_model->EditCalendar($array_data);
    if ($result) {
        if (isset($_FILES['work_file_old']) && count($_FILES['work_file_old']) > 0) {
            $work_id = $_POST['work_id'];
            $fileName_old = $_POST['fileName_old'];
            $result = addWork($_FILES['work_file_old'], $mainFunc, $calendar_id, $calendar_model, 2, $work_id, $fileName_old);
        }

        if (isset($_FILES['work_file']) && count($_FILES['work_file']) > 0) {
            $result = addWork($_FILES['work_file'], $mainFunc, $calendar_id, $calendar_model);
        }

        $response = array(
            'status' => $result ? true : false,
            'msg' => $result ? 'แก้ไขการพบกลุ่มสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่',
            'reload' => true,
        );
    } else {
        $response = array('status' => false, 'reload' => true, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

function addWork($file, $mainFunc, $calenda_id, $calendar_model, $mode = 1, $work_id = [], $work_file_old = [])
{
    $result = 0;
    $uploadDir = '../uploads/work_new/';
    $file = reArrayFiles($file);
    for ($i = 0; $i < count($file); $i++) {
        $filenameResWork_file = $mainFunc->UploadFile($file[$i], $uploadDir);
        if (!$filenameResWork_file['status']) {
            return false;
            break;
        } else {
            if ($mode == 2) {
                unlink($uploadDir . $work_file_old[$i]);
            }
        }
        if ($mode == 1) {
            $array_data = [
                'calendar_id' => $calenda_id,
                'file_name' => $filenameResWork_file['result']
            ];
            $result = $calendar_model->InsertWork($array_data);
        } else {
            $array_data = [
                'file_name' => $filenameResWork_file['result'],
                'work_id' => $work_id[$i],
            ];
            $result = $calendar_model->UpdateWork($array_data);
        }
    }
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function addOther($file, $mainFunc, $calenda_id, $calendar_model, $mode = 1, $work_id = [], $work_file_old = [])
{
    $result = 0;
    $uploadDir = '../uploads/other_file/';
    $file = reArrayFiles($file);
    for ($i = 0; $i < count($file); $i++) {
        $filenameResWork_file = $mainFunc->UploadFile($file[$i], $uploadDir);
        if (!$filenameResWork_file['status']) {
            return false;
            break;
        } else {
            if ($mode == 2) {
                unlink($uploadDir . $work_file_old[$i]);
            }
        }
        if ($mode == 1) {
            $array_data = [
                'calendar_id' => $calenda_id,
                'file_name' => $filenameResWork_file['result']
            ];
            $result = $calendar_model->InsertOther($array_data);
        } else {
            $array_data = [
                'file_name' => $filenameResWork_file['result'],
                'other_id' => $work_id[$i],
            ];
            $result = $calendar_model->UpdateOther($array_data);
        }
    }
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function reArrayFiles($file_post)
{
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_ary;
}


if (isset($_POST['getDataCalender'])) {
    try {
        $calendar_model = new Calendar_New_Model($DB);
        $user_id = "";
        if (!empty($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
        }
        $result = $calendar_model->getDataCalender($user_id, $_POST['filter_field']);
        $response = ['status' => true, 'data' => $result];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}


if (isset($_REQUEST['getDataCalenderGET'])) {
    try {
        $calendar_model = new Calendar_New_Model($DB);

        $result = $calendar_model->getDataCalenderGET();

        $response = ['rows' => $result[2], "total" => (int)$result[0], "totalNotFiltered" => (int)$result[1]];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}


if (isset($_POST['getDatacalendarByTerm'])) {
    $calendar_model = new Calendar_New_Model($DB);
    $user_id = "";
    if (!empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
    }
    $term_select = $_POST['term_select'];
    $term_select = explode('/', $term_select);
    $result = $calendar_model->getDataCalender($user_id, $term_select[0], $term_select[1]);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['getDataCalenderOther'])) {
    $calendar_model = new Calendar_New_Model($DB);
    $result = $calendar_model->getDataCalendarOther();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['delete_calendar'])) {
    try {
        $response = array();

        $calendar_model = new Calendar_New_Model($DB);
        $mainFunc = new ClassMainFunctions();

        $id = $_POST['id'];
        $file = $_POST['file'];
        $content_file = $_POST['content_file'];
        $l_id = $_POST['l_id'];
        $l_old_id = $_POST['l_old_id'];
        //  $user_id = $_SESSION['user_data']->id;

        $uploadDir = '../uploads/work_new/';
        $uploadDir_learn_image = '../uploads/images_learn/';
        $uploadDir_learn_pdf = '../uploads/learning_pdf/';
        $uploadDir_edu_plan_new = '../uploads/edu_plan_new/';
        $uploadDir_plan_time = '../uploads/plan_time /';

        $file_delete = $calendar_model->getFileWork($id);
        $file_delete_image = $calendar_model->getImageLearning($l_old_id);
        $file_delete_pdf = $calendar_model->getPDFLearning($l_id);

        $result = $calendar_model->deleteCalender($id);
        if ($result) {
            if (!empty($file)) {
                if (file_exists($uploadDir_plan_time . $file)) {
                    unlink($uploadDir_plan_time . $file);
                }
            }

            if (file_exists($uploadDir_edu_plan_new . $content_file)) {
                unlink($uploadDir_edu_plan_new . $content_file);
            }

            for ($i = 0; $i < count($file_delete); $i++) {
                if (file_exists($uploadDir . $file_delete[$i]->file_name)) {
                    unlink($uploadDir . $file_delete[$i]->file_name);
                }
            }

            if (count($file_delete_image) > 0) {
                if (file_exists($uploadDir_learn_image . $file_delete_image[0]->img_name_1)) {
                    unlink($uploadDir_learn_image . $file_delete_image[0]->img_name_1);
                }
                if (file_exists($uploadDir_learn_image . $file_delete_image[0]->img_name_2)) {
                    unlink($uploadDir_learn_image . $file_delete_image[0]->img_name_2);
                }
                if (file_exists($uploadDir_learn_image . $file_delete_image[0]->img_name_3)) {
                    unlink($uploadDir_learn_image . $file_delete_image[0]->img_name_3);
                }
                if (file_exists($uploadDir_learn_image . $file_delete_image[0]->img_name_4)) {
                    unlink($uploadDir_learn_image . $file_delete_image[0]->img_name_4);
                }
            }

            if (count($file_delete_pdf) > 0) {
                if (file_exists($uploadDir_learn_pdf . $file_delete_pdf[0]->learning_file)) {
                    unlink($uploadDir_learn_pdf . $file_delete_pdf[0]->learning_file);
                }
            }
        }
        $response = ['status' => true, 'data' => $result];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}


if (isset($_POST['getDatacalendarOtherWhere'])) {
    $calendar_model = new Calendar_New_Model($DB);
    $pro_id = $_POST['pro_id'];
    $dis_id = $_POST['dis_id'];
    $sub_id = $_POST['sub_id'];
    $result = $calendar_model->getDataCalendarOther($sub_id, $pro_id, $dis_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}


if (isset($_POST['insertMainCalendar'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();
    $calendar_model = new Calendar_New_Model($DB);

    $file = $_FILES['main_calendar_file'];
    $uploadDir = '../uploads/calendar/';

    $filenameRes = $mainFunc->UploadFile($file, $uploadDir);
    if (!$filenameRes['status']) {
        $response = array('status' => false, 'msg' => $filenameRes['result']);
        echo json_encode($response);
        exit();
    }

    $checkMainCalOld = $calendar_model->getMainCalendarEnabled();

    if (count($checkMainCalOld) > 0) {
        for ($i = 0; $i < count($checkMainCalOld); $i++) {
            $calendar_model->updateEnabledMainCalendar($checkMainCalOld[$i]->m_calendar_id);
        }
    }

    $array_data = [
        'm_calendar_name' => $_POST['main_calendar_name'],
        'm_calendar_file' => $filenameRes['result'],
        'time' => $_POST['time'],
        'term' => $_POST['term'],
        'year' => $_POST['year'],
        'user_create' => $_SESSION['user_data']->id
    ];

    $result = $calendar_model->InsertMainCalendar($array_data);
    if ($result) {
        $mainCalendarEnabled = $calendar_model->getMainCalendarEnabled();
        $_SESSION['main_calendar'] = $mainCalendarEnabled[0];
        $response = array('status' => true, 'msg' => 'บันทึกปฎิทินการพบกลุ่มสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['getDataMainCalendar'])) {
    $calendar_model = new Calendar_New_Model($DB);
    $result = $calendar_model->getMainCalendar();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['delete_main_calendar'])) {
    try {
        $response = array();
        $calendar_model = new Calendar_New_Model($DB);
        $id = $_POST['id'];
        $result = $calendar_model->deleteMainCalender($id);
        $response = ['status' => true, 'data' => $result];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_POST['editMainCalendar'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();
    $calendar_model = new Calendar_New_Model($DB);
    $array_data = [];
    $m_calendar_id = $_POST['main_calendar_id'];
    $main_calendar_file_old = $_POST['main_calendar_file_old'];
    if (count($_FILES) != 0) {
        $file = $_FILES['file'];
        $uploadDir = '../uploads/calendar/';
        $filenameRes = $mainFunc->UploadFile($file, $uploadDir);
        if (!$filenameRes['status']) {
            $response = array('status' => false, 'msg' => $filenameRes['result']);
            echo json_encode($response);
            exit();
        }
        unlink($uploadDir . $main_calendar_file_old);
        $main_calendar_file_old = $filenameRes['result'];
    }

    $array_data = [
        'm_calendar_name' => $_POST['main_calendar_name'],
        'm_calendar_file' => $main_calendar_file_old,
        'time' => $_POST['time'],
        'term' => $_POST['term'],
        'year' => $_POST['year'],
        'm_calendar_id' => $m_calendar_id
    ];
    $result = $calendar_model->EditMainCalendar($array_data);
    if ($result) {
        $response = array('status' => true, 'msg' => 'แก้ไขปฎิทินการพบกลุ่มสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['signInClass'])) {
    $response = "";
    $calendar_model = new Calendar_New_Model($DB);
    $std_id = $_POST['std_id'];
    $calendar_id = $_POST['calendar_id'];
    $count = $calendar_model->checksignInClass($std_id, $calendar_id);
    if ($count[0]->c_std_sign_in == 0) {
        $result = $calendar_model->signInClass($std_id, $calendar_id);
        if ($result) {
            $response = array('status' => true, 'msg' => 'เช็คชื่อสำเร็จ');
        } else {
            $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
        }
    } else {
        $response = array('status' => true, 'msg' => 'เคยเช็คแล้ว');
    }

    echo json_encode($response);
}


if (isset($_POST['getDataStdSignInClass'])) {
    $response = "";
    $calendar_model = new Calendar_New_Model($DB);
    $calendar_id = $_POST['calendar_id'];
    $result = $calendar_model->getDataStdSignInClass($calendar_id);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['updateSharePlane'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();
    $calendar_model = new Calendar_New_Model($DB);


    $uploadDir = '../uploads/share_plane/';

    $array_data = [
        'sh_subject_code' => $_POST['subject_code'],
        'sh_subject_name' => $_POST['subject_name'],
        'sh_cate' => $_POST['cate'],
        'sh_class' => $_POST['std_class'],
        'year' => $_POST['year'],
        'user_create' => $_SESSION['user_data']->id
    ];

    if (count($_FILES) > 0) {
        $plan_file = $_FILES['sh_plan_file'];
        $filenameResPlan_file = $mainFunc->UploadFile($plan_file, $uploadDir);
        if (!$filenameResPlan_file['status']) {
            $response = array('status' => false, 'msg' => $filenameResPlan_file['result']);
            echo json_encode($response);
            exit();
        }
        $array_data['sh_plan_file'] = $filenameResPlan_file['result'];
        $array_data['sh_plan_file_name'] = $plan_file['name'];
        if (!empty($_POST['sh_plan_file_old'])) {
            unlink($uploadDir . $_POST['sh_plan_file_old']);
        }
    }

    $mode = "INSERT";
    if (!empty($_POST['sh_plan_id'])) {
        $array_data['sh_plan_id'] =  $_POST['sh_plan_id'];
        $mode = "UPDATE";
    }

    $result = $calendar_model->InsertSharePlane($array_data, $mode);
    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? !empty($_POST['sh_plan_id']) ? 'แก้ไข' . 'แผนการสอนสำเร็จ' : 'บันทึก' . 'แผนการสอนสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}

if (isset($_REQUEST['getSharePlane'])) {
    $response = array();
    $calendar_model = new Calendar_New_Model($DB);
    $result_event = $calendar_model->getSharePlane();
    $response = ['rows' => $result_event[2], "total" => (int)$result_event[0], "totalNotFiltered" => (int)$result_event[1]];
    echo json_encode($response);
}

if (isset($_POST['deleteSharePlan'])) {
    $response = array();
    $calendar_model = new Calendar_New_Model($DB);
    $sh_plan_id = $_POST['sh_plan_id'];
    $result = $calendar_model->deleteSharePlan($sh_plan_id);

    $uploadDir = '../uploads/share_plane/';
    $sh_plan_file = $_POST['sh_plan_file'];

    if ($result) {
        unlink($uploadDir . $sh_plan_file);
    }
    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? 'ลบข้อมูลแผนการสอนสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}

if (isset($_POST['downloadUpdate'])) {
    $response = array();
    $calendar_model = new Calendar_New_Model($DB);
    $sh_plan_id = $_POST['sh_plan_id'];
    $result = $calendar_model->downloadUpdate($sh_plan_id);
    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? 'ดาวน์โหลดสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}

if (isset($_POST['removeWork'])) {
    $response = array();

    $work_id = $_POST['work_id'];
    $work_name = $_POST['work_name'];

    $uploadDir = '../uploads/work_new/';

    $table = "cl_work_new";
    if ($_SESSION['user_data']->role_id != 3) {
        $table = "cl_work_new_am";
    }

    $sql = "DELETE FROM $table WHERE work_id = :work_id";
    $DB->Query($sql, ["work_id" => $work_id]);

    unlink($uploadDir . $work_name);

    $response = array(
        'status' => true,
        'msg' => 'ลบใบงานสำเร็จ'
    );
    echo json_encode($response);
}


if (isset($_POST['save_score'])) {
    $response = "";
    $calendar_model = new Calendar_New_Model($DB);
    $score = json_decode($_POST['score_arr']);
    $std_id = json_decode($_POST['std_id']);
    $mode = $_POST['mode'];

    $result = "";
    for ($i = 0; $i < count($score); $i++) {
        $array_data = [
            'calendar_id' => $_POST['calendar_id'],
            'score' => $score[$i],
            'user_create' => $_SESSION['user_data']->id,
            'std_id' => $std_id[$i]
        ];
        $result = $calendar_model->insertScore($array_data, $mode);
    }

    if ($result) {
        $response = array('status' => true, 'msg' => 'บันทึกคะแนนเก็บสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['changeStatusActive'])) {
    $calenda_id = $_POST['calendar_id'];
    $status = $_POST['status'];

    $sql = "UPDATE cl_calendar_new SET status_active = :status_active WHERE calendar_id = :calendar_id";
    $data = $DB->Update($sql, ["status_active" => $status, "calendar_id" => $calenda_id]);
    if ($data) {
        $response = array('status' => true, 'msg' => 'สำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['getDataStdSignInSum'])) {
    $response = "";
    $calendar_model = new Calendar_New_Model($DB);
    $std_class = $_POST['std_class'];

    $user_id = $_SESSION['user_data']->id;
    if ($_SESSION['user_data']->role_id == 2 || $_SESSION['user_data']->role_id == 6) {
        $user_id = $_POST['user_id'];
    }

    $term = $_POST['term'];

    $sqlStd = "SELECT std_id,std_code,std_prename,std_name FROM tb_students std WHERE user_create = :user_create and std_class = :std_class";
    $dataStd = $DB->Query($sqlStd, ["user_create" => $user_id, "std_class" => $std_class]);
    $dataStd = json_decode($dataStd);

    foreach ($dataStd as &$std) {
        $arrParam = ["std_id" => $std->std_id, "user_create" => $user_id, "std_class" => $std_class, "term" => $term];
        $sqlSignIn = "SELECT
                        (
                        SELECT
                            csitcn.type_sign_in
                        FROM
                            cl_sign_in_to_class_new csitcn
                        WHERE
                            ccn.calendar_id = csitcn.calendar_id
                            AND csitcn.std_id = :std_id ) type_sign_in
                    FROM
                        cl_calendar_new ccn
                    LEFT JOIN cl_main_calendar cmc ON ccn.m_calendar_id = cmc.m_calendar_id
                    WHERE
                        ccn.user_create = :user_create
                        AND ccn.std_class = :std_class AND CONCAT(cmc.term, '/', cmc.year) = :term
                    ORDER BY ccn.time_step ASC";
        $dataSignIn = $DB->Query($sqlSignIn, $arrParam);
        $dataSignIn = json_decode($dataSignIn);
        $objSignIn = [];
        for ($i = 0; $i < count($dataSignIn); $i++) {
            $typeSignIn = 0;
            if (!empty($dataSignIn[$i]->type_sign_in)) {
                $typeSignIn = ($dataSignIn[$i]->type_sign_in == 1 || $dataSignIn[$i]->type_sign_in == 2)  ? 1 : 3;
            }
            $objSignIn[$i] = $typeSignIn;
        }

        $std->sign_in = $objSignIn;
    }

    $response = array('status' => true, 'data' => $dataStd);
    echo json_encode($response);
}


if (isset($_POST['clear_calendar'])) {
    try {
        $response = array();

        $calendar_model = new Calendar_New_Model($DB);
        $mainFunc = new ClassMainFunctions();

        $id = $_POST['id'];
        $l_old_id = $_POST['l_old_id'];
        //  $user_id = $_SESSION['user_data']->id;

        $uploadDir_learn_image = '../uploads/images_learn/';

        $file_delete_image = $calendar_model->getImageLearning($l_old_id);

        // $result = $calendar_model->deleteCalender($id);

        $sql = "DELETE FROM cl_learning_saved WHERE calendar_id = :calendar_id";
        $data = $DB->Delete($sql, ["calendar_id" => $id]);

        if ($data) {
            if (count($file_delete_image) > 0) {
                if (!empty($file_delete_image[0]->img_name_1) && file_exists($uploadDir_learn_image . $file_delete_image[0]->img_name_1)) {
                    unlink($uploadDir_learn_image . $file_delete_image[0]->img_name_1);
                }
                if (!empty($file_delete_image[0]->img_name_2) && file_exists($uploadDir_learn_image . $file_delete_image[0]->img_name_2)) {
                    unlink($uploadDir_learn_image . $file_delete_image[0]->img_name_2);
                }
                if (!empty($file_delete_image[0]->img_name_3) && file_exists($uploadDir_learn_image . $file_delete_image[0]->img_name_3)) {
                    unlink($uploadDir_learn_image . $file_delete_image[0]->img_name_3);
                }
                if (!empty($file_delete_image[0]->img_name_4) && file_exists($uploadDir_learn_image . $file_delete_image[0]->img_name_4)) {
                    unlink($uploadDir_learn_image . $file_delete_image[0]->img_name_4);
                }
            }
        }

        $sql = "DELETE FROM cl_learning_images WHERE learning_id = :learning_id";
        $data = $DB->Delete($sql, ["learning_id" => $l_old_id]);

        $sql = "DELETE FROM cl_learning_reason WHERE learning_id = :learning_id";
        $data = $DB->Delete($sql, ["learning_id" => $l_old_id]);

        $sql = "DELETE FROM cl_sign_in_to_class_new WHERE calendar_id = :calendar_id";
        $data = $DB->Delete($sql, ["calendar_id" => $id]);

        $response = ['status' => true, 'msg' => "เคลียร์ข้อมูลสำเร็จ"];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}


if ($_POST['insertSelectPlan']) {
    $response = array();

    $dataCalendarFromAmSql = "SELECT * FROM cl_calendar_new_am WHERE calendar_id IN (" . implode(",", $_POST['calendarIdArr']) . ")";
    $dataCalendarFromAm = $DB->Query($dataCalendarFromAmSql, []);
    $dataCalendarFromAms = json_decode($dataCalendarFromAm, true);

    foreach ($dataCalendarFromAms as $key => $dataCalendarFromAm) {
        $array_data = [
            "m_calendar_id" => $_SESSION['main_calendar'][$_POST['std_class']]->m_calendar_id,
            "plan_name" => $dataCalendarFromAm['plan_name'],
            "content_link" => $dataCalendarFromAm['content_link'],
            "content_file" => $dataCalendarFromAm['content_file'],
            "test_before_link" => $dataCalendarFromAm['test_before_link'],
            "test_after_link" => $dataCalendarFromAm['test_after_link'],
            "std_class" => $dataCalendarFromAm['std_class'],
            "user_create" => $_SESSION['user_data']->id,
            "time_step" => $dataCalendarFromAm['time_step'],
            "work_sheet" => $dataCalendarFromAm['work_sheet'],
            "plan_file" => $dataCalendarFromAm['plan_file'],
            "from_calendar_am" => $dataCalendarFromAm['calendar_id']
        ];

        $calendar_model = new Calendar_New_Model($DB);
        $mainFunc = new ClassMainFunctions();


        $result = $calendar_model->InsertCalendar($array_data);
        if ($result > 0) {

            $dataWorkAmSql = "SELECT * FROM cl_work_new_am WHERE calendar_id = :calendar_id)";
            $dataWorkAm = $DB->Query($dataWorkAmSql, ["calendar_id" =>  $dataCalendarFromAm['calendar_id']]);
            $dataWorkAms = json_decode($dataWorkAm, true);

            if (count($dataWorkAms) > 0) {

                $calenda_id = $dataCalendarFromAm['calendar_id'];

                if (isset($_FILES['work_file']) && count($_FILES['work_file']) > 0) {
                    $result = addWork($_FILES['work_file'], $mainFunc, $calenda_id, $calendar_model);
                }

                $response = array(
                    'status' => $result ? true : false,
                    'msg' => $result ? 'บันทึกการพบกลุ่มสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
                );
            } else {
                $response = array('status' => true, 'msg' => 'บันทึกการพบกลุ่มสำเร็จ');
            }
        } else {
            $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
        }
    }

    echo json_encode($response);
}

if (isset($_POST['deletePlanCalendar'])) {
    try {
        $response = array();

        $calendar_model = new Calendar_New_Model($DB);
        $mainFunc = new ClassMainFunctions();

        $calendar_id = $_POST['calendar_id'];

        if ($_SESSION['user_data']->role_id != 3) {
            $sql = "SELECT * FROM cl_calendar_new WHERE from_calendar_am = :from_calendar_am";
            $data = $DB->Query($sql, ["from_calendar_am" => $calendar_id]);
            $data = json_decode($data);
            if (count($data) > 0) {
                $response = array('status' => false, 'msg' => "การพบกลุ่มนี้มีครูเลือกไปใช้งานแล้ว\nไม่สามารถแก้ไขหรือลบได้");
                echo json_encode($response);
                exit();
            }
        }


        $uploadDir = '../uploads/edu_plan_new/';
        $uploadDirWorkNew = '../uploads/work_new/';

        $sql = "SELECT * FROM cl_calendar_new_am WHERE calendar_id = :calendar_id";
        $data = $DB->Query($sql, ["calendar_id" => $calendar_id]);
        $data = json_decode($data, true);
        $data = $data[0];

        $result = $calendar_model->deleteCalender($calendar_id);

        if ($result) {
            if (!empty($data['content_file'])) {
                if (file_exists($uploadDir . $data['content_file'])) {
                    unlink($uploadDir . $data['content_file']);
                }
            }

            $file_delete = $calendar_model->getFileWork($calendar_id);
            for ($i = 0; $i < count($file_delete); $i++) {
                if (file_exists($uploadDirWorkNew . $file_delete[$i]->file_name)) {
                    unlink($uploadDirWorkNew . $file_delete[$i]->file_name);
                }
            }
        }

        $response = ['status' => true, 'msg' => ""];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}
