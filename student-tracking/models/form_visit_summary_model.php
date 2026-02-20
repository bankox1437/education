<?php
include "../../config/main_function.php";
class VisitSummaryModel
{

    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function getVisitData()
    {
        $sql = "SELECT * FROM stf_tb_visit_summary_subtitle st
        LEFT JOIN stf_tb_visit_summary_title t
        ON st.title_id = t.title_id order by st.title_id,st.sub_title_id";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    public function getVisitDataSum($std_class = "")
    {
        $where =  "WHERE vh.user_create = :user_id ";
        $wherSub = "";
        if (!empty($std_class)) {
            $where =  "WHERE\n" .
                " vh.user_create = :user_id AND std.std_class = :std_class \n";
            $wherSub = " AND sd.std_class = :std_class ";
        }
        $sql = "SELECT\n" .
            "	t.title_id,\n" .
            "	t.title_detail,	\n" .
            "	s.sub_title_id,\n" .
            "	s.sub_title_detail,\n" .
            "	SUM( vd.checked ) sum ,\n" .
            "   ( SELECT COUNT(sd.std_id) FROM tb_students sd WHERE sd.user_create = :user_id ".$wherSub." ) count_std \n" .
            "FROM\n" .
            "	stf_tb_form_visit_home_summary vs\n" .
            "	LEFT JOIN stf_tb_form_visit_home vh ON vs.form_visit_id = vh.form_visit_id\n" .
            "	LEFT JOIN stf_tb_form_visit_home_summary_detail vd ON vs.form_v_sum_id = vd.form_v_sum_id\n" .
            "	LEFT JOIN stf_tb_visit_summary_subtitle s ON vd.sub_title_id = s.sub_title_id\n" .
            "	LEFT JOIN stf_tb_visit_summary_title t ON s.title_id = t.title_id\n" .
            "	LEFT JOIN tb_students std ON vh.std_id = std.std_id \n" .
            $where .
            "GROUP BY\n" .
            "	s.sub_title_id ORDER BY t.title_id";
        if (!empty($std_class)) {
            $data = $this->db->Query($sql, ["user_id" => $_SESSION['user_data']->id, "std_class" => $std_class,"user_id" => $_SESSION['user_data']->id, "std_class" => $std_class]);
        } else {
            $data = $this->db->Query($sql, ["user_id" => $_SESSION['user_data']->id, "user_id" => $_SESSION['user_data']->id]);
        }
        return json_decode($data);
    }

    public function getStudentVisitData()
    {
        $sql = "SELECT * FROM stf_tb_form_visit_home_summary vs
        LEFT JOIN tb_students s
        ON vs.std_id = s.std_id order by s.std_class";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    // public function addFormVisitSummary($arr = [])
    // {

    //     $sql = "INSERT INTO stf_tb_form_visit_home_summary\n" .
    //         "(user_create,year,std_class,sum_male,sum_female) \n" .
    //         "VALUES (:user_create,:year,:std_class,:sum_male,:sum_female)";
    //     $data = $this->db->InsertLastID($sql, $arr);
    //     return $data;
    // }

    // public function insertVisitConclude($arr_data = [])
    // {
    //     $sql = "INSERT INTO stf_tb_form_visit_home_summary_detail\n" .
    //         "(form_v_sum_id,sub_title_id, sum_people, per_cent_people) \n" .
    //         "VALUES (:visitsummary_id,:sub_title_id, :counts_d, :counts_per)";
    //     $data = $this->db->Insert($sql, $arr_data);
    //     return $data;
    // }

    public function addFormVisitSummary($arr = [])
    {

        $sql = "INSERT INTO stf_tb_form_visit_home_summary(form_visit_id,user_create) VALUES(:form_visit_id,:user_create)";
        $data = $this->db->InsertLastID($sql, $arr);
        return $data;
    }

    public function addVisitSum($arr = [])
    {
        $sql = "INSERT INTO stf_tb_visit_summary (std_class,count_std, year, user_create )\n" .
            "VALUES\n" .
            "	( :std_class,:count_std, :year, :user_create);";
        $data = $this->db->InsertLastID($sql, $arr);
        return $data;
    }

    public function insertVisitSumDetail($arr_data = [])
    {
        $sql = "INSERT INTO stf_tb_visit_summary_detail (v_sum_id, sub_title_id, std_quantity, percent_quantity )\n" .
            "VALUES\n" .
            "	(:v_sum_id, :sub_title_id, :std_quantity, :percent_quantity );";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }


    public function insertVisitConclude($arr_data = [])
    {
        $sql = "INSERT INTO stf_tb_form_visit_home_summary_detail\n" .
            "(form_v_sum_id,sub_title_id,checked) \n" .
            "VALUES (:visitsummary_id,:sub_title_id,:checked)";
        $data = $this->db->Insert($sql, $arr_data);
        return $data;
    }

    public function updateVisitConclude($arr_data = [])
    {
        $sql = "UPDATE stf_tb_form_visit_home_summary_detail\n" .
            "SET sub_title_id = :sub_title_id,checked = :checked WHERE form_v_sum_det_id = :form_v_sum_det_id";
        $data = $this->db->Update($sql, $arr_data);
        return $data;
    }

    public function getVisitSumData($form_visit_id)
    {
        $sql = "SELECT form_v_sum_id FROM stf_tb_form_visit_home_summary WHERE form_visit_id = :form_visit_id";
        $data = $this->db->Query($sql, ["form_visit_id" => $form_visit_id]);
        return json_decode($data);
    }

    public function getFormVisitSummary($v_sum_id)
    {

        $sql = "SELECT\n" .
            "	* \n" .
            "FROM\n" .
            "	stf_tb_form_visit_home_summary_detail sd\n" .
            "	LEFT JOIN stf_tb_visit_summary_subtitle sub ON sd.sub_title_id = sub.sub_title_id\n" .
            "	LEFT JOIN stf_tb_visit_summary_title t ON sub.title_id = t.title_id \n" .
            "WHERE\n" .
            "	form_v_sum_id = :v_sum_id";
        $data = $this->db->Query($sql, ["v_sum_id" => $v_sum_id]);
        return json_decode($data);
    }

    public function updateStatusVisit($form_visit_id)
    {

        $sql = "UPDATE stf_tb_form_visit_home SET form_status = 1 WHERE form_visit_id = :form_visit_id";
        $data = $this->db->Update($sql, ["form_visit_id" => $form_visit_id]);
        return $data;
    }

    // public function getVisitStd($id)
    // {
    //     $sql = "SELECT sd.sub_title_id FROM stf_tb_form_visit_home_summary_detail sd
    //     LEFT JOIN stf_tb_form_visit_home_summary hs ON sd.form_v_sum_id = hs.form_v_sum_id 
    // 	LEFT JOIN tb_students s ON hs.std_id = s.std_id 
    //     WHERE sd.form_v_sum_id = :id";
    //     $data = $this->db->Query($sql, ["id" => $id]);
    //     return $data;
    // }

    // public function getVisitAllData()
    // {
    //     $sql = "SELECT s.form_v_sum_id,s.std_class,s.year FROM stf_tb_form_visit_home_summary s
    //     LEFT JOIN tb_users u
    //     ON s.user_create = u.id order by s.std_class";
    //     $data = $this->db->Query($sql, []);
    //     return json_decode($data);

    // }

    public function getVisitAllData()
    {
        $where = "";
        $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n" .
            "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        $address = "";
        $edu_name = "IFNULL( edu.NAME, edu_o.NAME ) edu_name \n";
        if ($_SESSION['user_data']->role_id == 3) {
            $where .= "WHERE u.id = :user_id\n";
        }
        if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu') {
            $where .= "WHERE edu.district_id = ( SELECT district_id FROM tb_users us LEFT JOIN tbl_non_education edu ON us.edu_id = edu.id WHERE us.id = :user_id) \n";
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $where .= "WHERE edu_o.id = :edu_id\n";
        }
        if ($_SESSION['user_data']->edu_type == 'edu_other') {
            $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n";
            $address = "";
            $edu_name = "edu_o.NAME edu_name \n";
        } else if ($_SESSION['user_data']->edu_type == 'edu') {
            $joinEDU = "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
            $address = "	,( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province \n";
            $edu_name = "edu.NAME edu_name \n";
        } else {
            $address = "	,( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province \n";
            $edu_name = "IFNULL( edu.NAME, edu_o.NAME ) edu_name \n";
        }
        $sql = "SELECT\n" .
            "	vs.v_sum_id,vs.std_class,vs.year,\n" .
            $edu_name .
            $address .
            "FROM\n" .
            "	stf_tb_visit_summary vs\n" .
            "	LEFT JOIN tb_users u ON vs.user_create = u.id\n" .
            $joinEDU .
            $where .
            "ORDER BY\n" .
            "	edu_name ASC,vs.std_class ASC";
        // die($sql);
        if ($_SESSION['user_data']->role_id == 1) {
            $data = $this->db->Query($sql, []);
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $data = $this->db->Query($sql, ['edu_id' => $_SESSION['user_data']->edu_id]);
        } else {
            $data = $this->db->Query($sql, ['user_id' => $_SESSION['user_data']->id]);
        }

        return json_decode($data);
    }

    public function deleteVisit($id)
    {

        $sql = "DELETE FROM stf_tb_visit_summary WHERE v_sum_id = :id";
        $data = $this->db->Delete($sql, ["id" => $id]);
        return $data;
    }

    public function getClassInDropdown()
    {
        $where = "";
        $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n" .
            "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        if ($_SESSION['user_data']->role_id == 3) {
            $where .= "WHERE u.id = :user_id\n";
        }
        if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu') {
            $where .= "WHERE edu.district_id = ( SELECT district_id FROM tb_users us LEFT JOIN tbl_non_education edu ON us.edu_id = edu.id WHERE us.id = :user_id) \n";
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $where .= "WHERE edu_o.id = :edu_id\n";
        }
        if ($_SESSION['user_data']->edu_type == 'edu_other') {
            $joinEDU = "LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n";
        } else if ($_SESSION['user_data']->edu_type == 'edu') {
            $joinEDU = "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";
        }
        $sql = "SELECT\n" .
            "	std_class \n" .
            "FROM\n" .
            "	stf_tb_visit_summary hs\n" .
            "   LEFT JOIN tb_users u ON u.id = hs.user_create\n" .
            $joinEDU . "\n" .
            $where . " GROUP BY std_class";

