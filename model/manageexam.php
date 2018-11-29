<?php
include 'exam.php';

function insertExam($exam){
    $conn = getConnection();
    $sql = "INSERT INTO T_Exam(
                exam_name,
                exam_month,
                exam_year,
                description,
                register_date,
                update_date,
                register_user,
                update_user)
            VALUES(
                :exam_name,
                :exam_month,
                :exam_year,
                :description,
                CURDATE(),
                CURDATE(),
                :user,
                :user
                )";

    $user_id = $exam->getRegister_user();
    $exam_name = $exam->getExam_name();
    $exam_month = $exam->getExam_month();
    $exam_year = $exam->getExam_year();
    $description= $exam->getDescription();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':exam_name', $exam_name);
    $stmt->bindParam(':exam_month', $exam_month);
    $stmt->bindParam(':exam_year', $exam_year);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':user', $user_id);
    $stmt->execute();
    $lastid = $conn->lastInsertId();
    return $lastid;
}

function getAllExams(){
    $sql = "SELECT 
                exam_id,
                exam_name,
                exam_month,
                exam_year,
                description,
                register_user,
                update_user,
                update_date,
                del_flag
            FROM T_Exam
            WHERE del_flag = 0 ORDER BY exam_id DESC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}
function getOneExam12($id){
    $sql = "SELECT 
                exam_id,
                exam_name,
                exam_month,
                exam_year,
                description,
                register_user,
                update_user,
                update_date,
                del_flag
            FROM T_Exam
            WHERE del_flag = 0 AND exam_id = :id";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();  
    $result = $stmt->fetch();

    return $result;
}

function getLastExam(){
    $sql = "SELECT exam_id,
                exam_name,
                exam_month,
                exam_year,
                description,
                register_user,
                update_user,
                update_date,
                del_flag
            FROM T_Exam
            WHERE exam_id = (SELECT MAX(exam_id) FROM T_Exam WHERE del_flag = 0) ORDER BY exam_id DESC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}

function getExamClass($id){
    $sql = "SELECT exam_id,
                exam_name,
                exam_month,
                exam_year,
                description,
                register_user,
                update_user,
                update_date,
                del_flag
                FROM T_Exam
                WHERE del_flag = 0 AND exam_id =:id ORDER BY exam_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}



function deleteExam($user_id, $exam_id){
	$sql = "UPDATE T_Exam 
		    SET 
                        del_flag = 1,
                        update_user = :user,
                        update_date = CURDATE()
                    WHERE 
                       exam_id = :exam_id";
        
	    $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(':exam_id',$exam_id);
	    $stmt->bindParam(':user',$user_id);
	    $stmt->execute();
    }
    




	function updateExam($exam){
        $conn = getConnection();
        
		$sql = "UPDATE T_Exam 
				SET 
			    exam_name = :exam_name,
                exam_month = :exam_month,
                exam_year = :exam_year,
                description = :description,              
                update_user = :user 
                WHERE exam_id = :exam_id";
        
        $exam_id = $exam->getExam_id();
        $exam_name =$exam->getExam_name();
        $exam_month =$exam->getExam_month();
        $exam_year =$exam->getExam_year();
        $description =$exam->getDescription();
        $update_user = $exam->getUpdate_user();
       
        
		$stmt = getConnection()->prepare($sql);
	    $stmt->bindParam(':exam_id',$exam_id);
        $stmt->bindParam(':exam_name',$exam_name);
        $stmt->bindParam(':exam_month',$exam_month);
        $stmt->bindParam(':exam_year',$exam_year);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':user',$update_user);
	    $stmt->execute();
	}


function getOneExam($id){
    $sql = "SELECT 
                exam_id,
                exam_name,
                exam_month,
                exam_year,
                description,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Exam
            WHERE del_flag = 0 AND exam_id = :id";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();  
    $result = $stmt->fetch();

    $exam = null;

    if (!empty($result)){
        $exam = new exam;
        $exam->setExam_id($result['exam_id']);
        $exam->setExam_name($result['exam_name']);
        $exam->setExam_month($result['exam_month']);
        $exam->setExam_year($result['exam_year']);
        $exam->setDescription($result['description']);
        $exam->setRegister_user($result['register_user']);
        $exam->setUpdate_user($result['update_user']);
        $exam->setRegister_date($result['register_date']);
        $exam->setRegister_user($result['register_user']);
    }

    return $exam;
}
function getExamID($month, $year) {
    $sql = "SELECT 
                exam_id,
                exam_name,
                exam_month,
                exam_year,
                description,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Exam
            WHERE del_flag = 0 AND exam_month = :month AND exam_year = :year";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':month', $month);
    $stmt->bindParam(':year', $year);
    $stmt->execute();
    $result = $stmt->fetch();

    $exam = null;

    if (!empty($result)) {
        $exam = new exam;
        $exam->setExam_id($result['exam_id']);
        $exam->setExam_name($result['exam_name']);
        $exam->setExam_month($result['exam_month']);
        $exam->setExam_year($result['exam_year']);
        $exam->setDescription($result['description']);
        $exam->setRegister_user($result['register_user']);
        $exam->setUpdate_user($result['update_user']);
        $exam->setRegister_date($result['register_date']);
        $exam->setRegister_user($result['register_user']);
    }

    return $exam;
}
function getExamIDbyleavedate($month, $year) {
    $sql = "SELECT 
                exam_id,
                exam_name,
                exam_month,
                exam_year,
                description,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Exam
            WHERE del_flag = 0 AND exam_month >= :month AND exam_year >= :year";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':month', $month);
    $stmt->bindParam(':year', $year);
    $stmt->execute();
    $result = $stmt->fetch();

    $exam = null;

    if (!empty($result)) {
        $exam = new exam;
        $exam->setExam_id($result['exam_id']);
        $exam->setExam_name($result['exam_name']);
        $exam->setExam_month($result['exam_month']);
        $exam->setExam_year($result['exam_year']);
        $exam->setDescription($result['description']);
        $exam->setRegister_user($result['register_user']);
        $exam->setUpdate_user($result['update_user']);
        $exam->setRegister_date($result['register_date']);
        $exam->setRegister_user($result['register_user']);
    }

    return $exam;
}
function getTrimExamID($fmonth, $lmonth, $year) {
    $sql = "SELECT 
                exam_id,
                exam_name,
                exam_month,
                exam_year,
                description,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Exam
            WHERE del_flag = 0 AND exam_month >= :fmonth AND exam_month <= :lmonth AND exam_year = :year";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fmonth', $fmonth);
    $stmt->bindParam(':lmonth', $lmonth);
    $stmt->bindParam(':year', $year);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
}


function deleteStudentExam($user_id, $exam_id){
    $conn = getConnection();
    $sql = "UPDATE 
                T_Exam
            SET 
                update_user = :user_id,
                update_date = CURRENT_TIMESTAMP,
                del_flag = 1
            WHERE
                exam_id = :exam_id";
    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':exam_id',$exam_id);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->execute();
    
    
}
?>