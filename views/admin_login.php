<html>
<?php

@session_start();
require_once "../public/header.php";
require_once "../classes/admin.php";
//require_once "admin.php";
main_header();

//processing the login for admin
$message = "";
$login_status = false;
if (isset($_POST['login'])) {

	if((!empty($_POST['uname'])) && (!empty($_POST['password']))) {

		$uname = $_POST['uname'];
		$pass = $_POST['password'];	

		$admin = new Admin();
		if($admin->login_admin($uname, $pass))
		{
      		$login_status = true;
      		$message = "You have been successfully logged in to your dashboard";
      		$url = "admin_dashboard.php";
      		header("Refresh:3; URL='$url'");
    	}else
    	{
      		$message = "Invalid username or password";
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
						<h4 align="center">Admin Login</h4>
						<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm">
							<div class="form-group"><br>
								<input class="form-control-two" name="uname" id="email" placeholder="Username" autofocus />
								<div class="validation"></div>
							</div><br />
							<div class="form-group">
								<input type="password" class="form-control-two" name="password" id="subject" placeholder="Password" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
								<div class="validation"></div>
							</div>
							<?php if (isset($_POST['login'])) {
								if ($login_status) 
									{ echo "<p align='center'>".$message."</p>"; }//echo "<p align='center'>Welcome ".$login_name." ...</p>"; } 
								else { echo "<p align='center'>".$message."</p>";  }
							}?>
							<div class="text-center"><button type="submit" name="login" class="btn btn-success">Continue</button></div>
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