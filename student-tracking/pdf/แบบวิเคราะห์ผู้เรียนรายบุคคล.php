<?php
// session_start();
// if (!isset($_SESSION["user_data"])) {
//     Header("Location: ../login");
// }
require_once('../../assets/TCPDF/tcpdf.php');
include "../../config/class_database.php";

$DB = new Class_Database();
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetTitle("แบบวิเคราะห์ผู้เรียนรายบุคคล");
$border_bottom = array(
	'B' => array('width' => 0.2, 'cap' => 'butt', 'dash' => 1, 'color' => array(0, 0, 0)),
);

// $std_per_id = htmlentities($_GET['std_per_id']);
$std_per_id = $_GET['std_per_id'];

$sql = "SELECT\n" .
	"	*,sp.phone sp_phone \n" .
	"FROM\n" .
	"	stf_tb_form_student_person_new sp\n" .
	"	LEFT JOIN tb_students s ON sp.std_id = s.std_id\n" .
	"	LEFT JOIN tb_users u ON s.user_create = u.id\n" .
	"	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id \n" .
	"WHERE\n" .
	"	sp.std_per_id = :std_per_id";
$data = $DB->Query($sql, ['std_per_id' => $std_per_id]);
$dataStdPerson = json_decode($data);

// set document information
$pdf->SetCreator(PDF_CREATOR);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetMargins(10, 3, 10, false);

$pdf->AddPage();
$pdf->SetFont('thsarabun', 'B', 16);

$pdf->Ln(9); //เว้นบรรทัด
$pdf->Cell(180, 5, "แบบวิเคราะห์ผู้เรียนรายบุคคล", 0, 1, 'C');
// $pdf->Cell(180, 5, "หลักสูตรการศึกษานอกระบบระดับการศึกษาขั้นพื้นฐาน พุทธศักราช 2551", 0, 1, 'C');
// $pdf->Cell(180, 5, "ภาคเรียนที่ 1 ปีการศึกษา 2566", 0, 1, 'C');
// $pdf->Cell(180, 5, "กศน.ตำบลบางแก้วฟ้า อำเภอนครชัยศรี จังหวัด นครปฐม", 0, 1, 'C');
$pdf->Cell(180, 5, "--------------------------------------------------------------------------------------------------------------------------", 0, 1, 'C');
// $pdf->SetFont('thsarabun', '', 14);
// $pdf->Cell(180, 5, "ระดับการศึกษา ( )  ประถมศึกษา ( )  มัธยมศึกษาตอนต้น ( )  มัธยมศึกษาตอนปลาย", 0, 1, 'C');
$pdf->SetFont('thsarabun', 'B', 14);
$pdf->Ln(2); //เว้นบรรทัด
$pdf->Cell(180, 5, "1. ข้อมูลพื้นฐาน", 0, 1, 'L');
$pdf->SetFont('thsarabun', '', 14);
$pdf->Cell(22, 6, "    1.1 ชื่อ-สกุล", 0, 0, 'L');
$pdf->Cell(80, 6, $dataStdPerson[0]->std_prename . $dataStdPerson[0]->std_name, $border_bottom, 0, 'L');
$pdf->Cell(11, 6, "ชื่อเล่น", 0, 0, 'L');
$pdf->Cell(30, 6, $dataStdPerson[0]->nickname, $border_bottom, 0, 'C');
$pdf->Cell(9, 6, "อายุ ", 0, 0, 'L');
$pdf->Cell(20, 6, calculateAge($dataStdPerson[0]->std_birthday), $border_bottom, 0, 'C');
$pdf->Cell(8, 6, "ปี ", 0, 1, 'L');

$pdf->Cell(32, 6, "         วัน/เดือน/ปีเกิด", 0, 0, 'L');
$pdf->Cell(70, 6, $dataStdPerson[0]->std_birthday, $border_bottom, 1, 'L');

$pdf->Cell(42, 6, "    1.2 อาศัยอยู่กับ", 0, 0, 'L');
$pdf->Cell(35, 6, $dataStdPerson[0]->address_who, $border_bottom, 0, 'L');
$pdf->Cell(14, 6, "บ้านเลขที่", 0, 0, 'L');
$pdf->Cell(20, 6, $dataStdPerson[0]->number_home, $border_bottom, 0, 'C');
$pdf->Cell(8, 6, "หมู่ที่ ", 0, 0, 'L');
$pdf->Cell(10, 6, $dataStdPerson[0]->moo, $border_bottom, 0, 'C');
$pdf->Cell(9, 6, "ตำบล ", 0, 0, 'L');
$pdf->Cell(48, 6, $dataStdPerson[0]->sub_district, $border_bottom, 1, 'L');

