<?php
session_start();
if (!isset($_SESSION["user_data"])) {
  Header("Location: ../login");
}
require_once('../../assets/TCPDF/tcpdf.php');
include "../../config/class_database.php";

$DB = new Class_Database();

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$std_p_id = htmlentities($_GET['form_std_p_id']);
$sql = "SELECT
	*,
	edu.name AS edu_name
FROM
	stf_tb_form_student_person sp
	LEFT JOIN tb_students s ON sp.std_id = s.std_id
	LEFT JOIN tb_users u ON s.user_create = u.id
	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id WHERE sp.std_p_id = :std_p_id";

$data = $DB->Query($sql, ['std_p_id' => $std_p_id]);
$dataStdPerson = json_decode($data);

if (count($dataStdPerson) == 0) {
	header('location: ../404');
	exit();
}

$fullname = $dataStdPerson[0]->std_prename.$dataStdPerson[0]->std_name;

$fullnameTitle = 'ข้อมูลนักศึกษารายบุคคล - ' . $fullname;
$pdf->SetTitle($fullnameTitle);
$border_bottom = array(
	'B' => array('width' => 0.2, 'cap' => 'butt', 'dash' => 1, 'color' => array(0, 0, 0)),
);


$pdf->SetCreator(PDF_CREATOR);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->SetMargins(10, 3, 10, false);

//a----


$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->SetMargins(10, 3, 10, false);


$pdf->AddPage();

$pdf->SetFont('thsarabun', '', 12);
$pdf->Cell(185, 0, "แบบ ด.ล. 1.1 ", 0, 1, 'R');

$pdf->SetFont('thsarabun', 'B', 16);
$pdf->Cell(185, 0, "ข้อมูลนักศึกษารายบุคคล", 0, 1, 'C');
$pdf->Cell(185, 0, "", 0, 1, 'C');
$pdf->SetFont('thsarabun', '', 16);

