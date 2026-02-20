<?php
session_start();
if (!isset($_SESSION["user_data"])) {
    Header("Location: ../login");
}
require_once('../../assets/TCPDF/tcpdf.php');
include "../../config/class_database.php";

$DB = new Class_Database();
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$form_id = htmlentities($_GET['form_id']);
$sql = "SELECT\n" .
    "	* \n" .
    "FROM\n" .
    "	stf_tb_form_evaluate_student_detail feva_det\n" .
    "	LEFT JOIN stf_tb_form_evaluate_students feva ON feva_det.form_evaluate_id = feva.form_evaluate_id \n" .
    "	LEFT JOIN stf_tb_behavior behavior ON behavior.behavior_id = feva_det.behavior_id\n" .
    "   LEFT JOIN tb_students std ON feva.std_id = std.std_id\n" .
    "WHERE\n" .
    "	feva.form_evaluate_id = :form_id";

$data = $DB->Query($sql, ['form_id' => $form_id]);
$dataBehavior = json_decode($data);
if (count($dataBehavior) == 0) {
    header('location: ../404');
    exit();
}
$fullname = $dataBehavior[0]->std_name;

$fullnameTitle = 'แบบประเมินนักศึกษา-' . $dataBehavior[0]->std_prename . $dataBehavior[0]->std_name;
$pdf->SetTitle($fullnameTitle);

// set document information
$pdf->SetCreator(PDF_CREATOR);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetMargins(10, 3, 10, false);


$border_bottom = array(
    'B' => array('width' => 0.2, 'cap' => 'butt', 'dash' => 1, 'color' => array(0, 0, 0)),
);

$pdf->AddPage();
$pdf->SetFont('thsarabun', '', 12);

$pdf->Cell(190, 0, "แบบ ด.ล. 1.3 (1)", 0, 1, 'R');
$pdf->SetFont('thsarabun', '', 14);

$pdf->Cell(70, 5, "", 0, 0, 'R');
$pdf->Cell(50, 5, "แบบประเมินนักศึกษา", 1, 0, 'C');
$html = '';
if ($dataBehavior[0]->std_prename == 'ด.ช.' || $dataBehavior[0]->std_prename == 'เด็กชาย') {
    $html .= '<span>ด.ช.</span>/';
    $html .= '<span style="text-decoration: line-through;">นาย</span>/';
    $html .= '<span style="text-decoration: line-through;">นางสาว</span>/';
    $html .= '<span style="text-decoration: line-through;">ด.ญ.</span>';
}
if ($dataBehavior[0]->std_prename == 'นาย') {
    $html .= '<span style="text-decoration: line-through;">ด.ช.</span>/';
    $html .= '<span>นาย</span>/';
    $html .= '<span style="text-decoration: line-through;">นางสาว</span>/';
    $html .= '<span style="text-decoration: line-through;">ด.ญ.</span>';
}
if ($dataBehavior[0]->std_prename == 'ด.ญ.'  || $dataBehavior[0]->std_prename == 'เด็กหญิง') {
    $html .= '<span style="text-decoration: line-through;">ด.ช.</span>/';
    $html .= '<span style="text-decoration: line-through;">นาย</span>/';
    $html .= '<span style="text-decoration: line-through;">นางสาว</span>/';
    $html .= '<span>ด.ญ.</span>';
}
if ($dataBehavior[0]->std_prename == 'นางสาว') {
    $html .= '<span style="text-decoration: line-through;">ด.ช.</span>/';
    $html .= '<span style="text-decoration: line-through;">นาย</span>/';
    $html .= '<span>นางสาว</span>/';
    $html .= '<span style="text-decoration: line-through;">ด.ญ.</span>';
}

$pdf->Ln(9); //เว้นบรรทัด

$pdf->Cell(13, 8, "ชื่อ-สกุล ( ", 0, 0, 'L');
$pdf->SetY(18);
$pdf->SetX(24);
$pdf->Cell(3, 6, $pdf->writeHTML($html, false, false, true, false, '') . ")", 0, 0, 'L');

$pdf->Cell(70, 0, $fullname, $border_bottom, 0, 'L');
$pdf->Cell(8, 8, "ชั้น", 0, 0, 'L');
$pdf->Cell(15, 0, $dataBehavior[0]->std_class, $border_bottom, 0, 'L');
$pdf->Cell(20, 8, "รหัสนักศึกษา", 0, 0, 'L');
$pdf->Cell(27, 0, $dataBehavior[0]->std_code, $border_bottom, 1, 'L');

$pdf->Cell(22, 8, "วัน/เดือน/ปีเกิด", 0, 0, 'L');
$pdf->Cell(50, 0, $dataBehavior[0]->std_birthday, $border_bottom, 0, 'L');
$pdf->Cell(8, 8, "เพศ", 0, 0, 'L');
$pdf->Cell(15, 0, $dataBehavior[0]->std_gender, $border_bottom, 1, 'L');

$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);

$pdf->Ln(5);

