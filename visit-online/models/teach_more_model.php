
<?php

class TeachMore_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }
    function getTeachMore()
    {
        //ถ้ามีการค้นหา
        $search = "";
        if (isset($_REQUEST['search'])) {
            $search = " ( CONCAT( u.NAME, ' ', u.surname ) LIKE '%" . $_REQUEST['search'] . "%' ";
            $search .= " OR teach.teach_subject_name LIKE '%" . $_REQUEST['search'] . "%' )";
        }
        if (isset($_REQUEST['std_class'])) {
            $actionClass = " ";
            if (!empty($search)) {
                $actionClass = " AND ";
            }
            $search .= $actionClass . " teach.teach_class LIKE '%" . $_REQUEST['std_class'] . "%' ";
        }

        $where = "";
        $wheruser = "";
        $action = " WHERE ";
        if ($_SESSION['user_data']->role_id == 3) {
            // $action = " AND ";
            // $wheruser = "WHERE teach.user_create = " . $_SESSION['user_data']->id . " ";
        }
        if ($_SESSION['user_data']->role_id == 4) {
            $sql_std = "SELECT std_class FROM tb_students WHERE std_id = " . $_SESSION['user_data']->edu_type;
            $result = $this->db->Query($sql_std, []);
            $result = json_decode($result);
            // $wheruser = "WHERE teach.user_create = " . $_SESSION['user_data']->user_create . " AND teach.teach_class = '" . $result[0]->std_class . "' ";
        }
        if (isset($_REQUEST['teach_m_id']) && !empty($_REQUEST['teach_m_id'])) {
            $where = $action . " teach.teach_m_id = '" . $_REQUEST['teach_m_id'] . "' \n ";
        }

        if (empty($where) && !empty($search)) {
            $search =  $action . " " . $search;
        }

        //นับจำนวนทั้งหมด
        $sql = "SELECT count(*) totalnotfilter FROM cl_teach_more teach ";
        $totalnotfilter = $this->db->Query($sql, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql_total = "SELECT\n" .
            "	teach.*,\n" .
            "   u.id u_id,\n" .
            "	CONCAT( u.NAME, ' ', u.surname ) u_name,\n" .
            "	edu.name edu_name\n" .
            "FROM\n" .
            "	`cl_teach_more` teach\n" .
            "	LEFT JOIN tb_users u ON teach.user_create = u.id\n" .
            "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id \n" .
            $wheruser . $where .  $search .
            "	ORDER BY teach.create_date DESC";
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $limit  = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql_total . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }


    public function deleteTeachMore($id)
    {
        $sql = "DELETE FROM cl_teach_more WHERE teach_m_id = :teach_m_id";
        $data = $this->db->Delete($sql, ["teach_m_id" => $id]);
        return $data;
    }

    public function InsertTeachmore($array_data, $mode = "INSERT")
    {
        $where =  "";
        if ($mode == "INSERT") {
            $mode = "INSERT cl_teach_more ";
        } else {
            $mode = "UPDATE cl_teach_more ";
            $where = " WHERE teach_m_id = :teach_m_id";
        }

        $file = "";
        if (isset($array_data['teach_file'])) {
            $file = " ,teach_file = :teach_file,
                teach_file_name = :teach_file_name ";
        }

        $sql = $mode . " SET 
            teach_subject_code = :teach_subject_code,
            teach_subject_name = :teach_subject_name,
            teach_cate = :teach_cate, 
            teach_class = :teach_class, 
            year = :year, 
            teach_link = :link, 
            user_create = :user_create " . $file . $where;
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function downloadUpdate($id)
    {
        $sql = "UPDATE cl_teach_more SET teach_downloads = (teach_downloads + 1) WHERE teach_m_id = :teach_m_id";
        $data = $this->db->Update($sql, ["teach_m_id" => $id]);
        return $data;
    }

    public function viewUpdate($id)
    {
        $sql = "UPDATE cl_teach_more SET teach_views = (teach_views + 1) WHERE teach_m_id = :teach_m_id";
        $data = $this->db->Update($sql, ["teach_m_id" => $id]);
        return $data;
    }
}
