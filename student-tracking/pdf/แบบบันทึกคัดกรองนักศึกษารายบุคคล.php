<?php
session_start();
if (!isset($_SESSION["user_data"])) {
  Header("Location: ../login");
}
require_once('../../assets/TCPDF/tcpdf.php');
include "../../config/class_database.php";
include "../models/form_screening_model.php";

$DB = new Class_Database();
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$form_id = htmlentities($_GET['form_id']);

$form_screening_model = new FormScreeningStudentModel($DB);
$std_data_in_form = $form_screening_model->getDataStdInFrom($form_id);
$std_data_in_form = json_decode($std_data_in_form);

if ($std_data_in_form->status != 1) {
  header('location: ../404');
  exit();
}

$data_form = $std_data_in_form->data_std_form;
$side_1 = $std_data_in_form->side_1;
$side_2 = $std_data_in_form->side_2;
$side_3 = $std_data_in_form->side_3;
$side_4 = $std_data_in_form->side_4;
$side_5 = $std_data_in_form->side_5;

$fullname = $data_form->std_prename . $data_form->std_name;

list($name, $surname) = explode(' ', $data_form->std_name);


$fullnameTitle = 'แบบบันทึกคัดกรองนักศึกษารายบุคคล - '.$fullname;
$pdf->SetTitle($fullnameTitle);

// set document information
$pdf->SetCreator(PDF_CREATOR);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setJPEGQuality(75);

$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetMargins(10, 3, 10, false);


$border_bottom = array(
  'B' => array('width' => 0.2, 'cap' => 'butt', 'dash' => 1, 'color' => array(0, 0, 0)),
);

$pdf->AddPage();
$pdf->SetFont('thsarabun', '', 12);

$pdf->Cell(190, 0, "แบบ ด.ล. 2.5", 0, 1, 'R');
$pdf->SetFont('thsarabun', 'B', 16);

$pdf->Cell(70, 5, "", 0, 0, 'R');
$pdf->Cell(50, 5, "แบบบันทึกการคัดกรองนักศึกษาเป็นรายบุคคล", 0, 1, 'C');

$border_bottom = array(
  'B' => array('width' => 0.2, 'cap' => 'butt', 'dash' => 1, 'color' => array(0, 0, 0)),
);

$pdf->SetFont('thsarabun', '', 14);
// name surname code
$pdf->Cell(5, 8, "ชื่อ", 0, 0, 'L');
$pdf->Cell(50, 0, "   " . $data_form->std_prename . $name, $border_bottom, 0, 'L');
$pdf->Cell(7, 8, "สกุล", 0, 0, 'L');
$pdf->Cell(50, 0, "   " . $surname, $border_bottom, 0, 'L');
// $pdf->Cell(18, 8, "เลขประจำตัว", 0, 0, 'L');
// $pdf->Cell(60, 0, "   " . $data_form->std_number, $border_bottom, 1, 'L');


// class number date_create
$pdf->Cell(5, 8, "ชั้น", 0, 0, 'L');
$pdf->Cell(20, 0, "   " . $data_form->std_class, $border_bottom, 0, 'L');
$pdf->Cell(19, 8, "รหัสนักศึกษา", 0, 0, 'L');
$pdf->Cell(34, 0, "   " . $data_form->std_code, $border_bottom, 1, 'L');
$pdf->Ln(3);
$pdf->Cell(23, 8, "วันที่บันทึกข้อมูล", 0, 0, 'L');
$pdf->Cell(50, 0, "   " . convertDateToThaidate($data_form->create_date_c), $border_bottom, 0, 'L');

$pdf->Cell(15, 8, "ครูผู้บันทึก", 0, 0, 'L');
$pdf->Cell(102, 0, "   " . $data_form->u_name, $border_bottom, 1, 'L');

$pdf->Ln(3);

