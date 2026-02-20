<?php

class User_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function checkLogIn($username, $password, $edu = "")
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
                "	AND PASSWORD = :password AND edu_type = 'edu'";
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
                "	AND PASSWORD = :password AND edu_type = 'edu_other'";
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
                "	username = :username \n" .
                "	AND PASSWORD = :password";
        }

        $data = $this->db->Query($sql, ["username" => $username, "password" => $password]);
        return json_decode($data);
    }


    public function getDataUser($role_id = 0)
    {
        $limit = $_POST['limit'];
        $page = ($_POST['page'] - 1) * $limit;

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
                "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province\n" .
                "	\n" .
                "FROM\n" .
                "	tb_users users\n" .
                "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
                "WHERE users.role_id = :role_id ORDER BY users.role_id ASC LIMIT $page,$limit";
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
                "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province -- tbl_provinces.name_th\n" .
                "	\n" .
                "FROM\n" .
                "	tb_users users\n" .
                "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id \n" .
                "   ORDER BY users.role_id ASC LIMIT $page,$limit";
            $data = $this->db->Query($sql, []);
            return json_decode($data);
        }
    }

    function countUsers()
    {
        $sql = "SELECT COUNT(*) count FROM tb_users";
        $dataCount = $this->db->Query($sql, []);
        return json_decode($dataCount)[0]->count;
    }

    public function getRoleData()
    {
        $sql = "SELECT * FROM tb_role_users";
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
        $sql = "INSERT INTO tb_users(name,surname,username,password,edu_id,edu_type,role_id,user_create,district_am,province_am,district_am_id,province_am_id,status) \n"
            . "VALUES(:name,:surname,:username,:password,:edu_id,:edu_type,:role_id,:user_create,:district,:province,:district_id,:province_id,:status)";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function addRoleCustom($role_name, $id, $role_id, $subdistrict_id, $subdistrict_text)
    {
        $lastRoleCus = $role_id;
        if (empty($role_id)) {
            $sql = "INSERT INTO tb_role_users(role_name,custom,user_create) \n"
                . "VALUES(:role_name,1,:user_create)";
            $lastRoleCus = $this->db->InsertLastID($sql, ["role_name" => $role_name, "user_create" =>  $_SESSION['user_data']->id]);
        }
        $sql = "UPDATE tb_users \n" .
            "SET 
            role_custom_id = :role_id, \n" .
            "subdistrict_id = :subdistrict_id, \n" .
            "subdistrict_text = :subdistrict_text \n" .
            "WHERE id=:id";
        $this->db->Update($sql, ["role_id" => $lastRoleCus, "subdistrict_id" => $subdistrict_id, "subdistrict_text" => $subdistrict_text, "id" => $id]);
    }

    public function editAdmin($array_data)
    {
        $sql = "UPDATE tb_users \n" .
            "SET name=:name,surname=:surname, \n" .
            "username=:username,password=:password, \n" .
            "edit_date=:edit_date,user_update=:user_update, \n" .
            "status=:status \n" .
            "WHERE id=:id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function editProfile($array_data)
    {
        $sql = "UPDATE tb_users \n" .
            "SET name=:name,surname=:surname, \n" .
            "password=:password,\n" .
            "edit_date=:edit_date,user_update=:user_update,channel = :channel \n" .
            "WHERE id=:id";
        $data =  $this->db->Update($sql, $array_data);
        if ($_SESSION['user_data']->role_id == 4) {
            $main_func = new ClassMainFunctions();
            $cleaned_name = $main_func->cleanName($array_data['name']);
            $full_name = $cleaned_name . " " . $array_data['surname'];
            $sql = "UPDATE tb_students 
                    SET std_name=:name
                    WHERE std_id=:id";
            $this->db->Update($sql, [
                "name" => $full_name,
                "id" => $_SESSION['user_data']->edu_type
            ]);
        }
        return $data;
    }

    public function getDataUserWhereId($id)
    {
        $joinSTD = "";
        $selectSTD = "";
        if ($_SESSION['user_data']->role_id == 4) {
            $joinSTD = "LEFT JOIN tb_students std ON users.edu_type = std.std_id \n";
            $selectSTD = " ,std.std_term, std.std_year ";
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
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province, \n" .
            "   ( SELECT tbl_sub_district.id FROM tbl_non_education edu LEFT JOIN tbl_sub_district ON edu.sub_district_id = tbl_sub_district.id WHERE users.edu_id = edu.id ) sub_district_id,\n" .
            "	( SELECT tbl_district.id FROM tbl_non_education edu LEFT JOIN tbl_district ON edu.district_id = tbl_district.id WHERE users.edu_id = edu.id ) district_id,\n" .
            "	( SELECT tbl_provinces.id FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province_id \n" .
            $selectSTD .
            "	\n" .
            "FROM\n" .
            "	tb_users users\n" .
            "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id \n" . $joinSTD .
            "WHERE id = :id \n" .
            "   ORDER BY users.role_id ASC";
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
        if ($_SESSION['user_data']->role_id == 1 && $table != "") {
            $sqlPro = "SELECT\n" .
                "	pro.id,\n" .
                "	pro.name_th \n" .
                "FROM\n" .
                "   tb_users u \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "	LEFT JOIN tbl_provinces pro ON edu.province_id = pro.id \n" .
                "WHERE pro.id IS NOT NULL\n" .
                "GROUP BY\n" .
                "	name_th";
        }
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

    public function getMainCalendar($user_id)
    {
        $sql = "SELECT * FROM cl_main_calendar WHERE user_create = :user_create AND enabled = 1";
        $data = $this->db->Query($sql, ["user_create" => $user_id]);
        return json_decode($data);
    }

    public function editEdu($array_edu)
    {
        $sql = "UPDATE tbl_non_education \n" .
            "SET NAME=:edu_name \n" .
            "WHERE id=:edu_id";
        $data = $this->db->Update($sql, $array_edu);
        return $data;
    }
}
