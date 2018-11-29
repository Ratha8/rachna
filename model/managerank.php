<?php

include 'rank.php';

function insertRank($rank) {
    $conn = getConnection();
    $sql = "INSERT INTO T_Rank(
                rank_name,
                year,
                description,
                register_date,
                update_date,
                register_user,
                update_user)
            VALUES(
                :rankName,
                :year,
                :description,
                CURDATE(),
                CURDATE(),
                :user,
                :user
                )";

    $user_id = $rank->getRegister_user();
    $rank_name = $rank->getRank_name();
    $year = $rank->getYear();
    $description = $rank->getDescription();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':rankName', $rank_name);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':user', $user_id);
    $stmt->execute();

    $lastid = $conn->lastInsertId();
    return $lastid;
}

function getAllRanks() {
    $sql = "SELECT 
                rank_id,
                rank_name,
                year,
                description,
                register_user,
                update_user,
                update_date,
                del_flag
            FROM T_Rank
            WHERE del_flag = 0 ORDER BY rank_id DESC";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
}

function getOneField($id) {
    $sql = "SELECT 
                rank_id,
                rank_name,
                year,
                description,
                register_user,
                update_user,
                update_date,
                del_flag
            FROM T_Rank
            WHERE del_flag = 0 AND rank_id = :id";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch();

    $rank = null;

    if (!empty($result)) {
        $rank = new Rank;
        $rank->setRank_id($result['rank_id']);
        $rank->setRank_name($result['rank_name']);
        $rank->setYear($result['year']);
        $rank->setDescription($result['description']);
        $rank->setRegister_user($result['register_user']);
        $rank->setUpdate_user($result['update_user']);
        $rank->setUpdate_date($result['update_date']);
    }

    return $rank;
}

function getTopOne() {
    $sql = "SELECT
               rank_id;
               
             ";
}

function deleteRank($user_id, $rank_id) {
    $sql = "UPDATE T_Rank 
		    SET 
                        del_flag = 1,
                        update_user = :user,
                        update_date = CURDATE()
                    WHERE 
                       rank_id = :rank_id";

    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':rank_id', $rank_id);
    $stmt->bindParam(':user', $user_id);
    $stmt->execute();
}

function updateRank($rank) {
    $conn = getConnection();

    $sql = "UPDATE T_Rank 
            SET 
		rank_name = :rank_name,
                year = :year,
                description = :description,              
                update_user = :user 
                WHERE rank_id = :rank_id";

    $rank_name = $rank->getRank_name();
    $rank_id = $rank->getRank_id();
    $year = $rank->getYear();
    $description = $rank->getDescription();
    $update_user = $rank->getUpdate_user();


    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':rank_id', $rank_id);
    $stmt->bindParam(':rank_name', $rank_name);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':user', $update_user);
    $stmt->execute();
}
