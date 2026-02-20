<?php

class Learning_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function getCountLearnSaved($term = "", $year = "", $user_id)
    {
        $sql = "SELECT COUNT(*) learn_saved FROM cl_learning_saved\n" .
            "WHERE term = :term AND year = :year AND user_create = :user_create";
        $data = $this->db->Query($sql, ['term' => $term, 'year' => $year, 'user_create' => $user_id]);
        return json_decode($data);
    }

    function getCountEduPlan($term = "", $year = "", $user_id)
    {
        $sql = "SELECT COUNT(*) plan FROM cl_edu_plan\n" .
            "WHERE term = :term AND year = :year AND user_create = :user_create";
        $data = $this->db->Query($sql, ['term' => $term, 'year' => $year, 'user_create' => $user_id]);
        return json_decode($data);
    }

    function getLearnList($term = "", $year = "", $user_id)
    {
        $sql = "SELECT learning_id,time FROM cl_learning_saved\n" .
            "WHERE term = :term AND year = :year AND user_create = :user_create";
        $data = $this->db->Query($sql, ['term' => $term, 'year' => $year, 'user_create' => $user_id]);
        return json_decode($data);
    }

    public function InsertLearnSaved($array_data)
    {
        $sql = "INSERT INTO cl_learning_saved (calendar_id, side_1, side_2, side_3, user_create)\n" .
            "VALUES\n" .
            "	(:calendar_id, :side_1, :side_2, :side_3, :user_create);";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function InsertLearnImage($array_data)
    {
        $sql = "INSERT INTO cl_learning_images (learning_id, img_name_1, img_name_2, img_name_3, img_name_4)\n" .
            "VALUES\n" .
            "	(:learning_id, :img_name_1, :img_name_2, :img_name_3, :img_name_4)";
        $data = $this->db->Insert($sql, $array_data);
        return $data;
    }

    function selectCheckReason($learning_id)
    {
        $sql = "SELECT COUNT(*) reason FROM cl_learning_reason\n" .
            "WHERE learning_id = :learning_id";
        $data = $this->db->Query($sql, ['learning_id' => $learning_id]);
        return json_decode($data);
    }

    public function InsertLearnReason($learning_id, $reason)
    {
        $sql = "INSERT INTO cl_learning_reason (  learning_id,reason,user_create)\n" .
            "VALUES\n" .
            "	(:learning_id, :reason, :user_create);";
        $data = $this->db->Insert($sql, ['learning_id' => $learning_id, 'reason' => $reason, 'user_create' => $_SESSION['user_data']->id]);
        return $data;
    }

    public function UpdateLearnReason($reason, $learning_id)
    {
        $sql = "UPDATE cl_learning_reason \n" .
            "SET reason = :reason\n" .
            "WHERE\n" .
            "	learning_id = :learning_id";
        $data = $this->db->Update($sql, ['reason' => $reason, 'learning_id' => $learning_id]);
        return $data;
    }

    public function UpdateLearnSaved($array_data)
    {
        $sql = "UPDATE cl_learning_saved \n" .
            "SET \n" .
            "side_1 = :side_1,\n" .
            "side_2 = :side_2,\n" .
            "side_3 = :side_3\n" .
            "WHERE\n" .
            "	learning_id = :learning_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function UpdateLearnImages($array_data)
    {
        $sql = "UPDATE cl_learning_images \n" .
            "SET \n" .
            "img_name_1 = :img_name_1,\n" .
            "img_name_2 = :img_name_2,\n" .
            "img_name_3 = :img_name_3,\n" .
            "img_name_4 = :img_name_4\n" .
            "WHERE\n" .
            "	learning_id = :learning_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    function getCountLearnList($user_id)
    {
        $user_id = $user_id == 0 ? $_SESSION['user_data']->id : $user_id;
        $sql = "SELECT\n" .
            "CONCAT( 'พบกลุ่มครั้งที่ ', time, ' - ', term, '/', YEAR ) calendar,\n" .
            "	l.calendar_id,\n" .
            "	l.learning_id,\n" .
            "	SUBSTR( l.side_1, 1, 21 ) side_1,\n" .
            "	SUBSTR( l.side_2, 1, 21 ) side_2,\n" .
            "	SUBSTR( l.side_3, 1, 21 ) side_3,\n" .
            "	SUBSTR( r.reason, 1, 21 ) reason \n" .
            "FROM\n" .
            "	cl_learning_saved l\n" .
            "	LEFT JOIN cl_calendar c ON l.calendar_id = c.calendar_id\n" .
            "	LEFT JOIN cl_learning_reason r ON l.learning_id = r.learning_id \n" .
            "	LEFT JOIN cl_main_calendar m ON c.m_calendar_id = m.m_calendar_id \n" .
            "WHERE\n" .
            "	c.user_create = :user_create";
        $data = $this->db->Query($sql, ['user_create' => $user_id]);
        return json_decode($data);
    }

    function getCountLearnDetail($learning_id)
    {
        $sql = "SELECT\n" .
            "	l.*,r.reason \n" .
            "FROM\n" .
            "	cl_learning_saved l\n" .
            "   LEFT JOIN cl_learning_reason r ON l.learning_id = r.learning_id \n" .
            "WHERE\n" .
            " l.learning_id = :learning_id";
        $data = $this->db->Query($sql, ['learning_id' => $learning_id]);
        return json_decode($data);
    }

    function getCountDataDetail($calendar_id, $new = false)
    {

        $viewTable = "	lf.*, lf.learning_id learning_file_id,\n";
        $joinReason = " LEFT JOIN cl_learning_save_file lf ON c.calendar_id = lf.calendar_id\n";
        $joinReason .= " LEFT JOIN cl_learning_reason r ON lf.learning_id = r.learning_id AND type_new = 1\n";

        $tableNew = " cl_calendar ";
        if ($new) {
            $joinReason = " LEFT JOIN cl_learning_saved l ON c.calendar_id = l.calendar_id\n";
            $joinReason .= " LEFT JOIN cl_learning_reason r ON l.learning_id = r.learning_id AND type_new = 2\n";
            $joinReason .= " LEFT JOIN cl_learning_images lm ON l.learning_id = lm.learning_id \n";
            $tableNew = " cl_calendar_new ";
            $viewTable = "	l.*,l.learning_id l_old,\n";
            $viewTable .= "	lm.*,\n";
        }
        $joinReason .= ' LEFT JOIN tb_users ur ON r.user_create = ur.id';
        $sql = "SELECT\n" .
            "	c.*,c.calendar_id calendar_id_new,\n" .
            "	m.*,\n" .
            $viewTable .
            "	r.reason,\n" .
            "	CONCAT(ur.name,' ',ur.surname) ur_name\n" .
            "FROM\n" .
            "	$tableNew c\n" .
            "   LEFT JOIN cl_main_calendar  m ON c.m_calendar_id = m.m_calendar_id\n" .
            $joinReason .
            "\n WHERE\n" .
            "	c.calendar_id = :calendar_id";
        $data = $this->db->Query($sql, ['calendar_id' => $calendar_id]);
        return json_decode($data);
    }

    function DeleteLearn($learning_id)
    {
        $sql = "DELETE FROM cl_learning_saved WHERE learning_id = :learning_id";
        $data = $this->db->Delete($sql, ['learning_id' => $learning_id]);
        return json_decode($data);
    }


    public function InsertLearnFile($array_data, $type)
    {
        $where = "";
        if ($type == 1) {
            $type = " INSERT INTO cl_learning_save_file SET calendar_id = :calendar_id,";
        } else {
            $type = " UPDATE cl_learning_save_file SET ";
            $where = " WHERE learning_id = :learning_id";
        }
        $sql = $type . "learning_file = :learning_file,user_create = :user_create " . $where;
        $data = $this->db->Insert($sql, $array_data);
        return $data;
    }
}
