<?php

class dashboard_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function getDistrictDataAmphur()
    {
        $sql = "SELECT\n" .
            "	u.district_am_id dis_id, \n" .
            "   u.district_am dis_name_th\n" .
            "FROM\n" .
            "	tb_users u \n" .
            "WHERE\n" .
            "	u.id = :user_id \n" .
            "	AND edu_type = 'amphur'";
        $result = $this->db->Query($sql, ['user_id' => $_SESSION['user_data']->id]);
        return $result;
    }

    public function getdatacount()
    {
        $array_data = [];
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) count_std", 'tb_students', 'user_create = :user_id AND std_status = \'กำลังศึกษา\''));
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) visit_home", 'stf_tb_form_visit_home', 'user_create = :user_id'));
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) from_evoluate", 'stf_tb_form_evaluate_students', 'user_create = :user_id'));
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) std_gender1", 'tb_students', " (std_gender = 'ชาย' OR std_prename = 'เด็กชาย' OR std_prename = 'นาย') \n" .
            " AND std_class = 'ประถม' \n" .
            " AND user_create = :user_id \n" .
            " AND std_status = 'กำลังศึกษา'"));
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) std_gender2", 'tb_students', " (std_gender = 'ชาย' OR std_prename = 'เด็กชาย' OR std_prename = 'นาย') \n" .
            " AND std_class = 'ม.ต้น' \n" .
            " AND user_create = :user_id \n" .
            " AND std_status = 'กำลังศึกษา'"));
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) std_gender3", 'tb_students', " (std_gender = 'ชาย' OR std_prename = 'เด็กชาย' OR std_prename = 'นาย') \n" .
            " AND std_class = 'ม.ปลาย' \n" .
            " AND user_create = :user_id \n" .
            " AND std_status = 'กำลังศึกษา'"));
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) std_gender4", 'tb_students',   " (std_gender = 'หญิง' OR std_prename = 'เด็กหญิง' OR std_prename = 'นางสาว' OR std_prename = 'นาง') \n" .
            " AND std_class = 'ประถม' \n" .
            " AND user_create = :user_id \n" .
            " AND std_status = 'กำลังศึกษา'"));
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) std_gender5", 'tb_students',  " (std_gender = 'หญิง' OR std_prename = 'เด็กหญิง' OR std_prename = 'นางสาว' OR std_prename = 'นาง') \n" .
            " AND std_class = 'ม.ต้น' \n" .
            " AND user_create = :user_id \n" .
            " AND std_status = 'กำลังศึกษา'"));
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) std_gender6", 'tb_students', " (std_gender = 'หญิง' OR std_prename = 'เด็กหญิง' OR std_prename = 'นางสาว' OR std_prename = 'นาง') \n" .
            " AND std_class = 'ม.ปลาย' \n" .
            " AND user_create = :user_id \n" .
            " AND std_status = 'กำลังศึกษา'"));
        array_push($array_data, $this->getDataCountDashboard(
            "COUNT(*) pratom_break",
            'tb_students',
            " std_class = 'ประถม' \n" .
                " AND user_create = :user_id \n" .
                " AND std_status = 'พักการเรียน'"
        ));
        array_push($array_data, $this->getDataCountDashboard(
            "COUNT(*) pratom_finish",
            'tb_students',
            " std_class = 'ประถม' \n" .
                " AND user_create = :user_id \n" .
                " AND std_status = 'จบการศึกษา'"
        ));
        array_push($array_data, $this->getDataCountDashboard(
            "COUNT(*) mt_break",
            'tb_students',
            " std_class = 'ม.ต้น' \n" .
                " AND user_create = :user_id \n" .
                " AND std_status = 'พักการเรียน'"
        ));
        array_push($array_data, $this->getDataCountDashboard(
            "COUNT(*) mt_finish",
            'tb_students',
            " std_class = 'ม.ต้น' \n" .
                " AND user_create = :user_id \n" .
                " AND std_status = 'จบการศึกษา'"
        ));
        array_push($array_data, $this->getDataCountDashboard(
            "COUNT(*) mp_break",
            'tb_students',
            " std_class = 'ม.ปลาย' \n" .
                " AND user_create = :user_id \n" .
                " AND std_status = 'พักการเรียน'"
        ));
        array_push($array_data, $this->getDataCountDashboard(
            "COUNT(*) mp_finish",
            'tb_students',
            " std_class = 'ม.ปลาย' \n" .
                " AND user_create = :user_id \n" .
                " AND std_status = 'จบการศึกษา'"
        ));
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) std_person", 'stf_tb_form_student_person_new', "user_create = :user_id"));
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) visit_sum", 'stf_tb_visit_summary', "user_create = :user_id"));
        array_push($array_data, $this->getDataCountDashboard("COUNT(*) screening", 'stf_tb_form_screening_students', "user_create = :user_id"));

        return $array_data;
    }

    function getDataCountDashboard($count_name, $table, $where, $join = "")
    {
        $sql = "SELECT\n" .
            $count_name . " \n" .
            "FROM\n" .
            $table . " \n "
            . $join . "\n WHERE \n"
            . $where;
        $data = $this->db->Query($sql, ["user_id" => $_SESSION['user_data']->id]);
        return json_decode($data)[0];
    }

    // =============================================================================================================================================================================
    public function getdatacountAdmin($province_id = "", $district_id = "", $sub_district_id = "", $teacherId = "0", $mode = "", $newDashboard = false)
    {
        $where = " WHERE ";
        $wherePDS = '';
        $whereVsum = '';
        $actionAND = " AND ";
        if (!empty($province_id) && empty($district_id) && empty($sub_district_id)) {
            $wherePDS .= " edu.province_id = '" . $province_id . "'";
            // $whereVsum .= " ( SELECT name_th FROM tbl_provinces WHERE id = edu.province_id ) = '" . $province_id . "'";
        }
        if (!empty($province_id) && !empty($district_id) && empty($sub_district_id)) {
            $wherePDS .= " edu.province_id = '" . $province_id . "' AND edu.district_id = '" . $district_id . "'";
            //$whereVsum .= " ( SELECT name_th FROM tbl_provinces WHERE id = edu.province_id ) = '" . $province_id . "' \n AND ( SELECT name_th FROM tbl_district WHERE id = edu.district_id ) = '" . $district_id . "'";
        }
        if (!empty($province_id) && !empty($district_id) && !empty($sub_district_id)) {
            $wherePDS .= " edu.province_id = '" . $province_id . "' AND edu.district_id = '" . $district_id . "'  AND edu.sub_district_id = '" . $sub_district_id . "'";
            // $whereVsum .= " ( SELECT name_th FROM tbl_provinces WHERE id = edu.province_id ) = '" . $province_id .
            //     "' \n AND ( SELECT name_th FROM tbl_district WHERE id = edu.district_id ) = '" . $district_id .
            //     "' \n AND ( SELECT name_th FROM tbl_sub_district WHERE id = edu.sub_district_id ) = '" . $sub_district_id . "'";
        }

        if (!empty($mode) && !empty($district_id && empty($sub_district_id))) {
            $wherePDS .= " edu.district_id = '" . $district_id . "' ";
            //$whereVsum .= " ( SELECT name_th FROM tbl_district WHERE id = edu.district_id ) = '" . $district_id . "'";
        }
        if (!empty($mode) && !empty($district_id) && !empty($sub_district_id)) {
            $wherePDS .= " edu.district_id = '" . $district_id . "'  AND edu.sub_district_id = '" . $sub_district_id . "' ";
            // $whereVsum .= " ( SELECT name_th FROM tbl_district WHERE id = edu.district_id ) = '" . $district_id .
            //     "' \n AND ( SELECT name_th FROM tbl_sub_district WHERE id = edu.sub_district_id ) = '" . $sub_district_id . "'";
        }

        if (empty($wherePDS)) {
            $where = ' ';
            $actionAND = " ";
        }

        $array_data = [];

        $whereUserCreate = " WHERE ";
        if ($where != ' ') {
            $whereUserCreate = " AND ";
        }

        if (!$newDashboard) {
            $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', $whereUserCreate) : '';
            array_push($array_data, $this->getDataCountDashboardAdmin(
                "SELECT\n" .
                    "	COUNT(*) count_std \n" .
                    "FROM\n" .
                    "	tb_students std\n" .
                    "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                    "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                    "	LEFT JOIN tbl_district d ON edu.district_id = d.id \n" .
                    $where . $wherePDS . $userCreate . " AND std_status = 'กำลังศึกษา'"
            ));
            $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'visit', $whereUserCreate) : '';
            array_push($array_data, $this->getDataCountDashboardAdmin(
                "SELECT\n" .
                    "	COUNT(*) visit_home \n" .
                    "FROM\n" .
                    "	stf_tb_form_visit_home visit\n" .
                    "	LEFT JOIN tb_students std ON visit.std_id = std.std_id\n" .
                    "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                    "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                    $where . $wherePDS . $userCreate
            ));
            $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'eva', $whereUserCreate) : '';
            array_push($array_data, $this->getDataCountDashboardAdmin(
                "SELECT\n" .
                    "	COUNT(*) from_evoluate \n" .
                    "FROM\n" .
                    "	stf_tb_form_evaluate_students eva\n" .
                    "	LEFT JOIN tb_students std ON eva.std_id = std.std_id\n" .
                    "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                    "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                    $where . $wherePDS . $userCreate
            ));
        }
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) std_gender1 \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	(std_gender = 'ชาย' OR std_gender = '-' OR std_gender = 'null') AND std_status = 'กำลังศึกษา' \n" .
                "	AND std_class = 'ประถม'" .
                $actionAND . $wherePDS . $userCreate
        ));
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) std_gender2 \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	(std_gender = 'ชาย' OR std_gender = '-' OR std_gender = 'null') AND std_status = 'กำลังศึกษา' \n" .
                "	AND std_class = 'ม.ต้น' \n" .
                $actionAND . $wherePDS . $userCreate
        ));
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) std_gender3 \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	(std_gender = 'ชาย' OR std_gender = '-' OR std_gender = 'null') AND std_status = 'กำลังศึกษา' \n" .
                "	AND std_class = 'ม.ปลาย' \n" .
                $actionAND . $wherePDS . $userCreate
        ));
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) std_gender4 \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	(std_gender = 'หญิง') AND std_status = 'กำลังศึกษา' \n" .
                "	AND std_class = 'ประถม'" .
                $actionAND . $wherePDS . $userCreate
        ));
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) std_gender5 \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	(std_gender = 'หญิง') AND std_status = 'กำลังศึกษา' \n" .
                "	AND std_class = 'ม.ต้น' \n" .
                $actionAND . $wherePDS . $userCreate
        ));
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) std_gender6 \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	(std_gender = 'หญิง') AND std_status = 'กำลังศึกษา' \n" .
                "	AND std_class = 'ม.ปลาย' \n" .
                $actionAND . $wherePDS . $userCreate
        ));

        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) pratom_break \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	std_status = 'พักการเรียน' \n" .
                "	AND std_class = 'ประถม' \n" .
                $actionAND . $wherePDS . $userCreate
        ));

        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) pratom_finish \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	std_status = 'จบการศึกษา' \n" .
                "	AND std_class = 'ประถม' \n" .
                $actionAND . $wherePDS . $userCreate
        ));

        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) mt_break \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	std_status = 'พักการเรียน' \n" .
                "	AND std_class = 'ม.ต้น' \n" .
                $actionAND . $wherePDS . $userCreate
        ));

        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) mt_finish \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	std_status = 'จบการศึกษา' \n" .
                "	AND std_class = 'ม.ต้น' \n" .
                $actionAND . $wherePDS . $userCreate
        ));

        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) mp_break \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	std_status = 'พักการเรียน' \n" .
                "	AND std_class = 'ม.ปลาย' \n" .
                $actionAND . $wherePDS . $userCreate
        ));

        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std', " AND ") : '';
        array_push($array_data, $this->getDataCountDashboardAdmin(
            "SELECT\n" .
                "	COUNT(*) mp_finish \n" .
                "FROM\n" .
                "	tb_students std\n" .
                "	LEFT JOIN tb_users u ON std.user_create = u.id \n" .
                "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                "WHERE\n" .
                "	std_status = 'จบการศึกษา' \n" .
                "	AND std_class = 'ม.ปลาย' \n" .
                $actionAND . $wherePDS . $userCreate
        ));

        if (!$newDashboard) {
            $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'std_per', $whereUserCreate) : '';
            array_push($array_data, $this->getDataCountDashboardAdmin(
                "SELECT\n" .
                    "	COUNT(*) std_person \n" .
                    "FROM\n" .
                    "	stf_tb_form_student_person_new std_per\n" .
                    "	LEFT JOIN tb_students std ON std_per.std_id = std.std_id\n" .
                    "	LEFT JOIN tb_users u ON std.user_create = u.id\n" .
                    "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                    $where . $wherePDS . $userCreate
            ));
            $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'vsum', $whereUserCreate) : '';
            array_push($array_data, $this->getDataCountDashboardAdmin(
                "SELECT\n" .
                    "	COUNT(*) visit_sum \n" .
                    "FROM\n" .
                    "	stf_tb_visit_summary vsum\n" .
                    "	LEFT JOIN tb_users u ON vsum.user_create = u.id\n" .
                    "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                    $where . $wherePDS . $userCreate
            ));
            $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'screen', $whereUserCreate) : '';
            array_push($array_data, $this->getDataCountDashboardAdmin(
                "SELECT\n" .
                    "	COUNT(*) screening \n" .
                    "FROM\n" .
                    "	stf_tb_form_screening_students screen\n" .
                    "	LEFT JOIN tb_students std ON screen.std_id = std.std_id\n" .
                    "	LEFT JOIN tb_users u ON std.user_create = u.id\n" .
                    "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
                    $where . $wherePDS . $userCreate
            ));
        }
        return $array_data;
    }


    function getDataCountDashboardAdmin($sql)
    {
        // echo $sql;
        $data = $this->db->Query($sql, []);
        return json_decode($data)[0];
    }

    function getUserCreateForCount($teacherId, $table, $where = "")
    {
        return $where . $table . '.user_create = ' . $teacherId;
    }

    function getDataListStd($province_id = "", $district_id = "", $sub_district_id = "", $userId = "0", $termId = 0, $mode = "")
    {
        $array_data = [];

        $where = " WHERE ";
        $wherePDS = '';
        $whereVsum = '';
        $actionAND = " AND ";
        $whereTermId = "";
        if (!empty($province_id) && empty($district_id) && empty($sub_district_id)) {
            $wherePDS .= " edu.province_id = '" . $province_id . "'";
            // $whereVsum .= " ( SELECT name_th FROM tbl_provinces WHERE id = edu.province_id ) = '" . $province_id . "'";
        }
        if (!empty($province_id) && !empty($district_id) && empty($sub_district_id)) {
            $wherePDS .= " edu.province_id = '" . $province_id . "' AND edu.district_id = '" . $district_id . "'";
            //$whereVsum .= " ( SELECT name_th FROM tbl_provinces WHERE id = edu.province_id ) = '" . $province_id . "' \n AND ( SELECT name_th FROM tbl_district WHERE id = edu.district_id ) = '" . $district_id . "'";
        }
        if (!empty($province_id) && !empty($district_id) && !empty($sub_district_id)) {
            $wherePDS .= " edu.province_id = '" . $province_id . "' AND edu.district_id = '" . $district_id . "'  AND edu.sub_district_id = '" . $sub_district_id . "'";
            // $whereVsum .= " ( SELECT name_th FROM tbl_provinces WHERE id = edu.province_id ) = '" . $province_id .
            //     "' \n AND ( SELECT name_th FROM tbl_district WHERE id = edu.district_id ) = '" . $district_id .
            //     "' \n AND ( SELECT name_th FROM tbl_sub_district WHERE id = edu.sub_district_id ) = '" . $sub_district_id . "'";
        }

        if (!empty($mode) && !empty($district_id && empty($sub_district_id))) {
            $wherePDS .= " edu.district_id = '" . $district_id . "' ";
            //$whereVsum .= " ( SELECT name_th FROM tbl_district WHERE id = edu.district_id ) = '" . $district_id . "'";
        }
        if (!empty($mode) && !empty($district_id) && !empty($sub_district_id)) {
            $wherePDS .= " edu.district_id = '" . $district_id . "'  AND edu.sub_district_id = '" . $sub_district_id . "' ";
            // $whereVsum .= " ( SELECT name_th FROM tbl_district WHERE id = edu.district_id ) = '" . $district_id .
            //     "' \n AND ( SELECT name_th FROM tbl_sub_district WHERE id = edu.sub_district_id ) = '" . $sub_district_id . "'";
        }

        if (empty($wherePDS)) {
            $where = ' ';
            $actionAND = " ";
        }

        $testResultArr = [];
        $sql = $this->makeSQLjion("vg_test_result", "ts", $actionAND,  $wherePDS, "ประถม", $userId, $termId);
        $data = $this->db->Query($sql, []);
        $testResultArr['pratom'] = json_decode($data)[0]->count_test_result;
        $sql = $this->makeSQLjion("vg_test_result", "ts", $actionAND,  $wherePDS, "ม.ต้น", $userId, $termId);
        $data = $this->db->Query($sql, []);
        $testResultArr['mt'] = json_decode($data)[0]->count_test_result;
        $sql = $this->makeSQLjion("vg_test_result", "ts", $actionAND,  $wherePDS, "ม.ปลาย", $userId, $termId);
        $data = $this->db->Query($sql, []);
        $testResultArr['mp'] = json_decode($data)[0]->count_test_result;
        $array_data['test_result'] = $testResultArr;

        $gradiateArr = [];
        $sql = $this->makeSQLjion("vg_gradiate", "gra", $actionAND,  $wherePDS, "ประถม", $userId, $termId);
        $data = $this->db->Query($sql, []);
        $gradiateArr['pratom'] = json_decode($data)[0]->count_test_result;
        $sql = $this->makeSQLjion("vg_gradiate", "gra", $actionAND,  $wherePDS, "ม.ต้น", $userId, $termId);
        $data = $this->db->Query($sql, []);
        $gradiateArr['mt'] = json_decode($data)[0]->count_test_result;
        $sql = $this->makeSQLjion("vg_gradiate", "gra", $actionAND,  $wherePDS, "ม.ปลาย", $userId, $termId);
        $data = $this->db->Query($sql, []);
        $gradiateArr['mp'] = json_decode($data)[0]->count_test_result;
        $array_data['gradiate'] = $gradiateArr;

        $finishArr = [];
        $sql = $this->makeSQLjion("vg_std_finish", "finish", $actionAND,  $wherePDS, "ประถม", $userId, $termId);
        $data = $this->db->Query($sql, []);
        $finishArr['pratom'] = json_decode($data)[0]->count_test_result;
        $sql = $this->makeSQLjion("vg_std_finish", "finish", $actionAND,  $wherePDS, "ม.ต้น", $userId, $termId);
        $data = $this->db->Query($sql, []);
        $finishArr['mt'] = json_decode($data)[0]->count_test_result;
        $sql = $this->makeSQLjion("vg_std_finish", "finish", $actionAND,  $wherePDS, "ม.ปลาย", $userId, $termId);
        $data = $this->db->Query($sql, []);
        $finishArr['mp'] = json_decode($data)[0]->count_test_result;
        $array_data['std_finish'] = $finishArr;

        return $array_data;
    }

    function makeSQLjion($table, $shortName, $actionAND, $wherePDS, $std_class, $userId, $termId = 0)
    {

        $whereUser = "";
        $whereTermId = "";
        if ($userId != '0') {
            $whereUser = " AND " . $shortName . '.user_create = ' . $userId;
        }
        if (!empty($termId)) {
            $whereTermId = " AND " . $shortName . ".term_id = " . $termId;
        }
        return "SELECT\n" .
            "count(*) count_test_result\n" .
            "FROM\n" .
            $table . " " . $shortName . "\n" .
            "LEFT JOIN tb_students std ON " . $shortName . ".std_id = std.std_id\n" .
            "LEFT JOIN tb_users u ON " . $shortName . ".user_create = u.id\n" .
            "LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
            "WHERE std.std_status = 'กำลังศึกษา' AND std.std_class = '" . $std_class . "' " . $actionAND . $wherePDS . $whereUser . $whereTermId;
    }
}
