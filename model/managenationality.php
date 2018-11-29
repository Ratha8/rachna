<?php
include 'nationality.php';
function insertNationality($nationality){
    $conn = getConnection();
    $sql = "INSERT INTO T_Nationality(
                nationality_name,
                register_user,
                update_user)
            VALUES(
                :nationality_name,
                :register_user,
                :update_user
                ) ";

    $user_id = $nationality->getRegisterUser();
    $nationality_name = $nationality->getNationalityName();  
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nationality_name', $nationality_name);
    $stmt->bindParam(':register_user', $user_id);
    $stmt->bindParam(':update_user', $user_id);
    $stmt->execute();   

    $lastid = $conn->lastInsertId();
    return $lastid;
}


function getAllNationalities(){
    $sql = "SELECT 
                nationality_id,
                nationality_name
            FROM T_Nationality
            ORDER BY nationality_name ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}

function getOneNationality($id){
    $sql = "SELECT 
                nationality_id,
                nationality_name,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Nationality
            WHERE del_flag = 0 AND nationality_id = :id";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();  
    $result = $stmt->fetch();

    $nationality = null;

    if (!empty($result)){
        $nationality = new Nationality;
        $nationality->setNationalityID($result['nationality_id']);
        $nationality->setNationalityName($result['nationality_name']);
        $nationality->setRegisterDate($result['register_date']);
        $nationality->setUpdateDate($result['update_date']);
        $nationality->setRegisterUser($result['register_user']);
        $nationality->setUpdateUSer($result['update_user']);
    }

    return $nationality;
}

function searchNationality($param){
    $sql = "SELECT 
                nationality_id,
                nationality_name,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Nationality
            WHERE del_flag = 0 AND nationality_id = :param OR nationality_name LIKE '%:param%'";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':param',$param);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}


function updateNationality($nationality){
    $conn = getConnection();
    $sql = "UPDATE  
                T_Nationality 
            SET
                nationality_name = :nationality_name,
                update_user = :update_user,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                nationality_id = :nationality_id";

    $nationality_name = $nationality->getNationalityName();
    $update_user = $nationality->getUpdateUser();
    $nationality_id = $nationality->getNationalityID();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nationality_name', $nationality_name);
    $stmt->bindParam(':update_user', $update_user);
    $stmt->bindParam(':nationality_id', $_id);
    $stmt->execute();
}

function deleteNationality($user_id, $nationality_id){
    $conn = getConnection();
    $sql = $sql =  "UPDATE 
                        T_Nationality 
                    SET 
                        update_user = :user_id,
                        update_date = CURRENT_TIMESTAMP,
                        del_flag = 1 
                    WHERE 
                        nationality_id= :nationality_id";

    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':nationality_id',$nationality_id);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->execute();
}    

?>