<?php
include 'parents.php';
function insertParent($parent){
    $conn = getConnection();
    $sql = "INSERT INTO T_Parents(
                student_id,
                parent_name,
                nationality,
                relationship,
                position,
                contact_number,
                address,
                register_user,
                update_user)
            VALUES(
                :student_id,
                :parent_name,
                :nationality,
                :relationship,
                :position,
                :contact_number,
                :address,
                :user_id,
                :user_id
                )";

    $student_id = $parent->getStudentID();
    $parent_name = $parent->getParentName();
    $nationality = $parent->getNationality();
    $relationship = $parent->getRelationship();
    $position = $parent->getPosition();
    $contact_number = $parent->getContactNumber();
    $address = $parent->getAddress();
    $register_user = $parent->getRegisterUser();
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':parent_name', $parent_name);
    $stmt->bindParam(':nationality', $nationality);
    $stmt->bindParam(':relationship', $relationship);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':contact_number', $contact_number);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':user_id', $register_user);
    $stmt->execute();   
    $lastid = $conn->lastInsertId();
    return $lastid;
}

function getAllParents(){
    $sql = "SELECT 
                parent_id,
                student_id,
                parent_name,
                nationality,
                relationship,
                position,
                contact_number,
                address,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Parents
            WHERE del_flag = 0 ORDER BY parent_name ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}

function getParents($student_id){
    $sql = "SELECT 
                parent_id,
                student_id,
                parent_name,
                nationality,
                relationship,
                position,
                contact_number,
                address,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Parents
            WHERE del_flag = 0 AND student_id = :student_id ORDER BY relationship DESC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id',$student_id);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}

function getOneParent($id){
    $sql = "SELECT 
                parent_id,
                student_id,
                parent_name,
                nationality,
                relationship,
                position,
                contact_number,
                address,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Parents
            WHERE del_flag = 0 AND parent_id = :id";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();  
    $result = $stmt->fetch();

    $parent = new Parents;
    $parent->setParentID($result['parent_id']);
    $parent->setStudentID($result['student_id']);
    $parent->setParentName($result['parent_name']);
    $parent->setNationality($result['nationality']);
    $parent->setRelationship($result['relationship']);
    $parent->setPosition($result['position']);
    $parent->setContactNumber($result['contact_number']);
    $parent->setAdress($result['address']);
    $parent->setRegisterDate($result['register_date']);
    $parent->setUpdateDate($result['update_date']);
    $parent->setRegisterUser($result['register_user']);
    $parent->setUpdateUSer($result['update_user']);

    return $parent;
}

function updateParent($parent){
    $conn = getConnection();
    $sql = "UPDATE  
                T_Parents 
            SET
                parent_name = :parent_name,
                nationality  = :nationality,
                relationship = :relationship,
                position = :position,
                contact_number = :contact_number,
                address = :address,
                update_user = :update_user,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                parent_id = :parent_id
            AND
                student_id = :student_id";

    $parent_id = $parent->getParentID();   
    $student_id = $parent->getStudentID();         
    $parent_name = $parent->getParentName();
    $nationality = $parent->getNationality();
    $relationship = $parent->getRelationship();
    $position = $parent->getPosition();
    $contact_number = $parent->getContactNumber();
    $address = $parent->getAddress();
    $update_user = $parent->getUpdateUser();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':parent_id', $parent_id);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':parent_name', $parent_name);
    $stmt->bindParam(':nationality', $nationality);
    $stmt->bindParam(':relationship', $relationship);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':contact_number', $contact_number);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':update_user', $update_user);
    $stmt->execute();
}

function deleteParent($user_id, $parent_id){
    $conn = getConnection();
    $sql = $sql =  "UPDATE 
                        T_Parents 
                    SET 
                        update_user = :user_id,
                        update_date = CURRENT_TIMESTAMP,
                        del_flag = 1
                    WHERE 
                        parent_id = :parent_id";

    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':parent_id',$parent_id);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->execute();
}    

?>