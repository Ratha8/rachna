<?php
include 'student.php';
include 'manageparent.php';
include 'manageemergency.php';
include 'managerelationship.php';
function insertStudent($student){
    $conn = getConnection();
    $sql = "INSERT INTO T_Students(
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                fee,
                enroll_date,
                switch_time,
                expire_paymentdate,
                payment_date,
                paid_date,
                register_user,
                update_user,
                photo,
                start_new,
                expire_new)
            VALUES(
                :student_name,
                :latin_name,
                :student_no,
                :class_id,
                :duration,
                :gender,
                :dob,
                :birth_place,
                :religion,
                :nationality,
                :address,
                :fee,
                :enroll_date,
                :switch_time,
                DATE_ADD(:enroll_date, INTERVAL :duration MONTH),
                CURDATE(),
                :enroll_date,
                :user_id,
                :user_id,
                :photo,
                :enroll_date,
                DATE_ADD(:enroll_date, INTERVAL :duration MONTH)
                )";
    $user_id = $student->getRegisterUser();
    $student_name = $student->getStudentName();
    $latin_name = $student->getLatinName();
    $student_no = $student->getStudentNo();
    $class_id = $student->getClassID();
    $fee = $student->getFee();
    $duration = $student->getDuration();
    $gender = $student->getGender();
    $dob = $student->getDob();
    $birth_place = $student->getBirthPlace();
    $religion = $student->getReligion();
    $nationality = $student->getNationality();
    $address = $student->getAddress();
    $enroll_date = $student->getEnrollDate();
    $switch_time = $student->getSwitchTime();
    $photo = $student->getPhoto();
    if (isset($_FILES['photo'])) {
        $file   = $_FILES['photo'];
        $file_name  = $file['name'];
        $file_tmp   = $file['tmp_name'];
        $file_size  = $file['size'];
        $file_error = $file['error'];
        $file_ext   = explode('.', $file_name);
        $file_fname = explode('.', $file_name);
        $file_fname = strtolower(current($file_fname));
        $file_ext   = strtolower(end($file_ext));
        $allowed    = array('jpg','png','jpeg');
        if (in_array($file_ext,$allowed)) {
            if ($file_error === 0) {
                if ($file_size <= 5000000) {
                        $file_name_new     =  $file_fname . uniqid('',true) . '.' . $file_ext;
                        $file_name_new    =  uniqid('',true) . '.' . $file_ext;
                        $file_destination =  'uploads/' . $file_name_new;
                        if (move_uploaded_file($file_tmp, $file_destination)) {
                                echo "Cv uploaded";
                        }
                        else
                        {
                            echo "some error in uploading file".mysql_error();
                        }
                }
                else
                {
                    echo "size must bne less then 5MB";
                }
            }
        }
        else
        {
            echo "invalid file";
        }
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':latin_name', $latin_name);
    $stmt->bindParam(':student_no', $student_no);
    $stmt->bindParam(':class_id', $class_id);
    $stmt->bindParam(':fee', $fee);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':birth_place', $birth_place);
    $stmt->bindParam(':religion', $religion);
    $stmt->bindParam(':nationality', $nationality);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':enroll_date', $enroll_date);
    $stmt->bindParam(':switch_time', $switch_time);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':start_new', $start_new);
    $stmt->bindParam(':expire_new', $expire_new);
    $stmt->bindParam(':photo', $file_name_new);
    $stmt->execute();   
    $lastid = $conn->lastInsertId();
    return $lastid;
   
}
function getAllStudents(){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                payment_date,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date,
                photo
            FROM T_Students
            WHERE del_flag = 0 ORDER BY student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function getAllStudentDuplicate($studentName){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                payment_date,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date,
                photo
            FROM T_Students
            WHERE del_flag = 0 
            AND student_name =:studentName ORDER BY student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam('studentName', $studentName);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function getAllStudentUserRole($user){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                payment_date,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date,
                photo
            FROM T_Students
            WHERE del_flag = 0 AND register_user = :user ORDER BY student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user',$user);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function getAllStudentByTeacher($user){
    $sql = "SELECT 
                ts.*
            FROM T_Students ts
            LEFT JOIN T_Classes tc
            ON ts.class_id = tc.class_id
            WHERE ts.del_flag = 0 AND tc.teacher_id = :user ORDER BY student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user',$user);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function getAllStudentInClass($class_id){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Students
            WHERE del_flag = 0 AND class_id = :class_id ORDER BY student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':class_id',$class_id);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function getAllStudentInMonth($target_date){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Students
            WHERE 
                enroll_date < LAST_DAY(:target_date) 
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;

}

function getAllStudentInMonth_Rec($target_date,$reciep){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Students
            WHERE 
                enroll_date < LAST_DAY(:target_date) 
            AND 
                del_flag = 0
            AND 
                register_user = :reciep
            ";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':reciep',$reciep);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}

function getAllStudentInMonthByTeacher($target_date,$user){
    $sql = "SELECT 
                ts.*
            FROM T_Students ts
            LEFT JOIN T_Classes tc
            ON ts.class_id = tc.class_id
            WHERE ts.del_flag = 0 
            AND teacher_id = :user  
            AND enroll_date < LAST_DAY(:target_date) 
            ORDER BY student_name ASC";
    
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':user',$user);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function getOneStudent($id){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                payment_date,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,                                                                                                                                                                                         
                update_date,
                photo,
                start_new,
                expire_new
            FROM T_Students
            WHERE del_flag = 0 AND student_id = :id";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();  
    $result = $stmt->fetch();
    $student = null;
    if (!empty($result)){
        $student = new Student;
        $student->setStudentID($result['student_id']);
        $student->setRegisterUser($result['register_user']);
        $student->setUpdateUser($result['update_user']);
        $student->setRegisterDate($result['register_date']);
        $student->setUpdateDate($result['update_date']);
        $student->setStudentName($result['student_name']);
        $student->setLatinName($result['latin_name']);
        $student->setStudentNo($result['student_no']);
        $student->setClassID($result['class_id']);
        $student->setDuration($result['duration']);
        $student->setGender($result['gender']);
        $student->setDob($result['dob']);
        $student->setBirthPlace($result['birth_place']);
        $student->setReligion($result['religion']);
        $student->setNationality($result['nationality']);
        $student->setAddress($result['address']);
        $student->setEnrollDate($result['enroll_date']);
        $student->setSwitchTime($result['switch_time']);
        $student->setLeaveFlag($result['leave_flag']);
        $student->setFee($result['fee']);
        $student->setPaid($result['paid']);
        $student->setExpirePaymentDate($result['expire_paymentdate']);
        $student->setPaymentDate($result['payment_date']);
        $student->setPaidDate($result['paid_date']);
        $student->setLeaveDate($result['leave_date']);
        $student->setPhoto($result['photo']);
        $student->setStart_new($result['start_new']);
        $student->setExpire_new($result['expire_new']);
    }
    return $student;
}

function searchStudent($param){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Students
            WHERE del_flag = 0 
            AND (student_id = :param OR student_name LIKE :custodian OR latin_name like :custodian OR student_no LIKE :custodian)
            ORDER BY student_name ASC";
    $custodian = '%' . $param . '%';
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':custodian', $custodian);
    $stmt->bindParam(':param', $param);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function searchContact($param) {
    $sql =  "SELECT 
            STU.student_id as student_id,
            STU.student_name AS student_name, 
            STU.latin_name AS latin_name, 
            STU.student_no AS student_no,
            STU.class_id AS class_id,
            STU.gender AS gender, 
            STU.address AS address, 
            EMC.emergency_name AS emergency_name, 
            EMC.contact_number AS contact_number, 
            EMC.address AS emergency_address
            FROM 
                t_students AS STU 
            LEFT JOIN 
                t_emergency AS EMC 
            ON 
                STU.student_id = EMC.student_id
            WHERE 
                STU.student_id = :param 
            OR 
                STU.student_name like :custodian 
            OR
                STU.latin_name like :custodian
            OR
                STU.student_no like :custodian                
            AND
                STU.leave_flag = 0
            AND
                STU.del_flag = 0
            GROUP BY 
                STU.student_id"; 
    $custodian ='%'.$param.'%';
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':param',$param);
    $stmt->bindParam(':custodian', $custodian);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;                
}
function getNewStudent($target_date) {

    $sql = "SELECT *
            FROM 
                T_Students
            WHERE 
                enroll_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date)-1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                leave_date is null
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}

function getNewStudentByTeacher($target_date,$userID) {

    $sql = "SELECT 
                ts*
            FROM 
                T_Students ts 
            LEFT JOIN 
                T_Classes tc 
            ON 
                ts.class_id = tc.class_id
            WHERE 
                enroll_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date)-1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                tc.teacher_id = :userID
            AND
                leave_date is null
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}

