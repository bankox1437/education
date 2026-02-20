<?php

function connect()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "edu2";
    try {
        $connect = new PDO(
            "mysql:host=$servername;dbname=$dbname",
            $username,
            $password,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
        );
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // ตั้งค่า max_allowed_packet เป็น 64MB
        $connect->exec("SET GLOBAL max_allowed_packet = 67108864;");

        return $connect; // Return connection object
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
}

function importSQLFilesFromZip($zipFilePath, $dbConnection)
{
    $extractTo = __DIR__ . '/extracted_sql'; // Directory to extract files
    if (!file_exists($extractTo)) {
        mkdir($extractTo, 0777, true); // Create directory if not exists
    }

    $zip = new ZipArchive();
    if ($zip->open($zipFilePath) === true) {
        $zip->extractTo($extractTo); // Extract the zip file
        $zip->close();
        echo "Zip extracted successfully.<br>";

        $sqlFiles = glob($extractTo . '/*.sql'); // Get all .sql files
        if (empty($sqlFiles)) {
            echo "No SQL files found in the zip.<br>";
            return;
        }

        try {
            // Disable foreign key checks
            $dbConnection->exec("SET FOREIGN_KEY_CHECKS=0;");

            foreach ($sqlFiles as $file) {
                try {
                    $fileSc = htmlspecialchars($file, ENT_QUOTES, 'UTF-8');
                    $sql = file_get_contents($fileSc); // Read the SQL file content
                    $dbConnection->exec($sql); // Execute the SQL commands
                    echo "Imported: " . basename($file) . "<br>";
                } catch (PDOException $e) {
                    echo "Failed to import " . basename($file) . ": " . $e->getMessage() . "<br>";
                }
            }

            // Enable foreign key checks
            // $dbConnection->exec("SET FOREIGN_KEY_CHECKS=1;");
        } catch (PDOException $e) {
            echo "Error setting foreign key checks: " . $e->getMessage() . "<br>";
        }

        // Cleanup: Remove extracted files
        array_map('unlink', glob($extractTo . '/*.*'));
        rmdir($extractTo);
    } else {
        echo "Failed to open the zip file.<br>";
    }
}
$zipFilePath = __DIR__ . '/backups/backup-2025-05-31-05-04.zip'; // Path to your zip file
$dbConnection = connect(); // Connect to database
if ($dbConnection) {
    importSQLFilesFromZip($zipFilePath, $dbConnection); // Import SQL files
}
