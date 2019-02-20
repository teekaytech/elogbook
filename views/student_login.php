<html>
<?php

@session_start();
require_once "../public/header.php";
require_once "../classes/student.php";

main_header();

//processing the login for admin
$message = "";
$login_status = false;
if (isset($_POST['login'])) {

	if((!empty($_POST['matric'])) && (!empty($_POST['password']))) {

		$matric = $_POST['matric'];
		$pass = $_POST['password'];	

		$student = new student();
		if($student->student_login($matric, $pass))
		{
      		$login_status = true;
      		$message = "You have been suucessfully logged in to your dashboard";
      		$url = "std_dboard.php";
      		header("Refresh: 1; URL='$url'");
    	}else
    	{
      		$message = "Invalid Matric number or password";
    	}
  	}else
  	{
    	$message = "Above boxes cannot be blank!";
  	}
}

?>
<body>
	<div id="wrapper">
		<section id="content">
			<div class="container">
				<section id="inner-headline"><div class="container"><h3></h3></div></section>
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<h4 align="center">Student Login</h4>
						<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm">
							<div class="form-group"><br>
								<input class="form-control-two" name="matric" id="matric" placeholder="Enter your Matric number" autofocus />
								<div class="validation"></div>
							</div><br />
							<div class="form-group">
								<input type="password" class="form-control-two" name="password" id="password" placeholder="Password" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
								<div class="validation"></div>
							</div>
							<?php if (isset($_POST['login'])) {
								if ($login_status) 
									{ echo "<p align='center'>".$message."</p>"; //echo $_SESSION['name']; 
									}//echo "<p align='center'>Welcome ".$login_name." ...</p>"; } 
								else { echo "<p align='center'>".$message."</p>";  }
							}?>
							<div class="text-center"><button type="submit" name="login" class="btn btn-theme">Continue</button></div>
						</form>
					</div>
				</div>
				<section id="inner-headline"><div class="container"><h3></h3></div></section>
			</div>
		</section>
	</div>
    </body>

</html>

<?php



?>