<?php
// session_start();
// if (!isset($_SESSION["user_data"])) {
//     Header("Location: ../login");
// }
require_once('../../assets/TCPDF/tcpdf.php');
include "../../config/class_database.php";

$DB = new Class_Database();
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetTitle("แบบติดตามหลังจบการศึกษา");
$border_bottom = array(
  'B' => array('width' => 0.2, 'cap' => 'butt', 'dash' => 1, 'color' => array(0, 0, 0)),
);

// set document information
$pdf->SetCreator(PDF_CREATOR);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetMargins(20, 10, 20, false);

$sql = "SELECT\n" .
  "	after_g.*,\n" .
  "	std_prename,\n" .
  "	std.std_name,\n" .
  "	IFNULL( edu.NAME, edu_o.NAME ) edu_name,(\n" .
  "	SELECT\n" .
  "		name_th \n" .
  "	FROM\n" .
  "		tbl_sub_district \n" .
  "	WHERE\n" .
  "		edu.sub_district_id = tbl_sub_district.id \n" .
  "	) sub_district,\n" .
  "	( SELECT name_th FROM tbl_district WHERE edu.district_id = tbl_district.id ) district,\n" .
  "	( SELECT name_th FROM tbl_provinces WHERE edu.province_id = tbl_provinces.id ) province \n" .
  "FROM\n" .
  "	stf_tb_after_gradiate after_g\n" .
  "	LEFT JOIN tb_users u ON after_g.user_create = u.id\n" .
  "	LEFT JOIN tbl_non_education_other edu_o ON u.edu_id = edu_o.id\n" .
  "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n" .
  "	LEFT JOIN tb_students std ON after_g.std_id = std.std_id\n" .
  "WHERE after_g.after_id = :after_id";
$data = $DB->Query($sql, ["after_id" => $_GET['after_id']]);
$data_after = json_decode($data);

if (count($data_after) == 0) {
  header('location: ../../404');
  exit();
}
$data_after = $data_after[0];
// print_r($data_after);

$pdf->AddPage();
$pdf->SetFont('thsarabun', 'B', 16);

