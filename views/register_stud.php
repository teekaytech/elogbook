<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
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
				</section><br>
                <center>
                    <div style="background-color: ghostwhite;">
                        <p style="color: red;">Kindly supply the necessary information. All  marked with (*) are compulsory.</p>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm" enctype="multipart/form-data">
                            <div class="form-group">
                                <div>
                                    <label for="mtext">* Matriculation Number: </label>
                                    <input class="form-control" name="matric_no" id="mtext" placeholder="Matric Number" required type="number" />
                                    <span id="mInfo" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label for="stext">* Surname:</label>
									<input class="form-control" name="sname" id="stext" placeholder="Surname" required="" />
                                    <span id="sInfo" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label for="fname">* Firstname:</label>
									<input class="form-control" name="fname" id="ftext" placeholder="First name" required="" />
                                    <span id="fInfo" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label for="oname">Othername:</label>
									<input class="form-control" name="oname" id="otext" placeholder="Othername" required="" />
                                    <span id="oInfo" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label for="nok">* Next Of Kin:</label>
									<input class="form-control" name="nok" id="nok" placeholder="Next of Kin" required="" />
                                    <span id="nokInfo" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label for="level">* Current Level:</label>
									<select name="level" required="" class="form-control" id="myDrop">
										<option value="">--Select level--</option>
										<option value="100">100L</option><option value="200">200L</option>
										<option value="300">300L</option><option value="400">400L</option>
										<option value="500">500L</option><option value="600">600L</option>
										<option value="700">700L</option>
									</select>
                                    <span id="myDrop" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label for="session">* Current Session:</label>
									<select name="session" required="" class="form-control" id="myDropTwo">
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
									</select>
                                    <span id="myDropTwo" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label for="it_duration">* Duration of Training:</label>
									<select name="it_duration" required="" class="form-control" id="myDropThree">
										<option value="">--Select internship duration--</option>
										<option value="1">1 Month</option>
										<option value="2">2 Months</option>
										<option value="3">3 Months</option>
										<option value="4">4 Months</option>
										<option value="5">5 Months</option>
										<option value="6">6 Months</option>
										<option value="12">12 Months</option>
									</select>
                                    <span id="myDropThree" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label for="password">* Enter Student Password:</label>
									<input class="form-control" name="password" id="password" placeholder="Password" type="password"  required/>
                                    <span id="pInfo" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label for="passwordTwo">* Re-enter Student Password:</label>
                                    <input class="form-control" name="passwordTwo" id="passwordTwo" placeholder="Password" type="password"  required/>
                                    <span id="ptInfo" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label for="department">* Select Department:</label>
                                    <select name="department" class="form-control" id="dept" required>
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
                                    </select>
                                    <span id="dept" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label for="org">* Select Department:</label>
                                    <select name="org" class="form-control" id="organ" required>
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
                                    <span id="organ" style="display: none; " class="fa label-info"></span>
                                </div>
                                <div>
                                    <label style="color: blue;">IT Commencement Date: </label>
                                    <input class="form-control" name="st_date" id="text" placeholder="" type="date"  required/>
                                </div>
                                <div>
                                    <label for="super_sign" style="color: blue;">Select Student Passport:</label>
                                    <input class="form-control" type="file" name="file" placeholder="Passport here..." required/><br>
								    <input type="submit" name="reg_student" class="btn btn-theme" style="color: red;" value="Register Student">
                                </div>
                            </div>
                        </form>
                    </div>
                </center>
            </div>
		</section>
	</div>
	<footer><?php footer(); ?></footer>
    <script>
        var matric = document.getElementById('mtext');
        matric.addEventListener('focusout', function () {
            var outputMessage = document.getElementById('mInfo');
            if (matric.value === '') {
                outputMessage.style.display = 'inline';
                outputMessage.innerText = 'Matric number cannot be empty, only Numbers are allowed!';
            } else if (matric.value.length > 6) {
                outputMessage.style.display = 'inline';
                outputMessage.innerText = 'Matric Number can be maximum of 6 digits!';
                matric.value = '';
            }
            else {
                outputMessage.innerText = '';
            }
        });

        var firstname = document.getElementById('ftext');
        firstname.addEventListener('focusout', function () {
            var outputMessage = document.getElementById('fInfo');
            if (firstname.value.length > 20) {
                outputMessage.style.display = 'inline';
                outputMessage.innerText = 'Firstname cannot be more than 20 characters!';
                firstname.value = '';
            } else if (firstname.value < 1) {
                outputMessage.style.display = 'inline';
                outputMessage.innerText = 'Firstname cannot be empty!';
            }
            else {
                outputMessage.innerText = '';
            }
        });

        var uSurname = document.getElementById('stext');
        uSurname.addEventListener('focusout', function () {
            var outputMessage = document.getElementById('sInfo');
            if (uSurname.value.length > 20) {
                outputMessage.style.display = 'inline';
                outputMessage.innerText = 'Surname cannot be more than 20 characters!';
                uSurname.value = '';
            } else if (uSurname.value < 1) {
                outputMessage.style.display = 'inline';
                outputMessage.innerText = 'Surname cannot be empty!';
            }
            else {
                outputMessage.innerText = '';
            }
        });

        var nextOfKin = document.getElementById('nok');
        nextOfKin.addEventListener('focusout', function () {
            var outputMessage = document.getElementById('nokInfo');
            if (nextOfKin.value < 1) {
                outputMessage.style.display = 'inline';
                outputMessage.innerText = 'Next Of Kin name cannot be empty!';
            }
            else {
                outputMessage.innerText = '';
            }
        });

        var passWord = document.getElementById('password');
        passWord.addEventListener('focusout', function () {
            var outputMessage = document.getElementById('pInfo');
            if (passWord.value === '') {
                outputMessage.style.display = 'inline';
                outputMessage.innerText = 'Password cannot be empty!';
            }
            else if (passWord.value.length < 8) {
                outputMessage.style.display = 'inline';
                outputMessage.innerText = 'Password length must be 8 or more characters';
                passWord.focus();
                return false;
            } else {
                outputMessage.innerText = '';
            }
        });
        var passWordTwo = document.getElementById('passwordTwo');
        passWordTwo.addEventListener("focusout", function () {
            var outputMessage = document.getElementById('ptInfo');
            if (passWordTwo.value === '') {
                outputMessage.style.display = 'inline';
                outputMessage.innerText = 'Confirm Password cannot be empty!';
            }
            else if (passWordTwo.value != passWord.value) {
                outputMessage.style.display = 'inline';
                outputMessage.innerText = 'Confirm password is not correct!';
                // passWordTwo.value = '';
                passWordTwo.focus();
            } else {
                outputMessage.innerText = '';
            }
        });

    </script>
</body>
</html>