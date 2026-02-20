<?php
include "../../config/main_function.php";
class after_gradiate_model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function addAfterGradiate($arr_data)
    {
        $whereedu_qualification_school = "";
        $whereedu_qualification_school_value = "";
        if (!empty($arr_data['edu_qualification_school_text'])) {
            $whereedu_qualification_school = "edu_qualification_school,";
            $whereedu_qualification_school_value = "'" . $arr_data['edu_qualification_school_text'] . "',";
            unset($arr_data['edu_qualification_school_text']);
        }
        $sql = "INSERT INTO stf_tb_after_gradiate (std_id, end_year, end_class, edu_qualification," . $whereedu_qualification_school . " visit_edu, cooperate_edu, satisfaction, user_create )\n" .
            "VALUES\n" .
            "	(:std_id, :end_year, :end_class, :edu_qualification," . $whereedu_qualification_school_value . " :visit_edu, :cooperate_edu, :satisfaction, :user_create);";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    public function editAfterGradiate($arr_data)
    {
        $whereedu_qualification_school = "";

        if (!empty($arr_data['edu_qualification_school_text'])) {
            $whereedu_qualification_school = "edu_qualification_school = '" . $arr_data['edu_qualification_school_text'] . "',";
            unset($arr_data['edu_qualification_school_text']);
        }
        $sql = "UPDATE stf_tb_after_gradiate SET end_year = :end_year, end_class = :end_class, edu_qualification = :edu_qualification,$whereedu_qualification_school\n" .
            " visit_edu = :visit_edu, cooperate_edu = :cooperate_edu , satisfaction = :satisfaction WHERE after_id = :after_id";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function deleteAfterGradiate($after_id)
    {
        $sql = "DELETE FROM stf_tb_after_gradiate WHERE after_id = :after_id";
        $data = $this->db->Delete($sql, ["after_id" => $after_id]);
        return $data;
    }

    public function getDataAfterGra()
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

        if ($_SESSION['user_data']->role_id == 4) {
            $where .= " WHERE std.std_id = " . $_REQUEST['std_id'] . " \n";
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
            "	after_g.after_id,\n" .
            "   after_g.end_year,\n" .
            "   std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	std.std_code,\n" .
            "   CONCAT(u.name,' ',u.surname) user_create_data,\n" .
            $edu_name .
            $address .
            "FROM\n" .
            "	stf_tb_after_gradiate after_g\n" .
            "	LEFT JOIN tb_users u ON after_g.user_create = u.id\n" .
            $joinEDU .
            "	LEFT JOIN tb_students std ON after_g.std_id = std.std_id \n" .
            $where .
            "ORDER BY\n" .
            "	edu_name ASC,std.std_class ASC,\n" .
            "	std.std_code ASC";

        if ($_SESSION['user_data']->role_id == 1) {
            $data = $this->db->Query($sql, []);
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $data = $this->db->Query($sql, ['edu_id' => $_SESSION['user_data']->edu_id]);
        } else {
            $data = $this->db->Query($sql, ['user_id' => $_SESSION['user_data']->id]);
        }

        return [json_decode($data), $sql];
    }

    public function getDataAfterGraByAmphur($std_class, $sub_district_id)
    {
        $std_class_where = '';
        $sub_district_id_where = ' edu.sub_district_id = :sub_district_id ';
        $option_and = ' AND ';
        if ($std_class != '0') {
            $std_class_where .= 'std.std_class = :std_class ';
        } else {
            $option_and = ' ';
        }
        $where = "WHERE $std_class_where  $option_and $sub_district_id_where";
        $main_func = new ClassMainFunctions();
        $colunm =   "	after_g.after_id,\n" .
            "   std.std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	std.std_code,\n" .
            "   after_g.end_year,\n" .
            "	\n" .
            "   CONCAT(u.name,' ',u.surname) user_create_data,\n";
        $table = "stf_tb_after_gradiate after_g \n";
        $join = "	LEFT JOIN tb_users u ON after_g.user_create = u.id\n" .
            "	LEFT JOIN tb_students std ON after_g.std_id = std.std_id \n";
        $order_by = "ORDER BY\n" .
            "	edu_name ASC,std.std_class ASC,\n" .
            "	std.std_code ASC";
        $arr_data = [];
        if ($std_class != '0') {
            $arr_data['std_class'] = $std_class;
        }
        if ($_SESSION['user_data']->role_id == 2) {
            $arr_data['sub_district_id'] = $sub_district_id;
        } else {
            if ($sub_district_id != '0') {
                $arr_data['sub_district_id'] = $sub_district_id;
            }
            $arr_data['user_id'] = $_SESSION['user_data']->id;
        }
        return $main_func->getDataAll($table, $join, $order_by, $this->db, $colunm,  $arr_data, $where);
    }


    public  function searchDataafterGra($std_class, $sub_district_id, $pro_id, $dis_id)
    {
        if ($_SESSION['user_data']->role_id == 3 || $_SESSION['user_data']->role_id == 2) {
            $session_user = ['user_id' => $_SESSION['user_data']->id];
        } else {
            $session_user = [];
        }
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

        $std_class_where = '';
        $sub_district_id_where = '';
        $option_and = ' ';
        if ($_SESSION['user_data']->role_id != 3) {
            $option_and = ' AND ';
            $sub_district_id_where = ' edu.sub_district_id = ' . $sub_district_id . " ";
        }

        if ($std_class != '0') {
            $std_class_where .= "std.std_class = '" . $std_class . "' ";
        } else {
            $option_and = ' ';
        }
        if (($sub_district_id == '0' || $sub_district_id == 0) && $_SESSION['user_data']->role_id == 2) {
            $sub_district_id = $_SESSION['user_data']->district_am_id;
            $sub_district_id_where = " edu.district_id = " . $sub_district_id . ' ';
        }
        $whereSearch = " AND $std_class_where  $option_and $sub_district_id_where";

        if ($_SESSION['user_data']->role_id == 1) {
            if ($pro_id != 0 && $dis_id == 0 && $sub_district_id == 0) {
                $sub_district_id_where = 'edu.province_id = ' . $pro_id . ' ';
            } else if ($pro_id != 0 && $dis_id != 0 && $sub_district_id == 0) {
                $sub_district_id_where = 'edu.province_id = ' . $pro_id . ' AND ';
                $sub_district_id_where .= 'edu.district_id = ' . $dis_id . ' ';
            } else if ($pro_id != 0 && $dis_id != 0 && $sub_district_id != 0) {
                $sub_district_id_where = 'edu.province_id = ' . $pro_id . ' AND ';
                $sub_district_id_where .= 'edu.district_id = ' . $dis_id . ' AND ';
                $sub_district_id_where .= 'edu.sub_district_id = ' . $sub_district_id .  ' ';
            }
            $whereSearch = " WHERE $std_class_where $option_and $sub_district_id_where";
        }

        $sql = "SELECT\n" .
            "	after_g.after_id,\n" .
            "   after_g.end_year,\n" .
            "   std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	std.std_code,\n" .
            "   CONCAT(u.name,' ',u.surname) user_create_data,\n" .
            $edu_name .
            $address .
            "FROM\n" .
            "	stf_tb_after_gradiate after_g\n" .
            "	LEFT JOIN tb_users u ON after_g.user_create = u.id\n" .
            $joinEDU .
            "	LEFT JOIN tb_students std ON after_g.std_id = std.std_id \n" .
            $where . $whereSearch .
            "ORDER BY\n" .
            "	edu_name ASC,std.std_class ASC,\n" .
            "	std.std_code ASC";


        $data = $this->db->Query($sql, $session_user);
        return [json_decode($data), $sql];
    }

    public function getClassInDropdown()
    {
        $where = "";
        $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n" .
            "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        if ($_SESSION['user_data']->role_id == 3) {
            $where .= "WHERE u.id = :user_id\n";
        }
        if ($_SESSION['user_data']->role_id == 2) {
            $where .= "WHERE edu.district_id = ( SELECT district_am_id FROM tb_users us LEFT JOIN tbl_non_education edu ON us.edu_id = edu.id WHERE us.id = :user_id) \n";
        }
        if ($_SESSION['user_data']->edu_type == 'edu_other') {
            $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n";
        } else if ($_SESSION['user_data']->edu_type == 'edu') {
            $joinEDU = "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        }
        $sql = "SELECT\n" .
            "	std_class \n" .
            "FROM\n" .
            "	stf_tb_after_gradiate after_g\n" .
            "   LEFT JOIN tb_users u ON u.id = after_g.user_create\n" .
            "	LEFT JOIN tb_students std ON after_g.std_id = std.std_id\n" .
            $joinEDU . "\n" .
            $where . " GROUP BY std_class";

        if ($_SESSION['user_data']->role_id == 1) {
            $data = $this->db->Query($sql, []);
        } else {
            $data = $this->db->Query($sql, ['user_id' => $_SESSION['user_data']->id]);
        }
        return [json_decode($data), $sql];
    }
}
