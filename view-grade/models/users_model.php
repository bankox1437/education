<?php

class User_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function checkLogIn($username, $edu = "")
    {
        $sql = "";
        if ($edu != "" && $edu == 'edu') {
            $sql = "SELECT\n" .
                "	users.*,\n" .
                "	role.role_name,\n" .
                "	rolec.role_name role_c_name,\n" .
                "	edu.name edu_name,edu.district_id\n" .
                "FROM\n" .
                "	tb_users users\n" .
                "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
                "	LEFT JOIN tb_role_users rolec ON users.role_custom_id = rolec.role_id\n" .
                "	LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id \n" .
                "WHERE\n" .
                "	username = :username \n" .
                "	AND edu_type = 'edu'";
        } else if ($edu != "" && $edu == 'other') {
            $sql = "SELECT\n" .
                "	users.*,\n" .
                "	role.role_name,\n" .
                "	rolec.role_name role_c_name,\n" .
                "	edu.name edu_name\n" .
                "FROM\n" .
                "	tb_users users\n" .
                "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
                "	LEFT JOIN tb_role_users rolec ON users.role_custom_id = rolec.role_id\n" .
                "	LEFT JOIN tbl_non_education_other edu ON users.edu_id = edu.id \n" .
                "WHERE\n" .
                "	username = :username \n" .
                "	AND edu_type = 'edu_other'";
        } else {
            $sql = "SELECT\n" .
                "	users.*,\n" .
                "	role.role_name,\n" .
                "	rolec.role_name role_c_name,\n" .
                "	edu.name edu_name,edu.district_id\n" .
                "FROM\n" .
                "	tb_users users\n" .
                "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
                "	LEFT JOIN tb_role_users rolec ON users.role_custom_id = rolec.role_id\n" .
                "	LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id \n" .
                "WHERE\n" .
                "	username = :username \n" .
                "	";
        }
        $data = $this->db->Query($sql, ["username" => $username]);
        return json_decode($data);
    }

    public function editProfile($array_data)
    {
        $sql = "UPDATE tb_users \n" .
            "SET name=:name,surname=:surname, \n" .
            "password=:password,\n" .
            "edit_date=:edit_date,user_update=:user_update \n" .
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

    public function getDataUserInfo($id)
    {
        $sql = "SELECT * FROM `info` WHERE user_id = :user_id";
        $data = $this->db->Query($sql, ["user_id" => $id]);
        return json_decode($data);
    }

    public function getDataProDistSub($table = "")
    {
        $sqlPro = "SELECT id,name_th FROM tbl_provinces";
        if ($_SESSION['user_data']->role_id == 1 && $table != "" && $table != "tb_users_role_3") {
            $sqlPro = "SELECT\n" .
                "	pro.id,\n" .
                "	pro.name_th \n" .
                "FROM\n" .
                "	$table tb\n" .
                "	LEFT JOIN tb_users u ON tb.user_create = u.id\n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "	LEFT JOIN tbl_provinces pro ON edu.province_id = pro.id \n" .
                "WHERE pro.id IS NOT NULL\n" .
                "GROUP BY\n" .
                "	name_th";
        } else if ($table == "tb_users_role_3") {
            $sqlPro = "SELECT\n" .
                "	pro.id,\n" .
                "	pro.name_th \n" .
                "FROM\n" .
                "	 tb_users u \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "	LEFT JOIN tbl_provinces pro ON edu.province_id = pro.id \n" .
                "WHERE\n" .
                "	pro.id IS NOT NULL \n" .
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

    public function getRoleData()
    {
        $sql = "SELECT * FROM tb_role_users";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    public function addAdmin($array_data)
    {
        $sql = "INSERT INTO tb_users(name,surname,username,password,edu_id,edu_type,role_id,user_create,district_am,province_am,district_am_id,province_am_id,status) \n"
            . "VALUES(:name,:surname,:username,:password,:edu_id,:edu_type,:role_id,:user_create,:district,:province,:district_id,:province_id,:status)";
        $data = $this->db->Insert($sql, $array_data);
        return $data;
    }

    public function checkUsernameDupicate($username)
    {
        $sql = "SELECT * FROM tb_users WHERE username = :username";
        $data = $this->db->Query($sql, ["username" => $username]);
        return json_decode($data);
    }

    public function InsertNewEdu($array_data)
    {
        $sql = "INSERT INTO tbl_non_education (name, code, province_id, district_id, sub_district_id, user_create )\n" .
            "VALUES\n" .
            "	(:name, :code, :province_id, :district_id, :sub_district_id, :user_create)";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function editAdmin($array_data)
    {
        $sql = "UPDATE tb_users \n" .
            "SET name=:name,surname=:surname, \n" .
            "username=:username,password=:password, \n" .
            "edit_date=:edit_date,user_update=:user_update, \n" .
            "status=:status\n" .
            "WHERE id=:id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function getMainCalendar($user_id)
    {
        $sql = "SELECT * FROM cl_main_calendar WHERE user_create = :user_create AND enabled = 1";
        $data = $this->db->Query($sql, ["user_create" => $user_id]);
        return json_decode($data);
    }

    public function getUserByUsername($username)
    {
        $sql = "SELECT password FROM tb_users WHERE username = :username limit 1";
        $data = $this->db->Query($sql, ["username" => $username]);
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

    public function getTeacherList()
    {
        $wherProDisSub = "";
        if (isset($_REQUEST['province_id']) && $_REQUEST['province_id'] != 0) {
            $wherProDisSub .= " AND edu.province_id = " . $_REQUEST['province_id'] . "\n";
        }

        //ถ้ามีตำบล
        if ($_SESSION['user_data']->role_id == 2) {
            $wherProDisSub .= "  AND edu.district_id = " . $_SESSION['user_data']->district_am_id . "\n";
        } else {
            //ถ้ามีอะเภอ
            if (isset($_REQUEST['district_id']) && $_REQUEST['district_id'] != 0) {
                $wherProDisSub .= "  AND edu.district_id = " . $_REQUEST['district_id'] . "\n";
            }
        }


        //ถ้ามีตำบล
        if (isset($_REQUEST['subdistrict_id']) && $_REQUEST['subdistrict_id'] != 0) {
            $wherProDisSub .= "  AND edu.sub_district_id = " . $_REQUEST['subdistrict_id'] . "\n";
        }


        $sql = "SELECT\n" .
            "	teacher.id,\n" .
            "	CONCAT( teacher.NAME, ' ', teacher.surname ) concat_name\n" .
            "FROM\n" .
            "	tb_users teacher\n" .
            "	LEFT JOIN tbl_non_education edu ON teacher.edu_id = edu.id \n" .
            "-- 	LEFT JOIN tbl_non_education_other edu_other ON teacher.edu_id = edu_other.id\n" .
            "WHERE\n" .
            "	role_id = 3 " . $wherProDisSub;
        $data = $this->db->Query($sql, []);
        return [json_decode($data), $sql];
    }

    public function editEdu($array_edu)
    {
        $sql = "UPDATE tbl_non_education \n" .
            "SET NAME=:edu_name \n" .
            "WHERE id=:edu_id";
        $data = $this->db->Update($sql, $array_edu);
        return $data;
    }

    public function updateLastLogin($id)
    {
        $sql = "UPDATE tb_users \n" .
            "SET last_login=:current_date \n" .
            "WHERE id=:id";
        $date = date('Y-m-d H:i:s');
        $data = $this->db->Update($sql, ["current_date" => $date, "id" => $id]);
        return $data;
    }
}
