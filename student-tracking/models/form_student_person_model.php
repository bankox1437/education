<?php
include "../../config/main_function.php";
class FormStudentPersonmodel
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function getStudentPerson()
    {
        $where = "";
        $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n" .
            "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        $address = "";
        $edu_name = "IFNULL( edu.NAME, edu_o.NAME ) edu_name \n";
        if ($_SESSION['user_data']->role_id == 3) {
            $where .= "WHERE u.id = :user_id\n";
        }
        if ($_SESSION['user_data']->role_id == 2) {
            $where .= "WHERE edu.district_id = ( SELECT district_am_id FROM tb_users us LEFT JOIN tbl_non_education edu ON us.edu_id = edu.id WHERE us.id = :user_id) \n";
        }

        if ($_SESSION['user_data']->edu_type == 'edu_other') {
            $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n";
            $address = "";
            $edu_name = "edu_o.NAME edu_name \n";
        } else if ($_SESSION['user_data']->edu_type == 'edu') {
            $joinEDU = "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
            $address = "	,( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province \n";
            $edu_name = "edu.NAME edu_name \n";
        } else {
            $address = "	,( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province \n";
            $edu_name = "IFNULL( edu.NAME, edu_o.NAME ) edu_name \n";
        }
        $sql = "SELECT\n" .
            "	sp.std_per_id,\n" .
            "   std.std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	std.std_code,\n" .
            "	\n" .
            "   CONCAT(u.name,' ',u.surname) user_create_data,\n" .
            "   ( SELECT COUNT(learn_analys_id) FROM stf_tb_learn_analysis
            WHERE std_per_id = sp.std_per_id limit 1 ) count_learn_analys, \n" .
            "   ( SELECT learn_analys_id FROM stf_tb_learn_analysis
            WHERE std_per_id = sp.std_per_id limit 1 ) learn_analys_id, \n" .
            $edu_name .
            $address .
            "FROM\n" .
            "	stf_tb_form_student_person_new sp\n" .
            "	LEFT JOIN tb_users u ON sp.user_create = u.id\n" .
            $joinEDU .
            "	LEFT JOIN tb_students std ON sp.std_id = std.std_id \n" .
            $where .
            "ORDER BY\n" .
            "	edu_name ASC,std.std_class ASC,\n" .
            "	std.std_code ASC";
        // die($sql);
        if ($_SESSION['user_data']->role_id == 1) {
            $data = $this->db->Query($sql, []);
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $data = $this->db->Query($sql, ['edu_id' => $_SESSION['user_data']->edu_id]);
        } else {
            $data = $this->db->Query($sql, ['user_id' => $_SESSION['user_data']->id]);
        }

        return [json_decode($data), $sql];
    }

    public function getDataStudentPerEdit($id)
    {

        $sql = "SELECT * FROM stf_tb_form_student_person sp\n" .
            "	LEFT JOIN tb_students std ON sp.std_id = std.std_id \n" .
            "    WHERE sp.std_p_id = :id";

        $data = $this->db->Query($sql, ["id" => $id]);
        return json_decode($data);
    }

    public function addStudent_Person($array_data)
    {
        $sql = "INSERT INTO `stf_tb_form_student_person` ( `std_id`, `std_type`, `num_siblings`, `num_younger`, `num_son`, `relation`, `live_present`, `feel_me`, `best_friend_name`, `want_around_people`, `afraid_others`, `life_myseft`, `not_life_myseft`, `want_improve`, `pride`, `impressive_event`, `uneasy`, `person_discuss_problems`, `activity`, `money_per_day`, `use_money_per_day`, `action_regret`, `feel_for_school_and_teacher`, `gpa`, `favorite_subject`, `not_favorite_subject`, `reason_not_favorite_subject`, `health_problems`,user_create)
VALUES(:std_id,:std_type,:num_siblings,:num_younger,:num_son,:relation,:live_present, :feel_me,:best_friend_name,:want_around_people,:afraid_others,:life_myseft,:not_life_myseft, :want_improve,:pride,:impressive_event,:uneasy,:person_discuss_problems,:activity, :money_per_day,:use_money_per_day,:action_regret,:feel_for_school_and_teacher,:gpa,:favorite_subject, :not_favorite_subject,:reason_not_favorite_subject,:health_problems,:user_id);";
        $data = $this->db->Insert($sql, $array_data);
        return $data;
    }

    public function editStudent_Person($arr)
    {
        $sql = "UPDATE `stf_tb_form_student_person` SET `num_siblings`= :num_siblings,`num_younger`= :num_younger,`num_son`= :num_son,`relation`= :relation,`live_present`= :live_present,`feel_me`= :feel_me,`best_friend_name`= :best_friend_name,`want_around_people`= :want_around_people,`afraid_others`= :afraid_others,`life_myseft`= :life_myseft,`not_life_myseft`= :not_life_myseft,`want_improve`= :want_improve,`pride`= :pride,`impressive_event`= :impressive_event,`uneasy`= :uneasy,`person_discuss_problems`= :person_discuss_problems,`activity`= :activity,`money_per_day`= :money_per_day,`use_money_per_day`= :use_money_per_day,`action_regret`= :action_regret,`feel_for_school_and_teacher`= :feel_for_school_and_teacher,`gpa`= :gpa,`favorite_subject`= :favorite_subject,`not_favorite_subject`= :not_favorite_subject,`reason_not_favorite_subject`= :reason_not_favorite_subject,`health_problems`= :health_problems WHERE `std_p_id`= :std_p_id;";
        $data = $this->db->Update($sql, $arr);
        return $data;
    }

    public function deleteFormStudentPreson($id)
    {
        $sql = "DELETE FROM stf_tb_form_student_person_new WHERE std_per_id = :id";
        $data = $this->db->Delete($sql, ["id" => $id]);
        return $data;
    }

    public function getClassInDropdown()
    {
        $where = "WHERE std_class is not null ";
        $joinEDU = "";
        if ($_SESSION['user_data']->role_id == 3) {
            $where .= " AND std_preson.user_create = :user_id\n";
        }
        if ($_SESSION['user_data']->role_id == 2) {
            $joinEDU = "	LEFT JOIN tb_users u ON std_preson.user_create = u.id\n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id \n";
            $where .= " AND edu.district_id = :edu_id\n";
        }

        $sql = "SELECT\n" .
            "	std.std_name,\n" .
            "	std.std_class \n" .
            "FROM\n" .
            "	stf_tb_form_student_person_new std_preson\n" .
            "	LEFT JOIN tb_students std ON std_preson.std_id = std.std_id \n" .
            $joinEDU .
            $where .
            "GROUP BY\n" .
            "	std.std_class";

        if ($_SESSION['user_data']->role_id == 1) {
            $data = $this->db->Query($sql, []);
        } else if ($_SESSION['user_data']->role_id == 2) {
            $data = $this->db->Query($sql, ['edu_id' => $_SESSION['user_data']->district_am_id]);
        } else {
            $data = $this->db->Query($sql, ['user_id' => $_SESSION['user_data']->id]);
        }
        return json_decode($data);
    }

    public function getSubDistrict()
    {
        $where = "WHERE sub.name_th IS NOT NULL ";
        if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu') {
            $where .= "AND edu.district_id = ( SELECT district_id FROM tb_users us LEFT JOIN tbl_non_education edu ON us.edu_id = edu.id WHERE us.id = :user_id) \n";
        }
        $sql = "SELECT\n" .
            "	edu.sub_district_id,\n" .
            "	sub.name_th sub_district_name \n" .
            "FROM\n" .
            "	stf_tb_form_student_person std_preson\n" .
            "	LEFT JOIN tb_users u ON u.id = std_preson.user_create\n" .
            "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
            "	LEFT JOIN tbl_sub_district sub ON edu.sub_district_id = sub.id \n" .
            $where . "GROUP BY edu.sub_district_id";

        if ($_SESSION['user_data']->role_id == 1) {
            $data = $this->db->Query($sql, []);
        } else {
            $data = $this->db->Query($sql, ['user_id' => $_SESSION['user_data']->id]);
        }
        return json_decode($data);
    }

    public function getDataStudentPersonByClass($std_class, $sub_district_id, $district_id, $province_id)
    {
        $std_class_where = '';
        $sub_district_id_where = '';
        $option_and = ' AND ';
        if ($std_class != '0') {
            $std_class_where .= 'std.std_class = :std_class ';
        } else {
            $option_and = ' ';
        }
        if ($province_id != '0' && $district_id == '0' && $sub_district_id == '0') {
            $sub_district_id_where .= 'edu.province_id = :province_id ';
        } else if ($province_id != '0' && $district_id != '0' && $sub_district_id == '0') {
            $sub_district_id_where .= 'edu.province_id = :province_id AND ';
            $sub_district_id_where .= 'edu.district_id = :district_id ';
        } else if ($province_id != '0' && $district_id != '0' && $sub_district_id != '0') {
            $sub_district_id_where .= 'edu.province_id = :province_id AND ';
            $sub_district_id_where .= 'edu.district_id = :district_id AND ';
            $sub_district_id_where .= 'edu.sub_district_id = :sub_district_id ';
        } else {
            $option_and = '  ';
        }
        $where = "WHERE $std_class_where  $option_and $sub_district_id_where";
        $main_func = new ClassMainFunctions();
        $colunm =   "	std_preson.std_per_id,\n" .
            "   std.std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	std.std_code,\n" .
            "	\n" .
            "   CONCAT(u.name,' ',u.surname) user_create_data,\n" .
            "   ( SELECT COUNT(learn_analys_id) FROM stf_tb_learn_analysis WHERE std_per_id = std_preson.std_per_id limit 1 ) count_learn_analys, \n" .
            "   ( SELECT learn_analys_id FROM stf_tb_learn_analysis WHERE std_per_id = std_preson.std_per_id limit 1 ) learn_analys_id, \n";
        $table = "stf_tb_form_student_person_new std_preson \n";
        $join = "	LEFT JOIN tb_users u ON std_preson.user_create = u.id\n" .
            "	LEFT JOIN tb_students std ON std_preson.std_id = std.std_id \n";
        $order_by = "ORDER BY\n" .
            "	edu_name ASC,std.std_class ASC,\n" .
            "	std.std_code ASC";
        $arr_data = [];
        if ($std_class != '0') {
            $arr_data['std_class'] = $std_class;
        }
        if ($_SESSION['user_data']->role_id == 1) {
            if ($province_id != '0' && $district_id == '0' && $sub_district_id == '0') {
                $arr_data['province_id'] = $province_id;
            } else if ($province_id != '0' && $district_id != '0' && $sub_district_id == '0') {
                $arr_data['province_id'] = $province_id;
                $arr_data['district_id'] = $district_id;
            } else if ($province_id != '0' && $district_id != '0' && $sub_district_id != '0') {
                $arr_data['province_id'] = $province_id;
                $arr_data['district_id'] = $district_id;
                $arr_data['sub_district_id'] = $sub_district_id;
            }
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            if ($sub_district_id != '0') {
                $arr_data['sub_district_id'] = $sub_district_id;
            }
            $arr_data['edu_id'] = $_SESSION['user_data']->edu_id;
        } else {
            if ($sub_district_id != '0') {
                $arr_data['sub_district_id'] = $sub_district_id;
            }
            $arr_data['user_id'] = $_SESSION['user_data']->id;
        }
        return $main_func->getDataAll($table, $join, $order_by, $this->db, $colunm,  $arr_data, $where);
    }

    public function getStudentPersonByAmphur($std_class, $sub_district_id)
    {
        $std_class_where = '';
        $sub_district_id_where = ' ';
        $option_and = ' ';
        if ($sub_district_id != '0') {
            $sub_district_id_where = ' edu.sub_district_id = :sub_district_id ';
            $option_and = ' AND ';
        }


        if ($std_class != '0') {
            $std_class_where .= 'std.std_class = :std_class ';
        } else {
            $option_and = ' ';
        }
        $where = "WHERE $std_class_where  $option_and $sub_district_id_where";
        $main_func = new ClassMainFunctions();
        $colunm =   "	std_preson.std_per_id,\n" .
            "   std.std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	std.std_code,\n" .
            "	\n" .
            "   CONCAT(u.name,' ',u.surname) user_create_data,\n" .
            "   ( SELECT COUNT(learn_analys_id) FROM stf_tb_learn_analysis WHERE std_per_id = std_preson.std_per_id limit 1 ) count_learn_analys, \n" .
            "   ( SELECT learn_analys_id FROM stf_tb_learn_analysis WHERE std_per_id = std_preson.std_per_id limit 1 ) learn_analys_id, \n";
        $table = "stf_tb_form_student_person_new std_preson \n";
        $join = "	LEFT JOIN tb_users u ON std_preson.user_create = u.id\n" .
            "	LEFT JOIN tb_students std ON std_preson.std_id = std.std_id \n";
        $order_by = "ORDER BY\n" .
            "	edu_name ASC,std.std_class ASC,\n" .
            "	std.std_code ASC";
        $arr_data = [];
        if ($std_class != '0') {
            $arr_data['std_class'] = $std_class;
        }
        if ($_SESSION['user_data']->role_id == 2) {
            if ($sub_district_id != '0') {
                $arr_data['sub_district_id'] = $sub_district_id;
            }
        } else {
            if ($sub_district_id != '0') {
                $arr_data['sub_district_id'] = $sub_district_id;
            }
            $arr_data['user_id'] = $_SESSION['user_data']->id;
        }
        return $main_func->getDataAll($table, $join, $order_by, $this->db, $colunm,  $arr_data, $where);
    }

    // -------------------------------------------------- new version --------------------------------------------------
    function insertNew($arr_data, $status = "insert")
    {
        $option = "INSERT ";
        $where =  "	,`std_id` = :std_id,\n" .
            "	`user_create` = :user_create";
        if ($status == "update") {
            $option = "UPDATE ";
            $where = " WHERE std_per_id = :std_per_id ";
        }
        $sql = $option . " stf_tb_form_student_person_new SET \n" .
            "	`nickname` = :nickname,\n" .
            "	`age` = :age,\n" .
            "	`phone` = :phone,\n" .
            "	`address_who` = :address_who,\n" .
            "	`number_home`= :number_home,\n" .
            "	`moo` = :moo,\n" .
            "	`sub_district` = :sub_district,\n" .
            "	`district` = :district,\n" .
            "	`province` = :province,\n" .
            "	`weight` = :weight,\n" .
            "	`height` = :height,\n" .
            "	`blood_group` = :blood_group,\n" .
            "	`disease` = :disease,\n" .
            "	`drug_allergy` = :drug_allergy,\n" .
            "	`like_subject1` = :like_subject1,\n" .
            "	`like_subject2` = :like_subject2,\n" .
            "	`dont_like_subject1` = :dont_like_subject1,\n" .
            "	`dont_like_subject2` = :dont_like_subject2,\n" .
            "	`std_ability` = :std_ability,\n" .
            "	`have_internet` = :have_internet,\n" .
            "	`use_device` = :use_device,\n" .
            "	`use_internet_more` = :use_internet_more,\n" .
            "	`reason_edu` = :reason_edu,\n" .
            "	`reason_learning_format` = :reason_learning_format,\n" .
            "	`reason_learning_format_text` = :reason_learning_format_other_text,\n" .
            "	`reason_process` = :reason_process,\n" .
            "	`expectations` = :expectations\n" .
            $where;
        if ($status == "update") {
            $data = $this->db->Update($sql, $arr_data);
        } else {
            $data = $this->db->InsertLastID($sql, $arr_data);
        }
        return $data;
    }

    function insertProgram($arr_data, $status = "insert")
    {
        $option = "INSERT ";
        $where =  "	,`std_per_id` = :std_per_id";
        if ($status == "update") {
            $option = "UPDATE ";
            $where = " WHERE std_per_id = :std_per_id ";
        }
        $sql =  $option . " stf_tb_program_of_student_person SET 
                word = :word, 
                power_point = :power_point, 
                excel = :excel, 
                photoshop = :photoshop " . $where;

        if ($status == "update") {
            $data = $this->db->Update($sql, $arr_data);
        } else {
            $data = $this->db->Insert($sql, $arr_data);
        }
        return $data;
    }

    function insertLearnAnalysis($arr_data, $status = "insert")
    {
        $option = "INSERT ";
        $where =  ",user_create = " . $_SESSION['user_data']->id;
        if ($status == "update") {
            $option = "UPDATE ";
            $where = " WHERE learn_analys_id = :learn_analys_id ";
        }
        $sql =  $option . " stf_tb_learn_analysis SET 
                std_per_id = :std_per_id, 
                note = :note " . $where;

        if ($status == "update") {
            $data = $this->db->Update($sql, $arr_data);
        } else {
            $data = $this->db->InsertLastID($sql, $arr_data);
        }
        return $data;
    }

    function insertLearnAnalysisSide($side, $arr_data, $status = "insert")
    {
        $option = "INSERT ";
        $where =  ",learn_analys_id = :learn_analys_id ";
        if ($status == "update") {
            $option = "UPDATE ";
            $where = " WHERE learn_analys_id = :learn_analys_id ";
        }
        $column = " note = :note,\n
                    learn_1 = :title_" . $side . "_1, \n
                    learn_2 = :title_" . $side . "_2, \n
                    learn_3 = :title_" . $side . "_3 \n";
        if ($side == 3) {
            $column .= ", learn_4 = :title_3_4 ";
        }
        $sql =  $option . " stf_tb_learn_anlysis_side" . $side . "  SET " . $column . $where . " \n";
        if ($status == "update") {
            $data = $this->db->Update($sql, $arr_data);
        } else {
            $data = $this->db->Insert($sql, $arr_data);
        }
        return $data;
    }


    function getStudentPersonBS()
    {
        //ถ้ามีการจัดเรียง
        $order = " ORDER BY\n" .
            "	edu_name ASC,\n" .
            "	std.std_class ASC,\n" .
            "	std.std_code ASC";
        $isNotNull = "WHERE sp.std_per_id IS NOT NULL AND std.std_id IS NOT NULL";
        $user_condition = " AND u.id = " . $_SESSION['user_data']->id . "\n";
        $address = "";
        $admin_join = "LEFT JOIN tb_users u ON sp.user_create = u.id\n" .
            "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";

        $edu_name = "";

        $std_class = "";
        if ($_SESSION['user_data']->role_id == 1 || $_SESSION['user_data']->role_id == 2) {
            $user_condition = "";
        }
        if (isset($_REQUEST['std_class']) && !empty($_REQUEST['std_class'])) {
            $std_class = " AND ";
            $std_class .= "   std.std_class = '" . $_REQUEST['std_class'] . "' \n";
        }

        $where_address = "";
        if ($_SESSION['user_data']->role_id == 1 || $_SESSION['user_data']->role_id == 2) {
            $address = ", ( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province, \n" .
                "   CONCAT(u.name,' ',u.surname) user_create_name \n";

            require_once("../../config/main_function.php");
            $mainFunc = new ClassMainFunctions();
            $start = " AND ";
            // if (empty($user_condition) && empty($std_class)) {
            //     $start = " WHERE ";
            // }
            $where_address =  $mainFunc->getSqlFindAddress($start);
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM stf_tb_form_student_person_new sp \n";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	sp.std_per_id,\n" .
            "	CONCAT( std.std_prename,std.std_name) std_name,\n" .
            "	std.std_class,\n" .
            "	std.std_code,\n" .
            "	CONCAT( u.NAME, ' ', u.surname ) user_create_data,\n" .
            "	( SELECT COUNT( learn_analys_id ) FROM stf_tb_learn_analysis WHERE std_per_id = sp.std_per_id LIMIT 1 ) count_learn_analys,\n" .
            "	( SELECT learn_analys_id FROM stf_tb_learn_analysis WHERE std_per_id = sp.std_per_id LIMIT 1 ) learn_analys_id,\n" .
            "	edu.NAME edu_name\n" .
            $address .
            "FROM\n" .
            "	stf_tb_form_student_person_new sp\n" .
            // "	LEFT JOIN tb_users u ON sp.user_create = u.id\n" .
            // "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
            "	LEFT JOIN tb_students std ON sp.std_id = std.std_id \n" .
            $admin_join .
            $isNotNull . $user_condition;

        $sql_total = $sql . $std_class . $where_address . " $order ";
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $limit = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $std_class . $where_address  . " $order " . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }

    function updateFMname($arr_data)
    {
        $sql =  "UPDATE tb_students SET std_father_name = :father_name, std_mather_name = :mather_name, std_father_job = :father_job, std_mather_job = :mather_job, std_father_phone = :father_phone, std_mather_phone = :mather_phone WHERE std_id = :std_id";
        $this->db->Update($sql, $arr_data);
    }
}
