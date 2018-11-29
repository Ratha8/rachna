<?php
class Report{
	private $report_id;
	private $student_id;
	private $mark_id;
	private $attentiveness;
	private $discipline;
	private $reading;
	private $writing;
	private $speaking;
	private $listening;
	private $memory;
	private $last_result;
	private $last_att;
	private $last_homework;
	private $last_classwork;
	private $last_q1;
	private $last_q2;
	private $last_q3;
	private $last_final;
	private $register_user;
	private $register_Date;
	private $update_user;
	private $update_date;
	private $del_flag;

        /**
	 * @return mixed $student_id
	 */
	public function getReportID()
	{
		return $this->report_id;
	}

	/**
	 * @param mixed $student_id
	 */
	public function setReportID($report_id)
	{
		$this->report_id = $report_id;
	}

	/**
	 * @return mixed $student_name
	 */
	public function getStudentID()
	{
		return $this->student_id;
	}

	/**
	 * @param mixed $student_name
	 */
	public function setStudentID($student_id)
	{
		$this->student_id = $student_id;
	}

	/**
	 * @return mixed $student_no
	 */
	public function getMarkID()
	{
		return $this->mark_id;
	}

	/**
	 * @param mixed $student_no
	 */
	public function setMarkID($mark_id)
	{
		$this->mark_id = $mark_id;
	}	

	/**
	 * @return mixed $latin_name
	 */
	public function getAttentiveness()
	{
		return $this->attentiveness;
	}

	/**
	 * @param mixed $latin_name
	 */
	public function setAttentiveness($attentiveness)
	{
		$this->attentiveness = $attentiveness;
	}	

	/**
	 * @return mixed $class_id
	 */
	public function getDiscipline()
	{
		return $this->discipline;
	}

	/**
	 * @param mixed $class_id
	 */
	public function setDiscipline($discipline)
	{
		$this->discipline = $discipline;
	}	

	/**
	 * @return mixed $duration
	 */
	public function getReading()
	{
		return $this->reading;
	}

	/**
	 * @param mixed $duration
	 */
	public function setReading($reading)
	{
		$this->reading = $reading;
	}

	/**
	 * @return mixed $gender
	 */
	public function getWriting()
	{
		return $this->writing;
	}

	/**
	 * @param mixed $gender
	 */
	public function setWriting($writing)
	{
		$this->writing = $writing;
	}

	/**
	 * @return mixed $dob
	 */
	public function getSpeaking()
	{
		return $this->speaking;
	}

	/**
	 * @param mixed $dob
	 */
	public function setSpeaking($speaking)
	{
		$this->speaking = $speaking;
	}

	/**
	 * @return mixed $course_id
	 */
	public function getListening()
	{
		return $this->listening;
	}

	/**
	 * @param mixed $course_id
	 */
	public function setListening($listening)
	{
		$this->listening = $listening;
	}

	/**
	 * @return mixed $religion
	 */
	public function getMemory()
	{
		return $this->memory;
	}

	/**
	 * @param mixed $religion
	 */
	public function setMemory($memory)
	{
		$this->memory = $memory;
	}
	/**
	 * @return mixed $religion
	 */
	public function getLastResult()
	{
		return $this->last_result;
	}

	/**
	 * @param mixed $religion
	 */
	public function setLastResult($last_result)
	{
		$this->last_result = $last_result;
	}

	/**
	 * @return mixed $register_user
	 */
	public function getRegisterUSer()
	{
		return $this->register_user;
	}

	/**
	 * @param mixed $register_user
	 */
	public function setRegisterUSer($register_user)
	{
		$this->register_user = $register_user;
	}

	/**
	 * @return mixed $register_date
	 */
	public function getRegisterDate()
	{
		return $this->register_Date;
	}

	/**
	 * @param mixed $register_date
	 */
	public function setRegisterDate($register_Date)
	{
		$this->register_Date = $register_Date;
	}				
															
	/**
	 * @return mixed $update_user
	 */
	public function getUpdateUser()
	{
		return $this->update_user;
	}

	/**
	 * @param mixed $update_user
	 */
	public function setUpdateUser($update_user)
	{
		$this->update_user = $update_user;
	}	

	/**
	 * @return mixed $update_date
	 */
	public function getUpdateDate()
	{
		return $this->update_date;
	}

	/**
	 * @param mixed $update_date
	 */
	public function setUpdateDate($update_date)
	{
		$this->update_date = $update_date;
	}

	/**
	 * @return mixed $del_flag
	 */
	public function getDelFlag()
	{
		return $this->del_flag;
	}

	/**
	 * @param mixed $del_flag
	 */
	public function setDelFlag($del_flag)
	{
		$this->del_flag = $del_flag;
	}

	/**
	 * @return mixed $att
	 */
	public function getAttendance()
	{
		return $this->att;
	}

	/**
	 * @param mixed $att
	 */
	public function setAttendance($att)
	{
		$this->att = $att;
	}
	/**
	 * @return mixed $homework
	 */
	public function getHomeWork()
	{
		return $this->homework;
	}

	/**
	 * @param mixed $homework
	 */
	public function setHomeWork($homework)
	{
		$this->homework = $homework;
	}

	/**
	 * @return mixed $classwork
	 */
	public function getClassWork()
	{
		return $this->classwork;
	}

	/**
	 * @param mixed $classwork
	 */
	public function setClassWork($classwork)
	{
		$this->classwork = $classwork;
	}

	/**
	 * @return mixed $q1
	 */
	public function getQuiz1()
	{
		return $this->q1;
	}

	/**
	 * @param mixed $q1
	 */
	public function setQuiz1($q1)
	{
		$this->q1 = $q1;
	}
	/**
	 * @return mixed $q2
	 */
	public function getQuiz2()
	{
		return $this->q2;
	}

	/**
	 * @param mixed $q2
	 */
	public function setQuiz2($q2)
	{
		$this->q2 = $q2;
	}
	/**
	 * @return mixed $q3
	 */
	public function getQuiz3()
	{
		return $this->q3;
	}

	/**
	 * @param mixed $q3
	 */
	public function setQuiz3($q3)
	{
		$this->q3 = $q3;
	}

	/**
	 * @return mixed $final
	 */
	public function getFinal()
	{
		return $this->final;
	}

	/**
	 * @param mixed $final
	 */
	public function setFinal($final)
	{
		$this->final = $final;
	}


}
?>