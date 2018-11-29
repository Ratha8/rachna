<?php
	
	class Rank {
		
		private $rank_id; //Declare column names
		private $rank_name;
//		private $start_month;
//		private $start_year;
//              private $end_month;
//		private $end_year;
                private $year;
		private $description;
		private $register_user;
		private $register_date;
		private $update_user;
		private $update_date;
		private $del_flag;

		public function getRank_id(){
			return $this->rank_id;
		}
		public function setRank_id($rank_id){
			 $this ->rank_id = $rank_id;
		}


		public function getRank_name(){
			return $this->rank_name;
		}
		public function setRank_name($rank_name){
			 $this ->rank_name = $rank_name;
		}


//		public function getStart_month(){
//			return $this->start_month;
//		}
//		public function setStart_month($start_month){
//			 $this ->start_month = $start_month;
//		}
//
//                public function getStart_year(){
//			return $this->start_year;
//		}
//		public function setStart_year($start_year){
//			 $this ->start_year = $start_year;
//		}
//                
//                public function getEnd_month(){
//			return $this->end_month;
//		}
//		public function setEnd_month($end_month){
//			 $this ->end_month = $end_month;
//		}
//
//                public function getEnd_year(){
//			return $this->end_year;
//		}
//		public function setEnd_year($end_year){
//			 $this ->end_year = $end_year;
//		}
                
                public function getYear(){
			return $this->year;
		}
		public function setYear($year){
			 $this ->year = $year;
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