$pdf->Cell(20, 6, "         อำเภอ", 0, 0, 'L');
$pdf->Cell(50, 6, $dataStdPerson[0]->district, $border_bottom, 0, 'L');
$pdf->Cell(10, 6, "จังหวัด", 0, 0, 'L');
$pdf->Cell(50, 6, $dataStdPerson[0]->province, $border_bottom, 0, 'L');
$pdf->Cell(25, 6, "หมายเลขโทรศัพท์", 0, 0, 'L');
$pdf->Cell(30, 6, $dataStdPerson[0]->sp_phone, $border_bottom, 1, 'L');

$pdf->Cell(45, 6, "    1.3 ข้อมูลด้านสุขภาพ  น้ำหนัก", 0, 0, 'L');
// $pdf->Cell(12, 6, "น้ำหนัก", 0, 0, 'L');
$pdf->Cell(20, 6, $dataStdPerson[0]->weight, $border_bottom, 0, 'C');
$pdf->Cell(12, 6, "กิโลกรัม", 0, 0, 'L');
$pdf->Cell(12, 6, " ส่วนสูง", 0, 0, 'L');
$pdf->Cell(20, 6, $dataStdPerson[0]->height, $border_bottom, 0, 'C');
$pdf->Cell(12, 6, "เซนติเมตร", 0, 1, 'L');

$pdf->Cell(22, 6, "         หมู่โลหิต", 0, 0, 'L');
$pdf->Cell(10, 6, $dataStdPerson[0]->blood_group, $border_bottom, 0, 'L');
$pdf->Cell(19, 6, "โรคประจำตัว", 0, 0, 'L');
$pdf->Cell(40, 6, $dataStdPerson[0]->disease, $border_bottom, 0, 'L');
$pdf->Cell(34, 6, "ประวัติการแพ้ยา/อาการ", 0, 0, 'L');
$pdf->Cell(60, 6, $dataStdPerson[0]->drug_allergy, $border_bottom, 1, 'L');

$pdf->Cell(31, 6, "    1.4 วิชาที่ชอบ    1.", 0, 0, 'L');
$pdf->Cell(74.5, 6, $dataStdPerson[0]->like_subject1, $border_bottom, 0, 'L');
$pdf->Cell(5, 6, "2.", 0, 0, 'L');
$pdf->Cell(74.5, 6, $dataStdPerson[0]->like_subject2, $border_bottom, 1, 'L');

$pdf->Cell(31, 6, "    1.5 วิชาที่ไม่ชอบ 1.", 0, 0, 'L');
$pdf->Cell(74.5, 6, $dataStdPerson[0]->dont_like_subject1, $border_bottom, 0, 'L');
$pdf->Cell(5, 6, "2. ", 0, 0, 'L');
$pdf->Cell(74.5, 6, $dataStdPerson[0]->dont_like_subject2, $border_bottom, 1, 'L');

$pdf->Cell(55, 6, "    1.6 ความสามารถพิเศษของผู้เรียน คือ ", 0, 0, 'L');
$pdf->Cell(130, 6, $dataStdPerson[0]->std_ability, $border_bottom, 1, 'L');

$pdf->Cell(55, 7, "    1.7 ผู้เรียนมีระบบ Internet หรือไม่", 0, 0, 'L');
$pdf->Cell(15, 7, $dataStdPerson[0]->have_internet == 1 ? "( / ) " . " มี" : "(  )" . " มี", 0, 0, 'L');
$pdf->Cell(15, 7, $dataStdPerson[0]->have_internet == 1 ? "(   ) " . " ไม่มี" : "( / )" . " ไม่มี", 0, 1, 'L');



$sqlp = "SELECT\n" .
	"	* \n" .
	"FROM\n" .
	"	stf_tb_program_of_student_person p\n" .
	"WHERE\n" .
	"	p.std_per_id = :std_per_id";