$pdf->SetFont('thsarabun', 'B', 14);
$pdf->Cell(190, 0, "1.ความสามารถด้านการเรียน", 0, 1, 'L');
$pdf->SetFont('thsarabun', '', 14);
$side_1->status == "ปกติ" ? $activeNormal = "" : $activeNormal = 'style="list-style-type: circle;"';
$side_1->status == "เสี่ยง" ? $activeRisk = "" : $activeRisk = 'style="list-style-type: circle;"';
$side_1->status == "มีปัญหา" ? $activeProblem = "" : $activeProblem = 'style="list-style-type: circle;"';
$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 30%;"><ul ' . $activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
</table>';

$pdf->writeHTML($html, false, false, true, false, '');
$pdf->Ln(2);
$side_1->side_1_1 = $side_1->side_1_1 == 'true' ? '/' : '&nbsp;';
$side_1->side_1_2 = $side_1->side_1_2 == 'true' ? '/' : '&nbsp;';
$side_1->side_1_3 = $side_1->side_1_3 == 'true' ? '/' : '&nbsp;';
$side_1->side_1_4 = $side_1->side_1_4 == 'true' ? '/' : '&nbsp;';
$side_1->side_1_5 = $side_1->side_1_5 == 'true' ? '/' : '&nbsp;';

$side_1_6_check = $side_1->side_1_6 == 'false' ? '&nbsp;' : '/';
$side_1_6 = $side_1->side_1_6 == 'false' ? '' : '"' . $side_1->side_1_6 . '"';

$side_1->side_1_7 = $side_1->side_1_7 == 'true' ? '/' : '&nbsp;';
$side_1->side_1_8 = $side_1->side_1_8 == 'true' ? '/' : '&nbsp;';
$side_1->side_1_9 = $side_1->side_1_9 == 'true' ? '/' : '&nbsp;';
$side_1->side_1_10 = $side_1->side_1_10 == 'true' ? '/' : '&nbsp;';
$side_1->side_1_11 = $side_1->side_1_11 ? '/' : '&nbsp;';

$side_1_12_check = $side_1->side_1_12 == 'false' ? '&nbsp;' : '/';
$side_1_12 = $side_1->side_1_12 == 'false' ? '' : '"' . $side_1->side_1_12 . '"';
$html = "
<table>
  <tr>
    <td style='width: 50%;'>
      <ul style=\"list-style-type: none;\">
        <li>[ $side_1->side_1_1 ]&nbsp;&nbsp; ผลการเรียนเฉลี่ย 1.00 – 2.00</li>
        <li>[ $side_1->side_1_2 ]&nbsp;&nbsp; มาโรงเรียนสาย 3 ครั้ง/สัปดาห์</li>
        <li>[ $side_1->side_1_3 ]&nbsp;&nbsp; ติด 0 , ร , มส 1 – 2 วิชาใน 1 ภาคเรียน</li>
        <li>[ $side_1->side_1_4 ]&nbsp;&nbsp; อ่านหนังสือไม่คล่อง</li>
        <li>[ $side_1->side_1_5 ]&nbsp;&nbsp; ไม่เข้าเรียนหลายครั้งโดยไม่มีเหตุจำเป็น</li>
        <li>[ $side_1_6_check ]&nbsp;&nbsp; อื่นๆระบุ <span>$side_1_6</span></li>
      </ul>
    </td>
    <td style='width: 50%;'>
      <ul style=\"list-style-type: none;\">
        <li>[  $side_1->side_1_7 ]&nbsp;&nbsp; ผลการเรียนเฉลี่ยต่ำกว่า 1.50</li>
        <li>[  $side_1->side_1_8 ]&nbsp;&nbsp; อ่านหนังสือไม่ออก</li>
        <li>[  $side_1->side_1_9 ]&nbsp;&nbsp; ติด 0 , ร , มส , มผ 3 วิชาขึ้นไป</li>
        <li>[  $side_1->side_1_10 ]&nbsp;&nbsp; ไม่ส่งงานหลายวิชา</li>
        <li>[  $side_1->side_1_11 ]&nbsp;&nbsp; เขียนหนังสือไม่ถูกต้องสะกดคำผิดแม้แต่คำง่ายๆ</li>
        <li>[  $side_1_12_check  ]&nbsp;&nbsp; อื่นๆระบุ <span>$side_1_12</span></li>
      </ul>
    </td>
  </tr>