function getNewStudentByRec($target_date,$userID) {

    $sql = "SELECT *
            FROM 
                T_Students
            WHERE 
                enroll_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date)-1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                register_id = :userID
            AND
                leave_date is null
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}

function getOldStudent($target_date) {
    $sql = "SELECT *
            FROM 
                T_Students
            WHERE 
                enroll_date < DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY)
            AND 
                leave_date is NULL
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}

function getOldStudentByTeacher($target_date,$userID) {
    $sql = "SELECT 
                ts.*
            FROM 
                T_Students ts 
            LEFT JOIN 
                T_Classes tc 
            ON
                ts.class_id = tc.class_id
            WHERE 
                enroll_date < DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY)
            AND 
                leave_date is NULL
            AND 
                ts.del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}

function getOldStudentByRec($target_date,$userID) {
    $sql = "SELECT *
            FROM 
                T_Students
            WHERE 
                enroll_date < DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY)
            AND 
                register_user = :userID
            AND
                leave_date is NULL
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}



function getLeaveStudent($target_date) {

    $sql = "SELECT *
            FROM 
                T_Students
            WHERE 
                leave_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}
function getLeaveStudentByTeacher($target_date,$userID) {

    $sql = "SELECT 
                ts.*
            FROM 
                T_Students ts
            LEFT JOIN 
                T_Classes tc
            ON 
                ts.class_id = :userID
            WHERE 
                leave_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                ts.del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}

