<?php
// สร้าง array ของข้อมูล 10 คน
$studentData = array(
    array("concat_name" => "John Doe", "class" => "ม.ปลาย", "year" => "2566", "recorder" => "พิมพ์ชนก สมใจ", "sub_district" => "แสนสุข", "district" => "เมืองสมุทรปราการ", "porvince" => "สมุทรปราการ"),
    array("concat_name" => "Jane Smith", "class" => "ม.3", "year" => "2570", "recorder" => "อรทัย ชื่นใจ", "sub_district" => "สามเสนใน", "district" => "พญาไท", "porvince" => "กรุงเทพมหานคร"),
    array("concat_name" => "Michael Johnson", "class" => "ม.6", "year" => "2567", "recorder" => "ศุภชัย ศรีสุข", "sub_district" => "หนองบัว", "district" => "หนองบัวลำภู", "porvince" => "ชัยภูมิ"),
    array("concat_name" => "Emily Williams", "class" => "ม.2", "year" => "2572", "recorder" => "สุรพงศ์ สมบัติ", "sub_district" => "สำนักขุนเณร", "district" => "บางระกำ", "porvince" => "อุบลราชธานี"),
    array("concat_name" => "Robert Brown", "class" => "ม.4", "year" => "2569", "recorder" => "ณัฐวุฒิ สมสวย", "sub_district" => "พังโคน", "district" => "ป่าติ้ว", "porvince" => "กาฬสินธุ์"),
    array("concat_name" => "Sophia Lee", "class" => "ม.5", "year" => "2568", "recorder" => "พิศิษฐ์ สมบูรณ์", "sub_district" => "ลำภูรา", "district" => "ลำภู", "porvince" => "เชียงใหม่"),
    array("concat_name" => "William Wang", "class" => "ม.1", "year" => "2574", "recorder" => "สิรภัทร สมควร", "sub_district" => "วัดโบสถ์", "district" => "เมืองพิษณุโลก", "porvince" => "พิษณุโลก"),
    array("concat_name" => "Olivia Kim", "class" => "ม.3", "year" => "2573", "recorder" => "ชานนท์ สมหมาย", "sub_district" => "หนองบัว", "district" => "หนองบัวลำภู", "porvince" => "ชัยภูมิ"),
    array("concat_name" => "James Lee", "class" => "ม.2", "year" => "2571", "recorder" => "ณรงค์ สมสวย", "sub_district" => "ลำภูรา", "district" => "ลำภู", "porvince" => "เชียงใหม่"),
    array("concat_name" => "Ava Nguyen", "class" => "ม.5", "year" => "2572", "recorder" => "ปฏิมากร สมหมาย", "sub_district" => "แสนสุข", "district" => "เมืองสมุทรปราการ", "porvince" => "สมุทรปราการ")
);

// แสดงผลข้อมูลใน array
foreach ($studentData as $student) {
    echo "ชื่อ-สกุล: " . $student["ชื่อ-สกุล"] . ", ชั้น: " . $student["ชั้น"] . ", ปีการศึกษา: " . $student["ปีการศึกษา"]."<br>";
}
?>