<?php
session_start();
if (!isset($_SESSION["user_data"])) {
  Header("Location: ../login");
}
require_once('../../assets/TCPDF/tcpdf.php');
include "../../config/class_database.php";
include "../models/form_visit_home_model.php";

$DB = new Class_Database();
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$form_id = htmlentities($_GET['form_id']);

// set document information
$pdf->SetCreator(PDF_CREATOR);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->SetMargins(10, 3, 10, false);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->AddPage();

// set JPEG quality
$pdf->setJPEGQuality(75);

$pdf->SetFont('thsarabun', '', 12);
$pdf->Cell(190, 0, "แบบ ด.ล. 1.2 ", 0, 1, 'R');

$pdf->SetFont('thsarabun', 'B', 16);
$pdf->Cell(190, 0, "แบบบันทึกการเยี่ยมบ้าน", 0, 1, 'C');

$border_bottom = array(
  'B' => array('width' => 0.2, 'cap' => 'butt', 'dash' => 1, 'color' => array(0, 0, 0)),
);
$pdf->SetFont('thsarabun', '', 14);


$form_visit_model = new FormVisitHomeModel($DB);
$form_visit_data = $form_visit_model->getDataVisitPDF($form_id);
$form_visit_data = json_decode($form_visit_data);

if ($form_visit_data->status != 1) {
  header('location: ../404');
  exit();
}

$std_data = $form_visit_data->std_visit_data;
$side_2 = $form_visit_data->side_2;
$side_3 = $form_visit_data->side_3;
$side_4 = $form_visit_data->side_4;

$fullname = $std_data->std_prename . $std_data->std_name;

$fullnameTitle = 'แบบบันทึกการเยี่ยมบ้าน-' . $fullname;
$pdf->SetTitle($fullnameTitle);
list($name, $surname) = explode(' ', $std_data->std_name);

$pdf->Cell(9, 8, "1. ชื่อ", 0, 0, 'L');
$pdf->Cell(50, 0, $std_data->std_prename . $name, $border_bottom, 0, 'L');
$pdf->Cell(7, 8, "สกุล", 0, 0, 'L');
$pdf->Cell(50, 0, $surname, $border_bottom, 0, 'L');
$pdf->Cell(5, 8, "ชั้น", 0, 0, 'L');
$pdf->Cell(15, 0, $std_data->std_class, $border_bottom, 0, 'L');
$pdf->Cell(18, 8, "รหัสนักศึกษา", 0, 0, 'L');
$pdf->Cell(36, 0, "  " . $std_data->std_code, $border_bottom, 1, 'L');

$pdf->Cell(20, 8, "บิดา (ชื่อ-สกุล)", 0, 0, 'L');
$pdf->Cell(100, 0, "  " . $std_data->std_father_name, $border_bottom, 0, 'L');
$pdf->Cell(10, 8, "อาชีพ", 0, 0, 'L');
$pdf->Cell(60, 0, "  " . $std_data->std_father_job, $border_bottom, 1, 'L');
$pdf->Cell(23, 8, "มารดา (ชื่อ-สกุล)", 0, 0, 'L');
$pdf->Cell(97, 0, " " . $std_data->std_mather_name, $border_bottom, 0, 'L');
$pdf->Cell(10, 8, "อาชีพ", 0, 0, 'L');
$pdf->Cell(60, 0, "  " . $std_data->std_mather_job, $border_bottom, 1, 'L');

$pdf->Cell(8, 8, "ที่อยู่", 0, 0, 'L');
$pdf->Cell(67, 0, $std_data->address, $border_bottom, 0, 'L');
$pdf->Cell(25, 8, "เบอร์โทรศัพท์บ้าน", 0, 0, 'L');
$pdf->Cell(20, 0, "  - ", $border_bottom, 0, 'L');
$pdf->Cell(20, 8, "เบอร์โทรมือถือ", 0, 0, 'L');
$pdf->Cell(50, 0, "  " . $std_data->phone, $border_bottom, 1, 'L');

$pdf->Ln(2);

$pdf->SetFont('thsarabun', '', 14);
$pdf->Cell(190, 0, "2. สภาพทั่วไปที่พบบ้านนักศึกษา", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "2.1 สภาพแวดล้อม / ท้องถิ่นของนักศึกษา", 0, 1, 'L');

$activeVeryGood = 'style="list-style-type: circle;"';
$activeGood = 'style="list-style-type: circle;"';
$activePoor = 'style="list-style-type: circle;"';
$activeUnsure = 'style="list-style-type: circle;"';

if ($side_2->side_2_1 == "very_good") {
  $activeVeryGood = "";
  $side_2->side_2_1 = "";
} else if ($side_2->side_2_1 == "good") {
  $activeGood = "";
  $side_2->side_2_1 = "";
} else if ($side_2->side_2_1 == "poor") {
  $activePoor = "";
  $side_2->side_2_1 = "";
} else {
  $activeUnsure = "";
}

