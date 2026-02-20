<?php

/**
 * Define database parameters here
 */
define("DB_USER", 'root');
define("DB_PASSWORD", '');
define("DB_NAME", 'edu');
define("DB_HOST", 'localhost');
define("BACKUP_DIR", 'backups'); // Directory to store backups
define("TABLES", '*'); // Full backup
//define("TABLES", 'table1, table2, table3'); // Partial backup
define('IGNORE_TABLES', array('tb_logs')); // Tables to ignore
define("CHARSET", 'utf8');
define("DISABLE_FOREIGN_KEY_CHECKS", true);
define("BATCH_SIZE", 1000);
define("GZIP_BACKUP_FILE", true); // Set to false if you want plain SQL backup files (not gzipped)

/**
 * The Backup_Database class
 */
class Backup_Database
{
    /**
     * Host where the database is located
     */
    var $host;

    /**
     * Username used to connect to database
     */
    var $username;

    /**
     * Password used to connect to database
     */
    var $passwd;

    /**
     * Database to backup
     */
    var $dbName;

    /**
     * Database charset
     */
    var $charset;

    /**
     * Database connection
     */
    var $conn;

    /**
     * Backup directory where backup files are stored 
     */
    var $backupDir;

    /**
     * Output backup file
     */
    var $backupFile;

    /**
     * Use gzip compression on backup file
     */
    var $gzipBackupFile;

    /**
     * Content of standard output
     */
    var $output;

    /**
     * Disable foreign key checks
     */
    var $disableForeignKeyChecks;

    /**
     * Batch size, number of rows to process per iteration
     */
    var $batchSize;

    /**
     * Constructor initializes database
     */
    public function __construct($host, $username, $passwd, $dbName, $charset = 'utf8')
    {
        $this->host                    = $host;
        $this->username                = $username;
        $this->passwd                  = $passwd;
        $this->dbName                  = $dbName;
        $this->charset                 = $charset;
        $this->conn                    = $this->initializeDatabase();
        $this->backupDir               = BACKUP_DIR ? BACKUP_DIR : '.';
        $this->backupFile              = 'backup-' . $this->dbName . '-' . date('Y-m-d') . "-" . date('H-i') . '.sql';
        $this->gzipBackupFile          = defined('GZIP_BACKUP_FILE') ? GZIP_BACKUP_FILE : true;
        $this->disableForeignKeyChecks = defined('DISABLE_FOREIGN_KEY_CHECKS') ? DISABLE_FOREIGN_KEY_CHECKS : true;
        $this->batchSize               = defined('BATCH_SIZE') ? BATCH_SIZE : 1000; // default 1000 rows
        $this->output                  = '';
    }

