<?php

class Class_Database
{
    public $conn;
    public function __construct()
    {
        include "connect_database.php";
        $connect_db = new Connect_Database_PDO();
        $this->conn = $connect_db->connect;
    }

    public function Query($sql, $param)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            if (count($param) == 0) {
                $stmt->execute();
            } else {
                $stmt->execute($param);
            }
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $json = json_encode($results);
            return $json;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function Insert($sql, $param)
    {
        try {
            // Log the query and parameters
            $this->logQueryAndParams("Insert", $sql, $param);
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($param);
            if ($stmt->rowCount() >= 1) {
                return 1;
            } else {
                $errors = $stmt->errorInfo();
                return $errors[2] . ", " . $errors[1] . " ," . $errors[0];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function InsertLastID($sql, $param)
    {
        try {
            $this->logQueryAndParams("InsertLastID", $sql, $param);
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($param);
            if ($stmt->rowCount() >= 1) {
                $lastId = $this->conn->lastInsertId();
                return $lastId;
            } else {
                $errors = $stmt->errorInfo();
                echo $errors[2] . ", " . $errors[1] . " ," . $errors[0];
                return 0;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function Update($sql, $param)
    {
        try {
            $this->logQueryAndParams("Update", $sql, $param);
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($param);
            if ($stmt) {
                return 1;
            } else {
                return 'Error updating table.';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function Delete($sql, $param)
    {
        try {
            $this->logQueryAndParams("Delete", $sql, $param);
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($param);
            if ($stmt) {
                return 1;
            } else {
                return 'Error deleting table.';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function logQueryAndParams($mode, $sql, $param)
    {
        // if (isset($_SESSION['user_data'])) {
        //     try {
        //         // Log the query
        //         $queryLog = "Query: " . $sql . PHP_EOL;

        //         // Log the parameters
        //         $paramLog = "Parameters: " . json_encode($param) . PHP_EOL;

        //         $sql = "INSERT INTO tb_logs(`mode`,`sql_detail`, `param_data`,`client_ip`,`username`, `user_create`) VALUES (:mode,:sql_detail, :param_data, :client_ip, :username, :user_create);";

        //         $stmt = $this->conn->prepare($sql);
        //         $client_ip = $this->get_client_ip();
        //         $user_create = $_SESSION['user_data']->id;

        //         if ($_SESSION['user_data']->role_id == 4) {
        //             $user_create = $_SESSION['user_data']->edu_type;
        //         }
        //         $stmt->execute(["mode" => $mode, "sql_detail" => $queryLog, "param_data" => $paramLog, "client_ip" => $client_ip, "username" => $_SESSION['user_data']->username, "user_create" => $user_create]);
        //     } catch (Exception $e) {
        //         echo $e->getMessage();
        //     }
        // }
    }

    private function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
