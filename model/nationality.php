<?php
class Nationality {
	private $nationality_id;
	private $nationatlity_name;
	private $register_user;
	private $register_date;
	private $update_user;
	private $update_date;
	private $del_flag;

	/**
	 * @return mixed $nationality_id
	 */
	public function getNationalityID()
	{
		return $this->nationality_id;
	}

	/**
	 * @param mixed $nationality_id
	 */
	public function setNationalityID($nationality_id)
	{
		$this->nationality_id = $nationality_id;
	}

	/**
	 * @return mixed $nationality_name
	 */
	public function getNationalityName()
	{
		return $this->nationality_name;
	}

	/**
	 * @param mixed $nationality_name
	 */
	public function setNationalityName($nationality_name)
	{
		$this->nationality_name = $nationality_name;
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