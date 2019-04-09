<?php

@session_start();
require_once ("../public/admin_header.php");
require_once ("../public/footer.php");
require_once ("../classes/admin.php");
require_once ("admin_reports.php");

$admin = new Admin();
$handle = $admin->dbEngine();
if (isset($_POST['Download'])) {

    $category = $_POST['category'];
    $cat_student = $_POST['sub_one'];
    $cat_super = $_POST['sub_two'];
    $department = $_POST['dept'];
    $session = $_POST['session'];
    
    
    if ($category=='1') { //interns selected
        if ($cat_student=='1') {  //Names of interns
            student_list_only($admin, $department, $session);
        }
        if ($cat_student=='2')  { //Full Details of Interns
            student_full_details($admin, $department, $session);
        }
    }
    else if ($category=='2') { //supervisors selected
        if ($cat_super=='1') { //basic details only
            supervisor_basic_details($admin, $session);
        }
        if ($cat_super=='2') { //exclusive details
            $super_type = $_POST['s_type'];
            if ($super_type == '1') { //industry-based supervisors
                supervisor_student_details($admin, $session, '0');
            }
            if ($super_type == '2') { //institution-based supervisors
                supervisor_student_details_inst($admin, $session, '1');
            }
            
        }
    }
    else {
        ?><script type="text/javascript"> alert('Please, select a category'); </script><?php
    }
}
main_header();
?>
<html>
<head>
	<script type="text/javascript">
    function doClick(objDrop){
      if (objDrop.value=="1"){ 
        document.getElementById("cat_one").style.display='block'; //show students category
        document.getElementById("cat_two").style.display='none'; //hide supervisors category
          document.getElementById("super_type").style.display='none'; //hide supervisors type
      }
      else if (objDrop.value=="2"){ 
        document.getElementById("cat_one").style.display='none';
        document.getElementById("cat_two").style.display='block';
          document.getElementById("dept").style.display='none';
        document.getElementById('cat_two').setAttribute('required', true);
      }
      else {
      	document.getElementById("cat_one").style.display='none';
        document.getElementById("cat_two").style.display='none';
          document.getElementById("super_type").style.display='none';
      }
    }
    
    function hideDept(selected) {
        if (selected.value=="1") {
            var myObj = document.getElementById("super_type");
            myObj.style.display='none';
            
        }
        if (selected.value=="2") {
            var myObj = document.getElementById("super_type");
            myObj.style.display='block';
            myObj.setAttribute('required', true);
        }
    }
  </script>
</head>
<body>
	<div id="wrapper">
		<section id="content">
			<div class="container">
				<section id="inner-headline">
					<div class="container">
						<h3 align="center">| Admin Download Page |</h3>
					</div>
				</section>
				<br><p><center>Dear <b style="color: blue;"><?php echo $_SESSION['admin_name']; ?>,</b> Welcome to Download page!</p>
				<div class="row" align="left" style="color: red;">Select an option to continue</div>
				</center>
      			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="contactForm">
 					<div class="row">
 						<select name="category"class="form-control" onclick="doClick(this)">
 							<option value="">--select category--</option>
 							<option value="1"> Students </option>
 							<option value="2"> Supervisors </option>
 						</select><br>
 						<div id="cat_one" style="display: none;">
	 						<select name="sub_one" class="form-control">
	 							<option value="">--select download type--</option>
	 							<option value="1">Names of Interns</option>
	 							<option value="2">Full Details of Interns</option>
                                <option value="3">Generated Grades</option>
	 						</select><br>
 						</div>
 						<div id="cat_two" style="display: none;">
	 						<select name="sub_two" class="form-control" onclick="hideDept(this)">
	 							<option value="">--select download type (Institution-based only)--</option>
	 							<option value="1">List of Supervisors only</option>
	 							<option value="2">List of supervisors and Students supervised</option>
	 						</select><br>
 						</div>
                        <div id="dept">
                            <select name="dept" class="form-control">
<!--                        fetching departments-->
                            <?php
                                try {
                                    $my_dept = $admin->fetch_department(); ?>
                                    <option value="">--select department--</option>
                                    <?php foreach ($my_dept as $item) {
                                        ?><option value="<?php echo $item['dept_id']; ?>"><?php echo $item['dept_desc']; ?></option><?php
                                    }
                                } catch (Exception $e) {
                                    echo "Error: " . $e->getMessage();
                                } ?>
                            </select><br>
                        </div>
                        <div id="super_type" style="display: none; ">
                            <select name="s_type" class="form-control">
                                <option value="">--select supervisor type--</option>
                                <option value="1">Industry-based</option>
                                <option value="2">Institution-based</option>
                            </select><br>
                        </div>
                        <div>
 						    <select name="session" class="form-control" required>
	 							<option value="">--select session--</option>
                                <option value="2010/2011">2010/2011</option>
                                <option value="2011/2012">2011/2012</option>
                                <option value="2012/2013">2012/2013</option>
                                <option value="2013/2014">2013/2014</option>
                                <option value="2014/2015">2014/2015</option>
                                <option value="2015/2016">2015/2016</option>
                                <option value="2016/2017">2016/2017</option>
                                <option value="2017/2018">2017/2018</option>
                                <option value="2018/2019">2018/2019</option>
                                <option value="2019/2020">2019/2020</option>
	 						</select><br>
 						</div>

 						<div class="text-left"><input type="submit" name="Download"  style="color: white; background-color: blue;" value="Download"/>
		   			</div>
		   		</form> 
			</div>
		</section>
	</div>
	<footer><?php footer(); ?></footer>
    </body>

</html>
