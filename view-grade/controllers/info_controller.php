<?php
session_start();
include "../../config/class_database.php";
include "../../config/main_function.php";
include '../models/users_model.php';

$DB = new Class_Database();

function thaiToGregorian($thaiDate)
{
    // Split the Thai date into day, month, and year
    list($day, $month, $year) = explode('-', $thaiDate);

    // Convert the Thai year to Gregorian year by subtracting 543
    $gregorianYear = $year - 543;

    // Return the date in 'YYYY-MM-DD' format
    return sprintf('%04d-%02d-%02d', $gregorianYear, $month, $day);
}

if (isset($_POST['insertRoyal'])) {
    $data = 0;
    if (empty($_POST['royal_id'])) {
        $sql = "INSERT INTO info_royal(royal_name,royal_get,user_create) VALUES (:royal_name,:royal_get,:user_create)";
        $data = $DB->Insert($sql, [
            "royal_name" => $_POST['royal_name'],
            "royal_get" => $_POST['get_royal'],
            "user_create" => $_SESSION['user_data']->id
        ]);
    } else {
        $sql = "UPDATE info_royal SET royal_name = :royal_name,royal_get = :royal_get WHERE royal_id = :royal_id";
        $data = $DB->Update($sql, [
            "royal_name" => $_POST['royal_name'],
            "royal_get" => $_POST['get_royal'],
            "royal_id" => $_POST['royal_id']
        ]);
    }
    echo $data;
}

if (isset($_GET['getRoyal'])) {
    $sql_order = "SELECT count(*) totalnotfilter FROM info_royal r";
    $totalnotfilter = $DB->Query($sql_order, []);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
    //จบการนับจำนวนทั้งหมด

    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM info_royal r WHERE r.user_create = :user_create " . " ORDER BY r.royal_get DESC";
    $total_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter];
    echo json_encode($response);
}

if (isset($_POST['deleteRoyal'])) {
    $data = 0;
    $sql = "DELETE FROM info_royal WHERE royal_id = :royal_id";
    $data = $DB->Delete($sql, ["royal_id" => $_POST['royal_id']]);
    echo $data;
}

// ------------------------training---------------------------------------- 
if (isset($_POST['update_training'])) {

    $mainFunc = new ClassMainFunctions();
    $data = 0;

    $training_id = $_POST['training_id'];
    $training_diploma_file_old = $_POST['training_diploma_file_old'];

    $uploadDir = '../uploads/info/training/';

    $file_new = $training_diploma_file_old;

    if (count($_FILES) != 0) {
        $training_diploma_file = $_FILES['training_diploma_file'];
        $fileNameRes = "";
        $fileNameRes = $mainFunc->UploadFile($training_diploma_file, $uploadDir);
        if (!$fileNameRes['status']) {
            $response = array('status' => false, 'msg' => $fileNameRes['result']);
            echo json_encode($response);
            exit();
        }
        if (!empty($training_id) && !empty($training_diploma_file_old)) {
            unlink($uploadDir . $training_diploma_file_old);
        }
        $file_new =  $fileNameRes['result'];
    }

    $location = "-";
    if ($_POST['training_type'] == 1) {
        $location = $_POST['training_location'];
    }

    if (empty($training_id)) {
        $sql = "INSERT INTO info_training \n" .
            "( training_type,training_name, training_agency, training_location,training_diploma_file, training_date, user_create )\n" .
            "VALUES\n" .
            "	(:training_type,:training_name, :training_agency, :training_location, :training_diploma_file, :training_date, :user_create)";
        $data = $DB->Insert($sql, [
            "training_type" => $_POST['training_type'],
            "training_name" => $_POST['training_name'],
            "training_agency" => $_POST['training_agency'],
            "training_location" => $location,
            "training_diploma_file" =>  $file_new,
            "training_date" => $_POST['training_date'],
            "user_create" => $_SESSION['user_data']->id
        ]);
    } else {
        $sql = "UPDATE info_training SET 
                training_type = :training_type, training_name = :training_name, training_agency = :training_agency, 
                training_location = :training_location,training_diploma_file = :training_diploma_file, training_date = :training_date 
                WHERE training_id = :training_id";
        $data = $DB->Update($sql, [
            "training_type" => $_POST['training_type'],
            "training_name" => $_POST['training_name'],
            "training_agency" => $_POST['training_agency'],
            "training_location" => $location,
            "training_diploma_file" =>  $file_new,
            "training_date" => $_POST['training_date'],
            "training_id" => $training_id,
        ]);
    }
    echo $data;
}

