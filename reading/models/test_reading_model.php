<?php

class Test_Reading_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function InsertTestReading($array_data)
    {
        // echo "<pre>";
        // print_r($array_data);
        // echo "</pre>";
        $sql = "INSERT INTO rd_reading_test (test_reading_name,date_test, date_out_test,description,media_id,std_class,user_create)\n" .
            "VALUES\n" .
            "	(:test_reading_name,:date_test, :date_out_test, :description, :media_id, :std_class, :user_create);";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function EditTestReading($array_data)
    {
        $sql = "UPDATE rd_reading_test SET test_reading_name = :test_reading_name,date_test = :date_test, date_out_test = :date_out_test, description = :description,media_id = :media_id,std_class = :std_class WHERE test_read_id = :test_read_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    // function getTermSelect($user_id)
    // {
    //     if (empty($user_id)) {
    //         $user_id = $_SESSION['user_data']->id;
    //     }
    //     $sql = "SELECT term,year FROM cl_calendar WHERE user_create = :user_create group by term,year ORDER BY time,term,year";
    //     $data = $this->db->Query($sql, ['user_create' => $user_id]);
    //     return json_decode($data);
    // }
    public function deleteTestReading($id)
    {
        $sql = "DELETE FROM rd_reading_test WHERE test_read_id = :test_read_id";
        $data = $this->db->Delete($sql, ["test_read_id" => $id]);
        return $data;
    }

    function getDataTestReading()
    {
        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search'])) {
            $search = " AND media_name LIKE '%" . $_REQUEST['search'] . "%' \n";
        }
        $user_condition = " rm.user_create = " . ($_SESSION['user_data']->role_id == 4 ? $_SESSION['user_data']->user_create : $_SESSION['user_data']->id) . "\n";
        $address = "";
        $admin_join = "";
        $where_address = "";
        if ($_SESSION['user_data']->role_id == 1) {
            $user_condition = "";
            $address = ", ( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province, \n" .
                "   CONCAT(u.name,' ',u.surname) user_create_name \n";
            $admin_join = "LEFT JOIN tb_users u ON rm.user_create = u.id\n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";

            require_once("../../config/main_function.php");
            $mainFunc = new ClassMainFunctions();
            $where_address =  $mainFunc->getSqlFindAddress();
        }

        $whereTotal = "";
        $user_condition_and = " ";
        if (!empty($user_condition)) {
            $user_condition_and = " AND " . $user_condition;
            $whereTotal = " AND " . $user_condition;
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM rd_medias rm WHERE \n" .
            substr($whereTotal, 4);
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        $sqlSTD = "SELECT 
                        std_class, 
                        std.user_create, 
                        edu.district_id dis_id
                    FROM 
                        tb_students std 
                        LEFT JOIN tb_users tu ON std.user_create = tu.id 
                        LEFT JOIN tbl_non_education edu ON tu.edu_id = edu.id 
                    WHERE 
                        std_id = " . $_SESSION['user_data']->edu_type;
        $dataStd = $this->db->Query($sqlSTD, []);
        $stdClass = json_decode($dataStd, true);
        $stdClass = $stdClass[0];

        $districtId = $stdClass["dis_id"];
        $stdClass = $stdClass['std_class'];

        $getCount = "";
        if ($_SESSION['user_data']->role_id == 4) {
            $getCount = ",	
            (
                select COUNT(*) FROM rd_audio_test  WHERE  rd_audio_test.test_read_id = rm.media_id AND rd_audio_test.user_create = " . $_SESSION['user_data']->edu_type . "
            ) count_test \n";
        }

        //นับจำนวนที่มีการ filter
        $sql = "SELECT rm.* $getCount $address FROM rd_medias rm \n WHERE (rm.std_class = '0' or rm.std_class = '" . $stdClass . "') AND rm.status_working = 1 " . $admin_join;


        $sqlUnion = "UNION
                SELECT rm2.* ,	
                            (
                                select COUNT(*) FROM rd_audio_test  WHERE  rd_audio_test.test_read_id = rm2.media_id AND rd_audio_test.user_create = 29148
                            ) count_test 
                FROM rd_medias rm2
                LEFT JOIN tb_users tu ON rm2.user_create = tu.id 
                WHERE (rm2.std_class = '0' or rm2.std_class = '" . $stdClass . "') AND rm2.status_working = 1  AND media_name LIKE '%%' 
                AND  tu.district_am_id = " . $districtId . " and rm2.media_type = 'libraries'";
        // "WHERE tg.user_create = :user_create";
        $sql_total = $sql . $search . $user_condition_and . $where_address . $sqlUnion . " ORDER BY media_name ASC \n";
        $total_result = $this->db->Query($sql_total, []);

        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql .  $search . $user_condition_and .  $where_address . $sqlUnion . " ORDER BY media_name ASC \n" . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }

    function getDataTestReadingOther()
    {
        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
            $search = " AND rm.media_name LIKE '%" . $_REQUEST['search'] . "%' \n";
        }
        $user_condition = "";
        $address = "";
        $admin_join = "";
        $where_address = "";

        $whereTotal = "";
        $user_condition_and = " ";
        if (!empty($user_condition)) {
            $user_condition_and = " AND " . $user_condition;
            $whereTotal = " AND " . $user_condition;
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM rd_medias rm WHERE \n" .
            substr($whereTotal, 4);
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        $getCount = "";

        //นับจำนวนที่มีการ filter
        $sql = "SELECT rm.*, CONCAT(tu.name,' ',tu.surname) user_create_name,td.name_th district, tne.name sub_district
                FROM rd_medias rm \n 
                LEFT JOIN tb_users tu ON rm.user_create = tu.id
                LEFT JOIN tbl_non_education tne on (tu.edu_id = tne.id)
                LEFT JOIN tbl_district td ON (tu.district_am_id = td.id OR tne.district_id = td.id)
                WHERE rm.status_working = 1 AND (rm.media_type = 'libraries' OR rm.media_type = 'edu') AND rm.link_e_book LIKE 'http://%' OR link_e_book LIKE 'https://%'
                    AND rm.user_create IS NOT NULL 
                    AND tu.id IS NOT NULL 
                    AND td.name_th IS NOT NULL" . $admin_join;

        // "WHERE tg.user_create = :user_create";
        $sql_total = $sql . $search . $user_condition_and . $where_address . " ORDER BY media_name ASC \n";
        $total_result = $this->db->Query($sql_total, []);

        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql .  $search . $user_condition_and .  $where_address . " ORDER BY media_name ASC \n" . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }
}
