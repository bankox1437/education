<?php

use function PHPSTORM_META\type;

class ListNameModel
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function getListName()
    {
        $user_condition = " WHERE ln.user_create = " . $_SESSION['user_data']->id . "\n";

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM vg_list_name ln \n";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT * FROM vg_list_name ln \n";

        $sql_total = $sql . $user_condition;
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $limit = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $user_condition . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }

    public function insertListName($arr_name)
    {
        $sql = "INSERT INTO vg_list_name (name1,name2,name3,name4,user_create) VALUES (:name1,:name2,:name3,:name4,:user_create)";
        $result = $this->db->Insert($sql, $arr_name);
        return $result;
    }

    public function editListName($arr_name)
    {
        $sql = "UPDATE vg_list_name SET name1 = :name1,name2 = :name2,name3 = :name3,name4 = :name4 WHERE list_name_id = :list_name_id";
        $result = $this->db->Update($sql, $arr_name);
        return $result;
    }

    public function deleteListName($list_name_id)
    {
        $sql = "DELETE FROM vg_list_name WHERE list_name_id = :list_name_id";
        $result = $this->db->Update($sql, ["list_name_id" => $list_name_id]);
        return $result;
    }

    public function checkHaveListName()
    {
        //นับจำนวนที่มีการ filter
        $sql = "SELECT * FROM vg_list_name ln  WHERE user_create = :user_create\n";
        $total_result = $this->db->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
        return json_decode($total_result);
    }
}
