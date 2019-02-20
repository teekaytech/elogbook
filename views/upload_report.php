

<html>
<?php
use Carbon\Carbon; //namespace
require '../vendor/autoload.php'; //php class library

@session_start();
require_once "../public/std_header.php";
require_once "../public/footer.php";
require_once "../classes/student.php";
require_once "../classes/report.php";

$student = new student();
$handle = $student->dbEngine();

//report object
$report = new report();
$rhandle = $report->dbEngine();

main_header();

if (isset($_POST["update"])) {
    $log_status = false;
    //$rep_upload = '';
    
    //check the database if a report have been uploaded today
    $user_report = $report->getReport($_SESSION['matric']);
    foreach ($user_report as $item) {
        if ($item['rpt_date']==date('Y-m-d')){ $log_status = true; }
    }
    
    if ($log_status) {
        echo '<script type="text/javascript"> alert(\'Report already submitted for today. You can submit one report per day.\'); </script>';
    } else {
        $rep_date = date('Y-m-d');
        $rep_week = $report->getWeek($_SESSION['matric']);
        $rep_content = $_POST['desc'];
        $rep_time = date('H:i:s',time());
        $rep_upload = $_FILES['file']['name'];
        $dest_folder = "../std_upld/";
    
        if (isset($_SESSION['matric']) && !empty($rep_upload)) {
            if ($report->check_duration($_SESSION['matric'])) {
                if ($report->upload_image($dest_folder)) {
                    if ($report->insert_report($rep_date, $rep_time, $rep_week, $rep_content)) {
                        $this_id = '';
                        $rep_id = $report->getReport($_SESSION['matric']);
                        foreach ($rep_id as $key) {
                            if ($key['rpt_date'] == date('Y-m-d')) {
                                $this_id = $key['rpt_id'];
                                break;
                            }
                        }
                        if ($report->insert_attachment($rep_upload,$this_id)) {?>
                            <script type="text/javascript"> alert('Report Upload Successful!');
                        window.location = "std_dboard.php"; </script><?php
                        } else { echo '<script type="text/javascript"> alert(\'Report uploaded but attachment NOT Successful!\'); </script>'; }
                    } else { echo '<script type="text/javascript"> alert(\'Report Upload NOT successful!\'); </script>'; }
                } else { echo '<script type="text/javascript"> alert(\'File size cannot be more than 100kb and MUST be jpg/jpeg format\'); </script>'; }
            } else { echo '<script type="text/javascript"> alert(\'IT Duration Session expired! Report can NO MORE be uploaded.\'); </script>'; }
        }
        if (isset($_SESSION['matric']) && empty($rep_upload)) {
            if ($report->check_duration($_SESSION['matric'])) {
                if ($report->insert_report($rep_date, $rep_time, $rep_week, $rep_content)) { ?>
                    <script type="text/javascript"> alert('Upload Successful!');
                        window.location = "std_dboard.php"; </script><?php
                } else { echo '<script type="text/javascript"> alert(\'Upload NOT Successful!\'); </script>'; }
            } else { echo '<script type="text/javascript"> alert(\'IT Duration Session expired! Report can NO MORE be uploaded.\'); </script>'; }
        }
    }
}
?>
<body>
	<div id="wrapper">
		<section id="content">
			<div class="container">
				<section id="inner-headline">
					<div class="container">
						<h3 align="center">Upload Report (<?php echo $_SESSION['name']; ?>)</h3>
					</div>
				</section><br>
            <?php
            if (($_SESSION['matric']) && ($_SESSION['key'])) {
                //Checking whether the Industrial Training end date has been reached
                if ($report->check_duration($_SESSION['matric'])) { ?>
                <div class="row">
                    <div align="center">
                        <span style="color: red;">All Fields are Compulsory</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm" enctype="multipart/form-data">
                            <div class="form-group"><br>
                                <?php
                                try {
                                    $student_profile = $student->fetch_student_details($_SESSION['matric']);
                                    foreach ($student_profile as $stud) { 
                                        //echo $student->get_weeks($stud['stud_id'],$stud['stud_it_duration'],$stud['it_date']);
                                        $stud_dept = $student->fetch_student_dept($stud['DEPARTMENTdept_id'], $stud['stud_id']);
                                    	?>
                                        <input class="form-control" type="text" name="duration" value="Start Date: <?php echo $stud['it_date']; ?>" readonly/><br>
                                        <input class="form-control" name="desig" value="End Date: <?php echo $student->calculate_end_date($stud['stud_id']); ?>" readonly/><br>
                                        <input class="form-control" type="text" name="currentWeek" value="Current Week: <?php echo $report->getWeek($stud['stud_id']); ?>" readonly/>
                                        <label style="color: red;"><b>*Description of work done:</b></label>
                                        <textarea class="form-control" name="desc"></textarea>
                                        <label style="color: red;"><b>*Attachment (if available):</b></label>
                                        <input class="form-control" name="file" type="file"/>
                                    <?php }
                                } catch (Exception $e) {
                                    echo "Error: " . $e->getMessage();
                                } ?>
                            </div>
                            <div class="text-center"><input type="submit" name="update" style="color: white; background-color: blue;" value="Upload Report"/>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } else { ?>
                    <script type="text/javascript"> alert('Report Upload not available. IT session lapsed!');
                    window.location = "std_dboard.php"; </script><?php
                }
            } ?>
			</div>
		</section>
	</div>
	<footer><?php footer(); ?></footer>
 </body>
</html>
