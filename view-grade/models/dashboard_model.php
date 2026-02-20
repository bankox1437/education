<?php
class Dashboard_Model
{
    private $db;

    public function __construct($DB)
    {
        $this->db = $DB;
        $this->initClass();
    }

    function initClass() {}

    function getDataCountAll()
    {
        // $district_id = isset($_REQUEST['district_id']) ? " AND edu.district_id = " . $_REQUEST['district_id'] : " ";
        $province_id = isset($_REQUEST['province_id']) && $_REQUEST['province_id'] ? " AND edu.province_id = " . $_REQUEST['province_id'] : " ";
        $district_id = isset($_REQUEST['district_id']) && $_REQUEST['district_id'] ? " AND edu.district_id = " . $_REQUEST['district_id'] : " ";
        $subdistrict_id = isset($_REQUEST['subdistrict_id']) && $_REQUEST['subdistrict_id'] ? " AND edu.sub_district_id = " . $_REQUEST['subdistrict_id'] : " ";

        $and_case =  $province_id . " \n " . $district_id . " \n " . $subdistrict_id;
        $term_id = isset($_REQUEST['termId']) && $_REQUEST['termId'] ? $_REQUEST['termId'] : "";
        $credit_case = $and_case;
        $term_case = "";

        if (!empty($term_id)) {
            $term_case = " AND term_id = " . $term_id;
        }

        $teacherId = isset($_REQUEST['teacherId']) && $_REQUEST['teacherId'] ? $_REQUEST['teacherId'] : "0";

        if (isset($_REQUEST['dhByTerm'])) {
            $term_case_dh = " AND term_id = " . $_SESSION['term_active']->term_id;
        }

        $main_sql = "SELECT ";
        $main_sql .= "( " . $this->std_count($and_case, $teacherId) . " ) std_count,";
        // $main_sql .= "( " . $this->test_grade_count($and_case.$term_case, $teacherId) . " ) test_grade_count,";
        $main_sql .= "( " . $this->n_net_count($and_case . $term_case . $term_case_dh, $teacherId) . " ) n_net_count,";
        $main_sql .= "( " . $this->kpc_count($and_case . $term_case, $teacherId) . " ) kpc_count,";
        $main_sql .= "( " . $this->table_test_count($and_case . $term_case, $teacherId) . " ) table_test_count,";
        $main_sql .= "( " . $this->test_result_count($and_case . $term_case . $term_case_dh, $teacherId) . " ) test_result_count,";
        $main_sql .= "( " . $this->graduate_count($and_case, $teacherId) . " ) graduate_count,";
        $main_sql .= "( " . $this->finish_count($and_case . $term_case . $term_case_dh, $teacherId) . " ) finish_count,";
        // $main_sql .= "( " . $this->moral_count($and_case.$term_case, $teacherId) . " ) moral_count,";
        $main_sql .= "( " . $this->credit_count($credit_case, $teacherId) . " ) credit_count";

        // echo $main_sql;
        $result = $this->db->Query($main_sql, []);
        return [json_decode($result)[0], $main_sql];
    }

