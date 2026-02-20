<?php

class KPC_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function insertKPC($arr_data, $mode = "add")
    {

        $sql = "SELECT * FROM vg_kpc kpc WHERE std_id = :std_id AND term_id = :term_id";
        $kpcData = $this->db->Query($sql, ["std_id" => $arr_data['std_id'], "term_id" => $arr_data['term_id']]);
        $kpcData = json_decode($kpcData);
        $data = 0;
        if (count($kpcData) > 0) {
            // unset($arr_data['term_id']);
            unset($arr_data['std_class']);
            unset($arr_data['user_create']);
            if ($mode == "update") {
                $arr_data['hour'] = ($kpcData[0]->hour + (int)$arr_data['hour']);
            }
            $sql = "UPDATE vg_kpc SET hour = :hour WHERE std_id = :std_id AND term_id = :term_id";
            $data = $this->db->Update($sql, $arr_data);
        } else {
            $sql = "INSERT INTO vg_kpc(term_id,std_class,hour,user_create,std_id) VALUES (:term_id,:std_class,:hour,:user_create,:std_id)";
            $data = $this->db->Insert($sql, $arr_data);
        }

        return $data;
    }

    function getDataKPC()
    {
        //ถ้ามีการค้นหา
        $search = "";
        if (isset($_REQUEST['search'])) {
            $search = " AND ( CONCAT(std_prename, std.std_name ) LIKE '%" . $_REQUEST['search'] . "%' \n";
            $search .= " OR CONCAT( term.term, '/', term.`year` ) LIKE '%" . $_REQUEST['search'] . "%' ) ";
        }

        //ถ้ามีการจัดเรียง
        $order = " kpc.term_id ASC , kpc.user_create ASC, std.std_code ASC ";
        if (isset($_REQUEST['sort'])) {
            $order = "std." . $_REQUEST['sort'] . " " . $_REQUEST['order'];
        }

        $group_by = "\n GROUP BY kpc.std_id \n";
        // $group_by = "";


        $term_name = " WHERE kpc.term_id = " . $_SESSION['term_active']->term_id . " \n";
        if (isset($_REQUEST['term_id']) && $_REQUEST['term_id'] != "0") {
            $term_name = " WHERE kpc.term_id = " . $_REQUEST['term_id'] . " \n";
        } else  if (isset($_REQUEST['term_id']) && $_REQUEST['term_id'] == "0") {
            $term_name = "";
        }

        $user_condition = " kpc.user_create = " . $_SESSION['user_data']->id . "\n";
        $address = "";
        $admin_join = "";
        $where_address = "";
        if ($_SESSION['user_data']->role_id == 1) {
            $user_condition = "";
            $address = ", ( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province, \n" .
                "   CONCAT(u.name,' ',u.surname) user_create_name \n";
            $admin_join = "LEFT JOIN tb_users u ON kpc.user_create = u.id\n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";


            require_once("../../config/main_function.php");
            $mainFunc = new ClassMainFunctions();
            $where_address =  $mainFunc->getSqlFindAddress();
        }

        $whereTotal = "";
        $user_condition_and = " ";
        if (!empty($user_condition)) {

            if (empty($term_name)) {
                $user_condition_and = " WHERE " . $user_condition;
            } else {
                $user_condition_and = " AND " . $user_condition;
            }

            $whereTotal = " WHERE " . $user_condition;
        }

        $std_class = "";
        if (isset($_REQUEST['std_class']) && !empty($_REQUEST['std_class'])) {
            $std_class = " AND  kpc.std_class = '" . $_REQUEST['std_class'] . "' \n";
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM vg_kpc kpc\n" .
            $whereTotal;
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //$sum_hour =  " SUM(kpc.hour) sum_hour,\n";
        $sum_hour =  " SUM(kpc.HOUR) sum_hour,\n";
        $sum_hour_all =  " IFNULL((SELECT SUM( `hour` ) FROM vg_kpc kpc WHERE kpc.std_id = std.std_id),0 ) sum_hour_all,";
        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	kpc.kpc_id,\n" . $sum_hour . $sum_hour_all .
            "	CONCAT( term.term, '/', term.`year` ) term_name,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name,\n" .
            "	std.std_code,\n" .
            "	kpc.std_class \n" .
            $address .
            "FROM\n" .
            "	vg_kpc kpc\n" .
            "	LEFT JOIN vg_terms term ON kpc.term_id = term.term_id\n" .
            "	LEFT JOIN tb_students std ON kpc.std_id = std.std_id \n" .
            $admin_join;

        $sql_total = $sql . $term_name . $user_condition_and . $search . $std_class . $where_address . "$group_by ORDER BY $order ";
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $limit = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $term_name . $user_condition_and . $search . $std_class . $where_address  . "$group_by ORDER BY $order " . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }

    function updateKPC($arr_data)
    {
        $sql = "UPDATE vg_kpc SET hour = :hour WHERE kpc_id = :kpc_id";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function deleteKPC($kpc_id)
    {
        $sql = "DELETE FROM vg_kpc WHERE kpc_id = :kpc_id";
        $data = $this->db->Delete($sql, ["kpc_id" => $kpc_id]);
        return $data;
    }

    public function getSTDByStdCode($std_code)
    {
        $sql = "SELECT * FROM tb_students std 
                WHERE std.std_code = :std_code AND std.user_create = :user_create";
        $data = $this->db->Query($sql, ["std_code" => $std_code, "user_create" => $_SESSION['user_data']->id]);
        return $data;
    }

    public function getKPCByStdId($std_id)
    {
        $sql = "SELECT * FROM vg_kpc kpc
                LEFT JOIN tb_students std ON kpc.std_id = std.std_id
                WHERE std.std_id = :std_id  AND kpc.term_id = :term_id";

        $data = $this->db->Query($sql, ["std_id" => $std_id, "term_id" => $_SESSION['term_active']->term_id]);
        return $data;
    }
}