$data_p = $DB->Query($sqlp, ['std_per_id' => $std_per_id]);
$dataProgram = json_decode($data_p);
$text_program = "";
if (count($dataProgram) > 0) {
	$dataProgram = $dataProgram[0];
	$dataProgram->word == 1 ? $text_program .= "( / )  Word    " : $text_program .= "(   )  Word    ";
	$dataProgram->power_point == 1 ? $text_program .= "    ( / )  Power Point    " : $text_program .= "    (   )  Power Point    ";
	$dataProgram->excel == 1 ? $text_program .= "    ( / )  Excel    " : $text_program .= "    (   )  Excel    ";
} else {
	$text_program .= "(   )  Word    ";
	$text_program .= "    (   )  Power Point    ";
	$text_program .= "    (   )  Excel    ";
}

// $dataProgram->photoshop == 1 ? $text_program .= "    ( / )  Photoshop    " : $text_program .= "    (   )  Photoshop    ";

$pdf->Cell(180, 7, "    1.8 ผู้เรียนใช้โปรแกรม micro office ใดได้บ้าง (เลือกได้มากกว่า 1 ข้อ)", 0, 1, 'L');
$pdf->Cell(180, 7, "         " . $text_program, 0, 1, 'L');


$text1_9 = "";

$dataStdPerson[0]->use_device == 2 ? $text1_9 .= "( / )  สมาร์ทโฟน    " : $text1_9 .= "(   )  สมาร์ทโฟน    ";
$dataStdPerson[0]->use_device == 3 ? $text1_9 .= "( / )  คอมพิวเตอร์    " : $text1_9 .= "(   )  คอมพิวเตอร์    ";
$dataStdPerson[0]->use_device == 1 ? $text1_9 .= "( / )  ไม่มี    " : $text1_9 .= "(   )  ไม่มี    ";

$pdf->Cell(180, 7, "    1.9 ผู้เรียนมีอุปกรณ์ใดที่ที่ใช้ในการศึกษา ค้นคว้าข้อมูลทางการศึกษาผ่านอินเทอร์เน็ต", 0, 1, 'L');
$pdf->Cell(100, 7, "         " . $text1_9, 0, 1, 'L');

$text1_10 = "";
$dataStdPerson[0]->use_internet_more == 1 ? $text1_10 .= "( / )  ของตนเอง    " : $text1_10 .= "(   )  ของตนเอง    ";
$dataStdPerson[0]->use_internet_more == 2 ? $text1_10 .= "( / )  ห้องสมุด/สถานศึกษา    " : $text1_10 .= "(   )  ห้องสมุด/สถานศึกษา    ";
$dataStdPerson[0]->use_internet_more == 3 ? $text1_10 .= "( / )  ที่ทำงาน    " : $text1_10 .= "(   )  ที่ทำงาน    ";
$dataStdPerson[0]->use_internet_more == 4 ? $text1_10 .= "( / )  สาธารณะ    " : $text1_10 .= "(   )  สาธารณะ    ";
$pdf->Cell(180, 7, "    1.10 ผู้เรียนใช้สัณญาณ Internet จากแหล่งใดมากที่สุด", 0, 1, 'L');
$pdf->Cell(100, 7, "         " . $text1_10, 0, 1, 'L');

$text1_11 = "";
$dataStdPerson[0]->reason_edu == 1 ? $text1_11 .= "( / )  เพื่อศึกษาต่อ    " : $text1_11 .= "(   )  เพื่อศึกษาต่อ    ";
$dataStdPerson[0]->reason_edu == 2 ? $text1_11 .= "( / )  เพื่อปรับเงินเดือน    " : $text1_11 .= "(   )  เพื่อปรับเงินเดือน    ";
$dataStdPerson[0]->reason_edu == 3 ? $text1_11 .= "( / )  เพื่อให้มีเพื่อน/มีสังคม    " : $text1_11 .= "(   )  เพื่อให้มีเพื่อน/มีสังคม    ";
$dataStdPerson[0]->reason_edu == 4 ? $text1_11 .= "( / )  เพื่อให้มีงานทำ    " : $text1_11 .= "(   )  เพื่อให้มีงานทำ    ";
$pdf->Cell(180, 7, "    1.11 ท่านมาเรียน กศน. ด้วยเหตุผลใด", 0, 1, 'L');
$pdf->Cell(100, 7, "         " . $text1_11, 0, 1, 'L');

