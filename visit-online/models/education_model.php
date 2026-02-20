<?php

class Education_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function getEducation()
    {
        $sql = "SELECT id,name,district_id,sub_district_id FROM tbl_non_education";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    public function getEducationOther()
    {
        $sql = "SELECT id,name FROM tbl_non_education_other";
        $data = $this->db->Query($sql, []);
        return json_decode($data);
    }

    public function getSubDisPro($edu_id)
    {
        $sql = "SELECT\n" .
            "   sd.id sub_id,\n" .
            "	sd.name_th sub_name,\n" .
            "	d.id d_id,\n" .
            "	d.name_th d_name,\n" .
            "	p.id p_id,\n" .
            "	p.name_th p_name \n" .
            "FROM\n" .
            "	tbl_non_education edu\n" .
            "	LEFT JOIN tbl_sub_district sd ON edu.sub_district_id = sd.id\n" .
            "	LEFT JOIN tbl_district d ON edu.district_id = d.id\n" .
            "	LEFT JOIN tbl_provinces p ON edu.province_id = p.id\n" .
            "WHERE edu.id = :edu_id";
        $data = $this->db->Query($sql, ['edu_id' => $edu_id]);
        return json_decode($data);
    }

    public function editEdu($array_edu)
    {
        $sql = "UPDATE tbl_non_education \n" .
            "SET NAME=:edu_name \n" .
            "WHERE id=:edu_id";
        $data = $this->db->Update($sql, $array_edu);
        return $data;
    }
}
