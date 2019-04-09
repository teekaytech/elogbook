<?php
use Carbon\Carbon; //namespace
require '../vendor/autoload.php'; //php class library
require_once "../pdf/fpdf.php";
require_once "../classes/student.php";
require_once "../classes/report.php";
require_once "../classes/supervisor.php";

@session_start();
//student object
$student = new student();
$handle = $student->dbEngine();

//supervisor object
$supervisor = new supervisor();
$rhandle = $supervisor->dbEngine();

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('../img/ui.png',10,6,15);
        // Arial bold 15
        $this->SetFont('Arial','B',12);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,5,'INDUSTRIAL TRAINING COORDINATING CENTRE, UNIVERSITY OF IBADAN',0,0,'C');
        $this->Cell(22,17,'Electronic Logbook System for SIWES',0,0,'R');
        // Line break
        $this->Ln(15);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'L');
        $this->Cell(0,10,'ITCC/UI E-logbook System. Date Printed: '. Carbon::now()->toDayDateTimeString(),0,0,'R');
    }
}

// Instantiation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(7);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,'END-OF-SIWES SLIP',0,1,'C');
$pdf->Ln(4);
$pdf->SetFont('Times','I'.'B',12);
$pdf->Cell(0,10,'Student Details: ','T'.'B',1);
$pdf->SetFont('Times','',11);
$pdf->Ln(3);
$pdf->Write(6,'Matriculation Number:  '.$_SESSION['matric']);
//fetching image
$myad = $student->fetch_student_passport($_SESSION['matric']);
//var_dump($myad);
foreach ($myad as $item) {
    if ($item['stud_id'] == $_SESSION['matric']) {
        $imgUrl = '../std_pass/'.$item['passport'];
        $pdf->Image($imgUrl,150,50,35,40);
        break;
    }
}
$pdf->Ln(7);
$pdf->Write(6,'Full Name:  '.$_SESSION['name']);
$pdf->Ln(7);
$pdf->Write(6,'Department:  '.$student->fetch_student_dept($_SESSION['dept_id'], $_SESSION['matric']));
$pdf->Ln(7);
$pdf->Write(6,'Faculty:  '.$student->fetch_student_fac($_SESSION['dept_id']));
$pdf->Ln(7);
$pdf->Write(6,'Session:  '.$_SESSION['session']);
$pdf->Ln(7);
$pdf->Write(6,'IT Completion Date:  '.$student->calculate_end_date($_SESSION['matric']));


$pdf->Ln(15);
$pdf->SetFont('Times','I'.'B',12);
$pdf->Cell(0,10,'Organization Details: ','T'.'B',1);
$pdf->SetFont('Times','',10);
foreach ($student->fetch_organization_details($_SESSION['matric']) as $organization_detail) {
    $pdf->Ln(3);
    $pdf->Write(6,'Name of Organization:  '.$organization_detail['org_name']);
    $pdf->Ln(7);
    $pdf->Write(6,'Address:  '.$organization_detail['org_address'].' '.$organization_detail['org_city'].' '.$organization_detail['org_state'].' state.');
    $pdf->Ln(7);
    $pdf->Write(6,'Contact Number: '.$organization_detail['org_contact_phone']);
    $pdf->Ln(7);
}
foreach ($student->fetch_supervisor_details($_SESSION['matric']) as $supervisor_detail) {
    $pdf->Write(6,'Name of Industry-based Supervisor:   '.$supervisor_detail['super_lname'].' '.$supervisor_detail['super_fname'].' '.$supervisor_detail['super_mname']);
    $pdf->Ln(7);
    $pdf->Write(6,'Phone Number:   '.$supervisor_detail['phone_no']);
    $pdf->Ln(5);
    $pdf->Cell(100,10,'Email Address:   '.$supervisor_detail['email'],0,0);
    $imgUrl = '../uploads/'.$supervisor_detail['super_sign'];
    $pdf->Cell(50,10,'Signature:   ',0,0);
    $pdf->Image($imgUrl,130,138,50,15);
}
$pdf->Ln(20);
$pdf->SetFont('Times','I'.'B',12);
$pdf->Cell(0,10,'For ITF Official Use Only:','T'.'B',1);
$pdf->SetFont('Times','',10);
$pdf->Ln(7);
$pdf->Cell(0,7,'Name of Official: ','B',1);
$pdf->Ln(4);
$pdf->Cell(0,7,'Comment(s): ','B',1);
$pdf->Ln(4);
$pdf->Cell(0,7,'','B',1);
$pdf->Ln(4);
$pdf->Cell(0,7,'Date: ','B',1);
$pdf->Ln(4);
$pdf->Cell(0,7,'Signature/Stamp: ',0,1);


//for($i=1;$i<=20;$i++) {
//    $pdf->Cell(10,10,'Printing line number '.$i,1,0);
//    $pdf->Cell(50,10,'Printing line number '.$i,1,0);
//    $pdf->Cell(50,10,'Printing line number '.$i,1,1);
//}
$pdf->Output();
//$pdf->Output("end-of-SIWES.pdf", "D"); //sending the pdf to the browser in download mode


// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'Hello World!',1);
// $pdf->Ln(100);
// $pdf->Cell(60,10,'Powered by FPDF.',0,1,'C');
// $pdf->Output();