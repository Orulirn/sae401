<?php
/**
 * @version 1.0
 * 
 * @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
 */

 include_once '../BDD/DatabaseConnection.php';

function addTeamToTournamentPlayer($idTeam, $idTournoi){
    global $db;
    try{
        $db->beginTransaction();
        $sql = $db->prepare("INSERT INTO valid_team_tournoi(idTeam, idTournoi) VALUES (:idTeam,:idTournoi)");
        $sql->execute(array('idTeam' => filter_var($idTeam,FILTER_VALIDATE_INT), 'idTournoi' => filter_var($idTournoi,FILTER_VALIDATE_INT)));
        $db->commit();
    }
    catch( PDOException $e) {
        $db->rollBack();
        echo($e->getMessage());
    }
}
?>