<?php
class Attendance{
	private $att_id;
	private $student_id;
	private $att_date;
	private $aprove_by;
	private $att_type;
	private $reason;
	private $register_user;
	private $register_date;
	private $update_user;
	private $update_date;
	private $del_flag;

	/**
	 * @return mixed $class_id
	 */
	public function getAttendanceID()
	{
		return $this->att_id;
	}

	/**
	 * @param mixed $class_id
	 */
	public function setID($att_id)
	{
		$this->att_id = $att_id;
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
	 * @return mixed $school_name_en
	 */
	public function getAttendanceDate()
	{
		return $this->att_date;
	}

	/**
	 * @param mixed $school_name_en
	 */
	public function setAttendanceDate($att_date)
	{
		$this->att_date = $att_date;
	}	

	/**
	 * @return mixed $phone_number
	 */
	public function getApproveBy()
	{
		return $this->approve_by;
	}

	/**
	 * @param mixed $phone_number
	 */
	public function setApproveBy($approve_by)
	{
		$this->approve_by = $approve_by;
	}
	/**
	 * @return mixed $email
	 */
	public function getAttendanceType()
	{
		return $this->att_type;
	}

	/**
	 * @param mixed $email
	 */
	public function setAttendanceType($att_type)
	{
		$this->att_type = $att_type;
	}
	/**
	 * @return mixed $email
	 */
	public function getReason()
	{
		return $this->reason;
	}

	/**
	 * @param mixed $email
	 */
	public function setReason($reason)
	{
		$this->reason = $reason;
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