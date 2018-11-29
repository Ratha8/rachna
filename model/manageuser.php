<?php

//session_destroy("user");

	include 'connection.php';
	if (isset($_POST['action'])) {
		switch ($_POST['action']) {
		    case 'change_password':
		       	$current_password = $_POST['current_password'];
				$new_password = $_POST['new_password'];
				$confirm_password = $_POST['confirm_password'];
				$user_id = $_POST['user_id'];
				$user = getUserByUserID($user_id);
				$cur_pass_err = '';
				$new_pass_err = '';
				$con_pass_err = '';
				$str_err = 0;
				$message = '';
		        if(empty($current_password)) {
		        	$str_err ++;
		        	$cur_pass_err = 'Current password is reqired.';
		        } elseif(strlen($current_password) > 100) {
		        	$str_err ++;
		        	$cur_pass_err = 'Current password must be within 100 characters.';
		        } elseif(crypt($current_password, $user->getPassword()) != $user->getPassword()) {	
		        	$str_err ++;
		        	$cur_pass_err = 'Current password does not match.';		        		
		        }
		        if(empty($new_password)) {
		        	$str_err ++;
		        	$new_pass_err = 'New password is reqired.';
		        } elseif(strlen($new_password) > 100) {
		        	$str_err ++;
		        	$new_pass_err = 'New password must be within 100 characters.';
		        } elseif ($current_password == $new_password) {
		        	$str_err ++;
		        	$new_pass_err = 'Current password and new password cannot be the same.';
		        }
		        if(empty($confirm_password)) {
		        	$str_err ++;
		        	$con_pass_err = 'Confirm password is reqired.';
		        } elseif(strlen($confirm_password) > 100) {
		        	$str_err ++;
		        	$con_pass_err = 'Confirm password must be within 100 characters.';
		        } elseif ($new_password != $confirm_password) {
		        	$str_err ++;
		        	$con_pass_err = 'Confirm password does not match.';		        		
		        }	  
		        if($str_err == 0) {

		            $message = changePassword($user_id, password_hash($new_password, PASSWORD_BCRYPT));

		        }
				header("content-type:application/json");
				$message_result = array
					(
					    'cur_pass_err' => $cur_pass_err,

					    'new_pass_err' => $new_pass_err,

					    'con_pass_err' => $con_pass_err,

					    'message' => $message,

					);
				echo json_encode($message_result);	
		        break;
		    case 'validate_user':
		    	$username = $_POST['username'];
		    	$action = $_POST['action'];
		    	if(getUserByUsername($username) != null) {
					$message_result = array
						(
							'valid' => 'true',
						    'available' => 'false',
						    'message' => 'This username is already taken.'
						);		    		
		    	} else {
					$message_result = array
						(
							'valid' => 'true',
						    'available' => 'true',
						    'message' => 'This username is available and safe to use.'
						);	
		    	}
		    	echo json_encode($message_result);
		    	break;    
		}	    
	}	
	function checkUserExistFrm($username, $password){
		$strErr = "";
        if(empty($username) && empty($password)){
        	$strErr = "Please input username and password.";
        }elseif(empty($username)){
        	$strErr = "Please input username.";
        }elseif(empty($password)){
        	$strErr = "Please input password.";
        }else{
        	$user = getUserByUsername($username);
        	if($user == null) {
        		$strErr = "This user does not exist.";
        	} else {
        		if(crypt($password, $user->getPassword()) !== $user->getPassword()){
	        		$strErr = "The username and password does not match.";
	        	}else{

	        	session_start();
	        		$_SESSION["user"] = serialize($user);
	        	}
        	}
        }
    	return $strErr;
	}
	class User{
		private $user_id;
		private $username;
		private $password;
		private $role;
		private $register_user;
		private $register_date;
		private $update_user;
		private $update_date;
		private $del_flag;
		public function getUserID(){
			return $this->user_id;
		}
		public function getUsername(){
			return $this->username;
		}
		public function getPassword(){
			return $this->password;
		}
		public function getRole(){
			return $this->role;
		}
		public function getRegisterUser(){
			return $this->register_user;
		}		
		public function getRegisterDate(){
			return $this->register_date;
		}
		public function getUpdateUser(){
			return $this->update_user;
		}		
		public function getUpdateDate(){
			return $this->update_date;
		}
		public function getDelFlag(){
			return $this->del_flag;
		}		
		public function setUserID($user_id){
			$this->user_id=$user_id;
		}
		public function setUsername($username){
			$this->username = $username;
		}
		public function setPassword($password){
			$this->password = $password;
		}
		public function setRole($role){
			$this->role = $role;
		}
		public function setRegisterUser($register_user){
			$this->register_user = $register_user;
		}		
		public function setRegisterDate($register_date){
			$this->register_date = $register_date;
		}
		public function setUpdateUser($update_user){
			$this->update_user = $update_user;
		}
		public function setUpdateDate($update_date){
			$this->update_date = $update_date;
		}		
		public function setDelFlag($del_flag){
			$this->del_flag;
		}
	}
   function getAllUsers(){

   		$sql = "SELECT 
             user_id,
                
		username,
		password,
		role,
		register_user,
		register_date,
		update_user,
		update_date 
		FROM T_Users
		WHERE del_flag = 0";
		$stmt = getConnection()->prepare($sql);
		$stmt->execute();
		$result=$stmt->fetchAll();
		return $result;       
   }
   function getAllTeachers(){
   	$sql = "SELECT 
   		user_id,
		username,
		password,
		role,
		register_user,
		register_date,
		update_user,
		update_date 
		FROM T_Users
		WHERE del_flag = 0 AND role = 'Teacher'" ;
		$stmt = getConnection()->prepare($sql);
		$stmt->execute();
		$result=$stmt->fetchAll();
		return $result;
   }
   function getAllReceipt(){
   	$sql = "SELECT 
   		user_id,
		username,
		password,
		role,
		register_user,
		register_date,
		update_user,
		update_date 
		FROM T_Users
		WHERE del_flag = 0 AND role = 'Receptionist'" ;
		$stmt = getConnection()->prepare($sql);
		$stmt->execute();
		$result=$stmt->fetchAll();
		return $result;
   }

   function getUserByUsername($param){
		$sql = "SELECT 	user_id,
			username,
			password,
			role,
			register_user,
			register_date,
			update_user,
			update_date,
			del_flag FROM T_Users
                        WHERE username = :username AND del_flag = 0";
		$stmt = getConnection()->prepare($sql);
		$stmt->bindParam(':username',$param);
		$stmt->execute();	
		$result=$stmt->fetch();
		$user = null;
		if(!(empty($result))) {
			$user = new User;
			$user->setUserID($result['user_id']);
			$user->setUsername($result['username']);
			$user->setPassword($result['password']);
			$user->setRole($result['role']);
			$user->setRegisterDate($result['register_date']);
			$user->setRegisterUser($result['register_user']);
			$user->setUpdateUser($result['update_user']);
			$user->setUpdateDate($result['update_date']);			
		}
		return $user;
	}
   function getUserByUserID($id){
		$sql = "SELECT 	user_id,
			username,
                        password,
			role,
			register_user,
			register_date,
			update_user,
			update_date,
			del_flag FROM T_Users
			WHERE user_id = :user_id AND del_flag = 0";
		$stmt = getConnection()->prepare($sql);
		$stmt->bindParam(':user_id',$id);
		$stmt->execute();	
		$result=$stmt->fetch();
		$user = null;
		if(!(empty($result))) {
			$user = new User;
			$user->setUserID($result['user_id']);
			$user->setUsername($result['username']);
			$user->setPassword($result['password']);
			$user->setRole($result['role']);
			$user->setRegisterDate($result['register_date']);
			$user->setRegisterUser($result['register_user']);
			$user->setUpdateUser($result['update_user']);
			$user->setUpdateDate($result['update_date']);			
		}
		return $user;
	}

   	function insertUser($user){

		$sql = "INSERT INTO T_Users(
			username,
			password,
			role,
			register_user,
			register_date,
			update_user,
			update_date)
 			VALUES(
 			:username,
 			:password,
 			:role,
 			:user_id,
 			CURRENT_TIMESTAMP,
 			:user_id,
 			CURRENT_TIMESTAMP)";
		$stmt = getConnection()->prepare($sql);
		$stmt->bindParam(':username',$user->getUsername());
		$stmt->bindParam(':password',$user->getPassword());
		$stmt->bindParam(':role',$user->getRole());
		$stmt->bindParam(':user_id',$user->getRegisterUser());				
   		$stmt->execute();	
	}

	function updateUser($user){

		$sql = "UPDATE T_Users 
			SET 
			username = :username,
			role = :role,
			password = :password,
			update_user = :update_user,
			update_date = CURRENT_TIMESTAMP 
			WHERE user_id = :user_id";
		$stmt = getConnection()->prepare($sql);
	    $stmt->bindParam(':user_id',$user->getUserID());
	    $stmt->bindParam(':username',$user->getUsername());
	    $stmt->bindParam(':role',$user->getRole());
	    $stmt->bindParam(':password',$user->getPassword());
	    $stmt->bindParam(':update_user',$user->getUpdateUser());
	    $stmt->execute();
	}

	function deleteUser($user_id, $update_user){

		$sql = "UPDATE T_Users 
			SET 
			del_flag = 1,
			update_user = :update_user,
			update_date = CURRENT_TIMESTAMP 
                        WHERE user_id = :user_id";
		$stmt = getConnection()->prepare($sql);
	    $stmt->bindParam(':user_id',$user_id);
	    $stmt->bindParam(':update_user',$update_user);
	    $stmt->execute();
	}

function changePassword($user_id, $password){
		$sql = "UPDATE T_Users 
                    SET 
                    password = :password,
                    update_date = CURRENT_TIMESTAMP
                    WHERE user_id = :user_id";
		$stmt = getConnection()->prepare($sql);
		$stmt->bindParam(':password',$password);
		$stmt->bindParam(':user_id',$user_id);
	    if($stmt->execute()) {
	    	return 'Password successfully changed!';
	    } else {
	    	return 'Error Occur! Failed to change the password.';
	    }
	}

?>