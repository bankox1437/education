<?php

class Student_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }
    public function getStudent()
    {
        $sql = "SELECT * FROM stf_tb_students";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    public function getDataStudent($user_create)
    {
        $sql = "SELECT * FROM stf_tb_students WHERE user_create = :user_create  ORDER BY std_class ASC,  std_code ASC";
        $data = $this->db->Query($sql, ["user_create" => $user_create]);
        return json_decode($data);
    }

    public function getDataStudentAdmin($edu_id = "")
    {
        $where = !empty($edu_id) ? "WHERE edu.id = :edu_id \n" : "\n";

        $sql = "SELECT\n" .
            "	std.* ,\n" .
            "	u.name u_name,\n" .
            "	u.surname u_surname,\n" .
            "	edu.name edu_name\n" .
            "FROM\n" .
            "	tb_students std\n" .
            "	LEFT JOIN tb_users u ON std.user_create = u.id\n" .
            "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id \n" .
            $where .
            "ORDER BY\n" .
            "	std_class ASC,\n" .
            "	std_code ASC";
        if (!empty($edu_id)) {
            $data = $this->db->Query($sql, ["edu_id" => $edu_id]);
        } else {
            $data = $this->db->Query($sql, []);
        }
        return json_decode($data);
    }

    public function getDataStudentAdminNew($edu_id = "")
    {
        $action = "";
        $edu = "";
        if (isset($_REQUEST['edu_id']) && !empty($_REQUEST['edu_id'])) {
            $action = " WHERE ";
            $edu = " edu_id = '" . $_REQUEST['edu_id'] . "'  AND u.edu_type = '" . $_REQUEST['edu_type'] . "' ";
        }

        //ถ้ามีการค้นหา
        $search = "";
        if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
            $action_search = "";
            if (empty($action)) {
                $action_search = " WHERE ";
            } else {
                $action_search = " AND ";
            }
            $search = $action_search . " CONCAT(std.std_prename,'',std.std_name) LIKE '%" . $_REQUEST['search'] . "%'";
        }

        //ถ้ามีจังหวัด
        $wherProDisSub = "";
        if (isset($_REQUEST['province_id'])) {
            $action_area = "";
            if (empty($action) && empty($search)) {
                $action_area = " WHERE ";
            } else {
                $action_area = " AND ";
            }
            $wherProDisSub .= $action_area . "  ( SELECT province_id FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE u.edu_id = edu.id ) = " . $_REQUEST['province_id'] . "\n";
        }
        //ถ้ามีอะเภอ
        if (isset($_REQUEST['district_id'])) {
            $action_area = "";
            if (empty($action) && empty($search)) {
                $action_area = " WHERE ";
            } else {
                $action_area = " AND ";
            }
            $wherProDisSub  .= " AND ( SELECT district_id FROM tbl_non_education edu LEFT JOIN tbl_district ON edu.district_id = tbl_district.id WHERE u.edu_id = edu.id ) = " . $_REQUEST['district_id'] . "\n";
        }

        //ถ้ามีตำบล
        if (isset($_REQUEST['subdistrict_id'])) {
            $action_area = "";
            if (empty($action) && empty($search)) {
                $action_area = " WHERE ";
            } else {
                $action_area = " AND ";
            }
            $wherProDisSub .= " AND ( SELECT sub_district_id FROM tbl_non_education edu LEFT JOIN tbl_sub_district ON edu.sub_district_id = tbl_sub_district.id WHERE u.edu_id = edu.id ) = " . $_REQUEST['subdistrict_id'] . "\n";
        }

        if (isset($_REQUEST['edu_type']) && $_REQUEST['edu_type'] == 'edu_other') {
            $wherProDisSub = "";
        }
        // ถ้ามีครู

        $whereTeacher = "";
        if (isset($_REQUEST['teacher_id'])) {
            $action_area = "";

            if (empty($wherProDisSub) && empty($_REQUEST['edu_id']) && empty($search)) {
                $action_area = " WHERE ";
            } else {
                $action_area = " AND ";
            }
            $whereTeacher = $action_area . " u.id = " . $_REQUEST['teacher_id'] . " \n";
        }

        //ถ้ามีการจัดเรียง
        $order = " std_class ASC,\n" .
            " std_code ASC";

        //นับจำนวนทั้งหมด
        // $sql_order = "SELECT count(*) totalnotfilter FROM vg_n_net\n" .
        //     "WHERE user_create = :user_create";
        $sql_order = "SELECT\n" .
            "	COUNT(*) totalnotfilter\n" .
            "FROM\n" .
            "	tb_students std\n";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	std.*,\n" .
            "   CONCAT(u.NAME,' ',u.surname) user_create_name, \n" .
            "	IFNULL(\n" .
            "		( SELECT id FROM tbl_non_education edu WHERE u.edu_id = edu.id ),\n" .
            "		( SELECT id FROM tbl_non_education_other edu_o WHERE u.edu_id = edu_o.id ) \n" .
            "	) edu_id,\n" .
            "	IFNULL(\n" .
            "		( SELECT NAME FROM tbl_non_education edu WHERE u.edu_id = edu.id ),\n" .
            "		( SELECT NAME FROM tbl_non_education_other edu_o WHERE u.edu_id = edu_o.id ) \n" .
            "	) edu_name \n" .
            "FROM\n" .
            "	tb_students std\n" .
            "	LEFT JOIN tb_users u ON std.user_create = u.id \n";
        $sql_total = $sql . $action . $edu . $wherProDisSub . $search . $whereTeacher . " ORDER BY $order";
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
        return [$total, $totalnotfilter, json_decode($data_result)];
    }

    public function getEduOfStd()
    {
        $whereJoin = "";
        if ($_SESSION['user_data']->role_id == 2) {
            $whereJoin = " AND edu.province_id = " . $_SESSION['user_data']->province_am_id . " AND edu.district_id = " . $_SESSION['user_data']->district_am_id . " \n";
        }

        if ($_SESSION['user_data']->role_id == 6) {
            $whereJoin = " AND edu.province_id = " . $_SESSION['user_data']->province_am_id . " \n";
        }

        $sql = "SELECT COALESCE\n" .
            "	( edu.id ) AS edu_id,\n" .
            "	COALESCE ( edu.NAME ) AS edu_name,\n" .
            "	u.edu_type \n" .
            "FROM\n" .
            "	tb_students std\n" .
            "	LEFT JOIN tb_users u ON std.user_create = u.id\n" .
            "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" . $whereJoin .
            "	LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id \n" .
            "WHERE\n" .
            "	COALESCE ( edu.id ) IS NOT NULL \n" .
            "	AND COALESCE ( edu.NAME ) IS NOT NULL \n" .
            "GROUP BY\n" .
            "	edu_id,\n" .
            "	edu_name,\n" .
            "	u.edu_type";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    public function getDataStudentWHereStdId($std_id)
    {
        $sql = "SELECT * FROM stf_tb_students WHERE std_id = :std_id";
        $data = $this->db->Query($sql, ["std_id" => $std_id]);
        return json_decode($data);
    }


    public function checkStudentWhereSTDNumber($std_number, $user_create)
    {
        $sql = "SELECT * FROM stf_tb_students WHERE std_code = :std_code AND user_create = :user_create";
        $data = $this->db->Query($sql, ['std_code' => $std_number, "user_create" => $user_create]);
        return json_decode($data);
    }

    public function InsertStudent($arr_data, $std_id = 0)
    {
        $state = '';
        $where = '';
        $data = 0;

        if ($std_id != 0) {
            $state = 'UPDATE ';
            $where = 'WHERE std_id = :std_id';
        } else {
            $state = 'INSERT INTO ';
        }
        $sql =  $state . " stf_tb_students SET \n" .
            "	std_code = :std_code,\n" .
            "	std_prename = :std_prename,\n" .
            "	std_name = :std_name,\n" .
            "	std_gender = :std_gender,\n" .
            "	std_class = :std_class,\n" .
            "	std_birthday = :std_birthday,\n" .
            "	std_father_name = :std_father_name,\n" .
            "	std_father_job = :std_father_job,\n" .
            "	std_mather_name = :std_mather_name,\n" .
            "	std_mather_job = :std_mather_job,\n" .
            "	phone = :phone,\n" .
            "	address = :address,\n" .
            "	user_create = :user_create\n" . $where;

        if ($std_id != 0) {
            $arr_data['std_id'] = $std_id;
            $data = $this->db->Update($sql, $arr_data);
        } else {
            $data = $this->db->Insert($sql, $arr_data);
        }

        return $data;
    }

    public function deleteStd($id)
    {
        $sql = "DELETE FROM stf_tb_form_evaluate_students WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_screening_students WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_student_person WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_visit_home WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_gradiate WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_kpc WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_moral WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_n_net WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_save_event WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_table_test WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_test_grade WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_test_result WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM tb_users WHERE edu_type = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM tb_students WHERE std_id = :id";
        $data = $this->db->Delete($sql, ["id" => $id]);
        return $data;
    }

    public function getTeacherStd($dataFilter)
    {
        $joinTeacher = "";
        $eduOther = "";

        $joinTypeEdu = " LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id ";

        if (isset($dataFilter['edu_id']) && !empty($dataFilter['edu_id'])) {
            $joinTypeEdu = " LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id ";
            $eduOther = " AND u.edu_id = '" . $dataFilter['edu_id'] . "'  AND u.edu_type = '" . $dataFilter['edu_type'] . "' ";
        }
        //ถ้ามีจังหวัด
        $wherePro = "";
        if (!empty($dataFilter['province_id'])) {
            $wherePro .= " AND edu.province_id = " . $dataFilter['province_id'] . " ";
            $joinTeacher .= " LEFT JOIN tbl_provinces pro ON edu.province_id = pro.id \n";
        }
        //ถ้ามีอะเภอ
        if (!empty($dataFilter['district_id'])) {
            $wherePro .= " AND edu.district_id = " . $dataFilter['district_id'] . " ";
            $joinTeacher  .= " LEFT JOIN tbl_district dis ON edu.district_id = dis.id \n";
        }

        //ถ้ามีตำบล
        if (!empty($dataFilter['subdistrict_id'])) {
            $wherePro .= " AND edu.sub_district_id = " . $dataFilter['subdistrict_id'] . " ";
            $joinTeacher .= " LEFT JOIN tbl_sub_district sub ON edu.sub_district_id = sub.id \n";
        }

        $sql = "SELECT 
                    u.id,CONCAT(u.name,' ',u.surname) full_name,
                    COUNT( std.std_id ) AS std_count  
                    FROM 
                    tb_users u	LEFT JOIN tb_students std ON std.user_create = u.id "
            . $joinTypeEdu . $joinTeacher . " WHERE u.role_id = 3 " .
            $wherePro .  $eduOther .
            " GROUP BY u.id, u.name, u.surname " .
            " HAVING std_count > 0";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    public function updateMoveStd($user_create, $std_id)
    {
        // $sql = "UPDATE tb_students SET user_create = :user_create WHERE std_id = :std_id";
        // $data = $this->db->Update($sql, ["user_create" => $user_create, "std_id" => $std_id]);

        // $sql = "SELECT * FROM tb_users WHERE id = " . $user_create;
        // $data = $this->db->Query($sql, []);
        // $dataJson = json_decode($data);
        // $dataJson = $dataJson[0];

        // $sql = "UPDATE tb_users SET user_create = :user_create,edu_id = :edu_id  WHERE edu_type = :std_id";
        // $data = $this->db->Update($sql, ["user_create" => $user_create, "edu_id" => $dataJson->edu_id, "std_id" => $std_id]);
        // return $data;

        // การเชื่อมต่อฐานข้อมูล
        $conn = $this->db->conn;

        try {
            // ดึงรายชื่อตารางทั้งหมด
            $tables_query = "SHOW TABLES";
            $tables_stmt = $conn->prepare($tables_query);
            $tables_stmt->execute();
            $tables = $tables_stmt->fetchAll(PDO::FETCH_COLUMN);

            // echo "<h2>ผลการตรวจสอบ column ในตาราง:</h2>";
            $i = 0;

            $table_ignore = ["cl_score"];

            foreach ($tables as $table) {
                // ตรวจสอบ column std_id
                $std_id_query = "SHOW COLUMNS FROM `$table` LIKE 'std_id'";
                $std_id_stmt = $conn->prepare($std_id_query);
                $std_id_stmt->execute();
                $has_std_id = $std_id_stmt->rowCount() > 0;

                // ตรวจสอบ column user_create
                $user_create_query = "SHOW COLUMNS FROM `$table` LIKE 'user_create'";
                $user_create_stmt = $conn->prepare($user_create_query);
                $user_create_stmt->execute();
                $has_user_create = $user_create_stmt->rowCount() > 0;

                if ($has_std_id && $has_user_create && !in_array($table, $table_ignore)) {
                    // echo $i + 1;
                    // // แสดงผล
                    // echo "<strong>ตาราง: $table</strong><br>";
                    // echo "- มี std_id: " . ($has_std_id ? "ใช่" : "ไม่") . "<br>";
                    // echo "- มี user_create: " . ($has_user_create ? "ใช่" : "ไม่") . "<br>";
                    // echo "- <span style='color: green;'>ตารางนี้มีทั้งสอง column</span><br>";
                    // echo "<br>";

                    $sql = "UPDATE $table SET user_create = :user_create WHERE std_id = :std_id";
                    $this->db->Update($sql, ["user_create" => $user_create, "std_id" => $std_id]);
                    $i++;
                }
            }

            $sql = "SELECT * FROM tb_users WHERE id = " . $user_create;
            $data = $this->db->Query($sql, []);
            $dataJson = json_decode($data);
            $dataJson = $dataJson[0];

            $sql = "UPDATE tb_users SET user_create = :user_create,edu_id = :edu_id  WHERE edu_type = :std_id";
            $data = $this->db->Update($sql, ["user_create" => $user_create, "edu_id" => $dataJson->edu_id, "std_id" => $std_id]);
            return $data;
        } catch (PDOException $e) {
            echo "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
    }
}
