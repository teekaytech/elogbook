<html>
<?php

@session_start();
require_once "../public/admin_header.php";
require_once "../public/footer.php";

main_header();
?>
<body>
	<div id="wrapper">
		<section id="content">
			<div class="container">
				<section id="inner-headline">
					<div class="container">
						<h3 align="center">| <?php echo $_SESSION['admin_name']; ?> Dashboard |</h3>
					</div>
				</section>
      			<br>
                You are an <b>Admin.</b><br>
 				<div class="row">
					<dl>
						<dt><br> You can: </dt>
						<dd>Change your password by clicking on <b><i>Edit profile</i></b> link above.</dd>
						<dd>Register Supervisors by clicking on <b><i>Register Supervisor</i></b> link above.</dd>
						<dd>Download reports clicking on the <b><i>Download</i></b> button above.</dd>
					</dl>
    			</div>
			</div>
		</section>
		<br><br><br><br><br>
	</div>
	<footer><?php footer(); ?></footer>
    </body>

</html>
