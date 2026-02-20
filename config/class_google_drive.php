<?php
date_default_timezone_set('Asia/Bangkok');
class GoogleDriveAPI
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $accessToken;
    private $refreshToken;
    private $tokenExpiry; // เพิ่มตัวแปรเพื่อเก็บเวลาหมดอายุของ access_token

    public function __construct($clientId = "", $clientSecret = "", $redirectUri = "")
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
    }

    // ฟังก์ชันสร้าง URL เพื่อให้ผู้ใช้อนุญาต
    public function getAuthUrl($scopes = ['https://www.googleapis.com/auth/drive.file'])
    {
        $scope = implode(' ', $scopes);
        return "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'scope' => $scope,
            'access_type' => 'offline',
            'prompt' => 'consent'
        ]);
    }

    public function setAccessToken($token)
    {
        $this->accessToken = $token;
    }

    public function setRefreshToken($token)
    {
        $this->refreshToken = $token;
    }

    // เพิ่ม method เพื่อดึง refresh_token
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    // ฟังก์ชันดึง access_token (ตรวจสอบหมดอายุและรีเฟรชอัตโนมัติ)
    public function getValidAccessToken()
    {
        return $this->refreshAccessToken();
    }

    // ฟังก์ชันแลกเปลี่ยน Authorization Code เป็น Access Token
    public function getAccessTokenFromCode($authorizationCode)
    {
        $url = "https://oauth2.googleapis.com/token";
        $data = [
            'code' => $authorizationCode,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code',
        ];

        $response = $this->makePostRequest($url, $data);

        if (isset($response['access_token'])) {
            $this->accessToken = $response['access_token'];
            $this->refreshToken = $response['refresh_token'] ?? $this->refreshToken;
            $this->tokenExpiry = time() + ($response['expires_in'] ?? 3600);
        } else {
            throw new Exception("Failed to get access token: " . json_encode($response));
        }

        return $response;
    }

    // ฟังก์ชันใช้ Refresh Token เพื่อรับ Access Token ใหม่
    public function refreshAccessToken($mainFunc = null)
    {
        if (!$this->refreshToken) {
            return ["url" => $this->redirectToAuth(), "status" => false];
        }

        $url = "https://oauth2.googleapis.com/token";
        $data = [
            'refresh_token' => $this->refreshToken,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
        ];

        $response = $this->makePostRequest($url, $data);


        if (isset($response['error'])) {
            if ($response['error'] === 'invalid_grant' || strpos($response['error_description'] ?? '', 'revoked') !== false) {
                return ["url" => $this->redirectToAuth(), "status" => false]; // ถ้า refresh_token ถูก revoke ให้ขอใหม่
            }
            throw new Exception("Refresh token failed: " . json_encode($response));
        }

        if (isset($response['access_token'])) {
            $this->accessToken = $response['access_token'];
            $this->tokenExpiry = time() + ($response['expires_in'] ?? 3600);
            $this->refreshToken = $response['refresh_token'] ?? $this->refreshToken; // อัปเดต refresh_token ถ้ามี
        } else {
            throw new Exception("No access token in response: " . json_encode($response));
        }

        return $response;
    }

    // ฟังก์ชัน redirect ไปหน้า OAuth เมื่อ token ไม่ใช้ได้
    private function redirectToAuth()
    {
        $authUrl = $this->getAuthUrl();
        return $authUrl;
    }

    // ปรับปรุงฟังก์ชัน uploadFile ให้ใช้ access_token ที่ถูกต้อง
    public function uploadFile($filePath, $fileName = null, $mimeType = 'application/octet-stream', $folderId = null)
    {
        $this->getValidAccessToken(); // ตรวจสอบและรีเฟรช token ก่อนใช้งาน

        $url = "https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart";
        $boundary = uniqid();
        $delimiter = "--$boundary";

        $fileMetadata = ['name' => $fileName ?: basename($filePath)];
        if ($folderId) {
            $fileMetadata['parents'] = [$folderId];
        }

        $fileMetadataJson = json_encode($fileMetadata);
        $fileData = file_get_contents($filePath);

        $body = "$delimiter\r\nContent-Type: application/json; charset=UTF-8\r\n\r\n$fileMetadataJson\r\n$delimiter\r\nContent-Type: $mimeType\r\n\r\n$fileData\r\n$delimiter--";

        $headers = [
            "Authorization: Bearer {$this->accessToken}",
            "Content-Type: multipart/related; boundary=$boundary",
            "Content-Length: " . strlen($body),
        ];

        return $this->makePostRequest($url, $body, $headers);
    }

    // ปรับปรุงฟังก์ชัน downloadFile
    public function downloadFile($fileId, $savePath)
    {
        $this->getValidAccessToken(); // ตรวจสอบและรีเฟรช token

        $url = "https://www.googleapis.com/drive/v3/files/$fileId?alt=media";
        $headers = ["Authorization: Bearer {$this->accessToken}"];

        $response = $this->makeGetRequest($url, $headers);
        if ($response) {
            file_put_contents($savePath, $response);
            return true;
        }
        return false;
    }

    // ปรับปรุงฟังก์ชัน deleteFile
    public function deleteFile($fileId)
    {
        $this->getValidAccessToken(); // ตรวจสอบและรีเฟรช token

        $url = "https://www.googleapis.com/drive/v3/files/$fileId";
        $headers = ["Authorization: Bearer {$this->accessToken}"];

        return $this->makeDeleteRequest($url, $headers);
    }

    // ปรับปรุงฟังก์ชัน makeGetRequest
    private function makeGetRequest($url, $headers = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 401) { // ถ้า token หมดอายุหรือไม่ถูกต้อง
            $this->refreshAccessToken();
            return $this->makeGetRequest($url, $headers); // ลองใหม่
        }

        return $response;
    }

    // ปรับปรุงฟังก์ชัน makePostRequest
    private function makePostRequest($url, $data, $headers = ['Content-Type: application/x-www-form-urlencoded'])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, is_array($data) ? http_build_query($data) : $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 401) { // ถ้า token หมดอายุหรือไม่ถูกต้อง
            $this->refreshAccessToken();
            return $this->makePostRequest($url, $data, $headers); // ลองใหม่
        }

        return json_decode($response, true);
    }

    // ปรับปรุงฟังก์ชัน makeDeleteRequest
    private function makeDeleteRequest($url, $headers = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 401) { // ถ้า token หมดอายุหรือไม่ถูกต้อง
            $this->refreshAccessToken();
            return $this->makeDeleteRequest($url, $headers); // ลองใหม่
        }

        return json_decode($response, true);
    }

    // ปรับปรุงฟังก์ชัน uploadFolder
    public function uploadFolder($db, $folderPath, $folderId, $table, $table_id, $f_id, $maxUploads = 100)
    {
        $uploadedFileIds = [];
        $counter = 0;
        $errors = [];
        $status = true;

        ob_implicit_flush(true);
        ob_end_flush();

        // Create backup folder name (original path + "-bk" + current date)
        $backupFolder = $folderPath . '-bk-' . date('Y-m-d');

        // Create backup folder if it does not exist
        if (!is_dir($backupFolder)) {
            if (!mkdir($backupFolder, 0777, true)) {
                $status = false;
                $errors[] = "Failed to create backup folder: $backupFolder";
                return json_encode(["status" => $status, "message" => "Failed to create backup folder", "errors" => $errors]);
            }
        }

        if (is_dir($folderPath)) {
            $files = scandir($folderPath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $filePath = "$folderPath/$file";
                    $backupFilePath = "$backupFolder/$file";

                    // Upload to Google Drive
                    $fileName = $file;
                    // Get MIME type based on file extension
                    $mimeType = $this->getMimeType($filePath);

                    // Check if file exists in the database
                    $sql = "SELECT * FROM $table WHERE $f_id = ?";
                    $data = $db->Query($sql, [$file]);
                    $data = json_decode($data);

                    if (!empty($data)) {
                        $response = $this->uploadFile($filePath, $fileName, $mimeType, $folderId);
                        if (isset($response['id'])) {
                            // Move file to backup folder
                            if (!copy($filePath, $backupFilePath)) {
                                $errors[] = "Failed to backup file: $filePath";
                                continue; // Skip upload if backup fails
                            }
                            $uploadedFileIds[] = [
                                "drive_id" => $response['id'],
                                "table_id" => $data[0]->$table_id,
                                "filePath" => $filePath
                            ];
                        } else {
                            $errors[] = "Failed to upload file: $file - " . json_encode($response);
                        }
                    } else {
                        $errors[] = "No matching record found and deleted file: $file";
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }

                    $counter++;
                    // Check if the upload limit has been reached
                    if ($counter >= $maxUploads) {
                        break; // Stop uploading if limit is reached
                    }

                    if ($counter % 100 === 0) {
                        sleep(5);
                    }
                    flush();
                }
            }
        } else {
            $status = false;
            $errors[] = "Not a directory: $folderPath";
        }

        return [
            "status" => $status,
            "message" => $status ? "Upload process completed." : "Upload encountered errors.",
            "uploaded_files" => $uploadedFileIds,
            "errors" => $errors
        ];
    }


    private function getMimeType($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Common MIME types
        $mimeTypes = [
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls'  => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt'  => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'txt'  => 'text/plain',
            'csv'  => 'text/csv',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'zip'  => 'application/zip',
            'rar'  => 'application/x-rar-compressed',
            'mp3'  => 'audio/mpeg',
            'mp4'  => 'video/mp4',
            'avi'  => 'video/x-msvideo',
            'mov'  => 'video/quicktime',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream'; // Default to binary stream if unknown
    }


    // ปรับปรุงฟังก์ชัน setFilePublic
    public function setFilePublic($fileId)
    {
        $this->getValidAccessToken(); // ตรวจสอบและรีเฟรช token

        $url = "https://www.googleapis.com/drive/v3/files/$fileId/permissions";
        $data = json_encode(['role' => 'reader', 'type' => 'anyone']);
        $headers = [
            "Authorization: Bearer {$this->accessToken}",
            "Content-Type: application/json",
        ];

        return $this->makePostRequest($url, $data, $headers);
    }
}
