<?php

class Report_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function getDataReport($user_id)
    {
        $sql = "SELECT * FROM cl_report WHERE user_create = :user_create";
        $data = $this->db->Query($sql, ['user_create' => $user_id]);
        return json_decode($data);
    }

    function getDataReportNew($user_id)
    {
        $sql = "SELECT * FROM cl_report_new WHERE user_create = :user_create";
        $data = $this->db->Query($sql, ['user_create' => $user_id]);
        return json_decode($data);
    }

    public function InsertReport($array_data)
    {
        $sql = "INSERT INTO cl_report (report_name, report_detail,img_1, img_2, img_3, img_4, user_create)\n" .
            "VALUES\n" .
            "	(:report_name, :report_detail, :img_name_1, :img_name_2, :img_name_3, :img_name_4,:user_create);";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function InsertReportNew($array_data)
    {
        $sql = "INSERT INTO cl_report_new (filename,filename_raw,user_create)\n" .
            "VALUES\n" .
            "	(:filename,:filename_raw,:user_create);";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function UpdateReport($array_data)
    {
        $sql = "UPDATE cl_report \n" .
            "SET \n" .
            "report_name = :report_name,\n" .
            "report_detail = :report_detail,\n" .
            "img_1 = :img_name_1,\n" .
            "img_2 = :img_name_2,\n" .
            "img_3 = :img_name_3,\n" .
            "img_4 = :img_name_4\n" .
            "WHERE\n" .
            "	report_id = :report_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    function DeleteReport($report_id)
    {
        $sql = "DELETE FROM cl_report WHERE report_id = :report_id";
        $data = $this->db->Delete($sql, ['report_id' => $report_id]);
        return json_decode($data);
    }

    function DeleteReportNew($report_id)
    {
        $sql = "DELETE FROM cl_report_new WHERE report_id = :report_id";
        $data = $this->db->Delete($sql, ['report_id' => $report_id]);
        return json_decode($data);
    }
}
