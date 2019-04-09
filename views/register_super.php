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
    <section id="content">
        <div class="container">
            <section id="inner-headline">
                <div class="container" style="align-items: center;">
                    <h3 align="center">| Supervisors Registration Page |</h3>
                </div>
            </section>
            <?php if ((isset($_SESSION['admin_id'])) && (isset($_SESSION['key']))) {
            $ad_id = $_SESSION['main_id']; ?><br>
            <center>
                <p>
                    <span>Dear <b style="color: blue;"><?php echo $_SESSION['admin_name']; ?>,</b> Welcome to Supervisors
                    Registration page!</span>
                </p>
                <div style="background-color: whitesmoke;">
                <p style="color: red;">Kindly supply the necessary information. All fields with (*) are compulsory.</p>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm"
                     name="myform" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="form-group">
                    <div>
                        <label for="itext">* Supervisor ID </label>
                        <input class="form-control" name="s_id" id="itext" size="20" placeholder="Enter Supervisor ID" required/>
                        <span id="iInfo" style="display: none; " class="fa label-info"></span>
                    </div>
                    <div>
                        <label for="stext">* Surname </label>
                        <input class="form-control" name="surname" id="stext" size="20" placeholder="Enter Surname" required/>
                        <span id="sInfo" style="display: none; " class="fa label-info"></span>
                    </div>
                    <div>
                        <label for="ftext">* First Name </label>
                        <input class="form-control" name="fname" id="ftext" size="20" placeholder="Enter First name" required/>
                        <span id="fInfo" style="display: none; " class="fa label-info"></span>
                    </div>
                    <label for="otext">Other names</label>
                    <input class="form-control" name="oname" id="otext" size="20" placeholder="Enter Other name"/>
                    <div>
                        <label for="utext">* Username </label>
                        <input class="form-control" name="uname" id="utext" size="15" placeholder="Enter Username" required=""/>
                        <span id="uInfo" style="display: none; " class="fa label-info"></span>
                    </div>
                    <div>
                        <label for="email">* Email </label>
                        <input class="form-control" name="email" id="email" size="60" placeholder="E.g olaosebikan@ymail.com"
                           type="email" required=""/>
                        <span id="eInfo" style="display: none; " class="fa label-info"></span>
                    </div>
                    <div>
                        <label for="password">* Enter Password </label>
                        <input class="form-control" name="password" type="password" placeholder="Enter Password"
                               id="password" required/>
                        <span id="pInfo" style="display: none; " class="fa label-info"></span>
                    </div>
                    <div>
                        <label for="password_two">* Re-enter Password </label>
                        <input class="form-control" name="password_two" type="password" placeholder="Enter Password"
                               data-rule="minlen:8" id="password_two" required/><span id="ptInfo" style="display: none; " class="fa label-info"></span>
                    </div>
                    <div>
                        <label for="ptext">* Phone Number </label>
                        <input class="form-control" name="phone_no" id="ptext" size="11" placeholder="E.g 080XXXXXXXX"
                               data-rule="minlen:11" required=""/>
                        <span id="passInfo" style="display: none; " class="fa label-info"></span>
                    </div>
                    <p>Select Category:&nbsp&nbsp
                        <input type="radio" name="rad" required value="0" onclick="doClick(this)">&nbspIndustry-based
                        &nbsp&nbsp&nbsp&nbsp
                        <input type="radio" name="rad" value="1" required onclick="doClick(this)">&nbspInstitution-based
                    </p>
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
                                    } ?>
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
                    <label for="super_sign" style="color: red;">* Select signature</label>
                    <input class="form-control" name="file" value="signature here..." type="file" required/>
                    <div class="validation"></div><br>
                        <input class="form-control" name="admin_id" type="text" required readonly
                               value='Admin ID: <?php echo "$ad_id"; ?>'/>
                    <br>
                    <button type="submit" name="super_submit" class="btn btn-primary">Register Supervisor </button>
                    </form>
                </div>
            </center>
        </div>
    </section>
</div>
<?php } ?>
<footer><?php footer(); ?></footer>
<script>
    var userMail = document.getElementById('email');
    userMail.addEventListener('focusout', function () {
        var outputMessage = document.getElementById('eInfo');
        var re = /\S+@\S+\.\S+/;
        if (userMail.value === '') {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Email cannot be empty!';
        }
        else if (! re.test(userMail.value)) {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Invalid Email Format...try again!';
            userMail.value = '';
        }
        else {
            outputMessage.innerText = '';
        }
    });
    
    var username = document.getElementById('utext');
    username.addEventListener('focusout', function () {
        var outputMessage = document.getElementById('uInfo');
        if (username.value === '') {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Username cannot be empty!';
        }
        else if (username.value.length > 20 || username.value.length < 8) {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Username cannot be less than 8 or more than 20 characters!';
            username.value = '';
        }
        else {
            outputMessage.innerText = '';
        }
    });
    
    var firstname = document.getElementById('ftext');
    firstname.addEventListener('focusout', function () {
        var outputMessage = document.getElementById('fInfo');
        if (firstname.value.length > 20) {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Firstname cannot be more than 20 characters!';
            firstname.value = '';
        } else if (firstname.value < 1) {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Firstname cannot be empty!';
        }
        else {
            outputMessage.innerText = '';
        }
    });
    
    var uSurname = document.getElementById('stext');
    uSurname.addEventListener('focusout', function () {
        var outputMessage = document.getElementById('sInfo');
        if (uSurname.value.length > 20) {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Surname cannot be more than 20 characters!';
            uSurname.value = '';
        } else if (uSurname.value < 1) {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Surname cannot be empty!';
        }
        else {
            outputMessage.innerText = '';
        }
    });

   var userId = document.getElementById('itext');
   userId.addEventListener('focusout', function () {
       var outputMessage = document.getElementById('iInfo');
       if (userId.value === '') {
           outputMessage.style.display = 'inline';
           outputMessage.innerText = 'Supervisor ID cannot be empty!';
       }
       else if (userId.value.length > 20) {
           outputMessage.style.display = 'inline';
           outputMessage.innerText = 'Supervisor ID cannot be more than 20 characters!';
           userId.value = '';
       }
       else {
           outputMessage.innerText = '';
       }
   });
    
    var passWord = document.getElementById('password');
    passWord.addEventListener('focusout', function () {
        var outputMessage = document.getElementById('pInfo');
        if (passWord.value === '') {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Password cannot be empty!';
        }
        else if (passWord.value.length < 8) {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Password length must be 8 or more characters';
            passWord.value = '';
        } else {
            outputMessage.innerText = '';
        }
    });
    var passWordTwo = document.getElementById('password_two');
    passWordTwo.addEventListener("focusout", function () {
        var outputMessage = document.getElementById('ptInfo');
        if (passWordTwo.value === '') {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Confirm Password cannot be empty!';
        }
        else if (passWordTwo.value != passWord.value) {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Confirm password is not correct!';
            // passWordTwo.value = '';
            passWordTwo.focus();
        } else {
            outputMessage.innerText = '';
        }
    });

    var phone = document.getElementById('ptext');
    phone.addEventListener("focusout", function () {
        var outputMessage = document.getElementById('passInfo');
        if (phone.value === '') {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Phone number cannot be empty!';
        }
        else if (phone.value.length !== 11 || isNumeric(phone.value)===false) {
            outputMessage.style.display = 'inline';
            outputMessage.innerText = 'Phone number format should be 080xxxxxxxx (11 digits)!';
            phone.value = '';
            phone.focus();
        } else {
            outputMessage.innerText = '';
        }
    });
    
</script>
</body>

</html>
