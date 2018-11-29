<?php
include 'relationship.php';

function getAllRelationships(){
    $sql = "SELECT 
                relationship_id,
                relationship_name
            FROM T_Relationship
            ORDER BY relationship_id ASC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetchAll();

    return $result;
}

function getOneRelationship($id){
    $sql = "SELECT 
                relationship_id,
                relationship_name
            FROM T_Relationship
            WHERE relationship_id = :id";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();  
    $result = $stmt->fetch();

    $relationship = null;

    if (!empty($result)){
        $relationship = new Relationship;
        $relationship->setRelationshipID($result['relationship_id']);
        $relationship->setRelationshipName($result['relationship_name']);
    }

    return $relationship;
}   

?>