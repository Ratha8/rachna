<?php
	
	class Exam_marks {
		
                private $mark_id;
                private $student_id;
                private $room_id; 
		private $exam_id; 
		private $absence_a;
		private $absence_p;
		private $home_work;
		private $class_work;
		private $quiz1;
		private $quiz2;
		private $quiz3;
		private $final_exam;
                private $total;
                private $register_user;
		private $register_date;
		private $update_user;
		private $update_date;
		private $del_flag;
                private $leave_flag;

                public function getRoom_id(){
			return $this->room_id;
		}
		public function setRoom_id($room_id){
			 $this ->room_id = $room_id;
		}
                
		public function getMark_id(){
			return $this->mark_id;
		}
		public function setMark_id($mark_id){
			 $this ->mark_id = $mark_id;
		}


		public function getStudent_id(){
			return $this->student_id;
		}
		public function setStudent_id($student_id){
			 $this ->student_id = $student_id;
		}

                public function getExam_id(){
			return $this->exam_id;
		}
		public function setExam_id($exam_id){
			 $this ->exam_id = $exam_id;
		}
        
		public function getAbsence_a(){
			return $this->absence_a;
		}
		public function setAbsence_a($absence_a){
			 $this ->absence_a = $absence_a;
		}

                public function getAbsence_p(){
			return $this->absence_p;
		}
		public function setAbsence_p($absence_p){
			 $this ->absence_p = $absence_p;
		}
                
		public function getHome_work(){
			return $this->home_work;
		}
		public function setHome_work($home_work){
			 $this ->home_work = $home_work;
		}


		public function getClass_work(){
			return $this->class_work;
		}
		public function setClass_work($class_work){
			 $this ->class_work = $class_work;
		}


		public function getQuiz1(){
			return $this->quiz1;
		}
		public function setQuiz1($quiz1){
			 $this ->quiz1 = $quiz1;
		}
        
        
                public function getQuiz2(){
			return $this->quiz2;
		}
		public function setQuiz2($quiz2){
			 $this ->quiz2 = $quiz2;
		}
        
        
                public function getQuiz3(){
			return $this->quiz3;
		}
		public function setQuiz3($quiz3){
			 $this ->quiz3 = $quiz3;
		}

                public function getFinal_exam(){
			return $this-> final_exam;
		}
		public function setFinal_exam($final_exam){
			 $this ->final_exam = $final_exam;
		}
        
        
                public function getTotal(){
			return $this->total;
		}
		public function setTotal($total){
			 $this ->total = $total;
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
                public function getLeave_flag(){
			return $this->leave_flag;
		}
		public function setLeave_flag($leave_flag){
			 $this ->leave_flag = $leave_flag;
                }
                
	}

?>