<?php

@session_start();
require_once ("mypdf.php");
require_once ("../public/admin_header.php");
require_once ("../public/footer.php");
require_once ("../classes/admin.php");

$admin = new Admin();
$handle = $admin->dbEngine();
if (isset($_POST['Download'])) {

    $category = $_POST['category'];
    $cat_student = $_POST['sub_one'];
    //$cat_super = $_POST['sub_two'];
    $session = $_POST['session'];

    $pdf = new PDF();
    if ($category=='1') { //interns selected
      if ($cat_student=='1') {  //names of interns students
          $students = $admin->fetch_student_details($session);
          $pdf->AliasNbPages();
          $pdf->AddPage();
          $pdf->SetFont('Times','',12);
          foreach ($students as $key) {
              $stud_name = $key['stud_lname'].' '.$key['stud_fname'].' '.$key['stud_mname'];
              $pdf->Cell(10,10,$key['stud_id'],1,0);
              $pdf->Cell(50,10,$stud_name,1,0);
              $pdf->Cell(50,10,$key['stud_it_duration'],1,1);
          }
          ob_end_clean();
          $pdf->Output();
      }             
        else {
            $students_full = $admin->fetch_full_student_details($session);
            foreach ($students_full as $key) {
            }
        }

    } if ($category=='2') { return; }
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
      }
      else if (objDrop.value=="2"){ 
        document.getElementById("cat_one").style.display='none';
        document.getElementById("cat_two").style.display='block';
      }
      else {
      	document.getElementById("cat_one").style.display='none';
        document.getElementById("cat_two").style.display='none';
      }
    }
    
    function hideDept(selected) {
        if (selected.value=="1") {
            var myObj = document.getElementById("dept");
            myObj.style.display='none';
            myObj.setAttribute('required', false);
            
        }
        if (selected.value=="2") {
            var myObj = document.getElementById("dept");
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
						<h3 align="center">| Download Page |</h3>
					</div>
				</section>
				<br><p><center>Dear <b style="color: blue;"><?php echo $_SESSION['admin_name']; ?>,</b> Welcome to Download page!</p>
				<div class="row" align="left" style="color: red;">Select an option to continue</div>
				</center>
      			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="contactForm">
 					<div class="row">
 						<select name="category"class="form-control" onclick="doClick(this)" required>
 							<option value="">--select category--</option>
 							<option value="1"> Students </option>
 							<option value="2"> Supervisors </option>
 						</select><br>
 						<div id="cat_one" style="display: none;">
	 						<select name="sub_one" class="form-control" required>
	 							<option value="">--select download type--</option>
	 							<option value="1">Names of Interns</option>
	 							<option value="2">Full Details of Interns</option>
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
                            <select name="sub_two" class="form-control" required>
                                <option value="">--select department--</option>
                                <option value="1">Adult Education</option>
                                <option value="2">Computer Science</option>
                            </select><br>
                        </div>
                        <div>
 						    <select name="session" class="form-control" required>
	 							<option value="">--select session--</option>
	 							<option value="2012/2013">2012/2013</option>
	 							<option value="2013/2014">2013/2014</option>
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
