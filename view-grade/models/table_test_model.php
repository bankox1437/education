<?php

class TableTestModel
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function getDataTableTest()
    {
        $std_class = "";
        if (isset($_REQUEST['std_class']) && !empty($_REQUEST['std_class'])) {
            $std_class = "  tt.std_class = '" . $_REQUEST['std_class'] . "' ";
        }

        //ถ้ามีการจัดเรียง
        $order = " tt.term_id ASC, tt.std_id ASC ";
        if (isset($_REQUEST['sort'])) {
            $order = "std." . $_REQUEST['sort'] . " " . $_REQUEST['order'];
        }


        $term_name = " tt.term_id = " . $_SESSION['term_active']->term_id . " \n";
        if (isset($_REQUEST['term_id']) && $_REQUEST['term_id'] != "0") {
            if (empty($std_class)) {
                $term_name = " tt.term_id = " . $_REQUEST['term_id'] . " \n";
            } else {
                $term_name = " AND tt.term_id = " . $_REQUEST['term_id'] . " \n";
            }
        } else  if (isset($_REQUEST['term_id']) && $_REQUEST['term_id'] == "0") {
            $term_name = " ";
        }

        $user_condition = " tt.user_create = " . $_SESSION['user_data']->id . "\n";
        $address = "";
        $admin_join = "";
        $where_address = "";
        if ($_SESSION['user_data']->role_id == 1) {
            $user_condition = "";
            $address = ", ( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province, \n" .
                "   CONCAT(u.name,' ',u.surname) user_create_name \n";
            $admin_join = "LEFT JOIN tb_users u ON tt.user_create = u.id\n" .
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
            // if (empty($std_class) && $term_name == " " && $user_condition_and == " ") {
            //     $search = " CONCAT( term.term, '/', term.`year` ) LIKE '%" . $_REQUEST['search'] . "%'";
            // } else {
            //     $search = " AND CONCAT( term.term, '/', term.`year` ) LIKE '%" . $_REQUEST['search'] . "%'";
            // }
              if (empty($std_class) && $term_name == " " && $user_condition_and == " ") {
                $search = " CONCAT ( std.std_prename, std.std_name ) LIKE '%" . $_REQUEST['search'] . "%'";
            } else {
                $search = " AND CONCAT ( std.std_prename, std.std_name ) LIKE '%" . $_REQUEST['search'] . "%'";
            }
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT\n" .
            "	COUNT(*) totalnotfilter \n" .
            "FROM\n" .
            "	vg_table_test tt\n" .
            $whereTotal;
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	tt.*,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            "   std.std_code,tt.std_class \n" .
            $address .
            "FROM\n" .
            "	vg_table_test tt\n" .
            "	LEFT JOIN vg_terms term ON tt.term_id = term.term_id\n" .
            "   LEFT JOIN tb_students std ON tt.std_id = std.std_id\n" .
            $admin_join .
            "WHERE\n" . $std_class . $term_name . $user_condition_and;
        $sql_total = $sql . $search . $where_address . " ORDER BY $order ";
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $search  . $where_address . " ORDER BY $order " . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }

    function insertTableTest($arr_data)
    {
        $sql = "INSERT INTO vg_table_test(std_id,term_id,std_class,file_name,user_create) VALUES (:std_id,:term_id,:std_class,:file_name,:user_create)";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    function UpdateTableTest($arr_data)
    {
        $sql = "UPDATE vg_table_test SET file_name = :file_name WHERE t_test_id = :t_test_id";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function deleteTableTest($t_test_id)
    {
        $sql = "DELETE FROM vg_table_test WHERE t_test_id = :t_test_id";
        $data = $this->db->Delete($sql, ["t_test_id" => $t_test_id]);
        return $data;
    }

    function stdGetDataTableTest()
    {
        // $std_class = "";
        // if (isset($_REQUEST['std_class']) && !empty($_REQUEST['std_class'])) {
        //     $std_class = " AND tt.std_class = '" . $_REQUEST['std_class'] . "' ";
        // }

        $term_name = "";
        if (isset($_REQUEST['term_name']) && !empty($_REQUEST['term_name'])) {
            $term_name = " AND CONCAT( term.term, '/', term.`year` ) = '" . $_REQUEST['term_name'] . "' ";
        }

        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search'])) {
            $search = " AND CONCAT( term.term, '/', term.`year` ) LIKE '%" . $_REQUEST['search'] . "%'";
        }

        //ถ้ามีการจัดเรียง
        $order = " tt.term_id ASC ";
        if (isset($_REQUEST['sort'])) {
            $order = "tt.term_id " . $_REQUEST['order'];
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter " .
            "FROM\n" .
            " vg_table_test tt\n" .
            "   LEFT JOIN tb_students std ON tt.std_id = std.std_id \n" .
            "WHERE\n" .
            " tt.std_id = :std_id";
        $totalnotfilter = $this->db->Query($sql_order, ['std_id' => $_SESSION['user_data']->edu_type]);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            " tt.*,\n" .
            " CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            " CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            " std.std_code,tt.std_class \n" .
            "FROM\n" .
            " vg_table_test tt\n" .
            " LEFT JOIN vg_terms term ON tt.term_id = term.term_id\n" .
            " LEFT JOIN tb_students std ON tt.std_id = std.std_id\n" .
            "WHERE\n" .
            " tt.std_id = :std_id " . $term_name;
        $sql_total = $sql . $search . " ORDER BY $order ";
        $total_result = $this->db->Query($sql_total, ['std_id' => $_SESSION['user_data']->edu_type]);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $search  . " ORDER BY $order " . $limit;
        $data_result = $this->db->Query($sql, ['std_id' => $_SESSION['user_data']->edu_type]);
        return [$total, $totalnotfilter, json_decode($data_result)];
    }
}