function getLeaveStudentByRec($target_date,$userID) {

    $sql = "SELECT 
                *
            FROM 
                T_Students
            WHERE 
                leave_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                register_user = :userID
            AND    
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}



function getTotalLeaveStudent($target_date) {

    $sql = "SELECT *
            FROM 
                T_Students
            WHERE 
                leave_date < LAST_DAY(:target_date)
            AND 
                del_flag = 0
            AND 
                enroll_date < LAST_DAY(:target_date)";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}

function getTotalLeaveStudentByTeacher($target_date,$userID) {

    $sql = "SELECT 
              ts.*
            FROM 
                T_Students ts
            LEFT JOIN 
                T_Classes tc
            ON ts.class_id = tc.class_id
            WHERE 
                leave_date < LAST_DAY(:target_date)
            AND
                tc.teacher_id = :userID
            AND
                del_flag = 0
            AND 
                enroll_date < LAST_DAY(:target_date)";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}

function getTotalLeaveStudentByRec($target_date,$userID) {

    $sql = "SELECT *
            FROM 
                T_Students
            WHERE 
                leave_date < LAST_DAY(:target_date)
            AND
                register_user = :userID
            AND
                del_flag = 0
            AND 
                enroll_date < LAST_DAY(:target_date)";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}



function countAllStudent($target_date) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                enroll_date < LAST_DAY(:target_date) 
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;
}


function countAllStudentUserRole($target_date,$user) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                enroll_date < LAST_DAY(:target_date) 
            AND 
                register_user =:user 
            AND 
                del_flag = 0";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':user', $user);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    

    return $result;
}

function countAllStudentByTeacher($target_date,$user) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students ts
            LEFT JOIN T_Classes tc
            ON ts.class_id = tc.class_id
            WHERE 
                enroll_date < LAST_DAY(:target_date) 
            AND 
                tc.teacher_id =:user 
            AND 
                ts.del_flag = 0";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':user', $user);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    

    return $result;
}

function countNewStudent($target_date) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                enroll_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date)-1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                leave_date is null
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;
}
function countNewStudentUserRole($target_date,$user) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                enroll_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date)-1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                leave_date is null
            AND 
                del_flag = 0
            AND register_user = :user";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':user',$user);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;
}
function countNewStudentByRec($target_date,$userID) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                enroll_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date)-1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                leave_date is null
            AND 
                register_user = :userID
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
     $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;
}
function countNewStudentByTeacher($target_date,$userID) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students ts
            LEFT JOIN 
                T_Classes tc
            ON
                ts.class_id = tc.class_id
            WHERE 
                enroll_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date)-1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                leave_date is null
            AND
                tc.teacher_id = :userID
            AND 
                ts.del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;
}


function countOldStudent($target_date) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                enroll_date < DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY)
            AND 
                leave_date is null
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;

}

function countOldStudentByRec($target_date,$userID) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                enroll_date < DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY)
            AND 
                leave_date is null
            AND 
                register_user = :userID
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;

}

function countOldStudentByTeacher($target_date,$userID) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students ts
            LEFT JOIN 
                T_Classes tc
            ON 
                ts.class_id = tc.class_id
            WHERE 
               enroll_date < DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY)
            AND 
                leave_date is null
            AND 
                tc.teacher_id = :userID    
            AND 
                ts.del_flag = 0";
    
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;

}
function countLeaveStudent($target_date) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                leave_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchColumn();
    return $result;
}
function countLeaveStudentUserRole($target_date,$user) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                leave_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                del_flag = 0
            AND register_user = :user ";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam('user', $user);
    $stmt->execute();  
    $result = $stmt->fetchColumn();
    return $result;
}
function countLeaveStudentByRec($target_date,$userID) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                leave_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                register_user = :userID 
            AND 
                del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchColumn();
    return $result;
}

