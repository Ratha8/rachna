<?php
class Parents {
	private $parent_id;
	private $student_id;
	private $parent_name;
	private $relationship;
	private $contact_number;
	private $age;
	private $position;
	private $nationality;
	private $address;
	private $register_user;
	private $register_date;
	private $update_user;
	private $update_date;
	private $del_flag;

	/**
	 * @return mixed $parnet_id
	 */
	public function getParentID()
	{
		return $this->parent_id;
	}

	/**
	 * @param mixed $parent_id
	 */
	public function setParentID($parent_id)
	{
		$this->parent_id = $parent_id;
	}

	/**
	 * @return mixed $student_id
	 */
	public function getStudentID()
	{
		return $this->student_id;
	}

	/**
	 * @param mixed $student_id
	 */
	public function setStudentID($student_id)
	{
		$this->student_id = $student_id;
	}

	/**
	 * @return mixed $parent_name
	 */
	public function getParentName()
	{
		return $this->parent_name;
	}

	/**
	 * @param mixed $parent_name
	 */
	public function setParentName($parent_name)
	{
		$this->parent_name = $parent_name;
	}

	/**
	 * @return mixed $relationship
	 */
	public function getRelationship()
	{
		return $this->relationship;
	}

	/**
	 * @param mixed $relationship
	 */
	public function setRelationship($relationship)
	{
		$this->relationship = $relationship;
	}

	/**
	 * @return mixed $contact_number
	 */
	public function getContactNumber()
	{
		return $this->contact_number;
	}

	/**
	 * @param mixed $contact_number
	 */
	public function setContactNumber($contact_number)
	{
		$this->contact_number = $contact_number;
	}

	/**
	 * @return mixed $position
	 */
	public function getPosition()
	{
		return $this->position;
	}

	/**
	 * @param mixed $position
	 */
	public function setPosition($position)
	{
		$this->position = $position;
	}			

	/**
	 * @return mixed $nationality
	 */
	public function getNationality()
	{
		return $this->nationality;
	}

	/**
	 * @param mixed $nationality
	 */
	public function setNationality($nationality)
	{
		$this->nationality = $nationality;
	}		

	/**
	 * @return mixed $address
	 */
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * @param mixed $address
	 */
	public function setAddress($address)
	{
		$this->address = $address;
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