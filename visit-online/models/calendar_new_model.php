<?php

class Calendar_New_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function InsertCalendar($array_data)
    {
        $param = "";
        $paramVal = "";
        $table = "cl_calendar_new";

        if ($_SESSION['user_data']->role_id != 3) {
            $array_data["province_id"] = $_SESSION['user_data']->province_am_id;
            $param = ",province_id";
            $paramVal = ",:province_id";
            $table = "cl_calendar_new_am";
        } else {
            if (!empty($array_data["from_calendar_am"])) {
                $param = ",from_calendar_am";
                $paramVal = ",:from_calendar_am";
            }
        }

        $sql = "INSERT INTO $table (m_calendar_id,plan_name,content_link,content_file,test_before_link,test_after_link,std_class,user_create,time_step,work_sheet, plan_file $param) VALUES
	            (:m_calendar_id, :plan_name, :content_link, :content_file, :test_before_link, :test_after_link, :std_class, :user_create,:time_step, :work_sheet, :plan_file $paramVal);";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function InsertWork($array_data)
    {
        $table = "cl_work_new";
        if ($_SESSION['user_data']->role_id != 3) {
            $table = "cl_work_new_am";
        }

        $sql = "INSERT INTO $table (calendar_id, file_name)\n" .
            "VALUES\n" .
            "	(:calendar_id, :file_name );";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function InsertOther($array_data)
    {
        $sql = "INSERT INTO cl_other_file (calendar_id, file_name)\n" .
            "VALUES\n" .
            "	(:calendar_id, :file_name );";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function UpdateWork($array_data)
    {
        $table = "cl_work_new";
        if ($_SESSION['user_data']->role_id != 3) {
            $table = "cl_work_new_am";
        }
        $sql = "UPDATE $table SET file_name = :file_name WHERE work_id = :work_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function UpdateOther($array_data)
    {
        $sql = "UPDATE cl_other_file SET file_name = :file_name WHERE other_id = :other_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function EditCalendar($array_data)
    {
        $table = "cl_calendar_new";
        if ($_SESSION['user_data']->role_id != 3) {
            $table = "cl_calendar_new_am";
        }

        $sql = "UPDATE $table SET plan_name = :plan_name,content_link = :content_link,content_file = :content_file,test_before_link = :test_before_link,
                test_after_link = :test_after_link,std_class = :std_class,time_step = :time_step,work_sheet = :work_sheet, plan_file = :plan_file WHERE calendar_id = :calendar_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function getDataCalender($user_id = "", $filterField = "")
    {

        $where = "WHERE ";
        $option = "";
        $arr_data = [];

        if (!empty($user_id)) {
            $whereStrClass = "";
            if ($_SESSION['user_data']->role_id == 4) {
                $sqlStdClass = "SELECT std_class FROM tb_students WHERE std_id = " . $_SESSION['user_data']->edu_type;
                $dataStdClass = $this->db->Query($sqlStdClass, []);
                $stdClassEn = json_decode($dataStdClass, true);
                $whereStrClass = " AND calendar.std_class = :std_class ";
            }
            $where .= " calendar.user_create = :user_id " . $whereStrClass . " \n";
            $option = " AND ";
            $arr_data = ['user_id' => $user_id] + ($_SESSION['user_data']->role_id == 4 ? ['std_class' => $stdClassEn[0]['std_class']] : []);
        }

        if ($_SESSION['user_data']->role_id == 3) {
            $where .=  $option . " calendar.user_create = :user_id\n";
            $arr_data = ['user_id' => $_SESSION['user_data']->id];
        }

        if (isset($filterField['std_class']) && !empty($filterField['std_class'])) {
            $where .= " AND calendar.std_class = '" . $filterField['std_class'] . "' ";
        }
        if (isset($filterField['term_name']) && !empty($filterField['term_name'])) {
            $where .= " AND CONCAT(m.term, '/', m.year) =  '" . $filterField['term_name'] . "' ";
        }

        $std_id = "";
        if (isset($_REQUEST['std_id'])) {
            $std_id = " , ( SELECT COUNT(*) FROM cl_sign_in_to_class_new sign_in WHERE sign_in.std_id = " . $_REQUEST['std_id'] . " AND sign_in.calendar_id = calendar.calendar_id ) sign_in_status \n";
        }
        $count_std_sign = " , ( SELECT COUNT(*) FROM cl_sign_in_to_class_new sign_in WHERE sign_in.calendar_id = calendar.calendar_id ) count_std_sign \n";

        $mainCalendarByClass = " AND m.std_class = '" . $filterField['std_class'] . "' \n";

        $sql = "SELECT\n" .
            "	calendar.*,\n" .
            "	m.*,l.learning_id learning_id_old, \n" .
            "	lf.learning_id learning_id,lf.learning_file  \n" .
            $std_id .
            $count_std_sign .
            "FROM\n" .
            "	cl_calendar_new calendar\n" .
            "	LEFT JOIN cl_main_calendar m ON ( calendar.m_calendar_id = m.m_calendar_id $mainCalendarByClass )\n" .
            "   LEFT JOIN cl_learning_saved l ON calendar.calendar_id = l.calendar_id \n" .
            "   LEFT JOIN cl_learning_save_file lf ON calendar.calendar_id = lf.calendar_id \n" . $where .
            "   ORDER BY calendar.time_step ASC";
        $data = $this->db->Query($sql, $arr_data);
        return json_decode($data);
    }

    public function getDataCalendarOther($sub_dis_id = 0, $pro_id = 0, $dis_id = 0)
    {
        $arr_data = [];
        $wherePro = "";
        $whereDis = "";
        $whereSub = "";
        $where = "";
        if ($_SESSION['user_data']->role_id == 1) {
            $wherePro = $pro_id == 0 ? " \n " : " edu.province_id = " . $pro_id . " \n";
            $whereDis = $dis_id == 0 ? " \n " : " AND edu.district_id = " . $dis_id . " \n";
            $whereSub = $sub_dis_id == 0 ? " \n " : " AND edu.sub_district_id = " . $sub_dis_id . " \n";
            if ($pro_id != 0 && $dis_id  == 0 && $sub_dis_id == 0) {
                $where = "WHERE " . $wherePro;
            }
            if ($pro_id != 0 && $dis_id  != 0 && $sub_dis_id == 0) {
                $where = "WHERE " . $wherePro . $whereDis;
            }
            if ($pro_id != 0 && $dis_id  != 0 && $sub_dis_id != 0) {
                $where = "WHERE " . $wherePro . $whereDis  . $whereSub;
            }
        }
        if ($_SESSION['user_data']->role_id == 2) {
            $whereSub = $sub_dis_id == 0 ? " \n " : " AND edu.sub_district_id = " . $sub_dis_id . " \n";
            $where = "WHERE edu.province_id = " . $_SESSION['user_data']->province_am_id . " AND edu.district_id = " . $_SESSION['user_data']->district_am_id . $whereSub;
        }

        $sql = "SELECT\n" .
            "	u.id,\n" .
            "	u.name,\n" .
            "	u.surname,\n" .
            "	IFNULL( edu.NAME, edu_o.NAME ) edu_name,(\n" .
            "	SELECT\n" .
            "		name_th \n" .
            "	FROM\n" .
            "		tbl_sub_district \n" .
            "	WHERE\n" .
            "		edu.sub_district_id = tbl_sub_district.id \n" .
            "	) sub_district,\n" .
            "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
            "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province \n" .
            "FROM\n" .
            "	cl_calendar_new calendar\n" .
            "	LEFT JOIN tb_users u ON calendar.user_create = u.id\n" .
            "	LEFT JOIN tb_role_users r ON u.role_id = r.role_id\n" .
            "	LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n" .
            "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id \n" .
            $where .
            "GROUP BY\n" .
            "	u.id";
        $data = $this->db->Query($sql, $arr_data);
        return json_decode($data);
    }


    public function getDataCalendarEdit($id)
    {
        $sql = "SELECT * FROM cl_calendar WHERE calendar_id = :id";
        $data = $this->db->Query($sql, ["id" => $id]);
        return json_decode($data);
    }

    public function deleteCalender($id)
    {
        $table = "cl_calendar_new";
        if ($_SESSION['user_data']->role_id != 3) {
            $table = "cl_calendar_new_am";
        }
        $sql = "DELETE FROM $table WHERE calendar_id = :id";
        $data = $this->db->Delete($sql, ["id" => $id]);
        return $data;
    }

    function getTermSelect($user_id)
    {
        if (empty($user_id)) {
            $user_id = $_SESSION['user_data']->id;
        }
        $sql = "SELECT term,year FROM cl_calendar WHERE user_create = :user_create group by term,year ORDER BY time,term,year";
        $data = $this->db->Query($sql, ['user_create' => $user_id]);
        return json_decode($data);
    }

    public function getMainCalendarEnabled()
    {
        $sql = "SELECT * FROM cl_main_calendar WHERE user_create = :user_create AND enabled = 1";
        $data = $this->db->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
        return json_decode($data);
    }

    public function getMainCalendar()
    {
        $sql = "SELECT * FROM cl_main_calendar WHERE user_create = :user_create ORDER BY enabled DESC";
        $data = $this->db->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
        return json_decode($data);
    }

    public function updateEnabledMainCalendar($m_calendar_id)
    {
        $sql = "UPDATE cl_main_calendar SET enabled = 0 WHERE m_calendar_id = :m_calendar_id";
        $data = $this->db->Update($sql, ["m_calendar_id" => $m_calendar_id]);
        return $data;
    }

    function InsertMainCalendar($array_data)
    {
        $sql = "INSERT INTO cl_main_calendar ( m_calendar_name,m_calendar_file,time,term,year,user_create )\n" .
            "VALUES\n" .
            "	(:m_calendar_name, :m_calendar_file,:time,:term,:year, :user_create);";
        $data = $this->db->Insert($sql, $array_data);
        return $data;
    }

    public function deleteMainCalender($id)
    {
        $sql = "DELETE FROM cl_main_calendar WHERE m_calendar_id = :m_calendar_id";
        $data = $this->db->Delete($sql, ["m_calendar_id" => $id]);
        return $data;
    }

    public function EditMainCalendar($array_data)
    {
        $sql = "UPDATE cl_main_calendar SET m_calendar_name = :m_calendar_name,m_calendar_file = :m_calendar_file ,time = :time,term = :term,year = :year\n" .
            " WHERE m_calendar_id = :m_calendar_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function getFileWork($calendar_id)
    {
        $table = "cl_work_new";
        if ($_SESSION['user_data']->role_id != 3) {
            $table = "cl_work_new_am";
        }
        $sql = "SELECT file_name FROM $table WHERE calendar_id = :calendar_id";
        $data = $this->db->Query($sql, ["calendar_id" => $calendar_id]);
        return json_decode($data);
    }

    public function getFileOther($calendar_id)
    {
        $sql = "SELECT file_name FROM cl_other_file WHERE calendar_id = :calendar_id";
        $data = $this->db->Query($sql, ["calendar_id" => $calendar_id]);
        return json_decode($data);
    }

    public function getImageLearning($learning_id)
    {
        $sql = "SELECT * FROM cl_learning_images WHERE learning_id = :learning_id";
        $data = $this->db->Query($sql, ["learning_id" => $learning_id]);
        return json_decode($data);
    }

    public function getPDFLearning($learning_id)
    {
        $sql = "SELECT learning_file FROM cl_learning_save_file WHERE learning_id = :learning_id";
        $data = $this->db->Query($sql, ["learning_id" => $learning_id]);
        return json_decode($data);
    }

    public function checksignInClass($std_id, $calendar_id)
    {
        $sql = "SELECT count(*) c_std_sign_in FROM `cl_sign_in_to_class` WHERE std_id = :std_id AND calendar_id = :calendar_id";
        $data = $this->db->Query($sql, ['std_id' => $std_id, 'calendar_id' => $calendar_id]);
        $data = json_decode($data);
        return $data;
    }

    public function signInClass($std_id, $calendar_id)
    {
        $sql = "INSERT INTO cl_sign_in_to_class (std_id,calendar_id )\n" .
            "VALUES\n" .
            "	(:std_id,:calendar_id);";
        $data = $this->db->Insert($sql, ["std_id" => $std_id, "calendar_id" => $calendar_id]);
        return $data;
    }
    public function getDataStdSignInClass($calendar_id)
    {
        $sql = "SELECT\n" .
            "	std.std_code,\n" .
            "	CONCAT( std.std_prename, std.std_name ) std_name ,\n" .
            "	sign.create_date\n" .
            "FROM\n" .
            "	cl_sign_in_to_class sign\n" .
            "	LEFT JOIN tb_students std ON sign.std_id = std.std_id \n" .
            "WHERE\n" .
            "	calendar_id = :calendar_id";
        $data = $this->db->Query($sql, ['calendar_id' => $calendar_id]);
        $data = json_decode($data);
        return $data;
    }

    public function InsertSharePlane($array_data, $mode = "INSERT")
    {
        $where =  "";
        if ($mode == "INSERT") {
            $mode = "INSERT cl_share_plan ";
        } else {
            $mode = "UPDATE cl_share_plan ";
            $where = " WHERE sh_plan_id = :sh_plan_id";
        }

        $file = "";
        if (isset($array_data['sh_plan_file'])) {
            $file = " ,sh_plan_file = :sh_plan_file,
                sh_plan_file_name = :sh_plan_file_name ";
        }

        $sql = $mode . " SET 
            sh_subject_code = :sh_subject_code,
            sh_subject_name = :sh_subject_name,
            sh_cate = :sh_cate, 
            sh_class = :sh_class, 
            year = :year, 
            user_create = :user_create " . $file . $where;
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }
    function getSharePlane()
    {
        //ถ้ามีการค้นหา
        $search = "";
        if (isset($_REQUEST['search'])) {
            $search = " ( CONCAT( u.NAME, ' ', u.surname ) LIKE '%" . $_REQUEST['search'] . "%' ";
            $search .= " OR sp.sh_subject_name LIKE '%" . $_REQUEST['search'] . "%' )";
        }

        $where = "";
        if (isset($_REQUEST['sh_plan_id']) && !empty($_REQUEST['sh_plan_id'])) {
            $where = " WHERE sp.sh_plan_id = '" . $_REQUEST['sh_plan_id'] . "' \n ";
        }

        if (empty($where) && !empty($search)) {
            $search =  " WHERE " . $search;
        }

        //นับจำนวนทั้งหมด
        $sql = "SELECT count(*) totalnotfilter FROM cl_share_plan sp ";
        $totalnotfilter = $this->db->Query($sql, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql_total = "SELECT\n" .
            "	sp.*,\n" .
            "   u.id u_id,\n" .
            "	CONCAT( u.NAME, ' ', u.surname ) u_name,\n" .
            "	edu.name edu_name\n" .
            "FROM\n" .
            "	`cl_share_plan` sp\n" .
            "	LEFT JOIN tb_users u ON sp.user_create = u.id\n" .
            "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id \n" .
            $where .  $search .
            "	ORDER BY sp.sh_downloads DESC, sp.create_date DESC";
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $limit  = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql_total . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }


    public function deleteSharePlan($id)
    {
        $sql = "DELETE FROM cl_share_plan WHERE sh_plan_id = :sh_plan_id";
        $data = $this->db->Delete($sql, ["sh_plan_id" => $id]);
        return $data;
    }

    public function downloadUpdate($id)
    {
        $sql = "UPDATE cl_share_plan SET sh_downloads = (sh_downloads + 1) WHERE sh_plan_id = :sh_plan_id";
        $data = $this->db->Update($sql, ["sh_plan_id" => $id]);
        return $data;
    }

    function insertScore($arr_data, $mode = "add")
    {

        $sql = "SELECT * FROM cl_score score WHERE  calendar_id = :calendar_id AND std_id = :std_id";
        $scoreData = $this->db->Query($sql, ["calendar_id" => $arr_data['calendar_id'], "std_id" => $arr_data['std_id']]);
        $scoreData = json_decode($scoreData);
        $data = 0;
        if (count($scoreData) > 0) {
            // unset($arr_data['term_id']);
            unset($arr_data['std_class']);
            unset($arr_data['user_create']);
            if ($mode == "add") {
                $arr_data['score'] = ($scoreData[0]->score + (int)$arr_data['score']);
            }
            $sql = "UPDATE cl_score SET score = :score WHERE calendar_id = :calendar_id AND std_id = :std_id";
            $data = $this->db->Update($sql, $arr_data);
        } else {
            $sql = "INSERT INTO cl_score(calendar_id,score,user_create,std_id) VALUES (:calendar_id,:score,:user_create,:std_id)";
            $data = $this->db->Insert($sql, $arr_data);
        }

        return $data;
    }

    // public function getDataStdSignInSum()
    // {
    //     $sql = "SELECT\n" .
    //         "	std.std_code,\n" .
    //         "	CONCAT( std.std_prename, std.std_name ) std_name ,\n" .
    //         "	sign.create_date\n" .
    //         "FROM\n" .
    //         "	cl_sign_in_to_class sign\n" .
    //         "	LEFT JOIN tb_students std ON sign.std_id = std.std_id \n" .
    //         "WHERE\n" .
    //         "	calendar_id = :calendar_id";
    //     $data = $this->db->Query($sql, ['calendar_id' => $calendar_id]);
    //     $data = json_decode($data);
    //     return $data;
    // }

    function getDataCalenderGET()
    {
        //ถ้ามีการค้นหา
        $actionClass = "";
        if (isset($_REQUEST['std_class']) && !empty($_REQUEST['std_class'])) {
            $actionClass = " AND cn.std_class = '" . $_REQUEST['std_class'] . "' ";
        }

        //นับจำนวนทั้งหมด
        $sql = "SELECT count(*) totalnotfilter FROM cl_calendar_new_am cn WHERE cn.province_id = " . $_SESSION['user_data']->province_am_id;
        $totalnotfilter = $this->db->Query($sql, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql_total = "SELECT\n" .
            "	cn.*,\n" .
            "   u.id u_id,\n" .
            "	CONCAT( u.NAME, ' ', u.surname ) u_name\n" .
            "FROM\n" .
            "	`cl_calendar_new_am` cn\n" .
            "	LEFT JOIN tb_users u ON cn.user_create = u.id\n" .
            "	LEFT JOIN tbl_provinces pro ON pro.id = u.province_am_id\n" .
            "	LEFT JOIN tbl_district  dis ON dis.id = u.district_am_id\n" .
            "	LEFT JOIN cl_main_calendar m ON cn.m_calendar_id = m.m_calendar_id\n" .
            "WHERE cn.province_id = " . $_SESSION['user_data']->province_am_id . " " . $actionClass  .
            "	ORDER BY cn.std_class ASC";
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $limit  = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql_total . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }
}
