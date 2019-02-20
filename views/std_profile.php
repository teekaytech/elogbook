<html>
<?php

@session_start();
require_once "../public/std_header.php";
require_once "../public/footer.php";
require_once "../classes/student.php";

$student = new student();
$handle = $student->dbEngine();

if (isset($_POST['update'])) {
    if (isset($_SESSION['matric']) && isset($_SESSION['key'])) {
        $c_pswd = $_POST['old_pwd'];
        $new_one = $_POST['new_pwd1'];
        $new_two = $_POST['new_pwd2'];
        if ($c_pswd==$_SESSION['key']) {
	        if ($new_one == $new_two) {
	        	try {
	            	//updating the admin profile on the database without changing password
	        		if ($student->update_profile($new_one)) { 
	            		$student->stud_logout();
	            		?><script type="text/javascript"> 
	            			alert('Profile Updated Successfully! Please re-login.'); 
	            			window.location="../index.php";
	            		</script><?php
	        		} else {
	            		echo "Update not successful!";
	        		}	
	        	} catch (PDOException $e) {
	            	echo $e->getMessage();
	        	}
	        } else { ?>
	            <script type="text/javascript"> alert('New password does not match. Please try again!.'); </script><?php
	        }
        } else { ?>
            <script type="text/javascript"> alert('Old password not correct!.'); </script><?php
        }
    }
}

main_header();
?>
<body>
	<div id="wrapper">
		<section id="content">
			<div class="container">
				<section id="inner-headline">
					<div class="container">
						<h3 align="center">Edit Profile (<?php echo $_SESSION['matric'].': '.$_SESSION['name']; ?>)</h3>
					</div>
				</section><br>
            <?php
            if (($_SESSION['matric']) && ($_SESSION['key'])) { ?>
                <div class="row">
                    <div>
                        <p style="color: red;">Note: Only fields with (*) can be updated!</p>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm">
                            <div class="form-group"><br>
                                <?php
                                try {
                                    $student_profile = $student->fetch_student_details($_SESSION['matric']);
                                    foreach ($student_profile as $stud) { 
                                    	$stud_dept = $student->fetch_student_dept($stud['DEPARTMENTdept_id'], $stud['stud_id']);
                                    	?>
                                        <input class="form-control" value="Matric: <?php echo $stud['stud_id']; ?>" readonly/><br>
                                        <input class="form-control" value="Full Name: <?php echo $stud['stud_lname'].' '.$stud['stud_fname'].' '.$stud['stud_mname']; ?>" readonly/><br>
                                        <input class="form-control" type="text" name="duration" value="IT Duration: <?php echo $stud['stud_it_duration']; ?> Months" readonly/><br>
                                        <input class="form-control" name="desig" value="Department: <?php echo $stud_dept; ?>" readonly/><br>
                                        <label style="color: red;"><b>*Current Password</b></label>
                                        <input class="form-control" type="password" name="old_pwd" placeholder="Current Password" />
                                        <label style="color: red;"><b>* New password</b></label>
                                        <input class="form-control" type="password" name="new_pwd1" placeholder="New Password"/>
                                        <label style="color: red;"><b>*Confirm new password</b></label>
                                        <input class="form-control" type="password" name="new_pwd2" placeholder="Repeat New Password" required/>
                                    <?php }
                                } catch (Exception $e) {
                                    echo "Error: " . $e->getMessage();
                                } ?>
                            </div>
                            <div class="text-left"><input type="submit" name="update" style="color: white; background-color: blue;" value="Update Profile"/>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
			</div>
		</section>
	</div>
	<footer><?php footer(); ?></footer>
 </body>
</html>
