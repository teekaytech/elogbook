<html>
<?php

@session_start();
require_once "../public/admin_header.php";
require_once "../public/footer.php";
require_once "../classes/admin.php";


$admin = new Admin();
$handle = $admin->dbEngine();

if (isset($_POST['update'])) {
    if (isset($_SESSION['admin_id']) && isset($_SESSION['key'])) {
        $desig = $_POST['desig'];
        $c_pswd = $_POST['old_pwd'];
        $new_one = $_POST['new_pwd1'];
        $new_two = $_POST['new_pwd2'];
        if ($c_pswd==$_SESSION['key']) {
        if ($new_one == $new_two) {
        try {
            //updating the admin profile on the database without changing password
        if ($admin->update_profile($desig, $new_one)) { ?>
            <script type="text/javascript">
                alert('Profile Updated Successfully! Please re-login.');
            </script><?php
        $url = "admin_dashboard.php";
        header("Refresh: 0; URL='$url'");
        } else {
            echo "Update not successful!";
        }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        } else { ?>
            <script type="text/javascript">
                alert('New password does not match. Please try again!.');
            </script><?php
        }
        } else { ?>
            <script type="text/javascript">
                alert('Old password not correct!.');
            </script><?php
        }
    }
}

main_header();
?>
<body>
<div id="wrapper">
    <section id="content">
        <div class="container">
            <section id="inner-headline">
                <div class="container">
                    <h3 align="center">| <?php echo $_SESSION['admin_id']?> -- Edit Profile |</h3>
                </div>
            </section>
            <br>
            <?php
            if (($_SESSION['admin_id']) && ($_SESSION['key'])) { ?>
                <div class="row">
                    <div>
                        <p style="color: red;">Note: Only fields with (*) can be updated!</p>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm">
                            <div class="form-group"><br>
                                <?php
                                try {
                                    $admin_profile = $admin->fetch_admin_details();
                                    foreach ($admin_profile as $k => $ad) {
                                        if ($ad['admin_id'] == $_SESSION['main_id']) { ?>
                                            <input class="form-control" value="Admin ID: <?php echo $ad['admin_id']; ?>" readonly/>
                                            <label style="color: red;"><b>&nbsp</b></label>
                                            <input class="form-control" value="Full Name: <?php echo $ad['admin_lname'].' '.$ad['admin_fname'].' '.$ad['admin_mname']; ?>" readonly/><br>
                                            <input class="form-control" type="text" name="username" value="Username: <?php echo $ad['admin_uname']; ?>" readonly/>
                                            <label style="color: red;"><b>Designation(*)</b></label>
                                            <input class="form-control" name="desig" value="<?php echo $ad['admin_desig']; ?>"/><br>
                                            <label style="color: red;"><b>*Current Password</b></label>
                                            <input class="form-control" type="password" name="old_pwd" placeholder="Current Password" />
                                            <label style="color: red;"><b>* New password</b></label>
                                            <input class="form-control" type="password" name="new_pwd1" placeholder="New Password"/>
                                            <label style="color: red;"><b>*Confirm new password</b></label>
                                            <input class="form-control" type="password" name="new_pwd2" placeholder="Repeat New Password" required/>
                                        <?php }
                                    }
                                } catch (Exception $e) {
                                    echo "Error: " . $e->getMessage();
                                } ?>
                            </div>
                            <div class="text-left"><input type="submit" name="update" style="color: white; background-color: blue;" value="Update Profile"/>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
</div>
<footer><?php footer(); ?></footer>
</body>

</html>