if (isset($_GET['getTrainingData'])) {

    $sql_order = "SELECT count(*) totalnotfilter FROM info_training t";
    $totalnotfilter = $DB->Query($sql_order, []);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
    //จบการนับจำนวนทั้งหมด

    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM info_training t WHERE t.user_create = :user_create ";
    $total_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter];
    echo json_encode($response);
}

if (isset($_POST['update_info'])) {
    $data = 0;

    $mainFunc = new ClassMainFunctions();
    $userModel = new User_Model($DB);

    if (empty($_POST['info_id'])) {
        $sql = "INSERT INTO info (user_id, birthday, age, scout_rank, start_work, end_work, gender,class_royal,date_get_royal,sum_get_royal,age_work,phone )\n" .
            "VALUES\n" .
            "	( :user_id, :birthday, :age, :scout_rank, :start_work, :end_work, :gender, :class_royal, :date_get_royal, :sum_get_royal, :age_work,:phone );";
        $arr_data = [
            "user_id" => $_SESSION['user_data']->id,
            "birthday" => $_POST['birthday'],
            "age" => $_POST['age'],
            "scout_rank" => $_POST['scout_rank'],
            "start_work" => $_POST['start_work'],
            "end_work" => null,
            "gender" => isset($_POST['gender']) ? $_POST['gender'] : '',
            "class_royal" => $_POST['class_royal'],
            "date_get_royal" => $_POST['date_get_royal'],
            "sum_get_royal" => $_POST['sum_get_royal'],
            "age_work" => $_POST['age_work'],
            "phone" => $mainFunc->encryptData($_POST['phone'])
        ];
        if (!empty($_POST['retire_work']) && !empty($_POST['age'])) {
            $arr_data["end_work"] = thaiToGregorian($_POST['retire_work']);
        }
        $data = $DB->Insert($sql, $arr_data);
    } else {
        $sql = "UPDATE info \n" .
            "SET user_id = :user_id,\n" .
            "birthday = :birthday,\n" .
            "age = :age,\n" .
            "scout_rank = :scout_rank,\n" .
            "start_work = :start_work,\n" .
            "end_work = :end_work,\n" .
            "gender = :gender, \n" .
            "class_royal = :class_royal, \n" .
            "date_get_royal = :date_get_royal, \n" .
            "sum_get_royal= :sum_get_royal, \n" .
            "phone= :phone, \n" .
            "age_work= :age_work \n" .
            "WHERE\n" .
            "	info_id = :info_id;";
        $arr_data = [
            "user_id" => $_SESSION['user_data']->id,
            "birthday" => $_POST['birthday'],
            "age" => $_POST['age'],
            "scout_rank" => $_POST['scout_rank'],
            "start_work" => $_POST['start_work'],
            "end_work" => null,
            "gender" => isset($_POST['gender']) ? $_POST['gender'] : '',
            "class_royal" => $_POST['class_royal'],
            "date_get_royal" => $_POST['date_get_royal'],
            "sum_get_royal" => $_POST['sum_get_royal'],
            "phone" => $mainFunc->encryptData($_POST['phone']),
            "age_work" => $_POST['age_work'],
            "info_id" => $_POST['info_id']
        ];

        if (!empty($_POST['retire_work']) && !empty($_POST['age'])) {
            $arr_data["end_work"] = thaiToGregorian($_POST['retire_work']);
        }
        $data = $DB->Update($sql, $arr_data);
    }

    // $name = htmlentities($_POST['name']);
    // $surname = htmlentities($_POST['surname']);
    // $password = htmlentities($_POST['password']);

    // if (empty($password)) {
    //     $password = $_POST['password_old'];
    // } else {
    //     $password = $main_func->encryptData($password);
    // }

    // $edit_date = date('Y-m-d H:i:s');
    // $array_data = [
    //     "name" => $name,
    //     "surname" => $surname,
    //     "password" => $password,
    //     "edit_date" =>  $edit_date,
    //     "user_update" => $_SESSION['user_data']->id,
    //     "id" => $_SESSION['user_data']->id
    // ];
    // $resultUpdate = $userModel->editProfile($array_data);
    // if ($resultUpdate == 1) {
    //     $_SESSION['user_data']->name = $name;
    //     $_SESSION['user_data']->surname = $surname;
    // }

    echo $data;
}

