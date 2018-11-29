<?php
include 'exam_marks.php';

function insertExam_marks($exam_mark){
    $conn = getConnection();
    $sql = "INSERT INTO T_Exam_Marks(
                room_id,
                student_id,
                exam_id,
                absence_a,
                absence_p,
                home_work,
                class_work,
                quiz1,
                quiz2,
                quiz3,
                final_exam,
                total,
                leave_flag,
                register_user,
                register_date,
                update_user,
                update_date)
            VALUES(
                :room_id,
                :student_id,
                :exam_id,
                :absence_a,
                :absence_p,
                :home_work,
                :class_work,
                :quiz1,
                :quiz2,
                :quiz3,
                :final_exam,
                :total,
                0,
                :user,
                CURDATE(),
                :user,
                CURDATE()
                )";

    $user_id = $exam_mark->getRegister_user();
    $room_id = $exam_mark->getRoom_id();
    $student_id = $exam_mark->getStudent_id();
    $exam_id = $exam_mark->getExam_id();
    $absence_a = $exam_mark->getAbsence_a();
    $absence_p = $exam_mark->getAbsence_p();
    $home_work = $exam_mark->getHome_work();
    $class_work = $exam_mark->getClass_work();
    $quiz1 = $exam_mark->getQuiz1();
    $quiz2 = $exam_mark->getQuiz2();
    $quiz3 = $exam_mark->getQuiz3();
    $final_exam = $exam_mark->getFinal_exam();
    $total = $exam_mark->getTotal();
//    $leave_flag = $exam_mark->getLeave_flag();
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':room_id', $room_id);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':exam_id', $exam_id);
    $stmt->bindParam(':absence_a', $absence_a);
    $stmt->bindParam(':absence_p', $absence_p);
    $stmt->bindParam(':home_work', $home_work);
    $stmt->bindParam(':class_work', $class_work);
    $stmt->bindParam(':quiz1', $quiz1);
    $stmt->bindParam(':quiz2', $quiz2);
    $stmt->bindParam(':quiz3', $quiz3);
    $stmt->bindParam(':final_exam', $final_exam);
    $stmt->bindParam(':total', $total);
//    $stmt->bindParam(':leave_flag', 0);
    $stmt->bindParam(':user', $user_id);
    
    $stmt->execute();
    $lastid = $conn->lastInsertId();
    return $lastid;
}
function autoInsertExamMarks($userID,$classID,$examID,$studentID){
    $conn = getConnection();
    $sql = "INSERT INTO T_Exam_Marks(
                room_id,
                student_id,
                exam_id,
                absence_a,
                absence_p,
                home_work,
                class_work,
                quiz1,
                quiz2,
                quiz3,
                final_exam,
                total,
                register_user,
                register_date,
                update_user,
                update_date)
            VALUES(
                :room_id,
                :student_id,
                :exam_id,
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                10,
                :user,
                CURDATE(),
                :user,
                CURDATE()
                )";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':room_id', $classID);
    $stmt->bindParam(':student_id', $studentID);
    $stmt->bindParam(':exam_id', $examID);
    $stmt->bindParam(':user', $userID);
    
    $stmt->execute();
    $lastid = $conn->lastInsertId();
    return $lastid;
}

function getOneExamMark($id=''){
    $conn = getConnection();
    $sql = "SELECT
                mark_id,
                room_id,
                student_id,
                exam_id,
                absence_a,
                absence_p,
                home_work,
                class_work,
                quiz1,
                quiz2,
                quiz3,
                final_exam,
                total,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Exam_Marks
            WHERE del_flag = 0 
            AND leave_flag = 0
            AND  mark_id = :id";

    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();  
    $result = $stmt->fetch();

    $exam_mark = null;

    if (!empty($result)){
        $exam_mark = new exam_marks;
        $exam_mark->setMark_id($result['mark_id']);
        $exam_mark->setExam_id($result['exam_id']);
        $exam_mark->setRoom_id($result['room_id']);
        $exam_mark->setStudent_id($result['student_id']);
        $exam_mark->setAbsence_a($result['absence_a']);
        $exam_mark->setAbsence_p($result['absence_p']);
        $exam_mark->setHome_work($result['home_work']);
        $exam_mark->setClass_work($result['class_work']);
        $exam_mark->setQuiz1($result['quiz1']);
        $exam_mark->setQuiz2($result['quiz2']);
        $exam_mark->setQuiz3($result['quiz3']);
        $exam_mark->setFinal_exam($result['final_exam']);
        $exam_mark->setTotal($result['total']);
        $exam_mark->setRegister_user($result['register_user']);
        $exam_mark->setUpdate_user($result['update_user']);
        $exam_mark->setRegister_date($result['register_date']);
        $exam_mark->setRegister_user($result['register_user']);
        
    }

    return $exam_mark;
}

