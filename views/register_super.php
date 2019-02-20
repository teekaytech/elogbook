<?php

@session_start();
require_once "../public/admin_header.php";
require_once "../public/footer.php";
require_once "../classes/admin.php";

main_header();
$admin = new Admin();
$handle = $admin->dbEngine();


if (isset($_POST['super_submit'])) {

    //capturing new organization details

    //existing organizations
    $org_id = $_POST['myDrop'];

    //new organization
    $org_name = $_POST['org_name'];
    $org_address = $_POST['org_add'];
    $org_city = $_POST['org_city'];
    $org_state = $_POST['org_state'];
    $org_phone = $_POST['org_phone'];


    //handling signature uploads
    $file = rand(1000, 100000) . "-" . $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder = "../uploads/";
    move_uploaded_file($file_loc, $folder . $file);

    $s_id = $_POST['s_id'];
    $sname = $_POST['surname'];
    $fname = $_POST['fname'];
    $oname = $_POST['oname'];
    $uname = $_POST['uname'];
    $status = $_POST['rad'];
    $sign = $file;
    $phone = $_POST['phone_no'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $a_id = $_SESSION['main_id'];

    $message = "";
    //$login_status = false;
    $url = '';

    //processing the supervisor registration form
    $check_supervisor = true;
    $supervisors = $admin->fetch_supervisors($s_id);
    foreach ($supervisors as $k => $s) {
        if ($s['super_id'] == $s_id) {
            $check_supervisor = true;
            ?>
            <script type="text/javascript">alert('Supervisor has already been registered. Check details and try again.');</script><?php
        }
    }
    if ($check_supervisor) {
        if (($status == "0") && ($org_id >= 1)) { //industry-based supervisor for existing organizations
            try {
                if ($admin->reg_super_industry($s_id, $sname, $fname, $oname, $uname, $status, $sign, $phone, $email, $password, $org_id)) {
                    // $login_status = true;
                    ?>
                    <script type="text/javascript">alert('Supervisor Registration Successful!');</script>
                    <?php
                    $url = "admin_dashboard.php";
                    header("Refresh: 0; URL='$url'");
                } else {
                    $truth_value = false;
                    ?>
                    <script type="text/javascript">alert('Supervisor Registration NOT Successful!');</script>
                    <?php
                    $message = "Invalid username or password";
                    $url = "register_super.php";
                    header("Refresh: 2; URL='$url'");
                }
            } catch (exception $e) {
                echo $e;
            }
        }
        if (($status == "0") && ($org_id == 0)) {  //new organizations
            if (!empty($org_name) && !empty($org_address) && !empty($org_city) && !empty($org_state) && !empty($org_phone)) {
                $process_organization = $admin->new_organization($org_name, $org_address, $org_city, $org_state, $org_phone);
                $getting_id = $admin->fetch_organization();
                $new_org_id = '';
                foreach ($getting_id as $k => $v) {
                    if ($v['org_name'] = $org_name) {
                        $new_org_id = $v['org_id'];
                    }
                }
                if ($process_organization) {
                    try {
                        if ($admin->reg_super_industry($s_id, $sname, $fname, $oname, $uname, $status, $sign, $phone, $email, $password, $new_org_id)) {
                            $url = "admin_dashboard.php";
                            header("Refresh: 0; URL='$url'");
                        } else {
                            $truth_value = false;
                            ?>
                            <script type="text/javascript">alert('Supervisor Registration NOT Successful!');</script>
                            <?php
                        }

                    } catch (Exception $e) {
                        echo $e;
                    }
                }
            } else { ?>
                <script type="text/javascript">alert('All fields are COMPULSORY');</script>
                <?php
                //$url = "admin_dashboard.php";
                //header("Refresh: 1; URL='$url'");
            }
        }
        if ($status == "1") { //institution-based supervisors, for this category, the status is 1 and organization_is 3, UI staffs.
            try {
                if ($admin->reg_super_institution($s_id, $sname, $fname, $oname, $uname, $status, $sign, $phone, $email, $password)) {
                    // $login_status = true;
                    ?>
                    <script type="text/javascript">alert('Supervisor Registration Successful!');</script>
                    <?php
                    $url = "admin_dashboard.php";
                    header("Refresh: 0; URL='$url'");
                } else {
                    $truth_value = false;
                    ?>
                    <script type="text/javascript">alert('Supervisor Registration NOT Successful!');</script>
                    <?php
                    $message = "Invalid username or password";
                    $url = "register_super.php";
                    header("Refresh: 0; URL='$url'");
                }
            } catch (exception $e) {
                echo $e;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript">
        function doClick(objRad) {
            if (objRad.value == "0") {
                document.getElementById("industry").style.display = 'block'; //hide textbox
                document.getElementById("institution").style.display = 'none'; //show other options
            }
            if (objRad.value == "1") {
                document.getElementById("institution").style.display = 'block'; //hide other options
                document.getElementById("industry").style.display = 'none';

                document.getElementById("others").style.display = 'none';//show textbox
            }

            var elem = document.getElementById("myDrop");
            elem.onchange = function () {
                var hiddenDiv = document.getElementById("others");
                hiddenDiv.style.display = (this.value == "0") ? "block" : "none";
            };
        }
    </script>
</head>
<body>
<div id="wrapper">
    <center>

        <section id="content">
            <div class="container">
                <section id="inner-headline">
                    <div class="container">
                        <h3 align="center">| Supervisors Registration Page |</h3>
                    </div>
                </section>
                <?php if ((isset($_SESSION['admin_id'])) && (isset($_SESSION['key']))) {
                $ad_id = $_SESSION['main_id']; ?>
                <br>
                <p>
                <span>Dear <b style="color: blue;"><?php echo $_SESSION['admin_name']; ?>,</b> Welcome to Supervisors
                    Registration page!</span>
                </p>

                <div class="row">
                    <div>
                        <p style="color: red;">Kindly supply the necessary information. All fields are compulsory.</p>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm"
                              name="myform" enctype="multipart/form-data">
                            <div class="form-group">
                                <input class="form-control" name="s_id" id="text" placeholder="Supervisor Id"
                                       data-msg="Please enter your matric nubmer" required=""/>
                                <div class="validation"></div>
                                <br>
                                <input class="form-control" name="surname" id="text" placeholder="Surname"
                                       data-msg="Please enter your surname" required=""/>
                                <div class="validation"></div>
                                <br>
                                <input class="form-control" name="fname" id="text" placeholder="First name"
                                       data-msg="Please enter your other name" required=""/>
                                <div class="validation"></div>
                                <br>
                                <input class="form-control" name="oname" id="text" placeholder="Other name"
                                       data-msg="Please enter your first name" required=""/>
                                <div class="validation"></div>
                                <br>
                                <input class="form-control" name="uname" id="text" placeholder="Username" required=""/>
                                <div class="validation"></div>
                                <br>
                                <input class="form-control" name="email" id="email" placeholder="Your Email"
                                       type="email"
                                       required=""/>
                                <div class="validation"></div>
                                <br>
                                <input class="form-control" name="password" type="password" placeholder="Password"
                                       data-rule="minlen:8" data-msg="Please enter at least 8 characters" required=""/>
                                <div class="validation"></div>
                                <br>
                                <input class="form-control" name="phone_no" id="text" placeholder="Your phone number"
                                       data-rule="minlen:11" required=""/><br>
                                <p>Select Category:&nbsp&nbsp
                                    <input type="radio" name="rad" value="0" onclick="doClick(this)">&nbspIndustry-based
                                    &nbsp&nbsp&nbsp&nbsp
                                    <input type="radio" name="rad" value="1" onclick="doClick(this)">&nbspInstitution-based
                                </p>
                            </div>
                            <div id="institution" style="display:none;">
                                <input type="text" value="University of Ibadan" readonly="" class="form-control">
                            </div>
                            <div id="industry" style="display:none;">
                                <select name="myDrop" class="form-control" id="myDrop">
                                    <option value="">--Select Organization Name--</option>
                                    <?php
                                    try {
                                        $ind = $admin->fetch_organization();
                                        foreach ($ind as $k => $v) { ?>
                                            <option value="<?php echo $v['org_id']; ?>"><?php echo $v['org_name']; ?></option> <?php
                                        }
                                    } catch (Exception $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    ?>
                                    <option value="0">Others</option>
                                </select><br>
                            </div>
                            <div id="others" style="display:none;">
                                <input type="text" name="org_name" placeholder="Name of Organization"
                                       class="form-control"><br>
                                <input type="text" name="org_add" placeholder="Address of Organization"
                                       class="form-control"><br>
                                <input type="text" name="org_city" placeholder="Organization City" class="form-control"><br>
                                <input type="text" name="org_state" placeholder="Organization State"
                                       class="form-control"><br>
                                <input type="text" name="org_phone" placeholder="Organization Phone"
                                       class="form-control">
                            </div>
                            <div class="validation"></div>
                            <label for="super_sign" style="color: red;">Select your signature</label>
                            <input class="form-control" name="file" value="signature here..." type="file" required/>
                            <div class="validation"></div>
                            <br>
                            <input class="form-control" name="admin_id" type="text" required readonly
                                   value='Admin ID: <?php echo "$ad_id"; ?>'/>
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="submit" name="super_submit" class="btn btn-theme" style="color: red;">Register
                            Supervisor
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </section>
    </center>
</div>
<?php } ?>
<footer><?php footer(); ?></footer>
</body>

</html>
