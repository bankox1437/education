<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include "../models/calendar_model.php";

$DB = new Class_Database();

if (isset($_POST['insertCalendar'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();
    $calendar_model = new Calendar_Model($DB);

    $plan_file = $_FILES['plan_file'];
    $uploadDir = '../uploads/edu_plan/';

    $filenameResPlan_file = $mainFunc->UploadFile($plan_file, $uploadDir);
    if (!$filenameResPlan_file['status']) {
        $response = array('status' => false, 'msg' => $filenameResPlan_file['result']);
        echo json_encode($response);
        exit();
    }

    $array_data = [
        'm_calendar_id' => $_SESSION['main_calendar']->m_calendar_id,
        'std_class' => $_POST['std_class'],
        'plan_name' => $_POST['plan_name'],
        'plan_file' => $filenameResPlan_file['result'],
        'link' => $_POST['link'],
        'link2' => $_POST['link2'],
        'link3' => $_POST['link3'],
        'link4' => $_POST['link4'],
        'time_step' => $_POST['time_step'],
        'user_create' => $_SESSION['user_data']->id
    ];

    $result = $calendar_model->InsertCalendar($array_data);
    if ($result > 0) {
        $calenda_id = $result;

        if (isset($_FILES['work_file']) && count($_FILES['work_file']) > 0) {
            $result = addWork($_FILES['work_file'], $mainFunc, $calenda_id, $calendar_model);
        }

        if (isset($_FILES['other_file']) && count($_FILES['other_file']) > 0) {
            $result = addOther($_FILES['other_file'], $mainFunc, $calenda_id, $calendar_model);
        }

        $response = array(
            'status' => $result ? true : false,
            'msg' => $result ? 'บันทึกปฎิทินการพบกลุ่มสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
        );
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['editCalendar'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();
    $calendar_model = new Calendar_Model($DB);
    $array_data = [];
    $calendar_id = $_POST['calendar_id'];
    $plan_file_old = $_POST['plan_file_old'];

    if (isset($_FILES['plan_file']) && count($_FILES['plan_file']) != 0) {
        $plan_file = $_FILES['plan_file'];
        $uploadDir = '../uploads/edu_plan/';
        unlink($uploadDir . $plan_file_old);
        $filenameResPlan_file = $mainFunc->UploadFile($plan_file, $uploadDir);
        if (!$filenameResPlan_file['status']) {
            $response = array('status' => false, 'msg' => $filenameResPlan_file['result']);
            echo json_encode($response);
            exit();
        }
        $plan_file_old = $filenameResPlan_file['result'];
    }

    $array_data = [
        'plan_name' => $_POST['plan_name'],
        'std_class' => $_POST['std_class'],
        'plan_file' => $plan_file_old,
        'link' => $_POST['link'],
        'link2' => $_POST['link2'],
        'link3' => $_POST['link3'],
        'link4' => $_POST['link4'],
        'time_step' => $_POST['time_step'],
        'calendar_id' => $_POST['calendar_id']
    ];
    $result = $calendar_model->EditCalendar($array_data);
    if ($result) {
        if (isset($_FILES['work_file_old']) && count($_FILES['work_file_old']) > 0) {
            $work_id = $_POST['work_id'];
            $fileName_old = $_POST['fileName_old'];
            $result = addWork($_FILES['work_file_old'], $mainFunc, $calendar_id, $calendar_model, 2, $work_id, $fileName_old);
        }

        if (isset($_FILES['other_file_old']) && count($_FILES['other_file_old']) > 0) {
            $other_id = $_POST['other_id'];
            $other_fileName_old = $_POST['other_fileName_old'];
            $result = addOther($_FILES['other_file_old'], $mainFunc, $calendar_id, $calendar_model, 2, $other_id, $other_fileName_old);
        }

        if (isset($_FILES['work_file']) && count($_FILES['work_file']) > 0) {
            $result = addWork($_FILES['work_file'], $mainFunc, $calendar_id, $calendar_model);
        }

        if (isset($_FILES['other_file']) && count($_FILES['other_file']) > 0) {
            $result = addOther($_FILES['other_file'], $mainFunc, $calendar_id, $calendar_model);
        }

        $response = array(
            'status' => $result ? true : false,
            'msg' => $result ? 'แก้ไขปฎิทินการพบกลุ่มสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
        );
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

function addWork($file, $mainFunc, $calenda_id, $calendar_model, $mode = 1, $work_id = [], $work_file_old = [])
{
    $result = 0;
    $uploadDir = '../uploads/work/';
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
        $calendar_model = new Calendar_Model($DB);
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

if (isset($_POST['getDatacalendarByTerm'])) {
    $calendar_model = new Calendar_Model($DB);
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
    $calendar_model = new Calendar_Model($DB);
    $result = $calendar_model->getDataCalendarOther();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['delete_calendar'])) {
    try {
        $response = array();
        $calendar_model = new Calendar_Model($DB);
        $id = $_POST['id'];
        $file = $_POST['file'];
        $l_id = $_POST['l_id'];
        $l_old_id = $_POST['l_old_id'];
        //  $user_id = $_SESSION['user_data']->id;

        $uploadDir = '../uploads/work/';
        $uploadDir_other = '../uploads/other_file/';
        $uploadDir_learn_image = '../uploads/images_learn/';
        $uploadDir_learn_pdf = '../uploads/learning_pdf/';

        $file_delete = $calendar_model->getFileWork($id);
        $file_delete_other = $calendar_model->getFileOther($id);
        $file_delete_image = $calendar_model->getImageLearning($l_old_id);
        $file_delete_pdf = $calendar_model->getPDFLearning($l_id);

        $result = $calendar_model->deleteCalender($id);
        if ($result) {
            unlink("../uploads/edu_plan/" . $file);
            for ($i = 0; $i < count($file_delete); $i++) {
                unlink($uploadDir . $file_delete[$i]->file_name);
            }
            for ($i = 0; $i < count($file_delete_other); $i++) {
                unlink($uploadDir_other . $file_delete_other[$i]->file_name);
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
    $calendar_model = new Calendar_Model($DB);
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
    $calendar_model = new Calendar_Model($DB);

    $file = $_FILES['main_calendar_file'];
    $uploadDir = '../uploads/calendar/';

    $filenameRes = $mainFunc->UploadFile($file, $uploadDir);
    if (!$filenameRes['status']) {
        $response = array('status' => false, 'msg' => $filenameRes['result']);
        echo json_encode($response);
        exit();
    }

    $array_data = [
        'm_calendar_name' => $_POST['main_calendar_name'],
        'm_calendar_file' => $filenameRes['result'],
        'time' => $_POST['time'],
        'term' => $_POST['term'],
        'year' => $_POST['year'],
        'std_class' => $_POST['std_class'],
        'user_create' => $_SESSION['user_data']->id
    ];

    $result = $calendar_model->InsertMainCalendar($array_data);
    if ($result != 0) {
        $m_calendar_id = $result;

        // $checkMainCalOld = $calendar_model->getMainCalendarStdClass($_POST['std_class']);

        // if (count($checkMainCalOld) > 0) {
        //     foreach ($checkMainCalOld as $key => $mainCal) {
        //         if ($mainCal->term == $_POST['term'] && $mainCal->year == $_POST['year']) {
        //             $calendar_model->updateEnabledMainCalendarNotIn($m_calendar_id, 0, $_POST['std_class']);
        //         }
        //     }
        // }

        $mainCalendarEnabled = $calendar_model->getMainCalendarById($m_calendar_id);
        $_SESSION['main_calendar'][$_POST['std_class']] = $mainCalendarEnabled[0];
        $response = array('status' => true, 'msg' => 'บันทึกปฎิทินการพบกลุ่มสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['getDataMainCalendar'])) {
    $calendar_model = new Calendar_Model($DB);
    $result = $calendar_model->getMainCalendar();
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['delete_main_calendar'])) {
    try {
        $response = array();
        $calendar_model = new Calendar_Model($DB);
        $id = $_POST['id'];
        $result = $calendar_model->deleteMainCalender($id);

        if ($result) {
            if ($_SESSION['main_calendar'][$_POST['std_class']]->m_calendar_id == $id) {
                unset($_SESSION['main_calendar'][$_POST['std_class']]);
            }
        }

        $response = ['status' => true, 'data' => $result];
        echo json_encode($response);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_POST['editMainCalendar'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();
    $calendar_model = new Calendar_Model($DB);
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

    // $checkMainCalOld = $calendar_model->getMainCalendarEnabled($_POST['std_class'], $_POST['term'], $_POST['year']);

    // if (count($checkMainCalOld) > 0) {
    //     $calendar_model->updateEnabledMainCalendarNotIn($m_calendar_id, 0, $_POST['std_class']);
    // }

    $calendar_model->updateEnabledMainCalendar($m_calendar_id, 1);

    $array_data = [
        'm_calendar_name' => $_POST['main_calendar_name'],
        'm_calendar_file' => $main_calendar_file_old,
        'time' => $_POST['time'],
        'term' => $_POST['term'],
        'year' => $_POST['year'],
        'std_class' => $_POST['std_class'],
        'm_calendar_id' => $m_calendar_id
    ];
    $result = $calendar_model->EditMainCalendar($array_data);
    if ($result) {
        $mainCalendarEnabled = $calendar_model->getMainCalendarEnabledAll();
        if (count($mainCalendarEnabled) > 0) {
            $newMainCalendar = array();
            foreach ($mainCalendarEnabled as $key => $value) {
                $newMainCalendar[$value->std_class] = $value;
            }
            $_SESSION['main_calendar'] = $newMainCalendar;
        }
        $response = array('status' => true, 'msg' => 'แก้ไขปฎิทินการพบกลุ่มสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }
    echo json_encode($response);
}

if (isset($_POST['signInClass'])) {
    $response = "";
    $calendar_model = new Calendar_Model($DB);
    $std_id = $_POST['std_id'];
    $calendar_id = $_POST['calendar_id'];

    $table = "cl_sign_in_to_class";
    if (isset($_POST['new'])) {
        $table = "cl_sign_in_to_class_new";
    }
    $count = $calendar_model->checksignInClass($std_id, $calendar_id, $table);
    if ($count[0]->c_std_sign_in == 0) {
        $result = $calendar_model->signInClass($std_id, $calendar_id, $table);
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
    $calendar_model = new Calendar_Model($DB);
    $calendar_id = $_POST['calendar_id'];
    $table = "cl_sign_in_to_class";
    $tableCalendar = "cl_calendar";
    if (isset($_POST['new'])) {
        $table = "cl_sign_in_to_class_new";
        $tableCalendar = "cl_calendar_new";
    }
    $result = $calendar_model->getDataStdSignInClass($calendar_id, $table, $tableCalendar);
    $response = array('status' => true, 'data' => $result);
    echo json_encode($response);
}

if (isset($_POST['updateSharePlane'])) {
    $response = "";
    $mainFunc = new ClassMainFunctions();
    $calendar_model = new Calendar_Model($DB);


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
    $calendar_model = new Calendar_Model($DB);
    $result_event = $calendar_model->getSharePlane();
    $response = ['rows' => $result_event[2], "total" => (int)$result_event[0], "totalNotFiltered" => (int)$result_event[1]];
    echo json_encode($response);
}

if (isset($_POST['deleteSharePlan'])) {
    $response = array();
    $calendar_model = new Calendar_Model($DB);
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
    $calendar_model = new Calendar_Model($DB);
    $sh_plan_id = $_POST['sh_plan_id'];
    $result = $calendar_model->downloadUpdate($sh_plan_id);
    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? 'ดาวน์โหลดสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}

if (isset($_POST['viewsUpdate'])) {
    $response = array();
    $calendar_model = new Calendar_Model($DB);
    $sh_plan_id = $_POST['sh_plan_id'];
    $result = $calendar_model->viewUpdate($sh_plan_id);
    $response = array(
        'status' => $result ? true : false,
        'msg' => $result ? 'เข้าชมสำเร็จ' : 'เกิดข้อผิดพลาด ลองใหม่'
    );
    echo json_encode($response);
}

if (isset($_POST['onsiteSignIn'])) {
    $response = array();
    $calendar_model = new Calendar_Model($DB);
    $calendar_id = $_POST['calendar_id'];
    $std_id = $_POST['std_id'];
    $type = $_POST['type'];
    $checked = $_POST['checked'];

    $table = "cl_sign_in_to_class";
    if (isset($_POST['new'])) {
        $table = "cl_sign_in_to_class_new";
    }
    $count = $calendar_model->checksignInClass($std_id, $calendar_id, $table);
    if ($count[0]->c_std_sign_in == 0) {
        $result = $calendar_model->signInClass($std_id, $calendar_id, $table, $type);
    } else {
        if ($checked == 'false') {
            $result = $calendar_model->deleteSignInClass($count[0]->sing_in_id, $table);
        } else {
            $result = $calendar_model->updateSignInClass($std_id, $calendar_id, $table, $type);
        }
    }

    if ($result) {
        $response = array('status' => true, 'msg' => 'เช็คชื่อสำเร็จ');
    } else {
        $response = array('status' => false, 'msg' => 'เกิดข้อผิดพลาด ลองใหม่');
    }

    echo json_encode($response);
}

if (isset($_POST['updateCalendarNew'])) {

    $calendarId = $_POST["calendarId"];
    $m_calendarId = $_POST["m_calendarId"];

    $sql = "UPDATE cl_calendar_new 
        SET m_calendar_id = :m_calendar_id
        WHERE calendar_id = :calendar_id";

    $update = $DB->Update($sql, [
        "m_calendar_id" => $m_calendarId,
        "calendar_id" => $calendarId
    ]);


    if ($update) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Update failed"]);
    }
}

if (isset($_POST['updateStatusMainCalendar'])) {

    $status = $_POST["status"];
    $m_calendarId = $_POST["m_calendarId"];

    $sql = "UPDATE cl_main_calendar 
        SET enabled = :status
        WHERE m_calendarId = :m_calendarId";

    $update = $DB->Update($sql, [
        "status" => $status,
        "m_calendarId" => $m_calendarId
    ]);


    if ($update) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Update failed"]);
    }
}