function getAllExamClass(){
    $sql = "SELECT
                mark_id,
                room_id,
                student_id,
                exam_id,
                absence_a,
                absence_p,
                home_work,
                class_work,
                quiz1,
                quiz2,
                quiz3,
                final_exam,
                total,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Exam_Marks
            WHERE del_flag = 0 
            AND leave_flag =0
            ";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetch();

    return $result;
}


function updateExam_marks($exam_marks){
        $conn = getConnection();
        
		$sql = "UPDATE 
                    T_Exam_Marks 
                SET
                    absence_a = :absence_a,
                    absence_p = :absence_p,
                    home_work = :home_work,
                    class_work = :class_work,
                    quiz1 = :quiz1,
                    quiz2 = :quiz2,
                    quiz3 = :quiz3,
                    final_exam = :final_exam,
                    total = :total,
                    update_user = :user ,
                    update_date = CURRENT_TIMESTAMP
                WHERE mark_id = :mark_id";
        
        $mark_id = $exam_marks->getMark_id();
        $absence_a = $exam_marks->getAbsence_a();
        $absence_p =$exam_marks->getAbsence_p();
        $home_work = $exam_marks->getHome_work();
        $class_work = $exam_marks->getClass_work();
        $quiz1 = $exam_marks->getQuiz1();
        $quiz2 = $exam_marks->getQuiz2();
        $quiz3 = $exam_marks->getQuiz3();
        $final_exam = $exam_marks->getFinal_exam();
        $total = $exam_marks-> getTotal();
        $update_user = $exam_marks->getUpdate_user();
       
        
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':mark_id',$mark_id);
        $stmt->bindParam(':absence_a',$absence_a);
        $stmt->bindParam(':absence_p',$absence_p);
        $stmt->bindParam(':home_work',$home_work);
        $stmt->bindParam(':class_work',$class_work);
        $stmt->bindParam(':quiz1',$quiz1);
        $stmt->bindParam(':quiz2',$quiz2);
        $stmt->bindParam(':quiz3',$quiz3);
        $stmt->bindParam(':final_exam',$final_exam);
        $stmt->bindParam(':total',$total);
        $stmt->bindParam(':user',$update_user);
        
	$stmt->execute();
	}
        
        
function getExamMarkID($id,$exam_id){
    $sql = "SELECT 
                mark_id,
                student_id,
                room_id,
                exam_id,
                absence_a,
                absence_p,
                home_work,
                class_work,
                quiz1,
                quiz2,
                quiz3,
                final_exam,
                total,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Exam_Marks
            WHERE 
                del_flag = 0 
            AND 
                leave_flag = 0
            AND 
                room_id = :id 
            AND 
                exam_id=:exam_id 
            ORDER BY total DESC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':exam_id',$exam_id);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
    
}

function checkExamMark($id,$lexam){
    $sql = "SELECT 
            mark_id, 
            room_id
            FROM T_Exam_Marks 
            WHERE del_flag=0 
            AND leave_flag = 0
            AND exam_id = :lid AND room_id = :id GROUP BY room_id";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':lid',$lexam);
    $stmt->execute(); 
    $result = $stmt->fetchAll();

    return $result;
            
}

function moveStudentMark($userID, $markID,$classID){
    $conn = getConnection();
    $sql = "UPDATE 
                T_Exam_Marks
            SET 
                room_id = :classID,
                update_user = :userID,
                update_date = CURRENT_TIMESTAMP
            WHERE
                mark_id = :markID";
    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':markID',$markID);
    $stmt->bindParam(':userID',$userID);
    $stmt->bindParam(':classID',$classID);
    $stmt->execute();
//     $result = $stmt ->fetchAll();
//      return $result;
}


function deleteClassExam($user_id, $exam_id, $class_id){
    $sql = "UPDATE T_Exam_Marks
            SET 
                del_flag = 1,
                update_user = :user,
                update_date = CURDATE()
            WHERE 
                exam_id = :exam_id
            AND
                room_id = :class_id";
            
            $stmt = getConnection()->prepare($sql);
            $stmt->bindParam(':exam_id',$exam_id);
            $stmt->bindParam(':user',$user_id);
            $stmt->bindParam(':class_id',$class_id);
            $stmt->execute();
        }

function deleteStudentMark($user_id, $mark_id){
    $conn = getConnection();
    $sql = "UPDATE 
                T_Exam_Marks
            SET 
                update_user = :user_id,
                update_date = CURRENT_TIMESTAMP,
                del_flag = 1
            WHERE
                mark_id = :mark_id";
    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':mark_id',$mark_id);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->execute();
}

