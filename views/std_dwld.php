<html xmlns="http://www.w3.org/1999/html">
<?php
use Carbon\Carbon; //namespace
require '../vendor/autoload.php'; //php class library

@session_start();
require_once "../public/std_header.php";
require_once "../public/footer.php";
require_once "../classes/admin.php";
require_once "../classes/student.php";
require_once "../classes/report.php";
require_once "../classes/supervisor.php";

//student object
$student = new student();
$handle = $student->dbEngine();

//report object
$report = new report();
$rhandle = $report->dbEngine();

//supervisor object
$supervisor = new supervisor();
$rhandle = $supervisor->dbEngine();


main_header();

$check_assessmentApproval_status = TRUE;
$slip_status = '';
$check_date = FALSE;
$date_status = '';

if (isset($_SESSION['matric']) && isset($_POST['status']) ) {
    //Checking whether the Industrial Training end date has been reached
    if ($report->check_duration($_SESSION['matric'])) {
        $check_date = TRUE;
        $date_status = 'Your Industrial Training ends on '.$report->it_end_string($_SESSION['matric']).
            '<br>Check back on '.$report->it_end_print($_SESSION['matric']).'.';
    } else { //if IT has ended
        $approval = $supervisor->fetch_student_report($_SESSION['matric']);
        foreach ($approval as $ass_index) {
            if ($ass_index['inst_appr_status'] == '0' || $ass_index['ind_appr_status'] == '0') {
                $check_assessmentApproval_status = FALSE;
            }
        }
        if ($check_assessmentApproval_status) {
            $slip_status = 'Congratulations You can now generate and print your End-of-SIWES slip.';
            $_SESSION['confirm'] = TRUE;
        } else {
            $slip_status = 'Either Industry or Institution supervisor is yet to approve your report.';
        }
    }
}
if (isset($_SESSION['matric']) && isset($_POST['download']) ) {
    if (isset($_SESSION['confirm'])) {
        ?> <script> window.open('end_of_siwes.php','_blank'); </script><?php
    } else { ?> <script> window.alert('Slip NOT available. Ensure you check your slip status. Please try again later.'); </script><?php }
    
}

?>
<body>
	<div id="wrapper">
		<section id="content">
			<div class="container">
				<section id="inner-headline">
					<div class="container">
						<h3 align="center">End of SIWES slip download page (<?php echo $_SESSION['name']; ?>)</h3>
					</div>
				</section>
				<br><p><center><b style="color: blue;"><?php echo $_SESSION['matric']; ?>,</b> Select an option to continue...</p>
				<br>
      			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm">
 					<div class="row">
 						<input type="submit" name="status" value="Check end-of-SIWES Slip Status" style="color: white; background-color: blue;">
 						<input type="submit" name="download"  style="color: white; background-color: blue;" value="Download end-of-SIWES Slip"/>
		   			</div>
		   		</form>
			</div><br><br>
            <?php
            if ($check_date) {
                echo '<p><center><b style="color: red;">'.$date_status.'</b></center></p>';
            } else { echo '<br>'; }
            if ($check_assessmentApproval_status) {
                echo '<p><center><b style="color: darkgreen;">'.$slip_status.'</b></center></p>';
                } else { echo '<p><center><b style="color: red;">'.$slip_status.'</b></center></p>'; }
                ?>
            <br><br><br>
		</section>
	</div>
	<footer><?php footer(); ?></footer>
    </body>
</html>