</table>";
$pdf->writeHTML($html, true, false, true, true, '');

$pdf->SetFont('thsarabun', 'B', 14);
$pdf->Cell(10, 0, "", 0, 0, 'L');
$pdf->Cell(180, 0, "1.1 ด้านความสามารถอื่นๆ", 0, 1, 'L');
$pdf->SetFont('thsarabun', '', 14);

$side_1_1_1_have = 'list-style-type: circle;';
$side_1_1_1_have_txt = '';
$side_1_1_1_not_have = 'list-style-type: circle;';
if ($side_1->side_1_1_1_have == 'ไม่มี') {
  $side_1_1_1_not_have = '';
} else {
  $side_1_1_1_have = '';
  $side_1_1_1_have_txt = '"' . $side_1->side_1_1_1_have . '"';
}

$html = '
  <table>
    <tr style="width: 50%;">
      <td style="width: 5%;"></td>
      <td>
        <ul style="' . $side_1_1_1_have . '">
          <li>มีระบุ <span>' . $side_1_1_1_have_txt . '</span></li>
        </ul>
      </td>
    </tr>
  </table>';
$pdf->writeHTML($html, true, false, true, true, '');
$html = '
  <table>
    <tr style="width: 50%;">
      <td style="width: 4.5%;"></td>
      <td>
        <ul style="' . $side_1_1_1_not_have . '">
          <li>ไม่มี (ไม่ชัดเจนในความสามารถด้านอื่น นอกจากด้านการเรียน) </li>
        </ul>
      </td>
    </tr>
  </table>';
$pdf->writeHTML($html, true, false, true, true, '');
$pdf->Ln(5);

//ข้อ 2 ---------------------------------
$pdf->SetFont('thsarabun', 'B', 14);
$pdf->Cell(190, 0, "2.ด้านสุขภาพ", 0, 1, 'L');
$pdf->SetFont('thsarabun', '', 14);

$side_2->status == "ปกติ" ? $activeNormal = "" : $activeNormal = 'style="list-style-type: circle;"';
$side_2->status == "เสี่ยง" ? $activeRisk = "" : $activeRisk = 'style="list-style-type: circle;"';
$side_2->status == "มีปัญหา" ? $activeProblem = "" : $activeProblem = 'style="list-style-type: circle;"';

$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 30%;"><ul ' . $activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, '');
$pdf->Ln(2);
$side_2->side_2_1 = $side_2->side_2_1 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_2 = $side_2->side_2_2 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_3 = $side_2->side_2_3 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_4 = $side_2->side_2_4 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_5 = $side_2->side_2_5 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_6 = $side_2->side_2_6 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_7 = $side_2->side_2_7 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_8 = $side_2->side_2_8 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_9 = $side_2->side_2_9 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_10 = $side_2->side_2_10 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_11 = $side_2->side_2_11 == 'true' ? '/' : '&nbsp;';

$side2_1_12_check = $side_2->side_2_12 == 'false' ? '&nbsp;' : '/';
$side2_1_12 = $side_2->side_2_12 == 'false' ? '&nbsp;' : '"' . $side_2->side_2_12 . '"';

$side_2->side_2_13 = $side_2->side_2_13 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_14 = $side_2->side_2_14 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_15 = $side_2->side_2_15 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_16 = $side_2->side_2_16 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_17 = $side_2->side_2_17 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_18 = $side_2->side_2_18 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_19 = $side_2->side_2_19 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_20 = $side_2->side_2_20 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_21 = $side_2->side_2_21 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_22 = $side_2->side_2_22 == 'true' ? '/' : '&nbsp;';
$side_2->side_2_23 = $side_2->side_2_23 == 'true' ? '/' : '&nbsp;';

$side2_1_24_check = $side_2->side_2_24 == 'false' ? '&nbsp;' : '/';
$side2_1_24 = $side_2->side_2_24 == 'false' ?  '&nbsp;' : '"' . $side_2->side_1_24 . '"';