$text1_12_1 = "";
$text1_12_2 = "";
$dataStdPerson[0]->reason_learning_format == 1 ? $text1_12_1 .= "( / )  การพบกลุ่ม    " : $text1_12_1 .= "(   )  การพบกลุ่ม    ";
$dataStdPerson[0]->reason_learning_format == 2 ? $text1_12_1 .= "     ( / )  การศึกษาทางไกล    " : $text1_12_1 .= "     (   )  การศึกษาทางไกล    ";
$dataStdPerson[0]->reason_learning_format == 3 ? $text1_12_1 .= "   ( / )  การสอนแบบชั้นเรียน    " : $text1_12_1 .= "   (   )  การสอนแบบชั้นเรียน    ";
$dataStdPerson[0]->reason_learning_format == 4 ? $text1_12_2 .= "( / )  การทำโครงการ    " : $text1_12_2 .= "(   )  การทำโครงการ    ";
$dataStdPerson[0]->reason_learning_format == 5 ? $text1_12_2 .= "( / )  การเรียนรู้ด้วยตัวเอง    " : $text1_12_2 .= "(   )  การเรียนรู้ด้วยตัวเอง    ";
$dataStdPerson[0]->reason_learning_format != 1 && $dataStdPerson[0]->reason_learning_format != 2 &&
	$dataStdPerson[0]->reason_learning_format != 3 && $dataStdPerson[0]->reason_learning_format != 4 &&
	$dataStdPerson[0]->reason_learning_format != 5 ? $text1_12_2 .= "( / )  อื่นๆ    " : $text1_12_2 .= "(   )  อื่นๆ    ";

$space_12 = 1;
if (
	$dataStdPerson[0]->reason_learning_format != 1 && $dataStdPerson[0]->reason_learning_format != 2 &&
	$dataStdPerson[0]->reason_learning_format != 3 && $dataStdPerson[0]->reason_learning_format != 4 &&
	$dataStdPerson[0]->reason_learning_format != 5
) {
	$space_12 = 0;
}
$pdf->Cell(180, 7, "    1.12 ท่านคิดว่า กศน. ควรจัดการเรียนการสอนในรูปแบบใด มากที่ีสุด ", 0, 1, 'L');
$pdf->Cell(100, 7, "         " . $text1_12_1, 0, 1, 'L');
$pdf->Cell(100, 7, "         " . $text1_12_2, 0, $space_12, 'L');
if (
	$dataStdPerson[0]->reason_learning_format != 1 || $dataStdPerson[0]->reason_learning_format != 2 ||
	$dataStdPerson[0]->reason_learning_format != 3 || $dataStdPerson[0]->reason_learning_format != 4 ||
	$dataStdPerson[0]->reason_learning_format != 5
) {
	$pdf->Cell(88, 6, $dataStdPerson[0]->reason_learning_format_text, $border_bottom, 1, 'L');
}


$text_13_1 = "";
$text_13_2 = "";
$text_13_3 = "";
$text_13_4 = "";
$text_13_5 = "";
$dataStdPerson[0]->reason_process == 1 ? $text_13_1 .= "( / )" : $text_13_1 .= "(   )";
$dataStdPerson[0]->reason_process == 2 ? $text_13_2 .= "( / )" : $text_13_2 .= "(   )";
$dataStdPerson[0]->reason_process == 3 ? $text_13_3 .= "( / )" : $text_13_3 .= "(   )";
$dataStdPerson[0]->reason_process == 4 ? $text_13_4 .= "( / )" : $text_13_4 .= "(   )";
$dataStdPerson[0]->reason_process == 5 ? $text_13_5 .= "( / )" : $text_13_5 .= "(   )";
$pdf->Cell(180, 7, "    1.13 ท่านคิดส่า ควรมีการประเมินผลระหว่างภาคเรียน และปลสยภาคเรียนอย่างไร", 0, 1, 'L');
$pdf->Cell(16, 7, "         " . $text_13_1, 0, 0, 'L');
$pdf->Cell(120, 7, "ตัดสินปลายภาคเรียนครั้งเดียว 100 คะแนน", 0, 1, 'L');
$pdf->Cell(16, 7, "         " . $text_13_2, 0, 0, 'L');
$pdf->Cell(120, 7, "ระหว่างภาคเรียน 40 คะแนน และปลายภาคเรียน 60 คะแนน รวม 100 คะแนน", 0, 1, 'L');
$pdf->Cell(16, 7, "         " . $text_13_3, 0, 0, 'L');
$pdf->Cell(120, 7, "ระหว่างภาคเรียน 50 คะแนน และปลายภาคเรียน 50 คะแนน รวม 100 คะแนน", 0, 1, 'L');
$pdf->Cell(16, 7, "         " . $text_13_5, 0, 0, 'L');
$pdf->Cell(120, 7, "ระหว่างภาคเรียน 60 คะแนน และปลายภาคเรียน 40 คะแนน รวม 100 คะแนน", 0, 1, 'L');
$pdf->Cell(16, 7, "         " . $text_13_4, 0, 0, 'L');
$pdf->Cell(120, 7, "ระหว่างภาคเรียน 70 คะแนน และปลายภาคเรียน 30 คะแนน รวม 100 คะแนน", 0, 1, 'L');

