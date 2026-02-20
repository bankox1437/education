<?php

class Am_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function getDataUser($edu_id)
    {
        $limit = $_POST['limit'];
        $page = ($_POST['page'] - 1) * $limit;
        $where = "";
        if ($edu_id != 0) {
            $where = " AND users.edu_id = $edu_id";
        }
        $sql = "SELECT\n" .
            "	users.*,\n" .
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
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province\n" .
            "	\n" .
            "FROM\n" .
            "	tb_users users\n" .
            "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id \n" .
            "   LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id \n" .
            "WHERE users.role_id = 3 AND edu.district_id = " . $_SESSION['user_data']->district_am_id . " $where\n" .
            "ORDER BY users.role_id ASC LIMIT $page,$limit";
        $dataCount = $this->db->Query($sql, []);
        return json_decode($dataCount);
    }

    function countUsers($edu_id)
    {
        $where = "";
        if ($edu_id != 0) {
            $where = " AND edu_id = $edu_id";
        }
        $sql = "SELECT COUNT(*) count FROM tb_users WHERE user_create = :user_create $where";
        $dataCount = $this->db->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
        return json_decode($dataCount)[0]->count;
    }

    function getEduUser()
    {
        $sql = "SELECT\n" .
            "	id edu_id,\n" .
            "	NAME edu_name \n" .
            "FROM\n" .
            "	tbl_non_education \n" .
            "WHERE\n" .
            "	district_id = :district_id";
        $dataCount = $this->db->Query($sql, ["district_id" => $_SESSION['user_data']->district_am_id]);
        return json_decode($dataCount);
    }

    public function getDataTeacher($sub_dis_id = 0, $pro_id = 0, $dis_id = 0)
    {
        $arr_data = [];
        $wherePro = "";
        $whereDis = "";
        $whereSub = "";
        $where = "";
        if ($_SESSION['user_data']->role_id == 1) {
            $wherePro = $pro_id == 0 ? " \n " : " edu.province_id = " . $pro_id . " \n";
            $whereDis = $dis_id == 0 ? " \n " : " AND edu.district_id = " . $dis_id . " \n";
            $whereSub = $sub_dis_id == 0 ? " \n " : " AND edu.sub_district_id = " . $sub_dis_id . " \n";
            $where = "WHERE users.role_id = 3 \n";
            if ($pro_id != 0 && $dis_id  == 0 && $sub_dis_id == 0) {
                $where .= " AND " . $wherePro;
            }
            if ($pro_id != 0 && $dis_id  != 0 && $sub_dis_id == 0) {
                $where .= " AND " . $wherePro . $whereDis;
            }
            if ($pro_id != 0 && $dis_id  != 0 && $sub_dis_id != 0) {
                $where .= " AND " . $wherePro . $whereDis  . $whereSub;
            }
        }
        if ($_SESSION['user_data']->role_id == 2) {
            $whereSub = $sub_dis_id == 0 ? " \n " : " AND edu.sub_district_id = " . $sub_dis_id . " \n";
            $where = "WHERE  users.role_id = 3 AND edu.province_id = " . $_SESSION['user_data']->province_am_id . " AND edu.district_id = " . $_SESSION['user_data']->district_am_id . $whereSub;
        }

        $sql = "SELECT\n" .
            "	users.*,\n" .
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
            "	LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id \n" . $where .
            " ORDER BY users.role_id ASC";
        $dataCount = $this->db->Query($sql, []);

        return json_decode($dataCount);
    }

    function getUsersBT()
    {
        //ถ้ามีจังหวัด
        $wherProDisSub = "  ";
        $wherProDisSubCustom = " OR ( users.role_custom_id IS NOT NULL ";
        if (isset($_REQUEST['province_id'])) {
            $wherProDisSub .= " AND COALESCE(edu.province_id, users.province_am_id) = " . $_REQUEST['province_id'] . "\n";
            $wherProDisSubCustom .= " AND users.province_am_id = " . $_REQUEST['province_id'] . "\n";
        }
        //ถ้ามีอะเภอ
        if (isset($_REQUEST['district_id'])) {
            $wherProDisSub .= "  AND COALESCE(edu.district_id, users.district_am_id) = " . $_REQUEST['district_id'] . "\n";
            $wherProDisSubCustom .= "  AND users.district_am_id = " . $_REQUEST['district_id'] . "\n";
        }

        //ถ้ามีตำบล
        if (isset($_REQUEST['subdistrict_id'])) {
            $wherProDisSub .= "  AND COALESCE(edu.sub_district_id, 0) = " . $_REQUEST['subdistrict_id'] . "\n";
            $wherProDisSubCustom .= "  AND users.subdistrict_id = " . $_REQUEST['subdistrict_id'] . "\n";
        }

        if ($_SESSION['user_data']->role_id == 2) {
            $wherProDisSub = " AND edu.province_id = " . $_SESSION['user_data']->province_am_id . " AND edu.district_id = " . $_SESSION['user_data']->district_am_id;
            $wherProDisSubCustom .= " AND users.province_am_id = " . $_SESSION['user_data']->province_am_id . " AND users.district_am_id = " . $_SESSION['user_data']->district_am_id;
            if (isset($_REQUEST['subdistrict_id'])) {
                $wherProDisSub .= "  AND COALESCE(edu.sub_district_id, 0) = " . $_REQUEST['subdistrict_id'] . "\n";
                $wherProDisSubCustom .= "  AND users.subdistrict_id = " . $_REQUEST['subdistrict_id'] . "\n";
            }
        }

        $wherProDisSubCustom .= " ) ";


        //ถ้ามีครู
        if (isset($_REQUEST['teacherId']) && $_REQUEST['teacherId'] != 0) {
            $wherProDisSub .= "  AND  users.id = " . $_REQUEST['teacherId'] . "\n";
            $wherProDisSubCustom = "";
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
            "	role_cus.role_name role_cus_name,\n" .
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
            "	LEFT JOIN tb_role_users role_cus ON users.role_custom_id = role_cus.role_id\n" .
            "	LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id \n" .
            " WHERE ( users.role_id = 3 " . $wherProDisSub . " ) " . $wherProDisSubCustom . " \n" .
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