$html = "
<table>
  <tr>
    <td>
      <ul style=\"list-style-type: none;\">
        <li>[ $side_2->side_2_1 ]&nbsp;&nbsp; น้ำหนักผิดปกติและไม่สัมพันธ์กับส่วนสูงหรืออายุเล็กน้อย</li>
        <li>[ $side_2->side_2_2 ]&nbsp;&nbsp; สุขภาพร่างกายไม่แข็งแรง</li>
        <li>[ $side_2->side_2_3 ]&nbsp;&nbsp; มีโรคประจำตัวที่ส่งผลกระทบต่อการเรียนหรือ<br>เจ็บป่วยบ่อย</li>
        <li>[ $side_2->side_2_4 ]&nbsp;&nbsp; มีปัญหาด้านสายตา /สั้น /เอียง</li>
        <li>[ $side_2->side_2_5 ]&nbsp;&nbsp; มีปัญหาในการได้ยินไม่ชัดเจน</li>
        <li>[ $side_2->side_2_6 ]&nbsp;&nbsp; ผลการเรียนเฉลี่ย 1.00 – 2.00</li>
        <li>[ $side_2->side_2_7 ]&nbsp;&nbsp; มาโรงเรียนสาย 3 ครั้ง/สัปดาห์</li>
        <li>[ $side_2->side_2_8 ]&nbsp;&nbsp; ติด 0 , ร , มส 1 – 2 วิชาใน 1 ภาคเรียน</li>
        <li>[ $side_2->side_2_9 ]&nbsp;&nbsp; อ่านหนังสือไม่คล่อง</li>
        <li>[ $side_2->side_2_10 ]&nbsp;&nbsp; ไม่เข้าเรียนหลายครั้งโดยไม่มีเหตุจำเป็น</li>
        <li>[ $side_2->side_2_11 ]&nbsp;&nbsp; ออทิสติก</li>
        <li>[ $side2_1_12_check ]&nbsp;&nbsp; อื่นๆระบุ <span>$side2_1_12</span></li>
      </ul>
    </td>
    <td style='width: 50%;'>
      <ul style=\"list-style-type: none;\">
        <li>[ $side_2->side_2_13 ]&nbsp;&nbsp; น้ำหนักผิดปกติและไม่สัมพันธ์ส่วนสูงหรืออายุมากชัดเจน</li>
        <li>[ $side_2->side_2_14 ]&nbsp;&nbsp; มีความพิการทางร่างกาย</li>
        <li>[ $side_2->side_2_15 ]&nbsp;&nbsp; ป่วยเป็นโรคร้ายแรง / เรื้อรัง</li>
        <li>[ $side_2->side_2_16 ]&nbsp;&nbsp; มีปัญหาในการมองเห็น (ไม่มีแว่นตาใส่)</li>
        <li>[ $side_2->side_2_17 ]&nbsp;&nbsp; มีความบกพร่องทางการได้ยินมาก</li>
        <li>[ $side_2->side_2_18 ]&nbsp;&nbsp; ผลการเรียนเฉลี่ยต่ำกว่า 1.50</li>
        <li>[ $side_2->side_2_19 ]&nbsp;&nbsp; อ่านหนังสือไม่ออก</li>
        <li>[ $side_2->side_2_20 ]&nbsp;&nbsp; ติด 0 , ร , มส , มผ 3 วิชาขึ้นไป</li>
        <li>[ $side_2->side_2_21 ]&nbsp;&nbsp; ไม่ส่งงานหลายวิชา</li>
        <li>[ $side_2->side_2_22 ]&nbsp;&nbsp; เขียนหนังสือไม่ถูกต้องสะกดคำผิด</li>
        <li>[ $side_2->side_2_23 ]&nbsp;&nbsp; บกพร่องในการพูด</li>
        <li>[ $side2_1_24_check ]&nbsp;&nbsp; อื่นๆระบุ <span>$side2_1_24</span></li>
      </ul>
    </td>
  </tr>
</table>";
$pdf->writeHTML($html, true, false, true, true, '');
$pdf->Ln(5);