    private function std_count($and_case, $teacherId)
    {
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'ts', " AND ") : '';
        $eduJoin = $teacherId != "0" ? $this->checkUserOther($teacherId) : ["		,tbl_non_education edu \n", "		AND u.edu_id = edu.id \n"];
        $sql = "SELECT\n" .
            "		COUNT(distinct ts.std_id) \n" .
            "	FROM\n" .
            "		tb_students ts,\n" .
            "		tb_users u\n" .
            $eduJoin[0] .
            "	WHERE\n" .
            "		ts.user_create = u.id \n" .
            $eduJoin[1] . $and_case . $userCreate . " AND ts.std_status = 'กำลังศึกษา'";
        return $sql;
    }

    private function test_grade_count($and_case, $teacherId)
    {
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'tg', " AND ") : '';
        $eduJoin = $teacherId != "0" ? $this->checkUserOther($teacherId) : ["		,tbl_non_education edu \n", "		AND u.edu_id = edu.id \n"];
        $sql = "SELECT\n" .
            "		COUNT( std_id ) \n" .
            "	FROM\n" .
            "		vg_test_grade tg,\n" .
            "		tb_users u\n" .
            $eduJoin[0] .
            "	WHERE\n" .
            "		tg.user_create = u.id \n" .
            $eduJoin[1] . $and_case . $userCreate;
        return $sql;
    }

    private function n_net_count($and_case, $teacherId)
    {
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'n_net', " AND ") : '';
        $eduJoin = $teacherId != "0" ? $this->checkUserOther($teacherId) : ["		,tbl_non_education edu \n", "		AND u.edu_id = edu.id \n"];
        $sql = "SELECT\n" .
            "		COUNT( std_id ) \n" .
            "	FROM\n" .
            "		vg_n_net n_net,\n" .
            "		tb_users u\n" .
            $eduJoin[0] .
            "	WHERE\n" .
            "		n_net.user_create = u.id \n" .
            $eduJoin[1] . $and_case . $userCreate;
        return $sql;
    }

    private function kpc_count($and_case, $teacherId)
    {
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'kpc', " AND ") : '';
        $eduJoin = $teacherId != "0" ? $this->checkUserOther($teacherId) : ["		,tbl_non_education edu \n", "		AND u.edu_id = edu.id \n"];
        $sql = "SELECT\n" .
            "		COUNT(distinct kpc.std_id) \n" .
            "	FROM\n" .
            "		vg_kpc kpc,\n" .
            "		tb_users u\n" .
            $eduJoin[0] .
            "	WHERE\n" .
            "		kpc.user_create = u.id \n" .
            $eduJoin[1] . $and_case . $userCreate;
        return $sql;
    }

    private function table_test_count($and_case, $teacherId)
    {
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 't_test', " AND ") : '';
        $eduJoin = $teacherId != "0" ? $this->checkUserOther($teacherId) : ["		,tbl_non_education edu \n", "		AND u.edu_id = edu.id \n"];
        $sql = "SELECT\n" .
            "		COUNT( t_test_id ) \n" .
            "	FROM\n" .
            "		vg_table_test t_test,\n" .
            "		tb_users u\n" .
            $eduJoin[0] .
            "	WHERE\n" .
            "		t_test.user_create = u.id \n" .
            $eduJoin[1] . $and_case . $userCreate;
        return $sql;
    }

    private function test_result_count($and_case, $teacherId)
    {
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 't_result', " AND ") : '';
        $eduJoin = $teacherId != "0" ? $this->checkUserOther($teacherId) : ["		,tbl_non_education edu \n", "		AND u.edu_id = edu.id \n"];
        $sql = "SELECT\n" .
            "		COUNT( test_result_id ) \n" .
            "	FROM\n" .
            "		vg_test_result t_result,\n" .
            "		tb_users u,\n" .
            "		tb_students ts\n" .
            $eduJoin[0] .
            "	WHERE\n" .
            "		t_result.user_create = u.id AND t_result.std_id = ts.std_id \n" .
            $eduJoin[1] . $and_case . $userCreate . " AND ts.std_status = 'กำลังศึกษา'";
        return $sql;
    }

    private function graduate_count($and_case, $teacherId)
    {
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'gra', " AND ") : '';
        $eduJoin = $teacherId != "0" ? $this->checkUserOther($teacherId) : ["		,tbl_non_education edu \n", "		AND u.edu_id = edu.id \n"];
        $sql = "SELECT\n" .
            "		COUNT( gradiate_id ) \n" .
            "	FROM\n" .
            "		vg_gradiate gra,\n" .
            "		tb_users u,\n" .
            "		tb_students ts\n" .
            $eduJoin[0] .
            "	WHERE\n" .
            "		gra.user_create = u.id AND gra.std_id = ts.std_id \n" .
            $eduJoin[1] . $and_case . $userCreate . " AND ts.std_status = 'กำลังศึกษา'";
        return $sql;
    }

    private function finish_count($and_case, $teacherId)
    {
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'finish', " AND ") : '';
        $eduJoin = $teacherId != "0" ? $this->checkUserOther($teacherId) : ["		,tbl_non_education edu \n", "		AND u.edu_id = edu.id \n"];
        $sql = "SELECT\n" .
            "		COUNT( finish_id ) \n" .
            "	FROM\n" .
            "		vg_std_finish finish,\n" .
            "		tb_users u,\n" .
            "		tb_students ts\n" .
            $eduJoin[0] .
            "	WHERE\n" .
            "		finish.user_create = u.id AND finish.std_id = ts.std_id \n" .
            $eduJoin[1] . $and_case . $userCreate  . " AND ts.std_status = 'กำลังศึกษา'";
        return $sql;
    }

    private function moral_count($and_case, $teacherId)
    {
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'moral', " AND ") : '';
        $eduJoin = $teacherId != "0" ? $this->checkUserOther($teacherId) : ["		,tbl_non_education edu \n", "		AND u.edu_id = edu.id \n"];
        $sql = "SELECT\n" .
            "		COUNT( moral_id ) \n" .
            "	FROM\n" .
            "		vg_moral moral,\n" .
            "		tb_users u\n" .
            $eduJoin[0] .
            "	WHERE\n" .
            "		moral.user_create = u.id \n" .
            $eduJoin[1] . $and_case . $userCreate;
        return $sql;
    }

    private function credit_count($and_case, $teacherId)
    {
        $userCreate =  $teacherId != "0" ? $this->getUserCreateForCount($teacherId, 'credit', " AND ") : '';
        $eduJoin = $teacherId != "0" ? $this->checkUserOther($teacherId) : ["		,tbl_non_education edu \n", "		AND u.edu_id = edu.id \n"];
        $sql = "SELECT\n" .
            "		COUNT( DISTINCT credit.std_id ) \n" .
            "	FROM\n" .
            "		vg_credit credit,\n" .
            "		tb_users u\n" .
            $eduJoin[0] .
            "	WHERE\n" .
            "		credit.user_create = u.id \n" .
            $eduJoin[1] . $and_case . $userCreate;
        return $sql;
    }

    function getDataSubDistrict($district_id)
    {
        $sql = "SELECT id,name_th FROM tbl_sub_district\n" .
            "WHERE district_id = :district_id";
        $result = $this->db->Query($sql, ['district_id' => $district_id]);
        return $result;
    }

    function getUserCreateForCount($teacherId, $table, $where = "")
    {
        return $where . $table . '.user_create = ' . $teacherId;
    }

    function checkUserOther($userId)
    {
        if ($userId != "0") {
            $sql = "SELECT id,edu_type FROM tb_users\n" .
                "WHERE id = :id";
            $result = $this->db->Query($sql, ['id' => $userId]);

            $result = json_decode($result);
            if (count($result) > 0 && $result[0]->edu_type == 'edu') {
                return ["		,tbl_non_education edu \n", "		AND u.edu_id = edu.id \n"];
            }
        }

        return [" ", " "];
    }

    function getCountSTDAll()
    {
        $db = $this->db;
        $params = [];
        $conditions = ["u.role_id = 3", "s.std_status = 'กำลังศึกษา'"];

        $filters = [
            'province_id' => 'n.province_id',
            'district_id' => 'n.district_id',
            'subdistrict_id' => 'n.sub_district_id',
            'teacherId'   => 'u.id'
        ];

        foreach ($filters as $key => $field) {
            if (!empty($_REQUEST[$key])) {
                $conditions[] = "$field = :$key"; // ใช้ :province_id, :district_id, :teacherId
                $params[$key] = $_REQUEST[$key];  // กำหนดค่าตรงกับ key
            }
        }

        $where = "WHERE " . implode(" AND ", $conditions);
        $term_id = $_SESSION['term_active']->term_id;

        $resultArr = [];

        // ==============================
        // 1️⃣ ฟังก์ชัน helper แปลงวันเกิดภาษาไทย -> CE
        // ==============================
        $parseThaiDate = function ($thaiDate) {
            $thaiMonths = [
                'มกราคม' => 1,
                'กุมภาพันธ์' => 2,
                'มีนาคม' => 3,
                'เมษายน' => 4,
                'พฤษภาคม' => 5,
                'มิถุนายน' => 6,
                'กรกฎาคม' => 7,
                'สิงหาคม' => 8,
                'กันยายน' => 9,
                'ตุลาคม' => 10,
                'พฤศจิกายน' => 11,
                'ธันวาคม' => 12
            ];
            if (preg_match('/(\d{1,2})\s+(\S+)\s+(\d{4})/', trim($thaiDate), $m)) {
                $day = (int)$m[1];
                $month = $thaiMonths[$m[2]] ?? 0;
                $year = (int)$m[3] - 543; // BE → CE
                if ($month > 0) return "$year-$month-$day";
            }
            return null;
        };

        // ==============================
        // 2️⃣ ฟังก์ชัน helper จัดอายุ
        // ==============================
        $formatAgeGroup = function ($students) use ($parseThaiDate) {
            $ageGroups = ['age_13_28', 'age_29_44', 'age_45_60', 'age_61_79', 'age_unknown'];
            $stdClasses = ['ประถม', 'ม.ต้น', 'ม.ปลาย', 'รวมทั้งหมด'];

            // init
            $arrAge = [];
            foreach ($stdClasses as $cls) {
                $arrAge[$cls] = array_fill_keys($ageGroups, 0);
            }

            foreach ($students as $s) {
                $cls = $s['std_class'];
                if (!in_array($cls, ['ประถม', 'ม.ต้น', 'ม.ปลาย'])) continue;

                $date = $parseThaiDate($s['std_birthday']);
                if (!$date) {
                    $group = 'age_unknown';
                } else {
                    $age = $date ? (int)date('Y') - (int)substr($date, 0, 4) : null;

                    if ($age >= 13 && $age <= 28) $group = 'age_13_28';
                    elseif ($age >= 29 && $age <= 44) $group = 'age_29_44';
                    elseif ($age >= 45 && $age <= 60) $group = 'age_45_60';
                    elseif ($age >= 61 && $age <= 79) $group = 'age_61_79';
                    else $group = 'age_unknown';
                }

                $arrAge[$cls][$group]++;
                $arrAge['รวมทั้งหมด'][$group]++;
            }

            // format output
            $formatted = [];
            foreach ($arrAge as $cls => $ages) {
                $formatted[] = ['std_class' => $cls, 'ages' => $ages];
            }
            return $formatted;
        };

        // ==============================
        // 3️⃣ ฟังก์ชันดึงข้อมูลเพศ
        // ==============================
        $getGenderData = function ($joinTable = null, $termFilter = null) use ($db, $where, $params, $term_id) {
            $sql = "SELECT s.std_class, s.std_gender, COUNT(DISTINCT s.std_id) AS total_students
                FROM tb_students s
                JOIN tb_users u ON s.user_create = u.id
                JOIN tbl_non_education n ON u.edu_id = n.id";

            if ($joinTable) $sql .= " JOIN $joinTable t ON s.std_id = t.std_id";
            $sql .= " $where";

            if ($termFilter) $sql .= " AND t.term_id = $term_id";

            $sql .= " GROUP BY s.std_class, s.std_gender
                  ORDER BY FIELD(s.std_class,'ประถม','ม.ต้น','ม.ปลาย')";

            $gender = $db->Query($sql, $params);
            return json_decode($gender);
        };

        // ==============================
        // 4️⃣ ฟังก์ชันดึงข้อมูลอายุ
        // ==============================
        $getAgeData = function ($joinTable = null, $termFilter = null) use ($db, $where, $params, $term_id, $formatAgeGroup) {
            $sql = "SELECT s.std_class, s.std_birthday
                FROM tb_students s
                JOIN tb_users u ON s.user_create = u.id
                JOIN tbl_non_education n ON u.edu_id = n.id";

            if ($joinTable) $sql .= " LEFT JOIN $joinTable t ON s.std_id = t.std_id";
            $sql .= " $where";

            if ($termFilter) $sql .= " AND t.term_id = $term_id";

            $sql .= " ORDER BY FIELD(s.std_class,'ประถม','ม.ต้น','ม.ปลาย')";
            $students = $db->Query($sql, $params);
            $students = json_decode($students, true);
            return $formatAgeGroup($students);
        };

        // ==============================
        // 5️⃣ ดึงข้อมูล std_gender และ std_age
        // ==============================
        $resultArr['std_gender'] = $getGenderData();
        $resultArr['std_age']    = $getAgeData();

        // // ==============================
        // // 6️⃣ ดึงข้อมูล test_result, gradiate, finish
        // // ==============================
        $tables = [
            'test_result' => ['table' => 'vg_test_result', 'term' => true],
            'gradiate'    => ['table' => 'vg_gradiate', 'term' => false],
            'finish'      => ['table' => 'vg_std_finish', 'term' => true]
        ];

        foreach ($tables as $key => $info) {
            $resultArr["{$key}_gender"] = $getGenderData($info['table'], $info['term']);
            $resultArr["{$key}_age"]    = $getAgeData($info['table'], $info['term']);
        }

        return $resultArr;
    }


    function calculateAge($birthday)
    {
        $birthdayC = $this->convertThaiDateToPHP($birthday);
        $ageDate = new DateTime($birthdayC);
        $now = new DateTime();
        $ageInterval = $now->diff($ageDate);
        return $ageInterval->y;
    }

    function convertThaiDateToPHP($thaiDate)
    {
        $thaiMonths = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        $dateParts = explode(" ", $thaiDate);
        $day = (int)$dateParts[0];
        $monthIndex = array_search($dateParts[1], $thaiMonths);
        $year = (int)$dateParts[2] - 543; // Convert Thai year to Western year
        return date("Y-m-d", mktime(0, 0, 0, $monthIndex + 1, $day, $year));
    }
}
