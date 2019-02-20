<?php

//@session_start();

class Supervisor {

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

	//supervisor login function
	public function super_login($username, $password){
		try
		{
			$this->stmt = $this->handle->prepare("SELECT * FROM supervisor WHERE super_id = :username AND super_pswd = :password");
			$this->stmt->execute(array(':username' =>$username, ':password' => $password));
			$row = $this->stmt->rowCount();
			$user = $this->stmt->fetch();
			if($row > 0)
			{
				@session_start();
				$_SESSION['super_id'] = $user['super_id'];
				$_SESSION['key'] = $password;
				$_SESSION['super_name'] = $user['super_lname'].' '.$user['super_fname'].' '.$user['super_mname'];
				$_SESSION['super_type'] = $user['super_status'];
				$_SESSION['org_id'] = $user['org_id'];
				$_SESSION['status'] = $user['super_status'];
			    return true;
			} else {
				return false;
			}
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function reg_student($matric, $sname, $fname, $oname, $nok, $pass, $level, $session, $it_duration, $dept, $org, $dt){
		try
		{
			$this->stmt = $this->handle->prepare("INSERT INTO student (`stud_id`,`stud_lname`,`stud_fname`, `stud_mname`,`stud_nok`,`stud_level`,`session`,`stud_it_duration`,`stud_pswd`, `DEPARTMENTdept_id`,`org_id`, `SUPERVISORsuper_id`, `it_date`) VALUES (:matric, :sname, :fname, :oname, :nok, :level, :session, :it_duration, :pass, :dept, :org, :sup_id, :dt)");
			$this->stmt->execute(array(':matric'=>$matric, ':sname'=>$sname, ':fname'=>$fname, ':oname'=>$oname, ':nok'=>$nok, ':level'=>$level, ':session'=>$session, ':it_duration'=>$it_duration, ':pass'=>$pass, ':dept'=>$dept, ':org'=>$org, ':sup_id'=>$_SESSION['super_id'], 'dt'=>$dt));
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


    public function fetch_super_details($id) {
	    try
	    {
	        $this->stmt = $this->handle->prepare("SELECT * FROM supervisor WHERE `super_id`=:id");
	        $this->stmt->execute(array('id'=>$id));
	        $user = $this->stmt->fetchAll();
	        return $user;
	    }
	    catch(PDOException $e)
	    {
	        echo $e->getMessage();
	    }
	}

    public function fetch_super_org($org_id) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT `org_name` FROM `organization` JOIN `supervisor` WHERE `organization`.`org_id` = :org_id");
            $this->stmt->execute(array('org_id'=>$org_id));
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

    public function super_status($status) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT `super_status` FROM `supervisor` WHERE `super_status` = :status");
            $this->stmt->execute(array('status'=>$status));
            $user = $this->stmt->fetchAll();
            $output = "Industry-based";
            foreach ($user as $key => $value) {
            	if ($value==0) {
            		$output = "Institution-based";
            	}
            }
            return $output;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

	public function update_profile($password) {
		try {
            $this->stmt = $this->handle->prepare("UPDATE supervisor SET super_pswd=:pswd WHERE super_id=:super_id");
            $this->stmt->execute(array('pswd'=>$password, 'super_id' => $_SESSION['super_id']));
            return true;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
	}

	public function super_logout() {
		unset($_SESSION['super_id']);
		unset($_SESSION['key']);
		unset($_SESSION['super_name']);
		unset($_SESSION['super_type']);
		unset($_SESSION['org_id']);
		unset($_SESSION['status']);
		session_destroy();
	}

	public function fetch_organization() {
		try
		{
			$this->stmt = $this->handle->prepare("SELECT * FROM organization ");
			$this->stmt->execute();
			$user = $this->stmt->fetchAll();
			return $user;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function fetch_department() {
		try
		{
			$this->stmt = $this->handle->prepare("SELECT * FROM department");
			$this->stmt->execute();
			$user = $this->stmt->fetchAll();
			return $user;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function fetch_student_report($id) {
        try {
            $this->stmt = $this->handle->prepare("SELECT * FROM daily_report WHERE stud_id=:id");
            $this->stmt->execute(array(':id' => $id));
            $result = $this->stmt->fetchAll();
            return $result;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function fetch_report_attachment() {
        try {
            $this->stmt = $this->handle->prepare("SELECT * FROM attachment JOIN daily_report WHERE `attachment`.DAILY_REPORTrpt_id=`daily_report`.rpt_id");
            $this->stmt->execute();
            $result = $this->stmt->fetchAll();
            return $result;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function fetch_student_details($sid) {
        try {
            $this->stmt = $this->handle->prepare("SELECT * FROM student WHERE stud_id=:id");
            $this->stmt->execute(array(':id'=>$sid));
            $result = $this->stmt->fetchAll();
            return $result;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
//    public function submit_supervisor_endorsement($comment, $grade, $sat_level) {
//        try
//        {
//            $this->stmt = $this->handle->prepare("INSERT INTO approval (`approv_date`,`approv_status`,`approv_comment`,`rpt_id`) VALUES (:matric, :sname, :fname, :oname, :nok, :level, :session, :it_duration, :pass, :dept, :org, :sup_id, :dt)");
//            $this->stmt->execute(array(':matric'=>$matric, ':sname'=>$sname, ':fname'=>$fname, ':oname'=>$oname, ':nok'=>$nok, ':level'=>$level, ':session'=>$session, ':it_duration'=>$it_duration, ':pass'=>$pass, ':dept'=>$dept, ':org'=>$org, ':sup_id'=>$_SESSION['super_id'], 'dt'=>$dt));
//            return true;
//        } catch(PDOException $e) { echo $e->getMessage(); }
//    }
    
    public function report_approval($date, $comment, $status, $id) {
        try {
            $this->stmt = $this->handle->prepare("INSERT INTO approval (`approv_date`,`approv_comment`,`approv_status`,`rpt_id`,`super_id`) VALUES (:dt,:cmt,:stat,:rid,:sup)");
            $this->stmt->execute(array(':dt' => $date, ':cmt'=>$comment, ':stat' => $status, ':rid'=>$id, ':sup'=>$_SESSION['super_id']));
            return true;
        } catch(PDOException $e) { echo $e->getMessage();   }
    }
    
    public function ind_report_approved($id) {
        try {
            $this->stmt = $this->handle->prepare("UPDATE daily_report SET `ind_appr_status`=:one WHERE `rpt_id`=:id");
            $this->stmt->execute(array(':one'=>'1', ':id'=>$id));
            return true;
        } catch(PDOException $e) { echo $e->getMessage(); }
    }
    
    public function fetch_report_approval($sid) {
        try {
            $this->stmt = $this->handle->prepare("SELECT approval.*, daily_report.`stud_id` FROM approval
            JOIN daily_report WHERE approval.`rpt_id` = daily_report.`rpt_id` AND daily_report.`stud_id`=:id");
            $this->stmt->execute(array(':id'=>$sid));
            $result = $this->stmt->fetchAll();
            return $result;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function fetch_assessment($sid) {
        try {
            $this->stmt = $this->handle->prepare("SELECT * FROM assessment WHERE `STUDENTstud_id`=:id");
            $this->stmt->execute(array(':id'=>$sid));
            $result = $this->stmt->fetchAll();
            return $result;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function report_assessment_upload($sid, $date, $comment, $grade) {
        try {
            $this->stmt = $this->handle->prepare("INSERT INTO assessment (`SUPERVISORsuper_id`,
            `STUDENTstud_id`,`assess_date`,`assess_comment`,`assess_grade`) VALUES (:ssid,:sid,:dt,:cmt,:grd)");
            $this->stmt->execute(array('ssid'=>$_SESSION['super_id'],':sid'=>$sid,':dt' => $date,':cmt'=>$comment, ':grd'=>$grade));
            return true;
        } catch(PDOException $e) { echo $e->getMessage();   }
    }
    
    
    public function ins_report_update($id) {
        try {
            $this->stmt = $this->handle->prepare("UPDATE daily_report SET `inst_appr_status`=:one WHERE `stud_id`=:id");
            $this->stmt->execute(array(':one'=>'1', ':id'=>$id));
            return true;
        } catch(PDOException $e) { echo $e->getMessage(); }
    }
    
    public function insert_passport($file, $sid) {
        try {
            $this->stmt = $this->handle->prepare("INSERT INTO stud_passport (`stud_id`,`passport`) VALUES (:id,:pass)");
            $this->stmt->execute(array(':id' => $sid, ':pass' => $file));
            return true;
        } catch(PDOException $e) { echo $e->getMessage();   }
    }
    
    public function upload_image($folder) {
	    $message = null;
        $file_name = $_FILES['file']['name'];
        $file_loc = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $max_size = 100000;
        
        // Get Image Dimension
        $fileinfo = @getimagesize($file_loc);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        
        if ($file_size <= $max_size) {
            if ($file_type=='image/jpg' || $file_type=='image/jpeg' || $file_type=='image/png') {
                if ($width <= "250" && $height <= "300") {
                    move_uploaded_file($file_loc, $folder . $file_name);
                } else { $message = 'Image dimension should be less or equal to 250 X 300px'; }
            } else { $message = 'Upload valid images. Only PNG and JPEG are allowed.'; }
        } else { $message = 'Image size exceeds 100KB'; }
        
        return $message;
    }
    
}