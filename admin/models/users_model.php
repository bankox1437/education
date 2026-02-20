<?php

class User_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function adminGetDataUser($manageRole = false)
    {
        $role_id = " users.role_id != 4 ";
        if (isset($_REQUEST['role_id']) && !empty($_REQUEST['role_id'])) {
            if ($_SESSION['user_data']->role_id == 2) {
                $role_id = " (users.role_id = '" . $_REQUEST['role_id'] . "' OR users.role_id = 5) ";
            } else {
                $role_id = "users.role_id = '" . $_REQUEST['role_id'] . "' ";
            }
        }

        $role_cus = "";
        if ($manageRole) {
            $role_cus = " AND users.role_custom_id IS NULL ";
        }

        //ถ้ามีการค้นหา
        $search = "";
        if (isset($_REQUEST['search'])) {
            $search = " AND CONCAT(users.name,' ',users.surname) LIKE '%" . $_REQUEST['search'] . "%'";
        }

        //ถ้ามีจังหวัด
        $wherProDisSub = "";
        if (isset($_REQUEST['province_id'])) {
            // if ($_REQUEST['role_id'] == 3 || $_REQUEST['role_id'] == 0) {
            //     $wherProDisSub .= " AND ( SELECT province_id FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) = " . $_REQUEST['province_id'] . "\n";
            // }
            // if ($_REQUEST['role_id'] == 2) {
            //     $wherProDisSub .= "AND users.province_am_id = " . $_REQUEST['province_id'] . "\n";
            // }
            $wherProDisSub .= " AND COALESCE(edu.province_id, users.province_am_id) = " . $_REQUEST['province_id'] . "\n";
        }
        //ถ้ามีอะเภอ
        if (isset($_REQUEST['district_id'])) {
            // if ($_REQUEST['role_id'] == 3 || $_REQUEST['role_id'] == 0) {
            //     $wherProDisSub  .= " AND ( SELECT district_id FROM tbl_non_education edu LEFT JOIN tbl_district ON edu.district_id = tbl_district.id WHERE users.edu_id = edu.id ) = " . $_REQUEST['district_id'] . "\n";
            // }
            // if ($_REQUEST['role_id'] == 2) {
            //     $wherProDisSub  .= " AND users.district_am_id = " . $_REQUEST['district_id'] . "\n";
            // }
            $wherProDisSub .= "  AND COALESCE(edu.district_id, users.district_am_id) = " . $_REQUEST['district_id'] . "\n";
        }

        //ถ้ามีตำบล
        if (isset($_REQUEST['subdistrict_id'])) {
            // if ($_REQUEST['role_id'] == 3 || $_REQUEST['role_id'] == 0) {
            //     $wherProDisSub .= "AND ( SELECT sub_district_id FROM tbl_non_education edu LEFT JOIN tbl_sub_district ON edu.sub_district_id = tbl_sub_district.id WHERE users.edu_id = edu.id ) = " . $_REQUEST['subdistrict_id'] . "\n";
            // }
            $wherProDisSub .= "  AND COALESCE(edu.sub_district_id, 0) = " . $_REQUEST['subdistrict_id'] . "\n";
        }

        if (isset($_REQUEST['role_id']) && $_REQUEST['role_id'] == 1) {
            $wherProDisSub = "";
        }

        //ถ้ามีการจัดเรียง
        $order = " users.role_id ASC,users.name ASC";

        //นับจำนวนทั้งหมด
        // $sql_order = "SELECT count(*) totalnotfilter FROM vg_n_net\n" .
        //     "WHERE user_create = :user_create";
        $sql_order = "SELECT\n" .
            "	COUNT(*) totalnotfilter\n" .
            "FROM\n" .
            "	tb_users users\n" .
            "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
            "WHERE users.role_id != 4;";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	users.*, \n" .
            "   CONCAT(users.name,' ',users.surname) concat_name,\n" .
            "	role.role_name,\n" .
            "	role_c.role_name role_name_cus,\n" .
            "	COALESCE(edu.name, edu_o.name) AS edu_name,\n" .
            "   sub_dist.name_th AS sub_district,\n" .
            "   dist.name_th AS district,\n" .
            "   prov.name_th AS province \n" .
            "	\n" .
            "FROM\n" .
            "	tb_users users\n" .
            "   LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
            "   LEFT JOIN tb_role_users role_c ON users.role_custom_id = role_c.role_id\n" .
            "   LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id\n" .
            "   LEFT JOIN tbl_non_education_other edu_o ON users.edu_id = edu_o.id\n" .
            "   LEFT JOIN tbl_sub_district sub_dist ON edu.sub_district_id = sub_dist.id\n" .
            "   LEFT JOIN tbl_district dist ON COALESCE( edu.district_id, users.district_am_id) = dist.id\n" .
            "   LEFT JOIN tbl_provinces prov ON COALESCE(edu.province_id, users.province_am_id) = prov.id \n";

        $sql_total = $sql . "WHERE " . $role_id . $role_cus . $wherProDisSub . $search . " ORDER BY $order";
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
        return [$total, $totalnotfilter, json_decode($data_result), $sql_total];
    }

    public function checkLogIn($username, $edu = "")
    {
        $sql = "";
        if ($edu != "" && $edu == 'edu') {
            $sql = "SELECT\n" .
                "	users.*,\n" .
                "	role.role_name,\n" .
                "	edu.name edu_name\n" .
                "FROM\n" .
                "	tb_users users\n" .
                "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
                "	LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id \n" .
                "WHERE\n" .
                "	username = :username \n" .
                "	AND edu_type = 'edu'";
        } else if ($edu != "" && $edu == 'other') {
            $sql = "SELECT\n" .
                "	users.*,\n" .
                "	role.role_name,\n" .
                "	edu.name edu_name\n" .
                "FROM\n" .
                "	tb_users users\n" .
                "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
                "	LEFT JOIN tbl_non_education_other edu ON users.edu_id = edu.id \n" .
                "WHERE\n" .
                "	username = :username \n" .
                "	AND edu_type = 'edu_other'";
        } else {
            $sql = "SELECT\n" .
                "	users.*,\n" .
                "	role.role_name,\n" .
                "	edu.name edu_name\n" .
                "FROM\n" .
                "	tb_users users\n" .
                "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
                "	LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id \n" .
                "WHERE\n" .
                "	username = :username ";
        }
        $data = $this->db->Query($sql, ["username" => $username]);
        return json_decode($data);
    }


    // public function getDataUser($role_id = 0)
    // {
    //     if (isset($_REQUEST['search'])) {
    //         $search = " CONCAT(users.name,' ',users.surname) LIKE '%" . $_REQUEST['search'] . "%'";
    //     }
    //     if (isset($_REQUEST['limit'])) {
    //         $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
    //     }
    //     if ($role_id > 0) {
    //         $where = " AND " . $search;
    //         $sql = "SELECT\n" .
    //             "	users.*, CONCAT(users.name,' ',users.surname) concat_name,\n" .
    //             "	role.role_name,\n" .
    //             "	IFNULL((\n" .
    //             "		SELECT NAME \n" .
    //             "		FROM\n" .
    //             "			tbl_non_education edu \n" .
    //             "		WHERE\n" .
    //             "			users.edu_id = edu.id \n" .
    //             "			),(\n" .
    //             "		SELECT NAME \n" .
    //             "		FROM\n" .
    //             "			tbl_non_education_other edu_o \n" .
    //             "		WHERE\n" .
    //             "			users.edu_id = edu_o.id \n" .
    //             "		)) edu_name,\n" .
    //             "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_sub_district ON edu.sub_district_id = tbl_sub_district.id WHERE users.edu_id = edu.id ) sub_district,\n" .
    //             "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_district ON edu.district_id = tbl_district.id WHERE users.edu_id = edu.id ) district,\n" .
    //             "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province\n" .
    //             "	\n" .
    //             "FROM\n" .
    //             "	tb_users users\n" .
    //             "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
    //             "WHERE users.role_id = $role_id $where ORDER BY users.role_id ASC";
    //     } else {
    //         $where = " WHERE users.role_id != 4 AND " . $search;
    //         $sql = "SELECT\n" .
    //             "	users.*, CONCAT(users.name,' ',users.surname) concat_name,\n" .
    //             "	role.role_name,\n" .
    //             "	IFNULL((\n" .
    //             "		SELECT NAME \n" .
    //             "		FROM\n" .
    //             "			tbl_non_education edu \n" .
    //             "		WHERE\n" .
    //             "			users.edu_id = edu.id \n" .
    //             "			),(\n" .
    //             "		SELECT NAME \n" .
    //             "		FROM\n" .
    //             "			tbl_non_education_other edu_o \n" .
    //             "		WHERE\n" .
    //             "			users.edu_id = edu_o.id \n" .
    //             "		)) edu_name,\n" .
    //             "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_sub_district ON edu.sub_district_id = tbl_sub_district.id WHERE users.edu_id = edu.id ) sub_district,\n" .
    //             "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_district ON edu.district_id = tbl_district.id WHERE users.edu_id = edu.id ) district,\n" .
    //             "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province -- tbl_provinces.name_th\n" .
    //             "	\n" .
    //             "FROM\n" .
    //             "	tb_users users\n" .
    //             "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id \n" .
    //             $where .
    //             "   ORDER BY users.role_id ASC";
    //     }
    //     $sql = $sql . $limit;
    //     $data = $this->db->Query($sql, []);
    //     return json_decode($data);
    // }

    public function getRoleData()
    {
        $sql = "SELECT * FROM tb_role_users WHERE custom IS NULL ORDER BY orders ASC";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    public function checkUsernameDupicate($username)
    {
        $sql = "SELECT * FROM tb_users WHERE username = :username";
        $data = $this->db->Query($sql, ["username" => $username]);
        return json_decode($data);
    }

    public function addAdmin($array_data)
    {
        $sql = "INSERT INTO tb_users(name,surname,username,password,edu_id,edu_type,role_id,user_create,sub_district_am,district_am,province_am,sub_district_am_id,district_am_id,province_am_id,status) \n"
            . "VALUES(:name,:surname,:username,:password,:edu_id,:edu_type,:role_id,:user_create,:sub_district_am,:district_am,:province_am,:sub_district_am_id,:district_am_id,:province_am_id,:status)";
        $data = $this->db->Insert($sql, $array_data);
        return $data;
    }

    public function editAdmin($array_data)
    {
        $sql = "UPDATE tb_users \n" .
            "SET name=:name,surname=:surname, \n" .
            "username=:username,password=:password, \n" .
            "edit_date=:edit_date,user_update=:user_update, \n" .
            "status = :status\n" .
            "WHERE id=:id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function editProfile($array_data)
    {
        $sql = "UPDATE tb_users \n" .
            "SET name=:name,surname=:surname, \n" .
            "password=:password,\n" .
            "edit_date=:edit_date,user_update=:user_update \n" .
            "WHERE id=:id";
        $data =  $this->db->Update($sql, $array_data);
        return $data;
    }

    public function getDataUserWhereId($id)
    {
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
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province, \n" .
            "   ( SELECT tbl_sub_district.id FROM tbl_non_education edu LEFT JOIN tbl_sub_district ON edu.sub_district_id = tbl_sub_district.id WHERE users.edu_id = edu.id ) sub_district_id,\n" .
            "	( SELECT tbl_district.id FROM tbl_non_education edu LEFT JOIN tbl_district ON edu.district_id = tbl_district.id WHERE users.edu_id = edu.id ) district_id,\n" .
            "	( SELECT tbl_provinces.id FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province_id \n" .
            "	\n" .
            "FROM\n" .
            "	tb_users users\n" .
            "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id \n" .
            "WHERE id = :id \n" .
            "   ORDER BY users.role_id ASC";

        $sql = "SELECT\n" .
            "	users.*, \n" .
            "   CONCAT(users.name,' ',users.surname) concat_name,\n" .
            "	role.role_name,\n" .
            "	COALESCE(edu.name, edu_o.name) AS edu_name,\n" .
            "	sub_dist.id AS sub_district_id,\n" .
            "	dist.id AS district_id,\n" .
            "	prov.id AS province_id,\n" .
            "   sub_dist.name_th AS sub_district,\n" .
            "   dist.name_th AS district,\n" .
            "   prov.name_th AS province \n" .
            "	\n" .
            "FROM\n" .
            "	tb_users users\n" .
            "   LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
            "   LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id\n" .
            "   LEFT JOIN tbl_non_education_other edu_o ON users.edu_id = edu_o.id\n" .
            "   LEFT JOIN tbl_sub_district sub_dist ON edu.sub_district_id = sub_dist.id\n" .
            "   LEFT JOIN tbl_district dist ON COALESCE( edu.district_id, users.district_am_id) = dist.id\n" .
            "   LEFT JOIN tbl_provinces prov ON COALESCE(edu.province_id, users.province_am_id) = prov.id \n" .
            "WHERE users.id = :id \n";
        $data = $this->db->Query($sql, ["id" => $id]);
        return json_decode($data);
    }

    public function deleteAdmin($id, $edu_id)
    {
        $sql = "DELETE FROM tb_users WHERE id = :id";
        $data = $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM tbl_non_education WHERE id = :id";
        $data = $this->db->Delete($sql, ["id" => $edu_id]);
        return $data;
    }

    public function SearchUsers($keyword, $role_id)
    {
        if ($role_id > 0) {
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
                "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id \n" .
                "WHERE\n" .
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
                "		)) LIKE '%" . $keyword . "%' AND users.role_id = :role_id \n" .
                "ORDER BY\n" .
                "	users.role_id ASC";
            $data = $this->db->Query($sql, ["role_id" => $role_id]);
            return json_decode($data);
        } else {
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
                "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id \n" .
                "WHERE\n" .
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
                "		)) LIKE '%" . $keyword . "%' \n" .
                "ORDER BY\n" .
                "	users.role_id ASC";
            $data = $this->db->Query($sql, []);
            return json_decode($data);
        }
    }

    public function getDataProDistSub($table = "")
    {
        $sqlPro = "SELECT id,name_th FROM tbl_provinces";
        if ($_SESSION['user_data']->role_id == 1 && $table != "" && $table === "tb_users") {
            $sqlPro = "SELECT\n" .
                // "    u.`name`,\n" .
                // "    u.role_id,\n" .
                // "    u.province_am_id,\n" .
                // "		edu.province_id,\n" .
                "    COALESCE(edu.province_id, u.province_am_id) AS pro_id,\n" .
                // "    pro.name_th AS pro_name\n" .
                "pro.id,pro.name_th \n" .
                "FROM\n" .
                "    $table u\n" .
                "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "LEFT JOIN tbl_provinces pro ON COALESCE(edu.province_id, u.province_am_id) = pro.id\n" .
                "WHERE\n" .
                "    u.role_id IN (2, 3) AND edu_type != 'edu_other'\n" .
                "GROUP BY pro_id \n" .
                "ORDER BY pro_id";
        }
        // $sqlPro = "SELECT id,name_th FROM tbl_provinces";
        $dataPro = $this->db->Query($sqlPro, []);

        $sqlDist = "SELECT id,name_th,province_id FROM tbl_district";
        $dataDist = $this->db->Query($sqlDist, []);

        $sqlSub = "SELECT id,name_th,district_id FROM tbl_sub_district";
        $dataSub = $this->db->Query($sqlSub, []);

        $Data = [
            "provinces" => json_decode($dataPro),
            "district" => json_decode($dataDist),
            "sub_district" => json_decode($dataSub)
        ];
        return $Data;
    }

    public function InsertNewEdu($array_data)
    {
        $sql = "INSERT INTO tbl_non_education (name, code, province_id, district_id, sub_district_id, user_create )\n" .
            "VALUES\n" .
            "	(:name, :code, :province_id, :district_id, :sub_district_id, :user_create)";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function InsertNewEduOther($array_data)
    {
        $sql = "INSERT INTO tbl_non_education_other (name, code,user_create )\n" .
            "VALUES\n" .
            "	(:name, :code,:user_create)";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function getUserByUsername($username)
    {
        $sql = "SELECT password FROM tb_users WHERE username = :username limit 1";
        $data = $this->db->Query($sql, ["username" => $username]);
        return json_decode($data);
    }

    function adminGetDataUserDuplicate()
    {
        //ถ้ามีจังหวัด
        $wherProDisSub = " WHERE std.role_id = 4 ";

        $filter_dup = " std.username \n";
        if (isset($_REQUEST['filter_dup']) && ($_REQUEST['filter_dup'] == 2)) {
            $filter_dup = " concat_name \n";
        }

        if (isset($_REQUEST['province_id'])) {
            $wherProDisSub .= " AND COALESCE(edu.province_id, u.province_am_id) = " . $_REQUEST['province_id'] . "\n";
        }
        //ถ้ามีอะเภอ
        if (isset($_REQUEST['district_id'])) {
            $wherProDisSub .= "  AND COALESCE(edu.district_id, u.district_am_id) = " . $_REQUEST['district_id'] . "\n";
        }

        //ถ้ามีตำบล
        if (isset($_REQUEST['subdistrict_id'])) {
            $wherProDisSub .= "  AND COALESCE(edu.sub_district_id, 0) = " . $_REQUEST['subdistrict_id'] . "\n";
        }

        if (isset($_REQUEST['role_id']) && $_REQUEST['role_id'] == 1) {
            $wherProDisSub = "";
        }

        $search = "";
        if (isset($_REQUEST['search'])) {
            if (isset($_REQUEST['filter_dup']) && ($_REQUEST['filter_dup'] == 2)) {
                $search = " AND CONCAT(std.name,' ',std.surname) LIKE '%" . $_REQUEST['search'] . "%'";
            } else {
                $search = " AND std.username LIKE '%" . $_REQUEST['search'] . "%'";
            }
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT\n" .
            "	COUNT(*) totalnotfilter\n" .
            "FROM\n" .
            "	tb_users users\n" .
            "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "   CONCAT(std.name,' ',std.surname) concat_name,\n" .
            "	std.id,\n" .
            "	std.edu_type,\n" .
            "	std.NAME,\n" .
            "	std.surname,\n" .
            "	CONCAT(u.NAME,' ',u.surname) creator_name,\n" .
            "	std.username,\n" .
            "	edu.name edu_name,\n" .
            "	COUNT(*) AS duplicate_data,\n" .
            "	sub_dist.name_th AS sub_district,\n" .
            "	dist.name_th AS district,\n" .
            "	prov.name_th AS province \n" .
            "FROM\n" .
            "	tb_users std\n" .
            "	LEFT JOIN tb_users u ON std.user_create = u.id\n" .
            "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
            "	LEFT JOIN tbl_sub_district sub_dist ON edu.sub_district_id = sub_dist.id\n" .
            "	LEFT JOIN tbl_district dist ON edu.district_id = dist.id\n" .
            "	LEFT JOIN tbl_provinces prov ON edu.province_id = prov.id \n" .
            $wherProDisSub . $search .
            "GROUP BY\n" .
            $filter_dup .
            "HAVING\n" .
            "	COUNT(*) > 1 \n" .
            "ORDER BY\n" .
            "	std.id ";

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

    public function getUserDupToDelete($username)
    {
        $sql = "SELECT * FROM tb_users WHERE username = :username";
        $data = $this->db->Query($sql, ["username" => $username]);
        $data = json_decode($data);
        if (count($data) > 0) {
            for ($i = 0; $i < (count($data) - 1); $i++) {
                $this->deleteDup($data[$i]->id, $data[$i]->edu_type);
            }
        }
        return true;
    }


    public function deleteDup($id, $edu_type)
    {
        $sql = "DELETE FROM stf_tb_form_evaluate_students WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM stf_tb_form_screening_students WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM stf_tb_form_student_person WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM stf_tb_form_visit_home WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM vg_gradiate WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM vg_kpc WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM vg_moral WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM vg_n_net WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM vg_save_event WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM vg_table_test WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM vg_test_grade WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM vg_test_result WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $edu_type]);

        $sql = "DELETE FROM tb_users WHERE id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM tb_students WHERE std_id = :id";
        $data = $this->db->Delete($sql, ["id" => $edu_type]);
        return $data;
    }



    function getLogsData()
    {
        //ถ้ามีการค้นหา
        $search = "";
        if (isset($_REQUEST['search'])) {
            $search = " WHERE sql_detail LIKE '%" . $_REQUEST['search'] . "%'";
            $search .= " OR username LIKE '%" . $_REQUEST['search'] . "%'";
            $search .= " OR user_create LIKE '%" . $_REQUEST['search'] . "%'";
        }

        //ถ้ามีการจัดเรียง
        $order = " ORDER BY log_id DESC ";

        //นับจำนวนทั้งหมด
        // $sql_order = "SELECT count(*) totalnotfilter FROM vg_n_net\n" .
        //     "WHERE user_create = :user_create";
        $sql_order = "SELECT\n" .
            "	COUNT(*) totalnotfilter\n" .
            "FROM\n" .
            "	tb_logs log";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	count(*) count_log \n" .
            "FROM\n" .
            "	tb_logs log";

        $sql_total = $sql . $search . $order;
        $total_result = $this->db->Query($sql_total, []);
        $total = json_decode($total_result);
        $total = $total[0]->count_log;
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $sqllimit = "SELECT\n" .
            "	log.* \n" .
            "FROM\n" .
            "	tb_logs log";

        $sqllimit .=  $search . $order;

        $limit = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sqllimit . $limit;
        $data_result = $this->db->Query($sql, []);

        $newResult = [];
        $data_result = json_decode($data_result);

        foreach ($data_result as $key => $value) {
            // The input string
            $input = $value->param_data;

            // Split the string at "Parameters:"
            $parts = explode('Parameters: ', $input);
            if (count($parts) == 2) {
                // Get the JSON string
                $jsonString = $parts[1];

                // Decode the JSON string
                $data = json_decode($jsonString, true, 512, JSON_UNESCAPED_UNICODE);
                if ($data !== null) {
                    $value->param_data = $data; // Assign the decoded data directly
                    $newResult[] = $value; // Append the modified object to $newResult
                }
            }
        }
        return [$total, $totalnotfilter, $newResult, $sql_total];
    }


    public function getRole($id)
    {
        $sql = "SELECT status FROM tb_users WHERE id = :id";
        $data = $this->db->Query($sql, ["id" => $id]);
        $data = json_decode($data);
        return $data;
    }

    public function updateRole($id, $role_status)
    {
        $sql = "UPDATE tb_users SET status = :status WHERE id = :id";
        $data = $this->db->Update($sql, ["status" => $role_status, "id" => $id]);
        return $data;
    }
}