    protected function initializeDatabase()
    {
        try {
            $conn = mysqli_connect($this->host, $this->username, $this->passwd, $this->dbName);
            if (mysqli_connect_errno()) {
                throw new Exception('ERROR connecting database: ' . mysqli_connect_error());
                die();
            }
            // Ensure proper UTF-8 encoding
            mysqli_set_charset($conn, 'utf8mb4');
            mysqli_query($conn, 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci');
        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }
    
        return $conn;
    }    

    public function backupTables($tables = '*')
    {
        try {
            if ($tables == '*') {
                $tables = array();
                $result = mysqli_query($this->conn, 'SHOW TABLES');
                while ($row = mysqli_fetch_row($result)) {
                    $tables[] = $row[0];
                }
            } else {
                $tables = is_array($tables) ? $tables : explode(',', str_replace(' ', '', $tables));
            }

            $backupFiles = [];

            foreach ($tables as $table) {
                if (in_array($table, IGNORE_TABLES)) continue;

                $this->obfPrint("Backing up `$table` table...", 0, 0);

                $sql = 'DROP TABLE IF EXISTS `' . $table . '`;';
                $row = mysqli_fetch_row(mysqli_query($this->conn, 'SHOW CREATE TABLE `' . $table . '`'));
                $sql .= "\n\n" . $row[1] . ";\n\n";

                $row = mysqli_fetch_row(mysqli_query($this->conn, 'SELECT COUNT(*) FROM `' . $table . '`'));
                $numRows = $row[0];
                $numBatches = intval($numRows / $this->batchSize) + 1;

                for ($b = 1; $b <= $numBatches; $b++) {
                    $query = 'SELECT * FROM `' . $table . '` LIMIT ' . ($b * $this->batchSize - $this->batchSize) . ',' . $this->batchSize;
                    $result = mysqli_query($this->conn, $query);
                    $realBatchSize = mysqli_num_rows($result);
                    $numFields = mysqli_num_fields($result);

                    if ($realBatchSize !== 0) {
                        $sql .= 'INSERT INTO `' . $table . '` VALUES ';
                        while ($row = mysqli_fetch_row($result)) {
                            $sql .= '(';
                            for ($j = 0; $j < $numFields; $j++) {
                                $sql .= isset($row[$j]) ? '"' . addslashes($row[$j]) . '"' : 'NULL';
                                $sql .= ($j < ($numFields - 1)) ? ',' : '';
                            }
                            $sql .= "),\n";
                        }
                        $sql = rtrim($sql, ",\n") . ";\n";
                    }
                }

                $fileName = $this->backupDir . '/' . $table . '-' . date('Y-m-d-H-i') . '.sql';
                file_put_contents($fileName, $sql);
                $backupFiles[] = $fileName;

                $this->obfPrint('OK');
            }

            $this->createZipArchive($backupFiles);

            return true;
        } catch (Exception $e) {
            print_r($e->getMessage());
            return false;
        }
    }

    /**
     * Create a ZIP archive of the SQL backup files.
     * @param array $backupFiles Array of individual table backup file paths.
     */
    private function createZipArchive($backupFiles)
    {
        $zip = new ZipArchive();
        $zipFileName = $this->backupDir . '/backup-' . $this->dbName . '-' . date('Y-m-d-H-i') . '.zip';

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($backupFiles as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();

            // Optionally, delete the individual SQL files after zipping
            foreach ($backupFiles as $file) {
                unlink($file);
            }

            $this->obfPrint('Backup successfully created as ' . $zipFileName, 1, 1);
        } else {
            $this->obfPrint('Failed to create ZIP archive', 1, 1);
        }
    }

    /**
     * Prints message forcing output buffer flush
     *
     */
    public function obfPrint($msg = '', $lineBreaksBefore = 0, $lineBreaksAfter = 1)
    {
        if (!$msg) {
            return false;
        }

        if ($msg != 'OK' and $msg != 'KO') {
            $msg = date("Y-m-d H:i:s") . ' - ' . $msg;
        }
        $output = '';

        if (php_sapi_name() != "cli") {
            $lineBreak = "<br />";
        } else {
            $lineBreak = "\n";
        }

        if ($lineBreaksBefore > 0) {
            for ($i = 1; $i <= $lineBreaksBefore; $i++) {
                $output .= $lineBreak;
            }
        }

        $output .= $msg;

        if ($lineBreaksAfter > 0) {
            for ($i = 1; $i <= $lineBreaksAfter; $i++) {
                $output .= $lineBreak;
            }
        }


        // Save output for later use
        $this->output .= str_replace('<br />', '\n', $output);

        echo $output;


        if (php_sapi_name() != "cli") {
            if (ob_get_level() > 0) {
                ob_flush();
            }
        }

        $this->output .= " ";

        flush();
    }
}

/**
 * Instantiate Backup_Database and perform backup
 */
error_reporting(E_ALL);
set_time_limit(900);

if (php_sapi_name() != "cli") {
    echo '<div style="font-family: monospace;">';
}

$backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, CHARSET);
$result = $backupDatabase->backupTables(TABLES) ? 'OK' : 'KO';
$backupDatabase->obfPrint('Backup result: ' . $result, 1);

if (php_sapi_name() != "cli") {
    echo '</div>';
}
