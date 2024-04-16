<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * 
 */

 include_once('../../Model/BDD/DatabaseConnection.php');

function deleteTeamMemberVerify($idTeam){
    global $db;
    try{
        $db->beginTransaction();
        $sql = $db->prepare("DELETE FROM verify_team_player WHERE idTeam = :idTeam");
        $sql->execute(array("idTeam"=>filter_var( $idTeam,FILTER_VALIDATE_INT)));
        $db->commit();
    }
    catch( PDOException $e) {
        $db->rollBack();
        echo($e->getMessage());
    }
}

function addPlayerVerify($idTeam, $player, $captain)
{
    global $db;
    try{
        $db->beginTransaction();
        $sql = $db->prepare("INSERT INTO verify_team_player(idTeam, player,isCaptain) VALUES (:idTeam,:player,:captain)");
        $sql->execute(array('idTeam' =>filter_var($idTeam,FILTER_VALIDATE_INT), 'player' =>filter_var($player,FILTER_VALIDATE_INT),"captain"=>filter_var($captain,FILTER_VALIDATE_INT)));
        $db->commit();
    }
    catch( PDOException $e) {
        $db->rollBack();
        echo($e->getMessage());
    }
}