        if ($_SESSION['user_data']->role_id == 1) {
            $data = $this->db->Query($sql, []);
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            $data = $this->db->Query($sql, ['edu_id' => $_SESSION['user_data']->edu_id]);
        } else {
            $data = $this->db->Query($sql, ['user_id' => $_SESSION['user_data']->id]);
        }
        return json_decode($data);
    }

    public function getSubDistrict()
    {
        $where = "WHERE sub.name_th IS NOT NULL ";
        if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu') {
            $where .= "AND edu.district_id = ( SELECT district_id FROM tb_users us LEFT JOIN tbl_non_education edu ON us.edu_id = edu.id WHERE us.id = :user_id) \n";
        }
        $sql = "SELECT\n" .
            "	edu.sub_district_id,\n" .
            "	sub.name_th sub_district_name \n" .
            "FROM\n" .
            "	stf_tb_form_visit_home_summary hs\n" .
            "	LEFT JOIN tb_users u ON u.id = hs.user_create\n" .
            "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
            "	LEFT JOIN tbl_sub_district sub ON edu.sub_district_id = sub.id \n" .
            $where . "GROUP BY edu.sub_district_id";

        if ($_SESSION['user_data']->role_id == 1) {
            $data = $this->db->Query($sql, []);
        } else {
            $data = $this->db->Query($sql, ['user_id' => $_SESSION['user_data']->id]);
        }
        return json_decode($data);
    }

    public function getDataVisitSummaryByStdClass($std_class, $sub_district_id, $district_id, $province_id)
    {
        $std_class_where = '';
        $sub_district_id_where = '';
        $option_and = ' AND ';
        if ($std_class != '0') {
            $std_class_where .= 'vs.std_class = :std_class ';
        } else {
            $option_and = ' ';
        }
        if ($province_id != '0' && $district_id == '0' && $sub_district_id == '0') {
            $sub_district_id_where .= 'edu.province_id = :province_id ';
        } else if ($province_id != '0' && $district_id != '0' && $sub_district_id == '0') {
            $sub_district_id_where .= 'edu.province_id = :province_id AND ';
            $sub_district_id_where .= 'edu.district_id = :district_id ';
        } else if ($province_id != '0' && $district_id != '0' && $sub_district_id != '0') {
            $sub_district_id_where .= 'edu.province_id = :province_id AND ';
            $sub_district_id_where .= 'edu.district_id = :district_id AND ';
            $sub_district_id_where .= 'edu.sub_district_id = :sub_district_id ';
        } else {
            $option_and = '  ';
        }
        $where = "WHERE $std_class_where  $option_and $sub_district_id_where";
        $main_func = new ClassMainFunctions();
        $colunm =   " vs.v_sum_id,vs.std_class,vs.year,\n";
        $table = " stf_tb_visit_summary vs";
        $join = "	LEFT JOIN tb_users u ON vs.user_create = u.id\n";
        $order_by = "ORDER BY\n" .
            "edu_name ASC,vs.std_class ASC\n";
        $arr_data = [];
        if ($std_class != '0') {
            $arr_data['std_class'] = $std_class;
        }
        if ($_SESSION['user_data']->role_id == 1) {
            if ($province_id != '0' && $district_id == '0' && $sub_district_id == '0') {
                $arr_data['province_id'] = $province_id;
            } else if ($province_id != '0' && $district_id != '0' && $sub_district_id == '0') {
                $arr_data['province_id'] = $province_id;
                $arr_data['district_id'] = $district_id;
            } else if ($province_id != '0' && $district_id != '0' && $sub_district_id != '0') {
                $arr_data['province_id'] = $province_id;
                $arr_data['district_id'] = $district_id;
                $arr_data['sub_district_id'] = $sub_district_id;
            }
        } else if ($_SESSION['user_data']->role_id == 2 && $_SESSION['user_data']->edu_type == 'edu_other') {
            if ($sub_district_id != '0') {
                $arr_data['sub_district_id'] = $sub_district_id;
            }
            $arr_data['edu_id'] = $_SESSION['user_data']->edu_id;
        } else {
            if ($sub_district_id != '0') {
                $arr_data['sub_district_id'] = $sub_district_id;
            }
            $arr_data['user_id'] = $_SESSION['user_data']->id;
        }
        return $main_func->getDataAll($table, $join, $order_by, $this->db, $colunm,  $arr_data, $where);
    }
    public function getDataVisitSummaryByAmphure($std_class, $sub_district_id)
    {
        $std_class_where = '';
        $sub_district_id_where = ' edu.sub_district_id = :sub_district_id ';
        $option_and = ' AND ';
        if ($std_class != '0') {
            $std_class_where .= 'vs.std_class = :std_class ';
        } else {
            $option_and = ' ';
        }
        $where = "WHERE $std_class_where  $option_and $sub_district_id_where";
        $main_func = new ClassMainFunctions();
        $colunm =   " vs.v_sum_id,vs.std_class,vs.year,\n";
        $table = " stf_tb_visit_summary vs";
        $join = "	LEFT JOIN tb_users u ON vs.user_create = u.id\n";
        $order_by = "ORDER BY\n" .
            "edu_name ASC,vs.std_class ASC\n";
        $arr_data = [];
        if ($std_class != '0') {
            $arr_data['std_class'] = $std_class;
        }
        if ($_SESSION['user_data']->role_id == 2) {
            $arr_data['sub_district_id'] = $sub_district_id;
        } else {
            if ($sub_district_id != '0') {
                $arr_data['sub_district_id'] = $sub_district_id;
            }
            $arr_data['user_id'] = $_SESSION['user_data']->id;
        }
        return $main_func->getDataAll($table, $join, $order_by, $this->db, $colunm,  $arr_data, $where);
    }

     function getDataVisitAllBS()
    {
        //ถ้ามีการจัดเรียง
        $order = " ORDER BY\n" .
         "	edu.name ASC,vs.std_class ASC"; 
        $isNotNull = "WHERE vs.v_sum_id IS NOT NULL";
          $user_condition = " AND u.id = " . $_SESSION['user_data']->id . "\n";
        
        $address = "";
        $admin_join = "LEFT JOIN tb_users u ON vs.user_create = u.id\n" .
            "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";

        $edu_name = "";

        $std_class = "";
        if ($_SESSION['user_data']->role_id == 1  || $_SESSION['user_data']->role_id == 2) {
            $user_condition = "";
        }
        if (isset($_REQUEST['std_class']) && !empty($_REQUEST['std_class'])) {
            $std_class = " AND ";
            $std_class .= "   std.std_class = '" . $_REQUEST['std_class'] . "' \n";
        }

        $where_address = "";
        if ($_SESSION['user_data']->role_id == 1  || $_SESSION['user_data']->role_id == 2) {
            $address = ", ( SELECT name_th FROM tbl_sub_district WHERE edu.sub_district_id = tbl_sub_district.id ) sub_district,\n" .
                "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
                "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province, \n" .
                "   CONCAT(u.name,' ',u.surname) user_create_name \n";

            require_once("../../config/main_function.php");
            $mainFunc = new ClassMainFunctions();
            $start = " AND ";

            $where_address =  $mainFunc->getSqlFindAddress($start);
        }

        //นับจำนวนทั้งหมด
        $sql_order = "SELECT count(*) totalnotfilter FROM stf_tb_visit_summary vs \n";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
         $sql = "SELECT\n" .
            "	vs.v_sum_id,vs.std_class,vs.year,\n" .
             "	edu.NAME edu_name\n" .
            $address .
            "FROM\n" .
            "	stf_tb_visit_summary vs\n" .
            $admin_join .
            $isNotNull . $user_condition;

        $sql_total = $sql . $std_class . $where_address . $order;
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $limit = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql . $std_class . $where_address  . " $order " . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql];
    }
}