//ข้อ 3 ---------------------------------
$pdf->SetFont('thsarabun', 'B', 14);
$pdf->Cell(190, 0, "3.ด้านสุขภาพจิตและพฤติกรรม (SDQ)", 0, 1, 'L');
$pdf->SetFont('thsarabun', '', 14);
$pdf->Ln(2);
$side_3->side_3_1 == "ปกติ" ? $side_3_1_activeNormal = "" : $side_3_1_activeNormal = 'style="list-style-type: circle;"';
$side_3->side_3_1 == "เสี่ยง" ? $side_3_1_activeRisk = "" : $side_3_1_activeRisk = 'style="list-style-type: circle;"';
$side_3->side_3_1 == "มีปัญหา" ? $side_3_1_activeProblem = "" : $side_3_1_activeProblem = 'style="list-style-type: circle;"';

$side_3->side_3_2 == "ปกติ" ? $side_3_2_activeNormal = "" : $side_3_2_activeNormal = 'style="list-style-type: circle;"';
$side_3->side_3_2 == "เสี่ยง" ? $side_3_2_activeRisk = "" : $side_3_2_activeRisk = 'style="list-style-type: circle;"';
$side_3->side_3_2 == "มีปัญหา" ? $side_3_2_activeProblem = "" : $side_3_2_activeProblem = 'style="list-style-type: circle;"';

$side_3->side_3_3 == "ปกติ" ? $side_3_3_activeNormal = "" : $side_3_3_activeNormal = 'style="list-style-type: circle;"';
$side_3->side_3_3 == "เสี่ยง" ? $side_3_3_activeRisk = "" : $side_3_3_activeRisk = 'style="list-style-type: circle;"';
$side_3->side_3_3 == "มีปัญหา" ? $side_3_3_activeProblem = "" : $side_3_3_activeProblem = 'style="list-style-type: circle;"';

$side_3->side_3_4 == "ปกติ" ? $side_3_4_activeNormal = "" : $side_3_4_activeNormal = 'style="list-style-type: circle;"';
$side_3->side_3_4 == "เสี่ยง" ? $side_3_4_activeRisk = "" : $side_3_4_activeRisk = 'style="list-style-type: circle;"';
$side_3->side_3_4 == "มีปัญหา" ? $side_3_4_activeProblem = "" : $side_3_4_activeProblem = 'style="list-style-type: circle;"';

$side_3->side_3_summary == "ปกติ" ? $side_3_sum_activeNormal = "" : $side_3_sum_activeNormal = 'style="list-style-type: circle;"';
$side_3->side_3_summary == "เสี่ยง" ? $side_3_sum_activeRisk = "" : $side_3_sum_activeRisk = 'style="list-style-type: circle;"';
$side_3->side_3_summary == "มีปัญหา" ? $side_3_sum_activeProblem = "" : $side_3_sum_activeProblem = 'style="list-style-type: circle;"';

$html = '
<table>
  <tr>
    <td style="width: 5%;"></td>
    <td style="width: 25%;">1)	ด้านอารมณ์</td>
    <td style="width: 20%;"><ul ' . $side_3_1_activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_3_1_activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_3_1_activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
  <tr>
    <td style="width: 5%;"></td>
    <td style="width: 25%;">2)	ด้านความพฤติกรรม /เกเร</td>
    <td style="width: 20%;"><ul ' . $side_3_2_activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_3_2_activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_3_2_activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
  <tr>
    <td style="width: 5%;"></td>
    <td style="width: 25%;">3)	ด้านพฤติกรรมอยู่ไม่นิ่ง/สมาธิสั้น</td>
    <td style="width: 20%;"><ul ' . $side_3_3_activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_3_3_activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_3_3_activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
  <tr>
    <td style="width: 5%;"></td>
    <td style="width: 25%;">4)	ด้านความสัมพันธ์กับเพื่อน</td>
    <td style="width: 20%;"><ul ' . $side_3_4_activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_3_4_activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_3_4_activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, '');
