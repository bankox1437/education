<?php

include("config/main_function.php");
include "config/class_database.php";
$main_func = new ClassMainFunctions();
$DB = new Class_Database();

$pass = isset($_GET['pass']) ? $main_func->decryptData($_GET['pass']) : 'no data';
echo "<form acton='' method='GET'><input type='text' name='pass'><button type='submit'>decrypt</button></form>";
echo "decrypt data => " . !isset($_GET['pass']) ? $pass : $main_func->decryptData($pass) . "<br>";

function splitAndFilter($text)
{
    // Use preg_split with pattern to handle multiple spaces
    $parts = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

    // Trim each part to remove leading and trailing spaces
    $trimmedParts = array_map('trim', $parts);

    return $trimmedParts;
}

$pass = isset($_GET['enpass']) ? $main_func->encryptData($_GET['enpass']) : 'no data';
echo "<br><br><form acton='' method='GET'><input type='text' name='enpass'><button type='submit'>encrypt</button></form>";
echo "decrypt data => " . !isset($_GET['enpass']) ? $pass : $main_func->decryptData($pass) . "<br>";

// $sql = "SELECT * FROM `tb_users`\n" .
//     "WHERE surname = '' limit 200";
// $data_query = $DB->Query($sql, []);
// $data = json_decode($data_query);

// $arr = [];
// foreach ($data as $key => $value) {
//     array_push($arr, $value->edu_type);
//     $sql = "SELECT std_name FROM `tb_students`\n" .
//         "WHERE std_id = :std_id";
//     $data_query = $DB->Query($sql, ["std_id" => $value->edu_type]);
//     $data = json_decode($data_query);

// echo "<pre>";
// print_r($data[0]->std_name);
// echo "</pre>";
// echo $value->edu_type . " name = " . $value->name . "-" . $value->surname . "<br>";
// echo $value->edu_type . " name = " . $data[0]->std_name . "<br>";

// $newName = splitAndFilter($data[0]->std_name);
// echo $value->edu_type . " name = " . $newName[0] . "-" . $newName[1] .  "<br>";

// // $sql = "update tb_users set surname = '" . $newName[1] . "' where edu_type = " . $value->edu_type;
// // echo "<br>" . $updateStatus = $DB->Update($sql, []);
// echo "--------------------------------------------------------<br>";
// }
// echo count($arr);
// echo "<pre>";
// print_r($arr);
// echo "</pre>";
// echo "(";
// for ($i = 0; $i < count($arr); $i++) {
//     echo $arr[$i] . ",";
// }
// echo ")";

// $data = json_decode('{"std_code":6423012000,"std_prename":"\u0e19\u0e32\u0e22","std_name":"\u0e23\u0e31\u0e15\u0e19\u0e0a\u0e31\u0e22 \u0e1e\u0e31\u0e19\u0e18\u0e07","std_gender":"","std_class":"\u0e21.\u0e1b\u0e25\u0e32\u0e22","std_birthday":"25 \u0e21\u0e35\u0e19\u0e32\u0e04\u0e21 2543","std_father_name":"","std_father_job":"","std_mather_name":"","std_mather_job":"","phone":"","address":"","national_id":"1169800210935","user_create":"74891"}', true, 512, JSON_UNESCAPED_UNICODE);

// $data2 = json_decode('{"name":"\u0e17\u0e14\u0e2a\u0e2d\u0e1a\u0e23\u0e30\u0e1a\u0e1a","surname":"\u0e19\u0e34\u0e40\u0e17\u0e28","username":"nitas","password":"mwDq8RpM3W9d8IPH2AG6llopaVZJ5kTxUIk4mQnohqo=","edu_id":0,"edu_type":"amphur","role_id":"2","user_create":"56119","district":"\u0e40\u0e21\u0e37\u0e2d\u0e07\u0e25\u0e1e\u0e1a\u0e38\u0e23\u0e35","province":"\u0e25\u0e1e\u0e1a\u0e38\u0e23\u0e35","district_id":"97","province_id":"7","status":"{\"std_tracking\":1,\"view_grade\":0,\"visit_online\":1,\"search\":0,\"see_people\":0,\"reading\":0,\"after\":1,\"estimate\":0,\"dashboard\":1,\"calendar_new\":0,\"teach_more\":0,\"guide\":0}"}', true, 512, JSON_UNESCAPED_UNICODE);


// $data3 = json_decode('{"name":"\u0e41\u0e2d\u0e14\u0e21\u0e34\u0e19","surname":"\u0e23\u0e30\u0e14\u0e31\u0e1a\u0e2d\u0e33\u0e40\u0e20\u0e2d\u0e40\u0e21\u0e37\u0e2d\u0e07\u0e25\u0e1e\u0e1a\u0e38\u0e23\u0e35","username":"adminlop","password":"p4fvyXlu87EW9xNhbDalDi5eLAKI7wEi3kxOVnxoeys=","edu_id":0,"edu_type":"amphur","role_id":"2","user_create":"56119","district":"\u0e40\u0e21\u0e37\u0e2d\u0e07\u0e25\u0e1e\u0e1a\u0e38\u0e23\u0e35","province":"\u0e25\u0e1e\u0e1a\u0e38\u0e23\u0e35","district_id":"97","province_id":"7","status":"{\"std_tracking\":1,\"view_grade\":1,\"visit_online\":1,\"search\":1,\"see_people\":1,\"reading\":1,\"after\":1,\"estimate\":1,\"dashboard\":1,\"calendar_new\":1,\"teach_more\":1,\"guide\":0}"}
// ', true, 512, JSON_UNESCAPED_UNICODE);

// echo "<pre>";
// print_r($data);
// print_r($data2);
// print_r($data3);
// echo "</pre>";