$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 20%;"><ul ' . $activeVeryGood . '><li>ดีมาก</li></ul></td>
    <td style="width: 20%;"><ul ' . $activeGood . '><li>ค่อนข้างดี</li></ul></td>
    <td style="width: 20%;"><ul ' . $activePoor . '><li>ยากจน</li></ul></td>
    <td style="width: 20%;"><ul ' . $activeUnsure . '><li>ไม่แน่ใจ เพราะ</li></ul></td>
  </tr>
</table>';

$pdf->writeHTML($html, false, false, true, false, '');

$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(9, 8, "เพราะ", 0, 0, 'L');
$pdf->Cell(175, 0, "  " . $side_2->side_2_1, $border_bottom, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "2.2 สภาพบ้าน / และครอบครัว", 0, 1, 'L');

$activeVeryGood = 'style="list-style-type: circle;"';
$activeGood = 'style="list-style-type: circle;"';
$activePoor = 'style="list-style-type: circle;"';
$activeUnsure = 'style="list-style-type: circle;"';

if ($side_2->side_2_2 == "very_good") {
  $activeVeryGood = "";
  $side_2->side_2_2 = "";
} else if ($side_2->side_2_2 == "good") {
  $activeGood = "";
  $side_2->side_2_2 = "";
} else if ($side_2->side_2_2 == "poor") {
  $activePoor = "";
  $side_2->side_2_2 = "";
} else {
  $activeUnsure = "";
}

$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 20%;"><ul ' . $activeVeryGood . '><li>ดีมาก</li></ul></td>
    <td style="width: 20%;"><ul ' . $activeGood . '><li>ค่อนข้างดี</li></ul></td>
    <td style="width: 20%;"><ul ' . $activePoor . '><li>ยากจน</li></ul></td>
    <td style="width: 20%;"><ul ' . $activeUnsure . '><li>ไม่แน่ใจ เพราะ</li></ul></td>
  </tr>
</table>';

$pdf->writeHTML($html, false, false, true, false, '');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(9, 8, "เพราะ", 0, 0, 'L');
$pdf->Cell(175, 0, "  " . $side_2->side_2_2, $border_bottom, 1, 'L');
$pdf->Ln(2);

$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "2.3 ความสัมพันธ์ของครอบครัว", 0, 1, 'L');

$activeVeryGood = 'style="list-style-type: circle;"';
$activeGood = 'style="list-style-type: circle;"';
$activePoor = 'style="list-style-type: circle;"';
$activeUnsure = 'style="list-style-type: circle;"';

if ($side_2->side_2_3 == "very_good") {
  $activeVeryGood = "";
  $side_2->side_2_3 = "";
} else if ($side_2->side_2_3 == "good") {
  $activeGood = "";
  $side_2->side_2_3 = "";
} else if ($side_2->side_2_3 == "poor") {
  $activePoor = "";
  $side_2->side_2_3 = "";
} else {
  $activeUnsure = "";
}

$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 20%;"><ul ' . $activeVeryGood . '><li>ดีมาก</li></ul></td>
    <td style="width: 20%;"><ul ' . $activeGood . '><li>ค่อนข้างดี</li></ul></td>
    <td style="width: 20%;"><ul ' . $activePoor . '><li>ยากจน</li></ul></td>
    <td style="width: 20%;"><ul ' . $activeUnsure . '><li>ไม่แน่ใจ เพราะ</li></ul></td>
  </tr>
</table>';

$pdf->writeHTML($html, false, false, true, false, '');

$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(9, 8, "เพราะ", 0, 0, 'L');
$pdf->Cell(175, 0, "  " . $side_2->side_2_3, $border_bottom, 1, 'L');
$pdf->Ln(2);

$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "2.4 ข้อมูลด้านอื่นๆ", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "  " . $side_2->side_2_4, $border_bottom, 1, 'L');
$pdf->Ln(5);

$pdf->SetFont('thsarabun', '', 14);
$pdf->Cell(190, 0, "3.  ความคิดเห็นของผู้ปกครองต่อนักศึกษา", 0, 1, 'L');

$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "3.1 ภารกิจที่รับผิดชอบ คือ ", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "  " . $side_3->text_3_1, $border_bottom, 1, 'L');

$side_3->side_3_1 == "very_good" ? $activeVeryGood = "" : $activeVeryGood = 'style="list-style-type: circle;"';
$side_3->side_3_1 == "good" ? $activeGood = "" : $activeGood = 'style="list-style-type: circle;"';
$side_3->side_3_1 == "meliorate" ? $activeMeliorate = "" : $activeMeliorate = 'style="list-style-type: circle;"';
$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 30%;"><ul ' . $activeVeryGood . '><li>ดีมาก</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeGood . '><li>ค่อนข้างดี</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeMeliorate . '><li>ปรับปรุง</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, '');
$pdf->Ln(5);

