<?php 
@session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>UI E-Logbook - Student Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <!-- css -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" />
        <link href="../css/fancybox/jquery.fancybox.css" rel="stylesheet">
        <link href="../css/jcarousel.css" rel="stylesheet" />
        <link href="../css/flexslider.css" rel="stylesheet" />
        <link href="../css/style.css" rel="stylesheet" />
        <!-- Theme skin -->
        <link href="skins/default.css" rel="stylesheet" />
    </head> 
<?php
function main_header() { ?>
    <header>
    <div class="navbar navbar-default ">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="../index.php"><span><img src="../img/ui.png"></span>   Industrial Training Coordinating Centre</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="../views/std_profile.php">Edit Profile</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle " data-toggle="dropdown">Upload <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="../views/upload_report.php">Daily Report</a></li>
                            <li><a href="../views/upload_slip.php">End-of-SIWES slip</a></li>
                        </ul>
                    </li>
                    <li><a href="../views/std_dwld.php">Download</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header><?php } ?>