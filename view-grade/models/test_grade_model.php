<?php

class TestGradeModel
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function getDataTestGrade()
    {
        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search'])) {
            $search = " WHERE ( CONCAT(std_prename, std.std_name ) LIKE '%" . $_REQUEST['search'] . "%' ";
            $search .= " OR CONCAT( term.term, '/', term.`year` ) LIKE '%" . $_REQUEST['search'] . "%' )";
        }

        //ถ้ามีการจัดเรียง
        $order = " tg.term_id ASC, std.std_code ASC ";
        if (isset($_REQUEST['sort'])) {
            $order = "std." . $_REQUEST['sort'] . " " . $_REQUEST['order'];
        }

        $format = " format = 0 ";
        if (isset($_REQUEST['format'])) {
            $format = " format = " . $_REQUEST['format'];
        }

        $term_name = " AND tg.term_id = " . $_SESSION['term_active']->term_id . " \n";
        if (isset($_REQUEST['term_id']) && $_REQUEST['term_id'] != "0") {
            $term_name = " AND tg.term_id = " . $_REQUEST['term_id'] . " \n";
        } else  if (isset($_REQUEST['term_id']) && $_REQUEST['term_id'] == "0") {
            $term_name = " ";
        }

        $user_condition = " tg.user_create = " . $_SESSION['user_data']->id . "\n";
        $address = "";
        $admin_join = "";
        $where_address = "";
        if ($_SESSION['user_data']->role_id == 1) {
            $user_condition = "";
            $address = ", ( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province, \n" .
                "   CONCAT(u.name,' ',u.surname) user_create_name \n";
            $admin_join = "LEFT JOIN tb_users u ON tg.user_create = u.id\n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";


            require_once("../../config/main_function.php");
            $mainFunc = new ClassMainFunctions();
            $where_address =  $mainFunc->getSqlFindAddress();
        }

        $whereTotal = "";
        $user_condition_and = " ";
        if (!empty($user_condition)) {
            $user_condition_and = " AND " . $user_condition;
            $whereTotal = " WHERE " . $user_condition;
        }
        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM vg_test_grade tg \n" .
            $whereTotal;
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	tg.*,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            "   std.std_code," .
            "	IFNULL(std.std_class,tg.std_id)  std_class \n" .
            $address .
            "FROM\n" .
            "	vg_test_grade tg\n" .
            "	LEFT JOIN vg_terms term ON tg.term_id = term.term_id\n" .
            "	LEFT JOIN tb_students std ON tg.std_id = std.std_id\n" . $admin_join;
        // "WHERE tg.user_create = :user_create";
        $sql_total = $sql . $search . $user_condition_and . $term_name . " AND " . $format . $where_address . " ORDER BY $order ";
        $total_result = $this->db->Query($sql_total, []);

        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql .  $search . $user_condition_and . $term_name . " AND " . $format . $where_address . " ORDER BY $order " . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }

    function changeTermUnActive($user_create)
    {
        $sql = "SELECT * FROM vg_terms\n" .
            "WHERE user_create = :user_create AND status = 1";
        $data = $this->db->Query($sql, ['user_create' => $user_create]);
        $term_data_active = json_decode($data);
        foreach ($term_data_active as $obj) {
            $sql = "UPDATE vg_terms SET status = 0 WHERE term_id = :term_id";
            $this->db->Update($sql, ["term_id" =>  $obj->term_id]);
        }
    }

    function insertTestGeade($arr_data)
    {
        $sql = "INSERT INTO vg_test_grade(std_id,term_id,file_name,test_type,format,user_create) VALUES (:std_id,:term_id,:file_name,:test_type,:format,:user_create)";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    function UpdateTestGeade($arr_data)
    {
        $sql = "UPDATE vg_test_grade SET file_name = :file_name,test_type = :test_type WHERE grade_id = :grade_id";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function deleteTestGrade($grade_id)
    {
        $sql = "DELETE FROM vg_test_grade WHERE grade_id = :grade_id";
        $data = $this->db->Delete($sql, ["grade_id" => $grade_id]);
        return $data;
    }

    function stdGetDataTestGrade()
    {
        $sql_format = "SELECT format FROM vg_test_grade tg WHERE std_id = " . $_SESSION['user_data']->edu_type . " LIMIT 1 ";
        $formatGrade = $this->db->Query($sql_format, []);
        $formatGrade = json_decode($formatGrade);

        $sql_class = "SELECT std_class,user_create FROM tb_students WHERE std_id = " . $_SESSION['user_data']->edu_type . " LIMIT 1 ";
        $class_std = $this->db->Query($sql_class, []);
        $class_std = json_decode($class_std);

        if (count($formatGrade) == 0) {
            $sql_format = "SELECT format FROM vg_test_grade tg WHERE std_id = '" .  $class_std[0]->std_class . "' LIMIT 1 ";
            $formatGrade = $this->db->Query($sql_format, []);
            $formatGrade = json_decode($formatGrade);
        }

        $formatSTD = count($formatGrade) > 0 ? $formatGrade[0]->format : 0;

        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search'])) {
            $search = " AND CONCAT( term.term, ' ', term.`year` ) LIKE '%" . $_REQUEST['search'] . "%'";
        }

        //ถ้ามีการจัดเรียง
        $order = "";
        if (isset($_REQUEST['sort'])) {
            $order = "std." . $_REQUEST['sort'] . " " . $_REQUEST['order'];
        }


        $std_id = " tg.std_id = " . $_SESSION['user_data']->edu_type;
        $format = "";

        if (!$formatSTD) {
            $format = "";
        } else {
            $format = " tg.format = " . $formatSTD . " AND tg.user_create = " . $class_std[0]->user_create . " AND tg.std_id = '" . $class_std[0]->std_class . "'";
            $std_id = "";
        }

        if (isset($_REQUEST['format']) && $_REQUEST['format'] == 1) {
            $format = " tg.format = " . $_REQUEST['format'] . " AND tg.user_create = " . $_REQUEST['user_create_std'] . " AND tg.std_id = '" . $class_std[0]->std_class . "'";
            $std_id = "";
            $formatSTD = 1;
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM vg_test_grade tg\n" .
            "WHERE " . $std_id . $format;
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	tg.*,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name, \n" .
            "   IFNULL(std.std_class,tg.std_id) std_class \n" .
            "FROM\n" .
            "	vg_test_grade tg\n" .
            "	LEFT JOIN vg_terms term ON tg.term_id = term.term_id \n" .
            "   LEFT JOIN tb_students std ON tg.std_id = std.std_id\n" .
            "WHERE\n" .
            $std_id;
        $sql_total = $sql . $format . $search . " $order ";
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $format . $search  . " $order " . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql_total, $formatSTD];
    }
}
