<?php
	
	class Exam {
		
		private $exam_id; //Declare column names
		private $exam_name;
		private $exam_month;
		private $exam_year;
		private $description;
		private $register_user;
		private $register_date;
		private $update_user;
		private $update_date;
		private $del_flag;

		public function getExam_id(){
			return $this->exam_id;
		}
		public function setExam_id($exam_id){
			 $this ->exam_id = $exam_id;
		}


		public function getExam_name(){
			return $this->exam_name;
		}
		public function setExam_name($exam_name){
			 $this ->exam_name = $exam_name;
		}


		public function getExam_month(){
			return $this->exam_month;
		}
		public function setExam_month($exam_month){
			 $this ->exam_month = $exam_month;
		}

        public function getExam_year(){
			return $this->exam_year;
		}
		public function setExam_year($exam_year){
			 $this ->exam_year = $exam_year;
		}
                
		public function getDescription(){
			return $this->description;
		}
		public function setDescription($description){
			 $this ->description = $description;
		}


		public function getRegister_user(){
			return $this->register_user;
		}
		public function setRegister_user($register_user){
			 $this ->register_user = $register_user;
		}


		public function getRegister_date(){
			return $this->register_date;
		}
		public function setRegister_date($register_date){
			 $this ->register_date = $register_date;
		}


		public function getUpdate_user(){
			return $this->update_user;
		}
		public function setUpdate_user($update_user){
			 $this ->update_user = $update_user;
		}


		public function getUpdate_date(){
			return $this->update_date;
		}
		public function setUpdate_date($update_date){
			 $this ->update_date = $update_date;
		}


		public function getDel_flag(){
			return $this->del_flag;
		}
		public function setDel_flag($del_flag){
			 $this ->del_flag = $del_flag;
                }
                
	}

?>