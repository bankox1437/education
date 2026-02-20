<?php

class GradiateRegModel
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function deleteGraReg($gra_reg_id)
    {
        $sql = "DELETE FROM stf_tb_gradiate_reg WHERE gra_reg_id = :gra_reg_id";
        $data = $this->db->Delete($sql, ["gra_reg_id" => $gra_reg_id]);
        return $data;
    }

    function insertGraReg($arr_data, $status = "insert")
    {
        $action = "INSERT INTO ";
        $where = "";
        $column = "std_id = :std_id, std_code = :std_code,std_name = :std_name,national_id = :national_id,years = :years,class = :class,file_name = :file_name,user_create = :user_create ";
        if ($status == "update") {
            $action = "UPDATE ";
            $column = " std_code = :std_code,std_name = :std_name,national_id = :national_id,years = :years,class = :class,file_name = :file_name";
            $where = " WHERE gra_reg_id = :gra_reg_id";
        }
        $sql = $action . " stf_tb_gradiate_reg SET " . $column . $where;
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    function getDataGraReg()
    {

        $whereAddress = "";
        if ($_SESSION['user_data']->edu_type != "edu_other") {
            $startProvince = $_SESSION['user_data']->role_id == 3 ? " AND " : " WHERE ";

            $startSub = $_SESSION['user_data']->role_id == 2 ? " WHERE " : " AND ";

            require_once("../../config/main_function.php");
            $mainFunc = new ClassMainFunctions();
            $whereAddress = $mainFunc->getSqlFindAddress($startProvince, $startSub);
        }

        $userCondition = ($_SESSION['user_data']->role_id == 3) ? " gr.user_create = {$_SESSION['user_data']->id}" : "";

        $whereTotal = $userCondition ? " WHERE $userCondition" : "";

        $searchCondition = "";
        $whereSearch = " ";
        if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
            $searchTerm = $_REQUEST['search'];
            $searchCondition = " ( CONCAT(gr.std_name) LIKE '%$searchTerm%' OR gr.national_id LIKE '%$searchTerm%' )";
        }

        if ($whereTotal || $whereAddress) {
            if ($searchCondition != "") {
                $whereSearch = " AND ";
            }
        } else {
            if ($_SESSION['user_data']->role_id == 3) {
                $whereSearch = " WHERE ";
            }
        }
        $searchCondition = $whereSearch . $searchCondition;

        //นับจำนวนทั้งหมด
        $sqlTotal = "SELECT count(*) totalnotfilter FROM stf_tb_gradiate_reg gr\n" .
            $whereTotal;
        $totalnotfilter = $this->db->Query($sqlTotal, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        // Combine queries to get total count and filtered data
        $sql = "SELECT
                gr.*,
                edu.NAME AS edu_name,
                sd.name_th AS sub_district,
                d.name_th AS district,
                p.name_th AS province,
                CONCAT( u.NAME, ' ', u.surname ) user_create_data
            FROM stf_tb_gradiate_reg gr
            LEFT JOIN tb_users u ON gr.user_create = u.id
            LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id
            LEFT JOIN tbl_sub_district sd ON edu.sub_district_id = sd.id
            LEFT JOIN tbl_district d ON edu.district_id = d.id
            LEFT JOIN tbl_provinces p ON edu.province_id = p.id
            $whereTotal
            $whereAddress
            $searchCondition";

        $total_result = $this->db->Query($sql, []);
        $total = count(json_decode($total_result));

        // Apply LIMIT if requested
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT {$_REQUEST['offset']}, {$_REQUEST['limit']}";
            $sql .= $limit;
        }
        $data_result = $this->db->Query($sql, []);

        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }
}
