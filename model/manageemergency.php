<?php
include 'emergency.php';
function insertEmergency($emergency){
    $conn = getConnection();
    $sql = "INSERT INTO T_Emergency(
                student_id,
                emergency_name,
                age,
                relationship,
                position,
                contact_number,
                address,
                register_user,
                update_user)
            VALUES(
                :student_id,
                :emergency_name,
                :age,
                :relationship,
                :position,
                :contact_number,
                :address,
                :user_id,
                :user_id
                )";

    $student_id = $emergency->getStudentID();
    $emergency_name = $emergency->getEmergencyName();
    $age = $emergency->getAge();
    $relationship = $emergency->getRelationship();
    $position = $emergency->getPosition();
    $contact_number = $emergency->getContactNumber();
    $address = $emergency->getAddress();
    $register_user = $emergency->getRegisterUser();
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':emergency_name', $emergency_name);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':relationship', $relationship);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':contact_number', $contact_number);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':user_id', $register_user);
    $stmt->execute();   
    $lastid = $conn->lastInsertId();
    return $lastid;
}

function getAllEmergencies(){
    $sql = "SELECT 
                emergency_id,
                student_id,
                emergency_name,
                age,
                relationship,
                position,
                contact_number,
                address,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Emergency
            WHERE 
                del_flag = 0 
            ORDER BY 
                emergency_name ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}

function getEmergency($student_id){
    $sql = "SELECT 
                emergency_id,
                student_id,
                emergency_name,
                age,
                relationship,
                position,
                contact_number,
                address,
                register_user,
                register_date,
                update_user,
                update_date
            FROM 
                T_Emergency
            WHERE 
                del_flag = 0 
            AND
                student_id = :student_id
            ORDER BY emergency_name ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();  
    $result = $stmt->fetch();

    $emergency = new Emergency;
    $emergency->setEmergencyID($result['emergency_id']);
    $emergency->setStudentID($result['student_id']);
    $emergency->setEmergencyName($result['emergency_name']);
    $emergency->setAge($result['age']);
    $emergency->setRelationship($result['relationship']);
    $emergency->setPosition($result['position']);
    $emergency->setContactNumber($result['contact_number']);
    $emergency->setAddress($result['address']);
    $emergency->setRegisterDate($result['register_date']);
    $emergency->setUpdateDate($result['update_date']);
    $emergency->setRegisterUser($result['register_user']);
    $emergency->setUpdateUSer($result['update_user']);

    return $emergency;
}

function getOneEmergency($id){
    $sql = "SELECT 
                emergency_id,
                student_id,
                emergency_name,
                age,
                relationship,
                position,
                contact_number,
                address,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Emergency
            WHERE del_flag = 0 AND emergency_id = :id";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();  
    $result = $stmt->fetch();

    $emergency = new Emergency;
    $emergency->setEmergencyID($result['emergency_id']);
    $emergency->setStudentID($result['student_id']);
    $emergency->setEmergencyName($result['emergency_name']);
    $emergency->setAge($result['age']);
    $emergency->setRelationship($result['relationship']);
    $emergency->setPosition($result['position']);
    $emergency->setContactNumber($result['contact_number']);
    $emergency->setAddress($result['address']);
    $emergency->setRegisterDate($result['register_date']);
    $emergency->setUpdateDate($result['update_date']);
    $emergency->setRegisterUser($result['register_user']);
    $emergency->setUpdateUSer($result['update_user']);

    return $emergency;
}

// function searchCourse($param){
//     $sql = "SELECT 
//                 course_id,
//                 course_name,
//                 duration,
//                 register_user,
//                 register_date,
//                 update_user,
//                 update_date
//             FROM T_Courses
//             WHERE del_flag = 0 AND course_id = :param OR course_name LIKE '%:param%'";

//     $conn = getConnection();
//     $stmt = $conn->prepare($sql);
//     $stmt->bindParam(':param',$param);
//     $stmt->execute();  
//     $result = $stmt->fetchAll();

//     return $result;
// }


function updateEmergency($emergency){
    $conn = getConnection();
    $sql = "UPDATE  
                T_Emergency 
            SET
                emergency_name = :emergency_name,
                age  = :age,
                relationship = :relationship,
                position = :position,
                contact_number = :contact_number,
                address = :address,
                update_user = :update_user,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                emergency_id = :emergency_id
            AND
                student_id = :student_id";

    $emergency_id = $emergency->getEmergencyID();
    $student_id = $emergency->getStudentID();            
    $emergency_name = $emergency->getEmergencyName();
    $age = $emergency->getAge();
    $relationship = $emergency->getRelationship();
    $position = $emergency->getPosition();
    $contact_number = $emergency->getContactNumber();
    $address = $emergency->getAddress();
    $update_user = $emergency->getUpdateUser();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':emergency_name', $emergency_name);
    $stmt->bindParam(':emergency_id', $emergency_id);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':relationship', $relationship);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':contact_number', $contact_number);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':update_user', $update_user);
    $stmt->execute();
}

// function deleteCourse($user_id, $course_id){
//     $conn = getConnection();
//     $sql = $sql =  "UPDATE 
//                         T_Courses 
//                     SET 
//                         update_user = :user_id,
//                         update_date = CURRENT_TIMESTAMP,
//                         del_flag = 1
//                     WHERE 
//                         course_id = :course_id";

//     $stmt = getConnection()->prepare($sql);
//     $stmt->bindParam(':course_id',$course_id);
//     $stmt->bindParam(':user_id',$user_id);
//     $stmt->execute();
// }    

?>