<?php
class Connect_Database_PDO
{
    public $connect;
    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "edu2";
        try {
            $connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connection successfuly \r\n";
            $this->connect = $connect;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
