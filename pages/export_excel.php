<?php
  include '../model/manageuser.php';
  include '../model/util.php';
  include '../model/managestudent.php';
  include '../model/manageclass.php';  


session_start();
ob_start();
if(!$_SESSION['user']) {
   header("Location:../index.php");
} else {
  $user_session = unserialize($_SESSION["user"]);
}
  /** PHPExcel_IOFactory */
  require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';

  // $target_date = date('Y-m-d');
  // $classes = getAllClasses();
  // $total = countAllStudent(date('Y-m-d'));
  // $new_stu = countNewStudent(date('Y-m-d'));
  // $old_stu = countOldStudent(date('Y-m-d'));
  // $leave_stu = countLeaveStudent(date('Y-m-d'));
  // $total_leave = countTotalLeaveStudent(date('Y-m-d'));
  // $list = getAllStudentInMonth(date('Y-m-d'));

  if (isset($_GET['date'])) {
    if(!empty($_GET['date'])) {
      $target_date = date('Y-m-d', strtotime($_GET['date']));
      $classes = getAllClasses();

      if($user_session->getRole() == 'Admin'){
    $list = getAllStudentInMonth($target_date);
    $new_stu = countNewStudent($target_date);
    $old_stu = countOldStudent($target_date);
    $leave_stu = countLeaveStudent($target_date);
    $total_leave = countTotalLeaveStudent($target_date);
    $total = countAllStudent($target_date);
  }elseif ($user_session->getRole() == 'Teacher') {
    $list = getAllStudentInMonthByTeacher($target_date,$user_session->getUserID());
    $new_stu = countNewStudentByTeacher($target_date,$user_session->getUserID());
    $old_stu = countOldStudentByTeacher($target_date,$user_session->getUserID());
    $leave_stu = countLeaveStudentByTeacher($target_date,$user_session->getUserID());
    $total_leave = countTotalLeaveStudentByTeacher($target_date,$user_session->getUserID());
    $total = countAllStudentByTeacher($target_date,$user_session->getUserID());
  }else{
    $list = getAllStudentInMonth_Rec($target_date,$user_session->getUserID());
    $new_stu = countNewStudentByRec($target_date,$user_session->getUserID());
    $old_stu = countOldStudentByRec($target_date,$user_session->getUserID());
    $leave_stu = countLeaveStudentByRec($target_date,$user_session->getUserID());
    $total_leave = countTotalLeaveStudentByRec($target_date,$user_session->getUserID());
    $total = countAllStudentUserRole($target_date,$user_session->getUserID());
  }

      $objReader = PHPExcel_IOFactory::createReader('Excel5');
      $objPHPExcel = $objReader->load("templates/report.xls");

      $objPHPExcel->getActiveSheet()->setCellValue('C1', dateFormat($target_date, 'F Y'));
      $objPHPExcel->getActiveSheet()->setCellValue('C3', dateFormat($target_date, 'F Y'));
      $objPHPExcel->getActiveSheet()->setCellValue('C5', $total . '(Leave: ' . $total_leave . ')');
      $objPHPExcel->getActiveSheet()->setCellValue('E5', $new_stu);
      $objPHPExcel->getActiveSheet()->setCellValue('C6', $old_stu);
      $objPHPExcel->getActiveSheet()->setCellValue('E6', $leave_stu);

      $baseRow = 10;
      foreach($list as $r => $dataRow) {
        $row = $baseRow + $r;
        $clazz = getOneClass($dataRow['class_id']);
        // $objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);

        $first_day = getTime($target_date, 'Y-m-01');
        $last_day = getTime($target_date, 'Y-m-t');
        $enroll_date = getTime($dataRow['enroll_date'], 'Y-m-d');
        $leave_date = getTime($dataRow['leave_date'], 'Y-m-d');
        $leave = $dataRow['leave_date'];

        $status = '';
        $color = '';

        if($enroll_date >= $first_day && $enroll_date <= $last_day && empty($leave)) {
          $status = "New";
          $color = PHPExcel_Style_Color::COLOR_DARKGREEN;
        } else if($enroll_date < $first_day && empty($leave)) {
          $status = "Old";
          $color = PHPExcel_Style_Color::COLOR_DARKBLUE;
        } else if(!empty($leave)) {
          if($leave_date >= $first_day && $leave_date <= $last_day) {
            $status = "Leave";
            $color = PHPExcel_Style_Color::COLOR_RED;
          } else {
            $status = "Leave";
            $color = PHPExcel_Style_Color::COLOR_DARKYELLOW;
          }
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $r+1)
                                      ->setCellValue('B'.$row, $dataRow['student_name'])
                                      ->setCellValue('C'.$row, $dataRow['gender'] != 1 ? ($dataRow['gender'] != 2 ? 'Other' : 'F') : 'M')
                                      ->setCellValue('D'.$row, $clazz != null ? $clazz->getClassName() : 'Unknown')
                                      ->setCellValue('E'.$row, $clazz != null ? dateFormat($clazz->getStartTime(), "g:i A") . " - " . 
                                                                                dateFormat($clazz->getEndTime(), "g:i A") : 'Unknown')
                                      ->setCellValue('F'.$row, dateFormat($dataRow['enroll_date'], "d - F - Y"))
                                      ->setCellValue('G'.$row, dateFormat($dataRow['dob'], "d - F - Y"))
                                      ->setCellValue('H'.$row, date_diff(date_create($dataRow['dob']), date_create('now'))->y)
                                      ->setCellValue('I'.$row, $dataRow['nationality'])
                                      ->setCellValue('J'.$row, $dataRow['address'])
                                      ->setCellValue('K'.$row, $status)
                                      ->getStyle('K'.$row)->getFont()->getColor()->setARGB($color);
      }

      $objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save(str_replace('.php', '.xls', __FILE__));

      $filename = "export_excel.xls";
      $file_path = "http://" . $_SERVER['HTTP_HOST'] . "/rachana/pages/" .$filename;

      $contenttype = "application/octet-stream";
      header("Content-Type: " . $contenttype);
      header("Content-Disposition: attachment; filename=\"" . basename("report-" . $target_date . ".xls") . "\";");
      header("Pragma: no-cache");
      header("Expires: 0");

      readfile($file_path);  
    } else {
      header("Location:404.php");
    }
  }
?>