if (isset($_POST['deleteTraining'])) {
    $data = 0;
    $sql = "DELETE FROM info_training WHERE training_id = :training_id";
    $data = $DB->Delete($sql, ["training_id" => $_POST['training_id']]);
    if ($data == 1) {
        $uploadDir = '../uploads/info/training/';
        if (!empty($_POST['training_diploma_file_old'])) {
            unlink($uploadDir . $_POST['training_diploma_file_old']);
        }
    }
    echo $data;
}

if (isset($_POST['update_training_scout'])) {

    $mainFunc = new ClassMainFunctions();
    $data = 0;

    $training_id = $_POST['training_id'];
    $training_diploma_file_old = $_POST['training_diploma_file_old'];

    $uploadDir = '../uploads/info/training_scout/';

    $file_new = $training_diploma_file_old;

    if (count($_FILES) != 0) {
        $training_diploma_file = $_FILES['training_diploma_file'];
        $fileNameRes = "";
        $fileNameRes = $mainFunc->UploadFile($training_diploma_file, $uploadDir);
        if (!$fileNameRes['status']) {
            $response = array('status' => false, 'msg' => $fileNameRes['result']);
            echo json_encode($response);
            exit();
        }
        if (!empty($training_id) && !empty($training_diploma_file_old)) {
            unlink($uploadDir . $training_diploma_file_old);
        }
        $file_new =  $fileNameRes['result'];
    }

    $location = "-";
    if ($_POST['training_type'] == 1) {
        $location = $_POST['training_location'];
    }

    if (empty($training_id)) {
        $sql = "INSERT INTO info_training_scout \n" .
            "( training_type,training_name, training_agency, training_location,training_diploma_file, training_date, user_create )\n" .
            "VALUES\n" .
            "	(:training_type,:training_name, :training_agency, :training_location, :training_diploma_file, :training_date, :user_create)";
        $data = $DB->Insert($sql, [
            "training_type" => $_POST['training_type'],
            "training_name" => $_POST['training_name'],
            "training_agency" => $_POST['training_agency'],
            "training_location" => $location,
            "training_diploma_file" =>  $file_new,
            "training_date" => $_POST['training_date'],
            "user_create" => $_SESSION['user_data']->id
        ]);
    } else {
        $sql = "UPDATE info_training_scout SET 
                training_type = :training_type, training_name = :training_name, training_agency = :training_agency, 
                training_location = :training_location,training_diploma_file = :training_diploma_file, training_date = :training_date 
                WHERE training_id = :training_id";
        $data = $DB->Update($sql, [
            "training_type" => $_POST['training_type'],
            "training_name" => $_POST['training_name'],
            "training_agency" => $_POST['training_agency'],
            "training_location" => $location,
            "training_diploma_file" =>  $file_new,
            "training_date" => $_POST['training_date'],
            "training_id" => $training_id,
        ]);
    }
    echo $data;
}

if (isset($_GET['getTrainingScoutData'])) {
    $sql_order = "SELECT count(*) totalnotfilter FROM info_training_scout t";
    $totalnotfilter = $DB->Query($sql_order, []);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
    //จบการนับจำนวนทั้งหมด

    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM info_training_scout t WHERE t.user_create = :user_create ";
    $total_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter];
    echo json_encode($response);
}

