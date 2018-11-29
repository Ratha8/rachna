<?php
class Setting{
	private $id;
	private $school_name_kh;
	private $school_name_en;
	private $phone_number;
	private $email;
        private $website;
        private $address;
	private $logo;
	private $register_user;
	private $register_date;
	private $update_user;
	private $update_date;

	/**
	 * @return mixed $class_id
	 */
	public function getID()
	{
		return $this->id;
	}

	/**
	 * @param mixed $class_id
	 */
	public function setID($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed $school_name_kh
	 */
	public function getSchoolNameKhmer()
	{
		return $this->school_name_kh;
	}

	/**
	 * @param mixed $school_name_kh
	 */
	public function setSchoolNameKhmer($school_name_kh)
	{
		$this->school_name_kh = $school_name_kh;
	}

	/**
	 * @return mixed $school_name_en
	 */
	public function getSchoolNameEnglish()
	{
		return $this->school_name_en;
	}

	/**
	 * @param mixed $school_name_en
	 */
	public function setSchoolNameEnglish($school_name_en)
	{
		$this->school_name_en = $school_name_en;
	}	

	/**
	 * @return mixed $phone_number
	 */
	public function getPhoneNumber()
	{
		return $this->phone_number;
	}

	/**
	 * @param mixed $phone_number
	 */
	public function setPhoneNumber($phone_number)
	{
		$this->phone_number = $phone_number;
	}

	/**
	 * @return mixed $email
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}
        
        /**
	 * @return mixed $website
	 */
	public function getWebsite()
	{
		return $this->website;
	}

	/**
	 * @param mixed $website
	 */
	public function setWebsite($website)
	{
		$this->website = $website;
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
	 * @return mixed $logo
	 */
	public function getLogo()
	{
		return $this->logo;
	}

	/**
	 * @param mixed $time_shift
	 */
	public function setLogo($logo)
	{
		$this->logo = $logo;
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
}
?>