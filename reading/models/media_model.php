<?php

class MediaModel
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function getDataMedia()
    {
        //ถ้ามีการค้นหา
        // if (isset($_REQUEST['search'])) {
        //     $search = " WHERE media_name LIKE '%" . $_REQUEST['search'] . "%' \n";
        // }

        $user_condition = " md.user_create = " . $_SESSION['user_data']->id . "\n";
        $address = "";
        $admin_join = "";
        $where_address = "";
        if ($_SESSION['user_data']->role_id == 1  || $_SESSION['user_data']->role_id == 2) {
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
            $user_condition_and = " WHERE " . $user_condition;
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
            "	md.*,\n" .
            "	IFNULL((\n" .
            "		SELECT\n" .
            "			SUM( duration ) \n" .
            "		FROM\n" .
            "			rd_audio_test rat\n" .
            "		WHERE\n" .
            "			rat.test_read_id = md.media_id \n" .
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
        $sql_total = $sql . $user_condition_and . $where_address . " ORDER BY media_name ASC \n";
        $total_result = $this->db->Query($sql_total, []);

        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $user_condition_and .  $where_address .  " ORDER BY media_name ASC \n" . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }

    function insertMedia($arr_data)
    {
        $sql = "INSERT INTO rd_medias(media_name, link_e_book, link_test, link_know_test, media_file_name,media_file_name_cover, media_type, std_class, author_name, isChecked, user_create) VALUES (:media_name, :link_e_book, :link_test, :link_know_test, :media_file_name,:media_file_name_cover, :media_type, :std_class, :author_name, :isChecked, :user_create);";
        $data = $this->db->InsertLastId($sql, $arr_data);
        return $data;
    }

    function insertMediaAccept($user_id, $media_id)
    {
        $sql = "INSERT INTO rd_accept_policy(user_id,media_id) VALUES (:user_id, :media_id);";
        $data = $this->db->Insert($sql, ["user_id" => $user_id, "media_id" => $media_id]);
        return $data;
    }

    function updateMedia($arr_data)
    {
        $sql = "UPDATE rd_medias SET media_name = :media_name, link_e_book = :link_e_book, link_test = :link_test, link_know_test = :link_know_test, media_file_name = :media_file_name,media_file_name_cover = :media_file_name_cover, std_class = :std_class, author_name = :author_name WHERE media_id = :media_id;";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function changeStatusWorkingMedia($arr_data)
    {
        array_pop($arr_data);
        $sql = "UPDATE rd_medias SET status_working = :status_change WHERE media_id = :media_id AND user_create = :user_create;";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function changeWorkingMedia($arr_data, $statusWorking)
    {
        if ($statusWorking == 0) {
            array_pop($arr_data);
            $sqlD = "DELETE FROM rd_reading_test WHERE media_id = :media_id  AND user_create = :user_create;";
            $data = $this->db->Delete($sqlD, $arr_data);
        } else if ($statusWorking == 1) {
            $sqlD = "INSERT INTO rd_reading_test(media_id,user_create,test_reading_name) VALUES(:media_id,:user_create,:media_name);";
            $data = $this->db->Insert($sqlD, $arr_data);
        }
        return $data;
    }

    public function deleteMedia($media_id)
    {
        $sql = "DELETE FROM rd_medias WHERE media_id = :media_id";
        $data = $this->db->Delete($sql, ["media_id" => $media_id]);
        return $data;
    }

    function getAudioFileForDelete($media_id)
    {
        $sql = "SELECT * FROM rd_audio_test WHERE test_read_id = :test_read_id";
        $result = $this->db->Query($sql, ["test_read_id" => $media_id]);
        return json_decode($result);
    }

    function stdGetDataTestGrade()
    {
        $sql_format = "SELECT format FROM vg_test_grade tg WHERE std_id = " . $_SESSION['user_data']->edu_type . " LIMIT 1 ";
        $formatGrade = $this->db->Query($sql_format, []);
        $formatGrade = json_decode($formatGrade);

        $sql_class = "SELECT std_class,user_create FROM tb_students WHERE std_id = " . $_SESSION['user_data']->edu_type . " LIMIT 1 ";
        $class_std = $this->db->Query($sql_class, []);
        $class_std = json_decode($class_std);

        if (count($formatGrade) == 0) {
            $sql_format = "SELECT format FROM vg_test_grade tg WHERE std_id = '" .  $class_std[0]->std_class . "' LIMIT 1 ";
            $formatGrade = $this->db->Query($sql_format, []);
            $formatGrade = json_decode($formatGrade);
        }

        $formatSTD = count($formatGrade) > 0 ? $formatGrade[0]->format : 0;

        //ถ้ามีการค้นหา
        if (isset($_REQUEST['search'])) {
            $search = " AND CONCAT( term.term, ' ', term.`year` ) LIKE '%" . $_REQUEST['search'] . "%'";
        }

        //ถ้ามีการจัดเรียง
        $order = "";
        if (isset($_REQUEST['sort'])) {
            $order = "std." . $_REQUEST['sort'] . " " . $_REQUEST['order'];
        }


        $std_id = " tg.std_id = " . $_SESSION['user_data']->edu_type;
        $format = "";

        if (!$formatSTD) {
            $format = "";
        } else {
            $format = " tg.format = " . $formatSTD . " AND tg.user_create = " . $class_std[0]->user_create . " AND tg.std_id = '" . $class_std[0]->std_class . "'";
            $std_id = "";
        }

        if (isset($_REQUEST['format']) && $_REQUEST['format'] == 1) {
            $format = " tg.format = " . $_REQUEST['format'] . " AND tg.user_create = " . $_REQUEST['user_create_std'] . " AND tg.std_id = '" . $class_std[0]->std_class . "'";
            $std_id = "";
            $formatSTD = 1;
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM vg_test_grade tg\n" .
            "WHERE " . $std_id . $format;
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	tg.*,\n" .
            "	CONCAT( term.term, '/', term.`year` ) term_name, \n" .
            "   IFNULL(std.std_class,tg.std_id) std_class \n" .
            "FROM\n" .
            "	vg_test_grade tg\n" .
            "	LEFT JOIN vg_terms term ON tg.term_id = term.term_id \n" .
            "   LEFT JOIN tb_students std ON tg.std_id = std.std_id\n" .
            "WHERE\n" .
            $std_id;
        $sql_total = $sql . $format . $search . " $order ";
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $format . $search  . " $order " . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql_total, $formatSTD];
    }

    function getDataMediaReading()
    {
        $sql = "SELECT * FROM rd_medias WHERE user_create = :user_create";
        $result = $this->db->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
        return json_decode($result);
    }

    function insertAudioTest($arr_data)
    {
        $sql = "INSERT INTO rd_audio_test( test_read_id, duration, type, file_audio_test, user_create)\n" .
            "VALUES\n" .
            "	(:test_read_id, :duration, :type, :file_audio_test, :user_create);";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    function insertViewMedia($media_id, $mode = 'count')
    {
        $sql = "SELECT * FROM rd_view_media WHERE media_id = :media_id";
        $result = $this->db->Query($sql, ["media_id" => $media_id]);
        $result = json_decode($result);

        if (count($result) == 0) {
            $sql = "INSERT INTO rd_view_media ( media_id, count, duration)\n" .
                "VALUES\n" .
                "	( :media_id, 1, 0);";
            $this->db->Insert($sql, ['media_id' => $media_id]);
        } else {
            $result = $result[0];
            $count =  (int)$result->count;
            $duration = (int)$result->duration;
            if ($mode == 'count') {
                $count =   $count + 1;
                $sql = "UPDATE rd_view_media SET count = $count WHERE media_id = :media_id;";
                $this->db->Update($sql, ['media_id' => $media_id]);
            } else {
                $duration =  (int)$duration + 5;
                $sql = "UPDATE rd_view_media SET duration = $duration WHERE media_id = :media_id;";
                $this->db->Update($sql, ['media_id' => $media_id]);
            }
        }
        return true;
    }
}
