<?php
session_start();
include_once '../Model/DatabaseConnection.php';

function getMatchesTable($idTournoi) {
    $db = Database::getInstance();

    try {
        $sql = "SELECT r.idRencontre, e1.name AS equipe_un_nom, e2.name AS equipe_deux_nom, p.nom AS parcours_nom, r.equipeChole, r.resultatRencontre
                FROM rencontre r
                INNER JOIN teams e1 ON r.idTeamUn = e1.idTeam
                INNER JOIN teams e2 ON r.idTeamDeux = e2.idTeam
                INNER JOIN parcours p ON r.idParcours = p.id
                WHERE r.idTournoi = :idTournoi";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':idTournoi', $idTournoi);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des matches : " . $e->getMessage();
        return [];
    }
}

function getTeamNameById($teamId){
    global $db;

    try {
        $sql = "SELECT name FROM teams WHERE idTeam = :teamId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':teamId', $teamId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['name'] : null;
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération du nom de l'équipe : " . $e->getMessage();
        return null;
    }
}
function getTournamentIdByCurrentYear(){
    $currentYear = date("Y");
    $db = Database::getInstance();

    try {
        $sql = "SELECT idTournoi FROM tournoi WHERE year = " . $currentYear;
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['idTournoi'];
        } else {
            $_SESSION['error'] = "Il n'y a pas de tournoi cette année";
            return null;
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération de l'ID du tournoi : " . $e->getMessage();
        return null;
    }
}