function countLeaveStudentByTeacher($target_date,$userID) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students ts
                
            LEFT JOIN 
                T_Classes tc 
            ON 
                ts.class_id = tc.class_id
            WHERE 
                leave_date between DATE_SUB(:target_date, INTERVAL DAYOFMONTH(:target_date) - 1 DAY) 
            AND 
                LAST_DAY(:target_date)
            AND 
                tc.teacher_id = :userID
            AND 
                ts.del_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();  
    $result = $stmt->fetchColumn();
    return $result;
}



function countTotalLeaveStudent($target_date) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                leave_date < LAST_DAY(:target_date)
            AND 
                del_flag = 0
            AND
                enroll_date < LAST_DAY(:target_date)";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;
}
function countTotalLeaveStudentByRec($target_date,$userID) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                leave_date < LAST_DAY(:target_date)
            AND 
                del_flag = 0
            AND
                register_user = :userID
            AND
                enroll_date < LAST_DAY(:target_date)";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;
}
function countTotalLeaveStudentByTeacher($target_date,$userID) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students ts
            LEFT 
                JOIN T_Classes tc
            ON 
                ts.class_id = tc.class_id
            WHERE 
                leave_date < LAST_DAY(:target_date)
            AND 
                ts.del_flag = 0
            AND 
                tc.teacher_id = :userID
            AND
                enroll_date < LAST_DAY(:target_date)";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':userID',$userID);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;
}
function getAllPaidStudent($target_date){
    $sql = "SELECT 
                student_id,    
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                payment_date,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Students
            WHERE 
                expire_paymentdate > :target_date 
            AND 
                expire_paymentdate > paid_date
            AND 
                del_flag = 0
            AND 
                leave_flag = 0
            ORDER BY 
                student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function getAllPaidRec($target_date,$reciep){
    $sql = "SELECT 
                student_id,    
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                payment_date,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Students
            WHERE 
                expire_paymentdate > :target_date 
            AND 
                expire_paymentdate > paid_date
            AND 
                del_flag = 0
            AND 
                leave_flag = 0
            AND 
                register_user = :reciep
            ORDER BY 
                student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':reciep',$reciep);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;

}
function getAllUnPaidStudent($target_date){
    $sql = "SELECT
                student_id,    
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                payment_date,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Students
            WHERE 
                expire_paymentdate between adddate(:target_date, INTERVAL 2-DAYOFWEEK(:target_date) DAY) 
            AND 
                adddate(:target_date, INTERVAL 8-DAYOFWEEK(:target_date) DAY)
            AND 
                del_flag = 0
            AND
                leave_flag = 0
            ORDER BY 
                student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date', $target_date);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function getAllUnPaidUserRole($target_date,$user){
    $sql = "SELECT
                student_id,    
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                payment_date,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Students
            WHERE 
                expire_paymentdate between adddate(:target_date, INTERVAL 2-DAYOFWEEK(:target_date) DAY) 
            AND 
                adddate(:target_date, INTERVAL 8-DAYOFWEEK(:target_date) DAY)
            AND 
                del_flag = 0
            AND
                leave_flag = 0
            AND
                register_user = :user
            ORDER BY 
                student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date', $target_date);
    $stmt->bindParam(':user', $user);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}



