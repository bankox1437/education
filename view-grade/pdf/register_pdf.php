<?php
session_start();
if (!isset($_SESSION["user_data"])) {
    Header("Location: ../login");
}
require_once('../../assets/TCPDF/tcpdf.php');
include "../../config/class_database.php";

$DB = new Class_Database();

class MYPDF extends TCPDF
{
    // Custom method to create dotted underline
    public function DottedUnderline($x, $y, $w, $txt, $dot_spacing = 0.5, $font_size = 16)
    {
        // Get the width of the text
        $text_width = $this->GetStringWidth($txt);

        // Calculate how many dots we need
        $dot_count = floor($w / $dot_spacing);

        // Position at x, y
        $this->SetXY($x, $y);

        // Draw the dots
        for ($i = 0; $i < $dot_count; ++$i) {
            $this->Write(0, '.');
            $this->SetX($this->GetX() + $dot_spacing);
        }

        // Now write the text over it
        $this->SetFont('thsarabun', '', $font_size);
        $this->Text($x + ($w - $text_width) / 2 + 4, $y - 2, $txt);
    }

    public function DrawFormattedIDNumberBoxes($x, $y, $value = "")
    {
        $this->SetFillColor(255, 255, 255); // White fill
        // Define the groups and the number of boxes in each group
        $groups = [1, 4, 5, 2, 1];
        $box_width = 5;
        $box_height = 6;
        $dash_length = 5; // Length of the dash or space for the dash

        $digits = str_split($value);
        $indexDigits = 0;
        foreach ($groups as $num_boxes) {
            for ($i = 0; $i < $num_boxes; ++$i) {
                // Draw each box
                $this->Rect($x, $y, $box_width, $box_height, 'DF');
                $this->Text($x + 0.5, $y - 0.7, $digits[$indexDigits]);
                $x += $box_width; // Move X to the right for the next box
                $indexDigits++; // increment index number of digits
            }
            $x += $dash_length; // Move X to the right for the space of the dash
        }
    }

    public function convertMonthToThai($month)
    {
        $engMonths = array(
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        );

        $thaiMonths = array(
            'มกราคม',
            'กุมภาพันธ์',
            'มีนาคม',
            'เมษายน',
            'พฤษภาคม',
            'มิถุนายน',
            'กรกฎาคม',
            'สิงหาคม',
            'กันยายน',
            'ตุลาคม',
            'พฤศจิกายน',
            'ธันวาคม'
        );

        $monthIndex = array_search($month, $engMonths);
        if ($monthIndex !== false) {
            return $thaiMonths[$monthIndex];
        }

        return false; // If month is not found
    }
}

$sql = "SELECT\n" .
    "	c.*,\n" .
    "   std.std_prename, \n" .
    "	std.std_name,\n" .
    "	std.national_id,\n" .
    "	std.std_class,\n" .
    "	std.std_code ,\n" .
    "	edu.name edu_name\n" .
    "FROM\n" .
    "	vg_credit c\n" .
    "	LEFT JOIN tb_students std ON c.std_id = std.std_id \n" .
    "	LEFT JOIN tb_users u ON c.user_create = u.id\n" .
    "	LEFT JOIN tbl_non_education edu ON u.edu_id = edu.id\n";

$where = " WHERE\n" .
    "	c.credit_id = :credit_id";

$arr_data  = [];

if (isset($_GET['term']) && !empty($_GET['term'])) {
    $where = " WHERE\n" .
        "	c.term_id = :term_id AND c.user_create = :user_create";
    $arr_data = ["term_id" => $_GET['term'], "user_create" => $_SESSION['user_data']->id];
} else {
    $credit_id = $_GET['credit_id'];
    $arr_data = ["credit_id" => $credit_id];
}

$sql = $sql . $where;

$data_result = $DB->Query($sql, $arr_data);
$data_results = json_decode($data_result);

// if (count($data_results) <= 0) {
//     header('location: ../../404');
//     exit();
// }

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$fullnameTitle = 'ใบลงทะเบียน';
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
$pdf->SetMargins(5, 5, 5, false);

$sql = "SELECT U.edu_id,EDU.name edu_name,DIS.name_th dis_name FROM tb_users U\n" .
    "LEFT JOIN tbl_non_education EDU ON U.edu_id = EDU.id\n" .
    "LEFT JOIN tbl_district DIS ON EDU.district_id = DIS.id\n" .
    "WHERE U.id = :id";
