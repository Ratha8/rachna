<?php
class Student{
	private $student_id;
	private $student_name;
	private $student_no;
	private $latin_name;
	private $class_id;
	private $duration;
	private $gender;
	private $dob;
	private $birth_place;
	private $religion;
	private $nationality;
	private $address;
	private $enroll_date;
	private $switch_time;
	private $fee;
	private $paid;
	private $leave_flag;
	private $expire_paymentdate;
	private $payment_date;
	private $paid_date;
	private $leave_date;
	private $register_user;
	private $register_Date;
	private $update_user;
	private $update_date;
	private $del_flag;
        private $photo;
        private $start_new;
        private $expire_new;

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
	 * @return mixed $student_name
	 */
	public function getStudentName()
	{
		return $this->student_name;
	}

	/**
	 * @param mixed $student_name
	 */
	public function setStudentName($student_name)
	{
		$this->student_name = $student_name;
	}

	/**
	 * @return mixed $student_no
	 */
	public function getStudentNo()
	{
		return $this->student_no;
	}

	/**
	 * @param mixed $student_no
	 */
	public function setStudentNo($student_no)
	{
		$this->student_no = $student_no;
	}	

	/**
	 * @return mixed $latin_name
	 */
	public function getLatinName()
	{
		return $this->latin_name;
	}

	/**
	 * @param mixed $latin_name
	 */
	public function setLatinName($latin_name)
	{
		$this->latin_name = $latin_name;
	}	

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
	 * @return mixed $gender
	 */
	public function getGender()
	{
		return $this->gender;
	}

	/**
	 * @param mixed $gender
	 */
	public function setGender($gender)
	{
		$this->gender = $gender;
	}

	/**
	 * @return mixed $dob
	 */
	public function getDob()
	{
		return $this->dob;
	}

	/**
	 * @param mixed $dob
	 */
	public function setDob($dob)
	{
		$this->dob = $dob;
	}

	/**
	 * @return mixed $course_id
	 */
	public function getBirthPlace()
	{
		return $this->birth_place;
	}

	/**
	 * @param mixed $course_id
	 */
	public function setBirthPlace($birth_place)
	{
		$this->birth_place = $birth_place;
	}

	/**
	 * @return mixed $religion
	 */
	public function getReligion()
	{
		return $this->religion;
	}

	/**
	 * @param mixed $religion
	 */
	public function setReligion($religion)
	{
		$this->religion = $religion;
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
	 * @return mixed $enroll_date
	 */
	public function getEnrollDate()
	{
		return $this->enroll_date;
	}

	/**
	 * @param mixed $enroll_date
	 */
	public function setEnrollDate($enroll_date)
	{
		$this->enroll_date = $enroll_date;
	}

	/**
	 * @return mixed $switch_time
	 */
	public function getSwitchTime()
	{
		return $this->switch_time;
	}

	/**
	 * @param mixed $switch_time
	 */
	public function setSwitchTime($switch_time)
	{
		$this->switch_time = $switch_time;
	}

	/**
	 * @return mixed $fee
	 */
	public function getFee()
	{
		return $this->fee;
	}

	/**
	 * @param mixed $fee
	 */
	public function setFee($fee)
	{
		$this->fee = $fee;
	}

	/**
	 * @return mixed $paid
	 */
	public function getPaid()
	{
		return $this->paid;
	}

	/**
	 * @param mixed $paid
	 */
	public function setPaid($paid)
	{
		$this->paid = $paid;
	}

	/**
	 * @return mixed $leave_flag
	 */
	public function getLeaveFlag()
	{
		return $this->leave_flag;
	}

	/**
	 * @param mixed $leave_flag
	 */
	public function setLeaveFlag($leave_flag)
	{
		$this->leave_flag = $leave_flag;
	}

	/**
	 * @return mixed $expire_paymentdate
	 */
	public function getExpirePaymentDate()
	{
		return $this->expire_paymentdate;
	}

	/**
	 * @param mixed $expire_paymentdate
	 */
	public function setExpirePaymentDate($expire_paymentdate)
	{
		$this->expire_paymentdate = $expire_paymentdate;
	}

	/**
	 * @return mixed $payment_date
	 */
	public function getPaymentDate()
	{
		return $this->payment_date;
	}

	/**
	 * @param mixed $payment_date
	 */
	public function setPaymentDate($payment_date)
	{
		$this->payment_date = $payment_date;
	}	

	/**
	 * @return mixed $paid_date
	 */
	public function getPaidDate()
	{
		return $this->paid_date;
	}

	/**
	 * @param mixed $paid_date
	 */
	public function setPaidDate($paid_date)
	{
		$this->paid_date = $paid_date;
	}

	/**
	 * @return mixed $leave_date
	 */
	public function getLeaveDate()
	{
		return $this->leave_date;
	}

	/**
	 * @param mixed $leave_date
	 */
	public function setLeaveDate($leave_date)
	{
		$this->leave_date = $leave_date;
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
	 * @return mixed $photo
	 */
	public function getPhoto()
	{
		return $this->photo;
	}

	/**
	 * @param mixed $photo
	 */
	public function setPhoto($photo)
	{
		$this->photo = $photo;
	}
        
        /**
	 * @return mixed $stat_new
	 */
	public function getStart_new()
	{
		return $this->start_new;
	}

	/**
	 * @param mixed $start_new
	 */
	public function setStart_new($start_new)
	{
		$this->start_new = $start_new;
	}
        
          /**
	 * @return mixed $expire_new
	 */
	public function getExpire_new()
	{
		return $this->expire_new;
	}

	/**
	 * @param mixed $expire_new
	 */
	public function setExpire_new($expire_new)
	{
		$this->expire_new = $expire_new;
	}
}
?>