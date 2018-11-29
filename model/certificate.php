<?php
class Certificate{
	private $cert_id;
	private $student_id;
	private $cert_type;
	private $level;
	private $level_id;
	private $score;
	private $grade;
	private $date;
	private $issue_date;
	private $no;
	private $detail;
	private $type_month;
	private $month;
	private $year;
	private $register_user;
	private $register_date;
	private $update_user;
	private $update_date;
	private $del_flag;

	/**
	 * @return mixed $class_id
	 */
	public function getCertificateID()
	{
		return $this->cert_id;
	}

	/**
	 * @param mixed $class_id
	 */
	public function setCertificateID($cert_id)
	{
		$this->cert_id = $cert_id;
	}

	/**
	 * @return mixed $school_name_kh
	 */
	public function getStudentID()
	{
		return $this->student_id;
	}

	/**
	 * @param mixed $school_name_kh
	 */
	public function setStudentID($student_id)
	{
		$this->student_id = $student_id;
	}

	/**
	 * @return mixed $school_name_kh
	 */
	public function getCertificateType()
	{
		return $this->cert_type;
	}

	/**
	 * @param mixed $school_name_kh
	 */
	public function setCertificateType($cert_type)
	{
		$this->cert_type = $cert_type;
	}

	/**
	 * @return mixed $school_name_kh
	 */
	public function getLevel()
	{
		return $this->level;
	}

	/**
	 * @param mixed $school_name_kh
	 */
	public function setLevel($level)
	{
		$this->level = $level;
	}

	/**
	 * @return mixed $school_name_kh
	 */
	public function getLevelID()
	{
		return $this->level_id;
	}

	/**
	 * @param mixed $school_name_kh
	 */
	public function setLevelID($level_id)
	{
		$this->level_id = $level_id;
	}

	/**
	 * @return mixed $school_name_kh
	 */
	public function getScore()
	{
		return $this->score;
	}

	/**
	 * @param mixed $school_name_kh
	 */
	public function setScore($score)
	{
		$this->score = $score;
	}

	/**
	 * @return mixed $school_name_kh
	 */
	public function getGrade()
	{
		return $this->grade;
	}

	/**
	 * @param mixed $school_name_kh
	 */
	public function setGrade($grade)
	{
		$this->grade = $grade;
	}

	/**
	 * @return mixed $school_name_en
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param mixed $school_name_en
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}	

	/**
	 * @return mixed $school_name_en
	 */
	public function getIssueDate()
	{
		return $this->issue_date;
	}

	/**
	 * @param mixed $school_name_en
	 */
	public function setIssueDate($issue_date)
	{
		$this->issue_date = $issue_date;
	}	

	/**
	 * @return mixed $phone_number
	 */
	public function getNo()
	{
		return $this->no;
	}

	/**
	 * @param mixed $phone_number
	 */
	public function setNo($no)
	{
		$this->no = $no;
	}
	/**
	 * @return mixed $email
	 */
	public function getDetail()
	{
		return $this->detail;
	}

	/**
	 * @param mixed $email
	 */
	public function setDetail($detail)
	{
		$this->detail = $detail;
	}

	/**
	 * @return mixed $email
	 */
	public function getTypeMonth()
	{
		return $this->type_month;
	}

	/**
	 * @param mixed $email
	 */
	public function setTypeMonth($type_month)
	{
		$this->type_month = $type_month;
	}

	/**
	 * @return mixed $email
	 */
	public function getMonth()
	{
		return $this->month;
	}

	/**
	 * @param mixed $email
	 */
	public function setMonth($month)
	{
		$this->month = $month;
	}

	/**
	 * @return mixed $email
	 */
	public function getYear()
	{
		return $this->year;
	}

	/**
	 * @param mixed $email
	 */
	public function setYear($year)
	{
		$this->year = $year;
	}
	/**
	 * @return mixed $register_user
	 */
	public function getRegisterUser()
	{
		return $this->register_user;
	}

	/**
	 * @param mixed $register_user
	 */
	public function setRegisterUser($register_user)
	{
		$this->register_user = $register_user;
	}

	/**
	 * @return mixed $register_date
	 */
	public function getRegisterDate()
	{
		return $this->register_date;
	}

	/**
	 * @param mixed $register_date
	 */
	public function setRegisterDate($register_date)
	{
		$this->register_date = $register_date;
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
}
?>