if (isset($_POST['deleteTrainingScout'])) {
    $data = 0;
    $sql = "DELETE FROM info_training_scout WHERE training_id = :training_id";
    $data = $DB->Delete($sql, ["training_id" => $_POST['training_id']]);
    if ($data == 1) {
        $uploadDir = '../uploads/info/training_scout/';
        if (!empty($_POST['training_diploma_file_old'])) {
            unlink($uploadDir . $_POST['training_diploma_file_old']);
        }
    }
    echo $data;
}


if (isset($_POST['update_lecturer'])) {

    $mainFunc = new ClassMainFunctions();
    $data = 0;

    $lecturer_id = $_POST['lecturer_id'];
    $lecturer_diploma_file_old = $_POST['lecturer_diploma_file_old'];

    $uploadDir = '../uploads/info/lecturer/';

    $file_new = $lecturer_diploma_file_old;

    if (count($_FILES) != 0) {
        $lecturer_diploma_file = $_FILES['lecturer_diploma_file'];
        $fileNameRes = "";
        $fileNameRes = $mainFunc->UploadFile($lecturer_diploma_file, $uploadDir);
        if (!$fileNameRes['status']) {
            $response = array('status' => false, 'msg' => $fileNameRes['result']);
            echo json_encode($response);
            exit();
        }
        if (!empty($lecturer_id) && !empty($lecturer_diploma_file_old)) {
            unlink($uploadDir . $lecturer_diploma_file_old);
        }
        $file_new =  $fileNameRes['result'];
    }

    if (empty($lecturer_id)) {
        $sql = "INSERT INTO info_lecturer \n" .
            "( lecturer_type,lecturer_name, lecturer_agency, lecturer_diploma_file, lecturer_date, user_create )\n" .
            "VALUES\n" .
            "	(:lecturer_type,:lecturer_name, :lecturer_agency, :lecturer_diploma_file, :lecturer_date, :user_create)";
        $data = $DB->Insert($sql, [
            "lecturer_type" => $_POST['lecturer_type'],
            "lecturer_name" => $_POST['lecturer_name'],
            "lecturer_agency" => $_POST['lecturer_agency'],
            "lecturer_diploma_file" =>  $file_new,
            "lecturer_date" => $_POST['lecturer_date'],
            "user_create" => $_SESSION['user_data']->id
        ]);
    } else {
        $sql = "UPDATE info_lecturer SET 
                lecturer_type = :lecturer_type, lecturer_name = :lecturer_name, lecturer_agency = :lecturer_agency, 
                lecturer_diploma_file = :lecturer_diploma_file, lecturer_date = :lecturer_date 
                WHERE lecturer_id = :lecturer_id";
        $data = $DB->Update($sql, [
            "lecturer_type" => $_POST['lecturer_type'],
            "lecturer_name" => $_POST['lecturer_name'],
            "lecturer_agency" => $_POST['lecturer_agency'],
            "lecturer_diploma_file" =>  $file_new,
            "lecturer_date" => $_POST['lecturer_date'],
            "lecturer_id" => $lecturer_id,
        ]);
    }
    echo $data;
}


if (isset($_GET['getLecturerData'])) {
    $sql_order = "SELECT count(*) totalnotfilter FROM info_lecturer t";
    $totalnotfilter = $DB->Query($sql_order, []);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
    //จบการนับจำนวนทั้งหมด

    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM info_lecturer t WHERE t.user_create = :user_create ";
    $total_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter];
    echo json_encode($response);
}

if (isset($_POST['deleteLecturer'])) {
    $data = 0;
    $sql = "DELETE FROM info_lecturer WHERE lecturer_id = :lecturer_id";
    $data = $DB->Delete($sql, ["lecturer_id" => $_POST['lecturer_id']]);
    if ($data == 1) {
        $uploadDir = '../uploads/info/lecturer/';
        if (!empty($_POST['lecturer_diploma_file_old'])) {
            unlink($uploadDir . $_POST['lecturer_diploma_file_old']);
        }
    }
    echo $data;
}



