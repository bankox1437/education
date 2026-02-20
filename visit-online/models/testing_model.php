<?php

class TestingModel
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function addTesting($array_data)
    {

        $sql = "INSERT INTO cl_testing(term, year,std_class, test_name, link, description, user_create) VALUES (:term,:year,:std_class,:test_name,:link,:description,:user_create);";
        $data = $this->db->Insert($sql, $array_data);
        return $data;
    }

    function editTesting($array_data)
    {
        $sql = "UPDATE cl_testing SET term = :term, year = :year,std_class = :std_class, test_name = :test_name, link = :link, description = :description WHERE testing_id = :testing_id;";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function getDataTesting($user_create, $classRoom = "")
    {
        $whereClass = "";
        if (!empty($classRoom)) {
            $whereClass = " AND ( std_class = '" . $classRoom . "' OR std_class IS null)";
        }

        $sql = "SELECT * FROM cl_testing\n" .
            "WHERE user_create = {$user_create} {$whereClass}\n" .
            "ORDER BY CONCAT( term, '/', year ) ASC";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    public function deleteTesting($testing_id)
    {
        $sql = "DELETE FROM cl_testing WHERE testing_id = :testing_id";
        $data = $this->db->Delete($sql, ["testing_id" => $testing_id]);
        return $data;
    }

    function getUsersBT()
    {
        //ถ้ามีจังหวัด
        $wherProDisSub = "  ";

        if (isset($_REQUEST['province_id'])) {
            $wherProDisSub .= " AND COALESCE(edu.province_id, users.province_am_id) = " . $_REQUEST['province_id'] . "\n";
        }
        //ถ้ามีอะเภอ
        if (isset($_REQUEST['district_id'])) {
            $wherProDisSub .= "  AND COALESCE(edu.district_id, users.district_am_id) = " . $_REQUEST['district_id'] . "\n";
        }

        //ถ้ามีตำบล
        if (isset($_REQUEST['subdistrict_id'])) {
            $wherProDisSub .= "  AND COALESCE(edu.sub_district_id, 0) = " . $_REQUEST['subdistrict_id'] . "\n";
        }

        if ($_SESSION['user_data']->role_id == 2) {
            $wherProDisSub = " AND edu.province_id = " . $_SESSION['user_data']->province_am_id . " AND edu.district_id = " . $_SESSION['user_data']->district_am_id;
            if (isset($_REQUEST['subdistrict_id'])) {
                $wherProDisSub .= "  AND COALESCE(edu.sub_district_id, 0) = " . $_REQUEST['subdistrict_id'] . "\n";
            }
        }


        //ถ้ามีครู
        if (isset($_REQUEST['teacherId']) && $_REQUEST['teacherId'] != 0) {
            $wherProDisSub .= "  AND  users.id = " . $_REQUEST['teacherId'] . "\n";
        }


        //นับจำนวนทั้งหมด
        $sql_order = "SELECT\n" .
            "	COUNT(*) totalnotfilter\n" .
            "FROM\n" .
            "	tb_users users\n";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql =  $sql = "SELECT\n" .
            "	users.*,\n" .
            "   CONCAT(users.name,' ',users.surname) concat_name_users,\n" .
            "	role.role_name,\n" .
            "	IFNULL((\n" .
            "		SELECT NAME \n" .
            "		FROM\n" .
            "			tbl_non_education edu \n" .
            "		WHERE\n" .
            "			users.edu_id = edu.id \n" .
            "			),(\n" .
            "		SELECT NAME \n" .
            "		FROM\n" .
            "			tbl_non_education_other edu_o \n" .
            "		WHERE\n" .
            "			users.edu_id = edu_o.id \n" .
            "		)) edu_name,\n" .
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_sub_district ON edu.sub_district_id = tbl_sub_district.id WHERE users.edu_id = edu.id ) sub_district,\n" .
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_district ON edu.district_id = tbl_district.id WHERE users.edu_id = edu.id ) district,\n" .
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province \n" .
            "FROM\n" .
            "	tb_users users\n" .
            "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
            "	LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id \n" .
            " WHERE users.role_id = 3 \n" . $wherProDisSub .
            " ORDER BY users.role_id ASC";

        $sql_total = $sql;
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $limit = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql_total . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result),  $sql];
    }
}