$pdf->Cell(15, 7, "ที่", 1, 0, 'C');
$pdf->Cell(100, 7, "พฤติกรรมประเมิน", 1, 0, 'C');
$pdf->Cell(25, 7, "ไม่จริง", 1, 0, 'C');
$pdf->Cell(25, 7, "จริงบางครั้ง", 1, 0, 'C');
$pdf->Cell(25, 7, "จริง", 1, 1, 'C');

for ($i = 0; $i < count($dataBehavior); $i++) {
    $pdf->Cell(15, 7, ($i + 1), 1, 0, 'C');
    $pdf->Cell(100, 7, $dataBehavior[$i]->behavior, 1, 0, 'L');
    $pdf->Cell(25, 7, $dataBehavior[$i]->status == 'false' ? 'X' : '', 1, 0, 'C');
    $pdf->Cell(25, 7, $dataBehavior[$i]->status == 'somthing_true' ? 'X' : '', 1, 0, 'C');
    $pdf->Cell(25, 7, $dataBehavior[$i]->status == 'true' ? 'X' : '', 1, 1, 'C');
}

$pdf->Ln(0);

$pdf->Cell(57, 9, "คุณมีความคิดเห็นหรือความกังวลอื่นหรือไม่", 0, 0, 'L');
$pdf->Cell(133, 7, '     ' . $dataBehavior[0]->note, $border_bottom, 1, 'L');

$pdf->Cell(10, 7, "", 0, 0, 'L');
$pdf->Cell(25, 10, "คะแนนด้านที่ 1 : ", 0, 0, 'L');
$pdf->Cell(5, 10, $dataBehavior[0]->side_1_score, 0, 0, 'L');
$pdf->Cell(13, 10, "แปลผล", 0, 0, 'L');
$pdf->Cell(20, 7, $dataBehavior[0]->side_1_score <= 5 ? 'ปกติ' : 'เสี่ยง/มีปัญหา', $border_bottom, 1, 'L');

$pdf->Cell(10, 7, "", 0, 0, 'L');
$pdf->Cell(25, 10, "คะแนนด้านที่ 2 : ", 0, 0, 'L');
$pdf->Cell(5, 10, $dataBehavior[0]->side_2_score, 0, 0, 'L');
$pdf->Cell(13, 10, "แปลผล", 0, 0, 'L');
$pdf->Cell(20, 7, $dataBehavior[0]->side_2_score <= 4 ? 'ปกติ' : 'เสี่ยง/มีปัญหา', $border_bottom, 1, 'L');

$pdf->Cell(10, 7, "", 0, 0, 'L');
$pdf->Cell(25, 10, "คะแนนด้านที่ 3 : ", 0, 0, 'L');
$pdf->Cell(5, 10, $dataBehavior[0]->side_3_score, 0, 0, 'L');
$pdf->Cell(13, 10, "แปลผล", 0, 0, 'L');
$pdf->Cell(20, 7, $dataBehavior[0]->side_1_score <= 5 ? 'ปกติ' : 'เสี่ยง/มีปัญหา', $border_bottom, 1, 'L');

$pdf->Cell(10, 7, "", 0, 0, 'L');
$pdf->Cell(25, 10, "คะแนนด้านที่ 4 : ", 0, 0, 'L');
$pdf->Cell(5, 10, $dataBehavior[0]->side_4_score, 0, 0, 'L');
$pdf->Cell(13, 10, "แปลผล", 0, 0, 'L');
$pdf->Cell(20, 7, $dataBehavior[0]->side_1_score <= 3 ? 'ปกติ' : 'เสี่ยง/มีปัญหา', $border_bottom, 1, 'L');

$pdf->Cell(2, 7, "", 0, 0, 'L');
$pdf->Cell(28, 10, "รวมคะแนนทั้ง 4 ด้าน : ", 0, 0, 'L');
$pdf->Cell(5, 7, "", 0, 0, 'L');
$pdf->Cell(5, 10, $dataBehavior[0]->sum_score, 0, 0, 'L');
$pdf->Cell(13, 10, "แปลผล", 0, 0, 'L');
$pdf->Cell(20, 7, $dataBehavior[0]->side_1_score <= 16 ? 'ปกติ' : 'เสี่ยง/มีปัญหา', $border_bottom, 1, 'L');

$pdf->Cell(10, 7, "", 0, 0, 'L');
$pdf->Cell(25, 10, "คะแนนด้านที่ 5 : ", 0, 0, 'L');
$pdf->Cell(5, 10, $dataBehavior[0]->side_5_score, 0, 0, 'L');
$pdf->Cell(13, 10, "แปลผล", 0, 0, 'L');
$pdf->Cell(20, 7, $dataBehavior[0]->side_1_score <= 3 ? 'ไม่มีจุดแข็ง' : 'เป็นจุดแข็ง', $border_bottom, 1, 'L');

$fullname = $dataBehavior[0]->std_prename . $dataBehavior[0]->std_name;
$pdf->lastPage();
$pdf->Output('แบบประเมินนักศึกษา-' . $fullname . '.pdf', 'I');
$pdf->Close();


function convertDateToThaidate($date)
{
    $originalDate = $date;
    list($year, $month, $day) = explode('-', $originalDate);
    $thaiDate = $day . '/' . $month . '/' . ($year);

    return $thaiDate; // Output: 9 พฤษภาคม 2566
}
