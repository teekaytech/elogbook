<?php

@session_start();

class Admin {

	public $handle;
	public $stmt;
	public $db_name = "elogbook";


	public function __construct(){
		$this->handle = $this->dbEngine();
	}

	public function dbEngine(){
		try{
		    $host = 'us-cdbr-iron-east-04.cleardb.net';
		    $db_name = 'heroku_5b6c70553cd33d6';
		    $username = 'b4f380863da188';
		    $password = '93f73eff';
			$this->handle = new PDO("mysql:host=us-cdbr-iron-east-04.cleardb.net;dbname=heroku_5b6c70553cd33d6",$username,$password);
				$this->handle->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
		return $this->handle;
	}

	//admin login function
	public function login_admin($username, $password){
		try
		{
			$this->stmt = $this->handle->prepare("SELECT * FROM admin WHERE admin_uname = :username AND admin_pswd = :password");
			$this->stmt->execute(array(':username' =>$username, ':password' => $password));
			$row = $this->stmt->rowCount();
			$user = $this->stmt->fetch();
			if($row > 0)
			{	
				@session_start();
				$_SESSION['admin_id'] = $username;
				$_SESSION['key'] = $password;
				$_SESSION['admin_name'] = $user['admin_lname'].' '.$user['admin_fname'];
				$_SESSION['title'] = $user['admin_desig'];
				$_SESSION['main_id'] = $user['admin_id'];
			    return true;
			} else { 
				return false;	
			}
		} catch(PDOException $e) { 
			echo $e->getMessage();	
		}
	}

	public function reg_super_industry($s_id, $sname, $fname, $oname, $uname, $status, $sign, $phone, $email, $password, $org_id) {
		try
		{
			$this->stmt = $this->handle->prepare("INSERT INTO supervisor (`super_id`, `super_lname`, `super_fname`, `super_mname`, `super_uname`, `super_status`, `super_sign`, `phone_no`, `email`, `super_pswd`, `org_id`, `Adminadmin_id`) VALUES (:s_id, :sname, :fname, :oname, :uname, :status, :sign, :phone, :email, :password, :org_id, :a_id)");
			$this->stmt->execute(array(':s_id' => $s_id, ':sname' => $sname, ':fname' => $fname, ':oname' => $oname, ':uname' => $uname, ':status' => $status, ':sign'=>$sign, ':phone' => $phone, ':email' => $email, ':password' => $password, ':org_id' => $org_id, ':a_id'=>$_SESSION['main_id']) );
			return true;
		} catch(PDOException $e) { echo $e->getMessage();	}
	}

	public function download_data($job_title, $surname, $othernames, $email, $password, $phone_no, $super_status){ 
		try
		{
			$this->stmt = $this->handle->prepare("");
			$this->stmt->execute(array());
			return true; 
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

    public function reg_super_institution($s_id, $sname, $fname, $oname, $uname, $status, $sign, $phone, $email, $password) {
        try
        {
            $this->stmt = $this->handle->prepare("INSERT INTO supervisor (`super_id`, `super_lname`, `super_fname`, `super_mname`, `super_uname`, `super_status`, `super_sign`, `phone_no`, `email`, `super_pswd`, `org_id`, `Adminadmin_id`) VALUES (:s_id, :sname, :fname, :oname, :uname, :status, :sign, :phone, :email, :password, :org_id, :a_id)");
            $this->stmt->execute(array(':s_id' => $s_id, ':sname' => $sname, ':fname' => $fname, ':oname' => $oname, ':uname' => $uname, ':status' => $status, ':sign'=>$sign, ':phone' => $phone, ':email' => $email, ':password' => $password, 'org_id'=>'3', ':a_id'=>$_SESSION['main_id']) );
            return true;
        } catch(PDOException $e) { echo $e->getMessage();	}
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


    public function fetch_admin_details() {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT * FROM admin ");
                $this->stmt->execute();
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }


    public function fetch_student_details($msession) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT * FROM student WHERE `session`=:msession");
            $this->stmt->execute(array('msession'=>$msession));
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function fetch_full_student_details($msession) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT student.*, supervisor.* FROM student JOIN supervisor WHERE student.SUPERVISORsuper_id = supervisor.super_id AND `session`=:msession");
            $this->stmt->execute(array('msession'=>$msession));
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }


    public function fetch_supervisors() {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT * FROM supervisor ");
            $this->stmt->execute();
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }


	public function log_out() {
		session_destroy();
		$url = "index.php";
      	header("Refresh: 1; URL='$url'");
	}

    public function new_organization($org_name, $org_address, $org_city, $org_state, $org_phone) {
        try
        {
            $this->stmt = $this->handle->prepare("INSERT INTO organization (`org_name`, `org_address`, `org_city`, `org_state`, `org_contact_phone`) VALUES (:org_name, :org_address, :org_city, :org_state, :org_phone)");
            $this->stmt->execute(array(':org_name' => $org_name, ':org_address' => $org_address, ':org_city' => $org_city, ':org_state' => $org_state, ':org_phone' => $org_phone));
            return true;
        } catch(PDOException $e) { echo $e->getMessage();	}
    }

    public function last_index_of_organization() {
        $this->stmt = $this->handle->prepare("SELECT * FROM organization ");
        $this->stmt->execute();
        $rows = $this->stmt->rowCount();
        return $rows;
    }

    public function update_profile ($desig, $pswd) {
        try
        {
            $this->stmt = $this->handle->prepare("UPDATE admin SET admin_desig=:desig, admin_pswd=:pswd WHERE admin_id=:ad_id");
            $this->stmt->execute(array('desig' => $desig, 'pswd'=>$pswd, 'ad_id' => $_SESSION['main_id']));
            return true;

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
    
    public function fetch_student($deptId, $msession) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT * FROM student WHERE `session`=:msession AND `DEPARTMENTdept_id`=:dept");
            $this->stmt->execute(array('msession'=>$msession, 'dept'=>$deptId));
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function fetch_department_name($id) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT * FROM department WHERE `dept_id`=:id");
            $this->stmt->execute(array('id'=>$id));
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function fetch_specific_organization($id) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT * FROM organization WHERE org_id = :id");
            $this->stmt->execute(array('id'=>$id));
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function fetch_spec_supervisors($session) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT DISTINCT supervisor.`super_id`, supervisor.`super_lname`, supervisor.`super_fname`, supervisor.`super_mname`,
    supervisor.`super_status`, `supervisor`.`phone_no`, `supervisor`.`org_id` FROM supervisor JOIN student WHERE student.`SUPERVISORsuper_id` = supervisor.`super_id` AND student.`session` = :session ");
            $this->stmt->execute(array('session'=>$session));
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function fetch_super_student($session, $status) {
        try
        {
            $this->stmt = $this->handle->prepare("SELECT DISTINCT supervisor.`super_id`, supervisor.`super_lname`,
            supervisor.`super_fname`, supervisor.`super_mname`, supervisor.`super_status`, supervisor.`org_id`, student.`stud_id`,
            `student`.`stud_lname`, student.`stud_fname`, student.`stud_mname`, `student`.`DEPARTMENTdept_id`, `student`.`org_id` AS studOrg,
            `student`.`stud_it_duration` FROM supervisor JOIN student WHERE student.`SUPERVISORsuper_id` = supervisor.`super_id`
            AND student.`session` = :session AND supervisor.`super_status`=:status");
            $this->stmt->execute(array('session'=>$session, 'status'=>$status));
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

}
