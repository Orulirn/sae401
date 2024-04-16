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

function selectAllTeamsVerifyWithCaptain(){
    global $db;
    $sql = $db->prepare("SELECT verify_teams.idTeam, verify_teams.name, users.idUser, users.firstname, users.lastname FROM verify_teams JOIN verify_team_player on verify_teams.idTeam = verify_team_player.idTeam JOIN users on verify_team_player.player = users.idUser where verify_team_player.isCaptain = 1");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
};

function deleteVerifyTeams($idTeam){
    global $db;
    try{
        $db->beginTransaction();
        $sql = $db->prepare("DELETE FROM verify_teams WHERE idTeam = :idTeam");
        $sql->execute(array("idTeam"=> $idTeam));
        $db->commit();
    }
    catch( PDOException $e) {
        $db->rollBack();
        echo($e->getMessage());
    }
};

function selectAllTeamsVerify(){
    global $db;
    $sql = $db->prepare("SELECT * FROM verify_teams");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
};

function selectTeamNameById($id){
    global $db;
    $sql = $db->prepare("SELECT name FROM `verify_teams` WHERE idTeam = :idTeam");
    $sql->execute(array('idTeam'=>$id));
    return $sql->fetch();
};

function selectAllVerifyTeamsWithCaptain(){
    global $db;
    $sql = $db->prepare("SELECT verify_teams.idTeam, verify_teams.name, users.idUser, users.firstname, users.lastname FROM verify_teams JOIN verify_team_player on verify_teams.idTeam = verify_team_player.idTeam JOIN users on verify_team_player.player = users.idUser where verify_team_player.isCaptain = 1");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
};