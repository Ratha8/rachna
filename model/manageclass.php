<?php

include 'managelevel.php';

include 'classes.php';

function insertClass($class){

    $conn = getConnection();
    $sql = "INSERT INTO T_Classes(
                class_name,
                teacher_name,
                teacher_id,
                level_id,
                start_time,
                end_time,
                time_shift,
                register_user,
                update_user)
            VALUES(
                :class_name,
                :teacher_name,
                :teacher_id,
                :level_id,
                :start_time,
                :end_time,
                :time_shift,
                :register_user,
                :update_user
                ) ";
    $register_user = $class->getRegisterUser();
    $user_id = $class->getUpdateUser();
    $class_name = $class->getClassName();
    $teacher_name = $class->getTeacherName();
    $teacher_id = $class->getTeacher_id();
    $level_id = $class->getLevelID();
    $start_time = $class->getStartTime();
    $end_time = $class->getEndTime();
    $time_shift = $class->getTimeShift();
    $stmt = $conn->prepare($sql);
    // $user_code=$model_code=$type_code=$manufacturer_code=$engine_code=$product_name=$year=$discount_price=$discount=$price=$description=null;
    $stmt->bindParam(':class_name', $class_name);
    $stmt->bindParam(':teacher_name', $teacher_name);
    $stmt->bindParam(':teacher_id', $teacher_id);
    $stmt->bindParam(':level_id', $level_id);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':time_shift', $time_shift);
    $stmt->bindParam(':register_user', $register_user);
    $stmt->bindParam(':update_user', $user_id);
    $stmt->execute();   

    //echo 'product code'.getConnection()->lastInsertId();            

    /*$result = $stmt->fetch(PDO::FETCH_ASSOC); 

    echo 'product code' . $result['product_code'];*/

    $lastid = $conn->lastInsertId();

    return $lastid;

}





function getAllClasses(){

    $sql = "SELECT 

                class_id,

                class_name,

                teacher_name,

                teacher_id,

                level_id,

                start_time,

                end_time,

                time_shift,

                register_user,

                register_date,

                update_user,

                update_date

            FROM T_Classes

            WHERE del_flag = 0 ORDER BY class_name ASC ";



    $conn = getConnection();

    $stmt = $conn->prepare($sql);

    $stmt->execute();  

    $result = $stmt->fetchAll();



    return $result;

}



function getAllClassesUserRole($users){

    $sql = "SELECT 
                class_id,
                class_name,
                teacher_name,
                teacher_id,
                level_id,
                start_time,
                end_time,
                time_shift,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Classes 
            WHERE del_flag = 0 AND teacher_id = :users ORDER BY class_name ASC ";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
     $stmt->bindParam(':users',$users);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;

}
function getAllClassesReciep($reciep){
    $sql = "SELECT 
                class_id,
                class_name,
                teacher_name,
                teacher_id,
                level_id,
                start_time,
                end_time,
                time_shift,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Classes 
            WHERE del_flag = 0 AND register_user = :reciep ORDER BY class_name ASC ";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':reciep',$reciep);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}



function getOneClass($id){

    $sql = "SELECT 
                class_id,
                class_name,
                teacher_name,
                teacher_id,
                level_id,
                start_time,
                end_time,
                time_shift,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Classes
            WHERE del_flag = 0 AND class_id = :id";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();  
    $result = $stmt->fetch();
    $class = null;

    if (!empty($result)){
        $class = new Classes;
        $class->setClassID($result['class_id']);
        $class->setClassName($result['class_name']);
        $class->setTeacherName($result['teacher_name']);
        $class->setTeacher_id($result['teacher_id']);
        $class->setLevelID($result['level_id']);
        $class->setStartTime($result['start_time']);
        $class->setEndTime($result['end_time']);
        $class->setTimeShift($result['time_shift']);
        $class->setRegisterDate($result['register_date']);
        $class->setUpdateDate($result['update_date']);
        $class->setRegisterUser($result['register_user']);
        $class->setUpdateUSer($result['update_user']);
    }
    return $class;

}



function searchClass($param){
    $sql = "SELECT 
                class_id,
                class_name,
                teacher_name,
                teacher_id,
                level_id,
                start_time,
                end_time,
                time_shift,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Classes
            WHERE del_flag = 0 AND class_id = :param OR class_name LIKE '%:param%'";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':param',$param);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function updateClass($class){
    $conn = getConnection();
    $sql = "UPDATE  
                T_Classes 
            SET
                class_name = :class_name,
                teacher_name = :teacher_name,
                teacher_id = :teacher_id,
                level_id = :level_id,
                start_time = :start_time,
                end_time = :end_time,
                time_shift = :time_shift,
                register_user = :register_user,
                update_user = :update_user,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                class_id = :class_id";
    $class_name = $class->getClassName();
    $teacher_id = $class->getTeacher_id();
    $teacher_name = $class->getTeacherName();
    $level_id = $class->getLevelID();
    $start_time = $class->getStartTime();
    $end_time = $class->getEndTime();
    $time_shift = $class->getTimeShift();
    $register_user = $class->getRegisterUser();
    $update_user = $class->getUpdateUser();
    $class_id = $class->getClassID();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':class_name', $class_name);
    $stmt->bindParam(':teacher_name', $teacher_name);
    $stmt->bindParam(':teacher_id', $teacher_id);
    $stmt->bindParam(':level_id', $level_id);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':time_shift', $time_shift);
    $stmt->bindParam('register_user', $register_user);
    $stmt->bindParam(':update_user', $update_user);
    $stmt->bindParam(':class_id', $class_id);
    $stmt->execute();
}
function deleteClass($user_id, $class_id){
    $conn = getConnection();
    $sql = $sql =  "UPDATE 
                        T_Classes 
                    SET 
                        update_user = :user_id,
                        update_date = CURRENT_TIMESTAMP,
                        del_flag = 1 
                    WHERE 
                        class_id= :class_id";
    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':class_id',$class_id);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->execute();
}    
function getAllClassByLevel($level){
    $sql = "SELECT 
                class_id,
                class_name,
                teacher_name,
                teacher_id,
                level_id,
                start_time,
                end_time,
                time_shift,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Classes 
            WHERE del_flag = 0 AND level_id = :level ORDER BY class_name ASC ";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
     $stmt->bindParam(':level',$level);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}

function getAllClassByLevelByteacher($level,$teacher){
    $sql = "SELECT 
                class_id,
                class_name,
                teacher_name,
                teacher_id,
                level_id,
                start_time,
                end_time,
                time_shift,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Classes 
            WHERE del_flag = 0 AND level_id = :level AND teacher_id = :teacher ORDER BY class_name ASC ";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
     $stmt->bindParam(':level',$level);
     $stmt->bindParam(':teacher',$teacher);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
?>