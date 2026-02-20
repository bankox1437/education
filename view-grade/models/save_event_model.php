<?php

class Save_Event_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function getSaveEvent()
    {
        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search'])) {
            $search = " AND ( event_name LIKE '%" . $_REQUEST['search'] . "%' ";
            $search .= " OR CONCAT( term.term, '/', term.`year` ) LIKE '%" . $_REQUEST['search'] . "%' )";
        }

        //ถ้ามีการจัดเรียง
        $order = " std.std_code ASC ";
        if (isset($_REQUEST['sort'])) {
            $order = "std." . $_REQUEST['sort'] . " " . $_REQUEST['order'];
        }

        $std_id = $_SESSION['user_data']->edu_type;
        if (isset($_REQUEST['std_id']) && $_REQUEST['std_id'] != 0) {
            $std_id = $_REQUEST['std_id'];
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM vg_save_event\n" .
            "WHERE std_id = :user_create";
        $totalnotfilter = $this->db->Query($sql_order, ['user_create' => $std_id]);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	se.*,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	CONCAT( std.std_prename, ' ',std.std_name ) std_name,\n" .
            "	std.std_code,std.std_class \n" .
            "FROM\n" .
            "	vg_save_event se\n" .
            "	LEFT JOIN vg_terms term ON se.term_id = term.term_id\n" .
            "	LEFT JOIN tb_students std ON se.std_id = std.std_id\n" .
            "WHERE se.std_id = :user_create ";
        $sql_total = $sql . $search . " ORDER BY $order ";
        $total_result = $this->db->Query($sql_total, ['user_create' => $std_id]);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $search  . " ORDER BY $order " . $limit;
        $data_result = $this->db->Query($sql, ['user_create' => $std_id]);
        return [$total, $totalnotfilter, json_decode($data_result)];
    }

    public function InsertEvent($array_data)
    {
        $sql = "INSERT INTO vg_save_event (std_id, term_id, event_name, event_detail,img_event_1, img_event_2, img_event_3, img_event_4, user_create)\n" .
            "VALUES\n" .
            "	(:std_id, :term_id, :event_name, :event_detail, :img_event_1, :img_event_2, :img_event_3, :img_event_4,:user_create);";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function UpdateEvent($array_data)
    {
        $sql = "UPDATE vg_save_event \n" .
            "SET \n" .
            "event_name = :event_name,\n" .
            "event_detail = :event_detail,\n" .
            "img_event_1 = :img_event_1,\n" .
            "img_event_2 = :img_event_2,\n" .
            "img_event_3 = :img_event_3,\n" .
            "img_event_4 = :img_event_4\n" .
            "WHERE\n" .
            "event_id = :event_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function getImageEventById($event_id)
    {
        $sql = "SELECT img_event_1,img_event_2,img_event_3,img_event_4 FROM vg_save_event WHERE event_id = :event_id";
        $data = $this->db->Query($sql, ["event_id" => $event_id]);
        return $data;
    }
    public function deleteEvent($event_id)
    {
        $sql = "DELETE FROM vg_save_event WHERE event_id = :event_id";
        $data = $this->db->Delete($sql, ["event_id" => $event_id]);
        return $data;
    }
}
