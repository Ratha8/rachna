<?php

class Invoice {
	private $invoice_id;
	private $invoice_number;
	private $student_id;
	private $class_name;
	private $receptionist;
	private $duration;
	private $level;
	private $time_shift;
	private $start_time;
	private $end_time;
	private $fee;
	private $invoice_date;
	private $enroll_date;
	private $expire_paymentdate;
	private $register_user;
	private $register_Date;
	private $update_user;
	private $update_date;
	private $del_flag;
    private $start_new;
    private $expire_new;

	/**

	 * @return mixed $invoice_id

	 */

	public function getInvoiceID()

	{

		return $this->invoice_id;

	}



	/**

	 * @param mixed $invoice_id

	 */

	public function setInvoiceID($invoice_id)

	{

		$this->invoice_id = $invoice_id;

	}


	/**

	 * @return mixed $invoice_number

	 */

	public function getInvoiceNumber()

	{

		return $this->invoice_number;

	}



	/**

	 * @param mixed $invoice_number

	 */

	public function setInvoiceNumber($invoice_number)

	{

		$this->invoice_number = $invoice_number;

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

	 * @return mixed $receptionist

	 */

	public function getReceptionist()

	{

		return $this->receptionist;

	}



	/**

	 * @param mixed $receptionist

	 */

	public function setReceptionist($receptionist)

	{

		$this->receptionist = $receptionist;

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

	 * @return mixed $level

	 */

	public function getLevel()

	{

		return $this->level;

	}



	/**

	 * @param mixed $level

	 */

	public function setLevel($level)

	{

		$this->level = $level;

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

	 * @return mixed $invoice_date

	 */

	public function getInvoiceDate()

	{

		return $this->invoice_date;

	}



	/**

	 * @param mixed $invoice_date

	 */

	public function setInvoiceDate($invoice_date)

	{

		$this->invoice_date = $invoice_date;

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

        public function getStart_new()

        {

            return $this->start_new;

        }

        /**

	 * @param mixed $start

	 */

        public function setStart_new($start_new)

        {

            $this->start_new = $start_new;

        }

        /**

	 * @return mixed $expire

	 */

        public function getExpire_new()

        {

            return $this->expire_new;

        }

        /**

	 * @param mixed $expire

	 */

        public function setExpire_new($expire_new)

        {

            $this->expire_new = $expire_new;

        }

}

?>



