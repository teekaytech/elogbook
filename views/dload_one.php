<html>
<?php

@session_start();
require_once "../public/std_header.php";
require_once "../public/footer.php";

main_header();
?>
<body>
	<div id="wrapper">
		<section id="content">
			<div class="container">
				<section id="inner-headline">
					<div class="container">
						<h3 align="center">| Edit Profile |</h3>
					</div>
				</section><br>
 				<?php 
 				if (($_SESSION['matric']) && ($_SESSION['key'])) {?>
					<div class="row">
						<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm">
						<div>
						<p style="color: red;">Note: Only fields with (*) can be updated!</p>
						<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm">
							<div class="form-group"><br>
								<input class="form-control" name="admin_id" value="" readonly="readonly" type="text" />
								<label style="color: red;"><b>*</b></label>
								<input class="form-control" name="name" value="" type="text" /><br>
								<input class="form-control" type="text" name="username" value="" readonly="readonly" />
								<label style="color: red;"><b>*</b></label>
								<input class="form-control" name="phone_no" value=""/><br>
								<p style="color: green;">Password session, proceed to update if you are not willing to change your password.</p>
								<label style="color: red;"><b>*</b></label>
								<input class="form-control" type="password" name="old_pwd" placeholder="Current Password" required="required"/>
								<label style="color: red;"><b>*</b></label>
								<input class="form-control" type="password" name="new_pwd1"  placeholder="New Password" required="required"/>
								<label style="color: red;"><b>*</b></label>
								<input class="form-control" type="password" name="new_pwd2" placeholder="Repeat New Password"  required="required"/>
							</div>
							<div class="text-left"><input type="submit" name="update"  style="color: white; background-color: blue;" value="Update Profile"/>
							</div>
							</form>		
						</div>
					</form>
				</div>
				<?php } ?>	
			</div>
		</section>
	</div>
	<footer><?php footer(); ?></footer>
 </body>

</html>
