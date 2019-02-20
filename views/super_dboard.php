<html>
<?php

@session_start();
require_once "../public/super_header.php";
require_once "../public/footer.php";
?>
<body>
	<div id="wrapper">
		<?php //1 for institution supervisor, 0 for industry supervisor
        if ($_SESSION['status']==1) { main_header(); } else { industry_header(); }?>
		<section id="content">
			<div class="container">
				<section id="inner-headline">
					<div class="container">
						<h3 align="center"><?php echo $_SESSION['super_id'].' ('.$_SESSION['super_name'].')'; ?> Dashboard</h3>
					</div>
				</section><br>
 				<div class="row">
 					<dl>
						<dt> You can: </dt><br>
						<dd>Change your password by clicking on <b><i>Edit profile</i></b> link above.</dd>
						<dd>Endorse interns' reports by clicking on <b><i>Upload</i></b> link above.</dd>
						<dd>Download end-of-SIWES form clicking on the <b><i>Download</i></b> button above.</dd>
					</dl>
    			</div>
			</div><br><br><br><br><br>
		</section>
	</div>
	<footer><?php footer(); ?></footer>
    </body>

</html>
