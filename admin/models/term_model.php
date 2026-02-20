<?php

class Term_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function getCountTerm()
    {
        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search'])) {
            $search = " WHERE CONCAT(term,'/',year) LIKE '%" . $_REQUEST['search'] . "%'";
        }

        //ถ้ามีการจัดเรียง
        $order = "";
        if (isset($_REQUEST['sort'])) {
            $order = $_REQUEST['sort'] . " " . $_REQUEST['order'] . ",";
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM vg_terms\n";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT *,CONCAT(term,'/',year) term_name FROM vg_terms\n";
        $sql_total = $sql . $search . " ORDER BY $order status DESC,term_id DESC";
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $search  . " ORDER BY $order status DESC,term_id DESC " . $limit;
        $data_result = $this->db->Query($sql, []);

        return [$total, $totalnotfilter, json_decode($data_result)];
    }

    function changeTermUnActive($user_create)
    {
        $sql = "SELECT * FROM vg_terms\n" .
            "WHERE status = 1";
        $data = $this->db->Query($sql, []);
        $term_data_active = json_decode($data);
        foreach ($term_data_active as $obj) {
            $sql = "UPDATE vg_terms SET status = 0 WHERE term_id = :term_id";
            $this->db->Update($sql, ["term_id" =>  $obj->term_id]);
        }
    }

    function insertTerm($arr_data)
    {
        $sql = "INSERT INTO vg_terms(term,year,user_create) VALUES (:term,:year,:user_create)";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }


    function updateTerm($arr_data)
    {
        $sql = "UPDATE vg_terms SET term = :term,year = :year WHERE term_id = :term_id";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }


    public function deleteTerm($term_id)
    {
        $sql = "DELETE FROM vg_terms WHERE term_id = :term_id";
        $data = $this->db->Delete($sql, ["term_id" => $term_id]);
        return $data;
    }

    function getTermByAdmin()
    {
        $sql = "SELECT term_id,CONCAT(term,'/',year) term_name FROM vg_terms \n" ;
        $data = $this->db->Query($sql, []);
        return $data;
    }

    function getrTermActive()
    {
        $sql = "SELECT term_id,CONCAT(term,'/',year) term_name FROM vg_terms \n" .
            "WHERE vg_terms.status = 1";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }
}
