<?php
include "../../config/main_function.php";
class FormEvaluatemodel
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function addEvaluate_student($array_data)
    {
        $sql = "INSERT INTO stf_tb_form_evaluate_students (\n" .
            "	std_id,note,\n" .
            "	side_1_score,side_2_score,side_3_score,side_4_score,sum_score,side_5_score,\n" .
            "	user_create \n" .
            ")\n" .
            "VALUES\n" .
            "	(\n" .
            "	:std_id,:note,\n" .
            "	:side_1_score,:side_2_score,:side_3_score,:side_4_score,:sum_score,:side_5_score,\n" .
            "	:user_create \n" .
            "	);";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function editEvaluate_student($array_data)
    {
        $sql = "UPDATE stf_tb_form_evaluate_students \n" .
            "SET \n" .
            "note = :note,\n" .
            "side_1_score = :side_1_score,\n" .
            "side_2_score = :side_2_score,\n" .
            "side_3_score = :side_3_score,\n" .
            "side_4_score = :side_4_score,\n" .
            "sum_score = :sum_score,\n" .
            "side_5_score = :side_5_score,\n" .
            "user_update = :user_update,\n" .
            "update_date = :update_date\n" .
            "WHERE\n" .
            "	form_evaluate_id = :form_id;";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function addBehavior($behavior_id, $status, $form_evaluate_id)
    {
        $sql = "INSERT INTO stf_tb_form_evaluate_student_detail (form_evaluate_id,behavior_id, STATUS )\n" .
            "VALUES\n" .
            "	(:form_evaluate_id, :behavior_id, :STATUS);";
        $data = $this->db->Insert($sql, ['form_evaluate_id' => $form_evaluate_id, 'behavior_id' => $behavior_id, "STATUS" => $status]);
        return $data;
    }

    public function UpdateBehavior($status, $form_evaluate_id)
    {
        $sql = "UPDATE stf_tb_form_evaluate_student_detail \n" .
            "SET \n" .
            "STATUS = :STATUS\n" .
            "WHERE\n" .
            "	form_evaluate_det_id = :form_evaluate_det_id";
        $data = $this->db->Update($sql, ["STATUS" => $status, 'form_evaluate_det_id' => $form_evaluate_id]);
        return $data;
    }

    public function getDataEvaluate()
    {
        $where = "";
        $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n" .
            "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        $address = "";
        $edu_name = "IFNULL( edu.NAME, edu_o.NAME ) edu_name \n";
        if ($_SESSION['user_data']->role_id == 3) {
            $where .= "WHERE u.id = :user_id\n";
        }
        if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu') {
            $where .= "WHERE edu.district_id = ( SELECT district_id FROM tb_users us LEFT JOIN tbl_non_education edu ON us.edu_id = edu.id WHERE us.id = :user_id) \n";
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $where .= "WHERE edu_o.id = :edu_id\n";
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
            "	eva.form_evaluate_id,\n" .
            "   std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	std.std_code,\n" .
            "   CONCAT(u.name,' ',u.surname) user_create_data,\n" .
            $edu_name .
            $address .
            "FROM\n" .
            "	stf_tb_form_evaluate_students eva\n" .
            "	LEFT JOIN tb_users u ON eva.user_create = u.id\n" .
            $joinEDU .
            "	LEFT JOIN tb_students std ON eva.std_id = std.std_id \n" .
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

        return json_decode($data);
    }

    public function deleteEvaluateData($form_eva_id)
    {
        $sql = "DELETE FROM stf_tb_form_evaluate_student_detail WHERE form_evaluate_id = :form_eva_id";
        $this->db->Delete($sql, ["form_eva_id" => $form_eva_id]);

        $sql = "DELETE FROM stf_tb_form_evaluate_students WHERE form_evaluate_id = :form_eva_id";
        $data = $this->db->Delete($sql, ["form_eva_id" => $form_eva_id]);
        return $data;
    }


    public function getClassInDropdown()
    {
        $where = "";
        $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n" .
            "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        if ($_SESSION['user_data']->role_id == 3) {
            $where .= "WHERE u.id = :user_id\n";
        }
        if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu') {
            $where .= "WHERE edu.district_id = ( SELECT district_id FROM tb_users us LEFT JOIN tbl_non_education edu ON us.edu_id = edu.id WHERE us.id = :user_id) \n";
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $where .= "WHERE edu_o.id = :edu_id\n";
        }
        if ($_SESSION['user_data']->edu_type == 'edu_other') {
            $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n";
        } else if ($_SESSION['user_data']->edu_type == 'edu') {
            $joinEDU = "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        }
        $sql = "SELECT\n" .
            "	std_class \n" .
            "FROM\n" .
            "	stf_tb_form_evaluate_students eva\n" .
            "   LEFT JOIN tb_users u ON u.id = eva.user_create\n" .
            "	LEFT JOIN tb_students std ON eva.std_id = std.std_id\n" .
            $joinEDU . "\n" .
            $where . " GROUP BY std_class";

        if ($_SESSION['user_data']->role_id == 1) {
            $data = $this->db->Query($sql, []);
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $data = $this->db->Query($sql, ['edu_id' => $_SESSION['user_data']->edu_id]);
        } else {
            $data = $this->db->Query($sql, ['user_id' => $_SESSION['user_data']->id]);
        }
        return json_decode($data);
    }

    public function getDataEvaluateByStdClass($std_class, $sub_district_id, $district_id, $province_id)
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
        $colunm =   "	eva.form_evaluate_id,\n" .
            "   std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	std.std_code,\n" .
            "   CONCAT(u.name,' ',u.surname) user_create_data,\n";
        $table = "stf_tb_form_evaluate_students eva ";
        $join = "	LEFT JOIN tb_users u ON eva.user_create = u.id\n" .
            "	LEFT JOIN tb_students std ON eva.std_id = std.std_id \n";
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

    public function getDataEvaluateByAmphur($std_class, $sub_district_id)
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
        $colunm =   "	eva.form_evaluate_id,\n" .
            "   std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	std.std_code,\n" .
            "   CONCAT(u.name,' ',u.surname) user_create_data,\n";
        $table = "stf_tb_form_evaluate_students eva ";
        $join = "	LEFT JOIN tb_users u ON eva.user_create = u.id\n" .
            "	LEFT JOIN tb_students std ON eva.std_id = std.std_id \n";
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
            "	stf_tb_form_evaluate_students eva\n" .
            "	LEFT JOIN tb_users u ON u.id = eva.user_create\n" .
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

    public function getdataedit($eva_id)
    {
        $sql = "SELECT * ,\n" .
            "eva_det.form_evaluate_det_id,\n" .
            "eva_det.behavior_id,\n" .
            "eva_det.`status`,\n" .
            "b.*\n" .
            "FROM stf_tb_form_evaluate_student_detail eva_det\n" .
            "LEFT JOIN  stf_tb_behavior b  ON eva_det.behavior_id = b.behavior_id\n" .
            "LEFT JOIN stf_tb_form_evaluate_students eva ON eva_det.form_evaluate_id = eva.form_evaluate_id\n" .
            "WHERE eva.form_evaluate_id = :eva_id";
        $data = $this->db->Query($sql, ['eva_id' => $eva_id]);
        return json_decode($data);
    }
}