$pdf->Cell(70, 7, "    1.14 ท่านมีความคาดหวังอะไรในการมาเรียน กศน. ", 0, 1, 'L');
// $pdf->Cell(10, 6, "         ", 0, 0, 'L');
// $pdf->Cell(177, 6, $dataStdPerson[0]->expectations, $border_bottom, 1, 'L');

$note = $dataStdPerson[0]->expectations ?? "";

if ($note != "") {
	$chunkSize = 127; // Set the desired chunk size

	for ($i = 0; $i < mb_strlen($note, 'UTF-8'); $i += $chunkSize) {
		$chunk = mb_substr($note, $i, $chunkSize, 'UTF-8');
		$pdf->Cell(10, 6, "         ", 0, 0, 'L');
		$pdf->Cell(177, 6, $chunk, $border_bottom, 1, 'L');
	}
} else {
	$pdf->Cell(10, 6, "         ", 0, 0, 'L');
	$pdf->Cell(177, 6, "-", $border_bottom, 1, 'L');
}


$learn_sql = "SELECT * FROM stf_tb_learn_analysis ls\n" .
	"WHERE ls.std_per_id = :std_per_id";
$result_learn = $DB->Query($learn_sql,  ['std_per_id' => $_GET['std_per_id']]);
$dataLearn = json_decode($result_learn);

