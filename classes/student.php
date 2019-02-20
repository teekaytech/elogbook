<?php
@session_start();

class student {

	public $handle;
	public $stmt;
	public $db_name = "elogbook";


	public function __construct(){
		$this->handle = $this->dbEngine();
	}

	public function dbEngine(){
		try{
			$this->handle = new PDO("mysql:host=localhost;dbname=$this->db_name","root","");
				$this->handle->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
		return $this->handle;
	}

	//admin login function
	public function student_login($matric_no, $password){
		try {
			$this->stmt = $this->handle->prepare("SELECT * FROM student WHERE stud_id = :matric_no AND stud_pswd = :password");
			$this->stmt->execute(array(':matric_no' =>$matric_no, ':password' => $password));
			$row = $this->stmt->rowCount();
			$student = $this->stmt->fetch();
			if($row > 0)
			{	
				@session_start();
				$_SESSION['matric'] = $student['stud_id'];
				$_SESSION['key'] = $password;
				$_SESSION['name'] = $student['stud_lname'].' '.$student['stud_fname'].' '.$student['stud_mname'];
				$_SESSION['dept_id'] = $student['DEPARTMENTdept_id'];
				$_SESSION['org_id'] = $student['org_id'];
				$_SESSION['start_date'] = $student['it_date'];
				$_SESSION['session'] = $student['session'];
			     return true;
			}
			else{
				return false;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function stud_logout() {
	    session_unset();
		session_destroy();
	}

	public function update_profile($password) {
		try {
            $this->stmt = $this->handle->prepare("UPDATE student SET stud_pswd=:pswd WHERE stud_id=:std_id");
            $this->stmt->execute(array('pswd'=>$password, 'std_id' => $_SESSION['matric']));
            return true;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
	}


    public function fetch_student_details($matric) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT * FROM student WHERE `stud_id`=:msession");
            $this->stmt->execute(array('msession'=>$matric));
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function fetch_student_dept($dept_id, $matric) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT `dept_desc` FROM `department` JOIN `student` WHERE `dept_id` = :dept_id AND `stud_id`=:matric");
            $this->stmt->execute(array('dept_id'=>$dept_id, 'matric'=>$matric));
            $user = $this->stmt->fetchAll();
            $output = "";
            foreach ($user as $key => $output) {
            	return $output[0];
            }
            return;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function calculate_end_date($matric){
    	$duration = $this->fetch_student_details($matric);
    	$start_date = '';
    	$no_of_days = '';
    	foreach ($duration as $key => $value) {
    		if ($value['stud_it_duration']==1) { $no_of_days = '+1 month'; }
    		if ($value['stud_it_duration']==2) { $no_of_days = '+2 months'; }
    		if ($value['stud_it_duration']==3) { $no_of_days = '+3 months'; }
    		if ($value['stud_it_duration']==4) { $no_of_days = '+4 months'; }
    		if ($value['stud_it_duration']==5) { $no_of_days = '+5 months'; }
    		if ($value['stud_it_duration']==6) { $no_of_days = '+6 months'; }
    		if ($value['stud_it_duration']==12) { $no_of_days = '+12 months'; }
    		$start_date = $value['it_date'];
    	}
    	$dur = strtotime($no_of_days,strtotime($start_date));
    	return $dur=date('Y-m-j',$dur);
    }

    public function get_weeks($matric,$duration,$start){
    	$start_date = $_SESSION['start_date'];
    	$end_date = $this->calculate_it_duration($matric,$duration,$start);
    	$date_d = date_diff(new DateTime($end_date),new DateTime($start_date));
    	echo $end_date;
    	return $date_d->format('%d');
    	
    }
    
    public function fetch_student_fac($dept_id) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT `fac_desc` FROM `faculty` JOIN `department` WHERE `department`.`FACULTYfac_id` = `fac_id` AND `department`.`dept_id`=:depId");
            $this->stmt->execute(array('depId'=>$dept_id));
            $user = $this->stmt->fetchAll();
            $output = "";
            foreach ($user as $key => $output) {
                return $output[0];
            }
            return;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function fetch_student_passport($matric) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT * FROM stud_passport WHERE `stud_id`=:msession");
            $this->stmt->execute(array('msession'=>$matric));
            $user = $this->stmt->fetchAll();
            $address = '';
            foreach ($user as $item) {
                $address = $item['passport'];
            }
            return $address;
        }
        catch(PDOException $e) { echo $e->getMessage(); }
    }
    
    public function fetch_organization_details($id) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT * FROM organization JOIN `student` WHERE `student`.`org_id`=`organization`.`org_id` AND `student`.`stud_id`=:stud");
            $this->stmt->execute(array('stud'=>$id));
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    
    public function fetch_supervisor_details($id) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT * FROM supervisor
            JOIN `student` WHERE student.`org_id`=`supervisor`.`org_id` AND `student`.`stud_id`=:id");
            $this->stmt->execute(array('id'=>$id));
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    function upload_completion_slip($fname, $matric) {
        try {
            $this->stmt = $this->handle->prepare("INSERT INTO end_of_siwes (`file_name`,`stud_id`) VALUES (:fname,:matric)");
            $this->stmt->execute(array(':fname' => $fname, ':matric' => $matric));
            return true;
        } catch(PDOException $e) { echo $e->getMessage();   }
    }
    
    public function upload_image($folder) {
	    
        $file_name = $_FILES['file']['name'];
        $file_loc = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $max_size = 200000;
        if ($file_size <= $max_size) {
            if ($file_type=='application/pdf') {
                move_uploaded_file($file_loc, $folder . $file_name);
                return true;
            }
        }
    }
    
    public function check_final_slip_status($matric) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT * FROM end_of_siwes WHERE `stud_id`=:msession");
            $this->stmt->execute(array('msession'=>$matric));
            $user = $this->stmt->fetchAll();
//            var_dump($user);
            if (count($user)< 1) {
                return TRUE;
            } else { return FALSE; }

        }
        catch(PDOException $e) { echo $e->getMessage(); }
    }
}
?>