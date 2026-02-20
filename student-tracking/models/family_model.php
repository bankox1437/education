<?php
class FamilyModel
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

    function insertFamilyData($arr_data)
    {
        $sql = "INSERT INTO stf_tb_family_data ( home_number, moo, subdistrict, district, province, street, alley, alley1, user_create)\n" .
            "VALUES\n" .
            "	(:home_number, :moo, :subdistrict, :district, :province, :street, :alley, :alley1, :user_create);";
        $data = $this->db->InsertLastID($sql, $arr_data);
        return $data;
    }

    function updateFamilyData($arr_data)
    {
        $sql = "UPDATE stf_tb_family_data \n" .
            "SET \n" .
            "home_number = :home_number,\n" .
            "moo = :moo,\n" .
            "alley = :alley,\n" .
            "alley1 = :alley1,\n" .
            "street = :street,\n" .
            "subdistrict = :subdistrict,\n" .
            "district = :district,\n" .
            "province = :province\n" .
            "WHERE\n" .
            "	family_id = :family_id;";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    function insertFamilyDataDetail($arrData)
    {
        $sql = "INSERT INTO stf_tb_family_data_detail (`family_id`, `name`, `gender`, `age`, `job`, `education`, `need_training`, `ability`, `role_village`, `training_1`, `training_2`, `training_3` )\n" .
            "VALUES\n" .
            "	(:family_id, :name, :gender, :age, :job, :education, :need_training, :ability, :role_village, :training_1, :training_2, :training_3);";
        $data = $this->db->Insert($sql, $arrData);
        return $data;
    }

    function updateFamilyDataDetail($arrData)
    {
        $sql = "UPDATE stf_tb_family_data_detail \n" .
            "SET NAME = :name,\n" .
            "gender = :gender,\n" .
            "age = :age,\n" .
            "job = :job,\n" .
            "education = :education,\n" .
            "need_training = :need_training,\n" .
            "ability = :ability,\n" .
            "role_village = :role_village,\n" .
            "training_1 = :training_1,\n" .
            "training_2 = :training_2,\n" .
            "training_3 = :training_3 \n" .
            "WHERE\n" .
            "	family_det_id = :family_det_id;";
        $data = $this->db->Update($sql, $arrData);
        return $data;
    }

    function deleteFamily($family_id)
    {
        $sql = "DELETE FROM stf_tb_family_data WHERE family_id = :family_id";
        $data = $this->db->Delete($sql, ["family_id" => $family_id]);
        return $data;
    }


    function getFamilyData()
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
        $joinUser = " LEFT JOIN tb_users u ON f.user_create = u.id ";
        if ($_SESSION['user_data']->role_id == 3) {
            $userCondition = " (f.user_create = {$_SESSION['user_data']->id} OR std.user_create = {$_SESSION['user_data']->id})";
        } else if ($_SESSION['user_data']->role_id == 4) {
            $userCondition = " f.user_create = {$_SESSION['user_data']->edu_type}";
            $joinUser = " LEFT JOIN tb_users u ON f.user_create = u.edu_type ";
        }

        $whereTotal = $userCondition ? " WHERE $userCondition" : "";

        $searchCondition = "";
        $whereSearch = "";
        if (isset($_REQUEST['search'])) {
            $searchTerm = $_REQUEST['search'];
            $searchCondition = " ( CONCAT(f.std_name) LIKE '%$searchTerm%' OR f.national_id LIKE '%$searchTerm%' )";
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
        $sqlTotal = "SELECT count(*) totalnotfilter FROM stf_tb_family_data f \n" .
            "LEFT JOIN tb_students std ON f.user_create = std.std_id \n" .
            $whereTotal;
        $totalnotfilter = $this->db->Query($sqlTotal, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        // echo "whereTotal ==> " . $whereTotal . "<br>";
        // echo "whereAddress ==> " . $whereAddress . "<br>";
        // echo "searchCondition ==> " . $searchCondition . "<br>";

        // Combine queries to get total count and filtered data
        $sql = "SELECT
                f.*,
                p.name_th province_th,
                d.name_th district_th,
                sd.name_th subdistrict_th,
                IFNULL(
                    CONCAT( u.NAME, ' ', u.surname ),
                    ( SELECT CONCAT( std_prename, std_name ) FROM tb_students WHERE std_id = f.user_create ) 
                ) AS user_create_data 
            FROM stf_tb_family_data f
            $joinUser
            LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id
            LEFT JOIN tbl_sub_district sd ON f.subdistrict = sd.id
            LEFT JOIN tbl_district d ON f.district = d.id
            LEFT JOIN tbl_provinces p ON f.province = p.id
            LEFT JOIN tb_students std ON f.user_create = std.std_id
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