if (count($dataLearn) > 0) {
	$dataLearn = $dataLearn[0];
	$learn_analys_id = $dataLearn->learn_analys_id;

	$pdf->AddPage();
	$pdf->Ln(5);
	$pdf->SetFont('thsarabun', 'B', 14);
	$pdf->Cell(180, 5, "2. การวิเคราะห์ผู้เรียน (ครูผู้สอนเป็นคนวิเคราะห์)", 0, 1, 'L');
	$pdf->SetFont('thsarabun', '', 14);
	$pdf->Ln(5); //เว้นบรรทัด
	$table = "<table width=\"100%\" border=\"0.5\">";
	$table .= "<tr>";
	$table .= "		<th width=\"10%\" rowspan=\"2\">ลำดับที่</th>";
	$table .= "		<th width=\"40%\" rowspan=\"2\"><b>รายการวิเคราะห์ผู้เรียน</b></th>";
	$table .= "		<th width=\"30%\" colspan=\"4\">ผลการวิเคราะห์ผู้เรียน</th>";
	$table .= "		<th width=\"20%\" rowspan=\"2\">สิ่งที่ควรปรับปรุง/แก้ไข</th>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<th>ดีมาก</th>";
	$table .= "		<th>ดี</th>";
	$table .= "		<th>ปานกลาง</th>";
	$table .= "		<th>ปรับปรุง</th>";
	$table .= "</tr>";

	$learn_1_sql = "SELECT * FROM stf_tb_learn_anlysis_side1\n" .
		"WHERE learn_analys_id = :learn_analys_id";
	$result_learn_1 = $DB->Query($learn_1_sql, ['learn_analys_id' => $learn_analys_id]);
	$dataLearn1 = json_decode($result_learn_1);
	$dataLearn1 = $dataLearn1[0];

	//ลำดับที่1
	$table .= "<tr>";
	$table .= "		<td rowspan=\"4\">1</td>";
	$table .= "		<td style=\"text-align:left;font-weight:bold;\"> ด้านความรู้ความสามารถและประสบการณ์</td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td rowspan=\"4\" style=\"text-align:left;\"> " . $dataLearn1->note . "</td>";
	$table .= "</tr>";

	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  1) ความรู้พื้นฐาน</td>";
	$table .= $dataLearn1->learn_1 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn1->learn_1 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn1->learn_1 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn1->learn_1 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";

	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  2) ความสามารถในการอ่าน</td>";
	$table .= $dataLearn1->learn_2 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn1->learn_2 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn1->learn_2 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn1->learn_2 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";

	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  3) ความสนใจและสมาธิในการเรียน</td>";
	$table .= $dataLearn1->learn_3 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn1->learn_3 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn1->learn_3 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn1->learn_3 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";

	$learn_2_sql = "SELECT * FROM stf_tb_learn_anlysis_side2\n" .
		"WHERE learn_analys_id = :learn_analys_id";
	$result_learn_2 = $DB->Query($learn_2_sql, ['learn_analys_id' => $learn_analys_id]);
	$dataLearn2 = json_decode($result_learn_2);
	$dataLearn2 = $dataLearn2[0];

	// ลำดับที่2
	$table .= "<tr>";
	$table .= "		<td rowspan=\"4\">2</td>";
	$table .= "		<td style=\"text-align:left;font-weight:bold;\"> ความพร้อมด้านสติปัญญา</td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td rowspan=\"4\"  style=\"text-align:left;\"> " . $dataLearn2->note . "</td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  1) ความคิดริเริ่มสร้างสรรค์</td>";
	$table .= $dataLearn2->learn_1 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn2->learn_1 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn2->learn_1 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn2->learn_1 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  2) ความมีเหตุผล</td>";
	$table .= $dataLearn2->learn_2 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn2->learn_2 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn2->learn_2 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn2->learn_2 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  3) ความสามารถในการเรียนรู้</td>";
	$table .= $dataLearn2->learn_3 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn2->learn_3 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn2->learn_3 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn2->learn_3 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";

	$learn_3_sql = "SELECT * FROM stf_tb_learn_anlysis_side3\n" .
		"WHERE learn_analys_id = :learn_analys_id";
	$result_learn_3 = $DB->Query($learn_3_sql, ['learn_analys_id' => $learn_analys_id]);
	$dataLearn3 = json_decode($result_learn_3);
	$dataLearn3 = $dataLearn3[0];

	// ลำดับที่3
	$table .= "<tr>";
	$table .= "<td rowspan=\"5\">3</td>";
	$table .= "<td style=\"text-align:left;font-weight:bold;\"> ความพร้อมด้านพฤติกรรม</td>";
	$table .= "<td></td>";
	$table .= "<td></td>";
	$table .= "<td></td>";
	$table .= "<td></td>";
	$table .= "<td rowspan=\"5\"  style=\"text-align:left;\"> " . $dataLearn3->note . "</td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "<td style=\"text-align:left;\">  1) การแสดงออก</td>";
	$table .= $dataLearn3->learn_1 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_1 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_1 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_1 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "<td style=\"text-align:left;\">  2) การควบคุมอารมณ์</td>";
	$table .= $dataLearn3->learn_2 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_2 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_2 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_2 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  3) ความมุ่งมั่น อดทน ขยันหมั่นเพียร</td>";
	$table .= $dataLearn3->learn_3 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_3 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_3 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_3 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  4) ความมุ่งมั่น อดทน ขยันหมั่นเพียรรับผิดชอบ</td>";
	$table .= $dataLearn3->learn_4 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_4 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_4 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn3->learn_4 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";

	$learn_4_sql = "SELECT * FROM stf_tb_learn_anlysis_side4\n" .
		"WHERE learn_analys_id = :learn_analys_id";
	$result_learn_4 = $DB->Query($learn_4_sql, ['learn_analys_id' => $learn_analys_id]);
	$dataLearn4 = json_decode($result_learn_4);
	$dataLearn4 = $dataLearn4[0];

	// ลำดับที่4
	$table .= "<tr>";
	$table .= "		<td rowspan=\"4\">4</td>";
	$table .= "		<td style=\"text-align:left;font-weight:bold;\"> ความพร้อมด้านร่างกายและจิตใจ</td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td rowspan=\"4\"  style=\"text-align:left;\"> " . $dataLearn4->note . "</td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  1) สุขภาพร่างกายสมบูรณ์</td>";
	$table .= $dataLearn4->learn_1 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn4->learn_1 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn4->learn_1 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn4->learn_1 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  2) การเจริญเติบโตตามวัย</td>";
	$table .= $dataLearn4->learn_2 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn4->learn_2 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn4->learn_2 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn4->learn_2 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  3) ความสมบูรณ์ทางด้านสุขภาพจิต</td>";
	$table .= $dataLearn4->learn_3 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn4->learn_3 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn4->learn_3 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn4->learn_3 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";

	$learn_5_sql = "SELECT * FROM stf_tb_learn_anlysis_side5\n" .
		"WHERE learn_analys_id = :learn_analys_id";
	$result_learn_5 = $DB->Query($learn_5_sql, ['learn_analys_id' => $learn_analys_id]);
	$dataLearn5 = json_decode($result_learn_5);
	$dataLearn5 = $dataLearn5[0];

	// ลำดับที่5
	$table .= "<tr>";
	$table .= "		<td rowspan=\"4\">5</td>";
	$table .= "		<td style=\"text-align:left;font-weight:bold;\"> ความพร้อมทางด้านสังคม</td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td></td>";
	$table .= "		<td rowspan=\"4\" style=\"text-align:left;\"> " . $dataLearn5->note . "</td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  1) การปรับตัวเข้ากับผู้อื่น</td>";
	$table .= $dataLearn5->learn_1 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn5->learn_1 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn5->learn_1 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn5->learn_1 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  2) การเสียสละ ไม่เห็นแก่ตัว</td>";
	$table .= $dataLearn5->learn_2 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn5->learn_2 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn5->learn_2 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn5->learn_2 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";
	$table .= "<tr>";
	$table .= "		<td style=\"text-align:left;\">  3) มีระเบียบวินัย เคารพกฎ กติกา</td>";
	$table .= $dataLearn5->learn_3 == 3 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn5->learn_3 == 2 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn5->learn_3 == 1 ? "<td>/</td>" : "<td></td>";
	$table .= $dataLearn5->learn_3 == 0 ? "<td>/</td>" : "<td></td>";
	$table .= "</tr>";


	$table .= "</table>";

	$pdf->writeHTML($table, false, false, true, false, 'C');

	$pdf->SetFont('thsarabun', 'B', 14);
	$pdf->Cell(70, 7, "ความคิดเห็น / ข้อเสนอแนะของครู", 0, 1, 'L');
	$pdf->SetFont('thsarabun', '', 14);
	// $pdf->Cell(190, 6, strlen($dataLearn->note) > 122 ? substr($dataLearn->note, 0, 123) : $dataLearn->note, $border_bottom, 1, 'L');
	// $pdf->Cell(190, 6, strlen($dataLearn->note) > 246 ? substr($dataLearn->note, 123, 246) : "", $border_bottom, 1, 'L');
	// $pdf->Cell(190, 6, strlen($dataLearn->note) > 123 ? substr($dataLearn->note, 123, 246) : "", $border_bottom, 1, 'L');

	$note = $dataLearn->note;

	$chunkSize = 135; // Set the desired chunk size

	for ($i = 0; $i < mb_strlen($note, 'UTF-8'); $i += $chunkSize) {
		$chunk = mb_substr($note, $i, $chunkSize, 'UTF-8');
		$pdf->Cell(190, 6, $chunk, $border_bottom, 1, 'L');
	}

	$pdf->Ln(9); //เว้นบรรทัด
}

$pdf->lastPage();
$pdf->Output('แบบวิเคราะห์ผู้เรียนรายบุคคล.php', 'I');
$pdf->Close();

function convertThaiDateToPHP($thaiDate)
{
	$thaiMonths = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
	$dateParts = explode(" ", $thaiDate);
	$day = (int)$dateParts[0];
	$monthIndex = array_search($dateParts[1], $thaiMonths);
	$year = (int)$dateParts[2] - 543; // Convert Thai year to Western year
	return date("Y-m-d", mktime(0, 0, 0, $monthIndex + 1, $day, $year));
}

function calculateAge($birthday)
{
	$birthdayC = convertThaiDateToPHP($birthday);
	$ageDate = new DateTime($birthdayC);
	$now = new DateTime();
	$ageInterval = $now->diff($ageDate);
	return $ageInterval->y;
}
