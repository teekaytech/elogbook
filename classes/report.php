<?php

@session_start();
use Carbon\Carbon; //namespace
require '../vendor/autoload.php'; //php class library

class Report {

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

    public function insert_report($rdate, $tm, $week, $rcontent) {
        try {
            $this->stmt = $this->handle->prepare("INSERT INTO daily_report (`rpt_date`,`time`,`week`,`rpt_content`,`stud_id`) VALUES (:dt,:tm,:week,:content,:sid)");
            $this->stmt->execute(array(':dt' => $rdate, ':tm' =>$tm, ':week'=>$week, ':content' => $rcontent, ':sid'=>$_SESSION['matric']) );
            return true;
        } catch(PDOException $e) { echo $e->getMessage();   }
    }
    
    public function insert_attachment($file, $rid) {
        try {
            $this->stmt = $this->handle->prepare("INSERT INTO attachment (`attach_file`,`DAILY_REPORTrpt_id`) VALUES (:attach,:id)");
            $this->stmt->execute(array(':attach' => $file, ':id' => $rid));
            return true;
        } catch(PDOException $e) { echo $e->getMessage();   }
    }

    protected function getDate($sid) {
        try {
            $this->stmt = $this->handle->prepare("SELECT * FROM student WHERE `stud_id`=:msession");
            $this->stmt->execute(array('msession'=>$sid));
            $user = $this->stmt->fetchAll();
            return $user;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getWeek($sid) {
        $startD = '';
        $duration = '';
        $student_profile = $this->getDate($sid);
        foreach ($student_profile as $stud) { 
            $startD = $stud['it_date'];
            $duration = $stud['stud_it_duration'];
        }
        
        $startDate = Carbon::createFromFormat('Y-m-d',$startD);

        $endDate = $startDate->copy()->addMonths($duration);
        
        $currentDate = Carbon::now();
        $currentWeek = $currentDate->diffInWeeks($startDate);
        if ($currentWeek == '0') {
            return $currentWeek = '1';
        } else {
            return $currentWeek;
        }
        //return  $stampDifference = $endDate->timestamp - $startDate->timestamp;
        // return $startDate->weekNumberInMonth;
    }
    
    public function getReport($sid) {
        try {
            $this->stmt = $this->handle->prepare("SELECT * FROM daily_report WHERE `stud_id`=:msession");
            $this->stmt->execute(array('msession'=>$sid));
            $user = $this->stmt->fetchAll();
            return $user;
        } catch(PDOException $e) { echo $e->getMessage();    }
    }
    
    /*
     * For this function to work well, ensure the following:
     * @param folder must be specified, which is the destination folder
     * Also the input type must be file, and name must also be file
     */
    public function upload_image($folder) {
        $file_name = $_FILES['file']['name'];
        $file_loc = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $max_size = 100000;
        //$folder = "../std_upld/";
        if ($file_size <= $max_size) {
            if ($file_type=='image/jpg' || $file_type=='image/jpeg') {
                move_uploaded_file($file_loc, $folder . $file_name);
                return true;
            }
        }
    }
    
    public function check_duration($sid) {
        $startD = '';
        $duration = '';
        $student_profile = $this->getDate($sid);
        foreach ($student_profile as $stud) {
            $startD = $stud['it_date'];
            $duration = $stud['stud_it_duration'];
        }
        $startDate = Carbon::createFromFormat('Y-m-d',$startD);
        $endDate = $startDate->copy()->addMonths($duration);
        $todayDate = Carbon::today();
//        echo $endDate.'<br>';
//        echo $startDate.'<br>';
        $todayDiff = $startDate->diffInDays($todayDate, FALSE).'<br>';
        $totalDays = $startDate->diffInDays($endDate, FALSE).'<br>';
//        echo $todayDiff.' '.$totalDays;
        if ($todayDiff <= $totalDays) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function it_end_string($sid) {
        $startD = '';
        $duration = '';
        $student_profile = $this->getDate($sid);
        foreach ($student_profile as $stud) {
            $startD = $stud['it_date'];
            $duration = $stud['stud_it_duration'];
        }
        $startDate = Carbon::createFromFormat('Y-m-d',$startD);
        $endDate = $startDate->copy()->addMonths($duration);
        
        return $endDate->toFormattedDateString();
    }
    
    public function it_end_print($sid) {
        $startD = '';
        $duration = '';
        $student_profile = $this->getDate($sid);
        foreach ($student_profile as $stud) {
            $startD = $stud['it_date'];
            $duration = $stud['stud_it_duration'];
        }
        $startDate = Carbon::createFromFormat('Y-m-d',$startD);
        $endDate = $startDate->copy()->addMonths($duration);
        
        return $endDate->copy()->addDays(2)->toFormattedDateString();
    }
    
    public function it_end_date($sid) {
        $startD = '';
        $duration = '';
        $student_profile = $this->getDate($sid);
        foreach ($student_profile as $stud) {
            $startD = $stud['it_date'];
            $duration = $stud['stud_it_duration'];
        }
        $startDate = Carbon::createFromFormat('Y-m-d',$startD);
        $endDate = $startDate->copy()->addMonths($duration);
        
        return $endDate;
    }
}
