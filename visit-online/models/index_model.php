<?php

class Index_Model
{
    private $db;
    public function __construct($DB)
    {
        $this->db = $DB;
    }

    function getDataIndex($user_id)
    {
        $sql = "SELECT i.*,CONCAT(m.term,'/',m.`year`) term FROM cl_index i\n" .
            "LEFT JOIN cl_main_calendar m ON i.m_calendar_id = m.m_calendar_id\n" .
            "WHERE i.user_create = :user_create";
        $data = $this->db->Query($sql, ['user_create' => $user_id]);
        return json_decode($data);
    }

    public function InsertIndex($array_data)
    {
        $sql = "INSERT INTO cl_index (m_calendar_id,user_create, title_index, video)\n" .
            "VALUES\n" .
            "	(:m_calendar_id, :user_create, :title_index, :video)";
        $data = $this->db->InsertLastID($sql, $array_data);
        return $data;
    }

    public function InsertIndexFile($array_data)
    {
        $sql = "INSERT INTO cl_index_file (file_name,file_name_old,index_id)\n" .
            "VALUES\n" .
            "	(:file_name,:file_name_old,:index_id)";
        $data = $this->db->Insert($sql, $array_data);
        return $data;
    }

    public function UpdateIndexFile($array_data)
    {
        $sql = "UPDATE cl_index_file SET file_name = :file_name,file_name_old = :file_name_old\n" .
            "WHERE \n" .
            "	index_file_id = :index_file_id";
        $data = $this->db->Insert($sql, $array_data);
        return $data;
    }

    public function UpdateTitleIdex($array_data)
    {
        $sql = "UPDATE cl_index \n" .
            "SET \n" .
            "title_index = :title_index,\n" .
            "video = :video\n" .
            "WHERE\n" .
            "	index_id = :index_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    public function UpdateIndex($array_data)
    {
        $sql = "UPDATE cl_index \n" .
            "SET \n" .
            "evaluation_results = :evaluation_results,\n" .
            "suggestions = :suggestions\n" .
            "WHERE\n" .
            "	index_id = :index_id";
        $data = $this->db->Update($sql, $array_data);
        return $data;
    }

    function DeleteIndex($index_id)
    {
        $sql = "DELETE FROM cl_index WHERE index_id = :index_id";
        $data = $this->db->Delete($sql, ['index_id' => $index_id]);
        return json_decode($data);
    }


    function getIndexFile($index_id)
    {
        $sql = "SELECT index_file_id,file_name FROM cl_index_file WHERE index_id = :index_id";
        $data = $this->db->Query($sql, ['index_id' => $index_id]);
        return json_decode($data);
    }

    function DeleteIndexFile($index_file_id)
    {
        $sql = "DELETE FROM cl_index_file WHERE index_file_id = :index_file_id";
        $data = $this->db->Delete($sql, ['index_file_id' => $index_file_id]);
        return json_decode($data);
    }
}