function getAllPaidStudentInMonth($target_date){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Students
            WHERE 
                paid_date between DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE())-1 DAY) 
            AND 
                LAST_DAY(CURDATE()) 
            AND 
                expire_paymentdate > CURDATE()
            AND 
                del_flag = 0
            AND 
                leave_flag = 0
            ORDER BY 
                student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function getAllPaidStudentInWeek($target_date){
    $sql = "SELECT
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                payment_date,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Students
            WHERE 
                paid_date between adddate(:target_date, INTERVAL 2 - DAYOFWEEK(:target_date) DAY) 
            AND 
                adddate(:target_date, INTERVAL 8 - DAYOFWEEK(:target_date) DAY) 
            -- AND 
                -- expire_paymentdate >DATE_SUB(:target_date, INTERVAL -1 DAY)
            AND 
                del_flag = 0
            AND
                leave_flag = 0
            ORDER BY 
                student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date', $target_date);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function getAllPaidStudentInWeekRec($target_date,$reciep){

    $sql = "SELECT
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                payment_date,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Students
            WHERE 
                paid_date between adddate(:target_date, INTERVAL 2 - DAYOFWEEK(:target_date) DAY) 
            AND 
                adddate(:target_date, INTERVAL 8 - DAYOFWEEK(:target_date) DAY) 
            -- AND 
                -- expire_paymentdate > :target_date
            AND
                del_flag = 0
            AND
                leave_flag = 0
            AND
                register_user = :reciep
            ORDER BY 
                student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date', $target_date);
    $stmt->bindParam(':reciep',$reciep);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function countPaidStudentInWeek($target_date) {

    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                paid_date between adddate(curdate(), INTERVAL 1-DAYOFWEEK(curdate()) DAY) 
            AND 
                adddate(curdate(), INTERVAL 7-DAYOFWEEK(curdate()) DAY) 
            AND 
                expire_paymentdate > CURDATE()
            AND 
                del_flag = 0
            AND 
                leave_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;
}
function getPaidStudentInWeek($target_date) {

    $sql = "SELECT 
                *
            FROM 
                T_Students
            WHERE 
                paid_date between adddate(curdate(), INTERVAL 1-DAYOFWEEK(curdate()) DAY) 
            AND 
                adddate(curdate(), INTERVAL 7-DAYOFWEEK(curdate()) DAY) 
            AND 
                expire_paymentdate > CURDATE()
            AND 
                del_flag = 0
            AND 
                leave_flag = 0
            ORDER BY
                student_name";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date', $target_date);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}
function getPaidStudentInWeekUserRole($user) {
    $sql = "SELECT 
                *
            FROM 
                T_Students
            WHERE 
                paid_date between adddate(curdate(), INTERVAL 1-DAYOFWEEK(curdate()) DAY) 
            AND 
                adddate(curdate(), INTERVAL 7-DAYOFWEEK(curdate()) DAY) 
            AND 
                expire_paymentdate > CURDATE()
            AND 
                del_flag = 0
            AND 
                leave_flag = 0
            AND 
                register_user = :user
            ORDER BY
                student_name";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
//    $stmt->bindParam(':target_date', $target_date);
    $stmt->bindParam(':user', $user);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}
function countUnPaidStudentInWeek($target_date) {
    $sql = "SELECT 
                COUNT(*)
            FROM 
                T_Students
            WHERE 
                expire_paymentdate between adddate(curdate(), INTERVAL 1-DAYOFWEEK(curdate()) DAY) 
            AND 
                adddate(curdate(), INTERVAL 7-DAYOFWEEK(curdate()) DAY)
            AND 
                del_flag = 0
            AND 
                leave_flag = 0";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;
}
function getUnPaidStudentInWeek($target_date) {
    $sql = "SELECT 
                *
            FROM 
                T_Students
            WHERE 
                expire_paymentdate between adddate(curdate(), INTERVAL 1-DAYOFWEEK(curdate()) DAY) 
            AND 
                adddate(curdate(), INTERVAL 7-DAYOFWEEK(curdate()) DAY)
            AND 
                del_flag = 0
            ORDER BY
                student_name";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':target_date',$target_date);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}
function  getUnPaidStudentInWeekUserRole($user) {
    $sql = "SELECT 
                *
            FROM 
                T_Students
            WHERE 
                expire_paymentdate between adddate(curdate(), INTERVAL 1-DAYOFWEEK(curdate()) DAY) 
            AND 
                adddate(curdate(), INTERVAL 7-DAYOFWEEK(curdate()) DAY)
            AND 
                del_flag = 0
            AND
              register_user = :user
            ORDER BY
                student_name";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
//    $stmt->bindParam(':target_date',$target_date);
    $stmt->bindParam(':user', $user);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;
}
function unpaidNotification($register_user) {
    $user = getUserByUserID($register_user);
    $sql = "SELECT * 
            FROM T_Students 
            WHERE (DATEDIFF(expire_paymentdate, CURDATE())) <= 2
            AND del_flag = 0
            AND leave_flag = 0";
    if($user != null) {
        $sql .= $user->getRole() == "Admin" ? "" : " AND (register_user = :register_user)";
    }
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':register_user',$register_user);
    $stmt->execute();  
    $result = $stmt->fetchAll();    
    return $result;    
}

function countUnpaidNotification($register_user = '') {
    $user = getUserByUserID($register_user);
    $sql = "SELECT 
                COUNT(*) 
            FROM T_Students 
            WHERE (DATEDIFF(expire_paymentdate, CURDATE())) <= 2
            AND del_flag = 0
            AND leave_flag = 0";
    if($user != null) {

        $sql .= $user->getRole() == "Admin" ? "" : " AND (register_user = :register_user)";
    }
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':register_user',$register_user);
    $stmt->execute();  
    $result = $stmt->fetchColumn();    
    return $result;        

}

function updateExpirePayment($student) {
    $conn = getConnection();
    $sql = "UPDATE  
                T_Students
            SET
                expire_paymentdate = :expire_paymentdate,
                payment_date = :payment_date,
                paid_date = :paid_date,
                start_new = :start_new,
                expire_new = :expire_new,
                update_user = :update_user,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                student_id = :student_id";

    $student_id = $student->getStudentID();
    $expire_paymentdate = $student->getExpirePaymentDate();
    $payment_date = $student->getPaymentDate();
    $paid_date = $student->getPaidDate();
    $start_new = $student->getStart_new();
    $expire_new = $student->getExpire_new();
    $student_id = $student->getStudentID();
    $update_user = $student->getUpdateUser();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':expire_paymentdate',$expire_new);
    $stmt->bindParam(':payment_date',$payment_date);
    $stmt->bindParam(':paid_date',  $paid_date);
    $stmt->bindParam(':start_new',  $start_new);
    $stmt->bindParam(':expire_new', $expire_new);
    $stmt->bindParam(':student_id', $student_id);    
    $stmt->bindParam(':update_user',$update_user);
    $stmt->execute();    

    return getOneStudent($student_id);
}