function deleteStudentMarkID($user_id, $student_id){
    $conn = getConnection();
    $sql = "UPDATE 
                T_Exam_Marks
            SET 
                update_user = :user_id,
                update_date = CURRENT_TIMESTAMP,
                del_flag = 1
            WHERE
                student_id = :student_id";
                
    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->bindParam(':student_id',$student_id);
    $stmt->execute();
}
function moveCheckMark($class_id,$exam_id){
    $conn = getConnection();
    $sql = "SELECT
                mark_id,
                room_id,
                student_id,
                exam_id,
                absence_a,
                absence_p,
                home_work,
                class_work,
                quiz1,
                quiz2,
                quiz3,
                final_exam,
                total,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Exam_Marks
            WHERE del_flag = 0 AND room_id = :room_id AND exam_id = :exam_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':room_id',$class_id);
    $stmt->bindParam(':exam_id',$exam_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
function getTopScore($room_id, $examID) {
    $sql = "SELECT 
                mark_id,
                room_id,
                student_id,
                exam_id,
                absence_a,
                absence_p,
                home_work,
                class_work,
                quiz1,
                quiz2,
                quiz3,
                final_exam,
                total,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Exam_Marks
            WHERE del_flag = 0 AND leave_flag = 0 AND room_id = :room_id AND exam_id = :examID AND total = (SELECT max(total) FROM T_Exam_Marks WHERE room_id = :room_id AND exam_id = :examID AND del_flag = 0 AND leave_flag = 0)";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':room_id', $room_id);
    $stmt->bindParam(':examID', $examID);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
}
function getTopTrimScore($examID, $roomID) {
    $where = '';
    foreach ($examID as $number => $examvalues){
        $where .= " exam_id =".$examvalues['exam_id'];
        if($number+1 < COUNT($examID) ){
            $where .= " OR ";
            }
       }
       
    $sql = "SELECT 
                student_id,
                room_id,
                exam_id,
                SUM(total) AS Total
            FROM `T_Exam_Marks` 
            WHERE (";
    $sql .= $where;
    $sql .= ")AND room_id = :roomID
            AND del_flag = 0
            AND leave_flag = 0
            GROUP BY student_id 
            ORDER BY Total DESC 
            LIMIT 3";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':roomID', $roomID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
function getTopSemScore($exam1, $exam2, $exam3, $exam4, $exam5, $exam6, $roomID) {
    
    $sql = "SELECT 
                student_id,
                room_id,
                exam_id,
                SUM(total) AS Total
            FROM `T_Exam_Marks` 
            WHERE (exam_id=:exam1 
            OR exam_id=:exam2
            OR exam_id=:exam3
            OR exam_id=:exam4
            OR exam_id=:exam5
            OR exam_id=:exam6)
            AND room_id = :roomID
            AND del_flag = 0
            GROUP BY student_id 
            ORDER BY Total DESC 
            LIMIT 6";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':exam1', $exam1);
    $stmt->bindParam(':exam2', $exam2);
    $stmt->bindParam(':exam3', $exam3);
    $stmt->bindParam(':exam4', $exam4);
    $stmt->bindParam(':exam5', $exam5);
    $stmt->bindParam(':exam6', $exam6);
    $stmt->bindParam(':roomID', $roomID);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
}
function getTopYearScore($exam1, $exam2, $exam3, $exam4, $exam5, $exam6, $exam7, $exam8, $exam9, $exam10, $exam11, $exam12, $roomID) {
    $sql = "SELECT 
                student_id,
                room_id,
                exam_id,
                SUM(total) AS Total
            FROM `T_Exam_Marks` 
            WHERE (exam_id=:exam1 
            OR exam_id=:exam2
            OR exam_id=:exam3
            OR exam_id=:exam4
            OR exam_id=:exam5
            OR exam_id=:exam6
            OR exam_id=:exam7
            OR exam_id=:exam8
            OR exam_id=:exam9
            OR exam_id=:exam10
            OR exam_id=:exam11
            OR exam_id=:exam12)
            AND room_id = :roomID
            AND del_flag = 0
            GROUP BY student_id 
            ORDER BY Total DESC 
            LIMIT 3";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':exam1', $exam1);
    $stmt->bindParam(':exam2', $exam2);
    $stmt->bindParam(':exam3', $exam3);
    $stmt->bindParam(':exam4', $exam4);
    $stmt->bindParam(':exam5', $exam5);
    $stmt->bindParam(':exam6', $exam6);

    $stmt->bindParam(':exam7', $exam7);
    $stmt->bindParam(':exam8', $exam8);
    $stmt->bindParam(':exam9', $exam9);
    $stmt->bindParam(':exam10', $exam10);
    $stmt->bindParam(':exam11', $exam11);
    $stmt->bindParam(':exam12', $exam12);
    $stmt->bindParam(':roomID', $roomID);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
}

function getExamMarkIdOrderById($id,$exam_id){
    $sql = "SELECT 
                mark_id,
                student_id,
                room_id,
                exam_id,
                absence_a,
                absence_p,
                home_work,
                class_work,
                quiz1,
                quiz2,
                quiz3,
                final_exam,
                total,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Exam_Marks
            WHERE del_flag = 0
            AND leave_flag = 0
            AND room_id = :id AND exam_id=:exam_id ORDER BY student_id ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':exam_id',$exam_id);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
    
}
function countNoneScore($id,$exam_id,$month = '',$year = ''){
    $sql = "SELECT mark_id,
                student_id,
                room_id,
                exam_id,
                absence_a,
                absence_p,
                home_work,
                class_work,
                quiz1,
                quiz2,
                quiz3,
                final_exam,
                total,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Exam_Marks tx
            WHERE
                tx.student_id IN (SELECT ts.student_id FROM T_Students ts WHERE ts.class_id = :id AND del_flag = 0 OR (leave_flag = 1 AND Year(leave_date) >= :year AND Month(leave_date) >= :month ))
            AND
                del_flag = 0
            AND 
                leave_flag = 0
            AND room_id = :id 
            AND exam_id=:exam_id 
            ORDER BY student_id ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':exam_id',$exam_id);
    $stmt->bindParam(':month',$month);
    $stmt->bindParam(':year',$year);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}
function getTopScoreLevelMultiple($class, $examID) {
    $where = '';
    $whereexam = '';
    foreach ($class as $number => $levelValues){
        $where .= " room_id =".$levelValues['class_id'];
        if($number+1 < COUNT($class) ){
            $where .= " OR ";
            }
       }
    
    foreach ($examID as $number => $examvalues){
        $whereexam .= " exam_id =".$examvalues['exam_id'];
        if($number+1 < COUNT($examID) ){
            $whereexam .= " OR ";
            }
       }

    $sql = "SELECT 
                student_id,
                room_id,
                exam_id,
                SUM(total) AS Total
            FROM `T_Exam_Marks` 
            WHERE ( ";
    $sql .= $where;
    $sql .= " ) AND (";
    $sql .= $whereexam;
    $sql .= " ) AND del_flag = 0
            AND leave_flag = 0
            GROUP BY student_id 
            ORDER BY Total DESC 
            LIMIT 3";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
function getTopScoreLevel($class, $examID) {
    $where = '';
    foreach ($class as $number => $levelValues){
        $where .= " room_id =".$levelValues['class_id'];
        if($number+1 < COUNT($class) ){
            $where .= " OR ";
            }
       }
       
    $sql = "SELECT 
                student_id,
                room_id,
                exam_id,
                total
            FROM `T_Exam_Marks` 
            WHERE ( ";
    $sql .= $where;
    $sql .= " ) AND exam_id = :examID
            AND del_flag = 0
            AND leave_flag = 0
            GROUP BY student_id 
            ORDER BY total DESC 
            LIMIT 1";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':examID', $examID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
function updateExamLeaveFlag( $student_id,$leaveFlag,$month,$year){
    $conn = getConnection();
    $sql =  "UPDATE 
                    T_Exam_Marks tem
            SET 
                tem.leave_flag = :leaveFlag 
            WHERE 
                tem.student_id = :student_id
            AND 
                tem.exam_id IN (SELECT te.exam_id FROM T_Exam te where te.exam_month > :month AND te.exam_year >= :year) ";
                $stmt = getConnection()->prepare($sql);
                $stmt->bindParam(':month', $month);
                $stmt->bindParam(':year', $year);
                $stmt->bindParam(':student_id',$student_id);
                $stmt->bindParam(':leaveFlag',$leaveFlag);
                $stmt->execute();
}
function getCheckStudentID($id,$roomID,$examID){
    $sql = "SELECT 
                mark_id
            FROM T_Exam_Marks
            WHERE del_flag = 0
            AND leave_flag = 0
            AND student_id = :id AND room_id = :roomID AND exam_id=:examID ORDER BY student_id ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':examID',$examID);
    $stmt->bindParam(':roomID',$roomID);
    $stmt->execute();  
    $result = $stmt->fetch();
    return $result;
    
}
function getCheckExamID($roomID,$examID){
    $sql = "SELECT 
                mark_id
            FROM T_Exam_Marks
            WHERE del_flag = 0
            AND leave_flag = 0
             AND room_id = :roomID AND exam_id=:examID ORDER BY student_id ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':examID',$examID);
    $stmt->bindParam(':roomID',$roomID);
    $stmt->execute();  
    $result = $stmt->fetch();
    return $result;
    
}
function countStuMarkByID($examID,$roomID){
    $sql = "SELECT 
                exam_id
            FROM T_Exam_Marks
            WHERE del_flag = 0
            AND leave_flag = 0
            AND exam_id=:examID AND room_id =:roomID";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':examID',$examID);
    $stmt->bindParam(':roomID',$roomID);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
?>