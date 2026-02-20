<?php

class ReportMediaModel
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function getDataReportMedia()
    {
        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search'])) {
            $search = " WHERE media_name LIKE '%" . $_REQUEST['search'] . "%' \n";
        }

        $user_condition = " md.user_create = " . $_SESSION['user_data']->id . "\n";
        $address = "";
        $admin_join = "";
        $where_address = "";
        if ($_SESSION['user_data']->role_id == 1 || $_SESSION['user_data']->role_id == 2) {
            $user_condition = "";
            $address = ", IFNULL(( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ),u.sub_district_am) sub_district,\n" .
                "	IFNULL(( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ),u.district_am) district,\n" .
                "	IFNULL(( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ),u.province_am) province, \n" .
                "   CONCAT(u.name,' ',u.surname) user_create_name \n";
            $admin_join = "LEFT JOIN tb_users u ON md.user_create = u.id\n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";

            require_once("../../config/main_function.php");
            $mainFunc = new ClassMainFunctions();
            $where_address =  $mainFunc->getSqlFindAddress();
            if ($_SESSION['user_data']->role_id == 2) {
                $where_address = str_replace("WHERE", "AND", $where_address);
            }
        }

        $whereTotal = "";
        $user_condition_and = " ";
        if (!empty($user_condition)) {
            $user_condition_and = " AND " . $user_condition;
            $whereTotal = " WHERE " . $user_condition;
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM rd_medias md \n" .
            $whereTotal;
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "   md.media_id,\n" .
            "	md.media_name,\n" .
            "	IFNULL((\n" .
            "		SELECT\n" .
            "			SUM( duration ) \n" .
            "		FROM\n" .
            "			rd_audio_test rat\n" .
            "			LEFT JOIN rd_reading_test rt ON rat.test_read_id = rt.test_read_id \n" .
            "		WHERE\n" .
            "			rt.media_id = md.media_id \n" .
            "			),\n" .
            "		0 \n" .
            "	) sum_duration, " .
            "IFNULL((\n" .
            "		SELECT\n" .
            "			SUM( duration ) \n" .
            "		FROM\n" .
            "			rd_view_media vm\n" .
            "		WHERE\n" .
            "			vm.media_id = md.media_id \n" .
            "			),\n" .
            "		0 \n" .
            "	) sum_duration_view, \n" .
            "   IFNULL(( SELECT count FROM rd_view_media vm WHERE vm.media_id = md.media_id ), 0 ) view_media \n" .
            $address .
            "FROM\n" .
            "	rd_medias md\n" . $admin_join;
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
        $sql = $sql .  $search . $user_condition_and .  $where_address .  " ORDER BY media_name ASC \n" . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }


    function getDataReportTimeOfMedia($media_id)
    {
        $sql = "SELECT\n" .
            "	CONCAT(std.std_prename,std.std_name) std_name, \n" .
            "   aut.duration, \n" .
            "   aut.file_audio_test, \n" .
            "   aut.type,rt.test_reading_name \n" .
            "FROM\n" .
            "	rd_audio_test aut\n" .
            "	LEFT JOIN tb_students std ON aut.user_create = std.std_id\n" .
            "	LEFT JOIN rd_reading_test rt ON aut.test_read_id = rt.test_read_id\n" .
            "WHERE rt.media_id = :media_id\n";
        $data_result = $this->db->Query($sql, ["media_id" => $media_id]);
        return [json_decode($data_result), $sql];
    }

    function getDataMediaReadingBS()
    {
        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search'])) {
            $search = " WHERE media_name LIKE '%" . $_REQUEST['search'] . "%' \n";
        }

        $whereTotal = "";
        $user_condition = "";
        $whereType = "";
        $admin_join = "";
        $where_address = "";
        // $user_condition = " md.user_create = " . $_SESSION['user_data']->id . "\n";
        $user_condition_and = "";
        if (isset($_SESSION['user_data'])) {
            if ($_SESSION['user_data']->role_id == 3 || $_SESSION['user_data']->role_id == 5) {
                $user_condition = " md.user_create = " . $_SESSION['user_data']->id . "\n";
                $user_condition_and = " AND " . $user_condition;
                $whereTotal = " WHERE " . $user_condition;
            } else if ($_SESSION['user_data']->role_id == 4) {
                $user_condition = " md.user_create = " . $_SESSION['user_data']->user_create . "\n";
                $user_condition_and = " AND " . $user_condition;
                $whereTotal = " WHERE " . $user_condition;
            } else if ($_SESSION['user_data']->role_id == 2) {
                // $user_condition = " md.user_create = " . $_SESSION['user_data']->user_create . "\n";
                // $user_condition_and = " AND " . $user_condition;
                // $whereTotal = " WHERE " . $user_condition;

                $user_condition = "";
                $admin_join = "LEFT JOIN tb_users u ON md.user_create = u.id\n" .
                    "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";

                require_once("../../config/main_function.php");
                $mainFunc = new ClassMainFunctions();
                $where_address =  $mainFunc->getSqlFindAddress();
                if ($_SESSION['user_data']->role_id == 2) {
                    $where_address = str_replace("WHERE", "AND", $where_address);
                    $where_address .= " OR u.district_am_id = " . $_SESSION['user_data']->district_am_id;
                }
            }
        } else {
            $user_condition = " md.media_type = 'libraries'";
            $user_condition_and = " AND " . $user_condition;
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM rd_medias md \n" . $whereTotal;
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "   * \n" .
            "FROM\n" .
            "	rd_medias md\n" . $admin_join;
        // "WHERE tg.user_create = :user_create";
        $sql_total = $sql . $search . $user_condition_and  . $where_address . " ORDER BY media_name ASC \n";
        $total_result = $this->db->Query($sql_total, []);

        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql_total . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }
}