if (isset($_POST['update_academic'])) {

    $mainFunc = new ClassMainFunctions();
    $data = 0;

    $academic_id = $_POST['academic_id'];
    $academic_file_old = $_POST['academic_file_old'];

    $uploadDir = '../uploads/info/academic/';

    $file_new = $academic_file_old;

    if (count($_FILES) != 0) {
        $academic_file = $_FILES['academic_file'];
        $fileNameRes = "";
        $fileNameRes = $mainFunc->UploadFile($academic_file, $uploadDir);
        if (!$fileNameRes['status']) {
            $response = array('status' => false, 'msg' => $fileNameRes['result']);
            echo json_encode($response);
            exit();
        }
        if (!empty($academic_id) && !empty($academic_file_old)) {
            unlink($uploadDir . $academic_file_old);
        }
        $file_new =  $fileNameRes['result'];
    }

    if (empty($academic_id)) {
        $sql = "INSERT INTO info_academic (academic_name, academic_file, user_create)\n" .
            "VALUES\n" .
            "	( :academic_name, :academic_file, :user_create);";
        $data = $DB->Insert($sql, [
            "academic_name" => $_POST['academic_name'],
            "academic_file" =>  $file_new,
            "user_create" => $_SESSION['user_data']->id
        ]);
    } else {
        $sql = "UPDATE info_academic SET 
                academic_name = :academic_name, academic_file = :academic_file
                WHERE academic_id = :academic_id";
        $data = $DB->Update($sql,  [
            "academic_name" => $_POST['academic_name'],
            "academic_file" =>  $file_new,
            "academic_id" => $academic_id,
        ]);
    }
    echo $data;
}


if (isset($_GET['getAcademicData'])) {
    $sql_order = "SELECT count(*) totalnotfilter FROM info_academic t";
    $totalnotfilter = $DB->Query($sql_order, []);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
    //จบการนับจำนวนทั้งหมด

    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM info_academic t WHERE t.user_create = :user_create ";
    $total_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter];
    echo json_encode($response);
}

if (isset($_POST['deleteAcademic'])) {
    $data = 0;
    $sql = "DELETE FROM info_academic WHERE academic_id = :academic_id";
    $data = $DB->Delete($sql, ["academic_id" => $_POST['academic_id']]);
    if ($data == 1) {
        $uploadDir = '../uploads/info/lecturer/';
        if (!empty($_POST['academic_file_old'])) {
            unlink($uploadDir . $_POST['academic_file_old']);
        }
    }
    echo $data;
}

if (isset($_POST['update_community'])) {

    $data = 0;

    $community_id = $_POST['community_id'];

    if (empty($community_id)) {
        $sql = "INSERT INTO info_community (community_name,user_create)\n" .
            "VALUES\n" .
            "	( :community_name, :user_create);";
        $data = $DB->Insert($sql, [
            "community_name" => $_POST['community_name'],
            "user_create" => $_SESSION['user_data']->id
        ]);
    } else {
        $sql = "UPDATE info_community SET 
                community_name = :community_name
                WHERE community_id = :community_id";
        $data = $DB->Update($sql,  [
            "community_name" => $_POST['community_name'],
            "community_id" => $community_id,
        ]);
    }
    echo $data;
}


if (isset($_GET['getCommunityData'])) {
    $sql_order = "SELECT count(*) totalnotfilter FROM info_community t";
    $totalnotfilter = $DB->Query($sql_order, []);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
    //จบการนับจำนวนทั้งหมด

    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM info_community t WHERE t.user_create = :user_create ";
    $total_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter];
    echo json_encode($response);
}

if (isset($_POST['deleteCommunity'])) {
    $data = 0;
    $sql = "DELETE FROM info_community WHERE community_id = :community_id";
    $data = $DB->Delete($sql, ["community_id" => $_POST['community_id']]);
    echo $data;
}


if (isset($_POST['update_submission'])) {

    $data = 0;

    $submission_id = $_POST['submission_id'];

    if (empty($submission_id)) {
        $sql = "INSERT INTO info_submission (submission_name,user_create)\n" .
            "VALUES\n" .
            "	( :submission_name, :user_create);";
        $data = $DB->Insert($sql, [
            "submission_name" => $_POST['submission_name'],
            "user_create" => $_SESSION['user_data']->id
        ]);
    } else {
        $sql = "UPDATE info_submission SET 
                submission_name = :submission_name
                WHERE submission_id = :submission_id";
        $data = $DB->Update($sql,  [
            "submission_name" => $_POST['submission_name'],
            "submission_id" => $submission_id,
        ]);
    }
    echo $data;
}


