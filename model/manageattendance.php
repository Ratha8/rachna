<?php

include 'attendance.php';

function getAllAttendance(){

}
function getAttendanceByDate($roomID,$month,$year){
    $sql = "SELECT
                att_id,
                student_id,
                att_date,
                approve_by,
                att_type,
                reason
            FROM 
                t_attendances
            WHERE 
                room_id =:roomID
            AND
                MONTH(att_date) =:month
            AND
                YEAR(att_date) =:year
            AND
                del_flag = 0
            GROUP BY student_id";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':roomID', $roomID);
    $stmt->bindParam(':month', $month);
    $stmt->bindParam(':year', $year);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
function getAttendanceFromDate($roomID,$from,$to){
    $sql = "SELECT
                att_id,
                student_id,
                att_date,
                approve_by,
                att_type,
                reason
            FROM 
                t_attendances
            WHERE 
                room_id =:roomID
            AND
                att_date between :from_date AND :to_date
            AND
                del_flag = 0
            GROUP BY student_id";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':roomID', $roomID);
    $stmt->bindParam(':from_date', $from);
    $stmt->bindParam(':to_date', $to);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
function insertAttendance($attendance,$roomID){
    $conn = getConnection();
    $sql = "INSERT INTO t_attendances(
        student_id,
        room_id,
        att_date,
        approve_by,
        att_type,
        reason,
        register_user,
        register_date,
        update_user,
        update_date,
        del_flag)
    VALUES(
        :StudentID,
        :roomID,
        :AttDate,
        :UserID,
        :AttType,
        :Reason,
        :UserID,
        CURDATE(),
        :UserID,
        CURDATE(),
        0
        )";
$userID = $attendance->getRegisterUser();
$studentID= $attendance->getStudentID();
$attDate = $attendance->getAttendanceDate();
$attType = $attendance->getAttendanceType();
$reason= $attendance->getReason();
$stmt = $conn->prepare($sql);
$stmt->bindParam(':roomID',$roomID);
$stmt->bindParam(':StudentID',$studentID);
$stmt->bindParam(':AttDate',$attDate);
$stmt->bindParam(':AttType',$attType);
$stmt->bindParam(':Reason',$reason);
$stmt->bindParam(':UserID',$userID);
$stmt->execute();
}
function updateAttendance($attendance){
    var_dump($attendance);
    $conn = getConnection();
    $sql =  "UPDATE 
                T_attendances
            SET 
                student_id = :studentID,
                att_type = :attType,
                att_date = :attDate,
                reason = :reason,
                update_user = :UserID,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                att_id = :attID";
    $attID = $attendance->getAttendanceID();
    $userID = $attendance->getRegisterUser();
    $studentID= $attendance->getStudentID();
    $attDate = $attendance->getAttendanceDate();
    $attType = $attendance->getAttendanceType();
    $reason= $attendance->getReason();
    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':attID',$attID);
    $stmt->bindParam(':studentID',$studentID);
    $stmt->bindParam(':attDate',$attDate);
    $stmt->bindParam(':attType',$attType);
    $stmt->bindParam(':reason',$reason);
    $stmt->bindParam(':UserID',$userID);
    $stmt->execute();
}
function deleteAttendance($userID, $id){
    $conn = getConnection();
    $sql = $sql =  "UPDATE 
                        T_attendances
                    SET 
                        update_user = :userID,
                        update_date = CURRENT_TIMESTAMP,
                        del_flag = 1
                    WHERE 
                        att_id = :attID";
    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':attID',$id);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();
}
function deleteAttendanceStudentID($userID, $id){
    $conn = getConnection();
    $sql = $sql =  "UPDATE 
                        T_attendances
                    SET 
                        update_user = :userID,
                        update_date = CURRENT_TIMESTAMP,
                        del_flag = 1
                    WHERE 
                        student_id = :studentID";
    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':studentID',$id);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();
}
function getAttendanceByID($id){
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
                att_id =:attID
            AND
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':attID', $id);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
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
function getAttendanceByAbsentFromDate($studentID,$from,$to){
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
                att_date >= :from_date
            AND
                att_date <= :to
            AND
                att_type = 0
            AND
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':studentID', $studentID);
    $stmt->bindParam(':from_date', $from);
    $stmt->bindParam(':to', $to);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getAttendanceByPermessionFromDate($studentID,$from,$to){
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
                att_date >= :from_date
            AND
                att_date <= :to
            AND
                att_type = 1
            AND
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':studentID', $studentID);
    $stmt->bindParam(':from_date', $from);
    $stmt->bindParam(':to', $to);
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
function getAttendanceByStudentFromDate($id,$from,$to){
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
                att_date >= :from_date
            AND
                att_date <= :to
            AND
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':studentID', $id);
    $stmt->bindParam(':from_date', $from);
    $stmt->bindParam(':to', $to);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getAttendanceOnlyDate($from,$to){
    $sql = "SELECT
                att_id,
                student_id,
                att_date,
                approve_by,
                att_type,
                reason
            FROM 
                t_attendances
            WHERE 
                att_date between :from_date AND :to_date
            AND
                del_flag = 0
            GROUP BY student_id";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':from_date', $from);
    $stmt->bindParam(':to_date', $to);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getAttendanceOnlyDateTech($from,$to){
    $sql = "SELECT
                att_id,
                student_id,
                att_date,
                approve_by,
                att_type,
                reason
            FROM 
                t_attendances
            LEFT JOIN t_classes
                ON  room_id = class_id
            WHERE 
                att_date between :from_date AND :to_date
            AND
                t_attendances.del_flag = 0
            AND 
                teacher_id = 2
            GROUP BY student_id";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':from_date', $from);
    $stmt->bindParam(':to_date', $to);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getAttendanceOnlyDateRe($from,$to){
    $sql = "SELECT
                att_id,
                ta.student_id,
                att_date,
                approve_by,
                att_type,
                reason
            FROM 
                t_attendances ta
            LEFT JOIN t_students ts
                ON  ta.student_id = ts.student_id
            WHERE 
                att_date between :from_date AND :to_date
            AND
                del_flag = 0
            AND 
                ts.register_user = 1
            GROUP BY ta.student_id";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':from_date', $from);
    $stmt->bindParam(':to_date', $to);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
?>