function updatePayment($student){
    $conn = getConnection();
    $sql = "UPDATE  
                T_Students 
            SET
                fee = :fee,
                duration = :duration,
                payment_date = expire_paymentdate,
                paid_date = CURDATE(),
                start_new = :start_new,
                expire_new = :expire_new,
                expire_paymentdate = DATE_ADD(expire_paymentdate, INTERVAL :duration MONTH),
                update_user = :update_user,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                student_id = :student_id";
    $student_id = $student->getStudentID();
    $fee = $student->getFee();
    $start_new= $student->getStart_new();
    $expire_new=$student->getExpire_new();
    $duration = $student->getDuration();
    $update_user = $student->getUpdateUser();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fee', $fee);
    $stmt->bindParam(':start_new', $start_new);
    $stmt->bindParam('expire_new', $expire_new);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':update_user', $update_user);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();

    return getOneStudent($student_id);
}
function updatePaymentStudent($student){
    $conn = getConnection();
    $sql = "UPDATE  
                T_Students 
            SET
                fee = :fee,
                duration = :duration,
                payment_date = expire_paymentdate,
                paid_date = CURDATE(),
                start_new = :start_new,
                expire_new = :expire_new,
                expire_paymentdate = expire_paymentdate,
                update_user = :update_user,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                student_id = :student_id";
    $student_id = $student->getStudentID();
    $fee = $student->getFee();
    $start_new= $student->getStart_new();
    $expire_new=$student->getExpire_new();
    $duration = $student->getDuration();
    $update_user = $student->getUpdateUser();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fee', $fee);
    $stmt->bindParam(':start_new', $start_new);
    $stmt->bindParam('expire_new', $expire_new);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':update_user', $update_user);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();

    return getOneStudent($student_id);
}

function deleteStudent($user_id, $student_id){
    $conn = getConnection();
    $sql = $sql =  "UPDATE 
                        T_Students 
                    SET 
                        update_user = :user_id,
                        update_date = CURRENT_TIMESTAMP,
                        del_flag = 1,
                        update_user = :user_id,
                        update_date = CURDATE()
                    WHERE 
                        student_id = :student_id";
    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':student_id',$student_id);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->execute();
}   
function updateLeaveFlag($user_id, $student_id, $leaveFlag,$date){
    $conn = getConnection();
    $sql =  "UPDATE 
                    T_Students 
            SET 
                update_user = :user_id,
                update_date = CURRENT_TIMESTAMP,
                leave_flag = :leaveFlag ,
                leave_date = :leavedate,
                update_user = :user_id,
                update_date = CURDATE()
            WHERE 
                student_id = :student_id";
                $stmt = getConnection()->prepare($sql);
                $stmt->bindParam(':student_id',$student_id);
                $stmt->bindParam(':user_id',$user_id);
                $stmt->bindParam(':leaveFlag',$leaveFlag);
                $stmt->bindParam(':leavedate',$date);
                $stmt->execute();
}  

