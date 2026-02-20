<?php

class ReadbBookModel
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    // ฟังก์ชันสำหรับเพิ่มข้อมูลหนังสือ/สื่อ
    public function InsertReadBook($array_data)
    {
        $sql = "INSERT INTO rd_read_books (date, month, year, title, author, publisher, book_type, summary, analysis, reference, user_create)
            VALUES (:date, :month, :year, :title, :author, :publisher, :book_type, :summary, :analysis, :reference, :user_create)";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data; // ส่งคืน ID ของข้อมูลที่เพิ่มใหม่
    }

    // ฟังก์ชันสำหรับแก้ไขข้อมูลหนังสือ/สื่อ
    public function EditReadBook($array_data)
    {
        $sql = "UPDATE rd_read_books 
            SET date = :date, 
                month = :month, 
                year = :year, 
                title = :title, 
                author = :author, 
                publisher = :publisher, 
                book_type = :book_type, 
                summary = :summary, 
                analysis = :analysis, 
                reference = :reference 
            WHERE id = :id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function EditReadBookImage($image, $id)
    {
        $sql = "UPDATE rd_read_books 
            SET image = :image
            WHERE id = :id";
        $data = $this->db->Update($sql, ['image' => $image, 'id' => $id]);
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
    public function deleteReadBook($id)
    {
        $sql = "DELETE FROM rd_read_books WHERE id = :id";
        $data = $this->db->Delete($sql, ["id" => $id]);
        return $data;
    }

    function getReadBooks()
    {
        $user_condition = " rb.user_create = " . ($_SESSION['user_data']->role_id == 4 ? $_SESSION['user_data']->edu_type : $_REQUEST['std_id']) . "\n";

        $whereTotal = "";
        $user_condition_and = " ";
        if (!empty($user_condition)) {
            $user_condition_and = " WHERE " . $user_condition;
            $whereTotal = " WHERE " . $user_condition;
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM rd_read_books rb \n" .
            $whereTotal;
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	rb.* " .
            "FROM\n" .
            "	rd_read_books rb\n";
        // "WHERE tg.user_create = :user_create";
        $sql_total = $sql . $user_condition_and;
        $total_result = $this->db->Query($sql_total, []);

        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $user_condition_and . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }

    public function getDataStudent()
    {
        $whereStdClass = "";
        if (isset($_REQUEST['std_class']) && !empty($_REQUEST['std_class'])) {
            $whereStdClass = " AND std.std_class = '" . $_REQUEST['std_class'] . "'";
        }
        $sql_order = "SELECT\n" .
            "	COUNT(*) totalnotfilter\n" .
            "FROM\n" .
            "	tb_students std WHERE user_create = :user_create $whereStdClass\n";
        $totalnotfilter = $this->db->Query($sql_order, ["user_create" => $_SESSION['user_data']->id]);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT\n" .
            "	std.*,\n" .
            "	(SELECT count(*) FROM rd_read_books WHERE user_create = std.std_id) count_read\n" .
            "FROM\n" .
            "	tb_students std\n" .
            "WHERE user_create = :user_create $whereStdClass";
        $sql_total = $sql;
        $total_result = $this->db->Query($sql_total, ["user_create" => $_SESSION['user_data']->id]);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $limit = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql_total . $limit;
        $data_result = $this->db->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
        return [$total, $totalnotfilter, json_decode($data_result)];
    }

    public function getDataStudentLib()
    {
        $whereStdClass = "";
        if (isset($_REQUEST['std_class']) && !empty($_REQUEST['std_class'])) {
            $whereStdClass = " AND ts.std_class = '" . $_REQUEST['std_class'] . "'";
        }

        $whereSubDistrictId = "";
        if (isset($_REQUEST['subdis_id']) && !empty($_REQUEST['subdis_id'])) {
            $whereSubDistrictId = " AND edu.sub_district_id = '" . $_REQUEST['subdis_id'] . "'";
        }

        $whereTeacherId = "";
        if (isset($_REQUEST['teacher_id']) && !empty($_REQUEST['teacher_id'])) {
            $whereTeacherId = " AND tu.id = '" . $_REQUEST['teacher_id'] . "'";
        }
        $sql_order = "SELECT\n" .
            "	COUNT(*) totalnotfilter\n" .
            "FROM\n" .
            "	tb_students ts 
            LEFT JOIN 
                tb_users tu ON ts.user_create = tu.id 
            LEFT JOIN 
                tbl_non_education edu ON tu.edu_id = edu.id 
            WHERE edu.district_id = :district_id $whereStdClass $whereSubDistrictId $whereTeacherId\n";
        $totalnotfilter = $this->db->Query($sql_order, ["district_id" => $_SESSION['user_data']->district_am_id]);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "SELECT 
                ts.*,
                edu.name edu_name,
                COUNT(rb.id) AS count_read
            FROM 
                tb_students ts
            LEFT JOIN 
                tb_users tu ON ts.user_create = tu.id
            LEFT JOIN 
                tbl_non_education edu ON tu.edu_id = edu.id
            LEFT JOIN 
                rd_read_books rb ON rb.user_create = ts.std_id
            WHERE 
                edu.district_id = :district_id $whereStdClass $whereSubDistrictId $whereTeacherId
            GROUP BY 
                ts.std_id
            HAVING 
                count_read != 0;";
        $sql_total = $sql;
        $total_result = $this->db->Query($sql_total, ["district_id" => $_SESSION['user_data']->district_am_id]);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $limit = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql_total . $limit;
        $data_result = $this->db->Query($sql, ["district_id" => $_SESSION['user_data']->district_am_id]);
        return [$total, $totalnotfilter, json_decode($data_result)];
    }
}
