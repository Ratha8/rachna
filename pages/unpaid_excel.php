<?php

include '../model/manageuser.php';
include '../model/util.php';
include '../model/managestudent.php';
include '../model/manageclass.php';
// include '../model/managelevel.php';
include '../model/managerank.php';
include '../model/manageexam.php';
include '../model/manageexammarks.php';

  session_start();
ob_start();
if(!$_SESSION['user']) {
   header("Location:../index.php");
} else {
  $user_session = unserialize($_SESSION["user"]);
}

 if($user_session->getRole() == 'Teacher'){
    $classes=getAllClassesUserRole($user_session->getUserID());
  }else{
    $classes = getAllClasses();
  }
/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';

if (isset($_GET['year']) & isset($_GET['month'])) {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $month_text = date('F',$month);
    $records = getAllUnPaidStudentEx($year, $month);
    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load("templates/unpaid_excel.xls");
    $objPHPExcel->getActiveSheet()->setCellValue('I6', $month_text.'-'.$year);
    $baseRow = 10;
    $row = 10;
    $time_s = array('None','Morning', 'Afternnon', "Evening");
     for($z = 1 ; $z <= 3; $z++ ){
        $row = $row + 1;
        $baseRow = $baseRow + 1;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $baseRow . ':N' . $baseRow);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $baseRow, $time_s[$z]);
        foreach ($records as $key => $value) {
            $getClass = getOneClass($value['class_id']);
            $getLevel = getOneLevel($getClass->getLevelID());
            if($getClass->getTimeShift() == $z ){
                $row = $row + 1;
                $baseRow = $baseRow + 1;
                $ex_date = date('d/F/Y', strtotime($value['expire_paymentdate']));
                $rec = getUserByUserID($getClass->getRegisterUser());
                switch ($value['gender']) {
                    case 1:
                        $sex = 'Male';
                        break;
                    case 2:
                        $sex = 'Female';
                        break;
                    default:
                        $sex = 'Orther';
                        break;
                }
                $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $row . ':N' . $row)->applyFromArray(
                    array(
                        'font' => array(
                            'bold' => false,
                            'size' => 14,
                            'name' => 'Khmer OS Battambang'
                        )
                    )
                );
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $key + 1)
                            ->setCellValue('B' . $row, $getLevel->getLevelName())
                            ->setCellValue('C' . $row, $getClass->getTeacherName())
                            ->setCellValue('D' . $row, $rec->getUsername())
                            ->setCellValue('E' . $row, $value['student_name'])
                            ->setCellValue('F' . $row, $sex)
                            ->setCellValue('G' . $row, $ex_date)
                            ->setCellValue('H' . $row, '')
                            ->setCellValue('I' . $row, '')
                            ->setCellValue('J' . $row, '')
                            ->setCellValue('K' . $row, '')
                            ->setCellValue('L' . $row, '')
                            ->setCellValue('M' . $row, '')
                            ->setCellValue('N' . $row, '');
                            }

        }
    }
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save(str_replace('.php', '.xls', __FILE__));

    $filename = "unpaid_excel.xls";
    $file_path = "http://" . $_SERVER['HTTP_HOST'] . "/rachana/pages/" . $filename;
    $contenttype = "application/octet-stream";
    header("Content-Type: " . $contenttype);
    header("Content-Disposition: attachment; filename=\"" . basename("Not Yet Pay" . $month_text ."-". $year. ".xls") . "\";");
    header("Pragma: no-cache");
    header("Expires: 0");

    readfile($file_path);
}
?>