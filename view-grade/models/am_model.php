<?php

class Am_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function getDataUser($edu_id)
    {
        $limit = $_POST['limit'];
        $page = ($_POST['page'] - 1) * $limit;
        $where = "";
        if ($edu_id != 0) {
            $where = " AND users.edu_id = $edu_id";
        }
        $sql = "SELECT\n" .
            "	users.*,\n" .
            "	role.role_name,\n" .
            "	IFNULL((\n" .
            "		SELECT NAME \n" .
            "		FROM\n" .
            "			tbl_non_education edu \n" .
            "		WHERE\n" .
            "			users.edu_id = edu.id \n" .
            "			),(\n" .
            "		SELECT NAME \n" .
            "		FROM\n" .
            "			tbl_non_education_other edu_o \n" .
            "		WHERE\n" .
            "			users.edu_id = edu_o.id \n" .
            "		)) edu_name,\n" .
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_sub_district ON edu.sub_district_id = tbl_sub_district.id WHERE users.edu_id = edu.id ) sub_district,\n" .
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_district ON edu.district_id = tbl_district.id WHERE users.edu_id = edu.id ) district,\n" .
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province\n" .
            "	\n" .
            "FROM\n" .
            "	tb_users users\n" .
            "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id \n" .
            "   LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id \n" .
            "WHERE role.role_id = 3 AND edu.district_id = " . $_SESSION['user_data']->district_am_id . " $where\n" .
            "ORDER BY users.role_id ASC LIMIT $page,$limit";
        $dataCount = $this->db->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
        return json_decode($dataCount);
    }

    function countUsers($edu_id)
    {
        $where = "";
        if ($edu_id != 0) {
            $where = " AND edu_id = $edu_id";
        }
        $sql = "SELECT COUNT(*) count FROM tb_users WHERE user_create = :user_create $where";
        $dataCount = $this->db->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
        return json_decode($dataCount)[0]->count;
    }

    function getEduUser()
    {
        $sql = "SELECT\n" .
            "	id edu_id,\n" .
            "	NAME edu_name \n" .
            "FROM\n" .
            "	tbl_non_education \n" .
            "WHERE\n" .
            "	district_id = :district_id";
        $dataCount = $this->db->Query($sql, ["district_id" => $_SESSION['user_data']->district_am_id]);
        return json_decode($dataCount);
    }

    public function getDataTeacher($sub_dis_id = 0, $pro_id = 0, $dis_id = 0)
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
            $where = "WHERE users.role_id = 3 \n";
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
            "	users.*,\n" .
            "	role.role_name,\n" .
            "	IFNULL((\n" .
            "		SELECT NAME \n" .
            "		FROM\n" .
            "			tbl_non_education edu \n" .
            "		WHERE\n" .
            "			users.edu_id = edu.id \n" .
            "			),(\n" .
            "		SELECT NAME \n" .
            "		FROM\n" .
            "			tbl_non_education_other edu_o \n" .
            "		WHERE\n" .
            "			users.edu_id = edu_o.id \n" .
            "		)) edu_name,\n" .
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_sub_district ON edu.sub_district_id = tbl_sub_district.id WHERE users.edu_id = edu.id ) sub_district,\n" .
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_district ON edu.district_id = tbl_district.id WHERE users.edu_id = edu.id ) district,\n" .
            "	( SELECT name_th FROM tbl_non_education edu LEFT JOIN tbl_provinces ON edu.province_id = tbl_provinces.id WHERE users.edu_id = edu.id ) province \n" .
            "FROM\n" .
            "	tb_users users\n" .
            "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
            "	LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id \n" . $where .
            " ORDER BY users.role_id ASC";
        $dataCount = $this->db->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
        return json_decode($dataCount);
    }


    function getDataDashboard()
    {
        $pro_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
        $dis_id = isset($_REQUEST['district_id']) ? $_REQUEST['district_id'] : '';
        $sub_dis = isset($_REQUEST['subdistrict_id']) ? $_REQUEST['subdistrict_id'] : '';
        if (!empty($pro_id)) {
            $pro_id = "    AND COALESCE(edu.province_id, users.province_am_id) = $pro_id\n";
        }
        if (!empty($dis_id)) {
            $dis_id = "    AND COALESCE(edu.district_id, users.district_am_id) = $dis_id\n";
        }
        if (!empty($sub_dis)) {
            $sub_dis = "	AND edu.sub_district_id = " . $sub_dis . " \n";
        }
        $sql_order = "SELECT\n" .
            "	COUNT(*) totalnotfilter\n" .
            "FROM\n" .
            "	tb_users users\n" .
            "	LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
            "WHERE users.role_id != 4;";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "WITH leave_totals AS (\n" .
            "    SELECT\n" .
            "        l.user_id,\n" .
            "        SUM(CASE WHEN l.leave_type = 1 THEN l.leave_day ELSE 0 END) AS l1,\n" .
            "        SUM(CASE WHEN l.leave_type = 2 THEN l.leave_day ELSE 0 END) AS l2,\n" .
            "				SUM(CASE WHEN l.leave_type = 3 THEN l.leave_day ELSE 0 END) AS l3,\n" .
            "				SUM(CASE WHEN l.leave_type = 4 THEN l.leave_day ELSE 0 END) AS l4,\n" .
            "				SUM(CASE WHEN l.leave_type = 5 THEN l.leave_day ELSE 0 END) AS l5\n" .
            "    FROM\n" .
            "        info_leave l\n" .
            "    GROUP BY\n" .
            "        l.user_id\n" .
            "),\n" .
            "student_counts AS (\n" .
            "    SELECT\n" .
            "        user_create,\n" .
            "        SUM(CASE WHEN std_class = 'ประถม' THEN 1 ELSE 0 END) AS pratom,\n" .
            "        SUM(CASE WHEN std_class = 'ม.ต้น' THEN 1 ELSE 0 END) AS mTon,\n" .
            "        SUM(CASE WHEN std_class = 'ม.ปลาย' THEN 1 ELSE 0 END) AS mPai\n" .
            "    FROM\n" .
            "        tb_students\n" .
            "    GROUP BY\n" .
            "        user_create\n" .
            "),\n" .
            "info_users AS (\n" .
            "    SELECT\n" .
            "       user_id,\n" .
            "       age,\n" .
            "		end_work,\n" .
            "		sum_get_royal,\n" .
            "		class_royal,\n" .
            "		scout_rank,\n" .
            "		start_work\n" .
            "    FROM\n" .
            "        info\n" .
            "    GROUP BY\n" .
            "        user_id\n" .
            "),\n" .
            "royal AS ( SELECT REPLACE(group_concat(royal_name), ',', ' | ') royal_name,user_create FROM info_royal group by user_create),\n" .
            "submission AS (SELECT REPLACE(group_concat(submission_name), ',', ' | ') submission_name,user_create FROM info_submission group by user_create)\n" .
            "SELECT\n" .
            "    users.id u_id,\n" .
            "    users.role_id,\n" .
            "    CONCAT(users.NAME, ' ', users.surname) AS concat_name,\n" .
            "    COALESCE(sc.pratom, 0) AS pratom,\n" .
            "    COALESCE(sc.mTon, 0) AS mTon,\n" .
            "    COALESCE(sc.mPai, 0) AS mPai,\n" .
            "    COALESCE(lt.l1, 0) AS l1,\n" .
            "    COALESCE(lt.l2, 0) AS l2,\n" .
            "	 COALESCE(lt.l3, 0) AS l3,\n" .
            "	 COALESCE(lt.l4, 0) AS l4,\n" .
            "	 COALESCE(lt.l5, 0) AS l5,\n" .
            "	 COALESCE(iu.age, '-') AS age,\n" .
            "	 COALESCE(iu.end_work, '-') AS end_work,\n" .
            "	 COALESCE(iu.sum_get_royal, '-') AS sum_get_royal,\n" .
            "	 COALESCE(iu.class_royal, '-') AS class_royal,\n" .
            "	 COALESCE(iu.scout_rank, '-') AS scout_rank,\n" .
            "	 COALESCE(r.royal_name, '-') AS royal_name,\n" .
            "	 COALESCE(iu.start_work, '-') AS start_work,\n" .
            "	 COALESCE(s.submission_name, '-') AS submission_name\n" .
            "FROM\n" .
            "    tb_users users\n" .
            "    LEFT JOIN tb_role_users role ON users.role_id = role.role_id\n" .
            "    LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id\n" .
            "    LEFT JOIN tbl_non_education_other edu_o ON users.edu_id = edu_o.id\n" .
            "    LEFT JOIN leave_totals lt ON users.id = lt.user_id\n" .
            "    LEFT JOIN student_counts sc ON users.id = sc.user_create\n" .
            "	 LEFT JOIN info_users iu ON users.id = iu.user_id\n" .
            "	 LEFT JOIN royal r ON users.id = r.user_create\n" .
            "	 LEFT JOIN submission s ON users.id = s.user_create\n" .
            "WHERE\n" .
            "    users.role_id IN (2, 3, 5)\n" .
            $pro_id . $dis_id . $sub_dis .
            "ORDER BY\n" .
            "    users.role_id ASC,\n" .
            "    users.NAME ASC";

        $sql_total = $sql;
        $total_result = $this->db->Query($sql_total, []);
        $total = count(json_decode($total_result));
        //จบนับจำนวนที่มีการ filter

        //จำกัดจำนวน
        $limit = "";
        if (isset($_REQUEST['limit'])) {
            $limit = " LIMIT " . $_REQUEST['offset'] . "," . $_REQUEST['limit'] . " ";
        }

        //ข้อมูลที่จะแสดง
        $sql = $sql_total . $limit;
        $data_result = $this->db->Query($sql, []);
        return [$total, $totalnotfilter, json_decode($data_result), $sql_total];
    }

    function subQueryGetCount($field, $count_name, $table, $where, $join = "")
    {
        $sql = ",( SELECT\n" .
            $count_name . " \n" .
            "FROM\n" .
            $table . " \n "
            . $join . "\n WHERE \n"
            . $where . " )  $field \n ";
        return  $sql;
    }


    function getDataDashboardKru()
    {
        $std_class_where = "";
        if (isset($_GET['std_class']) && !empty($_GET['std_class'])) {
            $std_class_where = "	AND std.std_class = '" . $_GET['std_class'] . "' \n";
        }

        $term_id = $_SESSION['term_active']->term_id;

        $sql_order = "SELECT\n" .
            "	COUNT(*) totalnotfilter\n" .
            "FROM\n" .
            "	tb_students std ";
        $totalnotfilter = $this->db->Query($sql_order, []);
        $totalnotfilter =  json_decode($totalnotfilter)[0]->totalnotfilter;
        //จบการนับจำนวนทั้งหมด

        //นับจำนวนที่มีการ filter
        $sql = "WITH estimate AS (\n" .
            "	SELECT\n" .
            "		es.*,\n" .
            "		( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '1' ) side1,\n" .
            "		( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '2' ) side2,\n" .
            "		( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '3' ) side3,\n" .
            "		( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '4' ) side4,\n" .
            "		( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '5' ) side5,\n" .
            "		( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '6' ) side6,\n" .
            "		( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '7' ) side7,\n" .
            "		( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '8' ) side8,\n" .
            "		( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '9' ) side9,\n" .
            "		( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '10' ) side10,\n" .
            "		( SELECT SUM( checked ) checked FROM stf_tb_estimate_detail WHERE estimate_id = es.estimate_id AND side = '11' ) side11 \n" .
            "	FROM\n" .
            "		stf_tb_estimate es\n" .
            "		LEFT JOIN tb_users u ON es.user_create = u.id\n" .
            "		INNER JOIN tb_students std ON es.std_id = std.std_id \n" .
            "	WHERE year = ".$term_id." \n" .
            "	) , \n" .
            "   credit AS ( SELECT cre.std_id, count( credit_id ) count_cre FROM vg_credit cre GROUP BY cre.std_id ), \n" .
            "kpc_sum AS (\n" .
            "    SELECT kpc.std_id, SUM(kpc.HOUR) as hours \n" .
            "    FROM vg_kpc kpc \n" .
            "    GROUP BY kpc.std_id\n" .
            ") \n" .
            "SELECT\n" .
            "	std.std_id,\n" .
            "   CONCAT( std.std_prename, '', std.std_name ) std_name,\n" .
            "	COALESCE(kpc_sum.hours, 0) hours,\n" .
            "	estimate.side1,\n" .
            "	estimate.side2,\n" .
            "	estimate.side3,\n" .
            "	estimate.side4,\n" .
            "	estimate.side5,\n" .
            "	estimate.side6,\n" .
            "	estimate.side7,\n" .
            "	estimate.side8,\n" .
            "	estimate.side9,\n" .
            "	estimate.side10,\n" .
            "	estimate.side11,\n" .
            "	nn.status_text,\n" .
            "	COALESCE ( cre.count_cre, 0 ) count_cre,\n" .
            "	( SELECT phone from stf_tb_form_student_person_new spn WHERE spn.std_id = std.std_id LIMIT 1 ) phone\n" .
            "FROM\n" .
            "	tb_students std\n" .
            "	LEFT JOIN tb_users users ON std.user_create = users.id\n" .
            "	LEFT JOIN tbl_non_education edu ON users.edu_id = edu.id\n" .
            "	LEFT JOIN kpc_sum ON kpc_sum.std_id = std.std_id\n" .
            "	LEFT JOIN estimate ON std.std_id = estimate.std_id\n" .
            "	LEFT JOIN vg_n_net nn ON std.std_id = nn.std_id\n" .
            "	LEFT JOIN credit cre ON std.std_id = cre.std_id \n" .
            "	-- LEFT JOIN stf_tb_form_student_person_new spn ON std.std_id = spn.std_id \n" .
            "WHERE\n" .
            "	std.std_status = 'กำลังศึกษา' AND std.user_create = :user_create " . $std_class_where . " ORDER BY std.std_id";

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

        $arr_data = json_decode($data_result);
        $new_arr_data = array();

        foreach ($arr_data as $key => $value) {
            $sql = "SELECT\n" .
                "	SUM(\n" .
                "	IFNULL( cc.total_credit, 0 )) AS cc,\n" .
                "	SUM(\n" .
                "	IFNULL( ce.total_credit, 0 )) AS ce,\n" .
                "	SUM(\n" .
                "	IFNULL( cfe.total_credit, 0 )) AS cfe\n" .
                "FROM\n" .
                "	vg_credit c\n" .
                "	LEFT JOIN ( SELECT credit_id, SUM( credit ) AS total_credit FROM vg_credit_compulsory WHERE grade > 1 GROUP BY credit_id ) cc ON cc.credit_id = c.credit_id\n" .
                "	LEFT JOIN ( SELECT credit_id, SUM( credit ) AS total_credit FROM vg_credit_electives WHERE grade > 1 GROUP BY credit_id ) ce ON ce.credit_id = c.credit_id\n" .
                "	LEFT JOIN ( SELECT credit_id, SUM( credit ) AS total_credit FROM vg_credit_free_electives WHERE grade > 1 GROUP BY credit_id ) cfe ON cfe.credit_id = c.credit_id \n" .
                "WHERE\n" .
                "	c.std_id = :std_id;";
            $data = $this->db->Query($sql, ['std_id' => $value->std_id]);
            $credit_data = json_decode($data);
            $credit_data = $credit_data[0];

            $cc =   $credit_data->cc;
            $ce = $credit_data->ce;
            $cfe = $credit_data->cfe;

            $value->cc = $cc;
            $value->ce = $ce;
            $value->cfe = $cfe;

            array_push($new_arr_data, $value);
        }

        return [$total, $totalnotfilter, $new_arr_data, $sql_total];
    }
}
