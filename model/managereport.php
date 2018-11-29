<?php
include 'report.php';

function insertReport($report){
    $conn = getConnection();
    $sql = "INSERT INTO t_report(
                student_id,
                mark_id,
                attentiveness,
                discipline,
                reading,
                writing,
                speaking,
                listening,
                result_last,
                att,
                homework,
                classwork,
                q1,
                q2,
                q3,
                final,
                memory,
                register_date,
                update_date,
                register_user,
                update_user)
            VALUES(
                :student_id,
                :mark_id,
                :attentiveness,
                :discipline,
                :reading,
                :writing,
                :speaking,
                :listening,
                :result_last,
                :att,
                :home_work,
                :class_work,
                :q1,
                :q2,
                :q3,
                :final,
                :memory,
                CURDATE(),
                CURDATE(),
                :user,
                :user
                )";
    $student_id = $report->getStudentID();
    $mark_id = $report->getMarkID();
    $attentiveness = $report->getAttentiveness();
    $discipline = $report->getDiscipline();
    $reading= $report->getReading();
    $writing= $report->getWriting();
    $speaking= $report->getSpeaking();
    $listening= $report->getListening();
    $att= $report->getAttendance();
    $homework= $report->getHomeWork();
    $classwork= $report->getClassWork();
    $q1= $report->getQuiz1();
    $q2= $report->getQuiz2();
    $q3= $report->getQuiz3();
    $final= $report->getFinal();
    $memory= $report->getMemory();
    $user_id = $report->getRegisterUSer();
    $result_last = $report->getLastResult();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':mark_id', $mark_id);
    $stmt->bindParam(':attentiveness', $attentiveness);
    $stmt->bindParam(':discipline', $discipline);
    $stmt->bindParam(':reading', $reading);
    $stmt->bindParam(':writing', $writing);
    $stmt->bindParam(':speaking', $speaking);
    $stmt->bindParam(':listening', $listening);
    $stmt->bindParam(':result_last', $result_last);
    $stmt->bindParam(':att', $att);
    $stmt->bindParam(':home_work', $homework);
    $stmt->bindParam(':class_work', $classwork);
    $stmt->bindParam(':q1', $q1);
    $stmt->bindParam(':q2', $q2);
    $stmt->bindParam(':q3', $q3);
    $stmt->bindParam(':final', $final);
    $stmt->bindParam(':memory', $memory);
    $stmt->bindParam(':user', $user_id);
    $stmt->execute();
    $lastid = $conn->lastInsertId();
    return $lastid;
}

function getAllReports(){
    $sql = "SELECT 
                report_id,
                student_id,
                mark_id,
                attentiveness,
                discipline,
                reading,
                writing,
                speaking,
                listening,
                memory,
                register_user,
                register_date,
                del_flag
            FROM t_report
            WHERE del_flag = 0 ORDER BY report_id DESC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}
function getOneReport($id){
    $sql = "SELECT 
                report_id,
                student_id,
                mark_id,
                attentiveness,
                discipline,
                reading,
                writing,
                speaking,
                listening,
                result_last,
                att,
                homework,
                classwork,
                q1,
                q2,
                q3,
                final,
                memory,
                register_user,
                register_date,
                del_flag
            FROM t_report
            WHERE del_flag = 0 AND report_id = :id";

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

function getReportTrimScore($examID, $studentID) {
    $where = '';
    foreach ($examID as $number => $examvalues){
        $where .= " exam_id =".$examvalues['exam_id'];
        if($number+1 < COUNT($examID) ){
            $where .= " OR ";
            }
       }
    $sql = "SELECT 
                student_id,
                SUM(absence_a) AS absence_a,
                SUM(absence_p) AS absence_p,
                SUM(home_work) AS home_work,
                SUM(class_work) AS class_work,
                SUM(quiz1) AS quiz1,
                SUM(quiz2) AS quiz2,
                SUM(quiz3) AS quiz3,
                SUM(total) AS Total
            FROM `T_Exam_Marks` 
            WHERE (";
    $sql .= $where;
    $sql .= ")AND student_id = :studentID
            AND del_flag = 0
            AND leave_flag = 0
            GROUP BY student_id
            LIMIT 3";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':studentID', $studentID);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}
?>