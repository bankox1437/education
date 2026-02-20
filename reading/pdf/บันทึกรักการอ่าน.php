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
}

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

$id = $_GET['id'];

$sql = "SELECT rb.*,std.std_code,std.std_class,std.std_prename,std.std_name,
sub.name_th sub_district_name,
dis.name_th district_name,
pro.name_th province_name,
usr.name,
usr.surname
FROM rd_read_books rb
LEFT JOIN tb_students std ON rb.user_create = std.std_id
LEFT JOIN tb_users usr ON std.user_create = usr.id
LEFT JOIN tbl_non_education edu on usr.edu_id = edu.id
LEFT JOIN tbl_sub_district sub on edu.sub_district_id = sub.id
LEFT JOIN tbl_district dis on edu.district_id = dis.id
LEFT JOIN tbl_provinces pro on edu.province_id = pro.id
WHERE rb.id = :id\n";

$data_result = $DB->Query($sql, ['id' => $id]);
$data_results = json_decode($data_result);

// if (count($data_results) <= 0) {
//     header('location: ../../404');
//     exit();
// }

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$fullnameTitle = 'บันทึก รักการอ่าน - ' . $data_results[0]->std_prename . $data_results[0]->std_name;
$pdf->SetTitle($fullnameTitle);
// $border_bottom = array(
//     'B' => array('width' => 0.2, 'cap' => 'butt', 'dash' => 1, 'color' => array(0, 0, 0)),
// );

$border_bottom = 0;

$pdf->SetCreator(PDF_CREATOR);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->SetMargins(20, 5, 20, false);

$pdf->AddPage();

$pdf->SetFont('thsarabun', 'B', 32);
$pdf->Cell(160, 0, "บันทึก รักการอ่าน", 0, 1, 'C');
$pdf->Ln(5);
// Extract data from $data_results array
$date = $data_results[0]->date ?? '';
$month = $data_results[0]->month ?? '';
$year = $data_results[0]->year ?? '';
$title = $data_results[0]->title ?? '';
$author = $data_results[0]->author ?? '';
$publisher = $data_results[0]->publisher ?? '';
$type = $data_results[0]->type ?? '';
$summary = $data_results[0]->summary ?? '';
$analysis = $data_results[0]->analysis ?? '';
$reference = $data_results[0]->reference ?? '';
$image = $data_results[0]->image ?? '';

// Add data to PDF
$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(17, 8, "รหัส นศ. :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(30, 8, "  " . $data_results[0]->std_code, $border_bottom, 0, 'L');

$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(16, 8, "ชื่อ-สกุล :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(55, 8, "  " . $data_results[0]->std_prename . $data_results[0]->std_name, $border_bottom, 0, 'L');

$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(17, 8, "ระดับชั้น :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(30, 8, "  " . $data_results[0]->std_class, $border_bottom, 1, 'L');

$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(12, 8, "ตำบล :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(35, 8, "  " . $data_results[0]->sub_district_name, $border_bottom, 0, 'L');

$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(16, 8, "อำเภอ :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(55, 8, "  " . $data_results[0]->district_name, $border_bottom, 0, 'L');

$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(15, 8, "จังหวัด :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(30, 8, "  " . $data_results[0]->province_name, $border_bottom, 1, 'L');

$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(28, 8, "ครูผู้รับผิดชอบ :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(30, 8, "  " . $data_results[0]->name . " " . $data_results[0]->surname, $border_bottom, 1, 'L');

$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(23, 8, "วันที่ (Date) :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(25, 8, "  " . $date, $border_bottom, 0, 'L');

$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(28, 8, "เดือน (Month) :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(43, 8, "  " . $thaiMonths[$month - 1], $border_bottom, 0, 'L');

$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(17, 8, "ปี (Year) :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(29, 8, "  " . $year, $border_bottom, 1, 'L');

// Title
$pdf->Ln(4);
$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(54, 8, "ชื่อหนังสือ/สื่อ (Title/Media) :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(118, 8, "  " . $title, $border_bottom, 1, 'L');

// Author
$pdf->Ln(4);
$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(98, 8, "ชื่อผู้แต่ง/ผู้เขียน/ผู้แปล (Author/Writer/Translator) :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(111, 8, "  " . $author, $border_bottom, 1, 'L');

// Publisher
$pdf->Ln(4);
$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(44, 8, "สำนักพิมพ์ (Publisher) :", 0, 0, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->Cell(129, 8, "  " . $publisher, $border_bottom, 1, 'L');

$pdf->Ln(4);

// Type
$pdf->SetFont('thsarabun', '', 18);
// Determine the active class for each type
$activeBook = ($data_results[0]->book_type != '1') ? 'style="list-style-type: circle;"' : '';
$activeArticle = ($data_results[0]->book_type != '2') ? 'style="list-style-type: circle;"' : '';
$activeShortStory = ($data_results[0]->book_type != '3') ? 'style="list-style-type: circle;"' : '';
$activeOthers = ($data_results[0]->book_type != '4') ? 'style="list-style-type: circle;"' : '';

// HTML for displaying options with bullet style
$html = '
<table>
  <tr>
    <td style="width: 10%;"><b>ประเภท</b></td>
    <td style="width: 20%;"><ul ' . $activeBook . '><li style="text-align:center">หนังสือ (Book)</li></ul></td>
    <td style="width: 20%;"><ul ' . $activeArticle . '><li style="text-align:center">บทความ (Article)</li></ul></td>
    <td style="width: 23%;"><ul ' . $activeShortStory . '><li style="text-align:center">เรื่องสั้น <br>(Short Story)</li></ul></td>
    <td style="width: 25%;"><ul ' . $activeOthers . '><li style="text-align:center">อื่น ๆ <br>(Others)</li></ul></td>
  </tr>
</table>';

// Write the HTML to PDF
$pdf->writeHTML($html, false, false, true, false, '');

// Summary
$pdf->Ln(4);
$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(30, 8, "เนื้อหาโดยสรุป (Summary) ", 0, 1, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->MultiCell(0, 8, $summary, 0, 'L', 0, 1);

// Analysis
$pdf->Ln(4);
$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(30, 8, "ข้อคิด / ประโยชน์ที่ได้รับ (Analysis) ", 0, 1, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->MultiCell(0, 8, $analysis, 0, 'L', 0, 1);

// Reference
$pdf->Ln(4);
$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(30, 8, "แหล่งอ้างอิง / บรรณานุกรม (Reference) ", 0, 1, 'L');
$pdf->SetFont('thsarabun', '', 16);
$pdf->MultiCell(0, 8, $reference, 0, 'L', 0, 1);

if (!empty($image)) {
    $pathImage = '../uploads/images_read/' . $image;
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

    $pdf->Ln(10);
    // Display image with calculated dimensions and centered position
    $pdf->Image($pathImage, $imageX, '', $newWidth, $newHeight);
}

// Output the PDF
$pdf->Output("บันทึก รักการอ่าน " . $data_results[0]->std_prename . $data_results[0]->std_name . ".pdf", "I");
$pdf->Close();
