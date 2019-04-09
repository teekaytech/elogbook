<html>
<?php
require_once "../public/header.php";
require_once "../public/footer.php";

main_header();
?>
<body>
<div id="wrapper">
    <section id="inner-headline">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i></a><i class="icon-angle-r ight"></i></li>
                        <li class="active">Manual</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section id="content">
        <div class="container">
            <p>This section involves the steps to take to ensure successful report activities and completion.</p>
            <p>The process starts from the <b>Admin</b>, who is given the full privilege to login and perform the following operations:
            <dl>
                <dd><span class="fa fa-chevron-right"></span>  Register supervsors (Industry/Institution based).</dd>
                <dd><span class="fa fa-chevron-right"></span>  Edit Profile (Password Update).</dd>
                <dd><span class="fa fa-chevron-right"></span>  Download summary/detailed report of Interns and Supervisors for a particular Session/Department.</dd>
            </dl>
            <p>Registered <b>Institution-based supervisors</b> can then login with their ID and password to:</p>
            <dl>
                <dd><span class="fa fa-chevron-right"></span>  Registers qualified students on the platform.</dd>
                <dd><span class="fa fa-chevron-right"></span>  Assesses students activities for approval.</dd>
                <dd><span class="fa fa-chevron-right"></span>  Edit Profile (Password Update).</dd>
            </dl>
            <p>Registered <b>Industry-based supervisors</b> can also login with their ID and password to:</p>
            <dl>
                <dd><span class="fa fa-chevron-right"></span>  Endorse Interns' reports (If any is available for endorsement).</dd>
                <dd><span class="fa fa-chevron-right"></span>  Edit Profile (Password Update).</dd>
            </dl>
            <p>Registered <b>Interns</b> login with their Matric Number and password, as assigned to them by the Industry-based supervisor, to:</p>
            <dl>
                <dd><span class="fa fa-chevron-right"></span>  Upload report of activities <b>ON DAILY BASIS!</b></dd>
                <dd><span class="fa fa-chevron-right"></span>  Edit Profile (Password Update).</dd>
                <dd><span class="fa fa-chevron-right"></span>  Download End-Of-SIWES slip for approval at ITCC at the end of the training.</dd>
                <dd><span class="fa fa-chevron-right"></span>  Re-Upload the approved End-Of-SIWES slip.</dd>
                <dd><i>This marks the end of the whole process for students.
                        <br><b>Note:</b> The End-Of-SIWES slip will not be accessible if any of the supervisors is yet to approve the intern's report.</i></dd>
            </dl>
        </div>
    </section>
    <?php footer(); ?>
</div>
<a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a>


</body>

</html>