$pdf->SetFont('thsarabun', 'B', 14);
$pdf->Ln(5);
$pdf->Cell(190, 0, "สรุป ข้อมูลแบบประเมิน SDQ ( จากคะแนนรวม 4 ด้าน ) นักศึกษาอยู่ในกลุ่ม", 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('thsarabun', '', 14);
$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 30%;"><ul ' . $side_3_sum_activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 30%;"><ul ' . $side_3_sum_activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 30%;"><ul ' . $side_3_sum_activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, 'C');
$pdf->Ln(20);

$pdf->Cell(190, 0, "", 0, 1, 'L');
//ข้อ 4 ---------------------------------
$pdf->SetFont('thsarabun', 'B', 14);
$pdf->Cell(190, 0, "4.ด้านครอบครัว", 0, 1, 'L');
$pdf->Cell(10, 0, "", 0, 0, 'L');
$pdf->Cell(180, 0, "4.1 ด้านเศรษฐกิจ", 0, 1, 'L');
$pdf->SetFont('thsarabun', '', 14);

$side_4->side_4_1_status == "ปกติ" ? $activeNormal = "" : $activeNormal = 'style="list-style-type: circle;"';
$side_4->side_4_1_status == "เสี่ยง" ? $activeRisk = "" : $activeRisk = 'style="list-style-type: circle;"';
$side_4->side_4_1_status == "มีปัญหา" ? $activeProblem = "" : $activeProblem = 'style="list-style-type: circle;"';

$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 30%;"><ul ' . $activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, '');

$side_4->side_4_1_1 = $side_4->side_4_1_1 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_1_2 = $side_4->side_4_1_2 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_1_3 = $side_4->side_4_1_3 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_1_4 = $side_4->side_4_1_4 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_1_5 = $side_4->side_4_1_5 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_1_6 = $side_4->side_4_1_6 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_1_7 = $side_4->side_4_1_7 == 'true' ? '/' : '&nbsp;';

$side_4_1_8_check = $side_4->side_4_1_8 == 'false' ? '&nbsp;' : '/';
$side_4_1_8 = $side_4->side_4_1_8 == 'false' ?  '&nbsp;' : '"' . $side_4->side_4_1_8 . '"';

$html = '
<table>
  <tr>
    <td>
      <ul style="list-style-type: none;">
        <li>[ ' . $side_4->side_4_1_1 . ' ]&nbsp;&nbsp; รายได้ครอบครัวต่อเดือนต่ำกว่า 10,000 บาท</li>
        <li>[ ' . $side_4->side_4_1_2 . ' ]&nbsp;&nbsp; บิดาหรือมารดาตกงาน</li>
        <li>[ ' . $side_4->side_4_1_3 . ' ]&nbsp;&nbsp; ใช้จ่ายฟุ่มเฟือย</li>
        <li>[ ' . $side_4->side_4_1_4 . ' ]&nbsp;&nbsp; ไม่มีเงินซื้ออุปกรณ์การเรียน</li>
      </ul>
    </td>
    <td style="width: 50%;">
      <ul style="list-style-type: none;">
        <li>[ ' . $side_4->side_4_1_5 . ' ]&nbsp;&nbsp; ยังไม่ได้ชำระค่าธรรมเนียมการเรียน 1 ภาคเรียนขึ้นไป</li>
        <li>[ ' . $side_4->side_4_1_6 . ' ]&nbsp;&nbsp; มีภาระหนี้สินจำนวนมาก</li>
        <li>[ ' . $side_4->side_4_1_7 . ' ]&nbsp;&nbsp; ไม่มีเงินพอรับประทานอาหารกลางวัน</li>
        <li>[ ' . $side_4_1_8_check . ' ]&nbsp;&nbsp; อื่นๆระบุ <span>' . $side_4_1_8 . '</span></li>
      </ul>
    </td>
  </tr>
</table>';
$pdf->writeHTML($html, true, false, true, true, '');
$pdf->Ln(3);
$pdf->SetFont('thsarabun', 'B', 14);
$pdf->Cell(10, 0, "", 0, 0, 'L');
$pdf->Cell(180, 0, "4.2 การคุ้มครองนักศึกษา", 0, 1, 'L');
$pdf->SetFont('thsarabun', '', 14);

