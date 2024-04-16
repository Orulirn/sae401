<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * 
 */

include_once('../../Model/BDD/DatabaseConnection.php');

function addTeamTournamentVerify($idTeam,$idTournoi){
    global $db;
    try{
        $db->beginTransaction();
        $sql = $db->prepare("INSERT INTO `verify_team_tournoi`(`idTeam`, `idTournoi`) VALUES (:idTeam, :idTournoi)");
        $sql->execute(array('idTeam' => filter_var($idTeam,FILTER_VALIDATE_INT), 'idTournoi' => filter_var($idTournoi,FILTER_VALIDATE_INT)));
        $db->commit();
    }
    catch( PDOException $e) {
        $db->rollBack();
        echo($e->getMessage());
    }
}

function deleteTeamTournamentVerify($idTeam,$idTournoi){
    global $db;
    try {
        $sql = $db->prepare("DELETE FROM verify_team_tournoi WHERE `idTeam` = :idTeam AND `idTournoi` = :idTournoi");
        $sql->execute(array('idTeam' => $idTeam, 'idTournoi' => $idTournoi));
    } catch (PDOException $erreur) {
        die($erreur->getMessage());
    }
}

function selectAllTeamTournamentVerify(){
    global $db;
    $sql = $db->prepare("SELECT idTeam, idTournoi FROM verify_team_tournoi");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}