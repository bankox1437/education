<?php

class N_Net_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function deleteN_Net($n_net_id)
    {
        $sql = "DELETE FROM vg_n_net WHERE n_net_id = :n_net_id";
        $data = $this->db->Delete($sql, ["n_net_id" => $n_net_id]);
        return $data;
    }

    function insertN_Net($arr_data, $status = "insert")
    {
        $action = "INSERT INTO ";
        $where = "";
        $column = " std_id = :std_id,status_text = :status_text,status = :status,user_create = :user_create,term_id = :term_id,std_class = :std_class ";
        if ($status == "update") {
            $action = "UPDATE ";
            $column = " status = :status ,status_text = :status_text ";
            $where = "WHERE n_net_id = :n_net_id";
        }
        $sql = $action . " vg_n_net SET " . $column . $where;
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    function checkStatus($term_id, $std_id)
    {
        $sql = "SELECT n_net_id,status FROM `vg_n_net`\n" .
            "WHERE term_id = :term_id AND std_id = :std_id";
        $data = $this->db->Query($sql, ["term_id" => $term_id, "std_id" => $std_id]);
        return json_decode($data);
    }

    function getDataN_Net()
    {
        $std_class = "";
        if (isset($_REQUEST['std_class']) && !empty($_REQUEST['std_class'])) {
            $std_class = " nn.std_class = '" . $_REQUEST['std_class'] . "' AND ";
        }

        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search'])) {
            $search = "\n ( CONCAT(std.std_prename, std.std_name ) LIKE '%" . $_REQUEST['search'] . "%' ";
            $search .= " OR std.std_code LIKE '%" . $_REQUEST['search'] . "%' )";
        }

        //ถ้ามีการจัดเรียง
        $order = " CONCAT( term.term, '/', term.`year` ) ASC, std.std_code ASC ";
        if (isset($_REQUEST['sort'])) {
            $order = "std." . $_REQUEST['sort'] . " " . $_REQUEST['order'];
        }


        $term_name = " nn.term_id = " . $_SESSION['term_active']->term_id . " AND  \n";
        if (isset($_REQUEST['term_id']) && $_REQUEST['term_id'] != "0") {
            $term_name = " nn.term_id = " . $_REQUEST['term_id'] . " AND \n";
        } else  if (isset($_REQUEST['term_id']) && $_REQUEST['term_id'] == "0") {
            $term_name = " ";
        }

        $user_condition = " nn.user_create = " . $_SESSION['user_data']->id . "\n";
        $address = "";
        $admin_join = "";
        $where_address = "";
        if ($_SESSION['user_data']->role_id == 1) {
            $user_condition = "";
            $address = ", ( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province, \n" .
                "   CONCAT(u.name,' ',u.surname) user_create_name \n";
            $admin_join = "LEFT JOIN tb_users u ON nn.user_create = u.id\n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";


            require_once("../../config/main_function.php");
            $mainFunc = new ClassMainFunctions();
            $where_address =  $mainFunc->getSqlFindAddress();
        }

        $whereTotal = "";
        $user_condition_and = " ";
        if (!empty($user_condition)) {
            $user_condition_and = " AND " . $user_condition;
            $whereTotal = " WHERE " . $user_condition;
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM vg_n_net nn\n" .
            $whereTotal;
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	nn.*,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            "	std.std_code,nn.std_class \n" .
            $address .
            "FROM\n" .
            "	vg_n_net nn\n" .
            "	LEFT JOIN vg_terms term ON nn.term_id = term.term_id\n" .
            "	LEFT JOIN tb_students std ON nn.std_id = std.std_id\n" .
            $admin_join .
            "WHERE " . $std_class . $term_name;
        $sql_total = $sql . $search . $user_condition_and . $where_address . " \n ORDER BY $order ";
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $search . $user_condition_and . $where_address  . " ORDER BY $order " . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }

    function stdGetDataN_Net()
    {
        $std_class = "";
        if (isset($_REQUEST['std_class']) && !empty($_REQUEST['std_class'])) {
            $std_class = " AND std.std_class = '" . $_REQUEST['std_class'] . "' ";
        }

        $term_name = "";
        if (isset($_REQUEST['term_name']) && !empty($_REQUEST['term_name'])) {
            $term_name = " AND CONCAT( term.term, '/', term.`year` ) = '" . $_REQUEST['term_name'] . "' ";
        }

        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search'])) {
            $search = "\n AND ( CONCAT(std.std_prename, std.std_name ) LIKE '%" . $_REQUEST['search'] . "%' ";
            $search .= " OR std.std_code LIKE '%" . $_REQUEST['search'] . "%' )";
        }

        //ถ้ามีการจัดเรียง
        $order = " CONCAT( term.term, '/', term.`year` ) ASC, std.std_code ASC ";
        if (isset($_REQUEST['sort'])) {
            $order = "std." . $_REQUEST['sort'] . " " . $_REQUEST['order'];
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM vg_n_net nn\n" .
            " LEFT JOIN tb_users users ON nn.user_create = users.id \n" .
            "WHERE users.edu_id = :edu_id";
        $totalnotfilter = $this->db->Query($sql_order, ['edu_id' => $_SESSION['user_data']->edu_id]);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	nn.*,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            "	std.std_code,\n" .
            "	std.std_class \n" .
            "FROM\n" .
            "	vg_n_net nn\n" .
            "	LEFT JOIN vg_terms term ON nn.term_id = term.term_id\n" .
            "	LEFT JOIN tb_students std ON nn.std_id = std.std_id \n" .
            "	LEFT JOIN tb_users users ON nn.user_create = users.id \n" .
            "WHERE\n" .
            "	users.edu_id = :edu_id \n" . $std_class . $term_name;
        $sql_total = $sql . $search . " \n ORDER BY $order ";
        $total_result = $this->db->Query($sql_total, ['edu_id' => $_SESSION['user_data']->edu_id]);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $search  . " ORDER BY $order " . $limit;
        $data_result = $this->db->Query($sql, ['edu_id' => $_SESSION['user_data']->edu_id]);
        return [$total, $totalnotfilter, json_decode($data_result)];
    }
}
