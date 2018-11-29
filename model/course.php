<?php
class Course{
	private $course_id;
	private $course_name;
	private $duration;
	private $register_user;
	private $register_date;
	private $update_user;
	private $update_date;
	private $del_flag;

	/**
	 * @return mixed $course_id
	 */
	public function getCourseID()
	{
		return $this->course_id;
	}

	/**
	 * @param mixed $course_id
	 */
	public function setCourseID($course_id)
	{
		$this->course_id = $course_id;
	}

	/**
	 * @return mixed $course_name
	 */
	public function getCourseName()
	{
		return $this->course_name;
	}

	/**
	 * @param mixed $course_name
	 */
	public function setCourseName($course_name)
	{
		$this->course_name = $course_name;
	}

	/**
	 * @return mixed $duration
	 */
	public function getDuration()
	{
		return $this->duration;
	}

	/**
	 * @param mixed $duration
	 */
	public function setDuration($duration)
	{
		$this->duration = $duration;
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