function getAllStudentInClassOrderById($class_id){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Students
            WHERE del_flag = 0 AND class_id = :class_id ORDER BY student_id ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':class_id',$class_id);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function getAllStudentInClassOrderByIdOnRegis($ClassID, $ExamMonth, $ExamYear){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Students
            WHERE 
                del_flag = 0 
            AND 
                class_id = :ClassID 
            AND(
                MONTH(enroll_date) <= :ExamMonth
            AND 
                YEAR(enroll_date) <= :ExamYear
            OR
                YEAR(enroll_date) < :ExamYear
            )
            ORDER BY student_id ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ClassID',$ClassID);
    $stmt->bindParam(':ExamMonth',$ExamMonth);
    $stmt->bindParam(':ExamYear',$ExamYear);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function getStudentPaymentLastID($student_id){
    $sql = "SELECT 
                MAX(invoice_id)
            FROM T_Invoice
            WHERE del_flag = 0 
            AND student_id = :student_id";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();  
    $result = $stmt->fetch();
    return $result;    

}
function getStudentPaymentDate($student_id){
    $sql = "SELECT 
                expire_paymentdate,
                fee,
                duration,
                start_new,
                expire_new
            FROM T_Invoice
            WHERE del_flag = 0 
            AND student_id = :student_id
            ORDER BY expire_paymentdate DESC
            Limit 1";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();  
    $result = $stmt->fetch();
    return $result;

}
function changeExpireDate($student) {
    $conn = getConnection();
    $sql = "UPDATE  
                T_Students
            SET
                expire_paymentdate = :expire_paymentdate,
                start_new = :start_new,
                expire_new = :expire_new,
                update_user = :update_user,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                student_id = :student_id";

    $student_id = $student->getStudentID();
    $expire_paymentdate = $student->getExpirePaymentDate();
    $start_new = $student->getStart_new();
    $expire_new = $student->getExpire_new();
    $student_id = $student->getStudentID();
    $update_user = $student->getUpdateUser();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':expire_paymentdate',$expire_new);
    $stmt->bindParam(':start_new',  $start_new);
    $stmt->bindParam(':expire_new', $expire_new);
    $stmt->bindParam(':student_id', $student_id);    
    $stmt->bindParam(':update_user',$update_user);
    $stmt->execute();    

}
function updateStudent($student){
    $conn = getConnection();
    $sql = "UPDATE  
                T_Students 
            SET
                student_name = :student_name,
                latin_name   = :latin_name,
                student_no   = :student_no,
                dob          = :dob,
                gender       = :gender,
                birth_place  = :birth_place,
                nationality  = :nationality,
                religion     = :religion,
                address      = :address,
                class_id     = :class_id,
                switch_time  = :switch_time,
                enroll_date  = :enroll_date,
                expire_paymentdate =:expire_paymentdate,
                start_new    = :enroll_date,
                update_user  = :update_user,
                update_date  = CURRENT_TIMESTAMP,
                photo        = :url
            WHERE 
                student_id   = :student_id";
    $file_name_new = $student->getPhoto();
//    var_dump($_FILES['newimg']);
    if (isset($_FILES['newimg'])) {
        $file   = $_FILES['newimg'];
        $file_name  = $file['name'];
        $file_tmp   = $file['tmp_name'];
        $file_size  = $file['size'];
        $file_error = $file['error'];
        // Working With File Extension
        $file_ext   = explode('.', $file_name);
        $file_fname = explode('.', $file_name);
        $file_fname = strtolower(current($file_fname));
        $file_ext   = strtolower(end($file_ext));
        $allowed    = array('jpg','png','jpeg');
        if (in_array($file_ext,$allowed)) {
            //print_r($_FILES);
            if ($file_error === 0) {
                if ($file_size <= 5000000) {
                    $file_name_new     =  $file_fname . uniqid('',true) . '.' . $file_ext;
                    $file_name_new    =  uniqid('',true) . '.' . $file_ext;
                    $file_destination =  'uploads/' . $file_name_new;
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        echo " uploaded";
                    }else{
                         echo "some error in uploading file".mysql_error();
                    }
                }
            }
        }else{
            $file_name_new = $student->getPhoto();
        }
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_name',$student->getStudentName());
    $stmt->bindParam(':student_id',$student->getStudentID());
    $stmt->bindParam(':latin_name',$student->getLatinName());
    $stmt->bindParam(':student_no',$student->getStudentNo());
    $stmt->bindParam(':dob',$student->getDob());
    $stmt->bindParam(':gender',$student->getGender());
    $stmt->bindParam(':birth_place',$student->getBirthPlace());
    $stmt->bindParam(':nationality',$student->getNationality());
    $stmt->bindParam(':religion',$student->getReligion());
    $stmt->bindParam(':address',$student->getAddress());
    $stmt->bindParam(':class_id',$student->getClassID());
    $stmt->bindParam(':switch_time',$student->getSwitchTime());
    $stmt->bindParam(':enroll_date',$student->getEnrollDate());
    $stmt->bindParam(':start_new',$student->getStart_new());
    $stmt->bindParam(':expire_paymentdate', $student->getExpirePaymentDate());
    $stmt->bindParam(':update_user',$student->getUpdateUser());
    $stmt->bindParam(':url', $file_name_new);
    $stmt->execute();
}
function updateClassStudent($student){
    $conn = getConnection();
    $sql = "UPDATE  
                T_Students
            SET
            class_id     = :class_id,
            register_user = :register_user,
            update_user  = :update_user,
            update_date  = CURRENT_TIMESTAMP
            WHERE 
            del_flag = 0
            AND
                student_id = :student_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id',$student->getStudentID());
    $stmt->bindParam(':class_id',$student->getClassID());
    $stmt->bindParam(':register_user',$student->getRegisterUSer());
    $stmt->bindParam(':update_user',$student->getUpdateUser());
    $stmt->execute();
}

