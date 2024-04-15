<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * 
 */

 include_once('../../Model/BDD/DatabaseConnection.php');

function addTeamVerify($name){
    global $db;
    try{
        $db->beginTransaction();
        $sql = $db->prepare("INSERT INTO `verify_teams`(`name`) VALUES (:name)");
        $sql->execute(array('name' =>htmlspecialchars($name)));
        $db->commit(); 
    }
    catch (PDOException $e){
        $db->rollBack();
        echo($e->getMessage());
    }
    return $db->lastInsertID();
};

function lastIdTeamVerify(){
    global $db;
    $sql = $db->prepare("SELECT idTeam FROM verify_teams ORDER BY idTeam DESC LIMIT 1  ");
    $sql->execute();
    return $sql->fetch()[0];
};