<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
 */

 include_once('../../Model/BDD/DatabaseConnection.php');

function addTeam($name){
    global $db;
    try{
        $db->beginTransaction();
        $sql = $db->prepare("INSERT INTO `teams`(`name`) VALUES (:name)");
        $sql->execute(array('name' =>htmlspecialchars($name)));
        $db->commit(); 
    }
    catch (PDOException $e){
        $db->rollBack();
        echo($e->getMessage());
    }
    return $db->lastInsertID();
};

function lastIdTeam(){
    global $db;
    $sql = $db->prepare("SELECT idTeam FROM teams ORDER BY idTeam DESC LIMIT 1  ");
    $sql->execute();
    return $sql->fetch()[0];
};

function selectAllTeams(){
    global $db;
    $sql = $db->prepare("SELECT * FROM teams");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
};

function selectAllTeamsWithCaptain(){
    global $db;
    $sql = $db->prepare("SELECT teams.idTeam, teams.name, users.firstname, users.lastname FROM teams JOIN team_player on teams.idTeam = team_player.idTeam JOIN users on team_player.player = users.idUser where team_player.isCaptain = 1");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
};

function selectNameWithIdTeam($idTeam){
    global $db;
    $sql = $db->prepare("SELECT name FROM teams WHERE idTeam = :idTeam");
    $sql->execute(array('idTeam' => $idTeam));
    return $sql->fetch(PDO::FETCH_ASSOC);
};