$userProDisSub = $DB->Query($sql, ["id" => $_SESSION['user_data']->id]);
$userProDisSub = json_decode($userProDisSub);
$userProDisSub = $userProDisSub[0];

foreach ($data_results as $key => $data_result) {
    $credit_id = $data_result->credit_id;
    $pdf->AddPage();

    $pdf->SetFont('thsarabun', 'B', 16);
    $pdf->Cell(185, 0, "ใบลงทะเบียน", 0, 1, 'C');
    $pdf->Cell(185, 0, "ศูนย์ส่งเสริมการเรียนรู้ระดับอำเภอ" . $userProDisSub->dis_name, 0, 1, 'C');
    $pdf->Cell(185, 0, "", 0, 1, 'C');
    $pdf->SetFont('thsarabun', '', 16);

    // $pdf->Cell(15, 8, "ชื่อ-สกุล ", 0, 0, 'L');
    // $pdf->Cell(73, 0, "  ", 0, 0, 'L');
    // $pdf->Cell(8, 8, "ชั้น", 0, 0, 'L');
    // $pdf->Cell(25, 0, '', 0, 1, 'L');

    // $pdf->Cell(38, 8, "เลขประจำตัวประชาชน", 0, 0, 'L');
    // $pdf->Cell(5, 0, "1 - 4799 - 00455 - 93 - 7", 0, 1, 'L');

    // $pdf->Cell(38, 8, "รหัสประจำตัวนักศึกษา", 0, 0, 'L');
    // $pdf->Cell(5, 0, "62011211050", 0, 1, 'L');

    $classText = 'มัธยมศึกษาตอนปลาย';
    if ($data_result->std_class == 'ประถม') {
        $classText =  'ประถมศึกษา';
    } else if ($data_result->std_class == 'ม.ต้น') {
        $classText =  'มัธยมศึกษาตอนต้น';
    }

    $pdf->Text(10, 25, "ระดับ");
    $pdf->Text(20, 25, $classText);

    $pdf->Text(55, 25, "ภาคเรียน");
    $pdf->Text(71, 25, $data_result->term_id);

    $pdf->Text(88, 25, "กลุ่ม");
    $pdf->Text(97, 25, $data_result->edu_name);

    $pdf->Text(10, 33, "ชื่อ-สกุล");
    $pdf->Text(24, 33, $data_result->std_prename . $data_result->std_name);

    $pdf->Text(10, 41, "เลขประจำตัวประชาชน");
    $pdf->DrawFormattedIDNumberBoxes(50, 41.5, $data_result->national_id);

    $pdf->Text(10, 49, "รหัสประจำตัวนักศึกษา");
    $pdf->Text(48, 49, $data_result->std_code);

    $pdf->Ln(10);

    // $table = "<table width=\"100%\">";
    // $table .= "<tr>";
    // $table .= "     <th width=\"40%\" style=\"border: 1px solid #000;\" align=\"center\"><b>ตารางการเรียนรู้</b></th>";
    // $table .= "     <th width=\"12%\" style=\"border: 1px solid #000;\" align=\"center\"><b>รหัสวิชา</b></th>";
    // $table .= "     <th width=\"12%\" style=\"border: 1px solid #000;\" align=\"center\"><b>จำนวน หน่วยกิต</b></th>";
    // $table .= "     <th width=\"12%\" style=\"border: 1px solid #000;\" align=\"center\"><b>ลงทะเบียน</b></th>";
    // $table .= "     <th width=\"12%\" style=\"border: 1px solid #000;\" align=\"center\"><b>ลงทะเบียน</b></th>";
    // $table .= "     <th width=\"12%\" style=\"border: 1px solid #000;\" align=\"center\"><b>หมายเหตุ</b></th>";
    // $table .= "</tr>";


    // -------------------------วิชาบังคับ---------------------------------------
    $sql = "SELECT * FROM vg_credit_compulsory WHERE credit_id = :credit_id";
    $data = $DB->Query($sql, ['credit_id' => $credit_id]);
    $compulsory_data = json_decode($data);

    // -------------------------วิชาเลือกบังคับ---------------------------------------
    $sql = "SELECT * FROM vg_credit_electives WHERE credit_id = :credit_id";
    $data = $DB->Query($sql, ['credit_id' => $credit_id]);
    $electives_data = json_decode($data);

    // -------------------------วิชาเลือกเสรี---------------------------------------
    $sql = "SELECT * FROM vg_credit_free_electives WHERE credit_id = :credit_id";
    $data = $DB->Query($sql, ['credit_id' => $credit_id]);
    $free_electives_data = json_decode($data);

    $pdf->SetFont('thsarabun', 'B', 14);
    $pdf->Cell(79.5, 10, "ตารางการเรียนรู้", 1, 0, 'C');
    $pdf->Cell(24, 10, "รหัสวิชา", 1, 0, 'C');
    $pdf->Cell(24, 10, "จำนวนหน่วยกิต", 1, 0, 'C');
    $pdf->Cell(24, 10, "ลงทะเบียน", 1, 0, 'C');
    $pdf->Cell(24, 10, "เทียบโอน", 1, 0, 'C');
    $pdf->Cell(24, 10, "หมายเหตุ", 1, 1, 'C');

    $pdf->Cell(79.5, 5, "วิชาบังคับ", 1, 0, 'L');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 1, 'C');

    $countCredit = 0;
    foreach ($compulsory_data as $row) {
        // Draw the table content
        $pdf->SetFont('thsarabun', '', 14);
        $pdf->Cell(79.5, 5, $row->sub_name, 1, 0, 'L');
        $pdf->Cell(24, 5, $row->sub_id, 1, 0, 'C');
        $pdf->Cell(24, 5, $row->credit, 1, 0, 'C');
        $pdf->Cell(24, 5, "/", 1, 0, 'C');
        $pdf->Cell(24, 5, "", 1, 0, 'C');
        $pdf->Cell(24, 5, "", 1, 1, 'C');
        $countCredit += $row->credit;
    }

    $pdf->Cell(79.5, 5, "", 1, 0, 'L');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 1, 'C');

    $pdf->SetFont('thsarabun', 'B', 14);
    $pdf->Cell(79.5, 5, "วิชาเลือกบังคับ", 1, 0, 'L');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 1, 'C');

    foreach ($electives_data as $row) {
        // Draw the table content
        $pdf->SetFont('thsarabun', '', 14);
        $pdf->Cell(79.5, 5, $row->sub_name, 1, 0, 'L');
        $pdf->Cell(24, 5, $row->sub_id, 1, 0, 'C');
        $pdf->Cell(24, 5, $row->credit, 1, 0, 'C');
        $pdf->Cell(24, 5, "/", 1, 0, 'C');
        $pdf->Cell(24, 5, "", 1, 0, 'C');
        $pdf->Cell(24, 5, "", 1, 1, 'C');
        $countCredit += $row->credit;
    }

    $pdf->Cell(79.5, 5, "", 1, 0, 'L');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 1, 'C');

    $pdf->SetFont('thsarabun', 'B', 14);
    $pdf->Cell(79.5, 5, "วิชาเลือกเสรี", 1, 0, 'L');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 1, 'C');

    foreach ($free_electives_data as $row) {
        // Draw the table content
        $pdf->SetFont('thsarabun', '', 14);
        $pdf->Cell(79.5, 5, $row->sub_name, 1, 0, 'L');
        $pdf->Cell(24, 5, $row->sub_id, 1, 0, 'C');
        $pdf->Cell(24, 5, $row->credit, 1, 0, 'C');
        $pdf->Cell(24, 5, "/", 1, 0, 'C');
        $pdf->Cell(24, 5, "", 1, 0, 'C');
        $pdf->Cell(24, 5, "", 1, 1, 'C');
        $countCredit += $row->credit;
    }

    $pdf->Cell(79.5, 5, "", 1, 0, 'L');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 1, 'C');

    $pdf->SetFont('thsarabun', '', 14);
    $pdf->Cell(79.5, 5, "รวมหน่วยกิต", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, $countCredit, 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 0, 'C');
    $pdf->Cell(24, 5, "", 1, 1, 'C');


    $yAfterHTML = $pdf->GetY();
    $yAfterHTML += 10;

    $pdf->SetFont('thsarabun', '', 14);
    $pdf->Text(12, $yAfterHTML, "ลงชื่อ");
    $pdf->DottedUnderline(20, $yAfterHTML + 0.5, 17, '');
    $pdf->SetFont('thsarabun', '', 14);
    $pdf->Text(64, $yAfterHTML, "นักศึกษา");

    $stdName = $data_result->std_prename . $data_result->std_name;
    $stdNameWidth = $pdf->GetStringWidth($stdName); // Get the width of the name
    $centeredXstd = 41 - ($stdNameWidth / 2); // 136 is the center between 117 and 166
    $pdf->Text($centeredXstd, $yAfterHTML + 10 + 0.5, "( " . $stdName . " )");


    $sql = "SELECT\n" .
        "	* \n" .
        "FROM\n" .
        "	vg_list_name \n" .
        "WHERE\n" .
        "	user_create = :user_create";
    $data_result_name = $DB->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
    $data_result_name = json_decode($data_result_name);

    $name1 = 'ยังไม่ได้ตั้งค่า';
    $name2 = 'ยังไม่ได้ตั้งค่า';
    $name3 = 'ยังไม่ได้ตั้งค่า';
    $name4 = 'ยังไม่ได้ตั้งค่า';

    if (count($data_result_name) > 0) {
        $name1 = !empty($data_result_name[0]->name1) ? $data_result_name[0]->name1 : $name1;
        $name2 = !empty($data_result_name[0]->name2) ? $data_result_name[0]->name2 : $name2;
        $name3 = !empty($data_result_name[0]->name3) ? $data_result_name[0]->name3 : $name3;
        $name4 = !empty($data_result_name[0]->name4) ? $data_result_name[0]->name4 : $name4;
    }

    $pdf->Text(100, $yAfterHTML, "ลงชื่อ");
    $pdf->DottedUnderline(108, $yAfterHTML + 0.5, 15, '');
    $pdf->SetFont('thsarabun', '', 14);
    $pdf->Text(147, $yAfterHTML, "เจ้าหน้าที่การศึกษาขั้นพื้นฐาน");

    $name = $name1;
    $nameWidth = $pdf->GetStringWidth($name); // Get the width of the name
    $centeredX = 130 - ($nameWidth / 2); // 136 is the center between 117 and 166
    $pdf->Text($centeredX, $yAfterHTML + 10 + 0.5, "( " . $name . " )");



    $pdf->Text(110, $yAfterHTML + 25, "ลงชื่อ");
    $pdf->DottedUnderline(118, $yAfterHTML + 25 + 0.5, 15, '');
    $pdf->SetFont('thsarabun', '', 14);
    $pdf->Text(157, $yAfterHTML + 25, "นายทะเบียน");

    $name = $name2;
    $nameWidth = $pdf->GetStringWidth($name); // Get the width of the name
    $centeredX = 135 - ($nameWidth / 2); // 136 is the center between 117 and 166
    $pdf->Text($centeredX, $yAfterHTML + 25 + 10 + 0.5, "( " . $name . " )");

    $currentDay = date('N');
    $currentMonth = date('F');
    $currentYear = date('Y');

    $date = 'วันที่........เดือน ' . $pdf->convertMonthToThai($currentMonth) . ' พ.ศ. ' . ($currentYear + 543);
    $dateWidth = $pdf->GetStringWidth($date); // Get the width of the date
    $centeredX = 138 - ($dateWidth / 2); // 136 is the center between 117 and 166
    $pdf->Text($centeredX, $yAfterHTML + 45, $date);

    $typeName = $name4;
    $pdf->SetFont('thsarabun', '', 14);
    $pdf->Text(12, $yAfterHTML + 45, "ลงชื่อ");
    $pdf->DottedUnderline(20, $yAfterHTML  + 45.5, 15, '');
    $pdf->SetFont('thsarabun', '', 14);
    $pdf->Text(59, $yAfterHTML + 45, $typeName);

    $stdName = $name3;
    $stdNameWidth = $pdf->GetStringWidth($stdName); // Get the width of the name
    $centeredXstd = 36 - ($stdNameWidth / 2); // 136 is the center between 117 and 166
    $pdf->Text($centeredXstd, $yAfterHTML + 55, "( " . $stdName . " )");

    $pdf->lastPage();
}
$pdf->Output('ข้อมูลนักศึกษารายบุคคล - ' . '.pdf', 'I');
$pdf->Close();
