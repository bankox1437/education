<?php
class EstimateModel
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function getFamilyDataWhereStdId($std_id)
    {
        $sql = "SELECT * FROM stf_tb_family_data WHERE std_id = :std_id";
        $data = $this->db->Query($sql, ["std_id" => $std_id]);
        $data = json_decode($data, true);
        return $data;
    }

    function insertEstimate($arr_data)
    {
        $sql = "INSERT INTO stf_tb_estimate(std_id, year, user_create) VALUES (:std_id, :year, :user_create);";
        $data = $this->db->InsertLastID($sql, $arr_data);
        return $data;
    }

    function insertEstimateDetail($arrData)
    {
        $sql = "INSERT INTO stf_tb_estimate_detail(estimate_id, side, sub_side, checked, premise_select) VALUES (:estimate_id, :side, :sub_side, :checked, :premise_select);";
        $data = $this->db->Insert($sql, $arrData);
        return $data;
    }

    function updateEstimateDetail($arrData)
    {
        $sql = "UPDATE stf_tb_estimate_detail \n" .
            "SET \n" .
            "checked = :checked,\n" .
            "premise_select = :premise_select \n" .
            "WHERE\n" .
            "	estimate_det_id = :estimate_det_id;";
        $data = $this->db->Update($sql, $arrData);
        return $data;
    }

    function deleteEstimate($estimate_id)
    {
        $sql = "DELETE FROM stf_tb_estimate WHERE estimate_id = :estimate_id";
        $data = $this->db->Delete($sql, ["estimate_id" => $estimate_id]);
        return $data;
    }


    function getDataEstimate()
    {

        $whereAddress = "";
        if ($_SESSION['user_data']->edu_type != "edu_other") {
            $startProvince = $_SESSION['user_data']->role_id == 3 ? " AND " : " WHERE ";

            $startSub = $_SESSION['user_data']->role_id == 2 ? " WHERE " : " AND ";

            require_once("../../config/main_function.php");
            $mainFunc = new ClassMainFunctions();

            $whereAddress .= $mainFunc->getSqlFindAddress($startProvince, $startSub, 1);
        }

        // $userCondition = ($_SESSION['user_data']->role_id == 3) ? " (f.user_create = {$_SESSION['user_data']->id} OR std.user_create = {$_SESSION['user_data']->id})" : " f.user_create = {$_SESSION['user_data']->edu_type}";
        $userCondition = "";
        $action = "";
        if ($_SESSION['user_data']->role_id == 3 || isset($_POST['userCreate'])) {
            $action = " WHERE ";
            $userid = $_SESSION['user_data']->id;
            if (isset($_POST['userCreate']) && $_POST['userCreate'] != 0) {
                $userid = $_POST['userCreate'];
            }
            $userCondition = $action . " es.user_create = {$userid}";
        }

        $classnameWhere = "";
        $actionClass = " AND ";
        if (empty($action)) {
            $actionClass = " WHERE ";
        }
        if ($_POST['className'] == 0) {
            $classnameWhere = $actionClass . " std.std_class = 'ประถม' \n";
        }
        if ($_POST['className'] == 1) {
            $classnameWhere = $actionClass . " std.std_class = 'ม.ต้น' \n";
        }
        if ($_POST['className'] == 2) {
            $classnameWhere = $actionClass . " std.std_class = 'ม.ปลาย' \n";
        }

        $yearWhere = "";
        $actionYear = " AND ";
        if (!empty($_POST['year'])) {
            $yearWhere = $actionYear . " es.year = " . $_POST['year'] . " \n";
        }

        $sql = "SELECT\n" .
            "	es.*,\n" .
            "	std_code,\n" .
            "	CONCAT( std.std_prename,'',std.std_name) std_name,\n" .
            "	IFNULL(\n" .
            "		CONCAT( u.NAME, ' ', u.surname ),\n" .
            "		( SELECT CONCAT( std_prename, std_name ) FROM tb_students WHERE std_id = es.user_create ) \n" .
            "	) AS user_create_data,\n" .
            "	( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '1' ) side1,\n" .
            "	( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '2' ) side2,\n" .
            "	( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '3' ) side3,\n" .
            "	( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '4' ) side4,\n" .
            "	( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '5' ) side5,\n" .
            "	( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '6' ) side6,\n" .
            "	( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '7' ) side7,\n" .
            "	( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '8' ) side8,\n" .
            "	( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '9' ) side9,\n" .
            "	( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '10' ) side10,\n" .
            "	( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '11' ) side11 \n" .
            "FROM\n" .
            "	stf_tb_estimate es\n" .
            "	LEFT JOIN tb_users u ON es.user_create = u.id\n" .
            "	INNER JOIN tb_students std ON es.std_id = std.std_id \n" .
            $userCondition . $classnameWhere . $yearWhere;

        $data_result = $this->db->Query($sql, []);

        return [json_decode($data_result), $sql];
    }
}
