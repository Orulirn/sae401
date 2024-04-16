<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
 */

 include_once('../../Model/BDD/DatabaseConnection.php');

function deleteTeamMember($idTeam){
    global $db;
    try{
        $db->beginTransaction();
        $sql = $db->prepare("DELETE FROM team_player WHERE idTeam = :idTeam");
        $sql->execute(array("idTeam"=> filter_var($idTeam,FILTER_VALIDATE_INT)));
        $db->commit();
    }
    catch( PDOException $e) {
        $db->rollBack();
        echo($e->getMessage());
    }
}

function addPlayer($idTeam, $player, $captain)
{
    global $db;
    try{
        $db->beginTransaction();
        $sql = $db->prepare("INSERT INTO team_player(idTeam, player,isCaptain) VALUES (:idTeam,:player,:captain)");
        $sql->execute(array('idTeam' => filter_var($idTeam,FILTER_VALIDATE_INT), 'player' => filter_var($player,FILTER_VALIDATE_INT),"captain"=> filter_var($captain,FILTER_VALIDATE_INT)));
        $db->commit();
    }
    catch( PDOException $e) {
        $db->rollBack();
        echo($e->getMessage());
    }
}

function selectAllPlayerWithTeam(){
    global $db;
    $sql = $db->prepare("SELECT idTeam,users.idUser, users.firstname, users.lastname FROM team_player JOIN users on users.idUser = team_player.player");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

function selectCaptainWithUser($player){
    global $db;
    $sql = $db->prepare("SELECT isCaptain FROM team_player WHERE player = :player ORDER BY isCaptain DESC LIMIT 1");
    $sql->execute(array('player' => $player));
    return $sql->fetch(PDO::FETCH_ASSOC);
}


function selectTeamWithCaptain($player){
    global $db;
    $sql = $db->prepare("SELECT idTeam FROM team_player WHERE player=(:player)");
    $sql->execute(array('player' => $player));
    return $sql->fetch(PDO::FETCH_ASSOC);
};


function selectAllPlayersWithIdTeam($idTeam){
    global $db;
    $sql = $db->prepare("SELECT users.firstname, users.lastname FROM team_player JOIN users on users.idUser = team_player.player WHERE team_player.idTeam = :idTeam");
    $sql->execute(array('idTeam' => $idTeam));
    return $sql->fetchAll(PDO::FETCH_ASSOC);
};

function selectCaptainNameWithTeam($idTeam){
    global $db;
    $sql = $db->prepare("SELECT users.firstname, users.lastname FROM team_player JOIN users on users.idUser = team_player.player WHERE team_player.idTeam = :idTeam and team_player.isCaptain = 1");
    $sql->execute(array('idTeam' => $idTeam));
    return $sql->fetchAll(PDO::FETCH_ASSOC);
};

function selectNumberOfTeamMates($idTeam){
    global $db;
    $sql = $db->prepare("SELECT count(player) as numberMates FROM team_player WHERE idTeam=(:idTeam)");
    $sql->execute(array('idTeam' => $idTeam));
    return $sql->fetch(PDO::FETCH_ASSOC);
}
