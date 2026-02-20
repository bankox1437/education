
<?php

class Share_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }
    function getShare()
    {
        //ถ้ามีการค้นหา
        $search = "";
        if (isset($_REQUEST['search'])) {
            // $search = " ( CONCAT( u.NAME, ' ', u.surname ) LIKE '%" . $_REQUEST['search'] . "%' ";
            $search .= " share.share_name LIKE '%" . $_REQUEST['search'] . "%' ";
        }

        $action = " WHERE ";

        if (!empty($search)) {
            $search =  $action . " " . $search;
        }

        if (isset($_REQUEST['share_id']) && !empty($_REQUEST['share_id'])) {
            $search = empty($search) ? $action : $search . " AND ";
            $search .= " share.share_id = '" . $_REQUEST['share_id'] . "' \n ";
        }

        if ($_SESSION['user_data'] && ($_SESSION['user_data']->role_id == 2 || $_SESSION['user_data']->role_id == 3)) {
            $search = empty($search) ? $action : $search . " AND ";
            $search .= " share.user_create = '" . $_SESSION['user_data']->id . "' \n ";
        }

        if (isset($_REQUEST['province_select']) && !empty($_REQUEST['province_select'])) {
            $search = empty($search) ? $action : $search . " AND ";
            $search .= " (d.province_id = '" . $_REQUEST['province_select'] . "' \n ";
            $search .= " OR tne.province_id = '" . $_REQUEST['province_select'] . "') \n ";
        }
        if (isset($_REQUEST['district_select']) && !empty($_REQUEST['district_select'])) {
            $search = empty($search) ? $action : $search . " AND ";
            $search .= " (d.id = '" . $_REQUEST['district_select'] . "' \n ";
            $search .= " OR tne.district_id = '" . $_REQUEST['district_select'] . "') \n ";
        }

        //นับจำนวนทั้งหมด
        $sql = "SELECT count(*) totalnotfilter FROM cl_share share ";
        $totalnotfilter = $this->db->Query($sql, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql_total = "SELECT\n" .
            "	share.*,\n" .
            "	CONCAT( u.NAME, ' ', u.surname ) u_name,\n" .
            "	IFNULL(tne.name, d.name_th) name_th\n" .
            "FROM\n" .
            "	`cl_share` share\n" .
            "LEFT JOIN tb_users u ON share.user_create = u.id\n" .
            "LEFT JOIN tbl_non_education tne on (u.edu_id = tne.id )\n" .
            "LEFT JOIN tbl_district d ON (u.district_am_id = d.id or tne.district_id = d.id)\n" .
            $search .
            "	ORDER BY share.create_date DESC";
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


    public function InsertShare($array_data, $mode = "INSERT")
    {
        $where =  "";
        if ($mode == "INSERT") {
            $mode = "INSERT cl_share ";
        } else {
            $mode = "UPDATE cl_share ";
            $where = " WHERE share_id = :share_id";
        }

        $sql = $mode . " SET 
            share_name = :share_name,
            share_link = :share_link, 
            user_create = :user_create " . $where;

        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function viewUpdate($id)
    {
        $sql = "UPDATE cl_share SET share_views = (share_views + 1) WHERE share_id = :share_id";
        $data = $this->db->Update($sql, ["share_id" => $id]);
        return $data;
    }

    public function deleteShare($id)
    {
        $sql = "DELETE FROM cl_share WHERE share_id = :share_id";
        $data = $this->db->Delete($sql, ["share_id" => $id]);
        return $data;
    }
}
