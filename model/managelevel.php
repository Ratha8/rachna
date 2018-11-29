<?php
include 'level.php';
function insertLevel($level){
    $conn = getConnection();
    $sql = "INSERT INTO T_Level(
                level_name,
                register_user,
                update_user)
            VALUES(
                :level_name,
                :register_user,
                :update_user
                ) ";

    $user_id = $level->getRegisterUser();
    $level_name = $level->getLevelName();  
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':level_name', $level_name);
    $stmt->bindParam(':register_user', $user_id);
    $stmt->bindParam(':update_user', $user_id);
    $stmt->execute();   

    $lastid = $conn->lastInsertId();
    return $lastid;
}


function getAllLevels(){
    $sql = "SELECT 
                level_id,
                level_name,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Level
            WHERE del_flag = 0 
            ORDER BY level_id ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}
function getAllLevelsUserRole($user){
    $sql = "SELECT 
                level_id,
                level_name,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Level
            WHERE del_flag = 0 
            AND register_user = :user
            ORDER BY level_id ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user', $user);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}
function getAllLevelsTeacher($user){
    $sql = "SELECT 
                tl.*
            FROM T_Level tl
            LEFT JOIN T_Classes tc 
            ON tl.level_id = tc.level_id 
            WHERE tl.del_flag = 0
            AND tc.teacher_id =:user
            GROUP BY tl.level_id
            ORDER BY tl.level_id ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user', $user);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}
function getOneLevel($id){
    $sql = "SELECT 
                level_id,
                level_name,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Level
            WHERE del_flag = 0 AND level_id = :id";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();  
    $result = $stmt->fetch();

    $level = null;

    if (!empty($result)){
        $level = new level;
        $level->setLevelID($result['level_id']);
        $level->setLevelName($result['level_name']);
        $level->setRegisterDate($result['register_date']);
        $level->setUpdateDate($result['update_date']);
        $level->setRegisterUser($result['register_user']);
        $level->setUpdateUSer($result['update_user']);
    }

    return $level;
}

function searchLevel($param){
    $sql = "SELECT 
                level_id,
                level_name,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Level
            WHERE del_flag = 0 AND level_id = :param OR level_name LIKE '%:param%'";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':param',$param);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}


function updateLevel($level){
    $conn = getConnection();
    $sql = "UPDATE  
                T_Level 
            SET
                level_name = :level_name,
                update_user = :update_user,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                level_id = :level_id";

    $level_name = $level->getLevelName();
    $update_user = $level->getUpdateUser();
    $level_id = $level->getLevelID();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':level_name', $level_name);
    $stmt->bindParam(':update_user', $update_user);
    $stmt->bindParam(':level_id', $level_id);
    $stmt->execute();
}

function deleteLevel($user_id, $level_id){
    $conn = getConnection();
    $sql = $sql =  "UPDATE 
                        T_Level 
                    SET 
                        update_user = :user_id,
                        update_date = CURRENT_TIMESTAMP,
                        del_flag = 1 
                    WHERE 
                        level_id= :level_id";

    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':level_id',$level_id);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->execute();
}    

?>