function updateStudentPayment($student){
    $conn = getConnection();
    $sql = "UPDATE  
                T_Students 
            SET
                fee = :fee,
                duration = :duration,
                expire_paymentdate = :expire_paymentdate,
                start_new = :start_new,
                expire_new = :expire_new, 
                update_date = CURRENT_TIMESTAMP
            WHERE 
                student_id = :student_id";
    $student_id = $student->getStudentID();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fee', $student->getFee());
    $stmt->bindParam(':duration', $student->getDuration());
    $stmt->bindParam(':start_new', $student->getStart_new());
    $stmt->bindParam('expire_new', $student->getExpire_new());
    $stmt->bindParam('expire_paymentdate', $student->getExpirePaymentDate());
    $stmt->bindParam(':student_id', $student->getStudentID());
    $stmt->execute();

    return getOneStudent($student_id);
}
function getAllStudentInClassLeaveFlag($class_id){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Students
            WHERE 
            del_flag = 0 
            AND 
            class_id = :class_id
            AND
            leave_flag = 0
            ORDER BY student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':class_id',$class_id);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function getAllStudentInClassNoneLeave($class_id,$month,$year){
    $sql = "SELECT 
                student_id,
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Students
            WHERE 
                del_flag = 0 
            AND 
                class_id = :class_id
            AND(
                MONTH(enroll_date) <= :month
            AND
                YEAR(enroll_date) <= :year
            OR
                YEAR(enroll_date) < :year
                )
            AND(
                leave_flag = 0
            OR
                (leave_flag = 1 AND Year(leave_date) >= :year AND Month(leave_date) >= :month ))
            ORDER BY student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':class_id',$class_id);
    $stmt->bindParam(':month',$month);
    $stmt->bindParam(':year',$year);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function insertStudentLeave($user_id, $student_id,$leaveFlag,$date){
   $conn = getConnection();
   $sql = "INSERT INTO T_leave_students(
            student_id,
            leave_date,
            leave_type,
            register_date,
            register_user
        )
        VALUES(
            :studentID,
            :leaveDate,
            1,
            CURDATE(),
            :userID
        )"; 
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':studentID',$student_id);
    $stmt->bindParam(':leaveDate',$date);
    $stmt->bindParam(':userID',$user_id);
    $stmt->execute();
}

function updateStudentLeave($user_id, $student_id,$leaveFlag,$date){
    $conn = getConnection();
   $sql = "UPDATE 
                T_leave_students 
            SET
                back_date = :backDate,
                leave_type = 0,
                update_date = CURRENT_TIMESTAMP,
                update_user = :userID
            WHERE
                student_id = :studentID
            AND
                leave_type = 1
            AND
                del_flag = 0"; 
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':studentID',$student_id);
    $stmt->bindParam(':backDate',$date);
    $stmt->bindParam(':userID',$user_id);
    $stmt->execute();
}
function getPaymentByYear($year,$studentID){
    $conn = getConnection();
   $sql = "SELECT 
                start_new,
                expire_new,
                duration,
                MONTH(start_new) as month,
                MONTH(start_new) + duration as getmonth
            FROM 
                T_invoice
            WHERE
                del_flag = 0
            AND
                YEAR(start_new) =:Year
            AND
                student_id =:studentID"; 
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Year',$year);
    $stmt->bindParam(':studentID',$studentID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
function getAllStudentLeaveByID($year,$studentID){
    $conn = getConnection();
    $sql = "SELECT 
                leave_id,
                student_id,
                leave_date,
                back_date,
                MONTH(leave_date) as leave_month,
                MONTH(back_date) as back_month,
                MONTH(back_date) - MONTH(leave_date) as duration,
                leave_type
            FROM 
                T_leave_students
            WHERE
                del_flag = 0
            AND
                YEAR(leave_date) =:Year
            AND
                student_id =:studentID"; 
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Year',$year);
    $stmt->bindParam(':studentID',$studentID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getAllUnPaidStudentEx($year, $month){
    $sql = "SELECT
                student_id,    
                student_name,
                latin_name,
                student_no,
                class_id,
                duration,
                gender,
                dob,
                birth_place,
                religion,
                nationality,
                address,
                enroll_date,
                switch_time,
                leave_flag,
                fee,
                paid,
                expire_paymentdate,
                payment_date,
                paid_date,
                leave_date,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Students
            WHERE 
                YEAR(expire_paymentdate) =:Year
            AND 
                MONTH(expire_paymentdate) =:Month
            AND 
                del_flag = 0
            AND
                leave_flag = 0
            ORDER BY 
                student_name ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Month', $month);
    $stmt->bindParam(':Year', $year);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
?>