$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "3.2 การใช้เวลาว่างที่บ้าน ได้แก่ คือ ", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "  " . $side_3->text_3_2, $border_bottom, 1, 'L');

$side_3->side_3_2 == "very_good" ? $activeVeryGood = "" : $activeVeryGood = 'style="list-style-type: circle;"';
$side_3->side_3_2 == "good" ? $activeGood = "" : $activeGood = 'style="list-style-type: circle;"';
$side_3->side_3_2 == "meliorate" ? $activeMeliorate = "" : $activeMeliorate = 'style="list-style-type: circle;"';
$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 30%;"><ul ' . $activeVeryGood . '><li>ดีมาก</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeGood . '><li>ค่อนข้างดี</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeMeliorate . '><li>ปรับปรุง</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, '');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "3.3 การมีสัมพันธภาพต่อครอบครัว ได้แก่  ", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "  " . $side_3->text_3_3, $border_bottom, 1, 'L');

$side_3->side_3_3 == "very_good" ? $activeVeryGood = "" : $activeVeryGood = 'style="list-style-type: circle;"';
$side_3->side_3_3 == "good" ? $activeGood = "" : $activeGood = 'style="list-style-type: circle;"';
$side_3->side_3_3 == "meliorate" ? $activeMeliorate = "" : $activeMeliorate = 'style="list-style-type: circle;"';
$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 30%;"><ul ' . $activeVeryGood . '><li>ดีมาก</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeGood . '><li>ค่อนข้างดี</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeMeliorate . '><li>ปรับปรุง</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, '');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "3.4 การเอาใจใส่ต่อการเรียน ", 0, 1, 'L');

$side_3->side_3_4 == "very_good" ? $activeVeryGood = "" : $activeVeryGood = 'style="list-style-type: circle;"';
$side_3->side_3_4 == "good" ? $activeGood = "" : $activeGood = 'style="list-style-type: circle;"';
$side_3->side_3_4 == "meliorate" ? $activeMeliorate = "" : $activeMeliorate = 'style="list-style-type: circle;"';
$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 30%;"><ul ' . $activeVeryGood . '><li>ดีมาก</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeGood . '><li>ค่อนข้างดี</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeMeliorate . '><li>ปรับปรุง</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, '');

$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(850, 0, "3.5 อื่นๆ", 0, 1, 'L');
$pdf->Cell(5, 0, "", 0, 0, 'L');
$pdf->Cell(185, 0, "  " . $side_3->side_3_5, $border_bottom, 1, 'L');

$pdf->SetFont('thsarabun', '', 14);
$pdf->Cell(190, 0, "", 0, 1, '');
$pdf->Cell(190, 0, "4.  สรุปผลการเยี่ยมบ้านนักศึกษา โดยรวมพบว่า ", 0, 1, 'L');

$side_4->status == "very_good" ? $activeVeryGood = "" : $activeVeryGood = 'style="list-style-type: circle;"';
$side_4->status == "promote" ? $activeGood = "" : $activeGood = 'style="list-style-type: circle;"';
$side_4->status == "help" ? $activeMeliorate = "" : $activeMeliorate = 'style="list-style-type: circle;"';
$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 30%;"><ul ' . $activeVeryGood . '><li>ดีมาก</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeGood . '><li>ค่อนข้างดี</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeMeliorate . '><li>ปรับปรุง</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, '');

if ($side_4->status == 'promote' || $side_4->status == 'help') {
  $pdf->Cell(5, 0, "", 0, 0, 'L');
  $pdf->Cell(185, 0, "  " . $side_4->text, $border_bottom, 1, 'L');
}
$pdf->SetFont('thsarabun', '', 14);
$pdf->Ln(5);
if (!empty($std_data->location)) {
  $html = '<a href="' . $std_data->location . '" target="_blank" style="text-decoration: none;">แผนที่ Google Map บ้านนักศึกษา</a>';
  $pdf->writeHTML($html, true, false, true, false, 'C');
}

$pathImage = '../uploads/visit_home_img/' . $std_data->home_img;
// Get the dimensions of the image
list($width, $height) = getimagesize($pathImage);

// Calculate new dimensions while maintaining aspect ratio
$maxWidth = 200; // Set your desired maximum width
$maxHeight = 100; // Set your desired maximum height

$ratio = min($maxWidth / $width, $maxHeight / $height);
$newWidth = $width * $ratio;
$newHeight = $height * $ratio;

// Calculate the X coordinate to center the image
$pageWidth = $pdf->getPageWidth();
$imageX = ($pageWidth - $newWidth) / 2;

// Display image with calculated dimensions and centered position
$pdf->Image($pathImage, $imageX, '', $newWidth, $newHeight);

$pdf->lastPage();
$pdf->Output('แบบบันทึกการเยี่ยมบ้าน-' . $fullname . '.pdf', 'I');
$pdf->Close();
