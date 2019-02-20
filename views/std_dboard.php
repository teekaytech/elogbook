<html>
<?php

@session_start();
require_once "../public/std_header.php";
require_once "../public/footer.php";
?>

<body>

	<div id="wrapper">
		<?php main_header(); ?>
		<section id="content">
			<div class="container">
				<section id="inner-headline">
					<div class="container">
						<h3 align="center">Student Dashboard (<?php echo $_SESSION['matric'].': '.$_SESSION['name']; ?>)</h3>
					</div>
				</section>
				<br><br>
 				<div class="row">
 					<dl>
						<dt> You can: </dt><br>
						<dd>Change your password by clicking on <b><i>Edit profile</i></b> link above.</dd>
						<dd>Upload daily reports or end-of-SIWES forms by clicking on <b><i>Upload</i></b> link above.</dd>
						<dd>Download end-of-SIWES form clicking on the <b><i>Download</i></b> button above.</dd>
					</dl>
    			</div>
			</div>
		</section><br><br><br><br>
		<footer><?php footer(); ?></footer>
	</div>
</body>

</html>