$pdf->Cell(17, 8, "1. ชื่อ-สกุล ", 0, 0, 'L');
$pdf->Cell(73, 0, "  " .$dataStdPerson[0]->std_prename.$dataStdPerson[0]->std_name, $border_bottom, 0, 'L');
$pdf->Cell(8, 8, "ชั้น", 0, 0, 'L');
$pdf->Cell(25, 0, $dataStdPerson[0]->std_class, $border_bottom, 0, 'L');
$pdf->Cell(20, 8, "รหัสนักศึกษา", 0, 0, 'L');
$pdf->Cell(47, 0, "  " . $dataStdPerson[0]->std_code, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(25, 0, "2. บิดา ชื่อ-สกุล", 0, 0, 'L');
$pdf->Cell(70, 0, "  " . $dataStdPerson[0]->std_father_name, $border_bottom, 0, 'L');
$pdf->Cell(12, 0, " อาชีพ", 0, 0, 'L');
$pdf->Cell(83, 0, $dataStdPerson[0]->std_father_job, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(30, 0, "3. มารดา ชื่อ-สกุล", 0, 0, 'L');
$pdf->Cell(70, 0, "  " . $dataStdPerson[0]->std_mather_name, $border_bottom, 0, 'L');
$pdf->Cell(12, 0, " อาชีพ", 0, 0, 'L');
$pdf->Cell(78, 0, $dataStdPerson[0]->std_mather_job, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(25, 0, " เบอร์โทรศัพท์", 0, 0, 'L');
$pdf->Cell(30, 0, $dataStdPerson[0]->phone, $border_bottom, 0, 'L');
$pdf->Cell(10, 0, " ที่อยู่", 0, 0, 'L');
$pdf->Cell(125, 0, $dataStdPerson[0]->address, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(30, 0, "4. นักศึกษามีพี่น้อง", 0, 0, 'L');
$pdf->Cell(30, 0, $dataStdPerson[0]->num_siblings . " คน", $border_bottom, 0, 'L');
$pdf->Cell(10, 0, "มีน้อง", 0, 0, 'L');
$pdf->Cell(30, 0, $dataStdPerson[0]->num_younger . " คน", $border_bottom, 0, 'L');
$pdf->Cell(35, 0, "นักศึกษาเป็นบุตรคนที่", 0, 0, 'L');
$pdf->Cell(55, 0, $dataStdPerson[0]->num_son . " ", $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(60, 0, "ความสัมพันธ์ระหว่างนักศึกษากับพี่น้อง", 0, 0, 'L');
$pdf->Cell(130, 0, $dataStdPerson[0]->relation, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(12, 0, "5. ชีวิตปัจจุบันอาศัยอยู่กับ", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->live_present, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(185, 0, "6. ความรู้สึกที่นักศึกษามีต่อตนเอง", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->feel_me, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(185, 0, "7. เพื่อนที่สนิทที่สุดของนักศึกษา (ชื่อ-สกุล)", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->best_friend_name, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(185, 0, "8. สิ่งที่นักศึกษาอยากได้จากคนรอบข้าง (พ่อ แม่ พี่ น้อง เพื่อน ฯลฯ)", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->want_around_people, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(185, 0, "9. สิ่งที่นักศึกษากลัวเวลาอยู่ร่วมกับผู้อื่น", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->afraid_others, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(185, 0, "10. สิ่งที่นักศึกษาชอบ / พอใจเกี่ยวกับตัวเอง", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->life_myseft, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(185, 0, "11. สิ่งที่นักศึกษาไม่ชอบที่เกี่ยวกับตัวเอง", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->not_life_myseft, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(185, 0, "12. สิ่งที่นักศึกษาอยากปรับปรุง / แก้ไขตนเอง", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->want_improve, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(185, 0, "13. ความภาคภูมิใจ / ความสำเร็จของนักศึกษา", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->pride, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(185, 0, "14. เหตุการณ์ที่นักศึกษาประทับใจมากที่สุด", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->impressive_event, $border_bottom, 1, 'L');
$pdf->Ln(2);

$pdf->Cell(185, 0, "15. ขณะนี้นักศึกษาไม่สบายใจในเรื่องอะไร", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->uneasy, $border_bottom, 1, 'L');
$pdf->Ln(2);

$pdf->Cell(185, 0, "16. บุคคลที่นักศึกษาวางใจอยากปรึกษาปัญหาต่างๆ", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->person_discuss_problems, $border_bottom, 1, 'L');
$pdf->Ln(2);

$pdf->Cell(185, 0, "17. กิจกรรมยามว่างที่นักศึกษาชอบทำ", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->activity, $border_bottom, 1, 'L');
$pdf->Ln(30);
$pdf->Cell(185, 0, "", 0, 1, 'L');

$pdf->Cell(50, 0, "18. นักศึกษาได้เงินโรงเรียนวันละ", 0, 0, 'L');
$pdf->Cell(30, 0, $dataStdPerson[0]->money_per_day . " บาท", $border_bottom, 0, 'L');
$pdf->Cell(30, 0, "ส่วนใหญ่ใช้เกี่ยวกับ", 0, 0, 'L');
$pdf->Cell(80, 0, $dataStdPerson[0]->use_money_per_day, $border_bottom, 1, 'L');
$pdf->Ln(2);

$pdf->Cell(185, 0, "19. นักศึกษาเสียใจเกี่ยวกับการกระทำเรื่องใดมากที่สุด", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->action_regret, $border_bottom, 1, 'L');
$pdf->Ln(2);

$pdf->Cell(185, 0, "20. ความรู้สึกของนักศึกษาที่มีต่อโรงเรียนและครู", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->feel_for_school_and_teacher, $border_bottom, 1, 'L');
$pdf->Ln(2);

$pdf->Cell(50, 0, "21. ผลการเรียนของนักศึกษา คือ", 0, 0, 'L');
$pdf->Cell(30, 0, $dataStdPerson[0]->gpa, $border_bottom, 0, 'L');
$pdf->Cell(25, 0, "วิชาที่ชอบ คือ", 0, 0, 'L');
$pdf->Cell(85, 0, $dataStdPerson[0]->favorite_subject, $border_bottom, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(25, 0, " วิชาที่ไม่ชอบ คือ", 0, 0, 'L');
$pdf->Cell(160, 0, "  " . $dataStdPerson[0]->not_favorite_subject, $border_bottom, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(20, 0, " เพราะเหตุใด", 0, 0, 'L');
$pdf->Cell(165, 0, "  " . $dataStdPerson[0]->reason_not_favorite_subject, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(185, 0, "22. ปัญหาด้านสุขภาพ", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, $dataStdPerson[0]->health_problems, $border_bottom, 1, 'L');

// $pdf->Cell(185, 0, "", 0, 1, 'C');
// $pdf->Cell(185, 3, "", 0, 1, 'C');
// $pdf->Cell(185, 3, "", 0, 1, 'C');
// $pdf->Cell(185, 0, "ลงชื่อ.............................................................ผู้กรอกข้อมูล", 0, 1, 'R');
// $pdf->Cell(185, 0, "วันที่.......................เดือน.............................................พ.ศ........................", 0, 1, 'R');






$pdf->Output('ข้อมูลนักศึกษารายบุคคล - ' . $fullname . '.pdf', 'I');
$pdf->Close();
