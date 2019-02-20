<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>UI - Electronic Logbook System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <!-- css -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" />
        <link href="../css/fancybox/jquery.fancybox.css" rel="stylesheet">
        <link href="../css/jcarousel.css" rel="stylesheet" />
        <link href="../css/flexslider.css" rel="stylesheet" />
        <link href="../css/style.css" rel="stylesheet" />

        <!-- Theme skin -->
        <link href="../skins/default.css" rel="stylesheet" />
    </head> 
<?php
function main_header() { ?>
<header>
    <div class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
                <a class="navbar-brand" href="#"><span><img src="../img/ui.png"></span>   Industrial Training Coordinating Centre</a>
            </div>
            <div class="navbar-collapse collapse ">
                <ul class="nav navbar-nav">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../views/features.php">Features</a></li>
<!--
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle " data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">Admin<b class=" icon-angle-down"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="typography.html">Login</a></li>
                        </ul>
                    </li>
-->
                    <li><a href="../views/admin_login.php">Admin</a></li>
                    <li><a href="../views/student_login.php">Students</a></li>
                    <li><a href="../views/super_login.php">Supervisors</a></li>
                </ul>
            </div>
        </div>
    </div>
</header> <?php
}
?>