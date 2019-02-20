<?php
	@session_start();

	if(((isset($_SESSION['matric'])) || (isset($_SESSION['super_id'])) || (isset($_SESSION['admin_id']))) ){
		unset($_SESSION['stud_id']);
		unset($_SESSION['staff_id']);
		unset($_SESSION['admin_id']);
		unset($_SESSION['matric']);
		unset($_SESSION['name']);
		unset($_SESSION['dept_id']);
		unset($_SESSION['org_id']);
		session_destroy();
		$url = "index.php";
		header("Location:$url");
	}

?>