$pdf->Ln(9); //เว้นบรรทัด
$pdf->Cell(180, 5, "แบบติดตามหลังจบการศึกษา", 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('thsarabun', '', 14);
$pdf->Cell(12, 5, "ชื่อ-สกุล", 0, 0, 'L');
$pdf->Cell(160, 5, "  " . $data_after->std_prename . $data_after->std_name, $border_bottom, 1, 'L');
$pdf->Ln(1);
$pdf->Cell(32, 1, "จบการศึกษาจาก ตำบล ", 0, 0, 'L');
$pdf->Cell(40, 6, $data_after->sub_district, $border_bottom, 0, 'L');
$pdf->Cell(10, 5, "อำเภอ", 0, 0, 'L');
$pdf->Cell(40, 6, $data_after->district, $border_bottom, 0, 'L');
$pdf->Cell(11, 5, "จังหวัด", 0, 0, 'L');
$pdf->Cell(40, 6, $data_after->province, $border_bottom, 1, 'L');
$pdf->Ln(1);
$pdf->Cell(19, 5, "ระดับชั้นที่จบ ", 0, 0, 'L');

$end_class_text = "";
if ($data_after->end_class == 1) {
  $end_class_text = "ประถม";
} else if ($data_after->end_class == 2) {
  $end_class_text = "ม.ต้น";
} else if ($data_after->end_class == 3) {
  $end_class_text = "ม.ปลาย";
}
$pdf->Cell(33, 5, $end_class_text, $border_bottom, 1, 'L');

$pdf->Cell(22, 5, "ปีการศึกษาที่จบ", 0, 0, 'L');
$pdf->Cell(30, 5, $data_after->end_year, $border_bottom, 1, 'L');

$pdf->Ln(2);
$activeVeryGood = 'style="list-style-type: circle;"';
$pdf->Cell(185, 0, "วุฒิการศึกษาที่ได้รับ นำไปใช้ในด้านใด", 0, 1, 'L');
$edu_qualification1 = ($data_after->edu_qualification != 1) ? 'style="list-style-type: circle;"' : '';
$edu_qualification_school = ($data_after->edu_qualification != 1 && !$data_after->edu_qualification_school) ? '' : $data_after->edu_qualification_school;

$edu_qualification2 = ($data_after->edu_qualification != 2) ? 'style="list-style-type: circle;"' : '';
$edu_qualification3 = ($data_after->edu_qualification != 3) ? 'style="list-style-type: circle;"' : '';
$edu_qualification4 = ($data_after->edu_qualification != 4) ? 'style="list-style-type: circle;"' : '';
$edu_qualification5 = ($data_after->edu_qualification != 5) ? 'style="list-style-type: circle;"' : '';
$edu_qualification6 = ($data_after->edu_qualification != 6) ? 'style="list-style-type: circle;"' : '';
$table_1 = '
<table>
  <tr>
    <td style="width: 100%;"><ul ' . $edu_qualification1 . '><li>ศึกษาต่อในระดับที่สูงขึ้น ' . ' ( ' . $edu_qualification_school . ' )' . '</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $edu_qualification2 . '><li>นำไปสมัครงานเอกชน</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $edu_qualification3 . '><li>นำไปใช้ปรับเงินเดือน</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $edu_qualification4 . '><li>สอบเข้ารับราชการ</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $edu_qualification5 . '><li>สมัครเป็นนักการเมืองท้องถิ่น</li></ul></td>
  </tr>
  <tr>
	  <td style="width: 100%;"><ul ' . $edu_qualification6 . '><li>สมัครเป็นอาสาสมัคร</li></ul></td>
  </tr>
</table>';
$pdf->writeHTML($table_1, false, false, true, false, 'C');


$pdf->Cell(185, 0, "หลังจบการศึกษาท่านจะกลับไปเยี่ยมสถานศึกษาเดิมหรือไม่", 0, 1, 'L');
$visit_edu1 = ($data_after->visit_edu != 1) ? 'style="list-style-type: circle;"' : '';
$visit_edu2 = ($data_after->visit_edu != 2) ? 'style="list-style-type: circle;"' : '';
$visit_edu3 = ($data_after->visit_edu != 3) ? 'style="list-style-type: circle;"' : '';
$table_2 = '
<table>
  <tr>
    <td style="width: 100%;"><ul ' . $visit_edu1 . '><li>กลับไปแน่นอน</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $visit_edu2 . '><li>ขอคิดดูก่อน</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $visit_edu3 . '><li>ไม่กลับไป</li></ul></td>
  </tr>
</table>';

$pdf->writeHTML($table_2, false, false, true, false, 'C');

$pdf->Cell(185, 0, "หลังจบการศึกษาท่านยินดีให้ความร่วมมือในการพัฒนาสถานศึกษาเดิมหรือไม่", 0, 1, 'L');
$cooperate_edu1 = ($data_after->cooperate_edu != 1) ? 'style="list-style-type: circle;"' : '';
$cooperate_edu2 = ($data_after->cooperate_edu != 2) ? 'style="list-style-type: circle;"' : '';
$cooperate_edu3 = ($data_after->cooperate_edu != 3) ? 'style="list-style-type: circle;"' : '';
$table_3 = '
<table>
  <tr>
    <td style="width: 100%;"><ul ' . $cooperate_edu1 . '><li>ยินดีให้ความร่วมมือ</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $cooperate_edu2 . '><li>ให้ความร่วมมือตามโอกาส</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $cooperate_edu3 . '><li>ขอคิดดูก่อน</li></ul></td>
  </tr>
</table>';

$pdf->writeHTML($table_3, false, false, true, false, 'C');

$pdf->Cell(185, 0, "ความพึงพอใจต่อสถานศึกษาที่จบมาอยู่ในระดับ", 0, 1, 'L');

$satisfaction1 = ($data_after->satisfaction != 1) ? 'style="list-style-type: circle;"' : '';
$satisfaction2 = ($data_after->satisfaction != 2) ? 'style="list-style-type: circle;"' : '';
$satisfaction3 = ($data_after->satisfaction != 3) ? 'style="list-style-type: circle;"' : '';
$satisfaction4 = ($data_after->satisfaction != 4) ? 'style="list-style-type: circle;"' : '';
$satisfaction5 = ($data_after->satisfaction != 5) ? 'style="list-style-type: circle;"' : '';

$table_4 = '
<table>
  <tr>
    <td style="width: 100%;"><ul ' . $satisfaction1 . '><li>ดีมาก</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $satisfaction2 . '><li>ดี</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $satisfaction3 . '><li>ปานกลาง</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $satisfaction4 . '><li>พอใช้</li></ul></td>
  </tr>
  <tr>
    <td style="width: 100%;"><ul ' . $satisfaction5 . '><li>ควรปรับปรุง</li></ul></td>
  </tr>
</table>';

$pdf->writeHTML($table_4, false, false, true, false, 'C');

$pdf->lastPage();
$pdf->Output('แบบติดตามหลังจบการศึกษา.php', 'I');
$pdf->Close();