$side_4->side_4_2_status == "ปกติ" ? $activeNormal = "" : $activeNormal = 'style="list-style-type: circle;"';
$side_4->side_4_2_status == "เสี่ยง" ? $activeRisk = "" : $activeRisk = 'style="list-style-type: circle;"';
$side_4->side_4_2_status == "มีปัญหา" ? $activeProblem = "" : $activeProblem = 'style="list-style-type: circle;"';

$html = '
<table>
  <tr>
    <td style="width: 10%;"></td>
    <td style="width: 30%;"><ul ' . $activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 30%;"><ul ' . $activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, '');

$side_4->side_4_2_1 = $side_4->side_4_2_1 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_2_2 = $side_4->side_4_2_2 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_2_3 = $side_4->side_4_2_3 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_2_4 = $side_4->side_4_2_4 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_2_5 = $side_4->side_4_2_5 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_2_6 = $side_4->side_4_2_6 == 'true' ? '/' : '&nbsp;';

$side_4_2_7_check = $side_4->side_4_2_7 == 'false' ? '&nbsp;' : '/';
$side_4_2_7 = $side_4->side_4_2_7 == 'false' ?  '&nbsp;' : '"' . $side_4->side_4_2_7 . '"';

$side_4->side_4_2_8 = $side_4->side_4_2_8 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_2_9 = $side_4->side_4_2_9 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_2_10 = $side_4->side_4_2_10 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_2_11 = $side_4->side_4_2_11 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_2_12 = $side_4->side_4_2_12 == 'true' ? '/' : '&nbsp;';
$side_4->side_4_2_13 = $side_4->side_4_2_13 == 'true' ? '/' : '&nbsp;';

$side_4_2_14_check = $side_4->side_4_2_14 == 'false' ? '&nbsp;' : '/';
$side_4_2_14 = $side_4->side_4_2_14 == 'false' ?  '&nbsp;' : '"' . $side_4->side_4_2_14 . '"';
$html = '
<table>
  <tr>
    <td>
      <ul style="list-style-type: none;">
        <li>[ ' . $side_4->side_4_2_1 . ' ]&nbsp;&nbsp; พ่อแม่แยกทางกันหรือแต่งงานใหม่</li>
        <li>[ ' . $side_4->side_4_2_2 . ' ]&nbsp;&nbsp; ที่พักอาศัยอยู่ใกล้แหล่งมั่วสุม/สถานที่เริงรมย์ที่เสี่ยง<br>ต่อสวัสดิภาพ</li>
        <li>[ ' . $side_4->side_4_2_3 . ' ]&nbsp;&nbsp; อยู่หอพัก</li>
        <li>[ ' . $side_4->side_4_2_4 . ' ]&nbsp;&nbsp; มีบุคคลในครอบครัวเจ็บป่วยด้วยโรคร้ายแรง</li>
        <li>[ ' . $side_4->side_4_2_5 . ' ]&nbsp;&nbsp; บุคคลในครอบครัวติดสารเสพติด หรือเล่นการพนัน</li>
        <li>[ ' . $side_4->side_4_2_6 . ' ]&nbsp;&nbsp; มีความขัดแย้ง/ทะเลาะกันในครอบครัว</li>
        <li>[ ' . $side_4_2_7_check . ' ]&nbsp;&nbsp; อื่นๆระบุ <span>' . $side_4_2_7 . '</span></li>
      </ul>
    </td>
    <td style="width: 50%;">
      <ul style="list-style-type: none;">
        <li>[ ' . $side_4->side_4_2_8 . ' ]&nbsp;&nbsp; มีความขัดแย้งและมีการใช้ความรุนแรงในครอบครัว</li>
        <li>[ ' . $side_4->side_4_2_9 . ' ]&nbsp;&nbsp; นักศึกษาถูกทารุณ / ทำร้ายจากบุคคลในครอบครัวผู้อื่น</li>
        <li>[ ' . $side_4->side_4_2_10 . ' ]&nbsp;&nbsp; ถูกล่วงละเมิดทางเพศ</li>
        <li>[ ' . $side_4->side_4_2_11 . ' ]&nbsp;&nbsp; ถูกรังแก/ข่มขู่/รีดไถ เงินหรือสิ่งของ</li>
        <li>[ ' . $side_4->side_4_2_12 . ' ]&nbsp;&nbsp; ไม่มีผู้ดูแล</li>
        <li>[ ' . $side_4->side_4_2_13 . ' ]&nbsp;&nbsp; ได้รับผลกระทบจากโรคร้ายแรง</li>
        <li>[ ' . $side_4_2_14_check . ' ]&nbsp;&nbsp; อื่นๆระบุ <span>' . $side_4_2_14 . '</span></li>
      </ul>
    </td>
  </tr>
