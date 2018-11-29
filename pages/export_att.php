<?php
include '../model/manageuser.php';
include '../model/util.php';
include'../model/manageexammarks.php';
include'../model/manageexam.php';
include '../model/managestudent.php';
include '../model/manageclass.php';
include '../model/manageattendance.php';

  session_start();
ob_start();
if(!$_SESSION['user']) {
   header("Location:../index.php");
} else {
  $user_session = unserialize($_SESSION["user"]);
}
$exam = new Exam; 
$exam_mark = new Exam_marks;
 if($user_session->getRole() == 'Teacher'){
    $classes=getAllClassesUserRole($user_session->getUserID());
  }else{
    $classes = getAllClasses();
  }
/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';
if((isset($_GET['from_date'])) && (isset($_GET['to_date']))) {
    $from = $_GET['from_date'];
    $to = $_GET['to_date'];
    if($user_session->getRole() == 'Admin'){
        $records = getAttendanceOnlyDate($from,$to);
    }elseif ($user_session->getRole() == 'Teacher') {
        $records = getAttendanceOnlyDateTech($from,$to);
    }else{
        $records = getAttendanceOnlyDateRe($from,$to);
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load("templates/export_att.xls");
    
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'បញ្ជីឈ្មោះអវត្តមានរបស់សិស្ស');
    $objPHPExcel->getActiveSheet()->setCellValue('B3', $from);
    $objPHPExcel->getActiveSheet()->setCellValue('B4', $to);
    
    $row = 5;
    $row_num = 1;
    foreach ($records as $key => $dataRow) {
        $row_num++;
        $student = getOneStudent($records[$key]['student_id']);
        $class = getOneClass($student->getClassID());
        $att_a = getAttendanceByAbsentFromDate($records[$key]['student_id'],$from,$to);
        $att_p = getAttendanceByPermessionFromDate($records[$key]['student_id'],$from,$to);
        $reason = '';
         if(!empty($att_p)){
          foreach ($att_p as $key => $value) {
            $reason .= $value['reason'].',';
          }
        }
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $row .':N'.$row)->applyFromArray(
            array(
                'font' => array(
                    'bold' => false,
                    'size' => 12,
                    'name' => 'Khmer OS Content',
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )));
              $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $row .':N'.$row)->applyFromArray( array(
                'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ))
    );
           $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row_num-1)
                                      ->setCellValue('B'.$row, $student->getStudentName())
                                      ->setCellValue('C'.$row, $class->getClassName())
                                      ->setCellValue('D'.$row, $class->getTeacherName())
                                      ->setCellValue('E'.$row, COUNT($att_a))
                                      ->setCellValue('F'.$row, COUNT($att_p))
                                      ->setCellValue('G'.$row, $reason);                
                            
    }

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save(str_replace('.php', '.xls', __FILE__));

    $filename = "export_att.xls";
    $file_path = "http://" . $_SERVER['HTTP_HOST'] . "/rachana/pages/" . $filename;
    $contenttype = "application/octet-stream";
    header("Content-Type: " . $contenttype);
    header("Content-Disposition: attachment; filename=\"" . basename("Student Attendent From " . $from . " TO ".$to.".xls") . "\";");
    header("Pragma: no-cache");
    header("Expires: 0");

    readfile($file_path);
} else {
      header("Location:404.php");
}

?>