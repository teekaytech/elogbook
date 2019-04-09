<html>
<?php

@session_start();
require_once "../public/super_header.php";
require_once "../public/footer.php";
require_once "../classes/supervisor.php";

$super = new supervisor();
$handle = $super->dbEngine();

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
                <?php
                $organizations = $super->fetch_organization();
                if ($_SESSION['status']==1) {
                    echo 'You\'re an <b>Institution-based </b>Supervisor.';
                    foreach ($organizations as $item) {
                        if ($_SESSION['org_id'] == $item['org_id']) {
                            echo '<br> Your Institution: <b>' . $item['org_name'].'</b>';
                            break;
                        }
                    } ?>
                    <div class="row">
                        <dl>
                            <dt><br> You can: </dt>
                            <dd>Register qualified students by clicking on <b><i>Register Student</i></b> link,</dd>
                            <dd>Assess daily activities of interns by clicking on <b><i>Assess Report</i></b> link,</dd>
                            <dd>Update Password by clicking on <b><i>Edit Profile</i></b> link, and</dd>
                            <dd>Logout of the platform by clicking on the <b><i>Logout</i></b> button above.</dd>
                        </dl>
    			    </div>
                    <p style="color: red">
                        <b>
                            If you are on Inspection, <a href="inspection_form.php">CLICK HERE</a>
                            to fill the Inspection Form. Ignore if otherwise.
                        </b>
                    </p>
                    <?php
                } else {
                    echo 'You\'re an <b>Industry-based</b> Supervisor.';
                    foreach ($organizations as $item) {
                        if ($_SESSION['org_id'] == $item['org_id']) {
                            echo '<br>Your Organization: <b>' . $item['org_name'].'</b>';
                            break;
                        }
                    }?>
                    <div class="row">
 					<dl>
						<dt><br> You can: </dt><br>
						<dd>Endorse daily activities of interns by clicking on <b><i>Endorse Report</i></b> link,</dd>
						<dd>Update Password by clicking on <b><i>Edit Profile</i></b> link, and</dd>
						<dd>Logout of the platform by clicking on the <b><i>Logout</i></b> button above.</dd><br>
					</dl>
    			</div>  <?php
                }?>
			</div><br>
		</section>
	</div>
	<footer><?php footer(); ?></footer>
    </body>

</html>
