<?php
use Carbon\Carbon; //namespace
require '../vendor/autoload.php'; //php class library
require_once "../pdf/fpdf.php";
require_once "../classes/admin.php";

@session_start();


function student_list_only($admin, $dept, $session) {
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
            $this->Cell(30, 5, 'INDUSTRIAL TRAINING COORDINATING CENTRE, UNIVERSITY OF IBADAN', 0, 0, 'C');
            $this->Cell(22, 17, 'Electronic Logbook System for SIWES', 0, 0, 'R');
            
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
    try {
        $students = $admin->fetch_student($dept, $session);
        if (count($students) == 0) {
            ?><script type="text/javascript"> alert('No record found for selected department in <?php echo $session; ?> session'); </script><?php
        } else {
            $pdf = new PDF();
            $students = $admin->fetch_student($dept, $session);
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->Ln(2);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 0, 'List of Interns for ' . $session . ' Academic Session', 0, 1, 'C');
            $pdf->Ln(4);
            $pdf->SetFont('Times', 'I' . 'B', 12);
            $pdf->Cell(50, 10, 'Session:   ' . $session, 0, 0);
            $dept_name = $admin->fetch_department_name($dept);
            foreach ($dept_name as $desc) {
                $pdf->Cell(50, 10, 'Department:   ' . $desc['dept_desc'], 0, 1);
            }
            $pdf->SetFont('Times', 'B', 10);
//        $pdf->Ln(3);
            $pdf->Cell(11, 7, 'S/N', 1, 0, 'C');
            $pdf->Cell(27, 7, 'MATRIC. NO', 1, 0, 'C');
            $pdf->Cell(152, 7, 'FULL NAME', 1, 1, 'C');
            $sn = 1;
            foreach ($students as $record) {
                $pdf->Cell(11, 7, $sn, 1, 0, 'C');
                $pdf->Cell(27, 7, $record['stud_id'], 1, 0, 'C');
                $pdf->Cell(152, 7, ' ' . $record['stud_lname'] . ' ' . $record['stud_fname'] . ' ' . $record['stud_mname'], 1, 1);
                $sn++;
            }
            ob_end_clean();
            $pdf->Output('list_of_interns.pdf', 'I');
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

$current_dept = '';
function student_full_details($admin, $dept, $session) {
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
            $this->Cell(100, 5, 'INDUSTRIAL TRAINING COORDINATING CENTRE, UNIVERSITY OF IBADAN', 0, 1,'C');
            $this->Cell(250, 17, 'Electronic Logbook System for SIWES', 0, 0, 'C');
            
            // Line break
            $this->Ln(18);
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
    try {
        $students = $admin->fetch_student($dept, $session);
        if (count($students) == 0) {
            ?><script type="text/javascript"> alert('No record found for selected department in <?php echo $session; ?> session'); </script><?php
        } else {
            $pdf = new PDF();
            $students = $admin->fetch_student($dept, $session);
            $pdf->AliasNbPages();
            $pdf->AddPage('L');
            $pdf->Ln(2);
            $pdf->SetFont('Arial', 'B', 12);
            $dept_name = $admin->fetch_department_name($dept);
            foreach ($dept_name as $desc) {
                $current_dept = $desc['dept_desc'];
            }
            $pdf->Cell(0, 0, 'Details of Interns for ' . $session . ' Academic Session, Department of '.$current_dept, 0, 1, 'C');
            $pdf->Ln(6);
            $pdf->SetFont('Times', 'I' . 'B', 12);
//            $pdf->Cell(50, 10, 'Session:   ' . $session, 0, 0);
            
            $pdf->SetFont('Times', 'B', 10);
//        $pdf->Ln(3);
            $pdf->Cell(11, 7, 'S/N', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Matric. No', 1, 0, 'C');
            $pdf->Cell(75, 7, 'Full Name', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Start Date (Y-M-D)', 1, 0, 'C');
            $pdf->Cell(20, 7, 'Level', 1, 0, 'C');
            $pdf->Cell(27, 7, 'IT Duration', 1, 0, 'C');
            $pdf->Cell(80, 7, 'Organization', 1, 1, 'C');
            $sn = 1;
            foreach ($students as $record) {
                $current_org = $admin->fetch_specific_organization($record['org_id']);
                $pdf->Cell(11, 7, $sn, 1, 0, 'C');
                $pdf->Cell(25, 7, $record['stud_id'], 1, 0, 'C');
                $pdf->Cell(75, 7, ' ' . $record['stud_lname'] . ' ' . $record['stud_fname'] . ' ' . $record['stud_mname'], 1, 0);
                $pdf->Cell(35, 7, $record['it_date'],1, 0, 'C');
                $pdf->Cell(20, 7, $record['stud_level'], 1, 0, 'C');
                $pdf->Cell(27, 7, $record['stud_it_duration'].' Month(s)', 1, 0, 'C');
                foreach ($current_org as $selected) {
                    $pdf->Cell(80, 7, $selected['org_name'], 1, 1);
                    break;
                }
                $sn++;
            }
            ob_end_clean();
            $pdf->Output('list_of_interns.pdf', 'I');
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

//List of Supervisors (Basic Information)
function supervisor_basic_details($admin, $session) {
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
            $this->Cell(100, 5, 'INDUSTRIAL TRAINING COORDINATING CENTRE, UNIVERSITY OF IBADAN', 0, 1,'C');
            $this->Cell(250, 17, 'Electronic Logbook System for SIWES', 0, 0, 'C');
        
            // Line break
            $this->Ln(18);
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
    try {
        $supervisors = $admin->fetch_spec_supervisors($session);
        if (count($supervisors) == 0) {
            ?><script type="text/javascript"> alert('No record found for supervisors in <?php echo $session; ?> session'); </script><?php
        } else {
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage('L');
            $pdf->Ln(2);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 0, 'Details of Supervisors for ' . $session . ' Academic Session', 0, 1, 'C');
            $pdf->Ln(6);
            $pdf->SetFont('Times', 'I' . 'B', 12);
//            $pdf->Cell(50, 10, 'Session:   ' . $session, 0, 0);
            
            $pdf->SetFont('Times', 'B', 10);
//        $pdf->Ln(3);
            $pdf->Cell(11, 7, 'S/N', 1, 0, 'C');
            $pdf->Cell(30, 7, 'ID', 1, 0, 'C');
            $pdf->Cell(75, 7, 'SUPERVISOR FULL NAME', 1, 0, 'C');
            $pdf->Cell(40, 7, 'STATUS', 1, 0, 'C');
            $pdf->Cell(30, 7, 'PHONE NO', 1, 0, 'C');
            $pdf->Cell(90, 7, 'ORGANIZATION', 1, 1, 'C');
            $sn = 1;
            $all_organizations = $admin->fetch_organization();
            foreach ($supervisors as $record) {
                $pdf->Cell(11, 7, $sn, 1, 0, 'C');
                $pdf->Cell(30, 7, $record['super_id'], 1, 0, 'C');
                $pdf->Cell(75, 7, ' '.$record['super_lname'].' '.$record['super_fname'].' '.$record['super_mname'], 1, 0);
                if ($record['super_status'] == '0') {
                    $pdf->Cell(40, 7, 'Industry - Based', 1, 0, 'C');
                } else {
                    $pdf->Cell(40, 7, 'Institution - Based', 1, 0, 'C');
                }
                $pdf->Cell(30, 7, $record['phone_no'], 1, 0, 'C');
                //fetching organization
                foreach ($all_organizations as $selected) {
                    if ($selected['org_id'] == $record['org_id']) {
                        $pdf->Cell(90, 7, ' '.$selected['org_name'], 1, 1);
                        break;
                    }
                }
                $sn++;
            }
            ob_end_clean();
            $pdf->Output('list_of_interns.pdf', 'I');
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}


//List of Supervisors and students combined
function supervisor_student_details($admin, $session, $super_status) {
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
            $this->Cell(100, 5, 'INDUSTRIAL TRAINING COORDINATING CENTRE, UNIVERSITY OF IBADAN', 0, 1,'C');
            $this->Cell(250, 17, 'Electronic Logbook System for SIWES', 0, 0, 'C');
            
            // Line break
            $this->Ln(18);
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
    try {
        $supervisors = $admin->fetch_super_student($session, $super_status);
        if (count($supervisors) == 0) {
            ?><script type="text/javascript"> alert('No record found for supervisors in <?php echo $session; ?> session'); </script><?php
        } else {
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage('L');
            $pdf->Ln(2);
            $pdf->SetFont('Arial', 'B', 12);

            $pdf->Cell(0, 0, 'Details of Industry - Based Supervisors and Students for ' . $session . ' Academic Session.', 0, 1, 'C');
            $pdf->Ln(6);
            $pdf->SetFont('Times', 'I' . 'B', 12);
            
            $pdf->SetFont('Times', 'B', 8);
            $pdf->Cell(8, 7, 'S/N', 1, 0, 'C');
            $pdf->Cell(18, 7, 'ID', 1, 0, 'C');
            $pdf->Cell(50, 7, 'SUPERVISOR FULL NAME', 1, 0, 'C');
            $pdf->Cell(65, 7, 'ORGANIZATION', 1, 0, 'C');
            $pdf->Cell(15, 7, 'CITY', 1, 0, 'C');
            $pdf->Cell(15, 7, 'MATRIC', 1, 0, 'C');
            $pdf->Cell(52, 7, 'STUDENT NAME', 1, 0, 'C');
            $pdf->Cell(36, 7, 'DEPARTMENT', 1, 0, 'C');
            $pdf->Cell(20, 7, 'IT DURATION', 1, 1, 'C');
    
            $pdf->SetFont('Times', '', 8);
            $sn = 1;
            $all_organizations = $admin->fetch_organization();
            
            foreach ($supervisors as $record) {
                $pdf->Cell(8, 7, $sn, 1, 0, 'C');
                $pdf->Cell(18, 7, $record['super_id'], 1, 0, 'C');
                $pdf->Cell(50, 7, ' '.$record['super_lname'].' '.$record['super_fname'].' '.$record['super_mname'], 1, 0, 'L');
                $current_org = $admin->fetch_specific_organization($record['org_id']);
                //fetching organizations
                foreach ($current_org as $myOrg) {
                    $pdf->Cell(65, 7, ' '.$myOrg['org_name'], 1, 0, 'L');
                    $pdf->Cell(15, 7, ' '.$myOrg['org_city'], 1, 0, 'L');
                    break;
                }
                $pdf->Cell(15, 7, $record['stud_id'], 1, 0, 'C');
                $pdf->Cell(52, 7, ' '.$record['stud_lname'].' '.$record['stud_fname'].' '.$record['stud_mname'], 1, 0, 'L');
                //fetching department
                $thisDepartment = $admin->fetch_department_name($record['DEPARTMENTdept_id']);
                foreach ($thisDepartment as $item) {
                    $pdf->Cell(36, 7, $item['dept_desc'], 1, 0, 'L');
                }
                
                $pdf->Cell(20, 7, ' '.$record['stud_it_duration'].'Month(s)', 1, 1, 'L');

                $sn++;
            }
            ob_end_clean();
            $pdf->Output('list_of_interns.pdf', 'I');
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}


//List of Supervisors and students combined
function supervisor_student_details_inst($admin, $session, $super_status) {
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
            $this->Cell(100, 5, 'INDUSTRIAL TRAINING COORDINATING CENTRE, UNIVERSITY OF IBADAN', 0, 1,'C');
            $this->Cell(250, 17, 'Electronic Logbook System for SIWES', 0, 0, 'C');
            
            // Line break
            $this->Ln(18);
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
    try {
        $supervisors = $admin->fetch_super_student($session, $super_status);
        if (count($supervisors) == 0) {
            ?><script type="text/javascript"> alert('No record found for supervisors in <?php echo $session; ?> session'); </script><?php
        } else {
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage('L');
            $pdf->Ln(2);
            $pdf->SetFont('Arial', 'B', 12);
            
            $pdf->Cell(0, 0, 'Details of Institution - Based Supervisors and Students for ' . $session . ' Academic Session.', 0, 1, 'C');
            $pdf->Ln(6);
            $pdf->SetFont('Times', 'I' . 'B', 12);
            
            $pdf->SetFont('Times', 'B', 8);
            $pdf->Cell(8, 7, 'S/N', 1, 0, 'C');
            $pdf->Cell(18, 7, 'ID', 1, 0, 'C');
            $pdf->Cell(50, 7, 'SUPERVISOR FULL NAME', 1, 0, 'C');
            $pdf->Cell(15, 7, 'MATRIC', 1, 0, 'C');
            $pdf->Cell(52, 7, 'STUDENT NAME', 1, 0, 'C');
            $pdf->Cell(65, 7, 'ORGANIZATION', 1, 0, 'C');
            $pdf->Cell(15, 7, 'CITY', 1, 0, 'C');
            $pdf->Cell(36, 7, 'DEPARTMENT', 1, 0, 'C');
            $pdf->Cell(20, 7, 'IT DURATION', 1, 1, 'C');
            
            $pdf->SetFont('Times', '', 8);
            $sn = 1;
            $all_organizations = $admin->fetch_organization();
            
            foreach ($supervisors as $record) {
                $pdf->Cell(8, 7, $sn, 1, 0, 'C');
                $pdf->Cell(18, 7, $record['super_id'], 1, 0, 'C');
                $pdf->Cell(50, 7, ' '.$record['super_lname'].' '.$record['super_fname'].' '.$record['super_mname'], 1, 0, 'L');
                $pdf->Cell(15, 7, $record['stud_id'], 1, 0, 'C');
                $pdf->Cell(52, 7, ' '.$record['stud_lname'].' '.$record['stud_fname'].' '.$record['stud_mname'], 1, 0, 'L');
                $current_org = $admin->fetch_specific_organization($record['studOrg']);
                //fetching organizations
                foreach ($current_org as $myOrg) {
                    $pdf->Cell(65, 7, ' '.$myOrg['org_name'], 1, 0, 'L');
                    $pdf->Cell(15, 7, ' '.$myOrg['org_city'], 1, 0, 'L');
                    break;
                }
                //fetching department
                $thisDepartment = $admin->fetch_department_name($record['DEPARTMENTdept_id']);
                foreach ($thisDepartment as $item) {
                    $pdf->Cell(36, 7, $item['dept_desc'], 1, 0, 'L');
                }
                
                $pdf->Cell(20, 7, ' '.$record['stud_it_duration'].'Month(s)', 1, 1, 'L');
                
                $sn++;
            }
            ob_end_clean();
            $pdf->Output('list_of_interns.pdf', 'I');
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}