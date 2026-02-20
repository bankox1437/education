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
        $sql = "SELECT * FROM tb_students";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    public function getDataStudent($user_create, $std_class = "", $all = false)
    {
        $whereStdClass = "";
        $whereStatus = "";
        if (!empty($std_class)) {
            $whereStdClass = " AND std.std_class = '" . $std_class . "'";
        }
        if (empty($all) || $all == false) {
            $whereStatus  = " std.std_status = 'กำลังศึกษา' AND ";
        }
        $sql = "SELECT std.*, U.password 
        FROM tb_students std
        INNER JOIN tb_users U ON std.std_id = U.edu_type 
        WHERE " . $whereStatus . " U.user_create = :user_create " . $whereStdClass . " 
        ORDER BY std.std_status ASC,std.std_class ASC, std.std_code ASC";
        $data = $this->db->Query($sql, ["user_create" => $user_create]);
        return json_decode($data);
    }

    public function getDataStudentEstimate($user_create, $std_class = "",$year = "", $all = false)
    {
        $whereStdClass = "";
        $whereTsClass = "";
        $whereStatus = "";
        if (!empty($std_class)) {
            $whereStdClass = " AND std.std_class = '" . $std_class . "'";
            $whereTsClass = " and ts.std_class = '" . $std_class . "'";
        }
        if (empty($all) || $all == false) {
            $whereStatus  = " std.std_status = 'กำลังศึกษา' AND ";
        }

        $sql = "SELECT
                    std.*,
                    U.password
                FROM
                    tb_students std
                INNER JOIN tb_users U on
                    std.std_id = U.edu_type
                WHERE
                    " . $whereStatus . " U.user_create = :user_create
                    and (
                    SELECT
                        count(*)
                    FROM
                        stf_tb_estimate ste
                    LEFT JOIN tb_students ts on ste.std_id = ts.std_id
                    WHERE
                        ste.std_id = std.std_id " . $whereTsClass . " AND year = ". $year . ") = 0
                    " . $whereStdClass . " 
                ORDER BY
                    std.std_status asc,
                    std.std_class asc,
                    std.std_code asc";
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

    public function getEduOfStd()
    {
        $sql = "SELECT\n" .
            "	edu.id,\n" .
            "	edu.NAME edu_name \n" .
            "FROM\n" .
            "	tb_students std\n" .
            "	LEFT JOIN tb_users u ON std.user_create = u.id\n" .
            "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id \n" .
            "GROUP BY edu.id";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    public function getDataStudentWHereStdId($std_id)
    {
        $sql = "SELECT * FROM tb_students WHERE std_id = :std_id";
        $data = $this->db->Query($sql, ["std_id" => $std_id]);
        return json_decode($data);
    }


    public function checkStudentWhereSTDNumber($std_number, $user_create)
    {
        $sql = "SELECT * FROM tb_students WHERE std_code = :std_code AND user_create = :user_create";
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
        $sql =  $state . " tb_students SET \n" .
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

    public function deleteStd($id, $mode = "")
    {
        $sql = "DELETE FROM stf_tb_after_gradiate WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_family_data WHERE user_create = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_evaluate_students WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_screening_students WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_student_person WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_form_student_person_new WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "SELECT home_img FROM stf_tb_form_visit_home WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir = '../uploads/visit_home_img/' . $value->home_img;
            unlink($uploadDir);
        }
        $sql = "DELETE FROM stf_tb_form_visit_home WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "SELECT file_name FROM stf_tb_gradiate_reg WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir = '../uploads/gradiate_reg/' . $value->file_name;
            unlink($uploadDir);
        }
        $sql = "DELETE FROM stf_tb_gradiate_reg WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "DELETE FROM vg_credit WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_gradiate WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_kpc WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_moral WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_n_net WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "SELECT img_event_1,img_event_2,img_event_3,img_event_4 FROM vg_save_event WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir1 = '../../view-grade/uploads/save_event/' . $value->img_event_1;
            $uploadDir2 = '../../view-grade/uploads/save_event/' . $value->img_event_2;
            $uploadDir3 = '../../view-grade/uploads/save_event/' . $value->img_event_3;
            $uploadDir4 = '../../view-grade/uploads/save_event/' . $value->img_event_4;
            unlink($uploadDir1);
            unlink($uploadDir2);
            unlink($uploadDir3);
            unlink($uploadDir4);
        }
        $sql = "DELETE FROM vg_save_event WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "DELETE FROM vg_std_finish WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "SELECT file_name FROM vg_table_test WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir1 = '../../view-grade/uploads/table_test_pdf/' . $value->file_name;
            unlink($uploadDir1);
        }
        $sql = "DELETE FROM vg_table_test WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "SELECT file_name FROM vg_test_grade WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir = '../../view-grade/uploads/test_grade_pdf/' . $value->file_name;
            unlink($uploadDir);
        }
        $sql = "DELETE FROM vg_test_grade WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "DELETE FROM vg_test_result WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        if ($mode == "deleteStd") {
            $sql = "DELETE FROM tb_users WHERE edu_type = :id";
            $this->db->Delete($sql, ["id" => $id]);

            $sql = "DELETE FROM tb_students WHERE std_id = :id";
            $this->db->Delete($sql, ["id" => $id]);
        }
        return 1;
    }

    function changeStd($std_id, $class_name)
    {
        $sql =  "UPDATE tb_students SET \n" .
            "	std_class = :std_class \n" .
            " WHERE std_id = :std_id \n";

        $data = $this->db->Update($sql, ["std_class" => $class_name, "std_id" => $std_id]);
        return $data;
    }

    public function deleteStdChangeClass($id)
    {
        $sql = "DELETE FROM vg_credit WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_gradiate WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_kpc WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_moral WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_n_net WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "SELECT img_event_1,img_event_2,img_event_3,img_event_4 FROM vg_save_event WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir1 = '../../view-grade/uploads/save_event/' . $value->img_event_1;
            $uploadDir2 = '../../view-grade/uploads/save_event/' . $value->img_event_2;
            $uploadDir3 = '../../view-grade/uploads/save_event/' . $value->img_event_3;
            $uploadDir4 = '../../view-grade/uploads/save_event/' . $value->img_event_4;
            unlink($uploadDir1);
            unlink($uploadDir2);
            unlink($uploadDir3);
            unlink($uploadDir4);
        }
        $sql = "DELETE FROM vg_save_event WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_std_finish WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "SELECT file_name FROM vg_table_test WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir1 = '../../view-grade/uploads/table_test_pdf/' . $value->file_name;
            unlink($uploadDir1);
        }
        $sql = "DELETE FROM vg_table_test WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);


        $sql = "SELECT file_name FROM vg_test_grade WHERE std_id = :id";
        $fileData = $this->db->Query($sql, ['id' => $id]);
        $fileData = json_decode($fileData);
        foreach ($fileData as $key => $value) {
            $uploadDir = '../../view-grade/uploads/test_grade_pdf/' . $value->file_name;
            unlink($uploadDir);
        }
        $sql = "DELETE FROM vg_test_grade WHERE std_id = :id";
        $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM vg_test_result WHERE std_id = :id";
        $data = $this->db->Delete($sql, ["id" => $id]);

        $sql = "DELETE FROM stf_tb_estimate WHERE std_id = :id";
        $data = $this->db->Delete($sql, ["id" => $id]);

        return $data;
    }


    function changeStatusStd($std_id, $status)
    {
        $sql =  "UPDATE tb_students SET \n" .
            "	std_status = :std_status \n" .
            " WHERE std_id = :std_id \n";

        $data = $this->db->Update($sql, ["std_status" => $status, "std_id" => $std_id]);
        return $data;
    }

    function changeGenderStd($std_id, $std_gender)
    {
        $sql =  "UPDATE tb_students SET \n" .
            "	std_gender = :std_gender \n" .
            " WHERE std_id = :std_id \n";

        $data = $this->db->Update($sql, ["std_gender" => $std_gender, "std_id" => $std_id]);
        return $data;
    }
}
