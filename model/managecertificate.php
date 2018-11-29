<?php

include 'certificate.php';

function getAllAttendance(){

}
function insertCertificate($certificate){
    $conn = getConnection();
    $sql = "INSERT INTO t_certificates(
        student_id,
        cert_type,
        level,
        level_id,
        score,
        grade,
        date,
        issus_date,
        no,
        detail,
        type_month,
        month,
        year,
        register_user,
        register_date,
        update_user,
        update_date,
        del_flag)
    VALUES(
        :StudentID,
        :Type,
        :Level,
        :LevelID,
        :Score,
        :Grade,
        :Date,
        :IssusDate,
        :No,
        :Detail,
        :TypeMonth,
        :Month,
        :Year,
        :UserID,
        :RegisterDate,
        :UserID,
        CURDATE(),
        0
        )";
$userID = $certificate->getRegisterUser();
$studentID= $certificate->getStudentID();
$type= $certificate->getCertificateType();
$level= $certificate->getLevel();
$level_id= $certificate->getLevelID();
$score= $certificate->getScore();
$grade= $certificate->getGrade();
$date= $certificate->getDate();
$issus= $certificate->getIssueDate();
$no= $certificate->getNo();
$detail= $certificate->getDetail();
$type_month= $certificate->getTypeMonth();
$month= $certificate->getMonth();
$year= $certificate->getYear();
$register_date= $certificate->getRegisterDate();

$stmt = $conn->prepare($sql);
$stmt->bindParam(':Type',$type);
$stmt->bindParam(':StudentID',$studentID);
$stmt->bindParam(':Level',$level);
$stmt->bindParam(':LevelID',$level_id);
$stmt->bindParam(':Score',$score);
$stmt->bindParam(':Grade',$grade);
$stmt->bindParam(':Date',$date);
$stmt->bindParam(':IssusDate',$issus);
$stmt->bindParam(':No',$no);
$stmt->bindParam(':Detail',$detail);
$stmt->bindParam(':TypeMonth',$type_month);
$stmt->bindParam(':Month',$month);
$stmt->bindParam(':Year',$year);
$stmt->bindParam(':UserID',$userID);
$stmt->bindParam(':RegisterDate',$register_date);
$stmt->execute();
$lastid = $conn->lastInsertId();
$records = getCertificateByID($lastid);
return $records;
}

function updateAttendance($attendance){

}
function deleteAttendance($userID, $id){
    
}

function getCertificateByID($id){
    $sql = "SELECT
                cert_id,
                student_id,
                cert_type,
                level,
                level_id,
                score,
                grade,
                date,
                issus_date,
                no,
                detail,
                type_month,
                month,
                year,
                register_date,
                register_user,
                update_date,
                update_user,
                del_flag
            FROM 
                t_certificates
            WHERE 
                cert_id =:certID
            AND
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':certID', $id);
    $stmt->execute();
    $result = $stmt->fetch();
    $certificate = null;
    if (!empty($result)){
        $certificate = new Certificate;
        $certificate->setCertificateID($result['cert_id']);
        $certificate->setStudentID($result['student_id']);
        $certificate->setCertificateType($result['cert_type']);
        $certificate->setLevel($result['level']);
        $certificate->setLevelID($result['level_id']);
        $certificate->setScore($result['score']);
        $certificate->setGrade($result['grade']);
        $certificate->setDate($result['date']);
        $certificate->setNo($result['no']);
        $certificate->setDetail($result['detail']);
        $certificate->setTypeMonth($result['type_month']);
        $certificate->setMonth($result['month']);
        $certificate->setYear($result['year']);
        $certificate->setRegisterUser($result['register_user']);
        $certificate->setRegisterDate($result['register_date']);
        $certificate->setUpdateUser($result['update_user']);
        $certificate->setUpdateDate($result['update_date']);
        $certificate->setDelFlag($result['del_flag']);
        $certificate->setIssueDate($result['issus_date']);
    }
    return $certificate;
}
function getAttendanceByAbsent($studentID,$month,$year){
    $sql = "SELECT
                att_id,
                student_id,
                room_id,
                att_date,
                approve_by,
                att_type,
                reason
            FROM 
                t_attendances
            WHERE 
                student_id =:studentID
            AND
                MONTH(att_date) =:month
            AND
                YEAR(att_date) =:year
            AND
                att_type = 0
            AND
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':studentID', $studentID);
    $stmt->bindParam(':month', $month);
    $stmt->bindParam(':year', $year);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getAttendanceByPermession($studentID,$month,$year){
    $sql = "SELECT
                att_id,
                student_id,
                room_id,
                att_date,
                approve_by,
                att_type,
                reason
            FROM 
                t_attendances
            WHERE 
                student_id =:studentID
            AND
                MONTH(att_date) =:month
            AND
                YEAR(att_date) =:year
            AND
                att_type = 1
            AND
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':studentID', $studentID);
    $stmt->bindParam(':month', $month);
    $stmt->bindParam(':year', $year);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
function getAttendanceByStudent($id,$month,$year){
    $sql = "SELECT
                att_id,
                student_id,
                room_id,
                att_date,
                approve_by,
                att_type,
                reason
            FROM 
                t_attendances
            WHERE 
                student_id =:studentID
            AND
                MONTH(att_date) =:month
            AND
                YEAR(att_date) =:year
            AND
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':studentID', $id);
    $stmt->bindParam(':month', $month);
    $stmt->bindParam(':year', $year);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

      function datekh($datekh){
        $datekh = str_replace('1', '១', $datekh);
        $datekh = str_replace('2', '២', $datekh);
        $datekh = str_replace('3', '៣', $datekh);
        $datekh = str_replace('4', '៤', $datekh);
        $datekh = str_replace('5', '៥', $datekh);
        $datekh = str_replace('6', '៦', $datekh);
        $datekh = str_replace('7', '៧', $datekh);
        $datekh = str_replace('8', '៨', $datekh);
        $datekh = str_replace('9', '៩', $datekh);
        $datekh = str_replace('0', '០', $datekh);
        $datekh = str_replace('January', 'មករា', $datekh);
        $datekh = str_replace('February', 'កុម្ភៈ', $datekh);
        $datekh = str_replace('March', 'មីនា', $datekh);
        $datekh = str_replace('April', 'មេសា', $datekh);
        $datekh = str_replace('May', 'ឧសភា', $datekh);
        $datekh = str_replace('June', 'មិថុនា', $datekh);
        $datekh = str_replace('July', 'កក្កដា', $datekh);
        $datekh = str_replace('August', 'សីហា', $datekh);
        $datekh = str_replace('September', 'កញ្ញា', $datekh);
        $datekh = str_replace('October', 'តុលា', $datekh);
        $datekh = str_replace('November', 'ខែវិច្ឆិកា', $datekh);
        $datekh = str_replace('December', 'ធ្នូ', $datekh);

        return $datekh;
      }
?>