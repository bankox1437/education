<?php

class Credit_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function insertCredit($arr_data)
    {
        $sql = "INSERT INTO vg_credit(std_id, term_id,user_create) VALUES (:std_id, :term_id, :user_create)";
        $data = $this->db->InsertLastID($sql, $arr_data);
        return $data;
    }

    function insertCompulsory($arr_data)
    {
        $sql = "INSERT INTO vg_credit_compulsory(sub_id, sub_name, credit, grade, credit_id) VALUES (:sub_id, :sub_name, :credit, :grade, :credit_id);";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    function insertElectives($arr_data)
    {
        $sql = "INSERT INTO vg_credit_electives(sub_id, sub_name, credit, grade, credit_id) VALUES (:sub_id, :sub_name, :credit, :grade, :credit_id);";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    function insertFreeElectives($arr_data)
    {
        $sql = "INSERT INTO vg_credit_free_electives(sub_id, sub_name, credit, grade, credit_id) VALUES (:sub_id, :sub_name, :credit, :grade, :credit_id);";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }


    function updateCompulsory($arr_data, $id)
    {
        $arr_data['compulsory_id'] = $id;
        $sql = "UPDATE vg_credit_compulsory SET sub_id = :sub_id, sub_name = :sub_name, credit = :credit, grade = :grade  WHERE compulsory_id = :compulsory_id;";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    function updateElectives($arr_data, $id)
    {
        $arr_data['elective_id'] = $id;
        $sql = "UPDATE vg_credit_electives SET sub_id = :sub_id, sub_name = :sub_name, credit = :credit, grade = :grade  WHERE elective_id = :elective_id;";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    function updateFreeElectives($arr_data, $id)
    {
        $arr_data['free_electives_id'] = $id;
        $sql = "UPDATE vg_credit_free_electives SET sub_id = :sub_id, sub_name = :sub_name, credit = :credit, grade = :grade  WHERE free_electives_id = :free_electives_id;";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    // ------------------------------set--------------------------------------

    function insertCreditSet($arr_data)
    {
        $sql = "INSERT INTO vg_credit_set(set_name,user_create) VALUES (:set_name, :user_create)";
        $data = $this->db->InsertLastID($sql, $arr_data);
        return $data;
    }

    function insertSetCompulsory($arr_data)
    {
        $sql = "INSERT INTO vg_credit_set_compulsory(sub_id, sub_name,credit,set_id) VALUES (:sub_id, :sub_name,:credit, :set_id);";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    function insertSetElectives($arr_data)
    {
        $sql = "INSERT INTO vg_credit_set_electives(sub_id, sub_name,credit,set_id) VALUES (:sub_id, :sub_name,:credit, :set_id);";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    function insertSetFreeElectives($arr_data)
    {
        $sql = "INSERT INTO vg_credit_set_free_electives(sub_id, sub_name,credit,set_id) VALUES (:sub_id, :sub_name,:credit, :set_id);";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    function getSubjectSet($table, $set_id)
    {
        $sql = "SELECT * FROM $table WHERE set_id = :set_id";
        $result = $this->db->Query($sql, ["set_id" => $set_id]);
        $result = json_decode($result);
        return $result;
    }

    function getDataCreditSet()
    {
        //ถ้ามีการค้นหา
        $search = "";
        if (isset($_REQUEST['search'])) {
            $search = " AND credit_set.set_name LIKE '%" . $_REQUEST['search'] . "%'\n";
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM vg_credit_set credit_set ";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;

        $sql = "SELECT * FROM \n" .
            "	vg_credit_set credit_set \n" .
            "WHERE credit_set.user_create = " . $_SESSION['user_data']->id;

        $sql_total = $sql . $search;
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $search . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }

    public function deleteCreditSet($set_id)
    {
        $sql = "DELETE FROM vg_credit_set WHERE set_id = :set_id";
        $data = $this->db->Delete($sql, ["set_id" => $set_id]);
        return $data;
    }

    function updateCreditSet($set_name, $id)
    {
        $sql = "UPDATE vg_credit_set SET set_name = :set_name  WHERE set_id = :set_id;";
        $data = $this->db->Update($sql, ["set_name" => $set_name, "set_id" => $id]);
        return $data;
    }

    function updateCompulsorySet($arr_data, $id)
    {
        $arr_data['compulsory_id'] = $id;
        $sql = "UPDATE vg_credit_set_compulsory SET sub_id = :sub_id, sub_name = :sub_name, credit = :credit  WHERE compulsory_id = :compulsory_id;";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    function updateElectivesSet($arr_data, $id)
    {
        $arr_data['elective_id'] = $id;
        $sql = "UPDATE vg_credit_set_electives SET sub_id = :sub_id, sub_name = :sub_name, credit = :credit  WHERE elective_id = :elective_id;";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    function updateFreeElectivesSet($arr_data, $id)
    {
        $arr_data['free_electives_id'] = $id;
        $sql = "UPDATE vg_credit_set_free_electives SET sub_id = :sub_id, sub_name = :sub_name, credit = :credit  WHERE free_electives_id = :free_electives_id;";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    // -----------------------------end set---------------------------------------

    function getDataCredit()
    {

        $std_class = "";
        if (isset($_REQUEST['std_class']) && !empty($_REQUEST['std_class'])) {
            $std_class = " std.std_class = '" . $_REQUEST['std_class'] . "' ";
        }

        //ถ้ามีการจัดเรียง
        $order = " std.std_code ASC ";
        if (isset($_REQUEST['sort'])) {
            $order = "std." . $_REQUEST['sort'] . " " . $_REQUEST['order'];
        }

        $term_name = " ";
        // $term_name = " credit.term_id = " . $_SESSION['term_active']->term_id . " \n";
        // if (isset($_REQUEST['term_id']) && $_REQUEST['term_id'] != "0") {
        //     if (empty($std_class)) {
        //         $term_name = " credit.term_id = " . $_REQUEST['term_id'] . " \n";
        //     } else {
        //         $term_name = " AND credit.term_id = " . $_REQUEST['term_id'] . " \n";
        //     }
        // } else  if (isset($_REQUEST['term_id']) && $_REQUEST['term_id'] == "0") {
        //     $term_name = " ";
        // }

        $user_condition = " credit.user_create = " . $_SESSION['user_data']->id . "\n";
        $address = "";
        $admin_join = "";
        $where_address = "";
        if ($_SESSION['user_data']->role_id == 1) {
            $user_condition = "";
            $address = ", ( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province, \n" .
                "   CONCAT(u.name,' ',u.surname) user_create_name \n";
            $admin_join = "LEFT JOIN tb_users u ON credit.user_create = u.id\n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";


            require_once("../../config/main_function.php");
            $mainFunc = new ClassMainFunctions();
            $where_address =  $mainFunc->getSqlFindAddress();
        }

        $whereTotal = "";
        $user_condition_and = " ";
        if (!empty($user_condition)) {
            if (empty($std_class) && $term_name == " ") {
                $user_condition_and = $user_condition;
            } else {
                $user_condition_and = " AND " . $user_condition;
            }

            $whereTotal = " WHERE " . $user_condition;
        }

        //ถ้ามีการค้นหา
        $search = "";
        if (isset($_REQUEST['search'])) {
            if (empty($std_class) && $term_name == " " && $user_condition_and == " ") {
                $search = " ( CONCAT(std_prename, std.std_name ) LIKE '%" . $_REQUEST['search'] . "%' )\n";
            } else {
                $search = " AND ( CONCAT(std_prename, std.std_name ) LIKE '%" . $_REQUEST['search'] . "%' )\n";
            }
            // $search .= " OR CONCAT( term.term, '/', term.`year` ) LIKE '%" . $_REQUEST['search'] . "%' ) ";
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM vg_credit credit \n" .
            $whereTotal;
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	credit.credit_id,\n" .
            // "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            "	std.std_code,\n" .
            "	std.std_class, \n" .
            "	std.std_id \n" .
            $address .
            "FROM\n" .
            "	vg_credit credit\n" .
            // "	LEFT JOIN vg_terms term ON credit.term_id = term.term_id\n" .
            "	LEFT JOIN tb_students std ON credit.std_id = std.std_id \n" .
            $admin_join .
            "WHERE\n" . $std_class . $term_name . $user_condition_and;

        $sql_total = $sql . $search  . $where_address . " group by credit.std_id ORDER BY $order ";
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $search   . $where_address . " group by credit.std_id ORDER BY $order " . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }

    function updateCredit($arr_data)
    {
        $sql = "UPDATE vg_credit SET compulsory_subjects = :compulsory_subjects, elective_subjects = :elective_subjects, free_electives = :free_electives WHERE credit_id = :credit_id";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function deleteCredit($credit_id)
    {
        $sql = "DELETE FROM vg_credit WHERE credit_id = :credit_id";
        $data = $this->db->Delete($sql, ["credit_id" => $credit_id]);
        return $data;
    }

    public function removeRowUpdate($table, $column, $id)
    {
        $sql = "DELETE FROM " . $table . " WHERE " . $column . " = :id";
        $data = $this->db->Delete($sql, ["id" => $id]);
        return $data;
    }

    public function removeRowUpdateSet($table, $column, $id)
    {
        $sql = "DELETE FROM " . $table . " WHERE " . $column . " = :id";
        $data = $this->db->Delete($sql, ["id" => $id]);
        return $data;
    }

    function getCreditByTermId($term_id)
    {
        $sql = "SELECT * FROM vg_credit WHERE current = 1 AND user_create = :user_create";
        $result = $this->db->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
        $result = json_decode($result);

        if (count($result) > 0) {
            $sql = "UPDATE vg_credit SET current = 0 WHERE  term_id = :term_id AND user_create = :user_create";
            $this->db->Update($sql,  ["term_id" => $result[0]->term_id, "user_create" => $_SESSION['user_data']->id]);
        }

        $sql = "UPDATE vg_credit SET current = 1 WHERE  term_id = :term_id AND user_create = :user_create";
        $this->db->Update($sql,  ["term_id" => $term_id, "user_create" => $_SESSION['user_data']->id]);
    }
}
