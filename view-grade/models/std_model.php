<?php

class STD_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function getDataStdToTable($std_class, $term_id = 0)
    {
        if ($term_id == 0) {
            $term_id = $_SESSION['term_active']->term_id;
        }
        $sql = "SELECT\n" .
            "	std.std_id,\n" .
            "   std.std_code,\n" .
            "	std.std_class,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	ts.`status`,\n" .
            "	ts.status_text \n" .
            "FROM\n" .
            "	tb_students std\n" .
            "	LEFT JOIN vg_test_result ts ON ( std.std_id = ts.std_id AND ts.term_id = :term_id ) \n" .
            "	LEFT JOIN vg_terms term ON ts.term_id = term.term_id \n" .
            "WHERE\n" .
            "	std.std_class = :std_class AND std_status = 'กำลังศึกษา' AND std.user_create = :user_create";
        $data = $this->db->Query($sql, ["term_id" =>  $term_id, "std_class" => $std_class, "user_create" => $_SESSION['user_data']->id]);
        return json_decode($data);
    }

    public function getDataStdMoralToTable($std_class)
    {
        $sql = "SELECT\n" .
            "	std.std_id,\n" .
            "   std.std_code,\n" .
            "	std.std_class,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	vm.score\n" .
            "FROM\n" .
            "	tb_students std\n" .
            "	LEFT JOIN vg_moral vm ON ( std.std_id = vm.std_id AND vm.term_id = :term_id ) \n" .
            "	LEFT JOIN vg_terms term ON vm.term_id = term.term_id \n" .
            "WHERE\n" .
            "	std.std_class = :std_class AND std.user_create = :user_create";
        $data = $this->db->Query($sql, ["term_id" =>  $_SESSION['term_active']->term_id, "std_class" => $std_class, "user_create" => $_SESSION['user_data']->id]);
        return json_decode($data);
    }

    public function getDataStdToTableGradiate($std_class, $term_id = 0)
    {
        if ($term_id == 0) {
            $term_id = $_SESSION['term_active']->term_id;
        }
        $sql = "SELECT\n" .
            "	std.std_id,\n" .
            "   std.std_code,\n" .
            "	std.std_class,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	gra.`status`,\n" .
            "	gra.status_text \n" .
            "FROM\n" .
            "	tb_students std\n" .
            "	LEFT JOIN vg_gradiate gra ON ( std.std_id = gra.std_id  AND gra.term_id = :term_id ) \n" .
            "	LEFT JOIN vg_terms term ON gra.term_id = term.term_id \n" .
            "WHERE\n" .
            "	std.std_class = :std_class AND std_status = 'กำลังศึกษา' AND std.user_create = :user_create ORDER BY std_code";
        $data = $this->db->Query($sql, ["term_id" =>  $term_id, "std_class" => $std_class, "user_create" => $_SESSION['user_data']->id]);
        return json_decode($data);
    }

    public function getDataStdToTableN_Net($std_class, $term_id = 0)
    {
        if ($term_id == 0) {
            $term_id = $_SESSION['term_active']->term_id;
        }
        $sql = "SELECT\n" .
            "	std.std_id,\n" .
            "   std.std_code,\n" .
            "	std.std_class,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	nn.`status`,\n" .
            "	nn.status_text \n" .
            "FROM\n" .
            "	tb_students std\n" .
            "	LEFT JOIN vg_n_net nn ON ( std.std_id = nn.std_id  AND nn.term_id = :term_id )\n" .
            "	LEFT JOIN vg_terms term ON nn.term_id = term.term_id \n" .
            "WHERE\n" .
            "	std.std_class = :std_class AND std_status = 'กำลังศึกษา' AND std.user_create = :user_create ORDER BY std_code";
        $data = $this->db->Query($sql, ["term_id" =>  $term_id, "std_class" => $std_class, "user_create" => $_SESSION['user_data']->id]);
        return json_decode($data);
    }

    public function getDataStdToTableFinish($std_class, $term_id = 0)
    {
        if ($term_id == 0) {
            $term_id = $_SESSION['term_active']->term_id;
        }
        $sql = "SELECT\n" .
            "	std.std_id,\n" .
            "   std.std_code,\n" .
            "	std.std_class,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	finish.`status`,\n" .
            "	finish.status_text \n" .
            "FROM\n" .
            "	tb_students std\n" .
            "	LEFT JOIN vg_std_finish finish ON ( std.std_id = finish.std_id AND finish.term_id = :term_id ) \n" .
            "	LEFT JOIN vg_terms term ON finish.term_id = term.term_id \n" .
            "WHERE\n" .
            "	std.std_class = :std_class AND std_status = 'กำลังศึกษา' AND std.user_create = :user_create ORDER BY std_code";
        $data = $this->db->Query($sql, ["term_id" =>  $term_id, "std_class" => $std_class, "user_create" => $_SESSION['user_data']->id]);
        return json_decode($data);
    }

    public function checkStudentWhereSTDNumber($std_number, $user_create)
    {
        $sql = "SELECT * FROM tb_students WHERE std_code = :std_code AND user_create = :user_create";
        $data = $this->db->Query($sql, ['std_code' => $std_number, "user_create" => $user_create]);
        return json_decode($data);
    }

    public function checkNationalId($national_id)
    {
        $sql = "SELECT national_id, CONCAT( u.name, ' ',u.surname ) u_name FROM tb_students std LEFT JOIN tb_users u ON std.user_create = u.id WHERE std.national_id = :national_id";
        $data = $this->db->Query($sql, ['national_id' => $national_id,]);
        return json_decode($data);
    }

    public function getDataStudent($user_create)
    {
        $sql = "SELECT * FROM tb_students WHERE user_create = :user_create  ORDER BY std_class ASC,  std_code ASC";
        $data = $this->db->Query($sql, ["user_create" => $user_create]);
        return json_decode($data);
    }

    public function deleteStd($id, $mode = "")
    {
        $sql = "DELETE FROM stf_tb_after_gradiate WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_family_data WHERE user_create = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_evaluate_students WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_screening_students WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_student_person WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_student_person_new WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "SELECT home_img FROM stf_tb_form_visit_home WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir = '../../student-tracking/uploads/visit_home_img/' . $value->home_img;
            unlink($uploadDir);
        }
        $sql = "DELETE FROM stf_tb_form_visit_home WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "SELECT file_name FROM stf_tb_gradiate_reg WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir = '../../student-tracking/uploads/gradiate_reg/' . $value->file_name;
            unlink($uploadDir);
        }
        $sql = "DELETE FROM stf_tb_gradiate_reg WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "DELETE FROM vg_credit WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_gradiate WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_kpc WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_moral WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_n_net WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "SELECT img_event_1,img_event_2 FROM vg_save_event WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir1 = '../uploads/save_event/' . $value->img_event_1;
            $uploadDir2 = '../uploads/save_event/' . $value->img_event_2;
            unlink($uploadDir1);
            unlink($uploadDir2);
        }
        $sql = "DELETE FROM vg_save_event WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "DELETE FROM vg_std_finish WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "SELECT file_name FROM vg_table_test WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir1 = '../uploads/table_test_pdf/' . $value->file_name;
            unlink($uploadDir1);
        }
        $sql = "DELETE FROM vg_table_test WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "SELECT file_name FROM vg_test_grade WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir = '../uploads/test_grade_pdf/' . $value->file_name;
            unlink($uploadDir);
        }
        $sql = "DELETE FROM vg_test_grade WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "DELETE FROM vg_test_result WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        if ($mode == "deleteStd") {
            $sql = "DELETE FROM tb_users WHERE edu_type = :id";
            $this->db->Delete($sql, ["id" => $id]);

            $sql = "DELETE FROM tb_students WHERE std_id = :id";
            $this->db->Delete($sql, ["id" => $id]);
        }
        return 1;
    }

    public function InsertStudent($arr_data, $std_id = 0)
    {
        unset($arr_data['password']);

        $state = '';
        $where = '';
        $data = 0;

        $termActive = $_SESSION['term_active'];
        $termData = explode('/', $termActive->term_name);
        $stdTerm = $termData[0];
        $stdYear = $termData[1];

        if ($std_id != 0) {
            $state = 'UPDATE ';
            $where = 'WHERE std_id = :std_id';
        } else {
            $state = 'INSERT INTO ';
        }
        $sql =  $state . " tb_students SET \n" .
            "	std_code = :std_code,\n" .
            "	std_prename = :std_prename,\n" .
            "	std_name = :std_name,\n" .
            "	std_gender = :std_gender,\n" .
            "	std_class = :std_class,\n" .
            "	std_birthday = :std_birthday,\n" .
            "	std_father_name = :std_father_name,\n" .
            "	std_father_job = :std_father_job,\n" .
            "	std_mather_name = :std_mather_name,\n" .
            "	std_mather_job = :std_mather_job,\n" .
            "	phone = :phone,\n" .
            "	address = :address,\n" .
            "   national_id = :national_id,\n" .
            "   user_create = :user_create,\n" .
            "	std_term = {$stdTerm},\n" .
            "	std_year = {$stdYear}\n" 
            . $where;
        if ($std_id != 0) {
            $data = $this->db->Update($sql, $arr_data);
        } else {
            $data = $this->db->InsertLastID($sql, $arr_data);
        }

        return $data;
    }

    public function addToTbUsers($array_data)
    {
        $sql = "INSERT INTO tb_users(name,surname,username,password,edu_id,edu_type,role_id,user_create,district_am,province_am,district_am_id,province_am_id,status) \n"
            . "VALUES(:name,:surname,:username,:password,:edu_id,:edu_type,:role_id,:user_create,:district,:province,:district_id,:province_id,:status)";
        $data = $this->db->Insert($sql, $array_data);
        return $data;
    }

    public function updateToTbUsers($array_data)
    {
        $sql = "UPDATE tb_users SET name = :name, surname = :surname,username = :username,password = :password WHERE edu_type = :edu_type";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function updateStd($array_data)
    {
        $sql = "UPDATE tb_students SET std_code = :std_code, std_prename = :std_prename, std_name = :std_name,std_birthday = :std_birthday, national_id = :national_id, 
                std_term = :std_term, std_year = :std_year, std_profile_image = :std_profile_image, std_profile_image_back = :std_profile_image_back WHERE std_id = :std_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function updateUserStd($array_data)
    {
        $sql = "UPDATE tb_users SET name = :name, surname = :surname,username = :username WHERE edu_type = :edu_type";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    function checkAndUpdateGenderStudents($main_func = null)
    {
        $sql = "SELECT std_id,std_prename,std_name FROM tb_students WHERE  user_create  = :user_create AND ( std_gender = '' OR std_gender = '-' )";
        $std_data = $this->db->Query($sql, ['user_create' => $_SESSION['user_data']->id]);
        $std_data = json_decode($std_data);

        $malePrename = ["เด็กชาย", "นาย"];
        $femalePrename = ["เด็กหญิง", "นางสาว", "นาง"];

        if (count($std_data) > 0) {
            foreach ($std_data as $key => $std) {
                $std_gender = '';
                $prename = $std->std_prename;
                if (empty($prename)) {
                    $cutname = $main_func->cutPrename($std->std_name);
                    $prename =  $cutname[0];
                }
                if (in_array($prename, $malePrename)) {
                    $std_gender = 'ชาย';
                } elseif (in_array($prename, $femalePrename)) {
                    $std_gender = 'หญิง';
                } else {
                    $std_gender = '-'; // Set empty if prename is not in the list
                }

                $sql = "UPDATE tb_students SET std_gender = :std_gender WHERE std_id = :std_id";
                $this->db->Update($sql, ['std_gender' => $std_gender, 'std_id' => $std->std_id]);
            }
        }
    }

    function updateGender($prename, $std_id)
    {
        $malePrename = ["เด็กชาย", "นาย"];
        $femalePrename = ["เด็กหญิง", "นางสาว", "นาง"];

        $std_gender = '';
        if (in_array($prename, $malePrename)) {
            $std_gender = 'ชาย';
        } elseif (in_array($prename, $femalePrename)) {
            $std_gender = 'หญิง';
        } else {
            $std_gender = '-'; // Set empty if prename is not in the list
        }

        $sql = "UPDATE tb_students SET std_gender = :std_gender WHERE std_id = :std_id";
        $this->db->Update($sql, ['std_gender' => $std_gender, 'std_id' => $std_id]);
    }

    function  deleteNullData()
    {
        $sql = "DELETE FROM tb_students WHERE user_create IS NULL";
        $this->db->Delete($sql, []);
    }
}
