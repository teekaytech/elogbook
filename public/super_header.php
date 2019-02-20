<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>UI E-Logbook - Supervisor Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <!-- css -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" />
        <link href="../css/fancybox/jquery.fancybox.css" rel="stylesheet">
        <link href="../css/jcarousel.css" rel="stylesheet" />
        <link href="../css/flexslider.css" rel="stylesheet" />
        <link href="../css/style.css" rel="stylesheet" />
        <script src="../js/bootstrap.min.js"></script>
    
        <!-- Theme skin -->
        <link href="skins/default.css" rel="stylesheet" />
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
                <a class="navbar-brand" href="index.html"><span><img src="../img/ui.png"></span>   Industrial Training Coordinating Centre</a>
            </div>
            <div class="navbar-collapse collapse ">
                <ul class="nav navbar-nav">
                    <li><a href="../views/register_stud.php">Register student</a></li>
                    <li><a href="../views/super_assess.php">Assess Report</a></li>
                    <li><a href="../views/super_profile.php">Edit Profile</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header> <?php
}

function industry_header() { ?>
    <header>
    <div class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
                <a class="navbar-brand" href="index.html"><span><img src="../img/ui.png"></span>   Industrial Training Coordinating Centre</a>
            </div>
            <div class="navbar-collapse collapse ">
                <ul class="nav navbar-nav">
                    <li><a href="../views/super_endorse.php">Endorse Report</a></li>
                    <li><a href="../views/super_profile.php">Edit Profile</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header> <?php
}
?>