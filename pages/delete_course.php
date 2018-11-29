<?php
  include '../model/manageuser.php';
  include '../model/managecourse.php';

  session_start();
  ob_start();
  if(!$_SESSION['user']){
     header("Location:../index.php");
  }else{
    $user_session = unserialize($_SESSION["user"]);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $user_id = $user_session->getUser_code();
    deleteCourse($user_id, $course_id);
    header("Location:course_list.php");
  } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    header("HTTP/1.0 405 Method Not Allowed"); 
    include 'custom-msg.php';
    exit(); 
  }     
?>