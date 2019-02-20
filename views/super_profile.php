<html>
<?php

@session_start();
require_once "../public/super_header.php";
require_once "../public/footer.php";
require_once "../classes/supervisor.php";

$supervisor = new supervisor();
$handle = $supervisor->dbEngine();

if (isset($_POST['update'])) {
    if (isset($_SESSION['super_id']) && isset($_SESSION['key'])) {
        $c_pswd = $_POST['old_pwd'];
        $new_one = $_POST['new_pwd1'];
        $new_two = $_POST['new_pwd2'];
        if ($c_pswd==$_SESSION['key']) {
	        if ($new_one == $new_two) {
	        	try {
	            	//updating the admin profile on the database without changing password
	        		if ($supervisor->update_profile($new_one)) { 
	            		$supervisor->super_logout();
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

if ($_SESSION['status']==1) { main_header(); } else { industry_header(); }
?>
<body>
	<div id="wrapper">
		<section id="content">
			<div class="container">
				<section id="inner-headline">
					<div class="container">
						<h3 align="center">| Edit Profile (<?php echo $_SESSION['super_id']; ?>) |</h3>
					</div>
				</section><br>
				<center>
 				<?php 
 				if (($_SESSION['super_id']) && ($_SESSION['key'])) {?>
 					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm">
						<div class="form-group"><br>
	                        <?php
	                        try {
	                            $super_profile = $supervisor->fetch_super_details($_SESSION['super_id']);
	                            $super_org = $supervisor->fetch_super_org($_SESSION['org_id']);
	                            foreach ($super_profile as $super) { ?>
	                                <input class="form-control" value="Organization: <?php echo $super_org; ?>" readonly/><br>
	                         	    <input class="form-control" value="Full Name: <?php echo $_SESSION['super_name']; ?>" readonly/><br>
	                                <input class="form-control" type="text" name="duration" value="Organization Type: <?php echo $supervisor->super_status($_SESSION['status']); ?>" readonly/><br>
	                                <input class="form-control" name="desig" value="Phone No: <?php echo $super['phone_no']; ?>" readonly/><br>
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
	                    <div class="text-center"><input type="submit" name="update" style="color: white; background-color: blue;" value="Update Profile"/>
                        </div>
					</form>
				<?php } ?>	
				</center>
			</div>
		</section>
	</div>
	<footer><?php footer(); ?></footer>
 </body>

</html>