if (isset($_GET['getSubmissionData'])) {
    $sql_order = "SELECT count(*) totalnotfilter FROM info_submission t";
    $totalnotfilter = $DB->Query($sql_order, []);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
    //จบการนับจำนวนทั้งหมด

    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM info_submission t WHERE t.user_create = :user_create ";
    $total_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, ["user_create" => isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_data']->id]);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter];
    echo json_encode($response);
}

if (isset($_POST['deleteSubmission'])) {
    $data = 0;
    $sql = "DELETE FROM info_submission WHERE submission_id = :submission_id";
    $data = $DB->Delete($sql, ["submission_id" => $_POST['submission_id']]);
    echo $data;
}


if (isset($_POST['update_leave'])) {

    $data = 0;

    $leave_id = $_POST['leave_id'];
    $leave_type = $_POST['leave_type'];
    $leave_day = $_POST['leave_day'];
    $leave_date = $_POST['leave_date'];

    $mode = "INSERT INTO ";
    $where = "";

    $leaveData = array();

    if (!empty($leave_id)) {
        $mode = "UPDATE ";
        $where = " WHERE leave_id = :leave_id";
        $params['leave_id'] = $leave_id;
    }
    $sql = $mode . "info_leave SET leave_type = :leave_type,leave_day = :leave_day,leave_date = :leave_date, user_id = :user_id" . $where;

    $params['leave_type'] = $leave_type;
    $params['leave_day'] = $leave_day;
    $params['leave_date'] = $leave_date;
    $params['user_id'] = $_POST['user_id'];

    $data = $DB->Update($sql, $params);

    echo $data;
}

if (isset($_GET['getLeaveDataByType'])) {
    $sql_order = "SELECT count(*) totalnotfilter FROM info_leave l";
    $totalnotfilter = $DB->Query($sql_order, []);
    $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
    //จบการนับจำนวนทั้งหมด

    //นับจำนวนที่มีการ filter
    $sql = "SELECT * FROM info_leave l WHERE l.user_id = :user_id AND l.leave_type = :leave_type";
    $total_result = $DB->Query($sql, ["user_id" => $_GET['user_id'], "leave_type" => $_GET['type']]);
    $total = count(json_decode($total_result));
    //จบนับจำนวนที่มีการ filter

    //จำกัดจำนวน
    $limit = "";
    if (isset($_REQUEST['limit'])) {
        $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    }

    //ข้อมูลที่จะแสดง
    $sql = $sql . $limit;
    $data_result = $DB->Query($sql, ["user_id" => $_GET['user_id'], "leave_type" => $_GET['type']]);

    $response = ['rows' => json_decode($data_result), "total" => (int)$total, "totalNotFiltered" => (int)$totalnotfilter];
    echo json_encode($response);
}

if (isset($_POST['deleteLeave'])) {
    $data = 0;
    $sql = "DELETE FROM info_leave WHERE leave_id = :leave_id";
    $data = $DB->Delete($sql, ["leave_id" => $_POST['leave_id']]);
    echo $data;
}

if (isset($_POST['getLeave'])) {
    $sql = "SELECT\n" .
        "	l.leave_type,\n" .
        "	count( l.leave_type ) count_type,\n" .
        "	SUM( l.leave_day ) leave_day \n" .
        "FROM\n" .
        "	info_leave l \n" .
        "WHERE\n" .
        "	l.user_id = :user_id \n" .
        "GROUP BY\n" .
        "	l.leave_type ORDER BY l.leave_type";
    $data = $DB->Query($sql, ['user_id' => $_POST['user_id']]);
    $leaveData = json_decode($data);

    $newArray = [];
    foreach ($leaveData as $item) {
        $leave_type = $item->leave_type;
        $newArray[$leave_type] = $item;
    }
    echo json_encode($newArray);
}
