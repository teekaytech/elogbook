<!DOCTYPE html>
<html>
<?php

@session_start();
require_once "../public/super_header.php";
require_once "../public/footer.php";
require_once "../classes/supervisor.php";
require_once "../classes/student.php";

// if ($_SESSION['status']==1) { main_header(); } else { industry_header();

main_header();

$supervisor = new supervisor();
$handle = $supervisor->dbEngine();

$student = new student();
$handle = $student->dbEngine();

if (isset($_POST['reg_student'])) {
$matric = $_POST['matric_no'];
$sname = $_POST['sname'];
$fname = $_POST['fname'];
$oname = $_POST['oname'];
$nok = $_POST['nok'];
$pass = $_POST['password'];
$level = $_POST['level'];
$session = $_POST['session'];
$it_duration = $_POST['it_duration'];
$dept = $_POST['department'];
$org = $_POST['org'];
$start_date = $_POST['st_date'];
$pass_upload = $_FILES['file']['name'];
$dest_folder = "../std_pass/";
    
    // Get Image Dimension
    $fileinfo = @getimagesize($_FILES["file"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];

try {
	if ($supervisor->reg_student($matric, $sname, $fname, $oname, $nok, $pass, $level, $session, $it_duration, $dept, $org, $start_date)) {
	    $uploadMessage = $supervisor->upload_image($dest_folder);
	    if (($uploadMessage == null) && ($supervisor->insert_passport($pass_upload,$matric))) {
            ?>
            <script type="text/javascript">
                alert('Registration Successful!');
                window.location = "super_dboard.php";
            </script><?php
        } else { ?> <script type="text/javascript"> alert('<?php echo $uploadMessage; ?>'); </script><?php  }
	} else { ?> <script type="text/javascript"> alert('Registration NOT successful'); </script><?php }
	// $login_status = true;
	// $url = "admin_dashboard.php";
	// header("Refresh: 2; URL='$url'");
} catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    }  
?>
<body>
	<div id="wrapper">
		<section id="content">
			<div class="container">
				<section id="inner-headline">
					<div class="container">
						<h3 align="center">Student Registration Page (Supervisor ID: <?php echo $_SESSION['super_id']; ?>)</h3>
					</div>
				</section>
				<center>
	 				<div class="row"><br>
						<div>
							<p style="color: red;">Kindly supply the necessary information. All fields are compulsory.</p>
							<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm" enctype="multipart/form-data">
								<div class="form-group">
									<input class="form-control" name="matric_no" id="text" placeholder="Matric Number" required="" />
									<div class="validation"></div><br>
									<input class="form-control" name="sname" id="text" placeholder="Surname" required="" />
									<div class="validation"></div><br>
									<input class="form-control" name="fname" type="text" placeholder="First name" required="" />
									<div class="validation"></div><br>
									<input class="form-control" name="oname" type="text" placeholder="Othername" required="" />
									<div class="validation"></div><br>
									<input class="form-control" name="nok" id="nok" placeholder="Next of Kin" required="" />
									<div class="validation"></div><br>
									<select name="level" required="" class="form-control" id="myDrop">
										<option value="">--Select level--</option>
										<option value="100">100L</option><option value="200">200L</option>
										<option value="300">300L</option><option value="400">400L</option>
										<option value="500">500L</option><option value="600">600L</option>
										<option value="700">700L</option>
									</select><br>
									<div class="validation"></div>
									<select name="session" required="" class="form-control" id="myDrop">
										<option value="">--Select session--</option>
										<option value="2010/2011">2010/2011</option>
										<option value="2011/2012">2011/2012</option>
										<option value="2012/2013">2012/2013</option>
										<option value="2013/2014">2013/2014</option>
										<option value="2014/2015">2014/2015</option>
										<option value="2015/2016">2015/2016</option>
										<option value="2016/2017">2016/2017</option>
										<option value="2017/2018">2017/2018</option>
										<option value="2018/2019">2018/2019</option>
										<option value="2019/2020">2019/2020</option>
									</select><br>
									<div class="validation"></div>
									<select name="it_duration" required="" class="form-control" id="myDrop">
										<option value="">--Select internship duration--</option>
										<option value="1">1 Month</option>
										<option value="2">2 Months</option>
										<option value="3">3 Months</option>
										<option value="4">4 Months</option>
										<option value="5">5 Months</option>
										<option value="6">6 Months</option>
										<option value="12">12 Months</option>
									</select><br>
									<input class="form-control" name="password" id="text" placeholder="Password" type="password"  required/><br>
                                <select name="department" class="form-control" id="myDrop" required>
                                    <option value="">Select department..</option>
                                    <?php
                                    try {
                                        $dept = $supervisor->fetch_department();
                                        foreach ($dept as $k => $v) { ?>
                                            <option value="<?php echo $v['dept_id']; ?>"><?php echo $v['dept_desc']; ?></option> <?php
                                        }
                                    } catch (Exception $e) {
                                        echo "Error: " . $e->getMessage();
                                    }  ?>
                                </select><br>
                                <select name="org" class="form-control" id="myDrop" required>
                                    <option value="">Select organization name..</option>
                                    <?php
                                    try {
                                        $ind = $supervisor->fetch_organization();
                                        foreach ($ind as $k => $v) { ?>
                                            <option value="<?php echo $v['org_id']; ?>"><?php echo $v['org_name']; ?></option> <?php
                                        }
                                    } catch (Exception $e) {
                                        echo "Error: " . $e->getMessage();
                                    }  ?>
                                </select>
                                <label style="color: blue;">IT Commencement Date: </label>
                                <input class="form-control" name="st_date" id="text" placeholder="" type="date"  required/>
                                    <label for="super_sign" style="color: blue;">Select Student Passport:</label>
                                    <input class="form-control" type="file" name="file" placeholder="Passport here..." required/>
<!--								</div>-->
								<div class="text-center"><input type="submit" name="reg_student" class="btn btn-theme" style="color: red;" value="Register Student"></div>
							</form>		
						</div>
	    			</div>
    			</center>
			</div>
		</section>
	</div>
	<footer><?php footer(); ?></footer>
</body>
</html>