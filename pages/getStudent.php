<?php 
  include '../model/managestudent.php';
  include '../model/manageuser.php';

	if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $students = getAllStudentInClass($id);
  } else {
    $students = getAllStudentInClass(1);
  }
  for($i = 0; $i< COUNT($students); $i++){
  	$Json[]=(array(
  		'id' => $students[$i]['student_id'],
  		'name' => $students[$i]['student_name']
  	));
  }
  echo json_encode($Json);
?>
