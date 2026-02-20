<?php

class Activity_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function insertActivity($arr_data, $mode = "INSERT",  $act_id = 0)
    {
        $where = "";
        if ($mode == "INSERT") {
            $mode = "INSERT INTO ";
        } else {
            $mode = "UPDATE ";
            $where = " WHERE act_id = :act_id";
            $arr_data['act_id'] = $act_id ?? 0;
        }
        $sql = $mode . " cl_calendar_activity SET " .
            "date_time = :date_time,
            act_name = :act_name,
            take_response = :take_response,
            note = :note,
            act_file_name = :act_file_name,
            user_create = :user_create,
            term_id = :term_id ";
        $sql .=  $where;
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function getDataCalendarActivity($term_id = 0, $user_create = 0)
    {
        $param = [
            "user_create" => $_SESSION['user_data']->id,
            "term_id" => $_SESSION['term_active']->term_id
        ];
        if ($term_id != 0) {
            $param['term_id'] = $term_id;
        }
        if ($user_create != 0) {
            $param['user_create'] = $user_create;
        }

        $showStdJoined = "";
        if ($_SESSION['user_data']->role_id == 4) {
            $param['std_id'] = $_SESSION['user_data']->edu_type;
            $showStdJoined = "   ,( SELECT count(*) FROM cl_join_activity jaa WHERE jaa.std_id = :std_id AND jaa.act_id = ca.act_id) joined \n";
        }

        $sql = "SELECT\n" .
            "	ca.* ,\n" .
            "	(SELECT count(*) FROM cl_join_activity ja WHERE ja.act_id = ca.act_id) count_join\n" .
            $showStdJoined .
            "FROM\n" .
            "	cl_calendar_activity ca\n" .
            "WHERE\n" .
            "	user_create = :user_create\n" .
            "	AND term_id = :term_id";


        $dataCount = $this->db->Query($sql, $param);
        return json_decode($dataCount);
    }

    public function deleteCalendarAct($id)
    {
        $sql = "DELETE FROM cl_calendar_activity WHERE act_id = :act_id";
        $data = $this->db->Delete($sql, ["act_id" => $id]);
        return $data;
    }

    public function deleteCalendarActJoin($id)
    {
        $sql = "DELETE FROM cl_join_activity WHERE act_id = :act_id";
        $data = $this->db->Delete($sql, ["act_id" => $id]);
        return $data;
    }

    public function joinActivity($act_id = 0)
    {
        $sql = "INSERT INTO cl_join_activity SET " .
            "act_id = :act_id,
            std_id = :std_id";
        $data = $this->db->Insert($sql, ["act_id" => $act_id, "std_id" => $_SESSION['user_data']->edu_type]);
        return $data;
    }


    public function getDataStdAct($act_id)
    {
        $sql = "SELECT\n" .
            "	std.std_code,\n" .
            "	CONCAT(std.std_prename,std.std_name) std_name,\n" .
            "	std.std_class \n" .
            "FROM\n" .
            "	cl_join_activity la\n" .
            "	LEFT JOIN tb_students std ON la.std_id = std.std_id \n" .
            "WHERE\n" .
            "	la.act_id = :act_id";
        $dataCount = $this->db->Query($sql, ["act_id" => $act_id]);
        return json_decode($dataCount);
    }
}
