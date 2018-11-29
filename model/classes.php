<?php

class Classes{

	private $class_id;
	private $class_name;
	private $teacher_name;
    private $teacher_id;
    private $level_id;
	private $start_time;
	private $end_time;
	private $time_shift;
	private $register_user;
	private $register_date;
	private $update_user;
	private $update_date;
	private $del_flag;
	/**

	 * @return mixed $class_id

	 */
	public function getClassID()
	{
		return $this->class_id;
	}
	/**

	 * @param mixed $class_id

	 */

	public function setClassID($class_id)
	{
		$this->class_id = $class_id;
	}
	/**

	 * @return mixed $class_name

	 */
	public function getClassName()
	{
		return $this->class_name;
	}
	/**

	 * @param mixed $class_name

	 */

	public function setClassName($class_name)

	{

		$this->class_name = $class_name;

	}



	/**

	 * @return mixed $teacher_name

	 */

	public function getTeacherName()

	{

		return $this->teacher_name;

	}



	/**

	 * @param mixed $teacher_name

	 */

	public function setTeacherName($teacher_name)

	{

		$this->teacher_name = $teacher_name;

	}	

        

        /**

	 * @return mixed $teacher_id

	 */

	public function getTeacher_id()

	{

		return $this->teacher_id;

	}



	/**

	 * @param mixed $teacher_id

	 */

	public function setTeacher_id($teacher_id)

	{

		$this->teacher_id = $teacher_id;

	}	



	/**

	 * @return mixed $level_id

	 */

	public function getLevelID()

	{

		return $this->level_id;

	}



	/**

	 * @param mixed $level_id

	 */

	public function setLevelID($level_id)

	{

		$this->level_id = $level_id;

	}



	/**

	 * @return mixed $start_time

	 */

	public function getStartTime()

	{

		return $this->start_time;

	}



	/**

	 * @param mixed $start_time

	 */

	public function setStartTime($start_time)

	{

		$this->start_time = $start_time;

	}		



	/**

	 * @return mixed $end_time

	 */

	public function getEndTime()

	{

		return $this->end_time;

	}



	/**

	 * @param mixed $end_time

	 */

	public function setEndTime($end_time)

	{

		$this->end_time = $end_time;

	}	



	/**

	 * @return mixed $time_shift

	 */

	public function getTimeShift()

	{

		return $this->time_shift;

	}



	/**

	 * @param mixed $time_shift

	 */

	public function setTimeShift($time_shift)

	{

		$this->time_shift = $time_shift;

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