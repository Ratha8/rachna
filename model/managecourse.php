<?php
include 'course.php';
function insertCourse($course){
    $conn = getConnection();
    $sql = "INSERT INTO T_Courses(
                course_name,
                duration,
                register_user,
                update_user)
            VALUES(
                :course_name,
                :duration,
                :register_user,
                :update_user
                )";

    $user_id = $course->getRegisterUser();
    $course_name = $course->getCourseName();
    $duration = $course->getDuration();
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':course_name', $course_name);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':register_user', $user_id);
    $stmt->bindParam(':update_user', $user_id);
    $stmt->execute();   
    $lastid = $conn->lastInsertId();
    return $lastid;
}

function getAllCourses(){
    $sql = "SELECT 
                course_id,
                course_name,
                duration,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Courses
            WHERE del_flag = 0 ORDER BY course_name ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}
function getAllCoursesUserRole($user){
    $sql = "SELECT 
                course_id,
                course_name,
                duration,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Courses
            WHERE del_flag = 0 
            AND register_user = :user
            ORDER BY course_name ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user', $user);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}
function getOneCourse($id){
    $sql = "SELECT 
                course_id,
                course_name,
                duration,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Courses
            WHERE del_flag = 0 AND course_id = :id";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();  
    $result = $stmt->fetch();

    $course = null;
    if (!empty($result)){
        $course = new Course;
        $course->setCourseID($result['course_id']);
        $course->setCourseName($result['course_name']);
        $course->setDuration($result['duration']);
        $course->setRegisterDate($result['register_date']);
        $course->setUpdateDate($result['update_date']);
        $course->setRegisterUser($result['register_user']);
        $course->setUpdateUSer($result['update_user']);
    }

    return $course;
}

function searchCourse($param){
    $sql = "SELECT 
                course_id,
                course_name,
                duration,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Courses
            WHERE del_flag = 0 AND course_id = :param OR course_name LIKE '%:param%'";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':param',$param);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}


function updateCourse($course){
    $conn = getConnection();
    $sql = "UPDATE  
                T_Courses 
            SET
                course_name = :course_name,
                duration = :duration,
                update_user = :update_user,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                course_id = :course_id";

    $course_id = $course->getCourseID();
    $course_name = $course->getCourseName();
    $duration = $course->getDuration();
    $update_user = $course->getUpdateUser();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->bindParam(':course_name', $course_name);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':update_user', $update_user);
    $stmt->execute();
}

function deleteCourse($user_id, $course_id){
    $conn = getConnection();
    $sql = $sql =  "UPDATE 
                        T_Courses 
                    SET 
                        update_user = :user_id,
                        update_date = CURRENT_TIMESTAMP,
                        del_flag = 1
                    WHERE 
                        course_id = :course_id";

    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}    

?>