</table>';
$pdf->writeHTML($html, true, false, true, true, '');
$pdf->Ln(3);

// ข้อ 5

$pdf->SetFont('thsarabun', 'B', 14);
$pdf->Cell(190, 0, "5.ด้านอื่นๆ (ดูรายละเอียดตามเกณฑ์การคัดกรองของโรงเรียน)", 0, 1, 'L');
$pdf->SetFont('thsarabun', '', 14);
$pdf->Ln(2);

$side_5->side_5_1 == "ปกติ" ? $side_5_1_activeNormal = "" : $side_5_1_activeNormal = 'style="list-style-type: circle;"';
$side_5->side_5_1 == "เสี่ยง" ? $side_5_1_activeRisk = "" : $side_5_1_activeRisk = 'style="list-style-type: circle;"';
$side_5->side_5_1 == "มีปัญหา" ? $side_5_1_activeProblem = "" : $side_5_1_activeProblem = 'style="list-style-type: circle;"';

$side_5->side_5_2 == "ปกติ" ? $side_5_2_activeNormal = "" : $side_5_2_activeNormal = 'style="list-style-type: circle;"';
$side_5->side_5_2 == "เสี่ยง" ? $side_5_2_activeRisk = "" : $side_5_2_activeRisk = 'style="list-style-type: circle;"';
$side_5->side_5_2 == "มีปัญหา" ? $side_5_2_activeProblem = "" : $side_5_2_activeProblem = 'style="list-style-type: circle;"';

$side_5->side_5_3 == "ปกติ" ? $side_5_3_activeNormal = "" : $side_5_3_activeNormal = 'style="list-style-type: circle;"';
$side_5->side_5_3 == "เสี่ยง" ? $side_5_3_activeRisk = "" : $side_5_3_activeRisk = 'style="list-style-type: circle;"';
$side_5->side_5_3 == "มีปัญหา" ? $side_5_3_activeProblem = "" : $side_5_3_activeProblem = 'style="list-style-type: circle;"';

$html = '
<table>
  <tr>
    <td style="width: 5%;"></td>
    <td style="width: 25%;">5.1	ด้านเสพติด</td>
    <td style="width: 20%;"><ul ' . $side_5_1_activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_5_1_activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_5_1_activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
  <tr>
    <td style="width: 5%;"></td>
    <td style="width: 25%;">5.2	ด้านพฤติกรรมทางเพศ /เกเร</td>
    <td style="width: 20%;"><ul ' . $side_5_2_activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_5_2_activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_5_2_activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
  <tr>
    <td style="width: 5%;"></td>
    <td style="width: 25%;">5.3	ด้านความปลอดภัย </td>
    <td style="width: 20%;"><ul ' . $side_5_3_activeNormal . '><li>ปกติ</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_5_3_activeRisk . '><li>เสี่ยง</li></ul></td>
    <td style="width: 20%;"><ul ' . $side_5_3_activeProblem . '><li>มีปัญหา</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, '');

$pdf->lastPage();
$pdf->Output('แบบบันทึกคัดกรองนักศึกษารายบุคคล-'.$fullname.'.pdf', 'I');
$pdf->Close();


function convertDateToThaidate($date)
{
  $originalDate = $date;
  list($year, $month, $day) = explode('-', $originalDate);
  $thaiDate = $day . '/' . $month . '/' . ($year + 543);

  return $thaiDate; // Output: 9 พฤษภาคม 2566
}
