<?php

require_once ("../pdf/fpdf.php");


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
	    $this->Cell(30,5,'INDUSTRIAL TRAINING COORDINATING CENTRE',0,0,'C');
	    $this->Cell(10,17,'University of Ibadan',0,0,'R');
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
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}


?>