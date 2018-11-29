<?php
include'../model/manageexammarks.php';
include '../model/manageuser.php';
include '../model/managestudent.php';
include '../model/managesettings.php';
include '../model/util.php';

session_start();
ob_start();
if(!$_SESSION['user']) {
   header("Location:../index.php");
} else {
  $user_session = unserialize($_SESSION["user"]);
}
//$student = new Student;
$exam_mark = new Exam_marks;
//var_dump($_POST);
if(isset($_POST)){
    $action = $_GET['action'];
    $markID = $_GET['mark_id'];
}else{
    $action = $_POST['action'];
    $markID = $_POST['mark_id'];
}
if($action !== 'duplicate'){
    $userID = $user_session->getUserID();
    $getStudentMarks = getOneExamMark($markID);
    $student = getOneStudent($getStudentMarks->getStudent_id());
    $classID = $student->getClassID();
    $moveExamID=$getStudentMarks->getExam_id(); 
}
    if($action == 'delete') {
        $showMark = getOneExamMark($markID);
        deleteStudentMark($userID,$markID);
        $JSON = array(
          'roomID' => $showMark->getRoom_id(),
          'examID' => $showMark->getExam_id()
        );
        echo json_encode($JSON);
        
    }elseif($action == 'move'){
        $showMark = getOneExamMark($markID);
        moveStudentMark($userID,$markID,$classID);
        $JSON = array(
          'examID' => $showMark->getExam_id()
        );
        echo json_encode($JSON);
        
    }elseif($action == 'replace'){
        $showMark = getOneExamMark($markID);
//        replaceStudentMark();
        moveStudentMark($userID,$markID,$classID);
        $JSON = array(
          'examID' => $showMark->getExam_id()
        );
        echo json_encode($JSON);
        
    }elseif($action == 'insert'){
        $getAllStudents = getAllStudentInClass($classID);
        $showMark = getOneExamMark($markID);
        foreach ($getAllStudents as $key => $value) {
            if($value['student_id'] == $getStudentMarks->getStudent_id()){
                moveStudentMark($userID,$markID,$classID);
            }else{
                autoInsertExamMarks($userID,$classID,$moveExamID,$value['student_id']);
            } 
        }
        $JSON = array(
          'examID' => $showMark->getExam_id()
        );
        echo json_encode($JSON);
    }
    
    if($action == 'duplicate'){
        $show = getAllStudentDuplicate($markID);
        $status = false;
        if($show == null){
            $status = true;
        }
        $JSON = array(
          'status' => $status
        );
        echo json_encode($JSON);
    }
    
    
  
?>
