<?php
session_start();
if (!isset($_SESSION["user_data"])) {
    Header("Location: ../login");
}
require_once('../../assets/TCPDF/tcpdf.php');
include "../../config/class_database.php";

$DB = new Class_Database();
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);



// set document information
$pdf->SetCreator(PDF_CREATOR);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetMargins(10, 3, 10, false);

$form_id = htmlentities($_GET['form_visit_sum_id']);
$sql = "SELECT * FROM stf_tb_visit_summary\n" .
    "WHERE v_sum_id = :form_id";

$data = $DB->Query($sql, ['form_id' => $form_id]);
$dataVisitSum = json_decode($data);
if (count($dataVisitSum) == 0) {
    header('location: ../404');
    exit();
}

$dataVisitSum = $dataVisitSum[0];

$fullnameTitle = 'แบบสรุปการเยี่ยมบ้านนักศึกษา-' . $dataVisitSum->std_class; // . $dataBehavior[0]->std_prename . $dataBehavior[0]->std_name;
$pdf->SetTitle($fullnameTitle);

$pdf->AddPage();
$pdf->SetFont('thsarabun', '', 12);

$pdf->Cell(190, 0, "แบบ ด.ล. 1.3", 0, 1, 'R');
$pdf->SetFont('thsarabun', 'B', 16);

$pdf->Cell(70, 5, "", 0, 0, 'R');
$pdf->Cell(50, 5, "แบบสรุปการเยี่ยมบ้านนักศึกษา", 0, 1, 'C');

$pdf->Ln(2);

$border_bottom = array(
    'B' => array('width' => 0.2, 'cap' => 'butt', 'dash' => 1, 'color' => array(0, 0, 0)),
);
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(25, 8, "จำนวนนักศึกษา", 0, 0, 'L');
$pdf->Cell(10, 0, "  " . $dataVisitSum->count_std, $border_bottom, 0, 'L');

$pdf->Cell(6, 8, "ชั้น", 0, 0, 'L');
$pdf->Cell(15, 0, " " . $dataVisitSum->std_class, $border_bottom, 0, 'L');
$pdf->Cell(18, 8, "ปีการศึกษา", 0, 0, 'L');
$pdf->Cell(30, 0, " " . $dataVisitSum->year, $border_bottom, 1, 'L');

$pdf->Ln(5);
$table = "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"55%\">";
$table .= "<tr>";
$table .= "<th width=\"40%\" style=\"border: 1px solid #000;\" align=\"center\"><b>รายการ</b></th>";
$table .= "<th width=\"30%\" style=\"border: 1px solid #000;\" align=\"center\"><b>ข้อมูล /รายละเอียดที่พบ</b></th>";
$table .= "<th width=\"15%\" style=\"border: 1px solid #000;\" align=\"center\"><b>รวม (คน)</b></th>";
$table .= "<th width=\"15%\" style=\"border: 1px solid #000;\" align=\"center\"><b>ร้อยละ</b></th>";

$table .= "</tr>";

$sql = "SELECT\n" .
    "	v_det.*,\n" .
    "	sub_t.sub_title_detail,\n" .
    "   t.title_id,\n" .
    "   t.title_detail\n" .
    "FROM\n" .
    "	stf_tb_visit_summary_detail v_det\n" .
    "	LEFT JOIN stf_tb_visit_summary_subtitle sub_t ON v_det.sub_title_id = sub_t.sub_title_id \n" .
    "   LEFT JOIN stf_tb_visit_summary_title t ON sub_t.title_id = t.title_id \n" .
    "WHERE\n" .
    "	v_sum_id = :form_id ORDER BY t.title_id";

$data = $DB->Query($sql, ['form_id' => $form_id]);
$dataVisitSumDetail = json_decode($data);

$check_title = "";
$topic_check = "";
$check_sub = "";
$index_sub = 0;
for ($i = 0; $i < count($dataVisitSumDetail); $i++) {
    if ($check_title == $dataVisitSumDetail[$i]->title_detail) {
        $topic_check = "";
    } else {
        $topic_check = $dataVisitSumDetail[$i]->title_id . "." . $dataVisitSumDetail[$i]->title_detail;
        $check_title = $dataVisitSumDetail[$i]->title_detail;
    }

    if ($check_sub == $dataVisitSumDetail[$i]->title_id) {
        $index_sub = $index_sub + 1;
    } else {
        $check_sub =  $dataVisitSumDetail[$i]->title_id;
        $index_sub = 1;
    }
    if ($i == 27) {
        $table .= "<tr>";
        $table .= "<td style=\"border: none\" align=\"left\"></td>";
        $table .= "<td style=\"border: none\" align=\"left\"></td>";
        $table .= "<td style=\"border: none\"></td>";
        $table .= "<td style=\"border: none\"></td>";
        $table .= "</tr>";
    }

    if ($i == 58) {
        $table .= "<tr>";
        $table .= "<td style=\"border: none\" align=\"left\"></td>";
        $table .= "<td style=\"border: none\" align=\"left\"></td>";
        $table .= "<td style=\"border: none\"></td>";
        $table .= "<td style=\"border: none\"></td>";
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<td style=\"border: none\" align=\"left\"></td>";
        $table .= "<td style=\"border: none\" align=\"left\"></td>";
        $table .= "<td style=\"border: none\"></td>";
        $table .= "<td style=\"border: none\"></td>";
        $table .= "</tr>";
    }

    $table .= "<tr>";
    $table .= "<td style=\"border: 1px solid #000;\" align=\"left\">&nbsp;" .  $topic_check . "</td>";
    $table .= "<td style=\"border: 1px solid #000;\" align=\"left\">&nbsp;" . $dataVisitSumDetail[$i]->title_id . "." . $index_sub . " " . $dataVisitSumDetail[$i]->sub_title_detail . "</td>";
    $table .= "<td style=\"border: 1px solid #000;\">&nbsp;" . $dataVisitSumDetail[$i]->std_quantity . "</td>";
    $table .= "<td style=\"border: 1px solid #000;\">&nbsp;" . $dataVisitSumDetail[$i]->percent_quantity . "</td>";
    $table .= "</tr>";
}
$table .= "</table>";

$pdf->writeHTML($table, false, false, true, false, 'C');
$pdf->Ln(2);


$pdf->lastPage();
$pdf->Output('แบบสรุปการเยี่ยมบ้านนักศึกษา' . $dataVisitSum->std_class . '.pdf', 'I');
$pdf->Close();
