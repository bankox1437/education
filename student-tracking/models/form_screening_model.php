<?php
include "../../config/main_function.php";
class FormScreeningStudentModel
{
    private $db;

    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function InsertFormScreening($arr_data = [])
    {
        $sql = "INSERT INTO stf_tb_form_screening_students(std_id,user_create)\n" .
            "VALUES (:std_id,:user_create)";
        $data = $this->db->InsertLastID($sql, $arr_data);
        return (int)$data;
    }

    public function InsertFormSide1($arr_data = [])
    {
        $sql = "INSERT INTO stf_tb_form_screening_side_1\n" .
            "( status, side_1_1, side_1_2, side_1_3, side_1_4, side_1_5, side_1_6,\n" .
            " side_1_7, side_1_8, side_1_9, side_1_10, side_1_11, side_1_12, side_1_1_1_have,screening_id) \n" .
            "VALUES (:status, :side_1_1, :side_1_2, :side_1_3, :side_1_4, :side_1_5, :side_1_6,\n" .
            " :side_1_7, :side_1_8, :side_1_9, :side_1_10, :side_1_11, :side_1_12, :side_1_1_1_have,:screening_id)";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    public function UpdateFormSide1($arr_data = [])
    {
        $sql = "UPDATE stf_tb_form_screening_side_1 \n" .
            "SET \n" .
            "status = :status,\n" .
            "side_1_1 = :side_1_1,\n" .
            "side_1_2 = :side_1_2,\n" .
            "side_1_3 = :side_1_3,\n" .
            "side_1_4 = :side_1_4,\n" .
            "side_1_5 = :side_1_5,\n" .
            "side_1_6 = :side_1_6,\n" .
            "side_1_7 = :side_1_7,\n" .
            "side_1_8 = :side_1_8,\n" .
            "side_1_9 = :side_1_9,\n" .
            "side_1_10 = :side_1_10,\n" .
            "side_1_11 = :side_1_11,\n" .
            "side_1_12 = :side_1_12,\n" .
            "side_1_1_1_have = :side_1_1_1_have \n" .
            "WHERE\n" .
            "	screening_id = :screening_id;";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function InsertFormSide2($arr_data = [])
    {
        $sql = "INSERT INTO stf_tb_form_screening_side_2\n" .
            "(status, side_2_1, side_2_2, side_2_3, side_2_4, side_2_5, side_2_6,\n" .
            "side_2_7, side_2_8, side_2_9, side_2_10, side_2_11, side_2_12, side_2_13, side_2_14, side_2_15,\n" .
            "side_2_16, side_2_17, side_2_18, side_2_19, side_2_20, side_2_21, side_2_22, side_2_23, side_2_24,screening_id) \n" .
            "VALUES (:status, :side_2_1, :side_2_2, :side_2_3, :side_2_4, :side_2_5, :side_2_6,\n" .
            ":side_2_7, :side_2_8, :side_2_9, :side_2_10, :side_2_11, :side_2_12, :side_2_13, :side_2_14, :side_2_15,\n" .
            ":side_2_16, :side_2_17, :side_2_18, :side_2_19, :side_2_20, :side_2_21, :side_2_22, :side_2_23, :side_2_24,:screening_id);";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    public function UpdateFormSide2($arr_data = [])
    {
        $sql = "UPDATE stf_tb_form_screening_side_2 \n" .
            "SET \n" .
            "STATUS = :status,\n" .
            "side_2_1 = :side_2_1,\n" .
            "side_2_2 = :side_2_2,\n" .
            "side_2_3 = :side_2_3,\n" .
            "side_2_4 = :side_2_4,\n" .
            "side_2_5 = :side_2_5,\n" .
            "side_2_6 = :side_2_6,\n" .
            "side_2_7 = :side_2_7,\n" .
            "side_2_8 = :side_2_8,\n" .
            "side_2_9 = :side_2_9,\n" .
            "side_2_10 = :side_2_10,\n" .
            "side_2_11 = :side_2_11,\n" .
            "side_2_12 = :side_2_12,\n" .
            "side_2_13 = :side_2_13,\n" .
            "side_2_14 = :side_2_14,\n" .
            "side_2_15 = :side_2_15,\n" .
            "side_2_16 = :side_2_16,\n" .
            "side_2_17 = :side_2_17,\n" .
            "side_2_18 = :side_2_18,\n" .
            "side_2_19 = :side_2_19,\n" .
            "side_2_20 = :side_2_20,\n" .
            "side_2_21 = :side_2_21,\n" .
            "side_2_22 = :side_2_22,\n" .
            "side_2_23 = :side_2_23,\n" .
            "side_2_24 = :side_2_24 \n" .
            "WHERE\n" .
            "	screening_id = :screening_id";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function InsertFormSide3($arr_data = [])
    {
        $sql = "INSERT INTO stf_tb_form_screening_side_3(side_3_1, side_3_2, side_3_3, side_3_4, side_3_summary,screening_id) \n" .
            "VALUES (:side_3_1, :side_3_2, :side_3_3, :side_3_4, :side_3_summary,:screening_id)";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    public function UpdateFormSide3($arr_data = [])
    {
        $sql = "UPDATE stf_tb_form_screening_side_3 \n" .
            "SET side_3_1 = :side_3_1,\n" .
            "side_3_2 = :side_3_2,\n" .
            "side_3_3 = :side_3_3,\n" .
            "side_3_4 = :side_3_4,\n" .
            "side_3_summary = :side_3_summary \n" .
            "WHERE\n" .
            "	screening_id = :screening_id";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function InsertFormSide4($arr_data = [])
    {
        $sql = "INSERT INTO stf_tb_form_screening_side_4\n" .
            "(side_4_1_status, side_4_1_1, side_4_1_2, side_4_1_3,\n" .
            "side_4_1_4, side_4_1_5, side_4_1_6, side_4_1_7, side_4_1_8, side_4_2_status,\n" .
            "side_4_2_1, side_4_2_2, side_4_2_3, side_4_2_4, side_4_2_5, side_4_2_6, side_4_2_7,\n" .
            "side_4_2_8, side_4_2_9, side_4_2_10, side_4_2_11, side_4_2_12, side_4_2_13, side_4_2_14,screening_id) \n" .
            "VALUES ( :side_4_1_status, :side_4_1_1, :side_4_1_2, :side_4_1_3,\n" .
            ":side_4_1_4, :side_4_1_5, :side_4_1_6, :side_4_1_7, :side_4_1_8, :side_4_2_status,\n" .
            ":side_4_2_1, :side_4_2_2, :side_4_2_3, :side_4_2_4, :side_4_2_5, :side_4_2_6, :side_4_2_7,\n" .
            ":side_4_2_8, :side_4_2_9, :side_4_2_10, :side_4_2_11, :side_4_2_12, :side_4_2_13, :side_4_2_14,:screening_id)";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    public function UpdateFormSide4($arr_data = [])
    {
        $sql = "UPDATE stf_tb_form_screening_side_4 \n" .
            "SET side_4_1_status = :side_4_1_status,\n" .
            "side_4_1_1 = :side_4_1_1,\n" .
            "side_4_1_2 = :side_4_1_2,\n" .
            "side_4_1_3 = :side_4_1_3,\n" .
            "side_4_1_4 = :side_4_1_4,\n" .
            "side_4_1_5 = :side_4_1_5,\n" .
            "side_4_1_6 = :side_4_1_6,\n" .
            "side_4_1_7 = :side_4_1_7,\n" .
            "side_4_1_8 = :side_4_1_8,\n" .
            "side_4_2_status = :side_4_2_status,\n" .
            "side_4_2_1 = :side_4_2_1,\n" .
            "side_4_2_2 = :side_4_2_2,\n" .
            "side_4_2_3 = :side_4_2_3,\n" .
            "side_4_2_4 = :side_4_2_4,\n" .
            "side_4_2_5 = :side_4_2_5,\n" .
            "side_4_2_6 = :side_4_2_6,\n" .
            "side_4_2_7 = :side_4_2_7,\n" .
            "side_4_2_8 = :side_4_2_8,\n" .
            "side_4_2_9 = :side_4_2_9,\n" .
            "side_4_2_10 = :side_4_2_10,\n" .
            "side_4_2_11 = :side_4_2_11,\n" .
            "side_4_2_12 = :side_4_2_12,\n" .
            "side_4_2_13 = :side_4_2_13,\n" .
            "side_4_2_14 = :side_4_2_14 \n" .
            "WHERE\n" .
            "	screening_id = :screening_id";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function InsertFormSide5($arr_data = [])
    {
        $sql = "INSERT INTO stf_tb_form_screening_side_5 ( side_5_1, side_5_2, side_5_3,screening_id )\n" .
            "VALUES\n" .
            "	( :side_5_1, :side_5_2, :side_5_3,:screening_id )";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    public function UpdateFormSide5($arr_data = [])
    {
        $sql = "UPDATE stf_tb_form_screening_side_5 \n" .
            "SET side_5_1 = :side_5_1,\n" .
            "side_5_2 = :side_5_2,\n" .
            "side_5_3 = :side_5_3 \n" .
            "WHERE\n" .
            "	screening_id = :screening_id";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function getDataScreeningStd()
    {
        $main_func = new ClassMainFunctions();
        $colunm =  "	screening_id,\n" .
            "	std.std_code,\n" .
            "	\n" .
            "	std.std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	CONCAT( u.NAME, ' ', u.surname ) user_create_data,\n";
        $table = "stf_tb_form_screening_students screening ";
        $join =   "	LEFT JOIN tb_users u ON screening.user_create = u.id\n" .
            "	LEFT JOIN tb_role_users r ON u.role_id = r.role_id\n" .
            "	LEFT JOIN tb_students std ON screening.std_id = std.std_id \n";
        $order_by = "ORDER BY\n" .
            "	edu_name ASC,std.std_class ASC,\n" .
            "	std.std_code ASC";

        $arr_data = [];
        if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $arr_data = ['edu_id' => $_SESSION['user_data']->edu_id];
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu') {
            $arr_data = ['user_id' => $_SESSION['user_data']->id];
        } else if ($_SESSION['user_data']->role_id == 3) {
            $arr_data = ['user_id' => $_SESSION['user_data']->id];
        }
        return $main_func->getDataAll($table, $join, $order_by, $this->db, $colunm,  $arr_data);
    }

    public function deleteForm($id)
    {
        $sql = "DELETE FROM stf_tb_form_screening_side_1 WHERE screening_id = :id";
        $this->db->Delete($sql, ["id" => $id]);
        $sql = "DELETE FROM stf_tb_form_screening_side_2 WHERE screening_id = :id";
        $this->db->Delete($sql, ["id" => $id]);
        $sql = "DELETE FROM stf_tb_form_screening_side_3 WHERE screening_id = :id";
        $this->db->Delete($sql, ["id" => $id]);
        $sql = "DELETE FROM stf_tb_form_screening_side_4 WHERE screening_id = :id";
        $this->db->Delete($sql, ["id" => $id]);
        $sql = "DELETE FROM stf_tb_form_screening_side_5 WHERE screening_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_screening_students WHERE screening_id = :id";
        $data = $this->db->Delete($sql, ["id" => $id]);
        return $data;
    }

    public function getDataStdInFrom($form_id)
    {
        $sql = "SELECT\n" .
            "	scr.*,\n" .
            "	std.std_prename,\n" .
            "	std.std_name,\n" .
            "	\n" .
            "	std.std_class,\n" .
            "	std.std_code,\n" .
            "	CONCAT( u.NAME, ' ', u.surname ) u_name, \n" .
            "   DATE(scr.create_date) create_date_c\n" .
            "FROM\n" .
            "	stf_tb_form_screening_students scr\n" .
            "	LEFT JOIN tb_students std ON scr.std_id = std.std_id\n" .
            "	LEFT JOIN tb_users u ON scr.user_create = u.id \n" .
            "WHERE\n" .
            "	scr.screening_id = :form_id";
        $dataStdForm = $this->db->Query($sql, ['form_id' => $form_id]);
        if (count(json_decode($dataStdForm)) == 0) {
            $arr_data = [
                "status" => false
            ];
            return json_encode($arr_data);
        }
        $sql_side_1 = "SELECT * FROM stf_tb_form_screening_side_1 WHERE screening_id = :form_id";
        $data_side_1 = $this->db->Query($sql_side_1, ['form_id' => $form_id]);

        $sql_side_2 = "SELECT * FROM stf_tb_form_screening_side_2 WHERE screening_id = :form_id";
        $data_side_2 = $this->db->Query($sql_side_2, ['form_id' => $form_id]);

        $sql_side_3 = "SELECT * FROM stf_tb_form_screening_side_3 WHERE screening_id = :form_id";
        $data_side_3 = $this->db->Query($sql_side_3, ['form_id' => $form_id]);

        $sql_side_4 = "SELECT * FROM stf_tb_form_screening_side_4 WHERE screening_id = :form_id";
        $data_side_4 = $this->db->Query($sql_side_4, ['form_id' => $form_id]);

        $sql_side_5 = "SELECT * FROM stf_tb_form_screening_side_5 WHERE screening_id = :form_id";
        $data_side_5 = $this->db->Query($sql_side_5, ['form_id' => $form_id]);



        $arr_data = [
            "data_std_form" => json_decode($dataStdForm)[0],
            "side_1" => json_decode($data_side_1)[0],
            "side_2" => json_decode($data_side_2)[0],
            "side_3" => json_decode($data_side_3)[0],
            "side_4" => json_decode($data_side_4)[0],
            "side_5" => json_decode($data_side_5)[0],
            "status" => true
        ];

        return json_encode($arr_data);
    }

    public function getClassInDropdown()
    {
        $main_func = new ClassMainFunctions();
        $colunm =  "	std_class\n";
        $table = "	stf_tb_form_screening_students scr\n";
        $join =    "   LEFT JOIN tb_users u ON u.id = scr.user_create\n" .
            "	LEFT JOIN tb_students std ON scr.std_id = std.std_id\n";
        $group_by = "GROUP BY std_class";
        return $main_func->getDataClass($table, $join, $group_by, $colunm, $this->db);
    }

    public function getDataScreeningStdByClass($std_class, $sub_district_id, $district_id, $province_id)
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
        $colunm =  "	screening_id,\n" .
            "	std.std_code,\n" .
            "	\n" .
            "	std.std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	CONCAT( u.NAME, ' ', u.surname ) user_create_data,\n";
        $table = "stf_tb_form_screening_students screening ";
        $join =   "	LEFT JOIN tb_users u ON screening.user_create = u.id\n" .
            "	LEFT JOIN tb_role_users r ON u.role_id = r.role_id\n" .
            "	LEFT JOIN tb_students std ON screening.std_id = std.std_id \n";
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

    public function getDataScreeningStdByAmphur($std_class, $sub_district_id)
    {
        $std_class_where = ' ';
        $sub_district_id_where = ' edu.sub_district_id = :sub_district_id ';
        $option_and = ' AND ';
        $std_class;
        if ($std_class != '0') {
            $std_class_where .= 'std.std_class = :std_class ';
        } else {
            $option_and = ' ';
        }
        $where = "WHERE " . $std_class_where . $option_and . $sub_district_id_where;
        $main_func = new ClassMainFunctions();
        $colunm =  "	screening_id,\n" .
            "	std.std_code,\n" .
            "	\n" .
            "	std.std_prename,\n" .
            "	std.std_name,\n" .
            "	std.std_class,\n" .
            "	CONCAT( u.NAME, ' ', u.surname ) user_create_data,\n";
        $table = "stf_tb_form_screening_students screening ";
        $join =   "	LEFT JOIN tb_users u ON screening.user_create = u.id\n" .
            "	LEFT JOIN tb_role_users r ON u.role_id = r.role_id\n" .
            "	LEFT JOIN tb_students std ON screening.std_id = std.std_id \n";
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
            "	stf_tb_form_screening_students scr\n" .
            "	LEFT JOIN tb_users u ON u.id = scr.user_create\n" .
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
}
